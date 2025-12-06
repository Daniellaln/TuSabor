@extends('layouts.admin')

@section('title', 'Editar Mesa - TuSabor')

@section('admin-content')
<div class="mb-4">
    <a href="{{ route('admin.mesas.index') }}" class="btn btn-outline-borgona btn-sm mb-3">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
    <h1 class="h2 text-borgona"><i class="fas fa-chair me-2"></i>Editar Mesa</h1>
</div>

<div class="card">
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="{{ route('admin.mesas.update', $mesa) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Número de Mesa <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="numero" 
                           class="form-control @error('numero') is-invalid @enderror" 
                           value="{{ old('numero', $mesa->numero) }}"
                           placeholder="Ej: M-01, #1, Mesa 1"
                           required>
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Identificador único de la mesa</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Capacidad <span class="text-danger">*</span></label>
                    <input type="number" 
                           name="capacidad" 
                           class="form-control @error('capacidad') is-invalid @enderror" 
                           value="{{ old('capacidad', $mesa->capacidad) }}"
                           min="1"
                           max="20"
                           placeholder="Ej: 4"
                           required>
                    @error('capacidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Número de personas</small>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Ubicación <span class="text-danger">*</span></label>
                <select name="ubicacion" 
                        class="form-select @error('ubicacion') is-invalid @enderror" 
                        required>
                    <option value="">Seleccione una ubicación</option>
                    <option value="interior" {{ old('ubicacion', $mesa->ubicacion) == 'interior' ? 'selected' : '' }}>
                        Interior
                    </option>
                    <option value="terraza" {{ old('ubicacion', $mesa->ubicacion) == 'terraza' ? 'selected' : '' }}>
                        Terraza
                    </option>
                    <option value="vip" {{ old('ubicacion', $mesa->ubicacion) == 'vip' ? 'selected' : '' }}>
                        VIP
                    </option>
                </select>
                @error('ubicacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input type="hidden" name="disponible" value="0">
                    <input type="checkbox" 
                           name="disponible" 
                           class="form-check-input" 
                           id="disponible"
                           value="1"
                           {{ old('disponible', $mesa->disponible) == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="disponible">
                        Mesa Disponible
                    </label>
                </div>
                <small class="text-muted">Desmarca si la mesa está fuera de servicio</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-borgona">
                    <i class="fas fa-save me-2"></i>Actualizar Mesa
                </button>
                <a href="{{ route('admin.mesas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
