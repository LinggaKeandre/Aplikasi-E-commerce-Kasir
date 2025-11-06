<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'product_discount',
        'final_price',
        'quantity',
        'variant_size',
        'variant_color',
        'variant_price',
        'variant_data',
        'subtotal',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'product_discount' => 'integer',
        'final_price' => 'decimal:2',
        'variant_price' => 'decimal:2',
        'variant_data' => 'array',
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship to Review
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Check if this item has been reviewed
     */
    public function hasReview()
    {
        return $this->review()->exists();
    }

    /**
     * Get variant information with proper labels from product
     */
    public function getVariantInfoAttribute()
    {
        $variants = [];
        
        // First check variant_data (new system with barcode scanner)
        if ($this->variant_data) {
            $variantData = is_string($this->variant_data) ? json_decode($this->variant_data, true) : $this->variant_data;
            if ($variantData && isset($variantData['type']) && isset($variantData['value'])) {
                return [['label' => $variantData['type'], 'value' => $variantData['value']]];
            }
        }
        
        // Fallback to old system
        $product = $this->product;
        
        if (!$product || !$product->variants) {
            // Fallback to generic labels
            if ($this->variant_size) {
                $variants[] = ['label' => 'Size', 'value' => $this->variant_size];
            }
            if ($this->variant_color) {
                $variants[] = ['label' => 'Warna', 'value' => $this->variant_color];
            }
            return $variants;
        }
        
        // Get proper labels from product variants
        $productVariants = $product->variants;
        
        foreach ($productVariants as $index => $variant) {
            $type = $variant['type'] ?? null;
            
            if ($index === 0 && $this->variant_size) {
                $variants[] = ['label' => $type, 'value' => $this->variant_size];
            } elseif ($index === 1 && $this->variant_color) {
                $variants[] = ['label' => $type, 'value' => $this->variant_color];
            }
        }
        
        return $variants;
    }
}
