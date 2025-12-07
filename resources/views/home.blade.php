@extends('layouts.app')

@section('content')
<div style="max-width: 1400px; margin: 0 auto;">
    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); border-radius: 12px; padding: 4rem 2rem; margin-bottom: 3rem; color: white; text-align: center;">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Bienvenido a CALZADO STORE</h1>
        <p style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9;">Descubre la mejor colección de zapatos con estilo y calidad premium</p>
        <a href="{{ route('catalogo') }}" style="display: inline-block; background: white; color: #2563eb; padding: 0.75rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 700; transition: all 150ms;">
            Explorar Catálogo
        </a>
    </div>

    @if(Auth::check())
        <!-- Logged In View -->
        <div style="background: white; border-radius: 8px; padding: 2rem; border: 1px solid #e5e7eb; margin-bottom: 3rem;">
            <h2 style="color: #111827; font-weight: 700; margin-bottom: 1rem;">
                <i class="fas fa-user-circle"></i> Hola, {{ Auth::user()->name }}!
            </h2>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">Accede a tu cuenta para ver tus pedidos, perfil y preferencias.</p>

            <!-- Dashboard Links -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <!-- My Orders -->
                <a href="{{ route('ventas.cliente') }}" style="display: block; padding: 1.5rem; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 8px; border: 1px solid #bae6fd; text-decoration: none; transition: all 150ms;">
                    <div style="color: #0369a1; font-size: 1.5rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h3 style="color: #0369a1; font-weight: 600; margin-bottom: 0.5rem;">Mis Compras</h3>
                    <p style="color: #06b6d4; font-size: 0.9rem;">Revisa el historial de tus pedidos</p>
                </a>

                <!-- My Profile -->
                <a href="{{ route('perfil.index') }}" style="display: block; padding: 1.5rem; background: linear-gradient(135deg, #f0fdf4 0%, #dbeafe 100%); border-radius: 8px; border: 1px solid #bbf7d0; text-decoration: none; transition: all 150ms;">
                    <div style="color: #059669; font-size: 1.5rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 style="color: #059669; font-weight: 600; margin-bottom: 0.5rem;">Mi Perfil</h3>
                    <p style="color: #10b981; font-size: 0.9rem;">Actualiza tu información personal</p>
                </a>

                <!-- Shopping Cart -->
                <a href="{{ route('carrito.index') }}" style="display: block; padding: 1.5rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 8px; border: 1px solid #fcd34d; text-decoration: none; transition: all 150ms;">
                    <div style="color: #b45309; font-size: 1.5rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 style="color: #b45309; font-weight: 600; margin-bottom: 0.5rem;">Mi Carrito</h3>
                    <p style="color: #d97706; font-size: 0.9rem;">Revisa los artículos en tu carrito</p>
                </a>

                @if(Auth::user()->is_admin)
                    <!-- Admin Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 1.5rem; background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); border-radius: 8px; border: 1px solid #fbcfe8; text-decoration: none; transition: all 150ms;">
                        <div style="color: #be185d; font-size: 1.5rem; margin-bottom: 0.5rem;">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <h3 style="color: #be185d; font-weight: 600; margin-bottom: 0.5rem;">Panel Admin</h3>
                        <p style="color: #ec4899; font-size: 0.9rem;">Gestiona la tienda</p>
                    </a>
                @endif
            </div>
        </div>
    @else
        <!-- Guest View -->
        <div style="background: white; border-radius: 8px; padding: 2rem; border: 1px solid #e5e7eb; margin-bottom: 3rem;">
            <h2 style="color: #111827; font-weight: 700; margin-bottom: 1rem;">
                <i class="fas fa-lock"></i> Acceso a tu Cuenta
            </h2>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">Inicia sesión o crea una cuenta para acceder a todas las funcionalidades.</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <!-- Login Card -->
                <a href="{{ route('login') }}" style="display: block; padding: 2rem; background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 100%); border-radius: 8px; border: 2px solid #93c5fd; text-decoration: none; text-align: center; transition: all 150ms;">
                    <div style="color: #2563eb; font-size: 2rem; margin-bottom: 1rem;">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <h3 style="color: #2563eb; font-weight: 600; margin-bottom: 0.5rem;">Inicia Sesión</h3>
                    <p style="color: #1e40af; font-size: 0.9rem;">Accede a tu cuenta existente</p>
                </a>

                <!-- Register Card -->
                <a href="{{ route('register') }}" style="display: block; padding: 2rem; background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 8px; border: 2px solid #86efac; text-decoration: none; text-align: center; transition: all 150ms;">
                    <div style="color: #059669; font-size: 2rem; margin-bottom: 1rem;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 style="color: #059669; font-weight: 600; margin-bottom: 0.5rem;">Regístrate</h3>
                    <p style="color: #047857; font-size: 0.9rem;">Crea una cuenta nueva</p>
                </a>
            </div>
        </div>
    @endif

    <!-- Featured Products Section -->
    <div style="margin-bottom: 3rem;">
        <h2 style="color: #111827; font-weight: 700; margin-bottom: 1rem;">Productos Destacados</h2>
        <p class="page-subtitle" style="margin-bottom: 2rem;">Descubre nuestra selección especial de zapatos</p>

        <div class="products-grid">
            @php
                $featured = \App\Models\Calzado::limit(6)->get();
            @endphp

            @forelse($featured as $zapato)
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
                        
                        <!-- Rating -->
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

                    <!-- Action Button -->
                    <button class="btn-add-cart" onclick="window.location.href='{{ route('calzados.show', $zapato->id) }}'">
                        <i class="fas fa-eye"></i> Ver Detalles
                    </button>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <p style="color: #9ca3af;">No hay productos disponibles en este momento.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Stats Section -->
    <div style="background: white; border-radius: 8px; padding: 2rem; border: 1px solid #e5e7eb; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
        <div>
            <div style="font-size: 2rem; font-weight: 700; color: #2563eb; margin-bottom: 0.5rem;">1000+</div>
            <p style="color: #6b7280;">Productos en Catálogo</p>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; color: #059669; margin-bottom: 0.5rem;">5000+</div>
            <p style="color: #6b7280;">Clientes Satisfechos</p>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; color: #f59e0b; margin-bottom: 0.5rem;">24/7</div>
            <p style="color: #6b7280;">Atención al Cliente</p>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; color: #8b5cf6; margin-bottom: 0.5rem;">100%</div>
            <p style="color: #6b7280;">Garantía de Calidad</p>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        h1 {
            font-size: 1.75rem !important;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)) !important;
            gap: 12px !important;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)) !important;
            gap: 8px !important;
        }
    }
</style>
@endsection
