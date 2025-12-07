@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0"><i class="fas fa-file-invoice-dollar"></i> Gestionar Ventas</h3>
        <span class="badge bg-dark">Total: {{ $totalVentas ?? 0 }}</span>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
            <strong>¡Éxito!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tarjetas de Estadísticas -->
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <div class="card border-left-primary shadow-sm" style="border-radius: 8px; padding: 0.75rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Total Vendido</p>
                        <h5 class="fw-bold text-primary mb-0">${{ number_format($totalVendido, 2) }}</h5>
                    </div>
                    <i class="fas fa-money-bill-wave fa-lg text-primary" style="opacity: 0.3;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow-sm" style="border-radius: 8px; padding: 0.75rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Total de Ventas</p>
                        <h5 class="fw-bold text-success mb-0">{{ $totalVentas }}</h5>
                    </div>
                    <i class="fas fa-shopping-cart fa-lg text-success" style="opacity: 0.3;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-warning shadow-sm" style="border-radius: 8px; padding: 0.75rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Ventas Pendientes</p>
                        <h5 class="fw-bold text-warning mb-0">{{ $ventasPendientes }}</h5>
                    </div>
                    <i class="fas fa-hourglass-end fa-lg text-warning" style="opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros Compactos -->
    <div class="card shadow-sm mb-3" style="border-radius: 8px;">
        <div class="card-body p-2">
            <form method="GET" action="{{ route('admin.ventas.index') }}" class="row g-2 align-items-end">
                <div class="col-auto">
                    <small class="d-block text-muted">Categoría</small>
                    <select name="categoria_id" class="form-select form-select-sm" style="width: 150px;">
                        <option value="">Todas</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <small class="d-block text-muted">Desde</small>
                    <input type="date" name="fecha_desde" class="form-control form-control-sm" value="{{ request('fecha_desde') }}" style="width: 130px;">
                </div>
                <div class="col-auto">
                    <small class="d-block text-muted">Hasta</small>
                    <input type="date" name="fecha_hasta" class="form-control form-control-sm" value="{{ request('fecha_hasta') }}" style="width: 130px;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm" style="border-radius: 8px;">
        <div class="card-header bg-dark text-white py-2" style="border-radius: 8px 8px 0 0;">
            <i class="fas fa-list"></i> Listado de Ventas
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th width="8%">ID</th>
                            <th width="18%">Cliente</th>
                            <th width="15%">Fecha</th>
                            <th width="12%">Total</th>
                            <th width="15%">Estado</th>
                            <th width="10%">Items</th>
                            <th width="12%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventas as $venta)
                            <tr>
                                <td><strong>#{{ $venta->id }}</strong></td>
                                <td>{{ Str::limit($venta->user->name, 15) }}</td>
                                <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                <td class="fw-bold">${{ number_format($venta->total, 2) }}</td>
                                <td>
                                    @switch($venta->estado)
                                        @case('pendiente')
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                            @break
                                        @case('pagado')
                                            <span class="badge bg-success">Pagado</span>
                                            @break
                                        @case('enviado')
                                            <span class="badge bg-info">Enviado</span>
                                            @break
                                        @case('entregado')
                                            <span class="badge bg-primary">Entregado</span>
                                            @break
                                        @case('cancelado')
                                            <span class="badge bg-danger">Cancelado</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $venta->estado }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ count($venta->detalles) ?? 0 }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.ventas.show', $venta->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    <i class="fas fa-inbox"></i> No hay ventas registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-3">
        {{ $ventas->links() }}
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 4px solid #2563eb !important;
    }
    .border-left-success {
        border-left: 4px solid #10b981 !important;
    }
    .border-left-warning {
        border-left: 4px solid #f59e0b !important;
    }
    .card {
        border: 1px solid #e5e7eb;
    }
</style>
@endsection
