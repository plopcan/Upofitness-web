<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Códigos Promocionales | Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Códigos Promocionales</h1>
            <a href="{{ route('welcome') }}" class="btn btn-secondary">
                <i class="bi bi-house-fill"></i> Volver a inicio
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

        <!-- Botón para crear nuevo código promocional -->
        <div class="mb-4">
            <a href="{{ route('promotion.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Crear Nuevo Código Promocional
            </a>
        </div>

        <!-- Tabla de códigos promocionales -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Códigos Promocionales Activos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Porcentaje</th>
                                <th>Fecha de Expiración</th>
                                <th>Usos Restantes</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($promotionCodes as $code)
                                <tr>
                                    <td>{{ $code->id }}</td>
                                    <td>{{ $code->code }}</td>
                                    <td>{{ $code->percentage }}%</td>
                                    <td>{{ \Carbon\Carbon::parse($code->expiration_date)->format('d/m/Y') }}</td>
                                    <td>{{ $code->uses }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('promotion.edit', $code->id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                            <form action="{{ route('promotion.destroy', $code->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este código promocional?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay códigos promocionales disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>