<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebar: false, photoModal: false, photoUrl: '' }">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="mx-auto px-4 py-3 flex items-center justify-between">
            <!-- Logo -->
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span class="font-bold text-xl text-gray-800">Admin Panel</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar -->
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
            <a href="<?php echo e(route('profile.show')); ?>" class="block p-6 hover:bg-gray-50 transition border-b border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <?php if(Auth::user()->photo): ?>
                            <div @click.prevent="photoModal = true; photoUrl = '<?php echo e(asset('storage/' . Auth::user()->photo)); ?>'" 
                                 class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200 shadow cursor-pointer hover:border-blue-500 transition">
                                <img src="<?php echo e(asset('storage/' . Auth::user()->photo)); ?>" 
                                     class="w-full h-full object-cover">
                            </div>
                        <?php else: ?>
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow">
                                <?php echo e(strtoupper(substr(Auth::user()->name ?? 'A', 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="font-bold text-gray-800"><?php echo e(Auth::user()->name ?? 'Admin'); ?></div>
                            <div class="text-xs text-gray-500">Administrator</div>
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
            <nav class="flex-1 flex flex-col gap-2 p-4 overflow-y-auto">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
                <a href="<?php echo e(route('admin.products')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('admin.products*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Produk
                </a>
                <a href="<?php echo e(route('admin.categories')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('admin.categories*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Kategori
                </a>
                <a href="<?php echo e(route('admin.reviews')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('admin.reviews*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Review Pelanggan
                </a>
                <a href="<?php echo e(route('admin.reports')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('admin.reports*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Laporan
                </a>
                <a href="<?php echo e(route('admin.orders')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('admin.orders*') && !request()->routeIs('admin.orders.cancellations*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Pesanan</span>
                    <?php
                        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
                    ?>
                    <?php if($pendingOrders > 0): ?>
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?php echo e($pendingOrders); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.orders.cancellations')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('admin.orders.cancellations*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span>Pembatalan</span>
                    <?php
                        $pendingCancellations = \App\Models\OrderCancellationRequest::where('status', 'pending')->count();
                    ?>
                    <?php if($pendingCancellations > 0): ?>
                    <span class="ml-auto bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?php echo e($pendingCancellations); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.accounts')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('admin.accounts*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Akun
                </a>
                <a href="<?php echo e(route('admin.promotions')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Promosi
                </a>
                
                <hr class="my-2">
                
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="py-2 px-3 rounded text-red-600 hover:bg-red-50 w-full text-left flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </nav>
        </div>
        
        <!-- Backdrop blur -->
        <div @click="sidebar=false" class="flex-1 bg-black bg-opacity-30 backdrop-blur-sm"></div>
    </div>

    <!-- Trigger Area -->
    <div @mouseenter="sidebar=true" class="fixed left-0 top-0 bottom-0 w-1 z-40 hover:bg-blue-500 transition-colors"></div>

    <!-- Visual Indicator when sidebar closed -->
    <div x-show="!sidebar" class="fixed left-0 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-1 py-3 rounded-r-lg shadow-lg z-30 cursor-pointer" @mouseenter="sidebar=true">
        <div class="text-xs">››</div>
    </div>

    <!-- Main Content -->
    <main class="p-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

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
                    class="absolute -top-10 right-0 text-white hover:text-gray-300 text-3xl font-bold z-10">
                &times;
            </button>
            
            <!-- Photo -->
            <img :src="photoUrl" 
                 alt="Profile Photo" 
                 class="max-w-full max-h-[80vh] rounded-lg shadow-2xl border-4 border-white"
                 @click.stop>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/layouts/admin.blade.php ENDPATH**/ ?>