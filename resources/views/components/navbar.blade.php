<nav x-data="{showFilters:true}" class="bg-white shadow-sm sticky top-0 z-40">
    <div class="container mx-auto px-4 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="font-bold text-xl text-blue-600">Anashop</a>
        </div>

        <div class="flex-1 mx-4">
            <form action="{{ route('home') }}" method="get" class="w-full flex gap-2 items-center">
                <div class="flex-1 relative">
                    <input 
                        type="search" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari produk..." 
                        class="w-full pl-4 pr-10 py-2.5 border-2 border-gray-200 rounded-lg 
                               focus:outline-none focus:border-blue-600 transition text-gray-700 bg-gray-50"
                    >
                    <!-- Tombol submit (ikon search) -->
                    <button 
                        type="submit" 
                        class="absolute right-3 top-0 bottom-0 flex items-center text-gray-400 hover:text-blue-600 transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>

                    <!-- Tombol silang (clear search) -->
                    @if(request('search'))
                    <button 
                        type="button" 
                        id="clear-search"
                        class="absolute right-10 top-0 bottom-0 flex items-center text-gray-400 hover:text-red-500 transition"
                        title="Hapus pencarian"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    @endif
                </div>
            </form>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('cart.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition relative" title="Keranjang">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @php
                        $cartItemsCount = Auth::user()->cart?->items->sum('quantity') ?? 0;
                    @endphp
                    @if($cartItemsCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">
                            {{ $cartItemsCount > 99 ? '99+' : $cartItemsCount }}
                        </span>
                    @endif
                </a>
                
                <!-- Notifikasi Icon -->
                <a href="{{ route('notifications.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition relative" title="Notifikasi">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php
                        $unreadCount = Auth::user()->unreadNotificationsCount();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold animate-pulse">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>
                
                <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
            @else
                <button x-data @click="$dispatch('open-login')" 
                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all shadow-sm hover:shadow-md transform hover:scale-105">
                    Login
                </button>
            @endauth
        </div>
    </div>

    {{-- kategori filter --}}
    <div x-data="{show:true,last:window.scrollY}" 
         x-init="window.addEventListener('scroll',()=>{if(window.scrollY>last){show=false}else{show=true}last=window.scrollY})" 
         class="overflow-x-auto border-t border-gray-200 py-2.5 bg-gray-50 hide-on-scroll" 
         :class="{'-translate-y-full':!show,'translate-y-0':show}" 
         style="transition:transform .3s cubic-bezier(.4,0,.2,1);" 
         id="filters">
        <div class="container mx-auto px-4 flex gap-2 items-center">
            @foreach($categories as $cat)
                <a href="{{ route('home', array_merge(request()->except('page'), ['category'=>$cat->slug])) }}"
                   class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ request('category')==$cat->slug ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
            @if(request('category'))
                <a href="{{ route('home', request()->except(['category','page'])) }}" class="ml-auto text-sm text-red-600 font-medium hover:text-red-700">Hapus</a>
            @endif
        </div>
    </div>
</nav>

<!-- Tambahkan script ini di akhir file -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const clearBtns = document.querySelectorAll('#clear-search');
    const searchInput = document.querySelector('input[name="search"]');

    clearBtns.forEach(function(clearBtn) {
        if (clearBtn && searchInput) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                const url = new URL(window.location.href);
                url.searchParams.delete('search');
                url.searchParams.delete('page');
                window.location.href = url.toString();
            });
        }
    });
});
</script>
