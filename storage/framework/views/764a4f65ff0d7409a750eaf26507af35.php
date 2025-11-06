<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - Kasir Panel</title>
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
            <a href="<?php echo e(route('kasir.dashboard')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <span class="font-bold text-xl text-gray-800">Kasir Panel</span>
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
                                 class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200 shadow cursor-pointer hover:border-green-500 transition">
                                <img src="<?php echo e(asset('storage/' . Auth::user()->photo)); ?>" 
                                     class="w-full h-full object-cover">
                            </div>
                        <?php else: ?>
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow">
                                <?php echo e(strtoupper(substr(Auth::user()->name ?? 'K', 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="font-bold text-gray-800"><?php echo e(Auth::user()->name ?? 'Kasir'); ?></div>
                            <div class="text-xs text-gray-500">Kasir</div>
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
                <a href="<?php echo e(route('kasir.transaksi')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('kasir.transaksi*') || request()->routeIs('kasir.cetak-struk') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Transaksi Penjualan
                </a>
                <a href="<?php echo e(route('kasir.riwayat')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('kasir.riwayat*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Riwayat Transaksi
                </a>
                <a href="<?php echo e(route('kasir.pelanggan')); ?>" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2 <?php echo e(request()->routeIs('kasir.pelanggan*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Pelanggan
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
    <div @mouseenter="sidebar=true" class="fixed left-0 top-0 bottom-0 w-1 z-40 hover:bg-green-500 transition-colors"></div>

    <!-- Visual Indicator when sidebar closed -->
    <div x-show="!sidebar" class="fixed left-0 top-1/2 -translate-y-1/2 bg-green-600 text-white px-1 py-3 rounded-r-lg shadow-lg z-30 cursor-pointer" @mouseenter="sidebar=true">
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
<?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/layouts/kasir.blade.php ENDPATH**/ ?>