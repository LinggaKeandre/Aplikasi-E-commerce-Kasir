# Database ERD - Aplikasi Kasir POS & E-Commerce

## Diagram Hubungan Antar Tabel (Simplified)

```mermaid
erDiagram
    %% CORE TABLES
    USERS ||--o{ ORDERS : "places/processes"
    USERS ||--o{ CARTS : "owns"
    USERS ||--o{ REVIEWS : "writes"
    USERS ||--o{ USER_POINTS : "earns"
    USERS ||--o{ USER_VOUCHERS : "claims"
    USERS ||--o{ DAILY_REWARDS : "tracks"
    
    %% PRODUCTS
    CATEGORIES ||--o{ PRODUCTS : "contains"
    PRODUCTS ||--o{ CART_ITEMS : "added_to"
    PRODUCTS ||--o{ ORDER_ITEMS : "sold_in"
    PRODUCTS ||--o{ REVIEWS : "reviewed_in"
    
    %% SHOPPING CART
    CARTS ||--o{ CART_ITEMS : "contains"
    
    %% ORDERS & TRANSACTIONS
    ORDERS ||--o{ ORDER_ITEMS : "contains"
    ORDERS ||--o| VOUCHERS : "uses"
    ORDERS ||--o| ORDER_CANCELLATION_REQUESTS : "may_have"
    ORDERS }o--|| USERS : "member (kasir only)"
    
    %% REWARDS & GAMIFICATION
    VOUCHERS ||--o{ USER_VOUCHERS : "claimed_by"
    VOUCHERS ||--o{ REWARD_VOUCHERS : "offered_as_reward"
    
    %% TABLE DEFINITIONS
    USERS {
        bigint id PK
        string name
        string email
        string password
        enum role "admin/kasir/member"
        string phone
        text address
        string photo
        int total_points
    }
    
    CATEGORIES {
        bigint id PK
        string name
        string slug
        text description
    }
    
    PRODUCTS {
        bigint id PK
        bigint category_id FK
        string title
        string slug
        string barcode "EAN-13 or 0000000000000"
        decimal price
        int discount "percentage 0-100"
        int stock
        json variants "type, options with price/barcode"
        text description
        string image
    }
    
    CARTS {
        bigint id PK
        bigint user_id FK
    }
    
    CART_ITEMS {
        bigint id PK
        bigint cart_id FK
        bigint product_id FK
        int quantity
        string variant_size
        string variant_color
        decimal variant_price
    }
    
    ORDERS {
        bigint id PK
        string order_number "unique"
        bigint user_id FK "kasir or member"
        bigint member_id FK "for kasir transactions"
        string shipping_method "kasir/si_kere/si_hemat/si_sultan"
        decimal shipping_cost
        enum payment_method
        enum payment_status
        decimal subtotal
        decimal discount_amount
        decimal voucher_discount
        decimal total
        enum status "pending/processing/shipped/delivered/cancelled"
        int points_awarded
        boolean is_verified
        string verification_code
        datetime shipped_at
    }
    
    ORDER_ITEMS {
        bigint id PK
        bigint order_id FK
        bigint product_id FK
        string product_title
        int quantity
        decimal price
        decimal final_price "after discount"
        json variant_info
    }
    
    VOUCHERS {
        bigint id PK
        string code "unique"
        string title
        enum type "percentage/fixed"
        decimal value
        decimal min_purchase
        int max_uses
        int used_count
        datetime valid_from
        datetime valid_until
        boolean is_active
    }
    
    USER_VOUCHERS {
        bigint id PK
        bigint user_id FK
        bigint voucher_id FK
        boolean is_used
        datetime used_at
    }
    
    REVIEWS {
        bigint id PK
        bigint user_id FK
        bigint product_id FK
        bigint order_item_id FK
        int rating "1-5"
        text comment
        text admin_reply
    }
    
    USER_POINTS {
        bigint id PK
        bigint user_id FK
        int points
        enum type "earned/spent"
        string description
    }
    
    DAILY_REWARDS {
        bigint id PK
        bigint user_id FK
        int current_day "1-7"
        int streak
        date last_claim_date
        datetime next_reset_at
    }
    
    REWARD_VOUCHERS {
        bigint id PK
        bigint voucher_id FK
        int required_points
        string title
        boolean is_active
    }
    
    ORDER_CANCELLATION_REQUESTS {
        bigint id PK
        bigint order_id FK
        string reason
        enum status "pending/approved/rejected"
        text admin_note
    }
```

