<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- ZONA DE IMPORTACIONES (AQUÍ ESTABA EL ERROR) ---
use App\Http\Controllers\CalzadoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController; // <--- ¡ESTA ES LA LÍNEA QUE FALTA!
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\VentaController;

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

// 5. PANEL DE ADMINISTRACIÓN
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