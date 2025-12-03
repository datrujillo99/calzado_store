<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Campos que permitimos guardar en la base de datos
    protected $fillable = [
        'user_id',
        'fecha_venta',
        'estado',
        'total'
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'fecha_venta' => 'datetime',
        'total' => 'decimal:2',
    ];

    /* * ---------------------------------------------------------
     * RELACIONES
     * ---------------------------------------------------------
     */

    /**
     * Relación Inversa: Una venta pertenece a un solo usuario (Cliente).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación Uno a Muchos: Una venta tiene muchos detalles (Zapatos vendidos).
     */
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}