<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar -->
    <header class="navbar-style-7 position-relative bg-dark text-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <h1 class="text-center">Upofitness</h1>
                <nav>
                    <a href="{{ route('welcome') }}" class="btn btn-primary link-button">Inicio</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary link-button">Categorías</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary link-button">Iniciar Sesión</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mt-6 flex-grow-1">
        <div class="container">
            <h1 class="text-center mb-4">Productos</h1>
            
            <!-- Category Filter -->
            <details class="mb-4">
                <summary class="btn btn-secondary">Filtrar por categoría</summary>
                <ul class="list-group mt-2">
                    @foreach ($categories as $category)
                        <li class="list-group-item">
                            <a href="{{ route('products.filterByCategory', ['categoryId' => $category->id]) }}" class="text-decoration-none">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </details>
            
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-img-container">
                                @if($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->url) }}" 
                                         class="card-img-top" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/150" 
                                         class="card-img-top" alt="{{ $product->name }}">
                                @endif
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
                                
                                <a href="#" class="btn btn-primary">Añadir al carrito</a>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary ms-2">Ver detalle</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>

            <!-- El formulario para subir imágenes debe estar dentro de una página de detalle de producto,
                 no en la lista general de productos, ya que necesita un $product específico -->
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
    <footer class="py-16 text-center text-sm text-black dark:text-white/70 mt-auto bg-dark text-white">
        <div class="container">
            <p>© {{ date('Y') }} Upofitness. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
