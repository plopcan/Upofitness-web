<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Factura #{{ $invoice->id }} | Upofitness</title>

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
                        <a href="{{ route('cart.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button" title="Carrito">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-4">Factura #{{ $invoice->id }}</h1>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                    <button onclick="window.history.back()" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </button>
                </div>
            </div>
            
            <div class="card card-background shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4 class="text-primary">Datos de la Factura</h4>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Fecha de Emisión:</th>
                                    <td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Porcentaje de Impuestos:</th>
                                    <td>{{ $invoice->tax_percentage }}%</td>
                                </tr>
                                <tr>
                                    <th>Monto Total:</th>
                                    <td class="fw-bold">{{ $invoice->total_amount }} €</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-primary">Datos del Cliente</h4>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Cliente:</th>
                                    <td>{{ $order->user->name ?? 'Cliente no disponible' }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $order->user->email ?? 'Email no disponible' }}</td>
                                </tr>
                                <tr>
                                    <th>Dirección:</th>
                                    <td>{{ $order->full_address }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <h4 class="text-primary mb-3">Detalle del Pedido</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($order->product && $order->product->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $order->product->images->first()->url) }}" 
                                                    alt="{{ $order->product->name }}" 
                                                    class="me-2" style="width: 50px; height: 50px; object-fit: contain;">
                                            @endif
                                            <span>{{ $order->product->name ?? 'Producto eliminado o no disponible' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ $order->product->price ?? 0 }} €</td>
                                    <td>{{ $order->total }} €</td>
                                    <td>
                                        @if(Auth::check() && Auth::user()->role_id == 2)
                                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="pendiente" {{ $order->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                    <option value="en camino" {{ $order->status === 'en camino' ? 'selected' : '' }}>En camino</option>
                                                    <option value="entregado" {{ $order->status === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                                </select>
                                            </form>
                                        @else
                                            <span class="badge bg-{{ $order->status == 'pendiente' ? 'warning' : ($order->status == 'en camino' ? 'info' : 'success') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td colspan="2">{{ number_format(($order->total / (1 + $invoice->tax_percentage/100)), 2) }} €</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>IVA ({{ $invoice->tax_percentage }}%):</strong></td>
                                    <td colspan="2">{{ number_format(($order->total - ($order->total / (1 + $invoice->tax_percentage/100))), 2) }} €</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td colspan="2" class="fw-bold text-primary">{{ $order->total }} €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card card-background shadow-sm">
                <div class="card-body p-4">
                    <h4 class="text-primary mb-3">Información Adicional</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Método de Pago:</strong> Tarjeta de crédito</p>
                            <p><strong>Fecha de Procesamiento:</strong> {{ \Carbon\Carbon::parse($order->purchase_date)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Referencia de Pago:</strong> #REF{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>Número de Factura:</strong> INV-{{ date('Y') }}-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="text-center mt-3">
                        <p class="small text-muted">Esta factura ha sido generada automáticamente y es válida sin firma ni sello.</p>
                        <p class="fw-bold text-primary">Gracias por su compra en Upofitness</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer que solo se muestra en pantalla (no en impresión) -->
    <footer class="py-4 text-center text-white mt-auto no-print">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0">© {{ date('Y') }} Upofitness. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: white !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            header, .btn {
                display: none !important;
            }
        }
    </style>
</body>
</html>
