@extends('layouts.cliente')

@section('title', 'Menú - TuSabor')

@section('cliente-content')
<div class="mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-utensils me-2"></i>Nuestro Menú</h1>
    <p class="text-muted">Descubre nuestros platos elaborados con ingredientes frescos</p>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="btn-group" role="group">
            <a href="{{ route('cliente.catalogo.index') }}" class="btn btn-outline-borgona {{ !request('categoria') ? 'active' : '' }}">
                Todos
            </a>
            @foreach($categorias as $cat)
            <a href="{{ route('cliente.catalogo.index', ['categoria' => $cat->id]) }}" 
               class="btn btn-outline-borgona {{ request('categoria') == $cat->id ? 'active' : '' }}">
                {{ $cat->nombre }}
            </a>
            @endforeach
        </div>
    </div>
</div>

<div class="row g-4">
    @forelse($productos as $producto)
    <div class="col-md-4">
        <div class="card product-card">
            @if($producto->destacado)
            <span class="badge-destacado">⭐ Destacado</span>
            @endif
            
            <img src="{{ $producto->imagen ? asset('images/'.$producto->imagen) : asset('images/placeholder.jpg') }}" 
                 class="card-img-top product-image" alt="{{ $producto->nombre }}"
                 onclick="verDetalle({{ $producto->id }})">
            
            <div class="card-body">
                <h5 class="card-title">{{ $producto->nombre }}</h5>
                <p class="card-text text-muted small">{{ Str::limit($producto->descripcion, 80) }}</p>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="price">S/ {{ number_format($producto->precio, 2) }}</span>
                    <div class="btn-group">
                        <button class="btn btn-outline-borgona btn-sm" onclick="verDetalle({{ $producto->id }})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-borgona btn-sm" onclick="agregarAlCarrito({{ $producto->id }})">
                            <i class="fas fa-cart-plus"></i> Agregar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>No hay productos disponibles en este momento.
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $productos->links() }}
</div>

<!-- Modal de Detalle del Producto -->
<div class="modal fade" id="productoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-borgona text-white">
                <h5 class="modal-title" id="productoModalLabel">Detalle del Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="productoModalBody">
                <div class="text-center">
                    <div class="spinner-border text-borgona" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

.btn-outline-borgona {
    color: #8B1538;
    border-color: #8B1538;
}

.btn-outline-borgona:hover,
.btn-outline-borgona.active {
    background-color: #8B1538;
    border-color: #8B1538;
    color: white;
}

.product-card {
    position: relative;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #dee2e6;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(139, 21, 56, 0.15);
}

.product-image {
    height: 250px;
    object-fit: cover;
    cursor: pointer;
    transition: opacity 0.3s ease;
}

.product-image:hover {
    opacity: 0.9;
}

.badge-destacado {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, #D4AF37 0%, #F4D03F 100%);
    color: #000;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #8B1538;
}

.card-title {
    color: #8B1538;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.bg-borgona {
    background-color: #8B1538;
}

.modal-content {
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

.modal-header {
    border-bottom: 2px solid #6d1029;
}
</style>

@push('scripts')
<script>
function verDetalle(productoId) {
    const modal = new bootstrap.Modal(document.getElementById('productoModal'));
    const modalBody = document.getElementById('productoModalBody');
    
    // Mostrar spinner
    modalBody.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-borgona" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    `;
    
    modal.show();
    
    // Cargar detalles del producto
    fetch('{{ url("cliente/catalogo") }}/' + productoId, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(producto => {
            modalBody.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <img src="${producto.imagen ? '{{ asset("images") }}/' + producto.imagen : '{{ asset("images/placeholder.jpg") }}'}" 
                             class="img-fluid rounded" alt="${producto.nombre}">
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-borgona mb-3">${producto.nombre}</h3>
                        ${producto.destacado ? '<span class="badge bg-warning text-dark mb-2">⭐ Destacado</span>' : ''}
                        <p class="text-muted mb-3">${producto.descripcion}</p>
                        <div class="mb-3">
                            <span class="badge bg-secondary">${producto.categoria}</span>
                        </div>
                        <h4 class="text-borgona mb-4">S/ ${parseFloat(producto.precio).toFixed(2)}</h4>
                        <button class="btn btn-borgona btn-lg w-100" onclick="agregarAlCarrito(${producto.id}); bootstrap.Modal.getInstance(document.getElementById('productoModal')).hide();">
                            <i class="fas fa-cart-plus me-2"></i>Agregar al Carrito
                        </button>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            modalBody.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>Error al cargar los detalles del producto.
                </div>
            `;
        });
}

function agregarAlCarrito(productoId) {
    $.ajax({
        url: '{{ url("cliente/carrito") }}/' + productoId,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            cantidad: 1
        },
        success: function(response) {
            // Mostrar notificación de éxito
            const toast = `
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
                    <div class="toast show bg-success text-white" role="alert">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i>Producto agregado al carrito
                        </div>
                    </div>
                </div>
            `;
            $('body').append(toast);
            setTimeout(() => $('.toast').remove(), 3000);
            
            actualizarContadorCarrito();
        },
        error: function(xhr) {
            console.error(xhr);
            alert('Error al agregar producto');
        }
    });
}

function actualizarContadorCarrito() {
    $.get('{{ route("cliente.carrito.count") }}', function(data) {
        $('#cart-count').text(data.count);
    });
}

$(document).ready(function() {
    actualizarContadorCarrito();
});
</script>
@endpush
@endsection
