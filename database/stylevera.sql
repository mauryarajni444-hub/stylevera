-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2026 at 09:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stylevera`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(300) DEFAULT NULL,
  `title_ar` varchar(300) DEFAULT NULL,
  `subtitle_en` varchar(500) DEFAULT NULL,
  `subtitle_ar` varchar(500) DEFAULT NULL,
  `image` varchar(2000) NOT NULL,
  `link` varchar(2000) DEFAULT NULL,
  `button_text_en` varchar(100) DEFAULT 'Discover Now',
  `button_text_ar` varchar(100) DEFAULT 'اكتشف الآن',
  `position` enum('hero','promo') DEFAULT 'hero',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title_en`, `title_ar`, `subtitle_en`, `subtitle_ar`, `image`, `link`, `button_text_en`, `button_text_ar`, `position`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Soft Leather Jackets', 'جاكيتات جلد ناعمة', 'Scelerisque duis aliquam qui lorem ipsum dolor amet.', 'اكتشف مجموعتنا من الجاكيتات الجلدية.', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/banners/1/1781079779_6a291ee345f49.jpeg', '/shop', 'Discover Now', 'اكتشف الآن', 'hero', 1, 1, '2026-06-09 19:10:39', '2026-06-10 02:53:01'),
(2, 'New Collections', 'مجموعات جديدة', 'Premium fashion for the modern lifestyle.', 'أزياء فاخرة لأسلوب الحياة العصري.', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/banners/2/1781079444_6a291d942f320.jpeg', '/shop', 'Shop Now', 'تسوق الآن', 'hero', 2, 1, '2026-06-09 19:10:39', '2026-06-10 02:47:26'),
(3, 'Out Crop Sweater', 'سويتر قصير', 'Scelerisque duis aliquam qui lorem ipsum.', 'أحدث صيحات الموضة.', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/banners/3/1781079918_6a291f6e29c38.jpeg', '/shop', 'Discover Now', 'اكتشف الآن', 'hero', 3, 1, '2026-06-09 19:10:39', '2026-06-10 02:55:20'),
(4, 'Summer Essentials', 'أساسيات الصيف', 'Light fabrics for warm UAE days.', 'أقمشة خفيفة لأيام الإمارات.', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/banners/4/1781080157_6a29205de107e.jpeg', '/shop', 'Shop Now', 'تسوق الآن', 'hero', 4, 1, '2026-06-09 19:10:39', '2026-06-10 02:59:19'),
(5, 'Classic Collection', 'المجموعة الكلاسيكية', 'Timeless pieces for every wardrobe.', 'قطع خالدة لكل خزانة.', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/banners/5/1781080387_6a2921438d3a7.jpeg', '/shop', 'Discover Now', 'اكتشف الآن', 'hero', 5, 1, '2026-06-09 19:10:39', '2026-06-10 03:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'sv_6a2868324a947', '2026-06-09 13:53:30', '2026-06-09 13:53:30'),
(2, NULL, 'sv_6a28e27af1833', '2026-06-09 22:35:15', '2026-06-09 22:35:15'),
(4, NULL, 'sv_6a29588e37d5e', '2026-06-10 06:59:02', '2026-06-10 06:59:02'),
(5, 1, NULL, '2026-06-10 07:46:53', '2026-06-10 07:46:53'),
(6, NULL, 'sv_6a29acc6f004f', '2026-06-10 12:58:23', '2026-06-10 12:58:23'),
(7, NULL, 'sv_6a2a6429d631e', '2026-06-11 02:00:49', '2026-06-11 02:00:49'),
(8, NULL, 'sv_6a2a8734ecf51', '2026-06-11 04:30:21', '2026-06-11 04:30:21'),
(9, NULL, 'sv_6a2ab6b8b970f', '2026-06-11 07:53:04', '2026-06-11 07:53:04'),
(10, NULL, 'sv_6a2b92fbea495', '2026-06-11 23:32:52', '2026-06-11 23:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `variant_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 4, 5, 15, 1, 799.00, '2026-06-10 06:59:20', '2026-06-10 06:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(300) NOT NULL,
  `name_ar` varchar(300) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `description_en` text DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `image` varchar(2000) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_en`, `name_ar`, `slug`, `description_en`, `description_ar`, `image`, `parent_id`, `sort_order`, `is_active`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Women', 'نساء', 'women', 'Elegant fashion for women', 'أزياء أنيقة للمرأة', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/categories/1/1781118225_6a29b5116feeb.jpeg', NULL, 1, 1, 1, '2026-06-09 19:10:39', '2026-06-10 13:33:54'),
(2, 'Men', 'رجال', 'men', 'Fashion for men', 'أزياء للرجل', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/categories/2/1781118250_6a29b52a690e9.jpeg', NULL, 2, 1, 1, '2026-06-09 19:10:39', '2026-06-10 13:34:12'),
(3, 'Accessories', 'إكسسوارات', 'accessories', 'Fashion accessories', 'إكسسوارات أزياء', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/categories/3/1781118512_6a29b630a076f.jpeg', NULL, 3, 1, 1, '2026-06-09 19:10:39', '2026-06-10 13:38:34'),
(4, 'Jackets', 'جاكيتات', 'jackets', 'Premium jackets', 'جاكيتات فاخرة', NULL, NULL, 4, 1, 0, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(5, 'Dresses', 'فساتين', 'dresses', 'Elegant dresses', 'فساتين أنيقة', NULL, NULL, 5, 1, 0, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(6, 'Shirts', 'قمصان', 'shirts', 'Classic shirts', 'قمصان كلاسيكية', NULL, NULL, 6, 1, 0, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(7, 'Sweaters', 'سويترات', 'sweaters', 'Cozy sweaters', 'سويترات مريحة', NULL, NULL, 7, 1, 0, '2026-06-09 19:10:39', '2026-06-09 19:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(300) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` enum('percent','fixed') DEFAULT 'percent',
  `value` decimal(10,2) NOT NULL,
  `min_order` decimal(10,2) DEFAULT 0.00,
  `max_uses` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `expires_at` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `min_order`, `max_uses`, `used_count`, `expires_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'STYLEVERA10', 'percent', 10.00, 200.00, 500, 0, '2026-12-31', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(2, 'WELCOME50', 'fixed', 50.00, 300.00, 100, 0, '2026-12-31', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(3, 'SUMMER20', 'percent', 20.00, 400.00, 200, 0, '2026-12-31', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(4, 'FREESHIP', 'fixed', 30.00, 150.00, NULL, 0, '2026-12-31', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(5, 'VIP25', 'percent', 25.00, 500.00, 50, 0, '2026-12-31', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_number` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_name` varchar(200) DEFAULT NULL,
  `guest_email` varchar(200) DEFAULT NULL,
  `guest_phone` varchar(30) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_country` varchar(100) DEFAULT 'UAE',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) DEFAULT 'AED',
  `coupon_code` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `ref_number`, `user_id`, `guest_name`, `guest_email`, `guest_phone`, `shipping_address`, `shipping_city`, `shipping_country`, `subtotal`, `shipping_fee`, `discount`, `total`, `currency`, `coupon_code`, `payment_method`, `payment_status`, `status`, `notes`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 'SV-2026-LBHD4H', 1, 'Master Admin', 'pritam156777@gmail.com', '8081453976', 'Raebareli', 'Dubai', 'UAE', 578.00, 0.00, 0.00, 578.00, 'AED', NULL, 'card', 'pending', 'pending', 'Test', NULL, '2026-06-10 07:46:52', '2026-06-10 07:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(500) NOT NULL,
  `variant_name` varchar(300) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `variant_id`, `product_name`, `variant_name`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 6, NULL, 'Floral Summer Dress', NULL, 2, 289.00, 578.00, '2026-06-10 07:46:52', '2026-06-10 07:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(300) NOT NULL,
  `title_ar` varchar(300) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `content_en` longtext DEFAULT NULL,
  `content_ar` longtext DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title_en`, `title_ar`, `slug`, `content_en`, `content_ar`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Privacy Policy', 'سياسة الخصوصية', 'privacy', '<h2>Privacy Policy</h2><p>At Stylevera, your privacy matters.</p>', '<h2>سياسة الخصوصية</h2><p>في ستايل فيرا، خصوصيتك تهمنا.</p>', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(2, 'Terms & Conditions', 'الشروط والأحكام', 'terms', '<h2>Terms</h2><p>By using Stylevera you agree to these terms.</p>', '<h2>الشروط</h2><p>باستخدامك ستايل فيرا تقبل هذه الشروط.</p>', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(3, 'About Us', 'من نحن', 'about', '<h2>About Stylevera</h2><p>Premium fashion for the UAE.</p>', '<h2>عن ستايل فيرا</h2><p>أزياء فاخرة للإمارات.</p>', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(4, 'Return Policy', 'سياسة الإرجاع', 'returns', '<h2>Returns</h2><p>14-day returns on unworn items.</p>', '<h2>الإرجاع</h2><p>إرجاع خلال 14 يوماً للمنتجات غير المستخدمة.</p>', 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name_en` varchar(500) NOT NULL,
  `name_ar` varchar(500) NOT NULL,
  `slug` varchar(600) NOT NULL,
  `short_desc_en` varchar(1000) DEFAULT NULL,
  `short_desc_ar` varchar(1000) DEFAULT NULL,
  `description_en` longtext DEFAULT NULL,
  `description_ar` longtext DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `cover_image` varchar(2000) DEFAULT NULL,
  `gender` enum('men','women','unisex','kids') DEFAULT 'unisex',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_new_arrival` tinyint(1) DEFAULT 0,
  `is_best_seller` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `rating` decimal(3,1) DEFAULT 0.0,
  `reviews_count` int(11) DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name_en`, `name_ar`, `slug`, `short_desc_en`, `short_desc_ar`, `description_en`, `description_ar`, `base_price`, `sale_price`, `sku`, `cover_image`, `gender`, `is_featured`, `is_new_arrival`, `is_best_seller`, `is_active`, `sort_order`, `views`, `rating`, `reviews_count`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 5, 'Dark Florish Onepiece', 'فستان الزهور الداكن', 'dark-florish-onepiece', 'Elegant floral print dress.', 'فستان بطبعات زهور أنيق.', NULL, NULL, 349.00, NULL, NULL, 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/products/1/cover/1781198405_6a2aee45883fe.jpeg', 'women', 1, 1, 0, 1, 1, 43, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-11 11:50:07'),
(2, 6, 'Baggy Shirt', 'قميص باجي', 'baggy-shirt', 'Relaxed oversized shirt.', 'قميص فضفاض واسع.', NULL, NULL, 199.00, NULL, NULL, 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/products/2/cover/1781198507_6a2aeeabbbfeb.jpeg', 'men', 1, 1, 1, 1, 2, 2, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-11 11:51:49'),
(3, 6, 'Cotton Off-White Shirt', 'قميص قطني كريمي', 'cotton-off-white-shirt', 'Classic off-white cotton shirt.', 'قميص كلاسيكي بلون كريمي.', NULL, NULL, 249.00, NULL, NULL, 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/products/3/cover/1781198571_6a2aeeeb1e446.jpeg', 'men', 0, 1, 1, 1, 3, 4, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-11 11:52:53'),
(4, 7, 'Crop Sweater', 'سويتر قصير', 'crop-sweater', 'Cozy pastel crop sweater.', 'سويتر قصير بألوان باستيل.', NULL, NULL, 279.00, NULL, NULL, 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/products/4/cover/1781197127_6a2ae947563a7.jpeg', 'women', 1, 0, 1, 1, 4, 1, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-11 11:28:49'),
(5, 4, 'Soft Leather Jacket', 'جاكيت جلد ناعم', 'soft-leather-jacket', 'Premium genuine leather jacket.', 'جاكيت جلد طبيعي فاخر.', NULL, NULL, 899.00, NULL, NULL, 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/products/5/cover/1781198176_6a2aed60c7ba2.jpeg', 'unisex', 1, 0, 1, 1, 5, 4, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-11 11:46:18'),
(6, 5, 'Floral Summer Dress', 'فستان صيفي زهري', 'floral-summer-dress', 'Light summer dress.', 'فستان صيفي خفيف.', NULL, NULL, 289.00, NULL, NULL, 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/products/6/cover/1781247348_6a2bad747e4f7.jpeg', 'women', 0, 1, 0, 1, 6, 1, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-12 01:25:50'),
(7, 7, 'Handmade Crop Sweater', 'سويتر يدوي', 'handmade-crop-sweater', 'Artisan crop sweater.', 'سويتر مصنوع يدوياً.', NULL, NULL, 319.00, NULL, NULL, 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/products/7/cover/1781198709_6a2aef751cb27.jpeg', 'women', 0, 0, 1, 1, 7, 0, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-11 11:55:11'),
(8, 3, 'Classic Leather Belt', 'حزام جلد', 'classic-leather-belt', 'Full-grain leather belt.', 'حزام جلد كامل.', NULL, NULL, 149.00, NULL, NULL, '/images/product-item-8.jpg', 'unisex', 0, 0, 0, 1, 8, 0, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(9, 7, 'Out Crop Sweater', 'سويتر خارجي', 'out-crop-sweater', 'Versatile crop sweater.', 'سويتر متعدد الاستخدامات.', NULL, NULL, 259.00, NULL, NULL, '/images/product-item-9.jpg', 'women', 0, 1, 0, 1, 9, 0, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(10, 7, 'Dark Knit Sweater', 'سويتر تريكو', 'dark-knit-sweater', 'Dark cable-knit sweater.', 'سويتر منسوج داكن.', NULL, NULL, 299.00, NULL, NULL, 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/products/10/cover/1781198060_6a2aecec8b5a2.jpeg', 'unisex', 1, 0, 1, 1, 10, 0, 0.0, 0, NULL, '2026-06-09 19:10:39', '2026-06-11 11:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(300) NOT NULL,
  `name_ar` varchar(300) NOT NULL,
  `color` varchar(100) DEFAULT NULL,
  `color_hex` varchar(7) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `material` varchar(200) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `name_en`, `name_ar`, `color`, `color_hex`, `size`, `material`, `sku`, `price`, `sale_price`, `stock`, `is_default`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Black / XS', 'أسود / XS', 'Black', '#111111', 'XS', NULL, NULL, 349.00, 299.00, 10, 1, 1, 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(2, 1, 'Black / S', 'أسود / S', 'Black', '#111111', 'S', NULL, NULL, 349.00, 299.00, 15, 0, 1, 2, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(3, 1, 'Black / M', 'أسود / M', 'Black', '#111111', 'M', NULL, NULL, 349.00, 299.00, 12, 0, 1, 3, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(4, 1, 'Black / L', 'أسود / L', 'Black', '#111111', 'L', NULL, NULL, 349.00, 299.00, 8, 0, 1, 4, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(5, 1, 'Burgundy / S', 'عنابي / S', 'Burgundy', '#800020', 'S', NULL, NULL, 349.00, NULL, 7, 0, 1, 5, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(6, 1, 'Burgundy / M', 'عنابي / M', 'Burgundy', '#800020', 'M', NULL, NULL, 349.00, NULL, 9, 0, 1, 6, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(9, 2, 'White / S', 'أبيض / S', 'White', '#F5F5F5', 'S', NULL, NULL, 199.00, NULL, 20, 1, 1, 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(10, 2, 'White / M', 'أبيض / M', 'White', '#F5F5F5', 'M', NULL, NULL, 199.00, NULL, 25, 0, 1, 2, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(11, 2, 'White / L', 'أبيض / L', 'White', '#F5F5F5', 'L', NULL, NULL, 199.00, NULL, 18, 0, 1, 3, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(12, 2, 'Blue / M', 'أزرق / M', 'Blue', '#4A90D9', 'M', NULL, NULL, 219.00, 179.00, 12, 0, 1, 4, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(13, 2, 'Blue / L', 'أزرق / L', 'Blue', '#4A90D9', 'L', NULL, NULL, 219.00, 179.00, 8, 0, 1, 5, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(14, 2, 'Black / M', 'أسود / M', 'Black', '#111111', 'M', NULL, NULL, 209.00, NULL, 15, 0, 1, 6, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(15, 5, 'Black / S', 'أسود / S', 'Black', '#111111', 'S', NULL, NULL, 899.00, 799.00, 5, 1, 1, 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(16, 5, 'Black / M', 'أسود / M', 'Black', '#111111', 'M', NULL, NULL, 899.00, 799.00, 8, 0, 1, 2, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(17, 5, 'Black / L', 'أسود / L', 'Black', '#111111', 'L', NULL, NULL, 899.00, 799.00, 6, 0, 1, 3, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(18, 5, 'Brown / M', 'بني / M', 'Brown', '#8B4513', 'M', NULL, NULL, 949.00, NULL, 5, 0, 1, 4, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(19, 5, 'Tan / M', 'بيج / M', 'Tan', '#D2B48C', 'M', NULL, NULL, 929.00, NULL, 3, 0, 1, 5, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(20, 4, 'Beige / XS', 'بيج / XS', 'Beige', '#F5F0E8', 'XS', NULL, NULL, 279.00, 249.00, 8, 1, 1, 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(21, 4, 'Beige / S', 'بيج / S', 'Beige', '#F5F0E8', 'S', NULL, NULL, 279.00, 249.00, 12, 0, 1, 2, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(22, 4, 'Beige / M', 'بيج / M', 'Beige', '#F5F0E8', 'M', NULL, NULL, 279.00, 249.00, 10, 0, 1, 3, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(23, 4, 'Pink / S', 'وردي / S', 'Pink', '#FFB6C1', 'S', NULL, NULL, 289.00, NULL, 6, 0, 1, 4, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(24, 4, 'Pink / M', 'وردي / M', 'Pink', '#FFB6C1', 'M', NULL, NULL, 289.00, NULL, 8, 0, 1, 5, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(25, 3, 'White / S', 'أبيض / S', 'White', '#FFFFFF', 'S', NULL, NULL, 259.00, NULL, 14, 1, 1, 1, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(26, 3, 'White / M', 'أبيض / M', 'White', '#FFFFFF', 'M', NULL, NULL, 259.00, NULL, 18, 0, 1, 2, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(27, 3, 'Navy / M', 'كحلي / M', 'Navy', '#001F5B', 'M', NULL, NULL, 259.00, 229.00, 9, 0, 1, 3, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(28, 3, 'Black / M', 'أسود / M', 'Black', '#111111', 'M', NULL, NULL, 259.00, NULL, 11, 0, 1, 4, '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(29, 10, 'Samsung Galaxy S24 Ultra', 'نايك اير ماكس 270', 'Black', '#111111', 'XS', NULL, '9VLCSXNJr', 10000.00, 10000.00, 3, 1, 1, 0, '2026-06-10 01:02:09', '2026-06-10 01:02:09'),
(30, 7, 'Blue Floral Midi Dress', 'فستان ميدي بنقشة زهور زرقاء', 'Blue / White', '#111111', 'L', NULL, 'MTR-TY67', 500.00, 500.00, 10, 0, 1, 0, '2026-06-11 09:58:54', '2026-06-11 09:58:54'),
(31, 6, 'Stylish & Modern Women\'s Dress', 'فستان نسائي أنيق وعصري', 'Multicolour', '#111111', 'L', NULL, 'STL-TRY-3456', 270.00, 250.00, 10, 0, 1, 0, '2026-06-12 01:32:55', '2026-06-12 01:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `content` text NOT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group` varchar(100) DEFAULT 'general',
  `key` varchar(200) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'general', 'general.store_name_en', 'Stylevera', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(2, 'general', 'general.store_name_ar', 'ستايل فيرا', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(3, 'general', 'general.tagline_en', 'Dress Your Story', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(4, 'general', 'general.tagline_ar', 'البسي قصتك', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(5, 'general', 'general.email', 'info@stylevera.com', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(6, 'general', 'general.phone', '+971 4 000 0000', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(7, 'general', 'general.address_en', 'Dubai Mall Area, Dubai, UAE', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(8, 'general', 'general.address_ar', 'منطقة دبي مول، دبي، الإمارات', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(9, 'general', 'general.shipping_fee', '30.00', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(10, 'general', 'general.free_shipping_above', '500.00', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(11, 'social', 'social.instagram', 'https://instagram.com/stylevera', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(12, 'social', 'social.facebook', 'https://facebook.com/stylevera', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(13, 'social', 'social.twitter', 'https://twitter.com/stylevera', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(14, 'announcement_en', 'announcement_en.text', 'Free Shipping above 500 AED  |  Use STYLEVERA10 for 10% off', '2026-06-09 19:10:39', '2026-06-09 19:10:39'),
(15, 'announcement_ar', 'announcement_ar.text', 'شحن مجاني فوق 500 درهم  |  استخدم STYLEVERA10 لخصم 10%', '2026-06-09 19:10:39', '2026-06-09 19:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('master_admin','admin','user') DEFAULT 'user',
  `phone` varchar(30) DEFAULT NULL,
  `avatar` varchar(2000) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'UAE',
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `avatar`, `address`, `city`, `country`, `is_active`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Master Admin', 'pritam156777@gmail.com', '$2y$12$e.pfwB56WbyDky6/ycmNsOMKQIMPzP4ms7pBRwY2Jj6gtz2a2B802', 'master_admin', NULL, NULL, NULL, NULL, 'UAE', 1, NULL, NULL, '2026-06-09 19:10:39', '2026-06-10 00:41:01'),
(2, 'Store Admin', 'er.pritam156777@gmail.com', '$2y$12$e.pfwB56WbyDky6/ycmNsOMKQIMPzP4ms7pBRwY2Jj6gtz2a2B802', 'admin', NULL, NULL, NULL, NULL, 'UAE', 1, NULL, NULL, '2026-06-09 19:10:39', '2026-06-10 00:41:01'),
(3, 'Test User', 'alvin156777@gmail.com', '$2y$12$e.pfwB56WbyDky6/ycmNsOMKQIMPzP4ms7pBRwY2Jj6gtz2a2B802', 'user', NULL, NULL, NULL, NULL, 'UAE', 1, NULL, NULL, '2026-06-09 19:10:39', '2026-06-10 00:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `variant_media`
--

CREATE TABLE `variant_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('image','video') DEFAULT 'image',
  `url` varchar(2000) NOT NULL,
  `thumbnail` varchar(2000) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `file_size` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variant_media`
--

INSERT INTO `variant_media` (`id`, `variant_id`, `type`, `url`, `thumbnail`, `is_primary`, `sort_order`, `file_size`, `created_at`, `updated_at`) VALUES
(5, 1, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/1/1781166936_6a2a73589f1ce.jpeg', NULL, 1, 0, 100960, '2026-06-11 03:05:47', '2026-06-11 03:05:47'),
(6, 1, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/1/1781166948_6a2a736426031.jpeg', NULL, 0, 1, 100837, '2026-06-11 03:05:50', '2026-06-11 03:05:50'),
(7, 1, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/1/1781166951_6a2a73670d4f4.jpeg', NULL, 0, 2, 101039, '2026-06-11 03:05:52', '2026-06-11 03:05:52'),
(8, 2, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/2/1781166974_6a2a737e7d4d4.jpeg', NULL, 1, 0, 100960, '2026-06-11 03:06:16', '2026-06-11 03:06:16'),
(9, 2, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/2/1781166977_6a2a738100d0d.jpeg', NULL, 0, 1, 100837, '2026-06-11 03:06:18', '2026-06-11 03:06:18'),
(10, 2, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/2/1781166979_6a2a73837f5da.jpeg', NULL, 0, 2, 101039, '2026-06-11 03:06:21', '2026-06-11 03:06:21'),
(11, 3, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/3/1781167010_6a2a73a2a61f7.jpeg', NULL, 1, 0, 100960, '2026-06-11 03:06:52', '2026-06-11 03:06:52'),
(12, 3, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/3/1781167013_6a2a73a5501d7.jpeg', NULL, 0, 1, 101039, '2026-06-11 03:06:55', '2026-06-11 03:06:55'),
(13, 3, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/3/1781167016_6a2a73a82d9e2.jpeg', NULL, 0, 2, 100837, '2026-06-11 03:06:58', '2026-06-11 03:06:58'),
(14, 4, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/4/1781167036_6a2a73bcb4c9b.jpeg', NULL, 1, 0, 100960, '2026-06-11 03:07:18', '2026-06-11 03:07:18'),
(15, 4, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/4/1781167039_6a2a73bf890ef.jpeg', NULL, 0, 1, 101039, '2026-06-11 03:07:22', '2026-06-11 03:07:22'),
(16, 4, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/4/1781167043_6a2a73c326690.jpeg', NULL, 0, 2, 100837, '2026-06-11 03:07:25', '2026-06-11 03:07:25'),
(17, 5, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/5/1781167059_6a2a73d3a713c.jpeg', NULL, 0, 0, 101155, '2026-06-11 03:07:41', '2026-06-11 03:09:40'),
(18, 5, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/5/1781167062_6a2a73d64ca10.jpeg', NULL, 0, 1, 100756, '2026-06-11 03:07:44', '2026-06-11 03:09:40'),
(19, 5, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/5/1781167064_6a2a73d8dd39d.jpeg', NULL, 1, 2, 101208, '2026-06-11 03:07:46', '2026-06-11 03:09:40'),
(20, 6, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/6/1781167085_6a2a73ede191c.jpeg', NULL, 0, 0, 101155, '2026-06-11 03:08:08', '2026-06-11 03:10:00'),
(21, 6, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/6/1781167089_6a2a73f13418a.jpeg', NULL, 0, 1, 100756, '2026-06-11 03:08:11', '2026-06-11 03:10:00'),
(22, 6, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/6/1781167092_6a2a73f4a538b.jpeg', NULL, 1, 2, 101208, '2026-06-11 03:08:15', '2026-06-11 03:10:00'),
(23, 14, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/14/1781176305_6a2a97f110dac.jpeg', NULL, 1, 0, 100510, '2026-06-11 05:41:59', '2026-06-11 05:41:59'),
(24, 14, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/14/1781176320_6a2a9800493ec.jpeg', NULL, 0, 1, 101228, '2026-06-11 05:42:02', '2026-06-11 05:42:02'),
(25, 13, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/13/1781176536_6a2a98d898268.jpeg', NULL, 1, 0, 101313, '2026-06-11 05:45:38', '2026-06-11 05:45:38'),
(26, 13, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/13/1781176539_6a2a98db2f409.jpeg', NULL, 0, 1, 100481, '2026-06-11 05:45:41', '2026-06-11 05:45:41'),
(27, 13, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/13/1781176541_6a2a98dddcdd3.jpeg', NULL, 0, 2, 101209, '2026-06-11 05:45:44', '2026-06-11 05:45:44'),
(28, 12, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/12/1781176587_6a2a990b7a4f2.jpeg', NULL, 1, 0, 100481, '2026-06-11 05:46:29', '2026-06-11 05:46:29'),
(29, 12, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/12/1781176590_6a2a990e778e9.jpeg', NULL, 0, 1, 101209, '2026-06-11 05:46:32', '2026-06-11 05:46:32'),
(30, 11, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/11/1781176609_6a2a99210fae4.jpeg', NULL, 1, 0, 100498, '2026-06-11 05:46:51', '2026-06-11 05:46:51'),
(31, 11, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/11/1781176611_6a2a9923c77ff.jpeg', NULL, 0, 1, 101332, '2026-06-11 05:46:54', '2026-06-11 05:46:54'),
(32, 10, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/10/1781176631_6a2a993790ecb.jpeg', NULL, 1, 0, 100498, '2026-06-11 05:47:14', '2026-06-11 05:47:14'),
(33, 10, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/10/1781176634_6a2a993aa0d5d.jpeg', NULL, 0, 1, 101332, '2026-06-11 05:47:16', '2026-06-11 05:47:16'),
(34, 9, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/9/1781176651_6a2a994b5d3ec.jpeg', NULL, 1, 0, 100498, '2026-06-11 05:47:33', '2026-06-11 05:47:33'),
(35, 9, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/9/1781176654_6a2a994e83ddc.jpeg', NULL, 0, 1, 101332, '2026-06-11 05:47:36', '2026-06-11 05:47:36'),
(36, 25, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/25/1781187700_6a2ac47484abf.jpeg', NULL, 1, 0, 101308, '2026-06-11 08:51:53', '2026-06-11 08:51:53'),
(38, 25, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/25/1781187718_6a2ac4860c255.jpeg', NULL, 0, 2, 101235, '2026-06-11 08:52:00', '2026-06-11 08:52:00'),
(39, 26, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/26/1781187764_6a2ac4b41e398.jpeg', NULL, 1, 0, 101308, '2026-06-11 08:52:47', '2026-06-11 08:52:47'),
(40, 26, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/26/1781187768_6a2ac4b86a718.jpeg', NULL, 0, 1, 101235, '2026-06-11 08:52:51', '2026-06-11 08:52:51'),
(41, 28, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/28/1781187799_6a2ac4d7d44fd.jpeg', NULL, 1, 0, 101060, '2026-06-11 08:53:22', '2026-06-11 08:53:22'),
(42, 28, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/28/1781187803_6a2ac4db202e6.jpeg', NULL, 0, 1, 100524, '2026-06-11 08:53:25', '2026-06-11 08:53:25'),
(43, 28, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/28/1781187806_6a2ac4de72939.jpeg', NULL, 0, 2, 100705, '2026-06-11 08:53:28', '2026-06-11 08:53:28'),
(44, 27, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/27/1781187995_6a2ac59b73a85.jpeg', NULL, 1, 0, 100752, '2026-06-11 08:56:37', '2026-06-11 08:56:37'),
(45, 27, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/27/1781187998_6a2ac59e73c53.jpeg', NULL, 0, 1, 101121, '2026-06-11 08:56:41', '2026-06-11 08:56:41'),
(46, 15, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/15/1781189461_6a2acb55e6ecc.jpeg', NULL, 1, 0, 101298, '2026-06-11 09:21:04', '2026-06-11 09:21:04'),
(47, 16, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/16/1781189482_6a2acb6aefd0d.jpeg', NULL, 1, 0, 101298, '2026-06-11 09:21:25', '2026-06-11 09:21:25'),
(48, 17, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/17/1781189497_6a2acb79e1c45.jpeg', NULL, 1, 0, 101298, '2026-06-11 09:21:40', '2026-06-11 09:21:40'),
(49, 18, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/18/1781189515_6a2acb8b3f1c0.jpeg', NULL, 1, 0, 100403, '2026-06-11 09:21:57', '2026-06-11 09:21:57'),
(50, 19, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/19/1781189530_6a2acb9ac3bbb.jpeg', NULL, 1, 0, 100359, '2026-06-11 09:22:13', '2026-06-11 09:22:13'),
(51, 30, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/30/1781191813_6a2ad48557709.jpeg', NULL, 1, 0, 101352, '2026-06-11 10:00:15', '2026-06-11 10:00:15'),
(52, 20, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/20/1781196981_6a2ae8b53f8b3.jpeg', NULL, 1, 0, 101141, '2026-06-11 11:26:24', '2026-06-11 11:26:24'),
(53, 20, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/20/1781196984_6a2ae8b893059.jpeg', NULL, 0, 1, 101153, '2026-06-11 11:26:27', '2026-06-11 11:26:27'),
(54, 20, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/20/1781196987_6a2ae8bbde8d7.jpeg', NULL, 0, 2, 100427, '2026-06-11 11:26:30', '2026-06-11 11:26:30'),
(55, 21, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/21/1781197014_6a2ae8d659913.jpeg', NULL, 1, 0, 101141, '2026-06-11 11:26:56', '2026-06-11 11:26:56'),
(56, 21, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/21/1781197017_6a2ae8d942771.jpeg', NULL, 0, 1, 101153, '2026-06-11 11:26:59', '2026-06-11 11:26:59'),
(57, 21, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/21/1781197019_6a2ae8dbdad70.jpeg', NULL, 0, 2, 100427, '2026-06-11 11:27:02', '2026-06-11 11:27:02'),
(58, 22, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/22/1781197034_6a2ae8ea12f52.jpeg', NULL, 1, 0, 101141, '2026-06-11 11:27:16', '2026-06-11 11:27:16'),
(59, 22, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/22/1781197036_6a2ae8ecdb981.jpeg', NULL, 0, 1, 101153, '2026-06-11 11:27:19', '2026-06-11 11:27:19'),
(60, 22, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/22/1781197039_6a2ae8efc7621.jpeg', NULL, 0, 2, 100427, '2026-06-11 11:27:22', '2026-06-11 11:27:22'),
(61, 23, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/23/1781197064_6a2ae9085b54d.jpeg', NULL, 1, 0, 100720, '2026-06-11 11:27:46', '2026-06-11 11:27:46'),
(62, 23, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/23/1781197067_6a2ae90b32d2c.jpeg', NULL, 0, 1, 101256, '2026-06-11 11:27:49', '2026-06-11 11:27:49'),
(63, 23, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/23/1781197070_6a2ae90e0a545.jpeg', NULL, 0, 2, 100902, '2026-06-11 11:27:52', '2026-06-11 11:27:52'),
(64, 24, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/24/1781197087_6a2ae91f3f919.jpeg', NULL, 1, 0, 100720, '2026-06-11 11:28:09', '2026-06-11 11:28:09'),
(65, 24, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/24/1781197090_6a2ae92224971.jpeg', NULL, 0, 1, 101256, '2026-06-11 11:28:12', '2026-06-11 11:28:12'),
(66, 24, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/24/1781197092_6a2ae924e2df2.jpeg', NULL, 0, 2, 100902, '2026-06-11 11:28:15', '2026-06-11 11:28:15'),
(67, 29, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/29/1781198042_6a2aecdae814a.jpeg', NULL, 1, 0, 100610, '2026-06-11 11:44:05', '2026-06-11 11:44:05'),
(68, 29, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/29/1781199773_6a2af39d99667.jpeg', NULL, 0, 1, 152953, '2026-06-11 12:12:55', '2026-06-11 12:12:55'),
(69, 29, 'video', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/29/1781208710_6a2b1686e77ca.mp4', NULL, 0, 2, 12793245, '2026-06-11 14:41:59', '2026-06-11 14:41:59'),
(71, 31, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/31/1781247884_6a2baf8c4d2f3.jpeg', NULL, 0, 0, 101036, '2026-06-12 01:34:47', '2026-06-12 01:34:59'),
(72, 31, 'image', 'https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/31/1781247888_6a2baf9090e11.jpeg', NULL, 1, 1, 100781, '2026-06-12 01:34:51', '2026-06-12 01:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_cart_fk` (`cart_id`),
  ADD KEY `ci_prod_fk` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_slug` (`slug`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_code` (`code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_ref` (`ref_number`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oi_order_fk` (`order_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug` (`slug`),
  ADD KEY `prod_cat_fk` (`category_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `var_prod_fk` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rev_prod_fk` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email` (`email`);

--
-- Indexes for table `variant_media`
--
ALTER TABLE `variant_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vm_var_fk` (`variant_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `variant_media`
--
ALTER TABLE `variant_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `ci_cart_fk` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ci_prod_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `oi_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `prod_cat_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `var_prod_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `rev_prod_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variant_media`
--
ALTER TABLE `variant_media`
  ADD CONSTRAINT `vm_var_fk` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------
-- api_tokens table (added for Flutter mobile app authentication)
-- --------------------------------------------------------

CREATE TABLE `api_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(64) NOT NULL,
  `device_name` varchar(150) DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `api_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_tokens_token_unique` (`token`),
  ADD KEY `api_tokens_user_id_foreign` (`user_id`);

ALTER TABLE `api_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `api_tokens`
  ADD CONSTRAINT `api_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
