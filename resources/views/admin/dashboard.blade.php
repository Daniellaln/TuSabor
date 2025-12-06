@extends("layouts.admin")

@section("admin-content")
<div class="mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Administrativo</h1>
    <p class="text-muted">Bienvenido, {{ auth()->user()->name }}</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="h1 text-borgona mb-0">{{ number_format($ventasHoy ?? 0, 2) }}</h3>
                    <p class="text-muted mb-0">Ventas Hoy</p>
                </div>
                <div class="icon-circle">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="h1 text-borgona mb-0">{{ $totalPedidos ?? 0 }}</h3>
                    <p class="text-muted mb-0">Pedidos</p>
                </div>
                <div class="icon-circle gold">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="h1 text-borgona mb-0">{{ $totalReservas ?? 0 }}</h3>
                    <p class="text-muted mb-0">Reservas</p>
                </div>
                <div class="icon-circle">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="h1 text-borgona mb-0">{{ $totalProductos ?? 0 }}</h3>
                    <p class="text-muted mb-0">Productos</p>
                </div>
                <div class="icon-circle gold">
                    <i class="fas fa-utensils"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="dashboard-card">
            <h4 class="text-borgona mb-3"><i class="fas fa-chart-line me-2"></i>Productos Más Vendidos</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Ventas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productosMasVendidos ?? [] as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->categoria->nombre ?? "N/A" }}</td>
                            <td><span class="badge badge-gold">{{ $producto->total_vendido }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No hay datos disponibles</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card">
            <h4 class="text-borgona mb-3"><i class="fas fa-clock me-2"></i>Pedidos Recientes</h4>
            <div class="list-group list-group-flush">
                @forelse($pedidosRecientes ?? [] as $pedido)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <span><strong>#{{ $pedido->id }}</strong></span>
                        <span class="badge bg-warning">{{ $pedido->estado }}</span>
                    </div>
                    <small class="text-muted">{{ $pedido->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <p class="text-muted text-center">No hay pedidos recientes</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection