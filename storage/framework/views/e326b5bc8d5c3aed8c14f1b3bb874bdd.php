

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <?php if(session('success')): ?>
    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">👥 Daftar Akun</h1>
            <p class="text-sm text-gray-600">Kelola akun member, kasir, dan admin</p>
        </div>
        <a href="<?php echo e(route('admin.accounts.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
            + Tambah Akun
        </a>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <form method="GET" action="<?php echo e(route('admin.accounts')); ?>" class="flex gap-3">
            <div class="flex-1 relative">
                <input type="text" 
                       name="search" 
                       value="<?php echo e(request('search')); ?>"
                       placeholder="Cari nama, email, telepon, atau role..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                Cari
            </button>
            <?php if(request('search')): ?>
            <a href="<?php echo e(route('admin.accounts')); ?>" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                Reset
            </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php if($users->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($user->id); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <?php if($user->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $user->photo)); ?>" 
                                             alt="<?php echo e($user->name); ?>"
                                             class="w-10 h-10 rounded-full border border-gray-200">
                                    <?php else: ?>
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                        </div>
                                    <?php endif; ?>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo e($user->email); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $roleColors = [
                                        'admin' => 'bg-purple-100 text-purple-800',
                                        'kasir' => 'bg-green-100 text-green-800',
                                        'member' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $roleLabels = [
                                        'admin' => 'Admin',
                                        'kasir' => 'Kasir',
                                        'member' => 'Member',
                                    ];
                                    $color = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800';
                                    $label = $roleLabels[$user->role] ?? ucfirst($user->role);
                                ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($color); ?>">
                                    <?php echo e($label); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo e($user->phone ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo e($user->created_at->format('d M Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <?php if($user->id !== Auth::id()): ?>
                                <a href="<?php echo e(route('admin.accounts.edit', $user->id)); ?>" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="<?php echo e(route('admin.accounts.delete', $user->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                </form>
                                <?php else: ?>
                                <span class="text-gray-400 font-medium">Akun Anda</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-200">
                <?php echo e($users->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/admin/accounts.blade.php ENDPATH**/ ?>