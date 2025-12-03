@extends('layouts.app')

@section('content')
<div class="container-fluid px-4"> {{-- Container fluido para aprovechar el ancho de pantalla --}}
    
    {{-- Título Principal --}}
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Catálogo de Calzado</h1>
        <p class="text-muted">Calidad y estilo en cada paso</p>
    </div>

    {{-- Mensajes de Éxito (Eliminar/Actualizar) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show container" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- ========================================== --}}
        {{-- COLUMNA IZQUIERDA: MENÚ LATERAL (FILTROS)  --}}
        {{-- ========================================== --}}
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="bi bi-funnel"></i> Filtrar por Categoría
                </div>
                <ul class="list-group list-group-flush">
                    {{-- Opción para quitar filtros --}}
                    <li class="list-group-item">
                        <a href="{{ route('catalogo') }}" class="text-decoration-none text-dark d-block py-1">
                            Ver Todo el Catálogo
                        </a>
                    </li>
                    
                    {{-- Categorías Dinámicas --}}
                    @foreach($categorias as $cat)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('catalogo', ['categoria_id' => $cat->id]) }}" 
                               class="text-decoration-none {{ request('categoria_id') == $cat->id ? 'fw-bold text-primary' : 'text-secondary' }}">
                                {{ $cat->nombre }}
                            </a>
                            {{-- Contador de zapatos por categoría (opcional si lo soportas en el modelo) --}}
                            @if(isset($cat->calzados_count))
                                <span class="badge bg-light text-dark border">{{ $cat->calzados_count }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- COLUMNA DERECHA: GRILLA DE PRODUCTOS       --}}
        {{-- ========================================== --}}
        <div class="col-md-9">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                
                @forelse($calzados as $zapato)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 transition-hover">
                            
                            {{-- Imagen del Producto --}}
                            <div style="height: 250px; overflow: hidden; position: relative;">
                                @if($zapato->imagen)
                                    <img src="{{ asset('storage/' . $zapato->imagen) }}" class="card-img-top w-100 h-100" style="object-fit: cover;" alt="{{ $zapato->modelo }}">
                                @else
                                    <img src="https://via.placeholder.com/300x250?text=Sin+Foto" class="card-img-top w-100 h-100 bg-secondary" style="object-fit: cover;">
                                @endif
                                
                                {{-- Etiqueta de Categoría Flotante --}}
                                <span class="position-absolute top-0 end-0 bg-dark text-white px-2 py-1 m-2 rounded small opacity-75">
                                    {{ $zapato->categoria->nombre ?? 'General' }}
                                </span>
                            </div>

                            {{-- Información del Producto --}}
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark">{{ $zapato->marca }} {{ $zapato->modelo }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($zapato->descripcion, 60) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="h4 mb-0 text-success fw-bold">${{ number_format($zapato->precio, 2) }}</span>
                                    <span class="badge bg-light text-dark border">Talla: {{ $zapato->talla }}</span>
                                </div>
                                <div class="mt-2 text-muted small">
                                    Stock: 
                                    <span class="{{ $zapato->stock > 0 ? 'text-success' : 'text-danger fw-bold' }}">
                                        {{ $zapato->stock > 0 ? $zapato->stock . ' disponibles' : 'Agotado' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Botones de Acción (Footer) --}}
                            <div class="card-footer bg-white border-top-0 pb-3">
                                @if(Auth::check() && Auth::user()->role == 'admin')
                                    {{-- VISTA DE ADMINISTRADOR --}}
                                    <div class="d-grid gap-2 d-md-flex">
                                        <a href="{{ route('calzados.edit', $zapato->id) }}" class="btn btn-warning btn-sm flex-grow-1">
                                            ✏️ Editar
                                        </a>
                                        
                                        <form action="{{ route('calzados.destroy', $zapato->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    {{-- VISTA DE CLIENTE / INVITADO --}}
                                    <div class="d-grid">
                                        {{-- Apuntamos a la ruta SHOW para ver el detalle completo --}}
                                        <a href="{{ route('calzados.show', $zapato->id) }}" class="btn btn-outline-dark">
                                            Ver Detalles
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Estado Vacío --}}
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <span class="display-1">👟</span>
                        </div>
                        <h3 class="text-muted">No se encontraron zapatos en esta categoría.</h3>
                        <p class="text-muted">Intenta seleccionar otra categoría o ver todo el catálogo.</p>
                        <a href="{{ route('catalogo') }}" class="btn btn-primary mt-3">Ver todo el catálogo</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection