<?php

namespace App\Http\Controllers;

use App\Models\UserVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Auth::user()->userVouchers()
            ->with(['rewardVoucher', 'order'])
            ->orderBy('is_used', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('member.vouchers', compact('vouchers'));
    }
}
