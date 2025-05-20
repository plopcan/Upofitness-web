<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>
<body>
    <!-- Navbar -->
    <header class="navbar-style-7 position-relative text-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <h1 class="text-center">Upofitness</h1>
                <nav>
                    <a href="{{ route('welcome') }}" class="btn btn-primary link-button">Inicio</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary link-button">Categorías</a>
                    @auth
                        <a href="{{ route('cart.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button">Carrito</a>
                        <a href="{{ route('wishlist.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button">Lista de Deseos</a>
                        
                        @if(Auth::user()->role_id == 2)
                            <a href="{{ route('products.create') }}" class="btn btn-success link-button">
                                <i class="bi bi-plus-circle"></i> Añadir Producto
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-secondary link-button">Iniciar Sesión</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mt-6 flex-grow-1">
        <div class="container">
            <h1 class="text-center mb-4">Productos</h1>
            
            <!-- Category Filter -->
            <form method="GET" action="{{ route('products.filterByCategory') }}" class="mb-4">
                <details>
                    <summary class="btn btn-secondary">Filtrar por categorías</summary>
                    <ul class="list-group mt-2">
                        @foreach ($categories as $category)
                            <li class="list-group-item">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                       id="category-{{ $category->id }}" 
                                       {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                <label for="category-{{ $category->id }}" class="ms-2">{{ $category->name }}</label>
                            </li>
                        @endforeach
                    </ul>
                </details>
                <button type="submit" class="btn btn-primary mt-3">Aplicar filtros</button>
            </form>
            
            <div class="row">
                @foreach ($products as $product)
                    @if($product->available == 1 || (Auth::check() && Auth::user()->role_id == 2))
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card shadow-sm card-background">
                                <div class="card-img-container position-relative ">
                                    @if($product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $product->images->first()->url) }}" 
                                             class="card-img-top" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://via.placeholder.com/150" 
                                             class="card-img-top" alt="{{ $product->name }}">
                                    @endif
                                    
                                    @auth
                                        @if(Auth::user()->role_id == 2)
                                            <div class="position-absolute top-0 end-0 p-2">
                                                <div class="btn-group">
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            @if($product->available == 0)
                                                <div class="position-absolute top-0 start-0 p-2">
                                                    <span class="badge bg-danger">No disponible</span>
                                                </div>
                                            @endif
                                        @endif
                                    @endauth
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                    <p class="card-text"><strong>Precio:</strong> ${{ $product->price }}</p>
                                    <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
                                    
                                    @if($product->images->count() > 1)
                                        <div class="product-gallery d-flex overflow-auto py-2">
                                            @foreach($product->images as $image)
                                                <div class="product-thumbnail mx-1">
                                                    <img src="{{ asset('storage/' . $image->url) }}" 
                                                         alt="Imagen del producto"
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        @if($product->available == 1 || !Auth::check() || Auth::user()->role_id != 2)
                                            <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST" class="me-2">
                                                @csrf
                                                @auth
                                                    <input type="hidden" name="usuario_id" value="{{ Auth::id() }}">
                                                @else
                                                    <input type="hidden" name="usuario_id" value="{{ session('usuario_id') }}">
                                                @endauth
                                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control mb-2">
                                                <button type="submit" class="btn btn-primary" {{ $product->available == 0 ? 'disabled' : '' }}>
                                                    Añadir al carrito
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @auth
                                            @php
                                                $wishlist = \App\Models\Wishlist::where('usuario_id', Auth::user()->id)->first();
                                                $inWishlist = false;
                                                
                                                if ($wishlist) {
                                                    $inWishlist = $wishlist->products()->where('product_id', $product->id)->exists();
                                                }
                                            @endphp
                                            
                                            @if($inWishlist)
                                                <form action="{{ route('wishlist.remove', ['productId' => $product->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="bi bi-heart-fill"></i> Eliminar de favoritos
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('wishlist.add', ['productId' => $product->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="bi bi-heart"></i> Añadir a favoritos
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-danger">
                                                <i class="bi bi-heart"></i> Añadir a favoritos
                                            </a>
                                        @endauth
                                    </div>
                                    
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">Ver detalle</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>

            <!-- El formulario para subir imágenes debe estar dentro de una página de detalle de producto -->
            @if(isset($singleProduct))
                <div class="mt-4">
                    <h3>Añadir imagen al producto</h3>
                    <form action="{{ route('products.images.store', $singleProduct->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="image">Seleccionar imagen</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Subir imagen</button>
                    </form>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-16 text-center text-sm text-black dark:text-white/70 mt-auto text-white">
        <div class="container">
            <p>© {{ date('Y') }} Upofitness. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
