<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        $stats = [
            'total' => $products->count(),
            'available' => $products->where('status', 'available')->where('stock', '>', 0)->count(),
            'out_of_stock' => $products->filter(fn ($p) => $p->status === 'out_of_stock' || $p->stock <= 0)->count(),
            'defective' => $products->where('status', 'defective')->count(),
            'low_stock' => $products->filter(fn ($p) => $p->status === 'available' && $p->stock > 0 && $p->stock <= 10)->count(),
            'new' => $products->filter(fn ($p) => $p->isNew())->count(),
            'stock_value' => $products->sum(fn ($p) => $p->stock * $p->cost),
            'stock_retail' => $products->sum(fn ($p) => $p->stock * $p->price),
        ];

        $byCategory = Category::withCount('products')->withSum('products', 'stock')->orderBy('name')->get();

        return view('admin.inventory.index', compact('products', 'stats', 'byCategory'));
    }
}