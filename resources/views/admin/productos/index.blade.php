@extends('layouts.admin')

@section('title', 'Gestión de Productos')

@section('admin-content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 style="color: #8B1538;"><i class="fas fa-utensils me-2"></i>Productos</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.productos.create') }}" class="btn btn-dorado">
                <i class="fas fa-plus me-2"></i>Nuevo Producto
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Destacado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td>
                                <strong>{{ $producto->nombre }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($producto->descripcion, 40) }}</small>
                            </td>
                            <td>
                                <span class="badge" style="background-color: #8B1538;">
                                    {{ $producto->categoria->nombre }}
                                </span>
                            </td>
                            <td><strong>${{ number_format($producto->precio, 2) }}</strong></td>
                            <td>
                                <span class="badge bg-{{ $producto->disponible ? 'success' : 'secondary' }}">
                                    {{ $producto->disponible ? 'Disponible' : 'No disponible' }}
                                </span>
                            </td>
                            <td>
                                @if($producto->destacado)
                                    <i class="fas fa-star text-warning"></i>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este producto?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No hay productos registrados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $productos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
