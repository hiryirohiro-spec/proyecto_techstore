<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = (float) Sale::where('status', 'completed')->sum('total');
        $totalSales = Sale::where('status', 'completed')->count();
        $totalCustomers = \App\Models\User::where('is_admin', false)->count();
        $totalProducts = Product::count();

        $available = Product::where('status', 'available')->where('stock', '>', 0)->count();
        $outOfStock = Product::outOfStock()->count();
        $defective = Product::defective()->count();
        $newProducts = Product::newlyAdded()->count();
        $lowStock = Product::lowStock()->count();

        $recentSales = Sale::with(['user', 'items'])->latest()->limit(8)->get();
        $lowStockProducts = Product::lowStock()->with('category')->limit(10)->get();

        $topProducts = \App\Models\SaleItem::selectRaw('product_id, product_name, SUM(quantity) as total_qty, SUM(subtotal) as total_revenue')
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $salesByMonth = Sale::where('status', 'completed')
            ->selectRaw("strftime('%Y-%m', created_at) as month, COUNT(*) as total_sales, SUM(total) as revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalSales',
            'totalCustomers',
            'totalProducts',
            'available',
            'outOfStock',
            'defective',
            'newProducts',
            'lowStock',
            'recentSales',
            'lowStockProducts',
            'topProducts',
            'salesByMonth',
        ));
    }
}