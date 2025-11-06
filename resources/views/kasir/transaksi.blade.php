@extends('layouts.kasir')

@section('title', 'Transaksi Penjualan')

<style>
    [x-cloak] { display: none !important; }
</style>

@section('content')
<div class="py-6" x-data="pos()">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Transaksi Penjualan (POS)</h1>
            <p class="text-gray-600">Point of Sale - Sistem Kasir</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs text-gray-500">Session ID Anda:</p>
                <p class="text-sm font-mono font-bold text-blue-600" x-text="sessionId"></p>
                <div class="mt-1 flex items-center gap-1 justify-end">
                    <div class="w-2 h-2 rounded-full" :class="connectedDevices > 0 ? 'bg-green-500' : 'bg-gray-300'"></div>
                    <p class="text-xs text-gray-600">
                        <span x-text="connectedDevices"></span> Display Terhubung
                    </p>
                </div>
            </div>
            <a :href="'{{ route('kasir.customer-display') }}?session=' + sessionId" 
               target="_blank"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center gap-2 font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Customer Display
            </a>
        </div>
    </div>

    <!-- Barcode Scanner Input (Hidden) -->
    <div class="mb-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 flex items-center gap-3">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
            </svg>
            <div class="flex-1">
                <label for="barcode-input" class="text-sm font-semibold text-blue-800">Barcode Scanner</label>
                <input type="text" 
                       id="barcode-input"
                       x-ref="barcodeInput"
                       @keydown.enter.prevent="scanBarcode($event.target.value); $event.target.value = ''"
                       placeholder="Scan barcode atau ketik manual..."
                       class="w-full mt-1 border border-blue-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       autocomplete="off">
            </div>
            <div x-show="scanning" x-cloak class="text-blue-600">
                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Produk List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200">
                    <input type="text" x-model="searchProduct" placeholder="Cari produk..." 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div class="p-4 grid grid-cols-2 md:grid-cols-3 gap-4 max-h-[600px] overflow-y-auto">
                    @foreach($products as $product)
                    @php
                        $finalPrice = $product->discount ? $product->price - ($product->price * $product->discount / 100) : $product->price;
                        $hasVariants = $product->variants && count($product->variants) > 0;
                        $variantsJson = $hasVariants ? json_encode($product->variants) : '[]';
                        
                        // Calculate price range for variants
                        $minPrice = $finalPrice;
                        $maxPrice = $finalPrice;
                        $hasVariantPrice = false;
                        
                        if ($hasVariants) {
                            $prices = [];
                            foreach ($product->variants as $variant) {
                                if (isset($variant['options'])) {
                                    foreach ($variant['options'] as $option) {
                                        if (isset($option['price']) && $option['price'] > 0) {
                                            $prices[] = $option['price'];
                                            $hasVariantPrice = true;
                                        }
                                    }
                                }
                            }
                            
                            // Only use variant prices if they exist, otherwise use base price
                            if ($hasVariantPrice && count($prices) > 0) {
                                $minPrice = min($prices);
                                $maxPrice = max($prices);
                            }
                        }
                    @endphp
                    <div x-show="searchProduct === '' || '{{ strtolower($product->title) }}'.includes(searchProduct.toLowerCase())"
                         @click="handleProductClick({{ $product->id }}, '{{ $product->title }}', {{ $finalPrice }}, {{ $product->stock }}, {{ $hasVariants ? 'true' : 'false' }}, {{ $variantsJson }}, {{ $product->discount ?? 0 }})" 
                         class="border border-gray-200 rounded-lg p-4 hover:border-green-500 hover:shadow-lg cursor-pointer transition">
                        <img src="{{ $product->image_url }}" class="w-full h-32 object-cover rounded mb-2">
                        <h3 class="font-semibold text-sm text-gray-800 truncate">{{ $product->title }}</h3>
                        @if($hasVariants)
                            <span class="inline-block bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded mb-1">Varian</span>
                        @endif
                        @if($hasVariants && $hasVariantPrice && $minPrice != $maxPrice)
                            <p class="text-green-600 font-bold text-lg">Rp {{ number_format($minPrice, 0, ',', '.') }} ~ Rp {{ number_format($maxPrice, 0, ',', '.') }}</p>
                        @elseif($hasVariants && $hasVariantPrice)
                            <p class="text-green-600 font-bold text-lg">Rp {{ number_format($minPrice, 0, ',', '.') }}</p>
                        @elseif($product->discount)
                            <div class="flex items-center gap-2">
                                <p class="text-gray-400 line-through text-xs">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <span class="bg-red-500 text-white text-xs px-1 rounded">-{{ $product->discount }}%</span>
                            </div>
                            <p class="text-green-600 font-bold text-lg">Rp {{ number_format($finalPrice, 0, ',', '.') }}</p>
                        @else
                            <p class="text-green-600 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        @endif
                        <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Cart & Payment -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow sticky top-4">
                <div class="p-4 border-b border-gray-200 bg-green-600 text-white rounded-t-lg">
                    <h2 class="text-xl font-bold">Keranjang</h2>
                </div>

                <!-- Cart Items -->
                <div class="p-4 max-h-[300px] overflow-y-auto">
                    <template x-if="cart.length === 0">
                        <p class="text-center text-gray-500 py-8">Keranjang masih kosong</p>
                    </template>
                    
                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-200">
                            <div class="flex-1">
                                <p class="font-semibold text-sm" x-text="item.displayName || item.name"></p>
                                <p class="text-xs text-gray-500" x-text="'Rp ' + formatRupiah(item.price)"></p>
                                <p x-show="item.variantInfo" class="text-xs text-blue-600" x-text="item.variantInfo ? `${item.variantInfo.type}: ${item.variantInfo.value}` : ''"></p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button @click="decreaseQty(index)" class="bg-gray-200 px-2 py-1 rounded text-sm">-</button>
                                <span class="font-semibold" x-text="item.qty"></span>
                                <button @click="increaseQty(index)" class="bg-gray-200 px-2 py-1 rounded text-sm">+</button>
                                <button @click="removeItem(index)" class="text-red-600 ml-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Summary -->
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Subtotal:</span>
                        <span class="font-bold text-xl" x-text="'Rp ' + formatRupiah(getTotal())"></span>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
                        <select x-model="paymentMethod" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="e-wallet">E-Wallet</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium mb-2">Jumlah Bayar</label>
                        <input type="number" x-model="paidAmount" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="0">
                    </div>

                    <div class="mt-2 flex justify-between" x-show="paidAmount > 0">
                        <span class="font-semibold">Kembalian:</span>
                        <span class="font-bold" :class="getChange() < 0 ? 'text-red-600' : 'text-green-600'" 
                              x-text="'Rp ' + formatRupiah(getChange())"></span>
                    </div>

                    <button @click="processPayment()" 
                            :disabled="cart.length === 0 || getChange() < 0"
                            class="w-full mt-4 bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                        Proses Pembayaran
                    </button>

                    <button @click="clearCart()" class="w-full mt-2 border border-red-600 text-red-600 py-2 rounded-lg font-semibold hover:bg-red-50 transition">
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi Member -->
    <div x-show="showMemberModal" 
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         @click.self="closeMemberModal()">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6" @click.stop>
            <h3 class="text-xl font-bold mb-4">Verifikasi Member</h3>
            
            <!-- Step 1: Search Member -->
            <div x-show="verificationStep === 1">
                <p class="text-gray-600 mb-4">Cari member berdasarkan email atau nama:</p>
                <input type="text" 
                       x-model="memberSearch" 
                       @keyup.enter="searchMember()"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500"
                       placeholder="Masukkan email atau nama member">
                <div class="flex gap-2">
                    <button @click="searchMember()" 
                            class="flex-1 bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700">
                        Cari Member
                    </button>
                    <button @click="skipVerification()" 
                            class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-300">
                        Lewati
                    </button>
                </div>
            </div>

            <!-- Step 2: Choose Verification Code -->
            <div x-show="verificationStep === 2">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <p class="font-semibold text-green-800" x-text="memberData.name"></p>
                    <p class="text-sm text-green-600" x-text="memberData.email"></p>
                    <p class="text-sm text-green-600">Poin saat ini: <span x-text="memberData.points"></span></p>
                </div>
                
                <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-6 mb-4 text-center">
                    <p class="text-sm text-gray-700 mb-3 font-medium">Sebutkan kode ini ke member:</p>
                    <div class="bg-white rounded-lg p-6 border-2 border-blue-500 shadow-lg">
                        <p class="text-6xl font-bold text-blue-600" x-text="correctCode"></p>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <p class="text-xs text-yellow-800">
                        💡 <strong>Tip:</strong> Sebutkan angka di atas kepada member secara lisan, lalu minta mereka memilih kode tersebut di HP/akun mereka.
                    </p>
                </div>

                <div class="flex gap-2 mb-3">
                    <button @click="if(confirm('Pastikan member sudah memilih kode yang benar. Lanjutkan?')) { finishTransaction() }" 
                            class="flex-1 bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700">
                        Selesai
                    </button>
                    <button @click="closeMemberModal()" 
                            class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-300">
                        Batal
                    </button>
                </div>
                
                <!-- Tombol Kirim Ulang -->
                <div class="border-t pt-3">
                    <button @click="resendVerification()" 
                            class="w-full bg-orange-100 border border-orange-300 text-orange-700 py-2 rounded-lg font-semibold hover:bg-orange-200 transition">
                        🔄 Kirim Ulang (Jika Member Salah Pilih)
                    </button>
                </div>
            </div>

            <!-- Loading -->
            <div x-show="isLoading" class="text-center py-8">
                <svg class="animate-spin h-8 w-8 text-green-600 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-gray-600 mt-2">Loading...</p>
            </div>
        </div>
    </div>

    <!-- Modal Transaction Success with Print -->
    <div x-show="showSuccessModal" 
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative">
            <!-- Success Icon -->
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Transaksi Berhasil!</h2>
                <p class="text-gray-600">Pembayaran telah diproses</p>
            </div>

            <!-- Transaction Summary -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order ID:</span>
                    <span class="font-semibold" x-text="'#' + orderId"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold text-xl" x-text="'Rp ' + formatRupiah(successTotal)"></span>
                </div>
                <div class="flex justify-between mb-2" x-show="successPaid > 0">
                    <span class="text-gray-600">Bayar:</span>
                    <span class="font-semibold" x-text="'Rp ' + formatRupiah(successPaid)"></span>
                </div>
                <div class="flex justify-between" x-show="successChange >= 0">
                    <span class="text-gray-600">Kembalian:</span>
                    <span class="font-bold text-green-600" x-text="'Rp ' + formatRupiah(successChange)"></span>
                </div>
                <div class="mt-3 pt-3 border-t" x-show="pointsEarned > 0">
                    <div class="flex items-center justify-center gap-2 bg-green-50 rounded-lg p-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-center">
                            <p class="text-xs text-gray-600">Poin Member:</p>
                            <p class="font-bold text-green-600" x-text="'+' + pointsEarned + ' Poin'"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print Button -->
            <button @click="printReceipt()" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Struk
            </button>

            <!-- Close Button -->
            <button @click="closeSuccessModal()" 
                    class="w-full mt-3 border border-gray-300 text-gray-700 py-2 px-6 rounded-lg font-semibold hover:bg-gray-50 transition">
                Tutup
            </button>
        </div>
    </div>

    <!-- Modal Pilih Varian -->
    <div x-show="showVariantModal" 
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         @click.self="showVariantModal = false">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6" @click.stop>
            <h3 class="text-xl font-bold mb-2" x-text="selectedProduct ? selectedProduct.name : ''"></h3>
            <p class="text-gray-600 text-sm mb-6">Pilih varian yang diinginkan:</p>
            
            <template x-if="selectedProduct && selectedProduct.variants">
                <div class="space-y-4">
                    <template x-for="variant in selectedProduct.variants" :key="variant.type">
                        <div>
                            <p class="text-sm font-semibold text-gray-700 mb-2" x-text="variant.type"></p>
                            <div class="grid grid-cols-2 gap-2">
                                <template x-for="option in variant.options" :key="option.value">
                                    <button @click="selectVariant(variant.type, option.value, option.price, selectedProduct.discount)" 
                                            class="border-2 border-gray-300 hover:border-blue-500 hover:bg-blue-50 rounded-lg p-3 transition text-left">
                                        <p class="font-semibold text-gray-900" x-text="option.value"></p>
                                        <template x-if="option.price > 0">
                                            <div>
                                                <p x-show="selectedProduct.discount > 0" class="text-xs text-gray-400 line-through" 
                                                   x-text="'Rp ' + formatRupiah(option.price)"></p>
                                                <p class="text-sm text-green-600 font-bold" 
                                                   x-text="'Rp ' + formatRupiah(selectedProduct.discount > 0 ? option.price - (option.price * selectedProduct.discount / 100) : option.price)"></p>
                                                <p x-show="selectedProduct.discount > 0" class="text-xs text-red-500 font-semibold">
                                                    <span x-text="'-' + selectedProduct.discount + '%'"></span>
                                                </p>
                                            </div>
                                        </template>
                                        <p x-show="!option.price || option.price === 0" class="text-sm text-blue-600 font-bold">Harga Basic</p>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
            
            <button @click="showVariantModal = false" 
                    class="w-full mt-6 border border-gray-300 text-gray-700 py-2 px-6 rounded-lg font-semibold hover:bg-gray-50 transition">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
