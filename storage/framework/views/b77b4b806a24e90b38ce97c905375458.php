

<?php $__env->startSection('content'); ?>
    <div class="my-4" x-data="{ 
        currentSlide: 0, 
        totalSlides: <?php echo e($banners->count() > 0 ? ceil($banners->count() / 2) : 1); ?>,
        bannersPerSlide: 2
    }">
        <!-- banner carousel - 2 banners per slide -->
        <?php if($banners->count() > 0): ?>
            <div class="relative overflow-hidden rounded-lg mb-6" 
                 x-init="setInterval(() => { currentSlide = (currentSlide + 1) % totalSlides }, 5000)">
                <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentSlide * 100}%)`">
                    <?php $chunks = $banners->chunk(2); ?>
                    <?php $__currentLoopData = $chunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="w-full flex-shrink-0 grid grid-cols-1 md:grid-cols-2 gap-4 px-1">
                            <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="rounded-lg overflow-hidden">
                                    <img src="<?php echo e(asset('storage/' . $banner->image_path)); ?>" 
                                         alt="<?php echo e($banner->title); ?>"
                                         class="w-full h-40 md:h-44 lg:h-48 object-cover">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- Dots -->
                <?php if($chunks->count() > 1): ?>
                    <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex gap-2">
                        <template x-for="i in totalSlides" :key="i">
                            <button @click="currentSlide = i - 1" 
                                    :class="currentSlide === i - 1 ? 'bg-white' : 'bg-white/50'" 
                                    class="w-2 h-2 rounded-full transition-all hover:bg-white"></button>
                        </template>
                    </div>
                <?php endif; ?>
                
                <!-- Navigation Arrows -->
                <?php if($chunks->count() > 1): ?>
                    <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1"
                            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button @click="currentSlide = (currentSlide + 1) % totalSlides"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Placeholder jika belum ada banner -->
            <div class="relative overflow-hidden rounded-lg mb-6 h-40 md:h-44 lg:h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                <div class="text-center text-white">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-2xl font-bold">Selamat Datang</h3>
                    <p class="text-lg mt-2">Belum ada banner promosi</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Daily Rewards Section (Only for logged-in users) -->
        <?php if(auth()->guard()->check()): ?>
            <?php if($dailyReward && count($days) > 0): ?>
                <div class="mb-8 bg-white rounded-xl shadow-md p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            Daily check in
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Continuous check-in for 7 days will earn surprise!</p>
                    </div>

                    <!-- Days Row -->
                    <div class="flex items-center justify-between gap-3">
                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex-1">
                                <div class="text-center">
                                    <!-- Coin Stack -->
                                    <?php if($dayData['current'] && $canClaim): ?>
                                        <!-- Clickable Current Day -->
                                        <form action="<?php echo e(route('daily-rewards.claim')); ?>" method="POST" class="inline-block">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="relative mb-2 transform transition-all hover:scale-110 coin-stack-button">
                                                <?php if($dayData['day'] == 1): ?>
                                                    <!-- Day 1: 1 Koin -->
                                                    <div class="text-5xl animate-bounce">🪙</div>
                                                <?php elseif($dayData['day'] == 2): ?>
                                                    <!-- Day 2: 2 Koin -->
                                                    <div class="relative inline-block">
                                                        <div class="text-4xl absolute" style="bottom: 0px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-4xl absolute" style="bottom: 10px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="h-20 w-16"></div>
                                                    </div>
                                                <?php elseif($dayData['day'] == 3): ?>
                                                    <!-- Day 3: 3 Koin -->
                                                    <div class="relative inline-block">
                                                        <div class="text-4xl absolute" style="bottom: 0px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-4xl absolute" style="bottom: 8px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-4xl absolute" style="bottom: 16px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="h-24 w-16"></div>
                                                    </div>
                                                <?php elseif($dayData['day'] == 4): ?>
                                                    <!-- Day 4: Banyak koin (4-5 koin) -->
                                                    <div class="relative inline-block">
                                                        <div class="text-3xl absolute" style="bottom: 0px; left: 30%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 0px; left: 70%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 10px; left: 40%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 10px; left: 60%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 20px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="h-24 w-20"></div>
                                                    </div>
                                                <?php elseif($dayData['day'] == 5): ?>
                                                    <!-- Day 5: Lebih banyak lagi (6-7 koin) -->
                                                    <div class="relative inline-block">
                                                        <div class="text-3xl absolute" style="bottom: 0px; left: 20%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 0px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 0px; left: 80%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 8px; left: 35%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 8px; left: 65%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 16px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 24px; left: 50%; transform: translateX(-50%);">💎</div>
                                                        <div class="h-28 w-20"></div>
                                                    </div>
                                                <?php elseif($dayData['day'] == 6): ?>
                                                    <!-- Day 6: Melimpah (pile of coins) -->
                                                    <div class="relative inline-block">
                                                        <div class="text-2xl absolute" style="bottom: 0px; left: 15%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-2xl absolute" style="bottom: 0px; left: 40%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-2xl absolute" style="bottom: 0px; left: 60%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-2xl absolute" style="bottom: 0px; left: 85%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-2xl absolute" style="bottom: 8px; left: 25%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-2xl absolute" style="bottom: 8px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-2xl absolute" style="bottom: 8px; left: 75%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-2xl absolute" style="bottom: 16px; left: 35%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-2xl absolute" style="bottom: 16px; left: 65%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-3xl absolute" style="bottom: 24px; left: 50%; transform: translateX(-50%);">💎</div>
                                                        <div class="h-28 w-24"></div>
                                                    </div>
                                                <?php else: ?>
                                                    <!-- Day 7: Sekarung Koin 💰 -->
                                                    <div class="text-6xl animate-bounce">💰</div>
                                                <?php endif; ?>
                                                
                                                <!-- Points Badge -->
                                                <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-xs font-bold rounded-full px-2 py-1 shadow-lg">
                                                    +<?php echo e($dayData['points']); ?>

                                                </div>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="relative inline-block mb-2">
                                            <?php if($dayData['claimed']): ?>
                                                <!-- Claimed: Full color with checkmark -->
                                                <?php if($dayData['day'] == 1): ?>
                                                    <div class="text-5xl relative">
                                                        🪙
                                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                            <svg class="w-10 h-10 text-white bg-green-500 rounded-full p-1 shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php elseif($dayData['day'] == 2): ?>
                                                    <div class="relative">
                                                        <div class="text-4xl absolute" style="bottom: 0px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="text-4xl absolute" style="bottom: 10px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <div class="h-20 w-16"></div>
                                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                            <svg class="w-10 h-10 text-white bg-green-500 rounded-full p-1 shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php elseif($dayData['day'] == 7): ?>
                                                    <div class="text-6xl relative">
                                                        💰
                                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                            <svg class="w-12 h-12 text-white bg-green-500 rounded-full p-1 shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="relative">
                                                        <?php for($i = 0; $i < min($dayData['day'], 4); $i++): ?>
                                                            <div class="text-3xl absolute" style="bottom: <?php echo e($i * 8); ?>px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <?php endfor; ?>
                                                        <div class="h-24 w-16"></div>
                                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                            <svg class="w-10 h-10 text-white bg-green-500 rounded-full p-1 shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php elseif($dayData['current']): ?>
                                                <!-- Current but already claimed today -->
                                                <?php if($dayData['day'] == 7): ?>
                                                    <div class="text-6xl opacity-50 grayscale">💰</div>
                                                <?php elseif($dayData['day'] == 1): ?>
                                                    <div class="text-5xl opacity-50 grayscale">🪙</div>
                                                <?php else: ?>
                                                    <div class="relative opacity-50 grayscale">
                                                        <?php for($i = 0; $i < min($dayData['day'], 4); $i++): ?>
                                                            <div class="text-3xl absolute" style="bottom: <?php echo e($i * 8); ?>px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <?php endfor; ?>
                                                        <div class="h-24 w-16"></div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <!-- Locked/Future: Grayscale -->
                                                <?php if($dayData['day'] == 7): ?>
                                                    <div class="text-6xl opacity-30 grayscale">💰</div>
                                                <?php elseif($dayData['day'] == 1): ?>
                                                    <div class="text-5xl opacity-30 grayscale">🪙</div>
                                                <?php else: ?>
                                                    <div class="relative opacity-30 grayscale">
                                                        <?php for($i = 0; $i < min($dayData['day'], 4); $i++): ?>
                                                            <div class="text-3xl absolute" style="bottom: <?php echo e($i * 8); ?>px; left: 50%; transform: translateX(-50%);">🪙</div>
                                                        <?php endfor; ?>
                                                        <div class="h-24 w-16"></div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Day Label with Points (Hidden when can claim) -->
                                    <?php if(!($dayData['current'] && $canClaim)): ?>
                                        <div class="text-xs text-gray-600 font-semibold">
                                            Day <?php echo e($dayData['day']); ?>

                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?php echo e($dayData['points']); ?> pts
                                        </div>
                                    <?php else: ?>
                                        <!-- Empty space to maintain alignment -->
                                        <div class="h-8"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if(!$loop->last): ?>
                                <!-- Connector Line -->
                                <div class="flex-shrink-0 w-8 h-0.5 <?php echo e($dayData['claimed'] ? 'bg-yellow-400' : 'bg-gray-200'); ?> mb-12"></div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <style>
                    @keyframes spin-coin {
                        0% { transform: rotateY(0deg) scale(1); }
                        50% { transform: rotateY(180deg) scale(1.15); }
                        100% { transform: rotateY(360deg) scale(1); }
                    }
                    
                    @keyframes shake-treasure {
                        0%, 100% { transform: rotate(0deg) scale(1); }
                        25% { transform: rotate(-5deg) scale(1.05); }
                        75% { transform: rotate(5deg) scale(1.05); }
                    }
                    
                    .coin-stack-button:active {
                        animation: spin-coin 0.6s ease-in-out;
                    }
                    
                    .coin-stack-button:hover {
                        filter: brightness(1.1);
                    }
                    
                    .coin-stack-button:active:has(div:first-child:contains("💰")) {
                        animation: shake-treasure 0.5s ease-in-out;
                    }
                </style>
            <?php endif; ?>
        <?php endif; ?>

        <!-- produk utama (paginasi, filter, search) -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-lg">
                    <?php if(request('category')): ?>
                        <?php echo e($categories->firstWhere('slug', request('category'))?->name ?? 'Produk'); ?>

                    <?php else: ?>
                        Produk
                    <?php endif; ?>
                </h2>
                <?php if(request('category')): ?>
                    <a href="<?php echo e(route('home', request()->except(['category','page']))); ?>" class="text-blue-600">Lihat Semua</a>
                <?php endif; ?>
            </div>
            <div class="grid grid-cols-5 gap-4">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php echo $__env->make('components.product-card', ['product'=>$product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-5 text-center text-gray-500">Produk tidak ditemukan</div>
                <?php endif; ?>
            </div>
            <div class="mt-6">
                <?php if($products->hasPages()): ?>
                    <nav class="flex justify-center">
                        <ul class="inline-flex -space-x-px">
                            <?php $__currentLoopData = $products->links()->elements[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $products->currentPage()): ?>
                                    <li>
                                        <span class="px-3 py-1 bg-blue-600 text-white rounded mx-1"><?php echo e($page); ?></span>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="<?php echo e($url); ?>" class="px-3 py-1 bg-gray-200 text-gray-700 rounded mx-1 hover:bg-blue-100"><?php echo e($page); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/home.blade.php ENDPATH**/ ?>