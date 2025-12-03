<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Calzado;
use App\Models\User;

class AdminController extends Controller
{
    // Proteger la ruta: Solo administradores pueden entrar aquí
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Verificamos si es admin (seguridad extra)
        if (auth()->user()->role !== 'admin') {
            return redirect('/calzados')->with('error', 'No tienes acceso al panel de administración.');
        }

        // Datos para el Dashboard (Resumen)
        $totalVentas = Venta::count();
        $totalIngresos = Venta::where('estado', 'pagado')->sum('total');
        $totalZapatos = Calzado::count();
        $totalClientes = User::where('role', 'cliente')->count();
        
        // Últimas 5 ventas para mostrar en la tabla
        $ventasRecientes = Venta::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalVentas', 'totalIngresos', 'totalZapatos', 'totalClientes', 'ventasRecientes'));
    }
}