@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{
    photoModal: false,
    photoUrl: ''
}">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Profil Admin</h1>
        <p class="text-sm text-gray-600">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Profile Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h2>
                
                <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Read Only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="{{ $user->email }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                               disabled>
                        <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                    </div>

                    <!-- Role (Read Only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <input type="text" value="Administrator" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                               disabled>
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                               placeholder="08xxxxxxxxxx"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin & Tanggal Lahir -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select name="gender" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}" 
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="address" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Jalan, No. Rumah, RT/RW">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <!-- Kota, Provinsi, Kode Pos -->
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                            <input type="text" name="province" value="{{ old('province', $user->province) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" 
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
                
                <form method="POST" action="{{ route('admin.profile.password') }}" x-data="{open: false}">
                    @csrf
                    @method('PUT')

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
            <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 text-center">Foto Profil</h2>
                
                <div class="flex flex-col items-center" x-data="{
                    preview: '{{ $user->photo ? asset('storage/' . $user->photo) : '' }}',
                    hasNewPhoto: false,
                    selectedFile: null,
                    errorMessage: '',
                    validateFile(file) {
                        this.errorMessage = '';
                        
                        // Check file size (2MB = 2 * 1024 * 1024 bytes)
                        const maxSize = 2 * 1024 * 1024;
                        if (file.size > maxSize) {
                            this.errorMessage = 'Ukuran file terlalu besar! Maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB';
                            this.hasNewPhoto = false;
                            this.selectedFile = null;
                            return false;
                        }
                        
                        // Check file type
                        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                        if (!allowedTypes.includes(file.type)) {
                            this.errorMessage = 'Format file tidak didukung! Gunakan JPG, JPEG, atau PNG';
                            this.hasNewPhoto = false;
                            this.selectedFile = null;
                            return false;
                        }
                        
                        return true;
                    }
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
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </template>
                    </div>

                    <!-- Upload Photo Form -->
                    <form method="POST" action="{{ route('admin.profile.photo') }}" enctype="multipart/form-data" class="w-full" 
                          @submit="hasNewPhoto = false; selectedFile = null; errorMessage = ''">
                        @csrf
                        @method('PUT')
                        
                        <input type="file" name="photo" id="photo" accept="image/*" class="hidden"
                               @change="
                                   selectedFile = $event.target.files[0];
                                   if (selectedFile && validateFile(selectedFile)) {
                                       preview = URL.createObjectURL(selectedFile); 
                                       hasNewPhoto = true;
                                   } else {
                                       $event.target.value = '';
                                   }
                               ">
                        
                        <!-- Error Message -->
                        <div x-show="errorMessage" x-cloak class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-xs text-red-600 text-center" x-text="errorMessage"></p>
                        </div>
                        
                        <!-- Backend Validation Error -->
                        @error('photo')
                            <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-xs text-red-600 text-center">{{ $message }}</p>
                            </div>
                        @enderror
                        
                        <div class="space-y-2">
                            <label for="photo" class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition cursor-pointer text-sm font-medium">
                                Pilih Foto
                            </label>
                            
                            <button type="submit" x-show="hasNewPhoto" x-cloak class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                Upload Foto
                            </button>
                        </div>
                    </form>

                    @if($user->photo)
                        <form method="POST" action="{{ route('admin.profile.photo.delete') }}" class="w-full mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block w-full bg-red-100 text-red-600 text-center px-4 py-2 rounded-lg hover:bg-red-200 transition text-sm font-medium"
                                    onclick="return confirm('Hapus foto profil?')">
                                Hapus Foto
                            </button>
                        </form>
                    @endif

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
@endsection
