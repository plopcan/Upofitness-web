<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Descuento | Upofitness</title>
    
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
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="page-title mb-0">Crear Nuevo Descuento</h1>
                <a href="{{ route('productDiscount.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver a descuentos
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

            <div class="card card-background shadow-sm">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-tag-fill me-2"></i>Formulario de Descuento</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('productDiscount.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label for="product_id" class="form-label">Producto</label>
                                <select name="product_id" id="product_id" class="form-select" required>
                                    <option value="">Seleccionar producto</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} - {{ $product->price }}€
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Selecciona el producto al que quieres aplicar el descuento</div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="percentage" class="form-label">Porcentaje de Descuento</label>
                                <div class="input-group">
                                    <input type="number" name="percentage" id="percentage" class="form-control" min="1" max="100" value="{{ old('percentage', 10) }}" required>
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="form-text">Introduce un valor entre 1 y 100</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="expiration_date" class="form-label">Fecha de Expiración</label>
                            <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ old('expiration_date', \Carbon\Carbon::now()->addDays(30)->format('Y-m-d')) }}" required>
                            <div class="form-text">La fecha debe ser posterior a hoy</div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('productDiscount.index') }}" class="btn btn-outline-secondary me-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i> Crear Descuento
                            </button>
                        </div>
                    </form>
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