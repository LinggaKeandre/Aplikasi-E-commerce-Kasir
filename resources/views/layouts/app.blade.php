<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name','Kasir') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* small helper styles for sticky/hide on scroll */
        .hide-on-scroll { transition: transform .2s ease; }
    </style>
</head>
<body x-data="{sidebar:false, photoModal: false, photoUrl: ''}" class="antialiased bg-gray-50">

    @include('components.navbar')

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{show: true}" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{show: true}" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Modal Login -->
    <div x-data="{open:{{ $errors->has('email') ? 'true' : 'false' }}}" 
         x-on:open-login.window="open=true" 
         x-show="open" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="open=false" class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md relative">
            <button @click="open=false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            <h2 class="text-2xl font-bold mb-6">Login</h2>
            
            @if($errors->has('email'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $errors->first('email') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input name="email" 
                           type="email" 
                           value="{{ old('email') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input name="password" 
                           type="password" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required>
                </div>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-3 rounded-lg w-full font-semibold hover:from-blue-700 hover:to-blue-800 transition">
                    Login
                </button>
            </form>
            <div class="mt-6 text-center text-sm">
                Belum punya akun? <a href="{{ route('register.form') }}" class="text-blue-600 hover:underline font-medium">Daftar di sini</a>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    @auth
    <div x-show="sidebar" class="fixed inset-0 z-50 flex" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div @mouseenter="sidebar=true" @mouseleave="sidebar=false" class="w-64 bg-white h-full shadow-2xl flex flex-col transform transition-transform duration-200"
             :class="sidebar ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Profile Section - Clickable -->
            <a href="{{ route('profile.show') }}" class="p-6 hover:bg-gray-50 transition border-b border-gray-200 block">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        @if(Auth::user()->photo)
                            <div @click.prevent="photoModal = true; photoUrl = '{{ asset('storage/' . Auth::user()->photo) }}'" 
                                 class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200 shadow cursor-pointer hover:border-blue-500 transition">
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="font-bold text-gray-800">{{ Auth::user()->name ?? 'Member' }}</div>
                            <div class="text-xs text-gray-500">Member</div>
                        </div>
                    </div>
                    <button @click.prevent="sidebar=false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </a>

            <!-- Navigation Menu -->
            <nav class="flex-1 flex flex-col gap-2 p-4">
                <a href="{{ route('home') }}" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 {{ request()->routeIs('home') || request()->routeIs('product.show') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Katalog
                </a>
                <a href="{{ route('orders.index') }}" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 {{ request()->routeIs('orders.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Pesanan
                </a>
                <a href="{{ route('cart.index') }}" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 {{ request()->routeIs('cart.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Keranjang
                </a>
                <a href="{{ route('rewards.index') }}" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 {{ request()->routeIs('rewards.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Rewards
                </a>
                <a href="{{ route('member.vouchers') }}" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 {{ request()->routeIs('member.vouchers') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Voucher Saya
                </a>
                
                <hr class="my-2">
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="py-2 px-3 rounded text-red-600 hover:bg-red-50 w-full text-left flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </nav>
        </div>
        <div class="flex-1 bg-black/30 backdrop-blur-sm"></div>
    </div>
    @endauth

    <main class="pt-4" :class="{'blur-sm pointer-events-none':sidebar || photoModal}">
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>
    @include('components.footer')

    <!-- Sidebar Trigger Area -->
    @auth
        <!-- Trigger zone (pojok kiri, kecuali navbar) -->
        <div @mouseenter="sidebar=true" class="fixed top-16 bottom-0 left-0 w-12 z-30 cursor-pointer"></div>
        
        <!-- Visual indicator -->
        <div class="fixed top-1/2 -translate-y-1/2 left-0 z-30 bg-gray-700 text-white shadow-md px-1.5 py-3 pointer-events-none">
            <div class="text-xs font-bold">››</div>
        </div>
    @endauth

    <!-- Photo Lightbox Modal -->
    <div x-show="photoModal" 
         x-cloak
         @click="photoModal = false"
         class="fixed inset-0 z-[60] flex items-center justify-center bg-black/90 p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="relative">
            <!-- Close Button -->
            <button @click="photoModal = false" 
                    class="absolute -top-3 -right-3 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition z-10">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <!-- Photo Container with Border -->
            <div class="border-4 border-white rounded-lg shadow-2xl overflow-hidden bg-white"
                 @click.stop>
                <img :src="photoUrl" 
                     class="w-auto h-auto max-w-[600px] max-h-[600px] object-contain"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
