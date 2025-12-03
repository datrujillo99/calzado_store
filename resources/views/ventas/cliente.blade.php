@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold">
                <i class="fas fa-history"></i> Mis Compras
            </h1>
            <p class="text-muted">Historial de tus pedidos realizados</p>
        </div>
    </div>

    @if ($ventas->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center">
                    <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Aún no tienes compras</h3>
                    <p class="text-muted mb-4">Comienza a comprar en nuestro catálogo y aquí verás tu historial.</p>
                    <a href="{{ route('catalogo') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-store"></i> Ir al catálogo
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach ($ventas as $venta)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 transition-all">
                        <div class="card-header bg-light p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <small class="text-muted">Pedido #{{ $venta->id }}</small>
                                    <p class="mb-0 fw-bold text-primary">Fecha: {{ $venta->fecha_venta->format('d/m/Y') }}</p>
                                </div>
                                <span class="badge 
                                    @if($venta->estado === 'pagado') bg-success
                                    @elseif($venta->estado === 'pendiente') bg-warning
                                    @elseif($venta->estado === 'cancelado') bg-danger
                                    @else bg-secondary
                                    @endif
                                ">
                                    {{ ucfirst($venta->estado) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="text-muted small mb-2">
                                <i class="fas fa-box"></i> {{ $venta->detalles->count() }} artículos
                            </p>

                            <div class="mb-3">
                                <small class="text-muted">Productos:</small>
                                <ul class="list-unstyled small mt-1">
                                    @foreach ($venta->detalles->take(3) as $detalle)
                                        <li class="mb-1">
                                            <i class="fas fa-shoe-prints"></i> 
                                            {{ $detalle->calzado->modelo ?? 'Producto eliminado' }}
                                            <span class="badge bg-light text-dark">{{ $detalle->cantidad }}x</span>
                                        </li>
                                    @endforeach
                                    @if ($venta->detalles->count() > 3)
                                        <li class="text-muted">
                                            <small>+{{ $venta->detalles->count() - 3 }} más...</small>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Total:</strong>
                                    <h5 class="mb-0 text-primary">
                                        ${{ number_format($venta->total, 2, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light p-3">
                            <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-sm btn-outline-primary w-100">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="row mt-4">
            <div class="col-12">
                {{ $ventas->links() }}
            </div>
        </div>
    @endif
</div>

<style>
    .transition-all {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
