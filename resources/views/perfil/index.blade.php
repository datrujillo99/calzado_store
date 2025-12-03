@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                    <h3 class="mb-0 text-white">
                        <i class="fas fa-user-circle me-2"></i>Mi Perfil
                    </h3>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Errores al actualizar:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Información Personal -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="fas fa-info-circle me-2" style="color: #ffc107;"></i>Información Personal
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nombre</label>
                                <p class="form-control-plaintext border-bottom pb-2">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Correo Electrónico</label>
                                <p class="form-control-plaintext border-bottom pb-2">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Acciones Rápidas -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="fas fa-bolt me-2" style="color: #ffc107;"></i>Acciones Rápidas
                        </h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('ventas.cliente') }}" class="btn btn-outline-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Ver mis compras
                            </a>
                            <a href="{{ route('calzados.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-shoe-prints me-2"></i>Continuar comprando
                            </a>
                        </div>
                    </div>

                    <hr>

                    <!-- Información de Cuenta -->
                    <div>
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="fas fa-cog me-2" style="color: #ffc107;"></i>Información de Cuenta
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Miembro desde</label>
                                <p class="text-dark fw-semibold">{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Última actualización</label>
                                <p class="text-dark fw-semibold">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Botones de Acción -->
                    <div class="d-flex gap-2 justify-content-end">
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                        <a href="{{ route('calzados.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>
@endsection
