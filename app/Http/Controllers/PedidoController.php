<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Venta;

class PedidoController extends Controller
{
    /**
     * Muestra la lista de pedidos del usuario autenticado.
     */
    public function index()
    {
        $cliente = Auth::user()->cliente;

        if (!$cliente) {
            return redirect()->route('home')->with('error', 'No se encontró información del cliente.');
        }

        // Obtener las ventas (pedidos) del cliente, más recientes primero
        $ventas = $cliente->ventas()->latest()->get();

        return view('pedidos.index', compact('ventas'));
    }

    /**
     * Muestra el detalle de un pedido específico.
     */
    public function show(Venta $venta)
    {
        $cliente = Auth::user()->cliente;

        if (!$cliente || $venta->cliente_id !== $cliente->id) {
            abort(403, 'No tienes permiso para ver este pedido.');
        }

        // El modelo Venta debe tener relación con DetalleVenta y Producto
        $venta->load('detalle_venta.producto');

        return view('pedidos.show', compact('venta'));
    }

    /**
     * (Opcional) Guardar un nuevo pedido si se requiere desde otro flujo.
     */
    public function store(Request $request)
    {
        // Este método puede quedar vacío si ya usas carrito.finalizar
    }

    public function descargarBoleta(Venta $venta)
    {
        $cliente = Auth::user()->cliente;

        if (!$cliente || $venta->cliente_id !== $cliente->id) {
            abort(403, 'No autorizado.');
        }

        $venta->load('detalle_venta.producto');

        $pdf = PDF::loadView('pedidos.boleta', [
            'venta' => $venta,
            'cliente' => $cliente,
            'empresa' => 'PANADERÍA DELICIA',
        ]);

        return $pdf->download('boleta_pedido_' . $venta->id . '.pdf');
    }

}
