<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()?->cart()
            ->with(['items' => function($query) {
                $query->orderBy('created_at', 'desc')
                    ->with('product:id,title,slug,price,discount,stock,image,variants'); // Include variants
            }])
            ->first();
        
        // Pre-calculate incomplete items count & sort items
        if ($cart) {
            // Helper function untuk cek incomplete
            $isItemIncomplete = function($item) {
                $product = $item->product;
                $productVariants = $product->variants ?? [];
                
                // Jika produk tidak punya varian, item dianggap complete
                if (count($productVariants) == 0) {
                    return false;
                }
                
                // Jika produk punya 1 varian, cek variant_size saja
                if (count($productVariants) == 1) {
                    return !$item->variant_size;
                }
                
                // Jika produk punya 2+ varian, cek variant_size DAN variant_color
                return !$item->variant_size || !$item->variant_color;
            };
            
            // Hitung incomplete count
            $cart->incompleteCount = $cart->items->filter($isItemIncomplete)->count();
            
            // Sort items: incomplete di atas (0), complete di bawah (1)
            $sortedItems = $cart->items->sortBy(function($item) use ($isItemIncomplete) {
                return $isItemIncomplete($item) ? 0 : 1;
            })->values(); // Reset keys
            
            // Replace collection dengan yang sudah di-sort
            $cart->setRelation('items', $sortedItems);
        }
        
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('home')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $quantity = $request->input('quantity', 1);
        
        // Ambil varian dari berbagai kemungkinan nama field
        // Strategy: varian pertama -> variant_size, varian kedua -> variant_color
        $variantSize = null;
        $variantColor = null;
        $variantPrice = 0; // Total variant price
        
        $productVariants = $product->variants ?? [];
        if (count($productVariants) > 0) {
            // Varian pertama
            $firstVariant = $productVariants[0];
            $firstVariantKey = 'variant_' . strtolower(str_replace(' ', '_', $firstVariant['type']));
            $variantSize = $request->input($firstVariantKey);
            
            // Cari harga varian pertama
            if ($variantSize && isset($firstVariant['options'])) {
                foreach ($firstVariant['options'] as $option) {
                    if ($option['value'] === $variantSize && isset($option['price']) && $option['price'] > 0) {
                        $variantPrice += (float)$option['price'];
                        break;
                    }
                }
            }
            
            // Varian kedua (jika ada)
            if (count($productVariants) > 1) {
                $secondVariant = $productVariants[1];
                $secondVariantKey = 'variant_' . strtolower(str_replace(' ', '_', $secondVariant['type']));
                $variantColor = $request->input($secondVariantKey);
                
                // Cari harga varian kedua
                if ($variantColor && isset($secondVariant['options'])) {
                    foreach ($secondVariant['options'] as $option) {
                        if ($option['value'] === $variantColor && isset($option['price']) && $option['price'] > 0) {
                            $variantPrice += (float)$option['price'];
                            break;
                        }
                    }
                }
            }
        }
        
        // Validasi stok
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }
        
        $cart = $user->cart()->firstOrCreate([]);
        
        // Cari item dengan produk DAN variasi yang sama (termasuk null)
        $item = $cart->items()
            ->where('product_id', $product->id)
            ->where(function($q) use ($variantSize) {
                if ($variantSize === null) {
                    $q->whereNull('variant_size');
                } else {
                    $q->where('variant_size', $variantSize);
                }
            })
            ->where(function($q) use ($variantColor) {
                if ($variantColor === null) {
                    $q->whereNull('variant_color');
                } else {
                    $q->where('variant_color', $variantColor);
                }
            })
            ->first();
        
        if ($item) {
            // Update quantity jika item dengan variasi yang sama sudah ada
            $newQuantity = $item->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi');
            }
            $item->update(['quantity' => $newQuantity]);
        } else {
            // Buat item baru jika variasi berbeda atau belum ada
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'variant_size' => $variantSize,
                'variant_color' => $variantColor,
                'variant_price' => $variantPrice > 0 ? $variantPrice : null,
            ]);
        }
        
        $variantText = [];
        if ($variantSize) $variantText[] = "ukuran {$variantSize}";
        if ($variantColor) $variantText[] = "warna {$variantColor}";
        $variantStr = !empty($variantText) ? ' (' . implode(', ', $variantText) . ')' : '';
        
        return back()->with('success', "Berhasil menambahkan {$quantity} {$product->title}{$variantStr} ke keranjang");
    }

    public function updateVariant(Request $request, $id)
    {
        $item = CartItem::with(['cart', 'product'])->findOrFail($id);
        
        // Pastikan item ini milik user yang sedang login
        if ($item->cart->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized');
        }
        
        // Strategy: varian pertama -> variant_size, varian kedua -> variant_color
        $variantSize = null;
        $variantColor = null;
        $variantPrice = 0;
        
        $productVariants = $item->product->variants ?? [];
        if (count($productVariants) > 0) {
            // Varian pertama
            $firstVariant = $productVariants[0];
            $firstVariantKey = 'variant_' . strtolower(str_replace(' ', '_', $firstVariant['type']));
            $variantSize = $request->input($firstVariantKey);
            
            // Cari harga varian pertama
            if ($variantSize && isset($firstVariant['options'])) {
                foreach ($firstVariant['options'] as $option) {
                    if ($option['value'] === $variantSize && isset($option['price']) && $option['price'] > 0) {
                        $variantPrice += (float)$option['price'];
                        break;
                    }
                }
            }
            
            // Varian kedua (jika ada)
            if (count($productVariants) > 1) {
                $secondVariant = $productVariants[1];
                $secondVariantKey = 'variant_' . strtolower(str_replace(' ', '_', $secondVariant['type']));
                $variantColor = $request->input($secondVariantKey);
                
                // Cari harga varian kedua
                if ($variantColor && isset($secondVariant['options'])) {
                    foreach ($secondVariant['options'] as $option) {
                        if ($option['value'] === $variantColor && isset($option['price']) && $option['price'] > 0) {
                            $variantPrice += (float)$option['price'];
                            break;
                        }
                    }
                }
            }
            
            // Validasi: varian pertama wajib diisi
            if (empty($variantSize)) {
                return back()->with('error', $firstVariant['type'] . ' harus dipilih');
            }
        }
        
        // Cek apakah kombinasi varian ini sama dengan varian item saat ini
        if ($item->variant_size === $variantSize && $item->variant_color === $variantColor) {
            return back()->with('info', 'Varian tidak berubah');
        }
        
        // Cek apakah sudah ada item dengan kombinasi varian yang sama persis
        $existingItem = $item->cart->items()
            ->where('product_id', $item->product_id)
            ->where('id', '!=', $item->id) // Exclude current item
            ->where(function($q) use ($variantSize) {
                if ($variantSize === null) {
                    $q->whereNull('variant_size');
                } else {
                    $q->where('variant_size', $variantSize);
                }
            })
            ->where(function($q) use ($variantColor) {
                if ($variantColor === null) {
                    $q->whereNull('variant_color');
                } else {
                    $q->where('variant_color', $variantColor);
                }
            })
            ->first();
        
        if ($existingItem) {
            // Jika sudah ada item dengan varian yang sama persis, gabungkan quantity dan hapus item yang lama
            $totalQty = $existingItem->quantity + $item->quantity;
            $existingItem->update(['quantity' => $totalQty]);
            $item->delete();
            
            return back()->with('success', "Varian diperbarui! Item digabungkan dengan varian yang sama (Total: {$totalQty} item)");
        } else {
            // Update varian item ini karena tidak ada duplikat
            $item->update([
                'variant_size' => $variantSize,
                'variant_color' => $variantColor,
                'variant_price' => $variantPrice > 0 ? $variantPrice : null,
            ]);
            
            return back()->with('success', 'Varian berhasil diperbarui');
        }
    }

    public function remove($id)
    {
        $user = Auth::user();
        $cart = $user->cart()->first();
        $item = $cart?->items()->find($id);
        if ($item) $item->delete();
        return back();
    }
}
