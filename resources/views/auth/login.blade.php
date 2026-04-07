@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-light text-center mb-6">Iniciar Sesión</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-black" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Contraseña</label>
                <input type="password" name="password" 
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-black" required>
            </div>
            
            <button type="submit" class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800">
                Ingresar
            </button>
        </form>
        
        <p class="text-center text-sm text-gray-600 mt-4">
            ¿No tienes cuenta? 
            <a href="{{ route('register') }}" class="text-black hover:underline">Regístrate</a>
        </p>
    </div>
</div>
@endsection