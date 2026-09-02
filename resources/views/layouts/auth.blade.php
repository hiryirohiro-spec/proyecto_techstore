<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TechStore')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0b0f19;
            background-image:
                radial-gradient(800px 500px at 15% 0%, rgba(34,211,238,.16), transparent 60%),
                radial-gradient(800px 500px at 90% 100%, rgba(232,121,249,.14), transparent 60%),
                radial-gradient(700px 450px at 85% 0%, rgba(129,140,248,.18), transparent 55%);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            color: #f1f5f9;
        }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', 'Segoe UI', sans-serif; }
        .auth-card {
            max-width: 440px;
            width: 100%;
            background: #131c2e;
            border: 1px solid rgba(34,211,238,.35);
            border-radius: 1.25rem;
            box-shadow: 0 0 40px rgba(34,211,238,.18), 0 20px 45px rgba(0,0,0,.5);
        }
        .auth-card h3 {
            font-weight: 800;
            background: linear-gradient(90deg, #67e8f9, #818cf8, #f0abfc, #67e8f9);
            background-size: 300% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: neonShimmer 8s linear infinite;
            filter: drop-shadow(0 0 12px rgba(34,211,238,.45));
        }
        .btn-brand {
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            border: none;
            color: #fff;
            box-shadow: 0 0 14px rgba(6,182,212,.35);
        }
        .btn-brand:hover { background: linear-gradient(135deg, #1d4ed8, #22d3ee); color: #fff; }
        .text-brand { color: #22d3ee; }
        .text-muted { color: #9fb0c8 !important; }
        .form-icon { color: #a5b4c8; }
        .form-label {
            color: #f1f5f9;
            font-weight: 600;
        }
        .form-check-label {
            color: #dbe4f0;
        }
        .form-control {
            background-color: #101827;
            border-color: #334155;
            color: #fff;
            font-weight: 500;
        }
        .form-control::placeholder { color: #8fa3bd; }
        .form-control:focus {
            background-color: #101827;
            border-color: rgba(34,211,238,.7);
            color: #fff;
            box-shadow: 0 0 0 .25rem rgba(34,211,238,.18);
        }
        .input-group-text {
            background-color: #0e1626;
            border-color: #29374f;
            color: #94a3b8;
        }
        @keyframes neonShimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 300% 50%; }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card auth-card shadow-lg">
            <div class="card-body p-4 p-md-5">
                <h3 class="text-center mb-1">
                    <i class="bi bi-lightning-charge-fill text-brand"></i> TechStore
                </h3>
                <p class="text-center text-muted mb-4">@yield('subtitle', 'Acceso de usuarios')</p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('auth-content')
            </div>
        </div>
        <p class="text-center mt-3 mb-0">
            <a href="{{ route('home') }}" class="text-white text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i> Volver a la tienda
            </a>
        </p>
    </div>
</body>
</html>