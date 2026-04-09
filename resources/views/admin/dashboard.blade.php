@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600">Total Productos</div>
        <div class="text-3xl font-bold mt-2">{{ \App\Models\Product::count() }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600">Stock Bajo</div>
        <div class="text-3xl font-bold mt-2">{{ \App\Models\Product::where('stock', '<', 10)->count() }}</div>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h2 class="text-xl font-semibold">Productos Recientes</h2>
        <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-4 py-2 rounded-lg text-sm">
            + Nuevo Producto
        </a>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr><th class="px-6 py-3 text-left">Nombre</th><th class="px-6 py-3 text-left">Precio</th><th class="px-6 py-3 text-left">Stock</th><th class="px-6 py-3 text-left">Acciones</th></tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Product::latest()->take(10)->get() as $product)
            <tr class="border-t">
                <td class="px-6 py-4">{{ $product->name }}</td>
                <td class="px-6 py-4">${{ $product->price }}</td>
                <td class="px-6 py-4">{{ $product->stock }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600">Editar</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline ml-2">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection