@extends('layouts.admin')
@section('admin-content')
<div class="mb-4">
    <h1 class="h2 text-borgona"><i class="fas fa-calendar-alt me-2"></i>Gestión de Reservas</h1>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-elegant">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Mesa</th>
                    <th>Fecha</th>
                    <th>Personas</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                <tr>
                    <td><strong>#{{ $reserva->id }}</strong></td>
                    <td>{{ $reserva->user->name }}</td>
                    <td>Mesa #{{ $reserva->mesa->numero }}</td>
                    <td>{{ $reserva->fecha_hora->format('d/m/Y H:i') }}</td>
                    <td>{{ $reserva->num_personas }}</td>
                    <td>
                        <span class="badge bg-{{ $reserva->estado == 'confirmada' ? 'success' : 'warning' }}">
                            {{ ucfirst($reserva->estado) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.reservas.show', $reserva) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay reservas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
