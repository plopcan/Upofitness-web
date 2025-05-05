<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDiscount;
use App\Models\Product;

class ProductDiscountController extends Controller
{
    public function index()
    {
        $discounts = ProductDiscount::with('product')->get();
        return view('productDiscount.index', compact('discounts'));
    }

    public function show($id)
    {
        $discount = ProductDiscount::with('product')->find($id);
        if (!$discount) {
            return redirect()->route('productDiscount.index')->with('error', 'Discount not found');
        }
        return view('productDiscount.show', compact('discount'));
    }

    public function create()
    {
        $products = Product::all();
        return view('productDiscount.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'percentage' => 'required|numeric|min:0|max:100',
            'expiration_date' => 'required|date|after:today',
            'name' => 'required|string|max:255|unique:product_discounts,name',
        ]);

        ProductDiscount::create($validatedData);

        return redirect()->route('productDiscount.index')->with('success', 'Discount created successfully');
    }

    public function edit($id)
    {
        $discount = ProductDiscount::find($id);
        if (!$discount) {
            return redirect()->route('productDiscount.index')->with('error', 'Discount not found');
        }
        $products = Product::all();
        return view('productDiscount.edit', compact('discount', 'products'));
    }

    public function update(Request $request, $id)
    {
        $discount = ProductDiscount::find($id);
        if (!$discount) {
            return redirect()->route('productDiscount.index')->with('error', 'Discount not found');
        }

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'percentage' => 'required|numeric|min:0|max:100',
            'expiration_date' => 'required|date|after:today',
            'name' => 'required|string|max:255|unique:product_discounts,name,' . $discount->id,
        ]);

        $discount->update($validatedData);

        return redirect()->route('productDiscount.index')->with('success', 'Discount updated successfully');
    }

    public function destroy($id)
    {
        $discount = ProductDiscount::find($id);
        if (!$discount) {
            return redirect()->route('productDiscount.index')->with('error', 'Discount not found');
        }

        $discount->delete();

        return redirect()->route('productDiscount.index')->with('success', 'Discount deleted successfully');
    }

    public function applyDiscounts()
    {
        $discounts = ProductDiscount::with('product')->where('expiration_date', '>', now())->get();

        foreach ($discounts as $discount) {
            $product = $discount->product;
            if ($product) {
                $discountedPrice = $product->price * (1 - ($discount->percentage / 100));
                $product->update(['price' => round($discountedPrice, 2)]);
            }
        }

        return redirect()->route('productDiscount.index')->with('success', 'Discounts applied successfully to products.');
    }
}
