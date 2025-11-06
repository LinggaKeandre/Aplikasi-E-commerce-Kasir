<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\UserPoint;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Hanya tampilkan notifikasi yang belum dibaca (is_read = false)
        $notifications = Auth::user()->notifications()
            ->where('is_read', false)
            ->paginate(20);
        $unreadCount = Auth::user()->unreadNotificationsCount();
        
        return view('member.notifications', compact('notifications', 'unreadCount'));
    }

    public function getUnreadCount()
    {
        return response()->json([
            'count' => Auth::user()->unreadNotificationsCount()
        ]);
    }

    public function verify(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        
        // Pastikan notifikasi milik user yang login
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $selectedCode = trim((string)$request->input('code'));
        $correctCode = trim((string)$notification->data['correct_code']);

        // Debug log
        \Log::info('Verification attempt', [
            'selected' => $selectedCode,
            'correct' => $correctCode,
            'match' => $selectedCode === $correctCode
        ]);

        if ($selectedCode !== $correctCode) {
            // Kode salah - expire notifikasi ini
            $notification->markAsRead();
            
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi salah! Notifikasi ini sudah tidak berlaku. Silakan minta kasir untuk mengirim ulang kode verifikasi.',
                'debug' => [
                    'selected' => $selectedCode,
                    'correct' => $correctCode
                ]
            ]);
        }

        // Mark notification as read
        $notification->markAsRead();

        // Find the pending order (last order for this user from kasir)
        $order = Order::where('shipping_method', 'kasir')
            ->whereNull('verification_code')
            ->latest()
            ->first();

        if ($order) {
            // Calculate points
            $points = floor($order->total / 1000);

            // Update order dengan member_id dan points
            $order->update([
                'member_id' => Auth::id(),
                'verification_code' => $correctCode,
                'is_verified' => true,
                'points_awarded' => $points  // Simpan jumlah poin yang diberikan
            ]);

            // Add points
            $userPoint = UserPoint::firstOrCreate(
                ['user_id' => Auth::id()],
                ['points' => 0]
            );
            $userPoint->increment('points', $points);

            // Log transaction
            PointTransaction::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'points' => $points,
                'type' => 'earn',
                'description' => 'Poin dari transaksi #' . $order->order_number
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil!',
                'points_earned' => $points,
                'total_points' => $userPoint->points
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Order tidak ditemukan'
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()->where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }
}
