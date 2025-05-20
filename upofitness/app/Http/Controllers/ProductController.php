<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(20);
        $categories = Category::all();
        return view('producto', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('producto-detalle', compact('product'));
    }

    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'available' => 'required|boolean',
            'categories' => 'array', // Validate categories as an array
            'categories.*' => 'exists:categories,id', // Ensure each category exists,
            'images.*' => 'image|mimes:jpeg,png,jpg,gif', // Validación de imágenes
        ]);

        $product = Product::create($validatedData);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories); // Sync categories
        }
    // Subir y guardar las imágenes
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('images', 'public'); // Guardar en storage/app/public/images
            $product->images()->create(['url' => $path]);
        }
    } else {
        \Log::info('No images found in the request.');
    }
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $categories = Category::all(); // Fetch all categories
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'available' => 'sometimes|required|boolean',
            'categories' => 'array', // Validate categories as an array
            'categories.*' => 'exists:categories,id', // Ensure each category exists
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de imágenes
        ]);

        $product->update($validatedData);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories); // Sync categories
        }

    // Subir y guardar las imágenes
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            \Log::info('Uploading image: ' . $image->getClientOriginalName());
            $path = $image->store('images', 'public'); // Guardar en storage/app/public/images
            $product->images()->create(['url' => $path]);
        }
    } else {
        \Log::info('No images found in the request.');
    }
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function deleteImage($productId, $imageId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $image = $product->images()->find($imageId);

        if (!$image) {
            return redirect()->route('products.edit', $productId)->with('error', 'Image not found');
        }

        // Eliminar el archivo de almacenamiento
        \Storage::delete('public/' . $image->url);

        // Eliminar el registro de la base de datos
        $image->delete();

        return redirect()->route('products.edit', $productId)->with('success', 'Image deleted successfully');
    }

    public function filterByCategory(Request $request)
    {
        $categoryIds = $request->input('categories', []);

        if (empty($categoryIds)) {
            // Si no hay categorías seleccionadas, mostrar todos los productos
            $products = Product::paginate(9);
        } else {
            // Filtrar productos que pertenezcan a las categorías seleccionadas
            $products = Product::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })->paginate(9);
        }

        // Obtener todas las categorías para el filtro
        $categories = Category::all();

        return view('producto', compact('products', 'categories'));
    }
}
