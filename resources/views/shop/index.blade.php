@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-grid me-2 text-brand"></i>Catálogo de productos</h4>
                <span class="text-muted">{{ $products->total() }} productos encontrados</span>
            </div>
            <form method="GET" class="d-flex gap-2" action="{{ route('shop.index') }}">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') === 'latest' || !request('sort') ? 'selected' : '' }}>Más recientes</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Menor precio</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Mayor precio</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nombre A-Z</option>
                </select>
            </form>
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-diagram-3 me-2 text-brand"></i>Categorías</h6>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('shop.index', array_merge(request()->except(['category']), ['category' => null])) }}"
                               class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                                Todas
                                <span class="badge rounded-pill {{ !request('category') ? 'bg-light text-dark' : 'bg-secondary' }}">{{ $categories->sum(fn ($c) => $c->products_count ?? 0) > 0 ? '' : '' }}</span>
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                                   class="list-group-item list-group-item-action {{ request('category') === $category->slug ? 'active' : '' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                @if ($products->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                        <h5 class="mt-3">No se encontraron productos</h5>
                        <a href="{{ route('shop.index') }}" class="btn btn-brand mt-2">Limpiar filtros</a>
                    </div>
                @else
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection