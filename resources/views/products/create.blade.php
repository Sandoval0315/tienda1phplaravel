@extends('layouts.admin')

@section('title', 'Crear Producto')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-light mb-6">Crear Nuevo Producto</h1>
    
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium mb-2">Nombre del producto</label>
                <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Precio</label>
                <input type="number" name="price" step="0.01" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Categoría</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="Camisetas">Camisetas</option>
                    <option value="Pantalones">Pantalones</option>
                    <option value="Vestidos">Vestidos</option>
                    <option value="Chaquetas">Chaquetas</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Marca</label>
                <input type="text" name="brand" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Stock</label>
                <input type="number" name="stock" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">URL de imagen</label>
                <input type="url" name="image" class="w-full border rounded-lg px-3 py-2" placeholder="https://...">
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Descripción</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2" required></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Tallas disponibles</label>
                <div class="space-y-2">
                    <label><input type="checkbox" name="sizes[]" value="S"> S</label>
                    <label><input type="checkbox" name="sizes[]" value="M"> M</label>
                    <label><input type="checkbox" name="sizes[]" value="L"> L</label>
                    <label><input type="checkbox" name="sizes[]" value="XL"> XL</label>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Colores disponibles</label>
                <div class="space-y-2">
                    <label><input type="checkbox" name="colors[]" value="Negro"> Negro</label>
                    <label><input type="checkbox" name="colors[]" value="Blanco"> Blanco</label>
                    <label><input type="checkbox" name="colors[]" value="Azul"> Azul</label>
                    <label><input type="checkbox" name="colors[]" value="Rojo"> Rojo</label>
                </div>
            </div>
        </div>
        
        <div class="mt-6 flex space-x-3">
            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">Guardar Producto</button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 px-6 py-2 rounded-lg hover:bg-gray-400">Cancelar</a>
        </div>
    </form>
</div>
@endsection