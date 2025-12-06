@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-tusabor">
    <div class="container">
        <a class="navbar-brand logo-text" href="{{ route('cliente.catalogo.index') }}">TuSabor</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.catalogo.index') }}">
                        <i class="fas fa-utensils me-1"></i> Menú
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.carrito.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i> Carrito
                        <span class="badge bg-danger" id="cart-count">0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.reservas.index') }}">
                        <i class="fas fa-calendar-check me-1"></i> Reservas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.pedidos.index') }}">
                        <i class="fas fa-box me-1"></i> Mis Pedidos
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i> {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-elegant">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-elegant">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif
        
        @yield('cliente-content')
    </div>
</main>

@include('components.chatbot')
@endsection
