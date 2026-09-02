@extends('layouts.app')

@section('title', 'Pedido ' . $order->code)

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none">Mis pedidos</a></li>
                <li class="breadcrumb-item active">{{ $order->code }}</li>
            </ol>
        </nav>

        <div class="text-center mb-4">
            <div class="bg-success-subtle d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 70px; height: 70px;">
                <i class="bi bi-check-lg text-success fs-1"></i>
            </div>
            <h4 class="fw-bold mb-1">¡Gracias por tu compra!</h4>
            <p class="text-muted">Tu pedido se registró correctamente con el código <strong>{{ $order->code }}</strong>.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border">
                    <div class="card-body">
                        <h6 class="fw-bold border-bottom pb-2 mb-3"><i class="bi bi-box-seam me-2 text-brand"></i>Artículos</h6>
                        @foreach ($order->items as $item)
                            <div class="d-flex gap-3 py-2 align-items-center border-bottom">
                                @if ($item->product)
                                    <img src="{{ product_image($item->product) }}" alt="" style="width: 55px; height: 55px; object-fit: cover; border-radius: .4rem;">
                                @else
                                    <div class="bg-light rounded p-3"><i class="bi bi-box text-muted"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <div class="small fw-semibold">{{ $item->product_name }}</div>
                                    <div class="small text-muted">{{ $item->quantity }} × {{ format_money($item->price) }}</div>
                                </div>
                                <div class="small fw-semibold">{{ format_money($item->subtotal) }}</div>
                            </div>
                        @endforeach

                        <div class="mt-3 pt-3 border-top ms-auto" style="max-width: 300px">
                            <div class="d-flex justify-content-between py-1"><span class="text-muted">Subtotal</span><span>{{ format_money($order->subtotal) }}</span></div>
                            <div class="d-flex justify-content-between py-1"><span class="text-muted">Impuestos</span><span>{{ format_money($order->tax) }}</span></div>
                            <div class="d-flex justify-content-between py-1 fw-bold fs-5"><span>Total</span><span>{{ format_money($order->total) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold border-bottom pb-2 mb-3"><i class="bi bi-info-circle me-2 text-brand"></i>Información del pedido</h6>
                        <div class="small">
                            <div class="d-flex justify-content-between py-1"><span class="text-muted">Fecha</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                            <div class="d-flex justify-content-between py-1"><span class="text-muted">Estado</span><span class="badge bg-success">{{ $order->getStatusLabel() }}</span></div>
                            <div class="d-flex justify-content-between py-1"><span class="text-muted">Pago</span><span>{{ ucfirst($order->payment_method) }}</span></div>
                        </div>
                        <hr>
                        <h6 class="fw-bold">Dirección de envío</h6>
                        <p class="small text-muted mb-0">{{ $order->shipping_address }}</p>
                        @if ($order->notes)
                            <hr>
                            <h6 class="fw-bold">Notas</h6>
                            <p class="small text-muted mb-0">{{ $order->notes }}</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('shop.index') }}" class="btn btn-brand w-100">
                    <i class="bi bi-bag me-2"></i>Ir a la tienda
                </a>
            </div>
        </div>
    </div>
@endsection