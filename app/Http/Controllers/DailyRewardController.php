<?php

namespace App\Http\Controllers;

use App\Models\DailyReward;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyRewardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get or create daily reward record
        $dailyReward = DailyReward::firstOrCreate(
            ['user_id' => $user->id],
            [
                'current_day' => 1,
                'streak' => 0,
                'last_claim_date' => null,
                'next_reset_at' => Carbon::tomorrow()->startOfDay(),
            ]
        );

        // Check if need to reset due to missed days
        $dailyReward->checkAndReset();

        // Prepare days data (1-7)
        $days = [];
        for ($i = 1; $i <= 7; $i++) {
            $days[] = [
                'day' => $i,
                'points' => DailyReward::getRewardForDay($i),
                'name' => DailyReward::getRewardName($i),
                'claimed' => $i < $dailyReward->current_day,
                'current' => $i == $dailyReward->current_day,
                'locked' => $i > $dailyReward->current_day,
            ];
        }

        return view('member.daily-rewards', [
            'dailyReward' => $dailyReward,
            'days' => $days,
            'canClaim' => $dailyReward->canClaim(),
        ]);
    }

    public function claim()
    {
        $user = auth()->user();
        
        $dailyReward = DailyReward::where('user_id', $user->id)->first();

        if (!$dailyReward) {
            return redirect()->back()->with('error', 'Daily reward tidak ditemukan.');
        }

        // Check if already claimed today
        if (!$dailyReward->canClaim()) {
            return redirect()->back()->with('error', 'Anda sudah claim hari ini. Kembali besok!');
        }

        // Check and reset if needed
        $dailyReward->checkAndReset();

        DB::beginTransaction();
        try {
            // Get reward points
            $points = DailyReward::getRewardForDay($dailyReward->current_day);

            // Add points to user
            PointTransaction::create([
                'user_id' => $user->id,
                'points' => $points,
                'type' => 'earn',
                'description' => 'Daily Reward - Day ' . $dailyReward->current_day,
            ]);

            // Update user total points in user_points table
            $userPoint = $user->userPoint;
            if ($userPoint) {
                $userPoint->increment('points', $points);
            } else {
                $user->userPoint()->create(['points' => $points]);
            }

            // Update daily reward
            $currentDay = $dailyReward->current_day;
            $nextDay = $currentDay + 1;
            
            // If completed 7 days, reset to day 1 and increment streak
            if ($nextDay > 7) {
                $dailyReward->update([
                    'current_day' => 1,
                    'streak' => $dailyReward->streak + 1,
                    'last_claim_date' => Carbon::today(),
                    'next_reset_at' => Carbon::tomorrow()->startOfDay(),
                ]);
            } else {
                $dailyReward->update([
                    'current_day' => $nextDay,
                    'last_claim_date' => Carbon::today(),
                    'next_reset_at' => Carbon::tomorrow()->startOfDay(),
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', "Selamat! Anda mendapat $points poin dari Daily Reward Day $currentDay!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
