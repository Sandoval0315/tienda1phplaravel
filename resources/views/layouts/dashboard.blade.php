@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-light">Dashboard</h1>
</div>

<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600">Total Productos</div>
        <div class="text-3xl font-bold mt-2">{{ \App\Models\Product::count() }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600">Stock Bajo</div>
        <div class="text-3xl font-bold mt-2">{{ \App\Models\Product::where('stock', '<', 10)->count() }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600">Usuarios</div>
        <div class="text-3xl font-bold mt-2">{{ \App\Models\User::count() }}</div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-xl font-light">Productos Recientes</h2>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach(\App\Models\Product::latest()->take(10)->get() as $product)
            <tr>
                <td class="px-6 py-4">{{ $product->name }}</td>
                <td class="px-6 py-4">${{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">{{ $product->stock }}</td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection