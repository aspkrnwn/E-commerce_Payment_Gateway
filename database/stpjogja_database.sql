-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 04, 2022 at 10:11 PM
-- Server version: 10.3.32-MariaDB-log-cll-lve
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stpjogja_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `customer_id`, `ip_address`, `product_id`, `quantity`) VALUES
(53, 2, '103.147.154.77', 11, 100);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `unit` enum('pcs','meter','kg') NOT NULL,
  `icon` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `unit`, `icon`, `created_at`, `updated_at`, `is_deleted`) VALUES
(17, 'Fitting', 'pcs', 'fitting.jpg', '2021-11-21 16:43:56', NULL, 0),
(18, 'Kabel', 'pcs', 'kabel.jpg', '2021-11-21 16:44:13', NULL, 0),
(19, 'Lampu', 'pcs', 'lampu.jpg', '2021-11-21 16:44:36', NULL, 0),
(20, 'MCB', 'pcs', 'mcb.jpg', '2021-11-21 16:44:51', NULL, 0),
(21, 'Saklar', 'pcs', 'saklar.jpg', '2021-11-21 16:45:09', NULL, 0),
(22, 'Sekring', 'pcs', 'sekring.jpg', '2021-11-21 16:45:33', NULL, 0),
(23, 'Steker', 'pcs', 'steker.png', '2021-11-21 16:45:53', NULL, 0),
(24, 'Stop Kontak', 'pcs', 'stopkontak.jpeg', '2021-11-21 16:46:30', '2022-02-14 15:03:54', 0),
(25, 'Kawat', 'meter', '', '2022-01-19 12:06:23', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `otp_time` timestamp NULL DEFAULT NULL,
  `token_register` varchar(255) DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0=aktif, 1=pending, 2=tidak aktif',
  `management_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `username`, `password`, `email`, `no_hp`, `created_at`, `updated_at`, `updated_by`, `is_deleted`, `last_login`, `profile_picture`, `otp`, `otp_time`, `token_register`, `status`, `management_id`, `remarks`) VALUES
(1, 'Asep Kurniawan', 'asep', '61d851eb08207ca53fe9137eb06bbae7', 'asepkurniawan093@gmail.com', '081215188344', '2022-02-04 10:30:02', '2022-02-04 10:30:38', 'System', 0, '2022-02-28 08:51:45', '', NULL, NULL, NULL, '0', NULL, NULL),
(2, 'Budi', 'budiii', '827ccb0eea8a706c4c34a16891f84e7b', 'asepkurniawan200198@gmail.com', '081215188344', '2022-02-04 10:46:12', '2022-02-20 09:14:19', 'System', 0, '2022-03-04 08:35:05', '', NULL, NULL, NULL, '0', NULL, NULL),
(3, 'Elvin dwi hendrawan', 'elvin123', '96e79218965eb72c92a549dd5a330112', 'elvinhndrwn@gmail.com', '081215188344', '2022-02-04 10:30:02', '2022-02-20 10:51:23', 'System', 0, '2022-02-27 14:59:08', '', NULL, NULL, NULL, '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `management`
--

CREATE TABLE `management` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('owner','admin') NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `management`
--

INSERT INTO `management` (`id`, `username`, `password`, `fullname`, `created_at`, `updated_at`, `updated_by`, `email`, `role`, `image`, `is_deleted`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'elvin', '2021-11-14 05:55:14', '2022-02-20 08:45:33', 'admin', 'elvin@email.com', 'admin', 'admin_profile_46129.jpg', 0),
(2, 'owner', '202cb962ac59075b964b07152d234b70', 'Asep', '2021-11-14 05:55:14', '2022-01-19 13:42:53', 'owner', 'asep@email.com', 'owner', 'admin_profile_75814.jpg', 0),
(3, 'elvin2', 'KOZ3QB', 'elvin2', '2022-02-04 07:44:49', NULL, NULL, 'elvin@gmail.com', 'admin', '', 0),
(4, 'jaja', 'GSRWKX', 'Jaja', '2022-02-13 14:17:00', '2022-02-13 14:17:19', NULL, 'elvinhndrwn@gmail.com', 'admin', '', 1),
(5, 'jojo', 'DATCPW', 'jaja', '2022-02-13 14:17:37', '2022-02-13 14:17:52', NULL, 'jaja@gmail.com', 'admin', '', 1),
(6, 'jeje', 'KCY8OE', 'jeje', '2022-02-13 14:18:06', NULL, NULL, 'jeje@gmail.com', 'admin', '', 0),
(7, 'yeye', 'WSKE6L', 'yeye', '2022-02-13 14:18:24', '2022-02-13 14:25:23', NULL, 'yeye@gmail.com', 'admin', '', 1),
(8, 'rere', 'OWQ61C', 'rere', '2022-02-13 14:20:49', '2022-02-13 14:25:20', NULL, 'jasja@gmail.com', 'admin', '', 1),
(9, 'rerere', 'UKG8X5', 'rere', '2022-02-14 14:23:16', NULL, NULL, 'rr@gmail.com', 'admin', '', 0),
(10, 'sdsa', 'TIZRNK', 'sadas21', '2022-02-14 14:26:21', NULL, NULL, 'qq@e.com', 'admin', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(100) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_order` varchar(100) NOT NULL,
  `total_pay` double NOT NULL,
  `shipping_cost` double NOT NULL,
  `shipping_address` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `receipt_number` varchar(100) NOT NULL,
  `delivery_service` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `weight_total` int(20) NOT NULL COMMENT 'gram'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `created_at`, `updated_at`, `status_order`, `total_pay`, `shipping_cost`, `shipping_address`, `note`, `receipt_number`, `delivery_service`, `is_deleted`, `weight_total`) VALUES
