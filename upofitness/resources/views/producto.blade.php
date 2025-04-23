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
                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/150' }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text"><strong>Precio:</strong> ${{ $product->price }}</p>
                                <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
                                <a href="#" class="btn btn-primary">Añadir al carrito</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
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
