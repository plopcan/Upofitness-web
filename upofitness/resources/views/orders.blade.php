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
    <h1 class="mb-4">Tus Pedidos</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Total</th>
                <th>Estado</th>
                <th>Dirección</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->product->name ?? 'Producto eliminado o no disponible' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->total }} €</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->full_address }}</td>
                    <td>
    @if ($order->invoice)
        <a href="{{ route('invoices.show', ['id' => $order->invoice->id]) }}" class="btn btn-primary">
            Ver Factura
        </a>
    @else
        <span class="text-muted">Sin factura</span>
    @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No tienes pedidos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
