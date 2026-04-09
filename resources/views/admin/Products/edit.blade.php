@extends('layouts.admin')

@section('title', 'Editar Producto')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-6">Editar Producto</h2>
    
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Precio *</label>
                <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Categoría *</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="Camisetas" {{ $product->category == 'Camisetas' ? 'selected' : '' }}>Camisetas</option>
                    <option value="Pantalones" {{ $product->category == 'Pantalones' ? 'selected' : '' }}>Pantalones</option>
                    <option value="Vestidos" {{ $product->category == 'Vestidos' ? 'selected' : '' }}>Vestidos</option>
                    <option value="Chaquetas" {{ $product->category == 'Chaquetas' ? 'selected' : '' }}>Chaquetas</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Marca *</label>
                <input type="text" name="brand" value="{{ $product->brand }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Stock *</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">URL de Imagen</label>
                <input type="url" name="image" value="{{ $product->image }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Descripción *</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2" required>{{ $product->description }}</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Tallas disponibles</label>
                <div class="flex space-x-4">
                    @php $sizes = json_decode($product->sizes) ?? []; @endphp
                    <label><input type="checkbox" name="sizes[]" value="S" {{ in_array('S', $sizes) ? 'checked' : '' }}> S</label>
                    <label><input type="checkbox" name="sizes[]" value="M" {{ in_array('M', $sizes) ? 'checked' : '' }}> M</label>
                    <label><input type="checkbox" name="sizes[]" value="L" {{ in_array('L', $sizes) ? 'checked' : '' }}> L</label>
                    <label><input type="checkbox" name="sizes[]" value="XL" {{ in_array('XL', $sizes) ? 'checked' : '' }}> XL</label>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Colores disponibles</label>
                <div class="flex space-x-4">
                    @php $colors = json_decode($product->colors) ?? []; @endphp
                    <label><input type="checkbox" name="colors[]" value="Negro" {{ in_array('Negro', $colors) ? 'checked' : '' }}> Negro</label>
                    <label><input type="checkbox" name="colors[]" value="Blanco" {{ in_array('Blanco', $colors) ? 'checked' : '' }}> Blanco</label>
                    <label><input type="checkbox" name="colors[]" value="Azul" {{ in_array('Azul', $colors) ? 'checked' : '' }}> Azul</label>
                    <label><input type="checkbox" name="colors[]" value="Rojo" {{ in_array('Rojo', $colors) ? 'checked' : '' }}> Rojo</label>
                </div>
            </div>
        </div>
        
        <div class="mt-6 flex space-x-3">
            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">
                Actualizar Producto
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 px-6 py-2 rounded-lg hover:bg-gray-400">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection