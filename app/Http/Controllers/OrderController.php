<?php

namespace App\Http\Controllers;

use App\Models\Sale;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->sales()->with('items')->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(string $code)
    {
        $order = auth()->user()->sales()->with('items')->where('code', $code)->firstOrFail();

        return view('orders.show', compact('order'));
    }

    public function cancel(string $code)
    {
        $order = auth()->user()->sales()->where('code', $code)->firstOrFail();

        if ($order->status !== 'pending') {
            return back()->with('error', 'Solo puedes cancelar pedidos que estén pendientes.');
        }

        $order->restoreStock();
        $order->update(['status' => 'canceled']);

        return back()->with('success', 'Tu pedido fue cancelado y el stock repuesto.');
    }
}