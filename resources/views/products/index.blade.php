@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <h1 class="text-5xl font-light tracking-wide mb-4">Nueva Colección</h1>
        <p class="text-gray-500 text-lg">Descubre nuestra selección de moda sostenible</p>
    </div>

    <!-- Filtros -->
    <div class="flex flex-wrap justify-between items-center mb-12 pb-4 border-b">
        <div class="flex space-x-6">
            <button class="filter-btn text-black border-b-2 border-black pb-2" data-filter="all">Todos</button>
            <button class="filter-btn text-gray-400 hover:text-black pb-2" data-filter="Camisetas">Camisetas</button>
            <button class="filter-btn text-gray-400 hover:text-black pb-2" data-filter="Pantalones">Pantalones</button>
            <button class="filter-btn text-gray-400 hover:text-black pb-2" data-filter="Vestidos">Vestidos</button>
            <button class="filter-btn text-gray-400 hover:text-black pb-2" data-filter="Chaquetas">Chaquetas</button>
        </div>
        
        <div class="relative">
            <select id="sort-select" class="border border-gray-200 rounded-lg px-4 py-2 text-sm bg-white cursor-pointer">
                <option value="newest">Más reciente</option>
                <option value="price_asc">Precio: menor a mayor</option>
                <option value="price_desc">Precio: mayor a menor</option>
            </select>
        </div>
    </div>

    <!-- Grid de Productos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="products-grid">
        @foreach($products as $product)
        <div class="product-card group" data-category="{{ $product->category }}" data-price="{{ $product->price }}" data-date="{{ $product->created_at }}">
            <div class="relative overflow-hidden bg-gray-100 rounded-2xl aspect-[3/4] cursor-pointer"
                 onclick="window.location='{{ route('products.show', $product->id) }}'">
                
                <!-- Imagen -->
                <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1539008835657-9e8e9680c956?w=600' }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                
                <!-- Badge (si hay oferta o nuevo) -->
                @if($loop->first)
                <div class="absolute top-4 left-4 bg-black text-white text-xs px-3 py-1 rounded-full">
                    Nuevo
                </div>
                @endif
                
                <!-- Overlay con botón rápido -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300">
                    <div class="absolute bottom-4 left-0 right-0 text-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <button onclick="event.stopPropagation(); addToCart({{ $product->id }})" 
                                class="bg-white text-black px-6 py-2 rounded-full text-sm font-medium hover:bg-black hover:text-white transition">
                            <i class="fa-solid fa-bag-shopping mr-2"></i>
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Información del producto -->
            <div class="mt-4 space-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-medium text-lg hover:text-gray-600 cursor-pointer"
                            onclick="window.location='{{ route('products.show', $product->id) }}'">
                            {{ $product->name }}
                        </h3>
                        <p class="text-sm text-gray-400">{{ $product->brand }}</p>
                    </div>
                    <button onclick="toggleWishlist({{ $product->id }})" class="text-gray-400 hover:text-red-500 transition">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-2xl font-semibold">${{ number_format($product->price, 0, ',', '.') }}</p>
                        @if($product->stock > 0)
                            <p class="text-xs text-green-600 mt-1">En stock</p>
                        @else
                            <p class="text-xs text-red-600 mt-1">Agotado</p>
                        @endif
                    </div>
                    
                    <!-- Tallas disponibles (mini) -->
                    <!-- Tallas disponibles según categoría -->
@if($product->sizes)
<div class="flex space-x-1 text-xs text-gray-500 mt-2">
    @php
        $sizesArray = json_decode($product->sizes);
        $displaySizes = array_slice($sizesArray, 0, 3);
    @endphp
    @foreach($displaySizes as $size)
        <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-100 text-xs">
            {{ $size }}
        </span>
    @endforeach
    @if(count($sizesArray) > 3)
        <span class="text-gray-400">+{{ count($sizesArray) - 3 }}</span>
    @endif
</div>
@endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Mensaje si no hay productos -->
    @if($products->count() == 0)
    <div class="text-center py-20">
        <i class="fa-regular fa-shirt text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 text-lg">No hay productos disponibles</p>
        @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" class="inline-block mt-4 bg-black text-white px-6 py-2 rounded-lg">
                Agregar primer producto
            </a>
            @endif
        @endauth
    </div>
    @endif
</div>

<script>
// Filtros por categoría
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function() {
        const filter = this.dataset.filter;
        
        // Actualizar estilos de botones
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('text-black', 'border-b-2', 'border-black');
            btn.classList.add('text-gray-400');
        });
        this.classList.remove('text-gray-400');
        this.classList.add('text-black', 'border-b-2', 'border-black');
        
        // Filtrar productos
        document.querySelectorAll('.product-card').forEach(card => {
            if(filter === 'all' || card.dataset.category === filter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// Ordenar productos
document.getElementById('sort-select').addEventListener('change', function() {
    const sortBy = this.value;
    const grid = document.getElementById('products-grid');
    const products = Array.from(document.querySelectorAll('.product-card'));
    
    products.sort((a, b) => {
        if(sortBy === 'price_asc') {
            return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
        } else if(sortBy === 'price_desc') {
            return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
        } else if(sortBy === 'newest') {
            return new Date(b.dataset.date) - new Date(a.dataset.date);
        }
        return 0;
    });
    
    products.forEach(product => grid.appendChild(product));
});

// Función para añadir al carrito
function addToCart(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ size: 'M', color: 'Negro' })
    }).then(() => {
        // Mostrar notificación
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fa-solid fa-check-circle mr-2"></i> Producto añadido al carrito';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
        
        // Recargar para actualizar contador
        setTimeout(() => location.reload(), 500);
    });
}

// Función para wishlist (favoritos)
function toggleWishlist(productId) {
    // Aquí puedes implementar la lógica de favoritos
    alert('Producto añadido a favoritos');
}
</script>
@endsection