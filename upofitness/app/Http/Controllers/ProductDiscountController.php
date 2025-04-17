<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDiscount;
use Illuminate\Support\Facades\Validator;

class ProductDiscountController extends Controller
{
    public function index()
    {
        $discounts = ProductDiscount::all();
        return response()->json($discounts);
    }

    public function show($id)
    {
        $discount = ProductDiscount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }
        return response()->json($discount);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'percentage' => 'required|numeric|min:0|max:100',
            'expiration_date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $discount = ProductDiscount::create($request->all());
        return response()->json($discount, 201);
    }

    public function update(Request $request, $id)
    {
        $discount = ProductDiscount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'sometimes|exists:products,id',
            'percentage' => 'sometimes|numeric|min:0|max:100',
            'expiration_date' => 'sometimes|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $discount->update($request->all());
        return response()->json($discount);
    }

    public function destroy($id)
    {
        $discount = ProductDiscount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $discount->delete();
        return response()->json(['message' => 'Discount deleted successfully']);
    }
}
