<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Descuento | Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Crear Nuevo Descuento</h1>
            <a href="{{ route('productDiscount.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Formulario de Descuento</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('productDiscount.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Producto</label>
                        <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Porcentaje de Descuento</label>
                        <div class="input-group">
                            <input type="number" name="percentage" id="percentage" class="form-control @error('percentage') is-invalid @enderror" min="1" max="100" value="{{ old('percentage') }}" required>
                            <span class="input-group-text">%</span>
                        </div>
                        @error('percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Introduce un valor entre 1 y 100</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">Fecha de Expiración</label>
                        <input type="date" name="expiration_date" id="expiration_date" class="form-control @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date') ?? \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}" required>
                        @error('expiration_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Crear Descuento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>