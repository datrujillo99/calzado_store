@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Imagen del producto -->
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm">
                @if ($calzado->imagen)
                    <img src="{{ asset('storage/' . $calzado->imagen) }}" alt="{{ $calzado->modelo }}" class="card-img-top" style="height: 500px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                        <i class="fas fa-shoe-prints fa-5x text-secondary"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detalles del producto -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4">
                <!-- Categoría -->
                <span class="badge bg-warning text-dark mb-3">
                    <i class="fas fa-tag"></i> {{ $calzado->categoria->nombre ?? 'Sin categoría' }}
                </span>

                <!-- Modelo y Marca -->
                <h1 class="display-5 fw-bold mb-2">{{ $calzado->modelo }}</h1>
                <p class="text-muted fs-5 mb-3">
                    <strong>Marca:</strong> {{ $calzado->marca }}
                </p>

                <!-- Rating y reseñas -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <span class="text-muted">(25 reseñas)</span>
                    </div>
                </div>

                <!-- Precio -->
                <div class="mb-4 p-3 bg-light border-start border-warning border-4">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Precio</p>
                            <h2 class="text-primary fw-bold mb-0">${{ number_format($calzado->precio, 2, ',', '.') }}</h2>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Stock disponible</p>
                            @if ($calzado->stock > 0)
                                <span class="badge bg-success fs-6">{{ $calzado->stock }} unidades</span>
                            @else
                                <span class="badge bg-danger fs-6">Agotado</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Características -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p class="text-muted small">Talla</p>
                        <p class="fs-5 fw-bold">{{ $calzado->talla }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted small">Color</p>
                        <div class="d-flex gap-2 align-items-center">
                            <div style="width: 30px; height: 30px; background-color: {{ $calzado->color }}; border-radius: 50%; border: 2px solid #ddd;"></div>
                            <span class="fs-5">{{ $calzado->color }}</span>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <h5 class="fw-bold">Descripción</h5>
                    <p class="text-muted">{{ $calzado->descripcion }}</p>
                </div>

                <!-- Botones de acción -->
                <div class="d-grid gap-2 d-md-flex mb-4">
                    @if ($calzado->stock > 0)
                        <form action="{{ route('carrito.agregar', $calzado->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                <i class="fas fa-shopping-cart"></i> Agregar al carrito
                            </button>
                        </form>
                        <button class="btn btn-outline-danger btn-lg" type="button" id="btnFavorito">
                            <i class="fas fa-heart"></i>
                        </button>
                    @else
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-ban"></i> Producto no disponible
                        </button>
                    @endif
                </div>

                <!-- Información adicional -->
                <div class="alert alert-info d-flex gap-2" role="alert">
                    <i class="fas fa-truck mt-1"></i>
                    <div>
                        <strong>Envío gratis</strong> en compras mayores a $50
                    </div>
                </div>

                <!-- Admin actions -->
                @auth
                    @if (auth()->user()->is_admin)
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="fw-bold text-danger mb-3">Acciones de administrador</h6>
                            <div class="d-grid gap-2 d-md-flex">
                                <a href="{{ route('calzados.edit', $calzado->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('calzados.destroy', $calzado->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Productos relacionados -->
    @if ($categoriasRelacionadas->isNotEmpty())
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4">
                    <i class="fas fa-related"></i> Productos similares
                </h3>
            </div>
            @foreach ($categoriasRelacionadas as $relacionado)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 transition-all" style="transition: all 0.3s ease;">
                        <!-- Imagen -->
                        <div style="height: 250px; overflow: hidden;">
                            @if ($relacionado->imagen)
                                <img src="{{ asset('storage/' . $relacionado->imagen) }}" alt="{{ $relacionado->modelo }}" class="card-img-top" style="height: 100%; object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-shoe-prints fa-3x text-secondary"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold">{{ $relacionado->modelo }}</h6>
                            <p class="card-text text-muted small mb-2">{{ $relacionado->marca }}</p>

                            <div class="d-flex justify-content-between align-items-center mb-3 mt-auto">
                                <span class="fs-5 fw-bold text-primary">${{ number_format($relacionado->precio, 2, ',', '.') }}</span>
                                @if ($relacionado->stock > 0)
                                    <span class="badge bg-success">En stock</span>
                                @else
                                    <span class="badge bg-danger">Agotado</span>
                                @endif
                            </div>

                            <a href="{{ route('calzados.show', $relacionado->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-eye"></i> Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
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

    .card-img-top {
        transition: transform 0.3s ease;
    }
</style>
@endsection
