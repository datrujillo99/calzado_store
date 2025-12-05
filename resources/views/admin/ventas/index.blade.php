@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-file-invoice-dollar"></i> Gestionar Ventas</h2>
        <span class="badge bg-dark">Total: {{ count($ventas) ?? 0 }}</span>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>¡Éxito!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-list"></i> Listado de Ventas
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="8%">ID</th>
                            <th width="20%">Cliente</th>
                            <th width="15%">Fecha</th>
                            <th width="12%">Total</th>
                            <th width="15%">Estado</th>
                            <th width="15%">Items</th>
                            <th width="15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventas as $venta)
                            <tr>
                                <td><strong>#{{ $venta->id }}</strong></td>
                                <td>{{ $venta->user->name }}</td>
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
                                <td colspan="7" class="text-center text-muted py-4">
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
    <div class="d-flex justify-content-center mt-4">
        {{ $ventas->links() }}
    </div>
</div>
@endsection
