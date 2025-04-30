<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $latestProducts = Product::with('images')->orderBy('created_at', 'desc')->take(3)->get(); // Ensure correct ordering
        return view('welcome', compact('latestProducts'));
    }
}
