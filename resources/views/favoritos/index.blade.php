@extends('layouts.app')

@section('content')
<div style="max-width: 1400px; margin: 0 auto;">
    <!-- Page Header -->
    <div style="margin-bottom: 2rem;">
        <h1 class="page-title">Mis Favoritos</h1>
        <p class="page-subtitle">Tus productos favoritos guardados</p>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div style="background: #d1fae5; border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: #065f46;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Products Grid -->
    <div style="width: 100%;">
        @forelse($favoritos as $fav)
            @if($loop->first)
                <div class="products-grid">
            @endif
            
            <!-- Product Card -->
            <div class="product-card">
                <!-- Image -->
                <div class="product-image">
                    @if($fav->calzado->imagen)
                        <img src="{{ asset('storage/' . $fav->calzado->imagen) }}" alt="{{ $fav->calzado->modelo }}" />
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                            👟
                        </div>
                    @endif
                    <span class="product-badge">{{ $fav->calzado->categoria->nombre ?? 'General' }}</span>
                    <button class="favorite-btn favorited" onclick="toggleFavorite({{ $fav->calzado->id }}, this)" data-product-id="{{ $fav->calzado->id }}" title="Quitar de favoritos">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="product-content">
                    <div class="product-category">{{ $fav->calzado->marca }}</div>
                    <h3 class="product-title">{{ $fav->calzado->modelo }}</h3>
                    <p class="product-description">{{ Str::limit($fav->calzado->descripcion, 80) }}</p>
                    
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
                            <span class="product-price-current">${{ number_format($fav->calzado->precio, 2) }}</span>
                        </div>
                        <div class="product-stock" style="{{ $fav->calzado->stock > 10 ? 'background: #e0f2fe; color: #0369a1;' : 'background: #fee2e2; color: #991b1b;' }}">
                            {{ $fav->calzado->stock > 0 ? $fav->calzado->stock . ' en stock' : 'Agotado' }}
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <button class="btn-add-cart" onclick="window.location.href='{{ route('calzados.show', $fav->calzado->id) }}'">
                    <i class="fas fa-eye"></i> Ver Detalles
                </button>
            </div>

            @if($loop->last)
                </div>
            @endif
        @empty
            <!-- Empty State -->
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: 8px;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">💔</div>
                <h3 style="color: #9ca3af; margin-bottom: 0.5rem;">No tienes favoritos guardados</h3>
                <p style="color: #9ca3af; margin-bottom: 1.5rem;">Comienza a agregar productos que te gusten a tus favoritos.</p>
                <a href="{{ route('catalogo') }}" style="display: inline-block; background: #2563eb; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 150ms;">
                    Explorar Catálogo
                </a>
            </div>
        @endforelse
        </div>
    </div>
</div>

<script>
    // Cargar estado inicial de favoritos al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.favorite-btn');
        buttons.forEach(btn => {
            const productId = btn.dataset.productId;
            // Si el botón ya tiene la clase 'favorited', significa que ya está en favoritos
            // No necesitamos hacer nada más en el index de favoritos
        });
    });

    function toggleFavorite(productId, button) {
        event.preventDefault();
        event.stopPropagation();
        
        const isFavorited = button.classList.contains('favorited');
        const endpoint = isFavorited ? 'remover' : 'agregar';
        
        fetch(`/favoritos/${endpoint}/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                button.classList.toggle('favorited');
                
                // Si estamos en la página de favoritos y removemos un favorito, recargamos
                if(isFavorited && window.location.pathname === '/favoritos') {
                    setTimeout(() => {
                        window.location.reload();
                    }, 300);
                }
                
                // Mostrar notificación
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Error al procesar', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error al procesar la solicitud', 'error');
        });
    }

    function showToast(message, type = 'info') {
        // Crear el toast element
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${type === 'success' ? '#10b981' : '#ef4444'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            animation: slideIn 300ms ease-out;
            max-width: 300px;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            toast.style.animation = 'slideOut 300ms ease-out';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    @media (max-width: 768px) {
        div[style*="display: flex; gap: 0.75rem"] {
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }
    }
</style>
@endsection
