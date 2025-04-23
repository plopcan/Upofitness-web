<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        return view('carts.index', compact('carts'));
    }

    public function create()
    {
        return view('carts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        Cart::create($request->all());

        return redirect()->route('carts.index')->with('success', 'Cart created successfully.');
    }

    public function edit(Cart $cart)
    {
        return view('carts.edit', compact('cart'));
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $cart->update($request->all());

        return redirect()->route('carts.index')->with('success', 'Cart updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('carts.index')->with('success', 'Cart deleted successfully.');
    }

    public function showByUserId($id)
    {
        // Verificar si el ID es nulo o si el usuario no está autenticado
        if ($id === null) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder al carrito.');
        }

        $cart = Cart::with('products')->where('usuario_id', $id)->first();

        if (!$cart) {
            return redirect()->route('productos.index')->with('error', 'El carrito está vacío.');
        }

        return view('cart', compact('cart'));
    }
}
