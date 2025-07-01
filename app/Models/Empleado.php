<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Empleado extends Authenticatable
{
    use Notifiable;

    protected $table = 'empleados';

    protected $fillable = [
        'nombre', 'apellido', 'usuario', 'password', 'rol', 'email', 'telefono', 'direccion', 'fecha_ingreso', 'estado', 'observaciones'
    ];

    protected $hidden = [
        'password',
    ];

    // Sobrescribe para autenticación con usuario en vez de email
    public function getAuthIdentifierName()
    {
        return 'usuario';
    }

    // Relación: Empleado puede tener muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'empleado_id');
    }
}
