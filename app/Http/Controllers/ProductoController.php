<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        // Recupera todos los productos activos
        $productos = Producto::where('estado', 'activo')->get();
        
        // Pasa la variable a la vista
        return view('productos', compact('productos'));
    }
}
