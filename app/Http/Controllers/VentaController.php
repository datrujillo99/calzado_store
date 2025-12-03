<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    // Mostrar las compras del cliente autenticado
    public function clienteCompras()
    {
        $ventas = Venta::where('user_id', Auth::id())
            ->with('detalles.calzado')
            ->orderBy('fecha_venta', 'desc')
            ->paginate(10);

        return view('ventas.cliente', compact('ventas'));
    }

    // Mostrar detalle de una venta específica
    public function show($id)
    {
        $venta = Venta::with('detalles.calzado')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('ventas.show', compact('venta'));
    }
}
