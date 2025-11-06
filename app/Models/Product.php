<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','title','slug','meta','description','price','stock','discount','brand','image','variants','barcode'];

    protected $casts = [
        'variants' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship to Reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get image URL (handles both local files and external URLs)
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://via.placeholder.com/200?text=No+Image';
        }

        // Check if it's already a full URL (starts with http:// or https://)
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Otherwise, it's a local file
        return asset('storage/' . $this->image);
    }

    /**
     * Get final price after discount
     */
    public function getFinalPriceAttribute()
    {
        if ($this->discount) {
            return $this->price * (1 - ($this->discount / 100));
        }
        return $this->price;
    }

    /**
     * Get formatted final price
     */
    public function getFormattedFinalPriceAttribute()
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    /**
     * Get formatted original price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get average rating from reviews
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count
     */
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Get formatted average rating (1 decimal)
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->average_rating, 1);
    }

    /**
     * Check if product has variants with prices
     */
    public function hasVariantPrices()
    {
        if (!$this->variants || !is_array($this->variants)) {
            return false;
        }

        foreach ($this->variants as $variant) {
            if (isset($variant['options']) && is_array($variant['options'])) {
                foreach ($variant['options'] as $option) {
                    if (isset($option['price']) && $option['price'] !== null && $option['price'] > 0) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Get price range from variants
     * Returns array ['min' => 50000, 'max' => 60000]
     */
    public function getVariantPriceRange()
    {
        if (!$this->hasVariantPrices()) {
            return null;
        }

        $prices = [];
        foreach ($this->variants as $variant) {
            if (isset($variant['options']) && is_array($variant['options'])) {
                foreach ($variant['options'] as $option) {
                    if (isset($option['price']) && $option['price'] !== null && $option['price'] > 0) {
                        $variantPrice = (float)$option['price'];
                        
                        // Apply discount to variant price if discount exists
                        if ($this->discount) {
                            $variantPrice = $variantPrice * (1 - ($this->discount / 100));
                        }
                        
                        $prices[] = $variantPrice;
                    }
                }
            }
        }

        if (empty($prices)) {
            return null;
        }

        return [
            'min' => min($prices),
            'max' => max($prices)
        ];
    }

    /**
     * Get original price range from variants (without discount)
     * Returns array ['min' => 50000, 'max' => 60000]
     */
    public function getVariantOriginalPriceRange()
    {
        if (!$this->hasVariantPrices()) {
            return null;
        }

        $prices = [];
        foreach ($this->variants as $variant) {
            if (isset($variant['options']) && is_array($variant['options'])) {
                foreach ($variant['options'] as $option) {
                    if (isset($option['price']) && $option['price'] !== null && $option['price'] > 0) {
                        $prices[] = (float)$option['price'];
                    }
                }
            }
        }

        if (empty($prices)) {
            return null;
        }

        return [
            'min' => min($prices),
            'max' => max($prices)
        ];
    }

    /**
     * Get formatted price range for display
     * Returns "Rp 50.000 ~ Rp 60.000" or single price if same
     */
    public function getFormattedPriceRangeAttribute()
    {
        $range = $this->getVariantPriceRange();
        
        if (!$range) {
            return $this->formatted_final_price;
        }

        $minFormatted = 'Rp ' . number_format($range['min'], 0, ',', '.');
        $maxFormatted = 'Rp ' . number_format($range['max'], 0, ',', '.');

        if ($range['min'] === $range['max']) {
            return $minFormatted;
        }

        return $minFormatted . ' ~ ' . $maxFormatted;
    }
}
