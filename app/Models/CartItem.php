<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id','product_id','quantity','variant_size','variant_color','variant_price'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get formatted variant text
     */
    public function getVariantTextAttribute()
    {
        $variants = [];
        if ($this->variant_size) {
            $variants[] = "Ukuran: {$this->variant_size}";
        }
        if ($this->variant_color) {
            $variants[] = "Warna: {$this->variant_color}";
        }
        return !empty($variants) ? implode(', ', $variants) : null;
    }

    /**
     * Get final item price (variant price OR product price, not both)
     */
    public function getFinalPriceAttribute()
    {
        $variantPrice = $this->variant_price ?? 0;
        
        // If variant has price, use variant price and apply discount
        if ($variantPrice > 0) {
            $discount = $this->product->discount ?? 0;
            if ($discount > 0) {
                return $variantPrice * (1 - ($discount / 100));
            }
            return $variantPrice;
        }
        
        // If no variant price, use base product price (with discount already applied)
        return $this->product->final_price;
    }

    /**
     * Get total price for this item (final_price * quantity)
     */
    public function getTotalPriceAttribute()
    {
        return $this->final_price * $this->quantity;
    }
}