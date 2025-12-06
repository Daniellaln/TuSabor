@extends('layouts.admin')
@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-chair me-2"></i>Gestión de Mesas</h1>
    <a href="{{ route('admin.mesas.create') }}" class="btn btn-borgona">
        <i class="fas fa-plus me-2"></i>Nueva Mesa
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-elegant">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mesas as $mesa)
                <tr>
                    <td><strong>Mesa #{{ $mesa->numero }}</strong></td>
                    <td>{{ $mesa->capacidad }} personas</td>
                    <td>
                        <span class="badge {{ $mesa->disponible ? 'bg-success' : 'bg-danger' }}">
                            {{ $mesa->disponible ? 'Disponible' : 'Ocupada' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.mesas.edit', $mesa) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.mesas.destroy', $mesa) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No hay mesas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
