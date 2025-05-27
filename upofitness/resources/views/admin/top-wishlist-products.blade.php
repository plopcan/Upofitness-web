<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Productos Favoritos | Upofitness</title>
    
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
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="page-title mb-0">Top Productos Favoritos</h1>
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al inicio
                </a>
            </div>
            
            <div class="card card-background shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-heart-fill me-2"></i>Productos más añadidos a favoritos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">#</th>
                                    <th>Producto</th>
                                    <th class="text-center">Veces Añadido a Favoritos</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $index => $product)
                                    <tr>
                                        <td class="align-middle">
                                            @if($index < 3)
                                                <span class="badge {{ $index === 0 ? 'bg-warning text-dark' : ($index === 1 ? 'bg-secondary' : 'bg-primary') }}">
                                                    {{ $index + 1 }}
                                                </span>
                                            @else
                                                <span class="text-muted">{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                @if(isset($product->images) && $product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->url) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="me-2" 
                                                         style="width: 50px; height: 50px; object-fit: contain; border-radius: 4px;">
                                                @else
                                                    <div class="me-2 d-flex align-items-center justify-content-center bg-light" 
                                                         style="width: 50px; height: 50px; border-radius: 4px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                                    @if(isset($product->stock))
                                                        <small class="text-muted">Stock: {{ $product->stock }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="mb-1">
                                                    <i class="bi bi-heart-fill text-danger"></i> × {{ $product->wishlists_count }}
                                                </div>
                                                <div class="progress" style="height: 6px; width: 80%;">
                                                    <div class="progress-bar bg-danger" 
                                                         role="progressbar" 
                                                         style="width: {{ min(100, ($product->wishlists_count / ($topProducts->first()->wishlists_count ?: 1)) * 100) }}%" 
                                                         aria-valuenow="{{ $product->wishlists_count }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="{{ $topProducts->first()->wishlists_count }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye"></i> Ver producto
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="bi bi-heart text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mt-2 mb-0">No hay datos de favoritos disponibles</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-background shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Estadísticas de Favoritos</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total de productos en favoritos
                                    <span class="badge bg-primary rounded-pill">{{ $topProducts->sum('wishlists_count') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Número de productos únicos
                                    <span class="badge bg-info rounded-pill">{{ $topProducts->count() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Promedio de favoritos por producto
                                    <span class="badge bg-success rounded-pill">{{ $topProducts->count() > 0 ? round($topProducts->sum('wishlists_count') / $topProducts->count(), 1) : 0 }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card card-background shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Recomendaciones</h5>
                        </div>
                        <div class="card-body">
                            <p>Basado en los datos de favoritos, considere:</p>
                            <ul class="mb-0">
                                <li>Crear promociones especiales para los productos más populares</li>
                                <li>Considerar aumentar el stock de los productos top</li>
                                <li>Analizar las categorías más populares para futuras adquisiciones</li>
                                <li>Usar estos datos para mejorar las recomendaciones a los usuarios</li>
                            </ul>
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
