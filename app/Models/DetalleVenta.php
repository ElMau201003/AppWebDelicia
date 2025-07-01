<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
    public $timestamps = false;

    protected $fillable = ['venta_id', 'producto_id', 'cantidad', 'precio_unitario'];


    // Relacion con venta
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    // Relacion con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
