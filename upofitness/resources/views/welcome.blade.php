<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('messages.title') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/bootstrap.bundle.js'])
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="navbar-style-7 position-relative text-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/logo.png') }}" alt="Upofitness Logo" class="logo">
                </a>
                <nav>
                    <a href="{{ route('products.index') }}" class="btn btn-primary link-button">{{ __('messages.products') }}</a>
                    @auth
                        @if(Auth::user()->role->name === 'administrador')
                    <a href="{{ route('productDiscount.index') }}" class="btn btn-primary link-button">{{ __('messages.product_discounts') }}</a>
                            <a href="{{ route('categories.index') }}" class="btn btn-primary link-button">{{ __('messages.categories') }}</a>
                            <a href="{{ route('usuarios.manage') }}" class="btn btn-primary link-button">{{__('messages.user')}}</a>
                            <a href="{{ route('promotion.index') }}" class="btn btn-primary link-button">Códigos Promocionales</a>
                            <a href="{{ route('admin.topWishlistProducts') }}" class="btn btn-primary link-button">{{__('messages.top_wishlist_products')}}</a>
                        @endif
                        <a href="{{ route('cart.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button">{{ __('messages.cart') }}</a>
                        <a href="{{ route('wishlist.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button">{{ __('messages.wishlist') }}</a>
                        <a href="{{ route('orders.showByUserId', ['id' => Auth::user()->id]) }}" class="btn btn-primary link-button">@lang('messages.orders_invoices')</a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary link-button">{{ __('messages.logout') }}</button>
                        </form>
                        <a href="{{ route('profile.edit') }}" class="profile-button">
                            @php
                                $imageUrl = null;
                                if (Auth::user()->image_id && Auth::user()->image) {
                                    $imageUrl = asset('storage/' . Auth::user()->image->url);
                                }
                            @endphp
                            <img src="{{ $imageUrl ?? 'https://via.placeholder.com/50' }}" 
                                 alt="Perfil" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-secondary link-button">{{__('messages.login')}}</a> <!-- Add login button for unauthenticated users -->
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="mt-6 flex-grow-1">
        <h1>
            @auth
                {{ __('messages.welcome_user', ['name' => Auth::user()->name]) }}
            @else
                {{ __('messages.welcome_guest') }}
            @endauth
        </h1>
        <p>
            @auth
                {{ __('messages.main_page_user') }}
            @else
                {{ __('messages.main_page_guest') }}
            @endauth
        </p>

        <!-- Carousel for latest products -->
        <section class="carousel-section my-5">
            <div id="latestProductsCarousel" class="carousel slide bg-secondary p-3 rounded" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($latestProducts as $index => $product)
                        <button 
                            type="button" 
                            data-bs-target="#latestProductsCarousel" 
                            data-bs-slide-to="{{ $index }}" 
                            class="{{ $index === 0 ? 'active' : '' }}" 
                            @if ($index === 0) aria-current="true" @endif 
                            aria-label="Slide {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach ($latestProducts as $index => $product)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            @if ($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->url) }}" 
                                     class="d-block mx-auto" 
                                     alt="{{ $product->name }}" 
                                     style="height: 300px; width: auto; max-width: 80%; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/800x400" 
                                     class="d-block mx-auto" 
                                     alt="Placeholder Image" 
                                     style="height: 300px; width: auto; max-width: 80%; object-fit: cover;">
                            @endif
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $product->name }}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#latestProductsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#latestProductsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        <!-- End of Carousel -->
        

    </main>

    <!-- Footer -->
    <footer class="py-16 text-center text-sm text-black dark:text-white/70 mt-auto text-white">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="font-weight-bold">{{ __('messages.about_us') }}</h5>
                    <p>{{ __('messages.about_us_description') }}</p>
                </div>
                <!-- Quick Links -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="font-weight-bold">{{ __('messages.quick_links') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('products.index') }}" class="text-white">{{ __('messages.products') }}</a></li>
                        @auth
                        <li><a href="{{ route('categories.index') }}" class="text-white">{{ __('messages.categories') }}</a></li>
                            <li><a href="{{ route('cart.showByUserId', ['id' => Auth::user()->id]) }}" class="text-white">{{ __('messages.cart') }}</a></li>
                            <li><a href="{{ route('wishlist.showByUserId', ['id' => Auth::user()->id]) }}" class="text-white">{{ __('messages.wishlist') }}</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-white">{{__('messages.login')}}</a></li>
                        @endauth
                    </ul>
                </div>
                <!-- Contact Info -->
                <div class="col-lg-4 col-md-12">
                    <h5 class="font-weight-bold">{{ __('messages.contact_us') }}</h5>
                    <p><i class="mdi mdi-phone"></i> {{ __('messages.phone') }}</p>
                    <p><i class="mdi mdi-email"></i> {{ __('messages.email') }}</p>
                    <p><i class="mdi mdi-map-marker"></i> {{ __('messages.address') }}</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0">© {{ date('Y') }} {{ __('messages.copyright') }}</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>