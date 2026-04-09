@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Galería de imágenes -->
        <div class="space-y-4">
            <div class="bg-gray-100 rounded-2xl overflow-hidden aspect-square">
                <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1539008835657-9e8e9680c956?w=800' }}" 
                     alt="{{ $product->name }}"
                     id="main-image"
                     class="w-full h-full object-cover">
            </div>
            
            <!-- Miniaturas (si tuvieras más imágenes) -->
            <div class="flex space-x-4">
                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 border-black">
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1539008835657-9e8e9680c956?w=800' }}" 
                         class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        
        <!-- Información del producto -->
        <div class="space-y-6">
            <div>
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl font-light mb-2">{{ $product->name }}</h1>
                        <p class="text-gray-500">{{ $product->brand }}</p>
                    </div>
                    <button onclick="toggleWishlist({{ $product->id }})" class="text-gray-400 hover:text-red-500 transition">
                        <i class="fa-regular fa-heart text-2xl"></i>
                    </button>
                </div>
                
                <div class="mt-4">
                    <span class="text-3xl font-semibold">${{ number_format($product->price, 0, ',', '.') }}</span>
                    @if($product->stock > 0)
                        <span class="ml-4 text-sm text-green-600">✓ En stock</span>
                    @else
                        <span class="ml-4 text-sm text-red-600">✗ Agotado</span>
                    @endif
                </div>
            </div>
            
            <!-- Descripción -->
            <div class="border-t pt-6">
                <h3 class="font-medium mb-3">Descripción</h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $product->description }}
                </p>
            </div>
            
            <!-- Tallas -->
            <!-- Tallas/Medidas según categoría -->
@if($product->sizes)
<div>
    <h3 class="font-medium mb-3">
        @if($product->category == 'Pantalones')
            Tallas (numeración)
        @elseif($product->category == 'Zapatos')
            Números disponibles
        @elseif($product->category == 'Carteras')
            Tamaños disponibles
        @else
            Tallas disponibles
        @endif
    </h3>
    <div class="flex flex-wrap gap-3">
        @foreach(json_decode($product->sizes) as $size)
        <button class="size-btn w-12 h-12 rounded-full border-2 border-gray-300 hover:border-black transition">
            {{ $size }}
        </button>
        @endforeach
    </div>
</div>
@endif
            
            <!-- Colores -->
            @if($product->colors)
            <div>
                <h3 class="font-medium mb-3">Colores</h3>
                <div class="flex space-x-3">
                    @foreach(json_decode($product->colors) as $color)
                    <button class="w-8 h-8 rounded-full border-2 border-gray-300 hover:border-black transition"
                            style="background-color: {{ $color == 'Negro' ? '#000' : ($color == 'Blanco' ? '#ffffff' : '#3b82f6') }}"></button>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Cantidad y botón comprar -->
            <div class="border-t pt-6 space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="flex border rounded-lg">
                        <button id="decrement" class="px-4 py-2 hover:bg-gray-100">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                               class="w-16 text-center border-x">
                        <button id="increment" class="px-4 py-2 hover:bg-gray-100">+</button>
                    </div>
                    
                    <button onclick="addToCart()" 
                            class="flex-1 bg-black text-white py-3 rounded-lg hover:bg-gray-800 transition font-medium">
                        <i class="fa-solid fa-bag-shopping mr-2"></i>
                        Añadir al carrito
                    </button>
                </div>
                
                <button class="w-full border-2 border-black py-3 rounded-lg hover:bg-black hover:text-white transition font-medium">
                    Comprar ahora
                </button>
            </div>
            
            <!-- Detalles adicionales -->
            <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Categoría</span>
                    <span class="font-medium">{{ $product->category }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">SKU</span>
                    <span class="font-medium">#{{ $product->id }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Envío</span>
                    <span class="font-medium">Envío gratis por compras +$50.000</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Productos relacionados -->
    @php
        $related = App\Models\Product::where('category', $product->category)
                                    ->where('id', '!=', $product->id)
                                    ->limit(4)
                                    ->get();
    @endphp
    
    @if($related->count() > 0)
    <div class="mt-20">
        <h2 class="text-2xl font-light text-center mb-8">También te puede interesar</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $rel)
            <div class="group cursor-pointer" onclick="window.location='{{ route('products.show', $rel->id) }}'">
                <div class="bg-gray-100 rounded-xl overflow-hidden aspect-square">
                    <img src="{{ $rel->image ?? 'https://placehold.co/600x800' }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition">
                </div>
                <div class="mt-3">
                    <h3 class="font-medium">{{ $rel->name }}</h3>
                    <p class="text-lg font-semibold">${{ number_format($rel->price, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
// Control de cantidad
const quantityInput = document.getElementById('quantity');
document.getElementById('decrement').addEventListener('click', () => {
    if(quantityInput.value > 1) quantityInput.value--;
});
document.getElementById('increment').addEventListener('click', () => {
    if(quantityInput.value < {{ $product->stock }}) quantityInput.value++;
});

// Selección de talla
document.querySelectorAll('.size-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.size-btn').forEach(b => {
            b.classList.remove('border-black', 'bg-black', 'text-white');
            b.classList.add('border-gray-300');
        });
        this.classList.remove('border-gray-300');
        this.classList.add('border-black', 'bg-black', 'text-white');
    });
});

// Añadir al carrito
function addToCart() {
    const size = document.querySelector('.size-btn.border-black')?.innerText || 'M';
    const quantity = quantityInput.value;
    
    fetch(`/cart/add/{{ $product->id }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ size: size, quantity: quantity })
    }).then(() => {
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fa-solid fa-check-circle mr-2"></i> Producto añadido al carrito';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    });
}

function toggleWishlist(id) {
    alert('Producto añadido a favoritos');
}
</script>
@endsection