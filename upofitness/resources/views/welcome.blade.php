<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="d-flex flex-column min-vh-100">
                <div class="container-fluid">
                    <header class="bg-dark text-white py-3">
                      <h1 class="text-center">BiblioGestor</h1>  
                    </header>

                    <main class="mt-6 flex-grow-1">
                        <h1>Bienvenido a la Aplicación</h1>
                        <p>Esta es una aplicación de ejemplo para gestionar personas, usuarios y libros.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">productos</a>
                        <a href="{{ route('productDiscount.index') }}" class="btn btn-primary">descuentos productos</a>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary">categorías</a>
                        <a href="{{ route('login') }}" class="btn btn-secondary">Iniciar Sesión</a> <!-- Botón añadido -->
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70 mt-auto">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
    </body>
</html>
