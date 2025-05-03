<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Address;
use App\Models\PaymentMethod;
use App\Models\PromotionCode;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;

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
            return response()->view('cart', ['error' => 'Debes iniciar sesión para acceder al carrito.']);
        }

        $cart = Cart::with('products')->where('usuario_id', $id)->first();
        
        if (!$cart) {
            $cart = Cart::create(['usuario_id' => $id]);
        }

        // Obtener las direcciones del usuario
        $addresses = Address::where('usuario_id', $id)->get();
        
        // Obtener los métodos de pago del usuario
        $paymentMethods = PaymentMethod::where('usuario_id', $id)->get();

        return view('cart', compact('cart', 'addresses', 'paymentMethods'));
    }

    public function checkout(Request $request)
    {
        $userId = Auth::id(); // Obtenemos el ID del usuario autenticado
        
        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para finalizar la compra.');
        }

        $cart = Cart::with('products')->where('usuario_id', $userId)->first();

        if (!$cart || $cart->products->isEmpty()) {
            return redirect()->route('cart.showByUserId', ['id' => $userId])
                ->with('error', 'El carrito está vacío.');
        }

        // Validar los datos del formulario
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'promo_code' => 'nullable|string',
        ]);

        // Obtener la dirección y el método de pago
        $address = Address::findOrFail($validated['address_id']);
        $paymentMethod = PaymentMethod::findOrFail($validated['payment_method_id']);

        // Calcular el total del carrito
        $subtotal = $cart->products->sum(function($product) {
            return $product->price * $product->pivot->quantity;
        });

        // Aplicar descuento si hay un código promocional
        $promotionCodeId = null;
        $total = $subtotal;
        
        if (!empty($request->input('promo_code'))) {
            $code = $request->input('promo_code');
            $promotionCode = PromotionCode::where('code', $code)
                ->where('expiration_date', '>=', now())
                ->where(function($query) {
                    $query->where('uses', '>', 0)
                          ->orWhereNull('uses');
                })
                ->first();

            if ($promotionCode) {
                // Aplicar el descuento
                $total = $subtotal * (1 - ($promotionCode->percentage / 100));
                $promotionCodeId = $promotionCode->id;
                
                // Decrementar el número de usos si es necesario
                if (!is_null($promotionCode->uses)) {
                    $promotionCode->decrement('uses');
                }
            }
        }

        // Preparamos los datos para la orden con todos los campos requeridos
        $order = new Order();
        $order->full_address = "{$address->address}, {$address->city}, {$address->postal_code}, {$address->country}";
        $order->total = round($total, 2);
        $order->status = 'pendiente';
        $order->purchase_date = now(); // Al asignar directamente, Laravel manejará el formato
        $order->quantity = $cart->products->sum('pivot.quantity');
        $order->usuario_id = $userId;
        $order->product_id = $cart->products->first()->id;
        
        if ($promotionCodeId) {
            $order->promotion_code_id = $promotionCodeId;
        }
        
        // Guardar el objeto
        $order->save();

        // Asociar los productos a la orden (si tienes una tabla pivot order_product)
        foreach ($cart->products as $product) {
            // Si tienes una relación muchos a muchos entre Order y Product
            if (method_exists($order, 'products')) {
                $order->products()->attach($product->id, [
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->price
                ]);
            }
        }

        // Crear el pago asociado a la orden
        $payment = Payment::create([
            'orders_id' => $order->id,
            'card_number' => $paymentMethod->card_number,
            'expiration_date' => $paymentMethod->expiration_date,
            'payment_status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Generar la factura automáticamente
        $invoice = Invoice::create([
            'issue_date' => now(),
            'tax_percentage' => 21, // IVA estándar en España
            'total_amount' => $total,
            'orders_id' => $order->id,
        ]);
        // Obtener el usuario actual
        $usuario = Usuario::find($userId);
        
        // Cargar la relación del código promocional si existe
        if ($promotionCodeId) {
            $order->load('promotion_code');
        }

        try {
            // Enviar correo directamente en lugar de usar notificaciones
            Mail::to($usuario->email)
                ->send(new OrderConfirmationMail($order, $usuario->name));
            \Log::info('Correo enviado correctamente a: ' . $usuario->email);
        } catch (\Exception $e) {
            \Log::error('Error al enviar correo de confirmación: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        }
        
        // Vaciar el carrito después del pago
        $cart->products()->detach();
        
        // Limpiar la sesión del código promocional
        session()->forget(['appliedPromoCode', 'discountPercentage']);

        // Redirigir a la página de pedidos del usuario, asegurándonos de incluir el ID
        return redirect()->route('orders.showByUserId', ['id' => $userId])
            ->with('success', 'Pago realizado con éxito. Le hemos enviado un email, ¡Gracias por tu compra!');
    }

    public function addToCart(Request $request, $productId)
    {
        // Si el usuario está autenticado, usar Auth::id()
        if (Auth::check()) {
            $userId = Auth::id();
        } 
        // Si no está autenticado, intentar obtener el ID de la sesión o request
        else {
            $userId = $request->input('usuario_id') ?? session('usuario_id');
            
            // Si no hay ID de usuario, redirigir al login
            if (!$userId) {
                return redirect()->route('login')->with('error', 'Debes iniciar sesión para añadir productos al carrito');
            }
        }
        
        // Obtener o crear el carrito para el usuario
        $cart = Cart::firstOrCreate(['usuario_id' => $userId]);
        
        // Verificar si el producto ya está en el carrito
        $existingProduct = $cart->products()->where('product_id', $productId)->first();
        
        if ($existingProduct) {
            // Si ya existe, actualizar la cantidad
            $newQuantity = $existingProduct->pivot->quantity + $request->input('quantity', 1);
            $cart->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
        } else {
            // Si no existe, añadirlo con la cantidad especificada
            $cart->products()->attach($productId, ['quantity' => $request->input('quantity', 1)]);
        }
        
        return redirect()->back()->with('success', 'Producto añadido al carrito correctamente');
    }

    public function updateQuantity(Request $request, $productId, $action)
    {
        $cart = Cart::firstOrCreate(['usuario_id' => Auth::id()]);

        $product = $cart->products()->where('product_id', $productId)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'El producto no existe en el carrito.');
        }

        $currentQuantity = $product->pivot->quantity;

        if ($action === 'increase') {
            $cart->products()->updateExistingPivot($productId, ['quantity' => $currentQuantity + 1]);
        } elseif ($action === 'decrease' && $currentQuantity > 1) {
            $cart->products()->updateExistingPivot($productId, ['quantity' => $currentQuantity - 1]);
        } elseif ($action === 'decrease' && $currentQuantity === 1) {
            $cart->products()->detach($productId);
        }

        return redirect()->back();
    }

    public function applyPromoCode(Request $request)
    {
        $code = $request->input('promo_code');
        
        if (!$code) {
            return redirect()->back()->with('promo_message', 'Por favor, introduce un código promocional.')->with('promo_valid', false);
        }
        
        // Buscar el código promocional en la base de datos
        $promotionCode = PromotionCode::where('code', $code)
            ->where('expiration_date', '>=', now())
            ->where(function($query) {
                $query->where('uses', '>', 0)
                      ->orWhereNull('uses');
            })
            ->first();
        
        if ($promotionCode) {
            // Guardar información del código promocional en la sesión
            session(['appliedPromoCode' => $code]);
            session(['discountPercentage' => $promotionCode->percentage]);
            
            return redirect()->back()
                ->with('promo_message', "¡Código aplicado! {$promotionCode->percentage}% de descuento.")
                ->with('promo_valid', true)
                ->with('success', "Código promocional aplicado correctamente.");
        } else {
            return redirect()->back()
                ->with('promo_message', 'Código promocional inválido o expirado.')
                ->with('promo_valid', false);
        }
    }
}
