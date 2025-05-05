<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Categoria</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Actualizar Categoria</h1>
        <form action="{{ route('categories.update', $category->id) }}" method="POST" onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                <div id="nameError" class="text-danger" style="display: none;">El nombre es obligatorio.</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripcion</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $category->description }}</textarea>
                <div id="descriptionError" class="text-danger" style="display: none;">La descripcion es obligatoria.</div>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Categoria</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script>
        function validateForm() {
            let isValid = true;
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();

            document.getElementById('nameError').style.display = name ? 'none' : 'block';
            document.getElementById('descriptionError').style.display = description ? 'none' : 'block';

            if (!name || !description) {
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>
</html>