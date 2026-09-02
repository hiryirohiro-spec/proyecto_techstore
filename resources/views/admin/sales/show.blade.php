@extends('layouts.admin')

@section('title', 'Venta ' . $sale->code)
@section('subtitle', 'Detalle de la venta')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h6 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-brand"></i>Artículos de la venta</h6>
                        <span class="badge {{ $sale->getStatusBadge() }} fs-6">{{ $sale->getStatusLabel() }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Cantidad</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($item->product)
                                                    <img src="{{ product_image($item->product) }}" class="img-thumb-sm" alt="">
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $item->product_name }}</div>
                                                    @if ($item->product)
                                                        <small class="text-muted">Ref: {{ $item->product->sku ?: '—' }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">{{ format_money($item->price) }}</td>
                                        <td class="text-end">{{ $item->quantity }}</td>
                                        <td class="text-end fw-semibold">{{ format_money($item->subtotal) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <div style="max-width: 320px; width: 100%">
                            <div class="d-flex justify-content-between py-1"><span class="text-muted">Subtotal</span><span>{{ format_money($sale->subtotal) }}</span></div>
                            <div class="d-flex justify-content-between py-1"><span class="text-muted">IVA (13%)</span><span>{{ format_money($sale->tax) }}</span></div>
                            <div class="d-flex justify-content-between py-1 border-top fw-bold fs-5 mt-1"><span>Total</span><span class="text-success">{{ format_money($sale->total) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-person me-2 text-brand"></i>Cliente</h6>
                    <p class="mb-1 fw-semibold">{{ $sale->user->name }}</p>
                    <p class="text-muted small mb-0">{{ $sale->user->email }}</p>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-brand"></i>Información</h6>
                    <div class="small">
                        <div class="d-flex justify-content-between py-1"><span class="text-muted">Código</span><span class="fw-semibold">{{ $sale->code }}</span></div>
                        <div class="d-flex justify-content-between py-1"><span class="text-muted">Fecha</span><span>{{ $sale->created_at->format('d/m/Y H:i') }}</span></div>
                        <div class="d-flex justify-content-between py-1"><span class="text-muted">Método de pago</span><span class="text-capitalize">{{ $sale->payment_method }}</span></div>
                    </div>
                    <hr>
                    <h6 class="fw-bold"><i class="bi bi-geo-alt me-2 text-brand"></i>Dirección de envío</h6>
                    <p class="small text-muted mb-3">{{ $sale->shipping_address }}</p>
                    @if ($sale->notes)
                        <h6 class="fw-bold"><i class="bi bi-journal-text me-2 text-brand"></i>Notas</h6>
                        <p class="small text-muted mb-0">{{ $sale->notes }}</p>
                    @endif
                </div>
            </div>
            @if ($sale->status === 'pending')
                <div class="d-grid gap-2 mb-3">
                    <form method="POST" action="{{ route('admin.sales.status', $sale) }}" onsubmit="return confirm('Confirmar la venta como completada?');">
                        @csrf
                        <input type="hidden" name="status" value="completed">
                        <button class="btn btn-success w-100"><i class="bi bi-check-lg me-2"></i>Marcar como completada</button>
                    </form>
                    <form method="POST" action="{{ route('admin.sales.status', $sale) }}" onsubmit="return confirm('Cancelar esta venta? El stock se repondrá.');">
                        @csrf
                        <input type="hidden" name="status" value="canceled">
                        <button class="btn btn-outline-danger w-100"><i class="bi bi-x-circle me-2"></i>Cancelar venta</button>
                    </form>
                </div>
            @elseif ($sale->status === 'completed')
                <form method="POST" action="{{ route('admin.sales.status', $sale) }}" class="mb-3" onsubmit="return confirm('Cancelar esta venta? Se repondrá el stock.');">
                    @csrf
                    <input type="hidden" name="status" value="canceled">
                    <button class="btn btn-outline-danger w-100"><i class="bi bi-x-circle me-2"></i>Cancelar venta (reembolso)</button>
                </form>
            @elseif ($sale->status === 'canceled')
                <form method="POST" action="{{ route('admin.sales.status', $sale) }}" class="mb-3" onsubmit="return confirm('Reactivar la venta como completada?');">
                    @csrf
                    <input type="hidden" name="status" value="completed">
                    <button class="btn btn-success w-100"><i class="bi bi-check-lg me-2"></i>Reactivar como completada</button>
                </form>
            @endif
            <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-2"></i>Volver a ventas
            </a>
        </div>
    </div>
@endsection