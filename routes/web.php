<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DailyRewardController;

// Auth (public routes)
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Secret Registration for Testing (with role selection)
Route::get('/secret-register', [AuthController::class, 'secretRegisterForm'])->name('secret.register.form');
Route::post('/secret-register', [AuthController::class, 'secretRegister'])->name('secret.register');

// Public routes (catalog browsing for everyone)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('product.category');

// Universal authenticated routes (all roles can access their own profile)
Route::middleware('auth')->group(function () {
    // Profile (each user manages their own profile)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

// Member-only routes (shopping features)
Route::middleware(['auth', 'member'])->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update-variant/{id}', [CartController::class, 'updateVariant'])->name('cart.updateVariant');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout & Orders
    Route::match(['get', 'post'], '/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/request-cancellation', [OrderController::class, 'requestCancellation'])->name('orders.request-cancellation');
    Route::get('/orders/{id}/verification-status', [OrderController::class, 'checkVerificationStatus'])->name('orders.verification-status');
    
    // Reviews
    Route::post('/reviews/order-item/{orderItemId}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{reviewId}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{reviewId}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{reviewId}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
    
    // Vouchers
    Route::get('/vouchers', [VoucherController::class, 'index'])->name('member.vouchers');
    
    // Rewards & Vouchers
    Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');
    Route::post('/rewards/{id}/redeem', [RewardController::class, 'redeem'])->name('rewards.redeem');
    
    // Daily Rewards (claim only - display ada di home page)
    Route::post('/daily-rewards/claim', [DailyRewardController::class, 'claim'])->name('daily-rewards.claim');
    
    // Notifications (Member)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/verify', [NotificationController::class, 'verify'])->name('notifications.verify');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});

// Admin Routes (require admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/profile/photo', [AdminController::class, 'uploadPhoto'])->name('admin.profile.photo');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');
    Route::delete('/profile/photo', [AdminController::class, 'deletePhoto'])->name('admin.profile.photo.delete');
    
    // Products CRUD
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
    
    // Categories CRUD
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::post('/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    Route::get('/orders/cancellations/requests', [AdminController::class, 'cancellationRequests'])->name('admin.orders.cancellations');
    Route::post('/orders/cancellations/{id}/review', [AdminController::class, 'reviewCancellation'])->name('admin.orders.cancellations.review');
    
    // Reviews Management
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::post('/reviews/{id}/reply', [AdminController::class, 'replyReview'])->name('admin.reviews.reply');
    Route::delete('/reviews/{id}/reply', [AdminController::class, 'deleteReply'])->name('admin.reviews.delete-reply');
    
    Route::get('/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
    Route::get('/accounts/create', [AdminController::class, 'createAccount'])->name('admin.accounts.create');
    Route::post('/accounts', [AdminController::class, 'storeAccount'])->name('admin.accounts.store');
    Route::get('/accounts/{id}/edit', [AdminController::class, 'editAccount'])->name('admin.accounts.edit');
    Route::put('/accounts/{id}', [AdminController::class, 'updateAccount'])->name('admin.accounts.update');
    Route::delete('/accounts/{id}', [AdminController::class, 'deleteAccount'])->name('admin.accounts.delete');
    
    Route::get('/promotions', [AdminController::class, 'promotions'])->name('admin.promotions');
    
    // Reports with Export
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('admin.reports.export');
    
    // Banner Management
    Route::get('/banners', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    Route::put('/banners/{banner}/toggle', [BannerController::class, 'toggle'])->name('admin.banners.toggle');
    Route::put('/banners/{banner}/reorder', [BannerController::class, 'reorder'])->name('admin.banners.reorder');
});

// Kasir Routes (require kasir middleware)
Route::middleware(['auth', 'kasir'])->prefix('kasir')->group(function () {
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
    
    // Transaksi Penjualan (POS)
    Route::get('/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi');
    Route::post('/transaksi/process', [KasirController::class, 'processTransaksi'])->name('kasir.transaksi.process');
    Route::get('/transaksi/struk/{id}', [KasirController::class, 'cetakStruk'])->name('kasir.cetak-struk');
    
    // Barcode Scanner
    Route::post('/scan-barcode', [KasirController::class, 'scanBarcode'])->name('kasir.scan-barcode');
    
    // Customer Display Sync (untuk push data dari kasir)
    Route::post('/sync-display', [KasirController::class, 'syncCustomerDisplay'])->name('kasir.sync-display');
    
    // Check connected devices
    Route::get('/check-connected-devices', [KasirController::class, 'checkConnectedDevices'])->name('kasir.check-devices');
    
    // Customer Display API (no auth - untuk polling dari device terpisah)
    Route::get('/customer-display-api', [KasirController::class, 'getCustomerDisplayData'])->withoutMiddleware(['auth', 'kasir'])->name('kasir.customer-display.api');
    
    // Sync Customer Display (no auth - untuk update cart dari kasir)
    Route::post('/sync-customer-display', [KasirController::class, 'syncCustomerDisplay'])->withoutMiddleware(['auth', 'kasir'])->name('kasir.sync-customer-display');
    
    // Customer Display (no auth required - bisa diakses langsung)
    Route::get('/customer-display', function() {
        return view('kasir.customer-display');
    })->withoutMiddleware(['auth', 'kasir'])->name('kasir.customer-display');
    
    // Riwayat Transaksi
    Route::get('/riwayat', [KasirController::class, 'riwayat'])->name('kasir.riwayat');
    Route::get('/riwayat/export', [KasirController::class, 'exportRiwayat'])->name('kasir.riwayat.export');
    
    // Pelanggan
    Route::get('/pelanggan', [KasirController::class, 'pelanggan'])->name('kasir.pelanggan');
    Route::get('/pelanggan/{id}/riwayat', [KasirController::class, 'riwayatPelanggan'])->name('kasir.pelanggan.riwayat');
    
    // Member Management
    Route::get('/member/create', [KasirController::class, 'createMember'])->name('kasir.member.create');
    Route::post('/member/store', [KasirController::class, 'storeMember'])->name('kasir.member.store');
    
    // Member Verification & Points
    Route::post('/member/search', [KasirController::class, 'searchMember'])->name('kasir.member.search');
    Route::post('/member/verify', [KasirController::class, 'verifyMember'])->name('kasir.member.verify');
});

// API Routes (untuk auto-refresh, bisa diakses tanpa middleware kasir tapi butuh auth)
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/product/{id}/fresh-price', [KasirController::class, 'getFreshProductPrice'])->name('api.product.fresh-price');
});
