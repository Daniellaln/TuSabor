@extends('layouts.admin')
@section('admin-content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h2 text-borgona">
            <i class="fas fa-calendar-check me-2"></i>Detalles de Reserva #{{ $reserva->id }}
        </h1>
        <a href="{{ route('admin.reservas.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Listado
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
        <!-- Información del Cliente -->
        <div class="card mb-3">
            <div class="card-header bg-borgona text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Información del Cliente
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-user text-borgona me-2"></i>Nombre:</strong><br>
                            {{ $reserva->user->name }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-envelope text-borgona me-2"></i>Email:</strong><br>
                            {{ $reserva->user->email }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles de la Reserva -->
        <div class="card mb-3">
            <div class="card-header bg-borgona text-white">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Detalles de la Reserva
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-hashtag text-borgona me-2"></i>ID Reserva:</strong><br>
                            #{{ $reserva->id }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-flag text-borgona me-2"></i>Estado:</strong><br>
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

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-chair text-borgona me-2"></i>Mesa:</strong><br>
                            Mesa #{{ $reserva->mesa->numero }}
                            @if($reserva->mesa->ubicacion)
                                <br><small class="text-muted">{{ $reserva->mesa->ubicacion }}</small>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-users text-borgona me-2"></i>Capacidad de Mesa:</strong><br>
                            {{ $reserva->mesa->capacidad }} personas
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-calendar text-borgona me-2"></i>Fecha:</strong><br>
                            {{ $reserva->fecha_hora->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-clock text-borgona me-2"></i>Hora:</strong><br>
                            {{ $reserva->fecha_hora->format('H:i') }}
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-users text-borgona me-2"></i>Número de Personas:</strong><br>
                            {{ $reserva->num_personas }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-calendar-plus text-borgona me-2"></i>Creada el:</strong><br>
                            {{ $reserva->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>

                @if($reserva->observaciones)
                <hr>
                <p class="mb-0">
                    <strong><i class="fas fa-comment text-borgona me-2"></i>Observaciones:</strong><br>
                    {{ $reserva->observaciones }}
                </p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Cambiar Estado -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-borgona">
                    <i class="fas fa-edit me-2"></i>Cambiar Estado
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reservas.updateEstado', $reserva) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label">Estado Actual:</label>
                        <p>
                            <span class="badge bg-{{ $badgeClass }} fs-6">
                                {{ ucfirst($reserva->estado) }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Nuevo Estado:</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="pendiente" {{ $reserva->estado == 'pendiente' ? 'selected' : '' }}>
                                Pendiente
                            </option>
                            <option value="confirmada" {{ $reserva->estado == 'confirmada' ? 'selected' : '' }}>
                                Confirmada
                            </option>
                            <option value="completada" {{ $reserva->estado == 'completada' ? 'selected' : '' }}>
                                Completada
                            </option>
                            <option value="cancelada" {{ $reserva->estado == 'cancelada' ? 'selected' : '' }}>
                                Cancelada
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-borgona w-100">
                        <i class="fas fa-save me-2"></i>Actualizar Estado
                    </button>
                </form>
            </div>
        </div>

        <!-- Acciones -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-borgona">
                    <i class="fas fa-cog me-2"></i>Acciones
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $reserva->user->email }}" class="btn btn-outline-primary">
                        <i class="fas fa-envelope me-2"></i>Enviar Email
                    </a>
                    
                    <form action="{{ route('admin.reservas.destroy', $reserva) }}" method="POST"
                          onsubmit="return confirm('¿Estás seguro de eliminar esta reserva? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>Eliminar Reserva
                        </button>
                    </form>
                </div>
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

.card {
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.card-header {
    border-bottom: 2px solid #dee2e6;
}

hr {
    margin: 1rem 0;
    opacity: 0.1;
}
</style>
@endsection
