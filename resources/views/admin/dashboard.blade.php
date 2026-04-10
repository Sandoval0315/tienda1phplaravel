@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">

        {{-- Header --}}
        <div class="mb-10">
            <p class="text-xs tracking-[0.2em] text-gray-400 uppercase mb-2">Panel de control</p>
            <h1 class="text-3xl font-light tracking-wide">BéRRY Admin</h1>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-10">

            <div class="bg-white border border-gray-100 rounded-xl px-8 py-7">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase mb-3">Total Productos</p>
                <p class="text-4xl font-light">{{ \App\Models\Product::count() }}</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl px-8 py-7">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase mb-3">Stock Bajo</p>
                <p class="text-4xl font-light {{ \App\Models\Product::where('stock', '<', 10)->count() > 0 ? 'text-amber-500' : '' }}">
                    {{ \App\Models\Product::where('stock', '<', 10)->count() }}
                </p>
            </div>

            <div class="bg-black rounded-xl px-8 py-7 flex flex-col justify-between">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase mb-3">Nuevo</p>
                <a href="{{ route('admin.products.create') }}"
                    class="text-white text-sm tracking-widest uppercase hover:opacity-70 transition-opacity">
                    + Crear producto →
                </a>
            </div>

        </div>

        {{-- Tabla productos recientes --}}
        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">

            <div class="flex items-center justify-between px-8 py-5 border-b border-gray-100">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase">Productos recientes</p>
                <a href="{{ route('admin.products.index') }}"
                    class="text-xs tracking-widest text-gray-400 hover:text-black uppercase transition-colors">
                    Ver todos →
                </a>
            </div>

            {{-- Cabecera --}}
            <div class="grid grid-cols-12 gap-4 px-8 py-3 border-b border-gray-50">
                <div class="col-span-5 text-xs tracking-[0.15em] text-gray-300 uppercase">Producto</div>
                <div class="col-span-2 text-xs tracking-[0.15em] text-gray-300 uppercase">Precio</div>
                <div class="col-span-2 text-xs tracking-[0.15em] text-gray-300 uppercase">Stock</div>
                <div class="col-span-3 text-xs tracking-[0.15em] text-gray-300 uppercase text-right">Acciones</div>
            </div>

            {{-- Filas --}}
            @foreach(\App\Models\Product::latest()->take(10)->get() as $product)
            <div class="grid grid-cols-12 gap-4 items-center px-8 py-4 border-b border-gray-50 hover:bg-gray-50 transition-colors last:border-0">

                <div class="col-span-5">
                    <p class="text-sm font-medium">{{ $product->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $product->category }}</p>
                </div>

                <div class="col-span-2">
                    <span class="text-sm">${{ number_format($product->price, 2) }}</span>
                </div>

                <div class="col-span-2">
                    @if($product->stock <= 0)
                        <span class="text-xs tracking-wider px-3 py-1 rounded-full bg-red-50 text-red-400">Agotado</span>
                    @elseif($product->stock < 10)
                        <span class="text-xs tracking-wider px-3 py-1 rounded-full bg-amber-50 text-amber-500">{{ $product->stock }} uds.</span>
                    @else
                        <span class="text-sm text-gray-700">{{ $product->stock }}</span>
                    @endif
                </div>

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
            @endforeach

        </div>

    </div>
</div>
@endsection