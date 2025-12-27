# 🛒 Anashop - E-commerce & POS System

Modern web application combining **E-commerce Platform** and **Point of Sale (POS) System** in one integrated solution. Built with Laravel 11, featuring member loyalty programs, real-time customer displays, and comprehensive inventory management.

## ✨ Key Features

### 🏪 E-commerce Platform
- **Product Catalog** with categories, variants (size/color), and advanced search
- **Shopping Cart** with real-time price updates and variant selection
- **Member System** with points reward, daily check-in bonuses (5→25 points progression)
- **Order Tracking** with multiple payment methods (Cash, Transfer, E-Wallet)
- **Product Reviews** and ratings system
- **Responsive Design** optimized for mobile and desktop

### 💳 Point of Sale (POS)
- **Barcode Scanner** integration for fast product lookup
- **Dual Display** - Cashier terminal + Customer-facing display (sync via localStorage/API)
- **Variant Support** with individual pricing and barcode per variant
- **Member Verification** system with secure 4-digit code validation
- **Real-time Stock** validation and auto-refresh prices before checkout
- **Receipt Printing** with order details and points earned
- **Transaction History** with date filtering and export to Excel/PDF

### 👥 Multi-Role System
- **Admin** - Full control (products, users, reports, banners)
- **Cashier** - POS operations, order management, member registration
- **Member** - Shopping, points collection, reward redemption, order history

### 📊 Admin Dashboard
- **Sales Reports** with charts and analytics
- **Inventory Management** with stock alerts
- **User Management** with role-based access control
- **Banner Management** for home page and customer display
- **Export Reports** to Excel and PDF

### 🎁 Loyalty & Gamification
- **Daily Check-in Rewards** - Progressive points (5→7→9→12→16→20→25)
- **Points System** - Earn points from purchases, redeem for vouchers
- **Reward Vouchers** with expiration dates
- **Notification Center** for member verification and updates

## 🛠️ Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Blade Templates, Alpine.js, Tailwind CSS
- **Database:** MySQL
- **Real-time:** LocalStorage sync + Server-side polling
- **Export:** Maatwebsite Excel, DomPDF
- **Authentication:** Laravel Breeze

## 📦 Installation

```bash
# Clone repository
git clone https://github.com/LinggaKeandre/Aplikasi-E-commerce-Kasir.git
cd Aplikasi-E-commerce-Kasir

# Install dependencies
composer install
npm install && npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env file
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations and seeders
php artisan migrate --seed

# Create storage link
php artisan storage:link

# Serve application
php artisan serve
```

## 🔐 Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@anashop.com | password |
| Cashier | kasir@anashop.com | password |
| Member | member@anashop.com | password |

## 🚀 Unique Features

- **Hybrid Image Storage** - Upload local files OR use external URLs
- **Smart Variant System** - Different prices per variant with individual barcodes
- **Auto Price Refresh** - Validates prices before checkout to prevent discrepancies
- **Customer Display API** - Separate screen for customers to see cart in real-time
- **Progressive Daily Rewards** - Streak-based point system with auto-reset
- **Dual Payment Flow** - Member (with verification) or Guest checkout
- **Real-time Synchronization** - Cart updates across cashier and customer displays
- **Role-based Borders** - Visual distinction (Admin: gold crown, Kasir: blue briefcase)

## 🎯 Routes Overview

### Public Routes
- `/` - Product catalog (homepage)
- `/product/{slug}` - Product detail page
- `/cart` - Shopping cart
- `/checkout` - Checkout process

### Member Routes
- `/profile` - User profile management
- `/orders` - Order history
- `/points` - Points & rewards
- `/notifications` - Member notifications
- `/daily-rewards/claim` - Claim daily check-in

### Cashier Routes
- `/kasir/dashboard` - Cashier dashboard
- `/kasir/transaksi` - POS terminal
- `/kasir/customer-display` - Customer-facing display
- `/kasir/riwayat` - Transaction history
- `/kasir/pesanan` - Order management

### Admin Routes
- `/admin/dashboard` - Admin dashboard with analytics
- `/admin/products` - Product management (CRUD)
- `/admin/categories` - Category management
- `/admin/accounts` - User management
- `/admin/reports` - Sales reports & exports
- `/admin/banners` - Banner management

## 📱 Customer Display Setup

1. Open `/kasir/customer-display` on a separate device/screen
2. System will auto-sync cart data from cashier terminal
3. Display shows: Cart items, Total, Payment method, Transaction success animations

## 🔧 Configuration

### Environment Variables
```env
APP_NAME="Anashop"
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_DATABASE=kasir_v2

# Mail (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
```

### Storage Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 📸 Screenshots

- **Homepage**: Product catalog with banners and daily check-in
- **POS Terminal**: Barcode scanner interface with member verification
- **Customer Display**: Real-time cart synchronization
- **Admin Dashboard**: Sales analytics and inventory management

## 🤝 Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Developer

Developed by **Lingga Keandre** - Full-stack Developer

- GitHub: [@LinggaKeandre](https://github.com/LinggaKeandre)

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Alpine.js
- Maatwebsite Excel
- DomPDF

---

⭐ **Star this repo if you find it useful, Thank You!**

💡 **For issues or questions, please open an issue on GitHub**
