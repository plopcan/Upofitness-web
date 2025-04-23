<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(Product $product)
    {
        return redirect()->route('products.show', $product->id);
    }

    public function create(Product $product)
    {
        return redirect()->route('products.show', $product->id);
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            
            $image = new Image([
                'url' => $path,
                'product_id' => $product->id
            ]);
            
            $image->save();
            
            return redirect()->route('products.show', $product->id)
                ->with('success', 'Imagen subida correctamente');
        }
        
        return back()->with('error', 'No se pudo subir la imagen');
    }

    public function show(Product $product, Image $image)
    {
        return view('images.show', compact('product', 'image'));
    }

    public function edit(Product $product, Image $image)
    {
        return view('images.edit', compact('product', 'image'));
    }

    public function update(Request $request, Product $product, Image $image)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($image->url)) {
                Storage::disk('public')->delete($image->url);
            }
            $path = $request->file('image')->store('products', 'public');
            $image->url = $path;
            $image->save();
            
            return redirect()->route('products.show', $product->id)
                ->with('success', 'Imagen actualizada correctamente');
        }
        
        return back()->with('error', 'No se pudo actualizar la imagen');
    }

    public function destroy(Product $product, Image $image)
    {
        if (Storage::disk('public')->exists($image->url)) {
            Storage::disk('public')->delete($image->url);
        }
        
        $image->delete();
        
        return redirect()->route('products.show', $product->id)
            ->with('success', 'Imagen eliminada correctamente');
    }
    
    public function storeMultiple(Request $request, Product $product)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                
                $newImage = new Image([
                    'url' => $path,
                    'product_id' => $product->id
                ]);
                
                $newImage->save();
            }
            
            return redirect()->route('products.show', $product->id)
                ->with('success', 'Imágenes subidas correctamente');
        }
        
        return back()->with('error', 'No se pudieron subir las imágenes');
    }
}