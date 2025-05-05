<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upofitness - Factura</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalles de la Factura</h1>
        <button onclick="window.history.back()" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver atrás
        </button>
    </div>
    
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
            <td>
                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="pendiente" {{ $order->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en camino" {{ $order->status === 'en camino' ? 'selected' : '' }}>En camino</option>
                        <option value="entregado" {{ $order->status === 'entregado' ? 'selected' : '' }}>Entregado</option>
                    </select>
                </form>
            </td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td>{{ $order->full_address }}</td>
        </tr>
    </table>
    
    <div class="mt-4 text-center">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Imprimir Factura
        </button>
    </div>
</div>
</body>
</html>
