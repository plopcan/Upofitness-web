<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Editar Usuario</h1>
    <a href="{{ route('usuarios.manage') }}" class="btn btn-secondary mb-3">Volver a la gestión de usuarios</a>

    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

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
            <label for="role">Rol</label>
            <select name="role_id" id="role" class="form-select">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $usuario->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="image">Imagen de Perfil</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($usuario->image)
                <img src="{{ asset('storage/' . $usuario->image->url) }}" alt="Imagen de Perfil" class="mt-2" style="width: 100px; height: 100px; object-fit: cover;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>