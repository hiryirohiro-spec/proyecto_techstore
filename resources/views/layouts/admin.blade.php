<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') | Admin TechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-w: 250px; }
        body { background: #f1f5f9; font-family: 'Segoe UI', system-ui, sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: var(--sidebar-w);
            background: #0f172a;
            color: #cbd5e1;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            z-index: 100;
        }
        .sidebar .brand {
            padding: 1.2rem 1.25rem;
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar .brand i { color: #3b82f6; }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .7rem 1.25rem;
            font-size: .95rem;
            transition: background .1s;
        }
        .sidebar a:hover { background: rgba(255,255,255,.06); color: #fff; }
        .sidebar a.active { background: #2563eb; color: #fff; }
        .sidebar .section-label {
            padding: 1rem 1.25rem .35rem;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
        }
        .main-content { margin-left: var(--sidebar-w); width: calc(100% - var(--sidebar-w)); }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .9rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-brand { background: #2563eb; border: none; color: #fff; }
        .btn-brand:hover { background: #1d4ed8; color: #fff; }
        .stat-card { border: none; border-radius: 1rem; transition: transform .1s ease; }
        .stat-card:hover { transform: translateY(-2px); }
        .table > :not(caption) > * > * { background: #fff; }
        .img-thumb-sm { width: 56px; height: 56px; object-fit: cover; border-radius: .5rem; }
        @media (max-width: 991px) {
            .sidebar { position: static; width: 100%; }
            .main-content { margin-left: 0; width: 100%; }
            .admin-layout { flex-direction: column; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="brand">
                <i class="bi bi-lightning-charge-fill me-1"></i> TechStore <span class="badge bg-primary ms-1">Admin</span>
            </div>
            <nav>
                <div class="section-label">General</div>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <div class="section-label">Catálogo</div>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.create','admin.products.edit') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Productos
                </a>
                <a href="{{ route('admin.products.create') }}" class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i> Nuevo producto
                </a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i> Categorías
                </a>
                <div class="section-label">Operaciones</div>
                <a href="{{ route('admin.inventory.index') }}" class="{{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i> Inventario
                </a>
                <a href="{{ route('admin.sales.index') }}" class="{{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                    <i class="bi bi-currency-dollar"></i> Ventas
                </a>
                <div class="section-label">Otros</div>
                <a href="{{ route('home') }}">
                    <i class="bi bi-shop"></i> Ver tienda
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                    </a>
                </form>
            </nav>
        </aside>

        <div class="main-content">
            <div class="topbar">
                <div>
                    <h5 class="mb-0 fw-semibold">@yield('title', 'Panel de administración')</h5>
                    <small class="text-muted">@yield('subtitle', 'Bienvenido al panel de administración')</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-brand btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Nuevo producto
                    </a>
                    <div class="text-end ms-3">
                        <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                        <div class="text-muted small">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            @if (session('success') || session('error'))
                <div class="px-4 pt-3">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
            @endif

            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>