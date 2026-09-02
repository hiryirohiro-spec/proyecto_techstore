<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'items'])->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        if ($from = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $sales = $query->paginate(15)->withQueryString();

        $summary = Sale::selectRaw('COUNT(*) as total_sales, COALESCE(SUM(total), 0) as total_revenue, COALESCE(SUM(subtotal), 0) as total_subtotal, COALESCE(SUM(tax), 0) as total_tax')
            ->where('status', 'completed')
            ->first();

        return view('admin.sales.index', compact('sales', 'summary'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'items.product']);

        return view('admin.sales.show', compact('sale'));
    }
}