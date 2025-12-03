@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- ALERTAS DE ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>¡No se pudo registrar!</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill"></i> Registrar Nuevo Cliente</h5>
                    <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-light text-primary fw-bold">
                        <i class="bi bi-arrow-left"></i> Volver a la Lista
                    </a>
                </div>

                <div class="card-body p-4">
                    {{-- FORMULARIO PARA GUARDAR CLIENTE (Ruta: clientes.store) --}}
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf

                        {{-- CAMPO: Nombre --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ej: Juan Pérez" required>
                        </div>

                        {{-- CAMPO: Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="cliente@ejemplo.com" required>
                        </div>

                        {{-- CAMPO: Contraseña --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                            <div class="form-text text-muted"><i class="bi bi-shield-lock"></i> Mínimo 8 caracteres.</div>
                        </div>

                        <hr>

                        {{-- BOTONES --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success fw-bold shadow-sm">
                                <i class="bi bi-save"></i> Guardar Cliente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection