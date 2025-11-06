@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8" 
     x-data="{
        shipping: '',
        terms: false,
        subtotal: {{ $subtotal ?? 0 }},
        showAddressForm: {{ isset($user->address) && isset($user->city) && $user->address && $user->city ? 'false' : 'true' }},
        useVoucher: true,
        selectedVoucher: null,
        availableVouchers: {{ Js::from($availableVouchers ?? []) }},
        init() {
            // Auto-select voucher terbaik saat load
            const bestVoucher = this.getBestVoucher();
            if (bestVoucher) {
                this.shipping = bestVoucher.reward_voucher.shipping_method;
                this.selectedVoucher = bestVoucher.id;
                this.useVoucher = true;
            }
        },
        getBestVoucher() {
            if (!this.availableVouchers || this.availableVouchers.length === 0) return null;
            // Urutkan voucher berdasarkan shipping method tercepat
            const shippingPriority = {
                crazy_rich: 1,
                si_sultan: 2,
                sahabat_kasir: 3,
                si_normal: 4,
                si_hemat: 5,
                si_kere: 6
            };
            const sorted = [...this.availableVouchers].sort((a, b) => {
                const priorityA = shippingPriority[a.reward_voucher.shipping_method] || 99;
                const priorityB = shippingPriority[b.reward_voucher.shipping_method] || 99;
                return priorityA - priorityB;
            });
            return sorted[0];
        },
        getCurrentVoucher() {
            if (!this.selectedVoucher || !this.useVoucher) return null;
            return this.availableVouchers.find(v => v.id === this.selectedVoucher);
        },
        getVoucherSavings() {
            const voucher = this.getCurrentVoucher();
            if (!voucher) return 0;
            const method = voucher.reward_voucher.shipping_method;
            const rates = { si_kere: 1, si_hemat: 2, si_normal: 4, sahabat_kasir: 6, si_sultan: 10, crazy_rich: 20 };
            return Math.round((this.subtotal * rates[method]) / 100);
        },
        getShippingCost() {
            if (!this.shipping) return 0;
            if (this.useVoucher && this.selectedVoucher) {
                const voucher = this.getCurrentVoucher();
                if (voucher && voucher.reward_voucher.shipping_method === this.shipping) {
                    return 0;
                }
            }
            const rates = { 
                si_kere: 1, 
                si_hemat: 2, 
                si_normal: 4, 
                sahabat_kasir: 6, 
                si_sultan: 10, 
                crazy_rich: 20 
            };
            return Math.round((this.subtotal * rates[this.shipping]) / 100);
        },
        getMatchingVoucher() {
            if (!this.shipping) return null;
            if (!this.availableVouchers || this.availableVouchers.length === 0) return null;
            const match = this.availableVouchers.find(v => v.reward_voucher && v.reward_voucher.shipping_method === this.shipping);
            if (match) {
                this.selectedVoucher = match.id;
            }
            return match;
        },
        getTotal() {
            return this.subtotal + this.getShippingCost();
        },
        getEstimatedDate() {
            if (!this.shipping) return '';
            const now = new Date();
            const estimates = {
                si_kere: 5 * 24 * 60,
                si_hemat: 3 * 24 * 60,
                si_normal: 2 * 24 * 60,
                sahabat_kasir: 1 * 24 * 60,
                si_sultan: 2 * 60,
                crazy_rich: 20
            };
            const minutes = estimates[this.shipping];
            const deliveryDate = new Date(now.getTime() + minutes * 60000);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            return deliveryDate.toLocaleDateString('id-ID', options);
        }
     }">

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">

                {{-- Alamat Pengiriman --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat Pengiriman
                    </h2>
                    
                    @if($user->address && $user->city)
                        <div x-show="!showAddressForm">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-gray-600 text-sm mt-1">{{ $user->phone ?? '-' }}</p>
                                        <p class="text-gray-700 mt-2">{{ $user->address }}</p>
                                        <p class="text-gray-600 text-sm">{{ $user->city }}@if($user->province), {{ $user->province }}@endif @if($user->postal_code) {{ $user->postal_code }}@endif</p>
                                    </div>
                                    <button type="button" @click="showAddressForm = true" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ubah</button>
                                </div>
                            </div>
                            <input type="hidden" name="shipping_name" value="{{ $user->name }}">
                            <input type="hidden" name="shipping_phone" value="{{ $user->phone ?? '' }}">
                            <input type="hidden" name="shipping_address" value="{{ $user->address }}">
                            <input type="hidden" name="shipping_city" value="{{ $user->city }}">
                            <input type="hidden" name="shipping_province" value="{{ $user->province ?? '' }}">
                            <input type="hidden" name="shipping_postal_code" value="{{ $user->postal_code ?? '' }}">
                        </div>
                    @endif

                    <div x-show="showAddressForm" x-cloak>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima *</label>
                                <input type="text" name="shipping_name" value="{{ $user->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon *</label>
                                <input type="tel" name="shipping_phone" value="{{ $user->phone ?? '' }}" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                                <textarea name="shipping_address" required rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ $user->address ?? '' }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten *</label>
                                    <input type="text" name="shipping_city" value="{{ $user->city ?? '' }}" required placeholder="Contoh: Jakarta" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                    <input type="text" name="shipping_province" value="{{ $user->province ?? '' }}" placeholder="Contoh: DKI Jakarta" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                <input type="text" name="shipping_postal_code" value="{{ $user->postal_code ?? '' }}" maxlength="10" placeholder="12345" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            @if($user->address && $user->city)
                                <button type="button" @click="showAddressForm = false" class="text-sm text-gray-600 hover:text-gray-800">Batal</button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Produk --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Produk yang Dibeli
                    </h2>
                    <div class="space-y-4">
                        @foreach($cart->items as $item)
                            <div class="flex gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <img src="{{ $item->product->image_url }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $item->product->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">Rp{{ number_format($item->final_price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                                    @if($item->variant_size || $item->variant_color)
                                        <p class="text-xs text-gray-500 mt-1">
                                            @if($item->variant_size)Size: {{ $item->variant_size }}@endif
                                            @if($item->variant_color), Warna: {{ $item->variant_color }}@endif
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-lg text-gray-800">Rp{{ number_format($item->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Voucher Gratis Ongkir - Minimalis & Profesional --}}
                <div class="bg-white rounded-lg shadow-md p-6" x-show="getBestVoucher()">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            Voucher Gratis Ongkir
                        </h2>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="useVoucher" class="sr-only peer">
                            <div class="relative w-14 h-7 rounded-full transition-colors duration-300 ease-in-out"
                                 :class="useVoucher ? 'bg-green-600' : 'bg-gray-200'">
                                <!-- Icon X (Nonaktif) -->
                                <svg class="absolute left-1.5 top-1.5 w-4 h-4 text-gray-600 transition-opacity duration-300 ease-in-out pointer-events-none" 
                                     :class="useVoucher ? 'opacity-0' : 'opacity-100'"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                <!-- Icon Check (Aktif) -->
                                <svg class="absolute right-1.5 top-1.5 w-4 h-4 text-white transition-opacity duration-300 ease-in-out pointer-events-none" 
                                     :class="useVoucher ? 'opacity-100' : 'opacity-0'"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <!-- Slider Circle -->
                                <div class="absolute top-0.5 bg-white border border-gray-300 rounded-full h-6 w-6 shadow-sm transition-all duration-300 ease-in-out"
                                     :class="useVoucher ? 'left-7' : 'left-0.5'">
                                </div>
                            </div>
                        </label>
                    </div>

                    <template x-if="getBestVoucher()">
                        <div class="border-2 rounded-lg p-4" :class="useVoucher ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-gray-50'">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-semibold text-gray-900" x-text="getBestVoucher().reward_voucher.name"></span>
                                        <span class="px-2 py-0.5 bg-green-600 text-white text-xs font-semibold rounded">GRATIS</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-3">
                                        Pengiriman: <span class="font-medium" x-text="getBestVoucher().reward_voucher.shipping_method_name"></span>
                                    </p>
                                    <div x-show="useVoucher" class="flex items-center gap-2 text-green-700 bg-white border border-green-200 rounded px-3 py-2">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm font-medium">
                                            Hemat <span class="font-bold" x-text="'Rp' + getVoucherSavings().toLocaleString('id-ID')"></span>
                                        </span>
                                    </div>
                                    <div x-show="!useVoucher" class="flex items-center gap-2 text-gray-600 text-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Voucher tidak digunakan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <input type="hidden" name="voucher_id" x-bind:value="useVoucher ? selectedVoucher : ''">
                    <input type="hidden" name="use_voucher" x-bind:value="useVoucher ? '1' : '0'">
                </div>

                {{-- Metode Pengiriman --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                        Metode Pengiriman <span class="text-red-500">*</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition relative" 
                               :class="shipping === 'si_kere' ? 'border-blue-500 bg-blue-50' : (availableVouchers.find(v => v.reward_voucher.shipping_method === 'si_kere') ? 'border-green-300 bg-green-50 hover:border-green-500' : 'border-gray-200 hover:border-blue-500 hover:bg-blue-50')">
                            <input type="radio" name="shipping_method" value="si_kere" x-model="shipping" required class="w-4 h-4 text-blue-600 mt-1">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">Si Kere</span>
                                    <span x-show="availableVouchers.find(v => v.reward_voucher.shipping_method === 'si_kere')" class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded">VOUCHER!</span>
                                </div>
                                <div class="text-sm text-gray-600">1% dari subtotal • Ekonomis</div>
                                <div class="text-xs text-green-600 mt-1" x-show="shipping === 'si_kere'" x-text="'Tiba: ' + getEstimatedDate()"></div>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition relative" 
                               :class="shipping === 'si_hemat' ? 'border-blue-500 bg-blue-50' : (availableVouchers.find(v => v.reward_voucher.shipping_method === 'si_hemat') ? 'border-green-300 bg-green-50 hover:border-green-500' : 'border-gray-200 hover:border-blue-500 hover:bg-blue-50')">
                            <input type="radio" name="shipping_method" value="si_hemat" x-model="shipping" required class="w-4 h-4 text-blue-600 mt-1">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">Si Hemat</span>
                                    <span x-show="availableVouchers.find(v => v.reward_voucher.shipping_method === 'si_hemat')" class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded">VOUCHER!</span>
                                </div>
                                <div class="text-sm text-gray-600">2% dari subtotal • Hemat</div>
                                <div class="text-xs text-green-600 mt-1" x-show="shipping === 'si_hemat'" x-text="'Tiba: ' + getEstimatedDate()"></div>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition relative" 
                               :class="shipping === 'si_normal' ? 'border-blue-500 bg-blue-50' : (availableVouchers.find(v => v.reward_voucher.shipping_method === 'si_normal') ? 'border-green-300 bg-green-50 hover:border-green-500' : 'border-gray-200 hover:border-blue-500 hover:bg-blue-50')">
                            <input type="radio" name="shipping_method" value="si_normal" x-model="shipping" required class="w-4 h-4 text-blue-600 mt-1">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">Si Normal</span>
                                    <span x-show="availableVouchers.find(v => v.reward_voucher.shipping_method === 'si_normal')" class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded">VOUCHER!</span>
                                </div>
                                <div class="text-sm text-gray-600">4% dari subtotal • Reguler</div>
                                <div class="text-xs text-green-600 mt-1" x-show="shipping === 'si_normal'" x-text="'Tiba: ' + getEstimatedDate()"></div>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition relative" 
                               :class="shipping === 'sahabat_kasir' ? 'border-blue-500 bg-blue-50' : (availableVouchers.find(v => v.reward_voucher.shipping_method === 'sahabat_kasir') ? 'border-green-300 bg-green-50 hover:border-green-500' : 'border-gray-200 hover:border-blue-500 hover:bg-blue-50')">
                            <input type="radio" name="shipping_method" value="sahabat_kasir" x-model="shipping" required class="w-4 h-4 text-blue-600 mt-1">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">Sahabat Kasir</span>
                                    <span x-show="availableVouchers.find(v => v.reward_voucher.shipping_method === 'sahabat_kasir')" class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded">VOUCHER!</span>
                                </div>
                                <div class="text-sm text-gray-600">6% dari subtotal • Prioritas</div>
                                <div class="text-xs text-green-600 mt-1" x-show="shipping === 'sahabat_kasir'" x-text="'Tiba: ' + getEstimatedDate()"></div>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition relative" 
                               :class="shipping === 'si_sultan' ? 'border-blue-500 bg-blue-50' : (availableVouchers.find(v => v.reward_voucher.shipping_method === 'si_sultan') ? 'border-green-300 bg-green-50 hover:border-green-500' : 'border-gray-200 hover:border-blue-500 hover:bg-blue-50')">
                            <input type="radio" name="shipping_method" value="si_sultan" x-model="shipping" required class="w-4 h-4 text-blue-600 mt-1">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">Si Sultan</span>
                                    <span x-show="availableVouchers.find(v => v.reward_voucher.shipping_method === 'si_sultan')" class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded">VOUCHER!</span>
                                </div>
                                <div class="text-sm text-gray-600">10% dari subtotal • Ekspres</div>
                                <div class="text-xs text-green-600 mt-1" x-show="shipping === 'si_sultan'" x-text="'Tiba: ' + getEstimatedDate()"></div>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition relative" 
                               :class="shipping === 'crazy_rich' ? 'border-blue-500 bg-blue-50' : (availableVouchers.find(v => v.reward_voucher.shipping_method === 'crazy_rich') ? 'border-green-300 bg-green-50 hover:border-green-500' : 'border-gray-200 hover:border-blue-500 hover:bg-blue-50')">
                            <input type="radio" name="shipping_method" value="crazy_rich" x-model="shipping" required class="w-4 h-4 text-blue-600 mt-1">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">Crazy Rich</span>
                                    <span x-show="availableVouchers.find(v => v.reward_voucher.shipping_method === 'crazy_rich')" class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded">VOUCHER!</span>
                                </div>
                                <div class="text-sm text-gray-600">20% dari subtotal • Super Kilat</div>
                                <div class="text-xs text-green-600 mt-1" x-show="shipping === 'crazy_rich'" x-text="'Tiba: ' + getEstimatedDate()"></div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Info Voucher Lain (jika user ganti shipping method) --}}
                <div class="bg-white rounded-lg shadow-md p-6" x-show="shipping && getMatchingVoucher() && getMatchingVoucher().id !== getBestVoucher()?.id">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Voucher Alternatif Ditemukan
                    </h2>
                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-gray-700">
                            Metode pengiriman ini juga punya voucher: 
                            <span class="font-semibold" x-text="getMatchingVoucher()?.reward_voucher.name"></span>
                        </p>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </h2>
                    <label class="flex items-center p-4 border-2 border-blue-500 bg-blue-50 rounded-lg cursor-pointer">
                        <input type="radio" name="payment_method" value="cod" checked required class="w-4 h-4 text-blue-600">
                        <div class="ml-3">
                            <div class="font-semibold text-gray-800">COD (Cash on Delivery)</div>
                            <div class="text-sm text-gray-600">Bayar saat barang diterima</div>
                        </div>
                    </label>
                </div>

                {{-- Terms & Conditions --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" name="terms_accepted" value="1" x-model="terms" required class="w-5 h-5 text-blue-600 mt-0.5 rounded">
                        <span class="ml-3 text-gray-700">
                            Dengan membuat pesanan, Anda menyetujui 
                            <a href="#" class="text-blue-600 hover:text-blue-800 underline">syarat & ketentuan</a> 
                            yang berlaku <span class="text-red-500">*</span>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Right Column: Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-3 mb-4 pb-4 border-b border-gray-200">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span class="font-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Ongkir</span>
                            <template x-if="!shipping">
                                <span class="text-gray-500">Pilih metode</span>
                            </template>
                            <template x-if="shipping && useVoucher && getMatchingVoucher()">
                                <div class="text-right">
                                    <div class="line-through text-gray-400 text-sm" x-text="'Rp' + Math.round((subtotal * ({si_kere:1,si_hemat:2,si_normal:4,sahabat_kasir:6,si_sultan:10,crazy_rich:20}[shipping])/100)).toLocaleString('id-ID')"></div>
                                    <div class="text-green-600 font-bold">Rp 0</div>
                                    <div class="text-xs text-green-600">Voucher Applied</div>
                                </div>
                            </template>
                            <template x-if="shipping && (!useVoucher || !getMatchingVoucher())">
                                <span class="font-semibold" x-text="'Rp' + getShippingCost().toLocaleString('id-ID')"></span>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-bold text-gray-800">Total</span>
                        <span class="text-2xl font-bold text-blue-600" x-text="'Rp' + getTotal().toLocaleString('id-ID')"></span>
                    </div>

                    <button type="submit" 
                            :disabled="!shipping || !terms"
                            :class="(shipping && terms) ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed'"
                            class="w-full text-white py-3 px-4 rounded-lg font-semibold text-lg transition duration-200 shadow-lg">
                        Buat Pesanan
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        Dengan membuat pesanan, dana akan diproses dengan aman
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
