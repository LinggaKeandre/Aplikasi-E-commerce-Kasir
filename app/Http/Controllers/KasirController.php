<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\UserPoint;
use App\Models\PointTransaction;
use App\Models\Notification;
use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class KasirController extends Controller
{
    // Dashboard Kasir
    public function dashboard()
    {
        $today = Carbon::today();
        $kasirId = Auth::id();

        // Statistik hari ini untuk kasir yang login (hanya transaksi kasir = delivered)
        $stats = [
            'transaksi_hari_ini' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('shipping_method', 'kasir')
                ->count(),
            'uang_masuk' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('shipping_method', 'kasir')
                ->where('payment_status', 'paid')
                ->sum('total'),
            'transaksi_berhasil' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('shipping_method', 'kasir')
                ->where('status', 'delivered')
                ->count(),
            'pending' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('status', 'pending')
                ->count(),
        ];

        // Transaksi terbaru hari ini (hanya transaksi kasir)
        $recentTransactions = Order::where('user_id', $kasirId)
            ->whereDate('created_at', $today)
            ->where('shipping_method', 'kasir')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('kasir.dashboard', compact('stats', 'recentTransactions'));
    }

    // Transaksi Penjualan (POS)
    public function transaksi()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('kasir.transaksi', compact('products'));
    }

    /**
     * Scan barcode dan return product data
     */
    public function scanBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string'
        ]);

        // First, check if barcode matches a product's main barcode
        $product = Product::where('barcode', $request->barcode)->first();
        
        // If not found in main barcode, search in variant barcodes
        $variantInfo = null;
        if (!$product) {
            $products = Product::whereNotNull('variants')->get();
            
            foreach ($products as $p) {
                if (!$p->variants) continue;
                
                foreach ($p->variants as $vIndex => $variant) {
                    if (!isset($variant['options'])) continue;
                    
                    foreach ($variant['options'] as $optIndex => $option) {
                        if (isset($option['barcode']) && $option['barcode'] === $request->barcode) {
                            $product = $p;
                            $variantInfo = [
                                'variant_index' => $vIndex,
                                'option_index' => $optIndex,
                                'variant_type' => $variant['type'],
                                'variant_value' => $option['value'],
                                'variant_price' => $option['price'] ?? null
                            ];
                            break 3; // Break all loops
                        }
                    }
                }
            }
        }

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan!'
            ], 404);
        }

        if ($product->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk habis!'
            ], 400);
        }

        // Calculate final price
        if ($variantInfo && $variantInfo['variant_price']) {
            // Use variant price with discount applied
            $variantPrice = $variantInfo['variant_price'];
            $finalPrice = $product->discount ? 
                $variantPrice - ($variantPrice * $product->discount / 100) : 
                $variantPrice;
        } else {
            // Use base price with discount
            $finalPrice = $product->discount ? 
                $product->price - ($product->price * $product->discount / 100) : 
                $product->price;
        }

        $response = [
            'success' => true,
            'product' => [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'final_price' => $finalPrice,
                'discount' => $product->discount,
                'stock' => $product->stock,
                'barcode' => $request->barcode,
                'variants' => $product->variants
            ]
        ];

        // Add variant info if found via variant barcode
        if ($variantInfo) {
            $response['product']['selected_variant'] = [
                'type' => $variantInfo['variant_type'],
                'value' => $variantInfo['variant_value'],
                'price' => $variantInfo['variant_price']
            ];
            $response['product']['variant_selection'] = [
                $variantInfo['variant_index'] => $variantInfo['option_index']
            ];
        }

        return response()->json($response);
    }

    /**
     * Get fresh product price (lightweight API for cart auto-refresh)
     */
    public function getFreshProductPrice($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan!'
            ], 404);
        }

        // Calculate final price with discount
        $finalPrice = $product->discount ? 
            $product->price - ($product->price * $product->discount / 100) : 
            $product->price;

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'final_price' => $finalPrice,
                'discount' => $product->discount,
                'stock' => $product->stock,
                'variants' => $product->variants ?? []
            ]
        ]);
    }

    public function processTransaksi(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0', // Price from frontend (includes variant price)
            'items.*.variantInfo' => 'nullable|array', // Variant info if available
            'payment_method' => 'required|in:cash,transfer,e-wallet',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $orderItems = [];
            
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => "Stok {$product->title} tidak cukup"
                        ], 400);
                    }
                    return back()->with('error', "Stok {$product->title} tidak cukup");
                }
                
                // Use price from frontend (already calculated with variant price)
                $itemPrice = $item['price'];
                    
                $total += $itemPrice * $item['quantity'];
                $orderItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $itemPrice,
                    'variantInfo' => $item['variantInfo'] ?? null
                ];
            }

            // Buat order number
            $orderNumber = 'KSR-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Buat order (untuk transaksi kasir langsung)
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(), // Kasir yang melakukan transaksi
                'shipping_name' => 'Walk-in Customer',
                'shipping_phone' => '-',
                'shipping_address' => 'Toko',
                'shipping_city' => '-',
                'shipping_province' => '-',
                'shipping_method' => 'kasir',
                'shipping_method_name' => 'Langsung (Kasir)',
                'shipping_cost' => 0,
                'estimated_delivery' => now(),
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid', // Langsung lunas
                'subtotal' => $total,
                'discount_amount' => 0,
                'total' => $total,
                'status' => 'delivered', // Transaksi kasir langsung selesai
                'terms_accepted' => true,
            ]);

            // Simpan order items dan update stok
            foreach ($orderItems as $item) {
                $product = $item['product'];
                $finalPrice = $item['price'];
                $variantInfo = $item['variantInfo'] ?? null;
                
                // Extract variant price if available
                $variantPrice = null;
                $variantData = null;
                if ($variantInfo) {
                    $variantPrice = $variantInfo['price'] ?? null;
                    // Store variant info as JSON for snapshot
                    $variantData = json_encode([
                        'type' => $variantInfo['type'],
                        'value' => $variantInfo['value']
                    ]);
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->title, // Snapshot nama produk (kolom di products: 'title')
                    'product_price' => $product->price, // Harga asli
                    'product_discount' => $product->discount ?? 0, // Diskon persen
                    'final_price' => $finalPrice, // Harga setelah diskon / variant price
                    'quantity' => $item['quantity'],
                    'variant_price' => $variantPrice, // Variant price snapshot
                    'variant_data' => $variantData, // Variant info snapshot
                    'variant_size' => null,
                    'variant_color' => null,
                    'subtotal' => $finalPrice * $item['quantity'], // final_price * quantity
                ]);
                
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            
            // Return JSON untuk AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'order_id' => $order->id,
                    'message' => 'Transaksi berhasil'
                ]);
            }
            
            return redirect()->route('kasir.cetak-struk', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi gagal: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
        }
    }

    public function cetakStruk($orderId)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($orderId);
        return view('kasir.struk', compact('order'));
    }

    // Daftar Pesanan
    public function pesanan(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('kasir.pesanan', compact('orders'));
    }

    public function updateStatusPesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diupdate');
    }

    // Riwayat Transaksi
    public function riwayat(Request $request)
    {
        $kasirId = Auth::id();
        
        $query = Order::where('user_id', $kasirId)
            ->where('shipping_method', 'kasir')
            ->with(['member']); // Load relasi member

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get customers and products for filter
        $customers = \App\Models\User::where('role', 'member')->orderBy('name')->get();
        $products = Product::orderBy('title')->get();
        
        return view('kasir.riwayat', compact('transactions', 'customers', 'products'));
    }

    public function exportRiwayat(Request $request)
    {
        $kasirId = Auth::id();
        $kasir = Auth::user();
        
        // Tentukan periode berdasarkan request
        $dateFrom = null;
        $dateTo = null;
        $periodLabel = 'Lifetime';
        
        switch ($request->get('period')) {
            case '1day':
                $dateFrom = now()->startOfDay();
                $dateTo = now()->endOfDay();
                $periodLabel = '1 Hari (' . $dateFrom->format('d M Y') . ')';
                break;
            case '1week':
                $dateFrom = now()->subDays(7)->startOfDay();
                $dateTo = now()->endOfDay();
                $periodLabel = '1 Minggu (' . $dateFrom->format('d M Y') . ' - ' . now()->format('d M Y') . ')';
                break;
            case '1month':
                $dateFrom = now()->subMonth()->startOfDay();
                $dateTo = now()->endOfDay();
                $periodLabel = '1 Bulan (' . $dateFrom->format('d M Y') . ' - ' . now()->format('d M Y') . ')';
                break;
            case 'lifetime':
            default:
                $dateFrom = null;
                $dateTo = null;
                $periodLabel = 'Lifetime (Semua Transaksi)';
                break;
        }
        
        $format = $request->get('format', 'excel');
        $customerId = $request->get('customer_id');
        $productId = $request->get('product_id');
        
        if ($format === 'pdf') {
            // Export PDF
            $query = Order::where('user_id', $kasirId)
                ->where('shipping_method', 'kasir')
                ->with(['member', 'items.product']);

            if ($dateFrom && $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            }
            
            // Filter by customer (member)
            if ($customerId) {
                $query->where('member_id', $customerId);
            }
            
            // Filter by product
            if ($productId) {
                $query->whereHas('items', function($q) use ($productId) {
                    $q->where('product_id', $productId);
                });
            }

            $transactions = $query->orderBy('created_at', 'desc')->get();
            
            // Hitung statistik
            $totalTransaksi = $transactions->count();
            $totalPendapatan = $transactions->sum('total');
            $totalPoin = $transactions->sum('points_awarded');
            
            $pdf = Pdf::loadView('kasir.exports.pdf', [
                'transactions' => $transactions,
                'kasir' => $kasir,
                'periodLabel' => $periodLabel,
                'totalTransaksi' => $totalTransaksi,
                'totalPendapatan' => $totalPendapatan,
                'totalPoin' => $totalPoin,
                'printDate' => now()->format('d M Y H:i')
            ])->setPaper('a4', 'landscape');
            
            $filename = 'Laporan_Transaksi_' . str_replace(' ', '_', $periodLabel) . '_' . now()->format('YmdHis') . '.pdf';
            
            return $pdf->download($filename);
        } else {
            // Export Excel
            $filename = 'Laporan_Transaksi_' . str_replace(' ', '_', $periodLabel) . '_' . now()->format('YmdHis') . '.xlsx';
            
            return Excel::download(
                new TransactionsExport($kasirId, $dateFrom, $dateTo, $customerId, $productId),
                $filename
            );
        }
    }

    // Stok Produk
    public function stok()
    {
        $products = Product::orderBy('title')->paginate(20);
        return view('kasir.stok', compact('products'));
    }

    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->update(['stock' => $request->stock]);

        return back()->with('success', 'Stok berhasil diupdate');
    }

    // Pelanggan
    public function pelanggan()
    {
        $customers = User::where('role', 'member')
            ->withCount([
                'orders as total_orders_count' => function($query) {
                    // Hitung pesanan online (sebagai user)
                },
                'memberOrders as member_orders_count' => function($query) {
                    // Hitung pesanan offline (sebagai member di transaksi kasir)
                }
            ])
            ->get()
            ->map(function($customer) {
                $customer->orders_count = $customer->total_orders_count + $customer->member_orders_count;
                return $customer;
            });
        
        // Paginate manually
        $perPage = 20;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedCustomers = new \Illuminate\Pagination\LengthAwarePaginator(
            $customers->slice($offset, $perPage)->values(),
            $customers->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('kasir.pelanggan', compact('paginatedCustomers'));
    }

    public function riwayatPelanggan($id)
    {
        $customer = User::findOrFail($id);
        
        // Gabungkan orders sebagai user dan sebagai member
        $orders = Order::where('user_id', $id)
            ->orWhere('member_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('kasir.pelanggan-riwayat', compact('customer', 'orders'));
    }

    /**
     * Form untuk menambah member baru
     */
    public function createMember()
    {
        return view('kasir.member-create');
    }

    /**
     * Simpan member baru
     */
    public function storeMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        try {
            DB::beginTransaction();

            // Buat user baru dengan role member
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'role' => 'member',
            ]);

            // Buat user_points dengan 0 poin
            UserPoint::create([
                'user_id' => $user->id,
                'points' => 0,
            ]);

            DB::commit();

            return redirect()
                ->route('kasir.pelanggan')
                ->with('success', "Member {$user->name} berhasil ditambahkan!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan member: ' . $e->getMessage());
        }
    }

    // Promo
    public function promo()
    {
        // Placeholder - nanti bisa ambil dari tabel promotions
        $promos = [];
        return view('kasir.promo', compact('promos'));
    }

    // Laporan Kasir
    public function laporan()
    {
        $today = Carbon::today();
        $kasirId = Auth::id();

        $report = [
            'total_transaksi' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('shipping_method', 'kasir')
                ->count(),
            'uang_masuk' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('shipping_method', 'kasir')
                ->where('payment_status', 'paid')
                ->sum('total'),
            'transaksi_berhasil' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('shipping_method', 'kasir')
                ->where('status', 'delivered')
                ->count(),
            'transaksi_pending' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('status', 'pending')
                ->count(),
            'transaksi_dibatalkan' => Order::where('user_id', $kasirId)
                ->whereDate('created_at', $today)
                ->where('status', 'cancelled')
                ->count(),
        ];

        // Detail transaksi per metode pembayaran (hanya transaksi kasir)
        $paymentMethods = Order::where('user_id', $kasirId)
            ->whereDate('created_at', $today)
            ->where('shipping_method', 'kasir')
            ->where('payment_status', 'paid')
            ->select('payment_method', DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();

        return view('kasir.laporan', compact('report', 'paymentMethods'));
    }

    public function tutupKasir()
    {
        // Placeholder untuk proses tutup kasir
        return back()->with('success', 'Kasir berhasil ditutup. Laporan telah disimpan.');
    }

    /**
     * Cari member berdasarkan email atau nama
     */
    public function searchMember(Request $request)
    {
        $search = $request->input('search');
        
        $member = User::where('role', 'member')
            ->where(function($query) use ($search) {
                $query->where('email', 'LIKE', "%{$search}%")
                      ->orWhere('name', 'LIKE', "%{$search}%");
            })
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan'
            ]);
        }

        // Expire semua notifikasi verification_request yang belum dibaca untuk member ini
        // Ini mencegah notifikasi double jika kasir kirim ulang
        Notification::where('user_id', $member->id)
            ->where('type', 'verification_request')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        // Generate 3 kode verifikasi (00-99)
        $correctCode = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
        $wrongCode1 = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
        $wrongCode2 = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);

        // Pastikan tidak ada duplikat
        while ($wrongCode1 == $correctCode) {
            $wrongCode1 = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
        }
        while ($wrongCode2 == $correctCode || $wrongCode2 == $wrongCode1) {
            $wrongCode2 = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
        }

        // Acak posisi kode
        $codes = [$correctCode, $wrongCode1, $wrongCode2];
        shuffle($codes);

        // Buat notifikasi baru untuk member
        Notification::create([
            'user_id' => $member->id,
            'type' => 'verification_request',
            'title' => 'Verifikasi Transaksi',
            'message' => 'Pilih kode verifikasi yang disebutkan kasir',
            'data' => [
                'codes' => $codes,
                'correct_code' => $correctCode,
                'kasir_name' => Auth::user()->name,
            ],
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'member' => [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'points' => $member->userPoint->points ?? 0
            ],
            'codes' => $codes,
            'correct_code' => $correctCode
        ]);
    }

    /**
     * Verifikasi kode dan tambahkan poin
     */
    public function verifyMember(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'selected_code' => 'required',
            'correct_code' => 'required'
        ]);

        if ($request->selected_code !== $request->correct_code) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi salah! Silakan coba lagi.'
            ]);
        }

        // Update order sebagai verified dan set member_id
        $order = Order::find($request->order_id);
        $order->update([
            'verification_code' => $request->correct_code,
            'is_verified' => true,
            'member_id' => $request->member_id, // Simpan member_id
        ]);

        // Hitung poin (1 poin per 1000 rupiah)
        $points = floor($order->total / 1000);

        // Cari atau buat user_points
        $userPoint = UserPoint::firstOrCreate(
            ['user_id' => $request->member_id],
            ['points' => 0]
        );

        // Tambahkan poin
        $userPoint->increment('points', $points);

        // Catat transaksi poin
        PointTransaction::create([
            'user_id' => $request->member_id,
            'order_id' => $order->id,
            'points' => $points,
            'type' => 'earn',
            'description' => 'Poin dari transaksi #' . $order->id
        ]);

        // Update order points_awarded
        $order->update(['points_awarded' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi berhasil!',
            'points_earned' => $points,
            'total_points' => $userPoint->points
        ]);
    }

    // Sync data dari kasir ke cache untuk customer display
    public function syncCustomerDisplay(Request $request)
    {
        $sessionId = $request->input('session_id');
        $cart = $request->input('cart', []);
        $cashier = $request->input('cashier', []);
        $verification = $request->input('verification');
        $paymentSuccess = $request->input('payment_success');

        if (!$sessionId) {
            return response()->json([
                'success' => false,
                'message' => 'Session ID required'
            ], 400);
        }

        $cacheKey = "customer_display_{$sessionId}";
        
        // Store data di cache dengan TTL 1 jam
        cache()->put($cacheKey, [
            'cart' => $cart,
            'cashier' => $cashier,
            'verification' => $verification,
            'payment_success' => $paymentSuccess,
            'updated_at' => now()->toIso8601String()
        ], 3600); // 1 hour

        return response()->json([
            'success' => true,
            'message' => 'Data synced successfully'
        ]);
    }

    // Customer Display API - untuk polling dari device terpisah
    public function getCustomerDisplayData(Request $request)
    {
        // Get session ID from request (dikirim dari halaman kasir)
        $sessionId = $request->input('session_id');
        
        if (!$sessionId) {
            return response()->json([
                'success' => false,
                'message' => 'Session ID required'
            ], 400);
        }

        // Register this device as connected (untuk tracking)
        $deviceId = $request->input('device_id', $request->ip());
        $connectedKey = "connected_devices_{$sessionId}";
        $connectedDevices = cache()->get($connectedKey, []);
        $connectedDevices[$deviceId] = now()->toIso8601String();
        cache()->put($connectedKey, $connectedDevices, 3600);

        // Get data dari cache/database based on session
        $cacheKey = "customer_display_{$sessionId}";
        $displayData = cache()->get($cacheKey, [
            'cart' => [],
            'cashier' => [
                'name' => '',
                'photo' => ''
            ],
            'verification' => null,
            'payment_success' => null
        ]);

        return response()->json([
            'success' => true,
            'data' => $displayData
        ]);
    }

    // Check connected customer displays
    public function checkConnectedDevices(Request $request)
    {
        $sessionId = $request->input('session_id');
        
        if (!$sessionId) {
            return response()->json(['count' => 0]);
        }

        // Cek berapa device yang actively polling dalam 10 detik terakhir
        $connectedKey = "connected_devices_{$sessionId}";
        $connectedDevices = cache()->get($connectedKey, []);
        
        // Remove stale connections (lebih dari 10 detik tidak ada activity)
        $now = now();
        $activeDevices = collect($connectedDevices)->filter(function ($timestamp) use ($now) {
            return $now->diffInSeconds(Carbon::parse($timestamp)) < 10;
        })->toArray();
        
        cache()->put($connectedKey, $activeDevices, 3600);
        
        return response()->json([
            'count' => count($activeDevices),
            'devices' => $activeDevices
        ]);
    }
}
