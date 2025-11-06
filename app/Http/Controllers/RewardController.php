<?php

namespace App\Http\Controllers;

use App\Models\RewardVoucher;
use App\Models\UserVoucher;
use App\Models\UserPoint;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = RewardVoucher::where('is_active', true)
            ->orderBy('points_required', 'asc')
            ->get();
        
        $userPoints = Auth::user()->userPoint->points ?? 0;
        
        return view('member.rewards', compact('rewards', 'userPoints'));
    }

    public function redeem(Request $request, $id)
    {
        $reward = RewardVoucher::findOrFail($id);
        $user = Auth::user();
        $userPoint = UserPoint::firstOrCreate(
            ['user_id' => $user->id],
            ['points' => 0]
        );

        // Check if user has enough points
        if ($userPoint->points < $reward->points_required) {
            return redirect()->back()->with('error', 'Poin Anda tidak cukup untuk menukar reward ini.');
        }

        DB::beginTransaction();
        try {
            // Kurangi poin user
            $userPoint->decrement('points', $reward->points_required);

            // Log point transaction
            PointTransaction::create([
                'user_id' => $user->id,
                'points' => -$reward->points_required,
                'type' => 'redeem',
                'description' => 'Penukaran voucher: ' . $reward->name
            ]);

            // Buat user voucher
            UserVoucher::create([
                'user_id' => $user->id,
                'reward_voucher_id' => $reward->id,
                'redeemed_at' => now(),
                'is_used' => false
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Voucher berhasil ditukar! Cek di halaman "Voucher Saya".');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
