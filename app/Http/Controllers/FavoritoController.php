<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Calzado;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Agregar a favoritos
     */
    public function agregar($calzadoId)
    {
        $calzado = Calzado::findOrFail($calzadoId);
        
        // Verificar si ya está en favoritos
        $favorito = Favorito::where('user_id', auth()->id())
                            ->where('calzado_id', $calzadoId)
                            ->first();

        if (!$favorito) {
            Favorito::create([
                'user_id' => auth()->id(),
                'calzado_id' => $calzadoId
            ]);
            return response()->json(['success' => true, 'message' => 'Agregado a favoritos']);
        }

        return response()->json(['success' => false, 'message' => 'Ya está en favoritos']);
    }

    /**
     * Remover de favoritos
     */
    public function remover($calzadoId)
    {
        Favorito::where('user_id', auth()->id())
                ->where('calzado_id', $calzadoId)
                ->delete();

        return response()->json(['success' => true, 'message' => 'Removido de favoritos']);
    }

    /**
     * Ver favoritos del usuario
     */
    public function index()
    {
        $favoritos = Favorito::where('user_id', auth()->id())
                            ->with('calzado')
                            ->get();

        return view('favoritos.index', compact('favoritos'));
    }

    /**
     * Verificar si un producto está en favoritos
     */
    public function check($calzadoId)
    {
        $favorito = Favorito::where('user_id', auth()->id())
                           ->where('calzado_id', $calzadoId)
                           ->exists();

        return response()->json(['isFavorite' => $favorito]);
    }
}
