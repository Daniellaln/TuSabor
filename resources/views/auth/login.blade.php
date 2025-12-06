@extends('layouts.app')

@section('title', 'Iniciar Sesión - TuSabor')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #FAF8F3 0%, #F5F5DC 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-elegant border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="logo-text mb-2">TuSabor</h1>
                            <p class="text-muted">Iniciar Sesión</p>
                        </div>
                        
                        @if(session('status'))
                            <div class="alert alert-success mb-3">{{ session('status') }}</div>
                        @endif
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label-elegant">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control form-control-elegant @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label-elegant">Contraseña</label>
                                <input type="password" name="password" class="form-control form-control-elegant @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                    <label class="form-check-label" for="remember">Recordarme</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-borgona w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>
                            
                            <div class="text-center">
                                <p class="mb-0">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-borgona">Regístrate</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
