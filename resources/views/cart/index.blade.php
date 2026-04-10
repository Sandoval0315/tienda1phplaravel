@extends('layouts.app')

@section('title', 'Mi Carrito')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-light mb-8">Mi Carrito</h1>
    
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lista de productos -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Producto</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Precio</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Cantidad</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Subtotal</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($cart as $id => $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $item['image'] ?? 'https://placehold.co/80x80' }}" 
                                             alt="{{ $item['name'] }}"
                                             class="w-16 h-16 object-cover rounded">
                                        <div>
                                            <h3 class="font-medium">{{ $item['name'] }}</h3>
                                            <p class="text-sm text-gray-500">
                                                Talla: {{ $item['size'] }} | Color: {{ $item['color'] }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    ${{ number_format($item['price'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                               min="1" max="99"
                                               class="w-16 border rounded-lg px-2 py-1 text-center">
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">
                                            Actualizar
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 font-semibold">
                                    ${{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-black">
                        ← Seguir comprando
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            Vaciar carrito
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Resumen -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 rounded-lg p-6 sticky top-24">
                    <h2 class="text-xl font-semibold mb-4">Resumen del pedido</h2>
                    
                    <div class="space-y-3 border-b pb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span>${{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Envío</span>
                            <span class="text-green-600">Gratis</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-4 text-lg font-semibold">
                        <span>Total</span>
                        <span>${{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <button class="w-full bg-black text-white py-3 rounded-lg mt-6 hover:bg-gray-800 transition">
                        Proceder al pago
                    </button>
                    
                    <p class="text-xs text-gray-500 text-center mt-4">
                        Envío gratis en compras sobre $50.000
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Carrito vacío -->
        <div class="text-center py-20">
            <i class="fa-regular fa-bag-shopping text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-light mb-2">Tu carrito está vacío</h2>
            <p class="text-gray-500 mb-6">Parece que aún no has agregado ningún producto</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">
                Explorar productos
            </a>
        </div>
    @endif
</div>

<script>
// Actualizar el contador del carrito en el navbar
function updateCartCount() {
    const cartCount = {{ count($cart) }};
    const cartBadge = document.querySelector('.cart-badge');
    if (cartBadge) {
        if (cartCount > 0) {
            cartBadge.textContent = cartCount;
            cartBadge.classList.remove('hidden');
        } else {
            cartBadge.classList.add('hidden');
        }
    }
}
</script>
@endsection