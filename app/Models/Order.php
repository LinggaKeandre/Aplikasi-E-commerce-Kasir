<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'member_id',
        'order_number',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_province',
        'shipping_postal_code',
        'shipping_method',
        'shipping_method_name',
        'shipping_cost',
        'estimated_delivery',
        'payment_method',
        'payment_status',
        'subtotal',
        'discount',
        'discount_amount',
        'total',
        'voucher_id',
        'voucher_discount',
        'free_shipping',
        'status',
        'shipped_at',
        'terms_accepted',
        'notes',
        'verification_code',
        'is_verified',
        'points_awarded',
    ];

    protected $casts = [
        'estimated_delivery' => 'datetime',
        'shipped_at' => 'datetime',
        'terms_accepted' => 'boolean',
        'free_shipping' => 'boolean',
        'shipping_cost' => 'decimal:0',
        'subtotal' => 'decimal:0',
        'discount' => 'decimal:0',
        'voucher_discount' => 'decimal:0',
        'total' => 'decimal:0',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function userVoucher()
    {
        return $this->belongsTo(UserVoucher::class, 'voucher_id');
    }

    public function cancellationRequest()
    {
        return $this->hasOne(OrderCancellationRequest::class);
    }

    // Check if order can be cancelled
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']) 
            && !$this->cancellationRequest;
    }
}
