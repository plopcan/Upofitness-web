<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Invoice::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'orders_id' => 'required|array',
            'tax_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $orders = Order::whereIn('id', $request->orders_id)->get();
        $totalOrdersAmount = $orders->sum('total_price');
        $taxAmount = $totalOrdersAmount * ($request->tax_percentage / 100);
        $totalAmount = $totalOrdersAmount + $taxAmount;

        $invoice = Invoice::create([
            'issue_date' => now(),
            'tax_percentage' => $request->tax_percentage,
            'total_amount' => $totalAmount,
            'orders_id' => json_encode($request->orders_id),
        ]);

        return response()->json($invoice, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with('order.product')->findOrFail($id); // Carga el pedido y su producto relacionado
        $order = $invoice->order; // Obtiene el pedido directamente
        return view('invoice', compact('invoice', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $invoice = Invoice::findOrFail($id);

        if ($request->has('tax_percentage')) {
            $orders = Order::whereIn('id', json_decode($invoice->orders_id))->get();
            $totalOrdersAmount = $orders->sum('total_price');
            $taxAmount = $totalOrdersAmount * ($request->tax_percentage / 100);
            $invoice->total_amount = $totalOrdersAmount + $taxAmount;
            $invoice->tax_percentage = $request->tax_percentage;
        }

        $invoice->save();

        return response()->json($invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}
