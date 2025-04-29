<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return response()->json($paymentMethods);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id', // Validate usuario_id
            'card_number' => 'required|string|max:16',
            'expiration_date' => 'required|date_format:Y-m-d',
            'cvv' => 'required|string|max:4',
        ]);

        $paymentMethod = new PaymentMethod();
        $paymentMethod->usuario_id = $validatedData['usuario_id'];
        $paymentMethod->card_number = $validatedData['card_number'];
        $paymentMethod->expiration_date = $validatedData['expiration_date'];
        $paymentMethod->cvv = $validatedData['cvv'];
        $paymentMethod->save(); // Save the payment method to the database

        return redirect()->route('profile.edit')->with('success', 'Payment method created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return response()->json($paymentMethod);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'card_number' => 'required|string|max:16',
            'expiration_date' => 'required|date_format:Y-m-d',
            'cvv' => 'required|string|max:4',
        ]);

        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->update($validatedData);

        return response()->json($paymentMethod);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('profile.edit')->with('success', 'Payment method deleted successfully.');
    }
}
