

<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-6" x-data="{
    photoModal: false,
    photoUrl: ''
}">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
        <p class="text-sm text-gray-600">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
    </div>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700">×</button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e(session('error')); ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-700">×</button>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Profile Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h2>
                
                <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email (Read Only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="<?php echo e($user->email); ?>" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                               disabled>
                        <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" 
                               placeholder="08xxxxxxxxxx"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Jenis Kelamin & Tanggal Lahir -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select name="gender" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih</option>
                                <option value="male" <?php echo e(old('gender', $user->gender) == 'male' ? 'selected' : ''); ?>>Laki-laki</option>
                                <option value="female" <?php echo e(old('gender', $user->gender) == 'female' ? 'selected' : ''); ?>>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="<?php echo e(old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '')); ?>" 
                                   max="<?php echo e(date('Y-m-d')); ?>"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="address" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Jalan, No. Rumah, RT/RW"><?php echo e(old('address', $user->address)); ?></textarea>
                    </div>

                    <!-- Kota, Provinsi, Kode Pos -->
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                            <input type="text" name="city" value="<?php echo e(old('city', $user->city)); ?>" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                            <input type="text" name="province" value="<?php echo e(old('province', $user->province)); ?>" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                            <input type="text" name="postal_code" value="<?php echo e(old('postal_code', $user->postal_code)); ?>" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-medium">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Section -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Keamanan Akun</h2>
                
                <form method="POST" action="<?php echo e(route('profile.password')); ?>" x-data="{open: false}">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="font-medium text-gray-700">Password</p>
                            <p class="text-sm text-gray-500">Ubah password Anda secara berkala untuk keamanan</p>
                        </div>
                        <button type="button" @click="open = !open" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                            <span x-show="!open">Ubah Password</span>
                            <span x-show="open" x-cloak>Batal</span>
                        </button>
                    </div>

                    <div x-show="open" x-cloak class="space-y-4 border-t pt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                            <input type="password" name="current_password" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                            <input type="password" name="new_password" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Photo Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-20">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 text-center">Foto Profil</h2>
                
                <div class="flex flex-col items-center" x-data="{
                    preview: '<?php echo e($user->photo ? asset('storage/' . $user->photo) : ''); ?>',
                    hasNewPhoto: false,
                    selectedFile: null
                }">
                    <!-- Photo Preview -->
                    <div class="w-32 h-32 mb-4">
                        <template x-if="preview">
                            <div @click="photoModal = true; photoUrl = preview" 
                                 class="w-full h-full rounded-full overflow-hidden border-4 border-gray-200 shadow-lg cursor-pointer hover:border-blue-500 transition">
                                <img :src="preview" class="w-full h-full object-cover">
                            </div>
                        </template>
                        <template x-if="!preview">
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                            </div>
                        </template>
                    </div>

                    <!-- Upload Photo Form (Separate) -->
                    <form method="POST" action="<?php echo e(route('profile.photo.upload')); ?>" enctype="multipart/form-data" class="w-full" 
                          @submit="hasNewPhoto = false; selectedFile = null">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <input type="file" name="photo" id="photo" accept="image/*" class="hidden"
                               @change="
                                   selectedFile = $event.target.files[0];
                                   preview = URL.createObjectURL(selectedFile); 
                                   hasNewPhoto = true
                               ">
                        
                        <div class="space-y-2">
                            <label for="photo" class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition cursor-pointer text-sm font-medium">
                                Pilih Foto
                            </label>
                            
                            <button type="submit" x-show="hasNewPhoto" x-cloak class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                Upload Foto
                            </button>
                        </div>
                    </form>

                    <?php if($user->photo): ?>
                        <form method="POST" action="<?php echo e(route('profile.photo.delete')); ?>" class="w-full mt-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="block w-full bg-red-100 text-red-600 text-center px-4 py-2 rounded-lg hover:bg-red-200 transition text-sm font-medium"
                                    onclick="return confirm('Hapus foto profil?')">
                                Hapus Foto
                            </button>
                        </form>
                    <?php endif; ?>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        Format: JPG, JPEG, PNG<br>
                        Maksimal: 2MB
                    </p>
                </div>
            </div>
        </div>
    </div>

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
                    class="absolute -top-3 -right-3 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition z-10">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <!-- Photo Container with Border -->
            <div class="border-4 border-white rounded-lg shadow-2xl overflow-hidden bg-white"
                 @click.stop>
                <img :src="photoUrl" 
                     class="w-auto h-auto max-w-[600px] max-h-[600px] object-contain"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'kasir' ? 'layouts.kasir' : 'layouts.app'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/profile/show.blade.php ENDPATH**/ ?>