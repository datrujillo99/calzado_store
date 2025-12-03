<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calzado extends Model
{
    use HasFactory;

    // AQUI AGREGAMOS TODOS LOS CAMPOS NUEVOS DE LA BASE DE DATOS
    protected $fillable = [
        'categoria_id', // Importante para la relación
        'modelo',
        'marca',
        'talla',
        'color',
        'precio',
        'stock',       // Nuevo
        'imagen',      // Nuevo
        'descripcion'  // Nuevo
    ];

    // Relación: Un Calzado pertenece a una Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}