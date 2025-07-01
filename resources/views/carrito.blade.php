@extends('layouts.app')

@push('styles')
<style>
    h2 {
        color: #8C4303;
        margin-bottom: 24px;
        font-weight: bold;
        text-align: center;
    }

    .carrito-container {
        max-width: 1000px;
        margin: auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f0f0f0;
        color: #555;
        font-weight: 600;
        padding: 1rem;
    }

    .table tbody td {
        padding: 0.8rem;
        vertical-align: middle;
    }

    .table input[type="number"] {
        width: 70px;
        padding: 6px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .btn {
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        padding: 8px 14px;
    }

    .btn-secondary {
        background-color: #8C4303;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #a65405;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .alert {
        border-radius: 6px;
        padding: 10px 15px;
        margin-bottom: 20px;
    }

    .text-end {
        text-align: right;
    }

    .table tbody tr:hover {
        background-color: #fafafa;
    }

    /* Modal */
    .modal-content {
        border-radius: 12px;
    }

    .modal-header, .modal-footer {
        background-color: #f7f7f7;
        border: none;
    }

    .modal-title {
        color: #8C4303;
        font-weight: bold;
    }

    #deliveryWarning {
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }

        .btn {
            margin-top: 6px;
            width: 100%;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: stretch;
        }

        .d-flex.justify-content-between h4 {
            margin-bottom: 12px;
            text-align: center;
        }

        .text-end {
            text-align: center;
        }

}

</style>
@endpush

@section('content')
<div class="container carrito-container">
    <h2>Tu Carrito</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (count($carrito) > 0)
        {{-- Actualizar cantidades --}}
        <form action="{{ route('carrito.actualizar') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($carrito as $id => $item)
                            @php
                                $subtotal = $item['precio'] * $item['cantidad'];
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ e($item['nombre']) }}</td>
                                <td>S/ {{ number_format($item['precio'], 2) }}</td>
                                <td>
                                    <input type="number" name="cantidades[{{ $id }}]" value="{{ $item['cantidad'] }}" min="1" class="form-control">
                                </td>
                                <td>S/ {{ number_format($subtotal, 2) }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto('{{ $id }}')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total y actualizar --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <h4 class="mb-0">Total: S/ {{ number_format($total, 2) }}</h4>
                <button class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Actualizar Cantidades</button>
            </div>
        </form>

        {{-- Formulario oculto para eliminar --}}
        <form id="formEliminar" method="POST" action="{{ route('carrito.eliminar') }}" style="display: none;">
            @csrf
            <input type="hidden" name="producto_id" id="producto_id_eliminar">
        </form>

        {{-- Finalizar compra --}}
        <!-- BOTÓN que abre el modal -->
        <div class="mt-4 text-end">
            <button type="button" class="btn btn-success px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#finalizarModal">
                <i class="fas fa-shopping-cart me-2"></i> Finalizar Compra
            </button>
        </div>

        <!-- MODAL para finalizar compra -->
        <div class="modal fade" id="finalizarModal" tabindex="-1" aria-labelledby="finalizarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('carrito.finalizar') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Finalizar Compra</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Forma de entrega -->
                        <div class="mb-3">
                            <label class="form-label">Forma de Entrega</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="forma_entrega" id="entregaRecojo" value="recojo" checked>
                                <label class="form-check-label" for="entregaRecojo">Recojo en tienda</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="forma_entrega" id="entregaDelivery" value="delivery">
                                <label class="form-check-label" for="entregaDelivery">Delivery</label>
                            </div>
                            <div id="deliveryWarning" class="alert alert-warning mt-2" style="display:none;">
                                Se añadirá entre <strong>S/5 y S/10</strong> por costo de delivery. Se cobrará al momento de la entrega.
                            </div>
                        </div>

                        <!-- Dirección para delivery -->
                        <div class="mb-3" id="direccionContainer" style="display:none;">
                            <label class="form-label">Dirección de entrega</label>
                            <select name="direccion_opcion" id="direccionOpcion" class="form-select">
                                <option value="guardada">Usar dirección guardada</option>
                                <option value="otra">Escribir otra dirección</option>
                            </select>

                            <div id="otraDireccionBox" class="mt-2" style="display:none;">
                                <input type="text" name="otra_direccion" class="form-control" placeholder="Nueva dirección...">
                            </div>
                        </div>

                        <!-- Tipo de pago -->
                        <div class="mb-3">
                            <label class="form-label">Tipo de pago</label>
                            <select name="tipo_pago" class="form-select" required>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirmar Compra</button>
                    </div>
                </div>
            </form>
        </div>
        </div>


    @else
        <p class="text-center text-muted fs-5">🛒 Tu carrito está vacío.</p>
    @endif
</div>
@endsection

@push('scripts')

<script>
    function eliminarProducto(productoId) {
        if (confirm('¿Eliminar este producto del carrito?')) {
            document.getElementById('producto_id_eliminar').value = productoId;
            document.getElementById('formEliminar').submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const entregaDelivery = document.getElementById('entregaDelivery');
        const entregaRecojo = document.getElementById('entregaRecojo');
        const direccionContainer = document.getElementById('direccionContainer');
        const deliveryWarning = document.getElementById('deliveryWarning');
        const direccionOpcion = document.getElementById('direccionOpcion');
        const otraDireccionBox = document.getElementById('otraDireccionBox');

        function toggleEntrega() {
            if (entregaDelivery.checked) {
                direccionContainer.style.display = 'block';
                deliveryWarning.style.display = 'block';
            } else {
                direccionContainer.style.display = 'none';
                deliveryWarning.style.display = 'none';
            }
        }

        function toggleDireccion() {
            otraDireccionBox.style.display = direccionOpcion.value === 'otra' ? 'block' : 'none';
        }

        entregaDelivery.addEventListener('change', toggleEntrega);
        entregaRecojo.addEventListener('change', toggleEntrega);
        direccionOpcion.addEventListener('change', toggleDireccion);

        toggleEntrega();
        toggleDireccion();
    });

</script>

@endpush
