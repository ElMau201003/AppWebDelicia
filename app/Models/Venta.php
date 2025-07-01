<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id', 'fecha', 'total', 'tipo_pago', 'numero_comprobante',
        'estado', 'observaciones', 'forma_entrega',
    ];

    // ✅ Cast para que 'fecha' sea un objeto Carbon
    protected $casts = [
        'fecha' => 'datetime',
    ];

    // Relacion cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Detalle de la venta
    public function detalle_venta()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}
