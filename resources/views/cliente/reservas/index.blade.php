@extends('layouts.cliente')
@section('cliente-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 text-borgona"><i class="fas fa-calendar-check me-2"></i>Mis Reservas</h1>
    </div>
    <a href="{{ route('cliente.reservas.create') }}" class="btn btn-borgona">
        <i class="fas fa-plus me-2"></i>Nueva Reserva
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    @forelse($reservas as $reserva)
    <div class="col-md-6 col-lg-4">
        <div class="card reserva-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="card-title text-borgona mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Reserva #{{ $reserva->id }}
                    </h5>
                    @php
                        $badgeClass = match($reserva->estado) {
                            'confirmada' => 'success',
                            'pendiente' => 'warning',
                            'cancelada' => 'danger',
                            'completada' => 'info',
                            default => 'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">
                        {{ ucfirst($reserva->estado) }}
                    </span>
                </div>
                
                <div class="reserva-details">
                    <p class="mb-2">
                        <i class="fas fa-chair me-2 text-borgona"></i>
                        <strong>Mesa:</strong> #{{ $reserva->mesa->numero }}
                        @if($reserva->mesa->ubicacion)
                            <span class="text-muted small">({{ $reserva->mesa->ubicacion }})</span>
                        @endif
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-calendar me-2 text-borgona"></i>
                        <strong>Fecha:</strong> {{ $reserva->fecha_hora->format('d/m/Y') }}
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-clock me-2 text-borgona"></i>
                        <strong>Hora:</strong> {{ $reserva->fecha_hora->format('H:i') }}
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-users me-2 text-borgona"></i>
                        <strong>Personas:</strong> {{ $reserva->num_personas }}
                    </p>
                    
                    @if($reserva->observaciones)
                    <div class="mt-3 pt-3 border-top">
                        <p class="mb-0 text-muted small">
                            <i class="fas fa-comment me-2"></i>
                            <strong>Observaciones:</strong><br>
                            {{ $reserva->observaciones }}
                        </p>
                    </div>
                    @endif
                </div>
                
                <div class="mt-3 pt-3 border-top d-flex gap-2">
                    <a href="{{ route('cliente.reservas.show', $reserva) }}" class="btn btn-sm btn-outline-borgona flex-fill">
                        <i class="fas fa-eye me-1"></i>Ver Detalles
                    </a>
                    @if(in_array($reserva->estado, ['pendiente', 'confirmada']))
                    <form action="{{ route('cliente.reservas.cancelar', $reserva) }}" method="POST" class="flex-fill">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100" 
                                onclick="return confirm('¿Estás seguro de cancelar esta reserva?')">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-calendar-times fa-3x mb-3 text-muted"></i>
            <h5>No tienes reservas</h5>
            <p class="mb-3">¡Haz tu primera reserva y disfruta de una experiencia gastronómica única!</p>
            <a href="{{ route('cliente.reservas.create') }}" class="btn btn-borgona">
                <i class="fas fa-plus me-2"></i>Crear Primera Reserva
            </a>
        </div>
    </div>
    @endforelse
</div>

@if($reservas->hasPages())
<div class="mt-4">
    {{ $reservas->links() }}
</div>
@endif

<style>
.reserva-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
}

.reserva-card:hover {
    box-shadow: 0 4px 12px rgba(139, 21, 56, 0.1);
    transform: translateY(-2px);
}

.reserva-details p {
    font-size: 0.95rem;
}

.btn-borgona {
    background-color: #8B1538;
    border-color: #8B1538;
    color: white;
}

.btn-borgona:hover {
    background-color: #6d1029;
    border-color: #6d1029;
    color: white;
}

.btn-outline-borgona {
    color: #8B1538;
    border-color: #8B1538;
}

.btn-outline-borgona:hover {
    background-color: #8B1538;
    border-color: #8B1538;
    color: white;
}

.text-borgona {
    color: #8B1538;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}
</style>
@endsection
