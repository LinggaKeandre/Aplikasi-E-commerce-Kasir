<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use App\Exports\AdminReportsExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get today's date range
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfWeek = Carbon::now()->startOfWeek();

        // Statistics
        $stats = [
            // Total penjualan hari ini (jumlah order)
            'sales_today' => Order::whereDate('created_at', $today)->count(),
            
            // Total penjualan bulan ini (jumlah order)
            'sales_month' => Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            
            // Total pendapatan hari ini (semua yang delivered)
            'revenue_today' => Order::whereDate('created_at', $today)
                ->where('status', 'delivered')
                ->sum('total'),
            
            // Total pendapatan bulan ini (semua yang delivered)
            'revenue_month' => Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('status', 'delivered')
                ->sum('total'),
            
            // Total pesanan (all time)
            'total_orders' => Order::count(),
            
            // Total produk aktif (stok > 0)
            'active_products' => Product::where('stock', '>', 0)->count(),
            
            // Total pelanggan terdaftar (role member)
            'total_customers' => User::where('role', 'member')->count(),
            
            // Total stok menipis (stok <= 5)
            'low_stock' => Product::where('stock', '<=', 5)->where('stock', '>', 0)->count(),
            
            // Total produk habis (stok = 0)
            'out_of_stock' => Product::where('stock', 0)->count(),
            
            // Kasir vs Online hari ini
            'kasir_today' => Order::whereDate('created_at', $today)
                ->where('shipping_method', 'kasir')->count(),
            'online_today' => Order::whereDate('created_at', $today)
                ->where('shipping_method', '!=', 'kasir')->count(),
            
            // Revenue Kasir vs Online hari ini (semua yang delivered)
            'kasir_revenue_today' => Order::whereDate('created_at', $today)
                ->where('shipping_method', 'kasir')
                ->where('status', 'delivered')
                ->sum('total'),
            'online_revenue_today' => Order::whereDate('created_at', $today)
                ->where('shipping_method', '!=', 'kasir')
                ->where('status', 'delivered')
                ->sum('total'),
            
            // Pending orders yang perlu diproses
            'pending_orders' => Order::whereIn('status', ['pending', 'processing'])->count(),
            
            // Cancelled orders bulan ini
            'cancelled_month' => Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('status', 'cancelled')->count(),
            
            // Average order value bulan ini (semua yang delivered)
            'avg_order_value' => Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('status', 'delivered')
                ->avg('total') ?? 0,
            
            // Pelanggan baru minggu ini
            'new_customers_week' => User::where('role', 'member')
                ->whereBetween('created_at', [$startOfWeek, now()])->count(),
            
            // Total poin yang diberikan bulan ini
            'points_given_month' => Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('points_awarded') ?? 0,
            
            // Total nilai inventori
            'inventory_value' => Product::selectRaw('SUM(stock * price) as total')->value('total') ?? 0,
            
            // Voucher aktif (belum dipakai dan belum expired)
            'active_vouchers' => \App\Models\Voucher::where('is_used', false)
                ->where('expires_at', '>', now())
                ->count(),
            
            // Review yang belum dibalas
            'pending_reviews' => \App\Models\Review::whereNull('admin_reply')->count(),
            
            // Request pembatalan pending
            'pending_cancellations' => \App\Models\OrderCancellationRequest::where('status', 'pending')->count(),
        ];

        // Top 5 Produk Terlaris (berdasarkan qty terjual)
        $topProducts = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->with('product')
            ->get();

        // Recent orders (10 terbaru)
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

                // Sales chart data (7 hari terakhir, semua yang delivered)
        $salesChart = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            
            $count = Order::whereDate('created_at', $date->toDateString())->count();
            $revenue = Order::whereDate('created_at', $date->toDateString())
                ->where('status', 'delivered')
                ->sum('total');
            
            $salesChart[] = [
                'date' => $date->format('d M'),
                'count' => $count,
                'revenue' => $revenue
            ];
        }

        // Get all products with full information
        $products = Product::orderBy('created_at', 'desc')->paginate(20);

        // Get products with low stock or out of stock
        $alertProducts = Product::where('stock', '<=', 5)->orderBy('stock', 'asc')->get();

        return view('admin.dashboard', compact('stats', 'products', 'alertProducts', 'topProducts', 'recentOrders', 'salesChart'));
    }

    // =============== PRODUCTS CRUD ===============
    public function products(Request $request)
    {
        $search = $request->get('search');
        
        $products = Product::with('category')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%")
                      ->orWhereHas('category', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();
            
        return view('admin.products.index', compact('products', 'search'));
    }

    public function createProduct()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        // Check if variants are enabled
        $hasVariants = $request->has('variants') && !empty($request->variants);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => $hasVariants ? 'nullable|numeric|min:0' : 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'brand' => 'nullable|string|max:100',
            'barcode' => $hasVariants ? 'nullable|string' : 'required|string|size:13|regex:/^[0-9]{13}$/',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_url' => 'nullable|url',
            'meta' => 'nullable|string',
            'variants' => 'nullable|array',
            'variants.*.type' => 'required_with:variants|string',
            'variants.*.options' => 'nullable|array|min:1',
            'variants.*.options.*.value' => 'required_with:variants.*.options|string',
            'variants.*.options.*.price' => 'nullable|numeric|min:0',
            'variants.*.options.*.barcode' => 'nullable|string|size:13|regex:/^[0-9]{13}$/',
        ]);
        
        // Validasi tambahan untuk produk TANPA varian: cek barcode di varian produk lain
        if (!$hasVariants && !empty($validated['barcode']) && $validated['barcode'] !== '0000000000000') {
            // Cek di kolom barcode utama (skip dummy barcode)
            $existingMain = Product::where('barcode', $validated['barcode'])
                ->where('barcode', '!=', '0000000000000')
                ->first();
            if ($existingMain) {
                return back()->withErrors([
                    'barcode' => "Barcode {$validated['barcode']} sudah digunakan oleh produk '{$existingMain->title}' (ID: {$existingMain->id})."
                ])->withInput();
            }
            
            // Cek di varian produk lain (skip dummy barcode)
            $existingInVariant = Product::whereNotNull('variants')
                ->get()
                ->filter(function($product) use ($validated) {
                    if (!$product->variants) return false;
                    foreach ($product->variants as $v) {
                        if (isset($v['options'])) {
                            foreach ($v['options'] as $opt) {
                                if (isset($opt['barcode']) && 
                                    $opt['barcode'] === $validated['barcode'] && 
                                    $opt['barcode'] !== '0000000000000') {
                                    return true;
                                }
                            }
                        }
                    }
                    return false;
                })
                ->first();
            
            if ($existingInVariant) {
                return back()->withErrors([
                    'barcode' => "Barcode {$validated['barcode']} sudah digunakan di varian produk '{$existingInVariant->title}' (ID: {$existingInVariant->id})."
                ])->withInput();
            }
        }
        
        // Set dummy barcode for products with variants (no longer needs to be unique)
        if ($hasVariants && (empty($validated['barcode']) || $validated['barcode'] === '0000000000000')) {
            $validated['barcode'] = '0000000000000';
        }
        
        // Validate unique barcodes across all variant options
        $variantBarcodes = [];
        if (isset($validated['variants']) && is_array($validated['variants'])) {
            foreach ($validated['variants'] as $vIndex => $variant) {
                if (isset($variant['options']) && is_array($variant['options'])) {
                    foreach ($variant['options'] as $optIndex => $option) {
                        if (!empty($option['barcode'])) {
                            // Skip validation for dummy/empty barcodes
                            if ($option['barcode'] === '0000000000000' || strlen($option['barcode']) !== 13) {
                                continue;
                            }
                            
                            // Check duplicate within request
                            if (in_array($option['barcode'], $variantBarcodes)) {
                                return back()->withErrors([
                                    "variants.{$vIndex}.options.{$optIndex}.barcode" => "Barcode {$option['barcode']} sudah digunakan di varian lain dalam form ini."
                                ])->withInput();
                            }
                            $variantBarcodes[] = $option['barcode'];
                            
                            // Check if barcode matches main product barcode of any product
                            $existingProduct = Product::where('barcode', $option['barcode'])->first();
                            if ($existingProduct) {
                                return back()->withErrors([
                                    "variants.{$vIndex}.options.{$optIndex}.barcode" => "Barcode {$option['barcode']} sudah digunakan oleh produk '{$existingProduct->title}'."
                                ])->withInput();
                            }
                            
                            // Check if barcode exists in other product variants
                            $existingInVariant = Product::whereNotNull('variants')
                                ->get()
                                ->filter(function($product) use ($option) {
                                    if (!$product->variants) return false;
                                    foreach ($product->variants as $v) {
                                        if (isset($v['options'])) {
                                            foreach ($v['options'] as $opt) {
                                                if (isset($opt['barcode']) && $opt['barcode'] === $option['barcode']) {
                                                    return true;
                                                }
                                            }
                                        }
                                    }
                                    return false;
                                })
                                ->first();
                            
                            if ($existingInVariant) {
                                return back()->withErrors([
                                    "variants.{$vIndex}.options.{$optIndex}.barcode" => "Barcode {$option['barcode']} sudah digunakan di varian produk '{$existingInVariant->title}'."
                                ])->withInput();
                            }
                        }
                    }
                }
            }
        }
        
        // Check if variants have prices
        $hasVariantPrice = false;
        if (isset($validated['variants']) && is_array($validated['variants'])) {
            foreach ($validated['variants'] as $variant) {
                if (isset($variant['options']) && is_array($variant['options'])) {
                    foreach ($variant['options'] as $option) {
                        if (isset($option['price']) && $option['price'] > 0) {
                            $hasVariantPrice = true;
                            break 2;
                        }
                    }
                }
            }
        }
        
        // Check if variants have prices
        $hasVariantPrice = false;
        if (isset($validated['variants']) && is_array($validated['variants'])) {
            foreach ($validated['variants'] as $variant) {
                if (isset($variant['options']) && is_array($variant['options'])) {
                    foreach ($variant['options'] as $option) {
                        if (isset($option['price']) && $option['price'] > 0) {
                            $hasVariantPrice = true;
                            break 2;
                        }
                    }
                }
            }
        }
        
        // Validate price: Either base price OR variant price must exist (HANYA untuk produk DENGAN varian)
        if ($hasVariants && !$hasVariantPrice && (empty($validated['price']) || $validated['price'] <= 0)) {
            return back()->withErrors([
                'price' => 'Produk dengan varian harus memiliki harga. Isi harga satuan ATAU isi harga di varian.'
            ])->withInput();
        }
        
        // Set price to 0 if has variant price (as indicated by hidden input)
        if ($hasVariants && $hasVariantPrice && empty($validated['price'])) {
            $validated['price'] = 0;
        }

        // Validate at least one image source
        if (!$request->hasFile('image') && empty($request->image_url)) {
            return back()->withErrors(['image' => 'Harap upload gambar atau masukkan URL gambar.'])->withInput();
        }

        // Generate slug from title
        $validated['slug'] = \Str::slug($validated['title']);
        
        // Make slug unique if already exists
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle image upload or URL
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            // Store image URL directly (you can also download and save it if needed)
            $validated['image'] = $request->image_url;
        }

        // Remove image_url from validated data as it's not in database
        unset($validated['image_url']);

        // Process variants - remove empty values
        if (isset($validated['variants']) && !empty($validated['variants'])) {
            $variants = [];
            foreach ($validated['variants'] as $variant) {
                if (!empty($variant['type']) && !empty($variant['options'])) {
                    // Filter out empty options
                    $options = array_filter($variant['options'], function($opt) {
                        return !empty(trim($opt['value'] ?? ''));
                    });
                    if (!empty($options)) {
                        $variants[] = [
                            'type' => $variant['type'],
                            'options' => array_values(array_map(function($opt) {
                                $option = [
                                    'value' => trim($opt['value']),
                                    'price' => !empty($opt['price']) ? (float)$opt['price'] : null
                                ];
                                // Add barcode if provided
                                if (!empty($opt['barcode'])) {
                                    $option['barcode'] = trim($opt['barcode']);
                                }
                                return $option;
                            }, $options))
                        ];
                    }
                }
            }
            $validated['variants'] = !empty($variants) ? $variants : null;
        } else {
            $validated['variants'] = null;
        }

        Product::create($validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct(Product $product)
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        // Check if variants are enabled
        $hasVariants = $request->has('variants') && !empty($request->variants);
        
        // Build barcode validation rule
        $barcodeRule = 'nullable|string';
        if (!$hasVariants) {
            // Product without variants must have valid unique barcode
            $barcodeRule = 'required|string|size:13|regex:/^[0-9]{13}$/';
            if ($request->barcode !== '0000000000000') {
                $barcodeRule .= '|unique:products,barcode,' . $product->id;
            }
        } else {
            // Product with variants: barcode will be dummy, but still check if real barcode is entered
            if ($request->barcode !== '0000000000000' && strlen($request->barcode) === 13) {
                $barcodeRule .= '|size:13|regex:/^[0-9]{13}$/|unique:products,barcode,' . $product->id;
            }
        }
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'brand' => 'nullable|string|max:100',
            'barcode' => $barcodeRule,
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_url' => 'nullable|url',
            'meta' => 'nullable|string',
            'variants' => 'nullable|array',
            'variants.*.type' => 'required_with:variants|string',
            'variants.*.options' => 'nullable|array|min:1',
            'variants.*.options.*.value' => 'required_with:variants.*.options|string',
            'variants.*.options.*.price' => 'nullable|numeric|min:0',
            'variants.*.options.*.barcode' => 'nullable|string|size:13|regex:/^[0-9]{13}$/',
            'clear_variants' => 'nullable|in:0,1',
        ]);
        
        // Validasi tambahan untuk produk TANPA varian: cek barcode di varian produk lain
        if (!$hasVariants && !empty($validated['barcode']) && $validated['barcode'] !== '0000000000000') {
            $existingInVariant = Product::whereNotNull('variants')
                ->where('id', '!=', $product->id) // Exclude current product
                ->get()
                ->filter(function($p) use ($validated) {
                    if (!$p->variants) return false;
                    foreach ($p->variants as $v) {
                        if (isset($v['options'])) {
                            foreach ($v['options'] as $opt) {
                                if (isset($opt['barcode']) && 
                                    $opt['barcode'] === $validated['barcode'] && 
                                    $opt['barcode'] !== '0000000000000') {
                                    return true;
                                }
                            }
                        }
                    }
                    return false;
                })
                ->first();
            
            if ($existingInVariant) {
                return back()->withErrors([
                    'barcode' => "Barcode {$validated['barcode']} sudah digunakan di varian produk '{$existingInVariant->title}' (ID: {$existingInVariant->id})."
                ])->withInput();
            }
        }
        
        // Set dummy barcode for products with variants (no longer needs to be unique)
        if ($hasVariants && (empty($validated['barcode']) || $validated['barcode'] === '0000000000000')) {
            $validated['barcode'] = '0000000000000';
        }
        
        // Validate unique barcodes across all variant options
        $variantBarcodes = [];
        if (isset($validated['variants']) && is_array($validated['variants'])) {
            foreach ($validated['variants'] as $vIndex => $variant) {
                if (isset($variant['options']) && is_array($variant['options'])) {
                    foreach ($variant['options'] as $optIndex => $option) {
                        if (!empty($option['barcode'])) {
                            // Skip validation for dummy/empty barcodes
                            if ($option['barcode'] === '0000000000000' || strlen($option['barcode']) !== 13) {
                                continue;
                            }
                            
                            // Check duplicate within request
                            if (in_array($option['barcode'], $variantBarcodes)) {
                                return back()->withErrors([
                                    "variants.{$vIndex}.options.{$optIndex}.barcode" => "Barcode {$option['barcode']} sudah digunakan di varian lain dalam form ini."
                                ])->withInput();
                            }
                            $variantBarcodes[] = $option['barcode'];
                            
                            // Check if barcode matches main product barcode of any product (including this one if not variant)
                            $existingProduct = Product::where('barcode', $option['barcode'])
                                ->get()
                                ->filter(function($p) use ($product) {
                                    // Allow if it's the current product and it has variants (dummy barcode)
                                    if ($p->id === $product->id && $p->variants) {
                                        return false;
                                    }
                                    return true;
                                })
                                ->first();
                            
                            if ($existingProduct) {
                                return back()->withErrors([
                                    "variants.{$vIndex}.options.{$optIndex}.barcode" => "Barcode {$option['barcode']} sudah digunakan oleh produk '{$existingProduct->title}'."
                                ])->withInput();
                            }
                            
                            // Check if barcode exists in other product variants
                            $existingInVariant = Product::whereNotNull('variants')
                                ->where('id', '!=', $product->id)
                                ->get()
                                ->filter(function($p) use ($option) {
                                    if (!$p->variants) return false;
                                    foreach ($p->variants as $v) {
                                        if (isset($v['options'])) {
                                            foreach ($v['options'] as $opt) {
                                                if (isset($opt['barcode']) && $opt['barcode'] === $option['barcode']) {
                                                    return true;
                                                }
                                            }
                                        }
                                    }
                                    return false;
                                })
                                ->first();
                            
                            if ($existingInVariant) {
                                return back()->withErrors([
                                    "variants.{$vIndex}.options.{$optIndex}.barcode" => "Barcode {$option['barcode']} sudah digunakan di varian produk '{$existingInVariant->title}'."
                                ])->withInput();
                            }
                        }
                    }
                }
            }
        }
        
        // Store original values for comparison
        $originalPrice = $product->price;
        $originalVariants = $product->variants;
        
        // Check if variants should be cleared
        if ($request->input('clear_variants') === '1') {
            $validated['variants'] = null;
        }
        
        // Check if variants have prices
        $hasVariantPrice = false;
        if (isset($validated['variants']) && is_array($validated['variants'])) {
            foreach ($validated['variants'] as $variant) {
                if (isset($variant['options']) && is_array($variant['options'])) {
                    foreach ($variant['options'] as $option) {
                        if (isset($option['price']) && $option['price'] > 0) {
                            $hasVariantPrice = true;
                            break 2;
                        }
                    }
                }
            }
        }
        
        // Validate price: Either base price OR variant price must exist (HANYA untuk produk DENGAN varian)
        if ($hasVariants && !$hasVariantPrice && (empty($validated['price']) || $validated['price'] <= 0)) {
            return back()->withErrors([
                'price' => 'Produk dengan varian harus memiliki harga. Isi harga satuan ATAU isi harga di varian.'
            ])->withInput();
        }
        
        // Set price to original or 0 if has variant price
        if ($hasVariants && $hasVariantPrice && empty($validated['price'])) {
            $validated['price'] = $originalPrice; // Keep original to detect changes
        }
        
        // Untuk produk TANPA varian, pastikan ada harga
        if (!$hasVariants && (empty($validated['price']) || $validated['price'] <= 0)) {
            return back()->withErrors([
                'price' => 'Produk harus memiliki harga satuan.'
            ])->withInput();
        }

        // Generate slug if title changed
        if ($validated['title'] !== $product->title) {
            $validated['slug'] = \Str::slug($validated['title']);
            
            // Make slug unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle image upload or URL
        if ($request->hasFile('image')) {
            // Delete old image if it's a file (not URL)
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            // Delete old image if it's a file (not URL)
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->image_url;
        }

        // Remove image_url from validated data
        unset($validated['image_url']);
        unset($validated['clear_variants']);

        // Process variants - remove empty values
        if (!isset($validated['variants']) || $validated['variants'] === null) {
            // Variants already set to null by clear_variants check
            // Do nothing
        } elseif (isset($validated['variants']) && !empty($validated['variants'])) {
            $variants = [];
            foreach ($validated['variants'] as $variant) {
                if (!empty($variant['type']) && !empty($variant['options'])) {
                    // Filter out empty options
                    $options = array_filter($variant['options'], function($opt) {
                        return !empty(trim($opt['value'] ?? ''));
                    });
                    if (!empty($options)) {
                        $variants[] = [
                            'type' => $variant['type'],
                            'options' => array_values(array_map(function($opt) {
                                $option = [
                                    'value' => trim($opt['value']),
                                    'price' => !empty($opt['price']) ? (float)$opt['price'] : null
                                ];
                                // Add barcode if provided
                                if (!empty($opt['barcode'])) {
                                    $option['barcode'] = trim($opt['barcode']);
                                }
                                return $option;
                            }, $options))
                        ];
                    }
                }
            }
            $validated['variants'] = !empty($variants) ? $variants : null;
        } else {
            // Explicitly set to null jika tidak ada variants atau kosong
            $validated['variants'] = null;
        }

        // Remove barcode from update if it's dummy barcode and unchanged to avoid duplicate key error
        if (isset($validated['barcode']) && 
            $validated['barcode'] === '0000000000000' && 
            $product->barcode === '0000000000000') {
            unset($validated['barcode']);
        }

        // Detect if price or variants changed
        $priceChanged = $originalPrice != $validated['price'];
        $variantsChanged = json_encode($originalVariants) !== json_encode($validated['variants']);
        
        // If price or variants changed, remove this product from all carts
        if ($priceChanged || $variantsChanged) {
            $deletedCount = \App\Models\CartItem::where('product_id', $product->id)->delete();
            
            $product->update($validated);
            
            $message = 'Produk berhasil diperbarui!';
            if ($deletedCount > 0) {
                $message .= " Produk telah dihapus dari {$deletedCount} keranjang karena perubahan harga/varian.";
            }
            
            return redirect()->route('admin.products')->with('success', $message);
        }

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyProduct(Product $product)
    {
        // Delete product image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus!');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $user->update($validated);
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function uploadPhoto(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'photo.required' => 'Silakan pilih foto terlebih dahulu',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'photo.max' => 'Ukuran foto maksimal 2MB'
        ]);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $photoPath = $request->file('photo')->store('profile-photos', 'public');
        $user->update(['photo' => $photoPath]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
            $user->update(['photo' => null]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    // Placeholder methods for other menu items
    public function reports(Request $request)
    {
        $query = Order::with(['user', 'member', 'items.product']);
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Filter by shipping method (kasir vs online)
        if ($request->filled('type')) {
            if ($request->type === 'kasir') {
                $query->where('shipping_method', 'kasir');
            } elseif ($request->type === 'online') {
                $query->where('shipping_method', '!=', 'kasir');
            }
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Calculate statistics (semua yang delivered)
        $stats = [
            'total_transactions' => Order::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total'),
            'kasir_transactions' => Order::where('shipping_method', 'kasir')->count(),
            'online_transactions' => Order::where('shipping_method', '!=', 'kasir')->count(),
            'kasir_revenue' => Order::where('shipping_method', 'kasir')->where('status', 'delivered')->sum('total'),
            'online_revenue' => Order::where('shipping_method', '!=', 'kasir')->where('status', 'delivered')->sum('total'),
            'total_points_given' => Order::sum('points_awarded'),
        ];
        
        // Get customers and products for filter
        $customers = \App\Models\User::where('role', 'member')->orderBy('name')->get();
        $products = Product::orderBy('title')->get();
        
        return view('admin.reports', compact('transactions', 'stats', 'customers', 'products'));
    }
    
    public function exportReports(Request $request)
    {
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
        
        $type = $request->get('type', 'all'); // all, kasir, online
        $format = $request->get('format', 'excel');
        $customerId = $request->get('customer_id');
        $productId = $request->get('product_id');
        
        if ($format === 'pdf') {
            // Export PDF
            $query = Order::with(['user', 'member', 'items.product']);

            if ($dateFrom) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            }
            
            if ($type === 'kasir') {
                $query->where('shipping_method', 'kasir');
            } elseif ($type === 'online') {
                $query->where('shipping_method', '!=', 'kasir');
            }
            
            // Filter by customer (check both user_id for online orders and member_id for kasir orders)
            if ($customerId) {
                $query->where(function($q) use ($customerId) {
                    $q->where('user_id', $customerId)
                      ->orWhere('member_id', $customerId);
                });
            }
            
            // Filter by product
            if ($productId) {
                $query->whereHas('items', function($q) use ($productId) {
                    $q->where('product_id', $productId);
                });
            }

            $transactions = $query->orderBy('created_at', 'desc')->get();
            
            // Hitung statistik (revenue hanya dari delivered orders)
            $totalTransaksi = $transactions->count();
            // Semua yang status delivered
            $totalPendapatan = $transactions->filter(function($transaction) {
                return $transaction->status === 'delivered';
            })->sum('total');
            $totalPoin = $transactions->sum('points_awarded');
            
            $typeLabel = $type === 'kasir' ? 'Kasir' : ($type === 'online' ? 'Online' : 'Semua');
            
            $pdf = Pdf::loadView('admin.exports.reports-pdf', [
                'transactions' => $transactions,
                'periodLabel' => $periodLabel,
                'typeLabel' => $typeLabel,
                'totalTransaksi' => $totalTransaksi,
                'totalPendapatan' => $totalPendapatan,
                'totalPoin' => $totalPoin,
                'printDate' => now()->format('d M Y H:i')
            ])->setPaper('a4', 'landscape');
            
            $filename = 'Laporan_' . $typeLabel . '_' . str_replace(' ', '_', $periodLabel) . '_' . now()->format('YmdHis') . '.pdf';
            
            return $pdf->download($filename);
        } else {
            // Export Excel
            $filename = 'Laporan_Penjualan_' . str_replace(' ', '_', $periodLabel) . '_' . now()->format('YmdHis') . '.xlsx';
            
            return Excel::download(
                new AdminReportsExport($dateFrom, $dateTo, $type, $customerId, $productId),
                $filename
            );
        }
    }

    public function orders(Request $request)
    {
        $query = Order::with('user');
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Search by order number or customer name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Priority ordering: pending, processing, shipped di atas, cancelled dan delivered di bawah
        $orders = $query->orderByRaw("
            CASE 
                WHEN status = 'pending' THEN 1
                WHEN status = 'processing' THEN 2
                WHEN status = 'shipped' THEN 3
                WHEN status = 'delivered' THEN 4
                WHEN status = 'cancelled' THEN 5
                ELSE 6
            END
        ")
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    public function showOrder($id)
    {
        $order = Order::with(['user', 'items.product', 'cancellationRequest'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $order = Order::with('cancellationRequest')->findOrFail($id);
        
        // Check if there's a pending cancellation request
        if ($order->cancellationRequest && $order->cancellationRequest->status === 'pending') {
            return redirect()->back()->with('error', 'Tidak dapat mengubah status pesanan. Ada pengajuan pembatalan yang menunggu persetujuan. Silakan proses request pembatalan terlebih dahulu.');
        }
        
        $oldStatus = $order->status;
        $order->status = $request->status;
        
        // Set shipped_at when status changes to delivered (tanggal saat admin set ke delivered)
        if ($request->status === 'delivered' && !$order->shipped_at) {
            $order->shipped_at = now();
        }
        
        // Auto update payment status
        if ($request->status === 'delivered') {
            $order->payment_status = 'paid';
        }
        
        // Restore stock and voucher if admin cancels order
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            // Restore stock
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            
            // Restore voucher if used
            if ($order->voucher_id) {
                $voucher = \App\Models\UserVoucher::find($order->voucher_id);
                if ($voucher) {
                    $voucher->update([
                        'is_used' => false,
                        'used_at' => null,
                        'order_id' => null
                    ]);
                }
            }
        }
        
        $order->save();
        
        $message = $request->status === 'cancelled' 
            ? 'Pesanan berhasil dibatalkan. Stok dan voucher (jika ada) telah dikembalikan.'
            : 'Status pesanan berhasil diupdate!';
        
        return redirect()->back()->with('success', $message);
    }

    public function cancellationRequests()
    {
        // Priority ordering: pending requests di atas, approved/rejected di bawah
        $requests = \App\Models\OrderCancellationRequest::with(['order', 'user'])
            ->orderByRaw("
                CASE 
                    WHEN status = 'pending' THEN 1
                    WHEN status = 'approved' THEN 2
                    WHEN status = 'rejected' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.orders.cancellation-requests', compact('requests'));
    }

    public function reviewCancellation(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $cancellation = \App\Models\OrderCancellationRequest::with('order')->findOrFail($id);
        
        if ($request->action === 'approve') {
            $cancellation->status = 'approved';
            $cancellation->order->status = 'cancelled';
            $cancellation->order->save();
            
            // Restore stock
            foreach ($cancellation->order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            
            // Restore voucher if used
            if ($cancellation->order->voucher_id) {
                $voucher = \App\Models\UserVoucher::find($cancellation->order->voucher_id);
                if ($voucher) {
                    $voucher->update([
                        'is_used' => false,
                        'used_at' => null,
                        'order_id' => null
                    ]);
                }
            }
            
            $message = 'Pembatalan pesanan telah disetujui. Stok dan voucher (jika ada) telah dikembalikan.';
        } else {
            $cancellation->status = 'rejected';
            $message = 'Pembatalan pesanan telah ditolak.';
        }
        
        $cancellation->admin_note = $request->admin_note;
        $cancellation->reviewed_by = auth()->id();
        $cancellation->reviewed_at = now();
        $cancellation->save();
        
        return redirect()->back()->with('success', $message);
    }

    public function accounts(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('role', 'like', '%' . $search . '%');
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.accounts', compact('users'));
    }

    public function createAccount()
    {
        return view('admin.accounts-create');
    }

    public function storeAccount(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,kasir,member',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        return redirect()->route('admin.accounts')->with('success', 'Akun berhasil dibuat!');
    }

    public function editAccount($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent editing own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.accounts')->with('error', 'Tidak dapat mengedit akun sendiri!');
        }
        
        return view('admin.accounts-edit', compact('user'));
    }

    public function updateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent updating own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.accounts')->with('error', 'Tidak dapat mengubah akun sendiri!');
        }

        // Admin can only update role and password
        $validated = $request->validate([
            'role' => 'required|in:admin,kasir,member',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Check if role is being changed
        $roleChanged = $user->role !== $validated['role'];
        
        // Update role - force it to be a string
        $user->role = strval($validated['role']);
        
        // Update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Save changes
        $user->save();

        // If role changed, mark the user session for forced logout
        if ($roleChanged) {
            // Store in session that this user's role has changed
            session(['user_role_changed_' . $user->id => true]);
        }

        return redirect()->route('admin.accounts')->with('success', 'Role dan password akun berhasil diupdate!');
    }

    public function deleteAccount($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.accounts')->with('success', 'Akun berhasil dihapus!');
    }

    public function promotions()
    {
        return redirect()->route('admin.banners.index');
    }

    // ==================== CATEGORIES CRUD ====================
    
    public function categories()
    {
        $categories = Category::withCount('products')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
            'name.max' => 'Nama kategori maksimal 255 karakter',
        ]);

        // Generate slug from name
        $slug = \Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;

        // Check if slug exists and make it unique
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;

        Category::create($validated);

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
            'name.max' => 'Nama kategori maksimal 255 karakter',
        ]);

        // Regenerate slug if name changed
        if ($validated['name'] !== $category->name) {
            $slug = \Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;

            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $slug;
        }

        $category->update($validated);

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroyCategory(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki produk!');
        }

        $category->delete();

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Show catalog for admin (read-only)
     */
    
    /**
     * Show all reviews for admin
     */
    public function reviews(Request $request)
    {
        $query = Review::with(['user', 'product', 'orderItem', 'replier']);
        
        // Filter by product
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }
        
        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }
        
        // Filter by reply status
        if ($request->has('status')) {
            if ($request->status === 'replied') {
                $query->whereNotNull('admin_reply');
            } elseif ($request->status === 'pending') {
                $query->whereNull('admin_reply');
            }
        }
        
        $reviews = $query->latest()->paginate(15);
        $products = Product::orderBy('title')->get();
        
        return view('admin.reviews.index', compact('reviews', 'products'));
    }

    /**
     * Store admin reply to review
     */
    public function replyReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);
        
        $review->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_by' => Auth::id(),
            'replied_at' => now(),
        ]);
        
        return back()->with('success', 'Balasan berhasil disimpan!');
    }

    /**
     * Delete admin reply from review
     */
    public function deleteReply($id)
    {
        $review = Review::findOrFail($id);
        
        $review->update([
            'admin_reply' => null,
            'replied_by' => null,
            'replied_at' => null,
        ]);
        
        return back()->with('success', 'Balasan berhasil dihapus!');
    }
}
