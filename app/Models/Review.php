<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'product_id',
        'user_id',
        'rating',
        'review',
        'admin_reply',
        'replied_by',
        'replied_at'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Relationship to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship to User (reviewer)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to OrderItem
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Relationship to Admin who replied
     */
    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    /**
     * Get star rating as formatted text
     */
    public function getStarsAttribute()
    {
        return str_repeat('⭐', $this->rating);
    }
}