function pos() {
    return {
        cart: [],
        searchProduct: '',
        paymentMethod: 'cash',
        paidAmount: 0,
        showMemberModal: false,
        showSuccessModal: false,
        successTotal: 0,
        successPaid: 0,
        successChange: 0,
        verificationStep: 1,
        memberSearch: '',
        memberData: null,
        verificationCodes: [],
        selectedCode: '',
        correctCode: '',
        orderId: null,
        isLoading: false,
        pointsEarned: 0,
        totalPoints: 0,
        pollingInterval: null,
        scanning: false,
        sessionId: '',
        connectedDevices: 0,
        scannerDetected: false,
        scannerName: 'Keyboard/USB Scanner',
        scannerLastScan: '',
        printerDetected: false,
        printerName: 'Tidak Terdeteksi',
        showVariantModal: false,
        selectedProduct: null,
        
        init() {
            // Generate atau ambil session ID
            this.sessionId = localStorage.getItem('kasir_session_id');
            if (!this.sessionId) {
                this.sessionId = 'KS-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                localStorage.setItem('kasir_session_id', this.sessionId);
            }
            
            // Check connected devices periodically
            this.checkConnectedDevices();
            setInterval(() => this.checkConnectedDevices(), 3000);
            
            // Detect printer availability
            this.detectPrinter();
            
            // Monitor scanner activity
            this.monitorScanner();
            
            // Prevent refresh/close saat modal verifikasi terbuka
            window.addEventListener('beforeunload', (e) => {
                if (this.showMemberModal) {
                    e.preventDefault();
                    e.returnValue = 'Anda sedang dalam proses verifikasi member. Yakin ingin keluar?';
                    return e.returnValue;
                }
            });
            
            // Sync cart ke server setiap ada perubahan
            this.$watch('cart', () => {
                this.syncToServer();
                this.syncToCustomerDisplay(); // Juga sync localStorage untuk backward compatibility
            });
            
            // Sync initial state ke customer display
            this.syncToCustomerDisplay();
            
            // Auto-focus ke barcode input
            this.$nextTick(() => {
                if (this.$refs.barcodeInput) {
                    this.$refs.barcodeInput.focus();
                }
            });
            
            // Auto-focus barcode input saat ada ketikan (kecuali sedang ketik di input lain)
            document.addEventListener('keydown', (e) => {
                const target = e.target;
                const isInputActive = target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.isContentEditable;
                
                // Jika sedang ketik di input lain, jangan auto-focus
                if (isInputActive && target.id !== 'barcode-input') {
                    return;
                }
                
                // Jika tekan angka (0-9) dan tidak sedang di input lain, focus ke barcode
                if (/^[0-9]$/.test(e.key) && !isInputActive) {
                    e.preventDefault();
                    if (this.$refs.barcodeInput) {
                        this.$refs.barcodeInput.focus();
                        this.$refs.barcodeInput.value += e.key;
                    }
                }
            });
        },
        
        async syncToServer(includeVerification = false, includePaymentSuccess = false) {
            try {
                const payload = {
                    session_id: this.sessionId,
                    cart: this.cart,
                    cashier: {
                        name: '{{ auth()->user()->name }}',
                        photo: '{{ auth()->user()->photo_url ?? '' }}'
                    }
                };
                
                // Tambahkan data verifikasi jika ada
                if (includeVerification && this.verificationStep === 2 && this.memberData) {
                    payload.verification = {
                        memberName: this.memberData.name,
                        correctCode: this.correctCode
                    };
                }
                
                // Tambahkan payment success jika ada
                if (includePaymentSuccess) {
                    const paymentMethods = {
                        'cash': 'Cash',
                        'transfer': 'Transfer Bank',
                        'e-wallet': 'E-Wallet'
                    };
                    
                    payload.payment_success = {
                        paymentMethod: paymentMethods[this.paymentMethod] || this.paymentMethod,
                        total: this.getTotal(),
                        points: this.pointsEarned || 0,
                        paid: this.paidAmount || 0,
                        change: this.getChange() || 0,
                        orderId: this.orderId
                    };
                }
                
                await fetch('/kasir/sync-display', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });
            } catch (error) {
                console.error('Sync error:', error);
            }
        },

        async checkConnectedDevices() {
            try {
                const response = await fetch(`/kasir/check-connected-devices?session_id=${this.sessionId}`);
                const data = await response.json();
                this.connectedDevices = data.count || 0;
            } catch (error) {
                console.error('Error checking devices:', error);
                this.connectedDevices = 0;
            }
        },

        detectPrinter() {
            // Simple check: browser print capability
            if (window.print && typeof window.print === 'function') {
                this.printerDetected = true;
                this.printerName = 'Browser Print Ready';
            } else {
                this.printerDetected = false;
                this.printerName = 'Tidak Tersedia';
            }
        },

        monitorScanner() {
            let scanBuffer = '';
            let scanTimeout = null;

            // Listen untuk input cepat dari barcode scanner
            document.addEventListener('keypress', (e) => {
                // Ignore jika sedang ketik di input field lain (selain barcode input)
                if (e.target !== this.$refs.barcodeInput && e.target.tagName === 'INPUT') {
                    return;
                }

                // Barcode scanner biasanya input sangat cepat (< 100ms antar karakter)
                clearTimeout(scanTimeout);
                
                scanBuffer += e.key;
                
                scanTimeout = setTimeout(() => {
                    // Jika buffer panjangnya >= 8 karakter, kemungkinan dari scanner
                    if (scanBuffer.length >= 8) {
                        this.scannerDetected = true;
                        this.scannerLastScan = new Date().toLocaleTimeString('id-ID');
                        console.log('✅ Barcode scanner detected!');
                    }
                    scanBuffer = '';
                }, 100);
            });

            // Juga detect dari barcode input field
            if (this.$refs.barcodeInput) {
                this.$refs.barcodeInput.addEventListener('input', (e) => {
                    if (e.target.value.length >= 8) {
                        this.scannerDetected = true;
                        this.scannerLastScan = new Date().toLocaleTimeString('id-ID');
                    }
                });
            }
        },

        async scanBarcode(barcode) {
            if (!barcode || barcode.trim() === '') return;

            this.scanning = true;
            
            try {
                const response = await fetch('{{ route('kasir.scan-barcode') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ barcode: barcode.trim() })
                });

                const data = await response.json();

                if (data.success) {
                    // Play success beep
                    this.playBeep(true);
                    
                    // Add product to cart with variant info if available
                    const variantInfo = data.product.selected_variant || null;
                    const variantKey = variantInfo ? `${variantInfo.type}_${variantInfo.value}` : null;
                    
                    this.addItem(
                        data.product.id, 
                        data.product.title, 
                        data.product.final_price, 
                        data.product.stock,
                        variantInfo,
                        variantKey
                    );
                    
                    // Show notification with variant info
                    const variantText = variantInfo ? ` (${variantInfo.type}: ${variantInfo.value})` : '';
                    this.showNotification(`✅ ${data.product.title}${variantText} ditambahkan`, 'success');
                } else {
                    // Play error beep
                    this.playBeep(false);
                    
                    // Show error
                    this.showNotification(`❌ ${data.message}`, 'error');
                }
            } catch (error) {
                console.error('Scan error:', error);
                this.playBeep(false);
                this.showNotification('❌ Terjadi kesalahan saat scan!', 'error');
            } finally {
                this.scanning = false;
                // Auto-focus kembali ke input barcode
                this.$nextTick(() => {
                    this.$refs.barcodeInput.focus();
                });
            }
        },

        playBeep(success = true) {
            // Web Audio API untuk beep sound
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.value = success ? 800 : 400; // Success: high pitch, Error: low pitch
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
        },

        showNotification(message, type = 'success', duration = 2000) {
            const colors = {
                'success': 'bg-green-600',
                'error': 'bg-red-600',
                'info': 'bg-gray-700',
                'warning': 'bg-yellow-600'
            };
            
            const bgColor = colors[type] || colors.success;
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-md`;
            notification.style.whiteSpace = 'pre-line'; // Support line breaks
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, duration);
        },

        handleProductClick(id, name, price, stock, hasVariants, variants = [], discount = 0) {
            if (hasVariants) {
                this.selectedProduct = {
                    id: id,
                    name: name,
                    price: price,
                    stock: stock,
                    variants: variants,
                    discount: discount
                };
                this.showVariantModal = true;
                return;
            }
            this.addItem(id, name, price, stock);
        },

        selectVariant(variantType, variantValue, variantPrice, discount = 0) {
            // Jika variant price = 0 atau null, gunakan harga basic produk (sudah dengan diskon)
            let finalPrice = (variantPrice && variantPrice > 0) ? variantPrice : this.selectedProduct.price;
            
            // Apply discount ke variant price kalau ada
            if (discount > 0 && variantPrice && variantPrice > 0) {
                finalPrice = variantPrice - (variantPrice * discount / 100);
            }
            
            const variantKey = `${variantType}_${variantValue}`;
            const variantInfo = {
                type: variantType,
                value: variantValue,
                price: finalPrice
            };
            
            this.addItem(
                this.selectedProduct.id,
                this.selectedProduct.name,
                finalPrice,
                this.selectedProduct.stock,
                variantInfo,
                variantKey
            );
            
            this.showVariantModal = false;
            this.selectedProduct = null;
        },

        addItem(id, name, price, stock, variantInfo = null, variantKey = null) {
            // Create unique key for product + variant combination
            const itemKey = variantKey ? `${id}_${variantKey}` : id;
            
            const existingItem = this.cart.find(item => {
                if (variantKey) {
                    return item.uniqueKey === itemKey;
                } else {
                    return item.id === id && !item.variantKey;
                }
            });
            
            if (existingItem) {
                if (existingItem.qty < stock) {
                    existingItem.qty++;
                } else {
                    alert('Stok tidak cukup!');
                }
            } else {
                const newItem = { 
                    id, 
                    name, 
                    price, 
                    qty: 1, 
                    stock,
                    uniqueKey: itemKey
                };
                
                // Add variant info if available (but don't change displayName)
                if (variantInfo) {
                    newItem.variantKey = variantKey;
                    newItem.variantInfo = variantInfo;
                    newItem.displayName = name; // Keep original name, variant shown separately
                } else {
                    newItem.displayName = name;
                }
                
                this.cart.push(newItem);
            }
            this.paidAmount = this.getTotal();
            this.syncToCustomerDisplay();
        },

        removeItem(index) {
            this.cart.splice(index, 1);
            this.syncToCustomerDisplay();
        },

        increaseQty(index) {
            if (this.cart[index].qty < this.cart[index].stock) {
                this.cart[index].qty++;
                this.syncToCustomerDisplay();
            } else {
                alert('Stok tidak cukup!');
            }
        },

        decreaseQty(index) {
            if (this.cart[index].qty > 1) {
                this.cart[index].qty--;
                this.syncToCustomerDisplay();
            }
        },

        getTotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },

        getChange() {
            return this.paidAmount - this.getTotal();
        },

        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        },

        syncToCustomerDisplay() {
            // Sync cart + nama kasir to localStorage for customer display
            localStorage.setItem('pos_cart', JSON.stringify(this.cart));
            localStorage.setItem('pos_cashier', JSON.stringify({
                name: '{{ Auth::user()->name }}',
                photo: '{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : '' }}'
            }));
            
            // Sync ke server untuk multi-device support
            fetch('/kasir/sync-customer-display', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: this.sessionId,
                    cart: this.cart,
                    cashier: {
                        name: '{{ Auth::user()->name }}',
                        photo: '{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : '' }}'
                    }
                })
            }).catch(err => console.error('Sync error:', err));
        },

        async refreshCartPrices() {
            // Skip if cart is empty
            if (this.cart.length === 0) return;

            try {
                // Collect unique product IDs from cart (handle variants)
                const productIds = [...new Set(this.cart.map(item => item.id))];
                
                // Fetch fresh data for all products in cart
                const freshDataPromises = productIds.map(id => 
                    fetch(`/api/product/${id}/fresh-price`, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(res => res.json())
                );
                
                const results = await Promise.all(freshDataPromises);
                
                // Track price changes
                let changeDetails = [];
                
                results.forEach(data => {
                    if (data.success) {
                        const product = data.product;
                        
                        // Update all cart items with this product ID
                        this.cart.forEach(item => {
                            if (item.id === product.id) {
                                const oldPrice = item.price;
                                let newPrice = product.final_price;
                                
                                // If item has variant, get variant price
                                if (item.variantInfo) {
                                    const variantKey = item.variantKey;
                                    // Find variant price from fresh data
                                    if (product.variants && product.variants.length > 0) {
                                        for (const variant of product.variants) {
                                            if (variant.options) {
                                                for (const option of variant.options) {
                                                    const optionKey = `${variant.type}_${option.value}`;
                                                    if (optionKey === variantKey && option.price) {
                                                        newPrice = option.price;
                                                        // Apply discount if exists
                                                        if (product.discount > 0) {
                                                            newPrice = newPrice - (newPrice * product.discount / 100);
                                                        }
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                // ONLY track if price actually changed (strict comparison)
                                if (Math.abs(oldPrice - newPrice) > 0.01) {
                                    const priceChange = newPrice > oldPrice ? 'naik' : 'turun';
                                    changeDetails.push(`${item.displayName || item.name}: Rp${this.formatRupiah(oldPrice)} → Rp${this.formatRupiah(newPrice)} (${priceChange})`);
                                    
                                    // Update price
                                    item.price = newPrice;
                                }
                                
                                // Always update stock (silent update)
                                item.stock = product.stock;
                            }
                        });
                    }
                });
                
                // ONLY show notification if there are actual price changes
                if (changeDetails.length > 0) {
                    const message = `Sebentar ya, ada update di salah satu produk yang ada di cart...\n\n${changeDetails.join('\n')}`;
                    this.showNotification(message, 'info', 5000);
                    
                    // Re-sync to customer display
                    this.syncToCustomerDisplay();
                }
                
            } catch (error) {
                console.error('Failed to refresh cart prices:', error);
            }
        },

        clearCart() {
            if (confirm('Yakin ingin mengosongkan keranjang?')) {
                this.cart = [];
                this.paidAmount = 0;
                this.syncToCustomerDisplay();
            }
        },

        async processPayment() {
            if (this.cart.length === 0) {
                alert('Keranjang kosong!');
                return;
            }

            if (this.getChange() < 0) {
                alert('Jumlah bayar kurang!');
                return;
            }

            this.isLoading = true;

            // ✅ VALIDASI HARGA TERAKHIR SEBELUM CHECKOUT
            try {
                await this.refreshCartPrices();
                
                // Tunggu sebentar kalau ada notifikasi perubahan harga
                // Biar kasir bisa liat dulu
                if (this.cart.length > 0) {
                    await new Promise(resolve => setTimeout(resolve, 100));
                }
            } catch (error) {
                console.error('Price validation failed:', error);
                // Lanjut aja kalau gagal, jangan block transaksi
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            
            this.cart.forEach((item, index) => {
                formData.append(`items[${index}][product_id]`, item.id);
                formData.append(`items[${index}][quantity]`, item.qty);
                formData.append(`items[${index}][price]`, item.price);
                
                // Include variant info if available
                if (item.variantInfo) {
                    formData.append(`items[${index}][variantInfo][type]`, item.variantInfo.type);
                    formData.append(`items[${index}][variantInfo][value]`, item.variantInfo.value);
                    formData.append(`items[${index}][variantInfo][price]`, item.variantInfo.price || '');
                }
            });
            
            formData.append('payment_method', this.paymentMethod);
            formData.append('paid_amount', this.paidAmount);

            fetch('{{ route("kasir.transaksi.process") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                this.isLoading = false;
                
                if (data.success) {
                    this.orderId = data.order_id;
                    // Langsung tampilkan modal verifikasi member
                    this.showMemberModal = true;
                    this.verificationStep = 1;
                } else {
                    alert(data.message || 'Transaksi gagal!');
                }
            })
            .catch(error => {
                this.isLoading = false;
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses transaksi!');
            });
        },

        async searchMember() {
            if (!this.memberSearch.trim()) {
                alert('Masukkan email atau nama member!');
                return;
            }

            this.isLoading = true;

            try {
                const response = await fetch('{{ route('kasir.member.search') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        search: this.memberSearch
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.memberData = data.member;
                    this.verificationCodes = data.codes;
                    this.correctCode = data.correct_code;
                    this.verificationStep = 2;
                    
                    // Kirim HANYA kode yang benar ke customer display (localStorage)
                    localStorage.setItem('pos_verification', JSON.stringify({
                        memberName: data.member.name,
                        correctCode: data.correct_code
                    }));
                    
                    // Sync ke server untuk multi-device
                    this.syncToServer(true, false);
                    
                    // Start polling untuk check status verifikasi
                    this.startPolling();
                } else {
                    alert(data.message || 'Member tidak ditemukan!');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari member!');
            } finally {
                this.isLoading = false;
            }
        },

        async verifyCode() {
            if (!this.selectedCode) {
                alert('Pilih kode verifikasi!');
                return;
            }

            this.isLoading = true;

            try {
                const response = await fetch('{{ route('kasir.member.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: this.orderId,
                        member_id: this.memberData.id,
                        selected_code: this.selectedCode,
                        correct_code: this.correctCode,
                        total: this.getTotal()
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.pointsEarned = data.points_earned;
                    this.totalPoints = data.total_points;
                    this.verificationStep = 3;
                } else {
                    alert(data.message || 'Kode verifikasi salah!');
                    this.selectedCode = '';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat verifikasi!');
            } finally {
                this.isLoading = false;
            }
        },

        skipVerification() {
            console.log('🔴 skipVerification() called');
            
            // Clear verification codes dari customer display
            localStorage.removeItem('pos_verification');
            
            // Set payment success data
            this.pointsEarned = 0;
            
            // Trigger payment success popup di customer display (tanpa poin)
            const paymentMethods = {
                'cash': 'Cash',
                'transfer': 'Transfer Bank',
                'e-wallet': 'E-Wallet'
            };
            
            const paymentData = {
                paymentMethod: paymentMethods[this.paymentMethod] || this.paymentMethod,
                total: this.getTotal(),
                points: 0,
                paid: this.paidAmount,
                change: this.getChange(),
                orderId: this.orderId
            };
            
            console.log('💾 Setting payment_success to localStorage:', paymentData);
            localStorage.setItem('payment_success', JSON.stringify(paymentData));
            
            console.log('🌐 Syncing to server...');
            // Sync ke server untuk multi-device (clear verification + show payment success)
            this.syncToServer(false, true);
            
            // Close member modal
            this.showMemberModal = false;
            this.verificationStep = 1;
            this.memberSearch = '';
            this.memberData = null;
            this.verificationCodes = [];
            this.selectedCode = '';
            this.correctCode = '';
            this.isLoading = false;
            this.stopPolling();
            
            // Show success modal di kasir
            this.successTotal = this.getTotal();
            this.successPaid = this.paidAmount;
            this.successChange = this.getChange();
            this.showSuccessModal = true;
            
            // TIDAK auto-clear cart - tunggu user tutup modal
        },

        closeMemberModal() {
            this.showMemberModal = false;
            this.verificationStep = 1;
            this.memberSearch = '';
            this.memberData = null;
            this.verificationCodes = [];
            this.selectedCode = '';
            this.correctCode = '';
            this.isLoading = false;
            this.stopPolling();
            
            // Clear verification di localStorage dan server
            localStorage.removeItem('pos_verification');
            this.syncToServer(false, false); // Clear verification dari server
            
            // Don't open receipt here - it will be handled by customer display
        },

        finishTransaction() {
            console.log('✅ finishTransaction() called');
            console.log('Points earned:', this.pointsEarned);
            console.log('Total points:', this.totalPoints);
            
            // Clear verification codes dari customer display
            localStorage.removeItem('pos_verification');
            
            // Trigger payment success popup di customer display (dengan poin)
            const paymentMethods = {
                'cash': 'Cash',
                'transfer': 'Transfer Bank',
                'e-wallet': 'E-Wallet'
            };
            
            const paymentData = {
                paymentMethod: paymentMethods[this.paymentMethod] || this.paymentMethod,
                total: this.getTotal(),
                points: this.pointsEarned,
                paid: this.paidAmount,
                change: this.getChange(),
                orderId: this.orderId
            };
            
            console.log('💾 Setting payment_success to localStorage:', paymentData);
            localStorage.setItem('payment_success', JSON.stringify(paymentData));
            
            console.log('🌐 Syncing to server...');
            // Sync ke server untuk multi-device (clear verification + show payment success)
            this.syncToServer(false, true);
            
            // Close member modal DULU sebelum show success
            this.showMemberModal = false;
            this.verificationStep = 1;
            this.memberSearch = '';
            this.memberData = null;
            this.verificationCodes = [];
            this.selectedCode = '';
            this.correctCode = '';
            this.stopPolling();
            
            // Show success modal di kasir SETELAH member modal ditutup
            this.successTotal = this.getTotal();
            this.successPaid = this.paidAmount;
            this.successChange = this.getChange();
            console.log('📊 Success modal data:', {
                total: this.successTotal,
                paid: this.successPaid,
                change: this.successChange
            });
            this.showSuccessModal = true;
            console.log('🎉 showSuccessModal set to true');
            
            // TIDAK clear cart otomatis - biarkan user tutup modal dulu
        },

        closeSuccessModal() {
            this.showSuccessModal = false;
            
            // Clear cart setelah modal ditutup
            this.cart = [];
            this.paidAmount = 0;
            localStorage.removeItem('payment_success');
            this.syncToServer(false, false);
        },

        printReceipt() {
            if (this.orderId) {
                window.open(`/kasir/transaksi/struk/${this.orderId}`, '_blank');
            }
        },

        // Polling untuk check apakah member sudah verifikasi
        startPolling() {
            if (!this.orderId) return;
            
            console.log('🔄 Polling started for order:', this.orderId);
            
            this.pollingInterval = setInterval(() => {
                fetch(`/orders/${this.orderId}/verification-status`)
                    .then(res => res.json())
                    .then(data => {
                        console.log('📡 Polling response:', data);
                        
                        if (data.success && data.is_verified) {
                            console.log('✅ Member verified! Points:', data.points_awarded);
                            
                            // Member sudah berhasil verifikasi!
                            this.stopPolling();
                            
                            // Clear verification codes dari customer display
                            localStorage.removeItem('pos_verification');
                            
                            // Set points earned
                            this.pointsEarned = data.points_awarded || 0;
                            this.totalPoints = data.total_points || 0;
                            
                            // Trigger payment success popup di customer display (localStorage)
                            const paymentMethods = {
                                'cash': 'Cash',
                                'transfer': 'Transfer Bank',
                                'e-wallet': 'E-Wallet'
                            };
                            
                            localStorage.setItem('payment_success', JSON.stringify({
                                paymentMethod: paymentMethods[this.paymentMethod] || this.paymentMethod,
                                total: this.getTotal(),
                                points: this.pointsEarned,
                                paid: this.paidAmount,
                                change: this.getChange(),
                                orderId: this.orderId
                            }));
                            
                            // Sync ke server untuk multi-device
                            this.syncToServer(false, true);
                            
                            // ✅ CLOSE MEMBER MODAL & SHOW SUCCESS MODAL
                            this.showMemberModal = false;
                            this.verificationStep = 1;
                            this.memberSearch = '';
                            this.memberData = null;
                            this.verificationCodes = [];
                            this.selectedCode = '';
                            this.correctCode = '';
                            
                            // Show success modal di kasir
                            this.successTotal = this.getTotal();
                            this.successPaid = this.paidAmount;
                            this.successChange = this.getChange();
                            this.showSuccessModal = true;
                            
                            console.log('🎉 Success modal shown with points:', this.pointsEarned);
                            
                            // Show notification
                            this.showNotification(`Verifikasi Berhasil!\nMember mendapat ${data.points_awarded} poin`, 'success', 3000);
                        }
                    })
                    .catch(err => console.error('Polling error:', err));
            }, 2000); // Check every 2 seconds
        },

        stopPolling() {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
                this.pollingInterval = null;
            }
        },

        // Kirim ulang kode verifikasi (jika member salah pilih)
        async resendVerification() {
            if (!this.memberData) {
                alert('Data member tidak ditemukan!');
                return;
            }

            this.isLoading = true;
            this.stopPolling(); // Stop polling yang lama

            try {
                const response = await fetch('{{ route('kasir.member.search') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        search: this.memberData.email
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update kode baru
                    this.verificationCodes = data.codes;
                    this.correctCode = data.correct_code;
                    
                    // Kembali ke step 2 (tampilkan kode baru)
                    this.verificationStep = 2;
                    
                    // Update customer display dengan kode baru (localStorage)
                    localStorage.setItem('pos_verification', JSON.stringify({
                        memberName: data.member.name,
                        correctCode: data.correct_code
                    }));
                    
                    // Sync ke server untuk multi-device
                    this.syncToServer(true, false);
                    
                    // Start polling lagi
                    this.startPolling();
                } else {
                    alert(data.message || 'Gagal mengirim ulang kode!');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim ulang kode!');
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>
@endsection