('STP3GOM20220211172911', 3, '2022-02-11 10:29:11', '2022-02-20 08:58:00', 'delivered', 12000, 73000, 'dsfsdf, Tana Tidung, Kalimantan Utara', '', 'KW1836173813', 'jne(OKE)', 0, 0),
('STP5RVK20220204174121', 1, '2022-02-04 10:41:21', '2022-02-21 18:49:02', 'on delivery', 14000, 6000, 'mlati, Sleman, DI Yogyakarta', '', 'JNEABABAB12212', 'jne(CTC)', 0, 0),
('STP6LC720220204173239', 1, '2022-02-04 10:32:39', '0000-00-00 00:00:00', 'pending', 109500, 16000, 'Rancaekek\r\n, Bandung, Jawa Barat', '', '', 'tiki(REG)', 0, 0),
('STPANKG20220221110401', 2, '2022-02-21 04:04:01', '2022-02-21 04:17:06', 'on delivery', 757500, 44000, 'ketapang, Ketapang, Kalimantan Barat', '', ' ', 'jne(OKE)', 0, 0),
('STPAWN620220222113320', 2, '2022-02-22 04:33:20', '2022-03-04 08:31:37', 'on delivery', 15000000, 9000, 'Untung Suropati No.82, Surakarta (Solo), Jawa Tengah', '', 'jK617339', 'jne(OKE)', 0, 0),
('STPCTKR20220210144926', 2, '2022-02-10 07:49:26', '2022-02-20 09:06:57', 'delivered', 28000, 19000, 'Kontol, Indramayu, Jawa Barat', '', 'JPK134819313', 'jne(OKE)', 0, 0),
('STPDLAN20220222141126', 3, '2022-02-22 07:11:26', '0000-00-00 00:00:00', 'pending', 32500, 0, '', '', '', '', 0, 0),
('STPDNDH20220204173635', 1, '2022-02-04 10:36:35', '0000-00-00 00:00:00', 'expire', 118000, 7000, 'Sleman, Sleman, DI Yogyakarta', '', '', 'pos(Paket Kilat Khusus)', 0, 0),
('STPICZE20220204193842', 2, '2022-02-04 12:38:42', '2022-02-20 09:07:12', 'delivered', 190000, 13000, 'Madiun, Madiun, Jawa Timur', '', 'JNE9892718728178', 'jne(OKE)', 0, 0),
('STPO9SU20220228155216', 1, '2022-02-28 08:52:16', '0000-00-00 00:00:00', 'pending', 108500, 0, '', '', '', '', 0, 2600),
('STPPAPJ20220204174717', 2, '2022-02-04 10:47:17', '2022-02-20 09:07:21', 'delivered', 516000, 19000, 'garut, Garut, Jawa Barat', '', 'hihuig', 'jne(OKE)', 0, 0),
('STPPGB620220222112950', 2, '2022-02-22 04:29:50', '0000-00-00 00:00:00', 'pending', 15000000, 11000, 'Untung Suropati No. 102, Surakarta (Solo), Jawa Tengah', '', '', 'jne(REG)', 0, 0),
('STPQVDE20220211173754', 3, '2022-02-11 10:37:54', '2022-02-20 08:56:19', 'delivered', 35000, 12000, 'erewr, Pati, Jawa Tengah', '', 'JPK134819313', 'jne(OKE)', 0, 0),
('STPRSMB20220228155720', 1, '2022-02-28 08:57:20', '0000-00-00 00:00:00', 'pending', 940000, 0, '', '', '', '', 0, 12000),
('STPRV0R20220211172225', 3, '2022-02-11 10:22:25', '2022-02-11 10:24:14', 'on delivery', 14000, 6000, 'Haha, Bantul, DI Yogyakarta', '', 'TK093738789', 'jne(CTC)', 0, 0),
('STPT2AM20220222014051', 2, '2022-02-21 18:40:51', '0000-00-00 00:00:00', 'waiting approval', 364000, 43000, 'Gunung Mas, Gunung Mas, Kalimantan Tengah', '', '', 'pos(Paket Kilat Khusus)', 0, 0),
('STPTMRT20220222142906', 3, '2022-02-22 07:29:06', '0000-00-00 00:00:00', 'pending', 32500, 0, '', '', '', '', 0, 0),
('STPTXNL20220215004235', 3, '2022-02-14 17:42:35', '0000-00-00 00:00:00', 'expire', 28000, 44000, 'asas, Kutai Barat, Kalimantan Timur', '', '', 'jne(OKE)', 0, 0),
('STPUQ7Y20220221050444', 2, '2022-02-20 22:04:44', '2022-02-20 22:14:32', 'delivered', 46000, 43000, 'Banjar, Banjar, Kalimantan Selatan', '', 'JKP2013048', 'jne(OKE)', 0, 0),
('STPUWBF20220228155859', 1, '2022-02-28 08:58:59', '0000-00-00 00:00:00', 'pending', 940000, 84000, 'Sleman, Sleman, DI Yogyakarta', '', '', 'tiki(ECO)', 0, 12000),
('STPXDMV20220222143203', 3, '2022-02-22 07:32:03', '0000-00-00 00:00:00', 'pending', 15000, 0, '', '', '', '', 0, 400);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `quantity`, `note`) VALUES
(1, 'STP6LC720220204173239', 11, 10, ''),
(2, 'STP6LC720220204173239', 12, 7, ''),
(3, 'STP6LC720220204173239', 14, 9, ''),
(4, 'STPDNDH20220204173635', 13, 9, ''),
(5, 'STPDNDH20220204173635', 15, 30, ''),
(6, 'STPDNDH20220204173635', 28, 7, ''),
(7, 'STP5RVK20220204174121', 11, 2, ''),
(8, 'STPPAPJ20220204174717', 12, 20, ''),
(9, 'STPPAPJ20220204174717', 26, 30, ''),
(10, 'STPPAPJ20220204174717', 28, 8, ''),
(11, 'STPICZE20220204193842', 13, 5, ''),
(12, 'STPICZE20220204193842', 11, 8, ''),
(13, 'STPICZE20220204193842', 31, 2, ''),
(14, 'STPICZE20220204193842', 30, 4, ''),
(15, 'STPCTKR20220210144926', 11, 4, ''),
(16, 'STPRV0R20220211172225', 11, 2, ''),
(17, 'STP3GOM20220211172911', 13, 2, ''),
(18, 'STPQVDE20220211173754', 11, 5, ''),
(19, 'STPTXNL20220215004235', 11, 4, ''),
(20, 'STPUQ7Y20220221050444', 13, 3, ''),
(21, 'STPUQ7Y20220221050444', 12, 5, ''),
(22, 'STPUQ7Y20220221050444', 14, 6, ''),
(23, 'STPANKG20220221110401', 10, 101, ''),
(24, 'STPT2AM20220222014051', 11, 16, ''),
(25, 'STPT2AM20220222014051', 51, 5, ''),
(26, 'STPT2AM20220222014051', 52, 8, ''),
(27, 'STPT2AM20220222014051', 53, 2, ''),
(28, 'STPPGB620220222112950', 50, 25, ''),
(29, 'STPAWN620220222113320', 50, 25, ''),
(30, 'STPDLAN20220222141126', 12, 5, ''),
(31, 'STPDLAN20220222141126', 10, 1, ''),
(32, 'STPTMRT20220222142906', 12, 5, ''),
(33, 'STPTMRT20220222142906', 10, 1, ''),
(34, 'STPXDMV20220222143203', 10, 2, ''),
(35, 'STPO9SU20220228155216', 10, 7, ''),
(36, 'STPO9SU20220228155216', 11, 8, ''),
(37, 'STPRSMB20220228155720', 50, 1, ''),
(38, 'STPRSMB20220228155720', 49, 2, ''),
(39, 'STPUWBF20220228155859', 50, 1, ''),
(40, 'STPUWBF20220228155859', 49, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `purchase_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` int(20) NOT NULL COMMENT 'gram'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `purchase_price`, `selling_price`, `stock`, `image`, `is_deleted`, `created_at`, `updated_at`, `weight`) VALUES
(10, 17, 'Fitting tempel bulat Broco hitam', 5350, 7500, 100, 'products_73418.jpg', 0, '2021-11-21 16:51:58', '2022-02-21 18:59:23', 200),
(11, 17, 'Fitting tempel colok + saklar', 5600, 7000, 100, 'products_08312.jpg', 0, '2021-11-21 16:53:02', '2022-02-21 18:59:54', 150),
(12, 17, 'Fitting Tempel Keramik', 4000, 5000, 34, 'products_15839.jpg', 0, '2021-11-21 16:53:52', NULL, 80),
(13, 17, 'Fitting gantung Broco', 4350, 6000, 68, 'products_82053.jpg', 0, '2021-11-21 16:55:01', NULL, 60),
(14, 17, 'Fitting kayu bulat', 400, 500, 75, 'products_83746.jpg', 0, '2021-11-21 16:57:15', NULL, 220),
(15, 17, 'Fitting kayu kotak', 400, 500, 70, 'products_02519.jpg', 0, '2021-11-21 17:00:32', NULL, 50),
(16, 24, 'Stop kontak IB Broco', 12950, 15000, 120, 'products_10695.jpg', 0, '2021-12-05 17:23:05', '2022-02-08 08:18:10', 100),
(17, 24, 'Stop kontak 1 lubang OB Loyal 901', 7500, 9000, 70, 'products_21634.jpeg', 0, '2021-12-05 17:23:05', '2022-02-08 07:38:13', 100),
(18, 24, 'Stop kontak 2 lubang OB Loyal 902', 8500, 10000, 100, 'products_84095.jpg', 0, '2021-12-05 17:23:05', '2022-02-08 08:21:22', 200),
(19, 24, 'Stop kontak 3 lubang OB Loyal 903', 9500, 12000, 100, 'products_49160.jpg', 0, '2021-12-05 17:23:05', '2022-02-08 07:37:07', 300),
(20, 24, 'Stop kontak 4 lubang OB Loyal 904', 10500, 14000, 100, '', 1, '2021-12-05 17:24:26', '2022-02-08 07:36:56', 400),
(21, 24, 'Stop kontak Bright', 13150, 17000, 120, '', 1, '2021-12-05 17:24:26', '2022-02-08 07:36:48', 100),
(22, 24, 'Stop kontak Panasonik OB', 12250, 15000, 110, '', 1, '2021-12-05 17:24:26', NULL, 100),
(23, 24, 'Stop kontak 4 lubang OB Loyal 904', 10500, 14000, 100, 'products_01854.jpg', 1, '2021-12-05 17:24:39', '2022-02-20 08:55:47', 400),
(24, 24, 'Stop kontak Bright', 13150, 17000, 120, 'products_29457.jpg', 0, '2021-12-05 17:24:39', '2022-02-08 07:36:06', 100),
(25, 24, 'Stop kontak Panasonik OB', 12250, 15000, 110, 'products_59267.jpg', 0, '2021-12-05 17:24:39', '2022-02-08 07:35:53', 100),
(26, 23, 'Steker bulat Broco', 9350, 12000, 70, 'products_40382.jpg', 0, '2021-12-05 17:27:49', '2022-02-08 07:35:23', 50),
(27, 23, 'Steker pipih Broco 344 L (hitam)', 2250, 500, 100, 'products_07923.jpg', 0, '2021-12-05 17:27:49', '2022-02-08 07:35:09', 50),
(28, 23, 'Steker pipih Loyal 930 (putih)', 3600, 7000, 75, '', 1, '2021-12-05 17:27:49', '2022-02-08 08:05:18', 50),
(29, 23, 'Steker T Arde Loyal 912', 18500, 24000, 120, 'products_86540.jpg', 0, '2021-12-05 17:27:49', '2022-02-08 07:34:21', 100),
(30, 23, 'Steker T Arde Loyal +saklar 929', 14500, 18000, 96, 'products_91284.jpg', 0, '2021-12-05 17:27:49', '2022-02-08 07:33:58', 100),
(31, 23, 'Steker Arder sk 932', 13600, 16000, 98, 'products_57642.png', 0, '2021-12-05 17:27:49', '2022-02-08 07:33:43', 100),
(32, 16, 'Tst', 122, 234, 100, 'products_25306.jpg', 1, '2021-12-05 17:35:47', NULL, 0),
(33, 22, 'Sekring Otomatis Matsuka 2A', 33500, 40000, 200, 'products_59670.jpg', 0, '2022-02-08 07:42:27', '2022-03-01 13:05:21', 100),
(34, 22, 'Kap Sekring Non Otomatis', 2800, 3500, 100, 'products_60954.png', 0, '2022-02-08 07:45:48', '2022-03-01 13:08:34', 100),
(35, 22, 'Sekring Otomatis 4A Okachi', 16000, 20000, 100, 'products_13450.jpg', 0, '2022-02-08 07:49:17', '2022-03-01 13:08:24', 100),
(36, 20, 'MCB 1 P Scneider Domae 4A', 50000, 69000, 100, 'products_59284.jpg', 0, '2022-02-08 07:52:21', '2022-03-01 13:08:02', 100),
(37, 20, 'MCB 1  Phase Shukaku 4A', 14500, 20000, 100, 'products_63712.jpg', 0, '2022-02-08 08:07:52', '2022-03-01 13:07:52', 100),
(38, 20, 'MCB 1 Phase Chint 4A', 23500, 30000, 100, 'products_68024.jpg', 0, '2022-02-08 08:09:56', '2022-03-01 13:07:37', 100),
(39, 20, 'MCB 3P Schneider Domae 16A', 140800, 188000, 100, 'products_65871.png', 0, '2022-02-08 08:11:04', '2022-03-01 13:07:12', 300),
(40, 20, 'MCB 3 Phase Schneider Merlin Gerin', 180500, 232500, 100, 'products_28640.jpg', 0, '2022-02-08 08:14:11', '2022-03-01 13:06:12', 300),
(41, 21, 'Saklar gantung', 2800, 3500, 100, 'products_94507.jpg', 0, '2022-02-08 08:25:29', '2022-03-01 13:05:44', 50),
(42, 21, 'Saklar hotel single  Broco IB', 12000, 15000, 100, 'products_34589.jpg', 0, '2022-02-08 08:26:15', '2022-03-01 13:04:48', 100),
(43, 21, 'Saklar Panasonic Seri IB', 16800, 21000, 100, 'products_86240.jpg', 0, '2022-02-08 08:28:25', '2022-03-01 13:04:29', 200),
(44, 21, 'Saklar Panasonic Seri OB', 15400, 18400, 100, 'products_34650.jpg', 0, '2022-02-08 08:29:36', '2022-03-01 13:03:17', 200),
(45, 21, 'Saklar Panasonic Single IB', 10920, 14000, 100, 'products_96347.jpg', 0, '2022-02-08 08:44:24', '2022-03-01 13:03:04', 100),
(46, 21, 'Saklar Panasonic Single OB', 12000, 14000, 100, 'products_69174.jpg', 0, '2022-02-08 08:45:28', '2022-03-01 13:02:39', 100),
(47, 21, 'Saklar Seri Broco IB1A', 13600, 17000, 100, 'products_72419.jpeg', 0, '2022-02-08 08:46:41', '2022-03-01 13:02:09', 100),
(48, 18, 'NYA Eterna 50 Meter', 120000, 170000, 30, 'products_17025.jpg', 0, '2022-02-20 14:34:07', NULL, 4000),
(49, 18, 'NYA Extrana ', 120000, 170000, 30, 'products_94762.jpg', 0, '2022-02-20 14:36:34', NULL, 4000),
(50, 18, 'NYM Eterna 50 Meter', 450000, 600000, 5, 'products_92136.jpg', 0, '2022-02-20 14:39:59', NULL, 4000),
(51, 19, 'Lampu Kulkas', 3200, 4000, 95, 'products_76832.jpg', 0, '2022-02-20 14:44:10', '2022-03-01 13:00:13', 50),
(52, 19, 'LED Chint 3W', 15000, 22000, 92, 'products_36250.jpg', 0, '2022-02-20 14:46:10', '2022-03-01 13:01:18', 275),
(53, 19, 'LED Philips 4W', 17000, 28000, 98, 'products_32918.jpg', 0, '2022-02-20 14:48:43', '2022-03-01 13:00:48', 600),
(54, 19, 'Lampu Tesla', 250000, 500000, 500000, 'products_42983.jpg', 1, '2022-02-21 04:38:59', '2022-03-01 12:59:56', 340),
(55, 24, 'Sendal', 1000, 2000, 100, 'products_34791.png', 1, '2022-02-28 05:34:52', '2022-02-28 05:35:00', 200);

