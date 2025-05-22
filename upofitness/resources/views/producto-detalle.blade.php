<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Upofitness</title>
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
    
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver a productos
                </a>
            </div>
            
            <div class="card card-background shadow-sm mb-4">
                <div class="card-body p-4">
                    <h1 class="text-center page-title mb-3">{{ $product->name }}</h1>
                    
                    <div class="mb-3 text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="me-2">Valoración:</span>
                            <span class="h5 mb-0 me-2">{{ number_format($media ?? 0, 1) }}</span>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($media ?? 0) ? '-fill' : '' }} text-warning"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-5">
                            @if($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->url) }}" 
                                     class="product-detail-image mb-3" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/400" 
                                     class="product-detail-image mb-3" alt="{{ $product->name }}">
                            @endif
                            
                            @if($product->images->count() > 1)
                                <div class="product-gallery d-flex overflow-auto py-2 justify-content-center">
                                    @foreach($product->images as $image)
                                        <div class="product-thumbnail mx-1">
                                            <img src="{{ asset('storage/' . $image->url) }}" 
                                                 alt="Imagen del producto"
                                                 class="border shadow-sm"
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-lg-7">
                            <div class="card card-background mb-3">
                                <div class="card-body">
                                    <h5 class="mb-3 text-primary">Detalles del producto</h5>
                                    <p class="text-muted">{{ $product->description }}</p>
                                    
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <p><strong>Precio:</strong> <span class="text-danger fw-bold">€{{ $product->price }}</span></p>
                                            <p><strong>Stock:</strong> 
                                                @if($product->stock > 10)
                                                    <span class="text-success">{{ $product->stock }} unidades</span>
                                                @elseif($product->stock > 0)
                                                    <span class="text-warning">{{ $product->stock }} unidades</span>
                                                @else
                                                    <span class="text-danger">Sin stock</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Categorías:</strong></p>
                                            <div>
                                                @if($product->categories->isNotEmpty())
                                                    @foreach($product->categories as $category)
                                                        <span class="badge bg-primary mb-1">{{ $category->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Sin categoría</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-wrap gap-2">
                                @auth
                                    <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST" class="mb-3 me-2">
                                        @csrf
                                        <input type="hidden" name="usuario_id" value="{{ Auth::id() }}">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">Cantidad</span>
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-cart-plus me-1"></i> Añadir al carrito
                                        </button>
                                    </form>
                                    
                                    @php
                                        $wishlist = \App\Models\Wishlist::where('usuario_id', Auth::user()->id)->first();
                                        $inWishlist = false;
                                        
                                        if ($wishlist) {
                                            $inWishlist = $wishlist->products()->where('product_id', $product->id)->exists();
                                        }
                                    @endphp
                                    
                                    @if($inWishlist)
                                        <form action="{{ route('wishlist.remove', ['productId' => $product->id]) }}" method="POST" class="mb-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-heart-fill me-1"></i> Eliminar de favoritos
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('wishlist.add', ['productId' => $product->id]) }}" method="POST" class="mb-3">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-heart me-1"></i> Añadir a favoritos
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión para comprar
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sección de valoraciones -->
            <div class="card card-background shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="bi bi-star me-2"></i>Valoraciones de clientes</h4>
                </div>
                <div class="card-body p-4">
                    @if($valoraciones->count())
                        @foreach($valoraciones as $valoracion)
                            <div class="border-bottom mb-3 pb-3">
                                <div class="d-flex align-items-start">
                                    @php
                                        $imageUrl = null;
                                        if (isset($valoracion->usuario) && $valoracion->usuario && $valoracion->usuario->image_id && $valoracion->usuario->image) {
                                            $imageUrl = asset('storage/' . $valoracion->usuario->image->url);
                                        }
                                    @endphp
                                    <img src="{{ $imageUrl ?? 'https://via.placeholder.com/50' }}"
                                         alt="Perfil"
                                         class="rounded-circle me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="mb-0">
                                                {{ $valoracion->usuario && $valoracion->usuario->name ? $valoracion->usuario->name : 'Usuario #' . $valoracion->usuario_id }}
                                            </h5>
                                            <small class="text-muted">{{ $valoracion->created_at ? $valoracion->created_at->format('d/m/Y') : '' }}</small>
                                        </div>
                                        <div class="mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $valoracion->puntuacion ? '-fill' : '' }} text-warning"></i>
                                            @endfor
                                        </div>
                                        <p class="mb-0">{{ $valoracion->comentario }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-center mt-4">
                            {{ $valoraciones->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-chat-square-text text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">Este producto aún no tiene valoraciones.</p>
                        </div>
                    @endif
                    
                    <!-- Formulario de valoración -->
                    <div class="mt-4 pt-4 border-top">
                        <h5 class="mb-3"><i class="bi bi-pencil-square me-2"></i>Deja tu valoración</h5>
                        @auth
                            <form action="{{ route('valoraciones.storeOrUpdate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="producto_id" value="{{ $product->id }}">
                                
                                <div class="mb-3">
                                    <label for="puntuacion" class="form-label">Puntuación</label>
                                    <select name="puntuacion" id="puntuacion" class="form-select" required>
                                        <option value="">Selecciona una puntuación</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ str_repeat('⭐', $i) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="comentario" class="form-label">Tu opinión</label>
                                    <textarea name="comentario" id="comentario" class="form-control" rows="3" placeholder="Comparte tu experiencia con este producto..."></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Enviar valoración
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <a href="{{ route('login') }}">Inicia sesión</a> para valorar este producto.
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
            
            @auth
                @if(Auth::user()->role && Auth::user()->role->name === 'administrador')
                    <div class="card card-background shadow-sm mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h4 class="mb-0"><i class="bi bi-gear me-2"></i>Administración del producto</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Añadir imagen al producto</h5>
                                    <form action="{{ route('products.images.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Seleccionar imagen</label>
                                            <input type="file" name="image" id="image" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-upload me-1"></i> Subir imagen
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5>Subir múltiples imágenes</h5>
                                    <form action="{{ route('products.images.storeMultiple', $product->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="images" class="form-label">Seleccionar imágenes</label>
                                            <input type="file" name="images[]" id="images" class="form-control" multiple required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-images me-1"></i> Subir imágenes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
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