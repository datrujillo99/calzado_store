@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('ventas.cliente') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Volver a Mis Compras
            </a>
            <h1 class="display-4 fw-bold">
                <i class="fas fa-file-invoice"></i> Detalles del Pedido #{{ $venta->id }}
            </h1>
        </div>
    </div>

    <div class="row">
        <!-- Información de la compra -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white p-4">
                    <h5 class="mb-0">Información del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted small">Número de Pedido</p>
                            <h6 class="fw-bold">#{{ $venta->id }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small">Fecha de Compra</p>
                            <h6 class="fw-bold">{{ $venta->fecha_venta->format('d/m/Y H:i') }}</h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted small">Estado</p>
                            <span class="badge 
                                @if($venta->estado === 'pagado') bg-success
                                @elseif($venta->estado === 'pendiente') bg-warning
                                @elseif($venta->estado === 'cancelado') bg-danger
                                @else bg-secondary
                                @endif
                                fs-6">
                                {{ ucfirst($venta->estado) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos comprados -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light p-4">
                    <h5 class="mb-0">Artículos Comprados</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Precio Unit.</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($venta->detalles as $detalle)
                                <tr>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">
                                            @if ($detalle->calzado && $detalle->calzado->imagen)
                                                <img src="{{ asset('storage/' . $detalle->calzado->imagen) }}" 
                                                     alt="{{ $detalle->calzado->modelo }}" 
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <div style="width: 60px; height: 60px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-shoe-prints text-secondary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="mb-1 fw-bold">
                                                    @if($detalle->calzado)
                                                        {{ $detalle->calzado->modelo }}
                                                    @else
                                                        Producto eliminado
                                                    @endif
                                                </p>
                                                @if($detalle->calzado)
                                                    <small class="text-muted">{{ $detalle->calzado->marca }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($detalle->precio_unitario, 2, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $detalle->cantidad }}</span>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($detalle->subtotal, 2, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Resumen de compra -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-header bg-success text-white p-4">
                    <h5 class="mb-0">Resumen de Compra</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Cantidad de artículos:</span>
                            <strong>{{ $venta->detalles->sum('cantidad') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>${{ number_format($venta->total * 0.85, 2, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Impuesto (16%):</span>
                            <strong>${{ number_format($venta->total * 0.15, 2, ',', '.') }}</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">Total:</h5>
                        <h5 class="mb-0 text-success">${{ number_format($venta->total, 2, ',', '.') }}</h5>
                    </div>
                </div>

                <div class="card-footer bg-light p-3">
                    <div class="alert alert-info small mb-0" role="alert">
                        <i class="fas fa-info-circle"></i>
                        <strong>Pedido confirmado</strong><br>
                        Recibirás detalles de seguimiento por correo electrónico.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .sticky-top {
        position: sticky;
        top: 100px;
    }

    @media (max-width: 991px) {
        .sticky-top {
            position: static;
        }
    }
</style>
@endsection
