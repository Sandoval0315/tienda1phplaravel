@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-4xl font-light">Nuestros Productos</h1>
        <div class="flex space-x-4">
            <select class="border px-4 py-2 text-sm bg-white rounded">
                <option>Categorías</option>
                <option>Camisetas</option>
                <option>Pantalones</option>
                <option>Vestidos</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($products as $product)
        <div class="group cursor-pointer">
            <div class="relative overflow-hidden bg-gray-100 aspect-square rounded-lg">
                <img src="{{ $product->image ?? 'https://placehold.co/600x800' }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <button onclick="addToCart({{ $product->id }})" 
                        class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-white px-6 py-2 text-sm opacity-0 group-hover:opacity-100 transition rounded">
                    Añadir
                </button>
            </div>
            <div class="mt-4">
                <h3 class="font-medium">{{ $product->name }}</h3>
                <p class="text-sm text-gray-500">{{ $product->brand }}</p>
                <p class="text-lg font-semibold mt-1">${{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function addToCart(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ size: 'M', color: 'Negro' })
    }).then(() => {
        location.reload();
    });
}
</script>
@endsection