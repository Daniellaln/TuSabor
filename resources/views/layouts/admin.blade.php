@extends('layouts.app')

@section('content')
<div class="d-flex">
    <nav class="sidebar-admin" style="width: 250px;">
        <div class="px-3 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="logo-text text-decoration-none">TuSabor</a>
            <p class="small text-muted mb-0">Panel Admin</p>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}" href="{{ route('admin.categorias.index') }}">
                    <i class="fas fa-tags"></i> Categorías
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" href="{{ route('admin.productos.index') }}">
                    <i class="fas fa-utensils"></i> Productos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.mesas.*') ? 'active' : '' }}" href="{{ route('admin.mesas.index') }}">
                    <i class="fas fa-chair"></i> Mesas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}" href="{{ route('admin.pedidos.index') }}">
                    <i class="fas fa-shopping-bag"></i> Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reservas.*') ? 'active' : '' }}" href="{{ route('admin.reservas.index') }}">
                    <i class="fas fa-calendar-alt"></i> Reservas
                </a>
            </li>
            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    
    <main class="flex-grow-1 p-4" style="background: #FAFAFA;">
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
        
        @yield('admin-content')
    </main>
</div>
@endsection