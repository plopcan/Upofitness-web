<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario | Upofitness</title>
    
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
                <h1 class="page-title mb-0">Editar Usuario</h1>
                <a href="{{ route('usuarios.manage') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la gestión de usuarios
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card card-background shadow-sm">
                        <div class="card-body text-center p-4">
                            @php
                                $imageUrl = null;
                                if ($usuario->image_id && $usuario->image) {
                                    $imageUrl = asset('storage/' . $usuario->image->url);
                                }
                            @endphp
                            <img src="{{ $imageUrl ?? 'https://via.placeholder.com/150' }}" 
                                 alt="Imagen de Perfil" 
                                 class="rounded-circle mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <h4 class="mb-1">{{ $usuario->name }}</h4>
                            <p class="text-muted">{{ $usuario->email }}</p>
                            
                            <div class="mt-3 d-flex flex-column gap-2">
                                <div class="badge bg-{{ $usuario->role->name === 'administrador' ? 'danger' : 'info' }} py-2">
                                    <i class="bi bi-person-badge me-1"></i> {{ ucfirst($usuario->role->name) }}
                                </div>
                                @if($usuario->phone)
                                    <p class="mb-0">
                                        <i class="bi bi-telephone me-2"></i>{{ $usuario->phone }}
                                    </p>
                                @endif
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar3 me-2"></i>Miembro desde {{ $usuario->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <div class="card card-background shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Información del Usuario</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $usuario->name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $usuario->phone }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Rol</label>
                                        <select name="role_id" id="role" class="form-select">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ $usuario->role_id == $role->id ? 'selected' : '' }}>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="image" class="form-label">Imagen de Perfil</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    <div class="form-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB.</div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('usuarios.manage') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card card-background shadow-sm mt-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información Adicional</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>ID de Usuario:</strong> {{ $usuario->id }}</p>
                                    <p><strong>Creado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                                    <p><strong>Actualizado:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Número de Direcciones:</strong> {{ $usuario->addresses->count() }}</p>
                                    <p><strong>Número de Pedidos:</strong> {{ $usuario->orders->count() }}</p>
                                    <p><strong>Métodos de Pago:</strong> {{ $usuario->paymentMethods->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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