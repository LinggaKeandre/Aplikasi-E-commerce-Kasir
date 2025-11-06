<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCancellationRequest extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'reason',
        'reason_detail',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Get reason options
    public static function getReasonOptions(): array
    {
        return [
            'wrong_product' => 'Salah memilih produk',
            'change_order' => 'Ingin mengganti pesanan',
            'wrong_address' => 'Salah alamat pengiriman',
            'change_payment' => 'Ingin ubah metode pembayaran',
            'delivery_too_long' => 'Estimasi pengiriman terlalu lama',
            'cheaper_elsewhere' => 'Menemukan harga lebih murah di tempat lain',
            'not_needed' => 'Produk tidak jadi dibutuhkan',
            'order_later' => 'Ingin memesan nanti saja',
            'duplicate_order' => 'Sudah memesan produk serupa',
            'other' => 'Lainnya',
        ];
    }

    // Get readable reason
    public function getReadableReasonAttribute(): string
    {
        $reasons = self::getReasonOptions();
        return $reasons[$this->reason] ?? $this->reason;
    }
}
