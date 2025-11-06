

<?php $__env->startSection('title', 'Pelanggan'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Data Pelanggan</h1>
            <p class="text-gray-600">Daftar pelanggan dan riwayat pembelian</p>
        </div>
        <a href="<?php echo e(route('kasir.member.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Member
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo e(session('error')); ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Pesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bergabung</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $paginatedCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <?php if($customer->photo): ?>
                                <img src="<?php echo e(asset('storage/' . $customer->photo)); ?>" class="w-10 h-10 rounded-full mr-3">
                            <?php else: ?>
                                <div class="w-10 h-10 bg-gray-300 rounded-full mr-3 flex items-center justify-center text-white font-bold">
                                    <?php echo e(strtoupper(substr($customer->name, 0, 1))); ?>

                                </div>
                            <?php endif; ?>
                            <span class="font-medium"><?php echo e($customer->name); ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm"><?php echo e($customer->email); ?></td>
                    <td class="px-6 py-4 text-sm"><?php echo e($customer->orders_count); ?> pesanan</td>
                    <td class="px-6 py-4 text-sm"><?php echo e($customer->created_at->format('d M Y')); ?></td>
                    <td class="px-6 py-4">
                        <a href="<?php echo e(route('kasir.pelanggan.riwayat', $customer->id)); ?>" 
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            Lihat Riwayat
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada pelanggan</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <?php echo e($paginatedCustomers->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kasir', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/kasir/pelanggan.blade.php ENDPATH**/ ?>