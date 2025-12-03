@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold">
                <i class="fas fa-shopping-cart"></i> Mi Carrito
            </h1>
            <p class="text-muted">Revisa tus productos antes de comprar</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (empty($carrito))
        <!-- Carrito vacío -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Tu carrito está vacío</h3>
                    <p class="text-muted mb-4">¡Aún no tienes productos! Regresa al catálogo y comienza a comprar.</p>
                    <a href="{{ route('catalogo') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-store"></i> Ir al catálogo
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <!-- Tabla de productos -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-bottom p-3">
                        <h5 class="mb-0 fw-bold">Productos en tu carrito</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio unitario</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carrito as $id => $item)
                                    <tr class="align-middle">
                                        <td>
                                            <div class="d-flex gap-3 align-items-start">
                                                @if ($item['imagen'])
                                                    <img src="{{ asset('storage/' . $item['imagen']) }}" alt="{{ $item['modelo'] }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <div style="width: 80px; height: 80px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-shoe-prints fa-2x text-secondary"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="mb-1 fw-bold">{{ $item['modelo'] }}</p>
                                                    <p class="mb-0 text-muted small">{{ $item['marca'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($item['precio'], 2, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <div class="input-group" style="width: 120px;">
                                                <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                                                <input type="text" class="form-control form-control-sm text-center" value="{{ $item['cantidad'] }}" readonly>
                                                <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($item['precio'] * $item['cantidad'], 2, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <form action="{{ route('carrito.eliminar', $id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-light p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Continuar comprando
                                </a>
                                <form action="{{ route('carrito.vaciar') }}" method="POST" class="d-inline" onsubmit="return confirm('¿Deseas vaciar todo el carrito?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i> Vaciar carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de compra -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white p-3">
                        <h5 class="mb-0 fw-bold">Resumen de compra</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $subtotal = 0;
                            foreach($carrito as $item) {
                                $subtotal += $item['precio'] * $item['cantidad'];
                            }
                            $impuesto = $subtotal * 0.16;
                            $total = $subtotal + $impuesto;
                        @endphp

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <strong>${{ number_format($subtotal, 2, ',', '.') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Impuesto (16%):</span>
                                <strong>${{ number_format($impuesto, 2, ',', '.') }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">Total:</h5>
                                <h5 class="mb-0 text-primary">${{ number_format($total, 2, ',', '.') }}</h5>
                            </div>
                        </div>

                        <form action="{{ route('carrito.procesar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-2">
                                <i class="fas fa-lock"></i> Procesar compra
                            </button>
                        </form>

                        <div class="alert alert-info small mb-0" role="alert">
                            <i class="fas fa-info-circle"></i> <strong>Nota:</strong> Se requiere estar registrado para realizar la compra.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm text-center p-3">
                    <i class="fas fa-truck fa-2x text-primary mb-2"></i>
                    <h6 class="fw-bold">Envío gratis</h6>
                    <small class="text-muted">En compras mayores a $50</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm text-center p-3">
                    <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                    <h6 class="fw-bold">Compra segura</h6>
                    <small class="text-muted">Pagos verificados</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm text-center p-3">
                    <i class="fas fa-undo fa-2x text-primary mb-2"></i>
                    <h6 class="fw-bold">Devoluciones</h6>
                    <small class="text-muted">30 días garantía</small>
                </div>
            </div>
        </div>
    @endif
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
