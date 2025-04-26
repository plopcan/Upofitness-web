<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
</head>
<body>
    <nav>
        <a href="{{ route('productos.index') }}">Catálogo</a>
        <a href="{{ route('cart.showByUserId', ['id' => Auth::user()->id]) }}">Carrito</a> <!-- Use logged-in user's ID -->
        <a href="{{ route('wishlist.showByUserId', ['id' => Auth::user()->id]) }}">Lista de Deseos</a> <!-- Use logged-in user's ID -->
        <a href="#profile">Perfil</a>
    </nav>

    <h1>Bienvenido, {{ Auth::user()->name }}</h1> <!-- Display the logged-in user's name -->
    <p>Esta es la página principal para usuarios.</p>
</body>
</html>