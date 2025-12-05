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
    public function index()
    {
        // Verificar si es admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso para acceder aquí.');
        }

        $ventas = Venta::with('user', 'detalles.calzado')->latest()->paginate(15);
        return view('admin.ventas.index', compact('ventas'));
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
