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
        @if (session('usuario_id'))
            <a href="{{ route('cart.showByUserId', ['id' => session('usuario_id')]) }}">Carrito</a>
            <a href="{{ route('wishlist.showByUserId', ['id' => session('usuario_id')]) }}">Lista de Deseos</a>
        @else
            <a href="#" onclick="alert('Debes iniciar sesión para acceder al carrito.')">Carrito</a>
            <a href="#" onclick="alert('Debes iniciar sesión para acceder a la lista de deseos.')">Lista de Deseos</a>
        @endif
        <a href="#profile">Perfil</a>
    </nav>

    <h1>Bienvenido, Usuario</h1>
    <p>Esta es la página principal para usuarios.</p>

    @if (session('usuario_id'))
        <p><strong>ID de Usuario en Sesión:</strong> {{ session('usuario_id') }}</p>
    @else
        <p>No hay un usuario autenticado en la sesión.</p>
    @endif
</body>
</html>