<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValorationController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $data = $request->validate([
            'usuario_id' => 'required',
            'producto_id' => 'required',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        $valoration = \App\Models\Valoration::updateOrCreate(
            [
                'usuario_id' => $data['usuario_id'],
                'producto_id' => $data['producto_id'],
            ],
            [
                'puntuacion' => $data['puntuacion'],
                'comentario' => $data['comentario'] ?? '',
            ]
        );

        return redirect()->route('products.index')->with('success', 'Valoration saved successfully');
    }
}
