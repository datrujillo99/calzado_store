@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">⚙️ Panel de Administración</h2>
        <span class="badge bg-dark">Bienvenido, {{ Auth::user()->name }}</span>
    </div>

    {{-- ========================================== --}}
    {{-- TARJETAS DE RESUMEN (ESTADÍSTICAS)         --}}
    {{-- ========================================== --}}
    <div class="row mb-4">
        <!-- Ventas -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-cart-check"></i> Ventas Totales</h5>
                    <p class="card-text display-6 fw-bold">{{ $totalVentas ?? 0 }}</p>
                </div>
            </div>
        </div>
        <!-- Ingresos -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-currency-dollar"></i> Ingresos</h5>
                    <p class="card-text display-6 fw-bold">${{ number_format($totalIngresos ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <!-- Productos -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3 shadow-sm h-100">
                <div class="card-body text-dark">
                    <h5 class="card-title"><i class="bi bi-box-seam"></i> Productos</h5>
                    <p class="card-text display-6 fw-bold">{{ $totalZapatos ?? 0 }}</p>
                </div>
            </div>
        </div>
        <!-- Clientes -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3 shadow-sm h-100">
                <div class="card-body text-dark">
                    <h5 class="card-title"><i class="bi bi-people"></i> Clientes</h5>
                    <p class="card-text display-6 fw-bold">{{ $totalClientes ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- BOTONES DE ACCIÓN RÁPIDA                   --}}
    {{-- ========================================== --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body bg-light d-flex gap-2 flex-wrap">
            
            {{-- Botón para ir a Productos --}}
            <a href="{{ route('calzados.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Agregar Nuevo Zapato
            </a>

            {{-- Botón para ir a Clientes (NUEVO) --}}
            <a href="{{ route('clientes.index') }}" class="btn btn-primary">
                <i class="bi bi-person-lines-fill"></i> Gestionar Clientes
            </a>

            {{-- Botón para ir a la Tienda --}}
            <a href="{{ route('catalogo') }}" class="btn btn-outline-dark ms-auto">
                <i class="bi bi-shop"></i> Ver Tienda
            </a>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- TABLA DE VENTAS RECIENTES                  --}}
    {{-- ========================================== --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">
            <i class="bi bi-clock-history"></i> Últimas Ventas Registradas
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventasRecientes as $venta)
                    <tr>
                        <td>#{{ $venta->id }}</td>
                        <td>{{ $venta->user->name }}</td>
                        <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td class="fw-bold">${{ number_format($venta->total, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $venta->estado == 'pagado' ? 'success' : 'secondary' }}">
                                {{ ucfirst($venta->estado) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Ver Detalle</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            No hay ventas registradas todavía.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection