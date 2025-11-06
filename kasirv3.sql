-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2025 at 05:37 PM
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
-- Database: `kasirv3`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `position` enum('home','customer_display') NOT NULL DEFAULT 'home',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image_path`, `position`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(3, 'costumer display', 'banners/1761920965_k5lVijfZJT.png', 'customer_display', 1, 1, '2025-10-31 01:44:51', '2025-10-31 14:29:25'),
(4, 'katalog member', 'banners/1762185389_qvHbGZUnkk.jpg', 'home', 1, 2, '2025-10-31 01:45:12', '2025-11-03 15:56:29'),
(5, 'TESTER', 'banners/1762185408_qVx7BC57nd.jpg', 'home', 1, 3, '2025-10-31 02:04:43', '2025-11-03 15:56:48'),
(6, 'banner 2', 'banners/1761921113_w2FaiijMic.jpg', 'customer_display', 1, 4, '2025-10-31 14:21:54', '2025-10-31 14:31:53'),
(7, 'banner 3', 'banners/1761921421_ELEi2s93xs.jpg', 'customer_display', 1, 5, '2025-10-31 14:37:01', '2025-10-31 14:37:01');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-connected_devices_KS-1761915469486-dz0pnvw6q', 'a:1:{s:26:\"CD-1762258758441-v02es6mal\";s:25:\"2025-11-04T19:51:02+07:00\";}', 1762264262),
('laravel-cache-connected_devices_KS-1762008218625-e4679695a', 'a:1:{s:26:\"CD-1762185691517-48onalh5p\";s:25:\"2025-11-05T23:37:11+07:00\";}', 1762364231),
('laravel-cache-connected_devices_KS-1762074877560-b2rqgtu85', 'a:0:{}', 1762274832),
('laravel-cache-connected_devices_KS-1762260510791-sw93ell4m', 'a:2:{s:26:\"CD-1762260620213-bst0kt304\";s:25:\"2025-11-04T22:45:19+07:00\";s:26:\"CD-1762258758441-v02es6mal\";s:25:\"2025-11-04T21:32:41+07:00\";}', 1762274719),
('laravel-cache-connected_devices_KS-1762265645830-dwqu1xhty', 'a:0:{}', 1762269721),
('laravel-cache-customer_display_KS-1762008218625-e4679695a', 'a:5:{s:4:\"cart\";a:0:{}s:7:\"cashier\";a:2:{s:4:\"name\";s:12:\"lingga kasir\";s:5:\"photo\";s:89:\"http://127.0.0.1:8000/storage/profile-photos/5X2Rqmr1a4oearfHaWb1g8DWabnqn0jw6ksYpp0q.jpg\";}s:12:\"verification\";N;s:15:\"payment_success\";N;s:10:\"updated_at\";s:25:\"2025-11-05T23:35:10+07:00\";}', 1762364110),
('laravel-cache-customer_display_KS-1762074877560-b2rqgtu85', 'a:5:{s:4:\"cart\";a:0:{}s:7:\"cashier\";a:2:{s:4:\"name\";s:5:\"Kasir\";s:5:\"photo\";s:89:\"http://127.0.0.1:8000/storage/profile-photos/5X2Rqmr1a4oearfHaWb1g8DWabnqn0jw6ksYpp0q.jpg\";}s:12:\"verification\";N;s:15:\"payment_success\";N;s:10:\"updated_at\";s:25:\"2025-11-04T22:47:06+07:00\";}', 1762274826),
('laravel-cache-customer_display_KS-1762265645830-dwqu1xhty', 'a:5:{s:4:\"cart\";a:2:{i:0;a:9:{s:2:\"id\";i:47;s:4:\"name\";s:9:\"oantoiaen\";s:5:\"price\";d:4201451.5;s:3:\"qty\";i:2;s:5:\"stock\";i:96;s:9:\"uniqueKey\";s:21:\"47_varian:ojabeotgoet\";s:10:\"variantKey\";s:18:\"varian:ojabeotgoet\";s:11:\"variantInfo\";a:3:{s:4:\"type\";s:6:\"varian\";s:5:\"value\";s:11:\"ojabeotgoet\";s:5:\"price\";i:8402903;}s:11:\"displayName\";s:9:\"oantoiaen\";}i:1;a:7:{s:2:\"id\";i:2;s:4:\"name\";s:16:\"Makanan Produk 2\";s:5:\"price\";i:198532;s:3:\"qty\";i:3;s:5:\"stock\";i:5;s:9:\"uniqueKey\";i:2;s:11:\"displayName\";s:16:\"Makanan Produk 2\";}}s:7:\"cashier\";a:2:{s:4:\"name\";s:5:\"Kasir\";s:5:\"photo\";N;}s:12:\"verification\";N;s:15:\"payment_success\";N;s:10:\"updated_at\";s:25:\"2025-11-04T21:21:39+07:00\";}', 1762269699);

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
(1, 2, '2025-10-31 03:30:58', '2025-10-31 03:30:58');

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
  `variant_price` decimal(10,2) DEFAULT NULL,
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
(1, 'Makanan', 'makanan', NULL, '2025-10-30 01:21:03', '2025-10-30 01:21:03'),
(2, 'Minuman', 'minuman', NULL, '2025-10-30 01:21:03', '2025-10-30 01:21:03'),
(3, 'Perawatan', 'perawatan', NULL, '2025-10-30 01:21:03', '2025-10-30 01:21:03'),
(4, 'Ibu & Anak', 'ibu-anak', NULL, '2025-10-30 01:21:03', '2025-10-30 01:21:03'),
(5, 'Dapur', 'dapur', NULL, '2025-10-30 01:21:03', '2025-10-30 01:21:03'),
(7, 'Perkakas', 'perkakas', 'untuk perkakas rumahan.', '2025-11-05 15:32:39', '2025-11-05 15:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `daily_rewards`
--

CREATE TABLE `daily_rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `current_day` int(11) NOT NULL DEFAULT 1,
  `streak` int(11) NOT NULL DEFAULT 0,
  `last_claim_date` date DEFAULT NULL,
  `next_reset_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_rewards`
--

