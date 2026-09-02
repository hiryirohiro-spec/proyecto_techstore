@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Resumen general de la tienda')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 shadow-sm bg-white">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Ingresos totales</div>
                            <div class="fs-4 fw-bold text-success">{{ format_money($totalRevenue) }}</div>
                        </div>
                        <i class="bi bi-cash-stack fs-2 text-success-subtle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Ventas completadas</div>
                            <div class="fs-4 fw-bold">{{ $totalSales }}</div>
                        </div>
                        <i class="bi bi-receipt fs-2 text-info-subtle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Clientes</div>
                            <div class="fs-4 fw-bold">{{ $totalCustomers }}</div>
                        </div>
                        <i class="bi bi-people fs-2 text-primary-subtle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Productos</div>
                            <div class="fs-4 fw-bold">{{ $totalProducts }}</div>
                        </div>
                        <i class="bi bi-box-seam fs-2 text-warning-subtle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-2">
            <div class="card border-0 shadow-sm bg-success-subtle">
                <div class="card-body py-3 text-center">
                    <div class="fs-3 fw-bold text-success">{{ $available }}</div>
                    <div class="small">Disponibles</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card border-0 shadow-sm bg-danger-subtle">
                <div class="card-body py-3 text-center">
                    <div class="fs-3 fw-bold text-danger">{{ $outOfStock }}</div>
                    <div class="small">Agotados</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card border-0 shadow-sm bg-dark-subtle">
                <div class="card-body py-3 text-center">
                    <div class="fs-3 fw-bold">{{ $defective }}</div>
                    <div class="small">Defectuosos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card border-0 shadow-sm bg-primary-subtle">
                <div class="card-body py-3 text-center">
                    <div class="fs-3 fw-bold text-primary">{{ $newProducts }}</div>
                    <div class="small">Nuevos (7d)</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card border-0 shadow-sm bg-warning-subtle">
                <div class="card-body py-3 text-center">
                    <div class="fs-3 fw-bold text-warning">{{ $lowStock }}</div>
                    <div class="small">Stock bajo</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card border-0 shadow-sm bg-info-subtle">
                <div class="card-body py-3 text-center">
                    <div class="fs-3 fw-bold text-info">{{ $totalSales }}</div>
                    <div class="small">Ventas</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold border-0 py-3">
                    <i class="bi bi-activity me-2 text-brand"></i>Ventas mensuales
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mes</th>
                                    <th class="text-end">Ventas</th>
                                    <th class="text-end">Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salesByMonth as $m)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $m->month)->translatedFormat('F Y') }}</td>
                                        <td class="text-end">{{ $m->total_sales }}</td>
                                        <td class="text-end fw-semibold text-success">{{ format_money($m->revenue) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-3">Aún no hay ventas registradas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white fw-bold border-0 py-3">
                    <i class="bi bi-trophy me-2 text-brand"></i>Productos más vendidos
                </div>
                <div class="card-body">
                    @if ($topProducts->isEmpty())
                        <p class="text-muted text-center py-3 mb-0">Sin datos de ventas todavía.</p>
                    @else
                        @foreach ($topProducts as $index => $tp)
                            <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <span class="badge bg-light text-dark border rounded-circle" style="width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;">{{ $index + 1 }}</span>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small">{{ $tp->product_name }}</div>
                                    <div class="small text-muted">{{ $tp->total_qty }} unidades vendidas</div>
                                </div>
                                <span class="fw-semibold text-success">{{ format_money($tp->total_revenue) }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold border-0 py-3 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history me-2 text-brand"></i>Ventas recientes</span>
                    <a href="{{ route('admin.sales.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse ($recentSales as $sale)
                            <a href="{{ route('admin.sales.show', $sale) }}" class="list-group-item list-group-item-action d-flex gap-3 align-items-center">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small">{{ $sale->code }}</div>
                                    <div class="small text-muted">{{ $sale->user->name }} · {{ $sale->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <span class="fw-semibold text-success small">{{ format_money($sale->total) }}</span>
                            </a>
                        @empty
                            <div class="text-center text-muted py-4">Sin ventas recientes.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white fw-bold border-0 py-3 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Stock bajo</span>
                    <a href="{{ route('admin.products.index', ['status' => 'low_stock']) }}" class="btn btn-sm btn-outline-warning">Ver todos</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse ($lowStockProducts as $product)
                            <div class="list-group-item d-flex gap-3 align-items-center">
                                <img src="{{ product_image($product) }}" class="img-thumb-sm" alt="">
                                <div class="flex-grow-1">
                                    <div class="small fw-semibold">{{ $product->name }}</div>
                                    <div class="small text-muted">{{ $product->category?->name }}</div>
                                </div>
                                <span class="badge bg-warning text-dark">Quedan {{ $product->stock }}</span>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">Todo el stock está bien.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection