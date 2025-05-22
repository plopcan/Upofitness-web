<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deseos | Upofitness</title>
    
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
                    @auth
                        @if(Auth::user()->role_id == 2)
                            <a href="{{ route('categories.index') }}" class="btn btn-primary link-button">Categorías</a>
                            <a href="{{ route('productDiscount.index') }}" class="btn btn-primary link-button">Descuentos</a>
                            <a href="{{ route('promotion.index') }}" class="btn btn-primary link-button">Promociones</a>
                            <a href="{{ route('admin.topWishlistProducts') }}" class="btn btn-primary link-button">Top Favoritos</a>
                        @endif
                        <a href="{{ route('cart.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button">
                            <i class="bi bi-cart3"></i> Carrito
                        </a>
                        <a href="{{ route('wishlist.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button active">
                            <i class="bi bi-heart"></i> Favoritos
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-light ms-2">Registrarse</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="page-title mb-0">Mi Lista de Favoritos</h1>
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al inicio
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(isset($error))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(isset($wishlist) && $wishlist->products->count() > 0)
                <div class="row">
                    @foreach($wishlist->products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card card-background shadow-sm h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex gap-3">
                                        @if($product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $product->images->first()->url) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="product-image" 
                                                 style="width: 90px; height: 90px; object-fit: contain;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 90px; height: 90px;">
                                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                        <div class="product-info">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                                            <h5 class="text-primary fw-bold">{{ number_format($product->price, 2) }} €</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-cart-plus"></i> Añadir al carrito
                                            </button>
                                        </form>
                                        <form action="{{ route('wishlist.remove', ['productId' => $product->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="pagination-container">
                        {{ $wishlist->products->links('pagination::bootstrap-4') }}
                    </div>
                    <form action="{{ route('wishlist.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro que desea vaciar su lista de favoritos?');">
                            <i class="bi bi-trash"></i> Vaciar lista
                        </button>
                    </form>
                </div>
            @else
                <div class="card card-background shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-heart text-danger" style="font-size: 4rem;"></i>
                        <h3 class="mt-3">Tu lista de favoritos está vacía</h3>
                        <p class="text-muted mb-4">Añade productos a tu lista para guardarlos para más tarde</p>
                        <a href="{{ route('productos.index') }}" class="btn btn-primary">
                            <i class="bi bi-bag"></i> Explorar catálogo
                        </a>
                    </div>
                </div>
            @endif
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