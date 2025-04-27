<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <h1>Carrito de Compras</h1>

    @if (session('success'))
        <p class="text-success">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p class="text-danger">{{ session('error') }}</p>
    @endif

    @if (isset($error))
        <p class="text-danger">{{ $error }}</p>
    @elseif ($cart && $cart->products->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            <form action="{{ route('cart.updateQuantity', ['productId' => $product->id, 'action' => 'decrease']) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">-</button>
                            </form>
                            {{ $product->pivot->quantity }}
                            <form action="{{ route('cart.updateQuantity', ['productId' => $product->id, 'action' => 'increase']) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">+</button>
                            </form>
                        </td>
                        <td>${{ $product->price }}</td>
                        <td>${{ $product->price * $product->pivot->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>Total del carrito:</strong> ${{ $cart->products->sum(fn($product) => $product->price * $product->pivot->quantity) }}</p>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>
    @else
        <p>Tu carrito está vacío.</p>
    @endif
</body>
</html>
