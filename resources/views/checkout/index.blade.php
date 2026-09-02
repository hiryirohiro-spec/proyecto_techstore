@extends('layouts.app')

@section('title', 'Finalizar compra')

@section('content')
    <div class="container py-4">
        <h4 class="fw-bold mb-4"><i class="bi bi-credit-card me-2 text-brand"></i>Finalizar compra</h4>

        <div class="row g-4">
            <div class="col-lg-7">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="card border mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-person me-2 text-brand"></i>Datos del cliente</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Correo</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Dirección de envío <span class="text-danger">*</span></label>
                                    <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="2" required placeholder="Calle, número, barrio, ciudad">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notas del pedido</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Instrucciones adicionales (opcional)">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-brand"></i>Método de pago</h6>
                            <div class="row g-2">
                                @php $paymentMethods = ['tarjeta' => ['bi-credit-card-2-front', 'Tarjeta'], 'efectivo' => ['bi-cash', 'Efectivo'], 'transferencia' => ['bi-bank', 'Transferencia bancaria'], 'qr' => ['bi-qr-code-scan', 'QR / Pagomóvil']]; @endphp
                                @foreach ($paymentMethods as $method => [$icon, $label])
                                    <div class="col-md-6">
                                        <label class="form-check border rounded p-3 w-100">
                                            <input type="radio" name="payment_method" value="{{ $method }}" class="form-check-input" {{ old('payment_method', 'tarjeta') === $method ? 'checked' : '' }}>
                                            <i class="bi {{ $icon }} me-2 text-brand"></i>{{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('payment_method')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            <div class="alert alert-warning small mt-3 mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                Demostración: el pago no se procesa realmente. La venta queda registrada en el sistema.
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-brand btn-lg w-100">
                        <i class="bi bi-check2-circle me-2"></i>Confirmar compra ({{ format_money($total) }})
                    </button>
                </form>
            </div>

            <div class="col-lg-5">
                <div class="card border">
                    <div class="card-body">
                        <h6 class="fw-bold border-bottom pb-2">Tu pedido</h6>
                        @foreach ($items as $item)
                            <div class="d-flex gap-3 py-2 align-items-center border-bottom">
                                <img src="{{ product_image($item['product']) }}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: .4rem;">
                                <div class="flex-grow-1">
                                    <div class="small fw-semibold">{{ $item['product']->name }}</div>
                                    <div class="small text-muted">{{ $item['quantity'] }} × {{ format_money($item['product']->price) }}</div>
                                </div>
                                <div class="small fw-semibold">{{ format_money($item['product']->price * $item['quantity']) }}</div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Subtotal</span>
                            <span>{{ format_money($subtotal) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">IVA (13%)</span>
                            <span>{{ format_money($tax) }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2 fw-bold fs-5">
                            <span>Total</span>
                            <span>{{ format_money($total) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection