@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.banners.index') }}" 
               class="text-gray-600 hover:text-gray-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Banner</h1>
        </div>
        <p class="text-gray-600">Perbarui informasi banner promosi</p>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-semibold text-blue-800 mb-1">Panduan Upload Banner</h3>
                <ul class="text-blue-700 text-sm space-y-1 mt-2">
                    <li>• <strong>Ukuran ideal:</strong> 1200 x 400 pixels (Ratio 3:1)</li>
                    <li>• <strong>Format:</strong> JPEG, PNG, atau WebP</li>
                    <li>• <strong>Ukuran file:</strong> Maksimal 2MB</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.banners.update', $banner) }}" 
              method="POST" 
              enctype="multipart/form-data"
              x-data="{ preview: '{{ asset('storage/' . $banner->image_path) }}' }">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Banner <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $banner->title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                           placeholder="Contoh: Promo Ramadan 2025"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Banner Saat Ini
                    </label>
                    <img src="{{ asset('storage/' . $banner->image_path) }}" 
                         alt="{{ $banner->title }}"
                         class="max-h-48 rounded-lg shadow-md border border-gray-200">
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Ganti Banner <span class="text-gray-500 text-xs">(Opsional)</span>
                    </label>
                    
                    <!-- Upload Area -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition"
                         @dragover.prevent="$el.classList.add('border-blue-500', 'bg-blue-50')"
                         @dragleave.prevent="$el.classList.remove('border-blue-500', 'bg-blue-50')"
                         @drop.prevent="
                             $el.classList.remove('border-blue-500', 'bg-blue-50');
                             const file = $event.dataTransfer.files[0];
                             if (file && file.type.startsWith('image/')) {
                                 $refs.imageInput.files = $event.dataTransfer.files;
                                 const reader = new FileReader();
                                 reader.onload = (e) => preview = e.target.result;
                                 reader.readAsDataURL(file);
                             }
                         ">
                        
                        <input type="file" 
                               name="image" 
                               id="image"
                               x-ref="imageInput"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="hidden"
                               @change="
                                   const file = $event.target.files[0];
                                   if (file) {
                                       const reader = new FileReader();
                                       reader.onload = (e) => preview = e.target.result;
                                       reader.readAsDataURL(file);
                                   }
                               ">
                        
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="mt-4">
                            <button type="button" 
                                    onclick="document.getElementById('image').click()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                                Pilih Gambar Baru
                            </button>
                            <p class="text-sm text-gray-500 mt-2">atau drag & drop gambar di sini</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, WebP hingga 2MB</p>

                        <!-- New Preview -->
                        <div x-show="preview && preview !== '{{ asset('storage/' . $banner->image_path) }}'" 
                             class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview Gambar Baru:</p>
                            <img :src="preview" 
                                 class="mx-auto max-h-48 rounded-lg shadow-lg border-2 border-blue-500"
                                 alt="Preview">
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                        Banner aktif
                    </label>
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">
                        Posisi Banner <span class="text-red-500">*</span>
                    </label>
                    <select name="position" 
                            id="position" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="home" {{ old('position', $banner->position) == 'home' ? 'selected' : '' }}>
                            Home / Katalog Member
                        </option>
                        <option value="customer_display" {{ old('position', $banner->position) == 'customer_display' ? 'selected' : '' }}>
                            Customer Display (Layar Kasir)
                        </option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Pilih dimana banner ini akan ditampilkan</p>
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-8 py-3 rounded-lg font-semibold transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
