@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none">Tienda</a></li>
                @if ($product->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="text-decoration-none">
                            {{ $product->category->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <div class="col-lg-6">
                <img src="{{ product_image($product) }}" class="img-preview w-100" alt="{{ $product->name }}">
            </div>
            <div class="col-lg-6">
                @if ($product->category)
                    <span class="text-muted text-uppercase small">{{ $product->category->name }}</span>
                @endif
                <h1 class="fw-bold mb-2">{{ $product->name }}</h1>
                <div class="d-flex gap-2 mb-3 flex-wrap">
                    @if ($product->isNew())
                        <span class="badge bg-success">Nuevo</span>
                    @endif
                    @if ($product->isAvailable())
                        <span class="badge bg-success-subtle text-success border">✔ En stock ({{ $product->stock }} disponibles)</span>
                    @elseif ($product->stock === 0)
                        <span class="badge bg-danger">Agotado</span>
                    @elseif ($product->status === 'defective')
                        <span class="badge bg-dark">No disponible</span>
                    @endif
                    @if ($product->sku)
                        <span class="badge bg-light text-dark border">Ref: {{ $product->sku }}</span>
                    @endif
                </div>
                <p class="price fs-3 mb-3">{{ format_money($product->price) }}</p>

                @if ($product->description)
                    <div class="mb-4">
                        <h6 class="fw-bold">Descripción</h6>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>
                @endif

                @if ($product->isAvailable())
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-2 align-items-center mb-3">
                        @csrf
                        <div class="input-group" style="max-width: 140px">
                            <button type="button" class="btn btn-outline-secondary" onclick="qtyMinus()">-</button>
                            <input type="number" name="quantity" id="qty" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}">
                            <button type="button" class="btn btn-outline-secondary" onclick="qtyPlus()">+</button>
                        </div>
                        <button class="btn btn-brand btn-lg flex-grow-1">
                            <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-lg disabled">Producto no disponible</button>
                @endif

                <div class="card border mt-3">
                    <div class="card-body small text-muted d-flex flex-column gap-2">
                        <span><i class="bi bi-truck me-2 text-brand"></i>Despacho en 24 horas hábiles</span>
                        <span><i class="bi bi-arrow-repeat me-2 text-brand"></i>Devoluciones dentro de 30 días</span>
                        <span><i class="bi bi-shield-lock me-2 text-brand"></i>Compra protegida de extremo a extremo</span>
                    </div>
                </div>
            </div>
        </div>

        @if ($related->isNotEmpty())
            <section class="mt-5">
                <h4 class="fw-bold mb-3">Productos relacionados</h4>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3">
                    @foreach ($related as $productRel)
                        <x-product-card :product="$productRel" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function qtyMinus() {
        const el = document.getElementById('qty');
        el.value = Math.max(1, parseInt(el.value || 1, 10) - 1);
    }
    function qtyPlus() {
        const el = document.getElementById('qty');
        el.value = Math.min({{ $product->stock }}, parseInt(el.value || 1, 10) + 1);
    }
</script>
@endpush