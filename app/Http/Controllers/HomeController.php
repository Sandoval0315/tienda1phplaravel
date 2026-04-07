<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Asegurar que NO hay ninguna redirección aquí
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('products.index', compact('products'));
    }
}