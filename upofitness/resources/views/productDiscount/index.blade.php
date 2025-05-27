<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Descuentos de Productos | Upofitness</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    
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
                    <a href="{{ route('productDiscount.index') }}" class="btn btn-primary link-button active">Descuentos</a>
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
            <h1 class="page-title mb-4">Gestión de Descuentos</h1>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Botones de acción -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('productDiscount.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Crear Nuevo Descuento
                </a>
                <form action="{{ route('productDiscount.apply') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Aplicar Descuentos
                    </button>
                </form>
            </div>

            <!-- Tabla de descuentos -->
            <div class="card card-background shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-tag-fill me-2"></i>Descuentos Activos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Porcentaje</th>
                                    <th>Fecha de Expiración</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($discounts as $discount)
                                    <tr>
                                        <td>{{ $discount->id }}</td>
                                        <td>
                                            @if($discount->product)
                                                <div class="d-flex align-items-center">
                                                    @if($discount->product->images->isNotEmpty())
                                                        <img src="{{ asset('storage/' . $discount->product->images->first()->url) }}" 
                                                             alt="{{ $discount->product->name }}" 
                                                             class="me-2" style="width: 40px; height: 40px; object-fit: contain;">
                                                    @endif
                                                    <span>{{ $discount->product->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">Producto no disponible</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-success">{{ $discount->percentage }}%</span></td>
                                        <td>
                                            @php
                                                $expirationDate = \Carbon\Carbon::parse($discount->expiration_date);
                                                $isExpired = $expirationDate->isPast();
                                            @endphp
                                            
                                            <span class="d-flex align-items-center">
                                                {{ $expirationDate->format('d/m/Y') }}
                                                @if($isExpired)
                                                    <span class="badge bg-danger ms-2">Expirado</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('productDiscount.edit', $discount->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                <form action="{{ route('productDiscount.destroy', $discount->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este descuento?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-tag-fill text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mt-2 mb-0">No hay descuentos disponibles</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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