<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Mostrar el carrito
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }
    
    // Agregar producto al carrito
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'size' => $request->input('size', 'M'),
                'color' => $request->input('color', 'Negro')
            ];
        }
        
        session()->put('cart', $cart);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => 'Producto añadido al carrito']);
        }

        return redirect()->back()->with('success', 'Producto añadido al carrito');
    }
    
    // Actualizar cantidad
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Carrito actualizado');
    }
    
    // Eliminar producto del carrito
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito');
    }
    
    // Vaciar carrito
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado');
    }
}