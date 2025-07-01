<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\User;
use App\Models\DetalleVenta;

class CarritoController extends Controller
{
    public function agregar(Request $request)
    {
        $productoId = $request->input('producto_id');
        $cantidad = $request->input('cantidad', 1);
        $producto = Producto::findOrFail($productoId);

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            $carrito[$productoId]['cantidad'] += $cantidad;
        } else {
            $carrito[$productoId] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => $cantidad,
            ];
        }

        session()->put('carrito', $carrito);

        return response()->json([
            'success' => true,
            'cantidad' => array_sum(array_column($carrito, 'cantidad')),
        ]);
    }

    public function cantidad()
    {
        $carrito = session()->get('carrito', []);
        return response()->json([
            'cantidad' => array_sum(array_column($carrito, 'cantidad')),
        ]);
    }

    public function ver()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito', compact('carrito'));
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('producto_id');
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.ver')->with('success', 'Producto eliminado');
    }

    public function actualizar(Request $request)
    {
        $cantidades = $request->input('cantidades', []);
        $carrito = session()->get('carrito', []);

        foreach ($cantidades as $id => $cantidad) {
            if (isset($carrito[$id])) {
                $carrito[$id]['cantidad'] = max(1, (int)$cantidad);
            }
        }

        session()->put('carrito', $carrito);
        return redirect()->route('carrito.ver')->with('success', 'Carrito actualizado');
    }

    public function finalizar(Request $request)
    {
        $carrito = session('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.ver')->with('error', 'El carrito está vacío.');
        }

        $user = Auth::user();
        $cliente = $user?->cliente;

        if (!$cliente) {
            return redirect()->route('carrito.ver')->with('error', 'No se encontró información del cliente.');
        }

        $total = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);

        $formaEntrega = $request->input('forma_entrega');
        $tipoPago = $request->input('tipo_pago');

        // Dirección de entrega
        $direccion = null;
        $costoDelivery = null;
        if ($formaEntrega === 'delivery') {
            $direccion = $request->direccion_opcion === 'otra'
                ? $request->otra_direccion
                : $cliente->direccion;

            // Costo aleatorio entre 5 y 10
            $costoDelivery = rand(5, 10);
            $total += $costoDelivery;
        }

        $venta = Venta::create([
            'cliente_id'         => $cliente->id,
            'fecha'              => now(),
            'total'              => $total,
            'tipo_pago'          => $tipoPago,
            'numero_comprobante' => 'VEN-' . now()->format('YmdHis'),
            'estado'             => 'completado',
            'observaciones'      => $direccion,
            'forma_entrega'      => $formaEntrega,
        ]);

        foreach ($carrito as $productoId => $item) {
            DetalleVenta::create([
                'venta_id'        => $venta->id,
                'producto_id'     => $productoId,
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $item['precio'],
            ]);
        }

        session()->forget('carrito');

        $mensaje = "Compra completada. Total: S/ " . number_format($total, 2);
        if ($costoDelivery) {
            $mensaje .= " (incluye S/{$costoDelivery} de delivery)";
        }

        return redirect()->route('carrito.ver')->with('success', $mensaje);
    }

}
