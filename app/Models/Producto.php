<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'categoria_id',
        'stock', 'imagen_url', 'peso', 'tiempo_preparacion',
        'estado', 'codigo_producto', 'fecha_creacion'
    ];

    // Relación con categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación con detalle_venta
    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }
}
