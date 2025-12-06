@extends('layouts.cliente')

@section('title', 'Detalle del Pedido - TuSabor')

@section('cliente-content')
<div class="mb-4">
    <a href="{{ route('cliente.pedidos.index') }}" class="btn btn-outline-borgona btn-sm mb-3">
        <i class="fas fa-arrow-left me-2"></i>Volver a Mis Pedidos
    </a>
    
    <h1 class="h2 text-borgona"><i class="fas fa-receipt me-2"></i>Detalle del Pedido #{{ $pedido->id }}</h1>
    <p class="text-muted">Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-borgona text-white">
                <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Productos del Pedido</h5>
            </div>
            <div class="card-body">
                @foreach($pedido->detalles as $detalle)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <img src="{{ $detalle->producto->imagen ? asset('storage/'.$detalle->producto->imagen) : asset('images/placeholder.jpg') }}" 
                         alt="{{ $detalle->producto->nombre }}" 
                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                    
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1">{{ $detalle->producto->nombre }}</h5>
                        <p class="text-muted mb-0 small">
                            Cantidad: {{ $detalle->cantidad }} × S/ {{ number_format($detalle->precio_unitario, 2) }}
                        </p>
                    </div>
                    
                    <div class="text-end">
                        <strong class="text-borgona">S/ {{ number_format($detalle->subtotal, 2) }}</strong>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Estado del Pedido</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge 
                        @if($pedido->estado === 'pendiente') bg-warning
                        @elseif($pedido->estado === 'confirmado') bg-info
                        @elseif($pedido->estado === 'en_preparacion') bg-primary
                        @elseif($pedido->estado === 'enviado') bg-secondary
                        @elseif($pedido->estado === 'entregado') bg-success
                        @elseif($pedido->estado === 'cancelado') bg-danger
                        @endif
                        fs-6 p-2">
                        {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                    </span>
                </div>
                
                <div class="timeline">
                    <div class="timeline-item {{ $pedido->estado === 'pendiente' || $pedido->estado === 'confirmado' || $pedido->estado === 'en_preparacion' || $pedido->estado === 'enviado' || $pedido->estado === 'entregado' ? 'active' : '' }}">
                        <i class="fas fa-clock"></i>
                        <span>Pendiente</span>
                    </div>
                    <div class="timeline-item {{ $pedido->estado === 'confirmado' || $pedido->estado === 'en_preparacion' || $pedido->estado === 'enviado' || $pedido->estado === 'entregado' ? 'active' : '' }}">
                        <i class="fas fa-check-circle"></i>
                        <span>Confirmado</span>
                    </div>
                    <div class="timeline-item {{ $pedido->estado === 'en_preparacion' || $pedido->estado === 'enviado' || $pedido->estado === 'entregado' ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i>
                        <span>En Preparación</span>
                    </div>
                    <div class="timeline-item {{ $pedido->estado === 'enviado' || $pedido->estado === 'entregado' ? 'active' : '' }}">
                        <i class="fas fa-truck"></i>
                        <span>Enviado</span>
                    </div>
                    <div class="timeline-item {{ $pedido->estado === 'entregado' ? 'active' : '' }}">
                        <i class="fas fa-box-open"></i>
                        <span>Entregado</span>
                    </div>
                </div>
                
                @if($pedido->estado === 'pendiente')
                <form action="{{ route('cliente.pedidos.cancelar', $pedido) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('¿Estás seguro de cancelar este pedido?')">
                        <i class="fas fa-times me-2"></i>Cancelar Pedido
                    </button>
                </form>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Resumen</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>S/ {{ number_format($pedido->total - 5, 2) }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span>Delivery:</span>
                    <span>S/ 5.00</span>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between mb-0">
                    <strong>Total:</strong>
                    <strong class="text-borgona fs-5">S/ {{ number_format($pedido->total, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 0;
    margin-top: 20px;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    padding-bottom: 20px;
    color: #999;
}

.timeline-item:not(:last-child):before {
    content: '';
    position: absolute;
    left: 10px;
    top: 25px;
    height: calc(100% - 10px);
    width: 2px;
    background: #e0e0e0;
}

.timeline-item.active {
    color: #8B1538;
}

.timeline-item.active:not(:last-child):before {
    background: #8B1538;
}

.timeline-item i {
    position: absolute;
    left: 0;
    top: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: white;
}

.timeline-item.active i {
    background: #8B1538;
}

.timeline-item span {
    display: block;
    font-size: 14px;
    margin-top: 2px;
}
</style>
@endpush
@endsection
