<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'brand' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|url',
            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',
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

        return redirect()->route('admin.products.index')->with('success', 'Producto creado');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'brand' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|url',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'brand' => $request->brand,
            'stock' => $request->stock,
            'image' => $request->image,
            'sizes' => json_encode($request->sizes ?? []),
            'colors' => json_encode($request->colors ?? []),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado');
    }
}