<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'reviews' => function($query) {
                $query->with(['user', 'replier'])
                      ->latest()
                      ->limit(10);
            }])
            ->firstOrFail();
        return view('product.show', compact('product'));
    }

    public function category($slug)
    {
        $products = Product::whereHas('category', fn($q)=> $q->where('slug', $slug))->get();
        return view('product.category', compact('products','slug'));
    }
}
