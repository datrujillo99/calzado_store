<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modern-design.css') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/modern-design.js') }}"></script>

    <script>
        // Función para manejar favoritos (cargar estado inicial)
        document.addEventListener('DOMContentLoaded', function() {
            const favoriteButtons = document.querySelectorAll('.favorite-btn');
            favoriteButtons.forEach(btn => {
                const productId = btn.dataset.productId;
                // Verificar si el producto está en favoritos
                fetch(`/favoritos/check/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if(data.isFavorite) {
                            btn.classList.add('favorited');
                            const icon = btn.querySelector('i');
                            if(icon) {
                                icon.classList.remove('far');
                                icon.classList.add('fas');
                            }
                        }
                    })
                    .catch(error => console.error('Error checking favorite:', error));
            });
        });

        // Función global para toggle de favoritos
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
                    const icon = button.querySelector('i');
                    if(icon) {
                        if(button.classList.contains('favorited')) {
                            icon.classList.remove('far');
                            icon.classList.add('fas');
                        } else {
                            icon.classList.remove('fas');
                            icon.classList.add('far');
                        }
                    }
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

        // Función para mostrar notificaciones Toast
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
                z-index: 9999;
                animation: slideIn 300ms ease-out;
                max-width: 300px;
                font-weight: 500;
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            
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
    </style>

</head>
<body>
    <div id="app" class="d-flex">
        <!-- SIDEBAR -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>
                    <i class="fas fa-shoe-prints"></i> CALZADO STORE
                </h3>
                <button class="btn-close-sidebar d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <ul class="nav flex-column">
                @if (!auth()->check() || auth()->user()->role !== 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalogo') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalogo') }}">
                            <i class="fas fa-shoe-prints"></i> Catálogo
                        </a>
                    </li>
                @endif

                @auth
                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.ventas.index') }}">
                                <i class="fas fa-file-invoice-dollar"></i> Ventas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('calzados.index') }}">
                                <i class="fas fa-shoe-prints"></i> Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clientes.index') }}">
                                <i class="fas fa-users"></i> Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categorias.index') }}">
                                <i class="fas fa-tags"></i> Categorías
                            </a>
                        </li>
                    @endif
                @endauth

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carrito.index') }}">
                        <i class="fas fa-shopping-cart"></i> Carrito
                        @php
                            $carritoCount = session('carrito') ? count(session('carrito')) : 0;
                        @endphp
                        @if ($carritoCount > 0)
                            <span class="badge bg-danger ms-2">{{ $carritoCount }}</span>
                        @endif
                    </a>
                </li>
                @endauth
            </ul>
        </nav>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="main-content">
            <!-- HEADER -->
            <header class="header">
                <div class="container-fluid" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 0;">
                    <!-- Header Left: Hamburger Menu -->
                    <div class="header-left d-md-none">
                        <button class="btn btn-link" onclick="toggleSidebar()" style="color: white; text-decoration: none; font-size: 1.5rem; border: none; background: none;">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <!-- Header Center: Search -->
                    <div class="header-center">
                        <div class="search-container">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" placeholder="Buscar productos..." id="searchInput">
                        </div>
                    </div>

                    <!-- Header Right: User Info / Auth Buttons -->
                    <div class="header-right">
                        @auth
                            <div class="user-menu-dropdown">
                                <button class="user-info" onclick="toggleUserMenu()">
                                    <i class="fas fa-user-circle"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <ul class="user-dropdown-menu" id="userDropdown">
                                    <li><a href="{{ route('perfil.index') }}"><i class="fas fa-user"></i> Mi Perfil</a></li>
                                    <li><a href="{{ route('ventas.cliente') }}"><i class="fas fa-history"></i> Mis Compras</a></li>
                                    <li><a href="{{ route('favoritos.index') }}"><i class="fas fa-heart"></i> Favoritos</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        @else
                            <div class="auth-buttons">
                                <a href="{{ route('login') }}" class="btn-auth btn-login">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                                </a>
                                <a href="{{ route('register') }}" class="btn-auth btn-register">
                                    <i class="fas fa-user-plus"></i> Registrarse
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- CONTENIDO -->
            <main style="padding: var(--spacing-xl); background: var(--light-gray); min-height: calc(100vh - var(--header-height));">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Cerrar menús al hacer click afuera
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu-dropdown');
            if (userMenu && !userMenu.contains(event.target)) {
                document.getElementById('userDropdown').classList.remove('show');
            }
        });

        // Cerrar sidebar al hacer click en un enlace (en móvil)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    document.getElementById('sidebar').classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>