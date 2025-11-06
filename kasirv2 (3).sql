-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2025 at 03:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasirv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-10-23 17:49:32', '2025-10-23 17:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `variant_size` varchar(255) DEFAULT NULL,
  `variant_color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Makanan', 'makanan', NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(2, 'Minuman', 'minuman', NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(3, 'Perawatan', 'perawatan', NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(4, 'Ibu & Anak', 'ibu-anak', NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(5, 'Dapur', 'dapur', NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(7, 'Hololive', 'hololive', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2025-10-28 12:28:36', '2025-10-28 12:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_20_000001_create_categories_table', 1),
(5, '2025_10_20_000002_create_products_table', 1),
(6, '2025_10_20_000005_create_carts_table', 1),
(7, '2025_10_20_000006_create_cart_items_table', 1),
(8, '2025_10_20_000007_create_reviews_table', 1),
(9, '2025_10_23_002725_add_role_to_users_table', 1),
(10, '2025_10_23_035533_add_variants_to_products_table', 1),
(11, '2025_10_23_141742_create_orders_table', 1),
(12, '2025_10_23_141811_create_order_items_table', 1),
(13, '2025_10_23_141840_create_vouchers_table', 1),
(14, '2025_10_24_083142_create_order_cancellation_requests_table', 2),
(15, '2025_10_24_131743_add_order_item_and_reply_columns_to_reviews_table', 3),
(16, '2025_10_28_000001_add_description_to_categories_table', 4),
(17, '2025_10_28_210532_add_shipped_at_to_orders_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_province` varchar(255) NOT NULL,
  `shipping_postal_code` varchar(255) DEFAULT NULL,
  `shipping_method` varchar(255) NOT NULL,
  `shipping_method_name` varchar(255) NOT NULL,
  `shipping_cost` decimal(12,2) NOT NULL,
  `estimated_delivery` datetime NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `subtotal` decimal(12,2) NOT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL,
  `voucher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `voucher_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `shipped_at` datetime DEFAULT NULL,
  `terms_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `shipping_name`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_province`, `shipping_postal_code`, `shipping_method`, `shipping_method_name`, `shipping_cost`, `estimated_delivery`, `payment_method`, `payment_status`, `subtotal`, `discount_amount`, `total`, `voucher_id`, `voucher_discount`, `status`, `shipped_at`, `terms_accepted`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD-68FACD29CE2DB', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'crazy_rich', 'Crazy Rich', 27402.00, '2025-10-24 01:09:45', 'cod', 'pending', 137008.00, 0.00, 164410.00, NULL, 0.00, 'cancelled', NULL, 1, NULL, '2025-10-23 17:49:45', '2025-10-26 15:42:42'),
