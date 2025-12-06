@extends('layouts.app')

@section('title', 'Registrarse - TuSabor')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #FAF8F3 0%, #F5F5DC 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-elegant border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="logo-text mb-2">TuSabor</h1>
                            <p class="text-muted">Crear Cuenta</p>
                        </div>
                        
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label-elegant">Nombre Completo</label>
                                <input type="text" name="name" class="form-control form-control-elegant @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label-elegant">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control form-control-elegant @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required>
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
                                <label class="form-label-elegant">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-elegant" required>
                            </div>
                            
                            <button type="submit" class="btn btn-borgona w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Registrarse
                            </button>
                            
                            <div class="text-center">
                                <p class="mb-0">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-borgona">Inicia sesión</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
