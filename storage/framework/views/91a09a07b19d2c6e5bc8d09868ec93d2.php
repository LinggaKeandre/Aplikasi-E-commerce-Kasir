

<?php $__env->startSection('title', 'Riwayat Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Transaksi Saya</h1>
            <p class="text-gray-600">Semua transaksi yang saya buat</p>
        </div>
        
        <!-- Export Buttons -->
        <div x-data="{ 
            showExportMenu: false,
            showAdvancedFilters: false,
            customerId: '',
            productId: ''
        }" class="relative">
            <button @click="showExportMenu = !showExportMenu; showAdvancedFilters = false; customerId = ''; productId = '';" 
                    class="bg-green-600 text-white px-6 py-2.5 rounded-lg hover:bg-green-700 flex items-center gap-2 shadow-md transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Laporan
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="showExportMenu" 
                 @click.away="showExportMenu = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl z-50 border border-gray-200"
                 style="display: none;">
                
                <div class="p-3 border-b border-gray-200">
                    <p class="text-sm font-semibold text-gray-700">Pilih Periode & Format</p>
                </div>
                
                <!-- Advanced Filters Toggle -->
                <div class="p-3 border-b border-gray-200">
                    <button @click="showAdvancedFilters = !showAdvancedFilters" 
                            class="w-full flex items-center justify-between px-3 py-2 bg-blue-50 hover:bg-blue-100 rounded-lg text-sm text-blue-700 transition">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            Filter Lanjutan (Opsional)
                        </span>
                        <svg class="w-4 h-4 transition-transform" :class="showAdvancedFilters ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <!-- Advanced Filter Options -->
                    <div x-show="showAdvancedFilters" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="mt-3 space-y-3">
                        <!-- Customer Filter -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Pelanggan Spesifik</label>
                            <select x-model="customerId" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Pelanggan</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?> (<?php echo e($customer->email); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Product Filter -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Produk Spesifik</label>
                            <select x-model="productId" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Produk</option>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product->id); ?>"><?php echo e($product->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="text-xs text-gray-500 bg-yellow-50 p-2 rounded border border-yellow-200">
                            💡 <strong>Tips:</strong> Filter ini akan menyaring data ekspor. Kosongkan untuk melihat semua data.
                        </div>
                    </div>
                </div>

                <!-- Excel Export Options -->
                <div class="p-3 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Excel (XLSX)
                    </p>
                    <a :href="`<?php echo e(route('kasir.riwayat.export')); ?>?format=excel&period=1day&customer_id=${customerId}&product_id=${productId}`" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded transition">
                        📅 Hari Ini
                    </a>
                    <a :href="`<?php echo e(route('kasir.riwayat.export')); ?>?format=excel&period=1week&customer_id=${customerId}&product_id=${productId}`" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded transition">
                        📊 1 Minggu Terakhir
                    </a>
                    <a :href="`<?php echo e(route('kasir.riwayat.export')); ?>?format=excel&period=1month&customer_id=${customerId}&product_id=${productId}`" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded transition">
                        📈 1 Bulan Terakhir
                    </a>
                    <a :href="`<?php echo e(route('kasir.riwayat.export')); ?>?format=excel&period=lifetime&customer_id=${customerId}&product_id=${productId}`" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded transition">
                        🗂️ Semua Transaksi (Lifetime)
                    </a>
                </div>

                <!-- PDF Export Options -->
                <div class="p-3">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        PDF
                    </p>
                    <a :href="`<?php echo e(route('kasir.riwayat.export')); ?>?format=pdf&period=1day&customer_id=${customerId}&product_id=${productId}`" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded transition">
                        📅 Hari Ini
                    </a>
                    <a :href="`<?php echo e(route('kasir.riwayat.export')); ?>?format=pdf&period=1week&customer_id=${customerId}&product_id=${productId}`" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded transition">
                        📊 1 Minggu Terakhir
                    </a>
                    <a :href="`<?php echo e(route('kasir.riwayat.export')); ?>?format=pdf&period=1month&customer_id=${customerId}&product_id=${productId}`" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded transition">
                        📈 1 Bulan Terakhir
                    </a>
                    <a :href="`<?php echo e(route('kasir.riwayat.export')); ?>?format=pdf&period=lifetime&customer_id=${customerId}&product_id=${productId}`" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded transition">
                        🗂️ Semua Transaksi (Lifetime)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Dari Tanggal</label>
                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Sampai Tanggal</label>
                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 mr-2">Filter</button>
                <a href="<?php echo e(route('kasir.riwayat')); ?>" class="border border-gray-300 px-6 py-2 rounded hover:bg-gray-50">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($transaction->order_number); ?></td>
                    <td class="px-6 py-4 text-sm"><?php echo e($transaction->created_at->format('d M Y H:i')); ?></td>
                    <td class="px-6 py-4 text-sm">
                        <?php if($transaction->member): ?>
                            <span class="text-gray-900"><?php echo e($transaction->member->email); ?></span>
                        <?php else: ?>
                            <span class="text-gray-400 italic">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold">Rp <?php echo e(number_format($transaction->total, 0, ',', '.')); ?></td>
                    <td class="px-6 py-4 text-sm capitalize"><?php echo e($transaction->payment_method ?? 'cash'); ?></td>
                    <td class="px-6 py-4 text-sm">
                        <?php if($transaction->member_id && $transaction->is_verified): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                ✓ <?php echo e($transaction->points_awarded ?? 0); ?> poin
                            </span>
                        <?php else: ?>
                            <span class="text-gray-400 italic">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <a href="<?php echo e(route('kasir.cetak-struk', $transaction->id)); ?>" 
                           target="_blank"
                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Cetak Struk
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <?php echo e($transactions->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kasir', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/kasir/riwayat.blade.php ENDPATH**/ ?>