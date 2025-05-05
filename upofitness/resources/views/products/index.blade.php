<!DOCTYPE html>
<html>
<head>
    <title>Libros</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    <h1>Productos</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Disponible</th>
                <th>Categorias</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->available ? 'Yes' : 'No' }}</td>
                <td>
                    @foreach ($product->categories as $category)
                        <span class="badge badge-secondary">{{ $category->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