---

## Penjelasan Singkat untuk Presentasi

### **1. USER MANAGEMENT**
- `users` → Pusat sistem (admin/kasir/member)
- Simpan data: nama, email, role, poin, foto

### **2. PRODUCT CATALOG**
- `categories` → Kelompok produk (Makanan, Minuman, dll)
- `products` → Detail produk (harga, diskon, stok, varian)
- Varian disimpan dalam format JSON (ukuran, warna, harga berbeda)

### **3. SHOPPING CART (Online)**
- `carts` → Keranjang per user
- `cart_items` → Item dalam keranjang (produk + jumlah + varian)

### **4. ORDERS & TRANSACTIONS**
- `orders` → Transaksi (kasir atau online)
  - **Kasir**: `user_id` = kasir, `member_id` = customer, `shipping_method` = kasir
  - **Online**: `user_id` = member, `shipping_method` = si_kere/si_hemat/si_sultan
- `order_items` → Detail produk yang dibeli
- `order_cancellation_requests` → Pengajuan pembatalan oleh customer

### **5. REWARDS & GAMIFICATION**
- `vouchers` → Kupon diskon (% atau nominal)
- `user_vouchers` → Voucher yang dimiliki member
- `reward_vouchers` → Voucher yang bisa ditukar dengan poin
- `daily_rewards` → Hadiah harian (streak 7 hari)
- `user_points` → Riwayat poin (dapat/pakai)

### **6. REVIEWS**
- `reviews` → Rating & komentar produk dari customer
- Admin bisa reply review

---

## Flow Bisnis Utama

### **A. TRANSAKSI KASIR (Offline POS)**
1. Kasir scan barcode → Tambah ke cart kasir
2. Customer bayar → Buat `orders` (status: paid & delivered)
3. Jika customer member → Catat di `member_id`, kasih poin
4. Update stok produk

### **B. TRANSAKSI ONLINE (E-Commerce)**
1. Member pilih produk → Tambah ke `cart_items`
2. Checkout → Pilih voucher, ongkir → Buat `orders`
3. Status flow: pending → processing → shipped → delivered
4. Setelah delivered → Member dapat poin & bisa review

### **C. REWARDS SYSTEM**
1. Member belanja → Dapat poin (5% dari total belanja)
2. Daily login → Klaim hadiah harian (poin/voucher)
3. Tukar poin → Redeem voucher di `reward_vouchers`
4. Pakai voucher → Diskon saat checkout

---

## Tips untuk Draw.io

1. **Copy** diagram Mermaid di atas
2. Buka https://mermaid.live
3. **Paste** kode Mermaid → Lihat preview
4. **Export** as PNG/SVG
5. **Import** ke Draw.io atau langsung pakai screenshot

Atau langsung paste ke Draw.io yang support Mermaid syntax!

---

## Tabel Penting vs Skip

### ✅ **PENTING (Tampilkan)**
- users, categories, products
- carts, cart_items
- orders, order_items
- vouchers, user_vouchers
- reviews, user_points

### ⏭️ **SKIP (Ga Perlu Presentasi)**
- cache, cache_locks
- failed_jobs, jobs, job_batches
- migrations, password_reset_tokens
- sessions
- banners, notifications, point_transactions

---

**Semoga membantu presentasi lo! 🚀**
