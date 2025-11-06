@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-6xl">
            <!-- Single Container with Grid -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Left Side - Image/Branding -->
                    <div class="hidden lg:flex bg-gradient-to-br from-blue-600 to-indigo-700 items-center justify-center relative overflow-hidden">
                        @if(file_exists(public_path('images/brand/register-illustration.png')))
                            <img src="{{ asset('images/brand/register-illustration.png') }}" 
                                 alt="Brand Illustration" 
                                 class="w-full h-full object-cover">
                        @else
                            <!-- Placeholder jika gambar belum ada -->
                            <div class="w-full h-full flex flex-col items-center justify-center p-12">
                                <!-- Decorative circles -->
                                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full -ml-48 -mb-48"></div>
                                
                                <div class="relative z-10 text-center">
                                    <div class="w-64 h-80 bg-white/20 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm mx-auto">
                                        <svg class="w-32 h-32 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-white text-2xl font-bold mb-2">Selamat Datang!</h2>
                                    <p class="text-blue-100 text-lg">Bergabunglah dengan sistem kasir modern kami</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Side - Form -->
                    <div class="p-8 lg:p-12">
                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun</h1>
                            <p class="text-gray-600">Buat akun baru untuk memulai</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-5">
                            @csrf

                            <!-- Nama Lengkap -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input 
                                    id="name"
                                    name="name" 
                                    type="text"
                                    placeholder="Masukkan nama lengkap Anda"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    required>
                                @error('name')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input 
                                    id="email"
                                    name="email" 
                                    type="email"
                                    placeholder="Masukkan email Anda"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    required>
                                @error('email')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input 
                                    id="password"
                                    name="password" 
                                    type="password"
                                    placeholder="Masukkan password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    required>
                                @error('password')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                <input 
                                    id="password_confirmation"
                                    name="password_confirmation" 
                                    type="password"
                                    placeholder="Konfirmasi password Anda"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    required>
                                @error('password_confirmation')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 mt-6 shadow-lg hover:shadow-xl">
                                Daftar Sekarang
                            </button>
                        </form>

                        <!-- Login Link -->
                        <p class="mt-6 text-center text-gray-600">
                            Sudah punya akun? 
                            <a href="/" class="text-blue-600 hover:text-blue-700 font-semibold">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection