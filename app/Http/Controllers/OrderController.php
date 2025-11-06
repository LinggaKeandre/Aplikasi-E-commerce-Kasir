<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderCancellationRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'items.review', 'cancellationRequest', 'userVoucher.rewardVoucher'])->findOrFail($id);
        
        // Check authorization
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
        
        return view('orders.show', compact('order'));
    }

    public function requestCancellation(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Check authorization
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
        
        // Check if order can be cancelled
        if (!$order->canBeCancelled()) {
            return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }
        
        // Validate request
        $request->validate([
            'reason' => 'required|string',
            'reason_detail' => 'nullable|string|max:500',
        ]);
        
        // Create cancellation request
        OrderCancellationRequest::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'reason_detail' => $request->reason_detail,
            'status' => 'pending',
        ]);
        
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Permintaan pembatalan pesanan telah dikirim ke admin. Anda akan mendapat notifikasi setelah direview.');
    }

    /**
     * Check verification status for polling
     */
    public function checkVerificationStatus($id)
    {
        $order = Order::find($id);
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'is_verified' => $order->is_verified ?? false,
            'member_id' => $order->member_id,
            'points_awarded' => $order->points_awarded
        ]);
    }
}
