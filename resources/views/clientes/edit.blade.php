@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- ALERTAS DE ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>¡Error al actualizar!</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square"></i> Editar Cliente: {{ $cliente->name }}</h5>
                    <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-dark text-white fw-bold">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card-body p-4">
                    {{-- FORMULARIO PARA ACTUALIZAR CLIENTE (Ruta: clientes.update) --}}
                    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- OBLIGATORIO PARA EDITAR --}}

                        {{-- CAMPO: Nombre --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $cliente->name) }}" required>
                        </div>

                        {{-- CAMPO: Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email) }}" required>
                        </div>

                        {{-- CAMPO: Nueva Contraseña --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nueva Contraseña (Opcional)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para mantener la actual">
                            </div>
                            <div class="form-text text-muted">Solo escribe aquí si deseas cambiarle la clave al cliente.</div>
                        </div>

                        <hr>

                        {{-- BOTONES --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning fw-bold shadow-sm">
                                <i class="bi bi-check-circle"></i> Actualizar Datos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection