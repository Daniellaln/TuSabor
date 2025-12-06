@extends('layouts.admin')

@section('title', 'Editar Producto - TuSabor')

@section('admin-content')
<div class="mb-4">
    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-borgona btn-sm mb-3">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
    <h1 class="h2 text-borgona"><i class="fas fa-utensils me-2"></i>Editar Producto</h1>
</div>

<form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Información del Producto</h5>
                </div>
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
                    
                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre', $producto->nombre) }}"
                               placeholder="Ej: Filete Mignon"
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select name="categoria_id" 
                                    class="form-select @error('categoria_id') is-invalid @enderror" 
                                    required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Precio <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="number" 
                                       name="precio" 
                                       class="form-control @error('precio') is-invalid @enderror" 
                                       value="{{ old('precio', $producto->precio) }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00"
                                       required>
                            </div>
                            @error('precio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" 
                                  class="form-control @error('descripcion') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Describe el producto, ingredientes, etc.">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Imagen del Producto</label>
                        
                        @if($producto->imagen)
                        <div class="mb-3">
                            <p class="text-muted small mb-2">Imagen actual:</p>
                            <img src="{{ asset('storage/'.$producto->imagen) }}" 
                                 alt="{{ $producto->nombre }}" 
                                 style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #dee2e6;">
                            <div class="form-check mt-2">
                                <input type="checkbox" name="eliminar_imagen" class="form-check-input" id="eliminarImagen">
                                <label class="form-check-label text-danger" for="eliminarImagen">
                                    Eliminar imagen actual
                                </label>
                            </div>
                        </div>
                        @endif
                        
                        <input type="file" 
                               name="imagen" 
                               class="form-control @error('imagen') is-invalid @enderror" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               id="imagenInput">
                        @error('imagen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB. Deja vacío para mantener la imagen actual.</small>
                        
                        <div id="imagenPreview" class="mt-3" style="display: none;">
                            <p class="text-muted small mb-2">Nueva imagen:</p>
                            <img id="imagenPreviewImg" src="" alt="Vista previa" style="max-width: 300px; max-height: 300px; border-radius: 8px; border: 2px solid #dee2e6;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Opciones</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="disponible" value="0">
                            <input type="checkbox" 
                                   name="disponible" 
                                   class="form-check-input" 
                                   id="disponible"
                                   value="1"
                                   {{ old('disponible', $producto->disponible) == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="disponible">
                                <i class="fas fa-check-circle text-success me-1"></i>
                                Disponible para venta
                            </label>
                        </div>
                        <small class="text-muted">El producto aparecerá en el catálogo</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="destacado" value="0">
                            <input type="checkbox" 
                                   name="destacado" 
                                   class="form-check-input" 
                                   id="destacado"
                                   value="1"
                                   {{ old('destacado', $producto->destacado) == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="destacado">
                                <i class="fas fa-star text-warning me-1"></i>
                                Producto Destacado
                            </label>
                        </div>
                        <small class="text-muted">Aparecerá en la sección destacados</small>
                    </div>
                    
                    <hr>
                    
                    <button type="submit" class="btn btn-borgona w-100 mb-2">
                        <i class="fas fa-save me-2"></i>Actualizar Producto
                    </button>
                    
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('imagenInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagenPreviewImg').src = e.target.result;
            document.getElementById('imagenPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagenPreview').style.display = 'none';
    }
});
</script>
@endpush
@endsection
