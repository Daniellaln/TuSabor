@extends('layouts.admin')

@section('title', isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría')

@section('admin-content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 style="color: #8B1538;">
                <i class="fas fa-tags me-2"></i>{{ isset($categoria) ? 'Editar' : 'Nueva' }} Categoría
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ isset($categoria) ? route('admin.categorias.update', $categoria) : route('admin.categorias.store') }}" method="POST">
                        @csrf
                        @if(isset($categoria))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Categoría *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" 
                                       {{ old('activo', $categoria->activo ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    Categoría Activa
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dorado">
                                <i class="fas fa-save me-2"></i>Guardar
                            </button>
                            <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
