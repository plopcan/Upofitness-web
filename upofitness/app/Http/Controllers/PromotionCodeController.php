<?php

namespace App\Http\Controllers;

use App\Models\PromotionCode;
use Illuminate\Http\Request;

class PromotionCodeController extends Controller
{
    // Display a listing of the promotion codes
    public function index()
    {
        $promotionCodes = PromotionCode::all();
        return response()->json($promotionCodes);
    }

    // Store a newly created promotion code in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:promotion_codes,code',
            'percentage' => 'required|numeric|min:0|max:100',
            'expiration_date' => 'required|date',
            'uses' => 'required|integer|min:0',
        ]);

        $promotionCode = PromotionCode::create($validatedData);
        return response()->json($promotionCode, 201);
    }

    // Display the specified promotion code
    public function show($id)
    {
        $promotionCode = PromotionCode::findOrFail($id);
        return response()->json($promotionCode);
    }

    // Update the specified promotion code in storage
    public function update(Request $request, $id)
    {
        $promotionCode = PromotionCode::findOrFail($id);

        $validatedData = $request->validate([
            'code' => 'string|unique:promotion_codes,code,' . $promotionCode->id,
            'percentage' => 'numeric|min:0|max:100',
            'expiration_date' => 'date',
            'uses' => 'integer|min:0',
        ]);

        $promotionCode->update($validatedData);
        return response()->json($promotionCode);
    }

    // Remove the specified promotion code from storage
    public function destroy($id)
    {
        $promotionCode = PromotionCode::findOrFail($id);
        $promotionCode->delete();
        return response()->json(['message' => 'Promotion code deleted successfully']);
    }
}
