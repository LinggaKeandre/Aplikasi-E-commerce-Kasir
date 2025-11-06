

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Akun</h1>
        <p class="text-sm text-gray-600">Edit informasi akun <?php echo e($user->name); ?></p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?php echo e(route('admin.accounts.update', $user->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="space-y-4">
                <!-- Profile Photo -->
                <?php if($user->photo): ?>
                <div class="flex items-center gap-4 pb-4 border-b">
                    <img src="<?php echo e(asset('storage/' . $user->photo)); ?>" alt="<?php echo e($user->name); ?>"
                         class="w-20 h-20 rounded-full border-2 border-gray-200">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Foto Profil</p>
                        <p class="text-xs text-gray-500">Foto hanya bisa diubah oleh user sendiri</p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Read-only Data Pribadi -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-sm font-bold text-gray-800 mb-3">📋 Data Pribadi (Read-only)</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Nama Lengkap</p>
                            <p class="font-semibold text-gray-900"><?php echo e($user->name); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Email</p>
                            <p class="font-semibold text-gray-900"><?php echo e($user->email); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Telepon</p>
                            <p class="font-semibold text-gray-900"><?php echo e($user->phone ?? '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Jenis Kelamin</p>
                            <p class="font-semibold text-gray-900">
                                <?php if($user->gender === 'male'): ?>
                                    Laki-laki
                                <?php elseif($user->gender === 'female'): ?>
                                    Perempuan
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tanggal Lahir</p>
                            <p class="font-semibold text-gray-900"><?php echo e($user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d M Y') : '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kota</p>
                            <p class="font-semibold text-gray-900"><?php echo e($user->city ?? '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Provinsi</p>
                            <p class="font-semibold text-gray-900"><?php echo e($user->province ?? '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kode Pos</p>
                            <p class="font-semibold text-gray-900"><?php echo e($user->postal_code ?? '-'); ?></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-600">Alamat Lengkap</p>
                            <p class="font-semibold text-gray-900"><?php echo e($user->address ?? '-'); ?></p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">
                        ℹ️ Data pribadi tidak dapat diubah oleh admin. User harus mengubahnya sendiri dari halaman profile.
                    </p>
                </div>

                <hr class="my-4">

                <h3 class="text-sm font-bold text-gray-800 mb-3">✏️ Yang Dapat Diubah Admin</h3>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                    <select name="role" id="role" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="member" <?php echo e(old('role', $user->role) === 'member' ? 'selected' : ''); ?>>Member</option>
                        <option value="kasir" <?php echo e(old('role', $user->role) === 'kasir' ? 'selected' : ''); ?>>Kasir</option>
                        <option value="admin" <?php echo e(old('role', $user->role) === 'admin' ? 'selected' : ''); ?>>Admin</option>
                    </select>
                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <hr class="my-4">

                <!-- Password (Optional) -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-yellow-800 mb-2">⚠️ Ubah Password (Opsional)</p>
                    <p class="text-xs text-yellow-700 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                    <div class="space-y-3">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password" id="password"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-gray-700 mb-2">ℹ️ Informasi Akun</p>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p>ID: <span class="font-semibold"><?php echo e($user->id); ?></span></p>
                        <p>Terdaftar: <span class="font-semibold"><?php echo e($user->created_at->format('d M Y H:i')); ?></span></p>
                        <p>Update Terakhir: <span class="font-semibold"><?php echo e($user->updated_at->format('d M Y H:i')); ?></span></p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <a href="<?php echo e(route('admin.accounts')); ?>" 
                   class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/admin/accounts-edit.blade.php ENDPATH**/ ?>