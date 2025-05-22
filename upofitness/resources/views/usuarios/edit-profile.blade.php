<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Upofitness</title>
    
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
                    <a href="{{ route('wishlist.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button">Lista de Deseos</a>
                    <a href="{{ route('orders.showByUserId', ['id' => Auth::id()]) }}" class="btn btn-primary link-button">Mis Pedidos</a>
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
            <h1 class="page-title mb-4">Mi Perfil</h1>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card card-background shadow-sm">
                        <div class="card-body text-center p-4">
                            @php
                                $imageUrl = null;
                                if ($usuario->image_id && $usuario->image) {
                                    $imageUrl = asset('storage/' . $usuario->image->url);
                                }
                            @endphp
                            <img src="{{ $imageUrl ?? 'https://via.placeholder.com/150' }}" 
                                 alt="Imagen de Perfil" 
                                 class="rounded-circle mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <h4 class="mb-1">{{ $usuario->name }}</h4>
                            <p class="text-muted">{{ $usuario->email }}</p>
                            <p>
                                <i class="bi bi-telephone me-2"></i>{{ $usuario->phone ?? 'No disponible' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card card-background shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Actualizar Información Personal</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $usuario->name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $usuario->phone }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image" class="form-label">Imagen de Perfil</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i> Actualizar Perfil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Direcciones -->
                    <div class="card card-background shadow-sm mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Direcciones de Envío</h5>
                        </div>
                        <div class="card-body p-4">
                            @if($usuario->addresses->isEmpty())
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>No tienes direcciones guardadas.
                                </div>
                            @else
                                <div class="table-responsive mb-3">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Dirección</th>
                                                <th>Ciudad</th>
                                                <th>Código Postal</th>
                                                <th>País</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usuario->addresses as $address)
                                                <tr>
                                                    <td>{{ $address->address }}</td>
                                                    <td>{{ $address->city }}</td>
                                                    <td>{{ $address->postal_code }}</td>
                                                    <td>{{ $address->country }}</td>
                                                    <td>
                                                        <form action="{{ route('addresses.destroy', $address->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            
                            <h6 class="mb-3">Añadir Nueva Dirección</h6>
                            <form action="{{ route('addresses.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ Auth::id() }}">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="address" class="form-label">Dirección</label>
                                        <input type="text" name="address" id="address" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">Ciudad</label>
                                        <input type="text" name="city" id="city" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label for="postal_code" class="form-label">Código Postal</label>
                                        <input type="text" name="postal_code" id="postal_code" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label for="country" class="form-label">País</label>
                                        <input type="text" name="country" id="country" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-plus-circle me-1"></i> Añadir Dirección
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Métodos de Pago -->
                    <div class="card card-background shadow-sm">
                        <div class="card-header bg-accent text-white" style="background-color: var(--accent-color);">
                            <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Métodos de Pago</h5>
                        </div>
                        <div class="card-body p-4">
                            @if($usuario->paymentMethods->isEmpty())
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>No tienes métodos de pago guardados.
                                </div>
                            @else
                                <div class="table-responsive mb-3">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Número de Tarjeta</th>
                                                <th>Expiración</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usuario->paymentMethods as $paymentMethod)
                                                <tr>
                                                    <td>**** **** **** {{ substr($paymentMethod->card_number, -4) }}</td>
                                                    <td>{{ $paymentMethod->expiration_date }}</td>
                                                    <td>
                                                        <form action="{{ route('payment-methods.destroy', $paymentMethod->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            
                            <h6 class="mb-3">Añadir Nuevo Método de Pago</h6>
                            <form action="{{ route('payment-methods.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ Auth::id() }}">
                                <div class="row mb-3">
                                    <div class="col-md-12 mb-3">
                                        <label for="card_number" class="form-label">Número de Tarjeta</label>
                                        <input type="text" name="card_number" id="card_number" class="form-control" required placeholder="XXXX XXXX XXXX XXXX">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="expiration_date" class="form-label">Fecha de Expiración</label>
                                        <input type="date" name="expiration_date" id="expiration_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" name="cvv" id="cvv" class="form-control" required placeholder="123">
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-plus-circle me-1"></i> Añadir Método de Pago
                                    </button>
                                </div>
                            </form>
                        </div>
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
