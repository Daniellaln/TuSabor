@extends('layouts.admin')
@section('admin-content')
<div class="mb-4">
    <h1 class="h2 text-borgona">{{ isset($mesa) ? 'Editar Mesa' : 'Nueva Mesa' }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($mesa) ? route('admin.mesas.update', $mesa) : route('admin.mesas.store') }}" method="POST">
            @csrf
            @if(isset($mesa))
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label class="form-label-elegant">Número de Mesa</label>
                <input type="number" name="numero" class="form-control form-control-elegant" 
                       value="{{ old('numero', $mesa->numero ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label-elegant">Capacidad</label>
                <input type="number" name="capacidad" class="form-control form-control-elegant" 
                       value="{{ old('capacidad', $mesa->capacidad ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="disponible" class="form-check-input" 
                           {{ old('disponible', $mesa->disponible ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label">Disponible</label>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-borgona">
                    <i class="fas fa-save me-2"></i>Guardar
                </button>
                <a href="{{ route('admin.mesas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
