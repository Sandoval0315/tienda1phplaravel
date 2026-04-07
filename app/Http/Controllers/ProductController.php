<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Público: mostrar todos los productos
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('products.index', compact('products'));
    }

    // Público: mostrar un producto específico
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // Admin: formulario crear
    public function create()
    {
        return view('admin.products.create');
    }

    // Admin: guardar producto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'brand' => 'required',
            'stock' => 'required|integer',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->brand = $request->brand;
        $product->stock = $request->stock;
        $product->image = $request->image;
        $product->sizes = json_encode($request->sizes ?? []);
        $product->colors = json_encode($request->colors ?? []);
        $product->save();

        return redirect()->route('admin.dashboard')->with('success', 'Producto creado');
    }

    // Admin: formulario editar
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    // Admin: actualizar producto
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Producto actualizado');
    }

    // Admin: eliminar producto
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'Producto eliminado');
    }
}