<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar aquí... -->
    
    <main class="mt-6 flex-grow-1">
        <div class="container">
            <h1 class="text-center mb-4">{{ $product->name }}</h1>
            
            <div class="row">
                <div class="col-md-6">
                    @if($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->url) }}" 
                             class="img-fluid" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/400" 
                             class="img-fluid" alt="{{ $product->name }}">
                    @endif
                    
                    @if($product->images->count() > 1)
                        <div class="product-gallery d-flex overflow-auto py-2">
                            @foreach($product->images as $image)
                                <div class="product-thumbnail mx-1">
                                    <img src="{{ asset('storage/' . $image->url) }}" 
                                         alt="Imagen del producto"
                                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6">
                    <p>{{ $product->description }}</p>
                    <p><strong>Precio:</strong> ${{ $product->price }}</p>
                    <p><strong>Stock:</strong> {{ $product->stock }}</p>
                    <p><strong>Categorías:</strong> 
                        @if($product->categories->isNotEmpty())
                            @foreach($product->categories as $category)
                                <span class="badge bg-primary">{{ $category->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">Sin categoría</span>
                        @endif
                    </p>
                    @auth
                        <a href="{{ route('cart.add', ['productId' => $product->id]) }}" class="btn btn-primary">Añadir al carrito</a>
                        <form action="{{ route('wishlist.add', ['productId' => $product->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Añadir a la lista de deseos</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
            
            <div class="mt-4">
                <h3>Añadir imagen al producto</h3>
                <form action="{{ route('products.images.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="image">Seleccionar imagen</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Subir imagen</button>
                </form>
            </div>
            
            <div class="mt-4">
                <h3>Subir múltiples imágenes</h3>
                <form action="{{ route('products.images.storeMultiple', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="images">Seleccionar imágenes</label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir imágenes</button>
                </form>
            </div>
            
            {{-- Formulario de valoración --}}
            <div class="mt-4">
                <h3>Valora este producto</h3>
                @auth
                    <form action="{{ route('valoraciones.storeOrUpdate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="producto_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label for="puntuacion" class="form-label">Puntuación</label>
                            <select name="puntuacion" id="puntuacion" class="form-control" required>
                                <option value="">Selecciona una puntuación</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="comentario" class="form-label">Comentario</label>
                            <textarea name="comentario" id="comentario" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Enviar valoración</button>
                    </form>
                @else
                    <p><a href="{{ route('login') }}">Inicia sesión</a> para valorar este producto.</p>
                @endauth
            </div>
        </div>
    </main>
    
    <!-- Footer aquí... -->
</body>
</html>