-- --------------------------------------------------------

--
-- Table structure for table `store_setting`
--

CREATE TABLE `store_setting` (
  `id` int(11) NOT NULL,
  `name_store` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `telp` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `slogan` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_setting`
--

INSERT INTO `store_setting` (`id`, `name_store`, `address`, `telp`, `email`, `created_at`, `updated_at`, `slogan`, `logo`, `is_deleted`) VALUES
(1, 'STP NEW', 'Jl. Purbaya No. 121 Warak. Sumberadi Mlati, Sleman, Yogyakarta.', '085643101868', 'steplistrik@gmail.co', '2022-02-14 18:00:59', '2022-02-19 17:27:39', 'Kualitas pasti, 100% ORI !', 'store_profile_50439.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `transaction_id` varchar(200) NOT NULL,
  `transaction_time` datetime NOT NULL,
  `gross_amount` double NOT NULL,
  `currency` varchar(10) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `status_code` varchar(10) NOT NULL,
  `transaction_status` varchar(150) NOT NULL,
  `merchant_id` varchar(100) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `va_number` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`transaction_id`, `transaction_time`, `gross_amount`, `currency`, `order_id`, `payment_type`, `status_code`, `transaction_status`, `merchant_id`, `bank_name`, `va_number`) VALUES
('000caec1-b5cb-47a6-ac3b-5362f0698af1', '2022-02-11 17:29:30', 85000, 'IDR', 'STP3GOM20220211172911', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482994636'),
('265b8e17-f29a-408a-97b8-9e5eec910af1', '2022-02-04 17:33:29', 125500, 'IDR', 'STP6LC720220204173239', 'bank_transfer', '200', 'settlement', 'G615626482', 'bca', '26482662931'),
('2e681dac-09ed-4dd0-8379-c48f12bc351a', '2022-02-04 17:41:55', 20000, 'IDR', 'STP5RVK20220204174121', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482104940'),
('5f16507d-9069-49eb-b34f-5720429bbbee', '2022-02-22 01:41:28', 407000, 'IDR', 'STPT2AM20220222014051', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482811286'),
('73428e56-255c-47a4-923e-3d740de8d060', '2022-02-04 19:39:20', 203000, 'IDR', 'STPICZE20220204193842', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482874244'),
('9200b624-fb20-4e59-b96d-af354ec4e356', '2022-02-11 17:38:11', 47000, 'IDR', 'STPQVDE20220211173754', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482861529'),
('953a982a-3391-4038-9da4-376714478394', '2022-02-11 17:22:47', 20000, 'IDR', 'STPRV0R20220211172225', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482651724'),
('96351122-7fec-4422-8920-ef280d2cb5ed', '2022-02-21 05:06:19', 89000, 'IDR', 'STPUQ7Y20220221050444', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482906802'),
('a6f74aa8-1f2e-4f44-8bdd-c80001c202d9', '2022-02-10 14:49:54', 47000, 'IDR', 'STPCTKR20220210144926', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482936964'),
('bd7690c7-cfac-4dc8-9496-c0414e3e4fd2', '2022-02-15 00:42:53', 72000, 'IDR', 'STPTXNL20220215004235', 'bank_transfer', '201', 'expire', 'G615626482', 'bca', '26482161524'),
('cfc42985-98f3-42e0-b265-7023a2b70989', '2022-02-04 17:48:01', 535000, 'IDR', 'STPPAPJ20220204174717', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482558277'),
('d24b0f86-a063-46ad-a767-da955fde9ff5', '2022-02-04 17:37:13', 125000, 'IDR', 'STPDNDH20220204173635', 'bank_transfer', '201', 'expire', 'G615626482', 'bca', '26482037281'),
('dedeadc2-2cab-4010-9b61-ee8cd0db948e', '2022-02-21 11:04:47', 801500, 'IDR', 'STPANKG20220221110401', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482506455'),
('e841ebb4-3621-4c61-8790-e92d11c2923c', '2022-02-22 11:34:28', 15009000, 'IDR', 'STPAWN620220222113320', 'bank_transfer', '201', 'settlement', 'G615626482', 'bca', '26482044460');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `management_id` (`management_id`);

--
-- Indexes for table `management`
--
ALTER TABLE `management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `store_setting`
--
ALTER TABLE `store_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `management`
--
ALTER TABLE `management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `store_setting`
--
ALTER TABLE `store_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
