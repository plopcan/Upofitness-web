<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
</head>
<body>
    <div class="container">
        <h2>Editar Perfil</h2>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $usuario->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $usuario->phone }}">
            </div>
            <div class="form-group">
                <label for="image">Imagen de Perfil</label>
                <input type="file" name="image" id="image" class="form-control">
                @if ($usuario->image)
                    <img src="{{ asset('storage/' . $usuario->image->url) }}" alt="Imagen de Perfil" style="width: 100px; height: 100px; object-fit: cover;">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
        </form>
    </div>
</body>
</html>
