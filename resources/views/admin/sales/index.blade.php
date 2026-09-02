@extends('layouts.admin')

@section('title', 'Ventas')
@section('subtitle', 'Historial completo de ventas')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-success-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold text-success">{{ $summary->total_sales }}</div>
                    <div class="small">Ventas</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-primary-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold text-primary">{{ format_money($summary->total_subtotal) }}</div>
                    <div class="small">Subtotal</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-warning-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold text-warning">{{ format_money($summary->total_tax) }}</div>
                    <div class="small">Impuestos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-success-subtle">
                <div class="card-body text-center">
                    <div class="fs-3 fw-bold text-success">{{ format_money($summary->total_revenue) }}</div>
                    <div class="small">Ingresos totales</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Buscar por código o cliente..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Todos los estados</option>
                        @foreach (['completed' => 'Completada', 'pending' => 'Pendiente', 'canceled' => 'Cancelada'] as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" title="Desde">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" title="Hasta">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1">Filtrar</button>
                    <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Pago</th>
                            <th>Artículos</th>
                            <th class="text-end">Total</th>
                            <th>Estado</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $sale)
                            <tr>
                                <td class="fw-semibold">{{ $sale->code }}</td>
                                <td>
                                    <div>{{ $sale->user->name }}</div>
                                    <small class="text-muted">{{ $sale->user->email }}</small>
                                </td>
                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td><span class="badge bg-light text-dark border">{{ ucfirst($sale->payment_method) }}</span></td>
                                <td>{{ $sale->items->sum('quantity') }}</td>
                                <td class="text-end fw-semibold text-success">{{ format_money($sale->total) }}</td>
                                <td>
                                    @if ($sale->status === 'completed')
                                        <span class="badge bg-success">Completada</span>
                                    @elseif ($sale->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @else
                                        <span class="badge bg-danger">Cancelada</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.sales.show', $sale) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">No hay ventas que coincidan con el filtro.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $sales->links() }}
        </div>
    </div>
@endsection