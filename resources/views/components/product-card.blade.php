<a href="{{ route('product.show', $product->slug) }}" class="block bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-xl hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-1 group">
    <!-- Product Image Container -->
    <div class="relative bg-white p-4 flex items-center justify-center" style="height: 200px;">
        <img src="{{ $product->image_url }}" 
             alt="{{ $product->title }}" 
             class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-300" 
             loading="lazy">
        
        <!-- Badge Diskon -->
        @if($product->discount)
            <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold shadow-md">
                -{{ $product->discount }}%
            </div>
        @endif
        
        <!-- Badge Stock Habis -->
        @if($product->stock <= 0)
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <span class="bg-gray-800 text-white px-4 py-2 rounded-lg font-semibold">Stok Habis</span>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-3 space-y-2">
        <!-- Product Title -->
        <h3 class="text-sm font-medium text-gray-800 line-clamp-2 min-h-[40px] group-hover:text-blue-600 transition-colors">
            {{ $product->title }}
        </h3>

        <!-- Rating & Sales -->
        <div class="flex items-center gap-2 text-xs">
            <div class="flex items-center gap-1">
                <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-gray-600 font-semibold">
                    {{ $product->total_reviews > 0 ? $product->formatted_rating : 'Belum ada' }}
                </span>
            </div>
            @if($product->total_reviews > 0)
                <span class="text-gray-400">|</span>
                <span class="text-gray-500">{{ $product->total_reviews }} review</span>
            @endif
        </div>

        <!-- Price Section -->
        <div class="space-y-1">
            @if($product->discount)
                <!-- Original Price (Strikethrough) -->
                <div class="flex items-center gap-2">
                    @php
                        $originalRange = $product->getVariantOriginalPriceRange();
                        if ($originalRange) {
                            $minOriginal = 'Rp ' . number_format($originalRange['min'], 0, ',', '.');
                            $maxOriginal = 'Rp ' . number_format($originalRange['max'], 0, ',', '.');
                            $originalPriceDisplay = ($originalRange['min'] === $originalRange['max']) 
                                ? $minOriginal 
                                : $minOriginal . ' ~ ' . $maxOriginal;
                        } else {
                            $originalPriceDisplay = $product->formatted_price;
                        }
                    @endphp
                    <span class="text-xs text-gray-400 line-through">{{ $originalPriceDisplay }}</span>
                    <span class="text-xs bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded font-bold">
                        -{{ $product->discount }}%
                    </span>
                </div>
                <!-- Discounted Price or Price Range -->
                <div class="text-lg font-bold text-orange-600">
                    {{ $product->formatted_price_range }}
                </div>
            @else
                <!-- Normal Price or Price Range -->
                <div class="text-lg font-bold text-gray-900">
                    {{ $product->formatted_price_range }}
                </div>
            @endif
        </div>

        <!-- Stock Badge -->
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-500">
                @if($product->stock > 50)
                    <span class="text-green-600 font-semibold">Stok Banyak</span>
                @elseif($product->stock > 10)
                    <span class="text-blue-600 font-semibold">Tersedia</span>
                @elseif($product->stock > 0)
                    <span class="text-orange-600 font-semibold">Stok Terbatas</span>
                @else
                    <span class="text-red-600 font-semibold">Habis</span>
                @endif
            </span>
            
            <!-- Quick Add Button (Optional) -->
            @auth
                @if($product->stock > 0)
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" @click.stop class="inline">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" 
                                class="p-1.5 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-md hover:shadow-lg"
                                title="Tambah ke keranjang">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</a>
