<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calzado;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;
        foreach($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return view('carrito.index', compact('carrito', 'total'));
    }

    public function agregar(Request $request, $id)
    {
        $calzado = Calzado::findOrFail($id);

        if ($calzado->stock < 1) {
            return back()->with('error', 'Lo sentimos! Este producto está agotado.');
        }

        $carrito = session()->get('carrito', []);

        if(isset($carrito[$id])) {
            if($carrito[$id]['cantidad'] + 1 > $calzado->stock) {
                return back()->with('error', 'No hay suficiente stock disponible.');
            }
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                "modelo" => $calzado->modelo,
                "marca" => $calzado->marca,
                "cantidad" => 1,
                "precio" => $calzado->precio,
                "imagen" => $calzado->imagen
            ];
        }

        session()->put('carrito', $carrito);
        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function eliminar($id)
    {
        $carrito = session()->get('carrito');
        if(isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return back()->with('success', 'Carrito vaciado.');
    }

    public function procesarPedido()
    {
        $carrito = session()->get('carrito');

        if(!$carrito) {
            return back()->with('error', 'El carrito está vacío.');
        }

        try {
            DB::beginTransaction();

            $venta = Venta::create([
                'user_id' => Auth::id(),
                'fecha_venta' => now(),
                'estado' => 'pagado',
                'total' => 0
            ]);

            $totalVenta = 0;

            foreach($carrito as $id => $item) {
                $calzado = Calzado::lockForUpdate()->find($id);
                
                if ($calzado->stock < $item['cantidad']) {
                    throw new \Exception("El producto {$calzado->modelo} ya no tiene stock suficiente.");
                }

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'calzado_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['precio'] * $item['cantidad']
                ]);

                $calzado->decrement('stock', $item['cantidad']);
                $totalVenta += ($item['precio'] * $item['cantidad']);
            }

            $venta->update(['total' => $totalVenta]);
            DB::commit();
            
            session()->forget('carrito');

            return redirect()->route('catalogo')->with('success', '¡Compra realizada con éxito! Tu pedido es el #' . $venta->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }
}


