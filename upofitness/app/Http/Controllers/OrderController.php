<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;
use App\Models\PromotionCode;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todos los pedidos con paginación
        $orders = Order::paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retorna la vista para crear un nuevo pedido
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida y guarda un nuevo pedido
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
            'promotion_code_id' => 'nullable|exists:promotion_codes,id',
            'address_id' => 'required|exists:addresses,id',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $address = Address::findOrFail($validated['address_id']);

        $validated['total_price'] = $product->price * $validated['quantity'];

        if (!empty($validated['promotion_code_id'])) {
            $promotionCode = PromotionCode::findOrFail($validated['promotion_code_id']);
            if ($promotionCode->uses > 0) {
                $validated['total_price'] *= (1 - $promotionCode->percentage / 100);
                $promotionCode->decrement('uses');
            }
        }

        $validated['full_address'] = "{$address->address}, {$address->city}, {$address->postal_code}, {$address->country}";

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        if ($id) {
            // Busca las órdenes donde el usuario_id coincida con el ID proporcionado
            $orders = Order::with('product')->where('usuario_id', $id)->get();
        } else {
            // Devuelve todas las órdenes
            $orders = Order::with('product')->get();
        }

        return view('orders', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Retorna la vista para editar un pedido
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Valida y actualiza un pedido existente
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
            'promotion_code_id' => 'nullable|exists:promotion_codes,id',
            'address_id' => 'required|exists:addresses,id',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $address = Address::findOrFail($validated['address_id']);

        $validated['total_price'] = $product->price * $validated['quantity'];

        $order = Order::findOrFail($id);

        if (!empty($validated['promotion_code_id'])) {
            if ($order->promotion_code_id != $validated['promotion_code_id']) {
                $promotionCode = PromotionCode::findOrFail($validated['promotion_code_id']);
                if ($promotionCode->uses > 0) {
                    $validated['total_price'] *= (1 - $promotionCode->percentage / 100);
                    $promotionCode->decrement('uses');
                }
            } else {
                $promotionCode = PromotionCode::findOrFail($validated['promotion_code_id']);
                $validated['total_price'] *= (1 - $promotionCode->percentage / 100);
            }
        }

        $validated['full_address'] = "{$address->address}, {$address->city}, {$address->postal_code}, {$address->country}";

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Elimina un pedido
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    /**
     * Display all orders for a specific user.
     */
    public function showByUserId($id)
    {
        $orders = Order::with('product')->where('usuario_id', $id)->get();
        return view('orders', compact('orders'));
    }
}
