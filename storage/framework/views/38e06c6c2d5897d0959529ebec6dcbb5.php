

<?php $__env->startSection('title', 'Manajemen Banner Promosi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6" x-data="{ activeTab: '<?php echo e(request('position', 'home')); ?>' }">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Banner Promosi</h1>
            <p class="text-gray-600 mt-1">Kelola banner di katalog dan layar customer</p>
        </div>
        <a href="<?php echo e(route('admin.banners.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">Tambah Banner</a>
    </div>

    <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-1 inline-flex gap-1 mb-6">
        <a href="<?php echo e(route('admin.banners.index', ['position' => 'home'])); ?>" @click="activeTab = 'home'" :class="activeTab === 'home' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100'" class="px-6 py-2.5 rounded-md font-medium text-sm transition">Banner Katalog</a>
        <a href="<?php echo e(route('admin.banners.index', ['position' => 'customer_display'])); ?>" @click="activeTab = 'customer_display'" :class="activeTab === 'customer_display' ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-gray-100'" class="px-6 py-2.5 rounded-md font-medium text-sm transition">Banner Customer Display</a>
    </div>

    <?php
        $position = request('position', 'home');
        $filteredBanners = $banners->where('position', $position)->sortBy('display_order');
    ?>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <?php if($filteredBanners->count() > 0): ?>
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">Urutan</th>
                    <th class="px-6 py-4 text-left">Preview</th>
                    <th class="px-6 py-4 text-left">Judul</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $filteredBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <?php if(!$loop->first): ?>
                        <form action="<?php echo e(route('admin.banners.reorder', $banner)); ?>" method="POST" class="inline"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><input type="hidden" name="direction" value="up"><button type="submit">↑</button></form>
                        <?php endif; ?>
                        <?php if(!$loop->last): ?>
                        <form action="<?php echo e(route('admin.banners.reorder', $banner)); ?>" method="POST" class="inline"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><input type="hidden" name="direction" value="down"><button type="submit">↓</button></form>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4"><img src="<?php echo e(asset('storage/' . $banner->image_path)); ?>" class="h-20 w-40 object-cover rounded"></td>
                    <td class="px-6 py-4">
                        <div><?php echo e($banner->title); ?></div>
                        <span class="text-xs px-2 py-1 rounded <?php echo e($position === 'home' ? 'bg-blue-100' : 'bg-green-100'); ?>"><?php echo e($position === 'home' ? 'Katalog' : 'Customer Display'); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="<?php echo e(route('admin.banners.toggle', $banner)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><button type="submit" class="px-3 py-1 rounded <?php echo e($banner->is_active ? 'bg-green-100' : 'bg-gray-100'); ?>"><?php echo e($banner->is_active ? 'Aktif' : 'Nonaktif'); ?></button></form>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="<?php echo e(route('admin.banners.edit', $banner)); ?>" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                        <form action="<?php echo e(route('admin.banners.destroy', $banner)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button></form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="text-center py-12">
            <h3 class="text-lg font-medium">Belum ada banner <?php echo e($position === 'home' ? 'katalog' : 'customer display'); ?></h3>
            <a href="<?php echo e(route('admin.banners.create')); ?>" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded">Tambah Banner</a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>