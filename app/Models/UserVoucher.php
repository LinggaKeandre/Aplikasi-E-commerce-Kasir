<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reward_voucher_id',
        'order_id',
        'redeemed_at',
        'used_at',
        'is_used'
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'redeemed_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rewardVoucher()
    {
        return $this->belongsTo(RewardVoucher::class, 'reward_voucher_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
