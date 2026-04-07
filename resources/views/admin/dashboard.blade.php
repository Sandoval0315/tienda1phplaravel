@extends('layouts.app')

@section('title', 'Panel Admin')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-light mb-6">Panel de Administración</h1>
        
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="text-gray-600">Total Productos</div>
                <div class="text-3xl font-bold mt-2">{{ \App\Models\Product::count() }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="text-gray-600">Usuarios</div>
                <div class="text-3xl font-bold mt-2">{{ \App\Models\User::count() }}</div>
            </div>
        </div>
        
        <div class="mt-8">
            <a href="{{ route('products.create') }}" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">
                + Crear Nuevo Producto
            </a>
        </div>
    </div>
</div>
@endsection
