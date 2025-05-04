<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Productos Deseados</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Top Productos Deseados</h1>
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Productos más deseados</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Veces Añadido a Favoritos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->wishlists_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
