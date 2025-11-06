<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'shipping_method',
        'shipping_method_name',
        'discount_amount',
        'points_required',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'discount_amount' => 'decimal:0',
    ];
}
