<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-3">
            <h1>Carrito de Compras</h1>
            <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver a la página principal</a>
        </div>

        @if (isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
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
            
            <!-- Después de la tabla de productos -->
            <div class="d-flex justify-content-center mt-4">
                {{ $cart->products->links() }}
            </div>
            
            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <h3>Finalizar Compra</h3>
                </div>
                <div class="card-body">
                    <!-- Formulario para validar código promocional -->
                    @if(!session('appliedPromoCode'))
                        <form action="{{ route('cart.apply-promo') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="promo_code" class="form-label">¿Tienes un código promocional?</label>
                                <div class="input-group">
                                    <input type="text" name="promo_code" id="promo_code" class="form-control" placeholder="Introduce tu código">
                                    <button type="submit" class="btn btn-outline-secondary">Aplicar</button>
                                </div>
                                @if(session('promo_message'))
                                    <small class="form-text {{ session('promo_valid') ? 'text-success' : 'text-danger' }}">
                                        {{ session('promo_message') }}
                                    </small>
                                @endif
                            </div>
                        </form>
                    @endif
                    
                    <!-- Formulario de checkout -->
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <!-- Selección de dirección -->
                        <div class="mb-3">
                            <label for="address_id" class="form-label">Dirección de Envío</label>
                            <select name="address_id" id="address_id" class="form-select" required>
                                <option value="">Selecciona una dirección</option>
                                @foreach ($addresses as $address)
                                    <option value="{{ $address->id }}">
                                        {{ $address->address }}, {{ $address->city }}, {{ $address->postal_code }}, {{ $address->country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Selección de método de pago -->
                        <div class="mb-3">
                            <label for="payment_method_id" class="form-label">Método de Pago</label>
                            <select name="payment_method_id" id="payment_method_id" class="form-select" required>
                                <option value="">Selecciona un método de pago</option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}">
                                        Tarjeta: **** **** **** {{ substr($paymentMethod->card_number, -4) }} 
                                        (Expira: {{ $paymentMethod->expiration_date }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Resumen de la compra -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Resumen de la compra</h5>
                                
                                @php
                                    $subtotal = $cart->products->sum(fn($product) => $product->price * $product->pivot->quantity);
                                    $discountAmount = 0;
                                    $discountPercentage = 0;
                                    
                                    if(session('appliedPromoCode')) {
                                        $discountPercentage = session('discountPercentage', 0);
                                        $discountAmount = $subtotal * ($discountPercentage / 100);
                                    }
                                    
                                    $total = $subtotal - $discountAmount;
                                @endphp
                                
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if(session('appliedPromoCode'))
                                    <div class="d-flex justify-content-between">
                                        <span>Descuento ({{ $discountPercentage }}%):</span>
                                        <span>-${{ number_format($discountAmount, 2) }}</span>
                                    </div>
                                    <input type="hidden" name="promo_code" value="{{ session('appliedPromoCode') }}">
                                    <input type="hidden" name="discount_amount" value="{{ $discountAmount }}">
                                @endif
                                
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total a pagar:</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Completar Compra</button>
                    </form>
                </div>
            </div>
        @else
            <p>Tu carrito está vacío.</p>
            <a href="{{ route('welcome') }}" class="btn btn-primary mt-3">Ir a comprar productos</a>
        @endif
    </div>
</body>
</html>