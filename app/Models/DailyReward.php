<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DailyReward extends Model
{
    protected $fillable = [
        'user_id',
        'current_day',
        'streak',
        'last_claim_date',
        'next_reset_at',
    ];

    protected $casts = [
        'last_claim_date' => 'date',
        'next_reset_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get reward points for specific day
     */
    public static function getRewardForDay($day)
    {
        $rewards = [
            1 => 5,
            2 => 7,
            3 => 9,
            4 => 12,
            5 => 16,
            6 => 20,
            7 => 25,
        ];

        return $rewards[$day] ?? 0;
    }

    /**
     * Get reward name for specific day
     */
    public static function getRewardName($day)
    {
        $names = [
            1 => '50 COINS - CLAIMED',
            2 => '100 COINS - DAY 2',
            3 => 'CONTROL - DAY 3',
            4 => 'DOUGLAS DC-3 - DAY 4',
            5 => 'SUSPENSION - DAY 5',
            6 => '1500 COINS - DAY 6',
            7 => 'F-15 JET FIGHTER - DAY 7',
        ];

        return $names[$day] ?? "DAY $day";
    }

    /**
     * Check if can claim today
     */
    public function canClaim()
    {
        if (!$this->last_claim_date) {
            return true;
        }

        return Carbon::parse($this->last_claim_date)->lt(Carbon::today());
    }

    /**
     * Reset if missed a day
     */
    public function checkAndReset()
    {
        if (!$this->last_claim_date) {
            return;
        }

        $daysSinceLastClaim = Carbon::today()->diffInDays($this->last_claim_date);
        
        // If missed more than 1 day, reset to day 1
        if ($daysSinceLastClaim > 1) {
            $this->current_day = 1;
            $this->save();
        }
    }
}
