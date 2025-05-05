<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders by Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Orders by Users</h1>
    <a href="{{ route('welcome') }}" class="btn btn-secondary mb-3">Back to Home</a>

    @foreach ($orders as $user)
        <h2>Usuario: {{ $user->name }}</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user->orders as $order)
                    <tr>
                        <td>{{ $order->product->name ?? 'Product not available' }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->total }} €</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->full_address }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No orders for this user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>