<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-0">
        <!-- Logo/Marca -->
        <a class="navbar-brand" href="{{ route('catalogo') }}">
            <i class="fas fa-shoe-prints"></i> CALZADO STORE
        </a>

        <!-- Botón toggle para móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido del navbar -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Enlaces principales (izquierda) -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('catalogo') }}">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalogo') }}">
                        <i class="fas fa-shoe-prints"></i> Catálogo
                    </a>
                </li>
                @auth
                    @if (auth()->user()->is_admin)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog"></i> Administración
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">
                                        <i class="fas fa-box"></i> Productos
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('calzados.index') }}">
                                                <i class="fas fa-list"></i> Ver Todos
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('calzados.create') }}">
                                                <i class="fas fa-plus-circle"></i> Agregar Producto
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">
                                        <i class="fas fa-tags"></i> Categorías
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('categorias.index') }}">
                                                <i class="fas fa-list"></i> Ver Todas
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('categorias.create') }}">
                                                <i class="fas fa-plus-circle"></i> Crear Categoría
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('clientes.index') }}">
                                        <i class="fas fa-users"></i> Clientes
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.ventas.index') }}">
                                        <i class="fas fa-file-invoice-dollar"></i> Ventas
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-chart-bar"></i> Reportes
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cogs"></i> Configuración
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Enlaces de usuario (derecha) -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- Carrito de compras -->
                <li class="nav-item me-2">
                    <a class="nav-link position-relative" href="{{ route('carrito.index') }}">
                        <i class="fas fa-shopping-cart"></i> Carrito
                        @php
                            $carritoCount = session('carrito') ? count(session('carrito')) : 0;
                        @endphp
                        @if ($carritoCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $carritoCount }}
                            </span>
                        @endif
                    </a>
                </li>

                @guest
                    <!-- Invitado -->
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary btn-sm text-white ms-2" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Registrarse
                            </a>
                        </li>
                    @endif
                @else
                    <!-- Usuario autenticado -->
                    <li class="nav-item dropdown">
                        <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('perfil.index') }}">
                                    <i class="fas fa-user"></i> Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ventas.cliente') }}">
                                    <i class="fas fa-history"></i> Mis Compras
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-heart"></i> Favoritos
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
