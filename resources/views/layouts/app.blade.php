<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Ropa - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    * {
        transition: all 0.2s ease;
    }

    .hover-scale:hover {
        transform: scale(1.02);
    }

    /* Animaciones para cards */
    .product-card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Scrollbar personalizada */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navbar Minimalista -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('products.index') }}" class="text-2xl font-light tracking-wider">
                    BéRRY
                </a>

                <div class="flex space-x-8">
                    <a href="{{ route('products.index') }}" class="hover:text-gray-600">Tienda</a>
                    <a href="#" class="hover:text-gray-600">Nuevo</a>
                    <a href="#" class="hover:text-gray-600">Ofertas</a>
                </div>

                <div class="flex space-x-4">
                    <a href="#" class="relative">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </a>
                    <a href="{{ route('cart.index') }}" class="relative">
                        <i class="fa-regular fa-bag-shopping text-xl"></i>
                        @php
                        $cartCount = count(session()->get('cart', []));
                        @endphp
                        @if($cartCount > 0)
                        <span
                            class="cart-badge absolute -top-2 -right-3 bg-black text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                        @else
                        <span
                            class="cart-badge absolute -top-2 -right-3 bg-black text-white text-xs rounded-full w-5 h-5 flex items-center justify-center hidden">
                            0
                        </span>
                        @endif
                    </a>

                    @auth
                    <div class="relative group">
                        <button class="relative">
                            <i class="fa-regular fa-user text-xl"></i>
                        </button>
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg hidden group-hover:block z-50">
                            <div class="px-4 py-2 border-b">
                                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                Panel Administración
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="relative">
                        <i class="fa-regular fa-user text-xl"></i>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-4 gap-8">
                <div>
                    <h3 class="font-medium mb-4">BéRRY</h3>
                    <p class="text-sm text-gray-600">Tienda de ropa</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium mb-4">AYUDA</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><a href="#" class="hover:text-black">Envíos</a></li>
                        <li><a href="#" class="hover:text-black">Devoluciones</a></li>
                        <li><a href="#" class="hover:text-black">Tallas</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-medium mb-4">LEGAL</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><a href="#" class="hover:text-black">Privacidad</a></li>
                        <li><a href="#" class="hover:text-black">Términos</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-medium mb-4">SÍGUENOS</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-xl"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-xl"><i class="fa-brands fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>