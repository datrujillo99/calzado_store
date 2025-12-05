<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Proteger las rutas: Solo administradores
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Listar todas las categorías
    public function index()
    {
        // Verificar si es admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso para acceder aquí.');
        }

        $categorias = Categoria::withCount('calzados')->paginate(10);
        return view('admin.categorias.index', compact('categorias'));
    }

    // Formulario para crear categoría
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso.');
        }
        return view('admin.categorias.create');
    }

    // Guardar nueva categoría
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
            'descripcion' => 'nullable|string'
        ]);

        Categoria::create($validated);
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    // Formulario para editar categoría
    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso.');
        }

        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    // Actualizar categoría
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso.');
        }

        $categoria = Categoria::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $id,
            'descripcion' => 'nullable|string'
        ]);

        $categoria->update($validated);
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    // Eliminar categoría
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/catalogo')->with('error', 'No tienes permiso.');
        }

        $categoria = Categoria::findOrFail($id);
        
        // Verificar si tiene productos
        if ($categoria->calzados()->count() > 0) {
            return redirect()->route('categorias.index')->with('error', 'No puedes eliminar una categoría que tiene productos.');
        }

        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
