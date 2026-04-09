@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h2 class="text-xl font-semibold">Lista de Productos</h2>
        <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-4 py-2 rounded-lg text-sm">
            + Nuevo Producto
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imagen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4">
                        <img src="{{ $product->image ?? 'https://placehold.co/50x50' }}" class="w-10 h-10 object-cover rounded">
                    </td>
                    <td class="px-6 py-4">{{ $product->name }}</td>
                    <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>
                    <td class="px-6 py-4">{{ $product->stock }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Eliminar este producto?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection