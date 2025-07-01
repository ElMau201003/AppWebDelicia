<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    public $timestamps = false; // 👈 Evita insertar columnas de tiempo

    protected $fillable = [
        'user_id', 'nombre', 'apellido', 'email', 'telefono', 'direccion', 'dni', 'fecha_nacimiento', 'genero', 'estado', 'comentarios'
    ];

    // Relación: Cliente tiene muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    // Relacion: Cliente - usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
