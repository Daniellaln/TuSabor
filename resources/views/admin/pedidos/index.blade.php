@extends('layouts.admin')
@section('admin-content')
<div class="mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-shopping-bag me-2"></i>Gestión de Pedidos</h1>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-elegant">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                <tr>
                    <td><strong>#{{ $pedido->id }}</strong></td>
                    <td>{{ $pedido->user->name }}</td>
                    <td>S/ {{ number_format($pedido->total, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $pedido->estado == 'entregado' ? 'success' : 'warning' }}">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </td>
                    <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay pedidos</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
