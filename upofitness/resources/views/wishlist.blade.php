<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deseos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-info {
            flex: 1;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .empty-message {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .success {
            color: green;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #e8f5e9;
            border-radius: 5px;
        }

        .error {
            color: red;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #ffebee;
            border-radius: 5px;
        }

        .info {
            color: blue;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #e3f2fd;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <nav>
        <a href="{{ route('productos.index') }}">Catálogo</a>
        @auth
            <a href="{{ route('cart.showByUserId', ['id' => auth()->id()]) }}">Carrito</a>
            <a href="{{ route('wishlist.showByUserId', ['id' => auth()->id()]) }}">Lista de Deseos</a>
            <a href="{{ route('profile.edit') }}" class="profile-button">
                @php
                    $imageUrl = null;
                    if (Auth::user()->image_id && Auth::user()->image) {
                        $imageUrl = asset('storage/' . Auth::user()->image->url);
                    }
                @endphp
                <img src="{{ $imageUrl ?? 'https://via.placeholder.com/50' }}" alt="Perfil" class="rounded-circle"
                    style="width: 50px; height: 50px; object-fit: cover;">
            </a>
        @else
            <a href="#" onclick="alert('Debes iniciar sesión para acceder al carrito.')">Carrito</a>
            <a href="#" onclick="alert('Debes iniciar sesión para acceder a la lista de deseos.')">Lista de Deseos</a>
        @endauth
    </nav>

    <h1>Mi Lista de Deseos</h1>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    @if(session('info'))
        <div class="info">{{ session('info') }}</div>
    @endif

    @if(isset($error))
        <div class="error">{{ $error }}</div>
    @endif

    @if(isset($wishlist) && $wishlist->products->count() > 0)
        <div class="wishlist-container">
            @foreach($wishlist->products as $product)
                <div class="product-card">
                    <div class="product-info">
                        <h3>{{ $product->name }}</h3>
                        <p>{{ $product->description }}</p>
                        <p><strong>Precio:</strong> €{{ $product->price }}</p>
                    </div>
                    <div class="product-actions">
                        <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST">
                            @csrf
                            <button type="submit">Añadir al carrito</button>
                        </form>
                        <form action="{{ route('wishlist.remove', ['productId' => $product->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar de la lista</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <form action="{{ route('wishlist.clear') }}" method="POST">
                @csrf
                <button type="submit">Vaciar lista de deseos</button>
            </form>
        </div>
    @else
        <div class="empty-message">
            <p>Tu lista de deseos está vacía</p>
            <a href="{{ route('productos.index') }}">Ir al catálogo</a>
        </div>
    @endif
</body>

</html>