<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Códigos Promocionales | Upofitness</title>
    
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
                    <a href="{{ route('promotion.index') }}" class="btn btn-primary link-button active">Promociones</a>
                    <a href="{{ route('admin.topWishlistProducts') }}" class="btn btn-primary link-button">Top Favoritos</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="page-title mb-0">Gestión de Códigos Promocionales</h1>
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('promotion.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Crear Nuevo Código Promocional
                </a>
            </div>

            <div class="card card-background shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-ticket-perforated-fill me-2"></i>Códigos Promocionales Activos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
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
                                        <td class="align-middle">{{ $code->id }}</td>
                                        <td class="align-middle">
                                            <span class="fw-bold">{{ $code->code }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-success">{{ $code->percentage }}%</span>
                                        </td>
                                        <td class="align-middle">
                                            @php
                                                $expirationDate = \Carbon\Carbon::parse($code->expiration_date);
                                                $isExpired = $expirationDate->isPast();
                                            @endphp
                                            
                                            <span class="{{ $isExpired ? 'text-danger' : '' }}">
                                                {{ $expirationDate->format('d/m/Y') }}
                                                @if($isExpired)
                                                    <i class="bi bi-exclamation-circle ms-1"></i>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            @if($code->uses > 0)
                                                <span class="badge bg-{{ $code->uses > 10 ? 'info' : 'warning' }}">{{ $code->uses }}</span>
                                            @else
                                                <span class="badge bg-danger">Agotado</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('promotion.edit', $code->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                <form action="{{ route('promotion.destroy', $code->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro que desea eliminar el código promocional {{ $code->code }}?');">
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
                                        <td colspan="6" class="text-center py-4">
                                            <i class="bi bi-ticket-perforated text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mt-2 mb-0">No hay códigos promocionales disponibles</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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