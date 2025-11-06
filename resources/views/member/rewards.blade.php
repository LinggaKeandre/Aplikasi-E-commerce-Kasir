@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Rewards</h1>
        <p class="text-gray-600">Tukarkan poin Anda dengan voucher gratis ongkir</p>
    </div>

    <!-- Points Balance -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg p-6 mb-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm opacity-90">Total Poin Anda</p>
                <p class="text-4xl font-bold">{{ number_format($userPoints) }}</p>
            </div>
            <div class="text-right">
                <svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Voucher Gratis Ongkir Section -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Voucher Gratis Ongkir</h2>
        
        @if($rewards->where('type', 'free_shipping')->isEmpty())
            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada voucher gratis ongkir yang tersedia saat ini</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rewards->where('type', 'free_shipping') as $reward)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 border border-gray-200">
                        <!-- Image Section -->
                        @php
                            $imageName = strtolower(str_replace(' ', '', $reward->shipping_method_name)) . '.jpg';
                            $imagePath = public_path('images/vouchers/' . $imageName);
                        @endphp
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            @if(file_exists($imagePath))
                                <img src="{{ asset('images/vouchers/' . $imageName) }}" 
                                     alt="{{ $reward->shipping_method_name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <span class="text-sm">{{ $imageName }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <p class="text-gray-700 mb-4">Voucher gratis ongkir untuk metode pengiriman {{ $reward->shipping_method_name }}</p>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Harga</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-bold text-gray-900">{{ number_format($reward->points_required) }}</span>
                                    <span class="text-gray-600">Poin</span>
                                </div>
                                @if($userPoints < $reward->points_required)
                                    <div class="mt-2 inline-block bg-red-50 text-red-600 px-3 py-1 rounded-full text-sm">
                                        🔒 Kurang {{ number_format($reward->points_required - $userPoints) }} poin
                                    </div>
                                @endif
                            </div>
                            
                            @if($userPoints >= $reward->points_required)
                                <form action="{{ route('rewards.redeem', $reward) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-md">
                                        Tukar Sekarang
                                    </button>
                                </form>
                            @else
                                <button disabled 
                                        class="w-full bg-gray-200 text-gray-500 font-semibold py-3 px-4 rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Poin Tidak Cukup
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