(2, 'ORD-68FAD30B0887C', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'crazy_rich', 'Crazy Rich', 57915.00, '2025-10-24 01:34:51', 'cod', 'paid', 289573.00, 0.00, 347488.00, NULL, 0.00, 'delivered', NULL, 1, NULL, '2025-10-23 18:14:51', '2025-10-24 07:36:36'),
(3, 'ORD-68FAD5E844481', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'si_sultan', 'Si Sultan', 12398.00, '2025-10-24 10:27:04', 'cod', 'paid', 123976.52, 0.00, 136374.52, NULL, 0.00, 'delivered', NULL, 1, NULL, '2025-10-24 01:27:04', '2025-10-24 07:55:24'),
(4, 'ORD-6900BE04EF3CC', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'si_kere', 'Si Kere', 7050.00, '2025-11-02 19:58:44', 'cod', 'pending', 705015.04, 0.00, 712065.04, NULL, 0.00, 'pending', NULL, 1, NULL, '2025-10-28 12:58:44', '2025-10-28 12:58:44'),
(5, 'ORD-6900BE7EDD8B5', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'si_kere', 'Si Kere', 1731.00, '2025-11-02 20:00:46', 'cod', 'pending', 173060.00, 0.00, 174791.00, NULL, 0.00, 'pending', NULL, 1, NULL, '2025-10-28 13:00:46', '2025-10-28 13:00:46'),
(6, 'ORD-6900BF427D464', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'crazy_rich', 'Crazy Rich', 16000.00, '2025-10-28 20:24:02', 'cod', 'pending', 80000.00, 0.00, 96000.00, NULL, 0.00, 'cancelled', NULL, 1, NULL, '2025-10-28 13:04:02', '2025-10-28 13:08:26'),
(7, 'ORD-6900CB57098D0', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'si_normal', 'Si Normal', 3200.00, '2025-10-30 20:55:35', 'cod', 'paid', 80000.00, 0.00, 83200.00, NULL, 0.00, 'delivered', NULL, 1, NULL, '2025-10-28 13:55:35', '2025-10-28 14:01:08'),
(8, 'ORD-6900CEBE1D16C', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'sahabat_kasir', 'Sahabat Kasir', 13339.00, '2025-10-29 21:10:06', 'cod', 'paid', 222314.00, 0.00, 235653.00, NULL, 0.00, 'delivered', NULL, 1, NULL, '2025-10-28 14:10:06', '2025-10-28 14:10:43'),
(9, 'ORD-6900CFD4B2F3D', 2, 'Member', '082122780082', 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', 'si_hemat', 'Si Hemat', 5491.00, '2025-10-31 21:14:44', 'cod', 'paid', 274556.00, 0.00, 280047.00, NULL, 0.00, 'delivered', '2025-10-28 21:15:22', 1, NULL, '2025-10-28 14:14:44', '2025-10-28 14:15:22');

-- --------------------------------------------------------

--
-- Table structure for table `order_cancellation_requests`
--

CREATE TABLE `order_cancellation_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `reason_detail` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_cancellation_requests`
--

INSERT INTO `order_cancellation_requests` (`id`, `order_id`, `user_id`, `reason`, `reason_detail`, `status`, `admin_note`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'change_payment', NULL, 'rejected', 'haha lawak', 3, '2025-10-24 01:47:28', '2025-10-24 01:46:34', '2025-10-24 01:47:28'),
(2, 1, 2, 'other', 'kelamaan', 'approved', 'oke diterima!', 3, '2025-10-24 01:49:00', '2025-10-24 01:48:38', '2025-10-24 01:49:00'),
(3, 6, 2, 'order_later', NULL, 'approved', 'sip', 3, '2025-10-28 13:08:26', '2025-10-28 13:07:48', '2025-10-28 13:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(12,2) NOT NULL,
  `product_discount` int(11) NOT NULL DEFAULT 0,
  `final_price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `variant_size` varchar(255) DEFAULT NULL,
  `variant_color` varchar(255) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `product_discount`, `final_price`, `quantity`, `variant_size`, `variant_color`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Makanan Produk 1', 137008.00, 0, 137008.00, 1, NULL, NULL, 137008.00, '2025-10-23 17:49:45', '2025-10-23 17:49:45'),
(2, 2, 32, 'Ibu & Anak Produk 8', 148531.00, 0, 148531.00, 1, NULL, NULL, 148531.00, '2025-10-23 18:14:51', '2025-10-23 18:14:51'),
(3, 2, 18, 'Perawatan Produk 2', 141042.00, 0, 141042.00, 1, NULL, NULL, 141042.00, '2025-10-23 18:14:51', '2025-10-23 18:14:51'),
(4, 3, 25, 'Ibu & Anak Produk 1', 163127.00, 24, 123976.52, 1, NULL, NULL, 123976.52, '2025-10-24 01:27:04', '2025-10-24 01:27:04'),
(5, 4, 25, 'Ibu & Anak Produk 1', 163127.00, 24, 123976.52, 2, NULL, NULL, 247953.04, '2025-10-28 12:58:45', '2025-10-28 12:58:45'),
(6, 4, 32, 'Ibu & Anak Produk 8', 148531.00, 0, 148531.00, 2, NULL, NULL, 297062.00, '2025-10-28 12:58:45', '2025-10-28 12:58:45'),
(7, 4, 41, 'laijsfgaeoij', 100000.00, 20, 80000.00, 2, 'L', NULL, 160000.00, '2025-10-28 12:58:45', '2025-10-28 12:58:45'),
(8, 5, 26, 'Ibu & Anak Produk 2', 93060.00, 0, 93060.00, 1, NULL, NULL, 93060.00, '2025-10-28 13:00:46', '2025-10-28 13:00:46'),
(9, 5, 41, 'laijsfgaeoij', 100000.00, 20, 80000.00, 1, 'M', NULL, 80000.00, '2025-10-28 13:00:46', '2025-10-28 13:00:46'),
(10, 6, 41, 'laijsfgaeoij', 100000.00, 20, 80000.00, 1, 'XL', NULL, 80000.00, '2025-10-28 13:04:02', '2025-10-28 13:04:02'),
(11, 7, 41, 'laijsfgaeoij', 100000.00, 20, 80000.00, 1, 'L', NULL, 80000.00, '2025-10-28 13:55:35', '2025-10-28 13:55:35'),
(12, 8, 10, 'Minuman Produk 2', 142314.00, 0, 142314.00, 1, NULL, NULL, 142314.00, '2025-10-28 14:10:06', '2025-10-28 14:10:06'),
(13, 8, 41, 'laijsfgaeoij', 100000.00, 20, 80000.00, 1, 'XL', NULL, 80000.00, '2025-10-28 14:10:06', '2025-10-28 14:10:06'),
(14, 9, 33, 'Dapur Produk 1', 194556.00, 0, 194556.00, 1, NULL, NULL, 194556.00, '2025-10-28 14:14:44', '2025-10-28 14:14:44'),
(15, 9, 41, 'laijsfgaeoij', 100000.00, 20, 80000.00, 1, 'M', NULL, 80000.00, '2025-10-28 14:14:44', '2025-10-28 14:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `discount` int(11) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`variants`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `title`, `slug`, `meta`, `description`, `price`, `stock`, `discount`, `brand`, `image`, `variants`, `created_at`, `updated_at`) VALUES
(1, 1, 'Makanan Produk 1', 'makanan-produk-1-68facc9379c69', 'Meta 1', 'Deskripsi 1', 137008.00, 93, NULL, 'Brand 1', NULL, NULL, '2025-10-23 17:47:15', '2025-10-24 01:49:00'),
(2, 1, 'Makanan Produk 2', 'makanan-produk-2-68facc937a99f', 'Meta 2', 'Deskripsi 2', 141996.00, 49, 11, 'Brand 2', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(3, 1, 'Makanan Produk 3', 'makanan-produk-3-68facc937b2a8', 'Meta 3', 'Deskripsi 3', 170124.00, 49, NULL, 'Brand 3', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(4, 1, 'Makanan Produk 4', 'makanan-produk-4-68facc937bdb3', 'Meta 4', 'Deskripsi 4', 172282.00, 20, NULL, 'Brand 4', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(5, 1, 'Makanan Produk 5', 'makanan-produk-5-68facc937c6ed', 'Meta 5', 'Deskripsi 5', 80728.00, 84, NULL, 'Brand 5', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(6, 1, 'Makanan Produk 6', 'makanan-produk-6-68facc937cf4f', 'Meta 6', 'Deskripsi 6', 154206.00, 80, NULL, 'Brand 6', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(7, 1, 'Makanan Produk 7', 'makanan-produk-7-68facc937d781', 'Meta 7', 'Deskripsi 7', 144640.00, 71, NULL, 'Brand 7', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(8, 1, 'Makanan Produk 8', 'makanan-produk-8-68facc937e00e', 'Meta 8', 'Deskripsi 8', 124275.00, 79, NULL, 'Brand 8', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(9, 2, 'Minuman Produk 1', 'minuman-produk-1-68facc937f180', 'Meta 1', 'Deskripsi 1', 135673.00, 74, NULL, 'Brand 1', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(10, 2, 'Minuman Produk 2', 'minuman-produk-2-68facc938075e', 'Meta 2', 'Deskripsi 2', 142314.00, 97, NULL, 'Brand 2', NULL, NULL, '2025-10-23 17:47:15', '2025-10-28 14:10:06'),
(11, 2, 'Minuman Produk 3', 'minuman-produk-3-68facc9381181', 'Meta 3', 'Deskripsi 3', 196302.00, 53, NULL, 'Brand 3', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(12, 2, 'Minuman Produk 4', 'minuman-produk-4-68facc93819ed', 'Meta 4', 'Deskripsi 4', 47349.00, 8, 26, 'Brand 4', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(13, 2, 'Minuman Produk 5', 'minuman-produk-5-68facc9382279', 'Meta 5', 'Deskripsi 5', 41288.00, 48, NULL, 'Brand 5', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(14, 2, 'Minuman Produk 6', 'minuman-produk-6-68facc9382add', 'Meta 6', 'Deskripsi 6', 196136.00, 78, NULL, 'Brand 6', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(15, 2, 'Minuman Produk 7', 'minuman-produk-7-68facc9383402', 'Meta 7', 'Deskripsi 7', 95232.00, 17, 21, 'Brand 7', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(16, 2, 'Minuman Produk 8', 'minuman-produk-8-68facc938400c', 'Meta 8', 'Deskripsi 8', 108009.00, 37, NULL, 'Brand 8', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(17, 3, 'Perawatan Produk 1', 'perawatan-produk-1-68facc93851d6', 'Meta 1', 'Deskripsi 1', 169450.00, 5, NULL, 'Brand 1', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(18, 3, 'Perawatan Produk 2', 'perawatan-produk-2-68facc9385a5b', 'Meta 2', 'Deskripsi 2', 141042.00, 14, NULL, 'Brand 2', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 18:14:51'),
(19, 3, 'Perawatan Produk 3', 'perawatan-produk-3-68facc9386342', 'Meta 3', 'Deskripsi 3', 84190.00, 4, NULL, 'Brand 3', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(20, 3, 'Perawatan Produk 4', 'perawatan-produk-4-68facc9386aa8', 'Meta 4', 'Deskripsi 4', 41192.00, 19, NULL, 'Brand 4', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(21, 3, 'Perawatan Produk 5', 'perawatan-produk-5-68facc9387400', 'Meta 5', 'Deskripsi 5', 74524.00, 18, NULL, 'Brand 5', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(22, 3, 'Perawatan Produk 6', 'perawatan-produk-6-68facc93880e7', 'Meta 6', 'Deskripsi 6', 87411.00, 42, NULL, 'Brand 6', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(23, 3, 'Perawatan Produk 7', 'perawatan-produk-7-68facc93888c3', 'Meta 7', 'Deskripsi 7', 62552.00, 6, NULL, 'Brand 7', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(24, 3, 'Perawatan Produk 8', 'perawatan-produk-8-68facc93890d3', 'Meta 8', 'Deskripsi 8', 38100.00, 74, NULL, 'Brand 8', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(25, 4, 'Ibu & Anak Produk 1', 'ibu-anak-produk-1-68facc938a11c', 'Meta 1', 'Deskripsi 1', 163127.00, 85, 24, 'Brand 1', NULL, NULL, '2025-10-23 17:47:15', '2025-10-28 12:58:45'),
(26, 4, 'Ibu & Anak Produk 2', 'ibu-anak-produk-2-68facc938a8e7', 'Meta 2', 'Deskripsi 2', 93060.00, 12, NULL, 'Brand 2', NULL, NULL, '2025-10-23 17:47:15', '2025-10-28 13:00:46'),
(27, 4, 'Ibu & Anak Produk 3', 'ibu-anak-produk-3-68facc938b04d', 'Meta 3', 'Deskripsi 3', 133014.00, 49, NULL, 'Brand 3', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(28, 4, 'Ibu & Anak Produk 4', 'ibu-anak-produk-4-68facc938ba4a', 'Meta 4', 'Deskripsi 4', 171810.00, 14, NULL, 'Brand 4', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(29, 4, 'Ibu & Anak Produk 5', 'ibu-anak-produk-5-68facc938c555', 'Meta 5', 'Deskripsi 5', 128314.00, 21, NULL, 'Brand 5', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(30, 4, 'Ibu & Anak Produk 6', 'ibu-anak-produk-6-68facc938d037', 'Meta 6', 'Deskripsi 6', 86440.00, 26, NULL, 'Brand 6', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(31, 4, 'Ibu & Anak Produk 7', 'ibu-anak-produk-7-68facc938d9ff', 'Meta 7', 'Deskripsi 7', 151828.00, 49, NULL, 'Brand 7', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(32, 4, 'Ibu & Anak Produk 8', 'ibu-anak-produk-8-68facc938e25a', 'Meta 8', 'Deskripsi 8', 148531.00, 32, NULL, 'Brand 8', NULL, NULL, '2025-10-23 17:47:15', '2025-10-28 12:58:45'),
(33, 5, 'Dapur Produk 1', 'dapur-produk-1-68facc938f02c', 'Meta 1', 'Deskripsi 1', 194556.00, 89, NULL, 'Brand 1', NULL, NULL, '2025-10-23 17:47:15', '2025-10-28 14:14:44'),
(34, 5, 'Dapur Produk 2', 'dapur-produk-2-68facc938f75e', 'Meta 2', 'Deskripsi 2', 166692.00, 68, NULL, 'Brand 2', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(35, 5, 'Dapur Produk 3', 'dapur-produk-3-68facc938fed1', 'Meta 3', 'Deskripsi 3', 182289.00, 6, NULL, 'Brand 3', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(36, 5, 'Dapur Produk 4', 'dapur-produk-4-68facc939061b', 'Meta 4', 'Deskripsi 4', 147950.00, 53, NULL, 'Brand 4', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(37, 5, 'Dapur Produk 5', 'dapur-produk-5-68facc9390d44', 'Meta 5', 'Deskripsi 5', 54054.00, 90, NULL, 'Brand 5', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(38, 5, 'Dapur Produk 6', 'dapur-produk-6-68facc93914c2', 'Meta 6', 'Deskripsi 6', 65207.00, 76, NULL, 'Brand 6', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(39, 5, 'Dapur Produk 7', 'dapur-produk-7-68facc9391c73', 'Meta 7', 'Deskripsi 7', 25317.00, 20, NULL, 'Brand 7', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(40, 5, 'Dapur Produk 8', 'dapur-produk-8-68facc9392378', 'Meta 8', 'Deskripsi 8', 181936.00, 7, NULL, 'Brand 8', NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(41, 5, 'laijsfgaeoij', 'laijsfgaeoij', 'fabeojbaeoifnao', 'naldfnaafo', 100000.00, 94, 20, 'khilfaeof', 'https://i.pinimg.com/1200x/66/a2/2a/66a22a046526239251dc35b689102b6f.jpg', '[{\"type\":\"Ukuran\",\"values\":[\"S\",\"M\",\"L\",\"XL\"]}]', '2025-10-24 02:10:02', '2025-10-28 14:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `review` text DEFAULT NULL,
  `admin_reply` text DEFAULT NULL,
  `replied_by` bigint(20) UNSIGNED DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `order_item_id`, `product_id`, `user_id`, `rating`, `review`, `admin_reply`, `replied_by`, `replied_at`, `created_at`, `updated_at`) VALUES
(1, 2, 32, 2, 5, 'mantap min', 'terimakasih', 3, '2025-10-26 15:39:31', '2025-10-24 06:31:13', '2025-10-26 15:39:31'),
(2, 3, 18, 2, 3, 'kurang', NULL, NULL, NULL, '2025-10-24 06:34:31', '2025-10-24 06:34:31'),
(4, 15, 41, 2, 5, 'oke juga sip mantap', 'terimakasih', 3, '2025-10-28 14:39:46', '2025-10-28 14:39:25', '2025-10-28 14:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bmEHopqs7XsX2E6tZFBVC6rmLzhEq0coM9LMysRu', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibWFiYm1tSDdxdHV5Q09hQ3EyNFJZS29tNnpqbXd1VnhZRXZpbU1xaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0L2xhaWpzZmdhZW9paiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo5OiJ1c2VyX3JvbGUiO3M6NToiYWRtaW4iO30=', 1761662679),
('dJ3taPRrc8FZxVYCFtxo8uxtusS4TpneO3hvlyEd', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT2xpc2s1NWxwc3dLV1RVbGFxVmdxWjBqZjlSckpTcENoWGk5OTB2ciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0L2xhaWpzZmdhZW9paiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czo5OiJ1c2VyX3JvbGUiO3M6NjoibWVtYmVyIjt9', 1761662658);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','kasir','member') NOT NULL DEFAULT 'member',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `phone`, `photo`, `gender`, `birth_date`, `address`, `city`, `province`, `postal_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Demo User', 'demo@example.com', 'member', NULL, '$2y$12$3Nt3Uq/IOsg6Ggm5zX2GouOXusd.spTfetlcRo2Hp05RLJOACJ0iu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 17:47:15', '2025-10-23 17:47:15'),
(2, 'Member', 'member@gmail.com', 'member', NULL, '$2y$12$kmCWs5.zz0novBnjEnkhM.G8iCXRZa/g8w6Je2v2y9iagRs2huQ0y', '082122780082', NULL, NULL, NULL, 'Jl. Monco Kerto Raya No.4A, RT.4/RW.11, Utan Kayu Sel., Kec. Matraman, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13120', 'Jakarta Timur', 'DKI Jakarta', '13120', NULL, '2025-10-23 17:49:00', '2025-10-26 16:53:41'),
(3, 'Admin', 'admin@gmail.com', 'admin', NULL, '$2y$12$ksXoVltebeGc12f/wq2C/uTFXu5PonBU0NzPLk9lgBkCI1635.mQq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 17:50:19', '2025-10-23 17:50:19'),
(4, 'Kasir', 'kasir@gmail.com', 'kasir', NULL, '$2y$12$OKDHn.xsaJSX0hL7EA23Rup/Undgcyin.s0QWD/bl0/grRvCGA5Jq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-24 06:10:36', '2025-10-24 06:10:36'),
(5, 'ujicoba1', 'ujicoba1@gmail.com', 'admin', NULL, '$2y$12$No2mnZZrNN3GCHtQK5yjJO54acHfFwE7gnLwha9oLm5V3s8.Uiil6', '082312891033', NULL, NULL, NULL, 'mantap', NULL, NULL, NULL, NULL, '2025-10-26 16:19:54', '2025-10-26 16:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('free_shipping') NOT NULL DEFAULT 'free_shipping',
  `shipping_method` varchar(255) NOT NULL,
  `shipping_method_name` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `used_at` datetime DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_cancellation_requests`
--
ALTER TABLE `order_cancellation_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_cancellation_requests_order_id_foreign` (`order_id`),
  ADD KEY `order_cancellation_requests_user_id_foreign` (`user_id`),
  ADD KEY `order_cancellation_requests_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_order_item_id_unique` (`order_item_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_replied_by_foreign` (`replied_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`),
  ADD KEY `vouchers_user_id_foreign` (`user_id`),
  ADD KEY `vouchers_order_id_foreign` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_cancellation_requests`
--
ALTER TABLE `order_cancellation_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_cancellation_requests`
--
ALTER TABLE `order_cancellation_requests`
  ADD CONSTRAINT `order_cancellation_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_cancellation_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_cancellation_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_replied_by_foreign` FOREIGN KEY (`replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `vouchers_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vouchers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
