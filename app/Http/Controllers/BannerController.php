<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('display_order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'position' => 'required|in:home,customer_display',
        ]);

        // Get the highest display order and add 1
        $maxOrder = Banner::max('display_order') ?? 0;

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('banners', $imageName, 'public');
        }

        Banner::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active'),
            'display_order' => $maxOrder + 1,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.banners.index', ['position' => $request->position])
            ->with('success', 'Banner berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'position' => 'required|in:home,customer_display',
        ]);

        $data = [
            'title' => $request->title,
            'is_active' => $request->has('is_active'),
            'position' => $request->position,
        ];

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $data['image_path'] = $image->storeAs('banners', $imageName, 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index', ['position' => $request->position])
            ->with('success', 'Banner berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $position = $banner->position;
        
        // Delete image file
        if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index', ['position' => $position])
            ->with('success', 'Banner berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggle(Banner $banner)
    {
        $banner->update([
            'is_active' => !$banner->is_active
        ]);

        return redirect()->route('admin.banners.index', ['position' => $banner->position])
            ->with('success', 'Status banner berhasil diubah!');
    }

    /**
     * Reorder banners (move up or down)
     */
    public function reorder(Request $request, Banner $banner)
    {
        $direction = $request->input('direction'); // 'up' or 'down'
        
        $currentOrder = $banner->display_order;
        $position = $banner->position;
        
        if ($direction === 'up') {
            // Find banner with the next lower order in the same position
            $swapBanner = Banner::where('position', $position)
                ->where('display_order', '<', $currentOrder)
                ->orderBy('display_order', 'desc')
                ->first();
                
            if ($swapBanner) {
                $banner->update(['display_order' => $swapBanner->display_order]);
                $swapBanner->update(['display_order' => $currentOrder]);
            }
        } elseif ($direction === 'down') {
            // Find banner with the next higher order in the same position
            $swapBanner = Banner::where('position', $position)
                ->where('display_order', '>', $currentOrder)
                ->orderBy('display_order', 'asc')
                ->first();
                
            if ($swapBanner) {
                $banner->update(['display_order' => $swapBanner->display_order]);
                $swapBanner->update(['display_order' => $currentOrder]);
            }
        }

        return redirect()->route('admin.banners.index', ['position' => $position])
            ->with('success', 'Urutan banner berhasil diubah!');
    }
}
