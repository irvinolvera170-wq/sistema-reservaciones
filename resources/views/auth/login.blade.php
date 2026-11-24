@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-sm w-100" style="max-width: 400px;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Iniciar sesión</h3>

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
</div>
@endsection