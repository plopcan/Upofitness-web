<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Código Promocional | Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Crear Nuevo Código Promocional</h1>
            <a href="{{ route('promotion.index') }}" class="btn btn-secondary">
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
                <h5 class="mb-0">Formulario de Código Promocional</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('promotion.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="code" class="form-label">Código</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
                        <small class="text-muted">Introduce un código único (ej. VERANO25)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Porcentaje de Descuento</label>
                        <div class="input-group">
                            <input type="number" name="percentage" id="percentage" class="form-control" min="1" max="100" value="{{ old('percentage') }}" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="text-muted">Introduce un valor entre 1 y 100</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">Fecha de Expiración</label>
                        <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ old('expiration_date') ?? \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="uses" class="form-label">Número de Usos</label>
                        <input type="number" name="uses" id="uses" class="form-control" min="0" value="{{ old('uses', 100) }}" required>
                        <small class="text-muted">Número de veces que se puede usar este código</small>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Crear Código Promocional
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>