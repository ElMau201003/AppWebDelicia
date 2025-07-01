<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/pedido', [PedidoController::class, 'store'])->name('pedido.store');
    // RUTAS protegidas para pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{venta}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::get('/pedidos/{venta}/boleta', [PedidoController::class, 'descargarBoleta'])->name('pedidos.boleta');


});

// Productos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

// Carrito
Route::get('/carrito', [CarritoController::class, 'ver'])->name('carrito.ver');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito/cantidad', [CarritoController::class, 'cantidad'])->name('carrito.cantidad');
Route::post('/carrito/eliminar', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::post('/carrito/finalizar', [CarritoController::class, 'finalizar'])->name('carrito.finalizar');
