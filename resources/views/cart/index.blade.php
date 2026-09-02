@extends('layouts.app')

@section('title', 'Carrito')

@section('content')
    <div class="container py-4">
        <h4 class="fw-bold mb-4"><i class="bi bi-cart3 me-2 text-brand"></i>Mi carrito</h4>

        @if (empty($cart))
            <div class="text-center py-5">
                <i class="bi bi-cart-x display-4 text-muted"></i>
                <h5 class="mt-3">Tu carrito está vacío</h5>
                <p class="text-muted">Explora nuestro catálogo y encuentra lo que buscas.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-brand mt-2"><i class="bi bi-bag me-2"></i>Ir a la tienda</a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    @foreach ($cart as $productId => $quantity)
                        @php $product = \App\Models\Product::find($productId); @endphp
                        @if ($product)
                            <div class="card border mb-3">
                                <div class="card-body d-flex gap-3 align-items-center">
                                    <a href="{{ route('shop.show', $product->slug) }}">
                                        <img src="{{ product_image($product) }}" alt="{{ $product->name }}" style="width: 90px; height: 90px; object-fit: cover; border-radius: .5rem;">
                                    </a>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                                        </h6>
                                        <span class="price">{{ format_money($product->price) }}</span>
                                        <div class="small text-muted">
                                            @if ($product->stock > 0)
                                                Stock disponible: {{ $product->stock }}
                                            @else
                                                <span class="text-danger">Sin stock</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-end gap-2">
                                        <form action="{{ route('cart.update', $product) }}" method="POST" class="d-flex align-items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $quantity }}" min="1" max="{{ max($product->stock, $quantity) }}" class="form-control form-control-sm" style="width: 70px" onchange="this.form.submit()">
                                        </form>
                                        <span class="small text-muted">Subtotal: {{ format_money($product->price * $quantity) }}</span>
                                        <form action="{{ route('cart.remove', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-link text-danger text-decoration-none p-0">
                                                <i class="bi bi-trash me-1"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <a href="{{ route('shop.index') }}" class="btn btn-link text-brand text-decoration-none p-0">
                        <i class="bi bi-arrow-left me-1"></i>Seguir comprando
                    </a>
                </div>
                <div class="col-lg-4">
                    <div class="card border sticky-top" style="top: 90px">
                        <div class="card-body">
                            <h6 class="fw-bold border-bottom pb-2">Resumen del pedido</h6>
                            <div class="d-flex justify-content-between py-2">
                                <span>Productos ({{ $count }})</span>
                                <span>{{ format_money($subtotal) }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 fw-bold fs-5">
                                <span>Total</span>
                                <span>{{ format_money($subtotal) }}</span>
                            </div>
                            <a href="{{ auth()->check() ? route('checkout.index') : route('login') }}" class="btn btn-brand w-100 mt-3">
                                <i class="bi bi-credit-card me-2"></i>{{ auth()->check() ? 'Tramitar pedido' : 'Inicia sesión para comprar' }}
                            </a>
                            <form action="{{ route('cart.clear') }}" method="POST" class="mt-2 text-center">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-link text-muted text-decoration-none">
                                    Vaciar carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection