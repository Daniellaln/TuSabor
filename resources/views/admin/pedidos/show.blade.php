@extends('layouts.admin')

@section('title', 'Detalle del Pedido')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-borgona">
            <i class="fas fa-receipt me-2"></i>Pedido #{{ $pedido->id }}
        </h1>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    <div class="row">
        <!-- Información del Cliente -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-borgona text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Cliente</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Nombre:</strong> {{ $pedido->user->name }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $pedido->user->email }}</p>
                    <p class="mb-2"><strong>Teléfono:</strong> {{ $pedido->telefono ?? 'No especificado' }}</p>
                    <p class="mb-0"><strong>Dirección:</strong> {{ $pedido->direccion ?? 'No especificada' }}</p>
                </div>
            </div>
        </div>

        <!-- Estado del Pedido -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-borgona text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Estado</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pedidos.updateEstado', $pedido) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label">Estado Actual:</label>
                            <select name="estado" class="form-select" required>
                                <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>
                                    Pendiente
                                </option>
                                <option value="preparando" {{ $pedido->estado == 'preparando' ? 'selected' : '' }}>
                                    En Preparación
                                </option>
                                <option value="en_camino" {{ $pedido->estado == 'en_camino' ? 'selected' : '' }}>
                                    En Camino
                                </option>
                                <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>
                                    Entregado
                                </option>
                                <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>
                                    Cancelado
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-borgona w-100">
                            <i class="fas fa-save me-2"></i>Actualizar Estado
                        </button>
                    </form>

                    <hr>

                    <p class="mb-2"><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Total:</strong> <span class="text-borgona fw-bold">S/ {{ number_format($pedido->total, 2) }}</span></p>
                </div>
            </div>
        </div>

        <!-- Timeline del Pedido -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-borgona text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Progreso</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $pedido->estado == 'pendiente' ? 'active' : ($pedido->estado != 'cancelado' ? 'completed' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Pendiente</h6>
                                <small>Pedido recibido</small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $pedido->estado == 'preparando' ? 'active' : (in_array($pedido->estado, ['en_camino', 'entregado']) ? 'completed' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>En Preparación</h6>
                                <small>Cocinando tu pedido</small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $pedido->estado == 'en_camino' ? 'active' : ($pedido->estado == 'entregado' ? 'completed' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>En Camino</h6>
                                <small>Delivery en ruta</small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $pedido->estado == 'entregado' ? 'active completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Entregado</h6>
                                <small>Pedido completado</small>
                            </div>
                        </div>

                        @if($pedido->estado == 'cancelado')
                        <div class="timeline-item active" style="border-left-color: #dc3545;">
                            <div class="timeline-icon bg-danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="text-danger">Cancelado</h6>
                                <small>Pedido cancelado</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos del Pedido -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-borgona text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Productos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio Unit.</th>
                                    <th>Cantidad</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $detalle->producto->imagen ? asset('images/'.$detalle->producto->imagen) : asset('images/placeholder.jpg') }}" 
                                                 alt="{{ $detalle->producto->nombre }}"
                                                 class="rounded me-3"
                                                 style="width: 50px; height: 50px; object-fit: cover;"
                                                 onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                            <div>
                                                <strong>{{ $detalle->producto->nombre }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $detalle->producto->categoria->nombre }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>S/ {{ number_format($detalle->precio, 2) }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td class="text-end">S/ {{ number_format($detalle->precio * $detalle->cantidad, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">S/ {{ number_format($pedido->total - 5, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Delivery:</strong></td>
                                    <td class="text-end">S/ 5.00</td>
                                </tr>
                                <tr class="table-active">
                                    <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                                    <td class="text-end"><strong class="text-borgona fs-5">S/ {{ number_format($pedido->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notas Adicionales -->
    @if($pedido->notas)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-borgona text-white">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notas del Cliente</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $pedido->notas }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.timeline {
    position: relative;
    padding-left: 0;
}

.timeline-item {
    position: relative;
    padding-left: 45px;
    padding-bottom: 25px;
    border-left: 2px solid #e0e0e0;
}

.timeline-item:last-child {
    border-left: 2px solid transparent;
    padding-bottom: 0;
}

.timeline-item.active {
    border-left-color: #8B1538;
}

.timeline-item.completed {
    border-left-color: #28a745;
}

.timeline-icon {
    position: absolute;
    left: -12px;
    top: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #666;
}

.timeline-item.active .timeline-icon {
    background: #8B1538;
    color: white;
}

.timeline-item.completed .timeline-icon {
    background: #28a745;
    color: white;
}

.timeline-content h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

.timeline-content small {
    color: #666;
    font-size: 12px;
}
</style>
@endsection
