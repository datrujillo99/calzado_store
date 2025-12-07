<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- ZONA DE IMPORTACIONES (AQUÍ ESTABA EL ERROR) ---
use App\Http\Controllers\CalzadoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AdminVentaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ProductoRestfulService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. PÁGINA PRINCIPAL
Route::get('/', [CalzadoController::class, 'index'])->name('catalogo');

// 2. RUTAS DE AUTENTICACIÓN
Auth::routes();

// 3. CRUD DE PRODUCTOS (ZAPATOS)
Route::resource('calzados', CalzadoController::class);

// 4. CRUD DE CLIENTES (Ahora funcionará porque ya lo importamos arriba)
Route::resource('clientes', ClienteController::class);

// 4.5. CRUD DE CATEGORÍAS (Solo admin)
Route::resource('categorias', CategoriaController::class);

// 4.6. RUTAS DE VENTAS PARA ADMIN
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/ventas', [AdminVentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{id}', [AdminVentaController::class, 'show'])->name('ventas.show');
    Route::put('/ventas/{id}/estado', [AdminVentaController::class, 'actualizarEstado'])->name('ventas.actualizar-estado');
});
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

// 6. RUTA HOME
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 7. RUTAS DEL CARRITO
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
Route::post('/carrito/procesar', [CarritoController::class, 'procesarPedido'])->name('carrito.procesar');

// 8. RUTAS DE VENTAS Y PERFIL DEL CLIENTE (protegidas por auth)
Route::middleware('auth')->group(function () {
    Route::get('/mis-compras', [VentaController::class, 'clienteCompras'])->name('ventas.cliente');
    Route::get('/compra/{id}', [VentaController::class, 'show'])->name('ventas.show');
    Route::get('/perfil', function() {
        return view('perfil.index');
    })->name('perfil.index');
});

// 9. RUTAS DE FAVORITOS (protegidas por auth)
Route::middleware('auth')->group(function () {
    Route::post('/favoritos/agregar/{id}', [FavoritoController::class, 'agregar'])->name('favoritos.agregar');
    Route::post('/favoritos/remover/{id}', [FavoritoController::class, 'remover'])->name('favoritos.remover');
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
    Route::get('/favoritos/check/{id}', [FavoritoController::class, 'check'])->name('favoritos.check');
});

// 10. API RESTFUL PARA PRODUCTOS
Route::prefix('api/productos')->group(function () {
    Route::get('/', [ProductoRestfulService::class, 'listar'])->name('api.productos.listar');
    Route::get('/buscar', [ProductoRestfulService::class, 'buscar'])->name('api.productos.buscar');
    Route::get('/categoria/{id}', [ProductoRestfulService::class, 'listarPorCategoria'])->name('api.productos.categoria');
    Route::get('/{id}', [ProductoRestfulService::class, 'obtener'])->name('api.productos.obtener');
});