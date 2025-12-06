@extends('layouts.cliente')

@section('title', 'Finalizar Pedido - TuSabor')

@section('cliente-content')
<div class="mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-credit-card me-2"></i>Finalizar Pedido</h1>
</div>

<form action="{{ route('cliente.pedidos.store') }}" method="POST" id="checkoutForm">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title text-borgona mb-3">Datos de Entrega</h5>
                    
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">Dirección de Entrega <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="direccion_entrega" 
                               class="form-control @error('direccion_entrega') is-invalid @enderror" 
                               value="{{ old('direccion_entrega') }}"
                               placeholder="Ej: Av. Principal 123, Dpto 4B"
                               required
                               minlength="10"
                               maxlength="255">
                        @error('direccion_entrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Incluye número de casa/departamento y referencias</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Teléfono de Contacto <span class="text-danger">*</span></label>
                        <input type="tel" 
                               name="telefono" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               value="{{ old('telefono') }}"
                               placeholder="999999999"
                               required
                               pattern="[0-9]{9,15}"
                               minlength="9"
                               maxlength="15"
                               title="Ingrese solo números (9-15 dígitos)">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Solo números, sin espacios ni guiones</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Observaciones (opcional)</label>
                        <textarea name="observaciones" 
                                  class="form-control @error('observaciones') is-invalid @enderror" 
                                  rows="3"
                                  maxlength="500"
                                  placeholder="Ej: Sin cebolla, sin picante, tocar el timbre 2 veces...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Máximo 500 caracteres</small>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-borgona mb-3">Método de Pago</h5>
                    
                    <div class="form-check mb-3 p-3 border rounded">
                        <input class="form-check-input" type="radio" name="metodo_pago" id="efectivo" value="efectivo" checked>
                        <label class="form-check-label w-100" for="efectivo">
                            <i class="fas fa-money-bill-wave me-2 text-success"></i>
                            <strong>Efectivo</strong>
                            <p class="text-muted small mb-0 ms-4">Paga al recibir tu pedido</p>
                        </label>
                    </div>
                    
                    <div class="form-check p-3 border rounded">
                        <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta">
                        <label class="form-check-label w-100" for="tarjeta">
                            <i class="fas fa-credit-card me-2 text-primary"></i>
                            <strong>Tarjeta</strong>
                            <p class="text-muted small mb-0 ms-4">Pago contra entrega con tarjeta</p>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title text-borgona mb-3">Resumen del Pedido</h5>
                    
                    <div class="mb-3">
                        <small class="text-muted">{{ $items->count() }} producto(s)</small>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>S/ {{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery:</span>
                        <span>S/ {{ number_format($costoEnvio, 2) }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total a Pagar:</strong>
                        <strong class="text-borgona fs-4">S/ {{ number_format($total, 2) }}</strong>
                    </div>
                    
                    <button type="submit" class="btn btn-borgona w-100 mb-2" id="btnConfirmar">
                        <i class="fas fa-check me-2"></i>Confirmar Pedido
                    </button>
                    
                    <a href="{{ route('cliente.carrito.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const telefono = document.querySelector('input[name="telefono"]');
    const valor = telefono.value.trim();
    
    // Validar que solo contenga números
    if (!/^\d+$/.test(valor)) {
        e.preventDefault();
        alert('El teléfono debe contener solo números.');
        telefono.focus();
        return false;
    }
    
    // Validar longitud
    if (valor.length < 9 || valor.length > 15) {
        e.preventDefault();
        alert('El teléfono debe tener entre 9 y 15 dígitos.');
        telefono.focus();
        return false;
    }
    
    // Deshabilitar botón para evitar doble envío
    const btn = document.getElementById('btnConfirmar');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
});

// Validación en tiempo real del teléfono
document.querySelector('input[name="telefono"]').addEventListener('input', function(e) {
    // Eliminar cualquier caracter que no sea número
    this.value = this.value.replace(/\D/g, '');
});
</script>
@endpush
@endsection
