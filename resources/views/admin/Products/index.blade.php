@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
<div class="min-h-screen bg-gray py-12">
    <div class="max-w-5xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-xs tracking-[0.2em] text-gray-400 uppercase mb-2">Administración</p>
                <h1 class="text-3xl font-light tracking-wide">Productos</h1>
            </div>
            <a href="{{ route('admin.products.create') }}"
                class="bg-black text-white text-xs tracking-[0.2em] uppercase px-6 py-3 rounded-full hover:bg-gray-800 transition-colors">
                + Nuevo
            </a>
        </div>

        {{-- Tabla --}}
        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">

            {{-- Cabecera tabla --}}
            <div class="grid grid-cols-12 gap-4 px-8 py-4 border-b border-gray-100">
                <div class="col-span-1"></div>
                <div class="col-span-4 text-xs tracking-[0.15em] text-gray-400 uppercase">Producto</div>
                <div class="col-span-2 text-xs tracking-[0.15em] text-gray-400 uppercase">Precio</div>
                <div class="col-span-2 text-xs tracking-[0.15em] text-gray-400 uppercase">Stock</div>
                <div class="col-span-3 text-xs tracking-[0.15em] text-gray-400 uppercase text-right">Acciones</div>
            </div>

            {{-- Filas --}}
            @forelse($products as $product)
            <div class="grid grid-cols-12 gap-4 items-center px-8 py-5 border-b border-gray-50 hover:bg-gray-50 transition-colors last:border-0">

                {{-- Imagen --}}
                <div class="col-span-1">
                    <img src="{{ $product->image ?? 'https://placehold.co/48x48/f3f4f6/9ca3af?text=·' }}"
                        class="w-10 h-10 object-cover rounded-lg">
                </div>

                {{-- Nombre + categoría --}}
                <div class="col-span-4">
                    <p class="text-sm font-medium">{{ $product->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $product->category }} · {{ $product->brand }}</p>
                </div>

                {{-- Precio --}}
                <div class="col-span-2">
                    <span class="text-sm">${{ number_format($product->price, 2) }}</span>
                </div>

                {{-- Stock --}}
                <div class="col-span-2">
                    @if($product->stock <= 0)
                        <span class="inline-block text-xs tracking-wider px-3 py-1 rounded-full bg-red-50 text-red-400">Agotado</span>
                    @elseif($product->stock < 10)
                        <span class="inline-block text-xs tracking-wider px-3 py-1 rounded-full bg-amber-50 text-amber-500">{{ $product->stock }} uds.</span>
                    @else
                        <span class="text-sm text-gray-700">{{ $product->stock }}</span>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="col-span-3 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                        class="text-xs tracking-widest text-gray-500 hover:text-black uppercase transition-colors">
                        Editar
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('¿Eliminar {{ $product->name }}?')"
                            class="text-xs tracking-widest text-gray-300 hover:text-red-500 uppercase transition-colors">
                            Eliminar
                        </button>
                    </form>
                </div>

            </div>
            @empty
            <div class="px-8 py-16 text-center">
                <p class="text-gray-300 text-sm tracking-wider">Sin productos todavía</p>
                <a href="{{ route('admin.products.create') }}" class="inline-block mt-4 text-xs tracking-widest uppercase text-gray-500 hover:text-black transition-colors">
                    Crear el primero →
                </a>
            </div>
            @endforelse

        </div>

        {{-- Paginación si aplica --}}
        @if(method_exists($products, 'links'))
        <div class="mt-6 flex justify-center">
            {{ $products->links() }}
        </div>
        @endif

    </div>
</div>
@endsection