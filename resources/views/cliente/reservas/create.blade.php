@extends('layouts.cliente')
@section('cliente-content')
<div class="mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-calendar-plus me-2"></i>Nueva Reserva</h1>
</div>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('cliente.reservas.store') }}" method="POST" id="formReserva">
                    @csrf
                    
                    <!-- Selector de Mesa -->
                    <div class="mb-4">
                        <label class="form-label-elegant">Seleccionar Mesa <span class="text-danger">*</span></label>
                        <div class="row g-3" id="mesasContainer">
                            @forelse($mesas as $mesa)
                            <div class="col-md-6">
                                <div class="card mesa-card" onclick="seleccionarMesa({{ $mesa->id }}, this)">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1 text-borgona">
                                                    <i class="fas fa-chair me-2"></i>Mesa {{ $mesa->numero }}
                                                </h5>
                                                <p class="mb-1 small">
                                                    <i class="fas fa-users me-1"></i>Capacidad: {{ $mesa->capacidad }} personas
                                                </p>
                                                @if($mesa->ubicacion)
                                                <p class="mb-0 small text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $mesa->ubicacion }}
                                                </p>
                                                @endif
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="mesa_id" 
                                                       value="{{ $mesa->id }}" id="mesa{{ $mesa->id }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle me-2"></i>No hay mesas disponibles en este momento.
                                </div>
                            </div>
                            @endforelse
                        </div>
                        @error('mesa_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Fecha y Hora -->
                    <div class="mb-3">
                        <label class="form-label-elegant">Fecha y Hora <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="fecha_hora" id="fecha_hora" 
                               class="form-control form-control-elegant @error('fecha_hora') is-invalid @enderror" 
                               min="{{ date('Y-m-d\TH:i', strtotime('+2 hours')) }}" required>
                        @error('fecha_hora')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Las reservas deben hacerse con al menos 2 horas de anticipación.</small>
                    </div>
                    
                    <!-- Verificar Disponibilidad -->
                    <div class="mb-3" id="verificarContainer" style="display: none;">
                        <button type="button" class="btn btn-outline-borgona btn-sm" onclick="verificarDisponibilidad()">
                            <i class="fas fa-search me-2"></i>Verificar Disponibilidad
                        </button>
                        <div id="resultadoDisponibilidad" class="mt-2"></div>
                    </div>
                    
                    <!-- Número de Personas -->
                    <div class="mb-3">
                        <label class="form-label-elegant">Número de Personas <span class="text-danger">*</span></label>
                        <select name="num_personas" id="num_personas" 
                                class="form-control form-control-elegant @error('num_personas') is-invalid @enderror" required>
                            <option value="">Seleccionar...</option>
                            @for($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'persona' : 'personas' }}</option>
                            @endfor
                        </select>
                        @error('num_personas')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Observaciones -->
                    <div class="mb-3">
                        <label class="form-label-elegant">Observaciones (opcional)</label>
                        <textarea name="observaciones" class="form-control form-control-elegant @error('observaciones') is-invalid @enderror" 
                                  rows="3" placeholder="Alergias, preferencias, ocasión especial..."></textarea>
                        @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Botones -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-borgona" id="btnSubmit">
                            <i class="fas fa-check me-2"></i>Confirmar Reserva
                        </button>
                        <a href="{{ route('cliente.reservas.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="text-borgona mb-3"><i class="fas fa-info-circle me-2"></i>Información</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="fas fa-clock text-borgona me-2"></i>
                        Las reservas deben hacerse con al menos 2 horas de anticipación.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope text-borgona me-2"></i>
                        Recibirás una confirmación por correo electrónico.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-users text-borgona me-2"></i>
                        Para reservas de más de 20 personas, por favor contáctanos directamente.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-utensils text-borgona me-2"></i>
                        Selecciona la mesa que mejor se adapte a tu grupo.
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="text-borgona mb-3"><i class="fas fa-phone me-2"></i>Contacto</h5>
                <p class="small mb-1"><strong>Teléfono:</strong> (123) 456-7890</p>
                <p class="small mb-0"><strong>Email:</strong> reservas@tusabor.com</p>
            </div>
        </div>
    </div>
</div>

<style>
.mesa-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
}

.mesa-card:hover {
    border-color: #8B1538;
    box-shadow: 0 4px 8px rgba(139, 21, 56, 0.1);
    transform: translateY(-2px);
}

.mesa-card.selected {
    border-color: #8B1538;
    background-color: #fff5f7;
}

.mesa-card .form-check-input:checked {
    background-color: #8B1538;
    border-color: #8B1538;
}

.form-label-elegant {
    font-weight: 600;
    color: #8B1538;
    margin-bottom: 0.5rem;
}

.form-control-elegant:focus {
    border-color: #8B1538;
    box-shadow: 0 0 0 0.2rem rgba(139, 21, 56, 0.25);
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
</style>

<script>
let mesaSeleccionada = null;

function seleccionarMesa(mesaId, card) {
    // Remover selección anterior
    document.querySelectorAll('.mesa-card').forEach(c => c.classList.remove('selected'));
    
    // Seleccionar nueva mesa
    card.classList.add('selected');
    document.getElementById('mesa' + mesaId).checked = true;
    mesaSeleccionada = mesaId;
    
    // Mostrar botón de verificar disponibilidad
    const fechaHora = document.getElementById('fecha_hora').value;
    if (fechaHora) {
        document.getElementById('verificarContainer').style.display = 'block';
    }
}

// Mostrar verificar disponibilidad cuando se selecciona fecha
document.getElementById('fecha_hora').addEventListener('change', function() {
    if (mesaSeleccionada) {
        document.getElementById('verificarContainer').style.display = 'block';
    }
});

function verificarDisponibilidad() {
    const mesaId = mesaSeleccionada;
    const fechaHora = document.getElementById('fecha_hora').value;
    
    if (!mesaId || !fechaHora) {
        alert('Por favor selecciona una mesa y una fecha/hora');
        return;
    }
    
    const resultado = document.getElementById('resultadoDisponibilidad');
    resultado.innerHTML = '<div class="spinner-border spinner-border-sm text-borgona" role="status"></div> Verificando...';
    
    fetch('{{ route("cliente.reservas.verificarDisponibilidad") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            mesa_id: mesaId,
            fecha_hora: fechaHora
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.disponible) {
            resultado.innerHTML = '<div class="alert alert-success py-2 mb-0"><i class="fas fa-check-circle me-2"></i>' + data.mensaje + '</div>';
        } else {
            resultado.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="fas fa-times-circle me-2"></i>' + data.mensaje + '</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        resultado.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="fas fa-exclamation-circle me-2"></i>Error al verificar disponibilidad</div>';
    });
}

// Validación antes de enviar
document.getElementById('formReserva').addEventListener('submit', function(e) {
    if (!mesaSeleccionada) {
        e.preventDefault();
        alert('Por favor selecciona una mesa');
        return false;
    }
});
</script>
@endsection
