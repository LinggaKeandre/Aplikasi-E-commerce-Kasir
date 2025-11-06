<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\UserVoucher;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('home')->with('error', 'Silakan login terlebih dahulu');
        }

        // Get selected item IDs from request
        $selectedItemIds = $request->input('items', []);
        
        if (empty($selectedItemIds)) {
            return redirect()->route('cart.index')->with('error', 'Pilih produk yang ingin di-checkout');
        }

        // Get cart with only selected items
        $cart = $user->cart()->with(['items' => function($query) use ($selectedItemIds) {
            $query->whereIn('id', $selectedItemIds)
                  ->with('product:id,title,slug,price,discount,stock,image,variants');
        }])->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item yang dipilih tidak ditemukan');
        }

        // Check if all selected items have complete variants
        $incompleteItems = $cart->items->filter(function($item) {
            $product = $item->product;
            $productVariants = $product->variants ?? [];
            $hasVariants = count($productVariants) > 0;
            
            // Jika produk punya varian tapi tidak ada variant_size, dianggap incomplete
            return $hasVariants && !$item->variant_size;
        });
        
        if ($incompleteItems->count() > 0) {
            return redirect()->route('cart.index')->with('error', 'Pastikan semua varian produk yang dipilih sudah lengkap');
        }

        // Calculate totals using final_price for selected items only
        $subtotal = $cart->items->sum(function($item) {
            return $item->final_price * $item->quantity; // Use CartItem final_price (handles variant prices)
        });

        // Store selected item IDs in session for checkout process
        session(['checkout_items' => $selectedItemIds]);

        // Get user's unused vouchers with reward voucher details
        $availableVouchers = $user->unusedVouchers()->with('rewardVoucher')->get();

        return view('checkout.index', compact('cart', 'user', 'subtotal', 'availableVouchers'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        
        // Validate request
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'nullable|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:10',
            'shipping_method' => 'required|in:si_kere,si_hemat,si_normal,sahabat_kasir,si_sultan,crazy_rich',
            'payment_method' => 'required|in:cod',
            'terms_accepted' => 'required|accepted',
            'use_voucher' => 'nullable|boolean',
            'voucher_id' => 'nullable|exists:user_vouchers,id',
        ]);

        // Get selected item IDs from session
        $selectedItemIds = session('checkout_items', []);
        
        if (empty($selectedItemIds)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih untuk checkout');
        }

        // Get cart with only selected items
        $cart = $user->cart()->with(['items' => function($query) use ($selectedItemIds) {
            $query->whereIn('id', $selectedItemIds)->with('product');
        }])->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Produk yang dipilih tidak ditemukan');
        }
        
        $cartItems = $cart->items;

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->final_price * $item->quantity; // Use CartItem final_price (handles variant prices)
        });

        // Calculate shipping cost based on method (percentage of subtotal)
        $shippingRates = [
            'si_kere' => 1,        // 1%
            'si_hemat' => 2,       // 2%
            'si_normal' => 4,      // 4%
            'sahabat_kasir' => 6,  // 6%
            'si_sultan' => 10,     // 10%
            'crazy_rich' => 20,    // 20%
        ];

        $shippingRate = $shippingRates[$validated['shipping_method']];
        $shippingCost = round(($subtotal * $shippingRate) / 100);

        // Check if user wants to use voucher
        $userVoucher = null;
        $freeShipping = false;
        
        if ($request->input('use_voucher') && $request->input('voucher_id')) {
            $userVoucher = UserVoucher::with('rewardVoucher')
                ->where('id', $request->input('voucher_id'))
                ->where('user_id', $user->id)
                ->where('is_used', false)
                ->first();
            
            // Check if voucher matches shipping method
            if ($userVoucher && $userVoucher->rewardVoucher->shipping_method === $validated['shipping_method']) {
                $shippingCost = 0;
                $freeShipping = true;
            }
        }

        // Get shipping method name
        $shippingMethodNames = [
            'si_kere' => 'Si Kere',
            'si_hemat' => 'Si Hemat',
            'si_normal' => 'Si Normal',
            'sahabat_kasir' => 'Sahabat Kasir',
            'si_sultan' => 'Si Sultan',
            'crazy_rich' => 'Crazy Rich',
        ];

        // Calculate estimated delivery date
        $estimatedDelivery = $this->calculateEstimatedDelivery($validated['shipping_method']);

        // Calculate total
        $total = $subtotal + $shippingCost;

        // Create order
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'shipping_name' => $validated['shipping_name'],
            'shipping_phone' => $validated['shipping_phone'],
            'shipping_address' => $validated['shipping_address'],
            'shipping_city' => $validated['shipping_city'],
            'shipping_province' => $validated['shipping_province'],
            'shipping_postal_code' => $validated['shipping_postal_code'],
            'shipping_method' => $validated['shipping_method'],
            'shipping_method_name' => $shippingMethodNames[$validated['shipping_method']],
            'shipping_cost' => $shippingCost,
            'estimated_delivery' => $estimatedDelivery,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'subtotal' => $subtotal,
            'total' => $total,
            'status' => 'pending',
            'terms_accepted' => true,
            'voucher_id' => $userVoucher ? $userVoucher->id : null,
            'free_shipping' => $freeShipping,
        ]);

        // Create order items with product snapshot
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            
            // Calculate final price including variant price
            $itemFinalPrice = $cartItem->final_price; // Uses CartItem getFinalPriceAttribute
            
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->title,
                'product_price' => $product->price,
                'product_discount' => $product->discount ?? 0,
                'final_price' => $itemFinalPrice,
                'quantity' => $cartItem->quantity,
                'variant_size' => $cartItem->variant_size,
                'variant_color' => $cartItem->variant_color,
                'variant_price' => $cartItem->variant_price,
                'subtotal' => $itemFinalPrice * $cartItem->quantity,
            ]);

            // Reduce product stock
            $product->decrement('stock', $cartItem->quantity);
        }

        // Mark voucher as used if applied
        if ($userVoucher) {
            $userVoucher->update([
                'is_used' => true,
                'used_at' => now(),
                'order_id' => $order->id
            ]);
        }

        // Delete only the selected cart items after order is created
        $cart->items()->whereIn('id', $selectedItemIds)->delete();

        // Clear checkout session
        session()->forget('checkout_items');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
    }

    private function calculateEstimatedDelivery($method)
    {
        $now = now();
        
        switch ($method) {
            case 'si_kere':
                return $now->addDays(5); // 5 hari
            case 'si_hemat':
                return $now->addDays(3); // 3 hari
            case 'si_normal':
                return $now->addDays(2); // 2 hari
            case 'sahabat_kasir':
                return $now->addDays(1); // Besok
            case 'si_sultan':
                return $now->addHours(2); // 2 jam
            case 'crazy_rich':
                return $now->addMinutes(20); // 20 menit
            default:
                return $now->addDays(3);
        }
    }
}
