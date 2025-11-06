@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    
    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.orders') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Pesanan
        </a>
        
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan</h1>
                <p class="text-gray-600 mt-1">Order #{{ $order->order_number }}</p>
            </div>
            
            {{-- Quick Status Update --}}
            <div class="flex items-center gap-3">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                        'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                        'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
                        'delivered' => 'bg-green-100 text-green-800 border-green-300',
                        'cancelled' => 'bg-red-100 text-red-800 border-red-300',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                    
                    // Check if there's a pending cancellation request
                    $hasPendingCancellation = $order->cancellationRequest && $order->cancellationRequest->status === 'pending';
                @endphp
                
                <span class="px-4 py-2 rounded-lg border-2 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-300' }} font-semibold text-sm">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </span>
                
                {{-- Only show Update Status button if not kasir transaction --}}
                @if($order->shipping_method !== 'kasir')
                    @if($hasPendingCancellation)
                        <div class="relative group">
                            <button disabled
                                    class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed font-medium text-sm flex items-center gap-2 opacity-60">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Update Status
                            </button>
                            <div class="hidden group-hover:block absolute bottom-full right-0 mb-2 w-72 max-w-sm bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10">
                                <div class="absolute bottom-0 right-4 transform translate-y-1/2 rotate-45 w-2 h-2 bg-gray-800"></div>
                                ⚠️ Tidak bisa update status. Ada request pembatalan yang menunggu persetujuan.
                            </div>
                        </div>
                    @else
                        <button onclick="document.getElementById('updateStatusModal').classList.remove('hidden')" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Update Status
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Customer Info --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Pelanggan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-gray-800">{{ $order->user->name ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Email</p>
                        <p class="font-semibold text-gray-800">{{ $order->user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">No. Telepon</p>
                        <p class="font-semibold text-gray-800">{{ $order->shipping_phone }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Order Date</p>
                        <p class="font-semibold text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Produk --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Produk yang Dibeli ({{ $order->items->count() }} Item)
                </h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-0 group">
                            @if($item->product)
                                <a href="{{ route('product.show', $item->product->slug) }}" class="flex-shrink-0">
                                    <img src="{{ $item->product->image_url }}" 
                                         class="w-24 h-24 object-cover rounded-lg border border-gray-200 group-hover:border-blue-400 transition-colors">
                                </a>
                            @else
                                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200 flex-shrink-0">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                @if($item->product)
                                    <a href="{{ route('product.show', $item->product->slug) }}" class="group-hover:text-blue-600 transition-colors">
                                        <h3 class="font-semibold text-gray-800 mb-1">{{ $item->product_name }}</h3>
                                    </a>
                                @else
                                    <h3 class="font-semibold text-gray-800 mb-1">{{ $item->product_name }}</h3>
                                @endif
                                
                                @if($item->variant_size || $item->variant_color || $item->variant_data)
                                    <div class="flex gap-2 mb-2">
                                        @foreach($item->variant_info as $variant)
                                            <span class="text-sm text-blue-600">{{ $variant['label'] }}: {{ $variant['value'] }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div class="flex items-center gap-4 text-sm">
                                    <div>
                                        @if($item->product_discount > 0)
                                            <div class="flex items-center gap-2">
                                                <span class="line-through text-gray-400">Rp{{ number_format($item->product_price, 0, ',', '.') }}</span>
                                                <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded text-xs font-semibold">-{{ $item->product_discount }}%</span>
                                            </div>
                                        @endif
                                        <span class="font-bold text-gray-900">Rp{{ number_format($item->final_price, 0, ',', '.') }}</span>
                                    </div>
                                    <span class="text-gray-400">×</span>
                                    <span class="font-semibold text-gray-700">{{ $item->quantity }}</span>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="font-bold text-lg text-gray-800">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Alamat Pengiriman --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Alamat Pengiriman
                </h2>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-gray-800 text-lg">{{ $order->shipping_name }}</p>
                            <p class="text-gray-600 text-sm mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $order->shipping_phone }}
                            </p>
                            <p class="text-gray-700 mt-3 leading-relaxed">{{ $order->shipping_address }}</p>
                            <p class="text-gray-600 text-sm mt-2">
                                {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Summary --}}
        <div class="lg:col-span-1">
            <div class="sticky top-4 space-y-6">
                
                {{-- Ringkasan Pembayaran --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Ringkasan Pembayaran
                    </h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal Produk</span>
                            <span class="font-semibold">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-700">
                            <div>
                                <div>Ongkos Kirim</div>
                                <div class="text-xs text-gray-500">{{ $order->shipping_method_name }}</div>
                            </div>
                            <span class="font-semibold">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($order->voucher_discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Diskon Voucher</span>
                                <span class="font-semibold">-Rp{{ number_format($order->voucher_discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Diskon Produk</span>
                                <span class="font-semibold">-Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-2xl font-bold text-blue-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Pengiriman - Only show if not kasir transaction --}}
                @if($order->shipping_method !== 'kasir')
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md p-6 border border-blue-200">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                        Metode Pengiriman
                    </h3>
                    <div class="bg-white rounded-lg p-4">
                        <p class="font-bold text-gray-800">{{ $order->shipping_method_name }}</p>
                        <p class="text-sm text-gray-600 mt-1">Estimasi: {{ $order->estimated_delivery->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Ongkir: Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endif

                {{-- Info Pembayaran --}}
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-md p-6 border border-green-200">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Metode Pembayaran
                    </h3>
                    <div class="bg-white rounded-lg p-4">
                        <p class="font-bold text-gray-800 uppercase">{{ $order->payment_method }}</p>
                        <p class="text-sm text-gray-600 mt-1">
                            Status: 
                            @if($order->payment_status === 'paid')
                                <span class="text-green-600 font-semibold">✓ Lunas</span>
                            @elseif($order->payment_status === 'pending')
                                <span class="text-yellow-600 font-semibold">⏳ Menunggu</span>
                            @else
                                <span class="text-red-600 font-semibold">✗ {{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($order->notes)
                    <div class="bg-gray-50 rounded-lg shadow-md p-6 border border-gray-200">
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Catatan
                        </h3>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Update Status --}}
<div id="updateStatusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Update Status Pesanan
                </h3>
                <button onclick="document.getElementById('updateStatusModal').classList.add('hidden')" 
                        class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" class="p-6" id="statusUpdateForm" onsubmit="return confirmDelivered(event)">
            @csrf
            
            @if($order->status === 'delivered')
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center gap-2 text-green-800">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">Pesanan telah selesai (Delivered)</span>
                </div>
                <p class="text-sm text-green-700 mt-2">Status pesanan tidak dapat diubah lagi karena sudah delivered.</p>
            </div>
            @endif
            
            @if($order->status === 'cancelled')
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center gap-2 text-red-800">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">Pesanan telah dibatalkan (Cancelled)</span>
                </div>
                <p class="text-sm text-red-700 mt-2">Status pesanan tidak dapat diubah lagi karena sudah cancelled.</p>
            </div>
            @endif
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Status Baru</label>
                <div class="space-y-2">
                    <label class="flex items-center p-4 border-2 rounded-lg {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-yellow-50' }} {{ $order->status === 'pending' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200' }}">
                        <input type="radio" name="status" value="pending" class="text-yellow-600 focus:ring-yellow-500" {{ $order->status === 'pending' ? 'checked' : '' }} {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'disabled' : '' }}>
                        <div class="ml-3">
                            <span class="font-semibold text-gray-800">Pending</span>
                            <p class="text-xs text-gray-500">Menunggu konfirmasi</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 rounded-lg {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-blue-50' }} {{ $order->status === 'processing' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                        <input type="radio" name="status" value="processing" class="text-blue-600 focus:ring-blue-500" {{ $order->status === 'processing' ? 'checked' : '' }} {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'disabled' : '' }}>
                        <div class="ml-3">
                            <span class="font-semibold text-gray-800">Processing</span>
                            <p class="text-xs text-gray-500">Pesanan sedang diproses</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 rounded-lg {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-purple-50' }} {{ $order->status === 'shipped' ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }}">
                        <input type="radio" name="status" value="shipped" class="text-purple-600 focus:ring-purple-500" {{ $order->status === 'shipped' ? 'checked' : '' }} {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'disabled' : '' }}>
                        <div class="ml-3">
                            <span class="font-semibold text-gray-800">Shipped</span>
                            <p class="text-xs text-gray-500">Paket dalam perjalanan</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 rounded-lg {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-green-50' }} {{ $order->status === 'delivered' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                        <input type="radio" name="status" value="delivered" class="text-green-600 focus:ring-green-500" {{ $order->status === 'delivered' ? 'checked' : '' }} {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'disabled' : '' }}>
                        <div class="ml-3">
                            <span class="font-semibold text-gray-800">Delivered</span>
                            <p class="text-xs text-gray-500">Pesanan telah sampai</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 rounded-lg {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-red-50' }} {{ $order->status === 'cancelled' ? 'border-red-500 bg-red-50' : 'border-gray-200' }}">
                        <input type="radio" name="status" value="cancelled" class="text-red-600 focus:ring-red-500" {{ $order->status === 'cancelled' ? 'checked' : '' }} {{ ($order->status === 'delivered' || $order->status === 'cancelled') ? 'disabled' : '' }}>
                        <div class="ml-3">
                            <span class="font-semibold text-gray-800">Cancelled</span>
                            <p class="text-xs text-gray-500">Pesanan dibatalkan</p>
                        </div>
                    </label>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('updateStatusModal').classList.add('hidden')"
                        class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                    Batal
                </button>
                @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                <button type="submit" 
                        class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Update Status
                </button>
                @else
                <button type="button" 
                        disabled
                        class="flex-1 px-4 py-3 bg-gray-400 text-white rounded-lg cursor-not-allowed font-semibold">
                    Status Tidak Dapat Diubah
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
function confirmDelivered(event) {
    const form = event.target;
    const selectedStatus = form.querySelector('input[name="status"]:checked').value;
    const currentStatus = '{{ $order->status }}';
    
    // Show confirmation if changing TO delivered status (not if already delivered)
    if (selectedStatus === 'delivered' && currentStatus !== 'delivered') {
        if (!confirm('Status delivered tidak bisa diubah kembali. Yakin ingin melanjutkan?')) {
            event.preventDefault();
            return false;
        }
    }
    
    // Show confirmation if changing TO cancelled status (not if already cancelled)
    if (selectedStatus === 'cancelled' && currentStatus !== 'cancelled') {
        if (!confirm('Status cancelled tidak bisa diubah kembali. Yakin ingin melanjutkan?')) {
            event.preventDefault();
            return false;
        }
    }
    
    return true;
}
</script>

@endsection
