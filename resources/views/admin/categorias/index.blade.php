@extends('layouts.admin')

@section('title', 'Gestión de Categorías')

@section('admin-content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 style="color: #8B1538;"><i class="fas fa-tags me-2"></i>Categorías</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-dorado">
                <i class="fas fa-plus me-2"></i>Nueva Categoría
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
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td><strong>{{ $categoria->nombre }}</strong></td>
                            <td>{{ Str::limit($categoria->descripcion, 50) }}</td>
                            <td>
                                <span class="badge bg-{{ $categoria->activo ? 'success' : 'secondary' }}">
                                    {{ $categoria->activo ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta categoría?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No hay categorías registradas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
