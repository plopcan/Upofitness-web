<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto | Upofitness</title>
    
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
                    <a href="{{ route('welcome') }}" class="btn btn-primary link-button">Inicio</a>
                    <a href="{{ route('products.index') }}" class="btn btn-primary link-button">Productos</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary link-button">Categorías</a>
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
                <h1 class="page-title mb-0">Crear Nuevo Producto</h1>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver a productos
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
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Información del Producto</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre del Producto</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Proporciona una descripción detallada del producto, características, beneficios, etc.</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="stock" class="form-label">Cantidad en Stock</label>
                                <input type="number" name="stock" id="stock" min="0" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="available" class="form-label">Disponibilidad</label>
                                <select name="available" id="available" class="form-select @error('available') is-invalid @enderror" required>
                                    <option value="1" {{ old('available') == '1' ? 'selected' : '' }}>Disponible</option>
                                    <option value="0" {{ old('available') == '0' ? 'selected' : '' }}>No disponible</option>
                                </select>
                                @error('available')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="sku" class="form-label">SKU <span class="text-muted">(opcional)</span></label>
                                <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Categorías</label>
                            <div class="row">
                                @foreach($categories as $category)
                                    <div class="col-md-4 col-lg-3 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" 
                                                class="form-check-input @error('categories') is-invalid @enderror"
                                                {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}>
                                            <label for="category_{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Selecciona al menos una categoría para el producto.</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="images" class="form-label">Imágenes del Producto</label>
                            <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" multiple accept="image/*">
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Puedes seleccionar múltiples imágenes. Formatos permitidos: JPG, PNG, GIF. Máx: 2MB por imagen.</small>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-x-circle me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i> Crear Producto
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
