@extends('layouts.admin')

@section('title', 'Inventario')
@section('subtitle', 'Control de stock, productos nuevos, agotados y defectuosos')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-success-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold text-success">{{ $stats['available'] }}</div>
                    <div class="small">Disponibles en venta</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-danger-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold text-danger">{{ $stats['out_of_stock'] }}</div>
                    <div class="small">Productos agotados</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-dark-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold">{{ $stats['defective'] }}</div>
                    <div class="small">Productos defectuosos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-primary-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold text-primary">{{ $stats['new'] }}</div>
                    <div class="small">Nuevos (últimos 7 días)</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-warning-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold text-warning">{{ $stats['low_stock'] }}</div>
                    <div class="small">Stock bajo (≤ 10)</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold">{{ $stats['total'] }}</div>
                    <div class="small">Total de productos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold">{{ format_money($stats['stock_value']) }}</div>
                    <div class="small">Valor del inventario (costo)</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold">{{ format_money($stats['stock_retail']) }}</div>
                    <div class="small">Valor del inventario (venta)</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-diagram-3 me-2 text-brand"></i>Stock por categoría
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Categoría</th>
                                    <th class="text-end">Productos</th>
                                    <th class="text-end">Unidades</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($byCategory as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td class="text-end">{{ $category->products_count }}</td>
                                        <td class="text-end">{{ $category->products_sum_stock }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Sin categorías.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-box-seam me-2 text-brand"></i>Estado del inventario</span>
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-secondary filter-btn active" data-filter="all">Todos</button>
                        <button class="btn btn-outline-success filter-btn" data-filter="available">Disponibles</button>
                        <button class="btn btn-outline-danger filter-btn" data-filter="out_of_stock">Agotados</button>
                        <button class="btn btn-outline-dark filter-btn" data-filter="defective">Defectuosos</button>
                        <button class="btn btn-outline-warning filter-btn" data-filter="low">Stock bajo</button>
                        <button class="btn btn-outline-primary filter-btn" data-filter="new">Nuevos</button>
                    </div>
                </div>
                <div class="card-body" style="max-height: 520px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="inventoryTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Stock</th>
                                    <th>Estado</th>
                                    <th>Ingresado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr data-state="{{ $product->status === 'defective' ? 'defective' : ($product->status === 'out_of_stock' || $product->stock === 0 ? 'out_of_stock' : ($product->stock <= 10 ? 'low' : 'available')) }}"
                                        data-new="{{ $product->isNew() ? '1' : '0' }}">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ product_image($product) }}" class="img-thumb-sm" alt="">
                                                <div>
                                                    <div class="fw-semibold">{{ $product->name }}</div>
                                                    <small class="text-muted">Ref: {{ $product->sku ?: '—' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->category?->name ?: '—' }}</td>
                                        <td class="text-end">{{ format_money($product->price) }}</td>
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
                                            @if ($product->status === 'defective')
                                                <span class="badge bg-dark">Defectuoso</span>
                                            @elseif ($product->status === 'out_of_stock' || $product->stock === 0)
                                                <span class="badge bg-danger">Agotado</span>
                                            @elseif ($product->stock <= 10)
                                                <span class="badge bg-warning text-dark">Stock bajo</span>
                                            @else
                                                <span class="badge bg-success">Disponible</span>
                                            @endif
                                            @if ($product->isNew())
                                                <span class="badge bg-primary ms-1">Nuevo</span>
                                            @endif
                                        </td>
                                        <td class="small text-muted">{{ $product->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('#inventoryTable tbody tr').forEach(row => {
                let show = filter === 'all';
                if (filter === 'new') show = row.dataset.new === '1';
                else if (filter === 'low') show = row.dataset.state === 'low';
                else show = row.dataset.state === filter;
                row.style.display = show ? '' : 'none';
            });
        });
    });
</script>
@endpush