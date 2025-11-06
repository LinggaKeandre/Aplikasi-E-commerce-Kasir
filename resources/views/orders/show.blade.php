@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Pesanan
        </a>
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan</h1>
                <p class="text-gray-600 mt-1">Order #{{ $order->order_number }}</p>
            </div>
            
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
            @endphp
            
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 rounded-lg border-2 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-300' }} font-semibold text-sm">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </span>
                
                @if($order->canBeCancelled())
                    <button onclick="document.getElementById('cancelModal').classList.remove('hidden')" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batalkan Pesanan
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Cancellation Request Alert --}}
    @if($order->cancellationRequest)
        <div class="mb-6 bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-orange-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold text-orange-800 text-lg">Permintaan Pembatalan Pesanan</h3>
                    <p class="text-orange-700 mt-1">
                        Status: 
                        @if($order->cancellationRequest->status === 'pending')
                            <span class="font-semibold">Menunggu Review Admin</span>
                        @elseif($order->cancellationRequest->status === 'approved')
                            <span class="font-semibold text-green-700">Disetujui</span>
                        @else
                            <span class="font-semibold text-red-700">Ditolak</span>
                        @endif
                    </p>
                    <p class="text-sm text-orange-600 mt-2">
                        <strong>Alasan:</strong> {{ $order->cancellationRequest->readable_reason }}
                    </p>
                    @if($order->cancellationRequest->reason_detail)
                        <p class="text-sm text-orange-600 mt-1">
                            <strong>Detail:</strong> {{ $order->cancellationRequest->reason_detail }}
                        </p>
                    @endif
                    @if($order->cancellationRequest->admin_note)
                        <div class="mt-3 bg-white border border-orange-200 rounded p-3">
                            <p class="text-sm font-semibold text-gray-800">Catatan Admin:</p>
                            <p class="text-sm text-gray-700 mt-1">{{ $order->cancellationRequest->admin_note }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Timeline / Progress --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Status Pengiriman
                </h2>
                
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">Pesanan Dibuat</p>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">Diproses</p>
                            <p class="text-sm text-gray-600">{{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'Pesanan sedang diproses' : 'Menunggu' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">Dikirim</p>
                            <p class="text-sm text-gray-600">{{ in_array($order->status, ['shipped', 'delivered']) ? 'Paket dalam perjalanan' : 'Menunggu' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $order->status === 'delivered' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">Selesai</p>
                            @if($order->status === 'delivered' && $order->shipped_at)
                                <p class="text-sm text-gray-600">Dikirim: {{ $order->shipped_at->format('d M Y, H:i') }}</p>
                            @else
                                <p class="text-sm text-gray-600">Estimasi: {{ $order->estimated_delivery->format('d M Y, H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produk --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Produk yang Dibeli
                </h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-0 group">
                            @if($item->product)
                                <a href="{{ route('product.show', $item->product->slug) }}" class="flex-shrink-0">
                                    <img src="{{ $item->product->image_url }}" 
                                         class="w-20 h-20 object-cover rounded-lg border border-gray-200 group-hover:border-blue-400 transition-colors">
                                </a>
                            @else
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200 flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                @if($item->product)
                                    <a href="{{ route('product.show', $item->product->slug) }}" class="group-hover:text-blue-600 transition-colors">
                                        <h3 class="font-semibold text-gray-800">{{ $item->product_name }}</h3>
                                    </a>
                                @else
                                    <h3 class="font-semibold text-gray-800">{{ $item->product_name }}</h3>
                                @endif
                                
                                @if($item->variant_size || $item->variant_color || $item->variant_data)
                                    <div class="flex gap-2 mt-1">
                                        @foreach($item->variant_info as $variant)
                                            <span class="text-sm text-blue-600">{{ $variant['label'] }}: {{ $variant['value'] }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div class="mt-2 text-sm text-gray-600">
                                    <span>Rp{{ number_format($item->final_price, 0, ',', '.') }}</span>
                                    <span class="mx-2">×</span>
                                    <span>{{ $item->quantity }}</span>
                                </div>
                                
                                @if($item->product_discount > 0)
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs line-through text-gray-400">Rp{{ number_format($item->product_price, 0, ',', '.') }}</span>
                                        <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded">-{{ $item->product_discount }}%</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="text-right">
                                <p class="font-bold text-lg text-gray-800">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                
                                {{-- Review Button/Status --}}
                                @if($order->status === 'delivered')
                                    @if($item->review)
                                        {{-- Already Reviewed --}}
                                        <div class="mt-2">
                                            <div class="flex items-center gap-1 justify-end mb-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $item->review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <p class="text-xs text-green-600 font-semibold">✓ Sudah direview</p>
                                        </div>
                                    @else
                                        {{-- Review Button --}}
                                        <button onclick="openReviewModal({{ $item->id }}, '{{ $item->product_name }}')"
                                                class="mt-2 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition font-semibold flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            Beri Rating
                                        </button>
                                    @endif
                                @endif
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
                    <p class="font-semibold text-gray-800">{{ $order->shipping_name }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $order->shipping_phone }}</p>
                    <p class="text-gray-700 mt-3">{{ $order->shipping_address }}</p>
                    <p class="text-gray-600 text-sm mt-1">
                        {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}
                    </p>
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
                                <div class="flex items-center gap-2">
                                    <span>Ongkos Kirim</span>
                                    @if($order->free_shipping)
                                        <span class="px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded">GRATIS</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">{{ $order->shipping_method_name }}</div>
                                @if($order->free_shipping && $order->userVoucher)
                                    <div class="text-xs text-green-600 font-medium mt-1">
                                        ✓ Voucher: {{ $order->userVoucher->rewardVoucher->name ?? 'Gratis Ongkir' }}
                                    </div>
                                @endif
                            </div>
                            <span class="font-semibold" :class="{'text-green-600': {{ $order->free_shipping ? 'true' : 'false' }} }">
                                Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
                            </span>
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
                                <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
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
                    <div class="bg-white rounded-lg p-3">
                        <p class="font-bold text-gray-800">{{ $order->shipping_method_name }}</p>
                        @if($order->status === 'delivered' && $order->shipped_at)
                            <p class="text-sm text-gray-600 mt-1">Dikirim pada: {{ $order->shipped_at->format('d M Y, H:i') }}</p>
                        @else
                            <p class="text-sm text-gray-600 mt-1">Estimasi tiba: {{ $order->estimated_delivery->format('d M Y, H:i') }}</p>
                        @endif
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
                    <div class="bg-white rounded-lg p-3">
                        <p class="font-bold text-gray-800 uppercase">{{ $order->payment_method }}</p>
                        <p class="text-sm text-gray-600 mt-1">
                            Status: 
                            @if($order->payment_status === 'paid')
                                <span class="text-green-600 font-semibold">Lunas</span>
                            @elseif($order->payment_status === 'pending')
                                <span class="text-yellow-600 font-semibold">Menunggu</span>
                            @else
                                <span class="text-red-600 font-semibold">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($order->notes)
                    <div class="bg-gray-50 rounded-lg shadow-md p-6 border border-gray-200">
                        <h3 class="font-semibold text-gray-800 mb-2">Catatan</h3>
                        <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Pembatalan Pesanan --}}
@if($order->canBeCancelled())
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl my-8">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-4 sm:px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="truncate">Batalkan Pesanan</span>
                    </h3>
                    <button onclick="document.getElementById('cancelModal').classList.add('hidden')" 
                            class="text-white hover:text-gray-200 flex-shrink-0 ml-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
        <form method="POST" action="{{ route('orders.request-cancellation', $order->id) }}" class="p-4 sm:p-6 max-h-[calc(100vh-200px)] overflow-y-auto">
            @csrf
            
            <div class="mb-4 sm:mb-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 sm:p-4 rounded mb-4 sm:mb-6">
                    <div class="flex items-start gap-2 sm:gap-3">
                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800">Perhatian!</p>
                            <p class="text-xs sm:text-sm text-yellow-700 mt-1">Permintaan pembatalan akan dikirim ke admin untuk direview. Anda akan mendapat notifikasi setelah admin memproses permintaan Anda.</p>
                        </div>
                    </div>
                </div>

                <label class="block text-sm font-bold text-gray-700 mb-2 sm:mb-3">
                    Alasan Pembatalan <span class="text-red-500">*</span>
                </label>
                
                <div class="space-y-2" x-data="{ selectedReason: '', showOtherInput: false }">
                    @php
                        $reasons = \App\Models\OrderCancellationRequest::getReasonOptions();
                    @endphp
                    
                    @foreach($reasons as $key => $label)
                        <label class="flex items-start p-3 sm:p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition"
                               :class="selectedReason === '{{ $key }}' ? 'border-red-500 bg-red-50' : 'border-gray-200'">
                            <input type="radio" 
                                   name="reason" 
                                   value="{{ $key }}" 
                                   class="mt-1 text-red-600 focus:ring-red-500 flex-shrink-0" 
                                   required
                                   x-model="selectedReason"
                                   @change="showOtherInput = (selectedReason === 'other')">
                            <div class="ml-2 sm:ml-3 flex-1 min-w-0">
                                <span class="font-semibold text-gray-800 text-sm sm:text-base block">{{ $label }}</span>
                                @if($key === 'wrong_product')
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">Produk yang dipilih tidak sesuai dengan kebutuhan</p>
                                @elseif($key === 'delivery_too_long')
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">Estimasi pengiriman memakan waktu terlalu lama</p>
                                @elseif($key === 'cheaper_elsewhere')
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">Menemukan produk yang sama dengan harga lebih murah</p>
                                @elseif($key === 'other')
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">Alasan lain yang tidak tercantum di atas</p>
                                @endif
                            </div>
                        </label>
                    @endforeach
                    
                    {{-- Input Detail untuk "Lainnya" --}}
                    <div x-show="showOtherInput" 
                         x-transition
                         class="mt-3 sm:mt-4 p-3 sm:p-4 bg-gray-50 rounded-lg border border-gray-300">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Detail Alasan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="reason_detail" 
                                  rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Mohon jelaskan alasan pembatalan pesanan Anda..."
                                  maxlength="500"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
                <h4 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">Informasi Pesanan:</h4>
                <div class="text-xs sm:text-sm text-gray-700 space-y-1">
                    <p><strong>Order:</strong> {{ $order->order_number }}</p>
                    <p><strong>Total:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                    <p><strong>Status:</strong> {{ $statusLabels[$order->status] }}</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <button type="button" 
                        onclick="document.getElementById('cancelModal').classList.add('hidden')"
                        class="w-full sm:flex-1 px-4 sm:px-6 py-2.5 sm:py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition text-sm sm:text-base">
                    Batal
                </button>
                <button type="submit" 
                        class="w-full sm:flex-1 px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition flex items-center justify-center gap-2 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="truncate">Kirim Permintaan</span>
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
@endif

{{-- Review Modal --}}
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Beri Rating & Review</h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form id="reviewForm" method="POST" action="">
                @csrf
                
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Produk:</p>
                    <p id="reviewProductName" class="font-semibold text-gray-800"></p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Rating <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    onclick="setRating({{ $i }})"
                                    class="star-btn transition-transform hover:scale-110"
                                    data-rating="{{ $i }}">
                                <svg class="w-10 h-10 text-gray-300 hover:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" required>
                    <p id="ratingError" class="text-red-500 text-sm mt-1 hidden">Mohon pilih rating</p>
                </div>
                
                <div class="mb-6">
                    <label for="reviewText" class="block text-sm font-semibold text-gray-700 mb-2">
                        Review (Opsional)
                    </label>
                    <textarea name="review" 
                              id="reviewText"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Bagikan pengalaman Anda dengan produk ini..."
                              maxlength="1000"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 1000 karakter</p>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="closeReviewModal()"
                            class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Kirim Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentRating = 0;

function openReviewModal(orderItemId, productName) {
    document.getElementById('reviewModal').classList.remove('hidden');
    document.getElementById('reviewProductName').textContent = productName;
    document.getElementById('reviewForm').action = `/reviews/order-item/${orderItemId}`;
    currentRating = 0;
    updateStars();
    document.getElementById('ratingInput').value = '';
    document.getElementById('reviewText').value = '';
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    currentRating = 0;
    updateStars();
}

function setRating(rating) {
    currentRating = rating;
    document.getElementById('ratingInput').value = rating;
    document.getElementById('ratingError').classList.add('hidden');
    updateStars();
}

function updateStars() {
    document.querySelectorAll('.star-btn').forEach((btn, index) => {
        const star = btn.querySelector('svg');
        if (index < currentRating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

// Form validation
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    if (!document.getElementById('ratingInput').value) {
        e.preventDefault();
        document.getElementById('ratingError').classList.remove('hidden');
    }
});

// Close modal on backdrop click
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});
</script>
@endsection
