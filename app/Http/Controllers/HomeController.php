<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::available()->where('is_featured', true)->latest()->limit(8)->get();
        $newArrivals = Product::available()->newlyAdded()->latest()->limit(8)->get();
        $categories = Category::withCount('products')->get();

        return view('home.index', compact('featured', 'newArrivals', 'categories'));
    }
}