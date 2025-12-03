@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white p-4">
                    <h3 class="mb-0">
                        <i class="fas fa-plus-circle"></i> Agregar Nuevo Zapato
                    </h3>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="mb-3"><i class="fas fa-exclamation-circle"></i> Errores encontrados:</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('calzados.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Modelo -->
                        <div class="mb-3">
                            <label for="modelo" class="form-label fw-bold">
                                <i class="fas fa-tag"></i> Modelo *
                            </label>
                            <input type="text" class="form-control @error('modelo') is-invalid @enderror" 
                                   id="modelo" name="modelo" placeholder="Ej: Air Max 270" value="{{ old('modelo') }}" required>
                            @error('modelo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Marca -->
                        <div class="mb-3">
                            <label for="marca" class="form-label fw-bold">
                                <i class="fas fa-shield-alt"></i> Marca *
                            </label>
                            <input type="text" class="form-control @error('marca') is-invalid @enderror" 
                                   id="marca" name="marca" placeholder="Ej: Nike" value="{{ old('marca') }}" required>
                            @error('marca')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Categoría -->
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label fw-bold">
                                <i class="fas fa-list"></i> Categoría *
                            </label>
                            <select class="form-select @error('categoria_id') is-invalid @enderror" 
                                    id="categoria_id" name="categoria_id" required>
                                <option value="">-- Selecciona una categoría --</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Precio -->
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign"></i> Precio *
                                </label>
                                <input type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" 
                                       id="precio" name="precio" placeholder="99.99" value="{{ old('precio') }}" required>
                                @error('precio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold">
                                    <i class="fas fa-box"></i> Stock *
                                </label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" placeholder="0" value="{{ old('stock') }}" required>
                                @error('stock')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Talla -->
                            <div class="col-md-6 mb-3">
                                <label for="talla" class="form-label fw-bold">
                                    <i class="fas fa-ruler"></i> Talla (US) *
                                </label>
                                <input type="number" step="0.5" class="form-control @error('talla') is-invalid @enderror" 
                                       id="talla" name="talla" placeholder="10.5" value="{{ old('talla') }}" required>
                                @error('talla')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Color -->
                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label fw-bold">
                                    <i class="fas fa-palette"></i> Color *
                                </label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color', '#000000') }}" required>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                           id="colorName" placeholder="Nombre del color" value="{{ old('color') }}" disabled>
                                </div>
                                @error('color')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">
                                <i class="fas fa-pen"></i> Descripción *
                            </label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="4" 
                                      placeholder="Escribe una descripción detallada del producto..." required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Imagen -->
                        <div class="mb-4">
                            <label for="imagen" class="form-label fw-bold">
                                <i class="fas fa-image"></i> Imagen del Producto
                            </label>
                            <div class="input-group mb-2">
                                <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                                       id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)">
                                <small class="form-text text-muted d-block">Formatos: JPEG, PNG, JPG, WEBP (Máx: 2MB)</small>
                            </div>
                            <div id="imagePreview" class="mt-2"></div>
                            @error('imagen')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="card border-2 border-success">
                    <img src="${e.target.result}" alt="Preview" class="card-img-top" style="height: 300px; object-fit: cover;">
                    <div class="card-body">
                        <small class="text-muted">Nombre: ${file.name}</small><br>
                        <small class="text-muted">Tamaño: ${(file.size / 1024).toFixed(2)} KB</small>
                    </div>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

// Actualizar nombre de color
document.getElementById('color').addEventListener('change', function() {
    const colorCode = this.value.toUpperCase();
    document.getElementById('colorName').value = colorCode;
});

// Inicializar color
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('colorName').value = document.getElementById('color').value.toUpperCase();
});
</script>

<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .form-label {
        color: #333;
        margin-bottom: 0.5rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection
