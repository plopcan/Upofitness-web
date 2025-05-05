<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Código Promocional | Upofitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Editar Código Promocional</h1>
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
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Formulario de Edición</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('promotion.update', $promotionCode->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="code" class="form-label">Código</label>
                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $promotionCode->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Porcentaje de Descuento</label>
                        <div class="input-group">
                            <input type="number" name="percentage" id="percentage" class="form-control @error('percentage') is-invalid @enderror" min="1" max="100" value="{{ old('percentage', $promotionCode->percentage) }}" required>
                            <span class="input-group-text">%</span>
                        </div>
                        @error('percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">Fecha de Expiración</label>
                        <input type="date" name="expiration_date" id="expiration_date" class="form-control @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date', \Carbon\Carbon::parse($promotionCode->expiration_date)->format('Y-m-d')) }}" required>
                        @error('expiration_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="uses" class="form-label">Número de Usos Restantes</label>
                        <input type="number" name="uses" id="uses" class="form-control @error('uses') is-invalid @enderror" min="0" value="{{ old('uses', $promotionCode->uses) }}" required>
                        @error('uses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Actualizar Código Promocional
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>