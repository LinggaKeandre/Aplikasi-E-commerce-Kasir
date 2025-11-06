@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-100 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-2xl">
            <!-- Form Section -->
            <div class="bg-white p-10 rounded-lg shadow-xl">
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <h1 class="text-3xl font-bold text-gray-900">Secret Registration</h1>
                    </div>
                    <p class="text-gray-600">Halaman testing untuk membuat akun dengan role custom</p>
                    <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <p class="text-sm text-yellow-800">
                            <strong>⚠️ Testing Only:</strong> Halaman ini untuk development/testing. Bisa membuat akun dengan role: Admin, Kasir, atau Member.
                        </p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('secret.register') }}" class="space-y-5">
                    @csrf

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="role"
                            name="role" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition"
                            required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                            <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir (POS & Orders)</option>
                            <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member (Customer)</option>
                        </select>
                        @error('role')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="name"
                            name="name" 
                            type="text"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition"
                            required>
                        @error('name')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="email"
                            name="email" 
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="example@email.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition"
                            required>
                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="password"
                            name="password" 
                            type="password"
                            placeholder="Minimal 6 karakter"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition"
                            required>
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="password_confirmation"
                            name="password_confirmation" 
                            type="password"
                            placeholder="Konfirmasi password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition"
                            required>
                    </div>

                    <hr class="my-6">

                    <!-- Optional Fields -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Data Opsional (Bisa dikosongkan)</p>
                        
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-600 mb-2">No. Telepon</label>
                            <input 
                                id="phone"
                                name="phone" 
                                type="text"
                                value="{{ old('phone') }}"
                                placeholder="08123456789"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-600 mb-2">Alamat</label>
                            <textarea 
                                id="address"
                                name="address" 
                                rows="2"
                                placeholder="Jl. Contoh No. 123"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">{{ old('address') }}</textarea>
                        </div>

                        <!-- City, Province, Postal Code -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-600 mb-2">Kota</label>
                                <input 
                                    id="city"
                                    name="city" 
                                    type="text"
                                    value="{{ old('city') }}"
                                    placeholder="Jakarta"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
                            </div>

                            <div>
                                <label for="province" class="block text-sm font-medium text-gray-600 mb-2">Provinsi</label>
                                <input 
                                    id="province"
                                    name="province" 
                                    type="text"
                                    value="{{ old('province') }}"
                                    placeholder="DKI Jakarta"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
                            </div>

                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-600 mb-2">Kode Pos</label>
                                <input 
                                    id="postal_code"
                                    name="postal_code" 
                                    type="text"
                                    value="{{ old('postal_code') }}"
                                    placeholder="12345"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 mt-6">
                        🔒 Create Test Account
                    </button>
                </form>

                <!-- Back to Home -->
                <p class="mt-6 text-center text-gray-600">
                    <a href="/" class="text-purple-600 hover:text-purple-700 font-semibold">← Kembali ke Home</a>
                </p>

                <!-- Existing Accounts Info -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-blue-900 mb-2">📋 Akun Default dari Seeder:</p>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li><strong>Admin:</strong> admin@kasir.com / admin123</li>
                        <li><strong>Kasir:</strong> kasir@kasir.com / kasir123</li>
                        <li><strong>Member:</strong> member@kasir.com / member123</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
