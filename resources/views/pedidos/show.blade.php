@extends('layouts.app')

@push('styles')
<style>
    .detalle-container {
        background-color: var(--color-blanco);
        padding: 2rem;
        border-radius: var(--borde-redondeado);
        box-shadow: var(--sombra);
        color: var(--color-texto);
    }

    .detalle-container h2 {
        color: var(--color-primario);
        margin-bottom: 1rem;
    }

    .detalle-info p {
        margin: 0.3rem 0;
        font-size: 1rem;
    }

    .detalle-info strong {
        color: var(--color-texto-claro);
    }

    .detalle-productos {
        margin-top: 1.5rem;
    }

    .detalle-productos table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .detalle-productos th, .detalle-productos td {
        border: 1px solid var(--color-gris);
        padding: 0.75rem;
        text-align: left;
    }

    .detalle-productos th {
        background-color: var(--color-secundario);
        color: var(--color-blanco);
    }

    .detalle-productos td {
        background-color: var(--color-fondo);
    }

    .btn-volver {
        margin-top: 1.5rem;
        background-color: var(--color-secundario);
        color: var(--color-blanco);
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: var(--borde-redondeado);
        transition: var(--transicion);
        text-decoration: none;
        display: inline-block;
    }

    .btn-volver:hover {
        background-color: var(--color-primario);
        box-shadow: var(--sombra-hover);
        color: white;
    }

    .btn-descargar {
        margin-top: 1.5rem;
        background-color: var(--color-primario);
        color: var(--color-blanco);
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: var(--borde-redondeado);
        transition: var(--transicion);
        text-decoration: none;
        display: inline-block;
    }

    .btn-descargar:hover {
        background-color: var(--color-secundario);
        box-shadow: var(--sombra-hover);
        color: white;
    }

</style>

@endpush

@section('content')

<div class="container detalle-container">
    <h2>Detalle del Pedido #{{ $venta->id }}</h2>

    <div class="detalle-info">
        <p><strong>Fecha:</strong> {{ $venta->fecha->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($venta->estado) }}</p>
        <p><strong>Forma de Entrega:</strong> {{ ucfirst($venta->forma_entrega) }}</p>
        @if ($venta->forma_entrega === 'delivery')
            <p><strong>Dirección:</strong> {{ $venta->observaciones }}</p>
        @endif
        <p><strong>Tipo de Pago:</strong> {{ ucfirst($venta->tipo_pago) }}</p>
        <p><strong>Total:</strong> S/ {{ number_format($venta->total, 2) }}</p>
    </div>

    <div class="detalle-productos">
        <h4>Productos:</h4>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalle_venta as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>S/ {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('pedidos.index') }}" class="btn-volver">← Volver a pedidos</a>
    <a href="{{ route('pedidos.boleta', $venta->id) }}" class="btn-descargar float-end">
        <i class="fas fa-file-pdf"></i> Descargar Boleta
    </a>


</div>
@endsection
