<?php

namespace App\Http\Controllers;

use App\Models\PromotionCode;
use Illuminate\Http\Request;

class PromotionCodeController extends Controller
{
    // Display a listing of the promotion codes
    public function index()
    {
        $promotionCodes = PromotionCode::orderBy('expiration_date', 'asc')->get();
        return view('promotionCode.index', compact('promotionCodes'));
    }

    // Show the form for creating a new promotion code
    public function create()
    {
        return view('promotionCode.create');
    }

    // Store a newly created promotion code in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:promotion_codes,code',
            'percentage' => 'required|numeric|min:0|max:100',
            'expiration_date' => 'required|date|after:today',
            'uses' => 'required|integer|min:0',
        ]);

        PromotionCode::create($validatedData);

        return redirect()->route('promotion.index')->with('success', 'Código promocional creado correctamente');
    }

    // Display the specified promotion code
    public function show($id)
    {
        $promotionCode = PromotionCode::findOrFail($id);
        if (!$promotionCode) {
            return redirect()->route('promotion.index')->with('error', 'Código promocional no encontrado');
        }
        return view('promotionCode.show', compact('promotionCode'));
    }

    // Show the form for editing the specified promotion code
    public function edit($id)
    {
        $promotionCode = PromotionCode::find($id);
        if (!$promotionCode) {
            return redirect()->route('promotion.index')->with('error', 'Código promocional no encontrado');
        }
        return view('promotionCode.edit', compact('promotionCode'));
    }

    // Update the specified promotion code in storage
    public function update(Request $request, $id)
    {
        $promotionCode = PromotionCode::find($id);
        if (!$promotionCode) {
            return redirect()->route('promotion.index')->with('error', 'Código promocional no encontrado');
        }

        $validatedData = $request->validate([
            'code' => 'required|string|unique:promotion_codes,code,' . $promotionCode->id,
            'percentage' => 'required|numeric|min:0|max:100',
            'expiration_date' => 'required|date|after:today',
            'uses' => 'required|integer|min:0',
        ]);

        $promotionCode->update($validatedData);

        return redirect()->route('promotion.index')->with('success', 'Código promocional actualizado correctamente');
    }

    // Remove the specified promotion code from storage
    public function destroy($id)
    {
        $promotionCode = PromotionCode::find($id);
        if (!$promotionCode) {
            return redirect()->route('promotion.index')->with('error', 'Código promocional no encontrado');
        }

        $promotionCode->delete();

        return redirect()->route('promotion.index')->with('success', 'Código promocional eliminado correctamente');
    }
}
