<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deseos | Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .wishlist-container {
            flex: 1;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .product-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
        }

        .empty-wishlist {
            text-align: center;
            padding: 50px 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-back {
            margin-bottom: 20px;
        }

        .page-title {
            margin-bottom: 30px;
            color: #333;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
            display: inline-block;
        }

        .clear-wishlist-btn {
            margin-top: 20px;
        }

        footer {
            margin-top: auto;
        }
    </style>
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
                    @auth
                        <a href="{{ route('cart.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button">Carrito</a>
                        <a href="{{ route('wishlist.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button active">Lista de Deseos</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-secondary link-button">Iniciar Sesión</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <div class="wishlist-container">
        <button onclick="window.history.back()" class="btn btn-secondary btn-back">
            <i class="bi bi-arrow-left"></i> Volver
        </button>

        <h1 class="page-title">Mi Lista de Deseos</h1>

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
                        <div class="product-card h-100 p-3">
                            <div class="d-flex gap-3">
                                @if($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->url) }}" alt="{{ $product->name }}" class="product-image">
                                @else
                                    <img src="https://via.placeholder.com/150" alt="{{ $product->name }}" class="product-image">
                                @endif
                                <div class="product-info">
                                    <h4>{{ $product->name }}</h4>
                                    <p class="text-muted">{{ Str::limit($product->description, 100) }}</p>
                                    <h5 class="text-danger fw-bold">€{{ $product->price }}</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-cart-plus"></i> Añadir al carrito
                                    </button>
                                </form>
                                <form action="{{ route('wishlist.remove', ['productId' => $product->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center clear-wishlist-btn">
                <form action="{{ route('wishlist.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Vaciar lista de deseos
                    </button>
                </form>
            </div>
        @else
            <div class="empty-wishlist">
                <i class="bi bi-heart" style="font-size: 4rem; color: #dc3545;"></i>
                <h3 class="mt-3">Tu lista de deseos está vacía</h3>
                <p class="text-muted mb-4">Añade productos a tu lista para guardarlos para más tarde</p>
                <a href="{{ route('productos.index') }}" class="btn btn-primary">
                    <i class="bi bi-bag"></i> Explorar catálogo
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="py-4 text-center text-white bg-dark mt-5">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} Upofitness. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>