@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><i class="bi bi-bag-check me-2 text-brand"></i>Mis pedidos</h4>
            <a href="{{ route('shop.index') }}" class="btn btn-sm brand-btn-outline">Seguir comprando</a>
        </div>

        @if ($orders->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-receipt display-4 text-muted"></i>
                <h5 class="mt-3">Aún no tienes pedidos</h5>
                <a href="{{ route('shop.index') }}" class="btn btn-brand mt-2">Explorar tienda</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle bg-white">
                    <thead class="table-light">
                        <tr>
                            <th>Pedido</th>
                            <th>Fecha</th>
                            <th>Artículos</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><strong>{{ $order->code }}</strong></td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $order->items->sum('quantity') }} artículos</td>
                                <td>{{ format_money($order->total) }}</td>
                                <td><span class="badge {{ $order->getStatusBadge() }}">{{ $order->getStatusLabel() }}</span></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('orders.show', $order->code) }}" class="btn btn-sm btn-outline-primary">Ver detalle</a>
                                        @if ($order->status === 'pending')
                                            <form method="POST" action="{{ route('orders.cancel', $order->code) }}"
                                                  onsubmit="return confirm('¿Seguro que quieres cancelar el pedido {{ $order->code }}?');">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger">Cancelar</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        @endif
    </div>
@endsection