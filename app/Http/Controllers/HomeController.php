<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\DailyReward;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        
        // Get active banners for home page only
        $banners = Banner::active()->where('position', 'home')->ordered()->get();

        // Get daily reward data for authenticated users
        $dailyReward = null;
        $days = [];
        $canClaim = false;
        
        if (auth()->check()) {
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
            for ($i = 1; $i <= 7; $i++) {
                $days[] = [
                    'day' => $i,
                    'points' => DailyReward::getRewardForDay($i),
                    'claimed' => $i < $dailyReward->current_day,
                    'current' => $i == $dailyReward->current_day,
                    'locked' => $i > $dailyReward->current_day,
                ];
            }

            $canClaim = $dailyReward->canClaim();
        }

        $query = Product::query()->with('category');

        // filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('meta', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        // ✅ Produk terbaru di atas (descending by id)
        $query->orderBy('id', 'desc');

        // paginasi
        $products = $query->paginate(20)->withQueryString();

        return view('home', compact('categories', 'products', 'banners', 'dailyReward', 'days', 'canClaim'));
    }
}