INSERT INTO `daily_rewards` (`id`, `user_id`, `current_day`, `streak`, `last_claim_date`, `next_reset_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, '2025-11-05', '2025-11-05 17:00:00', '2025-10-30 01:23:42', '2025-11-05 14:45:27'),
(2, 3, 1, 0, NULL, '2025-10-31 17:00:00', '2025-10-31 05:55:53', '2025-10-31 05:55:53'),
(3, 7, 2, 0, '2025-11-03', '2025-11-03 17:00:00', '2025-11-03 15:59:32', '2025-11-03 15:59:36'),
(4, 4, 1, 0, NULL, '2025-11-04 17:00:00', '2025-11-04 14:36:26', '2025-11-04 14:36:26');

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
(14, '2025_10_24_083142_create_order_cancellation_requests_table', 1),
(15, '2025_10_24_131743_add_order_item_and_reply_columns_to_reviews_table', 1),
(16, '2025_10_28_000001_add_description_to_categories_table', 1),
(17, '2025_10_28_210532_add_shipped_at_to_orders_table', 1),
(18, '2025_10_29_000001_create_banners_table', 1),
(19, '2025_10_29_000002_create_user_points_table', 1),
(20, '2025_10_29_000003_create_point_transactions_table', 1),
(21, '2025_10_29_000004_add_verification_to_orders_table', 1),
(22, '2025_10_29_000005_create_notifications_table', 1),
(23, '2025_10_29_000006_add_member_id_to_orders_table', 1),
(24, '2025_10_29_201310_change_points_awarded_to_integer_in_orders_table', 1),
(25, '2025_10_29_205559_create_reward_vouchers_table', 1),
(26, '2025_10_29_205600_create_user_vouchers_table', 1),
(27, '2025_10_29_221038_create_daily_rewards_table', 1),
(28, '2025_10_29_224049_add_free_shipping_to_orders_table', 1),
(29, '2025_10_30_081934_add_type_and_discount_to_reward_vouchers_table', 1),
(30, '2025_10_30_104327_add_barcode_to_products_table', 2),
(31, '2025_10_30_215721_add_customer_display_banner_to_banners_table', 3),
(32, '2025_11_01_220913_add_price_to_variants_in_products_table', 4),
(33, '2025_11_01_221500_add_variant_price_to_cart_items_table', 4),
(34, '2025_11_01_224643_add_variant_price_to_cart_items_table', 4),
(35, '2025_11_01_233823_add_variant_price_to_order_items_table', 5),
(36, '2025_11_02_004219_add_variant_data_to_order_items_table', 6),
(37, '2025_11_04_202900_remove_unique_constraint_from_barcode', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"27\",\"40\",\"65\"],\"correct_code\":\"65\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-30 15:03:56', '2025-10-30 15:03:43', '2025-10-30 15:03:56'),
(2, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"40\",\"03\",\"44\"],\"correct_code\":\"44\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-30 15:12:15', '2025-10-30 15:11:59', '2025-10-30 15:12:15'),
(3, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"89\",\"06\",\"47\"],\"correct_code\":\"47\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-30 15:14:26', '2025-10-30 15:14:15', '2025-10-30 15:14:26'),
(4, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"31\",\"63\",\"87\"],\"correct_code\":\"63\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-30 15:26:35', '2025-10-30 15:25:31', '2025-10-30 15:26:35'),
(5, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"53\",\"88\",\"32\"],\"correct_code\":\"88\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-30 15:30:27', '2025-10-30 15:30:21', '2025-10-30 15:30:27'),
(6, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"35\",\"75\",\"14\"],\"correct_code\":\"35\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-30 15:40:36', '2025-10-30 15:39:28', '2025-10-30 15:40:36'),
(7, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"54\",\"72\",\"95\"],\"correct_code\":\"54\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 12:38:28', '2025-10-31 12:38:09', '2025-10-31 12:38:28'),
(8, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"37\",\"89\",\"00\"],\"correct_code\":\"37\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:00:15', '2025-10-31 12:59:55', '2025-10-31 13:00:15'),
(9, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"28\",\"69\",\"68\"],\"correct_code\":\"28\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:09:00', '2025-10-31 13:02:17', '2025-10-31 13:09:00'),
(10, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"94\",\"30\",\"37\"],\"correct_code\":\"30\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:09:23', '2025-10-31 13:09:00', '2025-10-31 13:09:23'),
(11, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"53\",\"73\",\"98\"],\"correct_code\":\"73\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:09:45', '2025-10-31 13:09:32', '2025-10-31 13:09:45'),
(12, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"10\",\"23\",\"48\"],\"correct_code\":\"48\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:14:20', '2025-10-31 13:14:16', '2025-10-31 13:14:20'),
(13, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"12\",\"48\",\"67\"],\"correct_code\":\"48\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:14:24', '2025-10-31 13:14:20', '2025-10-31 13:14:24'),
(14, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"06\",\"11\",\"85\"],\"correct_code\":\"85\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:14:49', '2025-10-31 13:14:24', '2025-10-31 13:14:49'),
(15, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"16\",\"60\",\"35\"],\"correct_code\":\"16\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:15:31', '2025-10-31 13:15:22', '2025-10-31 13:15:31'),
(16, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"67\",\"64\",\"24\"],\"correct_code\":\"67\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:15:37', '2025-10-31 13:15:31', '2025-10-31 13:15:37'),
(17, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"89\",\"47\",\"04\"],\"correct_code\":\"89\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:15:49', '2025-10-31 13:15:37', '2025-10-31 13:15:49'),
(18, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"27\",\"71\",\"24\"],\"correct_code\":\"27\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:15:52', '2025-10-31 13:15:49', '2025-10-31 13:15:52'),
(19, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"45\",\"53\",\"48\"],\"correct_code\":\"53\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:15:54', '2025-10-31 13:15:52', '2025-10-31 13:15:54'),
(20, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"95\",\"30\",\"06\"],\"correct_code\":\"06\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:16:01', '2025-10-31 13:15:54', '2025-10-31 13:16:01'),
(21, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"70\",\"12\",\"24\"],\"correct_code\":\"24\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:37:28', '2025-10-31 13:35:00', '2025-10-31 13:37:28'),
(22, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"98\",\"70\",\"81\"],\"correct_code\":\"98\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:37:54', '2025-10-31 13:37:35', '2025-10-31 13:37:54'),
(23, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"52\",\"24\",\"63\"],\"correct_code\":\"63\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:38:00', '2025-10-31 13:37:54', '2025-10-31 13:38:00'),
(24, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"18\",\"26\",\"25\"],\"correct_code\":\"18\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:44:43', '2025-10-31 13:44:40', '2025-10-31 13:44:43'),
(25, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"00\",\"10\",\"52\"],\"correct_code\":\"10\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:45:03', '2025-10-31 13:44:43', '2025-10-31 13:45:03'),
(26, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"62\",\"91\",\"31\"],\"correct_code\":\"31\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:47:03', '2025-10-31 13:45:40', '2025-10-31 13:47:03'),
(27, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"66\",\"70\",\"48\"],\"correct_code\":\"70\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:47:27', '2025-10-31 13:47:03', '2025-10-31 13:47:27'),
(28, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"35\",\"10\",\"21\"],\"correct_code\":\"35\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:48:06', '2025-10-31 13:48:01', '2025-10-31 13:48:06'),
(29, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"62\",\"31\",\"82\"],\"correct_code\":\"82\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 13:52:37', '2025-10-31 13:50:23', '2025-10-31 13:52:37'),
(30, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"88\",\"80\",\"59\"],\"correct_code\":\"80\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 14:05:35', '2025-10-31 14:05:29', '2025-10-31 14:05:35'),
(31, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"67\",\"20\",\"11\"],\"correct_code\":\"67\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 14:06:06', '2025-10-31 14:06:01', '2025-10-31 14:06:06'),
(32, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"15\",\"65\",\"70\"],\"correct_code\":\"65\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 14:14:10', '2025-10-31 14:14:06', '2025-10-31 14:14:10'),
(33, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"61\",\"88\",\"67\"],\"correct_code\":\"67\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 14:26:27', '2025-10-31 14:26:16', '2025-10-31 14:26:27'),
(34, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"85\",\"94\",\"67\"],\"correct_code\":\"94\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 14:39:26', '2025-10-31 14:39:15', '2025-10-31 14:39:26'),
(35, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"91\",\"35\",\"17\"],\"correct_code\":\"91\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 14:40:41', '2025-10-31 14:40:36', '2025-10-31 14:40:41'),
(36, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"01\",\"25\",\"75\"],\"correct_code\":\"01\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 14:45:40', '2025-10-31 14:45:33', '2025-10-31 14:45:40'),
(37, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"03\",\"04\",\"83\"],\"correct_code\":\"03\",\"kasir_name\":\"Kasir\"}', 1, '2025-10-31 14:46:21', '2025-10-31 14:46:16', '2025-10-31 14:46:21'),
(38, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"46\",\"04\",\"13\"],\"correct_code\":\"04\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-01 17:45:42', '2025-11-01 17:45:30', '2025-11-01 17:45:42'),
(39, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"14\",\"36\",\"22\"],\"correct_code\":\"36\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-02 09:57:56', '2025-11-02 09:57:11', '2025-11-02 09:57:56'),
(40, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"41\",\"00\",\"09\"],\"correct_code\":\"09\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-02 10:00:59', '2025-11-02 10:00:54', '2025-11-02 10:00:59'),
(41, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"54\",\"72\",\"88\"],\"correct_code\":\"88\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-02 10:45:52', '2025-11-02 10:45:45', '2025-11-02 10:45:52'),
(42, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"06\",\"22\",\"28\"],\"correct_code\":\"22\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-02 10:46:01', '2025-11-02 10:45:57', '2025-11-02 10:46:01'),
(43, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"87\",\"18\",\"70\"],\"correct_code\":\"18\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-02 11:59:00', '2025-11-02 11:58:53', '2025-11-02 11:59:00'),
(44, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"50\",\"03\",\"89\"],\"correct_code\":\"89\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-03 16:02:08', '2025-11-03 16:01:22', '2025-11-03 16:02:08'),
(45, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"75\",\"72\",\"00\"],\"correct_code\":\"75\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-03 16:31:59', '2025-11-03 16:24:40', '2025-11-03 16:31:59'),
(46, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"59\",\"32\",\"49\"],\"correct_code\":\"59\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-03 16:32:09', '2025-11-03 16:31:59', '2025-11-03 16:32:09'),
(47, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"70\",\"49\",\"45\"],\"correct_code\":\"49\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 12:57:25', '2025-11-04 12:56:48', '2025-11-04 12:57:25'),
(48, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"14\",\"10\",\"53\"],\"correct_code\":\"53\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 13:01:44', '2025-11-04 13:01:21', '2025-11-04 13:01:44'),
(49, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"08\",\"11\",\"70\"],\"correct_code\":\"70\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 14:20:18', '2025-11-04 14:19:53', '2025-11-04 14:20:18'),
(50, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"55\",\"58\",\"89\"],\"correct_code\":\"55\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 14:27:31', '2025-11-04 14:20:18', '2025-11-04 14:27:31'),
(51, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"64\",\"58\",\"19\"],\"correct_code\":\"58\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 14:27:50', '2025-11-04 14:27:31', '2025-11-04 14:27:50'),
(52, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"85\",\"71\",\"02\"],\"correct_code\":\"85\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 14:38:30', '2025-11-04 14:38:20', '2025-11-04 14:38:30'),
(53, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"05\",\"82\",\"60\"],\"correct_code\":\"05\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 15:29:55', '2025-11-04 15:29:42', '2025-11-04 15:29:55'),
(54, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"94\",\"70\",\"21\"],\"correct_code\":\"70\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 15:30:39', '2025-11-04 15:30:29', '2025-11-04 15:30:39'),
(55, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"55\",\"04\",\"95\"],\"correct_code\":\"55\",\"kasir_name\":\"Kasir\"}', 1, '2025-11-04 15:33:26', '2025-11-04 15:33:18', '2025-11-04 15:33:26'),
(56, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"00\",\"67\",\"05\"],\"correct_code\":\"00\",\"kasir_name\":\"lingga kasir\"}', 1, '2025-11-05 16:20:13', '2025-11-05 16:20:09', '2025-11-05 16:20:13'),
(57, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"86\",\"05\",\"28\"],\"correct_code\":\"05\",\"kasir_name\":\"lingga kasir\"}', 1, '2025-11-05 16:20:20', '2025-11-05 16:20:13', '2025-11-05 16:20:20'),
(58, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"86\",\"26\",\"00\"],\"correct_code\":\"26\",\"kasir_name\":\"lingga kasir\"}', 1, '2025-11-05 16:20:40', '2025-11-05 16:20:20', '2025-11-05 16:20:40'),
(59, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"41\",\"50\",\"92\"],\"correct_code\":\"41\",\"kasir_name\":\"lingga kasir\"}', 1, '2025-11-05 16:21:49', '2025-11-05 16:21:38', '2025-11-05 16:21:49'),
(60, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"17\",\"44\",\"21\"],\"correct_code\":\"44\",\"kasir_name\":\"lingga kasir\"}', 1, '2025-11-05 16:22:41', '2025-11-05 16:22:35', '2025-11-05 16:22:41'),
(61, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"66\",\"37\",\"15\"],\"correct_code\":\"66\",\"kasir_name\":\"lingga kasir\"}', 1, '2025-11-05 16:27:23', '2025-11-05 16:27:11', '2025-11-05 16:27:23'),
(62, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"81\",\"64\",\"47\"],\"correct_code\":\"47\",\"kasir_name\":\"lingga kasir\"}', 1, '2025-11-05 16:30:58', '2025-11-05 16:30:51', '2025-11-05 16:30:58'),
(63, 2, 'verification_request', 'Verifikasi Transaksi', 'Pilih kode verifikasi yang disebutkan kasir', '{\"codes\":[\"98\",\"44\",\"29\"],\"correct_code\":\"44\",\"kasir_name\":\"lingga kasir\"}', 1, '2025-11-05 16:34:50', '2025-11-05 16:34:44', '2025-11-05 16:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  `free_shipping` tinyint(1) NOT NULL DEFAULT 0,
  `voucher_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `verification_code` varchar(2) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `points_awarded` int(11) DEFAULT NULL,
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

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `member_id`, `shipping_name`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_province`, `shipping_postal_code`, `shipping_method`, `shipping_method_name`, `shipping_cost`, `estimated_delivery`, `payment_method`, `payment_status`, `subtotal`, `discount_amount`, `total`, `voucher_id`, `free_shipping`, `voucher_discount`, `verification_code`, `is_verified`, `points_awarded`, `status`, `shipped_at`, `terms_accepted`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'KSR-20251030-0001', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-30 10:55:07', 'cash', 'paid', 166186.00, 0.00, 166186.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-30 03:55:07', '2025-10-30 03:55:07'),
(2, 'KSR-20251030-0002', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-30 22:03:28', 'cash', 'paid', 176532.00, 0.00, 176532.00, NULL, 0, 0.00, '65', 1, 176, 'delivered', NULL, 1, NULL, '2025-10-30 15:03:28', '2025-10-30 15:03:56'),
(3, 'KSR-20251030-0003', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-30 22:11:30', 'cash', 'paid', 242520.80, 0.00, 242520.80, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-30 15:11:30', '2025-10-30 15:11:30'),
(4, 'KSR-20251030-0004', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-30 22:11:52', 'cash', 'paid', 168018.00, 0.00, 168018.00, NULL, 0, 0.00, '44', 1, 168, 'delivered', NULL, 1, NULL, '2025-10-30 15:11:52', '2025-10-30 15:12:15'),
(5, 'KSR-20251030-0005', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-30 22:14:09', 'cash', 'paid', 24054.00, 0.00, 24054.00, NULL, 0, 0.00, '47', 1, 24, 'delivered', NULL, 1, NULL, '2025-10-30 15:14:09', '2025-10-30 15:14:26'),
(6, 'KSR-20251030-0006', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-30 22:25:22', 'cash', 'paid', 24054.00, 0.00, 24054.00, NULL, 0, 0.00, '63', 1, 24, 'delivered', NULL, 1, NULL, '2025-10-30 15:25:22', '2025-10-30 15:26:35'),
(7, 'KSR-20251030-0007', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-30 22:30:14', 'cash', 'paid', 198532.00, 0.00, 198532.00, NULL, 0, 0.00, '88', 1, 198, 'delivered', NULL, 1, NULL, '2025-10-30 15:30:14', '2025-10-30 15:30:27'),
(8, 'KSR-20251030-0008', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-30 22:39:20', 'cash', 'paid', 24054.00, 0.00, 24054.00, NULL, 0, 0.00, '35', 1, 24, 'delivered', NULL, 1, NULL, '2025-10-30 15:39:20', '2025-10-30 15:40:36'),
(9, 'ORD-6904344DB30A0', 2, NULL, 'Member', '09088928320', 'afnianpernaepr', 'awnobipar', 'ianwirpn', '129032', 'crazy_rich', 'Crazy Rich', 39706.00, '2025-10-31 11:20:13', 'cod', 'paid', 198532.00, 0.00, 238238.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', '2025-10-31 11:00:45', 1, NULL, '2025-10-31 04:00:13', '2025-10-31 04:00:45'),
(10, 'ORD-690434CBAA2E8', 2, NULL, 'Member', '09088928320', 'afnianpernaepr', 'awnobipar', 'ianwirpn', '129032', 'crazy_rich', 'Crazy Rich', 12079.00, '2025-10-31 11:22:19', 'cod', 'pending', 60393.00, 0.00, 72472.00, NULL, 0, 0.00, NULL, 0, NULL, 'cancelled', NULL, 1, NULL, '2025-10-31 04:02:19', '2025-10-31 04:03:17'),
(11, 'ORD-690439BEA6918', 2, NULL, 'Member', '09088928320', 'jhhuoh\'ihiphiphspeiojoe', 'awnobipar', 'ianwirpn', '129032', 'crazy_rich', 'Crazy Rich', 6766.00, '2025-10-31 11:43:26', 'cod', 'pending', 33828.00, 0.00, 40594.00, NULL, 0, 0.00, NULL, 0, NULL, 'cancelled', NULL, 1, NULL, '2025-10-31 04:23:26', '2025-10-31 04:26:43'),
(12, 'ORD-69043A20D0CCC', 2, NULL, 'Member', '09088928320', 'afnianpernaepr', 'awnobipar', 'ianwirpn', '129032', 'crazy_rich', 'Crazy Rich', 20811.00, '2025-10-31 11:45:04', 'cod', 'paid', 104057.00, 0.00, 124868.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', '2025-10-31 11:26:03', 1, NULL, '2025-10-31 04:25:04', '2025-10-31 04:26:03'),
(13, 'ORD-6904592ACD66F', 2, NULL, 'Member', '09088928320', 'jhhuoh\'ihiphiphspeiojoe', 'awnobipar', 'ianwirpn', '129032', 'crazy_rich', 'Crazy Rich', 4811.00, '2025-10-31 13:57:30', 'cod', 'paid', 24054.00, 0.00, 28865.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', '2025-11-02 20:22:38', 1, NULL, '2025-10-31 06:37:30', '2025-11-02 13:22:38'),
(14, 'ORD-6904AC8B31EEA', 2, NULL, 'Member', '0821783112', 'ishfouafobaefaeu', 'aubfoaebfa', 'ouabfubeoarfe', '182013', 'crazy_rich', 'Crazy Rich', 0.00, '2025-10-31 19:53:15', 'cod', 'pending', 176169.00, 0.00, 176169.00, 1, 1, 0.00, NULL, 0, NULL, 'cancelled', NULL, 1, NULL, '2025-10-31 12:33:15', '2025-10-31 12:34:13'),
(15, 'KSR-20251031-0007', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 19:38:03', 'cash', 'paid', 1985320.00, 0.00, 1985320.00, NULL, 0, 0.00, '54', 1, 1985, 'delivered', NULL, 1, NULL, '2025-10-31 12:38:03', '2025-10-31 12:38:28'),
(16, 'ORD-6904AE2631D94', 2, NULL, 'Member', '0821783112', '09usejpsejgopsrj', 'iaeifgbaeipg', 'aenbfobaeipgb', 'aiebfaebog', 'crazy_rich', 'Crazy Rich', 0.00, '2025-10-31 20:00:06', 'cod', 'pending', 59992.00, 0.00, 59992.00, 2, 1, 0.00, NULL, 0, NULL, 'cancelled', NULL, 1, NULL, '2025-10-31 12:40:06', '2025-10-31 12:41:05'),
(17, 'KSR-20251031-0009', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 19:59:50', 'cash', 'paid', 24054.00, 0.00, 24054.00, NULL, 0, 0.00, '37', 1, 24, 'delivered', NULL, 1, NULL, '2025-10-31 12:59:50', '2025-10-31 13:00:15'),
(18, 'KSR-20251031-0010', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:02:08', 'cash', 'paid', 276403.00, 0.00, 276403.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 13:02:08', '2025-10-31 13:02:08'),
(19, 'KSR-20251031-0011', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:03:54', 'cash', 'paid', 276403.00, 0.00, 276403.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 13:03:54', '2025-10-31 13:03:54'),
(20, 'KSR-20251031-0012', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:08:53', 'cash', 'paid', 230467.50, 0.00, 230467.50, NULL, 0, 0.00, '73', 1, 230, 'delivered', NULL, 1, NULL, '2025-10-31 13:08:53', '2025-10-31 13:09:45'),
(21, 'KSR-20251031-0013', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:14:10', 'cash', 'paid', 200586.00, 0.00, 200586.00, NULL, 0, 0.00, '85', 1, 200, 'delivered', NULL, 1, NULL, '2025-10-31 13:14:10', '2025-10-31 13:14:49'),
(22, 'KSR-20251031-0014', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:15:16', 'cash', 'paid', 24054.00, 0.00, 24054.00, NULL, 0, 0.00, '06', 1, 24, 'delivered', NULL, 1, NULL, '2025-10-31 13:15:16', '2025-10-31 13:16:01'),
(23, 'KSR-20251031-0015', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:34:51', 'cash', 'paid', 348688.00, 0.00, 348688.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 13:34:51', '2025-10-31 13:34:51'),
(24, 'KSR-20251031-0016', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:37:49', 'cash', 'paid', 186566.00, 0.00, 186566.00, NULL, 0, 0.00, '63', 1, 186, 'delivered', NULL, 1, NULL, '2025-10-31 13:37:49', '2025-10-31 13:38:00'),
(25, 'KSR-20251031-0017', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:44:34', 'cash', 'paid', 222586.00, 0.00, 222586.00, NULL, 0, 0.00, '10', 1, 222, 'delivered', NULL, 1, NULL, '2025-10-31 13:44:34', '2025-10-31 13:45:03'),
(26, 'KSR-20251031-0018', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:45:32', 'cash', 'paid', 24054.00, 0.00, 24054.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 13:45:32', '2025-10-31 13:45:32'),
(27, 'KSR-20251031-0019', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:46:54', 'cash', 'paid', 262831.00, 0.00, 262831.00, NULL, 0, 0.00, '70', 1, 262, 'delivered', NULL, 1, NULL, '2025-10-31 13:46:54', '2025-10-31 13:47:27'),
(28, 'KSR-20251031-0020', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:47:50', 'cash', 'paid', 128111.00, 0.00, 128111.00, NULL, 0, 0.00, '35', 1, 128, 'delivered', NULL, 1, NULL, '2025-10-31 13:47:50', '2025-10-31 13:48:07'),
(29, 'KSR-20251031-0021', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 20:50:17', 'cash', 'paid', 72475.00, 0.00, 72475.00, NULL, 0, 0.00, '82', 1, 72, 'delivered', NULL, 1, NULL, '2025-10-31 13:50:17', '2025-10-31 13:52:38'),
(30, 'KSR-20251031-0022', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:05:15', 'cash', 'paid', 200586.00, 0.00, 200586.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:05:15', '2025-10-31 14:05:15'),
(31, 'KSR-20251031-0023', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:05:22', 'cash', 'paid', 251725.00, 0.00, 251725.00, NULL, 0, 0.00, '80', 1, 251, 'delivered', NULL, 1, NULL, '2025-10-31 14:05:22', '2025-10-31 14:05:35'),
(32, 'KSR-20251031-0024', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:05:57', 'cash', 'paid', 270243.00, 0.00, 270243.00, NULL, 0, 0.00, '67', 1, 270, 'delivered', NULL, 1, NULL, '2025-10-31 14:05:57', '2025-10-31 14:06:06'),
(33, 'KSR-20251031-0025', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:12:26', 'cash', 'paid', 176532.00, 0.00, 176532.00, NULL, 0, 0.00, '65', 1, 176, 'delivered', NULL, 1, NULL, '2025-10-31 14:12:26', '2025-10-31 14:14:10'),
(34, 'KSR-20251031-0026', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:25:41', 'cash', 'paid', 222586.00, 0.00, 222586.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:25:41', '2025-10-31 14:25:41'),
(35, 'KSR-20251031-0027', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:26:01', 'cash', 'paid', 128111.00, 0.00, 128111.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:26:01', '2025-10-31 14:26:01'),
(36, 'KSR-20251031-0028', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:26:11', 'cash', 'paid', 304643.00, 0.00, 304643.00, NULL, 0, 0.00, '67', 1, 304, 'delivered', NULL, 1, NULL, '2025-10-31 14:26:11', '2025-10-31 14:26:27'),
(37, 'KSR-20251031-0029', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:37:31', 'cash', 'paid', 273725.00, 0.00, 273725.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:37:31', '2025-10-31 14:37:31'),
(38, 'KSR-20251031-0030', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:37:38', 'cash', 'paid', 273725.00, 0.00, 273725.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:37:38', '2025-10-31 14:37:38'),
(39, 'KSR-20251031-0031', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:37:55', 'cash', 'paid', 195414.00, 0.00, 195414.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:37:55', '2025-10-31 14:37:55'),
(40, 'KSR-20251031-0032', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:38:19', 'cash', 'paid', 147668.00, 0.00, 147668.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:38:19', '2025-10-31 14:38:19'),
(41, 'KSR-20251031-0033', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:39:08', 'cash', 'paid', 147668.00, 0.00, 147668.00, NULL, 0, 0.00, '94', 1, 147, 'delivered', NULL, 1, NULL, '2025-10-31 14:39:08', '2025-10-31 14:39:26'),
(42, 'KSR-20251031-0034', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:39:52', 'cash', 'paid', 140932.00, 0.00, 140932.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:39:52', '2025-10-31 14:39:52'),
(43, 'KSR-20251031-0035', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:40:31', 'cash', 'paid', 158267.00, 0.00, 158267.00, NULL, 0, 0.00, '91', 1, 158, 'delivered', NULL, 1, NULL, '2025-10-31 14:40:31', '2025-10-31 14:40:41'),
(44, 'KSR-20251031-0036', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:44:39', 'cash', 'paid', 176169.00, 0.00, 176169.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:44:39', '2025-10-31 14:44:39'),
(45, 'KSR-20251031-0037', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:44:47', 'cash', 'paid', 58903.00, 0.00, 58903.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:44:47', '2025-10-31 14:44:47'),
(46, 'KSR-20251031-0038', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:45:27', 'cash', 'paid', 222586.00, 0.00, 222586.00, NULL, 0, 0.00, '01', 1, 222, 'delivered', NULL, 1, NULL, '2025-10-31 14:45:27', '2025-10-31 14:45:40'),
(47, 'KSR-20251031-0039', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:46:11', 'cash', 'paid', 104057.00, 0.00, 104057.00, NULL, 0, 0.00, '03', 1, 104, 'delivered', NULL, 1, NULL, '2025-10-31 14:46:11', '2025-10-31 14:46:22'),
(48, 'KSR-20251031-0040', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-10-31 21:56:15', 'cash', 'paid', 198532.00, 0.00, 198532.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-10-31 14:56:15', '2025-10-31 14:56:15'),
(49, 'ORD-6906360BE9B2C', 2, NULL, 'Member', '0821783112', 'afapefnpaiengae', 'jnoangae', 'joaejgnae', 'ajeganegae', 'crazy_rich', 'Crazy Rich', 0.00, '2025-11-01 23:52:11', 'cod', 'pending', 30000.00, 0.00, 30000.00, 2, 1, 0.00, NULL, 0, NULL, 'cancelled', NULL, 1, NULL, '2025-11-01 16:32:11', '2025-11-02 12:57:49'),
(50, 'ORD-69063CFA68EBD', 2, NULL, 'Member', '082122780082', 'aeofbaeifgbaeipgnpoaetn', 'onaonfipae', 'naegtnipae', '19832', 'crazy_rich', 'Crazy Rich', 0.00, '2025-11-02 00:21:46', 'cod', 'pending', 819293.00, 0.00, 819293.00, 3, 1, 0.00, NULL, 0, NULL, 'pending', NULL, 1, NULL, '2025-11-01 17:01:46', '2025-11-01 17:01:46'),
(51, 'KSR-20251102-0002', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 00:36:07', 'cash', 'paid', 60000.00, 0.00, 60000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-01 17:36:07', '2025-11-01 17:36:07'),
(52, 'KSR-20251102-0003', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 00:38:12', 'cash', 'paid', 54054.00, 0.00, 54054.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-01 17:38:12', '2025-11-01 17:38:12'),
(53, 'KSR-20251102-0004', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 00:38:37', 'cash', 'paid', 302589.00, 0.00, 302589.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-01 17:38:37', '2025-11-01 17:38:37'),
(54, 'KSR-20251102-0005', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 00:45:22', 'cash', 'paid', 519293.00, 0.00, 519293.00, NULL, 0, 0.00, '04', 1, 519, 'delivered', NULL, 1, NULL, '2025-11-01 17:45:22', '2025-11-01 17:45:42'),
(55, 'KSR-20251102-0006', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 01:14:34', 'cash', 'paid', 128111.00, 0.00, 128111.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-01 18:14:34', '2025-11-01 18:14:34'),
(56, 'KSR-20251102-0007', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 01:22:02', 'cash', 'paid', 300000.00, 0.00, 300000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-01 18:22:02', '2025-11-01 18:22:02'),
(57, 'KSR-20251102-0008', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:15:04', 'cash', 'paid', 198532.00, 0.00, 198532.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:15:04', '2025-11-02 09:15:04'),
(58, 'KSR-20251102-0009', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:21:00', 'cash', 'paid', 60393.00, 0.00, 60393.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:21:00', '2025-11-02 09:21:00'),
(59, 'KSR-20251102-0010', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:25:07', 'cash', 'paid', 93711.00, 0.00, 93711.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:25:07', '2025-11-02 09:25:07'),
(60, 'KSR-20251102-0011', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:32:34', 'cash', 'paid', 316297.00, 0.00, 316297.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:32:34', '2025-11-02 09:32:34'),
(61, 'KSR-20251102-0012', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:37:08', 'cash', 'paid', 36000.00, 0.00, 36000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:37:08', '2025-11-02 09:37:08'),
(62, 'KSR-20251102-0013', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:41:29', 'cash', 'paid', 36000.00, 0.00, 36000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:41:29', '2025-11-02 09:41:29'),
(63, 'KSR-20251102-0014', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:42:08', 'cash', 'paid', 36000.00, 0.00, 36000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:42:08', '2025-11-02 09:42:08'),
(64, 'KSR-20251102-0015', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:45:31', 'cash', 'paid', 36000.00, 0.00, 36000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:45:31', '2025-11-02 09:45:31'),
(65, 'KSR-20251102-0016', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:49:06', 'cash', 'paid', 36000.00, 0.00, 36000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 09:49:06', '2025-11-02 09:49:06'),
(66, 'KSR-20251102-0017', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 16:57:03', 'cash', 'paid', 36000.00, 0.00, 36000.00, NULL, 0, 0.00, '36', 1, 36, 'delivered', NULL, 1, NULL, '2025-11-02 09:57:03', '2025-11-02 09:57:56'),
(67, 'KSR-20251102-0018', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 17:00:34', 'cash', 'paid', 2000.00, 0.00, 2000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 10:00:34', '2025-11-02 10:00:34'),
(68, 'KSR-20251102-0019', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 17:00:47', 'cash', 'paid', 2000.00, 0.00, 2000.00, NULL, 0, 0.00, '09', 1, 2, 'delivered', NULL, 1, NULL, '2025-11-02 10:00:47', '2025-11-02 10:01:00'),
(69, 'KSR-20251102-0020', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 17:45:39', 'cash', 'paid', 7000.00, 0.00, 7000.00, NULL, 0, 0.00, '22', 1, 7, 'delivered', NULL, 1, NULL, '2025-11-02 10:45:39', '2025-11-02 10:46:01'),
(70, 'KSR-20251102-0021', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 18:02:56', 'cash', 'paid', 4000.00, 0.00, 4000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 11:02:56', '2025-11-02 11:02:56'),
(71, 'KSR-20251102-0022', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 18:03:11', 'cash', 'paid', 109963.00, 0.00, 109963.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-02 11:03:11', '2025-11-02 11:03:11'),
(72, 'KSR-20251102-0023', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-02 18:58:47', 'cash', 'paid', 308000.00, 0.00, 308000.00, NULL, 0, 0.00, '18', 1, 308, 'delivered', NULL, 1, NULL, '2025-11-02 11:58:47', '2025-11-02 11:59:00'),
(73, 'ORD-690761BD92FFC', 2, NULL, 'Member', '082122780082', 'aeofbaeifgbaeipgnpoaetn', 'onaonfipae', 'naegtnipae', '19832', 'si_kere', 'Si Kere', 0.00, '2025-11-07 20:50:53', 'cod', 'pending', 324054.00, 0.00, 324054.00, 4, 1, 0.00, NULL, 0, NULL, 'pending', NULL, 1, NULL, '2025-11-02 13:50:53', '2025-11-02 13:50:53'),
(74, 'ORD-6908BC4B8BFE8', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 43859.00, '2025-11-03 21:49:31', 'cod', 'paid', 219293.00, 0.00, 263152.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', '2025-11-03 21:33:21', 1, NULL, '2025-11-03 14:29:31', '2025-11-03 14:33:21'),
(75, 'ORD-6908BFAB7F6CC', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 0.00, '2025-11-03 22:03:55', 'cod', 'pending', 749363.70, 0.00, 749363.70, 2, 1, 0.00, NULL, 0, NULL, 'cancelled', NULL, 1, NULL, '2025-11-03 14:43:55', '2025-11-03 14:45:02'),
(76, 'ORD-6908C1E967904', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 0.00, '2025-11-03 22:13:29', 'cod', 'paid', 540000.00, 0.00, 540000.00, 2, 1, 0.00, NULL, 0, NULL, 'delivered', '2025-11-03 22:55:05', 1, NULL, '2025-11-03 14:53:29', '2025-11-03 15:55:05'),
(77, 'ORD-6908C42E4E2C1', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 0.00, '2025-11-03 22:23:10', 'cod', 'pending', 21600000.00, 0.00, 21600000.00, 5, 1, 0.00, NULL, 0, NULL, 'cancelled', NULL, 1, NULL, '2025-11-03 15:03:10', '2025-11-03 15:04:47'),
(78, 'ORD-6908C898ADB3F', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 0.00, '2025-11-03 22:42:00', 'cod', 'paid', 270000.00, 0.00, 270000.00, 5, 1, 0.00, NULL, 0, NULL, 'delivered', '2025-11-03 22:22:30', 1, NULL, '2025-11-03 15:22:00', '2025-11-03 15:22:30'),
(79, 'KSR-20251103-0006', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:01:16', 'cash', 'paid', 15268031.00, 0.00, 15268031.00, NULL, 0, 0.00, '89', 1, 15268, 'delivered', NULL, 1, NULL, '2025-11-03 16:01:16', '2025-11-03 16:02:08'),
(80, 'KSR-20251103-0007', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:07:51', 'cash', 'paid', 300000.00, 0.00, 300000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-03 16:07:51', '2025-11-03 16:07:51'),
(81, 'KSR-20251103-0008', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:17:24', 'cash', 'paid', 300000.00, 0.00, 300000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-03 16:17:24', '2025-11-03 16:17:24'),
(82, 'KSR-20251103-0009', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:19:15', 'cash', 'paid', 75193.00, 0.00, 75193.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-03 16:19:15', '2025-11-03 16:19:15'),
(83, 'ORD-6908D61D58B15', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 39706.00, '2025-11-03 23:39:41', 'cod', 'paid', 198532.00, 0.00, 238238.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', '2025-11-03 23:19:59', 1, NULL, '2025-11-03 16:19:41', '2025-11-03 16:19:59'),
(84, 'KSR-20251103-0011', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:24:35', 'cash', 'paid', 198532.00, 0.00, 198532.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-03 16:24:35', '2025-11-03 16:24:35'),
(85, 'KSR-20251103-0012', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:24:56', 'cash', 'paid', 198532.00, 0.00, 198532.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-03 16:24:56', '2025-11-03 16:24:56'),
(86, 'KSR-20251103-0013', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:25:07', 'cash', 'paid', 188114.00, 0.00, 188114.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-03 16:25:07', '2025-11-03 16:25:07'),
(87, 'KSR-20251103-0014', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:26:51', 'cash', 'paid', 143909.00, 0.00, 143909.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-03 16:26:51', '2025-11-03 16:26:51'),
(88, 'KSR-20251103-0015', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-03 23:31:55', 'cash', 'paid', 75193.00, 0.00, 75193.00, NULL, 0, 0.00, '59', 1, 75, 'delivered', NULL, 1, NULL, '2025-11-03 16:31:55', '2025-11-03 16:32:09'),
(89, 'KSR-20251104-0001', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 19:56:41', 'cash', 'paid', 3061695.60, 0.00, 3061695.60, NULL, 0, 0.00, '49', 1, 3061, 'delivered', NULL, 1, NULL, '2025-11-04 12:56:41', '2025-11-04 12:57:25'),
(90, 'KSR-20251104-0002', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 20:00:28', 'cash', 'paid', 219293.00, 0.00, 219293.00, NULL, 0, 0.00, '53', 1, 219, 'delivered', NULL, 1, NULL, '2025-11-04 13:00:28', '2025-11-04 13:01:44'),
(91, 'KSR-20251104-0003', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 20:03:13', 'cash', 'paid', 13993823.00, 0.00, 13993823.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-04 13:03:13', '2025-11-04 13:03:13'),
(92, 'ORD-690A025351B49', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 0.00, '2025-11-04 21:00:35', 'cod', 'paid', 9000.00, 0.00, 9000.00, 6, 1, 0.00, NULL, 0, NULL, 'delivered', '2025-11-04 20:41:37', 1, NULL, '2025-11-04 13:40:35', '2025-11-04 13:41:37'),
(93, 'KSR-20251104-0005', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 20:44:40', 'cash', 'paid', 1001000.00, 0.00, 1001000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-04 13:44:40', '2025-11-04 13:44:40'),
(94, 'KSR-20251104-0006', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 21:19:46', 'cash', 'paid', 8402903.00, 0.00, 8402903.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-04 14:19:46', '2025-11-04 14:19:46'),
(95, 'KSR-20251104-0007', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 21:20:12', 'cash', 'paid', 8402903.00, 0.00, 8402903.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-04 14:20:12', '2025-11-04 14:20:12'),
(96, 'KSR-20251104-0008', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 21:27:23', 'cash', 'paid', 8468370.00, 0.00, 8468370.00, NULL, 0, 0.00, '58', 1, 8468, 'delivered', NULL, 1, NULL, '2025-11-04 14:27:23', '2025-11-04 14:27:50'),
(97, 'KSR-20251104-0009', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 21:38:14', 'cash', 'paid', 4201451.50, 0.00, 4201451.50, NULL, 0, 0.00, '85', 1, 4201, 'delivered', NULL, 1, NULL, '2025-11-04 14:38:14', '2025-11-04 14:38:30'),
(98, 'KSR-20251104-0010', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 22:26:36', 'cash', 'paid', 70000.00, 0.00, 70000.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-04 15:26:36', '2025-11-04 15:26:36'),
(99, 'KSR-20251104-0011', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 22:29:35', 'cash', 'paid', 350000.00, 0.00, 350000.00, NULL, 0, 0.00, '05', 1, 350, 'delivered', NULL, 1, NULL, '2025-11-04 15:29:35', '2025-11-04 15:29:55'),
(100, 'KSR-20251104-0012', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 22:30:23', 'cash', 'paid', 198532.00, 0.00, 198532.00, NULL, 0, 0.00, '70', 1, 198, 'delivered', NULL, 1, NULL, '2025-11-04 15:30:23', '2025-11-04 15:30:39'),
(101, 'KSR-20251104-0013', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-04 22:33:12', 'cash', 'paid', 19800.00, 0.00, 19800.00, NULL, 0, 0.00, '55', 1, 19, 'delivered', NULL, 1, NULL, '2025-11-04 15:33:12', '2025-11-04 15:33:26'),
(102, 'ORD-690B6693A8DB4', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 859033.00, '2025-11-05 22:20:35', 'cod', 'pending', 4295162.50, 0.00, 5154195.50, NULL, 0, 0.00, NULL, 0, NULL, 'pending', NULL, 1, NULL, '2025-11-05 15:00:35', '2025-11-05 15:00:35'),
(103, 'KSR-20251105-0002', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 22:27:08', 'cash', 'paid', 3600.00, 0.00, 3600.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-05 15:27:08', '2025-11-05 15:27:08'),
(104, 'ORD-690B6D546D717', 2, NULL, 'Member', '082122780082', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', 'crazy_rich', 'Crazy Rich', 0.00, '2025-11-05 22:49:24', 'cod', 'paid', 365575.00, 0.00, 365575.00, 7, 1, 0.00, NULL, 0, NULL, 'delivered', '2025-11-05 22:29:47', 1, NULL, '2025-11-05 15:29:24', '2025-11-05 15:29:47'),
(105, 'KSR-20251105-0004', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:19:59', 'cash', 'paid', 156868.00, 0.00, 156868.00, NULL, 0, 0.00, '26', 1, 156, 'delivered', NULL, 1, NULL, '2025-11-05 16:19:59', '2025-11-05 16:20:40'),
(106, 'KSR-20251105-0005', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:21:32', 'cash', 'paid', 24000.00, 0.00, 24000.00, NULL, 0, 0.00, '41', 1, 24, 'delivered', NULL, 1, NULL, '2025-11-05 16:21:32', '2025-11-05 16:21:49'),
(107, 'KSR-20251105-0006', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:22:27', 'cash', 'paid', 123871.00, 0.00, 123871.00, NULL, 0, 0.00, '44', 1, 123, 'delivered', NULL, 1, NULL, '2025-11-05 16:22:27', '2025-11-05 16:22:41'),
(108, 'KSR-20251105-0007', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:23:32', 'cash', 'paid', 140932.00, 0.00, 140932.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-05 16:23:32', '2025-11-05 16:23:32'),
(109, 'KSR-20251105-0008', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:23:35', 'cash', 'paid', 140932.00, 0.00, 140932.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-05 16:23:35', '2025-11-05 16:23:35'),
(110, 'KSR-20251105-0009', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:24:12', 'cash', 'paid', 17335.00, 0.00, 17335.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-05 16:24:12', '2025-11-05 16:24:12'),
(111, 'KSR-20251105-0010', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:24:21', 'cash', 'paid', 17335.00, 0.00, 17335.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-05 16:24:21', '2025-11-05 16:24:21'),
(112, 'KSR-20251105-0011', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:27:04', 'cash', 'paid', 24054.00, 0.00, 24054.00, NULL, 0, 0.00, '66', 1, 24, 'delivered', NULL, 1, NULL, '2025-11-05 16:27:04', '2025-11-05 16:27:23'),
(113, 'KSR-20251105-0012', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:30:46', 'cash', 'paid', 99871.00, 0.00, 99871.00, NULL, 0, 0.00, '47', 1, 99, 'delivered', NULL, 1, NULL, '2025-11-05 16:30:46', '2025-11-05 16:30:58'),
(114, 'KSR-20251105-0013', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:34:22', 'cash', 'paid', 12300.00, 0.00, 12300.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-05 16:34:22', '2025-11-05 16:34:22'),
(115, 'KSR-20251105-0014', 4, NULL, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:34:39', 'cash', 'paid', 23400.00, 0.00, 23400.00, NULL, 0, 0.00, NULL, 0, NULL, 'delivered', NULL, 1, NULL, '2025-11-05 16:34:39', '2025-11-05 16:34:39'),
(116, 'KSR-20251105-0015', 4, 2, 'Walk-in Customer', '-', 'Toko', '-', '-', NULL, 'kasir', 'Langsung (Kasir)', 0.00, '2025-11-05 23:34:42', 'cash', 'paid', 23400.00, 0.00, 23400.00, NULL, 0, 0.00, '44', 1, 23, 'delivered', NULL, 1, NULL, '2025-11-05 16:34:42', '2025-11-05 16:34:50');

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
(1, 10, 2, 'duplicate_order', NULL, 'approved', 'oke', 3, '2025-10-31 04:03:17', '2025-10-31 04:02:26', '2025-10-31 04:03:17'),
(2, 11, 2, 'change_order', NULL, 'approved', 'mantap', 3, '2025-10-31 04:26:43', '2025-10-31 04:23:39', '2025-10-31 04:26:43'),
(3, 13, 2, 'wrong_product', NULL, 'rejected', 'tidak', 3, '2025-11-02 13:21:37', '2025-10-31 06:37:37', '2025-11-02 13:21:37'),
(4, 14, 2, 'wrong_product', NULL, 'approved', 'oke', 3, '2025-10-31 12:34:13', '2025-10-31 12:33:35', '2025-10-31 12:34:13'),
(5, 16, 2, 'wrong_product', NULL, 'approved', 'eko', 3, '2025-10-31 12:41:05', '2025-10-31 12:40:26', '2025-10-31 12:41:05'),
(6, 49, 2, 'wrong_product', NULL, 'approved', 'ok', 3, '2025-11-02 12:57:49', '2025-11-01 16:33:31', '2025-11-02 12:57:49'),
(7, 50, 2, 'wrong_product', NULL, 'pending', NULL, NULL, NULL, '2025-11-02 13:23:05', '2025-11-02 13:23:05'),
(8, 74, 2, 'other', 'jelek', 'rejected', 'lawak', 3, '2025-11-03 14:32:08', '2025-11-03 14:31:18', '2025-11-03 14:32:08');

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
  `variant_price` decimal(12,2) DEFAULT NULL,
  `variant_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`variant_data`)),
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `product_discount`, `final_price`, `quantity`, `variant_size`, `variant_color`, `variant_price`, `variant_data`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Makanan Produk 1', 93711.00, 0, 93711.00, 1, NULL, NULL, NULL, NULL, 93711.00, '2025-10-30 03:55:07', '2025-10-30 03:55:07'),
(2, 1, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-30 03:55:07', '2025-10-30 03:55:07'),
(3, 2, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-30 15:03:28', '2025-10-30 15:03:28'),
(4, 2, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-30 15:03:28', '2025-10-30 15:03:28'),
(5, 3, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-30 15:11:30', '2025-10-30 15:11:30'),
(6, 3, 16, 'Minuman Produk 8', 57880.00, 24, 43988.80, 1, NULL, NULL, NULL, NULL, 43988.80, '2025-10-30 15:11:30', '2025-10-30 15:11:30'),
(7, 4, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-30 15:11:52', '2025-10-30 15:11:52'),
(8, 4, 9, 'Minuman Produk 1', 95543.00, 0, 95543.00, 1, NULL, NULL, NULL, NULL, 95543.00, '2025-10-30 15:11:52', '2025-10-30 15:11:52'),
(9, 5, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-30 15:14:09', '2025-10-30 15:14:09'),
(10, 6, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-30 15:25:22', '2025-10-30 15:25:22'),
(11, 7, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-30 15:30:14', '2025-10-30 15:30:14'),
(12, 8, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-30 15:39:20', '2025-10-30 15:39:20'),
(13, 9, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-31 04:00:13', '2025-10-31 04:00:13'),
(14, 10, 7, 'Makanan Produk 7', 60393.00, 0, 60393.00, 1, NULL, NULL, NULL, NULL, 60393.00, '2025-10-31 04:02:19', '2025-10-31 04:02:19'),
(15, 11, 26, 'Ibu & Anak Produk 2', 33828.00, 0, 33828.00, 1, NULL, NULL, NULL, NULL, 33828.00, '2025-10-31 04:23:26', '2025-10-31 04:23:26'),
(16, 12, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 04:25:04', '2025-10-31 04:25:04'),
(17, 13, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 06:37:30', '2025-10-31 06:37:30'),
(18, 14, 10, 'Minuman Produk 2', 176169.00, 0, 176169.00, 1, NULL, NULL, NULL, NULL, 176169.00, '2025-10-31 12:33:15', '2025-10-31 12:33:15'),
(19, 15, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 10, NULL, NULL, NULL, NULL, 1985320.00, '2025-10-31 12:38:03', '2025-10-31 12:38:03'),
(20, 16, 18, 'Perawatan Produk 2', 59992.00, 0, 59992.00, 1, NULL, NULL, NULL, NULL, 59992.00, '2025-10-31 12:40:06', '2025-10-31 12:40:06'),
(21, 17, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 12:59:50', '2025-10-31 12:59:50'),
(22, 18, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 13:02:08', '2025-10-31 13:02:08'),
(23, 18, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 13:02:08', '2025-10-31 13:02:08'),
(24, 18, 8, 'Makanan Produk 8', 99871.00, 0, 99871.00, 1, NULL, NULL, NULL, NULL, 99871.00, '2025-10-31 13:02:08', '2025-10-31 13:02:08'),
(25, 19, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 13:03:54', '2025-10-31 13:03:54'),
(26, 19, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 13:03:54', '2025-10-31 13:03:54'),
(27, 19, 8, 'Makanan Produk 8', 99871.00, 0, 99871.00, 1, NULL, NULL, NULL, NULL, 99871.00, '2025-10-31 13:03:54', '2025-10-31 13:03:54'),
(28, 20, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 13:08:53', '2025-10-31 13:08:53'),
(29, 20, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-31 13:08:53', '2025-10-31 13:08:53'),
(30, 20, 24, 'Perawatan Produk 8', 15763.00, 50, 7881.50, 1, NULL, NULL, NULL, NULL, 7881.50, '2025-10-31 13:08:53', '2025-10-31 13:08:53'),
(31, 21, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 13:14:10', '2025-10-31 13:14:10'),
(32, 21, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 13:14:10', '2025-10-31 13:14:10'),
(33, 21, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 13:14:10', '2025-10-31 13:14:10'),
(34, 22, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 13:15:16', '2025-10-31 13:15:16'),
(35, 23, 9, 'Minuman Produk 1', 95543.00, 0, 95543.00, 1, NULL, NULL, NULL, NULL, 95543.00, '2025-10-31 13:34:51', '2025-10-31 13:34:51'),
(36, 23, 11, 'Minuman Produk 3', 76976.00, 0, 76976.00, 1, NULL, NULL, NULL, NULL, 76976.00, '2025-10-31 13:34:51', '2025-10-31 13:34:51'),
(37, 23, 10, 'Minuman Produk 2', 176169.00, 0, 176169.00, 1, NULL, NULL, NULL, NULL, 176169.00, '2025-10-31 13:34:51', '2025-10-31 13:34:51'),
(38, 24, 15, 'Minuman Produk 7', 126574.00, 0, 126574.00, 1, NULL, NULL, NULL, NULL, 126574.00, '2025-10-31 13:37:49', '2025-10-31 13:37:49'),
(39, 24, 18, 'Perawatan Produk 2', 59992.00, 0, 59992.00, 1, NULL, NULL, NULL, NULL, 59992.00, '2025-10-31 13:37:49', '2025-10-31 13:37:49'),
(40, 25, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 13:44:34', '2025-10-31 13:44:34'),
(41, 25, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-31 13:44:34', '2025-10-31 13:44:34'),
(42, 26, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 13:45:32', '2025-10-31 13:45:32'),
(43, 27, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 13:46:54', '2025-10-31 13:46:54'),
(44, 27, 8, 'Makanan Produk 8', 99871.00, 0, 99871.00, 1, NULL, NULL, NULL, NULL, 99871.00, '2025-10-31 13:46:54', '2025-10-31 13:46:54'),
(45, 27, 13, 'Minuman Produk 5', 58903.00, 0, 58903.00, 1, NULL, NULL, NULL, NULL, 58903.00, '2025-10-31 13:46:54', '2025-10-31 13:46:54'),
(46, 28, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 13:47:50', '2025-10-31 13:47:50'),
(47, 28, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 13:47:50', '2025-10-31 13:47:50'),
(48, 29, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 13:50:17', '2025-10-31 13:50:17'),
(49, 30, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 14:05:15', '2025-10-31 14:05:15'),
(50, 30, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 14:05:15', '2025-10-31 14:05:15'),
(51, 30, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 14:05:15', '2025-10-31 14:05:15'),
(52, 31, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 14:05:22', '2025-10-31 14:05:22'),
(53, 31, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 14:05:22', '2025-10-31 14:05:22'),
(54, 31, 4, 'Makanan Produk 4', 75193.00, 0, 75193.00, 1, NULL, NULL, NULL, NULL, 75193.00, '2025-10-31 14:05:22', '2025-10-31 14:05:22'),
(55, 32, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 14:05:57', '2025-10-31 14:05:57'),
(56, 32, 1, 'Makanan Produk 1', 93711.00, 0, 93711.00, 1, NULL, NULL, NULL, NULL, 93711.00, '2025-10-31 14:05:57', '2025-10-31 14:05:57'),
(57, 32, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 14:05:57', '2025-10-31 14:05:57'),
(58, 33, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 14:12:26', '2025-10-31 14:12:26'),
(59, 33, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 14:12:26', '2025-10-31 14:12:26'),
(60, 34, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-31 14:25:41', '2025-10-31 14:25:41'),
(61, 34, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 14:25:41', '2025-10-31 14:25:41'),
(62, 35, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 14:26:01', '2025-10-31 14:26:01'),
(63, 35, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 14:26:01', '2025-10-31 14:26:01'),
(64, 36, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 14:26:11', '2025-10-31 14:26:11'),
(65, 36, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 2, NULL, NULL, NULL, NULL, 208114.00, '2025-10-31 14:26:11', '2025-10-31 14:26:11'),
(66, 36, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 14:26:11', '2025-10-31 14:26:11'),
(67, 37, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-31 14:37:31', '2025-10-31 14:37:31'),
(68, 37, 4, 'Makanan Produk 4', 75193.00, 0, 75193.00, 1, NULL, NULL, NULL, NULL, 75193.00, '2025-10-31 14:37:31', '2025-10-31 14:37:31'),
(69, 38, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-31 14:37:38', '2025-10-31 14:37:38'),
(70, 38, 4, 'Makanan Produk 4', 75193.00, 0, 75193.00, 1, NULL, NULL, NULL, NULL, 75193.00, '2025-10-31 14:37:38', '2025-10-31 14:37:38'),
(71, 39, 9, 'Minuman Produk 1', 95543.00, 0, 95543.00, 1, NULL, NULL, NULL, NULL, 95543.00, '2025-10-31 14:37:55', '2025-10-31 14:37:55'),
(72, 39, 8, 'Makanan Produk 8', 99871.00, 0, 99871.00, 1, NULL, NULL, NULL, NULL, 99871.00, '2025-10-31 14:37:55', '2025-10-31 14:37:55'),
(73, 40, 4, 'Makanan Produk 4', 75193.00, 0, 75193.00, 1, NULL, NULL, NULL, NULL, 75193.00, '2025-10-31 14:38:19', '2025-10-31 14:38:19'),
(74, 40, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 14:38:19', '2025-10-31 14:38:19'),
(75, 41, 4, 'Makanan Produk 4', 75193.00, 0, 75193.00, 1, NULL, NULL, NULL, NULL, 75193.00, '2025-10-31 14:39:08', '2025-10-31 14:39:08'),
(76, 41, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-10-31 14:39:08', '2025-10-31 14:39:08'),
(77, 42, 12, 'Minuman Produk 4', 140932.00, 0, 140932.00, 1, NULL, NULL, NULL, NULL, 140932.00, '2025-10-31 14:39:52', '2025-10-31 14:39:52'),
(78, 43, 12, 'Minuman Produk 4', 140932.00, 0, 140932.00, 1, NULL, NULL, NULL, NULL, 140932.00, '2025-10-31 14:40:31', '2025-10-31 14:40:31'),
(79, 43, 14, 'Minuman Produk 6', 17335.00, 0, 17335.00, 1, NULL, NULL, NULL, NULL, 17335.00, '2025-10-31 14:40:31', '2025-10-31 14:40:31'),
(80, 44, 10, 'Minuman Produk 2', 176169.00, 0, 176169.00, 1, NULL, NULL, NULL, NULL, 176169.00, '2025-10-31 14:44:39', '2025-10-31 14:44:39'),
(81, 45, 13, 'Minuman Produk 5', 58903.00, 0, 58903.00, 1, NULL, NULL, NULL, NULL, 58903.00, '2025-10-31 14:44:47', '2025-10-31 14:44:47'),
(82, 46, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-10-31 14:45:27', '2025-10-31 14:45:27'),
(83, 46, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-31 14:45:27', '2025-10-31 14:45:27'),
(84, 47, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-10-31 14:46:11', '2025-10-31 14:46:11'),
(85, 48, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-10-31 14:56:16', '2025-10-31 14:56:16'),
(86, 49, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, 'oyw8rth9-w', NULL, NULL, NULL, 30000.00, '2025-11-01 16:32:12', '2025-11-01 16:32:12'),
(87, 50, 43, 'Watsons Cream Bath', 30000.00, 0, 300000.00, 2, '8aehrahgahg', NULL, 300000.00, NULL, 600000.00, '2025-11-01 17:01:46', '2025-11-01 17:01:46'),
(88, 50, 43, 'Watsons Cream Bath', 30000.00, 0, 219293.00, 1, 'naonfinapfna', NULL, 219293.00, NULL, 219293.00, '2025-11-01 17:01:46', '2025-11-01 17:01:46'),
(89, 51, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-01 17:36:07', '2025-11-01 17:36:07'),
(90, 51, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-01 17:36:07', '2025-11-01 17:36:07'),
(91, 52, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-01 17:38:12', '2025-11-01 17:38:12'),
(92, 52, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-11-01 17:38:12', '2025-11-01 17:38:12'),
(93, 53, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-11-01 17:38:37', '2025-11-01 17:38:37'),
(94, 53, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-11-01 17:38:37', '2025-11-01 17:38:37'),
(95, 54, 43, 'Watsons Cream Bath', 30000.00, 0, 300000.00, 1, NULL, NULL, 300000.00, '\"{\\\"type\\\":\\\"fioionaiofna\\\",\\\"value\\\":\\\"8aehrahgahg\\\"}\"', 300000.00, '2025-11-01 17:45:22', '2025-11-01 17:45:22'),
(96, 54, 43, 'Watsons Cream Bath', 30000.00, 0, 219293.00, 1, NULL, NULL, 219293.00, '\"{\\\"type\\\":\\\"fioionaiofna\\\",\\\"value\\\":\\\"naonfinapfna\\\"}\"', 219293.00, '2025-11-01 17:45:22', '2025-11-01 17:45:22'),
(97, 55, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-11-01 18:14:34', '2025-11-01 18:14:34'),
(98, 55, 6, 'Makanan Produk 6', 104057.00, 0, 104057.00, 1, NULL, NULL, NULL, NULL, 104057.00, '2025-11-01 18:14:34', '2025-11-01 18:14:34'),
(99, 56, 43, 'Watsons Cream Bath', 30000.00, 0, 300000.00, 1, NULL, NULL, 300000.00, '\"{\\\"type\\\":\\\"fioionaiofna\\\",\\\"value\\\":\\\"8aehrahgahg\\\"}\"', 300000.00, '2025-11-01 18:22:02', '2025-11-01 18:22:02'),
(100, 57, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-11-02 09:15:04', '2025-11-02 09:15:04'),
(101, 58, 7, 'Makanan Produk 7', 60393.00, 0, 60393.00, 1, NULL, NULL, NULL, NULL, 60393.00, '2025-11-02 09:21:00', '2025-11-02 09:21:00'),
(102, 59, 1, 'Makanan Produk 1', 93711.00, 0, 93711.00, 1, NULL, NULL, NULL, NULL, 93711.00, '2025-11-02 09:25:07', '2025-11-02 09:25:07'),
(103, 60, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-11-02 09:32:34', '2025-11-02 09:32:34'),
(104, 60, 1, 'Makanan Produk 1', 93711.00, 0, 93711.00, 1, NULL, NULL, NULL, NULL, 93711.00, '2025-11-02 09:32:34', '2025-11-02 09:32:34'),
(105, 60, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-11-02 09:32:34', '2025-11-02 09:32:34'),
(107, 61, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-02 09:37:08', '2025-11-02 09:37:08'),
(108, 61, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 1, NULL, NULL, NULL, NULL, 4000.00, '2025-11-02 09:37:08', '2025-11-02 09:37:08'),
(110, 62, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-02 09:41:29', '2025-11-02 09:41:29'),
(111, 62, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 1, NULL, NULL, NULL, NULL, 4000.00, '2025-11-02 09:41:29', '2025-11-02 09:41:29'),
(113, 63, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-02 09:42:08', '2025-11-02 09:42:08'),
(114, 63, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 1, NULL, NULL, NULL, NULL, 4000.00, '2025-11-02 09:42:08', '2025-11-02 09:42:08'),
(116, 64, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-02 09:45:31', '2025-11-02 09:45:31'),
(117, 64, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 1, NULL, NULL, NULL, NULL, 4000.00, '2025-11-02 09:45:31', '2025-11-02 09:45:31'),
(119, 65, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-02 09:49:06', '2025-11-02 09:49:06'),
(120, 65, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 1, NULL, NULL, NULL, NULL, 4000.00, '2025-11-02 09:49:06', '2025-11-02 09:49:06'),
(121, 66, 43, 'Watsons Cream Bath', 30000.00, 0, 30000.00, 1, NULL, NULL, NULL, NULL, 30000.00, '2025-11-02 09:57:03', '2025-11-02 09:57:03'),
(122, 66, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 1, NULL, NULL, NULL, NULL, 4000.00, '2025-11-02 09:57:03', '2025-11-02 09:57:03'),
(126, 69, 45, 'Oasis Botol', 0.00, 0, 2000.00, 1, NULL, NULL, 2000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"600mL\\\"}\"', 2000.00, '2025-11-02 10:45:39', '2025-11-02 10:45:39'),
(127, 69, 45, 'Oasis Botol', 0.00, 0, 1000.00, 1, NULL, NULL, 1000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"250mL\\\"}\"', 1000.00, '2025-11-02 10:45:39', '2025-11-02 10:45:39'),
(128, 69, 45, 'Oasis Botol', 0.00, 0, 4000.00, 1, NULL, NULL, 4000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"1500mL\\\"}\"', 4000.00, '2025-11-02 10:45:39', '2025-11-02 10:45:39'),
(129, 70, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 1, NULL, NULL, 4000.00, '\"{\\\"type\\\":\\\"ooiosrgis\\\",\\\"value\\\":\\\"aejaeeitpjh[aeo\\\"}\"', 4000.00, '2025-11-02 11:02:56', '2025-11-02 11:02:56'),
(130, 71, 40, 'Dapur Produk 8', 109963.00, 0, 109963.00, 1, NULL, NULL, NULL, NULL, 109963.00, '2025-11-02 11:03:11', '2025-11-02 11:03:11'),
(131, 72, 43, 'Watsons Cream Bath', 30000.00, 0, 300000.00, 1, NULL, NULL, 300000.00, '\"{\\\"type\\\":\\\"fioionaiofna\\\",\\\"value\\\":\\\"8aehrahgahg\\\"}\"', 300000.00, '2025-11-02 11:58:47', '2025-11-02 11:58:47'),
(132, 72, 45, 'Oasis Botol', 0.00, 0, 4000.00, 1, NULL, NULL, 4000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"1500mL\\\"}\"', 4000.00, '2025-11-02 11:58:47', '2025-11-02 11:58:47'),
(133, 72, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 1, NULL, NULL, 4000.00, '\"{\\\"type\\\":\\\"ooiosrgis\\\",\\\"value\\\":\\\"aeojtaee[tja[0\\\"}\"', 4000.00, '2025-11-02 11:58:47', '2025-11-02 11:58:47'),
(134, 73, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-11-02 13:50:53', '2025-11-02 13:50:53'),
(135, 73, 43, 'Watsons Cream Bath', 30000.00, 0, 300000.00, 1, '8aehrahgahg', NULL, 300000.00, NULL, 300000.00, '2025-11-02 13:50:53', '2025-11-02 13:50:53'),
(136, 74, 43, 'Watsons Cream Bath', 30000.00, 0, 219293.00, 1, 'naonfinapfna', NULL, 219293.00, NULL, 219293.00, '2025-11-03 14:29:31', '2025-11-03 14:29:31'),
(137, 75, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 2, 'pajrpjaeg', NULL, NULL, NULL, 8000.00, '2025-11-03 14:43:55', '2025-11-03 14:43:55'),
(138, 75, 43, 'Watsons Cream Bath', 30000.00, 10, 270000.00, 2, '8aehrahgahg', NULL, 300000.00, NULL, 540000.00, '2025-11-03 14:43:55', '2025-11-03 14:43:55'),
(139, 75, 45, 'Oasis Botol', 0.00, 0, 4000.00, 1, '1500mL', NULL, 4000.00, NULL, 4000.00, '2025-11-03 14:43:55', '2025-11-03 14:43:55'),
(140, 75, 43, 'Watsons Cream Bath', 30000.00, 10, 197363.70, 1, 'naonfinapfna', NULL, 219293.00, NULL, 197363.70, '2025-11-03 14:43:55', '2025-11-03 14:43:55'),
(141, 76, 43, 'Watsons Cream Bath', 30000.00, 10, 270000.00, 2, '8aehrahgahg', NULL, 300000.00, NULL, 540000.00, '2025-11-03 14:53:29', '2025-11-03 14:53:29'),
(142, 77, 43, 'Watsons Cream Bath', 30000.00, 10, 270000.00, 80, '8aehrahgahg', NULL, 300000.00, NULL, 21600000.00, '2025-11-03 15:03:10', '2025-11-03 15:03:10'),
(143, 78, 43, 'Watsons Cream Bath', 30000.00, 10, 270000.00, 1, '8aehrahgahg', NULL, 300000.00, NULL, 270000.00, '2025-11-03 15:22:00', '2025-11-03 15:22:00'),
(144, 79, 46, 'jasdingiobeig', 0.00, 2, 1283208.00, 1, NULL, NULL, 1283208.00, '\"{\\\"type\\\":\\\"iapifhape\\\",\\\"value\\\":\\\"eahtgphaeptae\\\"}\"', 1283208.00, '2025-11-03 16:01:16', '2025-11-03 16:01:16'),
(145, 79, 46, 'jasdingiobeig', 0.00, 2, 13984823.00, 1, NULL, NULL, 13984823.00, '\"{\\\"type\\\":\\\"iapifhape\\\",\\\"value\\\":\\\"9qehgwihgwieohgwpe\\\"}\"', 13984823.00, '2025-11-03 16:01:16', '2025-11-03 16:01:16'),
(146, 80, 43, 'Watsons Cream Bath', 30000.00, 10, 300000.00, 1, NULL, NULL, 300000.00, '\"{\\\"type\\\":\\\"fioionaiofna\\\",\\\"value\\\":\\\"8aehrahgahg\\\"}\"', 300000.00, '2025-11-03 16:07:51', '2025-11-03 16:07:51'),
(147, 81, 43, 'Watsons Cream Bath', 30000.00, 10, 300000.00, 1, NULL, NULL, 300000.00, '\"{\\\"type\\\":\\\"fioionaiofna\\\",\\\"value\\\":\\\"8aehrahgahg\\\"}\"', 300000.00, '2025-11-03 16:17:24', '2025-11-03 16:17:24'),
(148, 82, 4, 'Makanan Produk 4', 75193.00, 0, 75193.00, 1, NULL, NULL, NULL, NULL, 75193.00, '2025-11-03 16:19:15', '2025-11-03 16:19:15'),
(149, 83, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-11-03 16:19:41', '2025-11-03 16:19:41'),
(150, 84, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-11-03 16:24:35', '2025-11-03 16:24:35'),
(151, 85, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-11-03 16:24:56', '2025-11-03 16:24:56'),
(152, 86, 29, 'Ibu & Anak Produk 5', 188114.00, 0, 188114.00, 1, NULL, NULL, NULL, NULL, 188114.00, '2025-11-03 16:25:07', '2025-11-03 16:25:07'),
(153, 87, 14, 'Minuman Produk 6', 17335.00, 0, 17335.00, 1, NULL, NULL, NULL, NULL, 17335.00, '2025-11-03 16:26:51', '2025-11-03 16:26:51'),
(154, 87, 15, 'Minuman Produk 7', 126574.00, 0, 126574.00, 1, NULL, NULL, NULL, NULL, 126574.00, '2025-11-03 16:26:51', '2025-11-03 16:26:51'),
(155, 88, 4, 'Makanan Produk 4', 75193.00, 0, 75193.00, 1, NULL, NULL, NULL, NULL, 75193.00, '2025-11-03 16:31:55', '2025-11-03 16:31:55'),
(156, 89, 45, 'Oasis Botol', 0.00, 0, 2000.00, 1, NULL, NULL, 2000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"600mL\\\"}\"', 2000.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(157, 89, 43, 'Watsons Cream Bath', 30000.00, 10, 300000.00, 1, NULL, NULL, 300000.00, '\"{\\\"type\\\":\\\"fioionaiofna\\\",\\\"value\\\":\\\"8aehrahgahg\\\"}\"', 300000.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(158, 89, 4, 'Makanan Produk 4', 75193.00, 0, 75193.00, 1, NULL, NULL, NULL, NULL, 75193.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(159, 89, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(160, 89, 7, 'Makanan Produk 7', 60393.00, 0, 60393.00, 1, NULL, NULL, NULL, NULL, 60393.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(161, 89, 9, 'Minuman Produk 1', 95543.00, 0, 95543.00, 1, NULL, NULL, NULL, NULL, 95543.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(162, 89, 8, 'Makanan Produk 8', 99871.00, 0, 99871.00, 1, NULL, NULL, NULL, NULL, 99871.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(163, 89, 11, 'Minuman Produk 3', 76976.00, 0, 76976.00, 1, NULL, NULL, NULL, NULL, 76976.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(164, 89, 12, 'Minuman Produk 4', 140932.00, 0, 140932.00, 1, NULL, NULL, NULL, NULL, 140932.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(165, 89, 13, 'Minuman Produk 5', 58903.00, 0, 58903.00, 1, NULL, NULL, NULL, NULL, 58903.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(166, 89, 16, 'Minuman Produk 8', 57880.00, 24, 43988.80, 1, NULL, NULL, NULL, NULL, 43988.80, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(167, 89, 15, 'Minuman Produk 7', 126574.00, 0, 126574.00, 1, NULL, NULL, NULL, NULL, 126574.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(168, 89, 14, 'Minuman Produk 6', 17335.00, 0, 17335.00, 1, NULL, NULL, NULL, NULL, 17335.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(169, 89, 17, 'Perawatan Produk 1', 143715.00, 0, 143715.00, 1, NULL, NULL, NULL, NULL, 143715.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(170, 89, 18, 'Perawatan Produk 2', 59992.00, 0, 59992.00, 1, NULL, NULL, NULL, NULL, 59992.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(171, 89, 19, 'Perawatan Produk 3', 106824.00, 0, 106824.00, 1, NULL, NULL, NULL, NULL, 106824.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(172, 89, 23, 'Perawatan Produk 7', 160241.00, 0, 160241.00, 1, NULL, NULL, NULL, NULL, 160241.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(173, 89, 21, 'Perawatan Produk 5', 42240.00, 0, 42240.00, 1, NULL, NULL, NULL, NULL, 42240.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(174, 89, 20, 'Perawatan Produk 4', 60262.00, 35, 39170.30, 1, NULL, NULL, NULL, NULL, 39170.30, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(175, 89, 24, 'Perawatan Produk 8', 15763.00, 50, 7881.50, 1, NULL, NULL, NULL, NULL, 7881.50, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(176, 89, 25, 'Ibu & Anak Produk 1', 89507.00, 0, 89507.00, 1, NULL, NULL, NULL, NULL, 89507.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(177, 89, 26, 'Ibu & Anak Produk 2', 33828.00, 0, 33828.00, 1, NULL, NULL, NULL, NULL, 33828.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(178, 89, 27, 'Ibu & Anak Produk 3', 26614.00, 0, 26614.00, 1, NULL, NULL, NULL, NULL, 26614.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(179, 89, 28, 'Ibu & Anak Produk 4', 94562.00, 0, 94562.00, 1, NULL, NULL, NULL, NULL, 94562.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(180, 89, 29, 'Ibu & Anak Produk 5', 188114.00, 0, 188114.00, 1, NULL, NULL, NULL, NULL, 188114.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(181, 89, 32, 'Ibu & Anak Produk 8', 95587.00, 0, 95587.00, 1, NULL, NULL, NULL, NULL, 95587.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(182, 89, 31, 'Ibu & Anak Produk 7', 116128.00, 0, 116128.00, 1, NULL, NULL, NULL, NULL, 116128.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(183, 89, 30, 'Ibu & Anak Produk 6', 11003.00, 0, 11003.00, 1, NULL, NULL, NULL, NULL, 11003.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(184, 89, 33, 'Dapur Produk 1', 32347.00, 0, 32347.00, 1, NULL, NULL, NULL, NULL, 32347.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(185, 89, 34, 'Dapur Produk 2', 40277.00, 0, 40277.00, 1, NULL, NULL, NULL, NULL, 40277.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(186, 89, 35, 'Dapur Produk 3', 118312.00, 0, 118312.00, 1, NULL, NULL, NULL, NULL, 118312.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(187, 89, 38, 'Dapur Produk 6', 194442.00, 0, 194442.00, 1, NULL, NULL, NULL, NULL, 194442.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(188, 89, 37, 'Dapur Produk 5', 170914.00, 0, 170914.00, 1, NULL, NULL, NULL, NULL, 170914.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(189, 89, 36, 'Dapur Produk 4', 107813.00, 0, 107813.00, 1, NULL, NULL, NULL, NULL, 107813.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(190, 89, 42, 'Fruit Tea', 4000.00, 0, 6000.00, 2, NULL, NULL, 6000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"500ml\\\"}\"', 12000.00, '2025-11-04 12:56:41', '2025-11-04 12:56:41'),
(191, 90, 43, 'Watsons Cream Bath', 30000.00, 10, 219293.00, 1, NULL, NULL, 219293.00, '\"{\\\"type\\\":\\\"fioionaiofna\\\",\\\"value\\\":\\\"naonfinapfna\\\"}\"', 219293.00, '2025-11-04 13:00:28', '2025-11-04 13:00:28'),
(192, 91, 46, 'jasdingiobeig', 0.00, 2, 13984823.00, 1, NULL, NULL, 13984823.00, '\"{\\\"type\\\":\\\"iapifhape\\\",\\\"value\\\":\\\"9qehgwihgwieohgwpe\\\"}\"', 13984823.00, '2025-11-04 13:03:13', '2025-11-04 13:03:13'),
(193, 91, 42, 'Fruit Tea', 4000.00, 0, 4000.00, 2, NULL, NULL, 4000.00, '\"{\\\"type\\\":\\\"ooiosrgis\\\",\\\"value\\\":\\\"aeojtaee[tja[0\\\"}\"', 8000.00, '2025-11-04 13:03:13', '2025-11-04 13:03:13'),
(194, 91, 45, 'Oasis Botol', 0.00, 0, 1000.00, 1, NULL, NULL, 1000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"250mL\\\"}\"', 1000.00, '2025-11-04 13:03:13', '2025-11-04 13:03:13'),
(195, 92, 50, 'afiuafuoaebof', 10000.00, 10, 9000.00, 1, NULL, NULL, NULL, NULL, 9000.00, '2025-11-04 13:40:35', '2025-11-04 13:40:35'),
(196, 93, 51, 'anfoieighei', 0.00, 0, 1000000.00, 1, NULL, NULL, 1000000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"auosfguoaebgoi\\\"}\"', 1000000.00, '2025-11-04 13:44:41', '2025-11-04 13:44:41'),
(197, 93, 51, 'anfoieighei', 0.00, 0, 1000.00, 1, NULL, NULL, 1000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"aiofhaub\\\"}\"', 1000.00, '2025-11-04 13:44:41', '2025-11-04 13:44:41'),
(198, 94, 47, 'oantoiaen', 0.00, 50, 4201451.50, 1, NULL, NULL, 8402903.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"ojabeotgoet\\\"}\"', 4201451.50, '2025-11-04 14:19:46', '2025-11-04 14:19:46'),
(199, 94, 47, 'oantoiaen', 0.00, 50, 4201451.50, 1, NULL, NULL, 4201451.50, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"ojabeotgoet\\\"}\"', 4201451.50, '2025-11-04 14:19:46', '2025-11-04 14:19:46'),
(200, 95, 47, 'oantoiaen', 0.00, 50, 4201451.50, 1, NULL, NULL, 8402903.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"ojabeotgoet\\\"}\"', 4201451.50, '2025-11-04 14:20:12', '2025-11-04 14:20:12'),
(201, 95, 47, 'oantoiaen', 0.00, 50, 4201451.50, 1, NULL, NULL, 4201451.50, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"ojabeotgoet\\\"}\"', 4201451.50, '2025-11-04 14:20:12', '2025-11-04 14:20:12'),
(202, 96, 47, 'oantoiaen', 0.00, 50, 4201451.50, 2, NULL, NULL, 8402903.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"ojabeotgoet\\\"}\"', 8402903.00, '2025-11-04 14:27:23', '2025-11-04 14:27:23'),
(203, 96, 47, 'oantoiaen', 0.00, 50, 65467.00, 1, NULL, NULL, 65467.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"jojaeotnetn\\\"}\"', 65467.00, '2025-11-04 14:27:23', '2025-11-04 14:27:23'),
(204, 97, 47, 'oantoiaen', 0.00, 50, 4201451.50, 1, NULL, NULL, 8402903.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"ojabeotgoet\\\"}\"', 4201451.50, '2025-11-04 14:38:14', '2025-11-04 14:38:14'),
(205, 98, 53, 'aiejfgipaegnaen', 100000.00, 30, 70000.00, 1, NULL, NULL, NULL, NULL, 70000.00, '2025-11-04 15:26:36', '2025-11-04 15:26:36'),
(206, 99, 53, 'aiejfgipaegnaen', 100000.00, 30, 140000.00, 1, NULL, NULL, 200000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"S\\\"}\"', 140000.00, '2025-11-04 15:29:35', '2025-11-04 15:29:35'),
(207, 99, 53, 'aiejfgipaegnaen', 100000.00, 30, 210000.00, 1, NULL, NULL, 300000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"M\\\"}\"', 210000.00, '2025-11-04 15:29:35', '2025-11-04 15:29:35'),
(208, 100, 2, 'Makanan Produk 2', 198532.00, 0, 198532.00, 1, NULL, NULL, NULL, NULL, 198532.00, '2025-11-04 15:30:23', '2025-11-04 15:30:23'),
(209, 101, 48, 'Kecap Bango', 0.00, 10, 6300.00, 1, NULL, NULL, 6300.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"150ml\\\"}\"', 6300.00, '2025-11-04 15:33:12', '2025-11-04 15:33:12'),
(210, 101, 48, 'Kecap Bango', 0.00, 10, 13500.00, 1, NULL, NULL, 13500.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"520ml\\\"}\"', 13500.00, '2025-11-04 15:33:12', '2025-11-04 15:33:12'),
(211, 102, 47, 'oantoiaen', 0.00, 50, 4201451.50, 1, 'ojabeotgoet', NULL, 8402903.00, NULL, 4201451.50, '2025-11-05 15:00:35', '2025-11-05 15:00:35'),
(212, 102, 1, 'Makanan Produk 1', 93711.00, 0, 93711.00, 1, NULL, NULL, NULL, NULL, 93711.00, '2025-11-05 15:00:35', '2025-11-05 15:00:35'),
(213, 103, 50, 'Teh Botol', 4000.00, 10, 3600.00, 1, NULL, NULL, NULL, NULL, 3600.00, '2025-11-05 15:27:08', '2025-11-05 15:27:08'),
(214, 104, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-11-05 15:29:24', '2025-11-05 15:29:24'),
(215, 104, 43, 'Watsons Cream Bath', 30000.00, 10, 270000.00, 1, '8aehrahgahg', NULL, 300000.00, NULL, 270000.00, '2025-11-05 15:29:24', '2025-11-05 15:29:24'),
(216, 104, 42, 'Fruit Tea', 4000.00, 0, 6000.00, 1, '500ml', NULL, 6000.00, NULL, 6000.00, '2025-11-05 15:29:24', '2025-11-05 15:29:24'),
(217, 104, 48, 'Kecap Bango', 0.00, 10, 13500.00, 1, '520ml', NULL, 15000.00, NULL, 13500.00, '2025-11-05 15:29:24', '2025-11-05 15:29:24'),
(218, 104, 50, 'Teh Botol', 4000.00, 10, 3600.00, 1, NULL, NULL, NULL, NULL, 3600.00, '2025-11-05 15:29:24', '2025-11-05 15:29:24'),
(219, 105, 7, 'Makanan Produk 7', 60393.00, 0, 60393.00, 1, NULL, NULL, NULL, NULL, 60393.00, '2025-11-05 16:19:59', '2025-11-05 16:19:59'),
(220, 105, 5, 'Makanan Produk 5', 72475.00, 0, 72475.00, 1, NULL, NULL, NULL, NULL, 72475.00, '2025-11-05 16:19:59', '2025-11-05 16:19:59'),
(221, 105, 54, 'Lifebuoy Sabun Cair', 0.00, 20, 24000.00, 1, NULL, NULL, 300000.00, '\"{\\\"type\\\":\\\"Varian\\\",\\\"value\\\":\\\"Mild Care 450ml\\\"}\"', 24000.00, '2025-11-05 16:19:59', '2025-11-05 16:19:59'),
(222, 106, 54, 'Lifebuoy Sabun Cair', 0.00, 20, 24000.00, 1, NULL, NULL, 30000.00, '\"{\\\"type\\\":\\\"Varian\\\",\\\"value\\\":\\\"Mild Care 450ml\\\"}\"', 24000.00, '2025-11-05 16:21:32', '2025-11-05 16:21:32'),
(223, 107, 8, 'Makanan Produk 8', 99871.00, 0, 99871.00, 1, NULL, NULL, NULL, NULL, 99871.00, '2025-11-05 16:22:27', '2025-11-05 16:22:27'),
(224, 107, 54, 'Lifebuoy Sabun Cair', 0.00, 20, 24000.00, 1, NULL, NULL, 30000.00, '\"{\\\"type\\\":\\\"Varian\\\",\\\"value\\\":\\\"Mild Care 450ml\\\"}\"', 24000.00, '2025-11-05 16:22:27', '2025-11-05 16:22:27'),
(225, 108, 12, 'Minuman Produk 4', 140932.00, 0, 140932.00, 1, NULL, NULL, NULL, NULL, 140932.00, '2025-11-05 16:23:32', '2025-11-05 16:23:32'),
(226, 109, 12, 'Minuman Produk 4', 140932.00, 0, 140932.00, 1, NULL, NULL, NULL, NULL, 140932.00, '2025-11-05 16:23:35', '2025-11-05 16:23:35'),
(227, 110, 14, 'Minuman Produk 6', 17335.00, 0, 17335.00, 1, NULL, NULL, NULL, NULL, 17335.00, '2025-11-05 16:24:12', '2025-11-05 16:24:12'),
(228, 111, 14, 'Minuman Produk 6', 17335.00, 0, 17335.00, 1, NULL, NULL, NULL, NULL, 17335.00, '2025-11-05 16:24:21', '2025-11-05 16:24:21'),
(229, 112, 3, 'Makanan Produk 3', 24054.00, 0, 24054.00, 1, NULL, NULL, NULL, NULL, 24054.00, '2025-11-05 16:27:04', '2025-11-05 16:27:04'),
(230, 113, 8, 'Makanan Produk 8', 99871.00, 0, 99871.00, 1, NULL, NULL, NULL, NULL, 99871.00, '2025-11-05 16:30:46', '2025-11-05 16:30:46'),
(231, 114, 48, 'Kecap Bango', 0.00, 10, 6300.00, 1, NULL, NULL, 6300.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"150ml\\\"}\"', 6300.00, '2025-11-05 16:34:22', '2025-11-05 16:34:22'),
(232, 114, 42, 'Fruit Tea', 4000.00, 0, 6000.00, 1, NULL, NULL, 6000.00, '\"{\\\"type\\\":\\\"Ukuran\\\",\\\"value\\\":\\\"500ml\\\"}\"', 6000.00, '2025-11-05 16:34:22', '2025-11-05 16:34:22'),
(233, 115, 50, 'Teh Botol', 4000.00, 10, 3600.00, 1, NULL, NULL, NULL, NULL, 3600.00, '2025-11-05 16:34:39', '2025-11-05 16:34:39'),
(234, 115, 48, 'Kecap Bango', 0.00, 10, 6300.00, 1, NULL, NULL, 6300.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"150ml\\\"}\"', 6300.00, '2025-11-05 16:34:39', '2025-11-05 16:34:39'),
(235, 115, 48, 'Kecap Bango', 0.00, 10, 13500.00, 1, NULL, NULL, 13500.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"520ml\\\"}\"', 13500.00, '2025-11-05 16:34:39', '2025-11-05 16:34:39'),
(236, 116, 50, 'Teh Botol', 4000.00, 10, 3600.00, 1, NULL, NULL, NULL, NULL, 3600.00, '2025-11-05 16:34:42', '2025-11-05 16:34:42'),
(237, 116, 48, 'Kecap Bango', 0.00, 10, 6300.00, 1, NULL, NULL, 6300.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"150ml\\\"}\"', 6300.00, '2025-11-05 16:34:42', '2025-11-05 16:34:42'),
(238, 116, 48, 'Kecap Bango', 0.00, 10, 13500.00, 1, NULL, NULL, 13500.00, '\"{\\\"type\\\":\\\"varian\\\",\\\"value\\\":\\\"520ml\\\"}\"', 13500.00, '2025-11-05 16:34:42', '2025-11-05 16:34:42');

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
-- Table structure for table `point_transactions`
--

CREATE TABLE `point_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `points` int(11) NOT NULL,
  `type` enum('earn','redeem') NOT NULL DEFAULT 'earn',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `point_transactions`
--

INSERT INTO `point_transactions` (`id`, `user_id`, `order_id`, `points`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 5, 'earn', 'Daily Reward - Day 1', '2025-10-30 13:03:55', '2025-10-30 13:03:55'),
(2, 2, 2, 176, 'earn', 'Poin dari transaksi #KSR-20251030-0002', '2025-10-30 15:03:56', '2025-10-30 15:03:56'),
(3, 2, 4, 168, 'earn', 'Poin dari transaksi #KSR-20251030-0004', '2025-10-30 15:12:15', '2025-10-30 15:12:15'),
(4, 2, 5, 24, 'earn', 'Poin dari transaksi #KSR-20251030-0005', '2025-10-30 15:14:26', '2025-10-30 15:14:26'),
(5, 2, 6, 24, 'earn', 'Poin dari transaksi #KSR-20251030-0006', '2025-10-30 15:26:35', '2025-10-30 15:26:35'),
(6, 2, 7, 198, 'earn', 'Poin dari transaksi #KSR-20251030-0007', '2025-10-30 15:30:27', '2025-10-30 15:30:27'),
(7, 2, 8, 24, 'earn', 'Poin dari transaksi #KSR-20251030-0008', '2025-10-30 15:40:36', '2025-10-30 15:40:36'),
(8, 2, NULL, 5, 'earn', 'Daily Reward - Day 2', '2025-10-31 01:18:23', '2025-10-31 01:18:23'),
(11, 2, NULL, -400, 'redeem', 'Penukaran voucher: Gratis Ongkir Crazy Rich', '2025-10-31 06:44:32', '2025-10-31 06:44:32'),
(12, 2, 15, 1985, 'earn', 'Poin dari transaksi #KSR-20251031-0007', '2025-10-31 12:38:28', '2025-10-31 12:38:28'),
(13, 2, NULL, -400, 'redeem', 'Penukaran voucher: Gratis Ongkir Crazy Rich', '2025-10-31 12:38:49', '2025-10-31 12:38:49'),
(14, 2, 17, 24, 'earn', 'Poin dari transaksi #KSR-20251031-0009', '2025-10-31 13:00:15', '2025-10-31 13:00:15'),
(15, 2, 20, 230, 'earn', 'Poin dari transaksi #KSR-20251031-0012', '2025-10-31 13:09:45', '2025-10-31 13:09:45'),
(16, 2, 21, 200, 'earn', 'Poin dari transaksi #KSR-20251031-0013', '2025-10-31 13:14:49', '2025-10-31 13:14:49'),
(17, 2, 22, 24, 'earn', 'Poin dari transaksi #KSR-20251031-0014', '2025-10-31 13:16:01', '2025-10-31 13:16:01'),
(18, 2, 24, 186, 'earn', 'Poin dari transaksi #KSR-20251031-0016', '2025-10-31 13:38:00', '2025-10-31 13:38:00'),
(19, 2, 25, 222, 'earn', 'Poin dari transaksi #KSR-20251031-0017', '2025-10-31 13:45:03', '2025-10-31 13:45:03'),
(20, 2, 27, 262, 'earn', 'Poin dari transaksi #KSR-20251031-0019', '2025-10-31 13:47:27', '2025-10-31 13:47:27'),
(21, 2, 28, 128, 'earn', 'Poin dari transaksi #KSR-20251031-0020', '2025-10-31 13:48:07', '2025-10-31 13:48:07'),
(22, 2, 29, 72, 'earn', 'Poin dari transaksi #KSR-20251031-0021', '2025-10-31 13:52:38', '2025-10-31 13:52:38'),
(23, 2, 31, 251, 'earn', 'Poin dari transaksi #KSR-20251031-0023', '2025-10-31 14:05:35', '2025-10-31 14:05:35'),
(24, 2, 32, 270, 'earn', 'Poin dari transaksi #KSR-20251031-0024', '2025-10-31 14:06:06', '2025-10-31 14:06:06'),
(25, 2, 33, 176, 'earn', 'Poin dari transaksi #KSR-20251031-0025', '2025-10-31 14:14:10', '2025-10-31 14:14:10'),
(26, 2, 36, 304, 'earn', 'Poin dari transaksi #KSR-20251031-0028', '2025-10-31 14:26:27', '2025-10-31 14:26:27'),
(27, 2, 41, 147, 'earn', 'Poin dari transaksi #KSR-20251031-0033', '2025-10-31 14:39:26', '2025-10-31 14:39:26'),
(28, 2, 43, 158, 'earn', 'Poin dari transaksi #KSR-20251031-0035', '2025-10-31 14:40:41', '2025-10-31 14:40:41'),
(29, 2, 46, 222, 'earn', 'Poin dari transaksi #KSR-20251031-0038', '2025-10-31 14:45:40', '2025-10-31 14:45:40'),
(30, 2, 47, 104, 'earn', 'Poin dari transaksi #KSR-20251031-0039', '2025-10-31 14:46:22', '2025-10-31 14:46:22'),
(31, 2, NULL, -400, 'redeem', 'Penukaran voucher: Gratis Ongkir Crazy Rich', '2025-10-31 15:00:47', '2025-10-31 15:00:47'),
(32, 2, NULL, 5, 'earn', 'Daily Reward - Day 3', '2025-11-01 14:43:18', '2025-11-01 14:43:18'),
(33, 2, 54, 519, 'earn', 'Poin dari transaksi #KSR-20251102-0005', '2025-11-01 17:45:42', '2025-11-01 17:45:42'),
(34, 2, NULL, 10, 'earn', 'Daily Reward - Day 4', '2025-11-01 17:48:08', '2025-11-01 17:48:08'),
(35, 2, 66, 36, 'earn', 'Poin dari transaksi #KSR-20251102-0017', '2025-11-02 09:57:56', '2025-11-02 09:57:56'),
(36, 2, 68, 2, 'earn', 'Poin dari transaksi #KSR-20251102-0019', '2025-11-02 10:01:00', '2025-11-02 10:01:00'),
(37, 2, 69, 7, 'earn', 'Poin dari transaksi #KSR-20251102-0020', '2025-11-02 10:46:01', '2025-11-02 10:46:01'),
(38, 2, 72, 308, 'earn', 'Poin dari transaksi #KSR-20251102-0023', '2025-11-02 11:59:00', '2025-11-02 11:59:00'),
(39, 2, NULL, -50, 'redeem', 'Penukaran voucher: Gratis Ongkir Si Kere', '2025-11-02 13:49:56', '2025-11-02 13:49:56'),
(40, 2, NULL, 10, 'earn', 'Daily Reward - Day 5', '2025-11-03 14:24:16', '2025-11-03 14:24:16'),
(41, 2, NULL, -400, 'redeem', 'Penukaran voucher: Gratis Ongkir Crazy Rich', '2025-11-03 14:24:44', '2025-11-03 14:24:44'),
(42, 7, NULL, 5, 'earn', 'Daily Reward - Day 1', '2025-11-03 15:59:36', '2025-11-03 15:59:36'),
(43, 2, 79, 15268, 'earn', 'Poin dari transaksi #KSR-20251103-0006', '2025-11-03 16:02:08', '2025-11-03 16:02:08'),
(44, 2, 88, 75, 'earn', 'Poin dari transaksi #KSR-20251103-0015', '2025-11-03 16:32:09', '2025-11-03 16:32:09'),
(45, 2, NULL, 15, 'earn', 'Daily Reward - Day 6', '2025-11-04 12:04:47', '2025-11-04 12:04:47'),
(46, 2, 89, 3061, 'earn', 'Poin dari transaksi #KSR-20251104-0001', '2025-11-04 12:57:25', '2025-11-04 12:57:25'),
(47, 2, 90, 219, 'earn', 'Poin dari transaksi #KSR-20251104-0002', '2025-11-04 13:01:44', '2025-11-04 13:01:44'),
(48, 2, NULL, -400, 'redeem', 'Penukaran voucher: Gratis Ongkir Crazy Rich', '2025-11-04 13:40:03', '2025-11-04 13:40:03'),
(49, 2, 96, 8468, 'earn', 'Poin dari transaksi #KSR-20251104-0008', '2025-11-04 14:27:50', '2025-11-04 14:27:50'),
(50, 2, 97, 4201, 'earn', 'Poin dari transaksi #KSR-20251104-0009', '2025-11-04 14:38:30', '2025-11-04 14:38:30'),
(51, 2, 99, 350, 'earn', 'Poin dari transaksi #KSR-20251104-0011', '2025-11-04 15:29:55', '2025-11-04 15:29:55'),
(52, 2, 100, 198, 'earn', 'Poin dari transaksi #KSR-20251104-0012', '2025-11-04 15:30:39', '2025-11-04 15:30:39'),
(53, 2, 101, 19, 'earn', 'Poin dari transaksi #KSR-20251104-0013', '2025-11-04 15:33:26', '2025-11-04 15:33:26'),
(54, 2, NULL, 25, 'earn', 'Daily Reward - Day 7', '2025-11-05 14:45:27', '2025-11-05 14:45:27'),
(55, 2, NULL, -400, 'redeem', 'Penukaran voucher: Gratis Ongkir Crazy Rich', '2025-11-05 15:29:09', '2025-11-05 15:29:09'),
(56, 2, 105, 156, 'earn', 'Poin dari transaksi #KSR-20251105-0004', '2025-11-05 16:20:40', '2025-11-05 16:20:40'),
(57, 2, 106, 24, 'earn', 'Poin dari transaksi #KSR-20251105-0005', '2025-11-05 16:21:49', '2025-11-05 16:21:49'),
(58, 2, 107, 123, 'earn', 'Poin dari transaksi #KSR-20251105-0006', '2025-11-05 16:22:41', '2025-11-05 16:22:41'),
(59, 2, 112, 24, 'earn', 'Poin dari transaksi #KSR-20251105-0011', '2025-11-05 16:27:23', '2025-11-05 16:27:23'),
(60, 2, 113, 99, 'earn', 'Poin dari transaksi #KSR-20251105-0012', '2025-11-05 16:30:58', '2025-11-05 16:30:58'),
(61, 2, 116, 23, 'earn', 'Poin dari transaksi #KSR-20251105-0015', '2025-11-05 16:34:50', '2025-11-05 16:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `barcode` varchar(50) DEFAULT NULL,
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

INSERT INTO `products` (`id`, `category_id`, `barcode`, `title`, `slug`, `meta`, `description`, `price`, `stock`, `discount`, `brand`, `image`, `variants`, `created_at`, `updated_at`) VALUES
(1, 1, 'SKU-000001', 'Makanan Produk 1', 'makanan-produk-1-6902bd7f02250', 'Meta 1', 'Deskripsi 1', 93711.00, 18, NULL, 'Brand 1', NULL, NULL, '2025-10-30 01:21:03', '2025-11-05 15:00:35'),
(2, 1, 'SKU-000002', 'Makanan Produk 2', 'makanan-produk-2-6902bd7f03262', 'Meta 2', 'Deskripsi 2', 198532.00, 4, NULL, 'Brand 2', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 15:30:23'),
(3, 1, 'SKU-000003', 'Makanan Produk 3', 'makanan-produk-3-6902bd7f03b89', 'Meta 3', 'Deskripsi 3', 24054.00, 35, NULL, 'Brand 3', NULL, NULL, '2025-10-30 01:21:03', '2025-11-05 16:27:04'),
(4, 1, 'SKU-000004', 'Makanan Produk 4', 'makanan-produk-4-6902bd7f0454d', 'Meta 4', 'Deskripsi 4', 75193.00, 55, NULL, 'Brand 4', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(5, 1, 'SKU-000005', 'Makanan Produk 5', 'makanan-produk-5-6902bd7f04dc8', 'Meta 5', 'Deskripsi 5', 72475.00, 67, NULL, 'Brand 5', NULL, NULL, '2025-10-30 01:21:03', '2025-11-05 16:19:59'),
(6, 1, 'SKU-000006', 'Makanan Produk 6', 'makanan-produk-6-6902bd7f056fc', 'Meta 6', 'Deskripsi 6', 104057.00, 0, NULL, 'Brand 6', NULL, NULL, '2025-10-30 01:21:03', '2025-11-01 18:14:34'),
(7, 1, 'SKU-000007', 'Makanan Produk 7', 'makanan-produk-7-6902bd7f06109', 'Meta 7', 'Deskripsi 7', 60393.00, 20, NULL, 'Brand 7', NULL, NULL, '2025-10-30 01:21:03', '2025-11-05 16:19:59'),
(8, 1, 'SKU-000008', 'Makanan Produk 8', 'makanan-produk-8-6902bd7f06916', 'Meta 8', 'Deskripsi 8', 99871.00, 31, NULL, 'Brand 8', NULL, NULL, '2025-10-30 01:21:03', '2025-11-05 16:30:46'),
(9, 2, 'SKU-000009', 'Minuman Produk 1', 'minuman-produk-1-6902bd7f07842', 'Meta 1', 'Deskripsi 1', 95543.00, 57, NULL, 'Brand 1', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(10, 2, 'SKU-000010', 'Minuman Produk 2', 'minuman-produk-2-6902bd7f08783', 'Meta 2', 'Deskripsi 2', 176169.00, 94, NULL, 'Brand 2', NULL, NULL, '2025-10-30 01:21:03', '2025-10-31 14:44:39'),
(11, 2, 'SKU-000011', 'Minuman Produk 3', 'minuman-produk-3-6902bd7f08edc', 'Meta 3', 'Deskripsi 3', 76976.00, 9, NULL, 'Brand 3', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(12, 2, 'SKU-000012', 'Minuman Produk 4', 'minuman-produk-4-6902bd7f09680', 'Meta 4', 'Deskripsi 4', 140932.00, 71, NULL, 'Brand 4', NULL, NULL, '2025-10-30 01:21:03', '2025-11-05 16:23:35'),
(13, 2, 'SKU-000013', 'Minuman Produk 5', 'minuman-produk-5-6902bd7f0a2b6', 'Meta 5', 'Deskripsi 5', 58903.00, 90, NULL, 'Brand 5', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(14, 2, 'SKU-000014', 'Minuman Produk 6', 'minuman-produk-6-6902bd7f0aab5', 'Meta 6', 'Deskripsi 6', 17335.00, 70, NULL, 'Brand 6', NULL, NULL, '2025-10-30 01:21:03', '2025-11-05 16:24:21'),
(15, 2, 'SKU-000015', 'Minuman Produk 7', 'minuman-produk-7-6902bd7f0b285', 'Meta 7', 'Deskripsi 7', 126574.00, 6, NULL, 'Brand 7', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(16, 2, 'SKU-000016', 'Minuman Produk 8', 'minuman-produk-8-6902bd7f0ba63', 'Meta 8', 'Deskripsi 8', 57880.00, 17, 24, 'Brand 8', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(17, 3, 'SKU-000017', 'Perawatan Produk 1', 'perawatan-produk-1-6902bd7f0ce95', 'Meta 1', 'Deskripsi 1', 143715.00, 4, NULL, 'Brand 1', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(18, 3, 'SKU-000018', 'Perawatan Produk 2', 'perawatan-produk-2-6902bd7f0dc8d', 'Meta 2', 'Deskripsi 2', 59992.00, 97, NULL, 'Brand 2', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(19, 3, 'SKU-000019', 'Perawatan Produk 3', 'perawatan-produk-3-6902bd7f0e7f3', 'Meta 3', 'Deskripsi 3', 106824.00, 54, NULL, 'Brand 3', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(20, 3, 'SKU-000020', 'Perawatan Produk 4', 'perawatan-produk-4-6902bd7f0f071', 'Meta 4', 'Deskripsi 4', 60262.00, 44, 35, 'Brand 4', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(21, 3, 'SKU-000021', 'Perawatan Produk 5', 'perawatan-produk-5-6902bd7f0f87f', 'Meta 5', 'Deskripsi 5', 42240.00, 74, NULL, 'Brand 5', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(22, 3, 'SKU-000022', 'Perawatan Produk 6', 'perawatan-produk-6-6902bd7f10058', 'Meta 6', 'Deskripsi 6', 48397.00, 0, 45, 'Brand 6', NULL, NULL, '2025-10-30 01:21:03', '2025-10-30 03:45:40'),
(23, 3, 'SKU-000023', 'Perawatan Produk 7', 'perawatan-produk-7-6902bd7f107da', 'Meta 7', 'Deskripsi 7', 160241.00, 22, NULL, 'Brand 7', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(24, 3, 'SKU-000024', 'Perawatan Produk 8', 'perawatan-produk-8-6902bd7f10f7f', 'Meta 8', 'Deskripsi 8', 15763.00, 10, 50, 'Brand 8', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(25, 4, 'SKU-000025', 'Ibu & Anak Produk 1', 'ibu-anak-produk-1-6902bd7f120d7', 'Meta 1', 'Deskripsi 1', 89507.00, 67, NULL, 'Brand 1', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(26, 4, 'SKU-000026', 'Ibu & Anak Produk 2', 'ibu-anak-produk-2-6902bd7f12976', 'Meta 2', 'Deskripsi 2', 33828.00, 13, NULL, 'Brand 2', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(27, 4, 'SKU-000027', 'Ibu & Anak Produk 3', 'ibu-anak-produk-3-6902bd7f131a5', 'Meta 3', 'Deskripsi 3', 26614.00, 1, NULL, 'Brand 3', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(28, 4, 'SKU-000028', 'Ibu & Anak Produk 4', 'ibu-anak-produk-4-6902bd7f139d0', 'Meta 4', 'Deskripsi 4', 94562.00, 47, NULL, 'Brand 4', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(29, 4, 'SKU-000029', 'Ibu & Anak Produk 5', 'ibu-anak-produk-5-6902bd7f141ef', 'Meta 5', 'Deskripsi 5', 188114.00, 77, NULL, 'Brand 5', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(30, 4, 'SKU-000030', 'Ibu & Anak Produk 6', 'ibu-anak-produk-6-6902bd7f149eb', 'Meta 6', 'Deskripsi 6', 11003.00, 79, NULL, 'Brand 6', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(31, 4, 'SKU-000031', 'Ibu & Anak Produk 7', 'ibu-anak-produk-7-6902bd7f151ae', 'Meta 7', 'Deskripsi 7', 116128.00, 29, NULL, 'Brand 7', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(32, 4, 'SKU-000032', 'Ibu & Anak Produk 8', 'ibu-anak-produk-8-6902bd7f15a10', 'Meta 8', 'Deskripsi 8', 95587.00, 60, NULL, 'Brand 8', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(33, 5, 'SKU-000033', 'Dapur Produk 1', 'dapur-produk-1-6902bd7f16cfa', 'Meta 1', 'Deskripsi 1', 32347.00, 78, NULL, 'Brand 1', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(34, 5, 'SKU-000034', 'Dapur Produk 2', 'dapur-produk-2-6902bd7f1747a', 'Meta 2', 'Deskripsi 2', 40277.00, 4, NULL, 'Brand 2', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(35, 5, 'SKU-000035', 'Dapur Produk 3', 'dapur-produk-3-6902bd7f17b9f', 'Meta 3', 'Deskripsi 3', 118312.00, 98, NULL, 'Brand 3', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(36, 5, 'SKU-000036', 'Dapur Produk 4', 'dapur-produk-4-6902bd7f1827d', 'Meta 4', 'Deskripsi 4', 107813.00, 16, NULL, 'Brand 4', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(37, 5, 'SKU-000037', 'Dapur Produk 5', 'dapur-produk-5-6902bd7f18983', 'Meta 5', 'Deskripsi 5', 170914.00, 31, NULL, 'Brand 5', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(38, 5, 'SKU-000038', 'Dapur Produk 6', 'dapur-produk-6-6902bd7f19053', 'Meta 6', 'Deskripsi 6', 194442.00, 83, NULL, 'Brand 6', NULL, NULL, '2025-10-30 01:21:03', '2025-11-04 12:56:41'),
(39, 5, 'SKU-000039', 'Dapur Produk 7', 'dapur-produk-7-6902bd7f1976b', 'Meta 7', 'Deskripsi 7', 109232.00, 70, NULL, 'Brand 7', NULL, NULL, '2025-10-30 01:21:03', '2025-10-30 03:45:40'),
(40, 5, 'SKU-000040', 'Dapur Produk 8', 'dapur-produk-8-6902bd7f19fb6', 'Meta 8', 'Deskripsi 8', 109963.00, 54, NULL, 'Brand 8', NULL, NULL, '2025-10-30 01:21:03', '2025-11-02 11:03:11'),
(42, 2, 'V0000428efdb8', 'Fruit Tea', 'fruit-tea', 'minuman teh rasa buah', '600ml', 4000.00, 86, 0, 'PT. SINAR SOSRO', 'https://drivethru.klikindomaret.com/twb5/wp-content/uploads/sites/31/2021/07/20002203_1.jpg', '[{\"type\":\"Ukuran\",\"options\":[{\"value\":\"350ml\",\"price\":4000,\"barcode\":\"8996001400024\"},{\"value\":\"500ml\",\"price\":6000,\"barcode\":\"8996001400123\"}]}]', '2025-11-01 15:04:37', '2025-11-05 16:34:22'),
(43, 3, '0000000000000', 'Watsons Cream Bath', 'watsons-cream-bath', 'sabun untuk mandi', 'mantap', 30000.00, 74, 10, 'Watsons', 'https://medias.watsons.co.id/publishing/WTCID-44292-side-zoom.jpg?version=1753283584', '[{\"type\":\"fioionaiofna\",\"options\":[{\"value\":\"naonfinapfna\",\"price\":219293,\"barcode\":\"8993137010925\"},{\"value\":\"8aehrahgahg\",\"price\":300000,\"barcode\":\"8993137010926\"}]}]', '2025-11-01 15:24:40', '2025-11-05 15:29:24'),
(45, 2, 'V383f9167db1e', 'Oasis Botol', 'oasis-botol', 'minum air sehat', 'sehat jaya jaya jaya', 0.00, 94, 0, 'PT. OASIS WATERS', 'https://down-id.img.susercontent.com/file/sg-11134201-23010-ouvmws62aylvbc', '[{\"type\":\"Ukuran\",\"options\":[{\"value\":\"250mL\",\"price\":1000,\"barcode\":\"8991368188282\"},{\"value\":\"600mL\",\"price\":2000,\"barcode\":\"8991368188283\"},{\"value\":\"1500mL\",\"price\":4000,\"barcode\":\"8991368188284\"}]}]', '2025-11-02 10:44:02', '2025-11-04 13:03:13'),
(46, 2, 'Vabc48e2a09fc', 'jasdingiobeig', 'jasdingiobeig', 'auebfaebi', 'iaoentipspt', 0.00, 97, 2, 'uabgaeb', 'products/RlD1GsBVv4QCRbuNywTlyoCIUhhKZLa118BACcvs.jpg', '[{\"type\":\"iapifhape\",\"options\":[{\"value\":\"eahtgphaeptae\",\"price\":1283208,\"barcode\":\"8993137010921\"},{\"value\":\"9qehgwihgwieohgwpe\",\"price\":13984823,\"barcode\":\"8993137010929\"}]}]', '2025-11-03 15:12:26', '2025-11-04 13:03:13'),
(47, 5, 'V8d00f038e82e', 'oantoiaen', 'oantoiaen', 'insgpnrwi', 'npgnwirgp', 0.00, 91, 50, 'sdngipanegi', 'products/mIxrCGl5xvGm362WrWmJ8q7HfDOrddXSoPnXJrjg.jpg', '[{\"type\":\"varian\",\"options\":[{\"value\":\"jojaeotnetn\",\"price\":130934,\"barcode\":\"8993137030925\"},{\"value\":\"ojabeotgoet\",\"price\":8402903,\"barcode\":\"8993137030926\"}]}]', '2025-11-03 15:24:19', '2025-11-05 15:00:35'),
(48, 1, 'V6ff435efa4dd', 'Kecap Bango', 'kecap-bango', 'kecap manis', 'kecap mantap', 0.00, 92, 10, 'Bango', 'https://id-test-11.slatic.net/p/81f71d729042613354d66d580327824d.jpg', '[{\"type\":\"varian\",\"options\":[{\"value\":\"520ml\",\"price\":15000,\"barcode\":\"8997204401776\"},{\"value\":\"150ml\",\"price\":7000,\"barcode\":\"8997204401775\"}]}]', '2025-11-04 13:14:25', '2025-11-05 16:34:42'),
(50, 2, '8996006858818', 'Teh Botol', 'teh-botol', 'Minuman teh dalam kemasan botol berukuran 350 mL dari merek Sosro, varian Tawar. Tidak manis, cocok untuk yang menginginkan rasa teh ringan menyegarkan tanpa pemanis tambahan.', 'Dibuat dari daun teh pilihan yang diolah dengan teknologi modern untuk menjaga kesegaran dan kualitas rasa. \r\n\r\nKomposisi utama: air, teh melati (atau teh pilihan lainnya) dan antioksidan asam askorbat. \r\nklikindogrosir\r\n\r\nNutrisi per serving: energi total 0 kcal, lemak 0 g, protein 0 g, karbohidrat 0 g, gula 0 g, natrium sekitar 30 mg.', 4000.00, 95, 10, 'Sosro', 'products/XFVGBvOfLmzrHzb6ZIcmnHcTpVHwXM8exXQT7juM.jpg', NULL, '2025-11-04 13:36:23', '2025-11-05 16:34:42'),
(51, 3, '0000000000000', 'anfoieighei', 'anfoieighei', 'aijfipaepi', 'ietogiegi', 0.00, 97, 0, 'ja vjkanvl', 'products/YY9qBuwFAzCD9V72uNbcSFhPssfP8rCvfebWOMRn.jpg', '[{\"type\":\"Ukuran\",\"options\":[{\"value\":\"aiofhaub\",\"price\":1000,\"barcode\":\"8996001400283\"},{\"value\":\"auosfguoaebgoi\",\"price\":1000000,\"barcode\":\"8996001400281\"}]}]', '2025-11-04 13:44:12', '2025-11-04 13:44:41'),
(52, 2, '8997204403283', 'iaehgioaehgiaehipgae', 'iaehgioaehgiaehipgae', 'iaigaehog', 'aihgioaeiogae', 100000.00, 100, 10, 'oiahigbaeipgbae', 'products/X9v0y2iOL1Ko5wn0hWZ6Djs5JHDp40qkKXYERpfi.jpg', NULL, '2025-11-04 13:49:59', '2025-11-04 13:49:59'),
(53, 3, '8996001402900', 'aiejfgipaegnaen', 'aiejfgipaegnaen', 'oadogahig', 'oiawfoinaw', 100000.00, 97, 30, 'afnlangipaen', 'products/L3TYaCJzNHtcbHdBFnUnnXbWbCBCcTFoqMWpXbcT.png', '[{\"type\":\"Ukuran\",\"options\":[{\"value\":\"S\",\"price\":200000,\"barcode\":\"8996001400321\"},{\"value\":\"M\",\"price\":300000,\"barcode\":\"8996001400322\"}]}]', '2025-11-04 13:52:32', '2025-11-04 15:29:35'),
(54, 3, '0000000000000', 'Lifebuoy Sabun Cair', 'lifebuoy-sabun-cair', 'Sabun cair antibakteri yang membantu melindungi kulit dari kuman penyebab penyakit.', 'Lifebuoy Body Wash memberikan perlindungan higienis dengan formula antibakteri aktif. Tersedia dalam beberapa varian seperti Total 10, Lemon Fresh, Mild Care, dan Cool Fresh yang menyesuaikan kebutuhan kulit. Teksturnya lembut, mudah dibilas, dan memberi sensasi segar sehabis mandi.', 0.00, 97, 20, 'Lifebuoy', 'https://o-cdf.oramiland.com/unsafe/core.oramiland.com/media/products/2043/HPER-LIFE-035A-1-1.jpg', '[{\"type\":\"Varian\",\"options\":[{\"value\":\"Total 10 450ml\",\"price\":29000,\"barcode\":\"8999999045316\"},{\"value\":\"Lemon Fresh 450ml\",\"price\":30500,\"barcode\":\"8999999045323\"},{\"value\":\"Mild Care 450ml\",\"price\":30000,\"barcode\":\"8999999045330\"},{\"value\":\"Cool Fresh 450ml\",\"price\":29500,\"barcode\":\"8999999045347\"}]}]', '2025-11-05 15:45:25', '2025-11-05 16:22:27'),
(55, 1, '8996001302046', 'Roma Kelapa', 'roma-kelapa', 'Biskuit kelapa renyah dengan aroma khas dan rasa gurih manis seimbang.', 'Roma Kelapa merupakan biskuit legendaris yang dibuat dari perpaduan tepung terigu pilihan dan parutan kelapa asli. Mengandung vitamin dan mineral, cocok untuk teman minum teh atau kopi. Kemasan 300 gram ekonomis untuk konsumsi keluarga.', 11000.00, 100, 10, 'Roma', 'https://cdn-klik.klikindomaret.com/klik-catalog/product/10031595_1.jpg', NULL, '2025-11-05 15:47:16', '2025-11-05 15:47:16');

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
(1, 136, 43, 2, 5, 'sangat bagus', NULL, NULL, NULL, '2025-11-03 14:33:33', '2025-11-03 15:26:33'),
(2, 143, 43, 2, 5, 'kelas cuy', 'oke', 3, '2025-11-03 15:27:42', '2025-11-03 15:27:06', '2025-11-03 15:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `reward_vouchers`
--

CREATE TABLE `reward_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('free_shipping','price_discount') NOT NULL DEFAULT 'free_shipping',
  `shipping_method` varchar(255) DEFAULT NULL,
  `shipping_method_name` varchar(255) DEFAULT NULL,
  `discount_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `points_required` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_vouchers`
--

INSERT INTO `reward_vouchers` (`id`, `name`, `type`, `shipping_method`, `shipping_method_name`, `discount_amount`, `points_required`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(19, 'Gratis Ongkir Si Kere', 'free_shipping', 'si_kere', 'Si Kere', 0, 50, 'Voucher gratis ongkir untuk metode pengiriman Si Kere', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43'),
(20, 'Gratis Ongkir Si Hemat', 'free_shipping', 'si_hemat', 'Si Hemat', 0, 100, 'Voucher gratis ongkir untuk metode pengiriman Si Hemat', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43'),
(21, 'Gratis Ongkir Si Normal', 'free_shipping', 'si_normal', 'Si Normal', 0, 160, 'Voucher gratis ongkir untuk metode pengiriman Si Normal', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43'),
(22, 'Gratis Ongkir Sahabat Kasir', 'free_shipping', 'sahabat_kasir', 'Sahabat Kasir', 0, 240, 'Voucher gratis ongkir untuk metode pengiriman Sahabat Kasir', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43'),
(23, 'Gratis Ongkir Si Sultan', 'free_shipping', 'si_sultan', 'Si Sultan', 0, 320, 'Voucher gratis ongkir untuk metode pengiriman Si Sultan', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43'),
(24, 'Gratis Ongkir Crazy Rich', 'free_shipping', 'crazy_rich', 'Crazy Rich', 0, 400, 'Voucher gratis ongkir untuk metode pengiriman Crazy Rich', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43'),
(25, 'Diskon Rp 25.000', 'price_discount', NULL, NULL, 25000, 800, 'Potongan harga Rp 25.000 untuk total belanja', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43'),
(26, 'Diskon Rp 50.000', 'price_discount', NULL, NULL, 50000, 1500, 'Potongan harga Rp 50.000 untuk total belanja', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43'),
(27, 'Diskon Rp 100.000', 'price_discount', NULL, NULL, 100000, 2800, 'Potongan harga Rp 100.000 untuk total belanja', 1, '2025-10-30 01:25:43', '2025-10-30 01:25:43');

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
('CKr5Wmvfrdy1vDMdXeychiG2Pj9l0HuLiNXMKQzF', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU1d5SXA4bkYwTkE5b0s1eUZ1cUg2bFhMaDF2QTlHZXN3SjQzOHBCcyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Byb2R1Y3RzLzUwL2VkaXQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXNpci9jdXN0b21lci1kaXNwbGF5LWFwaT9kZXZpY2VfaWQ9Q0QtMTc2MjE4NTY5MTUxNy00OG9uYWxoNXAmc2Vzc2lvbl9pZD1LUy0xNzYyMDA4MjE4NjI1LWU0Njc5Njk1YSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czo5OiJ1c2VyX3JvbGUiO3M6NToia2FzaXIiO30=', 1762360631),
('KSXYcPyUsNmF63peKzkNcUILq1aRzsFqe4DPu6zL', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNWxYb3M3R2sxSzFrbDhZbWtkMW95djdDQjY4blVacEZ4eG1XcDNZUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub3RpZmljYXRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6InVzZXJfcm9sZSI7czo2OiJtZW1iZXIiO30=', 1762360493),
('y3P2sUCBHpRtVcRzShohDJohgjyLD3LmDafM1WIs', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUFU2SWhhSXJmMWxyTlJYdEZuSG5mVFFyYllRNTBBdlNoZnB6NHlmayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2NhcnQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo5OiJ1c2VyX3JvbGUiO3M6NToiYWRtaW4iO30=', 1762359867);

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
(1, 'Demo User', 'demo@example.com', 'member', NULL, '$2y$12$qq/Er1fpSkhJAb5kvXOcVeVP/8DJj/mqhUhAToH3TkvrDqjkHK4BC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-30 01:21:02', '2025-10-30 01:21:02'),
(2, 'Member', 'member@gmail.com', 'member', NULL, '$2y$12$svGcasLHlmA7ph8/lLoUwO5YUH8lFy9YCtSRQtvl6hvwII9o.ftUG', '082122780082', 'profile-photos/KswlY4lSIvYVyr2RKoHHux5q0ZYimSSdt7Ea98uq.jpg', 'male', '2007-11-04', 'Jl. Pahlawan Revolusi No.22B, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430', 'Jakarta Timur', 'DKI Jakarta', '13430', NULL, '2025-10-30 01:23:41', '2025-11-03 14:23:51'),
(3, 'Admin', 'admin@gmail.com', 'admin', NULL, '$2y$12$i/fz7zgyMl.l7YgCzNfAJ.OaJ4p90pNB/N2/pBivPG75akWFPe21K', NULL, 'profile-photos/taUkJTtaLY06D0EmGpxBpML2iP7NgYodhbC6pQNA.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-30 02:10:37', '2025-11-05 07:41:07'),
(4, 'lingga kasir', 'kasir@gmail.com', 'kasir', NULL, '$2y$12$akYKd7ch5WvVe2nG/fKrjuMYvhaNkvBp1yXbSVtFK7HCeqBXPTBe2', NULL, 'profile-photos/5X2Rqmr1a4oearfHaWb1g8DWabnqn0jw6ksYpp0q.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-30 02:22:43', '2025-11-04 15:48:00'),
(5, 'Kasir2', 'kasir123@gmail.com', 'kasir', NULL, '$2y$12$tWxq6EYZN1BxQErZAJbESOZUiVX7dC2kPhbfQsxmrzf9TRStedlDG', NULL, NULL, 'male', '2007-11-04', NULL, NULL, NULL, NULL, NULL, '2025-10-30 13:00:24', '2025-10-30 13:00:24'),
(7, 'tester', 'tester@gmail.com', 'member', NULL, '$2y$12$ONm5mptoiml1RhxxDswaLuPNsFyE1u9uIbd4CSrZyEPCtKUH0SOj6', '09088928320', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-03 15:59:16', '2025-11-03 15:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_points`
--

CREATE TABLE `user_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_points`
--

INSERT INTO `user_points` (`id`, `user_id`, `points`, `created_at`, `updated_at`) VALUES
(1, 2, 36384, '2025-10-30 13:03:55', '2025-11-05 16:34:50'),
(2, 7, 5, '2025-11-03 15:59:16', '2025-11-03 15:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_vouchers`
--

CREATE TABLE `user_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reward_voucher_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `redeemed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `used_at` timestamp NULL DEFAULT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_vouchers`
--

INSERT INTO `user_vouchers` (`id`, `user_id`, `reward_voucher_id`, `order_id`, `redeemed_at`, `used_at`, `is_used`, `created_at`, `updated_at`) VALUES
(1, 2, 24, 14, '2025-10-31 12:33:15', '2025-10-31 12:33:15', 1, '2025-10-31 06:44:32', '2025-10-31 12:33:15'),
(2, 2, 24, 76, '2025-11-03 14:53:29', '2025-11-03 14:53:29', 1, '2025-10-31 12:38:49', '2025-11-03 14:53:29'),
(3, 2, 24, 50, '2025-11-01 17:01:46', '2025-11-01 17:01:46', 1, '2025-10-31 15:00:47', '2025-11-01 17:01:46'),
(4, 2, 19, 73, '2025-11-02 13:50:53', '2025-11-02 13:50:53', 1, '2025-11-02 13:49:56', '2025-11-02 13:50:53'),
(5, 2, 24, 78, '2025-11-03 15:22:00', '2025-11-03 15:22:00', 1, '2025-11-03 14:24:44', '2025-11-03 15:22:00'),
(6, 2, 24, 92, '2025-11-04 13:40:35', '2025-11-04 13:40:35', 1, '2025-11-04 13:40:03', '2025-11-04 13:40:35'),
(7, 2, 24, 104, '2025-11-05 15:29:24', '2025-11-05 15:29:24', 1, '2025-11-05 15:29:09', '2025-11-05 15:29:24');

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
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `daily_rewards`
--
ALTER TABLE `daily_rewards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `daily_rewards_user_id_unique` (`user_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_member_id_foreign` (`member_id`);

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
-- Indexes for table `point_transactions`
--
ALTER TABLE `point_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_transactions_user_id_foreign` (`user_id`),
  ADD KEY `point_transactions_order_id_foreign` (`order_id`);

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
-- Indexes for table `reward_vouchers`
--
ALTER TABLE `reward_vouchers`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `user_points`
--
ALTER TABLE `user_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_points_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_vouchers_user_id_foreign` (`user_id`),
  ADD KEY `user_vouchers_reward_voucher_id_foreign` (`reward_voucher_id`),
  ADD KEY `user_vouchers_order_id_foreign` (`order_id`);

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
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `daily_rewards`
--
ALTER TABLE `daily_rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `order_cancellation_requests`
--
ALTER TABLE `order_cancellation_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `point_transactions`
--
ALTER TABLE `point_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reward_vouchers`
--
ALTER TABLE `reward_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_points`
--
ALTER TABLE `user_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Constraints for table `daily_rewards`
--
ALTER TABLE `daily_rewards`
  ADD CONSTRAINT `daily_rewards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
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
-- Constraints for table `point_transactions`
--
ALTER TABLE `point_transactions`
  ADD CONSTRAINT `point_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `point_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `user_points`
--
ALTER TABLE `user_points`
  ADD CONSTRAINT `user_points_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  ADD CONSTRAINT `user_vouchers_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_vouchers_reward_voucher_id_foreign` FOREIGN KEY (`reward_voucher_id`) REFERENCES `reward_vouchers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_vouchers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
