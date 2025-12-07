<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class AdminVentaController extends Controller
{
    // Proteger las rutas: Solo administradores
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Listar todas las ventas
    public function index(Request $request)
    {
        // Verificar si es admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso para acceder aquí.');
        }

        $query = Venta::with('user', 'detalles.calzado');

        // Filtro por rango de fechas
        if ($request->has('fecha_desde') && $request->fecha_desde != '') {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->has('fecha_hasta') && $request->fecha_hasta != '') {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Filtro por categoría (productos en la venta)
        if ($request->has('categoria_id') && $request->categoria_id != '') {
            $query->whereHas('detalles.calzado', function($q) use ($request) {
                $q->where('categoria_id', $request->categoria_id);
            });
        }

        $ventas = $query->latest()->paginate(15);

        // Calcular estadísticas
        $totalVendido = Venta::whereIn('estado', ['pagado', 'entregado'])
            ->sum('total');
        $totalVentas = Venta::count();
        $ventasPendientes = Venta::where('estado', 'pendiente')->count();

        // Obtener lista de categorías para el filtro
        $categorias = \App\Models\Categoria::all();

        return view('admin.ventas.index', compact('ventas', 'totalVendido', 'totalVentas', 'ventasPendientes', 'categorias'));
    }

    // Ver detalles de una venta
    public function show($id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso.');
        }

        $venta = Venta::with('user', 'detalles.calzado')->findOrFail($id);
        return view('admin.ventas.show', compact('venta'));
    }

    // Cambiar estado de una venta
    public function actualizarEstado(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso.');
        }

        $venta = Venta::findOrFail($id);
        
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,pagado,enviado,entregado,cancelado'
        ]);

        $venta->update($validated);
        return redirect()->route('admin.ventas.show', $id)->with('success', 'Estado actualizado.');
    }
}
