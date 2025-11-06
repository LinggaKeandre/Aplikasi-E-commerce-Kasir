<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review for an order item
     */
    public function store(Request $request, $orderItemId)
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($orderItemId);
        
        // Verify order belongs to authenticated user
        if ($orderItem->order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Verify order status is delivered
        if ($orderItem->order->status !== 'delivered') {
            return back()->with('error', 'Anda hanya bisa memberikan review untuk pesanan yang sudah diterima.');
        }
        
        // Verify item hasn't been reviewed yet
        if ($orderItem->hasReview()) {
            return back()->with('error', 'Produk ini sudah Anda review sebelumnya.');
        }
        
        // Validate request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);
        
        // Create review
        Review::create([
            'order_item_id' => $orderItem->id,
            'user_id' => Auth::id(),
            'product_id' => $orderItem->product_id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);
        
        return back()->with('success', 'Terima kasih! Review Anda telah berhasil disimpan.');
    }

    /**
     * Update an existing review (only by the review owner)
     */
    public function update(Request $request, $reviewId)
    {
        $review = Review::findOrFail($reviewId);
        
        // Verify review belongs to authenticated user
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);
        
        // Update review (will automatically update updated_at timestamp)
        $review->rating = $validated['rating'];
        $review->review = $validated['review'];
        $review->save(); // This will update the updated_at timestamp
        
        return back()->with('success', 'Review Anda berhasil diupdate!');
    }

    /**
     * Delete a review (only by the review owner)
     */
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        
        // Verify review belongs to authenticated user
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $review->delete();
        
        return back()->with('success', 'Review Anda berhasil dihapus.');
    }

    /**
     * Admin reply to a review
     */
    public function reply(Request $request, $reviewId)
    {
        // Verify user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $review = Review::findOrFail($reviewId);
        
        // Validate request
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);
        
        // Update review with admin reply
        $review->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_by' => Auth::id(),
            'replied_at' => now(),
        ]);
        
        return back()->with('success', 'Balasan berhasil ditambahkan!');
    }
}
