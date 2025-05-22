<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mis Pedidos | Upofitness</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/bootstrap.bundle.js'])
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
                    <a href="{{ route('wishlist.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button">Lista de Deseos</a>
                    <a href="{{ route('orders.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button active">Mis Pedidos</a>
                    <a href="{{ route('cart.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button" title="Carrito">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <h1 class="page-title mb-4">Historial de Pedidos</h1>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($orders->isEmpty())
                <div class="card-background p-5 text-center rounded shadow-sm">
                    <i class="bi bi-bag-x" style="font-size: 4rem; color: var(--accent-color);"></i>
                    <h3 class="mt-3">No tienes pedidos</h3>
                    <p class="text-muted mb-4">¡Explora nuestro catálogo para encontrar productos que te interesen!</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="bi bi-bag"></i> Explorar catálogo
                    </a>
                </div>
            @else
                <div class="card card-background shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Dirección</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->product->name ?? 'Producto no disponible' }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td class="fw-bold">{{ $order->total }} €</td>
                                            <td>{{ \Carbon\Carbon::parse($order->purchase_date)->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status == 'pendiente' ? 'warning' : ($order->status == 'en camino' ? 'info' : 'success') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($order->full_address, 30) }}</td>
                                            <td>
                                                @if($order->invoice)
                                                    <a href="{{ route('invoices.show', ['id' => $order->invoice->id]) }}" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-file-text"></i> Ver Factura
                                                    </a>
                                                @else
                                                    <span class="badge bg-secondary">Sin factura</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
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
