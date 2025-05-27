<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras | Upofitness</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="navbar-style-7 position-relative text-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/logo.png') }}" alt="Upofitness Logo" class="logo">
                </a>
                <nav>
                    <a href="{{ route('products.index') }}" class="btn btn-primary link-button">Productos</a>
                    @auth
                        <a href="{{ route('wishlist.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button">Lista de Deseos</a>
                        <a href="{{ route('orders.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button">Mis Pedidos</a>
                        <a href="{{ route('cart.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button active" title="Carrito">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary link-button">Iniciar Sesión</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <h1 class="mb-4">Mi Carrito de Compras</h1>

            @if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @elseif ($cart && $cart->products->count() > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-background shadow-sm mb-4">
                            <div class="card-body">
                                <h4 class="text-primary mb-3">Productos en tu carrito</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th width="150">Cantidad</th>
                                                <th>Total</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart->products as $product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($product->images->isNotEmpty())
                                                                <img src="{{ asset('storage/' . $product->images->first()->url) }}" 
                                                                    alt="{{ $product->name }}" 
                                                                    class="me-2 cart-item-image" 
                                                                    style="width: 60px; height: 60px; object-fit: contain;">
                                                            @endif
                                                            <div>
                                                                <h6 class="mb-0">{{ $product->name }}</h6>
                                                                <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">{{ number_format($product->price, 2) }} €</td>
                                                    <td class="align-middle">
                                                        <div class="input-group">
                                                            <form action="{{ route('cart.updateQuantity', ['productId' => $product->id, 'action' => 'decrease']) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-outline-secondary">
                                                                    <i class="bi bi-dash"></i>
                                                                </button>
                                                            </form>
                                                            <span class="input-group-text bg-white border-0">{{ $product->pivot->quantity }}</span>
                                                            <form action="{{ route('cart.updateQuantity', ['productId' => $product->id, 'action' => 'increase']) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-outline-secondary">
                                                                    <i class="bi bi-plus"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle fw-bold">{{ number_format($product->price * $product->pivot->quantity, 2) }} €</td>
                                                    <td class="align-middle">
                                                        <form action="{{ route('cart.updateQuantity', ['productId' => $product->id, 'action' => 'decrease']) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="remove" value="1">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-arrow-left"></i> Seguir comprando
                                    </a>
                                    <!-- Botón para vaciar carrito (si tienes esta ruta) -->
                                    <a href="{{ route('welcome') }}" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i> Vaciar carrito
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card card-background shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Finalizar Compra</h5>
                            </div>
                            <div class="card-body">
                                <!-- Formulario para validar código promocional -->
                                @if(!session('appliedPromoCode'))
                                    <form action="{{ route('cart.apply-promo') }}" method="POST" class="mb-3">
                                        @csrf
                                        <label for="promo_code" class="form-label">¿Tienes un código promocional?</label>
                                        <div class="input-group mb-2">
                                            <input type="text" name="promo_code" id="promo_code" class="form-control" placeholder="Introduce tu código">
                                            <button type="submit" class="btn btn-outline-secondary">Aplicar</button>
                                        </div>
                                        @if(session('promo_message'))
                                            <div class="alert alert-{{ session('promo_valid') ? 'success' : 'danger' }} py-2 small">
                                                {{ session('promo_message') }}
                                            </div>
                                        @endif
                                    </form>
                                @else
                                    <div class="alert alert-success py-2 small mb-3">
                                        <i class="bi bi-check-circle-fill me-1"></i> Código promocional aplicado: <strong>{{ session('appliedPromoCode') }}</strong>
                                        <form action="{{ route('cart.apply-promo') }}" method="POST" class="mt-1">
                                            @csrf
                                            <input type="hidden" name="remove" value="1">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                @endif
                                
                                <!-- Resumen de la compra -->
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
                                
                                <div class="card bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title">Resumen de compra</h6>
                                        <hr>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span>{{ number_format($subtotal, 2) }} €</span>
                                        </div>
                                        
                                        @if(session('appliedPromoCode'))
                                            <div class="d-flex justify-content-between mb-2 text-success">
                                                <span>Descuento ({{ $discountPercentage }}%):</span>
                                                <span>-{{ number_format($discountAmount, 2) }} €</span>
                                            </div>
                                        @endif
                                        
                                        <div class="d-flex justify-content-between fw-bold mt-2">
                                            <span>Total:</span>
                                            <span class="text-primary">{{ number_format($total, 2) }} €</span>
                                        </div>
                                    </div>
                                </div>
                                
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
                                                    {{ $address->address }}, {{ $address->city }}, {{ $address->postal_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-end mt-1">
                                            <a href="#" class="small text-primary">+ Añadir nueva dirección</a>
                                        </div>
                                    </div>
                                    
                                    <!-- Selección de método de pago -->
                                    <div class="mb-4">
                                        <label for="payment_method_id" class="form-label">Método de Pago</label>
                                        <select name="payment_method_id" id="payment_method_id" class="form-select" required>
                                            <option value="">Selecciona un método de pago</option>
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <option value="{{ $paymentMethod->id }}">
                                                    <i class="bi bi-credit-card me-1"></i>
                                                    Tarjeta: **** {{ substr($paymentMethod->card_number, -4) }} 
                                                    ({{ $paymentMethod->expiration_date }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-end mt-1">
                                            <a href="#" class="small text-primary">+ Añadir nueva tarjeta</a>
                                        </div>
                                    </div>
                                    
                                    @if(session('appliedPromoCode'))
                                        <input type="hidden" name="promo_code" value="{{ session('appliedPromoCode') }}">
                                        <input type="hidden" name="discount_amount" value="{{ $discountAmount }}">
                                    @endif
                                    
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-lock-fill me-1"></i> Finalizar Compra
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="card card-background shadow-sm p-5">
                        <i class="bi bi-cart-x text-primary" style="font-size: 5rem;"></i>
                        <h3 class="mt-4">Tu carrito está vacío</h3>
                        <p class="text-muted mb-4">No tienes productos en tu carrito de compras.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="bi bi-bag"></i> Explorar productos
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-white mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0">© {{ date('Y') }} Upofitness. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>