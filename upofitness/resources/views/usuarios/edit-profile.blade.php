<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Editar Perfil</h1>
    <a href="{{ route('welcome') }}" class="btn btn-secondary mb-3">Volver a la página principal</a>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $usuario->name }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="phone">Teléfono</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $usuario->phone }}">
        </div>

        <div class="form-group mb-3">
            <label for="image">Imagen de Perfil</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($usuario->image)
                <img src="{{ asset('storage/' . $usuario->image->url) }}" alt="Imagen de Perfil" class="mt-2" style="width: 100px; height: 100px; object-fit: cover;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
    </form>

        <hr>

        <h3>Direcciones</h3>
        <ul>
            @foreach ($usuario->addresses as $address)
                <li>
                    {{ $address->address }}, {{ $address->city }}, {{ $address->country }} ({{ $address->postal_code }})
                    <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <form action="{{ route('addresses.store') }}" method="POST">
            @csrf
            <input type="hidden" name="usuario_id" value="{{ Auth::id() }}"> <!-- Hidden input for authenticated user's ID -->
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" id="address" class="form-control" required>
</div>
<div class="form-group">
                <label for="city">Ciudad</label>
                <input type="text" name="city" id="city" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="postal_code">Código Postal</label>
                <input type="text" name="postal_code" id="postal_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="country">País</label>
                <input type="text" name="country" id="country" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" id="phone" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Añadir Dirección</button>
        </form>

        <hr>

        <h3>Métodos de Pago</h3>
        <ul>
            @foreach ($usuario->paymentMethods as $paymentMethod)
                <li>
                    Tarjeta: **** **** **** {{ substr($paymentMethod->card_number, -4) }} (Expira: {{ $paymentMethod->expiration_date }})
                    <form action="{{ route('payment-methods.destroy', $paymentMethod->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <form action="{{ route('payment-methods.store') }}" method="POST">
            @csrf
            <input type="hidden" name="usuario_id" value="{{ Auth::id() }}"> <!-- Hidden input for authenticated user's ID -->
            <div class="form-group">
                <label for="card_number">Número de Tarjeta</label>
                <input type="text" name="card_number" id="card_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="expiration_date">Fecha de Expiración</label>
                <input type="date" name="expiration_date" id="expiration_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" name="cvv" id="cvv" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Método de Pago</button>
        </form>
    </div>
</body>
</html>
