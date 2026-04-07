<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        
        $id = $product->id;
        
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'size' => $request->size ?? 'M',
                'color' => $request->color ?? 'Negro'
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Producto añadido al carrito');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Producto eliminado');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index');
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}