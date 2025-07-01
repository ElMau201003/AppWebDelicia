<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta Electrónica - Pedido #{{ $venta->id }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            margin: 30px;
        }
        .center { text-align: center; }
        .separador { border-top: 1px dashed #000; margin: 10px 0; }
        .tabla { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabla th, .tabla td { border: 1px solid #000; padding: 5px; text-align: left; }
        .tabla th { background-color: #f0f0f0; }
        .totales td { border: none; }
        .small { font-size: 10px; }
    </style>
</head>
<body>

    <div class="center">
        <strong>{{ strtoupper($empresa) }}</strong><br>
        R.U.C. 20481234567<br>
        AV. PRINCIPAL 123 - CIUDAD DEMO - PAÍS<br><br>
        <strong>BOLETA ELECTRÓNICA</strong><br>
        B001-{{ str_pad($venta->id, 8, '0', STR_PAD_LEFT) }}
    </div>

    <br>

    <p><strong>Fecha de emisión:</strong> {{ $venta->fecha->format('d/m/Y') }}  
    <strong>Hora:</strong> {{ $venta->fecha->format('H:i:s') }}</p>
    <p><strong>Moneda:</strong> PEN &nbsp;&nbsp;&nbsp;&nbsp; 
    <strong>Tipo de Pago:</strong> {{ ucfirst($venta->tipo_pago) }}</p>
    <p><strong>Cliente:</strong> {{ $cliente->nombre }}  
    <strong>DNI:</strong> {{ $cliente->dni ?? '---------'}} </p>

    @if($venta->forma_entrega === 'delivery')
        <p><strong>Dirección de entrega:</strong> {{ $venta->observaciones }}</p>
    @endif

    <div class="separador"></div>

    <table class="tabla">
        <thead>
            <tr>
                <th>CANT.</th>
                <th>DESCRIPCIÓN</th>
                <th>P. UNIT (S/)</th>
                <th>IMPORTE (S/)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detalle_venta as $detalle)
                <tr>
                    <td>{{ number_format($detalle->cantidad, 3) }}</td>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    @php
        $op_exonerada = $venta->total; // todo exonerado si IGV está incluido y no separado
        $igv = 0.00;
        $total = $venta->total;
    @endphp

    <table class="tabla totales" style="width: 100%; margin-top: 10px;">
        <tr>
            <td style="text-align: right; width: 80%;"><strong>Op. Gravada:</strong></td>
            <td style="text-align: right;">S/ {{ number_format(0.00, 2) }}</td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong>Op. Exonerada:</strong></td>
            <td style="text-align: right;">S/ {{ number_format($op_exonerada, 2) }}</td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong>IGV (18%):</strong></td>
            <td style="text-align: right;">S/ {{ number_format($igv, 2) }}</td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong>Importe Total:</strong></td>
            <td style="text-align: right;"><strong>S/ {{ number_format($total, 2) }}</strong></td>
        </tr>
    </table>

    <br>

    <br><br>

    <div class="small center">
        Representación impresa de la BOLETA DE VENTA ELECTRÓNICA<br>
        Consulte documento en: www.tuempresa.pe/consultas<br>
        Autorizado mediante resolución Nro. 720050000110 / SUNAT
    </div>

</body>
</html>
