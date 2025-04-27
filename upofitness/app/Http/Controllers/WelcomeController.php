<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
{
    $latestProducts = Product::latest()->take(5)->get();
    return view('welcome', compact('latestProducts'));
}
}
