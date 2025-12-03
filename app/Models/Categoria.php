<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Campos que permitimos llenar
    protected $fillable = ['nombre', 'descripcion'];

    // Relación: Una Categoría tiene muchos Calzados
    public function calzados()
    {
        return $this->hasMany(Calzado::class);
    }
}