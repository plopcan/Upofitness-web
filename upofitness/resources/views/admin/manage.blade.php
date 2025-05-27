<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Upofitness</title>
    
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
                    <a href="{{ route('products.index') }}" class="btn btn-primary link-button">Productos</a>
                    <a href="{{ route('productDiscount.index') }}" class="btn btn-primary link-button">Descuentos</a>
                    <a href="{{ route('admin.topWishlistProducts') }}" class="btn btn-primary link-button">Top Favoritos</a>
                    <a href="{{ route('promotion.index') }}" class="btn btn-primary link-button">Promociones</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="page-title mb-0">Gestión de Usuarios</h1>
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
            
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <a href="{{ route('register') }}" class="btn btn-success">
                    <i class="bi bi-person-plus-fill me-1"></i> Registrar Nuevo Usuario
                </a>
                
                <!-- Opcional: Filtros y búsqueda -->
                <div class="d-flex gap-2 mt-3 mt-md-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar usuario..." id="searchInput">
                        <button class="btn btn-primary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card card-background shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Listado de Usuarios</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="align-middle">
                                            @php
                                                $imageUrl = null;
                                                if ($usuario->image_id && $usuario->image) {
                                                    $imageUrl = asset('storage/' . $usuario->image->url);
                                                }
                                            @endphp
                                            <img src="{{ $imageUrl ?? 'https://via.placeholder.com/40' }}" 
                                                 alt="Perfil de {{ $usuario->name }}" 
                                                 class="rounded-circle" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        </td>
                                        <td class="align-middle">{{ $usuario->name }}</td>
                                        <td class="align-middle">{{ $usuario->email }}</td>
                                        <td class="align-middle">{{ $usuario->phone ?? 'No disponible' }}</td>
                                        <td class="align-middle">
                                            <span class="badge bg-{{ $usuario->role->name === 'administrador' ? 'danger' : 'info' }}">
                                                {{ ucfirst($usuario->role->name) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-fill"></i> Editar
                                                </a>
                                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('¿Está seguro que desea eliminar a {{ $usuario->name }}?')">
                                                        <i class="bi bi-trash-fill"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Paginación -->
            @if(method_exists($usuarios, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $usuarios->links() }}
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
    
    <!-- Script para búsqueda en tabla -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tr');
            
            searchInput.addEventListener('keyup', function() {
                const searchText = searchInput.value.toLowerCase();
                
                for (let i = 1; i < rows.length; i++) {
                    const rowData = rows[i].textContent.toLowerCase();
                    rows[i].style.display = rowData.includes(searchText) ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>