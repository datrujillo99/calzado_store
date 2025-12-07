<?php

namespace App\Http\Controllers;

use App\Models\Calzado;
use Illuminate\Http\Request;

class ProductoRestfulService extends RestfulController
{
    /**
     * Listar todos los productos
     */
    public function listar(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 15);
            $page = $request->query('page', 1);
            
            // Obtener productos con paginación
            $productos = Calzado::paginate($perPage, ['*'], 'page', $page);

            return $this->paginatedResponse(
                $productos,
                'Productos listados correctamente'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Error al listar productos: ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Listar productos por categoría
     */
    public function listarPorCategoria(Request $request, $categoriaId)
    {
        try {
            $perPage = $request->query('per_page', 15);
            
            $productos = Calzado::where('categoria_id', $categoriaId)
                ->paginate($perPage);

            return $this->paginatedResponse(
                $productos,
                'Productos por categoría listados correctamente'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Error al listar productos: ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Obtener un producto específico
     */
    public function obtener($id)
    {
        try {
            $producto = Calzado::findOrFail($id);

            return $this->successResponse(
                $producto,
                'Producto obtenido correctamente'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Producto no encontrado',
                404
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Error al obtener producto: ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Buscar productos por término
     */
    public function buscar(Request $request)
    {
        try {
            $termino = $request->query('q', '');
            $perPage = $request->query('per_page', 15);

            if (empty($termino)) {
                return $this->errorResponse('El término de búsqueda es requerido', 400);
            }

            $productos = Calzado::where('modelo', 'like', "%$termino%")
                ->orWhere('marca', 'like', "%$termino%")
                ->orWhere('color', 'like', "%$termino%")
                ->paginate($perPage);

            return $this->paginatedResponse(
                $productos,
                'Búsqueda completada correctamente'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Error en la búsqueda: ' . $e->getMessage(),
                500
            );
        }
    }
}
