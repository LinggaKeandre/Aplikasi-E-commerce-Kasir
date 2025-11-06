

<?php $__env->startSection('content'); ?>
<div x-data="{ activeTab: 'stats' }">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
        <p class="text-gray-600">Selamat datang di panel admin. Kelola toko Anda dengan mudah.</p>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex gap-4">
            <button @click="activeTab = 'stats'" 
                    :class="activeTab === 'stats' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-800'"
                    class="py-2 px-4 border-b-2 font-medium transition">
                📊 Statistik
            </button>
            <button @click="activeTab = 'charts'" 
                    :class="activeTab === 'charts' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-800'"
                    class="py-2 px-4 border-b-2 font-medium transition">
                📈 Grafik & Trend
            </button>
            <button @click="activeTab = 'alerts'" 
                    :class="activeTab === 'alerts' ? 'border-red-500 text-red-700 bg-red-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50'"
                    class="py-2 px-4 border-b-2 font-medium transition rounded-t-lg">
                ⚠️ Peringatan 
                <?php
                    $totalAlerts = $alertProducts->count();
                ?>
                <?php if($totalAlerts > 0): ?>
                <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?php echo e($totalAlerts); ?></span>
                <?php endif; ?>
            </button>
        </nav>
    </div>

    <!-- Statistics Tab -->
    <div x-show="activeTab === 'stats'" x-cloak>
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Penjualan Hari Ini -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Penjualan Hari Ini</h3>
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-800"><?php echo e($stats['sales_today']); ?></div>
                <div class="text-xs text-gray-500 mt-1">pesanan</div>
            </div>

            <!-- Total Penjualan Bulan Ini -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Penjualan Bulan Ini</h3>
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-800"><?php echo e($stats['sales_month']); ?></div>
                <div class="text-xs text-gray-500 mt-1">pesanan</div>
            </div>

            <!-- Revenue Hari Ini -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Pendapatan Hari Ini</h3>
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-800">Rp<?php echo e(number_format($stats['revenue_today'], 0, ',', '.')); ?></div>
                <div class="text-xs text-gray-500 mt-1">rupiah</div>
            </div>

            <!-- Revenue Bulan Ini -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Pendapatan Bulan Ini</h3>
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-800">Rp<?php echo e(number_format($stats['revenue_month'], 0, ',', '.')); ?></div>
                <div class="text-xs text-gray-500 mt-1">rupiah</div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            <!-- Total Pesanan -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-gray-600 text-sm mb-1">Total Pesanan</div>
                <div class="text-2xl font-bold text-gray-800"><?php echo e($stats['total_orders']); ?></div>
            </div>

            <!-- Produk Aktif -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-gray-600 text-sm mb-1">Produk Aktif</div>
                <div class="text-2xl font-bold text-green-600"><?php echo e($stats['active_products']); ?></div>
            </div>

            <!-- Total Pelanggan -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-gray-600 text-sm mb-1">Total Pelanggan</div>
                <div class="text-2xl font-bold text-blue-600"><?php echo e($stats['total_customers']); ?></div>
            </div>

            <!-- Stok Menipis -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-gray-600 text-sm mb-1">Stok Menipis</div>
                <div class="text-2xl font-bold text-orange-600"><?php echo e($stats['low_stock']); ?></div>
            </div>

            <!-- Stok Habis -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-gray-600 text-sm mb-1">Stok Habis</div>
                <div class="text-2xl font-bold text-red-600"><?php echo e($stats['out_of_stock']); ?></div>
            </div>
        </div>
        
        <!-- Kasir vs Online & Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Kasir Hari Ini -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow p-5 border border-purple-200">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-purple-700 text-sm font-semibold">Transaksi Kasir</h3>
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-purple-900"><?php echo e($stats['kasir_today']); ?> <span class="text-sm font-normal">hari ini</span></div>
                <div class="text-xs text-purple-700 mt-1">Rp <?php echo e(number_format($stats['kasir_revenue_today'], 0, ',', '.')); ?></div>
            </div>

            <!-- Online Hari Ini -->
            <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-lg shadow p-5 border border-cyan-200">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-cyan-700 text-sm font-semibold">Transaksi Online</h3>
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-cyan-900"><?php echo e($stats['online_today']); ?> <span class="text-sm font-normal">hari ini</span></div>
                <div class="text-xs text-cyan-700 mt-1">Rp <?php echo e(number_format($stats['online_revenue_today'], 0, ',', '.')); ?></div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg shadow p-5 border border-amber-200">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-amber-700 text-sm font-semibold">Perlu Diproses</h3>
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-amber-900"><?php echo e($stats['pending_orders']); ?></div>
                <div class="text-xs text-amber-700 mt-1">pesanan pending</div>
            </div>

            <!-- Average Order Value -->
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg shadow p-5 border border-teal-200">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-teal-700 text-sm font-semibold">Rata-rata Transaksi</h3>
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="text-lg font-bold text-teal-900">Rp <?php echo e(number_format($stats['avg_order_value'], 0, ',', '.')); ?></div>
                <div class="text-xs text-teal-700 mt-1">bulan ini</div>
            </div>
        </div>
        
        <!-- More Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- New Customers -->
            <div class="bg-white rounded-lg shadow-md p-5 border-l-4 border-indigo-500">
                <div class="text-gray-600 text-sm mb-1">Pelanggan Baru (Minggu Ini)</div>
                <div class="text-2xl font-bold text-indigo-600"><?php echo e($stats['new_customers_week']); ?></div>
            </div>

            <!-- Points Given -->
            <div class="bg-white rounded-lg shadow-md p-5 border-l-4 border-pink-500">
                <div class="text-gray-600 text-sm mb-1">Poin Diberikan (Bulan Ini)</div>
                <div class="text-2xl font-bold text-pink-600"><?php echo e(number_format($stats['points_given_month'])); ?></div>
            </div>

            <!-- Inventory Value -->
            <div class="bg-white rounded-lg shadow-md p-5 border-l-4 border-emerald-500">
                <div class="text-gray-600 text-sm mb-1">Nilai Inventori</div>
                <div class="text-xl font-bold text-emerald-600">Rp <?php echo e(number_format($stats['inventory_value'], 0, ',', '.')); ?></div>
            </div>

            <!-- Cancelled Orders -->
            <div class="bg-white rounded-lg shadow-md p-5 border-l-4 border-rose-500">
                <div class="text-gray-600 text-sm mb-1">Dibatalkan (Bulan Ini)</div>
                <div class="text-2xl font-bold text-rose-600"><?php echo e($stats['cancelled_month']); ?></div>
            </div>
        </div>
    </div>

    <!-- Charts & Trends Tab -->
    <div x-show="activeTab === 'charts'" x-cloak>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Sales Chart (7 days) -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Trend Penjualan (7 Hari Terakhir)</h3>
                <div class="space-y-2">
                    <?php
                        $maxRevenue = max(array_column($salesChart, 'revenue'));
                    ?>
                    <?php $__currentLoopData = $salesChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700"><?php echo e($day['date']); ?></span>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-gray-600"><?php echo e($day['count']); ?> order</span>
                                    <span class="text-sm font-semibold text-blue-600">Rp <?php echo e(number_format($day['revenue'], 0, ',', '.')); ?></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-500" 
                                     style="width: <?php echo e($maxRevenue > 0 ? ($day['revenue'] / $maxRevenue * 100) : 0); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🏆 Top 5 Produk Terlaris</h3>
                <div class="space-y-4">
                    <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($item->product): ?>
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white font-bold text-sm">
                                <?php echo e($index + 1); ?>

                            </div>
                            <img src="<?php echo e($item->product->image_url); ?>" alt="<?php echo e($item->product->title); ?>" class="w-12 h-12 object-cover rounded">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-900 truncate"><?php echo e($item->product->title); ?></div>
                                <div class="text-sm text-gray-500">Rp <?php echo e(number_format($item->product->price, 0, ',', '.')); ?></div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-blue-600"><?php echo e($item->total_sold); ?></div>
                                <div class="text-xs text-gray-500">terjual</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Vouchers -->
            <div class="bg-gradient-to-br from-violet-50 to-violet-100 rounded-lg shadow p-6 border border-violet-200">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-violet-700 text-sm font-medium mb-1">Voucher Aktif</div>
                        <div class="text-3xl font-bold text-violet-900"><?php echo e($stats['active_vouchers']); ?></div>
                    </div>
                    <div class="w-12 h-12 bg-violet-200 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Reviews to Reply -->
            <div class="bg-gradient-to-br from-sky-50 to-sky-100 rounded-lg shadow p-6 border border-sky-200">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sky-700 text-sm font-medium mb-1">Review Perlu Dibalas</div>
                        <div class="text-3xl font-bold text-sky-900"><?php echo e($stats['pending_reviews']); ?></div>
                    </div>
                    <div class="w-12 h-12 bg-sky-200 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cancellation Requests -->
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg shadow p-6 border border-red-200">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-red-700 text-sm font-medium mb-1">Request Pembatalan</div>
                        <div class="text-3xl font-bold text-red-900"><?php echo e($stats['pending_cancellations']); ?></div>
                    </div>
                    <div class="w-12 h-12 bg-red-200 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Tab -->
    <div x-show="activeTab === 'alerts'" x-cloak>
        <div class="space-y-6">
            <!-- Stok Alert -->
            <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-lg shadow-md overflow-hidden border-2 border-red-200">
                <div class="p-6 border-b border-red-200 bg-red-50/50">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-100 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-red-900">📦 Peringatan Stok</h2>
                            <p class="text-sm text-red-700 mt-1">Produk dengan stok menipis atau habis - segera restock!</p>
                        </div>
                        <div class="ml-auto">
                            <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full"><?php echo e($alertProducts->count()); ?></span>
                        </div>
                    </div>
                </div>
                
                <?php if($alertProducts->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $alertProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e($product->image_url); ?>" 
                                                 alt="<?php echo e($product->title); ?>" 
                                                 class="w-12 h-12 object-cover rounded">
                                            <div>
                                                <div class="font-medium text-gray-900"><?php echo e($product->title); ?></div>
                                                <div class="text-sm text-gray-500">Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo e($product->category->name ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-2xl font-bold <?php echo e($product->stock == 0 ? 'text-red-600' : 'text-orange-600'); ?>">
                                            <?php echo e($product->stock); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($product->stock == 0): ?>
                                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                                🚫 Stok Habis
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">
                                                ⚠️ Stok Menipis
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-1">Semua Stok Aman</h3>
                        <p class="text-gray-500">Tidak ada produk dengan stok menipis atau habis</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>