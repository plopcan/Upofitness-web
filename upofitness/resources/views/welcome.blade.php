<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Upofitness</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <header class="navbar-style-7 position-relative bg-dark text-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <h1 class="text-center">Upofitness</h1>
                <nav>
                    <a href="{{ route('products.index') }}" class="btn btn-primary link-button">Productos</a>
                    <a href="{{ route('productDiscount.index') }}" class="btn btn-primary link-button">Descuentos Productos</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary link-button">Categorías</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary link-button">Iniciar Sesión</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mt-6 flex-grow-1">
        <section class="header-style-1">
            <div class="header-big">
                <div class="header-items-active">
                    <div class="single-header-item bg_cover"
                        style="background-image: url('assets/images/header-1/header-big-1.jpg');">
                        <div class="header-item-content text-center">
                            <h3 class="title">Bienvenido a Upofitness</h3>
                            <p>Gestiona personas, usuarios y libros de manera eficiente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="py-16 text-center text-sm text-black dark:text-white/70 mt-auto bg-dark text-white">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="font-weight-bold">Sobre Nosotros</h5>
                    <p>Upofitness es una plataforma dedicada a mejorar tu bienestar físico y mental. Ofrecemos productos, servicios y recursos para ayudarte a alcanzar tus metas.</p>
                </div>
                <!-- Quick Links -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="font-weight-bold">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('products.index') }}" class="text-white">Productos</a></li>
                        <li><a href="{{ route('categories.index') }}" class="text-white">Categorías</a></li>
                        <li><a href="{{ route('login') }}" class="text-white">Iniciar Sesión</a></li>

                    </ul>
                </div>
                <!-- Contact Info -->
                <div class="col-lg-4 col-md-12">
                    <h5 class="font-weight-bold">Contáctanos</h5>
                    <p><i class="mdi mdi-phone"></i> +34 123 456 789</p>
                    <p><i class="mdi mdi-email"></i> soporte@upofitness.com</p>
                    <p><i class="mdi mdi-map-marker"></i> Calle Ejemplo 123, Sevilla, España</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0">© {{ date('Y') }} Upofitness. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
