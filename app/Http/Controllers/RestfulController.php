<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RestfulController extends Controller
{
    /**
     * Retorna una respuesta JSON exitosa
     */
    protected function successResponse($data, $message = 'Operación exitosa', $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Retorna una respuesta JSON de error
     */
    protected function errorResponse($message = 'Error en la operación', $code = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    /**
     * Retorna una respuesta paginada
     */
    protected function paginatedResponse($data, $message = 'Datos obtenidos correctamente', $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ],
        ], $code);
    }
}