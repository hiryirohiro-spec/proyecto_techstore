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
    <p class="text-center text-muted small mt-4 mb-0">
        ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-brand fw-semibold text-decoration-none">Regístrate gratis</a>
    </p>
@endsection