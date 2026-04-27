-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2026 at 09:38 AM
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
-- Database: `konstruksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Memperbarui proyek: Renovasi Gedung Juang', '2026-04-21 00:33:54', '2026-04-21 00:33:54'),
(2, 1, 'Membuat proyek baru: pembuatan hotel', '2026-04-21 00:34:36', '2026-04-21 00:34:36'),
(3, 1, 'Memperbarui proyek: Renovasi Gedung olahraga', '2026-04-21 02:17:53', '2026-04-21 02:17:53'),
(4, 1, 'Membuat proyek baru: pembuatan hotel di cirebon', '2026-04-22 05:19:15', '2026-04-22 05:19:15'),
(5, 1, 'Menambahkan Supplier: perusahaan cobaan', '2026-04-24 23:42:26', '2026-04-24 23:42:26'),
(6, 4, 'Menambahkan Master Material: Semen Tiga Roda', '2026-04-24 23:56:46', '2026-04-24 23:56:46'),
(7, 4, 'Menambahkan Supplier: PT Semen Indonesia', '2026-04-24 23:58:04', '2026-04-24 23:58:04'),
(8, 1, 'Menambahkan Master Material: besi', '2026-04-25 00:05:41', '2026-04-25 00:05:41'),
(9, 3, 'Menambahkan Master Material: besi', '2026-04-25 00:10:33', '2026-04-25 00:10:33'),
(10, 1, 'Menambah material batu ke proyek Pembangunan Jembatan Merdeka', '2026-04-26 19:39:55', '2026-04-26 19:39:55'),
(11, 1, 'Menambah material semen ke proyek Pembangunan Jembatan Merdeka', '2026-04-26 19:40:38', '2026-04-26 19:40:38'),
(12, 1, 'Memperbarui Master Material: Semen (Sak)', '2026-04-26 19:42:44', '2026-04-26 19:42:44'),
(13, 1, 'Mengajukan Permintaan Material MR-20260427-3B0C', '2026-04-26 20:34:11', '2026-04-26 20:34:11'),
(14, 1, 'Menambah material Semen Tiga Roda ke proyek Pembangunan Jembatan Merdeka', '2026-04-26 20:34:36', '2026-04-26 20:34:36'),
(15, 2, 'Mengajukan Permintaan Material MR-20260427-8EC8', '2026-04-26 23:06:09', '2026-04-26 23:06:09'),
(16, 3, 'Membuat Purchase Order PO-20260427-3A0C', '2026-04-26 23:08:51', '2026-04-26 23:08:51'),
(17, 3, 'Membuat draft Stock Opname tanggal 2026-04-27', '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(18, 1, 'Menyetujui permintaan material MR-20260427-8EC8', '2026-04-26 23:11:02', '2026-04-26 23:11:02'),
(19, 1, 'Menambah material semen ke proyek Renovasi Gedung olahraga', '2026-04-26 23:14:16', '2026-04-26 23:14:16'),
(20, 1, 'Memperbarui material semen pada proyek Pembangunan Jembatan Merdeka', '2026-04-27 00:17:07', '2026-04-27 00:17:07'),
(21, 1, 'Menghapus material semen dari proyek Pembangunan Jembatan Merdeka', '2026-04-27 00:21:26', '2026-04-27 00:21:26'),
(22, 1, 'Memperbarui material Semen Tiga Roda pada proyek Pembangunan Jembatan Merdeka', '2026-04-27 00:34:45', '2026-04-27 00:34:45');

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
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_material` varchar(255) DEFAULT NULL,
  `nama_material` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL DEFAULT 'pcs',
  `jumlah_tersedia` int(11) NOT NULL DEFAULT 0,
  `min_stock` int(11) NOT NULL DEFAULT 0,
  `max_stock` int(11) NOT NULL DEFAULT 0,
  `reorder_point` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `kode_material`, `nama_material`, `satuan`, `jumlah_tersedia`, `min_stock`, `max_stock`, `reorder_point`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Semen (Sak)', 'pcs', 3000, 0, 0, 0, '2026-04-21 00:29:02', '2026-04-26 19:42:44'),
