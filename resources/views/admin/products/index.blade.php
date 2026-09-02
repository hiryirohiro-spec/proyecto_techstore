@extends('layouts.admin')

@section('title', 'Productos')
@section('subtitle', 'Gestiona el catálogo de productos')

@section('content')
    <div class="row g-2 mb-3">
        @foreach ([
            'all' => ['Todos', $counts['all'], 'bg-white text-dark border'],
            'new' => ['Nuevos', $counts['new'], 'bg-primary-subtle text-primary'],
            'available' => ['Disponibles', $counts['available'], 'bg-success-subtle text-success'],
            'out_of_stock' => ['Agotados', $counts['out_of_stock'], 'bg-danger-subtle text-danger'],
            'defective' => ['Defectuosos', $counts['defective'], 'bg-dark-subtle text-dark'],
            'low_stock' => ['Stock bajo', $counts['low_stock'], 'bg-warning-subtle text-warning'],
        ] as $key => [$label, $value, $cls])
            <div class="col-6 col-md-2">
                <a href="{{ route('admin.products.index', ['status' => $key]) }}"
                   class="card text-decoration-none stat-card {{ $cls }} {{ request('status') === $key ? 'border border-primary border-2' : '' }}">
                    <div class="card-body py-2 px-3 text-center">
                        <div class="fs-5 fw-bold">{{ $value }}</div>
                        <div class="small">{{ $label }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3" action="{{ route('admin.products.index') }}">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Buscar por nombre o referencia..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filtrar</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th class="text-end">Precio</th>
                            <th class="text-end">Costo</th>
                            <th class="text-end">Stock</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td><img src="{{ product_image($product) }}" class="img-thumb-sm" alt=""></td>
                                <td>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <small class="text-muted">Ref: {{ $product->sku ?: '—' }}</small>
                                </td>
                                <td>{{ $product->category?->name ?: '—' }}</td>
                                <td class="text-end">{{ format_money($product->price) }}</td>
                                <td class="text-end text-muted">{{ format_money($product->cost) }}</td>
                                <td class="text-end">
                                    @if ($product->stock === 0)
                                        <span class="badge bg-danger">0</span>
                                    @elseif ($product->stock <= 10)
                                        <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->status === 'available' && $product->stock > 0)
                                        <span class="badge bg-success">Disponible</span>
                                    @elseif ($product->status === 'out_of_stock' || $product->stock === 0)
                                        <span class="badge bg-danger">Agotado</span>
                                    @elseif ($product->status === 'defective')
                                        <span class="badge bg-dark">Defectuoso</span>
                                    @endif
                                    @if ($product->isNew())
                                        <span class="badge bg-primary ms-1">Nuevo</span>
                                    @endif
                                    @if ($product->is_featured)
                                        <span class="badge bg-info ms-1">Destacado</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="bi bi-tag"></i> Estado
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.products.status', [$product, 'available']) }}">Disponible</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.products.status', [$product, 'out_of_stock']) }}">Agotado</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.products.status', [$product, 'defective']) }}">Defectuoso</a></li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Editar"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">No hay productos que coincidan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $products->links() }}
        </div>
    </div>
@endsection