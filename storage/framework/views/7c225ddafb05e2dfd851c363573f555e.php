

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📊 Laporan Penjualan</h1>
            <p class="text-gray-600">Ringkasan semua transaksi (Kasir + Online)</p>
        </div>
        
        <!-- Export Buttons -->
        <div x-data="{ 
            showExportMenu: false, 
            selectedType: '', 
            selectedFormat: '',
            showAdvancedFilters: false,
            customerId: '',
            productId: '',
            dateFrom: '',
            dateTo: ''
        }" class="relative">
            <button @click="showExportMenu = !showExportMenu; selectedType = ''; selectedFormat = ''; showAdvancedFilters = false;" 
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
                 style="display: none;"
                 x-cloak>
                
                <!-- Step 1: Pilih Tipe -->
                <div x-show="!selectedType" class="p-4">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Langkah 1: Pilih Tipe Transaksi</p>
                    <div class="space-y-2">
                        <button @click="selectedType = 'online'" 
                                class="w-full px-4 py-3 text-left bg-orange-50 hover:bg-orange-100 rounded-lg border border-orange-200 transition flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Pesanan Online</p>
                                <p class="text-xs text-gray-600">Transaksi dari e-commerce</p>
                            </div>
                        </button>
                        
                        <button @click="selectedType = 'kasir'" 
                                class="w-full px-4 py-3 text-left bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Transaksi Offline (Kasir)</p>
                                <p class="text-xs text-gray-600">Transaksi dari POS kasir</p>
                            </div>
                        </button>
                        
                        <button @click="selectedType = 'all'" 
                                class="w-full px-4 py-3 text-left bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Semua Transaksi</p>
                                <p class="text-xs text-gray-600">Online + Offline (Kasir)</p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Pilih Periode & Format -->
                <div x-show="selectedType" class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-semibold text-gray-700">Langkah 2: Pilih Periode & Format</p>
                        <button @click="selectedType = ''; selectedFormat = ''; showAdvancedFilters = false; customerId = ''; productId = '';" class="text-xs text-blue-600 hover:text-blue-700">
                            ← Kembali
                        </button>
                    </div>
                    
                    <!-- Advanced Filters Toggle -->
                    <div class="mb-4 pb-4 border-b border-gray-200">
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
                    
                    <!-- Excel Options -->
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-1">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Excel (XLSX)
                        </p>
                        <div class="space-y-1">
                            <a :href="`<?php echo e(route('admin.reports.export')); ?>?format=excel&type=${selectedType}&period=1day&customer_id=${customerId}&product_id=${productId}`" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded transition">📅 Hari Ini</a>
                            <a :href="`<?php echo e(route('admin.reports.export')); ?>?format=excel&type=${selectedType}&period=1week&customer_id=${customerId}&product_id=${productId}`" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded transition">📊 1 Minggu</a>
                            <a :href="`<?php echo e(route('admin.reports.export')); ?>?format=excel&type=${selectedType}&period=1month&customer_id=${customerId}&product_id=${productId}`" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded transition">📈 1 Bulan</a>
                            <a :href="`<?php echo e(route('admin.reports.export')); ?>?format=excel&type=${selectedType}&period=lifetime&customer_id=${customerId}&product_id=${productId}`" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded transition">🗂️ Lifetime</a>
                        </div>
                    </div>

                    <!-- PDF Options -->
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-1">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            PDF
                        </p>
                        <div class="space-y-1">
                            <a :href="`<?php echo e(route('admin.reports.export')); ?>?format=pdf&type=${selectedType}&period=1day&customer_id=${customerId}&product_id=${productId}`" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded transition">📅 Hari Ini</a>
                            <a :href="`<?php echo e(route('admin.reports.export')); ?>?format=pdf&type=${selectedType}&period=1week&customer_id=${customerId}&product_id=${productId}`" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded transition">📊 1 Minggu</a>
                            <a :href="`<?php echo e(route('admin.reports.export')); ?>?format=pdf&type=${selectedType}&period=1month&customer_id=${customerId}&product_id=${productId}`" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded transition">📈 1 Bulan</a>
                            <a :href="`<?php echo e(route('admin.reports.export')); ?>?format=pdf&type=${selectedType}&period=lifetime&customer_id=${customerId}&product_id=${productId}`" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded transition">🗂️ Lifetime</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($stats['total_transactions'])); ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">Rp <?php echo e(number_format($stats['total_revenue'], 0, ',', '.')); ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Kasir</p>
                    <p class="text-lg font-bold text-gray-900 mt-1"><?php echo e($stats['kasir_transactions']); ?> transaksi</p>
                    <p class="text-xs text-gray-500">Rp <?php echo e(number_format($stats['kasir_revenue'], 0, ',', '.')); ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Online</p>
                    <p class="text-lg font-bold text-gray-900 mt-1"><?php echo e($stats['online_transactions']); ?> transaksi</p>
                    <p class="text-xs text-gray-500">Rp <?php echo e(number_format($stats['online_revenue'], 0, ',', '.')); ?></p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Filter -->
    <div class="mb-6" x-data="{ activeTab: '<?php echo e(request('type', 'all')); ?>' }">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-1 inline-flex gap-1">
            <a href="<?php echo e(route('admin.reports', array_merge(request()->except('type'), ['type' => 'all']))); ?>" 
               @click="activeTab = 'all'"
               :class="activeTab === 'all' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100'"
               class="px-6 py-2.5 rounded-md font-medium text-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Semua
            </a>
            <a href="<?php echo e(route('admin.reports', array_merge(request()->except('type'), ['type' => 'kasir']))); ?>" 
               @click="activeTab = 'kasir'"
               :class="activeTab === 'kasir' ? 'bg-purple-600 text-white' : 'text-gray-600 hover:bg-gray-100'"
               class="px-6 py-2.5 rounded-md font-medium text-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Offline (Kasir)
            </a>
            <a href="<?php echo e(route('admin.reports', array_merge(request()->except('type'), ['type' => 'online']))); ?>" 
               @click="activeTab = 'online'"
               :class="activeTab === 'online' ? 'bg-orange-600 text-white' : 'text-gray-600 hover:bg-gray-100'"
               class="px-6 py-2.5 rounded-md font-medium text-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Online
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" class="flex gap-4 items-end">
            <input type="hidden" name="type" value="<?php echo e(request('type', 'all')); ?>">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-2">Dari Tanggal</label>
                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-2">Sampai Tanggal</label>
                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Filter</button>
                <a href="<?php echo e(route('admin.reports', ['type' => request('type', 'all')])); ?>" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Reset</a>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($transaction->order_number); ?></td>
                    <td class="px-6 py-4 text-sm"><?php echo e($transaction->created_at->format('d M Y H:i')); ?></td>
                    <td class="px-6 py-4 text-sm">
                        <?php if($transaction->shipping_method === 'kasir'): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Kasir</span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Online</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <?php if($transaction->shipping_method === 'kasir' && $transaction->member): ?>
                            <div>
                                <div class="font-medium text-gray-900"><?php echo e($transaction->member->name); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($transaction->member->email); ?></div>
                            </div>
                        <?php elseif($transaction->shipping_method !== 'kasir' && $transaction->user): ?>
                            <div>
                                <div class="font-medium text-gray-900"><?php echo e($transaction->user->name); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($transaction->user->email); ?></div>
                            </div>
                        <?php else: ?>
                            <span class="text-gray-400">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <?php if($transaction->shipping_method === 'kasir'): ?>
                            <?php echo e($transaction->user ? $transaction->user->name : '-'); ?>

                        <?php else: ?>
                            <span class="text-gray-400">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold">Rp <?php echo e(number_format($transaction->total, 0, ',', '.')); ?></td>
                    <td class="px-6 py-4 text-sm capitalize"><?php echo e($transaction->payment_method ?? '-'); ?></td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            <?php if($transaction->status === 'completed'): ?> bg-green-100 text-green-800
                            <?php elseif($transaction->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php else: ?> bg-gray-100 text-gray-800
                            <?php endif; ?>">
                            <?php echo e(ucfirst($transaction->status)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <?php if($transaction->is_verified): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                ✓ <?php echo e($transaction->points_awarded ?? 0); ?> poin
                            </span>
                        <?php else: ?>
                            <span class="text-gray-400">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi</td>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/admin/reports.blade.php ENDPATH**/ ?>