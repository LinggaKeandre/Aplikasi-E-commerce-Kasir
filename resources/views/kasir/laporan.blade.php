@extends('layouts.kasir')

@section('title', 'Laporan Kasir')

@section('content')
<div class="py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Laporan Kasir Hari Ini</h1>
            <p class="text-gray-600">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>
        <form method="POST" action="{{ route('kasir.tutup-kasir') }}">
            @csrf
            <button type="submit" onclick="return confirm('Yakin ingin tutup kasir? Laporan akan disimpan.')"
                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700">
                🔒 Tutup Kasir
            </button>
        </form>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6">
            <p class="text-blue-100 text-sm">Total Transaksi</p>
            <h3 class="text-4xl font-bold mt-2">{{ $report['total_transaksi'] }}</h3>
            <p class="text-blue-100 text-xs mt-2">Transaksi hari ini</p>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6">
            <p class="text-green-100 text-sm">Total Uang Masuk</p>
            <h3 class="text-3xl font-bold mt-2">Rp {{ number_format($report['uang_masuk'], 0, ',', '.') }}</h3>
            <p class="text-green-100 text-xs mt-2">Dari transaksi berhasil</p>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg shadow-lg p-6">
            <p class="text-purple-100 text-sm">Transaksi Berhasil</p>
            <h3 class="text-4xl font-bold mt-2">{{ $report['transaksi_berhasil'] }}</h3>
            <p class="text-purple-100 text-xs mt-2">Status completed</p>
        </div>
    </div>

    <!-- Detail Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pending</p>
                    <h3 class="text-2xl font-bold text-yellow-600 mt-1">{{ $report['transaksi_pending'] }}</h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Dibatalkan</p>
                    <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $report['transaksi_dibatalkan'] }}</h3>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Rata-rata/Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        Rp {{ $report['transaksi_berhasil'] > 0 ? number_format($report['uang_masuk'] / $report['transaksi_berhasil'], 0, ',', '.') : 0 }}
                    </h3>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Per Metode Pembayaran -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Rincian Per Metode Pembayaran</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($paymentMethods as $method)
                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-gray-500 text-sm font-medium">{{ strtoupper($method->payment_method ?? 'Cash') }}</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($method->total, 0, ',', '.') }}</h3>
                    <p class="text-gray-400 text-xs mt-1">{{ $method->count }} transaksi</p>
                </div>
                @empty
                <p class="text-gray-500 col-span-3 text-center py-4">Belum ada transaksi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
