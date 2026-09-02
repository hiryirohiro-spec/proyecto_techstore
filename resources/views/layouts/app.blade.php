<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TechStore') | TechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #3b82f6;
            --brand-dark: #2563eb;
            --neon-cyan: #22d3ee;
            --neon-magenta: #e879f9;
            --neon-green: #4ade80;
            --bg-base: #0b0f19;
            --bg-surface: #101827;
            --bg-card: #131c2e;
            --border-dark: #1f2a3d;
            --text-light: #e2e8f0;
        }
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 1.02rem;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: var(--bg-base);
            color: var(--text-light);
            background-image:
                radial-gradient(900px 500px at 12% -10%, rgba(34,211,238,.14), transparent 60%),
                radial-gradient(800px 500px at 90% 0%, rgba(129,140,248,.16), transparent 55%),
                radial-gradient(900px 600px at 85% 110%, rgba(232,121,249,.10), transparent 60%),
                radial-gradient(700px 500px at 15% 95%, rgba(59,130,246,.12), transparent 55%);
            background-attachment: fixed;
        }
        h1, h2, h3, h4, h5, h6, .display-1, .display-5, .navbar-brand {
            font-family: 'Outfit', 'Segoe UI', sans-serif;
            letter-spacing: -0.02em;
        }
        ::selection {
            background: rgba(34,211,238,.35);
            color: #fff;
        }
        @keyframes neonShimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 300% 50%; }
        }
        @keyframes brandPulse {
            0%, 100% { filter: drop-shadow(0 0 8px rgba(34,211,238,.55)); }
            50% { filter: drop-shadow(0 0 18px rgba(232,121,249,.65)); }
        }
        .navbar.bg-white {
            background: rgba(11,15,25,.72) !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(148,163,184,.14);
            box-shadow: 0 10px 30px rgba(0,0,0,.35);
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(90deg, #67e8f9, #818cf8, #f0abfc, #67e8f9);
            background-size: 300% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: neonShimmer 8s linear infinite, brandPulse 3.5s ease-in-out infinite;
        }
        .navbar-brand .icon {
            color: var(--neon-cyan);
            text-shadow: 0 0 12px rgba(34,211,238,.9);
        }
        .navbar .nav-link {
            color: #cbd5e1;
        }
        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: #fff;
        }
        .navbar-toggler {
            border-color: rgba(148,163,184,.35);
        }
        .navbar-toggler-icon {
            filter: invert(1);
        }
        .btn-brand {
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            border: none;
            color: #fff;
            box-shadow: 0 0 14px rgba(6,182,212,.35);
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #1d4ed8, #22d3ee);
            color: #fff;
            box-shadow: 0 0 22px rgba(6,182,212,.55);
        }
        .brand-btn-outline {
            color: var(--neon-cyan);
            border: 1px solid rgba(34,211,238,.6);
        }
        .brand-btn-outline:hover {
            background: rgba(34,211,238,.12);
            color: #fff;
            border-color: var(--neon-cyan);
        }
        .text-brand { color: var(--neon-cyan) !important; }
        .bg-brand { background-color: var(--brand); }
        .bg-brand-light { background-color: rgba(59,130,246,.15); }
        .hero-section {
            background:
                radial-gradient(700px 420px at 82% -20%, rgba(34,211,238,.28), transparent 60%),
                radial-gradient(600px 380px at 5% 0%, rgba(129,140,248,.25), transparent 55%),
                linear-gradient(135deg, #0d1430 0%, #14204a 55%, #0b0f19 100%);
            color: #fff;
            border-bottom: 1px solid rgba(148,163,184,.12);
        }
        .hero-section h1 {
            font-weight: 800;
            background: linear-gradient(90deg, #22d3ee, #818cf8, #e879f9, #67e8f9, #22d3ee);
            background-size: 300% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: neonShimmer 6s linear infinite;
            filter: drop-shadow(0 0 16px rgba(34,211,238,.55));
        }
        .hero-section .badge {
            background: rgba(148,163,184,.15);
            border: 1px solid rgba(148,163,184,.3);
        }
        .card {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border-dark);
            color: var(--text-light);
        }
        .card a.text-dark {
            color: #f1f5f9 !important;
        }
        .card a.text-dark:hover {
            color: var(--neon-cyan);
        }
        .product-card {
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            border-color: rgba(34,211,238,.65);
            box-shadow: 0 0 24px rgba(34,211,238,.28), 0 12px 30px rgba(0,0,0,.45);
        }
        .product-card .card-img-top {
            height: 220px;
            object-fit: cover;
            background: #0b1424;
        }
        .product-card .card-title a {
            color: #f1f5f9;
        }
        .product-card .card-title a:hover {
            color: var(--neon-cyan);
        }
        .price {
            font-weight: 700;
            color: var(--neon-green);
            text-shadow: 0 0 10px rgba(74,222,128,.35);
        }
        .btn-icon-danger {
            background: transparent;
            border: none;
            color: #f87171;
        }
        .btn-icon-danger:hover { color: #ef4444; }
        .cart-qty {
            background: linear-gradient(135deg, #06b6d4, #6366f1);
            color: #fff;
            font-size: .7rem;
            padding: .15rem .45rem;
            border-radius: 10px;
            margin-left: .25rem;
            vertical-align: top;
            box-shadow: 0 0 8px rgba(6,182,212,.6);
        }
        .form-control, .form-select {
            background-color: var(--bg-surface);
            border-color: #29374f;
            color: var(--text-light);
        }
        .form-control::placeholder { color: #64748b; }
        .form-control:focus, .form-select:focus {
            background-color: var(--bg-surface);
            border-color: rgba(34,211,238,.7);
            color: var(--text-light);
            box-shadow: 0 0 0 .25rem rgba(34,211,238,.18);
        }
        .form-control:disabled, .form-control[readonly] { background-color: #0e1626; }
        .input-group-text {
            background-color: #0e1626;
            border-color: #29374f;
            color: #94a3b8;
        }
        .form-check-input {
            background-color: #0e1626;
            border-color: #475569;
        }
        .form-check-input:checked {
            background-color: var(--brand);
            border-color: var(--brand);
        }
        .form-check.border {
            background: #0f1722;
            border-color: #29374f !important;
        }
        .text-muted { color: #9fb0c8 !important; }
        .list-group-item {
            background-color: var(--bg-card);
            color: var(--text-light);
            border-color: var(--border-dark);
        }
        .list-group-item-action:hover {
            background-color: #182338;
            color: #fff;
        }
        .list-group-item.active {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #fff;
        }
        .dropdown-menu {
            background-color: var(--bg-card);
            border-color: var(--border-dark);
        }
        .dropdown-item { color: #cbd5e1; }
        .dropdown-item:hover {
            background-color: #182338;
            color: #fff;
        }
        .dropdown-divider { border-color: var(--border-dark); }
        .table {
            --bs-table-bg: var(--bg-card);
            --bs-table-color: var(--text-light);
            --bs-table-border-color: var(--border-dark);
            --bs-table-hover-bg: #182338;
            --bs-table-hover-color: #fff;
            --bs-table-striped-bg: #151f33;
        }
        .table.bg-white { background-color: var(--bg-card) !important; }
        .table-light {
            --bs-table-bg: #1c2a40;
            --bs-table-color: var(--text-light);
        }
        .table-light th, .table-light td {
            background-color: #1c2a40 !important;
            color: var(--text-light);
        }
        .footer {
            background: #080c14;
            color: #cbd5e1;
            border-top: 1px solid rgba(34,211,238,.25);
        }
        .footer a { color: #94a3b8; text-decoration: none; }
        .footer a:hover { color: #fff; }
        .img-preview {
            height: 280px;
            object-fit: cover;
            border-radius: 1rem;
            background: #0b1424;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-lightning-charge-fill icon me-1"></i>TechStore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <form class="d-flex my-2 my-lg-0 mx-lg-4 flex-grow-1" action="{{ route('shop.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Buscar productos..." value="{{ request('q') }}">
                        <button class="btn btn-brand" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.index') }}">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3"></i> Carrito
                            @if ($globalCartCount > 0)
                                <span class="cart-qty">{{ $globalCartCount }}</span>
                            @endif
                        </a>
                    </li>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Panel
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-bag-check me-2"></i>Mis pedidos</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Ingresar</a></li>
                        <li class="nav-item"><a class="btn btn-brand ms-lg-2" href="{{ route('register') }}">Crear cuenta</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if (session('success') || session('error'))
        <div class="container mt-3">
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

    <main>
        @yield('content')
    </main>

    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="text-white"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>TechStore</h5>
                    <p class="mt-2 mb-0">Tienda de electrónica con los mejores productos, precios y garantía de calidad en cada compra.</p>
                </div>
                <div class="col-lg-2">
                    <h6 class="text-white">Tienda</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('shop.index') }}">Todos los productos</a></li>
                        <li><a href="{{ route('shop.index', ['sort' => 'price_desc']) }}">Más vendidos</a></li>
                        <li><a href="{{ route('shop.index', ['sort' => 'price_asc']) }}">Ofertas</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white">Cuenta</h6>
                    <ul class="list-unstyled">
                        @auth
                            <li><a href="{{ route('orders.index') }}">Mis pedidos</a></li>
                            <li><a href="{{ route('cart.index') }}">Mi carrito</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                            <li><a href="{{ route('register') }}">Crear cuenta</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white">Contacto</h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope me-2"></i>ventas@techstore.com</li>
                        <li><i class="bi bi-telephone me-2"></i>+591 700 000 00</li>
                        <li><i class="bi bi-geo-alt me-2"></i>Santa Cruz de la Sierra, Bolivia</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <p class="text-center mb-0 small">&copy; {{ date('Y') }} TechStore. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>