<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::with(['user', 'items'])->latest();
        $this->applyFilters($sales, $request);

        $sales = $sales->paginate(15)->withQueryString();

        $summary = Sale::selectRaw('COUNT(*) as total_sales, COALESCE(SUM(total), 0) as total_revenue, COALESCE(SUM(subtotal), 0) as total_subtotal, COALESCE(SUM(tax), 0) as total_tax');
        $this->applyFilters($summary, $request);
        $summary = $summary->first();

        return view('admin.sales.index', compact('sales', 'summary'));
    }

    private function applyFilters($query, Request $request): void
    {
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
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'items.product']);

        return view('admin.sales.show', compact('sale'));
    }

    public function updateStatus(Request $request, Sale $sale)
    {
        $status = $request->input('status');

        if (! in_array($status, ['completed', 'pending', 'canceled'], true)) {
            abort(422, 'Estado no válido.');
        }

        if ($sale->status === $status) {
            return back();
        }

        if ($status === 'canceled' && in_array($sale->status, ['pending', 'completed'], true)) {
            $sale->restoreStock();
        }

        if ($status === 'completed' && $sale->status === 'canceled') {
            $sale->deductStock();
        }

        $sale->update(['status' => $status]);

        return back()->with('success', 'Estado de la venta actualizado.');
    }
}