@props(['product'])

<div class="col">
    <div class="card product-card h-100 overflow-hidden">
        <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none">
            <img src="{{ product_image($product) }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy">
        </a>
        <div class="card-body d-flex flex-column">
            @if ($product->category)
                <span class="text-muted small text-uppercase mb-1">{{ $product->category->name }}</span>
            @endif
            <h6 class="card-title mb-1">
                <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none text-dark">
                    {{ $product->name }}
                </a>
            </h6>
            <div class="d-flex align-items-center mb-2">
                @if ($product->isNew())
                    <span class="badge bg-success me-1">Nuevo</span>
                @endif
                @if ($product->stock <= 5 && $product->stock > 0)
                    <span class="badge bg-warning text-dark">¡Pocas unidades!</span>
                @endif
            </div>
            <div class="mt-auto d-flex justify-content-between align-items-center">
                <span class="price fs-5">{{ format_money($product->price) }}</span>
                @if ($product->isAvailable())
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-brand" title="Agregar al carrito">
                            <i class="bi bi-cart-plus"></i>
                        </button>
                    </form>
                @else
                    <span class="badge bg-danger">Agotado</span>
                @endif
            </div>
        </div>
    </div>
</div>