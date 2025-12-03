<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    // Campos permitidos para guardar
    protected $fillable = [
        'venta_id',
        'calzado_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    /* * ---------------------------------------------------------
     * RELACIONES
     * ---------------------------------------------------------
     */

    /**
     * Relación: Este detalle pertenece a una Venta específica.
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Relación: Este detalle corresponde a un Calzado específico.
     */
    public function calzado()
    {
        return $this->belongsTo(Calzado::class);
    }
}