@extends('layouts.app')

@push('styles')
<style>
    .card-pedidos {
        background-color: var(--color-blanco);
        border-radius: var(--borde-redondeado);
        box-shadow: var(--sombra);
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    .card-pedidos .card-header {
        background-color: var(--color-primario);
        color: var(--color-blanco);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .card-pedidos .card-header i {
        font-size: 1.5rem;
    }

    .alert-custom {
        background-color: var(--color-gris);
        border-left: 4px solid var(--color-secundario);
        padding: 1rem;
        border-radius: var(--borde-redondeado);
        margin-bottom: 1.5rem;
        color: var(--color-texto);
        font-size: 0.95rem;
    }

    .tabla-pedidos {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
        margin-top: 1rem;
    }

    .tabla-pedidos thead th {
        background-color: var(--color-secundario);
        color: var(--color-blanco);
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 0.95rem;
    }

    .tabla-pedidos tbody td {
        background-color: var(--color-fondo);
        padding: 0.75rem 1rem;
        color: var(--color-texto);
        border-bottom: 1px solid #eee;
        font-size: 0.95rem;
    }

    .tabla-pedidos tbody tr:hover td {
        background-color: #f8f9fa;
    }

    .badge-estado {
        padding: 0.4rem 0.75rem;
        border-radius: var(--borde-redondeado);
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
        text-align: center;
        min-width: 90px;
    }

    .bg-completado {
        background-color: #28a745;
        color: white;
    }

    .bg-pendiente {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-ver-detalle {
        background-color: transparent;
        border: 1px solid var(--color-primario);
        color: var(--color-primario);
        border-radius: var(--borde-redondeado);
        padding: 0.3rem 0.9rem;
        font-size: 0.85rem;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-ver-detalle:hover {
        background-color: var(--color-primario);
        color: var(--color-blanco);
        box-shadow: var(--sombra-hover);
    }

    @media (max-width: 768px) {
        .card-header h4 {
            font-size: 1.1rem;
        }

        .tabla-pedidos thead {
            display: none;
        }

        .tabla-pedidos tbody tr {
            display: block;
            margin-bottom: 1rem;
            border-radius: var(--borde-redondeado);
            box-shadow: var(--sombra);
        }

        .tabla-pedidos td {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border: none;
            background-color: var(--color-fondo);
            font-size: 0.9rem;
        }

        .tabla-pedidos td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-right: 0.5rem;
            color: var(--color-primario);
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="card-pedidos">
        <div class="card-header">
            <h4 class="mb-0">Mis Pedidos</h4>
            <i class="fas fa-clipboard-list"></i>
        </div>

        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert-custom">{{ session('success') }}</div>
            @endif

            @if ($ventas->isEmpty())
                <div class="alert-custom">No tienes pedidos registrados aún.</div>
            @else
                <div class="table-responsive">
                    <table class="tabla-pedidos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Pago</th>
                                <th>Entrega</th>
                                <th>Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventas as $venta)
                                <tr>
                                    <td data-label="#"> {{ $venta->id }}</td>
                                    <td data-label="Fecha">{{ $venta->fecha->format('d/m/Y H:i') }}</td>
                                    <td data-label="Total"><strong>S/ {{ number_format($venta->total, 2) }}</strong></td>
                                    <td data-label="Estado">
                                        <span class="badge-estado {{ $venta->estado === 'completado' ? 'bg-completado' : 'bg-pendiente' }}">
                                            {{ ucfirst($venta->estado) }}
                                        </span>
                                    </td>
                                    <td data-label="Pago">{{ ucfirst($venta->tipo_pago) }}</td>
                                    <td data-label="Entrega">{{ ucfirst($venta->forma_entrega) }}</td>
                                    <td data-label="Detalle">
                                        <a href="{{ route('pedidos.show', $venta->id) }}" class="btn-ver-detalle">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
