@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <section class="hero-section py-5">
        <div class="container py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="badge mb-3"><i class="bi bi-lightning-charge"></i> Envíos a todo el país</span>
                    <h1 class="display-5 fw-bold mb-3">La mejor electrónica al mejor precio</h1>
                    <p class="lead mb-4 opacity-75">
                        Computadores, celulares, audífonos, accesorios y más. Calidad garantizada en cada compra.
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg fw-semibold">
                        <i class="bi bi-cart3 me-2"></i>Ver catálogo
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-end">
                    <i class="bi bi-headphones display-1 me-3 opacity-75"></i>
                    <i class="bi bi-laptop display-1 me-3 opacity-75"></i>
                    <i class="bi bi-phone display-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

    @if ($categories->isNotEmpty())
        <section class="container mt-4">
            <div class="row g-2 align-items-stretch">
                @foreach ($categories->take(4) as $category)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                           class="card text-center text-decoration-none h-100 border">
                            <div class="card-body py-3">
                                <i class="bi bi-box-seam text-brand fs-4"></i>
                                <div class="fw-semibold small mt-1">{{ $category->name }}</div>
                                <div class="text-muted small">{{ $category->products_count }} productos</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if ($featured->isNotEmpty())
        <section class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-star-fill text-warning me-2"></i>Productos destacados</h4>
                <a href="{{ route('shop.index') }}" class="btn btn-sm brand-btn-outline">Ver todos</a>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3">
                @foreach ($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    @if ($newArrivals->isNotEmpty())
        <section class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-patch-check-fill text-success me-2"></i>Nuevos ingresos</h4>
                <a href="{{ route('shop.index', ['sort' => 'latest']) }}" class="btn btn-sm brand-btn-outline">Ver todos</a>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3">
                @foreach ($newArrivals as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    <section class="container mt-5">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border h-100">
                    <div class="card-body">
                        <i class="bi bi-truck fs-3 text-brand"></i>
                        <h6 class="fw-bold mt-2 mb-1">Envío rápido</h6>
                        <p class="text-muted small mb-0">Recibe tu pedido en 24-48 horas en las principales ciudades.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border h-100">
                    <div class="card-body">
                        <i class="bi bi-arrow-repeat fs-3 text-brand"></i>
                        <h6 class="fw-bold mt-2 mb-1">Devolución fácil</h6>
                        <p class="text-muted small mb-0">Garantía de 30 días en todos nuestros productos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border h-100">
                    <div class="card-body">
                        <i class="bi bi-shield-check fs-3 text-brand"></i>
                        <h6 class="fw-bold mt-2 mb-1">Compra segura</h6>
                        <p class="text-muted small mb-0">Paga con tarjeta, QR, transferencia bancaria o efectivo con total seguridad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection