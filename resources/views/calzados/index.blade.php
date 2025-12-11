@extends('layouts.app')

@section('content')
<div style="max-width: 1400px; margin: 0 auto;">
    <!-- Page Header -->
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="page-title">Catálogo de Calzado</h1>
            <p class="page-subtitle">Calidad y estilo en cada paso</p>
        </div>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="http://172.17.1.127:8000/listar-pistas.html" target="_blank" style="padding: 0.75rem 1.5rem; background: #8b5cf6; color: white; border: none; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 150ms; cursor: pointer;">
                <i class="fas fa-map"></i> Ir a Pistas
            </a>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('calzados.create') }}" style="padding: 0.75rem 1.5rem; background: #10b981; color: white; border: none; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 150ms;">
                    <i class="fas fa-plus-circle"></i> Agregar Producto
                </a>
            @endif
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div style="background: #d1fae5; border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: #065f46;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Filtros Horizontales -->
    <div style="margin-bottom: 2rem; display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
        <span style="font-weight: 600; color: #111827; font-size: 0.9rem;">Categorías:</span>
        
        <!-- All Products -->
        <a href="{{ route('catalogo') }}" 
           style="padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-size: 0.85rem; transition: all 150ms; {{ !request('categoria_id') ? 'background: #2563eb; color: white; border: 2px solid #2563eb;' : 'background: white; color: #111827; border: 1px solid #e5e7eb;' }} cursor: pointer;">
            <i class="fas fa-th"></i> Todos
        </a>
        
        <!-- Categories -->
        @foreach($categorias as $cat)
            <a href="{{ route('catalogo', ['categoria_id' => $cat->id]) }}" 
               style="padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-size: 0.85rem; transition: all 150ms; {{ request('categoria_id') == $cat->id ? 'background: #2563eb; color: white; border: 2px solid #2563eb;' : 'background: white; color: #111827; border: 1px solid #e5e7eb;' }} cursor: pointer;">
                {{ $cat->nombre }}
            </a>
        @endforeach
    </div>

    <!-- Products Grid -->
    <div style="width: 100%;">
            @forelse($calzados as $zapato)
                @if($loop->first)
                    <div class="products-grid">
                @endif
                
                <!-- Product Card -->
                <div class="product-card">
                    <!-- Image -->
                    <div class="product-image">
                        @if($zapato->imagen)
                            <img src="{{ asset('storage/' . $zapato->imagen) }}" alt="{{ $zapato->modelo }}" />
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                                👟
                            </div>
                        @endif
                        <span class="product-badge">{{ $zapato->categoria->nombre ?? 'General' }}</span>
                    </div>

                    <!-- Content -->
                    <div class="product-content">
                        <div class="product-category">{{ $zapato->marca }}</div>
                        <h3 class="product-title">{{ $zapato->modelo }}</h3>
                        <p class="product-description">{{ Str::limit($zapato->descripcion, 80) }}</p>
                        
                        <!-- Rating (optional) -->
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="product-rating-text">(45)</span>
                        </div>

                        <!-- Footer -->
                        <div class="product-footer">
                            <div class="product-price">
                                <span class="product-price-current">${{ number_format($zapato->precio, 2) }}</span>
                            </div>
                            <div class="product-stock" style="{{ $zapato->stock > 10 ? 'background: #e0f2fe; color: #0369a1;' : 'background: #fee2e2; color: #991b1b;' }}">
                                {{ $zapato->stock > 0 ? $zapato->stock . ' en stock' : 'Agotado' }}
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <div style="display: flex; gap: 0.5rem; padding: 1rem; border-top: 1px solid #e5e7eb; flex-wrap: wrap;">
                            <a href="{{ route('calzados.show', $zapato->id) }}" style="flex: 1; min-width: 100px; padding: 0.5rem; background: #3b82f6; color: white; border: none; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; font-size: 0.85rem; transition: all 150ms;">
                                👁️ Ver
                            </a>
                            <a href="{{ route('calzados.edit', $zapato->id) }}" style="flex: 1; min-width: 100px; padding: 0.5rem; background: #f59e0b; color: white; border: none; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; font-size: 0.85rem; transition: all 150ms;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('calzados.destroy', $zapato->id) }}" method="POST" style="flex: 1; min-width: 100px;" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width: 100%; padding: 0.5rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; transition: all 150ms; cursor: pointer;">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    @else
                        <button class="btn-add-cart" onclick="window.location.href='{{ route('calzados.show', $zapato->id) }}'">
                            <i class="fas fa-eye"></i> Ver Detalles
                        </button>
                    @endif
                </div>

                @if($loop->last)
                    </div>
                @endif
            @empty
                <!-- Empty State -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: 8px;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">👟</div>
                    <h3 style="color: #9ca3af; margin-bottom: 0.5rem;">No se encontraron zapatos</h3>
                    <p style="color: #9ca3af; margin-bottom: 1.5rem;">Intenta seleccionar otra categoría o ver todo el catálogo.</p>
                    <a href="{{ route('catalogo') }}" style="display: inline-block; background: #2563eb; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 150ms;">
                        Ver todo el catálogo
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        /* Filtros responsivos en móvil */
        div[style*="display: flex; gap: 0.75rem"] {
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }
    }
</style>
@endsection