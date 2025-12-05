@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-file-invoice-dollar"></i> Detalle de Venta #{{ $venta->id }}</h2>
        <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>¡Éxito!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Información de la Venta -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-info-circle"></i> Información de la Venta
                </div>
                <div class="card-body">
                    <p><strong>ID Venta:</strong> #{{ $venta->id }}</p>
                    <p><strong>Cliente:</strong> {{ $venta->user->name }}</p>
                    <p><strong>Email:</strong> {{ $venta->user->email }}</p>
                    <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i:s') }}</p>
                    <p><strong>Total:</strong> <span class="text-success fw-bold">${{ number_format($venta->total, 2) }}</span></p>
                    <p>
                        <strong>Estado:</strong> 
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
                    </p>
                </div>
            </div>
        </div>

        <!-- Cambiar Estado -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-edit"></i> Cambiar Estado
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ventas.actualizar-estado', $venta->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="estado" class="form-label fw-bold">Seleccionar Nuevo Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="pendiente" @if($venta->estado === 'pendiente') selected @endif>Pendiente</option>
                                <option value="pagado" @if($venta->estado === 'pagado') selected @endif>Pagado</option>
                                <option value="enviado" @if($venta->estado === 'enviado') selected @endif>Enviado</option>
                                <option value="entregado" @if($venta->estado === 'entregado') selected @endif>Entregado</option>
                                <option value="cancelado" @if($venta->estado === 'cancelado') selected @endif>Cancelado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save"></i> Actualizar Estado
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles de Productos -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-box"></i> Productos en la Venta
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="35%">Producto</th>
                            <th width="15%">Precio Unit.</th>
                            <th width="15%">Cantidad</th>
                            <th width="25%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venta->detalles as $detalle)
                            <tr>
                                <td>#{{ $detalle->id }}</td>
                                <td>
                                    <strong>{{ $detalle->calzado->nombre ?? 'Producto no disponible' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $detalle->calzado->marca ?? 'N/A' }}</small>
                                </td>
                                <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td class="fw-bold">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light text-end">
            <h5>Total: <span class="text-success">${{ number_format($venta->total, 2) }}</span></h5>
        </div>
    </div>
</div>
@endsection
