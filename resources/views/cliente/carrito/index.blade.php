@extends('layouts.cliente')

@section('title', 'Carrito - TuSabor')

@section('cliente-content')
<div class="mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-shopping-cart me-2"></i>Mi Carrito</h1>
</div>

@if($items && count($items) > 0)
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @foreach($items as $item)
                <div class="row mb-3 pb-3 border-bottom">
                    <div class="col-md-3">
                        {{-- RUTA CORREGIDA: usa public/images directamente --}}
                        <img src="{{ $item->producto->imagen ? asset('images/'.$item->producto->imagen) : asset('images/placeholder.jpg') }}" 
                             class="img-fluid rounded" 
                             alt="{{ $item->producto->nombre }}"
                             style="width: 80px; height: 80px; object-fit: cover;"
                             onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                    </div>
                    <div class="col-md-6">
                        <h5>{{ $item->producto->nombre }}</h5>
                        <p class="text-muted small mb-1">{{ Str::limit($item->producto->descripcion, 60) }}</p>
                        <p class="text-borgona fw-bold mb-0">S/ {{ number_format($item->producto->precio, 2) }}</p>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="input-group input-group-sm mb-2">
                            <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidad({{ $item->id }}, {{ $item->cantidad - 1 }})">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center" value="{{ $item->cantidad }}" readonly style="max-width: 60px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidad({{ $item->id }}, {{ $item->cantidad + 1 }})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <p class="fw-bold mb-2">S/ {{ number_format($item->producto->precio * $item->cantidad, 2) }}</p>
                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarItem({{ $item->id }})">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-borgona text-white">
                <h5 class="mb-0">Resumen del Pedido</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>S/ {{ number_format($totalCarrito, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Delivery:</span>
                    <span>S/ 5.00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <strong>Total:</strong>
                    <strong class="text-borgona">S/ {{ number_format($totalCarrito + 5, 2) }}</strong>
                </div>
                
                <a href="{{ route('cliente.pedidos.checkout') }}" class="btn btn-borgona w-100 mb-2">
                    <i class="fas fa-credit-card me-2"></i>Proceder al Pago
                </a>
                <a href="{{ route('cliente.catalogo.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i>Seguir Comprando
                </a>
            </div>
        </div>
    </div>
</div>
@else
<div class="text-center py-5">
    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
    <h3>Tu carrito está vacío</h3>
    <p class="text-muted">Agrega productos desde nuestro catálogo</p>
    <a href="{{ route('cliente.catalogo.index') }}" class="btn btn-borgona">
        <i class="fas fa-utensils me-2"></i>Ver Menú
    </a>
</div>
@endif

@push('scripts')
<script>
function actualizarCantidad(itemId, nuevaCantidad) {
    if (nuevaCantidad < 1) {
        eliminarItem(itemId);
        return;
    }
    
    fetch(`/cliente/carrito/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ cantidad: nuevaCantidad })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al actualizar la cantidad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el carrito');
    });
}

function eliminarItem(itemId) {
    if (!confirm('¿Estás seguro de eliminar este producto?')) {
        return;
    }
    
    fetch(`/cliente/carrito/${itemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al eliminar el producto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el producto');
    });
}
</script>
@endpush
@endsection
