<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Detalles de la Factura</h1>
    <table class="table table-bordered">
        <tr>
            <th>Fecha de Emisión</th>
            <td>{{ $invoice->issue_date }}</td>
        </tr>
        <tr>
            <th>Porcentaje de Impuestos</th>
            <td>{{ $invoice->tax_percentage }}%</td>
        </tr>
        <tr>
            <th>Monto Total</th>
            <td>{{ $invoice->total_amount }} €</td>
        </tr>
    </table>
<h2 class="mt-4">Pedido Asociado</h2>
<table class="table table-bordered">
    <tr>
        <th>Producto</th>
        <td>{{ $order->product->name ?? 'Producto eliminado o no disponible' }}</td>
    </tr>
    <tr>
        <th>Cantidad</th>
        <td>{{ $order->quantity }}</td>
    </tr>
    <tr>
        <th>Precio Total</th>
        <td>{{ $order->total }} €</td>
    </tr>
    <tr>
        <th>Estado</th>
        <td>{{ $order->status }}</td>
    </tr>
    <tr>
        <th>Dirección</th>
        <td>{{ $order->full_address }}</td>
    </tr>
</table>
</div>
</body>
</html>