(2, NULL, 'Pasir (M3)', 'pcs', 100, 0, 0, 0, '2026-04-21 00:29:02', '2026-04-21 00:29:02'),
(3, NULL, 'Besi Beton', 'pcs', 50, 0, 0, 0, '2026-04-21 00:29:02', '2026-04-21 00:29:02'),
(4, NULL, 'Batu Bata', 'pcs', 1000, 0, 0, 0, '2026-04-21 00:29:02', '2026-04-21 00:29:02'),
(5, NULL, 'Cat Tembok (Pail)', 'pcs', 155, 0, 0, 0, '2026-04-21 00:29:02', '2026-04-21 00:33:29'),
(6, NULL, 'Keramik 40x40', 'pcs', 300, 0, 0, 0, '2026-04-21 00:29:02', '2026-04-21 00:33:39'),
(8, 'MAT-001', 'Semen Tiga Roda', 'Sak', 100, 20, 500, 500, '2026-04-24 23:56:46', '2026-04-24 23:56:46'),
(9, 'bsi', 'besi', 'pcs', 10, 10, 100, 99, '2026-04-25 00:05:41', '2026-04-25 00:05:41'),
(10, 'base', 'besi', 'pcs', 0, 0, 0, 0, '2026-04-25 00:10:33', '2026-04-25 00:10:33'),
(11, NULL, 'semen', 'pcs', 320, 0, 0, 0, '2026-04-26 19:39:55', '2026-04-27 00:17:07'),
(12, NULL, 'semen', 'pcs', 100, 0, 0, 0, '2026-04-26 19:40:38', '2026-04-26 19:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `material_requests`
--

CREATE TABLE `material_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_number` varchar(255) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `manager_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected','shipped','received') NOT NULL DEFAULT 'pending',
  `request_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_requests`
--

INSERT INTO `material_requests` (`id`, `request_number`, `project_id`, `manager_id`, `status`, `request_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'MR-20260427-3B0C', 3, 1, 'pending', '2026-04-27', 'semen', '2026-04-26 20:34:11', '2026-04-26 20:34:11'),
(2, 'MR-20260427-8EC8', 1, 2, 'approved', '2026-04-27', 'kurang bahan', '2026-04-26 23:06:09', '2026-04-26 23:11:02');

-- --------------------------------------------------------

--
-- Table structure for table `material_request_items`
--

CREATE TABLE `material_request_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_request_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_request_items`
--

INSERT INTO `material_request_items` (`id`, `material_request_id`, `material_id`, `quantity`, `priority`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 10, 'medium', '2026-04-26 20:34:11', '2026-04-26 20:34:11'),
(2, 2, 4, 100, 'medium', '2026-04-26 23:06:09', '2026-04-26 23:06:09');

-- --------------------------------------------------------

--
-- Table structure for table `material_transactions`
--

CREATE TABLE `material_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('order','stock_in','dispatch') NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_transactions`
--

