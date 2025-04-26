<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function showByUserId($id)
    {
        // Verificar si el ID es nulo o si el usuario no está autenticado
        if ($id === null) {
            return response()->view('wishlist', ['error' => 'Debes iniciar sesión para acceder a la lista de deseos.']);
        }

        $wishlist = Wishlist::with('products')->where('usuario_id', $id)->first();

        if (!$wishlist) {
            // Si el usuario no tiene una lista de deseos, creamos una
            $wishlist = Wishlist::create([
                'usuario_id' => $id
            ]);
        }

        return view('wishlist', compact('wishlist'));
    }

    public function addToWishlist(Request $request, $productId)
    {
        // Verificar si el usuario está logueado
        if (!session('usuario_id')) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para añadir productos a la lista de deseos.');
        }

        // Obtener o crear la lista de deseos del usuario
        $wishlist = Wishlist::firstOrCreate(['usuario_id' => session('usuario_id')]);

        // Verificar si el producto existe
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'El producto no existe.');
        }

        // Verificar si el producto ya está en la lista de deseos
        if ($wishlist->products()->where('product_id', $productId)->exists()) {
            return redirect()->back()->with('info', 'Este producto ya está en tu lista de deseos.');
        }

        // Añadir el producto a la lista de deseos
        $wishlist->products()->attach($productId);

        return redirect()->back()->with('success', 'Producto añadido a la lista de deseos con éxito.');
    }

    public function removeFromWishlist(Request $request, $productId)
    {
        // Verificar si el usuario está logueado
        if (!session('usuario_id')) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para eliminar productos de la lista de deseos.');
        }

        // Obtener la lista de deseos del usuario
        $wishlist = Wishlist::where('usuario_id', session('usuario_id'))->first();

        if (!$wishlist) {
            return redirect()->back()->with('error', 'No tienes una lista de deseos.');
        }

        // Eliminar el producto de la lista de deseos
        $wishlist->products()->detach($productId);

        return redirect()->back()->with('success', 'Producto eliminado de la lista de deseos con éxito.');
    }

    public function clearWishlist()
    {
        // Verificar si el usuario está logueado
        if (!session('usuario_id')) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para vaciar la lista de deseos.');
        }

        // Obtener la lista de deseos del usuario
        $wishlist = Wishlist::where('usuario_id', session('usuario_id'))->first();

        if (!$wishlist) {
            return redirect()->back()->with('error', 'No tienes una lista de deseos.');
        }

        // Vaciar la lista de deseos
        $wishlist->products()->detach();

        return redirect()->back()->with('success', 'Lista de deseos vaciada con éxito.');
    }
}