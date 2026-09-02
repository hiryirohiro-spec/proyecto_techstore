@extends('layouts.auth')

@section('title', 'Crear cuenta')
@section('subtitle', 'Regístrate y empieza a comprar en TechStore')

@section('auth-content')
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person form-icon"></i></span>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Nombre y apellido">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope form-icon"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="tucorreo@ejemplo.com">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock form-icon"></i></span>
                <input type="password" name="password" class="form-control" required placeholder="Mínimo 8 caracteres">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill form-icon"></i></span>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Repite la contraseña">
            </div>
        </div>
        <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold">
            <i class="bi bi-person-plus me-2"></i>Crear cuenta
        </button>
    </form>
    <p class="text-center text-muted small mt-4 mb-0">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-brand fw-semibold text-decoration-none">Inicia sesión</a>
    </p>
@endsection