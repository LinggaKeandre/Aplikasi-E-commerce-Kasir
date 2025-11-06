<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'phone',
        'photo',
        'gender',
        'birth_date',
        'address',
        'city',
        'province',
        'postal_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }
    /**
     * Relasi ke model Cart
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Relasi ke model Order
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi ke transaksi offline sebagai member
     */
    public function memberOrders()
    {
        return $this->hasMany(Order::class, 'member_id');
    }

    /**
     * Get all orders (online + offline)
     */
    public function allOrders()
    {
        return Order::where('user_id', $this->id)
            ->orWhere('member_id', $this->id);
    }

    /**
     * Relasi ke model UserPoint
     */
    public function userPoint()
    {
        return $this->hasOne(UserPoint::class);
    }

    /**
     * Relasi ke model PointTransaction
     */
    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    /**
     * Relasi ke model Notification
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get unread notifications count
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    /**
     * Relasi ke user vouchers
     */
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    /**
     * Get unused vouchers
     */
    public function unusedVouchers()
    {
        return $this->userVouchers()->where('is_used', false)->with('rewardVoucher');
    }

    /**
     * Get daily reward progress
     */
    public function dailyReward()
    {
        return $this->hasOne(DailyReward::class);
    }
}