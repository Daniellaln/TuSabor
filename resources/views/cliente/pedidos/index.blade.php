@extends('layouts.cliente')
@section('cliente-content')
<div class="mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-box me-2"></i>Mis Pedidos</h1>
</div>

<div class="row g-4">
    @forelse($pedidos as $pedido)
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="card-title text-borgona">Pedido #{{ $pedido->id }}</h5>
                    <span class="badge bg-{{ $pedido->estado == 'entregado' ? 'success' : 'warning' }}">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </div>
                
                <p class="mb-2"><i class="fas fa-calendar me-2 text-borgona"></i>{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-2"><i class="fas fa-map-marker-alt me-2 text-borgona"></i>{{ $pedido->direccion_entrega }}</p>
                <p class="mb-3"><strong class="text-borgona">Total: S/ {{ number_format($pedido->total, 2) }}</strong></p>
                
                <a href="{{ route('cliente.pedidos.show', $pedido) }}" class="btn btn-outline-borgona btn-sm">
                    <i class="fas fa-eye me-2"></i>Ver Detalles
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>No tienes pedidos aún. ¡Haz tu primer pedido!
        </div>
    </div>
    @endforelse
</div>
@endsection
