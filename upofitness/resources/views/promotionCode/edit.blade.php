<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Código Promocional | Upofitness</title>
    
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
                    <a href="{{ route('productDiscount.index') }}" class="btn btn-primary link-button">Descuentos</a>
                    <a href="{{ route('promotion.index') }}" class="btn btn-primary link-button">Promociones</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="page-title mb-0">Editar Código Promocional</h1>
                <a href="{{ route('promotion.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver a promociones
                </a>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-background shadow-sm">
                        <div class="card-header bg-warning text-dark py-3">
                            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Editar Código #{{ $promotionCode->id }}</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('promotion.update', $promotionCode->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="code" class="form-label">Código Promocional</label>
                                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $promotionCode->code) }}" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="percentage" class="form-label">Porcentaje de Descuento</label>
                                    <div class="input-group">
                                        <input type="number" name="percentage" id="percentage" class="form-control @error('percentage') is-invalid @enderror" min="1" max="100" value="{{ old('percentage', $promotionCode->percentage) }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="expiration_date" class="form-label">Fecha de Expiración</label>
                                    <input type="date" name="expiration_date" id="expiration_date" class="form-control @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date', \Carbon\Carbon::parse($promotionCode->expiration_date)->format('Y-m-d')) }}" required>
                                    @error('expiration_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="uses" class="form-label">Número de Usos Restantes</label>
                                    <input type="number" name="uses" id="uses" class="form-control @error('uses') is-invalid @enderror" min="0" value="{{ old('uses', $promotionCode->uses) }}" required>
                                    @error('uses')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('promotion.index') }}" class="btn btn-outline-secondary me-2">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-check-circle me-1"></i> Actualizar Código
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card card-background shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información del Código</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>ID:</span>
                                    <span class="badge bg-secondary">{{ $promotionCode->id }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Código:</span>
                                    <span class="badge bg-primary">{{ $promotionCode->code }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Descuento:</span>
                                    <span class="badge bg-success">{{ $promotionCode->percentage }}%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Fecha de Expiración:</span>
                                    <span>{{ \Carbon\Carbon::parse($promotionCode->expiration_date)->format('d/m/Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Usos Restantes:</span>
                                    <span class="badge bg-{{ $promotionCode->uses > 10 ? 'info' : ($promotionCode->uses > 0 ? 'warning' : 'danger') }}">
                                        {{ $promotionCode->uses }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Creado:</span>
                                    <span>{{ \Carbon\Carbon::parse($promotionCode->created_at)->format('d/m/Y H:i') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card card-background shadow-sm mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Uso Recomendado</h5>
                        </div>
                        <div class="card-body">
                            <p>Para usar este código en el carrito de compras, los clientes deben:</p>
                            <ol class="mb-0">
                                <li>Añadir productos al carrito</li>
                                <li>Ir a la página de checkout</li>
                                <li>Introducir el código: <strong>{{ $promotionCode->code }}</strong></li>
                                <li>Hacer clic en "Aplicar" para obtener el descuento del {{ $promotionCode->percentage }}%</li>
                            </ol>
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