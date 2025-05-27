<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Descuento | Upofitness</title>
    
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
                <h1 class="page-title mb-0">Editar Descuento</h1>
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
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Editar Descuento #{{ $discount->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('productDiscount.update', $discount->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label for="product_id" class="form-label">Producto</label>
                                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar producto</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ (old('product_id', $discount->product_id) == $product->id) ? 'selected' : '' }}>
                                            {{ $product->name }} - {{ $product->price }}€
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="percentage" class="form-label">Porcentaje de Descuento</label>
                                <div class="input-group">
                                    <input type="number" name="percentage" id="percentage" class="form-control @error('percentage') is-invalid @enderror" min="1" max="100" value="{{ old('percentage', $discount->percentage) }}" required>
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('percentage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="expiration_date" class="form-label">Fecha de Expiración</label>
                            <input type="date" name="expiration_date" id="expiration_date" class="form-control @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date', \Carbon\Carbon::parse($discount->expiration_date)->format('Y-m-d')) }}" required>
                            @error('expiration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('productDiscount.index') }}" class="btn btn-outline-secondary me-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-1"></i> Actualizar Descuento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Información del descuento actual -->
            <div class="card card-background shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información del Descuento</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $discount->id }}</td>
                                </tr>
                                <tr>
                                    <th>Producto:</th>
                                    <td>{{ $discount->product->name ?? 'Producto no disponible' }}</td>
                                </tr>
                                <tr>
                                    <th>Porcentaje:</th>
                                    <td>{{ $discount->percentage }}%</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Fecha de Expiración:</th>
                                    <td>{{ \Carbon\Carbon::parse($discount->expiration_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Creado el:</th>
                                    <td>{{ \Carbon\Carbon::parse($discount->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Actualizado el:</th>
                                    <td>{{ \Carbon\Carbon::parse($discount->updated_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
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