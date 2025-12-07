<?php

namespace App\Http\Controllers;

use App\Models\Calzado;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CalzadoController extends Controller
{
    /**
     * Muestra el catálogo público.
     * Acepta un parámetro opcional ?categoria_id=X para filtrar.
     */
    public function index(Request $request)
    {
        // Iniciamos la consulta
        $query = Calzado::with('categoria');

        // Si el usuario seleccionó una categoría, filtramos
        if ($request->has('categoria_id') && $request->categoria_id != null) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Ordenar del más reciente al más antiguo
        $query->orderBy('created_at', 'desc');

        // Obtenemos los resultados y también las categorías para el menú lateral
        $calzados = $query->get();
        $categorias = Categoria::all();

        return view('calzados.index', compact('calzados', 'categorias'));
    }

    /**
     * Muestra los detalles de un calzado específico
     */
    public function show(string $id)
    {
        $calzado = Calzado::with('categoria')->findOrFail($id);
        $categoriasRelacionadas = Calzado::where('categoria_id', $calzado->categoria_id)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        return view('calzados.show', compact('calzado', 'categoriasRelacionadas'));
    }

    /**
     * Formulario para crear un nuevo calzado (solo admin)
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('calzados.create', compact('categorias'));
    }

    /**
     * Guardar un nuevo calzado en la BD
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'modelo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'talla' => 'required|integer',
            'color' => 'required|string',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ], [
            'imagen.mimes' => 'La imagen debe ser un archivo tipo: jpeg, png, jpg, webp.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
            'imagen.image' => 'El archivo subido no es una imagen válida.'
        ]);

        try {
            if ($request->hasFile('imagen')) {
                $datos['imagen'] = $request->file('imagen')->store('calzados', 'public');
            }

            Calzado::create($datos);

            return redirect()->route('calzados.index')->with('success', '¡Zapato registrado correctamente!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Formulario para editar un calzado
     */
    public function edit(string $id)
    {
        $calzado = Calzado::findOrFail($id);
        $categorias = Categoria::all();
        return view('calzados.edit', compact('calzado', 'categorias'));
    }

    /**
     * Actualizar un calzado en la BD
     */
    public function update(Request $request, string $id)
    {
        $calzado = Calzado::findOrFail($id);

        $datos = $request->validate([
            'modelo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'talla' => 'required|integer',
            'color' => 'required|string',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        try {
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($calzado->imagen && Storage::disk('public')->exists($calzado->imagen)) {
                    Storage::disk('public')->delete($calzado->imagen);
                }
                $datos['imagen'] = $request->file('imagen')->store('calzados', 'public');
            }

            $calzado->update($datos);

            return redirect()->route('calzados.index')->with('success', 'Zapato actualizado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Eliminar un calzado
     */
    public function destroy(string $id)
    {
        $calzado = Calzado::findOrFail($id);

        try {
            // Eliminar imagen si existe
            if ($calzado->imagen && Storage::disk('public')->exists($calzado->imagen)) {
                Storage::disk('public')->delete($calzado->imagen);
            }

            $calzado->delete();

            return redirect()->route('calzados.index')->with('success', 'Zapato eliminado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}