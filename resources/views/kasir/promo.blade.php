@extends('layouts.kasir')

@section('title', 'Promo')

@section('content')
<div class="py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Promo Aktif</h1>
        <p class="text-gray-600">Daftar promo yang dapat diterapkan saat transaksi</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($promos as $promo)
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold mb-2">{{ $promo['title'] ?? 'Promo Spesial' }}</h3>
            <p class="text-purple-100 mb-4">{{ $promo['description'] ?? 'Diskon menarik untuk Anda' }}</p>
            <div class="bg-white text-purple-600 font-bold text-2xl p-3 rounded text-center">
                {{ $promo['discount'] ?? '10%' }} OFF
            </div>
        </div>
        @empty
        <div class="col-span-3">
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada promo aktif saat ini</p>
                <p class="text-gray-400 text-sm mt-2">Hubungi admin untuk informasi promo terbaru</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
