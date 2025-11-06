@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Voucher Saya</h1>
        <p class="text-gray-600">Kelola voucher gratis ongkir Anda</p>
    </div>

    <div x-data="{ activeTab: 'unused' }">
        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <div class="flex gap-4">
                <button @click="activeTab = 'unused'" 
                        :class="activeTab === 'unused' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500'"
                        class="pb-3 px-1 border-b-2 font-semibold transition">
                    Belum Digunakan
                </button>
                <button @click="activeTab = 'used'" 
                        :class="activeTab === 'used' ? 'border-gray-600 text-gray-600' : 'border-transparent text-gray-500'"
                        class="pb-3 px-1 border-b-2 font-semibold transition">
                    Sudah Digunakan
                </button>
            </div>
        </div>

        <!-- Unused Vouchers Tab -->
        <div x-show="activeTab === 'unused'" class="mt-6">
            @php
                $unusedVouchers = $vouchers->where('is_used', false);
            @endphp

            @if($unusedVouchers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($unusedVouchers as $voucher)
                        <div class="bg-white border-2 border-green-500 rounded-lg p-5 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-800">{{ $voucher->rewardVoucher->name ?? 'Voucher' }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $voucher->rewardVoucher->shipping_method_name ?? '' }}</p>
                                </div>
                                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded">
                                    GRATIS
                                </span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>Ditukar:</span>
                                    <span class="font-medium text-gray-700">{{ $voucher->redeemed_at ? $voucher->redeemed_at->format('d M Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Voucher</h3>
                    <p class="text-gray-500 mb-4">Tukar poin Anda untuk mendapatkan voucher gratis ongkir</p>
                    <a href="{{ route('rewards.index') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-semibold transition">
                        Lihat Rewards
                    </a>
                </div>
            @endif
        </div>

        <!-- Used Vouchers Tab -->
        <div x-show="activeTab === 'used'" class="mt-6">
            @php
                $usedVouchers = $vouchers->where('is_used', true);
            @endphp

            @if($usedVouchers->count() > 0)
                <div class="space-y-3">
                    @foreach($usedVouchers as $voucher)
                        <div class="bg-white border border-gray-300 rounded-lg p-5">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-bold text-base text-gray-800">{{ $voucher->rewardVoucher->name ?? 'Voucher' }}</h3>
                                        <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded">
                                            TERPAKAI
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-3">{{ $voucher->rewardVoucher->shipping_method_name ?? '' }}</p>
                                    
                                    <div class="text-sm text-gray-500 space-y-1">
                                        <p>Digunakan: {{ $voucher->used_at ? $voucher->used_at->format('d M Y H:i') : '-' }}</p>
                                        @if($voucher->order_id)
                                            <a href="{{ route('orders.show', $voucher->order_id) }}" class="text-green-600 hover:text-green-700 font-medium">
                                                Lihat Pesanan →
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-gray-500">Voucher yang telah digunakan akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>

    @if($vouchers->hasPages())
        <div class="mt-8">
            {{ $vouchers->links() }}
        </div>
    @endif
</div>
@endsection