INSERT INTO `material_transactions` (`id`, `user_id`, `material_id`, `type`, `quantity`, `description`, `created_at`, `updated_at`) VALUES
(3, 1, 5, 'stock_in', 50, 'masuk', '2026-04-21 00:32:55', '2026-04-21 00:32:55'),
(4, 1, 5, 'stock_in', 100, NULL, '2026-04-21 00:33:29', '2026-04-21 00:33:29'),
(5, 1, 6, 'stock_in', 300, NULL, '2026-04-21 00:33:39', '2026-04-21 00:33:39'),
(6, 3, 1, 'stock_in', 10, NULL, '2026-04-22 01:51:26', '2026-04-22 01:51:26'),
(7, 1, 11, 'stock_in', 100, NULL, '2026-04-26 19:40:53', '2026-04-26 19:40:53'),
(8, 1, 11, 'stock_in', 100, NULL, '2026-04-26 19:40:55', '2026-04-26 19:40:55'),
(9, 1, 11, 'stock_in', 20, NULL, '2026-04-26 19:41:05', '2026-04-26 19:41:05'),
(10, 1, 11, 'order', 100, 'dd', '2026-04-26 19:41:21', '2026-04-26 19:41:21');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_20_063400_create_projects_table', 1),
(6, '2026_04_20_063550_create_materials_table', 1),
(7, '2026_04_21_042908_add_role_to_users_table', 1),
(8, '2026_04_21_042923_add_user_id_to_projects_table', 1),
(9, '2026_04_21_042951_create_activity_logs_table', 1),
(10, '2026_04_21_054250_add_assigned_project_id_to_users_table', 1),
(11, '2026_04_21_054258_create_material_transactions_table', 1),
(12, '2026_04_21_063037_update_users_and_projects_for_tracking', 1),
(13, '2026_04_25_062143_create_suppliers_table', 2),
(14, '2026_04_25_062204_create_purchase_orders_table', 2),
(15, '2026_04_25_062205_create_purchase_order_items_table', 2),
(16, '2026_04_25_062207_create_material_requests_table', 2),
(17, '2026_04_25_062208_create_material_request_items_table', 2),
(18, '2026_04_25_062210_create_project_progress_updates_table', 2),
(19, '2026_04_25_062211_create_project_material_usages_table', 2),
(20, '2026_04_25_062213_create_stock_opnames_table', 2),
(21, '2026_04_25_062214_create_stock_opname_items_table', 2),
(22, '2026_04_25_062215_create_project_materials_table', 2),
(23, '2026_04_25_062216_update_materials_table_for_global_master', 2),
(24, '2026_04_27_032711_add_stock_fields_to_project_materials_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@gmail.com', '$2y$10$xVaskSJLleWR89U0CV4XJu7G2otPrPuYbCH2uKcm/mAgdw5YZs5rO', '2026-04-24 23:54:29'),
('gudang@gmail.com', '$2y$10$YkiiHSC/eDKVnzTg4Ezhyuarqs/TOvCn4xtNcg.fBcpBozf3DbDJ6', '2026-04-24 23:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_proyek` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_proyek` enum('berjalan','selesai') NOT NULL DEFAULT 'berjalan',
  `progres` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `manager_id`, `nama_proyek`, `lokasi`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`, `status_proyek`, `progres`) VALUES
(1, 2, 'Pembangunan Jembatan Merdeka', 'Bandung, Jawa Barat', '2026-05-01', '2026-12-31', '2026-04-21 00:29:02', '2026-04-21 00:29:13', 'berjalan', 25),
(2, 2, 'Renovasi Gedung olahraga', 'Jakarta Pusat', '2026-06-15', '2026-11-20', '2026-04-21 00:29:02', '2026-04-21 02:17:53', 'selesai', 100),
(3, 2, 'pembuatan hotel', 'cirebon,jabar', '2026-04-17', '2026-04-22', '2026-04-21 00:34:36', '2026-04-21 00:34:36', 'berjalan', 20),
(4, 2, 'pembuatan hotel di cirebon', 'cirebon,jabar', '2026-04-17', '2026-04-22', '2026-04-22 05:19:15', '2026-04-22 05:19:15', 'berjalan', 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_materials`
--

CREATE TABLE `project_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_kebutuhan` int(11) NOT NULL DEFAULT 0,
  `jumlah_dialokasikan` int(11) NOT NULL DEFAULT 0,
  `jumlah_tersedia` int(11) NOT NULL DEFAULT 0,
  `total_diterima` int(11) NOT NULL DEFAULT 0,
  `sisa_kebutuhan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_materials`
--

INSERT INTO `project_materials` (`id`, `project_id`, `material_id`, `jumlah_kebutuhan`, `jumlah_dialokasikan`, `jumlah_tersedia`, `total_diterima`, `sisa_kebutuhan`, `created_at`, `updated_at`) VALUES
(2, 1, 12, 100, 0, 0, 0, 100, '2026-04-26 19:40:38', '2026-04-26 19:40:38'),
(3, 1, 8, 500, 0, 0, 0, 500, '2026-04-26 20:34:36', '2026-04-27 00:34:45'),
(4, 2, 12, 100, 0, 0, 0, 100, '2026-04-26 23:14:16', '2026-04-26 23:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `project_material_usages`
--

CREATE TABLE `project_material_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_progress_update_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_used` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_progress_updates`
--

CREATE TABLE `project_progress_updates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `manager_id` bigint(20) UNSIGNED NOT NULL,
  `progress_percentage` decimal(5,2) NOT NULL,
  `description` text NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','completed','cancelled') NOT NULL DEFAULT 'pending',
  `expected_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `po_number`, `supplier_id`, `status`, `expected_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'PO-20260427-3A0C', 1, 'pending', '2026-04-27', 'beli besi', '2026-04-26 23:08:51', '2026-04-26 23:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`id`, `purchase_order_id`, `material_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 100, 5000.00, '2026-04-26 23:08:51', '2026-04-26 23:08:51'),
(2, 1, 11, 199, 50000.00, '2026-04-26 23:08:51', '2026-04-26 23:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `stock_opnames`
--

CREATE TABLE `stock_opnames` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('draft','completed') NOT NULL DEFAULT 'draft',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_opnames`
--

INSERT INTO `stock_opnames` (`id`, `date`, `user_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, '2026-04-27', 3, 'draft', 'beli bahan', '2026-04-26 23:09:19', '2026-04-26 23:09:19');

-- --------------------------------------------------------

--
-- Table structure for table `stock_opname_items`
--

CREATE TABLE `stock_opname_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_opname_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `system_stock` int(11) NOT NULL,
  `physical_stock` int(11) NOT NULL,
  `difference` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_opname_items`
--

INSERT INTO `stock_opname_items` (`id`, `stock_opname_id`, `material_id`, `system_stock`, `physical_stock`, `difference`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 11, 320, 320, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(2, 1, 4, 1000, 1000, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(3, 1, 9, 10, 10, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(4, 1, 10, 0, 0, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(5, 1, 3, 50, 50, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(6, 1, 5, 155, 155, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(7, 1, 6, 300, 300, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(8, 1, 2, 100, 100, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(9, 1, 12, 100, 100, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(10, 1, 1, 3000, 3000, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19'),
(11, 1, 8, 100, 100, 0, NULL, '2026-04-26 23:09:19', '2026-04-26 23:09:19');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'perusahaan cobaan', 'ali', '0893330333', 'cirebon', '2026-04-24 23:42:26', '2026-04-24 23:42:26'),
(2, 'PT Semen Indonesia', 'Budi', '08123456789', 'Jakarta', '2026-04-24 23:58:04', '2026-04-24 23:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manajer','gudang') NOT NULL DEFAULT 'gudang',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned_project_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `assigned_project_id`) VALUES
(1, 'Admin User', 'admin@gmail.com', NULL, '$2y$10$pQOVdDPgwykfZA.pUoVT5u4.vCWpdyeFWgwKfByZfKTEgYdJyv4TG', 'admin', 'fY3zu6vqTlUyIoNzfgQdb2DuEEjw9D4I7DISQk85pn3Oot5kQqSi8AclBRC2', '2026-04-21 00:29:02', '2026-04-21 00:29:02', NULL),
(2, 'Manager User', 'manager@gmail.com', NULL, '$2y$10$Cq9Z3UHhyMFCcn4FiFjheew0RRBfVDlF2iSc6Ia5XNtSkk3HNizx6', 'manajer', NULL, '2026-04-21 00:29:02', '2026-04-25 00:06:16', NULL),
(3, 'Gudang User', 'gudang@gmail.com', NULL, '$2y$10$jGYpEuHtzB2Tn4jerCyRJ.zRauWKVhINKFUI0Dixh4s4p1wXrADba', 'gudang', NULL, '2026-04-21 00:29:02', '2026-04-21 00:29:02', 1),
(4, 'Tester', 'tester@gmail.com', NULL, '$2y$10$zIao/1IGvfDw/gOPRdHACeZcKD8az5xZYjGDAy40RqpHcF6aiiTLO', 'gudang', NULL, '2026-04-24 23:55:37', '2026-04-25 00:08:00', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `materials_kode_material_unique` (`kode_material`);

--
-- Indexes for table `material_requests`
--
ALTER TABLE `material_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_requests_request_number_unique` (`request_number`),
  ADD KEY `material_requests_project_id_foreign` (`project_id`),
  ADD KEY `material_requests_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `material_request_items`
--
ALTER TABLE `material_request_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_request_items_material_request_id_foreign` (`material_request_id`),
  ADD KEY `material_request_items_material_id_foreign` (`material_id`);

--
-- Indexes for table `material_transactions`
--
ALTER TABLE `material_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_transactions_user_id_foreign` (`user_id`),
  ADD KEY `material_transactions_material_id_foreign` (`material_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_user_id_foreign` (`manager_id`);

--
-- Indexes for table `project_materials`
--
ALTER TABLE `project_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_materials_project_id_foreign` (`project_id`),
  ADD KEY `project_materials_material_id_foreign` (`material_id`);

--
-- Indexes for table `project_material_usages`
--
ALTER TABLE `project_material_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_material_usages_material_id_foreign` (`material_id`);

--
-- Indexes for table `project_progress_updates`
--
ALTER TABLE `project_progress_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_progress_updates_project_id_foreign` (`project_id`),
  ADD KEY `project_progress_updates_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_items_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `purchase_order_items_material_id_foreign` (`material_id`);

--
-- Indexes for table `stock_opnames`
--
ALTER TABLE `stock_opnames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_opnames_user_id_foreign` (`user_id`);

--
-- Indexes for table `stock_opname_items`
--
ALTER TABLE `stock_opname_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_opname_items_stock_opname_id_foreign` (`stock_opname_id`),
  ADD KEY `stock_opname_items_material_id_foreign` (`material_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `material_requests`
--
ALTER TABLE `material_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_request_items`
--
ALTER TABLE `material_request_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_transactions`
--
ALTER TABLE `material_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_materials`
--
ALTER TABLE `project_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_material_usages`
--
ALTER TABLE `project_material_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_progress_updates`
--
ALTER TABLE `project_progress_updates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_opnames`
--
ALTER TABLE `stock_opnames`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_opname_items`
--
ALTER TABLE `stock_opname_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_requests`
--
ALTER TABLE `material_requests`
  ADD CONSTRAINT `material_requests_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_requests_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_request_items`
--
ALTER TABLE `material_request_items`
  ADD CONSTRAINT `material_request_items_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_request_items_material_request_id_foreign` FOREIGN KEY (`material_request_id`) REFERENCES `material_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_transactions`
--
ALTER TABLE `material_transactions`
  ADD CONSTRAINT `material_transactions_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_materials`
--
ALTER TABLE `project_materials`
  ADD CONSTRAINT `project_materials_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_materials_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_material_usages`
--
ALTER TABLE `project_material_usages`
  ADD CONSTRAINT `project_material_usages_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_progress_updates`
--
ALTER TABLE `project_progress_updates`
  ADD CONSTRAINT `project_progress_updates_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_progress_updates_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD CONSTRAINT `purchase_order_items_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_order_items_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_opnames`
--
ALTER TABLE `stock_opnames`
  ADD CONSTRAINT `stock_opnames_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_opname_items`
--
ALTER TABLE `stock_opname_items`
  ADD CONSTRAINT `stock_opname_items_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_opname_items_stock_opname_id_foreign` FOREIGN KEY (`stock_opname_id`) REFERENCES `stock_opnames` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
