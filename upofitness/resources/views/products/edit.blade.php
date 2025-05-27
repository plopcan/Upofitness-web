<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto | Upofitness</title>
    
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
                <h1 class="page-title mb-0">Editar Producto: {{ $product->name }}</h1>
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-background shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark py-3">
                            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Información del Producto</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nombre del Producto</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label">Precio</label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="stock" class="form-label">Cantidad en Stock</label>
                                        <input type="number" name="stock" id="stock" min="0" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="available" class="form-label">Disponibilidad</label>
                                        <select name="available" id="available" class="form-select @error('available') is-invalid @enderror" required>
                                            <option value="1" {{ old('available', $product->available) == 1 ? 'selected' : '' }}>Disponible</option>
                                            <option value="0" {{ old('available', $product->available) == 0 ? 'selected' : '' }}>No disponible</option>
                                        </select>
                                        @error('available')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="sku" class="form-label">SKU <span class="text-muted">(opcional)</span></label>
                                        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku ?? '') }}">
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
                                                        {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) || 
                                                           ($errors->isEmpty() && $product->categories->contains($category->id)) ? 'checked' : '' }}>
                                                    <label for="category_{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('categories')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="images" class="form-label">Añadir Nuevas Imágenes</label>
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
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-save me-1"></i> Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card card-background shadow-sm mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información General</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>ID:</span>
                                    <span class="badge bg-secondary">{{ $product->id }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Creado:</span>
                                    <span>{{ $product->created_at->format('d/m/Y H:i') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Última actualización:</span>
                                    <span>{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Estado:</span>
                                    <span class="badge bg-{{ $product->available ? 'success' : 'danger' }}">
                                        {{ $product->available ? 'Disponible' : 'No disponible' }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Stock:</span>
                                    <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                        {{ $product->stock }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card card-background shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-images me-2"></i>Imágenes Actuales</h5>
                        </div>
                        <div class="card-body">
                            @if($product->images->count() > 0)
                                <div class="row">
                                    @foreach($product->images as $image)
                                        <div class="col-6 mb-3">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image->url) }}" alt="{{ $product->name }}" class="img-thumbnail w-100" style="height: 120px; object-fit: cover;">
                                                <form action="{{ route('products.images.destroy', ['product' => $product->id, 'image' => $image->id]) }}" method="POST" class="position-absolute" style="top: 5px; right: 5px;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle" onclick="return confirm('¿Está seguro que desea eliminar esta imagen?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-camera text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2">No hay imágenes disponibles</p>
                                </div>
                            @endif
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
