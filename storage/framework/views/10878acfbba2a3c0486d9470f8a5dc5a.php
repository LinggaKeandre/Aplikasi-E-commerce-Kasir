

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6" x-data="productDetail()">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-600">
        <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-blue-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900"><?php echo e($product->title); ?></span>
        <?php else: ?>
            <a href="<?php echo e(route('home')); ?>" class="hover:text-blue-600">Home</a>
            <span class="mx-2">/</span>
            <a href="<?php echo e(route('home', ['category' => $product->category->slug])); ?>" class="hover:text-blue-600"><?php echo e($product->category->name); ?></a>
            <span class="mx-2">/</span>
            <span class="text-gray-900"><?php echo e($product->title); ?></span>
        <?php endif; ?>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column: Image Gallery -->
        <div class="space-y-4">
            <!-- Main Image -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="relative aspect-square">
                    <img src="<?php echo e($product->image_url); ?>" 
                         alt="<?php echo e($product->title); ?>"
                         class="w-full h-full object-contain p-4">
                    
                    <!-- Badge Stok -->
                    <?php if($product->stock > 0): ?>
                        <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Tersedia
                        </div>
                    <?php else: ?>
                        <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Stok Habis
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Image Zoom Modal removed since we don't have multiple images -->
        </div>

        <!-- Right Column: Product Info -->
        <div class="space-y-6">
            <!-- Product Title & Brand -->
            <div>
                <?php if($product->brand): ?>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-sm text-gray-500">Brand:</span>
                    <span class="text-sm font-semibold text-blue-600"><?php echo e($product->brand); ?></span>
                </div>
                <?php endif; ?>
                <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($product->title); ?></h1>
                <?php if($product->meta): ?>
                    <p class="text-gray-600"><?php echo e($product->meta); ?></p>
                <?php endif; ?>
            </div>

            <!-- Rating & Reviews -->
            <div class="flex items-center gap-4 pb-4 border-b">
                <div class="flex items-center gap-1">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <svg class="w-5 h-5 <?php echo e($i <= round($product->average_rating) ? 'text-yellow-400' : 'text-gray-300'); ?>" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    <?php endfor; ?>
                    <span class="text-sm font-semibold ml-2"><?php echo e($product->total_reviews > 0 ? $product->formatted_rating : 'Belum ada rating'); ?></span>
                </div>
                <?php if($product->total_reviews > 0): ?>
                    <span class="text-gray-400">|</span>
                    <a href="#reviews" class="text-sm text-blue-600 hover:underline"><?php echo e($product->total_reviews); ?> Ulasan</a>
                <?php endif; ?>
                <span class="text-gray-400">|</span>
                <span class="text-sm text-gray-600"><?php echo e($product->stock); ?> Stok Tersedia</span>
            </div>

            <!-- Price -->
            <div class="py-4 border-b">
                <?php if($product->discount ?? false): ?>
                    <div class="flex items-center gap-3 mb-2" x-show="!hasVariantPrice">
                        <span class="text-gray-400 line-through text-lg" x-text="formattedOriginalPrice"></span>
                        <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">-<?php echo e($product->discount); ?>%</span>
                    </div>
                <?php endif; ?>
                
                <div class="text-3xl font-bold text-blue-600" x-text="formattedFinalPrice"></div>
                
                <!-- Variant price breakdown -->
                <div x-show="hasVariantPrice && variantPrice > 0" class="mt-2 text-sm text-gray-600">
                    <span class="text-xs">Harga varian yang dipilih</span>
                </div>
            </div>

            <!-- Quantity & Actions -->
            <form method="POST" action="<?php echo e(route('cart.add', $product->id)); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                
                <!-- Variations (if applicable) -->
                <?php if($product->variants && count($product->variants) > 0): ?>
                <div class="py-4 border-b">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Pilih Variasi:</h3>
                    
                    <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variantIndex => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-4">
                        <label class="text-xs text-gray-600 mb-2 block"><?php echo e($variant['type']); ?></label>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $variant['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionIndex => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button"
                                    @click="selectedVariants[<?php echo e($variantIndex); ?>] = '<?php echo e($option['value']); ?>'"
                                    :class="selectedVariants[<?php echo e($variantIndex); ?>] === '<?php echo e($option['value']); ?>' ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-gray-300 text-gray-700'"
                                    class="px-4 py-2 border-2 rounded-lg font-medium hover:border-blue-400 transition">
                                <?php echo e($option['value']); ?>

                            </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <input type="hidden" 
                               name="variant_<?php echo e(strtolower(str_replace(' ', '_', $variant['type']))); ?>" 
                               x-model="selectedVariants[<?php echo e($variantIndex); ?>]">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
                
                <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
                    
                <?php else: ?>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Jumlah</label>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center border-2 border-gray-300 rounded-lg">
                            <button type="button" @click="if(quantity > 1) quantity--" 
                                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <input type="number" 
                                   name="quantity" 
                                   x-model="quantity" 
                                   min="1" 
                                   max="<?php echo e($product->stock); ?>"
                                   class="w-16 text-center border-0 focus:outline-none font-semibold">
                            <button type="button" @click="if(quantity < <?php echo e($product->stock); ?>) quantity++" 
                                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm text-gray-600">Stok: <span class="font-semibold"><?php echo e($product->stock); ?></span></span>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                        <p class="text-sm text-blue-800">
                            <svg class="w-5 h-5 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Anda login sebagai Admin. Fitur keranjang dan favorit tidak tersedia.
                        </p>
                    </div>
                <?php else: ?>
                <div class="flex gap-3">
                    <button type="submit" 
                            <?php if($product->stock <= 0): ?> disabled <?php endif; ?>
                            class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 disabled:bg-gray-300 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Tambah ke Keranjang
                    </button>
                    <button type="button" 
                            class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="mt-12 bg-white rounded-lg shadow-sm border border-gray-200" x-data="{activeTab: 'description'}">
        <!-- Tabs Header -->
        <div class="border-b border-gray-200">
            <nav class="flex">
                <button @click="activeTab = 'description'" 
                        :class="activeTab === 'description' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600'"
                        class="px-6 py-4 font-semibold border-b-2 hover:text-blue-600 transition">
                    Deskripsi
                </button>
                <button @click="activeTab = 'specifications'" 
                        :class="activeTab === 'specifications' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600'"
                        class="px-6 py-4 font-semibold border-b-2 hover:text-blue-600 transition">
                    Spesifikasi
                </button>
                <button @click="activeTab = 'reviews'" 
                        :class="activeTab === 'reviews' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600'"
                        class="px-6 py-4 font-semibold border-b-2 hover:text-blue-600 transition">
                    Ulasan (<?php echo e($product->total_reviews); ?>)
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Description Tab -->
            <div x-show="activeTab === 'description'" class="prose max-w-none">
                <h3 class="text-lg font-semibold mb-3">Deskripsi Produk</h3>
                <?php if($product->description): ?>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                        <?php echo e($product->description); ?>

                    </div>
                <?php else: ?>
                    <p class="text-gray-500 italic">Deskripsi produk belum tersedia.</p>
                <?php endif; ?>
            </div>

            <!-- Specifications Tab -->
            <div x-show="activeTab === 'specifications'">
                <h3 class="text-lg font-semibold mb-4">Spesifikasi Lengkap</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex py-3 border-b">
                        <span class="text-gray-600 w-40">Kategori</span>
                        <span class="font-semibold text-gray-900"><?php echo e($product->category->name); ?></span>
                    </div>
                    <?php if($product->brand): ?>
                    <div class="flex py-3 border-b">
                        <span class="text-gray-600 w-40">Brand/Merek</span>
                        <span class="font-semibold text-gray-900"><?php echo e($product->brand); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex py-3 border-b">
                        <span class="text-gray-600 w-40">Stok</span>
                        <span class="font-semibold text-gray-900"><?php echo e($product->stock); ?> Buah</span>
                    </div>
                    <div class="flex py-3 border-b">
                        <span class="text-gray-600 w-40">Kondisi</span>
                        <span class="font-semibold text-gray-900">Baru</span>
                    </div>
                    <?php if($product->discount): ?>
                    <div class="flex py-3 border-b">
                        <span class="text-gray-600 w-40">Diskon</span>
                        <span class="font-semibold text-red-600"><?php echo e($product->discount); ?>%</span>
                    </div>
                    <?php endif; ?>
                    <div class="flex py-3 border-b">
                        <span class="text-gray-600 w-40">Harga Normal</span>
                        <span class="font-semibold text-gray-900"><?php echo e($product->formatted_price); ?></span>
                    </div>
                    <?php if($product->discount): ?>
                    <div class="flex py-3 border-b">
                        <span class="text-gray-600 w-40">Harga Diskon</span>
                        <span class="font-semibold text-blue-600"><?php echo e($product->formatted_final_price); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($product->variants && count($product->variants) > 0): ?>
                    <div class="flex py-3 border-b col-span-2">
                        <span class="text-gray-600 w-40">Varian Tersedia</span>
                        <div class="flex-1">
                            <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-2">
                                    <span class="font-semibold text-gray-900"><?php echo e($variant['type']); ?>:</span>
                                    <span class="text-gray-700">
                                        <?php $__currentLoopData = $variant['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($option['value']); ?><?php if(!empty($option['price'])): ?> (Rp <?php echo e(number_format($option['price'], 0, ',', '.')); ?>)<?php endif; ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div x-show="activeTab === 'reviews'" id="reviews">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Rating & Ulasan</h3>
                    
                    <?php if($product->total_reviews > 0): ?>
                        <div class="flex items-start gap-8">
                            <div class="text-center">
                                <div class="text-5xl font-bold text-gray-900 mb-2"><?php echo e($product->formatted_rating); ?></div>
                                <div class="flex items-center justify-center gap-1 mb-2">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <svg class="w-5 h-5 <?php echo e($i <= round($product->average_rating) ? 'text-yellow-400' : 'text-gray-300'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                                <div class="text-sm text-gray-600"><?php echo e($product->total_reviews); ?> Ulasan</div>
                            </div>
                            <div class="flex-1 space-y-2">
                                <?php
                                    $ratingCounts = $product->reviews->groupBy('rating')->map->count();
                                ?>
                                <?php for($star = 5; $star >= 1; $star--): ?>
                                    <?php
                                        $count = $ratingCounts->get($star, 0);
                                        $percentage = $product->total_reviews > 0 ? ($count / $product->total_reviews) * 100 : 0;
                                    ?>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600 w-3"><?php echo e($star); ?></span>
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-yellow-400 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600 w-8"><?php echo e($count); ?></span>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <p class="font-semibold">Belum Ada Review</p>
                            <p class="text-sm">Jadilah yang pertama memberikan review untuk produk ini</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Review List -->
                <?php if($product->reviews && $product->reviews->count() > 0): ?>
                <div class="space-y-4 border-t pt-6">
                    <?php $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-b pb-4 last:border-0" x-data="{ 
                        editingReview: false, 
                        replyingReview: false,
                        editRating: <?php echo e($review->rating); ?>,
                        updateStars(rating) {
                            this.editRating = rating;
                        }
                    }">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                <?php echo e(substr($review->user->name, 0, 1)); ?>

                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-semibold text-gray-900"><?php echo e($review->user->name); ?></h4>
                                        <?php if($review->updated_at && $review->created_at && $review->updated_at->diffInSeconds($review->created_at) > 60): ?>
                                            <span class="text-xs text-gray-500 italic">(diedit)</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-500"><?php echo e($review->created_at->diffForHumans()); ?></span>
                                        
                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if($review->user_id === auth()->id()): ?>
                                                <!-- Edit & Delete untuk user sendiri -->
                                                <button @click="editingReview = true" 
                                                        x-show="!editingReview"
                                                        class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                                    Edit
                                                </button>
                                                <form method="POST" action="<?php echo e(route('reviews.destroy', $review->id)); ?>" 
                                                      class="inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-medium">
                                                        Hapus
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Display Mode -->
                                <div x-show="!editingReview">
                                    <div class="flex items-center gap-1 mb-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <svg class="w-4 h-4 <?php echo e($i <= $review->rating ? 'text-yellow-400' : 'text-gray-300'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                    <?php if($review->review): ?>
                                        <p class="text-gray-700 text-sm mb-3"><?php echo e($review->review); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Edit Mode -->
                                <div x-show="editingReview" x-cloak class="mb-3">
                                    <form method="POST" action="<?php echo e(route('reviews.update', $review->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        
                                        <div class="mb-3">
                                            <label class="block text-xs font-semibold text-gray-700 mb-2">Rating</label>
                                            <div class="flex gap-2">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <label class="cursor-pointer">
                                                        <input type="radio" 
                                                               name="rating" 
                                                               value="<?php echo e($i); ?>" 
                                                               <?php echo e($review->rating == $i ? 'checked' : ''); ?>

                                                               @click="updateStars(<?php echo e($i); ?>)"
                                                               required 
                                                               class="hidden peer">
                                                        <svg class="w-6 h-6 transition-colors"
                                                             :class="editRating >= <?php echo e($i); ?> ? 'text-yellow-400' : 'text-gray-300'"
                                                             fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    </label>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="block text-xs font-semibold text-gray-700 mb-2">Review</label>
                                            <textarea name="review" rows="3" 
                                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                      maxlength="1000"><?php echo e($review->review); ?></textarea>
                                        </div>
                                        
                                        <div class="flex gap-2">
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 font-semibold">
                                                Simpan
                                            </button>
                                            <button type="button" 
                                                    @click="editingReview = false"
                                                    class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 font-semibold">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Admin Reply Display -->
                                <?php if($review->admin_reply): ?>
                                    <div class="mt-3 ml-4 pl-4 border-l-2 border-blue-500 bg-blue-50 p-3 rounded">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-semibold text-blue-600">Balasan Admin</span>
                                            <?php if($review->replier): ?>
                                                <span class="text-xs text-gray-500">(<?php echo e($review->replier->name); ?>)</span>
                                            <?php endif; ?>
                                            <span class="text-xs text-gray-400">• <?php echo e($review->replied_at->diffForHumans()); ?></span>
                                        </div>
                                        <p class="text-sm text-gray-700"><?php echo e($review->admin_reply); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Reply Button untuk Admin -->
                                <?php if(auth()->guard()->check()): ?>
                                    <?php if(auth()->user()->role === 'admin' && !$review->admin_reply): ?>
                                        <div class="mt-3">
                                            <button @click="replyingReview = !replyingReview" 
                                                    class="text-xs text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                </svg>
                                                Balas Review
                                            </button>
                                        </div>
                                        
                                        <!-- Reply Form -->
                                        <div x-show="replyingReview" x-cloak class="mt-3 ml-4 pl-4 border-l-2 border-blue-500 bg-blue-50 p-3 rounded">
                                            <form method="POST" action="<?php echo e(route('reviews.reply', $review->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <label class="block text-xs font-semibold text-gray-700 mb-2">Balasan Admin</label>
                                                <textarea name="admin_reply" rows="3" required
                                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2"
                                                          placeholder="Tulis balasan Anda..."
                                                          maxlength="1000"></textarea>
                                                <div class="flex gap-2">
                                                    <button type="submit" 
                                                            class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 font-semibold">
                                                        Kirim Balasan
                                                    </button>
                                                    <button type="button" 
                                                            @click="replyingReview = false"
                                                            class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 font-semibold">
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function productDetail() {
    return {
        quantity: 1,
        <?php if($product->variants && count($product->variants) > 0): ?>
        selectedVariants: <?php echo json_encode(array_map(function($variant) {
            return $variant['options'][0]['value'] ?? '';
        }, $product->variants)); ?>,
        variants: <?php echo json_encode($product->variants); ?>,
        basePrice: <?php echo e($product->price); ?>,
        discount: <?php echo e($product->discount ?? 0); ?>,
        <?php else: ?>
        selectedVariants: {},
        variants: [],
        basePrice: <?php echo e($product->price); ?>,
        discount: <?php echo e($product->discount ?? 0); ?>,
        <?php endif; ?>
        
        get variantPrice() {
            let total = 0;
            if (this.variants && this.variants.length > 0) {
                this.variants.forEach((variant, index) => {
                    const selectedValue = this.selectedVariants[index];
                    const option = variant.options?.find(opt => opt.value === selectedValue);
                    if (option && option.price) {
                        total += parseFloat(option.price);
                    }
                });
            }
            return total;
        },
        
        get hasVariantPrice() {
            return this.variants && this.variants.some(v => 
                v.options && v.options.some(opt => opt.price && opt.price > 0)
            );
        },
        
        get finalPrice() {
            // Jika ada variant price, apply discount juga ke variant price
            if (this.hasVariantPrice) {
                const discountedVariantPrice = this.variantPrice * (1 - (this.discount / 100));
                return discountedVariantPrice;
            }
            // Jika tidak ada variant price, gunakan base price dengan discount
            const price = this.basePrice * (1 - (this.discount / 100));
            return price;
        },
        
        get formattedFinalPrice() {
            return 'Rp ' + this.finalPrice.toLocaleString('id-ID');
        },
        
        get formattedOriginalPrice() {
            // Jika ada variant price, tampilkan harga variant original
            if (this.hasVariantPrice) {
                return 'Rp ' + this.variantPrice.toLocaleString('id-ID');
            }
            return 'Rp ' + this.basePrice.toLocaleString('id-ID');
        }
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(Auth::check() && Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/product/show.blade.php ENDPATH**/ ?>