<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layar Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(-100%); opacity: 0; }
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .slide-transition {
            animation: slideIn 1s ease-in-out;
        }
    </style>
</head>
<body class="bg-white overflow-hidden">
    <div x-data="customerDisplay()" x-init="init()" class="h-screen flex">
        
        <!-- LEFT: Order List (40%) -->
        <div class="w-2/5 bg-white p-8 flex flex-col">
            <!-- Header - Nama Kasir -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-1" x-text="cashierName || 'Kasir'"></h1>
                <p class="text-gray-500">Kasir</p>
            </div>

            <!-- Items List -->
            <div class="flex-1 overflow-y-auto space-y-3 mb-6">
                <template x-if="cart.length === 0">
                    <div class="text-center text-gray-400 mt-20">
                        <p class="text-lg">Belum ada item</p>
                    </div>
                </template>

                <template x-for="(item, index) in cart" :key="index">
                    <div class="fade-in flex justify-between items-start py-2 border-b border-gray-200">
                        <div class="flex-1">
                            <div class="flex items-start gap-2">
                                <span class="text-gray-800 font-medium" x-text="item.qty"></span>
                                <div class="flex-1">
                                    <div class="text-gray-800 font-medium" x-text="item.name"></div>
                                    <div x-show="item.variantInfo" class="text-sm text-blue-600" x-text="item.variantInfo ? `${item.variantInfo.type}: ${item.variantInfo.value}` : ''"></div>
                                </div>
                            </div>
                        </div>
                        <span class="text-gray-800 font-medium" x-text="'Rp ' + formatRupiah(item.price * item.qty)"></span>
                    </div>
                </template>
            </div>

            <!-- Totals -->
            <div class="border-t-2 border-gray-300 pt-4 space-y-2">
                <div class="flex justify-between text-gray-700">
                    <span>Total Penjualan</span>
                    <span x-text="'Rp ' + formatRupiah(getTotal())"></span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Diskon Item</span>
                    <span>Rp 0</span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Diskon Subtotal</span>
                    <span>Rp 0</span>
                </div>
                <div class="flex justify-between text-2xl font-bold text-gray-900 pt-2 border-t border-gray-300">
                    <span>Total Bersih</span>
                    <span x-text="'Rp ' + formatRupiah(getTotal())"></span>
                </div>
            </div>
        </div>

        <!-- RIGHT: Banner/Promo (60%) -->
        <div class="w-3/5 bg-gray-100 relative overflow-hidden">
            @php
                $banners = \App\Models\Banner::where('position', 'customer_display')
                    ->where('is_active', true)
                    ->orderBy('display_order')
                    ->get();
            @endphp

            @if($banners->count() > 0)
                <div x-data="{ currentSlide: 0, banners: {{ $banners->toJson() }} }" 
                     x-init="setInterval(() => { currentSlide = (currentSlide + 1) % banners.length }, 5000)"
                     class="w-full h-full relative">
                    
                    <template x-for="(banner, index) in banners" :key="index">
                        <div x-show="currentSlide === index"
                             x-transition:enter="transition ease-in-out duration-1000"
                             x-transition:enter-start="opacity-0 transform translate-x-full"
                             x-transition:enter-end="opacity-100 transform translate-x-0"
                             x-transition:leave="transition ease-in-out duration-1000"
                             x-transition:leave-start="opacity-100 transform translate-x-0"
                             x-transition:leave-end="opacity-0 transform -translate-x-full"
                             class="absolute inset-0">
                            <img :src="'{{ asset('storage') }}/' + banner.image_path" 
                                 :alt="banner.title"
                                 class="w-full h-full object-cover">
                        </div>
                    </template>

                    <!-- Slide Indicators (jika lebih dari 1 banner) -->
                    <div x-show="banners.length > 1" class="absolute bottom-20 left-0 right-0 flex justify-center gap-2 z-10">
                        <template x-for="(banner, index) in banners" :key="index">
                            <button @click="currentSlide = index"
                                    class="w-3 h-3 rounded-full transition-all duration-300"
                                    :class="currentSlide === index ? 'bg-white w-8' : 'bg-white/50'">
                            </button>
                        </template>
                    </div>
                </div>
            @else
                <!-- Default placeholder jika belum ada banner -->
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                    <div class="text-center text-gray-500">
                        <svg class="w-32 h-32 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xl">Upload banner di halaman Promo (Admin)</p>
                    </div>
                </div>
            @endif

            <!-- Footer Badge -->
            <div class="absolute bottom-6 right-6 bg-white/90 backdrop-blur px-4 py-2 rounded-lg shadow-lg z-20">
                <p class="text-sm font-semibold text-gray-700">{{ config('app.name') }}</p>
            </div>
        </div>

        <!-- Verification Codes Modal -->
        <div x-show="showVerification" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
             style="display: none;">
            
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-lg w-full mx-4">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Verifikasi Member</h2>
                    <p class="text-gray-600 mb-2" x-text="'Hai ' + verificationMemberName + ', pilih nomor ini ya:'"></p>
                </div>

                <!-- Single Correct Code Display -->
                <div class="bg-gradient-to-br from-green-50 to-blue-50 border-2 border-green-400 rounded-2xl p-8 mb-6">
                    <p class="text-center text-6xl font-bold text-gray-900" x-text="verificationCorrectCode"></p>
                </div>

                <p class="text-sm text-gray-500 text-center">Kode verifikasi telah dikirim ke email Anda</p>
            </div>
        </div>

        <!-- Success Payment Popup -->
        <div x-show="showSuccessPopup" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
             style="display: none;">
            
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4">
                <div class="text-center">
                    <!-- Success Icon -->
                    <div class="mb-6">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h2>
                    <p class="text-gray-600 mb-6">Terima kasih atas pembelian Anda</p>

                    <!-- Payment Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4 text-left">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Metode Pembayaran:</span>
                            <span class="font-semibold text-gray-900" x-text="paymentMethodLabel"></span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Total:</span>
                            <span class="font-bold text-gray-900 text-xl" x-text="'Rp ' + formatRupiah(successTotal)"></span>
                        </div>
                        
                        <!-- Bayar & Kembalian (jika ada) -->
                        <div x-show="successPaid > 0" class="border-t border-gray-200 pt-2 mt-2">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Bayar:</span>
                                <span class="font-semibold text-gray-900" x-text="'Rp ' + formatRupiah(successPaid)"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kembalian:</span>
                                <span class="font-bold text-green-600 text-lg" x-text="'Rp ' + formatRupiah(successChange)"></span>
                            </div>
                        </div>
                        
                        <!-- Points Earned (if member) -->
                        <div x-show="successPoints > 0" class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-center gap-2 bg-green-50 rounded-lg p-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">Poin yang didapat:</p>
                                    <p class="text-2xl font-bold text-green-600" x-text="successPoints + ' Poin'"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function customerDisplay() {
            return {
                cart: [],
                orderNumber: '20865',
                cashierName: '',
                cashierPhoto: '',
                showVerification: false,
                verificationMemberName: '',
                verificationCorrectCode: '',
                showSuccessPopup: false,
                paymentMethodLabel: '',
                successTotal: 0,
                successPoints: 0,
                successPaid: 0,
                successChange: 0,
                sessionId: '',
                currentBannerIndex: 0,
                banners: @json($banners),
                lastPaymentSuccessTime: null, // Track payment success timestamp
                deviceId: '', // Unique device identifier

                init() {
                    // Generate unique device ID
                    this.deviceId = localStorage.getItem('customer_display_device_id');
                    if (!this.deviceId) {
                        this.deviceId = 'CD-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                        localStorage.setItem('customer_display_device_id', this.deviceId);
                    }
                    
                    // Get session ID from URL
                    const urlParams = new URLSearchParams(window.location.search);
                    this.sessionId = urlParams.get('session');
                    
                    if (this.sessionId) {
                        // Multi-device mode: polling dari server
                        this.startServerPolling();
                    } else {
                        // Single-device mode: localStorage (backward compatible)
                        this.startLocalStorageMode();
                    }
                    
                    // Auto rotate banner
                    if (this.banners.length > 1) {
                        setInterval(() => {
                            this.currentBannerIndex = (this.currentBannerIndex + 1) % this.banners.length;
                        }, 5000);
                    }

                    this.orderNumber = Math.floor(10000 + Math.random() + 90000);
                },

                startServerPolling() {
                    // Polling dari server setiap 1 detik
                    setInterval(() => {
                        fetch(`/kasir/customer-display-api?session_id=${this.sessionId}&device_id=${this.deviceId}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.success && data.data) {
                                    this.cart = data.data.cart || [];
                                    if (data.data.cashier) {
                                        this.cashierName = data.data.cashier.name || '';
                                        this.cashierPhoto = data.data.cashier.photo || '';
                                    }
                                    if (data.data.verification) {
                                        this.verificationMemberName = data.data.verification.memberName || '';
                                        this.verificationCorrectCode = data.data.verification.correctCode || '';
                                        this.showVerification = true;
                                    } else {
                                        this.showVerification = false;
                                    }
                                    // Payment success dengan anti-duplicate check
                                    if (data.data.payment_success) {
                                        const currentTotal = data.data.payment_success.total;
                                        const currentTime = Date.now();
                                        
                                        // Hanya show jika belum pernah show atau sudah 10 detik sejak last show
                                        if (!this.lastPaymentSuccessTime || 
                                            (currentTime - this.lastPaymentSuccessTime) > 10000) {
                                            this.paymentMethodLabel = data.data.payment_success.paymentMethod || '';
                                            this.successTotal = currentTotal;
                                            this.successPoints = data.data.payment_success.points || 0;
                                            this.successPaid = data.data.payment_success.paid || 0;
                                            this.successChange = data.data.payment_success.change || 0;
                                            this.showSuccessPopup = true;
                                            this.lastPaymentSuccessTime = currentTime;
                                            
                                            // TIDAK ada setTimeout, popup tetap muncul sampai ada transaksi baru
                                        }
                                    } else {
                                        // Jika tidak ada payment_success DAN cart sudah ada item baru, hide popup
                                        if (this.showSuccessPopup && this.cart.length > 0) {
                                            this.showSuccessPopup = false;
                                        }
                                    }
                                }
                            })
                            .catch(err => console.error('Polling error:', err));
                    }, 1000);
                },

                startLocalStorageMode() {
                    // Backward compatible: localStorage sync
                    this.syncCart();
                    this.syncCashier();
                    this.syncVerification();
                    setInterval(() => {
                        this.syncCart();
                        this.syncCashier();
                        this.syncVerification();
                    }, 100);
                    
                    window.addEventListener('storage', (e) => {
                        if (e.key === 'pos_cart') this.syncCart();
                        else if (e.key === 'pos_cashier') this.syncCashier();
                        else if (e.key === 'pos_verification') this.syncVerification();
                        else if (e.key === 'payment_success') this.showPaymentSuccess();
                    });
                    
                    this.checkPaymentSuccess();
                    
                    // Watch cart: hide popup jika ada item baru
                    this.$watch('cart', (newCart) => {
                        if (this.showSuccessPopup && newCart.length > 0) {
                            this.showSuccessPopup = false;
                        }
                    });
                },

                syncCart() {
                    const cartData = localStorage.getItem('pos_cart');
                    if (cartData) {
                        try {
                            const newCart = JSON.parse(cartData);
                            if (JSON.stringify(this.cart) !== JSON.stringify(newCart)) {
                                this.cart = newCart;
                            }
                        } catch (e) {
                            console.error('Error parsing cart:', e);
                        }
                    } else {
                        this.cart = [];
                    }
                },

                syncCashier() {
                    const cashierData = localStorage.getItem('pos_cashier');
                    if (cashierData) {
                        try {
                            const data = JSON.parse(cashierData);
                            this.cashierName = data.name || '';
                            this.cashierPhoto = data.photo || '';
                        } catch (e) {
                            console.error('Error parsing cashier:', e);
                        }
                    }
                },

                syncVerification() {
                    const verificationData = localStorage.getItem('pos_verification');
                    if (verificationData) {
                        try {
                            const data = JSON.parse(verificationData);
                            this.verificationMemberName = data.memberName || '';
                            this.verificationCorrectCode = data.correctCode || '';
                            
                            // Auto show verification modal
                            this.showVerification = true;
                        } catch (e) {
                            console.error('Error parsing verification:', e);
                        }
                    } else {
                        this.showVerification = false;
                    }
                },

                checkPaymentSuccess() {
                    const successData = localStorage.getItem('payment_success');
                    if (successData) {
                        this.showPaymentSuccess();
                    }
                },

                showPaymentSuccess() {
                    console.log('📢 showPaymentSuccess() called');
                    const successData = localStorage.getItem('payment_success');
                    console.log('💾 payment_success from localStorage:', successData);
                    
                    if (successData) {
                        try {
                            const data = JSON.parse(successData);
                            console.log('✅ Parsed payment data:', data);
                            
                            this.paymentMethodLabel = data.paymentMethod;
                            this.successTotal = data.total;
                            this.successPoints = data.points || 0;
                            this.successPaid = data.paid || 0;
                            this.successChange = data.change || 0;
                            
                            this.showSuccessPopup = true;
                            console.log('🎉 Payment success popup shown!');
                            
                            // JANGAN hapus localStorage di sini, biarkan kasir yang hapus setelah 10 detik
                            // localStorage.removeItem('payment_success');
                            
                            // TIDAK ada setTimeout, popup tetap muncul
                        } catch (e) {
                            console.error('❌ Error parsing payment success:', e);
                        }
                    } else {
                        console.log('⚠️ No payment_success data in localStorage');
                    }
                },

                getTotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                }
            }
        }
    </script>
</body>
</html>
