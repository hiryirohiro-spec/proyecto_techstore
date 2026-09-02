@extends('layouts.auth')

@section('title', 'Iniciar sesión')
@section('subtitle', 'Accede a tu cuenta para comprar y ver tus pedidos')

@section('auth-content')
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope form-icon"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="tucorreo@ejemplo.com">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock form-icon"></i></span>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small" for="remember">Recordarme</label>
        </div>
        <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
        </button>
    </form>
    <div class="mt-3 p-3 rounded" style="background: #0e1626; border: 1px dashed #334155;">
        <p class="small text-muted mb-2 text-center">Cuentas del sistema (clic para autocompletar)</p>
        @foreach ($users as $user)
            <button type="button" class="btn btn-sm btn-outline-secondary w-100 text-start mb-2 demo-account" style="border-color: #334155; color: #e2e8f0;"
                    data-email="{{ $user->email }}" data-password="{{ $demoCredentials[$user->email] ?? '' }}">
                <span class="fw-semibold">
                    <i class="bi bi-person-circle me-1"></i>{{ $user->name }}
                    @if ($user->is_admin)
                        <span class="badge bg-warning text-dark ms-1">Admin</span>
                    @endif
                </span>
                <span class="d-block small text-muted">{{ $user->email }}{{ isset($demoCredentials[$user->email]) ? ' · ' . $demoCredentials[$user->email] : '' }}</span>
            </button>
        @endforeach
    </div>
    <p class="text-center text-muted small mt-4 mb-0">
        ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-brand fw-semibold text-decoration-none">Regístrate gratis</a>
    </p>
    <script>
        document.querySelectorAll('.demo-account').forEach(btn => {
            btn.addEventListener('click', () => {
                const email = document.querySelector('input[name="email"]');
                if (email) email.value = btn.dataset.email;
                const pass = document.querySelector('input[name="password"]');
                if (pass) pass.value = btn.dataset.password || '';
            });
        });
    </script>
@endsection