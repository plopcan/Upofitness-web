<!DOCTYPE html>
<html>
<head>
    <title>Libros</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1>{{ $product->name }}</h1>
    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    <p><strong>Available:</strong> {{ $product->available ? 'Yes' : 'No' }}</p>
    <p><strong>Categories:</strong></p>
    <ul>
        @foreach ($product->categories as $category)
            <li>{{ $category->name }}</li>
        @endforeach
    </ul>

    <h3>Images</h3>
    @if ($product->images->count() > 0)
        <div id="productImagesCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($product->images as $key => $image)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="d-block w-100" src="{{ asset('storage/' . $image->url) }}" alt="Product Image">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#productImagesCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#productImagesCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    @else
        <p>No images available for this product.</p>
    @endif

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Back to Products</a>
</div>
</body>
</html>
