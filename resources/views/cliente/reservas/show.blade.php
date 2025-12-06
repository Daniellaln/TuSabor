@extends('layouts.cliente')
@section('cliente-content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h2 text-borgona">
            <i class="fas fa-calendar-check me-2"></i>Detalles de la Reserva #{{ $reserva->id }}
        </h1>
        <a href="{{ route('cliente.reservas.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
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

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-borgona text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Información de la Reserva
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-hashtag text-borgona me-2"></i>Número de Reserva
                            </label>
                            <p class="info-value">#{{ $reserva->id }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-flag text-borgona me-2"></i>Estado
                            </label>
                            <p class="info-value">
                                @php
                                    $badgeClass = match($reserva->estado) {
                                        'confirmada' => 'success',
                                        'pendiente' => 'warning',
                                        'cancelada' => 'danger',
                                        'completada' => 'info',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }} fs-6">
                                    {{ ucfirst($reserva->estado) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-chair text-borgona me-2"></i>Mesa
                            </label>
                            <p class="info-value">
                                Mesa #{{ $reserva->mesa->numero }}
                                @if($reserva->mesa->ubicacion)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $reserva->mesa->ubicacion }}
                                    </small>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-users text-borgona me-2"></i>Capacidad de la Mesa
                            </label>
                            <p class="info-value">{{ $reserva->mesa->capacidad }} personas</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-calendar text-borgona me-2"></i>Fecha
                            </label>
                            <p class="info-value">{{ $reserva->fecha_hora->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-clock text-borgona me-2"></i>Hora
                            </label>
                            <p class="info-value">{{ $reserva->fecha_hora->format('H:i') }}</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-users text-borgona me-2"></i>Número de Personas
                            </label>
                            <p class="info-value">{{ $reserva->num_personas }} {{ $reserva->num_personas == 1 ? 'persona' : 'personas' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-calendar-plus text-borgona me-2"></i>Fecha de Creación
                            </label>
                            <p class="info-value">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($reserva->observaciones)
                <hr>
                <div class="info-item">
                    <label class="info-label">
                        <i class="fas fa-comment text-borgona me-2"></i>Observaciones
                    </label>
                    <p class="info-value">{{ $reserva->observaciones }}</p>
                </div>
                @endif
            </div>
        </div>

        @if(in_array($reserva->estado, ['pendiente', 'confirmada']))
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="text-danger mb-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>Cancelar Reserva
                </h5>
                <p class="text-muted mb-3">
                    Si necesitas cancelar tu reserva, puedes hacerlo aquí. Esta acción no se puede deshacer.
                </p>
                <form action="{{ route('cliente.reservas.cancelar', $reserva) }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-2"></i>Cancelar Reserva
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-borgona">
                    <i class="fas fa-info-circle me-2"></i>Información Importante
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-3">
                    <i class="fas fa-clock me-2"></i>
                    <strong>Hora de llegada:</strong><br>
                    Por favor llega 10 minutos antes de tu reserva.
                </div>

                <div class="alert alert-warning mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Política de cancelación:</strong><br>
                    Puedes cancelar hasta 2 horas antes de tu reserva.
                </div>

                <div class="alert alert-success mb-0">
                    <i class="fas fa-phone me-2"></i>
                    <strong>¿Necesitas ayuda?</strong><br>
                    Llámanos: (123) 456-7890<br>
                    Email: reservas@tusabor.com
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body text-center">
                <i class="fas fa-utensils fa-3x text-borgona mb-3"></i>
                <h5 class="text-borgona">¡Te esperamos!</h5>
                <p class="text-muted mb-0">
                    Estamos preparando todo para brindarte una experiencia gastronómica inolvidable.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.bg-borgona {
    background-color: #8B1538;
}

.text-borgona {
    color: #8B1538;
}

.info-item {
    margin-bottom: 1rem;
}

.info-label {
    font-weight: 600;
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    font-size: 1.1rem;
    color: #212529;
    margin-bottom: 0;
}

.card {
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.card-header {
    border-bottom: 2px solid #dee2e6;
}

hr {
    margin: 1.5rem 0;
    opacity: 0.1;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
}
</style>
@endsection
