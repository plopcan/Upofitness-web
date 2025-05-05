<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    <h1>Editar Producto</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Descripcion</label>
            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="price">Precio</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>
        <div class="form-group">
            <label for="available">Disponible</label>
            <select name="available" id="available" class="form-control" required>
                <option value="1" {{ $product->available ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$product->available ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="categories">Categorias</label>
            <div>
                @foreach($categories as $category)
                    <div class="form-check">
                        <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" 
                               class="form-check-input" {{ $product->categories->contains($category->id) ? 'checked' : '' }}>
                        <label for="category_{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <label>Imagenes:</label>
            <div class="row">
                @foreach ($product->images as $image)
                    <div class="col-md-3">
                        <img src="{{ asset('storage/' . $image->url) }}" alt="Product Image" class="img-thumbnail mb-2">
                        <form action="{{ route('products.images.destroy', ['product' => $product->id, 'image' => $image->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
            <label for="images">Imágenes:</label>
            <input type="file" name="images[]" id="images" multiple>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
</body>
</html>
