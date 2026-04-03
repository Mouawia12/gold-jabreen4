-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2026 at 12:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gold-jabreen4`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounting_closing`
--

CREATE TABLE `accounting_closing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_from` int(11) NOT NULL,
  `account_to` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_trees`
--

CREATE TABLE `accounts_trees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `parent_code` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `list` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `side` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts_trees`
--

INSERT INTO `accounts_trees` (`id`, `name`, `code`, `type`, `parent_id`, `parent_code`, `level`, `list`, `department`, `side`, `created_at`, `updated_at`) VALUES
(1, 'عميل نقدي افتراضي', '110701', 2, 13, '1107', 4, 1, 1, 1, '2026-02-01 17:23:32', '2026-02-01 17:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `account_movements`
--

CREATE TABLE `account_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `debit` double NOT NULL,
  `credit` double NOT NULL,
  `date` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_movements`
--

INSERT INTO `account_movements` (`id`, `journal_id`, `account_id`, `debit`, `credit`, `date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 500, '2026-02-01 23:23:00', '', NULL, NULL),
(2, 2, 1, 500, 0, '2026-02-01 20:24:00', '', NULL, NULL),
(3, 3, 1, 0, 950, '2026-02-03 21:04:00', '', NULL, NULL),
(4, 4, 1, 950, 0, '2026-02-03 18:06:02', '', NULL, NULL),
(5, 5, 1, 0, 2600, '2026-02-03 23:01:00', '', NULL, NULL),
(6, 6, 1, 2600, 0, '2026-02-03 20:03:57', '', NULL, NULL),
(7, 7, 1, 0, 900, '2026-02-03 23:14:00', '', NULL, NULL),
(8, 8, 1, 900, 0, '2026-02-03 20:15:53', '', NULL, NULL),
(9, 9, 1, 0, 1000, '2026-02-03 23:16:00', '', NULL, NULL),
(10, 10, 1, 1000, 0, '2026-02-03 20:17:48', '', NULL, NULL),
(11, 11, 1, 0, 1380, '2026-02-04 17:25:00', '', NULL, NULL),
(12, 12, 1, 1380, 0, '2026-02-04 14:26:21', '', NULL, NULL),
(13, 13, 1, 0, 4100, '2026-02-04 17:27:00', '', NULL, NULL),
(14, 14, 1, 4100, 0, '2026-02-04 14:27:27', '', NULL, NULL),
(15, 15, 1, 0, 3000, '2026-02-04 20:32:00', '', NULL, NULL),
(16, 16, 1, 0, 3300, '2026-02-04 20:32:00', '', NULL, NULL),
(17, 17, 1, 6300, 0, '2026-02-04 17:33:13', '', NULL, NULL),
(18, 18, 1, 0, 1150, '2026-02-04 21:38:00', '', NULL, NULL),
(19, 19, 1, 1150, 0, '2026-02-04 18:39:11', '', NULL, NULL),
(20, 20, 1, 0, 3700, '2026-02-05 22:19:00', '', NULL, NULL),
(21, 21, 1, 3700, 0, '2026-02-05 19:19:02', '', NULL, NULL),
(22, 22, 1, 0, 2200, '2026-02-05 22:48:00', '', NULL, NULL),
(23, 23, 1, 2200, 0, '2026-02-05 19:48:01', '', NULL, NULL),
(24, 24, 1, 0, 2000, '2026-02-06 17:55:00', '', NULL, NULL),
(25, 25, 1, 0, 3500, '2026-02-06 17:55:00', '', NULL, NULL),
(26, 26, 1, 5500, 0, '2026-02-06 14:55:36', '', NULL, NULL),
(27, 27, 1, 0, 2200, '2026-02-06 21:43:00', '', NULL, NULL),
(28, 28, 1, 2200, 0, '2026-02-06 18:43:11', '', NULL, NULL),
(29, 29, 1, 0, 1800, '2026-02-06 22:19:00', '', NULL, NULL),
(30, 30, 1, 1800, 0, '2026-02-06 19:19:35', '', NULL, NULL),
(31, 31, 1, 0, 32500, '2026-02-07 21:17:00', '', NULL, NULL),
(32, 32, 1, 32500, 0, '2026-02-07 18:22:15', '', NULL, NULL),
(33, 33, 1, 0, 3450, '2026-02-08 17:56:00', '', NULL, NULL),
(34, 34, 1, 3450, 0, '2026-02-08 14:57:28', '', NULL, NULL),
(35, 35, 1, 0, 3030, '2026-02-08 18:00:00', '', NULL, NULL),
(36, 36, 1, 3030, 0, '2026-02-08 16:50:10', '', NULL, NULL),
(37, 37, 1, 0, 2900, '2026-02-09 19:11:00', '', NULL, NULL),
(38, 38, 1, 2900, 0, '2026-02-09 16:10:57', '', NULL, NULL),
(39, 39, 1, 0, 1500, '2026-02-09 19:21:00', '', NULL, NULL),
(40, 40, 1, 1500, 0, '2026-02-09 16:22:03', '', NULL, NULL),
(41, 41, 1, 0, 2390, '2026-02-09 19:26:00', '', NULL, NULL),
(42, 42, 1, 2390, 0, '2026-02-09 16:26:32', '', NULL, NULL),
(43, 43, 1, 0, 9200, '2026-02-10 18:15:00', '', NULL, NULL),
(44, 44, 1, 9200, 0, '2026-02-10 15:15:26', '', NULL, NULL),
(45, 45, 1, 0, 850, '2026-02-11 19:21:00', '', NULL, NULL),
(46, 46, 1, 850, 0, '2026-02-11 16:21:13', '', NULL, NULL),
(47, 47, 1, 0, 850, '2026-02-11 19:23:00', '', NULL, NULL),
(48, 48, 1, 850, 0, '2026-02-11 16:23:42', '', NULL, NULL),
(49, 49, 1, 0, 3800, '2026-02-11 21:23:00', '', NULL, NULL),
(50, 50, 1, 3800, 0, '2026-02-11 18:26:05', '', NULL, NULL),
(51, 51, 1, 0, 3800, '2026-02-11 21:27:00', '', NULL, NULL),
(52, 52, 1, 3800, 0, '2026-02-11 18:28:05', '', NULL, NULL),
(53, 53, 1, 0, 2795, '2026-02-11 21:30:00', '', NULL, NULL),
(54, 54, 1, 2795, 0, '2026-02-11 18:30:40', '', NULL, NULL),
(55, 55, 1, 0, 1400, '2026-02-11 22:25:00', '', NULL, NULL),
(56, 56, 1, 1400, 0, '2026-02-11 19:25:57', '', NULL, NULL),
(57, 57, 1, 0, 750, '2026-02-11 22:46:00', '', NULL, NULL),
(58, 58, 1, 750, 0, '2026-02-11 19:47:31', '', NULL, NULL),
(59, 59, 1, 0, 750, '2026-02-11 22:48:00', '', NULL, NULL),
(60, 60, 1, 750, 0, '2026-02-11 19:49:10', '', NULL, NULL),
(61, 61, 1, 0, 1730, '2026-02-11 22:53:00', '', NULL, NULL),
(62, 62, 1, 1730, 0, '2026-02-11 19:53:50', '', NULL, NULL),
(63, 63, 1, 0, 11425, '2026-02-11 23:20:00', '', NULL, NULL),
(64, 64, 1, 11425, 0, '2026-02-11 20:23:11', '', NULL, NULL),
(65, 65, 1, 0, 1900, '2026-02-11 23:25:00', '', NULL, NULL),
(66, 66, 1, 1900, 0, '2026-02-11 20:25:04', '', NULL, NULL),
(67, 67, 1, 0, 2330, '2026-02-12 19:19:00', '', NULL, NULL),
(68, 68, 1, 2330, 0, '2026-02-12 16:20:19', '', NULL, NULL),
(69, 69, 1, 0, 650, '2026-02-12 21:01:00', '', NULL, NULL),
(70, 70, 1, 650, 0, '2026-02-12 18:02:44', '', NULL, NULL),
(71, 71, 1, 0, 3975, '2026-02-13 18:47:00', '', NULL, NULL),
(72, 72, 1, 3975, 0, '2026-02-13 15:48:52', '', NULL, NULL),
(73, 73, 1, 0, 2775, '2026-02-13 18:50:00', '', NULL, NULL),
(74, 74, 1, 2775, 0, '2026-02-13 15:50:38', '', NULL, NULL),
(75, 75, 1, 0, 2800, '2026-02-13 19:35:00', '', NULL, NULL),
(76, 76, 1, 2800, 0, '2026-02-13 16:35:14', '', NULL, NULL),
(77, 77, 1, 0, 1200, '2026-02-13 22:35:00', '', NULL, NULL),
(78, 78, 1, 0, 150, '2026-02-13 22:35:00', '', NULL, NULL),
(79, 79, 1, 1350, 0, '2026-02-13 19:36:05', '', NULL, NULL),
(80, 80, 1, 0, 3000, '2026-02-14 17:30:00', '', NULL, NULL),
(81, 81, 1, 3000, 0, '2026-02-14 14:30:05', '', NULL, NULL),
(82, 82, 1, 0, 580, '2026-02-14 20:24:00', '', NULL, NULL),
(83, 83, 1, 580, 0, '2026-02-14 17:25:19', '', NULL, NULL),
(84, 84, 1, 0, 1250, '2026-02-14 20:46:00', '', NULL, NULL),
(85, 85, 1, 1250, 0, '2026-02-14 17:47:57', '', NULL, NULL),
(86, 86, 1, 0, 3150, '2026-02-15 17:03:00', '', NULL, NULL),
(87, 87, 1, 3150, 0, '2026-02-15 14:03:30', '', NULL, NULL),
(88, 88, 1, 0, 1600, '2026-02-15 17:19:00', '', NULL, NULL),
(89, 89, 1, 0, 50, '2026-02-15 17:19:00', '', NULL, NULL),
(90, 90, 1, 1650, 0, '2026-02-15 14:46:23', '', NULL, NULL),
(91, 91, 1, 0, 2580, '2026-02-15 21:58:00', '', NULL, NULL),
(92, 92, 1, 2580, 0, '2026-02-15 18:58:17', '', NULL, NULL),
(93, 93, 1, 0, 1000, '2026-02-15 22:45:00', '', NULL, NULL),
(94, 94, 1, 1000, 0, '2026-02-15 19:48:50', '', NULL, NULL),
(95, 95, 1, 0, 25700, '2026-02-16 17:41:00', '', NULL, NULL),
(96, 96, 1, 25700, 0, '2026-02-16 14:42:35', '', NULL, NULL),
(97, 97, 1, 0, 3100, '2026-02-17 18:18:00', '', NULL, NULL),
(98, 98, 1, 3100, 0, '2026-02-17 15:18:39', '', NULL, NULL),
(99, 99, 1, 0, 1350, '2026-02-17 19:26:00', '', NULL, NULL),
(100, 100, 1, 1350, 0, '2026-02-17 16:26:03', '', NULL, NULL),
(101, 101, 1, 0, 600, '2026-02-18 23:31:00', '', NULL, NULL),
(102, 102, 1, 0, 630, '2026-02-18 23:31:00', '', NULL, NULL),
(103, 103, 1, 1230, 0, '2026-02-18 20:32:29', '', NULL, NULL),
(104, 104, 1, 0, 4700, '2026-02-20 01:08:00', '', NULL, NULL),
(105, 105, 1, 4700, 0, '2026-02-19 22:09:15', '', NULL, NULL),
(106, 106, 1, 0, 7130, '2026-02-20 23:33:00', '', NULL, NULL),
(107, 107, 1, 0, 150, '2026-02-20 23:33:00', '', NULL, NULL),
(108, 108, 1, 7280, 0, '2026-02-20 20:35:14', '', NULL, NULL),
(109, 109, 1, 0, 965, '2026-02-21 21:13:00', '', NULL, NULL),
(110, 110, 1, 965, 0, '2026-02-21 18:13:42', '', NULL, NULL),
(111, 111, 1, 0, 1620, '2026-02-21 21:41:00', '', NULL, NULL),
(112, 112, 1, 1620, 0, '2026-02-21 18:41:20', '', NULL, NULL),
(113, 113, 1, 0, 1350, '2026-02-22 21:41:00', '', NULL, NULL),
(114, 114, 1, 1350, 0, '2026-02-22 18:41:17', '', NULL, NULL),
(115, 115, 1, 0, 650, '2026-02-23 00:49:00', '', NULL, NULL),
(116, 116, 1, 650, 0, '2026-02-22 21:49:51', '', NULL, NULL),
(117, 117, 1, 0, 1720, '2026-02-23 01:24:00', '', NULL, NULL),
(118, 118, 1, 0, 150, '2026-02-23 01:24:00', '', NULL, NULL),
(119, 119, 1, 1870, 0, '2026-02-22 22:24:54', '', NULL, NULL),
(120, 120, 1, 0, 1850, '2026-02-23 17:23:00', '', NULL, NULL),
(121, 121, 1, 1850, 0, '2026-02-23 14:22:54', '', NULL, NULL),
(122, 122, 1, 0, 2020, '2026-02-24 00:24:00', '', NULL, NULL),
(123, 123, 1, 2020, 0, '2026-02-23 21:24:18', '', NULL, NULL),
(124, 124, 1, 0, 12040, '2026-02-24 01:42:00', '', NULL, NULL),
(125, 125, 1, 0, 2400, '2026-02-24 01:42:00', '', NULL, NULL),
(126, 126, 1, 14440, 0, '2026-02-23 22:47:15', '', NULL, NULL),
(127, 127, 1, 0, 2300, '2026-02-24 22:18:00', '', NULL, NULL),
(128, 128, 1, 2300, 0, '2026-02-24 19:17:33', '', NULL, NULL),
(129, 129, 1, 0, 870, '2026-02-24 23:44:00', '', NULL, NULL),
(130, 130, 1, 870, 0, '2026-02-24 20:44:58', '', NULL, NULL),
(131, 131, 1, 0, 1100, '2026-02-25 21:02:00', '', NULL, NULL),
(132, 132, 1, 1100, 0, '2026-02-25 18:24:14', '', NULL, NULL),
(133, 133, 1, 0, 2200, '2026-02-25 22:53:00', '', NULL, NULL),
(134, 134, 1, 2200, 0, '2026-02-25 19:53:52', '', NULL, NULL),
(135, 135, 1, 0, 800, '2026-02-25 23:02:00', '', NULL, NULL),
(136, 136, 1, 800, 0, '2026-02-25 20:01:55', '', NULL, NULL),
(137, 137, 1, 0, 100, '2026-02-26 23:21:00', '', NULL, NULL),
(138, 138, 1, 0, 3000, '2026-02-26 23:21:00', '', NULL, NULL),
(139, 139, 1, 3100, 0, '2026-02-26 20:22:10', '', NULL, NULL),
(140, 140, 1, 0, 630, '2026-02-26 23:32:00', '', NULL, NULL),
(141, 141, 1, 630, 0, '2026-02-26 20:32:45', '', NULL, NULL),
(142, 142, 1, 0, 920, '2026-02-27 21:17:00', '', NULL, NULL),
(143, 143, 1, 920, 0, '2026-02-27 18:18:07', '', NULL, NULL),
(144, 144, 1, 0, 1540, '2026-02-27 21:34:00', '', NULL, NULL),
(145, 145, 1, 1540, 0, '2026-02-27 18:34:36', '', NULL, NULL),
(146, 146, 1, 0, 11770, '2026-02-27 22:24:00', '', NULL, NULL),
(147, 147, 1, 0, 2000, '2026-02-27 22:24:00', '', NULL, NULL),
(148, 148, 1, 13770, 0, '2026-02-27 19:24:18', '', NULL, NULL),
(149, 149, 1, 0, 750, '2026-02-28 00:28:00', '', NULL, NULL),
(150, 150, 1, 750, 0, '2026-02-27 21:27:32', '', NULL, NULL),
(151, 151, 1, 0, 1400, '2026-02-28 00:37:00', '', NULL, NULL),
(152, 152, 1, 1400, 0, '2026-02-27 21:37:28', '', NULL, NULL),
(153, 153, 1, 0, 600, '2026-02-28 00:54:00', '', NULL, NULL),
(154, 154, 1, 0, 3000, '2026-02-28 00:54:00', '', NULL, NULL),
(155, 155, 1, 3600, 0, '2026-02-27 21:53:55', '', NULL, NULL),
(156, 156, 1, 0, 550, '2026-02-28 22:01:00', '', NULL, NULL),
(157, 157, 1, 550, 0, '2026-02-28 19:01:00', '', NULL, NULL),
(158, 158, 1, 0, 3450, '2026-02-28 23:17:00', '', NULL, NULL),
(159, 159, 1, 3450, 0, '2026-02-28 20:17:15', '', NULL, NULL),
(160, 160, 1, 0, 14000, '2026-03-01 21:19:00', '', NULL, NULL),
(161, 161, 1, 0, 650, '2026-03-01 21:19:00', '', NULL, NULL),
(162, 162, 1, 14650, 0, '2026-03-01 18:21:31', '', NULL, NULL),
(163, 163, 1, 0, 1420, '2026-03-01 22:38:00', '', NULL, NULL),
(164, 164, 1, 1420, 0, '2026-03-01 19:38:14', '', NULL, NULL),
(165, 165, 1, 0, 1600, '2026-03-01 23:14:00', '', NULL, NULL),
(166, 166, 1, 1600, 0, '2026-03-01 20:13:38', '', NULL, NULL),
(167, 167, 1, 0, 3930, '2026-03-01 23:39:00', '', NULL, NULL),
(168, 168, 1, 3930, 0, '2026-03-01 20:39:08', '', NULL, NULL),
(169, 169, 1, 0, 950, '2026-03-02 01:00:00', '', NULL, NULL),
(170, 170, 1, 950, 0, '2026-03-01 21:59:59', '', NULL, NULL),
(171, 171, 1, 0, 980, '2026-03-02 01:10:00', '', NULL, NULL),
(172, 172, 1, 980, 0, '2026-03-01 22:10:20', '', NULL, NULL),
(173, 173, 1, 0, 1300, '2026-03-02 01:13:00', '', NULL, NULL),
(174, 174, 1, 1300, 0, '2026-03-01 22:12:50', '', NULL, NULL),
(175, 175, 1, 0, 4535, '2026-03-02 01:20:00', '', NULL, NULL),
(176, 176, 1, 4535, 0, '2026-03-01 22:19:38', '', NULL, NULL),
(177, 177, 1, 0, 1100, '2026-03-02 01:40:00', '', NULL, NULL),
(178, 178, 1, 1100, 0, '2026-03-01 22:40:12', '', NULL, NULL),
(179, 179, 1, 0, 830, '2026-03-03 00:12:00', '', NULL, NULL),
(180, 180, 1, 830, 0, '2026-03-02 21:13:48', '', NULL, NULL),
(181, 181, 1, 0, 8600, '2026-03-03 00:14:00', '', NULL, NULL),
(182, 182, 1, 8600, 0, '2026-03-02 21:17:13', '', NULL, NULL),
(183, 183, 1, 0, 2800, '2026-03-03 16:53:00', '', NULL, NULL),
(184, 184, 1, 2800, 0, '2026-03-03 13:55:57', '', NULL, NULL),
(185, 185, 1, 0, 2150, '2026-03-03 16:56:00', '', NULL, NULL),
(186, 186, 1, 2150, 0, '2026-03-03 13:57:40', '', NULL, NULL),
(187, 187, 1, 0, 290, '2026-03-03 21:12:00', '', NULL, NULL),
(188, 188, 1, 0, 500, '2026-03-03 21:12:00', '', NULL, NULL),
(189, 189, 1, 790, 0, '2026-03-03 18:12:36', '', NULL, NULL),
(190, 190, 1, 0, 42000, '2026-03-04 00:30:00', '', NULL, NULL),
(191, 191, 1, 42000, 0, '2026-03-03 22:19:13', '', NULL, NULL),
(192, 192, 1, 0, 3100, '2026-03-04 01:25:00', '', NULL, NULL),
(193, 193, 1, 3100, 0, '2026-03-03 22:29:50', '', NULL, NULL),
(194, 194, 1, 0, 5350, '2026-03-04 01:30:00', '', NULL, NULL),
(195, 195, 1, 5350, 0, '2026-03-03 22:31:19', '', NULL, NULL),
(196, 196, 1, 0, 1550, '2026-03-04 02:10:00', '', NULL, NULL),
(197, 197, 1, 1550, 0, '2026-03-03 23:11:27', '', NULL, NULL),
(198, 198, 1, 0, 7400, '2026-03-04 07:19:00', '', NULL, NULL),
(199, 199, 1, 7400, 0, '2026-03-04 04:20:24', '', NULL, NULL),
(200, 200, 1, 0, 31100, '2026-03-04 22:38:00', '', NULL, NULL),
(201, 201, 1, 31100, 0, '2026-03-04 19:39:19', '', NULL, NULL),
(202, 202, 1, 0, 4450, '2026-03-04 23:24:00', '', NULL, NULL),
(203, 203, 1, 4450, 0, '2026-03-04 20:30:40', '', NULL, NULL),
(204, 204, 1, 0, 7700, '2026-03-04 23:37:00', '', NULL, NULL),
(205, 205, 1, 7700, 0, '2026-03-04 20:37:38', '', NULL, NULL),
(206, 206, 1, 0, 1550, '2026-03-05 22:26:00', '', NULL, NULL),
(207, 207, 1, 1550, 0, '2026-03-05 19:26:39', '', NULL, NULL),
(208, 208, 1, 0, 400, '2026-03-05 22:53:00', '', NULL, NULL),
(209, 209, 1, 400, 0, '2026-03-05 19:54:35', '', NULL, NULL),
(210, 210, 1, 0, 840, '2026-03-05 23:43:00', '', NULL, NULL),
(211, 211, 1, 840, 0, '2026-03-05 20:44:17', '', NULL, NULL),
(212, 212, 1, 0, 4450, '2026-03-06 00:10:00', '', NULL, NULL),
(213, 213, 1, 4450, 0, '2026-03-05 21:11:24', '', NULL, NULL),
(214, 214, 1, 0, 550, '2026-03-06 00:20:00', '', NULL, NULL),
(215, 215, 1, 550, 0, '2026-03-05 21:20:48', '', NULL, NULL),
(216, 216, 1, 0, 750, '2026-03-06 02:00:00', '', NULL, NULL),
(217, 217, 1, 750, 0, '2026-03-05 23:00:42', '', NULL, NULL),
(218, 218, 1, 0, 11300, '2026-03-06 21:11:00', '', NULL, NULL),
(219, 219, 1, 0, 650, '2026-03-06 21:11:00', '', NULL, NULL),
(220, 220, 1, 11950, 0, '2026-03-06 18:13:00', '', NULL, NULL),
(221, 221, 1, 0, 800, '2026-03-06 21:16:00', '', NULL, NULL),
(222, 222, 1, 800, 0, '2026-03-06 18:17:32', '', NULL, NULL),
(223, 223, 1, 0, 1550, '2026-03-06 22:44:00', '', NULL, NULL),
(224, 224, 1, 1550, 0, '2026-03-06 19:44:47', '', NULL, NULL),
(225, 225, 1, 0, 1200, '2026-03-06 23:08:00', '', NULL, NULL),
(226, 226, 1, 1200, 0, '2026-03-06 20:09:17', '', NULL, NULL),
(227, 227, 1, 0, 1930, '2026-03-07 00:03:00', '', NULL, NULL),
(228, 228, 1, 1930, 0, '2026-03-06 21:05:08', '', NULL, NULL),
(229, 229, 1, 0, 5500, '2026-03-07 00:07:00', '', NULL, NULL),
(230, 230, 1, 5500, 0, '2026-03-06 21:07:47', '', NULL, NULL),
(231, 231, 1, 0, 5000, '2026-03-07 00:08:00', '', NULL, NULL),
(232, 232, 1, 5000, 0, '2026-03-06 21:09:07', '', NULL, NULL),
(233, 233, 1, 0, 16650, '2026-03-07 00:26:00', '', NULL, NULL),
(234, 234, 1, 16650, 0, '2026-03-06 21:26:35', '', NULL, NULL),
(235, 235, 1, 0, 6000, '2026-03-07 08:08:00', '', NULL, NULL),
(236, 236, 1, 0, 3500, '2026-03-07 08:08:00', '', NULL, NULL),
(237, 237, 1, 9500, 0, '2026-03-07 05:19:52', '', NULL, NULL),
(238, 238, 1, 0, 1500, '2026-03-07 21:13:00', '', NULL, NULL),
(239, 239, 1, 1500, 0, '2026-03-07 18:13:45', '', NULL, NULL),
(240, 240, 1, 0, 6450, '2026-03-07 21:25:00', '', NULL, NULL),
(241, 241, 1, 6450, 0, '2026-03-07 18:26:02', '', NULL, NULL),
(242, 242, 1, 0, 1500, '2026-03-07 21:51:00', '', NULL, NULL),
(243, 243, 1, 1500, 0, '2026-03-07 18:52:09', '', NULL, NULL),
(244, 244, 1, 0, 3400, '2026-03-08 00:07:00', '', NULL, NULL),
(245, 245, 1, 0, 2300, '2026-03-08 00:07:00', '', NULL, NULL),
(246, 246, 1, 5700, 0, '2026-03-07 21:08:46', '', NULL, NULL),
(247, 247, 1, 0, 1620, '2026-03-08 00:27:00', '', NULL, NULL),
(248, 248, 1, 1620, 0, '2026-03-07 21:28:29', '', NULL, NULL),
(249, 249, 1, 0, 10800, '2026-03-08 00:30:00', '', NULL, NULL),
(250, 250, 1, 10800, 0, '2026-03-07 21:30:40', '', NULL, NULL),
(251, 251, 1, 0, 1980, '2026-03-08 02:15:00', '', NULL, NULL),
(252, 252, 1, 1980, 0, '2026-03-07 23:16:10', '', NULL, NULL),
(253, 253, 1, 0, 2230, '2026-03-08 17:06:00', '', NULL, NULL),
(254, 254, 1, 2230, 0, '2026-03-08 14:07:29', '', NULL, NULL),
(255, 255, 1, 0, 680, '2026-03-08 21:30:00', '', NULL, NULL),
(256, 256, 1, 0, 8240, '2026-03-08 21:30:00', '', NULL, NULL),
(257, 257, 1, 8920, 0, '2026-03-08 18:32:36', '', NULL, NULL),
(258, 258, 1, 0, 10170, '2026-03-08 22:18:00', '', NULL, NULL),
(259, 259, 1, 10170, 0, '2026-03-08 19:19:15', '', NULL, NULL),
(260, 260, 1, 0, 18900, '2026-03-08 22:19:00', '', NULL, NULL),
(261, 261, 1, 18900, 0, '2026-03-08 19:21:09', '', NULL, NULL),
(262, 262, 1, 0, 2400, '2026-03-08 22:54:00', '', NULL, NULL),
(263, 263, 1, 0, 6400, '2026-03-08 22:54:00', '', NULL, NULL),
(264, 264, 1, 8800, 0, '2026-03-08 19:55:00', '', NULL, NULL),
(265, 265, 1, 0, 3000, '2026-03-09 00:30:00', '', NULL, NULL),
(266, 266, 1, 0, 12500, '2026-03-09 00:30:00', '', NULL, NULL),
(267, 267, 1, 15500, 0, '2026-03-08 21:31:58', '', NULL, NULL),
(268, 268, 1, 0, 5100, '2026-03-09 02:06:00', '', NULL, NULL),
(269, 269, 1, 5100, 0, '2026-03-08 23:07:08', '', NULL, NULL),
(270, 270, 1, 0, 1130, '2026-03-09 02:08:00', '', NULL, NULL),
(271, 271, 1, 1130, 0, '2026-03-08 23:09:20', '', NULL, NULL),
(272, 272, 1, 0, 1810, '2026-03-09 02:18:00', '', NULL, NULL),
(273, 273, 1, 1810, 0, '2026-03-08 23:19:03', '', NULL, NULL),
(274, 274, 1, 0, 1040, '2026-03-09 17:23:00', '', NULL, NULL),
(275, 275, 1, 1040, 0, '2026-03-09 14:24:17', '', NULL, NULL),
(276, 276, 1, 0, 910, '2026-03-11 21:53:00', '', NULL, NULL),
(277, 277, 1, 910, 0, '2026-03-11 18:54:42', '', NULL, NULL),
(278, 278, 1, 0, 7080, '2026-03-11 22:00:00', '', NULL, NULL),
(279, 279, 1, 7080, 0, '2026-03-11 19:00:43', '', NULL, NULL),
(280, 280, 1, 0, 2210, '2026-03-11 23:34:00', '', NULL, NULL),
(281, 281, 1, 2210, 0, '2026-03-11 20:35:50', '', NULL, NULL),
(282, 282, 1, 0, 550, '2026-03-11 23:37:00', '', NULL, NULL),
(283, 283, 1, 550, 0, '2026-03-11 20:37:44', '', NULL, NULL),
(284, 284, 1, 0, 1000, '2026-03-12 07:39:00', '', NULL, NULL),
(285, 285, 1, 1000, 0, '2026-03-12 04:40:19', '', NULL, NULL),
(286, 286, 1, 0, 1150, '2026-03-12 21:37:00', '', NULL, NULL),
(287, 287, 1, 1150, 0, '2026-03-12 18:38:38', '', NULL, NULL),
(288, 288, 1, 0, 1250, '2026-03-12 21:39:00', '', NULL, NULL),
(289, 289, 1, 1250, 0, '2026-03-12 18:39:42', '', NULL, NULL),
(290, 290, 1, 0, 1000, '2026-03-12 22:46:00', '', NULL, NULL),
(291, 291, 1, 1000, 0, '2026-03-12 19:46:40', '', NULL, NULL),
(292, 292, 1, 0, 1290, '2026-03-12 23:48:00', '', NULL, NULL),
(293, 293, 1, 1290, 0, '2026-03-12 20:49:31', '', NULL, NULL),
(294, 294, 1, 0, 1700, '2026-03-13 00:36:00', '', NULL, NULL),
(295, 295, 1, 1700, 0, '2026-03-12 21:36:50', '', NULL, NULL),
(296, 296, 1, 0, 1100, '2026-03-13 02:03:00', '', NULL, NULL),
(297, 297, 1, 1100, 0, '2026-03-12 23:03:54', '', NULL, NULL),
(298, 298, 1, 0, 1000, '2026-03-13 07:34:00', '', NULL, NULL),
(299, 299, 1, 0, 980, '2026-03-13 07:34:00', '', NULL, NULL),
(300, 300, 1, 1980, 0, '2026-03-13 04:34:34', '', NULL, NULL),
(301, 301, 1, 0, 7600, '2026-03-13 21:33:00', '', NULL, NULL),
(302, 302, 1, 7600, 0, '2026-03-13 18:34:13', '', NULL, NULL),
(303, 303, 1, 0, 1800, '2026-03-13 22:32:00', '', NULL, NULL),
(304, 304, 1, 1800, 0, '2026-03-13 19:33:09', '', NULL, NULL),
(305, 305, 1, 0, 1700, '2026-03-13 22:49:00', '', NULL, NULL),
(306, 306, 1, 1700, 0, '2026-03-13 19:49:34', '', NULL, NULL),
(307, 307, 1, 0, 600, '2026-03-13 23:02:00', '', NULL, NULL),
(308, 308, 1, 600, 0, '2026-03-13 20:03:23', '', NULL, NULL),
(309, 309, 1, 0, 1070, '2026-03-13 23:38:00', '', NULL, NULL),
(310, 310, 1, 1070, 0, '2026-03-13 20:39:23', '', NULL, NULL),
(311, 311, 1, 0, 300, '2026-03-14 00:18:00', '', NULL, NULL),
(312, 312, 1, 300, 0, '2026-03-13 21:18:59', '', NULL, NULL),
(313, 313, 1, 0, 1700, '2026-03-14 00:49:00', '', NULL, NULL),
(314, 314, 1, 1700, 0, '2026-03-13 21:50:15', '', NULL, NULL),
(315, 315, 1, 0, 2670, '2026-03-14 02:49:00', '', NULL, NULL),
(316, 316, 1, 2670, 0, '2026-03-13 23:52:01', '', NULL, NULL),
(317, 317, 1, 0, 7300, '2026-03-14 06:00:00', '', NULL, NULL),
(318, 318, 1, 7300, 0, '2026-03-14 03:01:22', '', NULL, NULL),
(319, 319, 1, 0, 2550, '2026-03-14 07:55:00', '', NULL, NULL),
(320, 320, 1, 2550, 0, '2026-03-14 04:55:57', '', NULL, NULL),
(321, 321, 1, 0, 1500, '2026-03-14 21:55:00', '', NULL, NULL),
(322, 322, 1, 1500, 0, '2026-03-14 18:57:48', '', NULL, NULL),
(323, 323, 1, 0, 1000, '2026-03-14 21:58:00', '', NULL, NULL),
(324, 324, 1, 1000, 0, '2026-03-14 18:59:16', '', NULL, NULL),
(325, 325, 1, 0, 3100, '2026-03-14 22:09:00', '', NULL, NULL),
(326, 326, 1, 3100, 0, '2026-03-14 19:10:06', '', NULL, NULL),
(327, 327, 1, 0, 950, '2026-03-14 22:54:00', '', NULL, NULL),
(328, 328, 1, 950, 0, '2026-03-14 19:55:05', '', NULL, NULL),
(329, 329, 1, 0, 2600, '2026-03-15 01:53:00', '', NULL, NULL),
(330, 330, 1, 2600, 0, '2026-03-14 22:54:02', '', NULL, NULL),
(331, 331, 1, 0, 900, '2026-03-15 02:03:00', '', NULL, NULL),
(332, 332, 1, 900, 0, '2026-03-14 23:04:37', '', NULL, NULL),
(333, 333, 1, 0, 1950, '2026-03-15 07:49:00', '', NULL, NULL),
(334, 334, 1, 1950, 0, '2026-03-15 04:50:37', '', NULL, NULL),
(335, 335, 1, 0, 2550, '2026-03-15 17:11:00', '', NULL, NULL),
(336, 336, 1, 2550, 0, '2026-03-15 14:13:17', '', NULL, NULL),
(337, 337, 1, 0, 800, '2026-03-15 17:34:00', '', NULL, NULL),
(338, 338, 1, 800, 0, '2026-03-15 14:34:52', '', NULL, NULL),
(339, 339, 1, 0, 5500, '2026-03-15 22:45:00', '', NULL, NULL),
(340, 340, 1, 5500, 0, '2026-03-15 19:50:15', '', NULL, NULL),
(341, 341, 1, 0, 2300, '2026-03-15 23:57:00', '', NULL, NULL),
(342, 342, 1, 2300, 0, '2026-03-15 22:17:25', '', NULL, NULL),
(343, 343, 1, 0, 1445, '2026-03-16 07:39:00', '', NULL, NULL),
(344, 344, 1, 1445, 0, '2026-03-16 04:39:44', '', NULL, NULL),
(345, 345, 1, 0, 4300, '2026-03-16 17:03:00', '', NULL, NULL),
(346, 346, 1, 4300, 0, '2026-03-16 14:04:34', '', NULL, NULL),
(347, 347, 1, 0, 575, '2026-03-17 02:06:00', '', NULL, NULL),
(348, 348, 1, 575, 0, '2026-03-16 23:07:04', '', NULL, NULL),
(349, 349, 1, 0, 6850, '2026-03-18 01:13:00', '', NULL, NULL),
(350, 350, 1, 6850, 0, '2026-03-17 22:14:39', '', NULL, NULL),
(351, 351, 1, 0, 1800, '2026-03-18 01:40:00', '', NULL, NULL),
(352, 352, 1, 1800, 0, '2026-03-17 22:41:20', '', NULL, NULL),
(353, 353, 1, 0, 6500, '2026-03-18 08:33:00', '', NULL, NULL),
(354, 354, 1, 6500, 0, '2026-03-18 05:36:33', '', NULL, NULL),
(355, 355, 1, 0, 200, '2026-03-18 22:29:00', '', NULL, NULL),
(356, 356, 1, 0, 2000, '2026-03-18 22:29:00', '', NULL, NULL),
(357, 357, 1, 2200, 0, '2026-03-18 19:30:10', '', NULL, NULL),
(358, 358, 1, 0, 900, '2026-03-18 22:30:00', '', NULL, NULL),
(359, 359, 1, 900, 0, '2026-03-18 19:30:51', '', NULL, NULL),
(360, 360, 1, 0, 850, '2026-03-18 23:42:00', '', NULL, NULL),
(361, 361, 1, 850, 0, '2026-03-18 20:43:09', '', NULL, NULL),
(362, 362, 1, 0, 1980, '2026-03-18 23:57:00', '', NULL, NULL),
(363, 363, 1, 1980, 0, '2026-03-18 20:57:54', '', NULL, NULL),
(364, 364, 1, 0, 28900, '2026-03-19 00:20:00', '', NULL, NULL),
(365, 365, 1, 28900, 0, '2026-03-18 21:22:46', '', NULL, NULL),
(366, 366, 1, 0, 1270, '2026-03-19 01:13:00', '', NULL, NULL),
(367, 367, 1, 1270, 0, '2026-03-18 22:13:21', '', NULL, NULL),
(368, 368, 1, 0, 860, '2026-03-19 02:01:00', '', NULL, NULL),
(369, 369, 1, 860, 0, '2026-03-18 23:01:45', '', NULL, NULL),
(370, 370, 1, 0, 1700, '2026-03-19 22:49:00', '', NULL, NULL),
(371, 371, 1, 1700, 0, '2026-03-19 19:50:02', '', NULL, NULL),
(372, 372, 1, 0, 2100, '2026-03-23 18:31:00', '', NULL, NULL),
(373, 373, 1, 2100, 0, '2026-03-23 15:32:35', '', NULL, NULL),
(374, 374, 1, 0, 1375, '2026-03-23 19:58:00', '', NULL, NULL),
(375, 375, 1, 1375, 0, '2026-03-23 16:59:10', '', NULL, NULL),
(376, 376, 1, 0, 1395, '2026-03-23 22:58:00', '', NULL, NULL),
(377, 377, 1, 1395, 0, '2026-03-23 19:58:42', '', NULL, NULL),
(378, 378, 1, 0, 9100, '2026-03-23 23:23:00', '', NULL, NULL),
(379, 379, 1, 9100, 0, '2026-03-23 20:26:19', '', NULL, NULL),
(380, 380, 1, 0, 1000, '2026-03-24 10:41:00', '', NULL, NULL),
(381, 381, 1, 0, 520, '2026-03-24 10:41:00', '', NULL, NULL),
(382, 382, 1, 1520, 0, '2026-03-24 07:42:14', '', NULL, NULL),
(383, 383, 1, 0, 3005, '2026-03-24 17:44:00', '', NULL, NULL),
(384, 384, 1, 3005, 0, '2026-03-24 14:46:43', '', NULL, NULL),
(385, 385, 1, 0, 900, '2026-03-24 19:36:00', '', NULL, NULL),
(386, 386, 1, 900, 0, '2026-03-24 16:37:41', '', NULL, NULL),
(387, 387, 1, 0, 1650, '2026-03-24 21:52:00', '', NULL, NULL),
(388, 388, 1, 1650, 0, '2026-03-24 18:53:22', '', NULL, NULL),
(389, 389, 1, 0, 10340, '2026-03-24 22:01:00', '', NULL, NULL),
(390, 390, 1, 0, 1860, '2026-03-24 22:01:00', '', NULL, NULL),
(391, 391, 1, 12200, 0, '2026-03-24 19:02:13', '', NULL, NULL),
(392, 392, 1, 0, 860, '2026-03-24 22:40:00', '', NULL, NULL),
(393, 393, 1, 860, 0, '2026-03-24 19:40:32', '', NULL, NULL),
(394, 394, 1, 0, 2760, '2026-03-25 18:31:00', '', NULL, NULL),
(395, 395, 1, 0, 22610, '2026-03-25 18:31:00', '', NULL, NULL),
(396, 396, 1, 25370, 0, '2026-03-25 15:32:28', '', NULL, NULL),
(397, 397, 1, 0, 1400, '2026-03-25 21:12:00', '', NULL, NULL),
(398, 398, 1, 1400, 0, '2026-03-25 18:12:41', '', NULL, NULL),
(399, 399, 1, 0, 620, '2026-03-25 23:26:00', '', NULL, NULL),
(400, 400, 1, 620, 0, '2026-03-25 20:28:06', '', NULL, NULL),
(401, 401, 1, 0, 1075, '2026-03-26 20:59:00', '', NULL, NULL),
(402, 402, 1, 1075, 0, '2026-03-26 17:59:41', '', NULL, NULL),
(403, 403, 1, 0, 600, '2026-03-26 21:50:00', '', NULL, NULL),
(404, 404, 1, 0, 50, '2026-03-26 21:50:00', '', NULL, NULL),
(405, 405, 1, 650, 0, '2026-03-26 18:50:36', '', NULL, NULL),
(406, 406, 1, 0, 1600, '2026-03-26 21:55:00', '', NULL, NULL),
(407, 407, 1, 1600, 0, '2026-03-26 18:56:18', '', NULL, NULL),
(408, 408, 1, 0, 2150, '2026-03-26 22:58:00', '', NULL, NULL),
(409, 409, 1, 2150, 0, '2026-03-26 19:58:35', '', NULL, NULL),
(410, 410, 1, 0, 8100, '2026-03-27 17:28:00', '', NULL, NULL),
(411, 411, 1, 8100, 0, '2026-03-27 14:28:24', '', NULL, NULL),
(412, 412, 1, 0, 1050, '2026-03-27 17:30:00', '', NULL, NULL),
(413, 413, 1, 1050, 0, '2026-03-27 14:33:24', '', NULL, NULL),
(414, 414, 1, 0, 1600, '2026-03-27 21:24:00', '', NULL, NULL),
(415, 415, 1, 1600, 0, '2026-03-27 18:24:44', '', NULL, NULL),
(416, 416, 1, 0, 650, '2026-03-27 22:05:00', '', NULL, NULL),
(417, 417, 1, 0, 2300, '2026-03-27 22:05:00', '', NULL, NULL),
(418, 418, 1, 2950, 0, '2026-03-27 19:05:46', '', NULL, NULL),
(419, 419, 1, 0, 1150, '2026-03-27 23:04:00', '', NULL, NULL),
(420, 420, 1, 1150, 0, '2026-03-27 20:04:33', '', NULL, NULL),
(421, 421, 1, 0, 6500, '2026-03-28 17:58:00', '', NULL, NULL),
(422, 422, 1, 6500, 0, '2026-03-28 15:00:27', '', NULL, NULL),
(423, 423, 1, 0, 2240, '2026-03-28 19:43:00', '', NULL, NULL),
(424, 424, 1, 2240, 0, '2026-03-28 16:43:42', '', NULL, NULL),
(425, 425, 1, 0, 8900, '2026-03-28 20:57:00', '', NULL, NULL),
(426, 426, 1, 8900, 0, '2026-03-28 17:58:46', '', NULL, NULL),
(427, 427, 1, 0, 3600, '2026-03-28 21:32:00', '', NULL, NULL),
(428, 428, 1, 3600, 0, '2026-03-28 18:33:33', '', NULL, NULL),
(429, 429, 1, 0, 550, '2026-03-28 22:29:00', '', NULL, NULL),
(430, 430, 1, 550, 0, '2026-03-28 19:30:04', '', NULL, NULL),
(431, 431, 1, 0, 1200, '2026-03-28 23:00:00', '', NULL, NULL),
(432, 432, 1, 1200, 0, '2026-03-28 20:00:07', '', NULL, NULL),
(433, 433, 1, 0, 880, '2026-03-29 19:20:00', '', NULL, NULL),
(434, 434, 1, 880, 0, '2026-03-29 16:20:49', '', NULL, NULL),
(435, 435, 1, 0, 6300, '2026-03-29 21:03:00', '', NULL, NULL),
(436, 436, 1, 6300, 0, '2026-03-29 18:07:38', '', NULL, NULL),
(437, 437, 1, 0, 1500, '2026-03-29 23:10:00', '', NULL, NULL),
(438, 438, 1, 1500, 0, '2026-03-29 20:10:35', '', NULL, NULL),
(439, 439, 1, 0, 1600, '2026-03-29 23:20:00', '', NULL, NULL),
(440, 440, 1, 1600, 0, '2026-03-29 20:20:42', '', NULL, NULL),
(441, 441, 1, 0, 1700, '2026-03-31 16:55:00', '', NULL, NULL),
(442, 442, 1, 1700, 0, '2026-03-31 13:55:54', '', NULL, NULL),
(443, 443, 1, 0, 800, '2026-03-31 19:36:00', '', NULL, NULL),
(444, 444, 1, 800, 0, '2026-03-31 16:36:34', '', NULL, NULL),
(445, 445, 1, 0, 1100, '2026-03-31 21:15:00', '', NULL, NULL),
(446, 446, 1, 1100, 0, '2026-03-31 18:16:02', '', NULL, NULL),
(447, 447, 1, 0, 1750, '2026-04-01 11:30:00', '', NULL, NULL),
(448, 448, 1, 1750, 0, '2026-04-01 08:30:16', '', NULL, NULL),
(449, 449, 1, 0, 3705, '2026-04-01 23:24:00', '', NULL, NULL),
(450, 450, 1, 3705, 0, '2026-04-01 20:24:46', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_settings`
--

CREATE TABLE `account_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `safe_account` int(11) NOT NULL,
  `bank_account` int(11) NOT NULL,
  `sales_account` int(11) NOT NULL,
  `purchase_account` int(11) NOT NULL,
  `purchase_Jewelry_account` int(11) NOT NULL DEFAULT 0,
  `purchase_old_account` int(11) NOT NULL DEFAULT 0,
  `purchase_pure_account` int(11) NOT NULL DEFAULT 0,
  `return_sales_account` int(11) NOT NULL,
  `return_purchase_account` int(11) NOT NULL,
  `stock_account` int(11) NOT NULL,
  `stock_Jewelry_account` int(11) NOT NULL DEFAULT 0,
  `stock_old_account` int(11) NOT NULL DEFAULT 0,
  `stock_pure_account` int(11) NOT NULL DEFAULT 0,
  `stock_under_account` int(11) NOT NULL DEFAULT 0,
  `sales_discount_account` int(11) NOT NULL,
  `purchase_discount_account` int(11) NOT NULL,
  `made_account` int(11) NOT NULL DEFAULT 0,
  `cost_account` int(11) NOT NULL,
  `reverse_profit_account` int(11) NOT NULL,
  `supplier_default_account` int(11) NOT NULL DEFAULT 0,
  `profit_account` int(11) NOT NULL,
  `sales_tax_account` int(11) NOT NULL,
  `purchase_tax_account` int(11) NOT NULL,
  `sales_tax_excise_account` int(11) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_settings`
--

INSERT INTO `account_settings` (`id`, `safe_account`, `bank_account`, `sales_account`, `purchase_account`, `purchase_Jewelry_account`, `purchase_old_account`, `purchase_pure_account`, `return_sales_account`, `return_purchase_account`, `stock_account`, `stock_Jewelry_account`, `stock_old_account`, `stock_pure_account`, `stock_under_account`, `sales_discount_account`, `purchase_discount_account`, `made_account`, `cost_account`, `reverse_profit_account`, `supplier_default_account`, `profit_account`, `sales_tax_account`, `purchase_tax_account`, `sales_tax_excise_account`, `warehouse_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2026-02-01 16:29:39', '2026-02-01 16:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `advance_payments`
--

CREATE TABLE `advance_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `advance_amount` double NOT NULL,
  `remain` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advance_payment_months`
--

CREATE TABLE `advance_payment_months` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `advance_payment_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `state` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `branch_phone` varchar(255) DEFAULT NULL,
  `branch_address` varchar(255) DEFAULT NULL,
  `commercial_record` varchar(255) DEFAULT NULL,
  `license_number` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `branch_phone`, `branch_address`, `commercial_record`, `license_number`, `status`, `created_at`, `updated_at`) VALUES
(1, '11/46500570', '8282295', 'قباء', '46500570', '11/46500570', 1, '2026-02-01 16:29:39', '2026-02-02 11:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashiers`
--

CREATE TABLE `cashiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `commercial_register` varchar(255) DEFAULT NULL,
  `license` varchar(255) DEFAULT NULL,
  `tax_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `bill_holder1` varchar(255) DEFAULT NULL,
  `bill_holder2` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catch_gold_recipts`
--

CREATE TABLE `catch_gold_recipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `docNumber` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `payment_type` int(11) NOT NULL,
  `from_account` int(11) NOT NULL,
  `to_account` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `gold21` decimal(10,2) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catch_gold_recipts_details`
--

CREATE TABLE `catch_gold_recipts_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `weight` decimal(10,2) NOT NULL,
  `weight21` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catch_recipts`
--

CREATE TABLE `catch_recipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `docNumber` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `from_account` int(11) NOT NULL,
  `to_account` int(11) NOT NULL,
  `client` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `notes` text NOT NULL,
  `payment_type` int(11) DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catch_types`
--

CREATE TABLE `catch_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `tax_excise` double DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `name_ar`, `name_en`, `code`, `slug`, `description`, `image_url`, `parent_id`, `tax_excise`, `branch_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'عام', 'عام', 'عام', NULL, NULL, '', '', 0, 0, 1, 1, 1, '2026-02-01 17:23:00', '2026-02-01 17:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `customer_group_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `vat_no` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `invoice_footer` text DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `award_points` double NOT NULL DEFAULT 0,
  `deposit_amount` double NOT NULL DEFAULT 0,
  `deposit_gold` double NOT NULL DEFAULT 0,
  `credit_gold` double NOT NULL DEFAULT 0,
  `opening_balance` double NOT NULL DEFAULT 0,
  `account_id` int(11) NOT NULL DEFAULT 0,
  `credit_amount` double NOT NULL DEFAULT 0,
  `stop_sale` int(11) NOT NULL DEFAULT 0,
  `representative_id_` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `group_id`, `group_name`, `customer_group_id`, `customer_group_name`, `name`, `company`, `vat_no`, `address`, `city`, `state`, `postal_code`, `country`, `email`, `phone`, `invoice_footer`, `logo`, `award_points`, `deposit_amount`, `deposit_gold`, `credit_gold`, `opening_balance`, `account_id`, `credit_amount`, `stop_sale`, `representative_id_`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, '', 0, '', 'عميل نقدي افتراضي', 'عميل نقدي افتراضي', '', '', '', '', '', '', '', '', '', '', 0, 821485, 0, 0, 0, 1, 821485, 0, 0, 1, 0, '2026-02-01 17:23:32', '2026-04-01 17:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `company_infos`
--

CREATE TABLE `company_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `faild_ar` varchar(255) DEFAULT NULL,
  `faild_en` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `taxNumber` varchar(255) DEFAULT NULL,
  `registrationNumber` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `currency_ar` varchar(255) DEFAULT NULL,
  `currency_en` varchar(255) DEFAULT NULL,
  `currency_label` varchar(255) DEFAULT NULL,
  `currency_label_en` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_infos`
--

INSERT INTO `company_infos` (`id`, `name_ar`, `name_en`, `faild_ar`, `faild_en`, `phone`, `phone2`, `fax`, `email`, `website`, `taxNumber`, `registrationNumber`, `address`, `currency_ar`, `currency_en`, `currency_label`, `currency_label_en`, `logo`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'فرع مؤسسة الجابرين للذهب - قباء', 'Al-Jabreen Est. For Gold- Quba', NULL, NULL, '8282295', NULL, NULL, NULL, NULL, '300038867500003', '4650036216', 'قباء', 'ريال سعودي', 'Ryal', 'ر.س', 'S.R', '1770043749.png', 1, '2026-02-02 11:49:09', '2026-02-02 11:49:09');

-- --------------------------------------------------------

--
-- Table structure for table `company_movements`
--

CREATE TABLE `company_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `company_id` int(11) NOT NULL,
  `paid_money` double NOT NULL,
  `debit_money` double NOT NULL,
  `credit_money` double NOT NULL,
  `paid_gold` double NOT NULL,
  `debit_gold` decimal(10,2) NOT NULL,
  `credit_gold` decimal(10,2) NOT NULL,
  `date` varchar(191) NOT NULL,
  `invoice_type` varchar(191) NOT NULL,
  `bill_id` double NOT NULL,
  `bill_number` varchar(191) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_movements`
--

INSERT INTO `company_movements` (`id`, `branch_id`, `company_id`, `paid_money`, `debit_money`, `credit_money`, `paid_gold`, `debit_gold`, `credit_gold`, `date`, `invoice_type`, `bill_id`, `bill_number`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 500, 0, 0, 0.00, 0.00, '2026-02-01 20:24:00', 'Work Exit Bill', 1, 'SWSI-1-000001', 1, '2026-02-01 17:24:00', '2026-02-01 17:24:00'),
(2, 1, 1, 0, 0, 500, 0, 0.00, 0.00, '2026-02-01 20:24:00', 'Enter Money Bill', 1, 'ME-1-000001', 1, '2026-02-01 17:24:00', '2026-02-01 17:24:00'),
(3, 1, 1, 0, 950, 0, 0, 0.00, 0.00, '2026-02-03 18:06:02', 'Work Exit Bill', 2, 'SWSI-1-000002', 1, '2026-02-03 15:06:02', '2026-02-03 15:06:02'),
(4, 1, 1, 0, 0, 950, 0, 0.00, 0.00, '2026-02-03 18:06:02', 'Enter Money Bill', 2, 'ME-1-000002', 1, '2026-02-03 15:06:02', '2026-02-03 15:06:02'),
(5, 1, 1, 0, 2600, 0, 0, 0.00, 0.00, '2026-02-03 20:03:57', 'Work Exit Bill', 3, 'SWSI-1-000003', 1, '2026-02-03 17:03:57', '2026-02-03 17:03:57'),
(6, 1, 1, 0, 0, 2600, 0, 0.00, 0.00, '2026-02-03 20:03:57', 'Enter Money Bill', 3, 'ME-1-000003', 1, '2026-02-03 17:03:57', '2026-02-03 17:03:57'),
(7, 1, 1, 0, 900, 0, 0, 0.00, 0.00, '2026-02-03 20:15:53', 'Work Exit Bill', 4, 'SWSI-1-000004', 1, '2026-02-03 17:15:53', '2026-02-03 17:15:53'),
(8, 1, 1, 0, 0, 900, 0, 0.00, 0.00, '2026-02-03 20:15:53', 'Enter Money Bill', 4, 'ME-1-000004', 1, '2026-02-03 17:15:53', '2026-02-03 17:15:53'),
(9, 1, 1, 0, 1000, 0, 0, 0.00, 0.00, '2026-02-03 20:17:48', 'Work Exit Bill', 5, 'SWSI-1-000005', 1, '2026-02-03 17:17:48', '2026-02-03 17:17:48'),
(10, 1, 1, 0, 0, 1000, 0, 0.00, 0.00, '2026-02-03 20:17:48', 'Enter Money Bill', 5, 'ME-1-000005', 1, '2026-02-03 17:17:48', '2026-02-03 17:17:48'),
(11, 1, 1, 0, 1380, 0, 0, 0.00, 0.00, '2026-02-04 14:26:21', 'Work Exit Bill', 6, 'SWSI-1-000006', 1, '2026-02-04 11:26:21', '2026-02-04 11:26:21'),
(12, 1, 1, 0, 0, 1380, 0, 0.00, 0.00, '2026-02-04 14:26:21', 'Enter Money Bill', 6, 'ME-1-000006', 1, '2026-02-04 11:26:21', '2026-02-04 11:26:21'),
(13, 1, 1, 0, 4100, 0, 0, 0.00, 0.00, '2026-02-04 14:27:28', 'Work Exit Bill', 7, 'SWSI-1-000007', 1, '2026-02-04 11:27:28', '2026-02-04 11:27:28'),
(14, 1, 1, 0, 0, 4100, 0, 0.00, 0.00, '2026-02-04 14:27:28', 'Enter Money Bill', 7, 'ME-1-000007', 1, '2026-02-04 11:27:28', '2026-02-04 11:27:28'),
(15, 1, 1, 0, 6300, 0, 0, 0.00, 0.00, '2026-02-04 17:33:13', 'Work Exit Bill', 8, 'SWSI-1-000008', 1, '2026-02-04 14:33:13', '2026-02-04 14:33:13'),
(16, 1, 1, 0, 0, 3000, 0, 0.00, 0.00, '2026-02-04 17:33:13', 'Enter Money Bill', 8, 'ME-1-000008', 1, '2026-02-04 14:33:13', '2026-02-04 14:33:13'),
(17, 1, 1, 0, 0, 3300, 0, 0.00, 0.00, '2026-02-04 17:33:13', 'Enter Money Bill', 9, 'ME-1-000009', 1, '2026-02-04 14:33:13', '2026-02-04 14:33:13'),
(18, 1, 1, 0, 1150, 0, 0, 0.00, 0.00, '2026-02-04 18:39:11', 'Work Exit Bill', 9, 'SWSI-1-000009', 1, '2026-02-04 15:39:11', '2026-02-04 15:39:11'),
(19, 1, 1, 0, 0, 1150, 0, 0.00, 0.00, '2026-02-04 18:39:11', 'Enter Money Bill', 10, 'ME-1-000010', 1, '2026-02-04 15:39:11', '2026-02-04 15:39:11'),
(20, 1, 1, 0, 3700, 0, 0, 0.00, 0.00, '2026-02-05 19:19:02', 'Work Exit Bill', 10, 'SWSI-1-000010', 1, '2026-02-05 16:19:02', '2026-02-05 16:19:02'),
(21, 1, 1, 0, 0, 3700, 0, 0.00, 0.00, '2026-02-05 19:19:02', 'Enter Money Bill', 11, 'ME-1-000011', 1, '2026-02-05 16:19:02', '2026-02-05 16:19:02'),
(22, 1, 1, 0, 2200, 0, 0, 0.00, 0.00, '2026-02-05 19:48:01', 'Work Exit Bill', 11, 'SWSI-1-000011', 1, '2026-02-05 16:48:01', '2026-02-05 16:48:01'),
(23, 1, 1, 0, 0, 2200, 0, 0.00, 0.00, '2026-02-05 19:48:01', 'Enter Money Bill', 12, 'ME-1-000012', 1, '2026-02-05 16:48:01', '2026-02-05 16:48:01'),
(24, 1, 1, 0, 5500, 0, 0, 0.00, 0.00, '2026-02-06 14:55:36', 'Work Exit Bill', 12, 'SWSI-1-000012', 1, '2026-02-06 11:55:36', '2026-02-06 11:55:36'),
(25, 1, 1, 0, 0, 2000, 0, 0.00, 0.00, '2026-02-06 14:55:36', 'Enter Money Bill', 13, 'ME-1-000013', 1, '2026-02-06 11:55:36', '2026-02-06 11:55:36'),
(26, 1, 1, 0, 0, 3500, 0, 0.00, 0.00, '2026-02-06 14:55:36', 'Enter Money Bill', 14, 'ME-1-000014', 1, '2026-02-06 11:55:36', '2026-02-06 11:55:36'),
(27, 1, 1, 0, 2200, 0, 0, 0.00, 0.00, '2026-02-06 18:43:11', 'Work Exit Bill', 13, 'SWSI-1-000013', 1, '2026-02-06 15:43:11', '2026-02-06 15:43:11'),
(28, 1, 1, 0, 0, 2200, 0, 0.00, 0.00, '2026-02-06 18:43:11', 'Enter Money Bill', 15, 'ME-1-000015', 1, '2026-02-06 15:43:11', '2026-02-06 15:43:11'),
(29, 1, 1, 0, 1800, 0, 0, 0.00, 0.00, '2026-02-06 19:19:35', 'Work Exit Bill', 14, 'SWSI-1-000014', 1, '2026-02-06 16:19:35', '2026-02-06 16:19:35'),
(30, 1, 1, 0, 0, 1800, 0, 0.00, 0.00, '2026-02-06 19:19:35', 'Enter Money Bill', 16, 'ME-1-000016', 1, '2026-02-06 16:19:35', '2026-02-06 16:19:35'),
(31, 1, 1, 0, 32500, 0, 0, 0.00, 0.00, '2026-02-07 18:22:15', 'Work Exit Bill', 15, 'SWSI-1-000015', 1, '2026-02-07 15:22:15', '2026-02-07 15:22:15'),
(32, 1, 1, 0, 0, 32500, 0, 0.00, 0.00, '2026-02-07 18:22:15', 'Enter Money Bill', 17, 'ME-1-000017', 1, '2026-02-07 15:22:15', '2026-02-07 15:22:15'),
(33, 1, 1, 0, 3450, 0, 0, 0.00, 0.00, '2026-02-08 14:57:28', 'Work Exit Bill', 16, 'SWSI-1-000016', 1, '2026-02-08 11:57:28', '2026-02-08 11:57:28'),
(34, 1, 1, 0, 0, 3450, 0, 0.00, 0.00, '2026-02-08 14:57:28', 'Enter Money Bill', 18, 'ME-1-000018', 1, '2026-02-08 11:57:28', '2026-02-08 11:57:28'),
(35, 1, 1, 0, 3030, 0, 0, 0.00, 0.00, '2026-02-08 16:50:10', 'Work Exit Bill', 17, 'SWSI-1-000017', 1, '2026-02-08 13:50:10', '2026-02-08 13:50:10'),
(36, 1, 1, 0, 0, 3030, 0, 0.00, 0.00, '2026-02-08 16:50:11', 'Enter Money Bill', 19, 'ME-1-000019', 1, '2026-02-08 13:50:11', '2026-02-08 13:50:11'),
(37, 1, 1, 0, 2900, 0, 0, 0.00, 0.00, '2026-02-09 16:10:57', 'Work Exit Bill', 18, 'SWSI-1-000018', 1, '2026-02-09 13:10:57', '2026-02-09 13:10:57'),
(38, 1, 1, 0, 0, 2900, 0, 0.00, 0.00, '2026-02-09 16:10:57', 'Enter Money Bill', 20, 'ME-1-000020', 1, '2026-02-09 13:10:57', '2026-02-09 13:10:57'),
(39, 1, 1, 0, 1500, 0, 0, 0.00, 0.00, '2026-02-09 16:22:03', 'Work Exit Bill', 19, 'SWSI-1-000019', 1, '2026-02-09 13:22:03', '2026-02-09 13:22:03'),
(40, 1, 1, 0, 0, 1500, 0, 0.00, 0.00, '2026-02-09 16:22:03', 'Enter Money Bill', 21, 'ME-1-000021', 1, '2026-02-09 13:22:03', '2026-02-09 13:22:03'),
(41, 1, 1, 0, 2390, 0, 0, 0.00, 0.00, '2026-02-09 16:26:32', 'Work Exit Bill', 20, 'SWSI-1-000020', 1, '2026-02-09 13:26:32', '2026-02-09 13:26:32'),
(42, 1, 1, 0, 0, 2390, 0, 0.00, 0.00, '2026-02-09 16:26:32', 'Enter Money Bill', 22, 'ME-1-000022', 1, '2026-02-09 13:26:32', '2026-02-09 13:26:32'),
(43, 1, 1, 0, 9200, 0, 0, 0.00, 0.00, '2026-02-10 15:15:26', 'Work Exit Bill', 21, 'SWSI-1-000021', 1, '2026-02-10 12:15:26', '2026-02-10 12:15:26'),
(44, 1, 1, 0, 0, 9200, 0, 0.00, 0.00, '2026-02-10 15:15:26', 'Enter Money Bill', 23, 'ME-1-000023', 1, '2026-02-10 12:15:26', '2026-02-10 12:15:26'),
(45, 1, 1, 0, 850, 0, 0, 0.00, 0.00, '2026-02-11 16:21:13', 'Work Exit Bill', 22, 'SWSI-1-000022', 1, '2026-02-11 13:21:13', '2026-02-11 13:21:13'),
(46, 1, 1, 0, 0, 850, 0, 0.00, 0.00, '2026-02-11 16:21:13', 'Enter Money Bill', 24, 'ME-1-000024', 1, '2026-02-11 13:21:13', '2026-02-11 13:21:13'),
(47, 1, 1, 0, 850, 0, 0, 0.00, 0.00, '2026-02-11 16:23:42', 'Work Exit Bill', 23, 'SWSI-1-000023', 1, '2026-02-11 13:23:42', '2026-02-11 13:23:42'),
(48, 1, 1, 0, 0, 850, 0, 0.00, 0.00, '2026-02-11 16:23:42', 'Enter Money Bill', 25, 'ME-1-000025', 1, '2026-02-11 13:23:42', '2026-02-11 13:23:42'),
(49, 1, 1, 0, 3800, 0, 0, 0.00, 0.00, '2026-02-11 18:26:05', 'Work Exit Bill', 24, 'SWSI-1-000024', 1, '2026-02-11 15:26:05', '2026-02-11 15:26:05'),
(50, 1, 1, 0, 0, 3800, 0, 0.00, 0.00, '2026-02-11 18:26:05', 'Enter Money Bill', 26, 'ME-1-000026', 1, '2026-02-11 15:26:05', '2026-02-11 15:26:05'),
(51, 1, 1, 0, 3800, 0, 0, 0.00, 0.00, '2026-02-11 18:28:05', 'Work Exit Bill', 25, 'SWSI-1-000025', 1, '2026-02-11 15:28:05', '2026-02-11 15:28:05'),
(52, 1, 1, 0, 0, 3800, 0, 0.00, 0.00, '2026-02-11 18:28:05', 'Enter Money Bill', 27, 'ME-1-000027', 1, '2026-02-11 15:28:05', '2026-02-11 15:28:05'),
(53, 1, 1, 0, 2795, 0, 0, 0.00, 0.00, '2026-02-11 18:30:40', 'Work Exit Bill', 26, 'SWSI-1-000026', 1, '2026-02-11 15:30:40', '2026-02-11 15:30:40'),
(54, 1, 1, 0, 0, 2795, 0, 0.00, 0.00, '2026-02-11 18:30:40', 'Enter Money Bill', 28, 'ME-1-000028', 1, '2026-02-11 15:30:40', '2026-02-11 15:30:40'),
(55, 1, 1, 0, 1400, 0, 0, 0.00, 0.00, '2026-02-11 19:25:57', 'Work Exit Bill', 27, 'SWSI-1-000027', 1, '2026-02-11 16:25:57', '2026-02-11 16:25:57'),
(56, 1, 1, 0, 0, 1400, 0, 0.00, 0.00, '2026-02-11 19:25:57', 'Enter Money Bill', 29, 'ME-1-000029', 1, '2026-02-11 16:25:57', '2026-02-11 16:25:57'),
(57, 1, 1, 0, 750, 0, 0, 0.00, 0.00, '2026-02-11 19:47:31', 'Work Exit Bill', 28, 'SWSI-1-000028', 1, '2026-02-11 16:47:31', '2026-02-11 16:47:31'),
(58, 1, 1, 0, 0, 750, 0, 0.00, 0.00, '2026-02-11 19:47:31', 'Enter Money Bill', 30, 'ME-1-000030', 1, '2026-02-11 16:47:31', '2026-02-11 16:47:31'),
(59, 1, 1, 0, 750, 0, 0, 0.00, 0.00, '2026-02-11 19:49:10', 'Work Exit Bill', 29, 'SWSI-1-000029', 1, '2026-02-11 16:49:10', '2026-02-11 16:49:10'),
(60, 1, 1, 0, 0, 750, 0, 0.00, 0.00, '2026-02-11 19:49:10', 'Enter Money Bill', 31, 'ME-1-000031', 1, '2026-02-11 16:49:10', '2026-02-11 16:49:10'),
(61, 1, 1, 0, 1730, 0, 0, 0.00, 0.00, '2026-02-11 19:53:50', 'Work Exit Bill', 30, 'SWSI-1-000030', 1, '2026-02-11 16:53:50', '2026-02-11 16:53:50'),
(62, 1, 1, 0, 0, 1730, 0, 0.00, 0.00, '2026-02-11 19:53:50', 'Enter Money Bill', 32, 'ME-1-000032', 1, '2026-02-11 16:53:50', '2026-02-11 16:53:50'),
(63, 1, 1, 0, 11425, 0, 0, 0.00, 0.00, '2026-02-11 20:23:11', 'Work Exit Bill', 31, 'SWSI-1-000031', 1, '2026-02-11 17:23:11', '2026-02-11 17:23:11'),
(64, 1, 1, 0, 0, 11425, 0, 0.00, 0.00, '2026-02-11 20:23:11', 'Enter Money Bill', 33, 'ME-1-000033', 1, '2026-02-11 17:23:11', '2026-02-11 17:23:11'),
(65, 1, 1, 0, 1900, 0, 0, 0.00, 0.00, '2026-02-11 20:25:04', 'Work Exit Bill', 32, 'SWSI-1-000032', 1, '2026-02-11 17:25:04', '2026-02-11 17:25:04'),
(66, 1, 1, 0, 0, 1900, 0, 0.00, 0.00, '2026-02-11 20:25:04', 'Enter Money Bill', 34, 'ME-1-000034', 1, '2026-02-11 17:25:04', '2026-02-11 17:25:04'),
(67, 1, 1, 0, 2330, 0, 0, 0.00, 0.00, '2026-02-12 16:20:19', 'Work Exit Bill', 33, 'SWSI-1-000033', 1, '2026-02-12 13:20:19', '2026-02-12 13:20:19'),
(68, 1, 1, 0, 0, 2330, 0, 0.00, 0.00, '2026-02-12 16:20:19', 'Enter Money Bill', 35, 'ME-1-000035', 1, '2026-02-12 13:20:19', '2026-02-12 13:20:19'),
(69, 1, 1, 0, 650, 0, 0, 0.00, 0.00, '2026-02-12 18:02:44', 'Work Exit Bill', 34, 'SWSI-1-000034', 1, '2026-02-12 15:02:44', '2026-02-12 15:02:44'),
(70, 1, 1, 0, 0, 650, 0, 0.00, 0.00, '2026-02-12 18:02:44', 'Enter Money Bill', 36, 'ME-1-000036', 1, '2026-02-12 15:02:44', '2026-02-12 15:02:44'),
(71, 1, 1, 0, 3975, 0, 0, 0.00, 0.00, '2026-02-13 15:48:52', 'Work Exit Bill', 35, 'SWSI-1-000035', 1, '2026-02-13 12:48:52', '2026-02-13 12:48:52'),
(72, 1, 1, 0, 0, 3975, 0, 0.00, 0.00, '2026-02-13 15:48:52', 'Enter Money Bill', 37, 'ME-1-000037', 1, '2026-02-13 12:48:52', '2026-02-13 12:48:52'),
(73, 1, 1, 0, 2775, 0, 0, 0.00, 0.00, '2026-02-13 15:50:38', 'Work Exit Bill', 36, 'SWSI-1-000036', 1, '2026-02-13 12:50:38', '2026-02-13 12:50:38'),
(74, 1, 1, 0, 0, 2775, 0, 0.00, 0.00, '2026-02-13 15:50:38', 'Enter Money Bill', 38, 'ME-1-000038', 1, '2026-02-13 12:50:38', '2026-02-13 12:50:38'),
(75, 1, 1, 0, 2800, 0, 0, 0.00, 0.00, '2026-02-13 16:35:14', 'Work Exit Bill', 37, 'SWSI-1-000037', 1, '2026-02-13 13:35:14', '2026-02-13 13:35:14'),
(76, 1, 1, 0, 0, 2800, 0, 0.00, 0.00, '2026-02-13 16:35:14', 'Enter Money Bill', 39, 'ME-1-000039', 1, '2026-02-13 13:35:14', '2026-02-13 13:35:14'),
(77, 1, 1, 0, 1350, 0, 0, 0.00, 0.00, '2026-02-13 19:36:05', 'Work Exit Bill', 38, 'SWSI-1-000038', 1, '2026-02-13 16:36:05', '2026-02-13 16:36:05'),
(78, 1, 1, 0, 0, 1200, 0, 0.00, 0.00, '2026-02-13 19:36:05', 'Enter Money Bill', 40, 'ME-1-000040', 1, '2026-02-13 16:36:05', '2026-02-13 16:36:05'),
(79, 1, 1, 0, 0, 150, 0, 0.00, 0.00, '2026-02-13 19:36:05', 'Enter Money Bill', 41, 'ME-1-000041', 1, '2026-02-13 16:36:05', '2026-02-13 16:36:05'),
(80, 1, 1, 0, 3000, 0, 0, 0.00, 0.00, '2026-02-14 14:30:05', 'Work Exit Bill', 39, 'SWSI-1-000039', 1, '2026-02-14 11:30:05', '2026-02-14 11:30:05'),
(81, 1, 1, 0, 0, 3000, 0, 0.00, 0.00, '2026-02-14 14:30:05', 'Enter Money Bill', 42, 'ME-1-000042', 1, '2026-02-14 11:30:05', '2026-02-14 11:30:05'),
(82, 1, 1, 0, 580, 0, 0, 0.00, 0.00, '2026-02-14 17:25:19', 'Work Exit Bill', 40, 'SWSI-1-000040', 1, '2026-02-14 14:25:19', '2026-02-14 14:25:19'),
(83, 1, 1, 0, 0, 580, 0, 0.00, 0.00, '2026-02-14 17:25:20', 'Enter Money Bill', 43, 'ME-1-000043', 1, '2026-02-14 14:25:20', '2026-02-14 14:25:20'),
(84, 1, 1, 0, 1250, 0, 0, 0.00, 0.00, '2026-02-14 17:47:57', 'Work Exit Bill', 41, 'SWSI-1-000041', 1, '2026-02-14 14:47:57', '2026-02-14 14:47:57'),
(85, 1, 1, 0, 0, 1250, 0, 0.00, 0.00, '2026-02-14 17:47:57', 'Enter Money Bill', 44, 'ME-1-000044', 1, '2026-02-14 14:47:57', '2026-02-14 14:47:57'),
(86, 1, 1, 0, 3150, 0, 0, 0.00, 0.00, '2026-02-15 14:03:30', 'Work Exit Bill', 42, 'SWSI-1-000042', 1, '2026-02-15 11:03:30', '2026-02-15 11:03:30'),
(87, 1, 1, 0, 0, 3150, 0, 0.00, 0.00, '2026-02-15 14:03:30', 'Enter Money Bill', 45, 'ME-1-000045', 1, '2026-02-15 11:03:30', '2026-02-15 11:03:30'),
(88, 1, 1, 0, 1650, 0, 0, 0.00, 0.00, '2026-02-15 14:46:23', 'Work Exit Bill', 43, 'SWSI-1-000043', 1, '2026-02-15 11:46:23', '2026-02-15 11:46:23'),
(89, 1, 1, 0, 0, 1600, 0, 0.00, 0.00, '2026-02-15 14:46:23', 'Enter Money Bill', 46, 'ME-1-000046', 1, '2026-02-15 11:46:23', '2026-02-15 11:46:23'),
(90, 1, 1, 0, 0, 50, 0, 0.00, 0.00, '2026-02-15 14:46:23', 'Enter Money Bill', 47, 'ME-1-000047', 1, '2026-02-15 11:46:23', '2026-02-15 11:46:23'),
(91, 1, 1, 0, 2580, 0, 0, 0.00, 0.00, '2026-02-15 18:58:17', 'Work Exit Bill', 44, 'SWSI-1-000044', 1, '2026-02-15 15:58:17', '2026-02-15 15:58:17'),
(92, 1, 1, 0, 0, 2580, 0, 0.00, 0.00, '2026-02-15 18:58:17', 'Enter Money Bill', 48, 'ME-1-000048', 1, '2026-02-15 15:58:17', '2026-02-15 15:58:17'),
(93, 1, 1, 0, 1000, 0, 0, 0.00, 0.00, '2026-02-15 19:48:50', 'Work Exit Bill', 45, 'SWSI-1-000045', 1, '2026-02-15 16:48:50', '2026-02-15 16:48:50'),
(94, 1, 1, 0, 0, 1000, 0, 0.00, 0.00, '2026-02-15 19:48:50', 'Enter Money Bill', 49, 'ME-1-000049', 1, '2026-02-15 16:48:50', '2026-02-15 16:48:50'),
(95, 1, 1, 0, 25700, 0, 0, 0.00, 0.00, '2026-02-16 14:42:35', 'Work Exit Bill', 46, 'SWSI-1-000046', 1, '2026-02-16 11:42:35', '2026-02-16 11:42:35'),
(96, 1, 1, 0, 0, 25700, 0, 0.00, 0.00, '2026-02-16 14:42:35', 'Enter Money Bill', 50, 'ME-1-000050', 1, '2026-02-16 11:42:35', '2026-02-16 11:42:35'),
(97, 1, 1, 0, 3100, 0, 0, 0.00, 0.00, '2026-02-17 15:18:40', 'Work Exit Bill', 47, 'SWSI-1-000047', 1, '2026-02-17 12:18:40', '2026-02-17 12:18:40'),
(98, 1, 1, 0, 0, 3100, 0, 0.00, 0.00, '2026-02-17 15:18:40', 'Enter Money Bill', 51, 'ME-1-000051', 1, '2026-02-17 12:18:40', '2026-02-17 12:18:40'),
(99, 1, 1, 0, 1350, 0, 0, 0.00, 0.00, '2026-02-17 16:26:03', 'Work Exit Bill', 48, 'SWSI-1-000048', 1, '2026-02-17 13:26:03', '2026-02-17 13:26:03'),
(100, 1, 1, 0, 0, 1350, 0, 0.00, 0.00, '2026-02-17 16:26:03', 'Enter Money Bill', 52, 'ME-1-000052', 1, '2026-02-17 13:26:03', '2026-02-17 13:26:03'),
(101, 1, 1, 0, 1230, 0, 0, 0.00, 0.00, '2026-02-18 20:32:29', 'Work Exit Bill', 49, 'SWSI-1-000049', 1, '2026-02-18 17:32:29', '2026-02-18 17:32:29'),
(102, 1, 1, 0, 0, 600, 0, 0.00, 0.00, '2026-02-18 20:32:29', 'Enter Money Bill', 53, 'ME-1-000053', 1, '2026-02-18 17:32:29', '2026-02-18 17:32:29'),
(103, 1, 1, 0, 0, 630, 0, 0.00, 0.00, '2026-02-18 20:32:29', 'Enter Money Bill', 54, 'ME-1-000054', 1, '2026-02-18 17:32:29', '2026-02-18 17:32:29'),
(104, 1, 1, 0, 4700, 0, 0, 0.00, 0.00, '2026-02-19 22:09:15', 'Work Exit Bill', 50, 'SWSI-1-000050', 1, '2026-02-19 19:09:15', '2026-02-19 19:09:15'),
(105, 1, 1, 0, 0, 4700, 0, 0.00, 0.00, '2026-02-19 22:09:15', 'Enter Money Bill', 55, 'ME-1-000055', 1, '2026-02-19 19:09:15', '2026-02-19 19:09:15'),
(106, 1, 1, 0, 7280, 0, 0, 0.00, 0.00, '2026-02-20 20:35:14', 'Work Exit Bill', 51, 'SWSI-1-000051', 1, '2026-02-20 17:35:14', '2026-02-20 17:35:14'),
(107, 1, 1, 0, 0, 7130, 0, 0.00, 0.00, '2026-02-20 20:35:14', 'Enter Money Bill', 56, 'ME-1-000056', 1, '2026-02-20 17:35:14', '2026-02-20 17:35:14'),
(108, 1, 1, 0, 0, 150, 0, 0.00, 0.00, '2026-02-20 20:35:14', 'Enter Money Bill', 57, 'ME-1-000057', 1, '2026-02-20 17:35:14', '2026-02-20 17:35:14'),
(109, 1, 1, 0, 965, 0, 0, 0.00, 0.00, '2026-02-21 18:13:42', 'Work Exit Bill', 52, 'SWSI-1-000052', 1, '2026-02-21 15:13:42', '2026-02-21 15:13:42'),
(110, 1, 1, 0, 0, 965, 0, 0.00, 0.00, '2026-02-21 18:13:42', 'Enter Money Bill', 58, 'ME-1-000058', 1, '2026-02-21 15:13:42', '2026-02-21 15:13:42'),
(111, 1, 1, 0, 1620, 0, 0, 0.00, 0.00, '2026-02-21 18:41:20', 'Work Exit Bill', 53, 'SWSI-1-000053', 1, '2026-02-21 15:41:20', '2026-02-21 15:41:20'),
(112, 1, 1, 0, 0, 1620, 0, 0.00, 0.00, '2026-02-21 18:41:20', 'Enter Money Bill', 59, 'ME-1-000059', 1, '2026-02-21 15:41:20', '2026-02-21 15:41:20'),
(113, 1, 1, 0, 1350, 0, 0, 0.00, 0.00, '2026-02-22 18:41:17', 'Work Exit Bill', 54, 'SWSI-1-000054', 1, '2026-02-22 15:41:17', '2026-02-22 15:41:17'),
(114, 1, 1, 0, 0, 1350, 0, 0.00, 0.00, '2026-02-22 18:41:17', 'Enter Money Bill', 60, 'ME-1-000060', 1, '2026-02-22 15:41:17', '2026-02-22 15:41:17'),
(115, 1, 1, 0, 650, 0, 0, 0.00, 0.00, '2026-02-22 21:49:51', 'Work Exit Bill', 55, 'SWSI-1-000055', 1, '2026-02-22 18:49:51', '2026-02-22 18:49:51'),
(116, 1, 1, 0, 0, 650, 0, 0.00, 0.00, '2026-02-22 21:49:51', 'Enter Money Bill', 61, 'ME-1-000061', 1, '2026-02-22 18:49:51', '2026-02-22 18:49:51'),
(117, 1, 1, 0, 1870, 0, 0, 0.00, 0.00, '2026-02-22 22:24:54', 'Work Exit Bill', 56, 'SWSI-1-000056', 1, '2026-02-22 19:24:54', '2026-02-22 19:24:54'),
(118, 1, 1, 0, 0, 1720, 0, 0.00, 0.00, '2026-02-22 22:24:54', 'Enter Money Bill', 62, 'ME-1-000062', 1, '2026-02-22 19:24:54', '2026-02-22 19:24:54'),
(119, 1, 1, 0, 0, 150, 0, 0.00, 0.00, '2026-02-22 22:24:54', 'Enter Money Bill', 63, 'ME-1-000063', 1, '2026-02-22 19:24:54', '2026-02-22 19:24:54'),
(120, 1, 1, 0, 1850, 0, 0, 0.00, 0.00, '2026-02-23 14:22:54', 'Work Exit Bill', 57, 'SWSI-1-000057', 1, '2026-02-23 11:22:54', '2026-02-23 11:22:54'),
(121, 1, 1, 0, 0, 1850, 0, 0.00, 0.00, '2026-02-23 14:22:54', 'Enter Money Bill', 64, 'ME-1-000064', 1, '2026-02-23 11:22:54', '2026-02-23 11:22:54'),
(122, 1, 1, 0, 2020, 0, 0, 0.00, 0.00, '2026-02-23 21:24:18', 'Work Exit Bill', 58, 'SWSI-1-000058', 1, '2026-02-23 18:24:18', '2026-02-23 18:24:18'),
(123, 1, 1, 0, 0, 2020, 0, 0.00, 0.00, '2026-02-23 21:24:18', 'Enter Money Bill', 65, 'ME-1-000065', 1, '2026-02-23 18:24:18', '2026-02-23 18:24:18'),
(124, 1, 1, 0, 14440, 0, 0, 0.00, 0.00, '2026-02-23 22:47:15', 'Work Exit Bill', 59, 'SWSI-1-000059', 1, '2026-02-23 19:47:15', '2026-02-23 19:47:15'),
(125, 1, 1, 0, 0, 12040, 0, 0.00, 0.00, '2026-02-23 22:47:15', 'Enter Money Bill', 66, 'ME-1-000066', 1, '2026-02-23 19:47:15', '2026-02-23 19:47:15'),
(126, 1, 1, 0, 0, 2400, 0, 0.00, 0.00, '2026-02-23 22:47:15', 'Enter Money Bill', 67, 'ME-1-000067', 1, '2026-02-23 19:47:15', '2026-02-23 19:47:15'),
(127, 1, 1, 0, 2300, 0, 0, 0.00, 0.00, '2026-02-24 19:17:33', 'Work Exit Bill', 60, 'SWSI-1-000060', 1, '2026-02-24 16:17:33', '2026-02-24 16:17:33'),
(128, 1, 1, 0, 0, 2300, 0, 0.00, 0.00, '2026-02-24 19:17:33', 'Enter Money Bill', 68, 'ME-1-000068', 1, '2026-02-24 16:17:33', '2026-02-24 16:17:33'),
(129, 1, 1, 0, 870, 0, 0, 0.00, 0.00, '2026-02-24 20:44:58', 'Work Exit Bill', 61, 'SWSI-1-000061', 1, '2026-02-24 17:44:58', '2026-02-24 17:44:58'),
(130, 1, 1, 0, 0, 870, 0, 0.00, 0.00, '2026-02-24 20:44:58', 'Enter Money Bill', 69, 'ME-1-000069', 1, '2026-02-24 17:44:58', '2026-02-24 17:44:58'),
(131, 1, 1, 0, 1100, 0, 0, 0.00, 0.00, '2026-02-25 18:24:14', 'Work Exit Bill', 62, 'SWSI-1-000062', 1, '2026-02-25 15:24:14', '2026-02-25 15:24:14'),
(132, 1, 1, 0, 0, 1100, 0, 0.00, 0.00, '2026-02-25 18:24:14', 'Enter Money Bill', 70, 'ME-1-000070', 1, '2026-02-25 15:24:14', '2026-02-25 15:24:14'),
(133, 1, 1, 0, 2200, 0, 0, 0.00, 0.00, '2026-02-25 19:53:52', 'Work Exit Bill', 63, 'SWSI-1-000063', 1, '2026-02-25 16:53:52', '2026-02-25 16:53:52'),
(134, 1, 1, 0, 0, 2200, 0, 0.00, 0.00, '2026-02-25 19:53:52', 'Enter Money Bill', 71, 'ME-1-000071', 1, '2026-02-25 16:53:52', '2026-02-25 16:53:52'),
(135, 1, 1, 0, 800, 0, 0, 0.00, 0.00, '2026-02-25 20:01:55', 'Work Exit Bill', 64, 'SWSI-1-000064', 1, '2026-02-25 17:01:55', '2026-02-25 17:01:55'),
(136, 1, 1, 0, 0, 800, 0, 0.00, 0.00, '2026-02-25 20:01:55', 'Enter Money Bill', 72, 'ME-1-000072', 1, '2026-02-25 17:01:55', '2026-02-25 17:01:55'),
(137, 1, 1, 0, 3100, 0, 0, 0.00, 0.00, '2026-02-26 20:22:10', 'Work Exit Bill', 65, 'SWSI-1-000065', 1, '2026-02-26 17:22:10', '2026-02-26 17:22:10'),
(138, 1, 1, 0, 0, 100, 0, 0.00, 0.00, '2026-02-26 20:22:10', 'Enter Money Bill', 73, 'ME-1-000073', 1, '2026-02-26 17:22:10', '2026-02-26 17:22:10'),
(139, 1, 1, 0, 0, 3000, 0, 0.00, 0.00, '2026-02-26 20:22:10', 'Enter Money Bill', 74, 'ME-1-000074', 1, '2026-02-26 17:22:10', '2026-02-26 17:22:10'),
(140, 1, 1, 0, 630, 0, 0, 0.00, 0.00, '2026-02-26 20:32:45', 'Work Exit Bill', 66, 'SWSI-1-000066', 1, '2026-02-26 17:32:45', '2026-02-26 17:32:45'),
(141, 1, 1, 0, 0, 630, 0, 0.00, 0.00, '2026-02-26 20:32:45', 'Enter Money Bill', 75, 'ME-1-000075', 1, '2026-02-26 17:32:45', '2026-02-26 17:32:45'),
(142, 1, 1, 0, 920, 0, 0, 0.00, 0.00, '2026-02-27 18:18:07', 'Work Exit Bill', 67, 'SWSI-1-000067', 1, '2026-02-27 15:18:07', '2026-02-27 15:18:07'),
(143, 1, 1, 0, 0, 920, 0, 0.00, 0.00, '2026-02-27 18:18:07', 'Enter Money Bill', 76, 'ME-1-000076', 1, '2026-02-27 15:18:07', '2026-02-27 15:18:07'),
(144, 1, 1, 0, 1540, 0, 0, 0.00, 0.00, '2026-02-27 18:34:36', 'Work Exit Bill', 68, 'SWSI-1-000068', 1, '2026-02-27 15:34:36', '2026-02-27 15:34:36'),
(145, 1, 1, 0, 0, 1540, 0, 0.00, 0.00, '2026-02-27 18:34:36', 'Enter Money Bill', 77, 'ME-1-000077', 1, '2026-02-27 15:34:36', '2026-02-27 15:34:36'),
(146, 1, 1, 0, 13770, 0, 0, 0.00, 0.00, '2026-02-27 19:24:18', 'Work Exit Bill', 69, 'SWSI-1-000069', 1, '2026-02-27 16:24:18', '2026-02-27 16:24:18'),
(147, 1, 1, 0, 0, 11770, 0, 0.00, 0.00, '2026-02-27 19:24:18', 'Enter Money Bill', 78, 'ME-1-000078', 1, '2026-02-27 16:24:18', '2026-02-27 16:24:18'),
(148, 1, 1, 0, 0, 2000, 0, 0.00, 0.00, '2026-02-27 19:24:18', 'Enter Money Bill', 79, 'ME-1-000079', 1, '2026-02-27 16:24:18', '2026-02-27 16:24:18'),
(149, 1, 1, 0, 750, 0, 0, 0.00, 0.00, '2026-02-27 21:27:32', 'Work Exit Bill', 70, 'SWSI-1-000070', 1, '2026-02-27 18:27:32', '2026-02-27 18:27:32'),
(150, 1, 1, 0, 0, 750, 0, 0.00, 0.00, '2026-02-27 21:27:33', 'Enter Money Bill', 80, 'ME-1-000080', 1, '2026-02-27 18:27:33', '2026-02-27 18:27:33'),
(151, 1, 1, 0, 1400, 0, 0, 0.00, 0.00, '2026-02-27 21:37:28', 'Work Exit Bill', 71, 'SWSI-1-000071', 1, '2026-02-27 18:37:28', '2026-02-27 18:37:28'),
(152, 1, 1, 0, 0, 1400, 0, 0.00, 0.00, '2026-02-27 21:37:28', 'Enter Money Bill', 81, 'ME-1-000081', 1, '2026-02-27 18:37:28', '2026-02-27 18:37:28'),
(153, 1, 1, 0, 3600, 0, 0, 0.00, 0.00, '2026-02-27 21:53:55', 'Work Exit Bill', 72, 'SWSI-1-000072', 1, '2026-02-27 18:53:55', '2026-02-27 18:53:55'),
(154, 1, 1, 0, 0, 600, 0, 0.00, 0.00, '2026-02-27 21:53:55', 'Enter Money Bill', 82, 'ME-1-000082', 1, '2026-02-27 18:53:55', '2026-02-27 18:53:55'),
(155, 1, 1, 0, 0, 3000, 0, 0.00, 0.00, '2026-02-27 21:53:55', 'Enter Money Bill', 83, 'ME-1-000083', 1, '2026-02-27 18:53:55', '2026-02-27 18:53:55'),
(156, 1, 1, 0, 550, 0, 0, 0.00, 0.00, '2026-02-28 19:01:00', 'Work Exit Bill', 73, 'SWSI-1-000073', 1, '2026-02-28 16:01:00', '2026-02-28 16:01:00'),
(157, 1, 1, 0, 0, 550, 0, 0.00, 0.00, '2026-02-28 19:01:00', 'Enter Money Bill', 84, 'ME-1-000084', 1, '2026-02-28 16:01:00', '2026-02-28 16:01:00'),
(158, 1, 1, 0, 3450, 0, 0, 0.00, 0.00, '2026-02-28 20:17:15', 'Work Exit Bill', 74, 'SWSI-1-000074', 1, '2026-02-28 17:17:15', '2026-02-28 17:17:15'),
(159, 1, 1, 0, 0, 3450, 0, 0.00, 0.00, '2026-02-28 20:17:15', 'Enter Money Bill', 85, 'ME-1-000085', 1, '2026-02-28 17:17:15', '2026-02-28 17:17:15'),
(160, 1, 1, 0, 14650, 0, 0, 0.00, 0.00, '2026-03-01 18:21:31', 'Work Exit Bill', 75, 'SWSI-1-000075', 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(161, 1, 1, 0, 0, 14000, 0, 0.00, 0.00, '2026-03-01 18:21:31', 'Enter Money Bill', 86, 'ME-1-000086', 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(162, 1, 1, 0, 0, 650, 0, 0.00, 0.00, '2026-03-01 18:21:31', 'Enter Money Bill', 87, 'ME-1-000087', 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(163, 1, 1, 0, 1420, 0, 0, 0.00, 0.00, '2026-03-01 19:38:14', 'Work Exit Bill', 76, 'SWSI-1-000076', 1, '2026-03-01 16:38:14', '2026-03-01 16:38:14'),
(164, 1, 1, 0, 0, 1420, 0, 0.00, 0.00, '2026-03-01 19:38:14', 'Enter Money Bill', 88, 'ME-1-000088', 1, '2026-03-01 16:38:14', '2026-03-01 16:38:14'),
(165, 1, 1, 0, 1600, 0, 0, 0.00, 0.00, '2026-03-01 20:13:38', 'Work Exit Bill', 77, 'SWSI-1-000077', 1, '2026-03-01 17:13:38', '2026-03-01 17:13:38'),
(166, 1, 1, 0, 0, 1600, 0, 0.00, 0.00, '2026-03-01 20:13:38', 'Enter Money Bill', 89, 'ME-1-000089', 1, '2026-03-01 17:13:38', '2026-03-01 17:13:38'),
(167, 1, 1, 0, 3930, 0, 0, 0.00, 0.00, '2026-03-01 20:39:09', 'Work Exit Bill', 78, 'SWSI-1-000078', 1, '2026-03-01 17:39:09', '2026-03-01 17:39:09'),
(168, 1, 1, 0, 0, 3930, 0, 0.00, 0.00, '2026-03-01 20:39:09', 'Enter Money Bill', 90, 'ME-1-000090', 1, '2026-03-01 17:39:09', '2026-03-01 17:39:09'),
(169, 1, 1, 0, 950, 0, 0, 0.00, 0.00, '2026-03-01 21:59:59', 'Work Exit Bill', 79, 'SWSI-1-000079', 1, '2026-03-01 18:59:59', '2026-03-01 18:59:59'),
(170, 1, 1, 0, 0, 950, 0, 0.00, 0.00, '2026-03-01 21:59:59', 'Enter Money Bill', 91, 'ME-1-000091', 1, '2026-03-01 18:59:59', '2026-03-01 18:59:59'),
(171, 1, 1, 0, 980, 0, 0, 0.00, 0.00, '2026-03-01 22:10:20', 'Work Exit Bill', 80, 'SWSI-1-000080', 1, '2026-03-01 19:10:20', '2026-03-01 19:10:20'),
(172, 1, 1, 0, 0, 980, 0, 0.00, 0.00, '2026-03-01 22:10:20', 'Enter Money Bill', 92, 'ME-1-000092', 1, '2026-03-01 19:10:20', '2026-03-01 19:10:20'),
(173, 1, 1, 0, 1300, 0, 0, 0.00, 0.00, '2026-03-01 22:12:50', 'Work Exit Bill', 81, 'SWSI-1-000081', 1, '2026-03-01 19:12:50', '2026-03-01 19:12:50'),
(174, 1, 1, 0, 0, 1300, 0, 0.00, 0.00, '2026-03-01 22:12:50', 'Enter Money Bill', 93, 'ME-1-000093', 1, '2026-03-01 19:12:50', '2026-03-01 19:12:50'),
(175, 1, 1, 0, 4535, 0, 0, 0.00, 0.00, '2026-03-01 22:19:38', 'Work Exit Bill', 82, 'SWSI-1-000082', 1, '2026-03-01 19:19:38', '2026-03-01 19:19:38'),
(176, 1, 1, 0, 0, 4535, 0, 0.00, 0.00, '2026-03-01 22:19:38', 'Enter Money Bill', 94, 'ME-1-000094', 1, '2026-03-01 19:19:38', '2026-03-01 19:19:38'),
(177, 1, 1, 0, 1100, 0, 0, 0.00, 0.00, '2026-03-01 22:40:12', 'Work Exit Bill', 83, 'SWSI-1-000083', 1, '2026-03-01 19:40:12', '2026-03-01 19:40:12'),
(178, 1, 1, 0, 0, 1100, 0, 0.00, 0.00, '2026-03-01 22:40:12', 'Enter Money Bill', 95, 'ME-1-000095', 1, '2026-03-01 19:40:12', '2026-03-01 19:40:12'),
(179, 1, 1, 0, 830, 0, 0, 0.00, 0.00, '2026-03-02 21:13:48', 'Work Exit Bill', 84, 'SWSI-1-000084', 1, '2026-03-02 18:13:48', '2026-03-02 18:13:48'),
(180, 1, 1, 0, 0, 830, 0, 0.00, 0.00, '2026-03-02 21:13:48', 'Enter Money Bill', 96, 'ME-1-000096', 1, '2026-03-02 18:13:48', '2026-03-02 18:13:48'),
(181, 1, 1, 0, 8600, 0, 0, 0.00, 0.00, '2026-03-02 21:17:13', 'Work Exit Bill', 85, 'SWSI-1-000085', 1, '2026-03-02 18:17:13', '2026-03-02 18:17:13'),
(182, 1, 1, 0, 0, 8600, 0, 0.00, 0.00, '2026-03-02 21:17:13', 'Enter Money Bill', 97, 'ME-1-000097', 1, '2026-03-02 18:17:13', '2026-03-02 18:17:13'),
(183, 1, 1, 0, 2800, 0, 0, 0.00, 0.00, '2026-03-03 13:55:57', 'Work Exit Bill', 86, 'SWSI-1-000086', 1, '2026-03-03 10:55:57', '2026-03-03 10:55:57'),
(184, 1, 1, 0, 0, 2800, 0, 0.00, 0.00, '2026-03-03 13:55:57', 'Enter Money Bill', 98, 'ME-1-000098', 1, '2026-03-03 10:55:57', '2026-03-03 10:55:57'),
(185, 1, 1, 0, 2150, 0, 0, 0.00, 0.00, '2026-03-03 13:57:40', 'Work Exit Bill', 87, 'SWSI-1-000087', 1, '2026-03-03 10:57:40', '2026-03-03 10:57:40'),
(186, 1, 1, 0, 0, 2150, 0, 0.00, 0.00, '2026-03-03 13:57:40', 'Enter Money Bill', 99, 'ME-1-000099', 1, '2026-03-03 10:57:40', '2026-03-03 10:57:40'),
(187, 1, 1, 0, 790, 0, 0, 0.00, 0.00, '2026-03-03 18:12:36', 'Work Exit Bill', 88, 'SWSI-1-000088', 1, '2026-03-03 15:12:36', '2026-03-03 15:12:36'),
(188, 1, 1, 0, 0, 290, 0, 0.00, 0.00, '2026-03-03 18:12:36', 'Enter Money Bill', 100, 'ME-1-000100', 1, '2026-03-03 15:12:36', '2026-03-03 15:12:36'),
(189, 1, 1, 0, 0, 500, 0, 0.00, 0.00, '2026-03-03 18:12:36', 'Enter Money Bill', 101, 'ME-1-000101', 1, '2026-03-03 15:12:36', '2026-03-03 15:12:36'),
(190, 1, 1, 0, 42000, 0, 0, 0.00, 0.00, '2026-03-03 22:19:13', 'Work Exit Bill', 89, 'SWSI-1-000089', 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(191, 1, 1, 0, 0, 42000, 0, 0.00, 0.00, '2026-03-03 22:19:13', 'Enter Money Bill', 102, 'ME-1-000102', 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(192, 1, 1, 0, 3100, 0, 0, 0.00, 0.00, '2026-03-03 22:29:50', 'Work Exit Bill', 90, 'SWSI-1-000090', 1, '2026-03-03 19:29:50', '2026-03-03 19:29:50'),
(193, 1, 1, 0, 0, 3100, 0, 0.00, 0.00, '2026-03-03 22:29:50', 'Enter Money Bill', 103, 'ME-1-000103', 1, '2026-03-03 19:29:50', '2026-03-03 19:29:50'),
(194, 1, 1, 0, 5350, 0, 0, 0.00, 0.00, '2026-03-03 22:31:19', 'Work Exit Bill', 91, 'SWSI-1-000091', 1, '2026-03-03 19:31:19', '2026-03-03 19:31:19'),
(195, 1, 1, 0, 0, 5350, 0, 0.00, 0.00, '2026-03-03 22:31:19', 'Enter Money Bill', 104, 'ME-1-000104', 1, '2026-03-03 19:31:19', '2026-03-03 19:31:19'),
(196, 1, 1, 0, 1550, 0, 0, 0.00, 0.00, '2026-03-03 23:11:27', 'Work Exit Bill', 92, 'SWSI-1-000092', 1, '2026-03-03 20:11:27', '2026-03-03 20:11:27'),
(197, 1, 1, 0, 0, 1550, 0, 0.00, 0.00, '2026-03-03 23:11:27', 'Enter Money Bill', 105, 'ME-1-000105', 1, '2026-03-03 20:11:27', '2026-03-03 20:11:27'),
(198, 1, 1, 0, 7400, 0, 0, 0.00, 0.00, '2026-03-04 04:20:24', 'Work Exit Bill', 93, 'SWSI-1-000093', 1, '2026-03-04 01:20:24', '2026-03-04 01:20:24'),
(199, 1, 1, 0, 0, 7400, 0, 0.00, 0.00, '2026-03-04 04:20:24', 'Enter Money Bill', 106, 'ME-1-000106', 1, '2026-03-04 01:20:24', '2026-03-04 01:20:24'),
(200, 1, 1, 0, 31100, 0, 0, 0.00, 0.00, '2026-03-04 19:39:19', 'Work Exit Bill', 94, 'SWSI-1-000094', 1, '2026-03-04 16:39:19', '2026-03-04 16:39:19'),
(201, 1, 1, 0, 0, 31100, 0, 0.00, 0.00, '2026-03-04 19:39:19', 'Enter Money Bill', 107, 'ME-1-000107', 1, '2026-03-04 16:39:19', '2026-03-04 16:39:19'),
(202, 1, 1, 0, 4450, 0, 0, 0.00, 0.00, '2026-03-04 20:30:40', 'Work Exit Bill', 95, 'SWSI-1-000095', 1, '2026-03-04 17:30:40', '2026-03-04 17:30:40'),
(203, 1, 1, 0, 0, 4450, 0, 0.00, 0.00, '2026-03-04 20:30:40', 'Enter Money Bill', 108, 'ME-1-000108', 1, '2026-03-04 17:30:40', '2026-03-04 17:30:40'),
(204, 1, 1, 0, 7700, 0, 0, 0.00, 0.00, '2026-03-04 20:37:38', 'Work Exit Bill', 96, 'SWSI-1-000096', 1, '2026-03-04 17:37:38', '2026-03-04 17:37:38'),
(205, 1, 1, 0, 0, 7700, 0, 0.00, 0.00, '2026-03-04 20:37:38', 'Enter Money Bill', 109, 'ME-1-000109', 1, '2026-03-04 17:37:38', '2026-03-04 17:37:38'),
(206, 1, 1, 0, 1550, 0, 0, 0.00, 0.00, '2026-03-05 19:26:39', 'Work Exit Bill', 97, 'SWSI-1-000097', 1, '2026-03-05 16:26:39', '2026-03-05 16:26:39'),
(207, 1, 1, 0, 0, 1550, 0, 0.00, 0.00, '2026-03-05 19:26:39', 'Enter Money Bill', 110, 'ME-1-000110', 1, '2026-03-05 16:26:39', '2026-03-05 16:26:39'),
(208, 1, 1, 0, 400, 0, 0, 0.00, 0.00, '2026-03-05 19:54:35', 'Work Exit Bill', 98, 'SWSI-1-000098', 1, '2026-03-05 16:54:35', '2026-03-05 16:54:35'),
(209, 1, 1, 0, 0, 400, 0, 0.00, 0.00, '2026-03-05 19:54:35', 'Enter Money Bill', 111, 'ME-1-000111', 1, '2026-03-05 16:54:35', '2026-03-05 16:54:35'),
(210, 1, 1, 0, 840, 0, 0, 0.00, 0.00, '2026-03-05 20:44:17', 'Work Exit Bill', 99, 'SWSI-1-000099', 1, '2026-03-05 17:44:17', '2026-03-05 17:44:17'),
(211, 1, 1, 0, 0, 840, 0, 0.00, 0.00, '2026-03-05 20:44:17', 'Enter Money Bill', 112, 'ME-1-000112', 1, '2026-03-05 17:44:17', '2026-03-05 17:44:17'),
(212, 1, 1, 0, 4450, 0, 0, 0.00, 0.00, '2026-03-05 21:11:24', 'Work Exit Bill', 100, 'SWSI-1-000100', 1, '2026-03-05 18:11:24', '2026-03-05 18:11:24'),
(213, 1, 1, 0, 0, 4450, 0, 0.00, 0.00, '2026-03-05 21:11:24', 'Enter Money Bill', 113, 'ME-1-000113', 1, '2026-03-05 18:11:24', '2026-03-05 18:11:24'),
(214, 1, 1, 0, 550, 0, 0, 0.00, 0.00, '2026-03-05 21:20:48', 'Work Exit Bill', 101, 'SWSI-1-000101', 1, '2026-03-05 18:20:48', '2026-03-05 18:20:48'),
(215, 1, 1, 0, 0, 550, 0, 0.00, 0.00, '2026-03-05 21:20:48', 'Enter Money Bill', 114, 'ME-1-000114', 1, '2026-03-05 18:20:48', '2026-03-05 18:20:48'),
(216, 1, 1, 0, 750, 0, 0, 0.00, 0.00, '2026-03-05 23:00:42', 'Work Exit Bill', 102, 'SWSI-1-000102', 1, '2026-03-05 20:00:42', '2026-03-05 20:00:42'),
(217, 1, 1, 0, 0, 750, 0, 0.00, 0.00, '2026-03-05 23:00:42', 'Enter Money Bill', 115, 'ME-1-000115', 1, '2026-03-05 20:00:42', '2026-03-05 20:00:42'),
(218, 1, 1, 0, 11950, 0, 0, 0.00, 0.00, '2026-03-06 18:13:00', 'Work Exit Bill', 103, 'SWSI-1-000103', 1, '2026-03-06 15:13:00', '2026-03-06 15:13:00'),
(219, 1, 1, 0, 0, 11300, 0, 0.00, 0.00, '2026-03-06 18:13:00', 'Enter Money Bill', 116, 'ME-1-000116', 1, '2026-03-06 15:13:00', '2026-03-06 15:13:00'),
(220, 1, 1, 0, 0, 650, 0, 0.00, 0.00, '2026-03-06 18:13:00', 'Enter Money Bill', 117, 'ME-1-000117', 1, '2026-03-06 15:13:00', '2026-03-06 15:13:00'),
(221, 1, 1, 0, 800, 0, 0, 0.00, 0.00, '2026-03-06 18:17:32', 'Work Exit Bill', 104, 'SWSI-1-000104', 1, '2026-03-06 15:17:32', '2026-03-06 15:17:32'),
(222, 1, 1, 0, 0, 800, 0, 0.00, 0.00, '2026-03-06 18:17:32', 'Enter Money Bill', 118, 'ME-1-000118', 1, '2026-03-06 15:17:32', '2026-03-06 15:17:32'),
(223, 1, 1, 0, 1550, 0, 0, 0.00, 0.00, '2026-03-06 19:44:47', 'Work Exit Bill', 105, 'SWSI-1-000105', 1, '2026-03-06 16:44:47', '2026-03-06 16:44:47'),
(224, 1, 1, 0, 0, 1550, 0, 0.00, 0.00, '2026-03-06 19:44:47', 'Enter Money Bill', 119, 'ME-1-000119', 1, '2026-03-06 16:44:47', '2026-03-06 16:44:47'),
(225, 1, 1, 0, 1200, 0, 0, 0.00, 0.00, '2026-03-06 20:09:17', 'Work Exit Bill', 106, 'SWSI-1-000106', 1, '2026-03-06 17:09:17', '2026-03-06 17:09:17'),
(226, 1, 1, 0, 0, 1200, 0, 0.00, 0.00, '2026-03-06 20:09:17', 'Enter Money Bill', 120, 'ME-1-000120', 1, '2026-03-06 17:09:17', '2026-03-06 17:09:17'),
(227, 1, 1, 0, 1930, 0, 0, 0.00, 0.00, '2026-03-06 21:05:08', 'Work Exit Bill', 107, 'SWSI-1-000107', 1, '2026-03-06 18:05:08', '2026-03-06 18:05:08'),
(228, 1, 1, 0, 0, 1930, 0, 0.00, 0.00, '2026-03-06 21:05:08', 'Enter Money Bill', 121, 'ME-1-000121', 1, '2026-03-06 18:05:08', '2026-03-06 18:05:08'),
(229, 1, 1, 0, 5500, 0, 0, 0.00, 0.00, '2026-03-06 21:07:48', 'Work Exit Bill', 108, 'SWSI-1-000108', 1, '2026-03-06 18:07:48', '2026-03-06 18:07:48'),
(230, 1, 1, 0, 0, 5500, 0, 0.00, 0.00, '2026-03-06 21:07:48', 'Enter Money Bill', 122, 'ME-1-000122', 1, '2026-03-06 18:07:48', '2026-03-06 18:07:48'),
(231, 1, 1, 0, 5000, 0, 0, 0.00, 0.00, '2026-03-06 21:09:07', 'Work Exit Bill', 109, 'SWSI-1-000109', 1, '2026-03-06 18:09:07', '2026-03-06 18:09:07'),
(232, 1, 1, 0, 0, 5000, 0, 0.00, 0.00, '2026-03-06 21:09:07', 'Enter Money Bill', 123, 'ME-1-000123', 1, '2026-03-06 18:09:07', '2026-03-06 18:09:07'),
(233, 1, 1, 0, 16650, 0, 0, 0.00, 0.00, '2026-03-06 21:26:35', 'Work Exit Bill', 110, 'SWSI-1-000110', 1, '2026-03-06 18:26:35', '2026-03-06 18:26:35'),
(234, 1, 1, 0, 0, 16650, 0, 0.00, 0.00, '2026-03-06 21:26:35', 'Enter Money Bill', 124, 'ME-1-000124', 1, '2026-03-06 18:26:35', '2026-03-06 18:26:35'),
(235, 1, 1, 0, 9500, 0, 0, 0.00, 0.00, '2026-03-07 05:19:52', 'Work Exit Bill', 111, 'SWSI-1-000111', 1, '2026-03-07 02:19:52', '2026-03-07 02:19:52'),
(236, 1, 1, 0, 0, 6000, 0, 0.00, 0.00, '2026-03-07 05:19:52', 'Enter Money Bill', 125, 'ME-1-000125', 1, '2026-03-07 02:19:52', '2026-03-07 02:19:52'),
(237, 1, 1, 0, 0, 3500, 0, 0.00, 0.00, '2026-03-07 05:19:52', 'Enter Money Bill', 126, 'ME-1-000126', 1, '2026-03-07 02:19:52', '2026-03-07 02:19:52'),
(238, 1, 1, 0, 1500, 0, 0, 0.00, 0.00, '2026-03-07 18:13:45', 'Work Exit Bill', 112, 'SWSI-1-000112', 1, '2026-03-07 15:13:45', '2026-03-07 15:13:45'),
(239, 1, 1, 0, 0, 1500, 0, 0.00, 0.00, '2026-03-07 18:13:45', 'Enter Money Bill', 127, 'ME-1-000127', 1, '2026-03-07 15:13:45', '2026-03-07 15:13:45'),
(240, 1, 1, 0, 6450, 0, 0, 0.00, 0.00, '2026-03-07 18:26:02', 'Work Exit Bill', 113, 'SWSI-1-000113', 1, '2026-03-07 15:26:02', '2026-03-07 15:26:02'),
(241, 1, 1, 0, 0, 6450, 0, 0.00, 0.00, '2026-03-07 18:26:02', 'Enter Money Bill', 128, 'ME-1-000128', 1, '2026-03-07 15:26:02', '2026-03-07 15:26:02'),
(242, 1, 1, 0, 1500, 0, 0, 0.00, 0.00, '2026-03-07 18:52:09', 'Work Exit Bill', 114, 'SWSI-1-000114', 1, '2026-03-07 15:52:09', '2026-03-07 15:52:09'),
(243, 1, 1, 0, 0, 1500, 0, 0.00, 0.00, '2026-03-07 18:52:09', 'Enter Money Bill', 129, 'ME-1-000129', 1, '2026-03-07 15:52:09', '2026-03-07 15:52:09'),
(244, 1, 1, 0, 5700, 0, 0, 0.00, 0.00, '2026-03-07 21:08:46', 'Work Exit Bill', 115, 'SWSI-1-000115', 1, '2026-03-07 18:08:46', '2026-03-07 18:08:46'),
(245, 1, 1, 0, 0, 3400, 0, 0.00, 0.00, '2026-03-07 21:08:46', 'Enter Money Bill', 130, 'ME-1-000130', 1, '2026-03-07 18:08:46', '2026-03-07 18:08:46'),
(246, 1, 1, 0, 0, 2300, 0, 0.00, 0.00, '2026-03-07 21:08:46', 'Enter Money Bill', 131, 'ME-1-000131', 1, '2026-03-07 18:08:46', '2026-03-07 18:08:46'),
(247, 1, 1, 0, 1620, 0, 0, 0.00, 0.00, '2026-03-07 21:28:29', 'Work Exit Bill', 116, 'SWSI-1-000116', 1, '2026-03-07 18:28:29', '2026-03-07 18:28:29'),
(248, 1, 1, 0, 0, 1620, 0, 0.00, 0.00, '2026-03-07 21:28:29', 'Enter Money Bill', 132, 'ME-1-000132', 1, '2026-03-07 18:28:29', '2026-03-07 18:28:29'),
(249, 1, 1, 0, 10800, 0, 0, 0.00, 0.00, '2026-03-07 21:30:40', 'Work Exit Bill', 117, 'SWSI-1-000117', 1, '2026-03-07 18:30:40', '2026-03-07 18:30:40'),
(250, 1, 1, 0, 0, 10800, 0, 0.00, 0.00, '2026-03-07 21:30:40', 'Enter Money Bill', 133, 'ME-1-000133', 1, '2026-03-07 18:30:40', '2026-03-07 18:30:40'),
(251, 1, 1, 0, 1980, 0, 0, 0.00, 0.00, '2026-03-07 23:16:10', 'Work Exit Bill', 118, 'SWSI-1-000118', 1, '2026-03-07 20:16:10', '2026-03-07 20:16:10'),
(252, 1, 1, 0, 0, 1980, 0, 0.00, 0.00, '2026-03-07 23:16:10', 'Enter Money Bill', 134, 'ME-1-000134', 1, '2026-03-07 20:16:10', '2026-03-07 20:16:10'),
(253, 1, 1, 0, 2230, 0, 0, 0.00, 0.00, '2026-03-08 14:07:29', 'Work Exit Bill', 119, 'SWSI-1-000119', 1, '2026-03-08 11:07:29', '2026-03-08 11:07:29'),
(254, 1, 1, 0, 0, 2230, 0, 0.00, 0.00, '2026-03-08 14:07:29', 'Enter Money Bill', 135, 'ME-1-000135', 1, '2026-03-08 11:07:29', '2026-03-08 11:07:29'),
(255, 1, 1, 0, 8920, 0, 0, 0.00, 0.00, '2026-03-08 18:32:36', 'Work Exit Bill', 120, 'SWSI-1-000120', 1, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(256, 1, 1, 0, 0, 680, 0, 0.00, 0.00, '2026-03-08 18:32:36', 'Enter Money Bill', 136, 'ME-1-000136', 1, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(257, 1, 1, 0, 0, 8240, 0, 0.00, 0.00, '2026-03-08 18:32:36', 'Enter Money Bill', 137, 'ME-1-000137', 1, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(258, 1, 1, 0, 10170, 0, 0, 0.00, 0.00, '2026-03-08 19:19:15', 'Work Exit Bill', 121, 'SWSI-1-000121', 1, '2026-03-08 16:19:15', '2026-03-08 16:19:15'),
(259, 1, 1, 0, 0, 10170, 0, 0.00, 0.00, '2026-03-08 19:19:15', 'Enter Money Bill', 138, 'ME-1-000138', 1, '2026-03-08 16:19:15', '2026-03-08 16:19:15'),
(260, 1, 1, 0, 18900, 0, 0, 0.00, 0.00, '2026-03-08 19:21:09', 'Work Exit Bill', 122, 'SWSI-1-000122', 1, '2026-03-08 16:21:09', '2026-03-08 16:21:09'),
(261, 1, 1, 0, 0, 18900, 0, 0.00, 0.00, '2026-03-08 19:21:09', 'Enter Money Bill', 139, 'ME-1-000139', 1, '2026-03-08 16:21:09', '2026-03-08 16:21:09'),
(262, 1, 1, 0, 8800, 0, 0, 0.00, 0.00, '2026-03-08 19:55:00', 'Work Exit Bill', 123, 'SWSI-1-000123', 1, '2026-03-08 16:55:00', '2026-03-08 16:55:00'),
(263, 1, 1, 0, 0, 2400, 0, 0.00, 0.00, '2026-03-08 19:55:00', 'Enter Money Bill', 140, 'ME-1-000140', 1, '2026-03-08 16:55:00', '2026-03-08 16:55:00'),
(264, 1, 1, 0, 0, 6400, 0, 0.00, 0.00, '2026-03-08 19:55:00', 'Enter Money Bill', 141, 'ME-1-000141', 1, '2026-03-08 16:55:00', '2026-03-08 16:55:00'),
(265, 1, 1, 0, 15500, 0, 0, 0.00, 0.00, '2026-03-08 21:31:58', 'Work Exit Bill', 124, 'SWSI-1-000124', 1, '2026-03-08 18:31:58', '2026-03-08 18:31:58'),
(266, 1, 1, 0, 0, 3000, 0, 0.00, 0.00, '2026-03-08 21:31:58', 'Enter Money Bill', 142, 'ME-1-000142', 1, '2026-03-08 18:31:58', '2026-03-08 18:31:58'),
(267, 1, 1, 0, 0, 12500, 0, 0.00, 0.00, '2026-03-08 21:31:58', 'Enter Money Bill', 143, 'ME-1-000143', 1, '2026-03-08 18:31:58', '2026-03-08 18:31:58'),
(268, 1, 1, 0, 5100, 0, 0, 0.00, 0.00, '2026-03-08 23:07:08', 'Work Exit Bill', 125, 'SWSI-1-000125', 1, '2026-03-08 20:07:08', '2026-03-08 20:07:08'),
(269, 1, 1, 0, 0, 5100, 0, 0.00, 0.00, '2026-03-08 23:07:08', 'Enter Money Bill', 144, 'ME-1-000144', 1, '2026-03-08 20:07:08', '2026-03-08 20:07:08'),
(270, 1, 1, 0, 1130, 0, 0, 0.00, 0.00, '2026-03-08 23:09:20', 'Work Exit Bill', 126, 'SWSI-1-000126', 1, '2026-03-08 20:09:20', '2026-03-08 20:09:20'),
(271, 1, 1, 0, 0, 1130, 0, 0.00, 0.00, '2026-03-08 23:09:20', 'Enter Money Bill', 145, 'ME-1-000145', 1, '2026-03-08 20:09:20', '2026-03-08 20:09:20'),
(272, 1, 1, 0, 1810, 0, 0, 0.00, 0.00, '2026-03-08 23:19:03', 'Work Exit Bill', 127, 'SWSI-1-000127', 1, '2026-03-08 20:19:03', '2026-03-08 20:19:03'),
(273, 1, 1, 0, 0, 1810, 0, 0.00, 0.00, '2026-03-08 23:19:03', 'Enter Money Bill', 146, 'ME-1-000146', 1, '2026-03-08 20:19:03', '2026-03-08 20:19:03'),
(274, 1, 1, 0, 1040, 0, 0, 0.00, 0.00, '2026-03-09 14:24:17', 'Work Exit Bill', 128, 'SWSI-1-000128', 1, '2026-03-09 11:24:17', '2026-03-09 11:24:17'),
(275, 1, 1, 0, 0, 1040, 0, 0.00, 0.00, '2026-03-09 14:24:17', 'Enter Money Bill', 147, 'ME-1-000147', 1, '2026-03-09 11:24:17', '2026-03-09 11:24:17'),
(276, 1, 1, 0, 910, 0, 0, 0.00, 0.00, '2026-03-11 18:54:42', 'Work Exit Bill', 129, 'SWSI-1-000129', 1, '2026-03-11 15:54:42', '2026-03-11 15:54:42'),
(277, 1, 1, 0, 0, 910, 0, 0.00, 0.00, '2026-03-11 18:54:42', 'Enter Money Bill', 148, 'ME-1-000148', 1, '2026-03-11 15:54:42', '2026-03-11 15:54:42'),
(278, 1, 1, 0, 7080, 0, 0, 0.00, 0.00, '2026-03-11 19:00:43', 'Work Exit Bill', 130, 'SWSI-1-000130', 1, '2026-03-11 16:00:43', '2026-03-11 16:00:43'),
(279, 1, 1, 0, 0, 7080, 0, 0.00, 0.00, '2026-03-11 19:00:43', 'Enter Money Bill', 149, 'ME-1-000149', 1, '2026-03-11 16:00:43', '2026-03-11 16:00:43'),
(280, 1, 1, 0, 2210, 0, 0, 0.00, 0.00, '2026-03-11 20:35:50', 'Work Exit Bill', 131, 'SWSI-1-000131', 1, '2026-03-11 17:35:50', '2026-03-11 17:35:50'),
(281, 1, 1, 0, 0, 2210, 0, 0.00, 0.00, '2026-03-11 20:35:50', 'Enter Money Bill', 150, 'ME-1-000150', 1, '2026-03-11 17:35:50', '2026-03-11 17:35:50'),
(282, 1, 1, 0, 550, 0, 0, 0.00, 0.00, '2026-03-11 20:37:44', 'Work Exit Bill', 132, 'SWSI-1-000132', 1, '2026-03-11 17:37:44', '2026-03-11 17:37:44'),
(283, 1, 1, 0, 0, 550, 0, 0.00, 0.00, '2026-03-11 20:37:44', 'Enter Money Bill', 151, 'ME-1-000151', 1, '2026-03-11 17:37:44', '2026-03-11 17:37:44'),
(284, 1, 1, 0, 1000, 0, 0, 0.00, 0.00, '2026-03-12 04:40:19', 'Work Exit Bill', 133, 'SWSI-1-000133', 1, '2026-03-12 01:40:19', '2026-03-12 01:40:19'),
(285, 1, 1, 0, 0, 1000, 0, 0.00, 0.00, '2026-03-12 04:40:19', 'Enter Money Bill', 152, 'ME-1-000152', 1, '2026-03-12 01:40:19', '2026-03-12 01:40:19'),
(286, 1, 1, 0, 1150, 0, 0, 0.00, 0.00, '2026-03-12 18:38:38', 'Work Exit Bill', 134, 'SWSI-1-000134', 1, '2026-03-12 15:38:38', '2026-03-12 15:38:38'),
(287, 1, 1, 0, 0, 1150, 0, 0.00, 0.00, '2026-03-12 18:38:38', 'Enter Money Bill', 153, 'ME-1-000153', 1, '2026-03-12 15:38:38', '2026-03-12 15:38:38'),
(288, 1, 1, 0, 1250, 0, 0, 0.00, 0.00, '2026-03-12 18:39:42', 'Work Exit Bill', 135, 'SWSI-1-000135', 1, '2026-03-12 15:39:42', '2026-03-12 15:39:42'),
(289, 1, 1, 0, 0, 1250, 0, 0.00, 0.00, '2026-03-12 18:39:42', 'Enter Money Bill', 154, 'ME-1-000154', 1, '2026-03-12 15:39:42', '2026-03-12 15:39:42'),
(290, 1, 1, 0, 1000, 0, 0, 0.00, 0.00, '2026-03-12 19:46:40', 'Work Exit Bill', 136, 'SWSI-1-000136', 1, '2026-03-12 16:46:40', '2026-03-12 16:46:40'),
(291, 1, 1, 0, 0, 1000, 0, 0.00, 0.00, '2026-03-12 19:46:40', 'Enter Money Bill', 155, 'ME-1-000155', 1, '2026-03-12 16:46:40', '2026-03-12 16:46:40'),
(292, 1, 1, 0, 1290, 0, 0, 0.00, 0.00, '2026-03-12 20:49:31', 'Work Exit Bill', 137, 'SWSI-1-000137', 1, '2026-03-12 17:49:31', '2026-03-12 17:49:31'),
(293, 1, 1, 0, 0, 1290, 0, 0.00, 0.00, '2026-03-12 20:49:31', 'Enter Money Bill', 156, 'ME-1-000156', 1, '2026-03-12 17:49:31', '2026-03-12 17:49:31'),
(294, 1, 1, 0, 1700, 0, 0, 0.00, 0.00, '2026-03-12 21:36:50', 'Work Exit Bill', 138, 'SWSI-1-000138', 1, '2026-03-12 18:36:50', '2026-03-12 18:36:50'),
(295, 1, 1, 0, 0, 1700, 0, 0.00, 0.00, '2026-03-12 21:36:50', 'Enter Money Bill', 157, 'ME-1-000157', 1, '2026-03-12 18:36:50', '2026-03-12 18:36:50'),
(296, 1, 1, 0, 1100, 0, 0, 0.00, 0.00, '2026-03-12 23:03:54', 'Work Exit Bill', 139, 'SWSI-1-000139', 1, '2026-03-12 20:03:54', '2026-03-12 20:03:54'),
(297, 1, 1, 0, 0, 1100, 0, 0.00, 0.00, '2026-03-12 23:03:54', 'Enter Money Bill', 158, 'ME-1-000158', 1, '2026-03-12 20:03:54', '2026-03-12 20:03:54'),
(298, 1, 1, 0, 1980, 0, 0, 0.00, 0.00, '2026-03-13 04:34:34', 'Work Exit Bill', 140, 'SWSI-1-000140', 1, '2026-03-13 01:34:34', '2026-03-13 01:34:34'),
(299, 1, 1, 0, 0, 1000, 0, 0.00, 0.00, '2026-03-13 04:34:34', 'Enter Money Bill', 159, 'ME-1-000159', 1, '2026-03-13 01:34:34', '2026-03-13 01:34:34'),
(300, 1, 1, 0, 0, 980, 0, 0.00, 0.00, '2026-03-13 04:34:34', 'Enter Money Bill', 160, 'ME-1-000160', 1, '2026-03-13 01:34:34', '2026-03-13 01:34:34'),
(301, 1, 1, 0, 7600, 0, 0, 0.00, 0.00, '2026-03-13 18:34:13', 'Work Exit Bill', 141, 'SWSI-1-000141', 1, '2026-03-13 15:34:13', '2026-03-13 15:34:13'),
(302, 1, 1, 0, 0, 7600, 0, 0.00, 0.00, '2026-03-13 18:34:13', 'Enter Money Bill', 161, 'ME-1-000161', 1, '2026-03-13 15:34:13', '2026-03-13 15:34:13'),
(303, 1, 1, 0, 1800, 0, 0, 0.00, 0.00, '2026-03-13 19:33:09', 'Work Exit Bill', 142, 'SWSI-1-000142', 1, '2026-03-13 16:33:09', '2026-03-13 16:33:09'),
(304, 1, 1, 0, 0, 1800, 0, 0.00, 0.00, '2026-03-13 19:33:09', 'Enter Money Bill', 162, 'ME-1-000162', 1, '2026-03-13 16:33:09', '2026-03-13 16:33:09'),
(305, 1, 1, 0, 1700, 0, 0, 0.00, 0.00, '2026-03-13 19:49:34', 'Work Exit Bill', 143, 'SWSI-1-000143', 1, '2026-03-13 16:49:34', '2026-03-13 16:49:34'),
(306, 1, 1, 0, 0, 1700, 0, 0.00, 0.00, '2026-03-13 19:49:34', 'Enter Money Bill', 163, 'ME-1-000163', 1, '2026-03-13 16:49:34', '2026-03-13 16:49:34'),
(307, 1, 1, 0, 600, 0, 0, 0.00, 0.00, '2026-03-13 20:03:23', 'Work Exit Bill', 144, 'SWSI-1-000144', 1, '2026-03-13 17:03:23', '2026-03-13 17:03:23'),
(308, 1, 1, 0, 0, 600, 0, 0.00, 0.00, '2026-03-13 20:03:23', 'Enter Money Bill', 164, 'ME-1-000164', 1, '2026-03-13 17:03:23', '2026-03-13 17:03:23'),
(309, 1, 1, 0, 1070, 0, 0, 0.00, 0.00, '2026-03-13 20:39:23', 'Work Exit Bill', 145, 'SWSI-1-000145', 1, '2026-03-13 17:39:23', '2026-03-13 17:39:23'),
(310, 1, 1, 0, 0, 1070, 0, 0.00, 0.00, '2026-03-13 20:39:23', 'Enter Money Bill', 165, 'ME-1-000165', 1, '2026-03-13 17:39:23', '2026-03-13 17:39:23'),
(311, 1, 1, 0, 300, 0, 0, 0.00, 0.00, '2026-03-13 21:18:59', 'Work Exit Bill', 146, 'SWSI-1-000146', 1, '2026-03-13 18:18:59', '2026-03-13 18:18:59'),
(312, 1, 1, 0, 0, 300, 0, 0.00, 0.00, '2026-03-13 21:18:59', 'Enter Money Bill', 166, 'ME-1-000166', 1, '2026-03-13 18:18:59', '2026-03-13 18:18:59'),
(313, 1, 1, 0, 1700, 0, 0, 0.00, 0.00, '2026-03-13 21:50:15', 'Work Exit Bill', 147, 'SWSI-1-000147', 1, '2026-03-13 18:50:15', '2026-03-13 18:50:15'),
(314, 1, 1, 0, 0, 1700, 0, 0.00, 0.00, '2026-03-13 21:50:15', 'Enter Money Bill', 167, 'ME-1-000167', 1, '2026-03-13 18:50:15', '2026-03-13 18:50:15'),
(315, 1, 1, 0, 2670, 0, 0, 0.00, 0.00, '2026-03-13 23:52:01', 'Work Exit Bill', 148, 'SWSI-1-000148', 1, '2026-03-13 20:52:01', '2026-03-13 20:52:01'),
(316, 1, 1, 0, 0, 2670, 0, 0.00, 0.00, '2026-03-13 23:52:01', 'Enter Money Bill', 168, 'ME-1-000168', 1, '2026-03-13 20:52:01', '2026-03-13 20:52:01'),
(317, 1, 1, 0, 7300, 0, 0, 0.00, 0.00, '2026-03-14 03:01:22', 'Work Exit Bill', 149, 'SWSI-1-000149', 1, '2026-03-14 00:01:22', '2026-03-14 00:01:22'),
(318, 1, 1, 0, 0, 7300, 0, 0.00, 0.00, '2026-03-14 03:01:22', 'Enter Money Bill', 169, 'ME-1-000169', 1, '2026-03-14 00:01:22', '2026-03-14 00:01:22'),
(319, 1, 1, 0, 2550, 0, 0, 0.00, 0.00, '2026-03-14 04:55:57', 'Work Exit Bill', 150, 'SWSI-1-000150', 1, '2026-03-14 01:55:57', '2026-03-14 01:55:57'),
(320, 1, 1, 0, 0, 2550, 0, 0.00, 0.00, '2026-03-14 04:55:57', 'Enter Money Bill', 170, 'ME-1-000170', 1, '2026-03-14 01:55:57', '2026-03-14 01:55:57'),
(321, 1, 1, 0, 1500, 0, 0, 0.00, 0.00, '2026-03-14 18:57:48', 'Work Exit Bill', 151, 'SWSI-1-000151', 1, '2026-03-14 15:57:48', '2026-03-14 15:57:48'),
(322, 1, 1, 0, 0, 1500, 0, 0.00, 0.00, '2026-03-14 18:57:48', 'Enter Money Bill', 171, 'ME-1-000171', 1, '2026-03-14 15:57:48', '2026-03-14 15:57:48'),
(323, 1, 1, 0, 1000, 0, 0, 0.00, 0.00, '2026-03-14 18:59:16', 'Work Exit Bill', 152, 'SWSI-1-000152', 1, '2026-03-14 15:59:16', '2026-03-14 15:59:16'),
(324, 1, 1, 0, 0, 1000, 0, 0.00, 0.00, '2026-03-14 18:59:16', 'Enter Money Bill', 172, 'ME-1-000172', 1, '2026-03-14 15:59:16', '2026-03-14 15:59:16'),
(325, 1, 1, 0, 3100, 0, 0, 0.00, 0.00, '2026-03-14 19:10:06', 'Work Exit Bill', 153, 'SWSI-1-000153', 1, '2026-03-14 16:10:06', '2026-03-14 16:10:06'),
(326, 1, 1, 0, 0, 3100, 0, 0.00, 0.00, '2026-03-14 19:10:06', 'Enter Money Bill', 173, 'ME-1-000173', 1, '2026-03-14 16:10:06', '2026-03-14 16:10:06'),
(327, 1, 1, 0, 950, 0, 0, 0.00, 0.00, '2026-03-14 19:55:05', 'Work Exit Bill', 154, 'SWSI-1-000154', 1, '2026-03-14 16:55:05', '2026-03-14 16:55:05'),
(328, 1, 1, 0, 0, 950, 0, 0.00, 0.00, '2026-03-14 19:55:05', 'Enter Money Bill', 174, 'ME-1-000174', 1, '2026-03-14 16:55:05', '2026-03-14 16:55:05'),
(329, 1, 1, 0, 2600, 0, 0, 0.00, 0.00, '2026-03-14 22:54:02', 'Work Exit Bill', 155, 'SWSI-1-000155', 1, '2026-03-14 19:54:02', '2026-03-14 19:54:02'),
(330, 1, 1, 0, 0, 2600, 0, 0.00, 0.00, '2026-03-14 22:54:02', 'Enter Money Bill', 175, 'ME-1-000175', 1, '2026-03-14 19:54:02', '2026-03-14 19:54:02'),
(331, 1, 1, 0, 900, 0, 0, 0.00, 0.00, '2026-03-14 23:04:37', 'Work Exit Bill', 156, 'SWSI-1-000156', 1, '2026-03-14 20:04:37', '2026-03-14 20:04:37'),
(332, 1, 1, 0, 0, 900, 0, 0.00, 0.00, '2026-03-14 23:04:37', 'Enter Money Bill', 176, 'ME-1-000176', 1, '2026-03-14 20:04:37', '2026-03-14 20:04:37'),
(333, 1, 1, 0, 1950, 0, 0, 0.00, 0.00, '2026-03-15 04:50:38', 'Work Exit Bill', 157, 'SWSI-1-000157', 1, '2026-03-15 01:50:38', '2026-03-15 01:50:38'),
(334, 1, 1, 0, 0, 1950, 0, 0.00, 0.00, '2026-03-15 04:50:38', 'Enter Money Bill', 177, 'ME-1-000177', 1, '2026-03-15 01:50:38', '2026-03-15 01:50:38');
INSERT INTO `company_movements` (`id`, `branch_id`, `company_id`, `paid_money`, `debit_money`, `credit_money`, `paid_gold`, `debit_gold`, `credit_gold`, `date`, `invoice_type`, `bill_id`, `bill_number`, `user_id`, `created_at`, `updated_at`) VALUES
(335, 1, 1, 0, 2550, 0, 0, 0.00, 0.00, '2026-03-15 14:13:18', 'Work Exit Bill', 158, 'SWSI-1-000158', 1, '2026-03-15 11:13:18', '2026-03-15 11:13:18'),
(336, 1, 1, 0, 0, 2550, 0, 0.00, 0.00, '2026-03-15 14:13:18', 'Enter Money Bill', 178, 'ME-1-000178', 1, '2026-03-15 11:13:18', '2026-03-15 11:13:18'),
(337, 1, 1, 0, 800, 0, 0, 0.00, 0.00, '2026-03-15 14:34:52', 'Work Exit Bill', 159, 'SWSI-1-000159', 1, '2026-03-15 11:34:52', '2026-03-15 11:34:52'),
(338, 1, 1, 0, 0, 800, 0, 0.00, 0.00, '2026-03-15 14:34:52', 'Enter Money Bill', 179, 'ME-1-000179', 1, '2026-03-15 11:34:52', '2026-03-15 11:34:52'),
(339, 1, 1, 0, 5500, 0, 0, 0.00, 0.00, '2026-03-15 19:50:15', 'Work Exit Bill', 160, 'SWSI-1-000160', 1, '2026-03-15 16:50:15', '2026-03-15 16:50:15'),
(340, 1, 1, 0, 0, 5500, 0, 0.00, 0.00, '2026-03-15 19:50:15', 'Enter Money Bill', 180, 'ME-1-000180', 1, '2026-03-15 16:50:15', '2026-03-15 16:50:15'),
(341, 1, 1, 0, 2300, 0, 0, 0.00, 0.00, '2026-03-15 22:17:25', 'Work Exit Bill', 161, 'SWSI-1-000161', 1, '2026-03-15 19:17:25', '2026-03-15 19:17:25'),
(342, 1, 1, 0, 0, 2300, 0, 0.00, 0.00, '2026-03-15 22:17:25', 'Enter Money Bill', 181, 'ME-1-000181', 1, '2026-03-15 19:17:25', '2026-03-15 19:17:25'),
(343, 1, 1, 0, 1445, 0, 0, 0.00, 0.00, '2026-03-16 04:39:44', 'Work Exit Bill', 162, 'SWSI-1-000162', 1, '2026-03-16 01:39:44', '2026-03-16 01:39:44'),
(344, 1, 1, 0, 0, 1445, 0, 0.00, 0.00, '2026-03-16 04:39:44', 'Enter Money Bill', 182, 'ME-1-000182', 1, '2026-03-16 01:39:44', '2026-03-16 01:39:44'),
(345, 1, 1, 0, 4300, 0, 0, 0.00, 0.00, '2026-03-16 14:04:34', 'Work Exit Bill', 163, 'SWSI-1-000163', 1, '2026-03-16 11:04:34', '2026-03-16 11:04:34'),
(346, 1, 1, 0, 0, 4300, 0, 0.00, 0.00, '2026-03-16 14:04:34', 'Enter Money Bill', 183, 'ME-1-000183', 1, '2026-03-16 11:04:34', '2026-03-16 11:04:34'),
(347, 1, 1, 0, 575, 0, 0, 0.00, 0.00, '2026-03-16 23:07:04', 'Work Exit Bill', 164, 'SWSI-1-000164', 1, '2026-03-16 20:07:04', '2026-03-16 20:07:04'),
(348, 1, 1, 0, 0, 575, 0, 0.00, 0.00, '2026-03-16 23:07:04', 'Enter Money Bill', 184, 'ME-1-000184', 1, '2026-03-16 20:07:04', '2026-03-16 20:07:04'),
(349, 1, 1, 0, 6850, 0, 0, 0.00, 0.00, '2026-03-17 22:14:39', 'Work Exit Bill', 165, 'SWSI-1-000165', 1, '2026-03-17 19:14:39', '2026-03-17 19:14:39'),
(350, 1, 1, 0, 0, 6850, 0, 0.00, 0.00, '2026-03-17 22:14:39', 'Enter Money Bill', 185, 'ME-1-000185', 1, '2026-03-17 19:14:39', '2026-03-17 19:14:39'),
(351, 1, 1, 0, 1800, 0, 0, 0.00, 0.00, '2026-03-17 22:41:21', 'Work Exit Bill', 166, 'SWSI-1-000166', 1, '2026-03-17 19:41:21', '2026-03-17 19:41:21'),
(352, 1, 1, 0, 0, 1800, 0, 0.00, 0.00, '2026-03-17 22:41:21', 'Enter Money Bill', 186, 'ME-1-000186', 1, '2026-03-17 19:41:21', '2026-03-17 19:41:21'),
(353, 1, 1, 0, 6500, 0, 0, 0.00, 0.00, '2026-03-18 05:36:33', 'Work Exit Bill', 167, 'SWSI-1-000167', 1, '2026-03-18 02:36:33', '2026-03-18 02:36:33'),
(354, 1, 1, 0, 0, 6500, 0, 0.00, 0.00, '2026-03-18 05:36:33', 'Enter Money Bill', 187, 'ME-1-000187', 1, '2026-03-18 02:36:33', '2026-03-18 02:36:33'),
(355, 1, 1, 0, 2200, 0, 0, 0.00, 0.00, '2026-03-18 19:30:10', 'Work Exit Bill', 168, 'SWSI-1-000168', 1, '2026-03-18 16:30:10', '2026-03-18 16:30:10'),
(356, 1, 1, 0, 0, 200, 0, 0.00, 0.00, '2026-03-18 19:30:10', 'Enter Money Bill', 188, 'ME-1-000188', 1, '2026-03-18 16:30:10', '2026-03-18 16:30:10'),
(357, 1, 1, 0, 0, 2000, 0, 0.00, 0.00, '2026-03-18 19:30:10', 'Enter Money Bill', 189, 'ME-1-000189', 1, '2026-03-18 16:30:10', '2026-03-18 16:30:10'),
(358, 1, 1, 0, 900, 0, 0, 0.00, 0.00, '2026-03-18 19:30:51', 'Work Exit Bill', 169, 'SWSI-1-000169', 1, '2026-03-18 16:30:51', '2026-03-18 16:30:51'),
(359, 1, 1, 0, 0, 900, 0, 0.00, 0.00, '2026-03-18 19:30:51', 'Enter Money Bill', 190, 'ME-1-000190', 1, '2026-03-18 16:30:51', '2026-03-18 16:30:51'),
(360, 1, 1, 0, 850, 0, 0, 0.00, 0.00, '2026-03-18 20:43:09', 'Work Exit Bill', 170, 'SWSI-1-000170', 1, '2026-03-18 17:43:09', '2026-03-18 17:43:09'),
(361, 1, 1, 0, 0, 850, 0, 0.00, 0.00, '2026-03-18 20:43:09', 'Enter Money Bill', 191, 'ME-1-000191', 1, '2026-03-18 17:43:09', '2026-03-18 17:43:09'),
(362, 1, 1, 0, 1980, 0, 0, 0.00, 0.00, '2026-03-18 20:57:54', 'Work Exit Bill', 171, 'SWSI-1-000171', 1, '2026-03-18 17:57:54', '2026-03-18 17:57:54'),
(363, 1, 1, 0, 0, 1980, 0, 0.00, 0.00, '2026-03-18 20:57:54', 'Enter Money Bill', 192, 'ME-1-000192', 1, '2026-03-18 17:57:54', '2026-03-18 17:57:54'),
(364, 1, 1, 0, 28900, 0, 0, 0.00, 0.00, '2026-03-18 21:22:46', 'Work Exit Bill', 172, 'SWSI-1-000172', 1, '2026-03-18 18:22:46', '2026-03-18 18:22:46'),
(365, 1, 1, 0, 0, 28900, 0, 0.00, 0.00, '2026-03-18 21:22:46', 'Enter Money Bill', 193, 'ME-1-000193', 1, '2026-03-18 18:22:46', '2026-03-18 18:22:46'),
(366, 1, 1, 0, 1270, 0, 0, 0.00, 0.00, '2026-03-18 22:13:21', 'Work Exit Bill', 173, 'SWSI-1-000173', 1, '2026-03-18 19:13:21', '2026-03-18 19:13:21'),
(367, 1, 1, 0, 0, 1270, 0, 0.00, 0.00, '2026-03-18 22:13:21', 'Enter Money Bill', 194, 'ME-1-000194', 1, '2026-03-18 19:13:21', '2026-03-18 19:13:21'),
(368, 1, 1, 0, 860, 0, 0, 0.00, 0.00, '2026-03-18 23:01:45', 'Work Exit Bill', 174, 'SWSI-1-000174', 1, '2026-03-18 20:01:45', '2026-03-18 20:01:45'),
(369, 1, 1, 0, 0, 860, 0, 0.00, 0.00, '2026-03-18 23:01:45', 'Enter Money Bill', 195, 'ME-1-000195', 1, '2026-03-18 20:01:45', '2026-03-18 20:01:45'),
(370, 1, 1, 0, 1700, 0, 0, 0.00, 0.00, '2026-03-19 19:50:02', 'Work Exit Bill', 175, 'SWSI-1-000175', 1, '2026-03-19 16:50:02', '2026-03-19 16:50:02'),
(371, 1, 1, 0, 0, 1700, 0, 0.00, 0.00, '2026-03-19 19:50:02', 'Enter Money Bill', 196, 'ME-1-000196', 1, '2026-03-19 16:50:02', '2026-03-19 16:50:02'),
(372, 1, 1, 0, 2100, 0, 0, 0.00, 0.00, '2026-03-23 15:32:35', 'Work Exit Bill', 176, 'SWSI-1-000176', 1, '2026-03-23 12:32:35', '2026-03-23 12:32:35'),
(373, 1, 1, 0, 0, 2100, 0, 0.00, 0.00, '2026-03-23 15:32:35', 'Enter Money Bill', 197, 'ME-1-000197', 1, '2026-03-23 12:32:35', '2026-03-23 12:32:35'),
(374, 1, 1, 0, 1375, 0, 0, 0.00, 0.00, '2026-03-23 16:59:10', 'Work Exit Bill', 177, 'SWSI-1-000177', 1, '2026-03-23 13:59:10', '2026-03-23 13:59:10'),
(375, 1, 1, 0, 0, 1375, 0, 0.00, 0.00, '2026-03-23 16:59:10', 'Enter Money Bill', 198, 'ME-1-000198', 1, '2026-03-23 13:59:10', '2026-03-23 13:59:10'),
(376, 1, 1, 0, 1395, 0, 0, 0.00, 0.00, '2026-03-23 19:58:42', 'Work Exit Bill', 178, 'SWSI-1-000178', 1, '2026-03-23 16:58:42', '2026-03-23 16:58:42'),
(377, 1, 1, 0, 0, 1395, 0, 0.00, 0.00, '2026-03-23 19:58:42', 'Enter Money Bill', 199, 'ME-1-000199', 1, '2026-03-23 16:58:42', '2026-03-23 16:58:42'),
(378, 1, 1, 0, 9100, 0, 0, 0.00, 0.00, '2026-03-23 20:26:19', 'Work Exit Bill', 179, 'SWSI-1-000179', 1, '2026-03-23 17:26:19', '2026-03-23 17:26:19'),
(379, 1, 1, 0, 0, 9100, 0, 0.00, 0.00, '2026-03-23 20:26:19', 'Enter Money Bill', 200, 'ME-1-000200', 1, '2026-03-23 17:26:19', '2026-03-23 17:26:19'),
(380, 1, 1, 0, 1520, 0, 0, 0.00, 0.00, '2026-03-24 07:42:14', 'Work Exit Bill', 180, 'SWSI-1-000180', 1, '2026-03-24 04:42:14', '2026-03-24 04:42:14'),
(381, 1, 1, 0, 0, 1000, 0, 0.00, 0.00, '2026-03-24 07:42:14', 'Enter Money Bill', 201, 'ME-1-000201', 1, '2026-03-24 04:42:14', '2026-03-24 04:42:14'),
(382, 1, 1, 0, 0, 520, 0, 0.00, 0.00, '2026-03-24 07:42:14', 'Enter Money Bill', 202, 'ME-1-000202', 1, '2026-03-24 04:42:14', '2026-03-24 04:42:14'),
(383, 1, 1, 0, 3005, 0, 0, 0.00, 0.00, '2026-03-24 14:46:43', 'Work Exit Bill', 181, 'SWSI-1-000181', 1, '2026-03-24 11:46:43', '2026-03-24 11:46:43'),
(384, 1, 1, 0, 0, 3005, 0, 0.00, 0.00, '2026-03-24 14:46:43', 'Enter Money Bill', 203, 'ME-1-000203', 1, '2026-03-24 11:46:43', '2026-03-24 11:46:43'),
(385, 1, 1, 0, 900, 0, 0, 0.00, 0.00, '2026-03-24 16:37:41', 'Work Exit Bill', 182, 'SWSI-1-000182', 1, '2026-03-24 13:37:41', '2026-03-24 13:37:41'),
(386, 1, 1, 0, 0, 900, 0, 0.00, 0.00, '2026-03-24 16:37:41', 'Enter Money Bill', 204, 'ME-1-000204', 1, '2026-03-24 13:37:41', '2026-03-24 13:37:41'),
(387, 1, 1, 0, 1650, 0, 0, 0.00, 0.00, '2026-03-24 18:53:22', 'Work Exit Bill', 183, 'SWSI-1-000183', 1, '2026-03-24 15:53:22', '2026-03-24 15:53:22'),
(388, 1, 1, 0, 0, 1650, 0, 0.00, 0.00, '2026-03-24 18:53:22', 'Enter Money Bill', 205, 'ME-1-000205', 1, '2026-03-24 15:53:22', '2026-03-24 15:53:22'),
(389, 1, 1, 0, 12200, 0, 0, 0.00, 0.00, '2026-03-24 19:02:13', 'Work Exit Bill', 184, 'SWSI-1-000184', 1, '2026-03-24 16:02:13', '2026-03-24 16:02:13'),
(390, 1, 1, 0, 0, 10340, 0, 0.00, 0.00, '2026-03-24 19:02:13', 'Enter Money Bill', 206, 'ME-1-000206', 1, '2026-03-24 16:02:13', '2026-03-24 16:02:13'),
(391, 1, 1, 0, 0, 1860, 0, 0.00, 0.00, '2026-03-24 19:02:13', 'Enter Money Bill', 207, 'ME-1-000207', 1, '2026-03-24 16:02:13', '2026-03-24 16:02:13'),
(392, 1, 1, 0, 860, 0, 0, 0.00, 0.00, '2026-03-24 19:40:32', 'Work Exit Bill', 185, 'SWSI-1-000185', 1, '2026-03-24 16:40:32', '2026-03-24 16:40:32'),
(393, 1, 1, 0, 0, 860, 0, 0.00, 0.00, '2026-03-24 19:40:32', 'Enter Money Bill', 208, 'ME-1-000208', 1, '2026-03-24 16:40:32', '2026-03-24 16:40:32'),
(394, 1, 1, 0, 25370, 0, 0, 0.00, 0.00, '2026-03-25 15:32:28', 'Work Exit Bill', 186, 'SWSI-1-000186', 1, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(395, 1, 1, 0, 0, 2760, 0, 0.00, 0.00, '2026-03-25 15:32:28', 'Enter Money Bill', 209, 'ME-1-000209', 1, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(396, 1, 1, 0, 0, 22610, 0, 0.00, 0.00, '2026-03-25 15:32:28', 'Enter Money Bill', 210, 'ME-1-000210', 1, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(397, 1, 1, 0, 1400, 0, 0, 0.00, 0.00, '2026-03-25 18:12:41', 'Work Exit Bill', 187, 'SWSI-1-000187', 1, '2026-03-25 15:12:41', '2026-03-25 15:12:41'),
(398, 1, 1, 0, 0, 1400, 0, 0.00, 0.00, '2026-03-25 18:12:41', 'Enter Money Bill', 211, 'ME-1-000211', 1, '2026-03-25 15:12:41', '2026-03-25 15:12:41'),
(399, 1, 1, 0, 620, 0, 0, 0.00, 0.00, '2026-03-25 20:28:06', 'Work Exit Bill', 188, 'SWSI-1-000188', 1, '2026-03-25 17:28:06', '2026-03-25 17:28:06'),
(400, 1, 1, 0, 0, 620, 0, 0.00, 0.00, '2026-03-25 20:28:06', 'Enter Money Bill', 212, 'ME-1-000212', 1, '2026-03-25 17:28:06', '2026-03-25 17:28:06'),
(401, 1, 1, 0, 1075, 0, 0, 0.00, 0.00, '2026-03-26 17:59:41', 'Work Exit Bill', 189, 'SWSI-1-000189', 1, '2026-03-26 14:59:41', '2026-03-26 14:59:41'),
(402, 1, 1, 0, 0, 1075, 0, 0.00, 0.00, '2026-03-26 17:59:41', 'Enter Money Bill', 213, 'ME-1-000213', 1, '2026-03-26 14:59:41', '2026-03-26 14:59:41'),
(403, 1, 1, 0, 650, 0, 0, 0.00, 0.00, '2026-03-26 18:50:36', 'Work Exit Bill', 190, 'SWSI-1-000190', 1, '2026-03-26 15:50:36', '2026-03-26 15:50:36'),
(404, 1, 1, 0, 0, 600, 0, 0.00, 0.00, '2026-03-26 18:50:36', 'Enter Money Bill', 214, 'ME-1-000214', 1, '2026-03-26 15:50:36', '2026-03-26 15:50:36'),
(405, 1, 1, 0, 0, 50, 0, 0.00, 0.00, '2026-03-26 18:50:36', 'Enter Money Bill', 215, 'ME-1-000215', 1, '2026-03-26 15:50:36', '2026-03-26 15:50:36'),
(406, 1, 1, 0, 1600, 0, 0, 0.00, 0.00, '2026-03-26 18:56:18', 'Work Exit Bill', 191, 'SWSI-1-000191', 1, '2026-03-26 15:56:18', '2026-03-26 15:56:18'),
(407, 1, 1, 0, 0, 1600, 0, 0.00, 0.00, '2026-03-26 18:56:18', 'Enter Money Bill', 216, 'ME-1-000216', 1, '2026-03-26 15:56:18', '2026-03-26 15:56:18'),
(408, 1, 1, 0, 2150, 0, 0, 0.00, 0.00, '2026-03-26 19:58:35', 'Work Exit Bill', 192, 'SWSI-1-000192', 1, '2026-03-26 16:58:35', '2026-03-26 16:58:35'),
(409, 1, 1, 0, 0, 2150, 0, 0.00, 0.00, '2026-03-26 19:58:35', 'Enter Money Bill', 217, 'ME-1-000217', 1, '2026-03-26 16:58:35', '2026-03-26 16:58:35'),
(410, 1, 1, 0, 8100, 0, 0, 0.00, 0.00, '2026-03-27 14:28:24', 'Work Exit Bill', 193, 'SWSI-1-000193', 1, '2026-03-27 11:28:24', '2026-03-27 11:28:24'),
(411, 1, 1, 0, 0, 8100, 0, 0.00, 0.00, '2026-03-27 14:28:24', 'Enter Money Bill', 218, 'ME-1-000218', 1, '2026-03-27 11:28:24', '2026-03-27 11:28:24'),
(412, 1, 1, 0, 1050, 0, 0, 0.00, 0.00, '2026-03-27 14:33:24', 'Work Exit Bill', 194, 'SWSI-1-000194', 1, '2026-03-27 11:33:24', '2026-03-27 11:33:24'),
(413, 1, 1, 0, 0, 1050, 0, 0.00, 0.00, '2026-03-27 14:33:24', 'Enter Money Bill', 219, 'ME-1-000219', 1, '2026-03-27 11:33:24', '2026-03-27 11:33:24'),
(414, 1, 1, 0, 1600, 0, 0, 0.00, 0.00, '2026-03-27 18:24:44', 'Work Exit Bill', 195, 'SWSI-1-000195', 1, '2026-03-27 15:24:44', '2026-03-27 15:24:44'),
(415, 1, 1, 0, 0, 1600, 0, 0.00, 0.00, '2026-03-27 18:24:44', 'Enter Money Bill', 220, 'ME-1-000220', 1, '2026-03-27 15:24:44', '2026-03-27 15:24:44'),
(416, 1, 1, 0, 2950, 0, 0, 0.00, 0.00, '2026-03-27 19:05:47', 'Work Exit Bill', 196, 'SWSI-1-000196', 1, '2026-03-27 16:05:47', '2026-03-27 16:05:47'),
(417, 1, 1, 0, 0, 650, 0, 0.00, 0.00, '2026-03-27 19:05:47', 'Enter Money Bill', 221, 'ME-1-000221', 1, '2026-03-27 16:05:47', '2026-03-27 16:05:47'),
(418, 1, 1, 0, 0, 2300, 0, 0.00, 0.00, '2026-03-27 19:05:47', 'Enter Money Bill', 222, 'ME-1-000222', 1, '2026-03-27 16:05:47', '2026-03-27 16:05:47'),
(419, 1, 1, 0, 1150, 0, 0, 0.00, 0.00, '2026-03-27 20:04:33', 'Work Exit Bill', 197, 'SWSI-1-000197', 1, '2026-03-27 17:04:33', '2026-03-27 17:04:33'),
(420, 1, 1, 0, 0, 1150, 0, 0.00, 0.00, '2026-03-27 20:04:33', 'Enter Money Bill', 223, 'ME-1-000223', 1, '2026-03-27 17:04:33', '2026-03-27 17:04:33'),
(421, 1, 1, 0, 6500, 0, 0, 0.00, 0.00, '2026-03-28 15:00:27', 'Work Exit Bill', 198, 'SWSI-1-000198', 1, '2026-03-28 12:00:27', '2026-03-28 12:00:27'),
(422, 1, 1, 0, 0, 6500, 0, 0.00, 0.00, '2026-03-28 15:00:27', 'Enter Money Bill', 224, 'ME-1-000224', 1, '2026-03-28 12:00:27', '2026-03-28 12:00:27'),
(423, 1, 1, 0, 2240, 0, 0, 0.00, 0.00, '2026-03-28 16:43:42', 'Work Exit Bill', 199, 'SWSI-1-000199', 1, '2026-03-28 13:43:42', '2026-03-28 13:43:42'),
(424, 1, 1, 0, 0, 2240, 0, 0.00, 0.00, '2026-03-28 16:43:42', 'Enter Money Bill', 225, 'ME-1-000225', 1, '2026-03-28 13:43:42', '2026-03-28 13:43:42'),
(425, 1, 1, 0, 8900, 0, 0, 0.00, 0.00, '2026-03-28 17:58:46', 'Work Exit Bill', 200, 'SWSI-1-000200', 1, '2026-03-28 14:58:46', '2026-03-28 14:58:46'),
(426, 1, 1, 0, 0, 8900, 0, 0.00, 0.00, '2026-03-28 17:58:46', 'Enter Money Bill', 226, 'ME-1-000226', 1, '2026-03-28 14:58:46', '2026-03-28 14:58:46'),
(427, 1, 1, 0, 3600, 0, 0, 0.00, 0.00, '2026-03-28 18:33:34', 'Work Exit Bill', 201, 'SWSI-1-000201', 1, '2026-03-28 15:33:34', '2026-03-28 15:33:34'),
(428, 1, 1, 0, 0, 3600, 0, 0.00, 0.00, '2026-03-28 18:33:34', 'Enter Money Bill', 227, 'ME-1-000227', 1, '2026-03-28 15:33:34', '2026-03-28 15:33:34'),
(429, 1, 1, 0, 550, 0, 0, 0.00, 0.00, '2026-03-28 19:30:04', 'Work Exit Bill', 202, 'SWSI-1-000202', 1, '2026-03-28 16:30:04', '2026-03-28 16:30:04'),
(430, 1, 1, 0, 0, 550, 0, 0.00, 0.00, '2026-03-28 19:30:04', 'Enter Money Bill', 228, 'ME-1-000228', 1, '2026-03-28 16:30:04', '2026-03-28 16:30:04'),
(431, 1, 1, 0, 1200, 0, 0, 0.00, 0.00, '2026-03-28 20:00:07', 'Work Exit Bill', 203, 'SWSI-1-000203', 1, '2026-03-28 17:00:07', '2026-03-28 17:00:07'),
(432, 1, 1, 0, 0, 1200, 0, 0.00, 0.00, '2026-03-28 20:00:07', 'Enter Money Bill', 229, 'ME-1-000229', 1, '2026-03-28 17:00:07', '2026-03-28 17:00:07'),
(433, 1, 1, 0, 880, 0, 0, 0.00, 0.00, '2026-03-29 16:20:49', 'Work Exit Bill', 204, 'SWSI-1-000204', 1, '2026-03-29 13:20:49', '2026-03-29 13:20:49'),
(434, 1, 1, 0, 0, 880, 0, 0.00, 0.00, '2026-03-29 16:20:49', 'Enter Money Bill', 230, 'ME-1-000230', 1, '2026-03-29 13:20:49', '2026-03-29 13:20:49'),
(435, 1, 1, 0, 6300, 0, 0, 0.00, 0.00, '2026-03-29 18:07:38', 'Work Exit Bill', 205, 'SWSI-1-000205', 1, '2026-03-29 15:07:38', '2026-03-29 15:07:38'),
(436, 1, 1, 0, 0, 6300, 0, 0.00, 0.00, '2026-03-29 18:07:38', 'Enter Money Bill', 231, 'ME-1-000231', 1, '2026-03-29 15:07:38', '2026-03-29 15:07:38'),
(437, 1, 1, 0, 1500, 0, 0, 0.00, 0.00, '2026-03-29 20:10:35', 'Work Exit Bill', 206, 'SWSI-1-000206', 1, '2026-03-29 17:10:35', '2026-03-29 17:10:35'),
(438, 1, 1, 0, 0, 1500, 0, 0.00, 0.00, '2026-03-29 20:10:35', 'Enter Money Bill', 232, 'ME-1-000232', 1, '2026-03-29 17:10:35', '2026-03-29 17:10:35'),
(439, 1, 1, 0, 1600, 0, 0, 0.00, 0.00, '2026-03-29 20:20:42', 'Work Exit Bill', 207, 'SWSI-1-000207', 1, '2026-03-29 17:20:42', '2026-03-29 17:20:42'),
(440, 1, 1, 0, 0, 1600, 0, 0.00, 0.00, '2026-03-29 20:20:42', 'Enter Money Bill', 233, 'ME-1-000233', 1, '2026-03-29 17:20:42', '2026-03-29 17:20:42'),
(441, 1, 1, 0, 1700, 0, 0, 0.00, 0.00, '2026-03-31 13:55:54', 'Work Exit Bill', 208, 'SWSI-1-000208', 1, '2026-03-31 10:55:54', '2026-03-31 10:55:54'),
(442, 1, 1, 0, 0, 1700, 0, 0.00, 0.00, '2026-03-31 13:55:54', 'Enter Money Bill', 234, 'ME-1-000234', 1, '2026-03-31 10:55:54', '2026-03-31 10:55:54'),
(443, 1, 1, 0, 800, 0, 0, 0.00, 0.00, '2026-03-31 16:36:34', 'Work Exit Bill', 209, 'SWSI-1-000209', 1, '2026-03-31 13:36:34', '2026-03-31 13:36:34'),
(444, 1, 1, 0, 0, 800, 0, 0.00, 0.00, '2026-03-31 16:36:34', 'Enter Money Bill', 235, 'ME-1-000235', 1, '2026-03-31 13:36:34', '2026-03-31 13:36:34'),
(445, 1, 1, 0, 1100, 0, 0, 0.00, 0.00, '2026-03-31 18:16:02', 'Work Exit Bill', 210, 'SWSI-1-000210', 1, '2026-03-31 15:16:02', '2026-03-31 15:16:02'),
(446, 1, 1, 0, 0, 1100, 0, 0.00, 0.00, '2026-03-31 18:16:02', 'Enter Money Bill', 236, 'ME-1-000236', 1, '2026-03-31 15:16:02', '2026-03-31 15:16:02'),
(447, 1, 1, 0, 1750, 0, 0, 0.00, 0.00, '2026-04-01 08:30:16', 'Work Exit Bill', 211, 'SWSI-1-000211', 1, '2026-04-01 05:30:16', '2026-04-01 05:30:16'),
(448, 1, 1, 0, 0, 1750, 0, 0.00, 0.00, '2026-04-01 08:30:16', 'Enter Money Bill', 237, 'ME-1-000237', 1, '2026-04-01 05:30:16', '2026-04-01 05:30:16'),
(449, 1, 1, 0, 3705, 0, 0, 0.00, 0.00, '2026-04-01 20:24:46', 'Work Exit Bill', 212, 'SWSI-1-000212', 1, '2026-04-01 17:24:46', '2026-04-01 17:24:46'),
(450, 1, 1, 0, 0, 3705, 0, 0.00, 0.00, '2026-04-01 20:24:46', 'Enter Money Bill', 238, 'ME-1-000238', 1, '2026-04-01 17:24:46', '2026-04-01 17:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount_percentage` decimal(8,2) NOT NULL,
  `sell_with_cost` tinyint(1) NOT NULL,
  `enable_discount` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `reason` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

CREATE TABLE `employers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `employer_category_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `additional_salary` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employer_categories`
--

CREATE TABLE `employer_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enter_money`
--

CREATE TABLE `enter_money` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `doc_number` varchar(191) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `based_on` int(11) NOT NULL,
  `based_on_bill_number` varchar(191) DEFAULT '',
  `notes` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enter_money`
--

INSERT INTO `enter_money` (`id`, `branch_id`, `doc_number`, `date`, `client_id`, `amount`, `payment_method`, `based_on`, `based_on_bill_number`, `notes`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'ME-1-000001', '2026-02-01 23:23:00', 1, 500.00, 1, 1, 'SWSI-1-000001', '', 1, '2026-02-01 17:24:00', '2026-02-01 17:24:00'),
(2, 1, 'ME-1-000002', '2026-02-03 21:04:00', 1, 950.00, 1, 2, 'SWSI-1-000002', '', 1, '2026-02-03 15:06:02', '2026-02-03 15:06:02'),
(3, 1, 'ME-1-000003', '2026-02-03 23:01:00', 1, 2600.00, 0, 3, 'SWSI-1-000003', '', 1, '2026-02-03 17:03:57', '2026-02-03 17:03:57'),
(4, 1, 'ME-1-000004', '2026-02-03 23:14:00', 1, 900.00, 0, 4, 'SWSI-1-000004', '', 1, '2026-02-03 17:15:53', '2026-02-03 17:15:53'),
(5, 1, 'ME-1-000005', '2026-02-03 23:16:00', 1, 1000.00, 0, 5, 'SWSI-1-000005', '', 1, '2026-02-03 17:17:48', '2026-02-03 17:17:48'),
(6, 1, 'ME-1-000006', '2026-02-04 17:25:00', 1, 1380.00, 1, 6, 'SWSI-1-000006', '', 1, '2026-02-04 11:26:21', '2026-02-04 11:26:21'),
(7, 1, 'ME-1-000007', '2026-02-04 17:27:00', 1, 4100.00, 0, 7, 'SWSI-1-000007', '', 1, '2026-02-04 11:27:28', '2026-02-04 11:27:28'),
(8, 1, 'ME-1-000008', '2026-02-04 20:32:00', 1, 3000.00, 0, 8, 'SWSI-1-000008', '', 1, '2026-02-04 14:33:13', '2026-02-04 14:33:13'),
(9, 1, 'ME-1-000009', '2026-02-04 20:32:00', 1, 3300.00, 1, 8, 'SWSI-1-000008', '', 1, '2026-02-04 14:33:13', '2026-02-04 14:33:13'),
(10, 1, 'ME-1-000010', '2026-02-04 21:38:00', 1, 1150.00, 0, 9, 'SWSI-1-000009', '', 1, '2026-02-04 15:39:11', '2026-02-04 15:39:11'),
(11, 1, 'ME-1-000011', '2026-02-05 22:19:00', 1, 3700.00, 1, 10, 'SWSI-1-000010', '', 1, '2026-02-05 16:19:02', '2026-02-05 16:19:02'),
(12, 1, 'ME-1-000012', '2026-02-05 22:48:00', 1, 2200.00, 1, 11, 'SWSI-1-000011', '', 1, '2026-02-05 16:48:01', '2026-02-05 16:48:01'),
(13, 1, 'ME-1-000013', '2026-02-06 17:55:00', 1, 2000.00, 0, 12, 'SWSI-1-000012', '', 1, '2026-02-06 11:55:36', '2026-02-06 11:55:36'),
(14, 1, 'ME-1-000014', '2026-02-06 17:55:00', 1, 3500.00, 1, 12, 'SWSI-1-000012', '', 1, '2026-02-06 11:55:36', '2026-02-06 11:55:36'),
(15, 1, 'ME-1-000015', '2026-02-06 21:43:00', 1, 2200.00, 1, 13, 'SWSI-1-000013', '', 1, '2026-02-06 15:43:11', '2026-02-06 15:43:11'),
(16, 1, 'ME-1-000016', '2026-02-06 22:19:00', 1, 1800.00, 0, 14, 'SWSI-1-000014', '', 1, '2026-02-06 16:19:35', '2026-02-06 16:19:35'),
(17, 1, 'ME-1-000017', '2026-02-07 21:17:00', 1, 32500.00, 0, 15, 'SWSI-1-000015', '', 1, '2026-02-07 15:22:15', '2026-02-07 15:22:15'),
(18, 1, 'ME-1-000018', '2026-02-08 17:56:00', 1, 3450.00, 1, 16, 'SWSI-1-000016', '', 1, '2026-02-08 11:57:28', '2026-02-08 11:57:28'),
(19, 1, 'ME-1-000019', '2026-02-08 18:00:00', 1, 3030.00, 0, 17, 'SWSI-1-000017', '', 1, '2026-02-08 13:50:10', '2026-02-08 13:50:10'),
(20, 1, 'ME-1-000020', '2026-02-09 19:11:00', 1, 2900.00, 0, 18, 'SWSI-1-000018', '', 1, '2026-02-09 13:10:57', '2026-02-09 13:10:57'),
(21, 1, 'ME-1-000021', '2026-02-09 19:21:00', 1, 1500.00, 0, 19, 'SWSI-1-000019', '', 1, '2026-02-09 13:22:03', '2026-02-09 13:22:03'),
(22, 1, 'ME-1-000022', '2026-02-09 19:26:00', 1, 2390.00, 0, 20, 'SWSI-1-000020', '', 1, '2026-02-09 13:26:32', '2026-02-09 13:26:32'),
(23, 1, 'ME-1-000023', '2026-02-10 18:15:00', 1, 9200.00, 1, 21, 'SWSI-1-000021', '', 1, '2026-02-10 12:15:26', '2026-02-10 12:15:26'),
(24, 1, 'ME-1-000024', '2026-02-11 19:21:00', 1, 850.00, 0, 22, 'SWSI-1-000022', '', 1, '2026-02-11 13:21:13', '2026-02-11 13:21:13'),
(25, 1, 'ME-1-000025', '2026-02-11 19:23:00', 1, 850.00, 0, 23, 'SWSI-1-000023', '', 1, '2026-02-11 13:23:42', '2026-02-11 13:23:42'),
(26, 1, 'ME-1-000026', '2026-02-11 21:23:00', 1, 3800.00, 1, 24, 'SWSI-1-000024', '', 1, '2026-02-11 15:26:05', '2026-02-11 15:26:05'),
(27, 1, 'ME-1-000027', '2026-02-11 21:27:00', 1, 3800.00, 1, 25, 'SWSI-1-000025', '', 1, '2026-02-11 15:28:05', '2026-02-11 15:28:05'),
(28, 1, 'ME-1-000028', '2026-02-11 21:30:00', 1, 2795.00, 1, 26, 'SWSI-1-000026', '', 1, '2026-02-11 15:30:40', '2026-02-11 15:30:40'),
(29, 1, 'ME-1-000029', '2026-02-11 22:25:00', 1, 1400.00, 0, 27, 'SWSI-1-000027', '', 1, '2026-02-11 16:25:57', '2026-02-11 16:25:57'),
(30, 1, 'ME-1-000030', '2026-02-11 22:46:00', 1, 750.00, 0, 28, 'SWSI-1-000028', '', 1, '2026-02-11 16:47:31', '2026-02-11 16:47:31'),
(31, 1, 'ME-1-000031', '2026-02-11 22:48:00', 1, 750.00, 0, 29, 'SWSI-1-000029', '', 1, '2026-02-11 16:49:10', '2026-02-11 16:49:10'),
(32, 1, 'ME-1-000032', '2026-02-11 22:53:00', 1, 1730.00, 0, 30, 'SWSI-1-000030', '', 1, '2026-02-11 16:53:50', '2026-02-11 16:53:50'),
(33, 1, 'ME-1-000033', '2026-02-11 23:20:00', 1, 11425.00, 1, 31, 'SWSI-1-000031', '', 1, '2026-02-11 17:23:11', '2026-02-11 17:23:11'),
(34, 1, 'ME-1-000034', '2026-02-11 23:25:00', 1, 1900.00, 1, 32, 'SWSI-1-000032', '', 1, '2026-02-11 17:25:04', '2026-02-11 17:25:04'),
(35, 1, 'ME-1-000035', '2026-02-12 19:19:00', 1, 2330.00, 1, 33, 'SWSI-1-000033', '', 1, '2026-02-12 13:20:19', '2026-02-12 13:20:19'),
(36, 1, 'ME-1-000036', '2026-02-12 21:01:00', 1, 650.00, 1, 34, 'SWSI-1-000034', '', 1, '2026-02-12 15:02:44', '2026-02-12 15:02:44'),
(37, 1, 'ME-1-000037', '2026-02-13 18:47:00', 1, 3975.00, 0, 35, 'SWSI-1-000035', '', 1, '2026-02-13 12:48:52', '2026-02-13 12:48:52'),
(38, 1, 'ME-1-000038', '2026-02-13 18:50:00', 1, 2775.00, 0, 36, 'SWSI-1-000036', '', 1, '2026-02-13 12:50:38', '2026-02-13 12:50:38'),
(39, 1, 'ME-1-000039', '2026-02-13 19:35:00', 1, 2800.00, 0, 37, 'SWSI-1-000037', '', 1, '2026-02-13 13:35:14', '2026-02-13 13:35:14'),
(40, 1, 'ME-1-000040', '2026-02-13 22:35:00', 1, 1200.00, 0, 38, 'SWSI-1-000038', '', 1, '2026-02-13 16:36:05', '2026-02-13 16:36:05'),
(41, 1, 'ME-1-000041', '2026-02-13 22:35:00', 1, 150.00, 1, 38, 'SWSI-1-000038', '', 1, '2026-02-13 16:36:05', '2026-02-13 16:36:05'),
(42, 1, 'ME-1-000042', '2026-02-14 17:30:00', 1, 3000.00, 0, 39, 'SWSI-1-000039', '', 1, '2026-02-14 11:30:05', '2026-02-14 11:30:05'),
(43, 1, 'ME-1-000043', '2026-02-14 20:24:00', 1, 580.00, 0, 40, 'SWSI-1-000040', '', 1, '2026-02-14 14:25:19', '2026-02-14 14:25:19'),
(44, 1, 'ME-1-000044', '2026-02-14 20:46:00', 1, 1250.00, 1, 41, 'SWSI-1-000041', '', 1, '2026-02-14 14:47:57', '2026-02-14 14:47:57'),
(45, 1, 'ME-1-000045', '2026-02-15 17:03:00', 1, 3150.00, 0, 42, 'SWSI-1-000042', '', 1, '2026-02-15 11:03:30', '2026-02-15 11:03:30'),
(46, 1, 'ME-1-000046', '2026-02-15 17:19:00', 1, 1600.00, 0, 43, 'SWSI-1-000043', '', 1, '2026-02-15 11:46:23', '2026-02-15 11:46:23'),
(47, 1, 'ME-1-000047', '2026-02-15 17:19:00', 1, 50.00, 1, 43, 'SWSI-1-000043', '', 1, '2026-02-15 11:46:23', '2026-02-15 11:46:23'),
(48, 1, 'ME-1-000048', '2026-02-15 21:58:00', 1, 2580.00, 1, 44, 'SWSI-1-000044', '', 1, '2026-02-15 15:58:17', '2026-02-15 15:58:17'),
(49, 1, 'ME-1-000049', '2026-02-15 22:45:00', 1, 1000.00, 0, 45, 'SWSI-1-000045', '', 1, '2026-02-15 16:48:50', '2026-02-15 16:48:50'),
(50, 1, 'ME-1-000050', '2026-02-16 17:41:00', 1, 25700.00, 0, 46, 'SWSI-1-000046', '', 1, '2026-02-16 11:42:35', '2026-02-16 11:42:35'),
(51, 1, 'ME-1-000051', '2026-02-17 18:18:00', 1, 3100.00, 0, 47, 'SWSI-1-000047', '', 1, '2026-02-17 12:18:40', '2026-02-17 12:18:40'),
(52, 1, 'ME-1-000052', '2026-02-17 19:26:00', 1, 1350.00, 0, 48, 'SWSI-1-000048', '', 1, '2026-02-17 13:26:03', '2026-02-17 13:26:03'),
(53, 1, 'ME-1-000053', '2026-02-18 23:31:00', 1, 600.00, 0, 49, 'SWSI-1-000049', '', 1, '2026-02-18 17:32:29', '2026-02-18 17:32:29'),
(54, 1, 'ME-1-000054', '2026-02-18 23:31:00', 1, 630.00, 1, 49, 'SWSI-1-000049', '', 1, '2026-02-18 17:32:29', '2026-02-18 17:32:29'),
(55, 1, 'ME-1-000055', '2026-02-20 01:08:00', 1, 4700.00, 0, 50, 'SWSI-1-000050', '', 1, '2026-02-19 19:09:15', '2026-02-19 19:09:15'),
(56, 1, 'ME-1-000056', '2026-02-20 23:33:00', 1, 7130.00, 0, 51, 'SWSI-1-000051', '', 1, '2026-02-20 17:35:14', '2026-02-20 17:35:14'),
(57, 1, 'ME-1-000057', '2026-02-20 23:33:00', 1, 150.00, 1, 51, 'SWSI-1-000051', '', 1, '2026-02-20 17:35:14', '2026-02-20 17:35:14'),
(58, 1, 'ME-1-000058', '2026-02-21 21:13:00', 1, 965.00, 0, 52, 'SWSI-1-000052', '', 1, '2026-02-21 15:13:42', '2026-02-21 15:13:42'),
(59, 1, 'ME-1-000059', '2026-02-21 21:41:00', 1, 1620.00, 0, 53, 'SWSI-1-000053', '', 1, '2026-02-21 15:41:20', '2026-02-21 15:41:20'),
(60, 1, 'ME-1-000060', '2026-02-22 21:41:00', 1, 1350.00, 0, 54, 'SWSI-1-000054', '', 1, '2026-02-22 15:41:17', '2026-02-22 15:41:17'),
(61, 1, 'ME-1-000061', '2026-02-23 00:49:00', 1, 650.00, 0, 55, 'SWSI-1-000055', '', 1, '2026-02-22 18:49:51', '2026-02-22 18:49:51'),
(62, 1, 'ME-1-000062', '2026-02-23 01:24:00', 1, 1720.00, 0, 56, 'SWSI-1-000056', '', 1, '2026-02-22 19:24:54', '2026-02-22 19:24:54'),
(63, 1, 'ME-1-000063', '2026-02-23 01:24:00', 1, 150.00, 1, 56, 'SWSI-1-000056', '', 1, '2026-02-22 19:24:54', '2026-02-22 19:24:54'),
(64, 1, 'ME-1-000064', '2026-02-23 17:23:00', 1, 1850.00, 0, 57, 'SWSI-1-000057', '', 1, '2026-02-23 11:22:54', '2026-02-23 11:22:54'),
(65, 1, 'ME-1-000065', '2026-02-24 00:24:00', 1, 2020.00, 0, 58, 'SWSI-1-000058', '', 1, '2026-02-23 18:24:18', '2026-02-23 18:24:18'),
(66, 1, 'ME-1-000066', '2026-02-24 01:42:00', 1, 12040.00, 0, 59, 'SWSI-1-000059', '', 1, '2026-02-23 19:47:15', '2026-02-23 19:47:15'),
(67, 1, 'ME-1-000067', '2026-02-24 01:42:00', 1, 2400.00, 1, 59, 'SWSI-1-000059', '', 1, '2026-02-23 19:47:15', '2026-02-23 19:47:15'),
(68, 1, 'ME-1-000068', '2026-02-24 22:18:00', 1, 2300.00, 1, 60, 'SWSI-1-000060', '', 1, '2026-02-24 16:17:33', '2026-02-24 16:17:33'),
(69, 1, 'ME-1-000069', '2026-02-24 23:44:00', 1, 870.00, 0, 61, 'SWSI-1-000061', '', 1, '2026-02-24 17:44:58', '2026-02-24 17:44:58'),
(70, 1, 'ME-1-000070', '2026-02-25 21:02:00', 1, 1100.00, 0, 62, 'SWSI-1-000062', '', 1, '2026-02-25 15:24:14', '2026-02-25 15:24:14'),
(71, 1, 'ME-1-000071', '2026-02-25 22:53:00', 1, 2200.00, 1, 63, 'SWSI-1-000063', '', 1, '2026-02-25 16:53:52', '2026-02-25 16:53:52'),
(72, 1, 'ME-1-000072', '2026-02-25 23:02:00', 1, 800.00, 1, 64, 'SWSI-1-000064', '', 1, '2026-02-25 17:01:55', '2026-02-25 17:01:55'),
(73, 1, 'ME-1-000073', '2026-02-26 23:21:00', 1, 100.00, 0, 65, 'SWSI-1-000065', '', 1, '2026-02-26 17:22:10', '2026-02-26 17:22:10'),
(74, 1, 'ME-1-000074', '2026-02-26 23:21:00', 1, 3000.00, 1, 65, 'SWSI-1-000065', '', 1, '2026-02-26 17:22:10', '2026-02-26 17:22:10'),
(75, 1, 'ME-1-000075', '2026-02-26 23:32:00', 1, 630.00, 1, 66, 'SWSI-1-000066', '', 1, '2026-02-26 17:32:45', '2026-02-26 17:32:45'),
(76, 1, 'ME-1-000076', '2026-02-27 21:17:00', 1, 920.00, 1, 67, 'SWSI-1-000067', '', 1, '2026-02-27 15:18:07', '2026-02-27 15:18:07'),
(77, 1, 'ME-1-000077', '2026-02-27 21:34:00', 1, 1540.00, 0, 68, 'SWSI-1-000068', '', 1, '2026-02-27 15:34:36', '2026-02-27 15:34:36'),
(78, 1, 'ME-1-000078', '2026-02-27 22:24:00', 1, 11770.00, 0, 69, 'SWSI-1-000069', '', 1, '2026-02-27 16:24:18', '2026-02-27 16:24:18'),
(79, 1, 'ME-1-000079', '2026-02-27 22:24:00', 1, 2000.00, 1, 69, 'SWSI-1-000069', '', 1, '2026-02-27 16:24:18', '2026-02-27 16:24:18'),
(80, 1, 'ME-1-000080', '2026-02-28 00:28:00', 1, 750.00, 1, 70, 'SWSI-1-000070', '', 1, '2026-02-27 18:27:33', '2026-02-27 18:27:33'),
(81, 1, 'ME-1-000081', '2026-02-28 00:37:00', 1, 1400.00, 1, 71, 'SWSI-1-000071', '', 1, '2026-02-27 18:37:28', '2026-02-27 18:37:28'),
(82, 1, 'ME-1-000082', '2026-02-28 00:54:00', 1, 600.00, 0, 72, 'SWSI-1-000072', '', 1, '2026-02-27 18:53:55', '2026-02-27 18:53:55'),
(83, 1, 'ME-1-000083', '2026-02-28 00:54:00', 1, 3000.00, 1, 72, 'SWSI-1-000072', '', 1, '2026-02-27 18:53:55', '2026-02-27 18:53:55'),
(84, 1, 'ME-1-000084', '2026-02-28 22:01:00', 1, 550.00, 0, 73, 'SWSI-1-000073', '', 1, '2026-02-28 16:01:00', '2026-02-28 16:01:00'),
(85, 1, 'ME-1-000085', '2026-02-28 23:17:00', 1, 3450.00, 0, 74, 'SWSI-1-000074', '', 1, '2026-02-28 17:17:15', '2026-02-28 17:17:15'),
(86, 1, 'ME-1-000086', '2026-03-01 21:19:00', 1, 14000.00, 0, 75, 'SWSI-1-000075', '', 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(87, 1, 'ME-1-000087', '2026-03-01 21:19:00', 1, 650.00, 1, 75, 'SWSI-1-000075', '', 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(88, 1, 'ME-1-000088', '2026-03-01 22:38:00', 1, 1420.00, 0, 76, 'SWSI-1-000076', '', 1, '2026-03-01 16:38:14', '2026-03-01 16:38:14'),
(89, 1, 'ME-1-000089', '2026-03-01 23:14:00', 1, 1600.00, 0, 77, 'SWSI-1-000077', '', 1, '2026-03-01 17:13:38', '2026-03-01 17:13:38'),
(90, 1, 'ME-1-000090', '2026-03-01 23:39:00', 1, 3930.00, 0, 78, 'SWSI-1-000078', '', 1, '2026-03-01 17:39:09', '2026-03-01 17:39:09'),
(91, 1, 'ME-1-000091', '2026-03-02 01:00:00', 1, 950.00, 0, 79, 'SWSI-1-000079', '', 1, '2026-03-01 18:59:59', '2026-03-01 18:59:59'),
(92, 1, 'ME-1-000092', '2026-03-02 01:10:00', 1, 980.00, 0, 80, 'SWSI-1-000080', '', 1, '2026-03-01 19:10:20', '2026-03-01 19:10:20'),
(93, 1, 'ME-1-000093', '2026-03-02 01:13:00', 1, 1300.00, 0, 81, 'SWSI-1-000081', '', 1, '2026-03-01 19:12:50', '2026-03-01 19:12:50'),
(94, 1, 'ME-1-000094', '2026-03-02 01:20:00', 1, 4535.00, 0, 82, 'SWSI-1-000082', '', 1, '2026-03-01 19:19:38', '2026-03-01 19:19:38'),
(95, 1, 'ME-1-000095', '2026-03-02 01:40:00', 1, 1100.00, 1, 83, 'SWSI-1-000083', '', 1, '2026-03-01 19:40:12', '2026-03-01 19:40:12'),
(96, 1, 'ME-1-000096', '2026-03-03 00:12:00', 1, 830.00, 1, 84, 'SWSI-1-000084', '', 1, '2026-03-02 18:13:48', '2026-03-02 18:13:48'),
(97, 1, 'ME-1-000097', '2026-03-03 00:14:00', 1, 8600.00, 0, 85, 'SWSI-1-000085', '', 1, '2026-03-02 18:17:13', '2026-03-02 18:17:13'),
(98, 1, 'ME-1-000098', '2026-03-03 16:53:00', 1, 2800.00, 0, 86, 'SWSI-1-000086', '', 1, '2026-03-03 10:55:57', '2026-03-03 10:55:57'),
(99, 1, 'ME-1-000099', '2026-03-03 16:56:00', 1, 2150.00, 0, 87, 'SWSI-1-000087', '', 1, '2026-03-03 10:57:40', '2026-03-03 10:57:40'),
(100, 1, 'ME-1-000100', '2026-03-03 21:12:00', 1, 290.00, 0, 88, 'SWSI-1-000088', '', 1, '2026-03-03 15:12:36', '2026-03-03 15:12:36'),
(101, 1, 'ME-1-000101', '2026-03-03 21:12:00', 1, 500.00, 1, 88, 'SWSI-1-000088', '', 1, '2026-03-03 15:12:36', '2026-03-03 15:12:36'),
(102, 1, 'ME-1-000102', '2026-03-04 00:30:00', 1, 42000.00, 0, 89, 'SWSI-1-000089', '', 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(103, 1, 'ME-1-000103', '2026-03-04 01:25:00', 1, 3100.00, 1, 90, 'SWSI-1-000090', '', 1, '2026-03-03 19:29:50', '2026-03-03 19:29:50'),
(104, 1, 'ME-1-000104', '2026-03-04 01:30:00', 1, 5350.00, 0, 91, 'SWSI-1-000091', '', 1, '2026-03-03 19:31:19', '2026-03-03 19:31:19'),
(105, 1, 'ME-1-000105', '2026-03-04 02:10:00', 1, 1550.00, 1, 92, 'SWSI-1-000092', '', 1, '2026-03-03 20:11:27', '2026-03-03 20:11:27'),
(106, 1, 'ME-1-000106', '2026-03-04 07:19:00', 1, 7400.00, 1, 93, 'SWSI-1-000093', '', 1, '2026-03-04 01:20:24', '2026-03-04 01:20:24'),
(107, 1, 'ME-1-000107', '2026-03-04 22:38:00', 1, 31100.00, 0, 94, 'SWSI-1-000094', '', 1, '2026-03-04 16:39:19', '2026-03-04 16:39:19'),
(108, 1, 'ME-1-000108', '2026-03-04 23:24:00', 1, 4450.00, 1, 95, 'SWSI-1-000095', '', 1, '2026-03-04 17:30:40', '2026-03-04 17:30:40'),
(109, 1, 'ME-1-000109', '2026-03-04 23:37:00', 1, 7700.00, 0, 96, 'SWSI-1-000096', '', 1, '2026-03-04 17:37:38', '2026-03-04 17:37:38'),
(110, 1, 'ME-1-000110', '2026-03-05 22:26:00', 1, 1550.00, 0, 97, 'SWSI-1-000097', '', 1, '2026-03-05 16:26:39', '2026-03-05 16:26:39'),
(111, 1, 'ME-1-000111', '2026-03-05 22:53:00', 1, 400.00, 0, 98, 'SWSI-1-000098', '', 1, '2026-03-05 16:54:35', '2026-03-05 16:54:35'),
(112, 1, 'ME-1-000112', '2026-03-05 23:43:00', 1, 840.00, 0, 99, 'SWSI-1-000099', '', 1, '2026-03-05 17:44:17', '2026-03-05 17:44:17'),
(113, 1, 'ME-1-000113', '2026-03-06 00:10:00', 1, 4450.00, 1, 100, 'SWSI-1-000100', '', 1, '2026-03-05 18:11:24', '2026-03-05 18:11:24'),
(114, 1, 'ME-1-000114', '2026-03-06 00:20:00', 1, 550.00, 0, 101, 'SWSI-1-000101', '', 1, '2026-03-05 18:20:48', '2026-03-05 18:20:48'),
(115, 1, 'ME-1-000115', '2026-03-06 02:00:00', 1, 750.00, 1, 102, 'SWSI-1-000102', '', 1, '2026-03-05 20:00:42', '2026-03-05 20:00:42'),
(116, 1, 'ME-1-000116', '2026-03-06 21:11:00', 1, 11300.00, 0, 103, 'SWSI-1-000103', '', 1, '2026-03-06 15:13:00', '2026-03-06 15:13:00'),
(117, 1, 'ME-1-000117', '2026-03-06 21:11:00', 1, 650.00, 1, 103, 'SWSI-1-000103', '', 1, '2026-03-06 15:13:00', '2026-03-06 15:13:00'),
(118, 1, 'ME-1-000118', '2026-03-06 21:16:00', 1, 800.00, 1, 104, 'SWSI-1-000104', '', 1, '2026-03-06 15:17:32', '2026-03-06 15:17:32'),
(119, 1, 'ME-1-000119', '2026-03-06 22:44:00', 1, 1550.00, 0, 105, 'SWSI-1-000105', '', 1, '2026-03-06 16:44:47', '2026-03-06 16:44:47'),
(120, 1, 'ME-1-000120', '2026-03-06 23:08:00', 1, 1200.00, 0, 106, 'SWSI-1-000106', '', 1, '2026-03-06 17:09:17', '2026-03-06 17:09:17'),
(121, 1, 'ME-1-000121', '2026-03-07 00:03:00', 1, 1930.00, 1, 107, 'SWSI-1-000107', '', 1, '2026-03-06 18:05:08', '2026-03-06 18:05:08'),
(122, 1, 'ME-1-000122', '2026-03-07 00:07:00', 1, 5500.00, 0, 108, 'SWSI-1-000108', '', 1, '2026-03-06 18:07:48', '2026-03-06 18:07:48'),
(123, 1, 'ME-1-000123', '2026-03-07 00:08:00', 1, 5000.00, 0, 109, 'SWSI-1-000109', '', 1, '2026-03-06 18:09:07', '2026-03-06 18:09:07'),
(124, 1, 'ME-1-000124', '2026-03-07 00:26:00', 1, 16650.00, 0, 110, 'SWSI-1-000110', '', 1, '2026-03-06 18:26:35', '2026-03-06 18:26:35'),
(125, 1, 'ME-1-000125', '2026-03-07 08:08:00', 1, 6000.00, 0, 111, 'SWSI-1-000111', '', 1, '2026-03-07 02:19:52', '2026-03-07 02:19:52'),
(126, 1, 'ME-1-000126', '2026-03-07 08:08:00', 1, 3500.00, 1, 111, 'SWSI-1-000111', '', 1, '2026-03-07 02:19:52', '2026-03-07 02:19:52'),
(127, 1, 'ME-1-000127', '2026-03-07 21:13:00', 1, 1500.00, 0, 112, 'SWSI-1-000112', '', 1, '2026-03-07 15:13:45', '2026-03-07 15:13:45'),
(128, 1, 'ME-1-000128', '2026-03-07 21:25:00', 1, 6450.00, 0, 113, 'SWSI-1-000113', '', 1, '2026-03-07 15:26:02', '2026-03-07 15:26:02'),
(129, 1, 'ME-1-000129', '2026-03-07 21:51:00', 1, 1500.00, 1, 114, 'SWSI-1-000114', '', 1, '2026-03-07 15:52:09', '2026-03-07 15:52:09'),
(130, 1, 'ME-1-000130', '2026-03-08 00:07:00', 1, 3400.00, 0, 115, 'SWSI-1-000115', '', 1, '2026-03-07 18:08:46', '2026-03-07 18:08:46'),
(131, 1, 'ME-1-000131', '2026-03-08 00:07:00', 1, 2300.00, 1, 115, 'SWSI-1-000115', '', 1, '2026-03-07 18:08:46', '2026-03-07 18:08:46'),
(132, 1, 'ME-1-000132', '2026-03-08 00:27:00', 1, 1620.00, 0, 116, 'SWSI-1-000116', '', 1, '2026-03-07 18:28:29', '2026-03-07 18:28:29'),
(133, 1, 'ME-1-000133', '2026-03-08 00:30:00', 1, 10800.00, 0, 117, 'SWSI-1-000117', '', 1, '2026-03-07 18:30:40', '2026-03-07 18:30:40'),
(134, 1, 'ME-1-000134', '2026-03-08 02:15:00', 1, 1980.00, 0, 118, 'SWSI-1-000118', '', 1, '2026-03-07 20:16:10', '2026-03-07 20:16:10'),
(135, 1, 'ME-1-000135', '2026-03-08 17:06:00', 1, 2230.00, 1, 119, 'SWSI-1-000119', '', 1, '2026-03-08 11:07:29', '2026-03-08 11:07:29'),
(136, 1, 'ME-1-000136', '2026-03-08 21:30:00', 1, 680.00, 0, 120, 'SWSI-1-000120', '', 1, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(137, 1, 'ME-1-000137', '2026-03-08 21:30:00', 1, 8240.00, 1, 120, 'SWSI-1-000120', '', 1, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(138, 1, 'ME-1-000138', '2026-03-08 22:18:00', 1, 10170.00, 0, 121, 'SWSI-1-000121', '', 1, '2026-03-08 16:19:15', '2026-03-08 16:19:15'),
(139, 1, 'ME-1-000139', '2026-03-08 22:19:00', 1, 18900.00, 0, 122, 'SWSI-1-000122', '', 1, '2026-03-08 16:21:09', '2026-03-08 16:21:09'),
(140, 1, 'ME-1-000140', '2026-03-08 22:54:00', 1, 2400.00, 0, 123, 'SWSI-1-000123', '', 1, '2026-03-08 16:55:00', '2026-03-08 16:55:00'),
(141, 1, 'ME-1-000141', '2026-03-08 22:54:00', 1, 6400.00, 1, 123, 'SWSI-1-000123', '', 1, '2026-03-08 16:55:00', '2026-03-08 16:55:00'),
(142, 1, 'ME-1-000142', '2026-03-09 00:30:00', 1, 3000.00, 0, 124, 'SWSI-1-000124', '', 1, '2026-03-08 18:31:58', '2026-03-08 18:31:58'),
(143, 1, 'ME-1-000143', '2026-03-09 00:30:00', 1, 12500.00, 1, 124, 'SWSI-1-000124', '', 1, '2026-03-08 18:31:58', '2026-03-08 18:31:58'),
(144, 1, 'ME-1-000144', '2026-03-09 02:06:00', 1, 5100.00, 1, 125, 'SWSI-1-000125', '', 1, '2026-03-08 20:07:08', '2026-03-08 20:07:08'),
(145, 1, 'ME-1-000145', '2026-03-09 02:08:00', 1, 1130.00, 0, 126, 'SWSI-1-000126', '', 1, '2026-03-08 20:09:20', '2026-03-08 20:09:20'),
(146, 1, 'ME-1-000146', '2026-03-09 02:18:00', 1, 1810.00, 0, 127, 'SWSI-1-000127', '', 1, '2026-03-08 20:19:03', '2026-03-08 20:19:03'),
(147, 1, 'ME-1-000147', '2026-03-09 17:23:00', 1, 1040.00, 0, 128, 'SWSI-1-000128', '', 1, '2026-03-09 11:24:17', '2026-03-09 11:24:17'),
(148, 1, 'ME-1-000148', '2026-03-11 21:53:00', 1, 910.00, 0, 129, 'SWSI-1-000129', '', 1, '2026-03-11 15:54:42', '2026-03-11 15:54:42'),
(149, 1, 'ME-1-000149', '2026-03-11 22:00:00', 1, 7080.00, 0, 130, 'SWSI-1-000130', '', 1, '2026-03-11 16:00:43', '2026-03-11 16:00:43'),
(150, 1, 'ME-1-000150', '2026-03-11 23:34:00', 1, 2210.00, 0, 131, 'SWSI-1-000131', '', 1, '2026-03-11 17:35:50', '2026-03-11 17:35:50'),
(151, 1, 'ME-1-000151', '2026-03-11 23:37:00', 1, 550.00, 0, 132, 'SWSI-1-000132', '', 1, '2026-03-11 17:37:44', '2026-03-11 17:37:44'),
(152, 1, 'ME-1-000152', '2026-03-12 07:39:00', 1, 1000.00, 1, 133, 'SWSI-1-000133', '', 1, '2026-03-12 01:40:19', '2026-03-12 01:40:19'),
(153, 1, 'ME-1-000153', '2026-03-12 21:37:00', 1, 1150.00, 1, 134, 'SWSI-1-000134', '', 1, '2026-03-12 15:38:38', '2026-03-12 15:38:38'),
(154, 1, 'ME-1-000154', '2026-03-12 21:39:00', 1, 1250.00, 1, 135, 'SWSI-1-000135', '', 1, '2026-03-12 15:39:42', '2026-03-12 15:39:42'),
(155, 1, 'ME-1-000155', '2026-03-12 22:46:00', 1, 1000.00, 0, 136, 'SWSI-1-000136', '', 1, '2026-03-12 16:46:40', '2026-03-12 16:46:40'),
(156, 1, 'ME-1-000156', '2026-03-12 23:48:00', 1, 1290.00, 0, 137, 'SWSI-1-000137', '', 1, '2026-03-12 17:49:31', '2026-03-12 17:49:31'),
(157, 1, 'ME-1-000157', '2026-03-13 00:36:00', 1, 1700.00, 0, 138, 'SWSI-1-000138', '', 1, '2026-03-12 18:36:50', '2026-03-12 18:36:50'),
(158, 1, 'ME-1-000158', '2026-03-13 02:03:00', 1, 1100.00, 0, 139, 'SWSI-1-000139', '', 1, '2026-03-12 20:03:54', '2026-03-12 20:03:54'),
(159, 1, 'ME-1-000159', '2026-03-13 07:34:00', 1, 1000.00, 0, 140, 'SWSI-1-000140', '', 1, '2026-03-13 01:34:34', '2026-03-13 01:34:34'),
(160, 1, 'ME-1-000160', '2026-03-13 07:34:00', 1, 980.00, 1, 140, 'SWSI-1-000140', '', 1, '2026-03-13 01:34:34', '2026-03-13 01:34:34'),
(161, 1, 'ME-1-000161', '2026-03-13 21:33:00', 1, 7600.00, 0, 141, 'SWSI-1-000141', '', 1, '2026-03-13 15:34:13', '2026-03-13 15:34:13'),
(162, 1, 'ME-1-000162', '2026-03-13 22:32:00', 1, 1800.00, 1, 142, 'SWSI-1-000142', '', 1, '2026-03-13 16:33:09', '2026-03-13 16:33:09'),
(163, 1, 'ME-1-000163', '2026-03-13 22:49:00', 1, 1700.00, 0, 143, 'SWSI-1-000143', '', 1, '2026-03-13 16:49:34', '2026-03-13 16:49:34'),
(164, 1, 'ME-1-000164', '2026-03-13 23:02:00', 1, 600.00, 0, 144, 'SWSI-1-000144', '', 1, '2026-03-13 17:03:23', '2026-03-13 17:03:23'),
(165, 1, 'ME-1-000165', '2026-03-13 23:38:00', 1, 1070.00, 1, 145, 'SWSI-1-000145', '', 1, '2026-03-13 17:39:23', '2026-03-13 17:39:23'),
(166, 1, 'ME-1-000166', '2026-03-14 00:18:00', 1, 300.00, 1, 146, 'SWSI-1-000146', '', 1, '2026-03-13 18:18:59', '2026-03-13 18:18:59'),
(167, 1, 'ME-1-000167', '2026-03-14 00:49:00', 1, 1700.00, 0, 147, 'SWSI-1-000147', '', 1, '2026-03-13 18:50:15', '2026-03-13 18:50:15'),
(168, 1, 'ME-1-000168', '2026-03-14 02:49:00', 1, 2670.00, 0, 148, 'SWSI-1-000148', '', 1, '2026-03-13 20:52:01', '2026-03-13 20:52:01'),
(169, 1, 'ME-1-000169', '2026-03-14 06:00:00', 1, 7300.00, 1, 149, 'SWSI-1-000149', '', 1, '2026-03-14 00:01:22', '2026-03-14 00:01:22'),
(170, 1, 'ME-1-000170', '2026-03-14 07:55:00', 1, 2550.00, 1, 150, 'SWSI-1-000150', '', 1, '2026-03-14 01:55:57', '2026-03-14 01:55:57'),
(171, 1, 'ME-1-000171', '2026-03-14 21:55:00', 1, 1500.00, 0, 151, 'SWSI-1-000151', '', 1, '2026-03-14 15:57:48', '2026-03-14 15:57:48'),
(172, 1, 'ME-1-000172', '2026-03-14 21:58:00', 1, 1000.00, 1, 152, 'SWSI-1-000152', '', 1, '2026-03-14 15:59:16', '2026-03-14 15:59:16'),
(173, 1, 'ME-1-000173', '2026-03-14 22:09:00', 1, 3100.00, 1, 153, 'SWSI-1-000153', '', 1, '2026-03-14 16:10:06', '2026-03-14 16:10:06'),
(174, 1, 'ME-1-000174', '2026-03-14 22:54:00', 1, 950.00, 0, 154, 'SWSI-1-000154', '', 1, '2026-03-14 16:55:05', '2026-03-14 16:55:05'),
(175, 1, 'ME-1-000175', '2026-03-15 01:53:00', 1, 2600.00, 0, 155, 'SWSI-1-000155', '', 1, '2026-03-14 19:54:02', '2026-03-14 19:54:02'),
(176, 1, 'ME-1-000176', '2026-03-15 02:03:00', 1, 900.00, 0, 156, 'SWSI-1-000156', '', 1, '2026-03-14 20:04:37', '2026-03-14 20:04:37'),
(177, 1, 'ME-1-000177', '2026-03-15 07:49:00', 1, 1950.00, 0, 157, 'SWSI-1-000157', '', 1, '2026-03-15 01:50:38', '2026-03-15 01:50:38'),
(178, 1, 'ME-1-000178', '2026-03-15 17:11:00', 1, 2550.00, 0, 158, 'SWSI-1-000158', '', 1, '2026-03-15 11:13:18', '2026-03-15 11:13:18'),
(179, 1, 'ME-1-000179', '2026-03-15 17:34:00', 1, 800.00, 0, 159, 'SWSI-1-000159', '', 1, '2026-03-15 11:34:52', '2026-03-15 11:34:52'),
(180, 1, 'ME-1-000180', '2026-03-15 22:45:00', 1, 5500.00, 0, 160, 'SWSI-1-000160', '', 1, '2026-03-15 16:50:15', '2026-03-15 16:50:15'),
(181, 1, 'ME-1-000181', '2026-03-15 23:57:00', 1, 2300.00, 0, 161, 'SWSI-1-000161', '', 1, '2026-03-15 19:17:25', '2026-03-15 19:17:25'),
(182, 1, 'ME-1-000182', '2026-03-16 07:39:00', 1, 1445.00, 0, 162, 'SWSI-1-000162', '', 1, '2026-03-16 01:39:44', '2026-03-16 01:39:44'),
(183, 1, 'ME-1-000183', '2026-03-16 17:03:00', 1, 4300.00, 0, 163, 'SWSI-1-000163', '', 1, '2026-03-16 11:04:34', '2026-03-16 11:04:34'),
(184, 1, 'ME-1-000184', '2026-03-17 02:06:00', 1, 575.00, 0, 164, 'SWSI-1-000164', '', 1, '2026-03-16 20:07:04', '2026-03-16 20:07:04'),
(185, 1, 'ME-1-000185', '2026-03-18 01:13:00', 1, 6850.00, 1, 165, 'SWSI-1-000165', '', 1, '2026-03-17 19:14:39', '2026-03-17 19:14:39'),
(186, 1, 'ME-1-000186', '2026-03-18 01:40:00', 1, 1800.00, 1, 166, 'SWSI-1-000166', '', 1, '2026-03-17 19:41:21', '2026-03-17 19:41:21'),
(187, 1, 'ME-1-000187', '2026-03-18 08:33:00', 1, 6500.00, 1, 167, 'SWSI-1-000167', '', 1, '2026-03-18 02:36:33', '2026-03-18 02:36:33'),
(188, 1, 'ME-1-000188', '2026-03-18 22:29:00', 1, 200.00, 0, 168, 'SWSI-1-000168', '', 1, '2026-03-18 16:30:10', '2026-03-18 16:30:10'),
(189, 1, 'ME-1-000189', '2026-03-18 22:29:00', 1, 2000.00, 1, 168, 'SWSI-1-000168', '', 1, '2026-03-18 16:30:10', '2026-03-18 16:30:10'),
(190, 1, 'ME-1-000190', '2026-03-18 22:30:00', 1, 900.00, 1, 169, 'SWSI-1-000169', '', 1, '2026-03-18 16:30:51', '2026-03-18 16:30:51'),
(191, 1, 'ME-1-000191', '2026-03-18 23:42:00', 1, 850.00, 1, 170, 'SWSI-1-000170', '', 1, '2026-03-18 17:43:09', '2026-03-18 17:43:09'),
(192, 1, 'ME-1-000192', '2026-03-18 23:57:00', 1, 1980.00, 0, 171, 'SWSI-1-000171', '', 1, '2026-03-18 17:57:54', '2026-03-18 17:57:54'),
(193, 1, 'ME-1-000193', '2026-03-19 00:20:00', 1, 28900.00, 0, 172, 'SWSI-1-000172', '', 1, '2026-03-18 18:22:46', '2026-03-18 18:22:46'),
(194, 1, 'ME-1-000194', '2026-03-19 01:13:00', 1, 1270.00, 0, 173, 'SWSI-1-000173', '', 1, '2026-03-18 19:13:21', '2026-03-18 19:13:21'),
(195, 1, 'ME-1-000195', '2026-03-19 02:01:00', 1, 860.00, 0, 174, 'SWSI-1-000174', '', 1, '2026-03-18 20:01:45', '2026-03-18 20:01:45'),
(196, 1, 'ME-1-000196', '2026-03-19 22:49:00', 1, 1700.00, 0, 175, 'SWSI-1-000175', '', 1, '2026-03-19 16:50:02', '2026-03-19 16:50:02'),
(197, 1, 'ME-1-000197', '2026-03-23 18:31:00', 1, 2100.00, 0, 176, 'SWSI-1-000176', '', 1, '2026-03-23 12:32:35', '2026-03-23 12:32:35'),
(198, 1, 'ME-1-000198', '2026-03-23 19:58:00', 1, 1375.00, 1, 177, 'SWSI-1-000177', '', 1, '2026-03-23 13:59:10', '2026-03-23 13:59:10'),
(199, 1, 'ME-1-000199', '2026-03-23 22:58:00', 1, 1395.00, 0, 178, 'SWSI-1-000178', '', 1, '2026-03-23 16:58:42', '2026-03-23 16:58:42'),
(200, 1, 'ME-1-000200', '2026-03-23 23:23:00', 1, 9100.00, 0, 179, 'SWSI-1-000179', '', 1, '2026-03-23 17:26:19', '2026-03-23 17:26:19'),
(201, 1, 'ME-1-000201', '2026-03-24 10:41:00', 1, 1000.00, 0, 180, 'SWSI-1-000180', '', 1, '2026-03-24 04:42:14', '2026-03-24 04:42:14'),
(202, 1, 'ME-1-000202', '2026-03-24 10:41:00', 1, 520.00, 1, 180, 'SWSI-1-000180', '', 1, '2026-03-24 04:42:14', '2026-03-24 04:42:14'),
(203, 1, 'ME-1-000203', '2026-03-24 17:44:00', 1, 3005.00, 0, 181, 'SWSI-1-000181', '', 1, '2026-03-24 11:46:43', '2026-03-24 11:46:43'),
(204, 1, 'ME-1-000204', '2026-03-24 19:36:00', 1, 900.00, 0, 182, 'SWSI-1-000182', '', 1, '2026-03-24 13:37:41', '2026-03-24 13:37:41'),
(205, 1, 'ME-1-000205', '2026-03-24 21:52:00', 1, 1650.00, 0, 183, 'SWSI-1-000183', '', 1, '2026-03-24 15:53:22', '2026-03-24 15:53:22'),
(206, 1, 'ME-1-000206', '2026-03-24 22:01:00', 1, 10340.00, 0, 184, 'SWSI-1-000184', '', 1, '2026-03-24 16:02:13', '2026-03-24 16:02:13'),
(207, 1, 'ME-1-000207', '2026-03-24 22:01:00', 1, 1860.00, 1, 184, 'SWSI-1-000184', '', 1, '2026-03-24 16:02:13', '2026-03-24 16:02:13'),
(208, 1, 'ME-1-000208', '2026-03-24 22:40:00', 1, 860.00, 0, 185, 'SWSI-1-000185', '', 1, '2026-03-24 16:40:32', '2026-03-24 16:40:32'),
(209, 1, 'ME-1-000209', '2026-03-25 18:31:00', 1, 2760.00, 0, 186, 'SWSI-1-000186', '', 1, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(210, 1, 'ME-1-000210', '2026-03-25 18:31:00', 1, 22610.00, 1, 186, 'SWSI-1-000186', '', 1, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(211, 1, 'ME-1-000211', '2026-03-25 21:12:00', 1, 1400.00, 0, 187, 'SWSI-1-000187', '', 1, '2026-03-25 15:12:41', '2026-03-25 15:12:41'),
(212, 1, 'ME-1-000212', '2026-03-25 23:26:00', 1, 620.00, 0, 188, 'SWSI-1-000188', '', 1, '2026-03-25 17:28:06', '2026-03-25 17:28:06'),
(213, 1, 'ME-1-000213', '2026-03-26 20:59:00', 1, 1075.00, 0, 189, 'SWSI-1-000189', '', 1, '2026-03-26 14:59:41', '2026-03-26 14:59:41'),
(214, 1, 'ME-1-000214', '2026-03-26 21:50:00', 1, 600.00, 0, 190, 'SWSI-1-000190', '', 1, '2026-03-26 15:50:36', '2026-03-26 15:50:36'),
(215, 1, 'ME-1-000215', '2026-03-26 21:50:00', 1, 50.00, 1, 190, 'SWSI-1-000190', '', 1, '2026-03-26 15:50:36', '2026-03-26 15:50:36'),
(216, 1, 'ME-1-000216', '2026-03-26 21:55:00', 1, 1600.00, 0, 191, 'SWSI-1-000191', '', 1, '2026-03-26 15:56:18', '2026-03-26 15:56:18'),
(217, 1, 'ME-1-000217', '2026-03-26 22:58:00', 1, 2150.00, 0, 192, 'SWSI-1-000192', '', 1, '2026-03-26 16:58:35', '2026-03-26 16:58:35'),
(218, 1, 'ME-1-000218', '2026-03-27 17:28:00', 1, 8100.00, 1, 193, 'SWSI-1-000193', '', 1, '2026-03-27 11:28:24', '2026-03-27 11:28:24'),
(219, 1, 'ME-1-000219', '2026-03-27 17:30:00', 1, 1050.00, 0, 194, 'SWSI-1-000194', '', 1, '2026-03-27 11:33:24', '2026-03-27 11:33:24'),
(220, 1, 'ME-1-000220', '2026-03-27 21:24:00', 1, 1600.00, 0, 195, 'SWSI-1-000195', '', 1, '2026-03-27 15:24:44', '2026-03-27 15:24:44'),
(221, 1, 'ME-1-000221', '2026-03-27 22:05:00', 1, 650.00, 0, 196, 'SWSI-1-000196', '', 1, '2026-03-27 16:05:47', '2026-03-27 16:05:47'),
(222, 1, 'ME-1-000222', '2026-03-27 22:05:00', 1, 2300.00, 1, 196, 'SWSI-1-000196', '', 1, '2026-03-27 16:05:47', '2026-03-27 16:05:47'),
(223, 1, 'ME-1-000223', '2026-03-27 23:04:00', 1, 1150.00, 1, 197, 'SWSI-1-000197', '', 1, '2026-03-27 17:04:33', '2026-03-27 17:04:33'),
(224, 1, 'ME-1-000224', '2026-03-28 17:58:00', 1, 6500.00, 0, 198, 'SWSI-1-000198', '', 1, '2026-03-28 12:00:27', '2026-03-28 12:00:27'),
(225, 1, 'ME-1-000225', '2026-03-28 19:43:00', 1, 2240.00, 1, 199, 'SWSI-1-000199', '', 1, '2026-03-28 13:43:42', '2026-03-28 13:43:42'),
(226, 1, 'ME-1-000226', '2026-03-28 20:57:00', 1, 8900.00, 1, 200, 'SWSI-1-000200', '', 1, '2026-03-28 14:58:46', '2026-03-28 14:58:46'),
(227, 1, 'ME-1-000227', '2026-03-28 21:32:00', 1, 3600.00, 0, 201, 'SWSI-1-000201', '', 1, '2026-03-28 15:33:34', '2026-03-28 15:33:34'),
(228, 1, 'ME-1-000228', '2026-03-28 22:29:00', 1, 550.00, 0, 202, 'SWSI-1-000202', '', 1, '2026-03-28 16:30:04', '2026-03-28 16:30:04'),
(229, 1, 'ME-1-000229', '2026-03-28 23:00:00', 1, 1200.00, 0, 203, 'SWSI-1-000203', '', 1, '2026-03-28 17:00:07', '2026-03-28 17:00:07'),
(230, 1, 'ME-1-000230', '2026-03-29 19:20:00', 1, 880.00, 0, 204, 'SWSI-1-000204', '', 1, '2026-03-29 13:20:49', '2026-03-29 13:20:49'),
(231, 1, 'ME-1-000231', '2026-03-29 21:03:00', 1, 6300.00, 1, 205, 'SWSI-1-000205', '', 1, '2026-03-29 15:07:38', '2026-03-29 15:07:38'),
(232, 1, 'ME-1-000232', '2026-03-29 23:10:00', 1, 1500.00, 0, 206, 'SWSI-1-000206', '', 1, '2026-03-29 17:10:35', '2026-03-29 17:10:35'),
(233, 1, 'ME-1-000233', '2026-03-29 23:20:00', 1, 1600.00, 1, 207, 'SWSI-1-000207', '', 1, '2026-03-29 17:20:42', '2026-03-29 17:20:42'),
(234, 1, 'ME-1-000234', '2026-03-31 16:55:00', 1, 1700.00, 1, 208, 'SWSI-1-000208', '', 1, '2026-03-31 10:55:54', '2026-03-31 10:55:54'),
(235, 1, 'ME-1-000235', '2026-03-31 19:36:00', 1, 800.00, 1, 209, 'SWSI-1-000209', '', 1, '2026-03-31 13:36:34', '2026-03-31 13:36:34'),
(236, 1, 'ME-1-000236', '2026-03-31 21:15:00', 1, 1100.00, 0, 210, 'SWSI-1-000210', '', 1, '2026-03-31 15:16:02', '2026-03-31 15:16:02'),
(237, 1, 'ME-1-000237', '2026-04-01 11:30:00', 1, 1750.00, 1, 211, 'SWSI-1-000211', '', 1, '2026-04-01 05:30:16', '2026-04-01 05:30:16'),
(238, 1, 'ME-1-000238', '2026-04-01 23:24:00', 1, 3705.00, 0, 212, 'SWSI-1-000212', '', 1, '2026-04-01 17:24:46', '2026-04-01 17:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `enter_olds`
--

CREATE TABLE `enter_olds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(191) NOT NULL,
  `bill_type` smallint(6) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_money` decimal(12,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(12,2) NOT NULL,
  `remain_money` decimal(12,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(12,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT NULL,
  `bill_client_name` varchar(191) DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enter_old_details`
--

CREATE TABLE `enter_old_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(12,2) NOT NULL,
  `weight21` decimal(12,2) NOT NULL,
  `gram_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `made_money` decimal(12,2) NOT NULL,
  `net_weight` decimal(12,2) NOT NULL,
  `tax` decimal(12,2) NOT NULL,
  `net_money` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enter_works`
--

CREATE TABLE `enter_works` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(191) NOT NULL,
  `bill_type` smallint(6) NOT NULL,
  `supplier_bill_number` varchar(191) DEFAULT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_money` decimal(12,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(12,2) NOT NULL,
  `remain_money` decimal(12,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `made_total` decimal(12,0) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(12,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enter_work_details`
--

CREATE TABLE `enter_work_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `weight21` decimal(8,2) NOT NULL,
  `made_money` decimal(12,2) NOT NULL,
  `made_value` decimal(12,0) NOT NULL,
  `net_weight` decimal(12,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `net_money` decimal(12,2) NOT NULL,
  `returned_weight` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exchange_rates`
--

CREATE TABLE `exchange_rates` (
  `id` int(11) NOT NULL,
  `conversion_rates` double(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `exit_money`
--

CREATE TABLE `exit_money` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `doc_number` varchar(191) NOT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `based_on` int(11) NOT NULL,
  `based_on_bill_number` varchar(191) DEFAULT '',
  `type` int(11) DEFAULT NULL,
  `price_gram` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exit_olds`
--

CREATE TABLE `exit_olds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(50) NOT NULL,
  `bill_type` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) NOT NULL DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exit_olds_tax`
--

CREATE TABLE `exit_olds_tax` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(191) NOT NULL,
  `bill_type` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `client_tax_number` varchar(100) NOT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) NOT NULL DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exit_old_details`
--

CREATE TABLE `exit_old_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(10,2) DEFAULT 0.00,
  `weight21` decimal(8,2) NOT NULL,
  `made_money` decimal(8,2) NOT NULL,
  `net_weight` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(10,2) DEFAULT 0.00,
  `gram_tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exit_old_tax_details`
--

CREATE TABLE `exit_old_tax_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(10,2) DEFAULT 0.00,
  `weight21` decimal(8,2) NOT NULL,
  `made_money` decimal(8,2) NOT NULL,
  `net_weight` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(10,2) DEFAULT 0.00,
  `gram_tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exit_works`
--

CREATE TABLE `exit_works` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `branch_id` int(11) DEFAULT 1,
  `bill_number` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_phone` varchar(50) DEFAULT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `qr` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `invoice_hash` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exit_works`
--

INSERT INTO `exit_works` (`id`, `uuid`, `branch_id`, `bill_number`, `date`, `client_id`, `client_phone`, `total_money`, `total21_gold`, `paid_money`, `remain_money`, `paid_gold`, `remain_gold`, `discount`, `tax`, `net_money`, `returned_bill_id`, `bill_client_name`, `pos`, `notes`, `qr`, `response`, `invoice_hash`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '9d44c848-ce13-4998-bbe7-d544eb09e684', 1, 'SWSI-1-000001', '2026-02-01 20:24:00', 1, NULL, 434.78, 1.00, 1000.00, -500.00, 0.00, 0.00, 0.00, 65.22, 500.00, 0, 'moh', 1, '', NULL, NULL, NULL, 1, '2026-02-01 17:24:00', '2026-02-01 17:24:00'),
(2, 'f8f87725-1540-40a0-bf76-2346ae7036f2', 1, 'SWSI-1-000002', '2026-02-03 18:06:02', 1, '0', 826.09, 1.47, 1900.00, -950.00, 0.00, 0.00, 0.00, 123.91, 950.00, 0, '0', 1, '', NULL, NULL, NULL, 1, '2026-02-03 15:06:02', '2026-02-03 15:06:02'),
(3, '84962bbc-3706-4821-8a1a-2bb0c8902696', 1, 'SWSI-1-000003', '2026-02-03 20:03:57', 1, '0', 2260.87, 4.20, 5200.00, -2600.00, 0.00, 0.00, 0.00, 339.13, 2600.00, 0, 'محمد رميس', 1, '', NULL, NULL, NULL, 1, '2026-02-03 17:03:57', '2026-02-03 17:03:57'),
(4, '9607e9f9-8754-435b-8109-e58376868281', 1, 'SWSI-1-000004', '2026-02-03 20:15:53', 1, 'محمد رميس', 782.61, 1.40, 1800.00, -900.00, 0.00, 0.00, 0.00, 117.39, 900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-03 17:15:53', '2026-02-03 17:15:53'),
(5, 'ae0d595e-dd44-418f-a9bb-3b808e4e0da0', 1, 'SWSI-1-000005', '2026-02-03 20:17:48', 1, '0', 869.57, 1.60, 2000.00, -1000.00, 0.00, 0.00, 0.00, 130.43, 1000.00, 0, 'محمد رميس', 1, '', NULL, NULL, NULL, 1, '2026-02-03 17:17:48', '2026-02-03 17:17:48'),
(6, '9543747e-8484-4d2d-88a2-57069bbbd45d', 1, 'SWSI-1-000006', '2026-02-04 14:26:21', 1, NULL, 1200.00, 2.10, 2760.00, -1380.00, 0.00, 0.00, 0.00, 180.00, 1380.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-04 11:26:21', '2026-02-04 11:26:21'),
(7, '318dad4f-4a09-403b-a19f-10667b583098', 1, 'SWSI-1-000007', '2026-02-04 14:27:27', 1, NULL, 3565.22, 6.90, 8200.00, -4100.00, 0.00, 0.00, 0.00, 534.78, 4100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-04 11:27:27', '2026-02-04 11:27:28'),
(8, '9743b82d-9ca5-4a03-92e2-43fb26d8b8b9', 1, 'SWSI-1-000008', '2026-02-04 17:33:13', 1, NULL, 5478.26, 10.10, 12600.00, -6300.00, 0.00, 0.00, 0.00, 821.74, 6300.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-04 14:33:13', '2026-02-04 14:33:13'),
(9, '9d38abcb-e3a2-4126-8df1-e07f6e015140', 1, 'SWSI-1-000009', '2026-02-04 18:39:11', 1, NULL, 1000.00, 1.80, 2300.00, -1150.00, 0.00, 0.00, 0.00, 150.00, 1150.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-04 15:39:11', '2026-02-04 15:39:11'),
(10, 'e56d2bb7-4f43-495d-b01b-82f2f6aae812', 1, 'SWSI-1-000010', '2026-02-05 19:19:02', 1, NULL, 3217.39, 5.23, 7400.00, -3700.00, 0.00, 0.00, 0.00, 482.61, 3700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-05 16:19:02', '2026-02-05 16:19:02'),
(11, 'aeb2be40-a284-4f85-86bf-26147124420f', 1, 'SWSI-1-000011', '2026-02-05 19:48:01', 1, NULL, 1913.04, 3.50, 4400.00, -2200.00, 0.00, 0.00, 0.00, 286.96, 2200.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-05 16:48:01', '2026-02-05 16:48:01'),
(12, '8baad990-a61b-4258-a818-7784012887be', 1, 'SWSI-1-000012', '2026-02-06 14:55:36', 1, NULL, 4782.61, 9.63, 11000.00, -5500.00, 0.00, 0.00, 0.00, 717.39, 5500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-06 11:55:36', '2026-02-06 11:55:36'),
(13, '37fe55e9-4623-4b1b-840a-34609ff98b1a', 1, 'SWSI-1-000013', '2026-02-06 18:43:11', 1, NULL, 1913.04, 3.60, 4400.00, -2200.00, 0.00, 0.00, 0.00, 286.96, 2200.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-06 15:43:11', '2026-02-06 15:43:11'),
(14, '0cebd040-67a0-45fe-bb32-e496387c5c41', 1, 'SWSI-1-000014', '2026-02-06 19:19:35', 1, NULL, 1565.22, 2.90, 3600.00, -1800.00, 0.00, 0.00, 0.00, 234.78, 1800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-06 16:19:35', '2026-02-06 16:19:35'),
(15, '31073a45-c0c1-44eb-8992-35aee524895f', 1, 'SWSI-1-000015', '2026-02-07 18:22:15', 1, NULL, 28260.87, 52.00, 65000.00, -32500.00, 0.00, 0.00, 0.00, 4239.13, 32500.00, 0, 'مريم محمد عبالله', 1, '', NULL, NULL, NULL, 1, '2026-02-07 15:22:15', '2026-02-07 15:22:15'),
(16, '96002e4c-5697-4ddb-8c12-a7986c36f55f', 1, 'SWSI-1-000016', '2026-02-08 14:57:28', 1, NULL, 3000.00, 4.54, 6900.00, -3450.00, 0.00, 0.00, 0.00, 450.00, 3450.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-08 11:57:28', '2026-02-08 11:57:28'),
(17, '4305a69a-9a0f-4530-b0e9-64ca64f802c9', 1, 'SWSI-1-000017', '2026-02-08 16:50:10', 1, NULL, 2634.78, 5.10, 6060.00, -3030.00, 0.00, 0.00, 0.00, 395.22, 3030.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-08 13:50:10', '2026-02-08 13:50:11'),
(18, '7a6be0c8-9b23-4a87-ab18-ca896864e21e', 1, 'SWSI-1-000018', '2026-02-09 16:10:57', 1, NULL, 2521.74, 4.70, 5800.00, -2900.00, 0.00, 0.00, 0.00, 378.26, 2900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-09 13:10:57', '2026-02-09 13:10:57'),
(19, 'fc285653-aaae-40fe-a8c7-9573737730de', 1, 'SWSI-1-000019', '2026-02-09 16:22:03', 1, NULL, 1304.35, 2.50, 3000.00, -1500.00, 0.00, 0.00, 0.00, 195.65, 1500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-09 13:22:03', '2026-02-09 13:22:03'),
(20, 'e9952b5a-60c3-4f71-a330-745947393409', 1, 'SWSI-1-000020', '2026-02-09 16:26:32', 1, NULL, 2078.26, 3.98, 4780.00, -2390.00, 0.00, 0.00, 0.00, 311.74, 2390.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-09 13:26:32', '2026-02-09 13:26:32'),
(21, '0792922a-c569-455a-b19a-4a93351531e6', 1, 'SWSI-1-000021', '2026-02-10 15:15:26', 1, NULL, 8000.00, 13.60, 18400.00, -9200.00, 0.00, 0.00, 0.00, 1200.00, 9200.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-10 12:15:26', '2026-02-10 12:15:26'),
(22, 'afdf6478-1676-45a2-b9a7-cef70b710311', 1, 'SWSI-1-000022', '2026-02-11 16:21:13', 1, NULL, 739.13, 1.35, 1700.00, -850.00, 0.00, 0.00, 0.00, 110.87, 850.00, 0, 'غاليه', 1, '', NULL, NULL, NULL, 1, '2026-02-11 13:21:13', '2026-02-11 13:21:13'),
(23, '15952d2b-15d6-495a-b0c0-aae1f7585979', 1, 'SWSI-1-000023', '2026-02-11 16:23:42', 1, NULL, 739.13, 1.35, 1700.00, -850.00, 0.00, 0.00, 0.00, 110.87, 850.00, 0, 'رحمه', 1, '', NULL, NULL, NULL, 1, '2026-02-11 13:23:42', '2026-02-11 13:23:42'),
(24, '6fc0fcca-440b-488a-8807-1c48c003ac59', 1, 'SWSI-1-000024', '2026-02-11 18:26:05', 1, NULL, 3304.35, 6.39, 7600.00, -3800.00, 0.00, 0.00, 0.00, 495.65, 3800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 15:26:05', '2026-02-11 15:26:05'),
(25, '950289b8-fc3a-4bdf-952d-d409e8a402d6', 1, 'SWSI-1-000025', '2026-02-11 18:28:05', 1, NULL, 3304.35, 6.10, 7600.00, -3800.00, 0.00, 0.00, 0.00, 495.65, 3800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 15:28:05', '2026-02-11 15:28:05'),
(26, 'db9b0c17-08d2-4c4f-8bab-2e648f5f905b', 1, 'SWSI-1-000026', '2026-02-11 18:30:40', 1, NULL, 2430.43, 4.82, 5590.00, -2795.00, 0.00, 0.00, 0.00, 364.57, 2795.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 15:30:40', '2026-02-11 15:30:40'),
(27, 'e2b5d75a-d252-4c6e-89b4-391f5255e5c3', 1, 'SWSI-1-000027', '2026-02-11 19:25:57', 1, NULL, 1217.39, 2.20, 2800.00, -1400.00, 0.00, 0.00, 0.00, 182.61, 1400.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 16:25:57', '2026-02-11 16:25:57'),
(28, 'a6bbd63d-143c-4513-b64b-8145e3424cf8', 1, 'SWSI-1-000028', '2026-02-11 19:47:31', 1, NULL, 652.17, 1.15, 1500.00, -750.00, 0.00, 0.00, 0.00, 97.83, 750.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 16:47:31', '2026-02-11 16:47:31'),
(29, '03b3a318-c51d-445a-88e0-88d0d6ae76d1', 1, 'SWSI-1-000029', '2026-02-11 19:49:10', 1, NULL, 652.17, 1.10, 1500.00, -750.00, 0.00, 0.00, 0.00, 97.83, 750.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 16:49:10', '2026-02-11 16:49:10'),
(30, '02209ff6-c873-4c00-a608-dcc732864a6e', 1, 'SWSI-1-000030', '2026-02-11 19:53:50', 1, NULL, 1504.35, 2.83, 3460.00, -1730.00, 0.00, 0.00, 0.00, 225.65, 1730.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 16:53:50', '2026-02-11 16:53:50'),
(31, 'c3b218a2-ceae-497a-a276-30eca198877b', 1, 'SWSI-1-000031', '2026-02-11 20:23:11', 1, NULL, 9934.78, 18.40, 22850.00, -11425.00, 0.00, 0.00, 0.00, 1490.22, 11425.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 17:23:11', '2026-02-11 17:23:11'),
(32, '7bc782b5-9183-410f-a5bb-fc98db2d27b0', 1, 'SWSI-1-000032', '2026-02-11 20:25:04', 1, NULL, 1652.17, 2.14, 3800.00, -1900.00, 0.00, 0.00, 0.00, 247.83, 1900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-11 17:25:04', '2026-02-11 17:25:04'),
(33, 'cc973382-08cd-4529-b223-1726a7e4eafa', 1, 'SWSI-1-000033', '2026-02-12 16:20:19', 1, NULL, 2026.09, 3.60, 4660.00, -2330.00, 0.00, 0.00, 0.00, 303.91, 2330.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-12 13:20:19', '2026-02-12 13:20:19'),
(34, '6b3cb42e-3ba3-45de-9824-f353fe413e93', 1, 'SWSI-1-000034', '2026-02-12 18:02:44', 1, NULL, 565.22, 1.00, 1300.00, -650.00, 0.00, 0.00, 0.00, 84.78, 650.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-12 15:02:44', '2026-02-12 15:02:44'),
(35, '56e59989-8edf-4268-98da-40dc987cc912', 1, 'SWSI-1-000035', '2026-02-13 15:48:52', 1, NULL, 3456.52, 6.15, 7950.00, -3975.00, 0.00, 0.00, 0.00, 518.48, 3975.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-13 12:48:52', '2026-02-13 12:48:52'),
(36, 'f6714908-7db2-465e-b1ca-7c49aceb55d4', 1, 'SWSI-1-000036', '2026-02-13 15:50:38', 1, NULL, 2413.04, 4.29, 5550.00, -2775.00, 0.00, 0.00, 0.00, 361.96, 2775.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-13 12:50:38', '2026-02-13 12:50:38'),
(37, '7a6ee8ae-55f6-4bcf-9a38-640820fbb2f4', 1, 'SWSI-1-000037', '2026-02-13 16:35:14', 1, NULL, 2434.78, 4.40, 5600.00, -2800.00, 0.00, 0.00, 0.00, 365.22, 2800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-13 13:35:14', '2026-02-13 13:35:14'),
(38, '0e58f178-b914-4e98-a941-36ecd6bc5dbb', 1, 'SWSI-1-000038', '2026-02-13 19:36:05', 1, NULL, 1173.91, 1.60, 2700.00, -1350.00, 0.00, 0.00, 0.00, 176.09, 1350.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-13 16:36:05', '2026-02-13 16:36:05'),
(39, '992cdaf6-1e71-4e96-8dbb-f4397182915e', 1, 'SWSI-1-000039', '2026-02-14 14:30:05', 1, NULL, 2608.70, 4.80, 6000.00, -3000.00, 0.00, 0.00, 0.00, 391.30, 3000.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-14 11:30:05', '2026-02-14 11:30:05'),
(40, 'eb4274b9-1efd-4f40-b888-14f7222deeae', 1, 'SWSI-1-000040', '2026-02-14 17:25:19', 1, NULL, 504.35, 0.90, 1160.00, -580.00, 0.00, 0.00, 0.00, 75.65, 580.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-14 14:25:19', '2026-02-14 14:25:20'),
(41, '1f3f6146-5928-4d22-8a04-3fede1b6ab37', 1, 'SWSI-1-000041', '2026-02-14 17:47:57', 1, NULL, 1086.96, 2.00, 2500.00, -1250.00, 0.00, 0.00, 0.00, 163.04, 1250.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-14 14:47:57', '2026-02-14 14:47:57'),
(42, '56019840-aee1-4d85-a79a-56eac1bf2533', 1, 'SWSI-1-000042', '2026-02-15 14:03:30', 1, NULL, 2739.13, 5.23, 6300.00, -3150.00, 0.00, 0.00, 0.00, 410.87, 3150.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-15 11:03:30', '2026-02-15 11:03:30'),
(43, '6409985a-e221-448d-9f8d-d79f525cee37', 1, 'SWSI-1-000043', '2026-02-15 14:46:23', 1, NULL, 1434.78, 2.60, 3300.00, -1650.00, 0.00, 0.00, 0.00, 215.22, 1650.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-15 11:46:23', '2026-02-15 11:46:23'),
(44, '7c576e5d-be0c-41a2-aa9d-bad8fa7c454b', 1, 'SWSI-1-000044', '2026-02-15 18:58:17', 1, NULL, 2243.48, 4.29, 5160.00, -2580.00, 0.00, 0.00, 0.00, 336.52, 2580.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-15 15:58:17', '2026-02-15 15:58:17'),
(45, '23984bbf-cca0-4002-8510-1d0ce1ad654c', 1, 'SWSI-1-000045', '2026-02-15 19:48:50', 1, NULL, 869.57, 1.50, 2000.00, -1000.00, 0.00, 0.00, 0.00, 130.43, 1000.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-15 16:48:50', '2026-02-15 16:48:50'),
(46, 'e3fc858b-ccce-4efe-82bd-6747465ac904', 1, 'SWSI-1-000046', '2026-02-16 14:42:35', 1, NULL, 22347.83, 40.40, 51400.00, -25700.00, 0.00, 0.00, 0.00, 3352.17, 25700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-16 11:42:35', '2026-02-16 11:42:35'),
(47, 'ad1258e8-89dd-4273-bc53-eb57610d3436', 1, 'SWSI-1-000047', '2026-02-17 15:18:39', 1, NULL, 2695.65, 5.10, 6200.00, -3100.00, 0.00, 0.00, 0.00, 404.35, 3100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-17 12:18:39', '2026-02-17 12:18:40'),
(48, '48718706-eb73-49f1-8402-e37120c70774', 1, 'SWSI-1-000048', '2026-02-17 16:26:03', 1, NULL, 1173.91, 1.90, 2700.00, -1350.00, 0.00, 0.00, 0.00, 176.09, 1350.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-17 13:26:03', '2026-02-17 13:26:03'),
(49, '8be74ba9-83bc-40c8-97f6-b76dd839ef14', 1, 'SWSI-1-000049', '2026-02-18 20:32:29', 1, NULL, 1069.57, 1.90, 2460.00, -1230.00, 0.00, 0.00, 0.00, 160.43, 1230.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-18 17:32:29', '2026-02-18 17:32:29'),
(50, '4941d61f-31d2-4cf3-97ab-4c9575549ed7', 1, 'SWSI-1-000050', '2026-02-19 22:09:15', 1, NULL, 4086.96, 7.60, 9400.00, -4700.00, 0.00, 0.00, 0.00, 613.04, 4700.00, 0, 'شوكت علي', 1, '', NULL, NULL, NULL, 1, '2026-02-19 19:09:15', '2026-02-19 19:09:15'),
(51, '6ce37791-1ee9-4c17-a002-944d2106caa4', 1, 'SWSI-1-000051', '2026-02-20 20:35:14', 1, NULL, 6330.43, 11.70, 14560.00, -7280.00, 0.00, 0.00, 0.00, 949.57, 7280.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-20 17:35:14', '2026-02-20 17:35:14'),
(52, 'bee255c2-cc24-47b1-b15d-df303c45afd1', 1, 'SWSI-1-000052', '2026-02-21 18:13:42', 1, NULL, 839.13, 1.50, 1930.00, -965.00, 0.00, 0.00, 0.00, 125.87, 965.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-21 15:13:42', '2026-02-21 15:13:42'),
(53, '911ecddb-92fd-47d5-9d12-94e650ad5cdb', 1, 'SWSI-1-000053', '2026-02-21 18:41:20', 1, NULL, 1408.70, 2.60, 3240.00, -1620.00, 0.00, 0.00, 0.00, 211.30, 1620.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-21 15:41:20', '2026-02-21 15:41:20'),
(54, '4bec9eb0-c77a-4d41-83c2-7199202346ba', 1, 'SWSI-1-000054', '2026-02-22 18:41:17', 1, NULL, 1173.91, 2.10, 2700.00, -1350.00, 0.00, 0.00, 0.00, 176.09, 1350.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-22 15:41:17', '2026-02-22 15:41:17'),
(55, 'e89e6883-2fe0-4294-a3e3-876c6573939b', 1, 'SWSI-1-000055', '2026-02-22 21:49:51', 1, NULL, 565.22, 0.90, 1300.00, -650.00, 0.00, 0.00, 0.00, 84.78, 650.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-22 18:49:51', '2026-02-22 18:49:51'),
(56, '703c2c15-efc8-436c-b744-4b76985e0f85', 1, 'SWSI-1-000056', '2026-02-22 22:24:54', 1, NULL, 1626.09, 3.00, 3740.00, -1870.00, 0.00, 0.00, 0.00, 243.91, 1870.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-22 19:24:54', '2026-02-22 19:24:54'),
(57, 'bebd1979-d217-4432-8808-8079094b5ea3', 1, 'SWSI-1-000057', '2026-02-23 14:22:54', 1, NULL, 1608.70, 3.14, 3700.00, -1850.00, 0.00, 0.00, 0.00, 241.30, 1850.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-23 11:22:54', '2026-02-23 11:22:54'),
(58, '2d478f58-c528-4186-99b8-e61426a281ff', 1, 'SWSI-1-000058', '2026-02-23 21:24:18', 1, NULL, 1756.52, 3.10, 4040.00, -2020.00, 0.00, 0.00, 0.00, 263.48, 2020.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-23 18:24:18', '2026-02-23 18:24:18'),
(59, '8320a185-a5d6-4846-ab1e-9a2b21a61cda', 1, 'SWSI-1-000059', '2026-02-23 22:47:15', 1, NULL, 12556.52, 23.30, 28880.00, -14440.00, 0.00, 0.00, 0.00, 1883.48, 14440.00, 0, 'شازليه', 1, '', NULL, NULL, NULL, 1, '2026-02-23 19:47:15', '2026-02-23 19:47:15'),
(60, '5ef72e85-2768-465e-9bb7-8edf833f2290', 1, 'SWSI-1-000060', '2026-02-24 19:17:33', 1, NULL, 2000.00, 3.70, 4600.00, -2300.00, 0.00, 0.00, 0.00, 300.00, 2300.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-24 16:17:33', '2026-02-24 16:17:33'),
(61, '34c5e4ba-9c95-4992-a4e5-af4496a28fd0', 1, 'SWSI-1-000061', '2026-02-24 20:44:58', 1, NULL, 756.52, 1.30, 1740.00, -870.00, 0.00, 0.00, 0.00, 113.48, 870.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-24 17:44:58', '2026-02-24 17:44:58'),
(62, '87b0242e-b605-4d8c-b3e7-cb6bf18683da', 1, 'SWSI-1-000062', '2026-02-25 18:24:14', 1, NULL, 956.52, 1.70, 2200.00, -1100.00, 0.00, 0.00, 0.00, 143.48, 1100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-25 15:24:14', '2026-02-25 15:24:14'),
(63, 'f6c13da1-cc93-4316-8757-20d493865b4d', 1, 'SWSI-1-000063', '2026-02-25 19:53:52', 1, NULL, 1913.04, 2.91, 4400.00, -2200.00, 0.00, 0.00, 0.00, 286.96, 2200.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-25 16:53:52', '2026-02-25 16:53:52'),
(64, '2f7c04cc-d394-4e88-bc15-747dd51644d1', 1, 'SWSI-1-000064', '2026-02-25 20:01:55', 1, NULL, 695.65, 1.20, 1600.00, -800.00, 0.00, 0.00, 0.00, 104.35, 800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-25 17:01:55', '2026-02-25 17:01:55'),
(65, 'bd3dcb3d-6700-4321-8952-146b3492a1a4', 1, 'SWSI-1-000065', '2026-02-26 20:22:10', 1, NULL, 2695.65, 5.00, 6200.00, -3100.00, 0.00, 0.00, 0.00, 404.35, 3100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-26 17:22:10', '2026-02-26 17:22:10'),
(66, '9c2f8431-9c06-4033-beb9-5d032aa40c9a', 1, 'SWSI-1-000066', '2026-02-26 20:32:45', 1, NULL, 547.83, 1.00, 1260.00, -630.00, 0.00, 0.00, 0.00, 82.17, 630.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-26 17:32:45', '2026-02-26 17:32:45'),
(67, 'a385c62a-40d4-4e46-80b7-dcb274d6bf6a', 1, 'SWSI-1-000067', '2026-02-27 18:18:07', 1, NULL, 800.00, 1.40, 1840.00, -920.00, 0.00, 0.00, 0.00, 120.00, 920.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-27 15:18:07', '2026-02-27 15:18:07'),
(68, 'e7c8a1ee-4a7e-44d8-9d58-ce2766a0874b', 1, 'SWSI-1-000068', '2026-02-27 18:34:36', 1, NULL, 1339.13, 2.40, 3080.00, -1540.00, 0.00, 0.00, 0.00, 200.87, 1540.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-27 15:34:36', '2026-02-27 15:34:36'),
(69, '259ff8e0-cbfd-4923-aa6c-2723a35ca2e2', 1, 'SWSI-1-000069', '2026-02-27 19:24:18', 1, NULL, 11973.91, 22.80, 27540.00, -13770.00, 0.00, 0.00, 0.00, 1796.09, 13770.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-27 16:24:18', '2026-02-27 16:24:18'),
(70, '05d70ca8-6091-4645-b424-383c884b6460', 1, 'SWSI-1-000070', '2026-02-27 21:27:32', 1, NULL, 652.17, 1.10, 1500.00, -750.00, 0.00, 0.00, 0.00, 97.83, 750.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-27 18:27:32', '2026-02-27 18:27:33'),
(71, 'd406e8b3-19b1-453b-9ba1-d6ae4910b614', 1, 'SWSI-1-000071', '2026-02-27 21:37:28', 1, NULL, 1217.39, 2.10, 2800.00, -1400.00, 0.00, 0.00, 0.00, 182.61, 1400.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-27 18:37:28', '2026-02-27 18:37:28'),
(72, '58db1ee9-10b1-47ed-89c9-13c840410ca3', 1, 'SWSI-1-000072', '2026-02-27 21:53:55', 1, NULL, 3130.43, 5.50, 7200.00, -3600.00, 0.00, 0.00, 0.00, 469.57, 3600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-27 18:53:55', '2026-02-27 18:53:55'),
(73, '5608bf0c-3d9b-4fda-9acc-6f3bfde128db', 1, 'SWSI-1-000073', '2026-02-28 19:01:00', 1, NULL, 478.26, 0.90, 1100.00, -550.00, 0.00, 0.00, 0.00, 71.74, 550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-28 16:01:00', '2026-02-28 16:01:00'),
(74, 'ffa4d3f6-7c95-400d-8334-ec8ce7fe16eb', 1, 'SWSI-1-000074', '2026-02-28 20:17:15', 1, NULL, 3000.00, 5.20, 6900.00, -3450.00, 0.00, 0.00, 0.00, 450.00, 3450.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-02-28 17:17:15', '2026-02-28 17:17:15'),
(75, 'da220975-edee-4704-b88b-3d0a7e2fdac6', 1, 'SWSI-1-000075', '2026-03-01 18:21:31', 1, NULL, 12739.13, 22.40, 29300.00, -14650.00, 0.00, 0.00, 0.00, 1910.87, 14650.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(76, '9e3b43a1-7d8d-4995-b6d8-b76b68d6c3c1', 1, 'SWSI-1-000076', '2026-03-01 19:38:14', 1, NULL, 1234.78, 2.20, 2840.00, -1420.00, 0.00, 0.00, 0.00, 185.22, 1420.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 16:38:14', '2026-03-01 16:38:14'),
(77, 'c7104ce8-e1a6-45e9-a87e-d08194578ea0', 1, 'SWSI-1-000077', '2026-03-01 20:13:38', 1, NULL, 1391.30, 2.30, 3200.00, -1600.00, 0.00, 0.00, 0.00, 208.70, 1600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 17:13:38', '2026-03-01 17:13:38'),
(78, '16392076-7960-45da-8e1d-1944787737e5', 1, 'SWSI-1-000078', '2026-03-01 20:39:08', 1, NULL, 3417.39, 5.97, 7860.00, -3930.00, 0.00, 0.00, 0.00, 512.61, 3930.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 17:39:08', '2026-03-01 17:39:09'),
(79, 'bf5ee682-d58c-4920-abf4-f20be2bd005c', 1, 'SWSI-1-000079', '2026-03-01 21:59:59', 1, NULL, 826.09, 1.30, 1900.00, -950.00, 0.00, 0.00, 0.00, 123.91, 950.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 18:59:59', '2026-03-01 18:59:59'),
(80, 'c1a3d8f8-5566-433e-9802-f16b2099083d', 1, 'SWSI-1-000080', '2026-03-01 22:10:20', 1, NULL, 852.17, 1.40, 1960.00, -980.00, 0.00, 0.00, 0.00, 127.83, 980.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 19:10:20', '2026-03-01 19:10:20'),
(81, '8d070bd9-5f33-4655-9442-daa256b344bb', 1, 'SWSI-1-000081', '2026-03-01 22:12:50', 1, NULL, 1130.43, 1.90, 2600.00, -1300.00, 0.00, 0.00, 0.00, 169.57, 1300.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 19:12:50', '2026-03-01 19:12:50'),
(82, 'd0e73e14-7f04-4015-a42c-35aea94d35ce', 1, 'SWSI-1-000082', '2026-03-01 22:19:38', 1, NULL, 3943.48, 7.30, 9070.00, -4535.00, 0.00, 0.00, 0.00, 591.52, 4535.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 19:19:38', '2026-03-01 19:19:38'),
(83, 'caf9a646-69a5-424c-8169-abf5b51a8817', 1, 'SWSI-1-000083', '2026-03-01 22:40:12', 1, NULL, 956.52, 1.54, 2200.00, -1100.00, 0.00, 0.00, 0.00, 143.48, 1100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-01 19:40:12', '2026-03-01 19:40:12'),
(84, 'bce69ac6-1119-49ac-a290-62a909a11cb6', 1, 'SWSI-1-000084', '2026-03-02 21:13:48', 1, NULL, 721.74, 1.20, 1660.00, -830.00, 0.00, 0.00, 0.00, 108.26, 830.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-02 18:13:48', '2026-03-02 18:13:48'),
(85, 'a3ea0617-b48a-4ba6-b067-61f7f005bf64', 1, 'SWSI-1-000085', '2026-03-02 21:17:13', 1, NULL, 7478.26, 13.10, 17200.00, -8600.00, 0.00, 0.00, 0.00, 1121.74, 8600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-02 18:17:13', '2026-03-02 18:17:13'),
(86, 'e2d74c50-bb47-4885-bb68-59a0f9763773', 1, 'SWSI-1-000086', '2026-03-03 13:55:57', 1, NULL, 2434.78, 4.23, 5600.00, -2800.00, 0.00, 0.00, 0.00, 365.22, 2800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-03 10:55:57', '2026-03-03 10:55:57'),
(87, '2486b25e-faa1-4646-9842-d72476661c9f', 1, 'SWSI-1-000087', '2026-03-03 13:57:40', 1, NULL, 1869.57, 3.35, 4300.00, -2150.00, 0.00, 0.00, 0.00, 280.43, 2150.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-03 10:57:40', '2026-03-03 10:57:40'),
(88, '3554758d-3558-46fc-aa56-c95dbd0b37a5', 1, 'SWSI-1-000088', '2026-03-03 18:12:36', 1, NULL, 686.96, 1.10, 1580.00, -790.00, 0.00, 0.00, 0.00, 103.04, 790.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-03 15:12:36', '2026-03-03 15:12:36'),
(89, '7a81f48b-5290-4da5-a2a8-633acbd00757', 1, 'SWSI-1-000089', '2026-03-03 22:19:13', 1, NULL, 36521.73, 64.50, 84000.00, -42000.00, 0.00, 0.00, 0.00, 5478.27, 42000.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(90, '05ec9e3f-567e-4c7f-8a77-0a4a9661e70a', 1, 'SWSI-1-000090', '2026-03-03 22:29:50', 1, NULL, 2695.65, 5.00, 6200.00, -3100.00, 0.00, 0.00, 0.00, 404.35, 3100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-03 19:29:50', '2026-03-03 19:29:50'),
(91, '75442564-0ff5-4c81-880f-fd927f17ee75', 1, 'SWSI-1-000091', '2026-03-03 22:31:19', 1, NULL, 4652.17, 8.30, 10700.00, -5350.00, 0.00, 0.00, 0.00, 697.83, 5350.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-03 19:31:19', '2026-03-03 19:31:19'),
(92, 'd7e198c5-c212-4379-8968-aad4d8fbb202', 1, 'SWSI-1-000092', '2026-03-03 23:11:27', 1, NULL, 1347.83, 2.40, 3100.00, -1550.00, 0.00, 0.00, 0.00, 202.17, 1550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-03 20:11:27', '2026-03-03 20:11:27'),
(93, '5c2a5f96-ada6-44c8-9fbc-f181367d4943', 1, 'SWSI-1-000093', '2026-03-04 04:20:24', 1, NULL, 6434.78, 11.30, 14800.00, -7400.00, 0.00, 0.00, 0.00, 965.22, 7400.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-04 01:20:24', '2026-03-04 01:20:24'),
(94, 'e6ada919-027f-44eb-bd9f-70dfeeefd1ba', 1, 'SWSI-1-000094', '2026-03-04 19:39:19', 1, NULL, 27043.48, 48.40, 62200.00, -31100.00, 0.00, 0.00, 0.00, 4056.52, 31100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-04 16:39:19', '2026-03-04 16:39:19'),
(95, '615d226c-c740-4a13-901f-49d4d9d347e3', 1, 'SWSI-1-000095', '2026-03-04 20:30:40', 1, NULL, 3869.57, 6.80, 8900.00, -4450.00, 0.00, 0.00, 0.00, 580.43, 4450.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-04 17:30:40', '2026-03-04 17:30:40'),
(96, 'f45a56bb-c88d-405d-8e73-2ae5fc3b7c64', 1, 'SWSI-1-000096', '2026-03-04 20:37:38', 1, NULL, 6695.65, 11.60, 15400.00, -7700.00, 0.00, 0.00, 0.00, 1004.35, 7700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-04 17:37:38', '2026-03-04 17:37:38'),
(97, '2b52e9a1-016f-47b0-9016-1415d20e40e1', 1, 'SWSI-1-000097', '2026-03-05 19:26:39', 1, NULL, 1347.83, 2.40, 3100.00, -1550.00, 0.00, 0.00, 0.00, 202.17, 1550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-05 16:26:39', '2026-03-05 16:26:39'),
(98, '3ad5a813-3107-4a84-8ca5-a7d5abe2fbe5', 1, 'SWSI-1-000098', '2026-03-05 19:54:35', 1, NULL, 347.83, 0.51, 800.00, -400.00, 0.00, 0.00, 0.00, 52.17, 400.00, 0, 'صالح حسين', 1, '', NULL, NULL, NULL, 1, '2026-03-05 16:54:35', '2026-03-05 16:54:35'),
(99, '0f6b8b91-410b-463e-bd6f-a58f601acc40', 1, 'SWSI-1-000099', '2026-03-05 20:44:17', 1, NULL, 730.43, 1.22, 1680.00, -840.00, 0.00, 0.00, 0.00, 109.57, 840.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-05 17:44:17', '2026-03-05 17:44:17'),
(100, 'abd1a350-9208-4be1-9df2-43abe56d2c78', 1, 'SWSI-1-000100', '2026-03-05 21:11:24', 1, NULL, 3869.57, 7.00, 8900.00, -4450.00, 0.00, 0.00, 0.00, 580.43, 4450.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-05 18:11:24', '2026-03-05 18:11:24'),
(101, '6e49d19c-5454-42c7-9cfe-9d69ed8eb4dd', 1, 'SWSI-1-000101', '2026-03-05 21:20:48', 1, NULL, 478.26, 0.90, 1100.00, -550.00, 0.00, 0.00, 0.00, 71.74, 550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-05 18:20:48', '2026-03-05 18:20:48'),
(102, 'd271fc85-3389-4674-9a13-06d91021e024', 1, 'SWSI-1-000102', '2026-03-05 23:00:42', 1, NULL, 652.17, 1.00, 1500.00, -750.00, 0.00, 0.00, 0.00, 97.83, 750.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-05 20:00:42', '2026-03-05 20:00:42'),
(103, 'b6d5d47f-dfcd-4490-adac-8426124e92a5', 1, 'SWSI-1-000103', '2026-03-06 18:13:00', 1, NULL, 10391.30, 18.40, 23900.00, -11950.00, 0.00, 0.00, 0.00, 1558.70, 11950.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-06 15:13:00', '2026-03-06 15:13:00'),
(104, '3dd08388-fece-44c6-8994-28b086fed6a0', 1, 'SWSI-1-000104', '2026-03-06 18:17:32', 1, NULL, 695.65, 1.20, 1600.00, -800.00, 0.00, 0.00, 0.00, 104.35, 800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-06 15:17:32', '2026-03-06 15:17:32'),
(105, 'f8d27e0e-e73f-49a5-8e63-ba960c85685b', 1, 'SWSI-1-000105', '2026-03-06 19:44:47', 1, NULL, 1347.83, 2.30, 3100.00, -1550.00, 0.00, 0.00, 0.00, 202.17, 1550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-06 16:44:47', '2026-03-06 16:44:47'),
(106, '745b922f-5c70-4931-b4dc-685ae64aee65', 1, 'SWSI-1-000106', '2026-03-06 20:09:17', 1, NULL, 1043.48, 1.70, 2400.00, -1200.00, 0.00, 0.00, 0.00, 156.52, 1200.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-06 17:09:17', '2026-03-06 17:09:17'),
(107, 'bd30234d-f7ba-4bb2-a05d-452c218d89af', 1, 'SWSI-1-000107', '2026-03-06 21:05:08', 1, NULL, 1678.26, 3.04, 3860.00, -1930.00, 0.00, 0.00, 0.00, 251.74, 1930.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-06 18:05:08', '2026-03-06 18:05:08'),
(108, '4c0e43de-2e0e-47c9-9ee1-cea59d0f0497', 1, 'SWSI-1-000108', '2026-03-06 21:07:47', 1, NULL, 4782.61, 8.20, 11000.00, -5500.00, 0.00, 0.00, 0.00, 717.39, 5500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-06 18:07:47', '2026-03-06 18:07:48'),
(109, '5d09d983-9a12-4109-9275-bcfe7d2607b4', 1, 'SWSI-1-000109', '2026-03-06 21:09:07', 1, NULL, 4347.83, 7.70, 10000.00, -5000.00, 0.00, 0.00, 0.00, 652.17, 5000.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-06 18:09:07', '2026-03-06 18:09:07'),
(110, 'a7ced1d8-ea71-4892-ba34-c399d6bc2cab', 1, 'SWSI-1-000110', '2026-03-06 21:26:35', 1, NULL, 14478.26, 25.00, 33300.00, -16650.00, 0.00, 0.00, 0.00, 2171.74, 16650.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-06 18:26:35', '2026-03-06 18:26:35'),
(111, 'b1eb296b-55f8-486d-a813-04ef0af3c691', 1, 'SWSI-1-000111', '2026-03-07 05:19:52', 1, NULL, 8260.87, 14.70, 19000.00, -9500.00, 0.00, 0.00, 0.00, 1239.13, 9500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-07 02:19:52', '2026-03-07 02:19:52'),
(112, 'e5fdfb74-0774-4b83-b2c6-7999ba0e59a5', 1, 'SWSI-1-000112', '2026-03-07 18:13:45', 1, NULL, 1304.35, 2.30, 3000.00, -1500.00, 0.00, 0.00, 0.00, 195.65, 1500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-07 15:13:45', '2026-03-07 15:13:45'),
(113, 'bc2b959c-e38b-4a58-b101-a63fe41758db', 1, 'SWSI-1-000113', '2026-03-07 18:26:02', 1, NULL, 5608.70, 9.80, 12900.00, -6450.00, 0.00, 0.00, 0.00, 841.30, 6450.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-07 15:26:02', '2026-03-07 15:26:02'),
(114, 'd3bc0818-e190-4743-a81d-7e1a512f3a13', 1, 'SWSI-1-000114', '2026-03-07 18:52:09', 1, NULL, 1304.35, 2.06, 3000.00, -1500.00, 0.00, 0.00, 0.00, 195.65, 1500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-07 15:52:09', '2026-03-07 15:52:09'),
(115, '88e8f04c-ed9e-413a-9dc1-2739cca1c0f0', 1, 'SWSI-1-000115', '2026-03-07 21:08:46', 1, NULL, 4956.52, 8.70, 11400.00, -5700.00, 0.00, 0.00, 0.00, 743.48, 5700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-07 18:08:46', '2026-03-07 18:08:46'),
(116, '9a9e74b5-4d0e-4684-881a-98bb062560a7', 1, 'SWSI-1-000116', '2026-03-07 21:28:29', 1, NULL, 1408.70, 2.41, 3240.00, -1620.00, 0.00, 0.00, 0.00, 211.30, 1620.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-07 18:28:29', '2026-03-07 18:28:29'),
(117, 'e8684e19-0be5-48e3-aff4-31361a21ca4e', 1, 'SWSI-1-000117', '2026-03-07 21:30:40', 1, NULL, 9391.30, 16.00, 21600.00, -10800.00, 0.00, 0.00, 0.00, 1408.70, 10800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-07 18:30:40', '2026-03-07 18:30:40'),
(118, '0ccd5e85-5835-4265-8ae4-2890207b2f9a', 1, 'SWSI-1-000118', '2026-03-07 23:16:10', 1, NULL, 1721.74, 2.57, 3960.00, -1980.00, 0.00, 0.00, 0.00, 258.26, 1980.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-07 20:16:10', '2026-03-07 20:16:10'),
(119, '1ed1445f-ce62-4474-b7b8-9fe5b1833ace', 1, 'SWSI-1-000119', '2026-03-08 14:07:29', 1, NULL, 1939.13, 3.40, 4460.00, -2230.00, 0.00, 0.00, 0.00, 290.87, 2230.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 11:07:29', '2026-03-08 11:07:29'),
(120, 'defa22e3-22ca-41f7-8965-d90bbdc6550c', 1, 'SWSI-1-000120', '2026-03-08 18:32:36', 1, NULL, 7756.52, 13.80, 17840.00, -8920.00, 0.00, 0.00, 0.00, 1163.48, 8920.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(121, '25385da4-73ed-45d5-93bc-ad3f4371f5f8', 1, 'SWSI-1-000121', '2026-03-08 19:19:15', 1, NULL, 8843.48, 15.10, 20340.00, -10170.00, 0.00, 0.00, 0.00, 1326.52, 10170.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 16:19:15', '2026-03-08 16:19:15'),
(122, 'a4eb4695-6ccf-44ae-91d7-94c5399be54a', 1, 'SWSI-1-000122', '2026-03-08 19:21:09', 1, NULL, 16434.78, 28.20, 37800.00, -18900.00, 0.00, 0.00, 0.00, 2465.22, 18900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 16:21:09', '2026-03-08 16:21:09'),
(123, 'd21deb13-a9ba-4000-8e75-a8f55054cfcc', 1, 'SWSI-1-000123', '2026-03-08 19:55:00', 1, NULL, 7652.17, 13.70, 17600.00, -8800.00, 0.00, 0.00, 0.00, 1147.83, 8800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 16:55:00', '2026-03-08 16:55:00'),
(124, 'e8a4b604-c230-4d91-ac65-897f79461435', 1, 'SWSI-1-000124', '2026-03-08 21:31:58', 1, NULL, 13478.26, 25.00, 31000.00, -15500.00, 0.00, 0.00, 0.00, 2021.74, 15500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 18:31:58', '2026-03-08 18:31:58'),
(125, 'f33b63a4-114a-4252-8540-ab4a879e6664', 1, 'SWSI-1-000125', '2026-03-08 23:07:08', 1, NULL, 4434.78, 7.90, 10200.00, -5100.00, 0.00, 0.00, 0.00, 665.22, 5100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 20:07:08', '2026-03-08 20:07:08'),
(126, 'a3642d28-2562-487a-824a-b4a871f1ac4f', 1, 'SWSI-1-000126', '2026-03-08 23:09:20', 1, NULL, 982.61, 1.70, 2260.00, -1130.00, 0.00, 0.00, 0.00, 147.39, 1130.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 20:09:20', '2026-03-08 20:09:20'),
(127, 'dab0cf0e-6484-4307-bcc5-b6f3ee79c921', 1, 'SWSI-1-000127', '2026-03-08 23:19:03', 1, NULL, 1573.91, 2.80, 3620.00, -1810.00, 0.00, 0.00, 0.00, 236.09, 1810.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-08 20:19:03', '2026-03-08 20:19:03'),
(128, 'e3822292-f6d4-4148-aab3-92e66ff08670', 1, 'SWSI-1-000128', '2026-03-09 14:24:17', 1, NULL, 904.35, 1.60, 2080.00, -1040.00, 0.00, 0.00, 0.00, 135.65, 1040.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-09 11:24:17', '2026-03-09 11:24:17'),
(129, 'c47e2dbd-fc2a-4468-a8a3-b07768d5c4cb', 1, 'SWSI-1-000129', '2026-03-11 18:54:42', 1, NULL, 791.30, 1.40, 1820.00, -910.00, 0.00, 0.00, 0.00, 118.70, 910.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-11 15:54:42', '2026-03-11 15:54:42'),
(130, '2dba5c24-fe42-4bd7-b446-90fae719de77', 1, 'SWSI-1-000130', '2026-03-11 19:00:43', 1, NULL, 6156.52, 11.00, 14160.00, -7080.00, 0.00, 0.00, 0.00, 923.48, 7080.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-11 16:00:43', '2026-03-11 16:00:43'),
(131, '6036db8c-1101-428f-a86f-a8c25e920aab', 1, 'SWSI-1-000131', '2026-03-11 20:35:50', 1, NULL, 1921.74, 3.30, 4420.00, -2210.00, 0.00, 0.00, 0.00, 288.26, 2210.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-11 17:35:50', '2026-03-11 17:35:50'),
(132, 'fed7b649-b722-4e69-8ca0-4f8e8ddbc85f', 1, 'SWSI-1-000132', '2026-03-11 20:37:44', 1, NULL, 478.26, 0.74, 1100.00, -550.00, 0.00, 0.00, 0.00, 71.74, 550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-11 17:37:44', '2026-03-11 17:37:44'),
(133, '6a27edd0-7c2d-4f50-88d7-16a58e89aa1a', 1, 'SWSI-1-000133', '2026-03-12 04:40:19', 1, NULL, 869.57, 1.50, 2000.00, -1000.00, 0.00, 0.00, 0.00, 130.43, 1000.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-12 01:40:19', '2026-03-12 01:40:19'),
(134, '5ed1b3f3-6fd1-4e89-8a88-f5bffded36e1', 1, 'SWSI-1-000134', '2026-03-12 18:38:38', 1, NULL, 1000.00, 1.80, 2300.00, -1150.00, 0.00, 0.00, 0.00, 150.00, 1150.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-12 15:38:38', '2026-03-12 15:38:38'),
(135, '6636cf29-e2e2-4327-b9ed-03554cae4c60', 1, 'SWSI-1-000135', '2026-03-12 18:39:42', 1, NULL, 1086.96, 1.90, 2500.00, -1250.00, 0.00, 0.00, 0.00, 163.04, 1250.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-12 15:39:42', '2026-03-12 15:39:42'),
(136, '61a22ba5-761d-4d1b-b94a-10df06e5e8da', 1, 'SWSI-1-000136', '2026-03-12 19:46:40', 1, NULL, 869.57, 1.50, 2000.00, -1000.00, 0.00, 0.00, 0.00, 130.43, 1000.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-12 16:46:40', '2026-03-12 16:46:40'),
(137, '276f8c24-3cb0-434e-a9cd-14817875ee9b', 1, 'SWSI-1-000137', '2026-03-12 20:49:31', 1, NULL, 1121.74, 2.00, 2580.00, -1290.00, 0.00, 0.00, 0.00, 168.26, 1290.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-12 17:49:31', '2026-03-12 17:49:31'),
(138, 'f1c648e3-2ee5-4495-96ce-eb2a4c28ad16', 1, 'SWSI-1-000138', '2026-03-12 21:36:50', 1, NULL, 1478.26, 2.72, 3400.00, -1700.00, 0.00, 0.00, 0.00, 221.74, 1700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-12 18:36:50', '2026-03-12 18:36:50'),
(139, '97801f67-6f32-4548-9bc4-246c0ee0375a', 1, 'SWSI-1-000139', '2026-03-12 23:03:54', 1, NULL, 956.52, 1.70, 2200.00, -1100.00, 0.00, 0.00, 0.00, 143.48, 1100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-12 20:03:54', '2026-03-12 20:03:54'),
(140, 'ad656951-16ab-4a79-9441-252adbd05c3e', 1, 'SWSI-1-000140', '2026-03-13 04:34:34', 1, NULL, 1721.74, 3.00, 3960.00, -1980.00, 0.00, 0.00, 0.00, 258.26, 1980.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 01:34:34', '2026-03-13 01:34:34'),
(141, 'ce291f30-704b-421f-912c-778f2c36b880', 1, 'SWSI-1-000141', '2026-03-13 18:34:13', 1, NULL, 6608.70, 12.10, 15200.00, -7600.00, 0.00, 0.00, 0.00, 991.30, 7600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 15:34:13', '2026-03-13 15:34:13'),
(142, 'd598634b-f059-4def-b860-9980a5ea8894', 1, 'SWSI-1-000142', '2026-03-13 19:33:09', 1, NULL, 1565.22, 2.70, 3600.00, -1800.00, 0.00, 0.00, 0.00, 234.78, 1800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 16:33:09', '2026-03-13 16:33:09'),
(143, '86e39055-7e23-4076-b1f2-f54212cb281a', 1, 'SWSI-1-000143', '2026-03-13 19:49:34', 1, NULL, 1478.26, 2.60, 3400.00, -1700.00, 0.00, 0.00, 0.00, 221.74, 1700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 16:49:34', '2026-03-13 16:49:34'),
(144, 'bf4637f2-f262-455f-9127-9d561c229f33', 1, 'SWSI-1-000144', '2026-03-13 20:03:23', 1, NULL, 521.74, 0.90, 1200.00, -600.00, 0.00, 0.00, 0.00, 78.26, 600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 17:03:23', '2026-03-13 17:03:23'),
(145, '08485767-7bba-457a-bd41-ddecb3618950', 1, 'SWSI-1-000145', '2026-03-13 20:39:23', 1, NULL, 930.43, 1.46, 2140.00, -1070.00, 0.00, 0.00, 0.00, 139.57, 1070.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 17:39:23', '2026-03-13 17:39:23'),
(146, 'c4e974a5-d5d7-4b55-aa6d-f87a2f4f32ab', 1, 'SWSI-1-000146', '2026-03-13 21:18:59', 1, NULL, 260.87, 0.34, 600.00, -300.00, 0.00, 0.00, 0.00, 39.13, 300.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 18:18:59', '2026-03-13 18:18:59'),
(147, '776384d8-ac28-437d-90d1-e1d13eeecc0f', 1, 'SWSI-1-000147', '2026-03-13 21:50:15', 1, NULL, 1478.26, 2.72, 3400.00, -1700.00, 0.00, 0.00, 0.00, 221.74, 1700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 18:50:15', '2026-03-13 18:50:15'),
(148, '36091bb3-25b7-4d53-8cde-7099241d1be6', 1, 'SWSI-1-000148', '2026-03-13 23:52:01', 1, NULL, 2321.74, 4.00, 5340.00, -2670.00, 0.00, 0.00, 0.00, 348.26, 2670.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-13 20:52:01', '2026-03-13 20:52:01'),
(149, '6f5c464f-79d6-48ea-b257-aa338426c1e6', 1, 'SWSI-1-000149', '2026-03-14 03:01:22', 1, NULL, 6347.83, 9.94, 14600.00, -7300.00, 0.00, 0.00, 0.00, 952.17, 7300.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-14 00:01:22', '2026-03-14 00:01:22'),
(150, 'c29bd897-2e8d-488b-92c0-9771f331d056', 1, 'SWSI-1-000150', '2026-03-14 04:55:57', 1, NULL, 2217.39, 3.90, 5100.00, -2550.00, 0.00, 0.00, 0.00, 332.61, 2550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-14 01:55:57', '2026-03-14 01:55:57'),
(151, '30d58ddd-a304-4012-93bf-95e8b0b1fee0', 1, 'SWSI-1-000151', '2026-03-14 18:57:48', 1, NULL, 1304.35, 2.44, 3000.00, -1500.00, 0.00, 0.00, 0.00, 195.65, 1500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-14 15:57:48', '2026-03-14 15:57:48'),
(152, 'b5bb4194-3ffa-4beb-958a-860488623e93', 1, 'SWSI-1-000152', '2026-03-14 18:59:16', 1, NULL, 869.57, 1.60, 2000.00, -1000.00, 0.00, 0.00, 0.00, 130.43, 1000.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-14 15:59:16', '2026-03-14 15:59:16'),
(153, '32e739de-00f2-4c8a-a37d-f81c49e9fdd7', 1, 'SWSI-1-000153', '2026-03-14 19:10:06', 1, NULL, 2695.65, 4.80, 6200.00, -3100.00, 0.00, 0.00, 0.00, 404.35, 3100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-14 16:10:06', '2026-03-14 16:10:06'),
(154, '3eaaae42-373d-4931-8acb-529b21b7f23c', 1, 'SWSI-1-000154', '2026-03-14 19:55:05', 1, NULL, 826.09, 1.40, 1900.00, -950.00, 0.00, 0.00, 0.00, 123.91, 950.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-14 16:55:05', '2026-03-14 16:55:05'),
(155, 'bccb1242-b957-41e9-a66d-57f6bf55ffa3', 1, 'SWSI-1-000155', '2026-03-14 22:54:02', 1, NULL, 2260.87, 4.10, 5200.00, -2600.00, 0.00, 0.00, 0.00, 339.13, 2600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-14 19:54:02', '2026-03-14 19:54:02'),
(156, 'cd29360f-4c09-4a01-a2c9-8d1ee2d4b67e', 1, 'SWSI-1-000156', '2026-03-14 23:04:37', 1, NULL, 782.61, 1.47, 1800.00, -900.00, 0.00, 0.00, 0.00, 117.39, 900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-14 20:04:37', '2026-03-14 20:04:37'),
(157, 'a5b5ff69-a5b0-47c5-9ee5-9c18c764f3a8', 1, 'SWSI-1-000157', '2026-03-15 04:50:37', 1, NULL, 1695.65, 3.10, 3900.00, -1950.00, 0.00, 0.00, 0.00, 254.35, 1950.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-15 01:50:37', '2026-03-15 01:50:38'),
(158, '0f89ad21-86d5-408a-a47c-d9937ca811bc', 1, 'SWSI-1-000158', '2026-03-15 14:13:17', 1, NULL, 2217.39, 4.40, 5100.00, -2550.00, 0.00, 0.00, 0.00, 332.61, 2550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-15 11:13:17', '2026-03-15 11:13:18'),
(159, '93c95bcb-9c6b-46f9-b705-b01cb0dd2d72', 1, 'SWSI-1-000159', '2026-03-15 14:34:52', 1, NULL, 695.65, 1.03, 1600.00, -800.00, 0.00, 0.00, 0.00, 104.35, 800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-15 11:34:52', '2026-03-15 11:34:52'),
(160, '5421345c-053f-459b-a7d7-cd8472bd8404', 1, 'SWSI-1-000160', '2026-03-15 19:50:15', 1, NULL, 4782.61, 8.00, 11000.00, -5500.00, 0.00, 0.00, 0.00, 717.39, 5500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-15 16:50:15', '2026-03-15 16:50:15'),
(161, 'debc3e62-6dc9-4974-bb3b-10358c645c30', 1, 'SWSI-1-000161', '2026-03-15 22:17:25', 1, NULL, 2000.00, 3.50, 4600.00, -2300.00, 0.00, 0.00, 0.00, 300.00, 2300.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-15 19:17:25', '2026-03-15 19:17:25'),
(162, 'fe1d2890-5713-42ad-ba49-166114c22fb9', 1, 'SWSI-1-000162', '2026-03-16 04:39:44', 1, NULL, 1256.52, 2.20, 2890.00, -1445.00, 0.00, 0.00, 0.00, 188.48, 1445.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-16 01:39:44', '2026-03-16 01:39:44'),
(163, '20c392c8-c621-4f76-bf55-4e9bec9933e6', 1, 'SWSI-1-000163', '2026-03-16 14:04:34', 1, NULL, 3739.13, 6.80, 8600.00, -4300.00, 0.00, 0.00, 0.00, 560.87, 4300.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-16 11:04:34', '2026-03-16 11:04:34'),
(164, 'afdd397a-35d1-4f72-b15d-85603b067beb', 1, 'SWSI-1-000164', '2026-03-16 23:07:04', 1, NULL, 500.00, 0.90, 1150.00, -575.00, 0.00, 0.00, 0.00, 75.00, 575.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-16 20:07:04', '2026-03-16 20:07:04'),
(165, 'fece573f-55b2-46a0-94b7-9975ecbf6c4c', 1, 'SWSI-1-000165', '2026-03-17 22:14:39', 1, NULL, 5956.52, 11.10, 13700.00, -6850.00, 0.00, 0.00, 0.00, 893.48, 6850.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-17 19:14:39', '2026-03-17 19:14:39'),
(166, '51d55d91-2ec2-46af-a639-39b19edaf18b', 1, 'SWSI-1-000166', '2026-03-17 22:41:20', 1, NULL, 1565.22, 2.80, 3600.00, -1800.00, 0.00, 0.00, 0.00, 234.78, 1800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-17 19:41:20', '2026-03-17 19:41:21'),
(167, '9844c471-d327-4861-9c25-6b42b23739dc', 1, 'SWSI-1-000167', '2026-03-18 05:36:33', 1, NULL, 5652.18, 10.50, 13000.00, -6500.00, 0.00, 0.00, 0.00, 847.82, 6500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-18 02:36:33', '2026-03-18 02:36:33'),
(168, 'a35513a0-6569-4294-80d0-88e67f8fb336', 1, 'SWSI-1-000168', '2026-03-18 19:30:10', 1, NULL, 1913.04, 3.40, 4400.00, -2200.00, 0.00, 0.00, 0.00, 286.96, 2200.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-18 16:30:10', '2026-03-18 16:30:10'),
(169, 'dddf8add-2b54-473d-9c99-01dd3d5d1306', 1, 'SWSI-1-000169', '2026-03-18 19:30:51', 1, NULL, 782.61, 1.40, 1800.00, -900.00, 0.00, 0.00, 0.00, 117.39, 900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-18 16:30:51', '2026-03-18 16:30:51'),
(170, 'ebab3e7c-fed5-4699-b679-f54b0460aa4c', 1, 'SWSI-1-000170', '2026-03-18 20:43:09', 1, NULL, 739.13, 1.30, 1700.00, -850.00, 0.00, 0.00, 0.00, 110.87, 850.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-18 17:43:09', '2026-03-18 17:43:09'),
(171, 'db612257-7f46-4c45-8760-0c557a67e239', 1, 'SWSI-1-000171', '2026-03-18 20:57:54', 1, NULL, 1721.74, 3.30, 3960.00, -1980.00, 0.00, 0.00, 0.00, 258.26, 1980.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-18 17:57:54', '2026-03-18 17:57:54'),
(172, '5de9ec08-5fb4-487c-9c64-6f53b879e1db', 1, 'SWSI-1-000172', '2026-03-18 21:22:46', 1, NULL, 25130.44, 50.34, 57800.00, -28900.00, 0.00, 0.00, 0.00, 3769.56, 28900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-18 18:22:46', '2026-03-18 18:22:46'),
(173, '4c9e1e00-bb6a-42f3-9c23-40eca3e6799b', 1, 'SWSI-1-000173', '2026-03-18 22:13:21', 1, NULL, 1104.35, 2.00, 2540.00, -1270.00, 0.00, 0.00, 0.00, 165.65, 1270.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-18 19:13:21', '2026-03-18 19:13:21'),
(174, '60057a68-a24a-4a4f-a41a-ccd1daa93a6f', 1, 'SWSI-1-000174', '2026-03-18 23:01:45', 1, NULL, 747.83, 1.30, 1720.00, -860.00, 0.00, 0.00, 0.00, 112.17, 860.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-18 20:01:45', '2026-03-18 20:01:45'),
(175, '8c50d9c0-3af7-4ee4-aacd-a469eaf2186c', 1, 'SWSI-1-000175', '2026-03-19 19:50:02', 1, NULL, 1478.26, 2.70, 3400.00, -1700.00, 0.00, 0.00, 0.00, 221.74, 1700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-19 16:50:02', '2026-03-19 16:50:02'),
(176, '5610dead-efbe-40e4-b04b-d1838f7f6274', 1, 'SWSI-1-000176', '2026-03-23 15:32:35', 1, NULL, 1826.09, 3.56, 4200.00, -2100.00, 0.00, 0.00, 0.00, 273.91, 2100.00, 0, 'حسين', 1, '', NULL, NULL, NULL, 1, '2026-03-23 12:32:35', '2026-03-23 12:32:35'),
(177, '9f1a45d7-cded-47f4-be07-d6372fd1b518', 1, 'SWSI-1-000177', '2026-03-23 16:59:10', 1, NULL, 1195.65, 2.30, 2750.00, -1375.00, 0.00, 0.00, 0.00, 179.35, 1375.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-23 13:59:10', '2026-03-23 13:59:10'),
(178, '358fc93c-05b3-46de-8b1e-3a51e575948c', 1, 'SWSI-1-000178', '2026-03-23 19:58:42', 1, NULL, 1213.04, 2.30, 2790.00, -1395.00, 0.00, 0.00, 0.00, 181.96, 1395.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-23 16:58:42', '2026-03-23 16:58:42'),
(179, '5371dac0-501c-47bd-9695-01f0a9ba8d22', 1, 'SWSI-1-000179', '2026-03-23 20:26:19', 1, NULL, 7913.04, 17.07, 18200.00, -9100.00, 0.00, 0.00, 0.00, 1186.96, 9100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-23 17:26:19', '2026-03-23 17:26:19'),
(180, '648d9a34-8fc3-477a-a9a0-3092ccf4abff', 1, 'SWSI-1-000180', '2026-03-24 07:42:14', 1, NULL, 1321.74, 2.50, 3040.00, -1520.00, 0.00, 0.00, 0.00, 198.26, 1520.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-24 04:42:14', '2026-03-24 04:42:14'),
(181, 'ff2d95d5-9846-492e-a127-932a88f93613', 1, 'SWSI-1-000181', '2026-03-24 14:46:43', 1, NULL, 2613.04, 5.34, 6010.00, -3005.00, 0.00, 0.00, 0.00, 391.96, 3005.00, 0, 'روزينا', 1, '', NULL, NULL, NULL, 1, '2026-03-24 11:46:43', '2026-03-24 11:46:43'),
(182, 'cb16a9d4-d4fa-4e17-9056-5fd52ff592ba', 1, 'SWSI-1-000182', '2026-03-24 16:37:41', 1, NULL, 782.61, 1.60, 1800.00, -900.00, 0.00, 0.00, 0.00, 117.39, 900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-24 13:37:41', '2026-03-24 13:37:41'),
(183, '67d87aef-95a4-403a-bbd5-bc1115393a98', 1, 'SWSI-1-000183', '2026-03-24 18:53:22', 1, NULL, 1434.78, 2.80, 3300.00, -1650.00, 0.00, 0.00, 0.00, 215.22, 1650.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-24 15:53:22', '2026-03-24 15:53:22'),
(184, '8bfbc079-7033-4381-bea0-b0e2e9c264f9', 1, 'SWSI-1-000184', '2026-03-24 19:02:13', 1, NULL, 10608.70, 22.10, 24400.00, -12200.00, 0.00, 0.00, 0.00, 1591.30, 12200.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-24 16:02:13', '2026-03-24 16:02:13'),
(185, '6b9006d5-4398-496c-bdcf-112710b10a1a', 1, 'SWSI-1-000185', '2026-03-24 19:40:32', 1, NULL, 747.83, 1.41, 1720.00, -860.00, 0.00, 0.00, 0.00, 112.17, 860.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-24 16:40:32', '2026-03-24 16:40:32'),
(186, '0b68131c-161e-4352-9594-930b43d0a740', 1, 'SWSI-1-000186', '2026-03-25 15:32:28', 1, NULL, 22060.87, 43.29, 50740.00, -25370.00, 0.00, 0.00, 0.00, 3309.13, 25370.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(187, '16f6ebc8-9ad8-4ef2-aee9-94a4a5f04553', 1, 'SWSI-1-000187', '2026-03-25 18:12:41', 1, NULL, 1217.39, 2.60, 2800.00, -1400.00, 0.00, 0.00, 0.00, 182.61, 1400.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-25 15:12:41', '2026-03-25 15:12:41'),
(188, 'e05e5147-afc0-4152-9648-4e54c0eec411', 1, 'SWSI-1-000188', '2026-03-25 20:28:06', 1, NULL, 539.13, 1.08, 1240.00, -620.00, 0.00, 0.00, 0.00, 80.87, 620.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-25 17:28:06', '2026-03-25 17:28:06'),
(189, '88bf0858-ce1d-4fd8-80a4-c381da826132', 1, 'SWSI-1-000189', '2026-03-26 17:59:41', 1, NULL, 934.78, 1.90, 2150.00, -1075.00, 0.00, 0.00, 0.00, 140.22, 1075.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-26 14:59:41', '2026-03-26 14:59:41'),
(190, 'd98bc9e3-ee99-4ac1-a29e-2210ba1ba8a6', 1, 'SWSI-1-000190', '2026-03-26 18:50:36', 1, NULL, 565.22, 1.10, 1300.00, -650.00, 0.00, 0.00, 0.00, 84.78, 650.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-26 15:50:36', '2026-03-26 15:50:36'),
(191, '41ec32b7-a385-4e1f-8fa8-ee5b84bd2590', 1, 'SWSI-1-000191', '2026-03-26 18:56:18', 1, NULL, 1391.30, 3.00, 3200.00, -1600.00, 0.00, 0.00, 0.00, 208.70, 1600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-26 15:56:18', '2026-03-26 15:56:18'),
(192, '4a62f8a4-420b-466e-95b3-df7239646e90', 1, 'SWSI-1-000192', '2026-03-26 19:58:35', 1, NULL, 1869.57, 3.90, 4300.00, -2150.00, 0.00, 0.00, 0.00, 280.43, 2150.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-26 16:58:35', '2026-03-26 16:58:35'),
(193, 'c27e84e3-11de-4827-b241-993bfec94f17', 1, 'SWSI-1-000193', '2026-03-27 14:28:24', 1, NULL, 7043.48, 14.48, 16200.00, -8100.00, 0.00, 0.00, 0.00, 1056.52, 8100.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-27 11:28:24', '2026-03-27 11:28:24'),
(194, 'b97dd2e8-6a70-4ec1-8df7-cfa122123a4d', 1, 'SWSI-1-000194', '2026-03-27 14:33:24', 1, NULL, 913.05, 1.70, 2100.00, -1050.00, 0.00, 0.00, 0.00, 136.95, 1050.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-27 11:33:24', '2026-03-27 11:33:24'),
(195, '40d41d76-9e16-426e-9d11-a359f6f381df', 1, 'SWSI-1-000195', '2026-03-27 18:24:44', 1, NULL, 1391.30, 2.80, 3200.00, -1600.00, 0.00, 0.00, 0.00, 208.70, 1600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-27 15:24:44', '2026-03-27 15:24:44'),
(196, '43ac9e3e-eda2-4b52-b095-7280d148917c', 1, 'SWSI-1-000196', '2026-03-27 19:05:46', 1, NULL, 2565.22, 5.20, 5900.00, -2950.00, 0.00, 0.00, 0.00, 384.78, 2950.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-27 16:05:46', '2026-03-27 16:05:47'),
(197, '9663c13c-7e2f-43ef-b7d4-36ffff9c0f41', 1, 'SWSI-1-000197', '2026-03-27 20:04:33', 1, NULL, 1000.00, 1.90, 2300.00, -1150.00, 0.00, 0.00, 0.00, 150.00, 1150.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-27 17:04:33', '2026-03-27 17:04:33'),
(198, '3c235adb-a937-4eef-9bd8-73ac3b388e6c', 1, 'SWSI-1-000198', '2026-03-28 15:00:27', 1, NULL, 5652.17, 11.70, 13000.00, -6500.00, 0.00, 0.00, 0.00, 847.83, 6500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-28 12:00:27', '2026-03-28 12:00:27'),
(199, '273315f2-4530-484b-a086-bf3177ea0a97', 1, 'SWSI-1-000199', '2026-03-28 16:43:42', 1, NULL, 1947.83, 4.08, 4480.00, -2240.00, 0.00, 0.00, 0.00, 292.17, 2240.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-28 13:43:42', '2026-03-28 13:43:42');
INSERT INTO `exit_works` (`id`, `uuid`, `branch_id`, `bill_number`, `date`, `client_id`, `client_phone`, `total_money`, `total21_gold`, `paid_money`, `remain_money`, `paid_gold`, `remain_gold`, `discount`, `tax`, `net_money`, `returned_bill_id`, `bill_client_name`, `pos`, `notes`, `qr`, `response`, `invoice_hash`, `user_id`, `created_at`, `updated_at`) VALUES
(200, 'cb1da37f-082f-4be8-a2c2-b2556885a044', 1, 'SWSI-1-000200', '2026-03-28 17:58:46', 1, NULL, 7739.13, 16.00, 17800.00, -8900.00, 0.00, 0.00, 0.00, 1160.87, 8900.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-28 14:58:46', '2026-03-28 14:58:46'),
(201, 'e3b35ae9-b746-4b26-b1c5-c2e724d61752', 1, 'SWSI-1-000201', '2026-03-28 18:33:33', 1, NULL, 3130.43, 6.00, 7200.00, -3600.00, 0.00, 0.00, 0.00, 469.57, 3600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-28 15:33:33', '2026-03-28 15:33:34'),
(202, 'efa291e2-62e1-4640-be99-971d0f7ca4be', 1, 'SWSI-1-000202', '2026-03-28 19:30:04', 1, NULL, 478.26, 1.00, 1100.00, -550.00, 0.00, 0.00, 0.00, 71.74, 550.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-28 16:30:04', '2026-03-28 16:30:04'),
(203, '3537fb85-1249-46ac-86ea-de902971a8e4', 1, 'SWSI-1-000203', '2026-03-28 20:00:07', 1, NULL, 1043.48, 2.00, 2400.00, -1200.00, 0.00, 0.00, 0.00, 156.52, 1200.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-28 17:00:07', '2026-03-28 17:00:07'),
(204, '18267c5c-306b-4f72-b270-769c01af3da8', 1, 'SWSI-1-000204', '2026-03-29 16:20:49', 1, NULL, 765.22, 1.50, 1760.00, -880.00, 0.00, 0.00, 0.00, 114.78, 880.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-29 13:20:49', '2026-03-29 13:20:49'),
(205, 'ebb3f327-51d1-4bf9-8904-2f4926649baa', 1, 'SWSI-1-000205', '2026-03-29 18:07:38', 1, NULL, 5478.26, 11.30, 12600.00, -6300.00, 0.00, 0.00, 0.00, 821.74, 6300.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-29 15:07:38', '2026-03-29 15:07:38'),
(206, 'd0f14da3-9712-4a47-9192-bf997be6f654', 1, 'SWSI-1-000206', '2026-03-29 20:10:35', 1, NULL, 1304.35, 2.70, 3000.00, -1500.00, 0.00, 0.00, 0.00, 195.65, 1500.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-29 17:10:35', '2026-03-29 17:10:35'),
(207, 'f083b026-cb5c-4c3b-acf5-ffda703dfdce', 1, 'SWSI-1-000207', '2026-03-29 20:20:42', 1, NULL, 1391.30, 2.83, 3200.00, -1600.00, 0.00, 0.00, 0.00, 208.70, 1600.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-29 17:20:42', '2026-03-29 17:20:42'),
(208, '0b7177d6-1b8f-488d-9b65-12f6949c6b80', 1, 'SWSI-1-000208', '2026-03-31 13:55:54', 1, NULL, 1478.26, 3.10, 3400.00, -1700.00, 0.00, 0.00, 0.00, 221.74, 1700.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-31 10:55:54', '2026-03-31 10:55:54'),
(209, 'f8ce213a-cdda-4580-b851-7881e96e292a', 1, 'SWSI-1-000209', '2026-03-31 16:36:34', 1, NULL, 695.65, 1.40, 1600.00, -800.00, 0.00, 0.00, 0.00, 104.35, 800.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-03-31 13:36:34', '2026-03-31 13:36:34'),
(210, 'c91806b0-d015-4631-a1a1-269288bd7950', 1, 'SWSI-1-000210', '2026-03-31 18:16:02', 1, NULL, 956.52, 2.00, 2200.00, -1100.00, 0.00, 0.00, 0.00, 143.48, 1100.00, 0, 'روان علي', 1, '', NULL, NULL, NULL, 1, '2026-03-31 15:16:02', '2026-03-31 15:16:02'),
(211, '1344634e-b7b7-4f6c-9682-1dfc7c6ace3d', 1, 'SWSI-1-000211', '2026-04-01 08:30:16', 1, NULL, 1521.74, 2.90, 3500.00, -1750.00, 0.00, 0.00, 0.00, 228.26, 1750.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-04-01 05:30:16', '2026-04-01 05:30:16'),
(212, 'c82b21ec-d09b-4e86-829b-5d8af4c74bec', 1, 'SWSI-1-000212', '2026-04-01 20:24:46', 1, NULL, 3221.74, 6.20, 7410.00, -3705.00, 0.00, 0.00, 0.00, 483.26, 3705.00, 0, NULL, 1, '', NULL, NULL, NULL, 1, '2026-04-01 17:24:46', '2026-04-01 17:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `exit_works_tax`
--

CREATE TABLE `exit_works_tax` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `type` int(11) DEFAULT 0,
  `client_id` int(11) NOT NULL,
  `client_tax_number` varchar(100) NOT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `qr` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `invoice_hash` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exit_work_details`
--

CREATE TABLE `exit_work_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(8,2) NOT NULL,
  `gram_tax` decimal(8,2) NOT NULL,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exit_work_details`
--

INSERT INTO `exit_work_details` (`id`, `bill_id`, `item_id`, `karat_id`, `weight`, `gram_price`, `gram_manufacture`, `gram_tax`, `net_money`, `returned`, `count`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1.00, 434.78, 0.00, 65.22, 500.00, 0, 1, '2026-02-01 17:24:00', '2026-02-01 17:24:00'),
(2, 2, 6, 3, 1.40, 590.06, 0.00, 123.91, 950.00, 0, 1, '2026-02-03 15:06:02', '2026-02-03 15:06:02'),
(3, 3, 2, 2, 2.00, 521.74, 0.00, 156.52, 1200.00, 0, 1, '2026-02-03 17:03:57', '2026-02-03 17:03:57'),
(4, 3, 6, 3, 2.10, 579.71, 0.00, 182.61, 1400.00, 0, 1, '2026-02-03 17:03:57', '2026-02-03 17:03:57'),
(5, 4, 12, 2, 1.40, 559.01, 0.00, 117.39, 900.00, 0, 1, '2026-02-03 17:15:53', '2026-02-03 17:15:53'),
(6, 5, 12, 2, 1.60, 543.48, 0.00, 130.43, 1000.00, 0, 1, '2026-02-03 17:17:48', '2026-02-03 17:17:48'),
(7, 6, 15, 2, 2.10, 571.43, 0.00, 180.00, 1380.00, 0, 1, '2026-02-04 11:26:21', '2026-02-04 11:26:21'),
(8, 7, 2, 2, 6.90, 516.70, 0.00, 534.78, 4100.00, 0, 4, '2026-02-04 11:27:27', '2026-02-04 11:27:27'),
(9, 8, 17, 2, 10.10, 542.40, 0.00, 821.74, 6300.00, 0, 1, '2026-02-04 14:33:13', '2026-02-04 14:33:13'),
(10, 9, 12, 2, 1.80, 555.56, 0.00, 150.00, 1150.00, 0, 1, '2026-02-04 15:39:11', '2026-02-04 15:39:11'),
(11, 10, 11, 1, 6.10, 527.44, 0.00, 482.61, 3700.00, 0, 1, '2026-02-05 16:19:02', '2026-02-05 16:19:02'),
(12, 11, 2, 2, 3.50, 546.58, 0.00, 286.96, 2200.00, 0, 1, '2026-02-05 16:48:01', '2026-02-05 16:48:01'),
(13, 12, 7, 3, 9.20, 519.85, 0.00, 717.39, 5500.00, 0, 1, '2026-02-06 11:55:36', '2026-02-06 11:55:36'),
(14, 13, 2, 2, 3.60, 531.40, 0.00, 286.96, 2200.00, 0, 1, '2026-02-06 15:43:11', '2026-02-06 15:43:11'),
(15, 14, 8, 2, 2.90, 539.73, 0.00, 234.78, 1800.00, 0, 1, '2026-02-06 16:19:35', '2026-02-06 16:19:35'),
(16, 15, 2, 2, 47.70, 541.43, 0.00, 3873.91, 29700.00, 0, 1, '2026-02-07 15:22:15', '2026-02-07 15:22:15'),
(17, 15, 18, 2, 4.30, 566.23, 0.00, 365.22, 2800.00, 0, 1, '2026-02-07 15:22:15', '2026-02-07 15:22:15'),
(18, 16, 11, 1, 5.30, 566.04, 0.00, 450.00, 3450.00, 0, 1, '2026-02-08 11:57:28', '2026-02-08 11:57:28'),
(19, 17, 14, 2, 5.10, 516.62, 0.00, 395.22, 3030.00, 0, 1, '2026-02-08 13:50:10', '2026-02-08 13:50:10'),
(20, 18, 14, 2, 4.70, 536.54, 0.00, 378.26, 2900.00, 0, 1, '2026-02-09 13:10:57', '2026-02-09 13:10:57'),
(21, 19, 2, 2, 2.50, 521.74, 0.00, 195.65, 1500.00, 0, 1, '2026-02-09 13:22:03', '2026-02-09 13:22:03'),
(22, 20, 6, 3, 3.80, 546.91, 0.00, 311.74, 2390.00, 0, 1, '2026-02-09 13:26:32', '2026-02-09 13:26:32'),
(23, 21, 18, 2, 13.60, 588.24, 0.00, 1200.00, 9200.00, 0, 1, '2026-02-10 12:15:26', '2026-02-10 12:15:26'),
(24, 22, 12, 2, 1.35, 547.50, 0.00, 110.87, 850.00, 0, 1, '2026-02-11 13:21:13', '2026-02-11 13:21:13'),
(25, 23, 12, 2, 1.35, 547.50, 0.00, 110.87, 850.00, 0, 1, '2026-02-11 13:23:42', '2026-02-11 13:23:42'),
(26, 24, 6, 3, 6.10, 541.70, 0.00, 495.65, 3800.00, 0, 2, '2026-02-11 15:26:05', '2026-02-11 15:26:05'),
(27, 25, 2, 2, 6.10, 541.70, 0.00, 495.65, 3800.00, 0, 1, '2026-02-11 15:28:05', '2026-02-11 15:28:05'),
(28, 26, 7, 3, 4.60, 528.36, 0.00, 364.57, 2795.00, 0, 1, '2026-02-11 15:30:40', '2026-02-11 15:30:40'),
(29, 27, 2, 2, 2.20, 553.36, 0.00, 182.61, 1400.00, 0, 1, '2026-02-11 16:25:57', '2026-02-11 16:25:57'),
(30, 28, 6, 3, 1.10, 592.89, 0.00, 97.83, 750.00, 0, 1, '2026-02-11 16:47:31', '2026-02-11 16:47:31'),
(31, 29, 2, 2, 1.10, 592.89, 0.00, 97.83, 750.00, 0, 1, '2026-02-11 16:49:10', '2026-02-11 16:49:10'),
(32, 30, 19, 3, 2.70, 557.17, 0.00, 225.65, 1730.00, 0, 1, '2026-02-11 16:53:50', '2026-02-11 16:53:50'),
(33, 31, 4, 2, 18.40, 539.93, 0.00, 1490.22, 11425.00, 0, 1, '2026-02-11 17:23:11', '2026-02-11 17:23:11'),
(34, 32, 11, 1, 2.50, 660.87, 0.00, 247.83, 1900.00, 0, 1, '2026-02-11 17:25:04', '2026-02-11 17:25:04'),
(35, 33, 2, 2, 3.60, 562.80, 0.00, 303.91, 2330.00, 0, 2, '2026-02-12 13:20:19', '2026-02-12 13:20:19'),
(36, 34, 15, 2, 1.00, 565.22, 0.00, 84.78, 650.00, 0, 1, '2026-02-12 15:02:44', '2026-02-12 15:02:44'),
(37, 35, 20, 1, 7.17, 482.08, 0.00, 518.48, 3975.00, 0, 1, '2026-02-13 12:48:52', '2026-02-13 12:48:52'),
(38, 36, 21, 1, 5.00, 482.61, 0.00, 361.96, 2775.00, 0, 1, '2026-02-13 12:50:38', '2026-02-13 12:50:38'),
(39, 37, 14, 2, 4.40, 553.36, 0.00, 365.22, 2800.00, 0, 1, '2026-02-13 13:35:14', '2026-02-13 13:35:14'),
(40, 38, 5, 2, 1.60, 733.70, 0.00, 176.09, 1350.00, 0, 2, '2026-02-13 16:36:05', '2026-02-13 16:36:05'),
(41, 39, 2, 2, 4.80, 543.48, 0.00, 391.30, 3000.00, 0, 2, '2026-02-14 11:30:05', '2026-02-14 11:30:05'),
(42, 40, 10, 2, 0.90, 560.39, 0.00, 75.65, 580.00, 0, 1, '2026-02-14 14:25:19', '2026-02-14 14:25:19'),
(43, 41, 2, 2, 2.00, 543.48, 0.00, 163.04, 1250.00, 0, 1, '2026-02-14 14:47:57', '2026-02-14 14:47:57'),
(44, 42, 6, 3, 5.00, 547.83, 0.00, 410.87, 3150.00, 0, 1, '2026-02-15 11:03:30', '2026-02-15 11:03:30'),
(45, 43, 15, 2, 2.60, 551.84, 0.00, 215.22, 1650.00, 0, 1, '2026-02-15 11:46:23', '2026-02-15 11:46:23'),
(46, 44, 6, 3, 4.10, 547.19, 0.00, 336.52, 2580.00, 0, 1, '2026-02-15 15:58:17', '2026-02-15 15:58:17'),
(47, 45, 12, 2, 1.50, 579.71, 0.00, 130.43, 1000.00, 0, 1, '2026-02-15 16:48:50', '2026-02-15 16:48:50'),
(48, 46, 8, 2, 40.40, 553.16, 0.00, 3352.17, 25700.00, 0, 1, '2026-02-16 11:42:35', '2026-02-16 11:42:35'),
(49, 47, 22, 2, 5.10, 528.56, 0.00, 404.35, 3100.00, 0, 1, '2026-02-17 12:18:39', '2026-02-17 12:18:39'),
(50, 48, 2, 2, 1.90, 617.85, 0.00, 176.09, 1350.00, 0, 2, '2026-02-17 13:26:03', '2026-02-17 13:26:03'),
(51, 49, 2, 2, 1.90, 562.93, 0.00, 160.43, 1230.00, 0, 1, '2026-02-18 17:32:29', '2026-02-18 17:32:29'),
(52, 50, 23, 2, 7.60, 537.76, 0.00, 613.04, 4700.00, 0, 1, '2026-02-19 19:09:15', '2026-02-19 19:09:15'),
(53, 51, 4, 2, 11.70, 541.06, 0.00, 949.57, 7280.00, 0, 4, '2026-02-20 17:35:14', '2026-02-20 17:35:14'),
(54, 52, 2, 2, 1.50, 559.42, 0.00, 125.87, 965.00, 0, 1, '2026-02-21 15:13:42', '2026-02-21 15:13:42'),
(55, 53, 2, 2, 2.60, 541.81, 0.00, 211.30, 1620.00, 0, 1, '2026-02-21 15:41:20', '2026-02-21 15:41:20'),
(56, 54, 2, 2, 2.10, 559.01, 0.00, 176.09, 1350.00, 0, 1, '2026-02-22 15:41:17', '2026-02-22 15:41:17'),
(57, 55, 2, 2, 0.90, 628.02, 0.00, 84.78, 650.00, 0, 1, '2026-02-22 18:49:51', '2026-02-22 18:49:51'),
(58, 56, 2, 2, 3.00, 542.03, 0.00, 243.91, 1870.00, 0, 1, '2026-02-22 19:24:54', '2026-02-22 19:24:54'),
(59, 57, 24, 3, 3.00, 536.23, 0.00, 241.30, 1850.00, 0, 1, '2026-02-23 11:22:54', '2026-02-23 11:22:54'),
(60, 58, 8, 2, 3.10, 566.62, 0.00, 263.48, 2020.00, 0, 1, '2026-02-23 18:24:18', '2026-02-23 18:24:18'),
(61, 59, 8, 2, 23.30, 538.91, 0.00, 1883.48, 14440.00, 0, 2, '2026-02-23 19:47:15', '2026-02-23 19:47:15'),
(62, 60, 14, 2, 3.70, 540.54, 0.00, 300.00, 2300.00, 0, 1, '2026-02-24 16:17:33', '2026-02-24 16:17:33'),
(63, 61, 10, 2, 1.30, 581.94, 0.00, 113.48, 870.00, 0, 1, '2026-02-24 17:44:58', '2026-02-24 17:44:58'),
(64, 62, 2, 2, 1.70, 562.66, 0.00, 143.48, 1100.00, 0, 1, '2026-02-25 15:24:14', '2026-02-25 15:24:14'),
(65, 63, 25, 1, 3.40, 562.66, 0.00, 286.96, 2200.00, 0, 3, '2026-02-25 16:53:52', '2026-02-25 16:53:52'),
(66, 64, 12, 2, 1.20, 579.71, 0.00, 104.35, 800.00, 0, 1, '2026-02-25 17:01:55', '2026-02-25 17:01:55'),
(67, 65, 5, 2, 5.00, 539.13, 0.00, 404.35, 3100.00, 0, 1, '2026-02-26 17:22:10', '2026-02-26 17:22:10'),
(68, 66, 26, 2, 1.00, 547.83, 0.00, 82.17, 630.00, 0, 1, '2026-02-26 17:32:45', '2026-02-26 17:32:45'),
(69, 67, 15, 2, 1.40, 571.43, 0.00, 120.00, 920.00, 0, 1, '2026-02-27 15:18:07', '2026-02-27 15:18:07'),
(70, 68, 4, 2, 2.40, 557.97, 0.00, 200.87, 1540.00, 0, 1, '2026-02-27 15:34:36', '2026-02-27 15:34:36'),
(71, 69, 4, 2, 22.80, 525.17, 0.00, 1796.09, 13770.00, 0, 4, '2026-02-27 16:24:18', '2026-02-27 16:24:18'),
(72, 70, 15, 2, 1.10, 592.89, 0.00, 97.83, 750.00, 0, 1, '2026-02-27 18:27:32', '2026-02-27 18:27:32'),
(73, 71, 15, 2, 2.10, 579.71, 0.00, 182.61, 1400.00, 0, 1, '2026-02-27 18:37:28', '2026-02-27 18:37:28'),
(74, 72, 4, 2, 5.50, 569.17, 0.00, 469.57, 3600.00, 0, 1, '2026-02-27 18:53:55', '2026-02-27 18:53:55'),
(75, 73, 2, 2, 0.90, 531.40, 0.00, 71.74, 550.00, 0, 1, '2026-02-28 16:01:00', '2026-02-28 16:01:00'),
(76, 74, 27, 2, 5.20, 576.92, 0.00, 450.00, 3450.00, 0, 1, '2026-02-28 17:17:15', '2026-02-28 17:17:15'),
(77, 75, 2, 2, 1.80, 574.88, 0.00, 155.22, 1190.00, 0, 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(78, 75, 3, 2, 1.80, 560.39, 0.00, 151.30, 1160.00, 0, 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(79, 75, 4, 2, 18.80, 568.92, 0.00, 1604.35, 12300.00, 0, 1, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(80, 76, 6, 3, 2.10, 587.99, 0.00, 185.22, 1420.00, 0, 1, '2026-03-01 16:38:14', '2026-03-01 16:38:14'),
(81, 77, 17, 2, 2.30, 604.91, 0.00, 208.70, 1600.00, 0, 1, '2026-03-01 17:13:38', '2026-03-01 17:13:38'),
(82, 78, 7, 3, 5.70, 599.54, 0.00, 512.61, 3930.00, 0, 1, '2026-03-01 17:39:08', '2026-03-01 17:39:08'),
(83, 79, 2, 2, 1.30, 635.45, 0.00, 123.91, 950.00, 0, 1, '2026-03-01 18:59:59', '2026-03-01 18:59:59'),
(84, 80, 2, 2, 1.40, 608.70, 0.00, 127.83, 980.00, 0, 1, '2026-03-01 19:10:20', '2026-03-01 19:10:20'),
(85, 81, 2, 2, 1.90, 594.97, 0.00, 169.57, 1300.00, 0, 1, '2026-03-01 19:12:50', '2026-03-01 19:12:50'),
(86, 82, 23, 2, 7.30, 540.20, 0.00, 591.52, 4535.00, 0, 2, '2026-03-01 19:19:38', '2026-03-01 19:19:38'),
(87, 83, 28, 1, 1.80, 531.40, 0.00, 143.48, 1100.00, 0, 1, '2026-03-01 19:40:12', '2026-03-01 19:40:12'),
(88, 84, 12, 2, 1.20, 601.45, 0.00, 108.26, 830.00, 0, 1, '2026-03-02 18:13:48', '2026-03-02 18:13:48'),
(89, 85, 14, 2, 13.10, 570.86, 0.00, 1121.74, 8600.00, 0, 1, '2026-03-02 18:17:13', '2026-03-02 18:17:13'),
(90, 86, 2, 2, 2.83, 576.13, 0.00, 244.57, 1875.00, 0, 1, '2026-03-03 10:55:57', '2026-03-03 10:55:57'),
(91, 86, 12, 2, 1.40, 574.53, 0.00, 120.65, 925.00, 0, 1, '2026-03-03 10:55:57', '2026-03-03 10:55:57'),
(92, 87, 6, 3, 3.20, 584.24, 0.00, 280.43, 2150.00, 0, 1, '2026-03-03 10:57:40', '2026-03-03 10:57:40'),
(93, 88, 15, 2, 1.10, 624.51, 0.00, 103.04, 790.00, 0, 1, '2026-03-03 15:12:36', '2026-03-03 15:12:36'),
(94, 89, 29, 2, 4.60, 581.29, 0.00, 401.09, 3075.00, 0, 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(95, 89, 30, 2, 23.20, 560.53, 0.00, 1950.65, 14955.00, 0, 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(96, 89, 31, 2, 22.00, 560.47, 0.00, 1849.57, 14180.00, 0, 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(97, 89, 32, 2, 5.90, 574.80, 0.00, 508.70, 3900.00, 0, 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(98, 89, 33, 2, 8.80, 582.02, 0.00, 768.26, 5890.00, 0, 1, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(99, 90, 4, 2, 5.00, 539.13, 0.00, 404.35, 3100.00, 0, 1, '2026-03-03 19:29:50', '2026-03-03 19:29:50'),
(100, 91, 4, 2, 8.30, 560.50, 0.00, 697.83, 5350.00, 0, 1, '2026-03-03 19:31:19', '2026-03-03 19:31:19'),
(101, 92, 2, 2, 2.40, 561.59, 0.00, 202.17, 1550.00, 0, 1, '2026-03-03 20:11:27', '2026-03-03 20:11:27'),
(102, 93, 4, 2, 11.30, 569.45, 0.00, 965.22, 7400.00, 0, 2, '2026-03-04 01:20:24', '2026-03-04 01:20:24'),
(103, 94, 4, 2, 48.40, 558.75, 0.00, 4056.52, 31100.00, 0, 1, '2026-03-04 16:39:19', '2026-03-04 16:39:19'),
(104, 95, 15, 2, 5.60, 569.10, 0.00, 478.04, 3665.00, 0, 1, '2026-03-04 17:30:40', '2026-03-04 17:30:40'),
(105, 95, 32, 2, 1.20, 568.84, 0.00, 102.39, 785.00, 0, 1, '2026-03-04 17:30:40', '2026-03-04 17:30:40'),
(106, 96, 4, 2, 11.60, 577.21, 0.00, 1004.35, 7700.00, 0, 1, '2026-03-04 17:37:38', '2026-03-04 17:37:38'),
(107, 97, 15, 2, 2.40, 561.59, 0.00, 202.17, 1550.00, 0, 1, '2026-03-05 16:26:39', '2026-03-05 16:26:39'),
(108, 98, 34, 1, 0.60, 579.71, 0.00, 52.17, 400.00, 0, 1, '2026-03-05 16:54:35', '2026-03-05 16:54:35'),
(109, 99, 2, 2, 1.22, 598.72, 0.00, 109.57, 840.00, 0, 1, '2026-03-05 17:44:17', '2026-03-05 17:44:17'),
(110, 100, 10, 2, 7.00, 552.80, 0.00, 580.43, 4450.00, 0, 1, '2026-03-05 18:11:24', '2026-03-05 18:11:24'),
(111, 101, 12, 2, 0.90, 531.40, 0.00, 71.74, 550.00, 0, 1, '2026-03-05 18:20:48', '2026-03-05 18:20:48'),
(112, 102, 26, 2, 1.00, 652.17, 0.00, 97.83, 750.00, 0, 1, '2026-03-05 20:00:42', '2026-03-05 20:00:42'),
(113, 103, 4, 2, 18.40, 564.74, 0.00, 1558.70, 11950.00, 0, 3, '2026-03-06 15:13:00', '2026-03-06 15:13:00'),
(114, 104, 2, 2, 1.20, 579.71, 0.00, 104.35, 800.00, 0, 1, '2026-03-06 15:17:32', '2026-03-06 15:17:32'),
(115, 105, 2, 2, 2.30, 586.01, 0.00, 202.17, 1550.00, 0, 1, '2026-03-06 16:44:47', '2026-03-06 16:44:47'),
(116, 106, 15, 2, 1.70, 613.81, 0.00, 156.52, 1200.00, 0, 1, '2026-03-06 17:09:17', '2026-03-06 17:09:17'),
(117, 107, 6, 3, 2.90, 578.71, 0.00, 251.74, 1930.00, 0, 1, '2026-03-06 18:05:08', '2026-03-06 18:05:08'),
(118, 108, 26, 2, 8.20, 583.24, 0.00, 717.39, 5500.00, 0, 1, '2026-03-06 18:07:47', '2026-03-06 18:07:47'),
(119, 109, 4, 2, 7.70, 564.65, 0.00, 652.17, 5000.00, 0, 1, '2026-03-06 18:09:07', '2026-03-06 18:09:07'),
(120, 110, 4, 2, 25.00, 579.13, 0.00, 2171.74, 16650.00, 0, 1, '2026-03-06 18:26:35', '2026-03-06 18:26:35'),
(121, 111, 4, 2, 14.70, 561.96, 0.00, 1239.13, 9500.00, 0, 1, '2026-03-07 02:19:52', '2026-03-07 02:19:52'),
(122, 112, 12, 2, 2.30, 567.11, 0.00, 195.65, 1500.00, 0, 1, '2026-03-07 15:13:45', '2026-03-07 15:13:45'),
(123, 113, 4, 2, 9.80, 572.32, 0.00, 841.30, 6450.00, 0, 1, '2026-03-07 15:26:02', '2026-03-07 15:26:02'),
(124, 114, 35, 1, 2.40, 543.48, 0.00, 195.65, 1500.00, 0, 1, '2026-03-07 15:52:09', '2026-03-07 15:52:09'),
(125, 115, 4, 2, 8.70, 569.72, 0.00, 743.48, 5700.00, 0, 3, '2026-03-07 18:08:46', '2026-03-07 18:08:46'),
(126, 116, 24, 3, 2.30, 612.48, 0.00, 211.30, 1620.00, 0, 1, '2026-03-07 18:28:29', '2026-03-07 18:28:29'),
(127, 117, 8, 2, 16.00, 586.96, 0.00, 1408.70, 10800.00, 0, 1, '2026-03-07 18:30:40', '2026-03-07 18:30:40'),
(128, 118, 11, 1, 3.00, 573.91, 0.00, 258.26, 1980.00, 0, 1, '2026-03-07 20:16:10', '2026-03-07 20:16:10'),
(129, 119, 10, 2, 3.40, 570.33, 0.00, 290.87, 2230.00, 0, 1, '2026-03-08 11:07:29', '2026-03-08 11:07:29'),
(130, 120, 4, 2, 12.20, 560.23, 0.00, 1025.22, 7860.00, 0, 1, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(131, 120, 12, 2, 1.60, 576.09, 0.00, 138.26, 1060.00, 0, 1, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(132, 121, 31, 2, 15.10, 585.66, 0.00, 1326.52, 10170.00, 0, 2, '2026-03-08 16:19:15', '2026-03-08 16:19:15'),
(133, 122, 8, 2, 28.20, 582.79, 0.00, 2465.22, 18900.00, 0, 1, '2026-03-08 16:21:09', '2026-03-08 16:21:09'),
(134, 123, 31, 2, 13.70, 558.55, 0.00, 1147.83, 8800.00, 0, 1, '2026-03-08 16:55:00', '2026-03-08 16:55:00'),
(135, 124, 4, 2, 25.00, 539.13, 0.00, 2021.74, 15500.00, 0, 4, '2026-03-08 18:31:58', '2026-03-08 18:31:58'),
(136, 125, 17, 2, 7.90, 561.36, 0.00, 665.22, 5100.00, 0, 1, '2026-03-08 20:07:08', '2026-03-08 20:07:08'),
(137, 126, 2, 2, 1.70, 578.01, 0.00, 147.39, 1130.00, 0, 1, '2026-03-08 20:09:20', '2026-03-08 20:09:20'),
(138, 127, 12, 2, 2.80, 562.11, 0.00, 236.09, 1810.00, 0, 1, '2026-03-08 20:19:03', '2026-03-08 20:19:03'),
(139, 128, 10, 2, 1.60, 565.22, 0.00, 135.65, 1040.00, 0, 1, '2026-03-09 11:24:17', '2026-03-09 11:24:17'),
(140, 129, 2, 2, 1.40, 565.22, 0.00, 118.70, 910.00, 0, 1, '2026-03-11 15:54:42', '2026-03-11 15:54:42'),
(141, 130, 4, 2, 11.00, 559.68, 0.00, 923.48, 7080.00, 0, 1, '2026-03-11 16:00:43', '2026-03-11 16:00:43'),
(142, 131, 12, 2, 3.30, 582.35, 0.00, 288.26, 2210.00, 0, 1, '2026-03-11 17:35:50', '2026-03-11 17:35:50'),
(143, 132, 2, 2, 0.74, 646.30, 0.00, 71.74, 550.00, 0, 1, '2026-03-11 17:37:44', '2026-03-11 17:37:44'),
(144, 133, 15, 2, 1.50, 579.71, 0.00, 130.43, 1000.00, 0, 1, '2026-03-12 01:40:19', '2026-03-12 01:40:19'),
(145, 134, 2, 2, 1.80, 555.56, 0.00, 150.00, 1150.00, 0, 1, '2026-03-12 15:38:38', '2026-03-12 15:38:38'),
(146, 135, 2, 2, 1.90, 572.08, 0.00, 163.04, 1250.00, 0, 1, '2026-03-12 15:39:42', '2026-03-12 15:39:42'),
(147, 136, 27, 2, 1.50, 579.71, 0.00, 130.43, 1000.00, 0, 1, '2026-03-12 16:46:40', '2026-03-12 16:46:40'),
(148, 137, 12, 2, 2.00, 560.87, 0.00, 168.26, 1290.00, 0, 1, '2026-03-12 17:49:31', '2026-03-12 17:49:31'),
(149, 138, 7, 3, 2.60, 568.56, 0.00, 221.74, 1700.00, 0, 1, '2026-03-12 18:36:50', '2026-03-12 18:36:50'),
(150, 139, 2, 2, 1.70, 562.66, 0.00, 143.48, 1100.00, 0, 1, '2026-03-12 20:03:54', '2026-03-12 20:03:54'),
(151, 140, 17, 2, 3.00, 573.91, 0.00, 258.26, 1980.00, 0, 1, '2026-03-13 01:34:34', '2026-03-13 01:34:34'),
(152, 141, 4, 2, 12.10, 546.17, 0.00, 991.30, 7600.00, 0, 2, '2026-03-13 15:34:13', '2026-03-13 15:34:13'),
(153, 142, 2, 2, 2.70, 579.71, 0.00, 234.78, 1800.00, 0, 1, '2026-03-13 16:33:09', '2026-03-13 16:33:09'),
(154, 143, 10, 2, 2.60, 568.56, 0.00, 221.74, 1700.00, 0, 1, '2026-03-13 16:49:34', '2026-03-13 16:49:34'),
(155, 144, 12, 2, 0.90, 579.71, 0.00, 78.26, 600.00, 0, 1, '2026-03-13 17:03:23', '2026-03-13 17:03:23'),
(156, 145, 16, 1, 1.70, 547.31, 0.00, 139.57, 1070.00, 0, 1, '2026-03-13 17:39:23', '2026-03-13 17:39:23'),
(157, 146, 25, 1, 0.40, 652.17, 0.00, 39.13, 300.00, 0, 1, '2026-03-13 18:18:59', '2026-03-13 18:18:59'),
(158, 147, 7, 3, 2.60, 568.56, 0.00, 221.74, 1700.00, 0, 1, '2026-03-13 18:50:15', '2026-03-13 18:50:15'),
(159, 148, 15, 2, 1.90, 581.24, 0.00, 165.65, 1270.00, 0, 1, '2026-03-13 20:52:01', '2026-03-13 20:52:01'),
(160, 148, 17, 2, 2.10, 579.71, 0.00, 182.61, 1400.00, 0, 1, '2026-03-13 20:52:01', '2026-03-13 20:52:01'),
(161, 149, 11, 1, 11.60, 547.23, 0.00, 952.17, 7300.00, 0, 1, '2026-03-14 00:01:22', '2026-03-14 00:01:22'),
(162, 150, 32, 2, 3.90, 568.56, 0.00, 332.61, 2550.00, 0, 1, '2026-03-14 01:55:57', '2026-03-14 01:55:57'),
(163, 151, 26, 2, 2.44, 534.57, 0.00, 195.65, 1500.00, 0, 1, '2026-03-14 15:57:48', '2026-03-14 15:57:48'),
(164, 152, 2, 2, 1.60, 543.48, 0.00, 130.43, 1000.00, 0, 1, '2026-03-14 15:59:16', '2026-03-14 15:59:16'),
(165, 153, 15, 2, 4.80, 561.59, 0.00, 404.35, 3100.00, 0, 1, '2026-03-14 16:10:06', '2026-03-14 16:10:06'),
(166, 154, 12, 2, 1.40, 590.06, 0.00, 123.91, 950.00, 0, 1, '2026-03-14 16:55:05', '2026-03-14 16:55:05'),
(167, 155, 2, 2, 4.10, 551.43, 0.00, 339.13, 2600.00, 0, 2, '2026-03-14 19:54:02', '2026-03-14 19:54:02'),
(168, 156, 6, 3, 1.40, 559.01, 0.00, 117.39, 900.00, 0, 1, '2026-03-14 20:04:37', '2026-03-14 20:04:37'),
(169, 157, 4, 2, 3.10, 546.98, 0.00, 254.35, 1950.00, 0, 1, '2026-03-15 01:50:37', '2026-03-15 01:50:37'),
(170, 158, 12, 2, 1.90, 540.05, 0.00, 153.91, 1180.00, 0, 1, '2026-03-15 11:13:17', '2026-03-15 11:13:17'),
(171, 158, 15, 2, 1.90, 389.02, 0.00, 110.87, 850.00, 0, 1, '2026-03-15 11:13:17', '2026-03-15 11:13:17'),
(172, 158, 20, 1, 0.70, 645.96, 0.00, 67.83, 520.00, 0, 1, '2026-03-15 11:13:17', '2026-03-15 11:13:17'),
(173, 159, 25, 1, 1.20, 579.71, 0.00, 104.35, 800.00, 0, 1, '2026-03-15 11:34:52', '2026-03-15 11:34:52'),
(174, 160, 23, 2, 8.00, 597.83, 0.00, 717.39, 5500.00, 0, 1, '2026-03-15 16:50:15', '2026-03-15 16:50:15'),
(175, 161, 14, 2, 3.50, 571.43, 0.00, 300.00, 2300.00, 0, 1, '2026-03-15 19:17:25', '2026-03-15 19:17:25'),
(176, 162, 2, 2, 2.20, 571.15, 0.00, 188.48, 1445.00, 0, 2, '2026-03-16 01:39:44', '2026-03-16 01:39:44'),
(177, 163, 4, 2, 6.80, 549.87, 0.00, 560.87, 4300.00, 0, 2, '2026-03-16 11:04:34', '2026-03-16 11:04:34'),
(178, 164, 5, 2, 0.90, 555.56, 0.00, 75.00, 575.00, 0, 1, '2026-03-16 20:07:04', '2026-03-16 20:07:04'),
(179, 165, 8, 2, 11.10, 536.62, 0.00, 893.48, 6850.00, 0, 1, '2026-03-17 19:14:39', '2026-03-17 19:14:39'),
(180, 166, 32, 2, 2.80, 559.01, 0.00, 234.78, 1800.00, 0, 1, '2026-03-17 19:41:20', '2026-03-17 19:41:20'),
(181, 167, 8, 2, 7.70, 530.77, 0.00, 613.04, 4700.00, 0, 1, '2026-03-18 02:36:33', '2026-03-18 02:36:33'),
(182, 167, 12, 2, 2.80, 559.01, 0.00, 234.78, 1800.00, 0, 1, '2026-03-18 02:36:33', '2026-03-18 02:36:33'),
(183, 168, 12, 2, 3.40, 562.66, 0.00, 286.96, 2200.00, 0, 2, '2026-03-18 16:30:10', '2026-03-18 16:30:10'),
(184, 169, 2, 2, 1.40, 559.01, 0.00, 117.39, 900.00, 0, 1, '2026-03-18 16:30:51', '2026-03-18 16:30:51'),
(185, 170, 14, 2, 1.30, 568.56, 0.00, 110.87, 850.00, 0, 1, '2026-03-18 17:43:09', '2026-03-18 17:43:09'),
(186, 171, 2, 2, 3.30, 521.74, 0.00, 258.26, 1980.00, 0, 1, '2026-03-18 17:57:54', '2026-03-18 17:57:54'),
(187, 172, 4, 2, 50.00, 495.65, 0.00, 3717.39, 28500.00, 0, 6, '2026-03-18 18:22:46', '2026-03-18 18:22:46'),
(188, 172, 13, 1, 0.40, 869.57, 0.00, 52.17, 400.00, 0, 1, '2026-03-18 18:22:46', '2026-03-18 18:22:46'),
(189, 173, 15, 2, 2.00, 552.17, 0.00, 165.65, 1270.00, 0, 1, '2026-03-18 19:13:21', '2026-03-18 19:13:21'),
(190, 174, 2, 2, 1.30, 575.25, 0.00, 112.17, 860.00, 0, 1, '2026-03-18 20:01:45', '2026-03-18 20:01:45'),
(191, 175, 14, 2, 2.70, 547.50, 0.00, 221.74, 1700.00, 0, 1, '2026-03-19 16:50:02', '2026-03-19 16:50:02'),
(192, 176, 6, 3, 3.40, 537.08, 0.00, 273.91, 2100.00, 0, 1, '2026-03-23 12:32:35', '2026-03-23 12:32:35'),
(193, 177, 2, 2, 2.30, 519.85, 0.00, 179.35, 1375.00, 0, 1, '2026-03-23 13:59:10', '2026-03-23 13:59:10'),
(194, 178, 2, 2, 2.30, 527.41, 0.00, 181.96, 1395.00, 0, 1, '2026-03-23 16:58:42', '2026-03-23 16:58:42'),
(195, 179, 7, 3, 16.30, 485.46, 0.00, 1186.96, 9100.00, 0, 3, '2026-03-23 17:26:19', '2026-03-23 17:26:19'),
(196, 180, 15, 2, 2.50, 528.70, 0.00, 198.26, 1520.00, 0, 1, '2026-03-24 04:42:14', '2026-03-24 04:42:14'),
(197, 181, 36, 3, 5.10, 512.36, 0.00, 391.96, 3005.00, 0, 1, '2026-03-24 11:46:43', '2026-03-24 11:46:43'),
(198, 182, 12, 2, 1.60, 489.13, 0.00, 117.39, 900.00, 0, 1, '2026-03-24 13:37:41', '2026-03-24 13:37:41'),
(199, 183, 12, 2, 2.80, 512.42, 0.00, 215.22, 1650.00, 0, 2, '2026-03-24 15:53:22', '2026-03-24 15:53:22'),
(200, 184, 4, 2, 22.10, 480.03, 0.00, 1591.30, 12200.00, 0, 3, '2026-03-24 16:02:13', '2026-03-24 16:02:13'),
(201, 185, 2, 2, 1.41, 530.37, 0.00, 112.17, 860.00, 0, 1, '2026-03-24 16:40:32', '2026-03-24 16:40:32'),
(202, 186, 4, 2, 30.00, 484.93, 0.00, 2182.17, 16730.00, 0, 1, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(203, 186, 11, 1, 15.50, 484.71, 0.00, 1126.96, 8640.00, 0, 1, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(204, 187, 2, 2, 2.60, 468.23, 0.00, 182.61, 1400.00, 0, 1, '2026-03-25 15:12:41', '2026-03-25 15:12:41'),
(205, 188, 2, 2, 1.08, 499.19, 0.00, 80.87, 620.00, 0, 1, '2026-03-25 17:28:06', '2026-03-25 17:28:06'),
(206, 189, 12, 2, 1.90, 491.99, 0.00, 140.22, 1075.00, 0, 1, '2026-03-26 14:59:41', '2026-03-26 14:59:41'),
(207, 190, 17, 2, 1.10, 513.83, 0.00, 84.78, 650.00, 0, 1, '2026-03-26 15:50:36', '2026-03-26 15:50:36'),
(208, 191, 12, 2, 3.00, 463.77, 0.00, 208.70, 1600.00, 0, 1, '2026-03-26 15:56:18', '2026-03-26 15:56:18'),
(209, 192, 14, 2, 3.90, 479.38, 0.00, 280.43, 2150.00, 0, 1, '2026-03-26 16:58:35', '2026-03-26 16:58:35'),
(210, 193, 8, 2, 14.48, 486.43, 0.00, 1056.52, 8100.00, 0, 1, '2026-03-27 11:28:24', '2026-03-27 11:28:24'),
(211, 194, 5, 2, 0.60, 608.70, 0.00, 54.78, 420.00, 0, 1, '2026-03-27 11:33:24', '2026-03-27 11:33:24'),
(212, 194, 17, 2, 1.10, 498.02, 0.00, 82.17, 630.00, 0, 1, '2026-03-27 11:33:24', '2026-03-27 11:33:24'),
(213, 195, 15, 2, 2.80, 496.89, 0.00, 208.70, 1600.00, 0, 1, '2026-03-27 15:24:44', '2026-03-27 15:24:44'),
(214, 196, 14, 2, 5.20, 493.31, 0.00, 384.78, 2950.00, 0, 1, '2026-03-27 16:05:46', '2026-03-27 16:05:46'),
(215, 197, 2, 2, 1.90, 526.32, 0.00, 150.00, 1150.00, 0, 1, '2026-03-27 17:04:33', '2026-03-27 17:04:33'),
(216, 198, 10, 2, 11.70, 483.09, 0.00, 847.83, 6500.00, 0, 4, '2026-03-28 12:00:27', '2026-03-28 12:00:27'),
(217, 199, 6, 3, 3.90, 499.44, 0.00, 292.17, 2240.00, 0, 1, '2026-03-28 13:43:42', '2026-03-28 13:43:42'),
(218, 200, 4, 2, 12.10, 481.49, 0.00, 873.91, 6700.00, 0, 1, '2026-03-28 14:58:46', '2026-03-28 14:58:46'),
(219, 200, 32, 2, 3.90, 490.52, 0.00, 286.96, 2200.00, 0, 1, '2026-03-28 14:58:46', '2026-03-28 14:58:46'),
(220, 201, 20, 1, 7.00, 447.20, 0.00, 469.57, 3600.00, 0, 2, '2026-03-28 15:33:33', '2026-03-28 15:33:33'),
(221, 202, 12, 2, 1.00, 478.26, 0.00, 71.74, 550.00, 0, 1, '2026-03-28 16:30:04', '2026-03-28 16:30:04'),
(222, 203, 12, 2, 2.00, 521.74, 0.00, 156.52, 1200.00, 0, 1, '2026-03-28 17:00:07', '2026-03-28 17:00:07'),
(223, 204, 8, 2, 1.50, 510.14, 0.00, 114.78, 880.00, 0, 1, '2026-03-29 13:20:49', '2026-03-29 13:20:49'),
(224, 205, 4, 2, 11.30, 484.80, 0.00, 821.74, 6300.00, 0, 1, '2026-03-29 15:07:38', '2026-03-29 15:07:38'),
(225, 206, 2, 2, 2.70, 483.09, 0.00, 195.65, 1500.00, 0, 1, '2026-03-29 17:10:35', '2026-03-29 17:10:35'),
(226, 207, 11, 1, 3.30, 421.61, 0.00, 208.70, 1600.00, 0, 1, '2026-03-29 17:20:42', '2026-03-29 17:20:42'),
(227, 208, 12, 2, 3.10, 476.86, 0.00, 221.74, 1700.00, 0, 1, '2026-03-31 10:55:54', '2026-03-31 10:55:54'),
(228, 209, 10, 2, 1.40, 496.89, 0.00, 104.35, 800.00, 0, 1, '2026-03-31 13:36:34', '2026-03-31 13:36:34'),
(229, 210, 12, 2, 2.00, 478.26, 0.00, 143.48, 1100.00, 0, 1, '2026-03-31 15:16:02', '2026-03-31 15:16:02'),
(230, 211, 32, 2, 2.90, 524.74, 0.00, 228.26, 1750.00, 0, 1, '2026-04-01 05:30:16', '2026-04-01 05:30:16'),
(231, 212, 3, 2, 6.20, 519.64, 0.00, 483.26, 3705.00, 0, 1, '2026-04-01 17:24:46', '2026-04-01 17:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `exit_work_tax_details`
--

CREATE TABLE `exit_work_tax_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(8,2) NOT NULL,
  `gram_tax` decimal(8,2) NOT NULL,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `docNumber` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `from_account` int(11) NOT NULL,
  `to_account` int(11) NOT NULL,
  `client` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `payment_type` int(11) NOT NULL,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_categories`
--

CREATE TABLE `expenses_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `account_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `account_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `gold_converts`
--

CREATE TABLE `gold_converts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `doc_number` varchar(191) NOT NULL,
  `total21weight` decimal(8,2) NOT NULL,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gold_convert_items`
--

CREATE TABLE `gold_convert_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `docId` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `weight21` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `infos`
--

CREATE TABLE `infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventorys`
--

CREATE TABLE `inventorys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `state` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_details`
--

CREATE TABLE `inventory_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `new_quantity` double NOT NULL,
  `state` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `isroles`
--

CREATE TABLE `isroles` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `category_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `no_metal` decimal(8,2) NOT NULL DEFAULT 0.00,
  `no_metal_type` int(11) NOT NULL,
  `made_Value` decimal(8,2) DEFAULT 0.00,
  `item_type` int(11) NOT NULL,
  `tax` decimal(8,2) DEFAULT 0.00,
  `price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `multi` tinyint(4) DEFAULT 0,
  `supplier_id` smallint(6) DEFAULT NULL,
  `supplier_bill_number` varchar(100) DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `img` varchar(191) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `code`, `name_ar`, `name_en`, `branch_id`, `category_id`, `karat_id`, `weight`, `no_metal`, `no_metal_type`, `made_Value`, `item_type`, `tax`, `price`, `cost`, `multi`, `supplier_id`, `supplier_bill_number`, `state`, `img`, `quantity`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '000001', 'تجريبي', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-01 17:23:12', '2026-02-01 17:23:12'),
(2, '000002', 'خاتم عيار 21', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 04:56:35', '2026-02-03 04:56:35'),
(3, '000003', 'سلسال 21', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 05:00:04', '2026-02-03 05:00:04'),
(4, '000004', 'بناجر', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 05:05:13', '2026-02-03 05:05:13'),
(5, '000005', 'شوكر', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 14:28:37', '2026-02-03 14:28:37'),
(6, '000006', 'خاتم', ' ', 1, 1, 3, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 14:29:39', '2026-02-03 14:29:39'),
(7, '000007', 'سلسال', ' ', 1, 1, 3, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 14:29:59', '2026-02-03 14:29:59'),
(8, '000008', 'اساور', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 14:30:21', '2026-02-03 14:30:21'),
(9, '000009', 'سواره', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 14:30:36', '2026-02-03 14:30:36'),
(10, '000010', 'انسيال', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 14:31:07', '2026-02-03 14:31:07'),
(11, '000011', 'طقم', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 14:32:18', '2026-02-03 14:32:18'),
(12, '000012', 'حلق', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 17:13:58', '2026-02-03 17:13:58'),
(13, '000013', 'حلق عيار 18', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 17:24:48', '2026-02-03 17:24:48'),
(14, '000014', 'عقد', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-03 17:25:30', '2026-02-03 17:25:30'),
(15, '000015', 'دبله 21', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-04 11:24:44', '2026-02-04 11:24:44'),
(16, '000016', 'دبله', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-04 11:25:04', '2026-02-04 11:25:04'),
(17, '000017', 'كف', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-04 14:32:05', '2026-02-04 14:32:05'),
(18, '000018', 'طقم ملكي', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-07 15:18:16', '2026-02-07 15:18:16'),
(19, '000019', 'تعليقه 22', ' ', 1, 1, 3, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-11 16:52:45', '2026-02-11 16:52:45'),
(20, '000020', 'انسيال عيار 18', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-13 12:46:54', '2026-02-13 12:46:54'),
(21, '000021', 'اسوره عيار 18', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-13 12:49:44', '2026-02-13 12:49:44'),
(22, '000022', 'خلخال 21', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-17 12:18:02', '2026-02-17 12:18:02'),
(23, '000023', 'نصف طقم 21', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-19 19:07:33', '2026-02-19 19:07:33'),
(24, '000024', 'حلق 22', ' ', 1, 1, 3, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-23 11:22:20', '2026-02-23 11:22:20'),
(25, '000025', 'شوكر 18', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-25 16:52:29', '2026-02-25 16:52:29'),
(26, '000026', 'تعليقه 21', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-26 17:31:46', '2026-02-26 17:31:46'),
(27, '000027', 'طقم 21', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-02-28 17:16:23', '2026-02-28 17:16:23'),
(28, '000028', 'خاتم 18', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-01 19:39:37', '2026-03-01 19:39:37'),
(29, '000029', 'اسوره فان كليف', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-03 18:26:33', '2026-03-03 18:26:33'),
(30, '000030', 'بناجر كوبره', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-03 18:27:56', '2026-03-03 18:27:56'),
(31, '000031', 'بناجر ورده', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-03 18:29:11', '2026-03-03 18:29:11'),
(32, '000032', 'خاتم وتر', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-03 18:29:33', '2026-03-03 18:29:33'),
(33, '000033', 'اسوره حرير', ' ', 1, 1, 2, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-03 18:30:07', '2026-03-03 18:30:07'),
(34, '000034', 'حلق طبي', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-05 16:53:22', '2026-03-05 16:53:22'),
(35, '000035', 'نص طقم  18', ' ', 1, 1, 1, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-07 15:51:07', '2026-03-07 15:51:07'),
(36, '000036', 'سلسال 22', ' ', 1, 1, 3, 0.00, 0.00, 1, 0.00, 1, 15.00, 0.00, 0.00, 1, 0, '0', 1, '', 0, 1, '2026-03-24 11:44:01', '2026-03-24 11:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `items_collectibles`
--

CREATE TABLE `items_collectibles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `category_id` int(11) NOT NULL,
  `karat_id` int(11) DEFAULT 0,
  `weight` decimal(8,2) DEFAULT 0.00,
  `no_metal` decimal(8,2) DEFAULT 0.00,
  `no_metal_type` int(11) DEFAULT 0,
  `made_Value` decimal(8,2) DEFAULT 0.00,
  `item_type` int(11) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `stone_type` varchar(255) DEFAULT NULL,
  `stone_purity` varchar(100) DEFAULT NULL,
  `stone_color` varchar(100) DEFAULT NULL,
  `stone_size` varchar(50) DEFAULT NULL,
  `metal_weight` decimal(8,2) DEFAULT NULL,
  `other_properties1` varchar(100) DEFAULT NULL,
  `other_properties2` varchar(100) DEFAULT NULL,
  `other_properties3` varchar(100) DEFAULT NULL,
  `tax` decimal(8,2) DEFAULT 0.00,
  `price` decimal(20,2) DEFAULT 0.00,
  `cost` decimal(20,2) DEFAULT 0.00,
  `state` int(11) NOT NULL DEFAULT -1,
  `img` varchar(191) DEFAULT NULL,
  `att_file` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_materials`
--

CREATE TABLE `item_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `basedon_no` varchar(255) NOT NULL,
  `basedon_id` int(11) NOT NULL,
  `baseon_text` varchar(255) NOT NULL,
  `total_credit` double NOT NULL,
  `total_debit` double NOT NULL,
  `notes` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journals`
--

INSERT INTO `journals` (`id`, `branch_id`, `date`, `basedon_no`, `basedon_id`, `baseon_text`, `total_credit`, `total_debit`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-02-01 23:23:00', 'ME-1-000001', 1, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(2, 1, '2026-02-01 20:24:00', 'SWSI-1-000001', 1, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(3, 1, '2026-02-03 21:04:00', 'ME-1-000002', 2, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(4, 1, '2026-02-03 18:06:02', 'SWSI-1-000002', 2, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(5, 1, '2026-02-03 23:01:00', 'ME-1-000003', 3, 'مستند قبض', 0, 0, '', NULL, NULL),
(6, 1, '2026-02-03 20:03:57', 'SWSI-1-000003', 3, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(7, 1, '2026-02-03 23:14:00', 'ME-1-000004', 4, 'مستند قبض', 0, 0, '', NULL, NULL),
(8, 1, '2026-02-03 20:15:53', 'SWSI-1-000004', 4, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(9, 1, '2026-02-03 23:16:00', 'ME-1-000005', 5, 'مستند قبض', 0, 0, '', NULL, NULL),
(10, 1, '2026-02-03 20:17:48', 'SWSI-1-000005', 5, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(11, 1, '2026-02-04 17:25:00', 'ME-1-000006', 6, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(12, 1, '2026-02-04 14:26:21', 'SWSI-1-000006', 6, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(13, 1, '2026-02-04 17:27:00', 'ME-1-000007', 7, 'مستند قبض', 0, 0, '', NULL, NULL),
(14, 1, '2026-02-04 14:27:27', 'SWSI-1-000007', 7, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(15, 1, '2026-02-04 20:32:00', 'ME-1-000008', 8, 'مستند قبض', 0, 0, '', NULL, NULL),
(16, 1, '2026-02-04 20:32:00', 'ME-1-000009', 9, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(17, 1, '2026-02-04 17:33:13', 'SWSI-1-000008', 8, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(18, 1, '2026-02-04 21:38:00', 'ME-1-000010', 10, 'مستند قبض', 0, 0, '', NULL, NULL),
(19, 1, '2026-02-04 18:39:11', 'SWSI-1-000009', 9, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(20, 1, '2026-02-05 22:19:00', 'ME-1-000011', 11, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(21, 1, '2026-02-05 19:19:02', 'SWSI-1-000010', 10, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(22, 1, '2026-02-05 22:48:00', 'ME-1-000012', 12, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(23, 1, '2026-02-05 19:48:01', 'SWSI-1-000011', 11, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(24, 1, '2026-02-06 17:55:00', 'ME-1-000013', 13, 'مستند قبض', 0, 0, '', NULL, NULL),
(25, 1, '2026-02-06 17:55:00', 'ME-1-000014', 14, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(26, 1, '2026-02-06 14:55:36', 'SWSI-1-000012', 12, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(27, 1, '2026-02-06 21:43:00', 'ME-1-000015', 15, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(28, 1, '2026-02-06 18:43:11', 'SWSI-1-000013', 13, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(29, 1, '2026-02-06 22:19:00', 'ME-1-000016', 16, 'مستند قبض', 0, 0, '', NULL, NULL),
(30, 1, '2026-02-06 19:19:35', 'SWSI-1-000014', 14, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(31, 1, '2026-02-07 21:17:00', 'ME-1-000017', 17, 'مستند قبض', 0, 0, '', NULL, NULL),
(32, 1, '2026-02-07 18:22:15', 'SWSI-1-000015', 15, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(33, 1, '2026-02-08 17:56:00', 'ME-1-000018', 18, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(34, 1, '2026-02-08 14:57:28', 'SWSI-1-000016', 16, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(35, 1, '2026-02-08 18:00:00', 'ME-1-000019', 19, 'مستند قبض', 0, 0, '', NULL, NULL),
(36, 1, '2026-02-08 16:50:10', 'SWSI-1-000017', 17, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(37, 1, '2026-02-09 19:11:00', 'ME-1-000020', 20, 'مستند قبض', 0, 0, '', NULL, NULL),
(38, 1, '2026-02-09 16:10:57', 'SWSI-1-000018', 18, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(39, 1, '2026-02-09 19:21:00', 'ME-1-000021', 21, 'مستند قبض', 0, 0, '', NULL, NULL),
(40, 1, '2026-02-09 16:22:03', 'SWSI-1-000019', 19, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(41, 1, '2026-02-09 19:26:00', 'ME-1-000022', 22, 'مستند قبض', 0, 0, '', NULL, NULL),
(42, 1, '2026-02-09 16:26:32', 'SWSI-1-000020', 20, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(43, 1, '2026-02-10 18:15:00', 'ME-1-000023', 23, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(44, 1, '2026-02-10 15:15:26', 'SWSI-1-000021', 21, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(45, 1, '2026-02-11 19:21:00', 'ME-1-000024', 24, 'مستند قبض', 0, 0, '', NULL, NULL),
(46, 1, '2026-02-11 16:21:13', 'SWSI-1-000022', 22, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(47, 1, '2026-02-11 19:23:00', 'ME-1-000025', 25, 'مستند قبض', 0, 0, '', NULL, NULL),
(48, 1, '2026-02-11 16:23:42', 'SWSI-1-000023', 23, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(49, 1, '2026-02-11 21:23:00', 'ME-1-000026', 26, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(50, 1, '2026-02-11 18:26:05', 'SWSI-1-000024', 24, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(51, 1, '2026-02-11 21:27:00', 'ME-1-000027', 27, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(52, 1, '2026-02-11 18:28:05', 'SWSI-1-000025', 25, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(53, 1, '2026-02-11 21:30:00', 'ME-1-000028', 28, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(54, 1, '2026-02-11 18:30:40', 'SWSI-1-000026', 26, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(55, 1, '2026-02-11 22:25:00', 'ME-1-000029', 29, 'مستند قبض', 0, 0, '', NULL, NULL),
(56, 1, '2026-02-11 19:25:57', 'SWSI-1-000027', 27, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(57, 1, '2026-02-11 22:46:00', 'ME-1-000030', 30, 'مستند قبض', 0, 0, '', NULL, NULL),
(58, 1, '2026-02-11 19:47:31', 'SWSI-1-000028', 28, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(59, 1, '2026-02-11 22:48:00', 'ME-1-000031', 31, 'مستند قبض', 0, 0, '', NULL, NULL),
(60, 1, '2026-02-11 19:49:10', 'SWSI-1-000029', 29, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(61, 1, '2026-02-11 22:53:00', 'ME-1-000032', 32, 'مستند قبض', 0, 0, '', NULL, NULL),
(62, 1, '2026-02-11 19:53:50', 'SWSI-1-000030', 30, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(63, 1, '2026-02-11 23:20:00', 'ME-1-000033', 33, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(64, 1, '2026-02-11 20:23:11', 'SWSI-1-000031', 31, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(65, 1, '2026-02-11 23:25:00', 'ME-1-000034', 34, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(66, 1, '2026-02-11 20:25:04', 'SWSI-1-000032', 32, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(67, 1, '2026-02-12 19:19:00', 'ME-1-000035', 35, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(68, 1, '2026-02-12 16:20:19', 'SWSI-1-000033', 33, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(69, 1, '2026-02-12 21:01:00', 'ME-1-000036', 36, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(70, 1, '2026-02-12 18:02:44', 'SWSI-1-000034', 34, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(71, 1, '2026-02-13 18:47:00', 'ME-1-000037', 37, 'مستند قبض', 0, 0, '', NULL, NULL),
(72, 1, '2026-02-13 15:48:52', 'SWSI-1-000035', 35, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(73, 1, '2026-02-13 18:50:00', 'ME-1-000038', 38, 'مستند قبض', 0, 0, '', NULL, NULL),
(74, 1, '2026-02-13 15:50:38', 'SWSI-1-000036', 36, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(75, 1, '2026-02-13 19:35:00', 'ME-1-000039', 39, 'مستند قبض', 0, 0, '', NULL, NULL),
(76, 1, '2026-02-13 16:35:14', 'SWSI-1-000037', 37, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(77, 1, '2026-02-13 22:35:00', 'ME-1-000040', 40, 'مستند قبض', 0, 0, '', NULL, NULL),
(78, 1, '2026-02-13 22:35:00', 'ME-1-000041', 41, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(79, 1, '2026-02-13 19:36:05', 'SWSI-1-000038', 38, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(80, 1, '2026-02-14 17:30:00', 'ME-1-000042', 42, 'مستند قبض', 0, 0, '', NULL, NULL),
(81, 1, '2026-02-14 14:30:05', 'SWSI-1-000039', 39, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(82, 1, '2026-02-14 20:24:00', 'ME-1-000043', 43, 'مستند قبض', 0, 0, '', NULL, NULL),
(83, 1, '2026-02-14 17:25:19', 'SWSI-1-000040', 40, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(84, 1, '2026-02-14 20:46:00', 'ME-1-000044', 44, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(85, 1, '2026-02-14 17:47:57', 'SWSI-1-000041', 41, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(86, 1, '2026-02-15 17:03:00', 'ME-1-000045', 45, 'مستند قبض', 0, 0, '', NULL, NULL),
(87, 1, '2026-02-15 14:03:30', 'SWSI-1-000042', 42, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(88, 1, '2026-02-15 17:19:00', 'ME-1-000046', 46, 'مستند قبض', 0, 0, '', NULL, NULL),
(89, 1, '2026-02-15 17:19:00', 'ME-1-000047', 47, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(90, 1, '2026-02-15 14:46:23', 'SWSI-1-000043', 43, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(91, 1, '2026-02-15 21:58:00', 'ME-1-000048', 48, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(92, 1, '2026-02-15 18:58:17', 'SWSI-1-000044', 44, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(93, 1, '2026-02-15 22:45:00', 'ME-1-000049', 49, 'مستند قبض', 0, 0, '', NULL, NULL),
(94, 1, '2026-02-15 19:48:50', 'SWSI-1-000045', 45, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(95, 1, '2026-02-16 17:41:00', 'ME-1-000050', 50, 'مستند قبض', 0, 0, '', NULL, NULL),
(96, 1, '2026-02-16 14:42:35', 'SWSI-1-000046', 46, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(97, 1, '2026-02-17 18:18:00', 'ME-1-000051', 51, 'مستند قبض', 0, 0, '', NULL, NULL),
(98, 1, '2026-02-17 15:18:39', 'SWSI-1-000047', 47, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(99, 1, '2026-02-17 19:26:00', 'ME-1-000052', 52, 'مستند قبض', 0, 0, '', NULL, NULL),
(100, 1, '2026-02-17 16:26:03', 'SWSI-1-000048', 48, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(101, 1, '2026-02-18 23:31:00', 'ME-1-000053', 53, 'مستند قبض', 0, 0, '', NULL, NULL),
(102, 1, '2026-02-18 23:31:00', 'ME-1-000054', 54, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(103, 1, '2026-02-18 20:32:29', 'SWSI-1-000049', 49, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(104, 1, '2026-02-20 01:08:00', 'ME-1-000055', 55, 'مستند قبض', 0, 0, '', NULL, NULL),
(105, 1, '2026-02-19 22:09:15', 'SWSI-1-000050', 50, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(106, 1, '2026-02-20 23:33:00', 'ME-1-000056', 56, 'مستند قبض', 0, 0, '', NULL, NULL),
(107, 1, '2026-02-20 23:33:00', 'ME-1-000057', 57, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(108, 1, '2026-02-20 20:35:14', 'SWSI-1-000051', 51, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(109, 1, '2026-02-21 21:13:00', 'ME-1-000058', 58, 'مستند قبض', 0, 0, '', NULL, NULL),
(110, 1, '2026-02-21 18:13:42', 'SWSI-1-000052', 52, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(111, 1, '2026-02-21 21:41:00', 'ME-1-000059', 59, 'مستند قبض', 0, 0, '', NULL, NULL),
(112, 1, '2026-02-21 18:41:20', 'SWSI-1-000053', 53, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(113, 1, '2026-02-22 21:41:00', 'ME-1-000060', 60, 'مستند قبض', 0, 0, '', NULL, NULL),
(114, 1, '2026-02-22 18:41:17', 'SWSI-1-000054', 54, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(115, 1, '2026-02-23 00:49:00', 'ME-1-000061', 61, 'مستند قبض', 0, 0, '', NULL, NULL),
(116, 1, '2026-02-22 21:49:51', 'SWSI-1-000055', 55, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(117, 1, '2026-02-23 01:24:00', 'ME-1-000062', 62, 'مستند قبض', 0, 0, '', NULL, NULL),
(118, 1, '2026-02-23 01:24:00', 'ME-1-000063', 63, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(119, 1, '2026-02-22 22:24:54', 'SWSI-1-000056', 56, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(120, 1, '2026-02-23 17:23:00', 'ME-1-000064', 64, 'مستند قبض', 0, 0, '', NULL, NULL),
(121, 1, '2026-02-23 14:22:54', 'SWSI-1-000057', 57, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(122, 1, '2026-02-24 00:24:00', 'ME-1-000065', 65, 'مستند قبض', 0, 0, '', NULL, NULL),
(123, 1, '2026-02-23 21:24:18', 'SWSI-1-000058', 58, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(124, 1, '2026-02-24 01:42:00', 'ME-1-000066', 66, 'مستند قبض', 0, 0, '', NULL, NULL),
(125, 1, '2026-02-24 01:42:00', 'ME-1-000067', 67, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(126, 1, '2026-02-23 22:47:15', 'SWSI-1-000059', 59, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(127, 1, '2026-02-24 22:18:00', 'ME-1-000068', 68, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(128, 1, '2026-02-24 19:17:33', 'SWSI-1-000060', 60, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(129, 1, '2026-02-24 23:44:00', 'ME-1-000069', 69, 'مستند قبض', 0, 0, '', NULL, NULL),
(130, 1, '2026-02-24 20:44:58', 'SWSI-1-000061', 61, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(131, 1, '2026-02-25 21:02:00', 'ME-1-000070', 70, 'مستند قبض', 0, 0, '', NULL, NULL),
(132, 1, '2026-02-25 18:24:14', 'SWSI-1-000062', 62, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(133, 1, '2026-02-25 22:53:00', 'ME-1-000071', 71, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(134, 1, '2026-02-25 19:53:52', 'SWSI-1-000063', 63, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(135, 1, '2026-02-25 23:02:00', 'ME-1-000072', 72, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(136, 1, '2026-02-25 20:01:55', 'SWSI-1-000064', 64, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(137, 1, '2026-02-26 23:21:00', 'ME-1-000073', 73, 'مستند قبض', 0, 0, '', NULL, NULL),
(138, 1, '2026-02-26 23:21:00', 'ME-1-000074', 74, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(139, 1, '2026-02-26 20:22:10', 'SWSI-1-000065', 65, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(140, 1, '2026-02-26 23:32:00', 'ME-1-000075', 75, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(141, 1, '2026-02-26 20:32:45', 'SWSI-1-000066', 66, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(142, 1, '2026-02-27 21:17:00', 'ME-1-000076', 76, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(143, 1, '2026-02-27 18:18:07', 'SWSI-1-000067', 67, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(144, 1, '2026-02-27 21:34:00', 'ME-1-000077', 77, 'مستند قبض', 0, 0, '', NULL, NULL),
(145, 1, '2026-02-27 18:34:36', 'SWSI-1-000068', 68, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(146, 1, '2026-02-27 22:24:00', 'ME-1-000078', 78, 'مستند قبض', 0, 0, '', NULL, NULL),
(147, 1, '2026-02-27 22:24:00', 'ME-1-000079', 79, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(148, 1, '2026-02-27 19:24:18', 'SWSI-1-000069', 69, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(149, 1, '2026-02-28 00:28:00', 'ME-1-000080', 80, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(150, 1, '2026-02-27 21:27:32', 'SWSI-1-000070', 70, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(151, 1, '2026-02-28 00:37:00', 'ME-1-000081', 81, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(152, 1, '2026-02-27 21:37:28', 'SWSI-1-000071', 71, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(153, 1, '2026-02-28 00:54:00', 'ME-1-000082', 82, 'مستند قبض', 0, 0, '', NULL, NULL),
(154, 1, '2026-02-28 00:54:00', 'ME-1-000083', 83, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(155, 1, '2026-02-27 21:53:55', 'SWSI-1-000072', 72, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(156, 1, '2026-02-28 22:01:00', 'ME-1-000084', 84, 'مستند قبض', 0, 0, '', NULL, NULL),
(157, 1, '2026-02-28 19:01:00', 'SWSI-1-000073', 73, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(158, 1, '2026-02-28 23:17:00', 'ME-1-000085', 85, 'مستند قبض', 0, 0, '', NULL, NULL),
(159, 1, '2026-02-28 20:17:15', 'SWSI-1-000074', 74, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(160, 1, '2026-03-01 21:19:00', 'ME-1-000086', 86, 'مستند قبض', 0, 0, '', NULL, NULL),
(161, 1, '2026-03-01 21:19:00', 'ME-1-000087', 87, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(162, 1, '2026-03-01 18:21:31', 'SWSI-1-000075', 75, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(163, 1, '2026-03-01 22:38:00', 'ME-1-000088', 88, 'مستند قبض', 0, 0, '', NULL, NULL),
(164, 1, '2026-03-01 19:38:14', 'SWSI-1-000076', 76, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(165, 1, '2026-03-01 23:14:00', 'ME-1-000089', 89, 'مستند قبض', 0, 0, '', NULL, NULL),
(166, 1, '2026-03-01 20:13:38', 'SWSI-1-000077', 77, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(167, 1, '2026-03-01 23:39:00', 'ME-1-000090', 90, 'مستند قبض', 0, 0, '', NULL, NULL),
(168, 1, '2026-03-01 20:39:08', 'SWSI-1-000078', 78, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(169, 1, '2026-03-02 01:00:00', 'ME-1-000091', 91, 'مستند قبض', 0, 0, '', NULL, NULL),
(170, 1, '2026-03-01 21:59:59', 'SWSI-1-000079', 79, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(171, 1, '2026-03-02 01:10:00', 'ME-1-000092', 92, 'مستند قبض', 0, 0, '', NULL, NULL),
(172, 1, '2026-03-01 22:10:20', 'SWSI-1-000080', 80, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(173, 1, '2026-03-02 01:13:00', 'ME-1-000093', 93, 'مستند قبض', 0, 0, '', NULL, NULL),
(174, 1, '2026-03-01 22:12:50', 'SWSI-1-000081', 81, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(175, 1, '2026-03-02 01:20:00', 'ME-1-000094', 94, 'مستند قبض', 0, 0, '', NULL, NULL),
(176, 1, '2026-03-01 22:19:38', 'SWSI-1-000082', 82, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(177, 1, '2026-03-02 01:40:00', 'ME-1-000095', 95, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(178, 1, '2026-03-01 22:40:12', 'SWSI-1-000083', 83, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(179, 1, '2026-03-03 00:12:00', 'ME-1-000096', 96, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(180, 1, '2026-03-02 21:13:48', 'SWSI-1-000084', 84, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(181, 1, '2026-03-03 00:14:00', 'ME-1-000097', 97, 'مستند قبض', 0, 0, '', NULL, NULL),
(182, 1, '2026-03-02 21:17:13', 'SWSI-1-000085', 85, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(183, 1, '2026-03-03 16:53:00', 'ME-1-000098', 98, 'مستند قبض', 0, 0, '', NULL, NULL),
(184, 1, '2026-03-03 13:55:57', 'SWSI-1-000086', 86, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(185, 1, '2026-03-03 16:56:00', 'ME-1-000099', 99, 'مستند قبض', 0, 0, '', NULL, NULL),
(186, 1, '2026-03-03 13:57:40', 'SWSI-1-000087', 87, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(187, 1, '2026-03-03 21:12:00', 'ME-1-000100', 100, 'مستند قبض', 0, 0, '', NULL, NULL),
(188, 1, '2026-03-03 21:12:00', 'ME-1-000101', 101, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(189, 1, '2026-03-03 18:12:36', 'SWSI-1-000088', 88, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(190, 1, '2026-03-04 00:30:00', 'ME-1-000102', 102, 'مستند قبض', 0, 0, '', NULL, NULL),
(191, 1, '2026-03-03 22:19:13', 'SWSI-1-000089', 89, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(192, 1, '2026-03-04 01:25:00', 'ME-1-000103', 103, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(193, 1, '2026-03-03 22:29:50', 'SWSI-1-000090', 90, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(194, 1, '2026-03-04 01:30:00', 'ME-1-000104', 104, 'مستند قبض', 0, 0, '', NULL, NULL),
(195, 1, '2026-03-03 22:31:19', 'SWSI-1-000091', 91, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(196, 1, '2026-03-04 02:10:00', 'ME-1-000105', 105, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(197, 1, '2026-03-03 23:11:27', 'SWSI-1-000092', 92, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(198, 1, '2026-03-04 07:19:00', 'ME-1-000106', 106, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(199, 1, '2026-03-04 04:20:24', 'SWSI-1-000093', 93, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(200, 1, '2026-03-04 22:38:00', 'ME-1-000107', 107, 'مستند قبض', 0, 0, '', NULL, NULL),
(201, 1, '2026-03-04 19:39:19', 'SWSI-1-000094', 94, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(202, 1, '2026-03-04 23:24:00', 'ME-1-000108', 108, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(203, 1, '2026-03-04 20:30:40', 'SWSI-1-000095', 95, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(204, 1, '2026-03-04 23:37:00', 'ME-1-000109', 109, 'مستند قبض', 0, 0, '', NULL, NULL),
(205, 1, '2026-03-04 20:37:38', 'SWSI-1-000096', 96, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(206, 1, '2026-03-05 22:26:00', 'ME-1-000110', 110, 'مستند قبض', 0, 0, '', NULL, NULL),
(207, 1, '2026-03-05 19:26:39', 'SWSI-1-000097', 97, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(208, 1, '2026-03-05 22:53:00', 'ME-1-000111', 111, 'مستند قبض', 0, 0, '', NULL, NULL),
(209, 1, '2026-03-05 19:54:35', 'SWSI-1-000098', 98, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(210, 1, '2026-03-05 23:43:00', 'ME-1-000112', 112, 'مستند قبض', 0, 0, '', NULL, NULL),
(211, 1, '2026-03-05 20:44:17', 'SWSI-1-000099', 99, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(212, 1, '2026-03-06 00:10:00', 'ME-1-000113', 113, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(213, 1, '2026-03-05 21:11:24', 'SWSI-1-000100', 100, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(214, 1, '2026-03-06 00:20:00', 'ME-1-000114', 114, 'مستند قبض', 0, 0, '', NULL, NULL),
(215, 1, '2026-03-05 21:20:48', 'SWSI-1-000101', 101, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(216, 1, '2026-03-06 02:00:00', 'ME-1-000115', 115, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(217, 1, '2026-03-05 23:00:42', 'SWSI-1-000102', 102, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(218, 1, '2026-03-06 21:11:00', 'ME-1-000116', 116, 'مستند قبض', 0, 0, '', NULL, NULL),
(219, 1, '2026-03-06 21:11:00', 'ME-1-000117', 117, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(220, 1, '2026-03-06 18:13:00', 'SWSI-1-000103', 103, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(221, 1, '2026-03-06 21:16:00', 'ME-1-000118', 118, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(222, 1, '2026-03-06 18:17:32', 'SWSI-1-000104', 104, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(223, 1, '2026-03-06 22:44:00', 'ME-1-000119', 119, 'مستند قبض', 0, 0, '', NULL, NULL),
(224, 1, '2026-03-06 19:44:47', 'SWSI-1-000105', 105, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(225, 1, '2026-03-06 23:08:00', 'ME-1-000120', 120, 'مستند قبض', 0, 0, '', NULL, NULL),
(226, 1, '2026-03-06 20:09:17', 'SWSI-1-000106', 106, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(227, 1, '2026-03-07 00:03:00', 'ME-1-000121', 121, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(228, 1, '2026-03-06 21:05:08', 'SWSI-1-000107', 107, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(229, 1, '2026-03-07 00:07:00', 'ME-1-000122', 122, 'مستند قبض', 0, 0, '', NULL, NULL),
(230, 1, '2026-03-06 21:07:47', 'SWSI-1-000108', 108, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(231, 1, '2026-03-07 00:08:00', 'ME-1-000123', 123, 'مستند قبض', 0, 0, '', NULL, NULL),
(232, 1, '2026-03-06 21:09:07', 'SWSI-1-000109', 109, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(233, 1, '2026-03-07 00:26:00', 'ME-1-000124', 124, 'مستند قبض', 0, 0, '', NULL, NULL),
(234, 1, '2026-03-06 21:26:35', 'SWSI-1-000110', 110, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(235, 1, '2026-03-07 08:08:00', 'ME-1-000125', 125, 'مستند قبض', 0, 0, '', NULL, NULL),
(236, 1, '2026-03-07 08:08:00', 'ME-1-000126', 126, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(237, 1, '2026-03-07 05:19:52', 'SWSI-1-000111', 111, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(238, 1, '2026-03-07 21:13:00', 'ME-1-000127', 127, 'مستند قبض', 0, 0, '', NULL, NULL),
(239, 1, '2026-03-07 18:13:45', 'SWSI-1-000112', 112, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(240, 1, '2026-03-07 21:25:00', 'ME-1-000128', 128, 'مستند قبض', 0, 0, '', NULL, NULL),
(241, 1, '2026-03-07 18:26:02', 'SWSI-1-000113', 113, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(242, 1, '2026-03-07 21:51:00', 'ME-1-000129', 129, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(243, 1, '2026-03-07 18:52:09', 'SWSI-1-000114', 114, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(244, 1, '2026-03-08 00:07:00', 'ME-1-000130', 130, 'مستند قبض', 0, 0, '', NULL, NULL),
(245, 1, '2026-03-08 00:07:00', 'ME-1-000131', 131, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(246, 1, '2026-03-07 21:08:46', 'SWSI-1-000115', 115, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(247, 1, '2026-03-08 00:27:00', 'ME-1-000132', 132, 'مستند قبض', 0, 0, '', NULL, NULL),
(248, 1, '2026-03-07 21:28:29', 'SWSI-1-000116', 116, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(249, 1, '2026-03-08 00:30:00', 'ME-1-000133', 133, 'مستند قبض', 0, 0, '', NULL, NULL),
(250, 1, '2026-03-07 21:30:40', 'SWSI-1-000117', 117, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(251, 1, '2026-03-08 02:15:00', 'ME-1-000134', 134, 'مستند قبض', 0, 0, '', NULL, NULL),
(252, 1, '2026-03-07 23:16:10', 'SWSI-1-000118', 118, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(253, 1, '2026-03-08 17:06:00', 'ME-1-000135', 135, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(254, 1, '2026-03-08 14:07:29', 'SWSI-1-000119', 119, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(255, 1, '2026-03-08 21:30:00', 'ME-1-000136', 136, 'مستند قبض', 0, 0, '', NULL, NULL),
(256, 1, '2026-03-08 21:30:00', 'ME-1-000137', 137, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(257, 1, '2026-03-08 18:32:36', 'SWSI-1-000120', 120, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(258, 1, '2026-03-08 22:18:00', 'ME-1-000138', 138, 'مستند قبض', 0, 0, '', NULL, NULL),
(259, 1, '2026-03-08 19:19:15', 'SWSI-1-000121', 121, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(260, 1, '2026-03-08 22:19:00', 'ME-1-000139', 139, 'مستند قبض', 0, 0, '', NULL, NULL),
(261, 1, '2026-03-08 19:21:09', 'SWSI-1-000122', 122, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(262, 1, '2026-03-08 22:54:00', 'ME-1-000140', 140, 'مستند قبض', 0, 0, '', NULL, NULL),
(263, 1, '2026-03-08 22:54:00', 'ME-1-000141', 141, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(264, 1, '2026-03-08 19:55:00', 'SWSI-1-000123', 123, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(265, 1, '2026-03-09 00:30:00', 'ME-1-000142', 142, 'مستند قبض', 0, 0, '', NULL, NULL),
(266, 1, '2026-03-09 00:30:00', 'ME-1-000143', 143, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(267, 1, '2026-03-08 21:31:58', 'SWSI-1-000124', 124, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(268, 1, '2026-03-09 02:06:00', 'ME-1-000144', 144, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(269, 1, '2026-03-08 23:07:08', 'SWSI-1-000125', 125, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(270, 1, '2026-03-09 02:08:00', 'ME-1-000145', 145, 'مستند قبض', 0, 0, '', NULL, NULL),
(271, 1, '2026-03-08 23:09:20', 'SWSI-1-000126', 126, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(272, 1, '2026-03-09 02:18:00', 'ME-1-000146', 146, 'مستند قبض', 0, 0, '', NULL, NULL),
(273, 1, '2026-03-08 23:19:03', 'SWSI-1-000127', 127, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(274, 1, '2026-03-09 17:23:00', 'ME-1-000147', 147, 'مستند قبض', 0, 0, '', NULL, NULL),
(275, 1, '2026-03-09 14:24:17', 'SWSI-1-000128', 128, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(276, 1, '2026-03-11 21:53:00', 'ME-1-000148', 148, 'مستند قبض', 0, 0, '', NULL, NULL),
(277, 1, '2026-03-11 18:54:42', 'SWSI-1-000129', 129, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(278, 1, '2026-03-11 22:00:00', 'ME-1-000149', 149, 'مستند قبض', 0, 0, '', NULL, NULL),
(279, 1, '2026-03-11 19:00:43', 'SWSI-1-000130', 130, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(280, 1, '2026-03-11 23:34:00', 'ME-1-000150', 150, 'مستند قبض', 0, 0, '', NULL, NULL),
(281, 1, '2026-03-11 20:35:50', 'SWSI-1-000131', 131, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(282, 1, '2026-03-11 23:37:00', 'ME-1-000151', 151, 'مستند قبض', 0, 0, '', NULL, NULL),
(283, 1, '2026-03-11 20:37:44', 'SWSI-1-000132', 132, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(284, 1, '2026-03-12 07:39:00', 'ME-1-000152', 152, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(285, 1, '2026-03-12 04:40:19', 'SWSI-1-000133', 133, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(286, 1, '2026-03-12 21:37:00', 'ME-1-000153', 153, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(287, 1, '2026-03-12 18:38:38', 'SWSI-1-000134', 134, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(288, 1, '2026-03-12 21:39:00', 'ME-1-000154', 154, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(289, 1, '2026-03-12 18:39:42', 'SWSI-1-000135', 135, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(290, 1, '2026-03-12 22:46:00', 'ME-1-000155', 155, 'مستند قبض', 0, 0, '', NULL, NULL),
(291, 1, '2026-03-12 19:46:40', 'SWSI-1-000136', 136, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(292, 1, '2026-03-12 23:48:00', 'ME-1-000156', 156, 'مستند قبض', 0, 0, '', NULL, NULL),
(293, 1, '2026-03-12 20:49:31', 'SWSI-1-000137', 137, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(294, 1, '2026-03-13 00:36:00', 'ME-1-000157', 157, 'مستند قبض', 0, 0, '', NULL, NULL),
(295, 1, '2026-03-12 21:36:50', 'SWSI-1-000138', 138, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(296, 1, '2026-03-13 02:03:00', 'ME-1-000158', 158, 'مستند قبض', 0, 0, '', NULL, NULL),
(297, 1, '2026-03-12 23:03:54', 'SWSI-1-000139', 139, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(298, 1, '2026-03-13 07:34:00', 'ME-1-000159', 159, 'مستند قبض', 0, 0, '', NULL, NULL),
(299, 1, '2026-03-13 07:34:00', 'ME-1-000160', 160, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(300, 1, '2026-03-13 04:34:34', 'SWSI-1-000140', 140, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(301, 1, '2026-03-13 21:33:00', 'ME-1-000161', 161, 'مستند قبض', 0, 0, '', NULL, NULL),
(302, 1, '2026-03-13 18:34:13', 'SWSI-1-000141', 141, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(303, 1, '2026-03-13 22:32:00', 'ME-1-000162', 162, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(304, 1, '2026-03-13 19:33:09', 'SWSI-1-000142', 142, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(305, 1, '2026-03-13 22:49:00', 'ME-1-000163', 163, 'مستند قبض', 0, 0, '', NULL, NULL),
(306, 1, '2026-03-13 19:49:34', 'SWSI-1-000143', 143, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(307, 1, '2026-03-13 23:02:00', 'ME-1-000164', 164, 'مستند قبض', 0, 0, '', NULL, NULL),
(308, 1, '2026-03-13 20:03:23', 'SWSI-1-000144', 144, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(309, 1, '2026-03-13 23:38:00', 'ME-1-000165', 165, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(310, 1, '2026-03-13 20:39:23', 'SWSI-1-000145', 145, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(311, 1, '2026-03-14 00:18:00', 'ME-1-000166', 166, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(312, 1, '2026-03-13 21:18:59', 'SWSI-1-000146', 146, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(313, 1, '2026-03-14 00:49:00', 'ME-1-000167', 167, 'مستند قبض', 0, 0, '', NULL, NULL),
(314, 1, '2026-03-13 21:50:15', 'SWSI-1-000147', 147, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(315, 1, '2026-03-14 02:49:00', 'ME-1-000168', 168, 'مستند قبض', 0, 0, '', NULL, NULL),
(316, 1, '2026-03-13 23:52:01', 'SWSI-1-000148', 148, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(317, 1, '2026-03-14 06:00:00', 'ME-1-000169', 169, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(318, 1, '2026-03-14 03:01:22', 'SWSI-1-000149', 149, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(319, 1, '2026-03-14 07:55:00', 'ME-1-000170', 170, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(320, 1, '2026-03-14 04:55:57', 'SWSI-1-000150', 150, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(321, 1, '2026-03-14 21:55:00', 'ME-1-000171', 171, 'مستند قبض', 0, 0, '', NULL, NULL),
(322, 1, '2026-03-14 18:57:48', 'SWSI-1-000151', 151, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(323, 1, '2026-03-14 21:58:00', 'ME-1-000172', 172, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(324, 1, '2026-03-14 18:59:16', 'SWSI-1-000152', 152, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(325, 1, '2026-03-14 22:09:00', 'ME-1-000173', 173, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(326, 1, '2026-03-14 19:10:06', 'SWSI-1-000153', 153, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(327, 1, '2026-03-14 22:54:00', 'ME-1-000174', 174, 'مستند قبض', 0, 0, '', NULL, NULL),
(328, 1, '2026-03-14 19:55:05', 'SWSI-1-000154', 154, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(329, 1, '2026-03-15 01:53:00', 'ME-1-000175', 175, 'مستند قبض', 0, 0, '', NULL, NULL),
(330, 1, '2026-03-14 22:54:02', 'SWSI-1-000155', 155, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(331, 1, '2026-03-15 02:03:00', 'ME-1-000176', 176, 'مستند قبض', 0, 0, '', NULL, NULL),
(332, 1, '2026-03-14 23:04:37', 'SWSI-1-000156', 156, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(333, 1, '2026-03-15 07:49:00', 'ME-1-000177', 177, 'مستند قبض', 0, 0, '', NULL, NULL),
(334, 1, '2026-03-15 04:50:37', 'SWSI-1-000157', 157, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(335, 1, '2026-03-15 17:11:00', 'ME-1-000178', 178, 'مستند قبض', 0, 0, '', NULL, NULL),
(336, 1, '2026-03-15 14:13:17', 'SWSI-1-000158', 158, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(337, 1, '2026-03-15 17:34:00', 'ME-1-000179', 179, 'مستند قبض', 0, 0, '', NULL, NULL),
(338, 1, '2026-03-15 14:34:52', 'SWSI-1-000159', 159, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(339, 1, '2026-03-15 22:45:00', 'ME-1-000180', 180, 'مستند قبض', 0, 0, '', NULL, NULL),
(340, 1, '2026-03-15 19:50:15', 'SWSI-1-000160', 160, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(341, 1, '2026-03-15 23:57:00', 'ME-1-000181', 181, 'مستند قبض', 0, 0, '', NULL, NULL),
(342, 1, '2026-03-15 22:17:25', 'SWSI-1-000161', 161, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(343, 1, '2026-03-16 07:39:00', 'ME-1-000182', 182, 'مستند قبض', 0, 0, '', NULL, NULL),
(344, 1, '2026-03-16 04:39:44', 'SWSI-1-000162', 162, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(345, 1, '2026-03-16 17:03:00', 'ME-1-000183', 183, 'مستند قبض', 0, 0, '', NULL, NULL),
(346, 1, '2026-03-16 14:04:34', 'SWSI-1-000163', 163, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(347, 1, '2026-03-17 02:06:00', 'ME-1-000184', 184, 'مستند قبض', 0, 0, '', NULL, NULL),
(348, 1, '2026-03-16 23:07:04', 'SWSI-1-000164', 164, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(349, 1, '2026-03-18 01:13:00', 'ME-1-000185', 185, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(350, 1, '2026-03-17 22:14:39', 'SWSI-1-000165', 165, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(351, 1, '2026-03-18 01:40:00', 'ME-1-000186', 186, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(352, 1, '2026-03-17 22:41:20', 'SWSI-1-000166', 166, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(353, 1, '2026-03-18 08:33:00', 'ME-1-000187', 187, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(354, 1, '2026-03-18 05:36:33', 'SWSI-1-000167', 167, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(355, 1, '2026-03-18 22:29:00', 'ME-1-000188', 188, 'مستند قبض', 0, 0, '', NULL, NULL),
(356, 1, '2026-03-18 22:29:00', 'ME-1-000189', 189, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(357, 1, '2026-03-18 19:30:10', 'SWSI-1-000168', 168, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(358, 1, '2026-03-18 22:30:00', 'ME-1-000190', 190, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(359, 1, '2026-03-18 19:30:51', 'SWSI-1-000169', 169, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(360, 1, '2026-03-18 23:42:00', 'ME-1-000191', 191, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(361, 1, '2026-03-18 20:43:09', 'SWSI-1-000170', 170, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(362, 1, '2026-03-18 23:57:00', 'ME-1-000192', 192, 'مستند قبض', 0, 0, '', NULL, NULL),
(363, 1, '2026-03-18 20:57:54', 'SWSI-1-000171', 171, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(364, 1, '2026-03-19 00:20:00', 'ME-1-000193', 193, 'مستند قبض', 0, 0, '', NULL, NULL),
(365, 1, '2026-03-18 21:22:46', 'SWSI-1-000172', 172, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(366, 1, '2026-03-19 01:13:00', 'ME-1-000194', 194, 'مستند قبض', 0, 0, '', NULL, NULL),
(367, 1, '2026-03-18 22:13:21', 'SWSI-1-000173', 173, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(368, 1, '2026-03-19 02:01:00', 'ME-1-000195', 195, 'مستند قبض', 0, 0, '', NULL, NULL),
(369, 1, '2026-03-18 23:01:45', 'SWSI-1-000174', 174, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(370, 1, '2026-03-19 22:49:00', 'ME-1-000196', 196, 'مستند قبض', 0, 0, '', NULL, NULL),
(371, 1, '2026-03-19 19:50:02', 'SWSI-1-000175', 175, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(372, 1, '2026-03-23 18:31:00', 'ME-1-000197', 197, 'مستند قبض', 0, 0, '', NULL, NULL),
(373, 1, '2026-03-23 15:32:35', 'SWSI-1-000176', 176, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(374, 1, '2026-03-23 19:58:00', 'ME-1-000198', 198, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(375, 1, '2026-03-23 16:59:10', 'SWSI-1-000177', 177, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(376, 1, '2026-03-23 22:58:00', 'ME-1-000199', 199, 'مستند قبض', 0, 0, '', NULL, NULL),
(377, 1, '2026-03-23 19:58:42', 'SWSI-1-000178', 178, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(378, 1, '2026-03-23 23:23:00', 'ME-1-000200', 200, 'مستند قبض', 0, 0, '', NULL, NULL),
(379, 1, '2026-03-23 20:26:19', 'SWSI-1-000179', 179, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(380, 1, '2026-03-24 10:41:00', 'ME-1-000201', 201, 'مستند قبض', 0, 0, '', NULL, NULL),
(381, 1, '2026-03-24 10:41:00', 'ME-1-000202', 202, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(382, 1, '2026-03-24 07:42:14', 'SWSI-1-000180', 180, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(383, 1, '2026-03-24 17:44:00', 'ME-1-000203', 203, 'مستند قبض', 0, 0, '', NULL, NULL),
(384, 1, '2026-03-24 14:46:43', 'SWSI-1-000181', 181, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(385, 1, '2026-03-24 19:36:00', 'ME-1-000204', 204, 'مستند قبض', 0, 0, '', NULL, NULL),
(386, 1, '2026-03-24 16:37:41', 'SWSI-1-000182', 182, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(387, 1, '2026-03-24 21:52:00', 'ME-1-000205', 205, 'مستند قبض', 0, 0, '', NULL, NULL),
(388, 1, '2026-03-24 18:53:22', 'SWSI-1-000183', 183, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(389, 1, '2026-03-24 22:01:00', 'ME-1-000206', 206, 'مستند قبض', 0, 0, '', NULL, NULL),
(390, 1, '2026-03-24 22:01:00', 'ME-1-000207', 207, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(391, 1, '2026-03-24 19:02:13', 'SWSI-1-000184', 184, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(392, 1, '2026-03-24 22:40:00', 'ME-1-000208', 208, 'مستند قبض', 0, 0, '', NULL, NULL),
(393, 1, '2026-03-24 19:40:32', 'SWSI-1-000185', 185, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(394, 1, '2026-03-25 18:31:00', 'ME-1-000209', 209, 'مستند قبض', 0, 0, '', NULL, NULL),
(395, 1, '2026-03-25 18:31:00', 'ME-1-000210', 210, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(396, 1, '2026-03-25 15:32:28', 'SWSI-1-000186', 186, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(397, 1, '2026-03-25 21:12:00', 'ME-1-000211', 211, 'مستند قبض', 0, 0, '', NULL, NULL),
(398, 1, '2026-03-25 18:12:41', 'SWSI-1-000187', 187, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(399, 1, '2026-03-25 23:26:00', 'ME-1-000212', 212, 'مستند قبض', 0, 0, '', NULL, NULL),
(400, 1, '2026-03-25 20:28:06', 'SWSI-1-000188', 188, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(401, 1, '2026-03-26 20:59:00', 'ME-1-000213', 213, 'مستند قبض', 0, 0, '', NULL, NULL),
(402, 1, '2026-03-26 17:59:41', 'SWSI-1-000189', 189, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(403, 1, '2026-03-26 21:50:00', 'ME-1-000214', 214, 'مستند قبض', 0, 0, '', NULL, NULL),
(404, 1, '2026-03-26 21:50:00', 'ME-1-000215', 215, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(405, 1, '2026-03-26 18:50:36', 'SWSI-1-000190', 190, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(406, 1, '2026-03-26 21:55:00', 'ME-1-000216', 216, 'مستند قبض', 0, 0, '', NULL, NULL),
(407, 1, '2026-03-26 18:56:18', 'SWSI-1-000191', 191, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(408, 1, '2026-03-26 22:58:00', 'ME-1-000217', 217, 'مستند قبض', 0, 0, '', NULL, NULL),
(409, 1, '2026-03-26 19:58:35', 'SWSI-1-000192', 192, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(410, 1, '2026-03-27 17:28:00', 'ME-1-000218', 218, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(411, 1, '2026-03-27 14:28:24', 'SWSI-1-000193', 193, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(412, 1, '2026-03-27 17:30:00', 'ME-1-000219', 219, 'مستند قبض', 0, 0, '', NULL, NULL),
(413, 1, '2026-03-27 14:33:24', 'SWSI-1-000194', 194, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(414, 1, '2026-03-27 21:24:00', 'ME-1-000220', 220, 'مستند قبض', 0, 0, '', NULL, NULL),
(415, 1, '2026-03-27 18:24:44', 'SWSI-1-000195', 195, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(416, 1, '2026-03-27 22:05:00', 'ME-1-000221', 221, 'مستند قبض', 0, 0, '', NULL, NULL),
(417, 1, '2026-03-27 22:05:00', 'ME-1-000222', 222, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(418, 1, '2026-03-27 19:05:46', 'SWSI-1-000196', 196, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(419, 1, '2026-03-27 23:04:00', 'ME-1-000223', 223, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(420, 1, '2026-03-27 20:04:33', 'SWSI-1-000197', 197, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(421, 1, '2026-03-28 17:58:00', 'ME-1-000224', 224, 'مستند قبض', 0, 0, '', NULL, NULL),
(422, 1, '2026-03-28 15:00:27', 'SWSI-1-000198', 198, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(423, 1, '2026-03-28 19:43:00', 'ME-1-000225', 225, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(424, 1, '2026-03-28 16:43:42', 'SWSI-1-000199', 199, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(425, 1, '2026-03-28 20:57:00', 'ME-1-000226', 226, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(426, 1, '2026-03-28 17:58:46', 'SWSI-1-000200', 200, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(427, 1, '2026-03-28 21:32:00', 'ME-1-000227', 227, 'مستند قبض', 0, 0, '', NULL, NULL),
(428, 1, '2026-03-28 18:33:33', 'SWSI-1-000201', 201, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(429, 1, '2026-03-28 22:29:00', 'ME-1-000228', 228, 'مستند قبض', 0, 0, '', NULL, NULL),
(430, 1, '2026-03-28 19:30:04', 'SWSI-1-000202', 202, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(431, 1, '2026-03-28 23:00:00', 'ME-1-000229', 229, 'مستند قبض', 0, 0, '', NULL, NULL),
(432, 1, '2026-03-28 20:00:07', 'SWSI-1-000203', 203, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(433, 1, '2026-03-29 19:20:00', 'ME-1-000230', 230, 'مستند قبض', 0, 0, '', NULL, NULL),
(434, 1, '2026-03-29 16:20:49', 'SWSI-1-000204', 204, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(435, 1, '2026-03-29 21:03:00', 'ME-1-000231', 231, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(436, 1, '2026-03-29 18:07:38', 'SWSI-1-000205', 205, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(437, 1, '2026-03-29 23:10:00', 'ME-1-000232', 232, 'مستند قبض', 0, 0, '', NULL, NULL),
(438, 1, '2026-03-29 20:10:35', 'SWSI-1-000206', 206, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(439, 1, '2026-03-29 23:20:00', 'ME-1-000233', 233, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(440, 1, '2026-03-29 20:20:42', 'SWSI-1-000207', 207, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(441, 1, '2026-03-31 16:55:00', 'ME-1-000234', 234, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(442, 1, '2026-03-31 13:55:54', 'SWSI-1-000208', 208, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(443, 1, '2026-03-31 19:36:00', 'ME-1-000235', 235, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(444, 1, '2026-03-31 16:36:34', 'SWSI-1-000209', 209, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(445, 1, '2026-03-31 21:15:00', 'ME-1-000236', 236, 'مستند قبض', 0, 0, '', NULL, NULL),
(446, 1, '2026-03-31 18:16:02', 'SWSI-1-000210', 210, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(447, 1, '2026-04-01 11:30:00', 'ME-1-000237', 237, 'تحويل بنكي فيزا', 0, 0, '', NULL, NULL),
(448, 1, '2026-04-01 08:30:16', 'SWSI-1-000211', 211, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL),
(449, 1, '2026-04-01 23:24:00', 'ME-1-000238', 238, 'مستند قبض', 0, 0, '', NULL, NULL),
(450, 1, '2026-04-01 20:24:46', 'SWSI-1-000212', 212, 'بيع ذهب مشغول ', 0, 0, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journal_details`
--

CREATE TABLE `journal_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `debit` double NOT NULL,
  `credit` double NOT NULL,
  `ledger_id` int(11) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_details`
--

INSERT INTO `journal_details` (`id`, `journal_id`, `account_id`, `debit`, `credit`, `ledger_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 500, 0, 0, '', NULL, NULL),
(2, 1, 1, 0, 500, 0, '', NULL, NULL),
(3, 2, 1, 500, 0, 1, '', NULL, NULL),
(4, 2, 0, 0, 434.78, 0, '', NULL, NULL),
(5, 2, 0, 0, 65.22, 0, '', NULL, NULL),
(6, 2, 0, 1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(7, 2, 0, 0, 1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(8, 3, 0, 950, 0, 0, '', NULL, NULL),
(9, 3, 1, 0, 950, 0, '', NULL, NULL),
(10, 4, 1, 950, 0, 1, '', NULL, NULL),
(11, 4, 0, 0, 826.09, 0, '', NULL, NULL),
(12, 4, 0, 0, 123.91, 0, '', NULL, NULL),
(13, 4, 0, 1.47, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(14, 4, 0, 0, 1.47, 0, 'جرام ذهب عيار 21', NULL, NULL),
(15, 5, 0, 2600, 0, 0, '', NULL, NULL),
(16, 5, 1, 0, 2600, 0, '', NULL, NULL),
(17, 6, 1, 2600, 0, 1, '', NULL, NULL),
(18, 6, 0, 0, 2260.87, 0, '', NULL, NULL),
(19, 6, 0, 0, 339.13, 0, '', NULL, NULL),
(20, 6, 0, 4.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(21, 6, 0, 0, 4.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(22, 7, 0, 900, 0, 0, '', NULL, NULL),
(23, 7, 1, 0, 900, 0, '', NULL, NULL),
(24, 8, 1, 900, 0, 1, '', NULL, NULL),
(25, 8, 0, 0, 782.61, 0, '', NULL, NULL),
(26, 8, 0, 0, 117.39, 0, '', NULL, NULL),
(27, 8, 0, 1.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(28, 8, 0, 0, 1.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(29, 9, 0, 1000, 0, 0, '', NULL, NULL),
(30, 9, 1, 0, 1000, 0, '', NULL, NULL),
(31, 10, 1, 1000, 0, 1, '', NULL, NULL),
(32, 10, 0, 0, 869.57, 0, '', NULL, NULL),
(33, 10, 0, 0, 130.43, 0, '', NULL, NULL),
(34, 10, 0, 1.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(35, 10, 0, 0, 1.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(36, 11, 0, 1380, 0, 0, '', NULL, NULL),
(37, 11, 1, 0, 1380, 0, '', NULL, NULL),
(38, 12, 1, 1380, 0, 1, '', NULL, NULL),
(39, 12, 0, 0, 1200, 0, '', NULL, NULL),
(40, 12, 0, 0, 180, 0, '', NULL, NULL),
(41, 12, 0, 2.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(42, 12, 0, 0, 2.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(43, 13, 0, 4100, 0, 0, '', NULL, NULL),
(44, 13, 1, 0, 4100, 0, '', NULL, NULL),
(45, 14, 1, 4100, 0, 1, '', NULL, NULL),
(46, 14, 0, 0, 3565.22, 0, '', NULL, NULL),
(47, 14, 0, 0, 534.78, 0, '', NULL, NULL),
(48, 14, 0, 6.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(49, 14, 0, 0, 6.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(50, 15, 0, 3000, 0, 0, '', NULL, NULL),
(51, 15, 1, 0, 3000, 0, '', NULL, NULL),
(52, 16, 0, 3300, 0, 0, '', NULL, NULL),
(53, 16, 1, 0, 3300, 0, '', NULL, NULL),
(54, 17, 1, 6300, 0, 1, '', NULL, NULL),
(55, 17, 0, 0, 5478.26, 0, '', NULL, NULL),
(56, 17, 0, 0, 821.74, 0, '', NULL, NULL),
(57, 17, 0, 10.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(58, 17, 0, 0, 10.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(59, 18, 0, 1150, 0, 0, '', NULL, NULL),
(60, 18, 1, 0, 1150, 0, '', NULL, NULL),
(61, 19, 1, 1150, 0, 1, '', NULL, NULL),
(62, 19, 0, 0, 1000, 0, '', NULL, NULL),
(63, 19, 0, 0, 150, 0, '', NULL, NULL),
(64, 19, 0, 1.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(65, 19, 0, 0, 1.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(66, 20, 0, 3700, 0, 0, '', NULL, NULL),
(67, 20, 1, 0, 3700, 0, '', NULL, NULL),
(68, 21, 1, 3700, 0, 1, '', NULL, NULL),
(69, 21, 0, 0, 3217.39, 0, '', NULL, NULL),
(70, 21, 0, 0, 482.61, 0, '', NULL, NULL),
(71, 21, 0, 5.23, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(72, 21, 0, 0, 5.23, 0, 'جرام ذهب عيار 21', NULL, NULL),
(73, 22, 0, 2200, 0, 0, '', NULL, NULL),
(74, 22, 1, 0, 2200, 0, '', NULL, NULL),
(75, 23, 1, 2200, 0, 1, '', NULL, NULL),
(76, 23, 0, 0, 1913.04, 0, '', NULL, NULL),
(77, 23, 0, 0, 286.96, 0, '', NULL, NULL),
(78, 23, 0, 3.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(79, 23, 0, 0, 3.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(80, 24, 0, 2000, 0, 0, '', NULL, NULL),
(81, 24, 1, 0, 2000, 0, '', NULL, NULL),
(82, 25, 0, 3500, 0, 0, '', NULL, NULL),
(83, 25, 1, 0, 3500, 0, '', NULL, NULL),
(84, 26, 1, 5500, 0, 1, '', NULL, NULL),
(85, 26, 0, 0, 4782.61, 0, '', NULL, NULL),
(86, 26, 0, 0, 717.39, 0, '', NULL, NULL),
(87, 26, 0, 9.63, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(88, 26, 0, 0, 9.63, 0, 'جرام ذهب عيار 21', NULL, NULL),
(89, 27, 0, 2200, 0, 0, '', NULL, NULL),
(90, 27, 1, 0, 2200, 0, '', NULL, NULL),
(91, 28, 1, 2200, 0, 1, '', NULL, NULL),
(92, 28, 0, 0, 1913.04, 0, '', NULL, NULL),
(93, 28, 0, 0, 286.96, 0, '', NULL, NULL),
(94, 28, 0, 3.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(95, 28, 0, 0, 3.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(96, 29, 0, 1800, 0, 0, '', NULL, NULL),
(97, 29, 1, 0, 1800, 0, '', NULL, NULL),
(98, 30, 1, 1800, 0, 1, '', NULL, NULL),
(99, 30, 0, 0, 1565.22, 0, '', NULL, NULL),
(100, 30, 0, 0, 234.78, 0, '', NULL, NULL),
(101, 30, 0, 2.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(102, 30, 0, 0, 2.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(103, 31, 0, 32500, 0, 0, '', NULL, NULL),
(104, 31, 1, 0, 32500, 0, '', NULL, NULL),
(105, 32, 1, 32500, 0, 1, '', NULL, NULL),
(106, 32, 0, 0, 28260.87, 0, '', NULL, NULL),
(107, 32, 0, 0, 4239.13, 0, '', NULL, NULL),
(108, 32, 0, 52, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(109, 32, 0, 0, 52, 0, 'جرام ذهب عيار 21', NULL, NULL),
(110, 33, 0, 3450, 0, 0, '', NULL, NULL),
(111, 33, 1, 0, 3450, 0, '', NULL, NULL),
(112, 34, 1, 3450, 0, 1, '', NULL, NULL),
(113, 34, 0, 0, 3000, 0, '', NULL, NULL),
(114, 34, 0, 0, 450, 0, '', NULL, NULL),
(115, 34, 0, 4.54, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(116, 34, 0, 0, 4.54, 0, 'جرام ذهب عيار 21', NULL, NULL),
(117, 35, 0, 3030, 0, 0, '', NULL, NULL),
(118, 35, 1, 0, 3030, 0, '', NULL, NULL),
(119, 36, 1, 3030, 0, 1, '', NULL, NULL),
(120, 36, 0, 0, 2634.78, 0, '', NULL, NULL),
(121, 36, 0, 0, 395.22, 0, '', NULL, NULL),
(122, 36, 0, 5.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(123, 36, 0, 0, 5.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(124, 37, 0, 2900, 0, 0, '', NULL, NULL),
(125, 37, 1, 0, 2900, 0, '', NULL, NULL),
(126, 38, 1, 2900, 0, 1, '', NULL, NULL),
(127, 38, 0, 0, 2521.74, 0, '', NULL, NULL),
(128, 38, 0, 0, 378.26, 0, '', NULL, NULL),
(129, 38, 0, 4.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(130, 38, 0, 0, 4.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(131, 39, 0, 1500, 0, 0, '', NULL, NULL),
(132, 39, 1, 0, 1500, 0, '', NULL, NULL),
(133, 40, 1, 1500, 0, 1, '', NULL, NULL),
(134, 40, 0, 0, 1304.35, 0, '', NULL, NULL),
(135, 40, 0, 0, 195.65, 0, '', NULL, NULL),
(136, 40, 0, 2.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(137, 40, 0, 0, 2.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(138, 41, 0, 2390, 0, 0, '', NULL, NULL),
(139, 41, 1, 0, 2390, 0, '', NULL, NULL),
(140, 42, 1, 2390, 0, 1, '', NULL, NULL),
(141, 42, 0, 0, 2078.26, 0, '', NULL, NULL),
(142, 42, 0, 0, 311.74, 0, '', NULL, NULL),
(143, 42, 0, 3.98, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(144, 42, 0, 0, 3.98, 0, 'جرام ذهب عيار 21', NULL, NULL),
(145, 43, 0, 9200, 0, 0, '', NULL, NULL),
(146, 43, 1, 0, 9200, 0, '', NULL, NULL),
(147, 44, 1, 9200, 0, 1, '', NULL, NULL),
(148, 44, 0, 0, 8000, 0, '', NULL, NULL),
(149, 44, 0, 0, 1200, 0, '', NULL, NULL),
(150, 44, 0, 13.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(151, 44, 0, 0, 13.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(152, 45, 0, 850, 0, 0, '', NULL, NULL),
(153, 45, 1, 0, 850, 0, '', NULL, NULL),
(154, 46, 1, 850, 0, 1, '', NULL, NULL),
(155, 46, 0, 0, 739.13, 0, '', NULL, NULL),
(156, 46, 0, 0, 110.87, 0, '', NULL, NULL),
(157, 46, 0, 1.35, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(158, 46, 0, 0, 1.35, 0, 'جرام ذهب عيار 21', NULL, NULL),
(159, 47, 0, 850, 0, 0, '', NULL, NULL),
(160, 47, 1, 0, 850, 0, '', NULL, NULL),
(161, 48, 1, 850, 0, 1, '', NULL, NULL),
(162, 48, 0, 0, 739.13, 0, '', NULL, NULL),
(163, 48, 0, 0, 110.87, 0, '', NULL, NULL),
(164, 48, 0, 1.35, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(165, 48, 0, 0, 1.35, 0, 'جرام ذهب عيار 21', NULL, NULL),
(166, 49, 0, 3800, 0, 0, '', NULL, NULL),
(167, 49, 1, 0, 3800, 0, '', NULL, NULL),
(168, 50, 1, 3800, 0, 1, '', NULL, NULL),
(169, 50, 0, 0, 3304.35, 0, '', NULL, NULL),
(170, 50, 0, 0, 495.65, 0, '', NULL, NULL),
(171, 50, 0, 6.39, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(172, 50, 0, 0, 6.39, 0, 'جرام ذهب عيار 21', NULL, NULL),
(173, 51, 0, 3800, 0, 0, '', NULL, NULL),
(174, 51, 1, 0, 3800, 0, '', NULL, NULL),
(175, 52, 1, 3800, 0, 1, '', NULL, NULL),
(176, 52, 0, 0, 3304.35, 0, '', NULL, NULL),
(177, 52, 0, 0, 495.65, 0, '', NULL, NULL),
(178, 52, 0, 6.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(179, 52, 0, 0, 6.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(180, 53, 0, 2795, 0, 0, '', NULL, NULL),
(181, 53, 1, 0, 2795, 0, '', NULL, NULL),
(182, 54, 1, 2795, 0, 1, '', NULL, NULL),
(183, 54, 0, 0, 2430.43, 0, '', NULL, NULL),
(184, 54, 0, 0, 364.57, 0, '', NULL, NULL),
(185, 54, 0, 4.82, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(186, 54, 0, 0, 4.82, 0, 'جرام ذهب عيار 21', NULL, NULL),
(187, 55, 0, 1400, 0, 0, '', NULL, NULL),
(188, 55, 1, 0, 1400, 0, '', NULL, NULL),
(189, 56, 1, 1400, 0, 1, '', NULL, NULL),
(190, 56, 0, 0, 1217.39, 0, '', NULL, NULL),
(191, 56, 0, 0, 182.61, 0, '', NULL, NULL),
(192, 56, 0, 2.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(193, 56, 0, 0, 2.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(194, 57, 0, 750, 0, 0, '', NULL, NULL),
(195, 57, 1, 0, 750, 0, '', NULL, NULL),
(196, 58, 1, 750, 0, 1, '', NULL, NULL),
(197, 58, 0, 0, 652.17, 0, '', NULL, NULL),
(198, 58, 0, 0, 97.83, 0, '', NULL, NULL),
(199, 58, 0, 1.15, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(200, 58, 0, 0, 1.15, 0, 'جرام ذهب عيار 21', NULL, NULL),
(201, 59, 0, 750, 0, 0, '', NULL, NULL),
(202, 59, 1, 0, 750, 0, '', NULL, NULL),
(203, 60, 1, 750, 0, 1, '', NULL, NULL),
(204, 60, 0, 0, 652.17, 0, '', NULL, NULL),
(205, 60, 0, 0, 97.83, 0, '', NULL, NULL),
(206, 60, 0, 1.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(207, 60, 0, 0, 1.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(208, 61, 0, 1730, 0, 0, '', NULL, NULL),
(209, 61, 1, 0, 1730, 0, '', NULL, NULL),
(210, 62, 1, 1730, 0, 1, '', NULL, NULL),
(211, 62, 0, 0, 1504.35, 0, '', NULL, NULL),
(212, 62, 0, 0, 225.65, 0, '', NULL, NULL),
(213, 62, 0, 2.83, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(214, 62, 0, 0, 2.83, 0, 'جرام ذهب عيار 21', NULL, NULL),
(215, 63, 0, 11425, 0, 0, '', NULL, NULL),
(216, 63, 1, 0, 11425, 0, '', NULL, NULL),
(217, 64, 1, 11425, 0, 1, '', NULL, NULL),
(218, 64, 0, 0, 9934.78, 0, '', NULL, NULL),
(219, 64, 0, 0, 1490.22, 0, '', NULL, NULL),
(220, 64, 0, 18.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(221, 64, 0, 0, 18.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(222, 65, 0, 1900, 0, 0, '', NULL, NULL),
(223, 65, 1, 0, 1900, 0, '', NULL, NULL),
(224, 66, 1, 1900, 0, 1, '', NULL, NULL),
(225, 66, 0, 0, 1652.17, 0, '', NULL, NULL),
(226, 66, 0, 0, 247.83, 0, '', NULL, NULL),
(227, 66, 0, 2.14, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(228, 66, 0, 0, 2.14, 0, 'جرام ذهب عيار 21', NULL, NULL),
(229, 67, 0, 2330, 0, 0, '', NULL, NULL),
(230, 67, 1, 0, 2330, 0, '', NULL, NULL),
(231, 68, 1, 2330, 0, 1, '', NULL, NULL),
(232, 68, 0, 0, 2026.09, 0, '', NULL, NULL),
(233, 68, 0, 0, 303.91, 0, '', NULL, NULL),
(234, 68, 0, 3.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(235, 68, 0, 0, 3.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(236, 69, 0, 650, 0, 0, '', NULL, NULL),
(237, 69, 1, 0, 650, 0, '', NULL, NULL),
(238, 70, 1, 650, 0, 1, '', NULL, NULL),
(239, 70, 0, 0, 565.22, 0, '', NULL, NULL),
(240, 70, 0, 0, 84.78, 0, '', NULL, NULL),
(241, 70, 0, 1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(242, 70, 0, 0, 1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(243, 71, 0, 3975, 0, 0, '', NULL, NULL),
(244, 71, 1, 0, 3975, 0, '', NULL, NULL),
(245, 72, 1, 3975, 0, 1, '', NULL, NULL),
(246, 72, 0, 0, 3456.52, 0, '', NULL, NULL),
(247, 72, 0, 0, 518.48, 0, '', NULL, NULL),
(248, 72, 0, 6.15, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(249, 72, 0, 0, 6.15, 0, 'جرام ذهب عيار 21', NULL, NULL),
(250, 73, 0, 2775, 0, 0, '', NULL, NULL),
(251, 73, 1, 0, 2775, 0, '', NULL, NULL),
(252, 74, 1, 2775, 0, 1, '', NULL, NULL),
(253, 74, 0, 0, 2413.04, 0, '', NULL, NULL),
(254, 74, 0, 0, 361.96, 0, '', NULL, NULL),
(255, 74, 0, 4.29, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(256, 74, 0, 0, 4.29, 0, 'جرام ذهب عيار 21', NULL, NULL),
(257, 75, 0, 2800, 0, 0, '', NULL, NULL),
(258, 75, 1, 0, 2800, 0, '', NULL, NULL),
(259, 76, 1, 2800, 0, 1, '', NULL, NULL),
(260, 76, 0, 0, 2434.78, 0, '', NULL, NULL),
(261, 76, 0, 0, 365.22, 0, '', NULL, NULL),
(262, 76, 0, 4.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(263, 76, 0, 0, 4.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(264, 77, 0, 1200, 0, 0, '', NULL, NULL),
(265, 77, 1, 0, 1200, 0, '', NULL, NULL),
(266, 78, 0, 150, 0, 0, '', NULL, NULL),
(267, 78, 1, 0, 150, 0, '', NULL, NULL),
(268, 79, 1, 1350, 0, 1, '', NULL, NULL),
(269, 79, 0, 0, 1173.91, 0, '', NULL, NULL),
(270, 79, 0, 0, 176.09, 0, '', NULL, NULL),
(271, 79, 0, 1.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(272, 79, 0, 0, 1.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(273, 80, 0, 3000, 0, 0, '', NULL, NULL),
(274, 80, 1, 0, 3000, 0, '', NULL, NULL),
(275, 81, 1, 3000, 0, 1, '', NULL, NULL),
(276, 81, 0, 0, 2608.7, 0, '', NULL, NULL),
(277, 81, 0, 0, 391.3, 0, '', NULL, NULL),
(278, 81, 0, 4.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(279, 81, 0, 0, 4.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(280, 82, 0, 580, 0, 0, '', NULL, NULL),
(281, 82, 1, 0, 580, 0, '', NULL, NULL),
(282, 83, 1, 580, 0, 1, '', NULL, NULL),
(283, 83, 0, 0, 504.35, 0, '', NULL, NULL),
(284, 83, 0, 0, 75.65, 0, '', NULL, NULL),
(285, 83, 0, 0.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(286, 83, 0, 0, 0.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(287, 84, 0, 1250, 0, 0, '', NULL, NULL),
(288, 84, 1, 0, 1250, 0, '', NULL, NULL),
(289, 85, 1, 1250, 0, 1, '', NULL, NULL),
(290, 85, 0, 0, 1086.96, 0, '', NULL, NULL),
(291, 85, 0, 0, 163.04, 0, '', NULL, NULL),
(292, 85, 0, 2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(293, 85, 0, 0, 2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(294, 86, 0, 3150, 0, 0, '', NULL, NULL),
(295, 86, 1, 0, 3150, 0, '', NULL, NULL),
(296, 87, 1, 3150, 0, 1, '', NULL, NULL),
(297, 87, 0, 0, 2739.13, 0, '', NULL, NULL),
(298, 87, 0, 0, 410.87, 0, '', NULL, NULL),
(299, 87, 0, 5.23, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(300, 87, 0, 0, 5.23, 0, 'جرام ذهب عيار 21', NULL, NULL),
(301, 88, 0, 1600, 0, 0, '', NULL, NULL),
(302, 88, 1, 0, 1600, 0, '', NULL, NULL),
(303, 89, 0, 50, 0, 0, '', NULL, NULL),
(304, 89, 1, 0, 50, 0, '', NULL, NULL),
(305, 90, 1, 1650, 0, 1, '', NULL, NULL),
(306, 90, 0, 0, 1434.78, 0, '', NULL, NULL),
(307, 90, 0, 0, 215.22, 0, '', NULL, NULL),
(308, 90, 0, 2.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(309, 90, 0, 0, 2.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(310, 91, 0, 2580, 0, 0, '', NULL, NULL),
(311, 91, 1, 0, 2580, 0, '', NULL, NULL),
(312, 92, 1, 2580, 0, 1, '', NULL, NULL),
(313, 92, 0, 0, 2243.48, 0, '', NULL, NULL),
(314, 92, 0, 0, 336.52, 0, '', NULL, NULL),
(315, 92, 0, 4.29, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(316, 92, 0, 0, 4.29, 0, 'جرام ذهب عيار 21', NULL, NULL),
(317, 93, 0, 1000, 0, 0, '', NULL, NULL),
(318, 93, 1, 0, 1000, 0, '', NULL, NULL),
(319, 94, 1, 1000, 0, 1, '', NULL, NULL),
(320, 94, 0, 0, 869.57, 0, '', NULL, NULL),
(321, 94, 0, 0, 130.43, 0, '', NULL, NULL),
(322, 94, 0, 1.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(323, 94, 0, 0, 1.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(324, 95, 0, 25700, 0, 0, '', NULL, NULL),
(325, 95, 1, 0, 25700, 0, '', NULL, NULL),
(326, 96, 1, 25700, 0, 1, '', NULL, NULL),
(327, 96, 0, 0, 22347.83, 0, '', NULL, NULL),
(328, 96, 0, 0, 3352.17, 0, '', NULL, NULL),
(329, 96, 0, 40.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(330, 96, 0, 0, 40.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(331, 97, 0, 3100, 0, 0, '', NULL, NULL),
(332, 97, 1, 0, 3100, 0, '', NULL, NULL),
(333, 98, 1, 3100, 0, 1, '', NULL, NULL),
(334, 98, 0, 0, 2695.65, 0, '', NULL, NULL),
(335, 98, 0, 0, 404.35, 0, '', NULL, NULL),
(336, 98, 0, 5.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(337, 98, 0, 0, 5.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(338, 99, 0, 1350, 0, 0, '', NULL, NULL),
(339, 99, 1, 0, 1350, 0, '', NULL, NULL),
(340, 100, 1, 1350, 0, 1, '', NULL, NULL),
(341, 100, 0, 0, 1173.91, 0, '', NULL, NULL),
(342, 100, 0, 0, 176.09, 0, '', NULL, NULL),
(343, 100, 0, 1.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(344, 100, 0, 0, 1.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(345, 101, 0, 600, 0, 0, '', NULL, NULL),
(346, 101, 1, 0, 600, 0, '', NULL, NULL),
(347, 102, 0, 630, 0, 0, '', NULL, NULL),
(348, 102, 1, 0, 630, 0, '', NULL, NULL),
(349, 103, 1, 1230, 0, 1, '', NULL, NULL),
(350, 103, 0, 0, 1069.57, 0, '', NULL, NULL),
(351, 103, 0, 0, 160.43, 0, '', NULL, NULL),
(352, 103, 0, 1.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(353, 103, 0, 0, 1.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(354, 104, 0, 4700, 0, 0, '', NULL, NULL),
(355, 104, 1, 0, 4700, 0, '', NULL, NULL),
(356, 105, 1, 4700, 0, 1, '', NULL, NULL),
(357, 105, 0, 0, 4086.96, 0, '', NULL, NULL),
(358, 105, 0, 0, 613.04, 0, '', NULL, NULL),
(359, 105, 0, 7.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(360, 105, 0, 0, 7.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(361, 106, 0, 7130, 0, 0, '', NULL, NULL),
(362, 106, 1, 0, 7130, 0, '', NULL, NULL),
(363, 107, 0, 150, 0, 0, '', NULL, NULL),
(364, 107, 1, 0, 150, 0, '', NULL, NULL),
(365, 108, 1, 7280, 0, 1, '', NULL, NULL),
(366, 108, 0, 0, 6330.43, 0, '', NULL, NULL),
(367, 108, 0, 0, 949.57, 0, '', NULL, NULL),
(368, 108, 0, 11.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(369, 108, 0, 0, 11.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(370, 109, 0, 965, 0, 0, '', NULL, NULL),
(371, 109, 1, 0, 965, 0, '', NULL, NULL),
(372, 110, 1, 965, 0, 1, '', NULL, NULL),
(373, 110, 0, 0, 839.13, 0, '', NULL, NULL),
(374, 110, 0, 0, 125.87, 0, '', NULL, NULL),
(375, 110, 0, 1.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(376, 110, 0, 0, 1.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(377, 111, 0, 1620, 0, 0, '', NULL, NULL),
(378, 111, 1, 0, 1620, 0, '', NULL, NULL),
(379, 112, 1, 1620, 0, 1, '', NULL, NULL),
(380, 112, 0, 0, 1408.7, 0, '', NULL, NULL),
(381, 112, 0, 0, 211.3, 0, '', NULL, NULL),
(382, 112, 0, 2.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(383, 112, 0, 0, 2.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(384, 113, 0, 1350, 0, 0, '', NULL, NULL),
(385, 113, 1, 0, 1350, 0, '', NULL, NULL),
(386, 114, 1, 1350, 0, 1, '', NULL, NULL),
(387, 114, 0, 0, 1173.91, 0, '', NULL, NULL),
(388, 114, 0, 0, 176.09, 0, '', NULL, NULL),
(389, 114, 0, 2.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(390, 114, 0, 0, 2.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(391, 115, 0, 650, 0, 0, '', NULL, NULL),
(392, 115, 1, 0, 650, 0, '', NULL, NULL),
(393, 116, 1, 650, 0, 1, '', NULL, NULL),
(394, 116, 0, 0, 565.22, 0, '', NULL, NULL),
(395, 116, 0, 0, 84.78, 0, '', NULL, NULL),
(396, 116, 0, 0.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(397, 116, 0, 0, 0.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(398, 117, 0, 1720, 0, 0, '', NULL, NULL),
(399, 117, 1, 0, 1720, 0, '', NULL, NULL),
(400, 118, 0, 150, 0, 0, '', NULL, NULL),
(401, 118, 1, 0, 150, 0, '', NULL, NULL),
(402, 119, 1, 1870, 0, 1, '', NULL, NULL),
(403, 119, 0, 0, 1626.09, 0, '', NULL, NULL),
(404, 119, 0, 0, 243.91, 0, '', NULL, NULL),
(405, 119, 0, 3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(406, 119, 0, 0, 3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(407, 120, 0, 1850, 0, 0, '', NULL, NULL),
(408, 120, 1, 0, 1850, 0, '', NULL, NULL),
(409, 121, 1, 1850, 0, 1, '', NULL, NULL),
(410, 121, 0, 0, 1608.7, 0, '', NULL, NULL),
(411, 121, 0, 0, 241.3, 0, '', NULL, NULL),
(412, 121, 0, 3.14, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(413, 121, 0, 0, 3.14, 0, 'جرام ذهب عيار 21', NULL, NULL),
(414, 122, 0, 2020, 0, 0, '', NULL, NULL),
(415, 122, 1, 0, 2020, 0, '', NULL, NULL),
(416, 123, 1, 2020, 0, 1, '', NULL, NULL),
(417, 123, 0, 0, 1756.52, 0, '', NULL, NULL),
(418, 123, 0, 0, 263.48, 0, '', NULL, NULL),
(419, 123, 0, 3.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(420, 123, 0, 0, 3.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(421, 124, 0, 12040, 0, 0, '', NULL, NULL),
(422, 124, 1, 0, 12040, 0, '', NULL, NULL),
(423, 125, 0, 2400, 0, 0, '', NULL, NULL),
(424, 125, 1, 0, 2400, 0, '', NULL, NULL),
(425, 126, 1, 14440, 0, 1, '', NULL, NULL),
(426, 126, 0, 0, 12556.52, 0, '', NULL, NULL),
(427, 126, 0, 0, 1883.48, 0, '', NULL, NULL),
(428, 126, 0, 23.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(429, 126, 0, 0, 23.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(430, 127, 0, 2300, 0, 0, '', NULL, NULL),
(431, 127, 1, 0, 2300, 0, '', NULL, NULL),
(432, 128, 1, 2300, 0, 1, '', NULL, NULL),
(433, 128, 0, 0, 2000, 0, '', NULL, NULL),
(434, 128, 0, 0, 300, 0, '', NULL, NULL),
(435, 128, 0, 3.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(436, 128, 0, 0, 3.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(437, 129, 0, 870, 0, 0, '', NULL, NULL),
(438, 129, 1, 0, 870, 0, '', NULL, NULL),
(439, 130, 1, 870, 0, 1, '', NULL, NULL),
(440, 130, 0, 0, 756.52, 0, '', NULL, NULL),
(441, 130, 0, 0, 113.48, 0, '', NULL, NULL),
(442, 130, 0, 1.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(443, 130, 0, 0, 1.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(444, 131, 0, 1100, 0, 0, '', NULL, NULL),
(445, 131, 1, 0, 1100, 0, '', NULL, NULL),
(446, 132, 1, 1100, 0, 1, '', NULL, NULL),
(447, 132, 0, 0, 956.52, 0, '', NULL, NULL),
(448, 132, 0, 0, 143.48, 0, '', NULL, NULL),
(449, 132, 0, 1.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(450, 132, 0, 0, 1.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(451, 133, 0, 2200, 0, 0, '', NULL, NULL),
(452, 133, 1, 0, 2200, 0, '', NULL, NULL),
(453, 134, 1, 2200, 0, 1, '', NULL, NULL),
(454, 134, 0, 0, 1913.04, 0, '', NULL, NULL),
(455, 134, 0, 0, 286.96, 0, '', NULL, NULL),
(456, 134, 0, 2.91, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(457, 134, 0, 0, 2.91, 0, 'جرام ذهب عيار 21', NULL, NULL),
(458, 135, 0, 800, 0, 0, '', NULL, NULL),
(459, 135, 1, 0, 800, 0, '', NULL, NULL),
(460, 136, 1, 800, 0, 1, '', NULL, NULL),
(461, 136, 0, 0, 695.65, 0, '', NULL, NULL),
(462, 136, 0, 0, 104.35, 0, '', NULL, NULL),
(463, 136, 0, 1.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(464, 136, 0, 0, 1.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(465, 137, 0, 100, 0, 0, '', NULL, NULL),
(466, 137, 1, 0, 100, 0, '', NULL, NULL),
(467, 138, 0, 3000, 0, 0, '', NULL, NULL),
(468, 138, 1, 0, 3000, 0, '', NULL, NULL),
(469, 139, 1, 3100, 0, 1, '', NULL, NULL),
(470, 139, 0, 0, 2695.65, 0, '', NULL, NULL),
(471, 139, 0, 0, 404.35, 0, '', NULL, NULL),
(472, 139, 0, 5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(473, 139, 0, 0, 5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(474, 140, 0, 630, 0, 0, '', NULL, NULL),
(475, 140, 1, 0, 630, 0, '', NULL, NULL),
(476, 141, 1, 630, 0, 1, '', NULL, NULL),
(477, 141, 0, 0, 547.83, 0, '', NULL, NULL),
(478, 141, 0, 0, 82.17, 0, '', NULL, NULL),
(479, 141, 0, 1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(480, 141, 0, 0, 1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(481, 142, 0, 920, 0, 0, '', NULL, NULL),
(482, 142, 1, 0, 920, 0, '', NULL, NULL),
(483, 143, 1, 920, 0, 1, '', NULL, NULL),
(484, 143, 0, 0, 800, 0, '', NULL, NULL),
(485, 143, 0, 0, 120, 0, '', NULL, NULL),
(486, 143, 0, 1.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(487, 143, 0, 0, 1.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(488, 144, 0, 1540, 0, 0, '', NULL, NULL),
(489, 144, 1, 0, 1540, 0, '', NULL, NULL),
(490, 145, 1, 1540, 0, 1, '', NULL, NULL),
(491, 145, 0, 0, 1339.13, 0, '', NULL, NULL),
(492, 145, 0, 0, 200.87, 0, '', NULL, NULL),
(493, 145, 0, 2.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(494, 145, 0, 0, 2.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(495, 146, 0, 11770, 0, 0, '', NULL, NULL),
(496, 146, 1, 0, 11770, 0, '', NULL, NULL),
(497, 147, 0, 2000, 0, 0, '', NULL, NULL),
(498, 147, 1, 0, 2000, 0, '', NULL, NULL),
(499, 148, 1, 13770, 0, 1, '', NULL, NULL),
(500, 148, 0, 0, 11973.91, 0, '', NULL, NULL),
(501, 148, 0, 0, 1796.09, 0, '', NULL, NULL),
(502, 148, 0, 22.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(503, 148, 0, 0, 22.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(504, 149, 0, 750, 0, 0, '', NULL, NULL),
(505, 149, 1, 0, 750, 0, '', NULL, NULL),
(506, 150, 1, 750, 0, 1, '', NULL, NULL),
(507, 150, 0, 0, 652.17, 0, '', NULL, NULL),
(508, 150, 0, 0, 97.83, 0, '', NULL, NULL),
(509, 150, 0, 1.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(510, 150, 0, 0, 1.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(511, 151, 0, 1400, 0, 0, '', NULL, NULL),
(512, 151, 1, 0, 1400, 0, '', NULL, NULL),
(513, 152, 1, 1400, 0, 1, '', NULL, NULL),
(514, 152, 0, 0, 1217.39, 0, '', NULL, NULL),
(515, 152, 0, 0, 182.61, 0, '', NULL, NULL),
(516, 152, 0, 2.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(517, 152, 0, 0, 2.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(518, 153, 0, 600, 0, 0, '', NULL, NULL),
(519, 153, 1, 0, 600, 0, '', NULL, NULL),
(520, 154, 0, 3000, 0, 0, '', NULL, NULL),
(521, 154, 1, 0, 3000, 0, '', NULL, NULL),
(522, 155, 1, 3600, 0, 1, '', NULL, NULL),
(523, 155, 0, 0, 3130.43, 0, '', NULL, NULL),
(524, 155, 0, 0, 469.57, 0, '', NULL, NULL),
(525, 155, 0, 5.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(526, 155, 0, 0, 5.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(527, 156, 0, 550, 0, 0, '', NULL, NULL),
(528, 156, 1, 0, 550, 0, '', NULL, NULL),
(529, 157, 1, 550, 0, 1, '', NULL, NULL),
(530, 157, 0, 0, 478.26, 0, '', NULL, NULL),
(531, 157, 0, 0, 71.74, 0, '', NULL, NULL),
(532, 157, 0, 0.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(533, 157, 0, 0, 0.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(534, 158, 0, 3450, 0, 0, '', NULL, NULL),
(535, 158, 1, 0, 3450, 0, '', NULL, NULL),
(536, 159, 1, 3450, 0, 1, '', NULL, NULL),
(537, 159, 0, 0, 3000, 0, '', NULL, NULL),
(538, 159, 0, 0, 450, 0, '', NULL, NULL),
(539, 159, 0, 5.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(540, 159, 0, 0, 5.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(541, 160, 0, 14000, 0, 0, '', NULL, NULL),
(542, 160, 1, 0, 14000, 0, '', NULL, NULL),
(543, 161, 0, 650, 0, 0, '', NULL, NULL),
(544, 161, 1, 0, 650, 0, '', NULL, NULL),
(545, 162, 1, 14650, 0, 1, '', NULL, NULL),
(546, 162, 0, 0, 12739.13, 0, '', NULL, NULL),
(547, 162, 0, 0, 1910.87, 0, '', NULL, NULL),
(548, 162, 0, 22.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(549, 162, 0, 0, 22.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(550, 163, 0, 1420, 0, 0, '', NULL, NULL),
(551, 163, 1, 0, 1420, 0, '', NULL, NULL),
(552, 164, 1, 1420, 0, 1, '', NULL, NULL),
(553, 164, 0, 0, 1234.78, 0, '', NULL, NULL),
(554, 164, 0, 0, 185.22, 0, '', NULL, NULL),
(555, 164, 0, 2.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(556, 164, 0, 0, 2.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(557, 165, 0, 1600, 0, 0, '', NULL, NULL),
(558, 165, 1, 0, 1600, 0, '', NULL, NULL),
(559, 166, 1, 1600, 0, 1, '', NULL, NULL),
(560, 166, 0, 0, 1391.3, 0, '', NULL, NULL),
(561, 166, 0, 0, 208.7, 0, '', NULL, NULL),
(562, 166, 0, 2.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(563, 166, 0, 0, 2.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(564, 167, 0, 3930, 0, 0, '', NULL, NULL),
(565, 167, 1, 0, 3930, 0, '', NULL, NULL),
(566, 168, 1, 3930, 0, 1, '', NULL, NULL),
(567, 168, 0, 0, 3417.39, 0, '', NULL, NULL),
(568, 168, 0, 0, 512.61, 0, '', NULL, NULL),
(569, 168, 0, 5.97, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(570, 168, 0, 0, 5.97, 0, 'جرام ذهب عيار 21', NULL, NULL),
(571, 169, 0, 950, 0, 0, '', NULL, NULL),
(572, 169, 1, 0, 950, 0, '', NULL, NULL),
(573, 170, 1, 950, 0, 1, '', NULL, NULL),
(574, 170, 0, 0, 826.09, 0, '', NULL, NULL),
(575, 170, 0, 0, 123.91, 0, '', NULL, NULL),
(576, 170, 0, 1.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(577, 170, 0, 0, 1.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(578, 171, 0, 980, 0, 0, '', NULL, NULL),
(579, 171, 1, 0, 980, 0, '', NULL, NULL),
(580, 172, 1, 980, 0, 1, '', NULL, NULL),
(581, 172, 0, 0, 852.17, 0, '', NULL, NULL),
(582, 172, 0, 0, 127.83, 0, '', NULL, NULL),
(583, 172, 0, 1.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(584, 172, 0, 0, 1.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(585, 173, 0, 1300, 0, 0, '', NULL, NULL),
(586, 173, 1, 0, 1300, 0, '', NULL, NULL),
(587, 174, 1, 1300, 0, 1, '', NULL, NULL),
(588, 174, 0, 0, 1130.43, 0, '', NULL, NULL),
(589, 174, 0, 0, 169.57, 0, '', NULL, NULL),
(590, 174, 0, 1.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(591, 174, 0, 0, 1.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(592, 175, 0, 4535, 0, 0, '', NULL, NULL),
(593, 175, 1, 0, 4535, 0, '', NULL, NULL),
(594, 176, 1, 4535, 0, 1, '', NULL, NULL),
(595, 176, 0, 0, 3943.48, 0, '', NULL, NULL),
(596, 176, 0, 0, 591.52, 0, '', NULL, NULL),
(597, 176, 0, 7.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(598, 176, 0, 0, 7.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(599, 177, 0, 1100, 0, 0, '', NULL, NULL),
(600, 177, 1, 0, 1100, 0, '', NULL, NULL),
(601, 178, 1, 1100, 0, 1, '', NULL, NULL),
(602, 178, 0, 0, 956.52, 0, '', NULL, NULL),
(603, 178, 0, 0, 143.48, 0, '', NULL, NULL),
(604, 178, 0, 1.54, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(605, 178, 0, 0, 1.54, 0, 'جرام ذهب عيار 21', NULL, NULL),
(606, 179, 0, 830, 0, 0, '', NULL, NULL),
(607, 179, 1, 0, 830, 0, '', NULL, NULL),
(608, 180, 1, 830, 0, 1, '', NULL, NULL),
(609, 180, 0, 0, 721.74, 0, '', NULL, NULL),
(610, 180, 0, 0, 108.26, 0, '', NULL, NULL),
(611, 180, 0, 1.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(612, 180, 0, 0, 1.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(613, 181, 0, 8600, 0, 0, '', NULL, NULL),
(614, 181, 1, 0, 8600, 0, '', NULL, NULL),
(615, 182, 1, 8600, 0, 1, '', NULL, NULL),
(616, 182, 0, 0, 7478.26, 0, '', NULL, NULL),
(617, 182, 0, 0, 1121.74, 0, '', NULL, NULL),
(618, 182, 0, 13.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(619, 182, 0, 0, 13.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(620, 183, 0, 2800, 0, 0, '', NULL, NULL),
(621, 183, 1, 0, 2800, 0, '', NULL, NULL),
(622, 184, 1, 2800, 0, 1, '', NULL, NULL),
(623, 184, 0, 0, 2434.78, 0, '', NULL, NULL),
(624, 184, 0, 0, 365.22, 0, '', NULL, NULL),
(625, 184, 0, 4.23, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(626, 184, 0, 0, 4.23, 0, 'جرام ذهب عيار 21', NULL, NULL),
(627, 185, 0, 2150, 0, 0, '', NULL, NULL),
(628, 185, 1, 0, 2150, 0, '', NULL, NULL),
(629, 186, 1, 2150, 0, 1, '', NULL, NULL),
(630, 186, 0, 0, 1869.57, 0, '', NULL, NULL),
(631, 186, 0, 0, 280.43, 0, '', NULL, NULL),
(632, 186, 0, 3.35, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(633, 186, 0, 0, 3.35, 0, 'جرام ذهب عيار 21', NULL, NULL),
(634, 187, 0, 290, 0, 0, '', NULL, NULL),
(635, 187, 1, 0, 290, 0, '', NULL, NULL),
(636, 188, 0, 500, 0, 0, '', NULL, NULL),
(637, 188, 1, 0, 500, 0, '', NULL, NULL),
(638, 189, 1, 790, 0, 1, '', NULL, NULL),
(639, 189, 0, 0, 686.96, 0, '', NULL, NULL),
(640, 189, 0, 0, 103.04, 0, '', NULL, NULL),
(641, 189, 0, 1.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(642, 189, 0, 0, 1.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(643, 190, 0, 42000, 0, 0, '', NULL, NULL),
(644, 190, 1, 0, 42000, 0, '', NULL, NULL),
(645, 191, 1, 42000, 0, 1, '', NULL, NULL),
(646, 191, 0, 0, 36521.73, 0, '', NULL, NULL),
(647, 191, 0, 0, 5478.27, 0, '', NULL, NULL),
(648, 191, 0, 64.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(649, 191, 0, 0, 64.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(650, 192, 0, 3100, 0, 0, '', NULL, NULL),
(651, 192, 1, 0, 3100, 0, '', NULL, NULL),
(652, 193, 1, 3100, 0, 1, '', NULL, NULL),
(653, 193, 0, 0, 2695.65, 0, '', NULL, NULL),
(654, 193, 0, 0, 404.35, 0, '', NULL, NULL),
(655, 193, 0, 5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(656, 193, 0, 0, 5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(657, 194, 0, 5350, 0, 0, '', NULL, NULL),
(658, 194, 1, 0, 5350, 0, '', NULL, NULL),
(659, 195, 1, 5350, 0, 1, '', NULL, NULL),
(660, 195, 0, 0, 4652.17, 0, '', NULL, NULL),
(661, 195, 0, 0, 697.83, 0, '', NULL, NULL),
(662, 195, 0, 8.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(663, 195, 0, 0, 8.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(664, 196, 0, 1550, 0, 0, '', NULL, NULL),
(665, 196, 1, 0, 1550, 0, '', NULL, NULL),
(666, 197, 1, 1550, 0, 1, '', NULL, NULL),
(667, 197, 0, 0, 1347.83, 0, '', NULL, NULL),
(668, 197, 0, 0, 202.17, 0, '', NULL, NULL),
(669, 197, 0, 2.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(670, 197, 0, 0, 2.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(671, 198, 0, 7400, 0, 0, '', NULL, NULL),
(672, 198, 1, 0, 7400, 0, '', NULL, NULL),
(673, 199, 1, 7400, 0, 1, '', NULL, NULL),
(674, 199, 0, 0, 6434.78, 0, '', NULL, NULL),
(675, 199, 0, 0, 965.22, 0, '', NULL, NULL),
(676, 199, 0, 11.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(677, 199, 0, 0, 11.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(678, 200, 0, 31100, 0, 0, '', NULL, NULL),
(679, 200, 1, 0, 31100, 0, '', NULL, NULL),
(680, 201, 1, 31100, 0, 1, '', NULL, NULL),
(681, 201, 0, 0, 27043.48, 0, '', NULL, NULL),
(682, 201, 0, 0, 4056.52, 0, '', NULL, NULL),
(683, 201, 0, 48.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(684, 201, 0, 0, 48.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(685, 202, 0, 4450, 0, 0, '', NULL, NULL),
(686, 202, 1, 0, 4450, 0, '', NULL, NULL),
(687, 203, 1, 4450, 0, 1, '', NULL, NULL),
(688, 203, 0, 0, 3869.57, 0, '', NULL, NULL),
(689, 203, 0, 0, 580.43, 0, '', NULL, NULL),
(690, 203, 0, 6.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(691, 203, 0, 0, 6.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(692, 204, 0, 7700, 0, 0, '', NULL, NULL),
(693, 204, 1, 0, 7700, 0, '', NULL, NULL),
(694, 205, 1, 7700, 0, 1, '', NULL, NULL),
(695, 205, 0, 0, 6695.65, 0, '', NULL, NULL),
(696, 205, 0, 0, 1004.35, 0, '', NULL, NULL),
(697, 205, 0, 11.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(698, 205, 0, 0, 11.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(699, 206, 0, 1550, 0, 0, '', NULL, NULL),
(700, 206, 1, 0, 1550, 0, '', NULL, NULL),
(701, 207, 1, 1550, 0, 1, '', NULL, NULL),
(702, 207, 0, 0, 1347.83, 0, '', NULL, NULL),
(703, 207, 0, 0, 202.17, 0, '', NULL, NULL),
(704, 207, 0, 2.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(705, 207, 0, 0, 2.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(706, 208, 0, 400, 0, 0, '', NULL, NULL),
(707, 208, 1, 0, 400, 0, '', NULL, NULL),
(708, 209, 1, 400, 0, 1, '', NULL, NULL),
(709, 209, 0, 0, 347.83, 0, '', NULL, NULL),
(710, 209, 0, 0, 52.17, 0, '', NULL, NULL),
(711, 209, 0, 0.51, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(712, 209, 0, 0, 0.51, 0, 'جرام ذهب عيار 21', NULL, NULL),
(713, 210, 0, 840, 0, 0, '', NULL, NULL),
(714, 210, 1, 0, 840, 0, '', NULL, NULL),
(715, 211, 1, 840, 0, 1, '', NULL, NULL),
(716, 211, 0, 0, 730.43, 0, '', NULL, NULL),
(717, 211, 0, 0, 109.57, 0, '', NULL, NULL),
(718, 211, 0, 1.22, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(719, 211, 0, 0, 1.22, 0, 'جرام ذهب عيار 21', NULL, NULL),
(720, 212, 0, 4450, 0, 0, '', NULL, NULL),
(721, 212, 1, 0, 4450, 0, '', NULL, NULL),
(722, 213, 1, 4450, 0, 1, '', NULL, NULL),
(723, 213, 0, 0, 3869.57, 0, '', NULL, NULL),
(724, 213, 0, 0, 580.43, 0, '', NULL, NULL),
(725, 213, 0, 7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(726, 213, 0, 0, 7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(727, 214, 0, 550, 0, 0, '', NULL, NULL),
(728, 214, 1, 0, 550, 0, '', NULL, NULL),
(729, 215, 1, 550, 0, 1, '', NULL, NULL),
(730, 215, 0, 0, 478.26, 0, '', NULL, NULL),
(731, 215, 0, 0, 71.74, 0, '', NULL, NULL),
(732, 215, 0, 0.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(733, 215, 0, 0, 0.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(734, 216, 0, 750, 0, 0, '', NULL, NULL),
(735, 216, 1, 0, 750, 0, '', NULL, NULL),
(736, 217, 1, 750, 0, 1, '', NULL, NULL),
(737, 217, 0, 0, 652.17, 0, '', NULL, NULL),
(738, 217, 0, 0, 97.83, 0, '', NULL, NULL),
(739, 217, 0, 1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(740, 217, 0, 0, 1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(741, 218, 0, 11300, 0, 0, '', NULL, NULL),
(742, 218, 1, 0, 11300, 0, '', NULL, NULL),
(743, 219, 0, 650, 0, 0, '', NULL, NULL),
(744, 219, 1, 0, 650, 0, '', NULL, NULL),
(745, 220, 1, 11950, 0, 1, '', NULL, NULL),
(746, 220, 0, 0, 10391.3, 0, '', NULL, NULL),
(747, 220, 0, 0, 1558.7, 0, '', NULL, NULL),
(748, 220, 0, 18.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(749, 220, 0, 0, 18.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(750, 221, 0, 800, 0, 0, '', NULL, NULL),
(751, 221, 1, 0, 800, 0, '', NULL, NULL),
(752, 222, 1, 800, 0, 1, '', NULL, NULL),
(753, 222, 0, 0, 695.65, 0, '', NULL, NULL),
(754, 222, 0, 0, 104.35, 0, '', NULL, NULL),
(755, 222, 0, 1.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(756, 222, 0, 0, 1.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(757, 223, 0, 1550, 0, 0, '', NULL, NULL),
(758, 223, 1, 0, 1550, 0, '', NULL, NULL),
(759, 224, 1, 1550, 0, 1, '', NULL, NULL),
(760, 224, 0, 0, 1347.83, 0, '', NULL, NULL),
(761, 224, 0, 0, 202.17, 0, '', NULL, NULL),
(762, 224, 0, 2.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(763, 224, 0, 0, 2.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(764, 225, 0, 1200, 0, 0, '', NULL, NULL),
(765, 225, 1, 0, 1200, 0, '', NULL, NULL),
(766, 226, 1, 1200, 0, 1, '', NULL, NULL),
(767, 226, 0, 0, 1043.48, 0, '', NULL, NULL),
(768, 226, 0, 0, 156.52, 0, '', NULL, NULL),
(769, 226, 0, 1.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(770, 226, 0, 0, 1.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(771, 227, 0, 1930, 0, 0, '', NULL, NULL),
(772, 227, 1, 0, 1930, 0, '', NULL, NULL),
(773, 228, 1, 1930, 0, 1, '', NULL, NULL),
(774, 228, 0, 0, 1678.26, 0, '', NULL, NULL),
(775, 228, 0, 0, 251.74, 0, '', NULL, NULL),
(776, 228, 0, 3.04, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(777, 228, 0, 0, 3.04, 0, 'جرام ذهب عيار 21', NULL, NULL),
(778, 229, 0, 5500, 0, 0, '', NULL, NULL),
(779, 229, 1, 0, 5500, 0, '', NULL, NULL),
(780, 230, 1, 5500, 0, 1, '', NULL, NULL),
(781, 230, 0, 0, 4782.61, 0, '', NULL, NULL),
(782, 230, 0, 0, 717.39, 0, '', NULL, NULL),
(783, 230, 0, 8.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(784, 230, 0, 0, 8.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(785, 231, 0, 5000, 0, 0, '', NULL, NULL),
(786, 231, 1, 0, 5000, 0, '', NULL, NULL),
(787, 232, 1, 5000, 0, 1, '', NULL, NULL),
(788, 232, 0, 0, 4347.83, 0, '', NULL, NULL),
(789, 232, 0, 0, 652.17, 0, '', NULL, NULL),
(790, 232, 0, 7.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(791, 232, 0, 0, 7.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(792, 233, 0, 16650, 0, 0, '', NULL, NULL),
(793, 233, 1, 0, 16650, 0, '', NULL, NULL),
(794, 234, 1, 16650, 0, 1, '', NULL, NULL),
(795, 234, 0, 0, 14478.26, 0, '', NULL, NULL),
(796, 234, 0, 0, 2171.74, 0, '', NULL, NULL),
(797, 234, 0, 25, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(798, 234, 0, 0, 25, 0, 'جرام ذهب عيار 21', NULL, NULL),
(799, 235, 0, 6000, 0, 0, '', NULL, NULL),
(800, 235, 1, 0, 6000, 0, '', NULL, NULL),
(801, 236, 0, 3500, 0, 0, '', NULL, NULL),
(802, 236, 1, 0, 3500, 0, '', NULL, NULL),
(803, 237, 1, 9500, 0, 1, '', NULL, NULL),
(804, 237, 0, 0, 8260.87, 0, '', NULL, NULL),
(805, 237, 0, 0, 1239.13, 0, '', NULL, NULL),
(806, 237, 0, 14.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(807, 237, 0, 0, 14.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(808, 238, 0, 1500, 0, 0, '', NULL, NULL),
(809, 238, 1, 0, 1500, 0, '', NULL, NULL),
(810, 239, 1, 1500, 0, 1, '', NULL, NULL),
(811, 239, 0, 0, 1304.35, 0, '', NULL, NULL),
(812, 239, 0, 0, 195.65, 0, '', NULL, NULL),
(813, 239, 0, 2.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(814, 239, 0, 0, 2.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(815, 240, 0, 6450, 0, 0, '', NULL, NULL),
(816, 240, 1, 0, 6450, 0, '', NULL, NULL),
(817, 241, 1, 6450, 0, 1, '', NULL, NULL),
(818, 241, 0, 0, 5608.7, 0, '', NULL, NULL),
(819, 241, 0, 0, 841.3, 0, '', NULL, NULL),
(820, 241, 0, 9.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(821, 241, 0, 0, 9.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(822, 242, 0, 1500, 0, 0, '', NULL, NULL),
(823, 242, 1, 0, 1500, 0, '', NULL, NULL),
(824, 243, 1, 1500, 0, 1, '', NULL, NULL),
(825, 243, 0, 0, 1304.35, 0, '', NULL, NULL),
(826, 243, 0, 0, 195.65, 0, '', NULL, NULL),
(827, 243, 0, 2.06, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(828, 243, 0, 0, 2.06, 0, 'جرام ذهب عيار 21', NULL, NULL),
(829, 244, 0, 3400, 0, 0, '', NULL, NULL),
(830, 244, 1, 0, 3400, 0, '', NULL, NULL),
(831, 245, 0, 2300, 0, 0, '', NULL, NULL),
(832, 245, 1, 0, 2300, 0, '', NULL, NULL),
(833, 246, 1, 5700, 0, 1, '', NULL, NULL),
(834, 246, 0, 0, 4956.52, 0, '', NULL, NULL),
(835, 246, 0, 0, 743.48, 0, '', NULL, NULL),
(836, 246, 0, 8.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(837, 246, 0, 0, 8.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(838, 247, 0, 1620, 0, 0, '', NULL, NULL),
(839, 247, 1, 0, 1620, 0, '', NULL, NULL),
(840, 248, 1, 1620, 0, 1, '', NULL, NULL),
(841, 248, 0, 0, 1408.7, 0, '', NULL, NULL),
(842, 248, 0, 0, 211.3, 0, '', NULL, NULL),
(843, 248, 0, 2.41, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(844, 248, 0, 0, 2.41, 0, 'جرام ذهب عيار 21', NULL, NULL),
(845, 249, 0, 10800, 0, 0, '', NULL, NULL),
(846, 249, 1, 0, 10800, 0, '', NULL, NULL),
(847, 250, 1, 10800, 0, 1, '', NULL, NULL),
(848, 250, 0, 0, 9391.3, 0, '', NULL, NULL),
(849, 250, 0, 0, 1408.7, 0, '', NULL, NULL),
(850, 250, 0, 16, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(851, 250, 0, 0, 16, 0, 'جرام ذهب عيار 21', NULL, NULL),
(852, 251, 0, 1980, 0, 0, '', NULL, NULL),
(853, 251, 1, 0, 1980, 0, '', NULL, NULL),
(854, 252, 1, 1980, 0, 1, '', NULL, NULL),
(855, 252, 0, 0, 1721.74, 0, '', NULL, NULL),
(856, 252, 0, 0, 258.26, 0, '', NULL, NULL),
(857, 252, 0, 2.57, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(858, 252, 0, 0, 2.57, 0, 'جرام ذهب عيار 21', NULL, NULL),
(859, 253, 0, 2230, 0, 0, '', NULL, NULL),
(860, 253, 1, 0, 2230, 0, '', NULL, NULL),
(861, 254, 1, 2230, 0, 1, '', NULL, NULL),
(862, 254, 0, 0, 1939.13, 0, '', NULL, NULL),
(863, 254, 0, 0, 290.87, 0, '', NULL, NULL),
(864, 254, 0, 3.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(865, 254, 0, 0, 3.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(866, 255, 0, 680, 0, 0, '', NULL, NULL),
(867, 255, 1, 0, 680, 0, '', NULL, NULL),
(868, 256, 0, 8240, 0, 0, '', NULL, NULL),
(869, 256, 1, 0, 8240, 0, '', NULL, NULL),
(870, 257, 1, 8920, 0, 1, '', NULL, NULL),
(871, 257, 0, 0, 7756.52, 0, '', NULL, NULL),
(872, 257, 0, 0, 1163.48, 0, '', NULL, NULL),
(873, 257, 0, 13.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(874, 257, 0, 0, 13.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(875, 258, 0, 10170, 0, 0, '', NULL, NULL),
(876, 258, 1, 0, 10170, 0, '', NULL, NULL),
(877, 259, 1, 10170, 0, 1, '', NULL, NULL),
(878, 259, 0, 0, 8843.48, 0, '', NULL, NULL),
(879, 259, 0, 0, 1326.52, 0, '', NULL, NULL),
(880, 259, 0, 15.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(881, 259, 0, 0, 15.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(882, 260, 0, 18900, 0, 0, '', NULL, NULL),
(883, 260, 1, 0, 18900, 0, '', NULL, NULL),
(884, 261, 1, 18900, 0, 1, '', NULL, NULL),
(885, 261, 0, 0, 16434.78, 0, '', NULL, NULL),
(886, 261, 0, 0, 2465.22, 0, '', NULL, NULL),
(887, 261, 0, 28.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(888, 261, 0, 0, 28.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(889, 262, 0, 2400, 0, 0, '', NULL, NULL),
(890, 262, 1, 0, 2400, 0, '', NULL, NULL),
(891, 263, 0, 6400, 0, 0, '', NULL, NULL),
(892, 263, 1, 0, 6400, 0, '', NULL, NULL),
(893, 264, 1, 8800, 0, 1, '', NULL, NULL),
(894, 264, 0, 0, 7652.17, 0, '', NULL, NULL),
(895, 264, 0, 0, 1147.83, 0, '', NULL, NULL),
(896, 264, 0, 13.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(897, 264, 0, 0, 13.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(898, 265, 0, 3000, 0, 0, '', NULL, NULL),
(899, 265, 1, 0, 3000, 0, '', NULL, NULL),
(900, 266, 0, 12500, 0, 0, '', NULL, NULL),
(901, 266, 1, 0, 12500, 0, '', NULL, NULL),
(902, 267, 1, 15500, 0, 1, '', NULL, NULL),
(903, 267, 0, 0, 13478.26, 0, '', NULL, NULL),
(904, 267, 0, 0, 2021.74, 0, '', NULL, NULL),
(905, 267, 0, 25, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(906, 267, 0, 0, 25, 0, 'جرام ذهب عيار 21', NULL, NULL),
(907, 268, 0, 5100, 0, 0, '', NULL, NULL),
(908, 268, 1, 0, 5100, 0, '', NULL, NULL),
(909, 269, 1, 5100, 0, 1, '', NULL, NULL),
(910, 269, 0, 0, 4434.78, 0, '', NULL, NULL),
(911, 269, 0, 0, 665.22, 0, '', NULL, NULL),
(912, 269, 0, 7.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(913, 269, 0, 0, 7.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(914, 270, 0, 1130, 0, 0, '', NULL, NULL),
(915, 270, 1, 0, 1130, 0, '', NULL, NULL),
(916, 271, 1, 1130, 0, 1, '', NULL, NULL),
(917, 271, 0, 0, 982.61, 0, '', NULL, NULL),
(918, 271, 0, 0, 147.39, 0, '', NULL, NULL),
(919, 271, 0, 1.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(920, 271, 0, 0, 1.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(921, 272, 0, 1810, 0, 0, '', NULL, NULL),
(922, 272, 1, 0, 1810, 0, '', NULL, NULL),
(923, 273, 1, 1810, 0, 1, '', NULL, NULL),
(924, 273, 0, 0, 1573.91, 0, '', NULL, NULL),
(925, 273, 0, 0, 236.09, 0, '', NULL, NULL),
(926, 273, 0, 2.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(927, 273, 0, 0, 2.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(928, 274, 0, 1040, 0, 0, '', NULL, NULL),
(929, 274, 1, 0, 1040, 0, '', NULL, NULL),
(930, 275, 1, 1040, 0, 1, '', NULL, NULL),
(931, 275, 0, 0, 904.35, 0, '', NULL, NULL),
(932, 275, 0, 0, 135.65, 0, '', NULL, NULL),
(933, 275, 0, 1.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(934, 275, 0, 0, 1.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(935, 276, 0, 910, 0, 0, '', NULL, NULL),
(936, 276, 1, 0, 910, 0, '', NULL, NULL),
(937, 277, 1, 910, 0, 1, '', NULL, NULL),
(938, 277, 0, 0, 791.3, 0, '', NULL, NULL),
(939, 277, 0, 0, 118.7, 0, '', NULL, NULL),
(940, 277, 0, 1.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(941, 277, 0, 0, 1.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(942, 278, 0, 7080, 0, 0, '', NULL, NULL),
(943, 278, 1, 0, 7080, 0, '', NULL, NULL),
(944, 279, 1, 7080, 0, 1, '', NULL, NULL),
(945, 279, 0, 0, 6156.52, 0, '', NULL, NULL),
(946, 279, 0, 0, 923.48, 0, '', NULL, NULL),
(947, 279, 0, 11, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(948, 279, 0, 0, 11, 0, 'جرام ذهب عيار 21', NULL, NULL),
(949, 280, 0, 2210, 0, 0, '', NULL, NULL),
(950, 280, 1, 0, 2210, 0, '', NULL, NULL),
(951, 281, 1, 2210, 0, 1, '', NULL, NULL),
(952, 281, 0, 0, 1921.74, 0, '', NULL, NULL),
(953, 281, 0, 0, 288.26, 0, '', NULL, NULL),
(954, 281, 0, 3.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(955, 281, 0, 0, 3.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(956, 282, 0, 550, 0, 0, '', NULL, NULL),
(957, 282, 1, 0, 550, 0, '', NULL, NULL),
(958, 283, 1, 550, 0, 1, '', NULL, NULL),
(959, 283, 0, 0, 478.26, 0, '', NULL, NULL),
(960, 283, 0, 0, 71.74, 0, '', NULL, NULL),
(961, 283, 0, 0.74, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(962, 283, 0, 0, 0.74, 0, 'جرام ذهب عيار 21', NULL, NULL),
(963, 284, 0, 1000, 0, 0, '', NULL, NULL),
(964, 284, 1, 0, 1000, 0, '', NULL, NULL),
(965, 285, 1, 1000, 0, 1, '', NULL, NULL),
(966, 285, 0, 0, 869.57, 0, '', NULL, NULL),
(967, 285, 0, 0, 130.43, 0, '', NULL, NULL),
(968, 285, 0, 1.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(969, 285, 0, 0, 1.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(970, 286, 0, 1150, 0, 0, '', NULL, NULL),
(971, 286, 1, 0, 1150, 0, '', NULL, NULL),
(972, 287, 1, 1150, 0, 1, '', NULL, NULL),
(973, 287, 0, 0, 1000, 0, '', NULL, NULL),
(974, 287, 0, 0, 150, 0, '', NULL, NULL),
(975, 287, 0, 1.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(976, 287, 0, 0, 1.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(977, 288, 0, 1250, 0, 0, '', NULL, NULL),
(978, 288, 1, 0, 1250, 0, '', NULL, NULL),
(979, 289, 1, 1250, 0, 1, '', NULL, NULL),
(980, 289, 0, 0, 1086.96, 0, '', NULL, NULL),
(981, 289, 0, 0, 163.04, 0, '', NULL, NULL),
(982, 289, 0, 1.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(983, 289, 0, 0, 1.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(984, 290, 0, 1000, 0, 0, '', NULL, NULL),
(985, 290, 1, 0, 1000, 0, '', NULL, NULL),
(986, 291, 1, 1000, 0, 1, '', NULL, NULL),
(987, 291, 0, 0, 869.57, 0, '', NULL, NULL),
(988, 291, 0, 0, 130.43, 0, '', NULL, NULL),
(989, 291, 0, 1.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(990, 291, 0, 0, 1.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(991, 292, 0, 1290, 0, 0, '', NULL, NULL),
(992, 292, 1, 0, 1290, 0, '', NULL, NULL),
(993, 293, 1, 1290, 0, 1, '', NULL, NULL),
(994, 293, 0, 0, 1121.74, 0, '', NULL, NULL),
(995, 293, 0, 0, 168.26, 0, '', NULL, NULL),
(996, 293, 0, 2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(997, 293, 0, 0, 2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(998, 294, 0, 1700, 0, 0, '', NULL, NULL),
(999, 294, 1, 0, 1700, 0, '', NULL, NULL),
(1000, 295, 1, 1700, 0, 1, '', NULL, NULL),
(1001, 295, 0, 0, 1478.26, 0, '', NULL, NULL),
(1002, 295, 0, 0, 221.74, 0, '', NULL, NULL),
(1003, 295, 0, 2.72, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1004, 295, 0, 0, 2.72, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1005, 296, 0, 1100, 0, 0, '', NULL, NULL),
(1006, 296, 1, 0, 1100, 0, '', NULL, NULL),
(1007, 297, 1, 1100, 0, 1, '', NULL, NULL),
(1008, 297, 0, 0, 956.52, 0, '', NULL, NULL),
(1009, 297, 0, 0, 143.48, 0, '', NULL, NULL),
(1010, 297, 0, 1.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1011, 297, 0, 0, 1.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1012, 298, 0, 1000, 0, 0, '', NULL, NULL),
(1013, 298, 1, 0, 1000, 0, '', NULL, NULL),
(1014, 299, 0, 980, 0, 0, '', NULL, NULL),
(1015, 299, 1, 0, 980, 0, '', NULL, NULL),
(1016, 300, 1, 1980, 0, 1, '', NULL, NULL),
(1017, 300, 0, 0, 1721.74, 0, '', NULL, NULL),
(1018, 300, 0, 0, 258.26, 0, '', NULL, NULL),
(1019, 300, 0, 3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1020, 300, 0, 0, 3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1021, 301, 0, 7600, 0, 0, '', NULL, NULL),
(1022, 301, 1, 0, 7600, 0, '', NULL, NULL),
(1023, 302, 1, 7600, 0, 1, '', NULL, NULL),
(1024, 302, 0, 0, 6608.7, 0, '', NULL, NULL),
(1025, 302, 0, 0, 991.3, 0, '', NULL, NULL),
(1026, 302, 0, 12.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1027, 302, 0, 0, 12.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1028, 303, 0, 1800, 0, 0, '', NULL, NULL),
(1029, 303, 1, 0, 1800, 0, '', NULL, NULL),
(1030, 304, 1, 1800, 0, 1, '', NULL, NULL),
(1031, 304, 0, 0, 1565.22, 0, '', NULL, NULL),
(1032, 304, 0, 0, 234.78, 0, '', NULL, NULL),
(1033, 304, 0, 2.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1034, 304, 0, 0, 2.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1035, 305, 0, 1700, 0, 0, '', NULL, NULL),
(1036, 305, 1, 0, 1700, 0, '', NULL, NULL),
(1037, 306, 1, 1700, 0, 1, '', NULL, NULL),
(1038, 306, 0, 0, 1478.26, 0, '', NULL, NULL),
(1039, 306, 0, 0, 221.74, 0, '', NULL, NULL),
(1040, 306, 0, 2.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1041, 306, 0, 0, 2.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1042, 307, 0, 600, 0, 0, '', NULL, NULL),
(1043, 307, 1, 0, 600, 0, '', NULL, NULL),
(1044, 308, 1, 600, 0, 1, '', NULL, NULL),
(1045, 308, 0, 0, 521.74, 0, '', NULL, NULL),
(1046, 308, 0, 0, 78.26, 0, '', NULL, NULL),
(1047, 308, 0, 0.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1048, 308, 0, 0, 0.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1049, 309, 0, 1070, 0, 0, '', NULL, NULL),
(1050, 309, 1, 0, 1070, 0, '', NULL, NULL),
(1051, 310, 1, 1070, 0, 1, '', NULL, NULL),
(1052, 310, 0, 0, 930.43, 0, '', NULL, NULL),
(1053, 310, 0, 0, 139.57, 0, '', NULL, NULL),
(1054, 310, 0, 1.46, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1055, 310, 0, 0, 1.46, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1056, 311, 0, 300, 0, 0, '', NULL, NULL),
(1057, 311, 1, 0, 300, 0, '', NULL, NULL),
(1058, 312, 1, 300, 0, 1, '', NULL, NULL),
(1059, 312, 0, 0, 260.87, 0, '', NULL, NULL),
(1060, 312, 0, 0, 39.13, 0, '', NULL, NULL),
(1061, 312, 0, 0.34, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1062, 312, 0, 0, 0.34, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1063, 313, 0, 1700, 0, 0, '', NULL, NULL),
(1064, 313, 1, 0, 1700, 0, '', NULL, NULL),
(1065, 314, 1, 1700, 0, 1, '', NULL, NULL),
(1066, 314, 0, 0, 1478.26, 0, '', NULL, NULL),
(1067, 314, 0, 0, 221.74, 0, '', NULL, NULL),
(1068, 314, 0, 2.72, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1069, 314, 0, 0, 2.72, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1070, 315, 0, 2670, 0, 0, '', NULL, NULL),
(1071, 315, 1, 0, 2670, 0, '', NULL, NULL),
(1072, 316, 1, 2670, 0, 1, '', NULL, NULL),
(1073, 316, 0, 0, 2321.74, 0, '', NULL, NULL),
(1074, 316, 0, 0, 348.26, 0, '', NULL, NULL),
(1075, 316, 0, 4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1076, 316, 0, 0, 4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1077, 317, 0, 7300, 0, 0, '', NULL, NULL),
(1078, 317, 1, 0, 7300, 0, '', NULL, NULL),
(1079, 318, 1, 7300, 0, 1, '', NULL, NULL),
(1080, 318, 0, 0, 6347.83, 0, '', NULL, NULL),
(1081, 318, 0, 0, 952.17, 0, '', NULL, NULL),
(1082, 318, 0, 9.94, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1083, 318, 0, 0, 9.94, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1084, 319, 0, 2550, 0, 0, '', NULL, NULL),
(1085, 319, 1, 0, 2550, 0, '', NULL, NULL),
(1086, 320, 1, 2550, 0, 1, '', NULL, NULL),
(1087, 320, 0, 0, 2217.39, 0, '', NULL, NULL),
(1088, 320, 0, 0, 332.61, 0, '', NULL, NULL),
(1089, 320, 0, 3.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1090, 320, 0, 0, 3.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1091, 321, 0, 1500, 0, 0, '', NULL, NULL),
(1092, 321, 1, 0, 1500, 0, '', NULL, NULL),
(1093, 322, 1, 1500, 0, 1, '', NULL, NULL),
(1094, 322, 0, 0, 1304.35, 0, '', NULL, NULL),
(1095, 322, 0, 0, 195.65, 0, '', NULL, NULL),
(1096, 322, 0, 2.44, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1097, 322, 0, 0, 2.44, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1098, 323, 0, 1000, 0, 0, '', NULL, NULL),
(1099, 323, 1, 0, 1000, 0, '', NULL, NULL);
INSERT INTO `journal_details` (`id`, `journal_id`, `account_id`, `debit`, `credit`, `ledger_id`, `notes`, `created_at`, `updated_at`) VALUES
(1100, 324, 1, 1000, 0, 1, '', NULL, NULL),
(1101, 324, 0, 0, 869.57, 0, '', NULL, NULL),
(1102, 324, 0, 0, 130.43, 0, '', NULL, NULL),
(1103, 324, 0, 1.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1104, 324, 0, 0, 1.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1105, 325, 0, 3100, 0, 0, '', NULL, NULL),
(1106, 325, 1, 0, 3100, 0, '', NULL, NULL),
(1107, 326, 1, 3100, 0, 1, '', NULL, NULL),
(1108, 326, 0, 0, 2695.65, 0, '', NULL, NULL),
(1109, 326, 0, 0, 404.35, 0, '', NULL, NULL),
(1110, 326, 0, 4.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1111, 326, 0, 0, 4.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1112, 327, 0, 950, 0, 0, '', NULL, NULL),
(1113, 327, 1, 0, 950, 0, '', NULL, NULL),
(1114, 328, 1, 950, 0, 1, '', NULL, NULL),
(1115, 328, 0, 0, 826.09, 0, '', NULL, NULL),
(1116, 328, 0, 0, 123.91, 0, '', NULL, NULL),
(1117, 328, 0, 1.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1118, 328, 0, 0, 1.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1119, 329, 0, 2600, 0, 0, '', NULL, NULL),
(1120, 329, 1, 0, 2600, 0, '', NULL, NULL),
(1121, 330, 1, 2600, 0, 1, '', NULL, NULL),
(1122, 330, 0, 0, 2260.87, 0, '', NULL, NULL),
(1123, 330, 0, 0, 339.13, 0, '', NULL, NULL),
(1124, 330, 0, 4.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1125, 330, 0, 0, 4.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1126, 331, 0, 900, 0, 0, '', NULL, NULL),
(1127, 331, 1, 0, 900, 0, '', NULL, NULL),
(1128, 332, 1, 900, 0, 1, '', NULL, NULL),
(1129, 332, 0, 0, 782.61, 0, '', NULL, NULL),
(1130, 332, 0, 0, 117.39, 0, '', NULL, NULL),
(1131, 332, 0, 1.47, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1132, 332, 0, 0, 1.47, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1133, 333, 0, 1950, 0, 0, '', NULL, NULL),
(1134, 333, 1, 0, 1950, 0, '', NULL, NULL),
(1135, 334, 1, 1950, 0, 1, '', NULL, NULL),
(1136, 334, 0, 0, 1695.65, 0, '', NULL, NULL),
(1137, 334, 0, 0, 254.35, 0, '', NULL, NULL),
(1138, 334, 0, 3.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1139, 334, 0, 0, 3.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1140, 335, 0, 2550, 0, 0, '', NULL, NULL),
(1141, 335, 1, 0, 2550, 0, '', NULL, NULL),
(1142, 336, 1, 2550, 0, 1, '', NULL, NULL),
(1143, 336, 0, 0, 2217.39, 0, '', NULL, NULL),
(1144, 336, 0, 0, 332.61, 0, '', NULL, NULL),
(1145, 336, 0, 4.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1146, 336, 0, 0, 4.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1147, 337, 0, 800, 0, 0, '', NULL, NULL),
(1148, 337, 1, 0, 800, 0, '', NULL, NULL),
(1149, 338, 1, 800, 0, 1, '', NULL, NULL),
(1150, 338, 0, 0, 695.65, 0, '', NULL, NULL),
(1151, 338, 0, 0, 104.35, 0, '', NULL, NULL),
(1152, 338, 0, 1.03, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1153, 338, 0, 0, 1.03, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1154, 339, 0, 5500, 0, 0, '', NULL, NULL),
(1155, 339, 1, 0, 5500, 0, '', NULL, NULL),
(1156, 340, 1, 5500, 0, 1, '', NULL, NULL),
(1157, 340, 0, 0, 4782.61, 0, '', NULL, NULL),
(1158, 340, 0, 0, 717.39, 0, '', NULL, NULL),
(1159, 340, 0, 8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1160, 340, 0, 0, 8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1161, 341, 0, 2300, 0, 0, '', NULL, NULL),
(1162, 341, 1, 0, 2300, 0, '', NULL, NULL),
(1163, 342, 1, 2300, 0, 1, '', NULL, NULL),
(1164, 342, 0, 0, 2000, 0, '', NULL, NULL),
(1165, 342, 0, 0, 300, 0, '', NULL, NULL),
(1166, 342, 0, 3.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1167, 342, 0, 0, 3.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1168, 343, 0, 1445, 0, 0, '', NULL, NULL),
(1169, 343, 1, 0, 1445, 0, '', NULL, NULL),
(1170, 344, 1, 1445, 0, 1, '', NULL, NULL),
(1171, 344, 0, 0, 1256.52, 0, '', NULL, NULL),
(1172, 344, 0, 0, 188.48, 0, '', NULL, NULL),
(1173, 344, 0, 2.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1174, 344, 0, 0, 2.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1175, 345, 0, 4300, 0, 0, '', NULL, NULL),
(1176, 345, 1, 0, 4300, 0, '', NULL, NULL),
(1177, 346, 1, 4300, 0, 1, '', NULL, NULL),
(1178, 346, 0, 0, 3739.13, 0, '', NULL, NULL),
(1179, 346, 0, 0, 560.87, 0, '', NULL, NULL),
(1180, 346, 0, 6.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1181, 346, 0, 0, 6.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1182, 347, 0, 575, 0, 0, '', NULL, NULL),
(1183, 347, 1, 0, 575, 0, '', NULL, NULL),
(1184, 348, 1, 575, 0, 1, '', NULL, NULL),
(1185, 348, 0, 0, 500, 0, '', NULL, NULL),
(1186, 348, 0, 0, 75, 0, '', NULL, NULL),
(1187, 348, 0, 0.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1188, 348, 0, 0, 0.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1189, 349, 0, 6850, 0, 0, '', NULL, NULL),
(1190, 349, 1, 0, 6850, 0, '', NULL, NULL),
(1191, 350, 1, 6850, 0, 1, '', NULL, NULL),
(1192, 350, 0, 0, 5956.52, 0, '', NULL, NULL),
(1193, 350, 0, 0, 893.48, 0, '', NULL, NULL),
(1194, 350, 0, 11.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1195, 350, 0, 0, 11.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1196, 351, 0, 1800, 0, 0, '', NULL, NULL),
(1197, 351, 1, 0, 1800, 0, '', NULL, NULL),
(1198, 352, 1, 1800, 0, 1, '', NULL, NULL),
(1199, 352, 0, 0, 1565.22, 0, '', NULL, NULL),
(1200, 352, 0, 0, 234.78, 0, '', NULL, NULL),
(1201, 352, 0, 2.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1202, 352, 0, 0, 2.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1203, 353, 0, 6500, 0, 0, '', NULL, NULL),
(1204, 353, 1, 0, 6500, 0, '', NULL, NULL),
(1205, 354, 1, 6500, 0, 1, '', NULL, NULL),
(1206, 354, 0, 0, 5652.18, 0, '', NULL, NULL),
(1207, 354, 0, 0, 847.82, 0, '', NULL, NULL),
(1208, 354, 0, 10.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1209, 354, 0, 0, 10.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1210, 355, 0, 200, 0, 0, '', NULL, NULL),
(1211, 355, 1, 0, 200, 0, '', NULL, NULL),
(1212, 356, 0, 2000, 0, 0, '', NULL, NULL),
(1213, 356, 1, 0, 2000, 0, '', NULL, NULL),
(1214, 357, 1, 2200, 0, 1, '', NULL, NULL),
(1215, 357, 0, 0, 1913.04, 0, '', NULL, NULL),
(1216, 357, 0, 0, 286.96, 0, '', NULL, NULL),
(1217, 357, 0, 3.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1218, 357, 0, 0, 3.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1219, 358, 0, 900, 0, 0, '', NULL, NULL),
(1220, 358, 1, 0, 900, 0, '', NULL, NULL),
(1221, 359, 1, 900, 0, 1, '', NULL, NULL),
(1222, 359, 0, 0, 782.61, 0, '', NULL, NULL),
(1223, 359, 0, 0, 117.39, 0, '', NULL, NULL),
(1224, 359, 0, 1.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1225, 359, 0, 0, 1.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1226, 360, 0, 850, 0, 0, '', NULL, NULL),
(1227, 360, 1, 0, 850, 0, '', NULL, NULL),
(1228, 361, 1, 850, 0, 1, '', NULL, NULL),
(1229, 361, 0, 0, 739.13, 0, '', NULL, NULL),
(1230, 361, 0, 0, 110.87, 0, '', NULL, NULL),
(1231, 361, 0, 1.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1232, 361, 0, 0, 1.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1233, 362, 0, 1980, 0, 0, '', NULL, NULL),
(1234, 362, 1, 0, 1980, 0, '', NULL, NULL),
(1235, 363, 1, 1980, 0, 1, '', NULL, NULL),
(1236, 363, 0, 0, 1721.74, 0, '', NULL, NULL),
(1237, 363, 0, 0, 258.26, 0, '', NULL, NULL),
(1238, 363, 0, 3.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1239, 363, 0, 0, 3.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1240, 364, 0, 28900, 0, 0, '', NULL, NULL),
(1241, 364, 1, 0, 28900, 0, '', NULL, NULL),
(1242, 365, 1, 28900, 0, 1, '', NULL, NULL),
(1243, 365, 0, 0, 25130.44, 0, '', NULL, NULL),
(1244, 365, 0, 0, 3769.56, 0, '', NULL, NULL),
(1245, 365, 0, 50.34, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1246, 365, 0, 0, 50.34, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1247, 366, 0, 1270, 0, 0, '', NULL, NULL),
(1248, 366, 1, 0, 1270, 0, '', NULL, NULL),
(1249, 367, 1, 1270, 0, 1, '', NULL, NULL),
(1250, 367, 0, 0, 1104.35, 0, '', NULL, NULL),
(1251, 367, 0, 0, 165.65, 0, '', NULL, NULL),
(1252, 367, 0, 2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1253, 367, 0, 0, 2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1254, 368, 0, 860, 0, 0, '', NULL, NULL),
(1255, 368, 1, 0, 860, 0, '', NULL, NULL),
(1256, 369, 1, 860, 0, 1, '', NULL, NULL),
(1257, 369, 0, 0, 747.83, 0, '', NULL, NULL),
(1258, 369, 0, 0, 112.17, 0, '', NULL, NULL),
(1259, 369, 0, 1.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1260, 369, 0, 0, 1.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1261, 370, 0, 1700, 0, 0, '', NULL, NULL),
(1262, 370, 1, 0, 1700, 0, '', NULL, NULL),
(1263, 371, 1, 1700, 0, 1, '', NULL, NULL),
(1264, 371, 0, 0, 1478.26, 0, '', NULL, NULL),
(1265, 371, 0, 0, 221.74, 0, '', NULL, NULL),
(1266, 371, 0, 2.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1267, 371, 0, 0, 2.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1268, 372, 0, 2100, 0, 0, '', NULL, NULL),
(1269, 372, 1, 0, 2100, 0, '', NULL, NULL),
(1270, 373, 1, 2100, 0, 1, '', NULL, NULL),
(1271, 373, 0, 0, 1826.09, 0, '', NULL, NULL),
(1272, 373, 0, 0, 273.91, 0, '', NULL, NULL),
(1273, 373, 0, 3.56, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1274, 373, 0, 0, 3.56, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1275, 374, 0, 1375, 0, 0, '', NULL, NULL),
(1276, 374, 1, 0, 1375, 0, '', NULL, NULL),
(1277, 375, 1, 1375, 0, 1, '', NULL, NULL),
(1278, 375, 0, 0, 1195.65, 0, '', NULL, NULL),
(1279, 375, 0, 0, 179.35, 0, '', NULL, NULL),
(1280, 375, 0, 2.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1281, 375, 0, 0, 2.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1282, 376, 0, 1395, 0, 0, '', NULL, NULL),
(1283, 376, 1, 0, 1395, 0, '', NULL, NULL),
(1284, 377, 1, 1395, 0, 1, '', NULL, NULL),
(1285, 377, 0, 0, 1213.04, 0, '', NULL, NULL),
(1286, 377, 0, 0, 181.96, 0, '', NULL, NULL),
(1287, 377, 0, 2.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1288, 377, 0, 0, 2.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1289, 378, 0, 9100, 0, 0, '', NULL, NULL),
(1290, 378, 1, 0, 9100, 0, '', NULL, NULL),
(1291, 379, 1, 9100, 0, 1, '', NULL, NULL),
(1292, 379, 0, 0, 7913.04, 0, '', NULL, NULL),
(1293, 379, 0, 0, 1186.96, 0, '', NULL, NULL),
(1294, 379, 0, 17.07, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1295, 379, 0, 0, 17.07, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1296, 380, 0, 1000, 0, 0, '', NULL, NULL),
(1297, 380, 1, 0, 1000, 0, '', NULL, NULL),
(1298, 381, 0, 520, 0, 0, '', NULL, NULL),
(1299, 381, 1, 0, 520, 0, '', NULL, NULL),
(1300, 382, 1, 1520, 0, 1, '', NULL, NULL),
(1301, 382, 0, 0, 1321.74, 0, '', NULL, NULL),
(1302, 382, 0, 0, 198.26, 0, '', NULL, NULL),
(1303, 382, 0, 2.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1304, 382, 0, 0, 2.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1305, 383, 0, 3005, 0, 0, '', NULL, NULL),
(1306, 383, 1, 0, 3005, 0, '', NULL, NULL),
(1307, 384, 1, 3005, 0, 1, '', NULL, NULL),
(1308, 384, 0, 0, 2613.04, 0, '', NULL, NULL),
(1309, 384, 0, 0, 391.96, 0, '', NULL, NULL),
(1310, 384, 0, 5.34, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1311, 384, 0, 0, 5.34, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1312, 385, 0, 900, 0, 0, '', NULL, NULL),
(1313, 385, 1, 0, 900, 0, '', NULL, NULL),
(1314, 386, 1, 900, 0, 1, '', NULL, NULL),
(1315, 386, 0, 0, 782.61, 0, '', NULL, NULL),
(1316, 386, 0, 0, 117.39, 0, '', NULL, NULL),
(1317, 386, 0, 1.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1318, 386, 0, 0, 1.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1319, 387, 0, 1650, 0, 0, '', NULL, NULL),
(1320, 387, 1, 0, 1650, 0, '', NULL, NULL),
(1321, 388, 1, 1650, 0, 1, '', NULL, NULL),
(1322, 388, 0, 0, 1434.78, 0, '', NULL, NULL),
(1323, 388, 0, 0, 215.22, 0, '', NULL, NULL),
(1324, 388, 0, 2.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1325, 388, 0, 0, 2.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1326, 389, 0, 10340, 0, 0, '', NULL, NULL),
(1327, 389, 1, 0, 10340, 0, '', NULL, NULL),
(1328, 390, 0, 1860, 0, 0, '', NULL, NULL),
(1329, 390, 1, 0, 1860, 0, '', NULL, NULL),
(1330, 391, 1, 12200, 0, 1, '', NULL, NULL),
(1331, 391, 0, 0, 10608.7, 0, '', NULL, NULL),
(1332, 391, 0, 0, 1591.3, 0, '', NULL, NULL),
(1333, 391, 0, 22.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1334, 391, 0, 0, 22.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1335, 392, 0, 860, 0, 0, '', NULL, NULL),
(1336, 392, 1, 0, 860, 0, '', NULL, NULL),
(1337, 393, 1, 860, 0, 1, '', NULL, NULL),
(1338, 393, 0, 0, 747.83, 0, '', NULL, NULL),
(1339, 393, 0, 0, 112.17, 0, '', NULL, NULL),
(1340, 393, 0, 1.41, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1341, 393, 0, 0, 1.41, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1342, 394, 0, 2760, 0, 0, '', NULL, NULL),
(1343, 394, 1, 0, 2760, 0, '', NULL, NULL),
(1344, 395, 0, 22610, 0, 0, '', NULL, NULL),
(1345, 395, 1, 0, 22610, 0, '', NULL, NULL),
(1346, 396, 1, 25370, 0, 1, '', NULL, NULL),
(1347, 396, 0, 0, 22060.87, 0, '', NULL, NULL),
(1348, 396, 0, 0, 3309.13, 0, '', NULL, NULL),
(1349, 396, 0, 43.29, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1350, 396, 0, 0, 43.29, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1351, 397, 0, 1400, 0, 0, '', NULL, NULL),
(1352, 397, 1, 0, 1400, 0, '', NULL, NULL),
(1353, 398, 1, 1400, 0, 1, '', NULL, NULL),
(1354, 398, 0, 0, 1217.39, 0, '', NULL, NULL),
(1355, 398, 0, 0, 182.61, 0, '', NULL, NULL),
(1356, 398, 0, 2.6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1357, 398, 0, 0, 2.6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1358, 399, 0, 620, 0, 0, '', NULL, NULL),
(1359, 399, 1, 0, 620, 0, '', NULL, NULL),
(1360, 400, 1, 620, 0, 1, '', NULL, NULL),
(1361, 400, 0, 0, 539.13, 0, '', NULL, NULL),
(1362, 400, 0, 0, 80.87, 0, '', NULL, NULL),
(1363, 400, 0, 1.08, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1364, 400, 0, 0, 1.08, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1365, 401, 0, 1075, 0, 0, '', NULL, NULL),
(1366, 401, 1, 0, 1075, 0, '', NULL, NULL),
(1367, 402, 1, 1075, 0, 1, '', NULL, NULL),
(1368, 402, 0, 0, 934.78, 0, '', NULL, NULL),
(1369, 402, 0, 0, 140.22, 0, '', NULL, NULL),
(1370, 402, 0, 1.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1371, 402, 0, 0, 1.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1372, 403, 0, 600, 0, 0, '', NULL, NULL),
(1373, 403, 1, 0, 600, 0, '', NULL, NULL),
(1374, 404, 0, 50, 0, 0, '', NULL, NULL),
(1375, 404, 1, 0, 50, 0, '', NULL, NULL),
(1376, 405, 1, 650, 0, 1, '', NULL, NULL),
(1377, 405, 0, 0, 565.22, 0, '', NULL, NULL),
(1378, 405, 0, 0, 84.78, 0, '', NULL, NULL),
(1379, 405, 0, 1.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1380, 405, 0, 0, 1.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1381, 406, 0, 1600, 0, 0, '', NULL, NULL),
(1382, 406, 1, 0, 1600, 0, '', NULL, NULL),
(1383, 407, 1, 1600, 0, 1, '', NULL, NULL),
(1384, 407, 0, 0, 1391.3, 0, '', NULL, NULL),
(1385, 407, 0, 0, 208.7, 0, '', NULL, NULL),
(1386, 407, 0, 3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1387, 407, 0, 0, 3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1388, 408, 0, 2150, 0, 0, '', NULL, NULL),
(1389, 408, 1, 0, 2150, 0, '', NULL, NULL),
(1390, 409, 1, 2150, 0, 1, '', NULL, NULL),
(1391, 409, 0, 0, 1869.57, 0, '', NULL, NULL),
(1392, 409, 0, 0, 280.43, 0, '', NULL, NULL),
(1393, 409, 0, 3.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1394, 409, 0, 0, 3.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1395, 410, 0, 8100, 0, 0, '', NULL, NULL),
(1396, 410, 1, 0, 8100, 0, '', NULL, NULL),
(1397, 411, 1, 8100, 0, 1, '', NULL, NULL),
(1398, 411, 0, 0, 7043.48, 0, '', NULL, NULL),
(1399, 411, 0, 0, 1056.52, 0, '', NULL, NULL),
(1400, 411, 0, 14.48, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1401, 411, 0, 0, 14.48, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1402, 412, 0, 1050, 0, 0, '', NULL, NULL),
(1403, 412, 1, 0, 1050, 0, '', NULL, NULL),
(1404, 413, 1, 1050, 0, 1, '', NULL, NULL),
(1405, 413, 0, 0, 913.05, 0, '', NULL, NULL),
(1406, 413, 0, 0, 136.95, 0, '', NULL, NULL),
(1407, 413, 0, 1.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1408, 413, 0, 0, 1.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1409, 414, 0, 1600, 0, 0, '', NULL, NULL),
(1410, 414, 1, 0, 1600, 0, '', NULL, NULL),
(1411, 415, 1, 1600, 0, 1, '', NULL, NULL),
(1412, 415, 0, 0, 1391.3, 0, '', NULL, NULL),
(1413, 415, 0, 0, 208.7, 0, '', NULL, NULL),
(1414, 415, 0, 2.8, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1415, 415, 0, 0, 2.8, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1416, 416, 0, 650, 0, 0, '', NULL, NULL),
(1417, 416, 1, 0, 650, 0, '', NULL, NULL),
(1418, 417, 0, 2300, 0, 0, '', NULL, NULL),
(1419, 417, 1, 0, 2300, 0, '', NULL, NULL),
(1420, 418, 1, 2950, 0, 1, '', NULL, NULL),
(1421, 418, 0, 0, 2565.22, 0, '', NULL, NULL),
(1422, 418, 0, 0, 384.78, 0, '', NULL, NULL),
(1423, 418, 0, 5.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1424, 418, 0, 0, 5.2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1425, 419, 0, 1150, 0, 0, '', NULL, NULL),
(1426, 419, 1, 0, 1150, 0, '', NULL, NULL),
(1427, 420, 1, 1150, 0, 1, '', NULL, NULL),
(1428, 420, 0, 0, 1000, 0, '', NULL, NULL),
(1429, 420, 0, 0, 150, 0, '', NULL, NULL),
(1430, 420, 0, 1.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1431, 420, 0, 0, 1.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1432, 421, 0, 6500, 0, 0, '', NULL, NULL),
(1433, 421, 1, 0, 6500, 0, '', NULL, NULL),
(1434, 422, 1, 6500, 0, 1, '', NULL, NULL),
(1435, 422, 0, 0, 5652.17, 0, '', NULL, NULL),
(1436, 422, 0, 0, 847.83, 0, '', NULL, NULL),
(1437, 422, 0, 11.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1438, 422, 0, 0, 11.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1439, 423, 0, 2240, 0, 0, '', NULL, NULL),
(1440, 423, 1, 0, 2240, 0, '', NULL, NULL),
(1441, 424, 1, 2240, 0, 1, '', NULL, NULL),
(1442, 424, 0, 0, 1947.83, 0, '', NULL, NULL),
(1443, 424, 0, 0, 292.17, 0, '', NULL, NULL),
(1444, 424, 0, 4.08, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1445, 424, 0, 0, 4.08, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1446, 425, 0, 8900, 0, 0, '', NULL, NULL),
(1447, 425, 1, 0, 8900, 0, '', NULL, NULL),
(1448, 426, 1, 8900, 0, 1, '', NULL, NULL),
(1449, 426, 0, 0, 7739.13, 0, '', NULL, NULL),
(1450, 426, 0, 0, 1160.87, 0, '', NULL, NULL),
(1451, 426, 0, 16, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1452, 426, 0, 0, 16, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1453, 427, 0, 3600, 0, 0, '', NULL, NULL),
(1454, 427, 1, 0, 3600, 0, '', NULL, NULL),
(1455, 428, 1, 3600, 0, 1, '', NULL, NULL),
(1456, 428, 0, 0, 3130.43, 0, '', NULL, NULL),
(1457, 428, 0, 0, 469.57, 0, '', NULL, NULL),
(1458, 428, 0, 6, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1459, 428, 0, 0, 6, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1460, 429, 0, 550, 0, 0, '', NULL, NULL),
(1461, 429, 1, 0, 550, 0, '', NULL, NULL),
(1462, 430, 1, 550, 0, 1, '', NULL, NULL),
(1463, 430, 0, 0, 478.26, 0, '', NULL, NULL),
(1464, 430, 0, 0, 71.74, 0, '', NULL, NULL),
(1465, 430, 0, 1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1466, 430, 0, 0, 1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1467, 431, 0, 1200, 0, 0, '', NULL, NULL),
(1468, 431, 1, 0, 1200, 0, '', NULL, NULL),
(1469, 432, 1, 1200, 0, 1, '', NULL, NULL),
(1470, 432, 0, 0, 1043.48, 0, '', NULL, NULL),
(1471, 432, 0, 0, 156.52, 0, '', NULL, NULL),
(1472, 432, 0, 2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1473, 432, 0, 0, 2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1474, 433, 0, 880, 0, 0, '', NULL, NULL),
(1475, 433, 1, 0, 880, 0, '', NULL, NULL),
(1476, 434, 1, 880, 0, 1, '', NULL, NULL),
(1477, 434, 0, 0, 765.22, 0, '', NULL, NULL),
(1478, 434, 0, 0, 114.78, 0, '', NULL, NULL),
(1479, 434, 0, 1.5, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1480, 434, 0, 0, 1.5, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1481, 435, 0, 6300, 0, 0, '', NULL, NULL),
(1482, 435, 1, 0, 6300, 0, '', NULL, NULL),
(1483, 436, 1, 6300, 0, 1, '', NULL, NULL),
(1484, 436, 0, 0, 5478.26, 0, '', NULL, NULL),
(1485, 436, 0, 0, 821.74, 0, '', NULL, NULL),
(1486, 436, 0, 11.3, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1487, 436, 0, 0, 11.3, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1488, 437, 0, 1500, 0, 0, '', NULL, NULL),
(1489, 437, 1, 0, 1500, 0, '', NULL, NULL),
(1490, 438, 1, 1500, 0, 1, '', NULL, NULL),
(1491, 438, 0, 0, 1304.35, 0, '', NULL, NULL),
(1492, 438, 0, 0, 195.65, 0, '', NULL, NULL),
(1493, 438, 0, 2.7, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1494, 438, 0, 0, 2.7, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1495, 439, 0, 1600, 0, 0, '', NULL, NULL),
(1496, 439, 1, 0, 1600, 0, '', NULL, NULL),
(1497, 440, 1, 1600, 0, 1, '', NULL, NULL),
(1498, 440, 0, 0, 1391.3, 0, '', NULL, NULL),
(1499, 440, 0, 0, 208.7, 0, '', NULL, NULL),
(1500, 440, 0, 2.83, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1501, 440, 0, 0, 2.83, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1502, 441, 0, 1700, 0, 0, '', NULL, NULL),
(1503, 441, 1, 0, 1700, 0, '', NULL, NULL),
(1504, 442, 1, 1700, 0, 1, '', NULL, NULL),
(1505, 442, 0, 0, 1478.26, 0, '', NULL, NULL),
(1506, 442, 0, 0, 221.74, 0, '', NULL, NULL),
(1507, 442, 0, 3.1, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1508, 442, 0, 0, 3.1, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1509, 443, 0, 800, 0, 0, '', NULL, NULL),
(1510, 443, 1, 0, 800, 0, '', NULL, NULL),
(1511, 444, 1, 800, 0, 1, '', NULL, NULL),
(1512, 444, 0, 0, 695.65, 0, '', NULL, NULL),
(1513, 444, 0, 0, 104.35, 0, '', NULL, NULL),
(1514, 444, 0, 1.4, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1515, 444, 0, 0, 1.4, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1516, 445, 0, 1100, 0, 0, '', NULL, NULL),
(1517, 445, 1, 0, 1100, 0, '', NULL, NULL),
(1518, 446, 1, 1100, 0, 1, '', NULL, NULL),
(1519, 446, 0, 0, 956.52, 0, '', NULL, NULL),
(1520, 446, 0, 0, 143.48, 0, '', NULL, NULL),
(1521, 446, 0, 2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1522, 446, 0, 0, 2, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1523, 447, 0, 1750, 0, 0, '', NULL, NULL),
(1524, 447, 1, 0, 1750, 0, '', NULL, NULL),
(1525, 448, 1, 1750, 0, 1, '', NULL, NULL),
(1526, 448, 0, 0, 1521.74, 0, '', NULL, NULL),
(1527, 448, 0, 0, 228.26, 0, '', NULL, NULL),
(1528, 448, 0, 2.9, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1529, 448, 0, 0, 2.9, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1530, 449, 0, 3705, 0, 0, '', NULL, NULL),
(1531, 449, 1, 0, 3705, 0, '', NULL, NULL),
(1532, 450, 1, 3705, 0, 1, '', NULL, NULL),
(1533, 450, 0, 0, 3221.74, 0, '', NULL, NULL),
(1534, 450, 0, 0, 483.26, 0, '', NULL, NULL),
(1535, 450, 0, 6.2, 0, 0, 'جرام ذهب عيار 21', NULL, NULL),
(1536, 450, 0, 0, 6.2, 0, 'جرام ذهب عيار 21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `karats`
--

CREATE TABLE `karats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `stamp_value` decimal(8,2) DEFAULT 0.00,
  `transform_factor` decimal(8,4) NOT NULL DEFAULT 0.0000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karats`
--

INSERT INTO `karats` (`id`, `name_ar`, `name_en`, `label`, `stamp_value`, `transform_factor`, `created_at`, `updated_at`) VALUES
(1, 'عيار 18', 'Karat 18', 'K18', 15.00, 0.8571, '2026-02-01 16:29:39', '2026-02-01 16:29:39'),
(2, 'عيار 21', 'Karat 21', 'K21', 15.00, 1.0000, '2026-02-01 16:29:39', '2026-02-01 16:29:39'),
(3, 'عيار 22', 'Karat 22', 'K22', 15.00, 1.0470, '2026-02-01 16:29:39', '2026-02-01 16:29:39'),
(4, 'عيار 24', 'Karat 24', 'K24', 0.00, 1.1428, '2026-02-01 16:29:39', '2026-02-01 16:29:39');

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
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_12_07_221527_create_customer_groups_table', 1),
(7, '2022_12_08_113446_create_expenses_categories_table', 1),
(8, '2022_12_08_113458_create_units_table', 1),
(9, '2022_12_08_113510_create_brands_table', 1),
(10, '2022_12_08_113524_create_tax_rates_table', 1),
(11, '2022_12_08_113536_create_warehouses_table', 1),
(12, '2022_12_08_114158_create_currencies_table', 1),
(13, '2022_12_19_083204_create_products_table', 1),
(14, '2022_12_19_083446_create_product_units_table', 1),
(15, '2022_12_19_083504_create_warehouse_products_table', 1),
(16, '2022_12_21_122231_create_system_settings_table', 1),
(17, '2022_12_22_115216_create_pos_settings_table', 1),
(18, '2022_12_22_121716_create_cashiers_table', 1),
(19, '2022_12_24_111823_create_user_groups_table', 1),
(20, '2022_12_26_084759_create_update_quntities_table', 1),
(21, '2022_12_26_084812_create_update_quntity_details_table', 1),
(22, '2022_12_28_211853_create_sales_table', 1),
(23, '2022_12_28_211945_create_sale_details_table', 1),
(24, '2023_01_10_190049_create_purchases_table', 1),
(25, '2023_01_10_193205_create_purchase_details_table', 1),
(26, '2023_01_16_102439_create_payments_table', 1),
(27, '2023_01_18_122024_create_vendor_movements_table', 1),
(28, '2023_01_30_091413_create_accounts_trees_table', 1),
(29, '2023_01_30_131709_create_journals_table', 1),
(30, '2023_01_30_131807_create_journal_details_table', 1),
(31, '2023_01_30_132603_create_account_movements_table', 1),
(32, '2023_02_02_203322_create_expenses_table', 1),
(33, '2023_02_03_190025_add_enable_inventory_to_settings_table', 1),
(34, '2023_02_03_190025_add_end_date_to_settings_table', 1),
(35, '2023_04_05_212857_create_employer_categories_table', 1),
(36, '2023_04_05_213023_create_employers_table', 1),
(37, '2023_04_05_220811_create_deductions_table', 1),
(38, '2023_04_05_220823_create_rewards_table', 1),
(39, '2023_04_05_220912_create_advance_payments_table', 1),
(40, '2023_04_05_225558_create_advance_payment_months_table', 1),
(41, '2023_04_06_115135_create_salary_docs_table', 1),
(42, '2023_04_06_115301_create_salary_doc_details_table', 1),
(43, '2023_04_12_141201_create_representatives_table', 1),
(44, '2023_04_18_110352_create_visits_table', 1),
(45, '2024_04_15_134839_create_permission_tables', 1),
(46, '2024_05_01_194738_create_branches_table', 1),
(47, '2024_05_01_194926_create_accounting_closing_table', 1),
(48, '2024_05_01_195650_create_account_settings_table', 1),
(49, '2024_05_01_200534_create_catch_recipts', 1),
(50, '2024_05_01_200902_create_categories_table', 1),
(51, '2024_05_01_201926_create_companies_table', 1),
(52, '2024_05_01_202209_create_company_infos_table', 1),
(53, '2024_05_01_203141_create_inventorys_table', 1),
(54, '2024_05_01_203402_create_inventory_details_table', 1),
(55, '2024_05_01_205942_create_tax_excise_table', 1),
(56, '2024_05_01_210955_create_warehouse_movements_table', 1),
(57, '2026_02_01_000000_create_pricings_table', 1),
(58, '2026_02_01_010000_create_missing_tables_from_sql', 1),
(59, '2026_02_01_020000_add_gold_columns_to_companies_table', 1),
(60, '2026_02_01_030000_add_movement_columns_to_warehouses_table', 1),
(61, '2026_02_01_040000_fix_auto_increment_for_core_tables', 1),
(62, '2026_02_01_050000_make_warehouses_optional_fields_nullable', 1),
(63, '2026_02_01_060000_add_supplier_default_account_to_account_settings', 1),
(64, '2026_02_01_070000_add_missing_columns_to_account_settings', 1),
(65, '2026_02_01_080000_fix_auto_increment_for_enter_money', 1),
(66, '2026_02_01_090000_add_notes_to_account_movements', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 1),
(10, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 1),
(13, 'App\\Models\\User', 1),
(14, 'App\\Models\\User', 1),
(15, 'App\\Models\\User', 1),
(16, 'App\\Models\\User', 1),
(17, 'App\\Models\\User', 1),
(18, 'App\\Models\\User', 1),
(19, 'App\\Models\\User', 1),
(20, 'App\\Models\\User', 1),
(21, 'App\\Models\\User', 1),
(22, 'App\\Models\\User', 1),
(23, 'App\\Models\\User', 1),
(24, 'App\\Models\\User', 1),
(25, 'App\\Models\\User', 1),
(26, 'App\\Models\\User', 1),
(27, 'App\\Models\\User', 1),
(28, 'App\\Models\\User', 1),
(29, 'App\\Models\\User', 1),
(30, 'App\\Models\\User', 1),
(31, 'App\\Models\\User', 1),
(32, 'App\\Models\\User', 1),
(33, 'App\\Models\\User', 1),
(34, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 1),
(37, 'App\\Models\\User', 1),
(38, 'App\\Models\\User', 1),
(39, 'App\\Models\\User', 1),
(40, 'App\\Models\\User', 1),
(41, 'App\\Models\\User', 1),
(42, 'App\\Models\\User', 1),
(43, 'App\\Models\\User', 1),
(44, 'App\\Models\\User', 1),
(45, 'App\\Models\\User', 1),
(46, 'App\\Models\\User', 1),
(47, 'App\\Models\\User', 1),
(48, 'App\\Models\\User', 1),
(49, 'App\\Models\\User', 1),
(50, 'App\\Models\\User', 1),
(51, 'App\\Models\\User', 1),
(52, 'App\\Models\\User', 1),
(53, 'App\\Models\\User', 1),
(54, 'App\\Models\\User', 1),
(55, 'App\\Models\\User', 1),
(56, 'App\\Models\\User', 1),
(57, 'App\\Models\\User', 1),
(58, 'App\\Models\\User', 1),
(59, 'App\\Models\\User', 1),
(60, 'App\\Models\\User', 1),
(61, 'App\\Models\\User', 1),
(62, 'App\\Models\\User', 1),
(63, 'App\\Models\\User', 1),
(64, 'App\\Models\\User', 1),
(65, 'App\\Models\\User', 1),
(66, 'App\\Models\\User', 1),
(67, 'App\\Models\\User', 1),
(68, 'App\\Models\\User', 1),
(69, 'App\\Models\\User', 1),
(70, 'App\\Models\\User', 1),
(71, 'App\\Models\\User', 1),
(72, 'App\\Models\\User', 1),
(73, 'App\\Models\\User', 1),
(74, 'App\\Models\\User', 1),
(75, 'App\\Models\\User', 1),
(76, 'App\\Models\\User', 1),
(77, 'App\\Models\\User', 1),
(78, 'App\\Models\\User', 1),
(79, 'App\\Models\\User', 1),
(80, 'App\\Models\\User', 1),
(81, 'App\\Models\\User', 1),
(82, 'App\\Models\\User', 1),
(83, 'App\\Models\\User', 1),
(84, 'App\\Models\\User', 1),
(85, 'App\\Models\\User', 1),
(86, 'App\\Models\\User', 1),
(87, 'App\\Models\\User', 1),
(88, 'App\\Models\\User', 1),
(89, 'App\\Models\\User', 1),
(90, 'App\\Models\\User', 1),
(91, 'App\\Models\\User', 1),
(92, 'App\\Models\\User', 1),
(93, 'App\\Models\\User', 1),
(94, 'App\\Models\\User', 1),
(95, 'App\\Models\\User', 1),
(96, 'App\\Models\\User', 1),
(97, 'App\\Models\\User', 1),
(98, 'App\\Models\\User', 1),
(99, 'App\\Models\\User', 1),
(100, 'App\\Models\\User', 1),
(101, 'App\\Models\\User', 1),
(102, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_wahtsapp`
--

CREATE TABLE `notification_wahtsapp` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(50) NOT NULL,
  `client_phone` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `doc_number` varchar(255) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `company_id` int(11) NOT NULL DEFAULT 0,
  `amount` double NOT NULL DEFAULT 0,
  `paid_by` varchar(255) NOT NULL DEFAULT 'CC',
  `remain` double NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `based_on_bill_number` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'اضافة مستخدم', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(2, 'عرض مستخدم', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(3, 'تعديل مستخدم', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(4, 'حذف مستخدم', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(5, 'اضافة صلاحية', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(6, 'عرض صلاحية', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(7, 'تعديل صلاحية', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(8, 'حذف صلاحية', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(9, 'اضافة فرع', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(10, 'عرض فرع', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(11, 'تعديل فرع', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(12, 'حذف فرع', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(13, 'اضافة صنف', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(14, 'عرض صنف', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(15, 'تعديل صنف', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(16, 'حذف صنف', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(17, 'اضافة امر توريد', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(18, 'عرض اوامر التوريد', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(19, 'اضافة فاتورة ضريبية', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(20, 'عرض فاتورة ضريبية', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(21, 'اضافة فاتورة مشتريات', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(22, 'عرض فاتورة مشتريات', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(23, 'اضافة مرتجع فاتورة مبيعات', 'admin-web', '2022-11-28 22:42:27', '2022-11-28 22:42:27'),
(24, 'عرض مرتجع فاتورة مبيعات', 'admin-web', '2022-11-28 22:42:27', '2022-11-28 22:42:27'),
(25, 'اضافة سند صرف', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(26, 'عرض سند صرف', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(27, 'تعديل سند صرف', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(28, 'حذف سند صرف', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(29, 'اضافة سند قبض', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(30, 'عرض سند قبض', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(31, 'تعديل سند قبض', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(32, 'حذف سند قبض', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(33, 'التقارير المخزون', 'admin-web', '2023-08-17 20:29:42', '2023-08-17 20:29:42'),
(34, 'اضافة مخزن', 'admin-web', '2023-08-18 07:09:22', '2023-08-18 07:09:22'),
(35, 'عرض مخزن', 'admin-web', '2023-08-18 07:09:41', '2023-08-18 07:09:41'),
(36, 'تعديل مخزن', 'admin-web', '2023-08-18 07:10:02', '2023-08-18 07:10:02'),
(37, 'حذف مخزن', 'admin-web', '2023-08-18 07:10:12', '2023-08-18 07:10:12'),
(38, 'اضافة عميل', 'admin-web', '2023-08-18 13:08:27', '2023-08-18 13:08:27'),
(39, 'عرض عميل', 'admin-web', '2023-08-18 13:08:36', '2023-08-18 13:08:36'),
(40, 'تعديل عميل', 'admin-web', '2023-08-18 13:08:46', '2023-08-18 13:08:46'),
(41, 'حذف عميل', 'admin-web', '2023-08-18 13:08:53', '2023-08-18 13:08:53'),
(42, 'اضافة مورد', 'admin-web', '2023-08-18 13:09:23', '2023-08-18 13:09:23'),
(43, 'عرض مورد', 'admin-web', '2023-08-18 13:09:31', '2023-08-18 13:09:31'),
(44, 'تعديل مورد', 'admin-web', '2023-08-18 13:09:41', '2023-08-18 13:09:41'),
(45, 'حذف مورد', 'admin-web', '2023-08-18 13:09:49', '2023-08-18 13:09:49'),
(46, 'اضافة حسابات', 'admin-web', '2023-08-18 13:09:23', '2023-08-18 13:09:23'),
(47, 'عرض حسابات', 'admin-web', '2023-08-18 13:09:31', '2023-08-18 13:09:31'),
(48, 'تعديل حسابات', 'admin-web', '2023-08-18 13:09:41', '2023-08-18 13:09:41'),
(49, 'حذف الحسابات', 'admin-web', '2023-08-18 13:09:49', '2023-08-18 13:09:49'),
(50, 'اضافة الاعدادات', 'admin-web', '2023-08-18 13:09:23', '2023-08-18 13:09:23'),
(51, 'عرض الاعدادات', 'admin-web', '2023-08-18 13:09:31', '2023-08-18 13:09:31'),
(52, 'تعديل الاعدادات', 'admin-web', '2023-08-18 13:09:41', '2023-08-18 13:09:41'),
(53, 'حذف الاعدات', 'admin-web', '2023-08-18 13:09:49', '2023-08-18 13:09:49'),
(54, 'اضافة اسعار الذهب', 'admin-web', '2023-08-18 13:09:23', '2023-08-18 13:09:23'),
(55, 'عرض اسعار الذهب', 'admin-web', '2023-08-18 13:09:31', '2023-08-18 13:09:31'),
(56, 'تعديل اسعار الذهب', 'admin-web', '2023-08-18 13:09:41', '2023-08-18 13:09:41'),
(57, 'حذف اسعار الذهب', 'admin-web', '2023-08-18 13:09:49', '2023-08-18 13:09:49'),
(58, 'عرض المخزون', 'admin-web', '2023-08-18 06:32:49', '2023-08-18 06:32:49'),
(59, 'دفتر الشغل', 'admin-web', '2023-08-18 09:13:22', '2023-08-18 09:13:22'),
(60, 'دفتر الكسر', 'admin-web', '2023-08-18 09:21:39', '2023-08-18 09:21:39'),
(61, 'اضافة مشغول الى كسر', 'admin-web', '2023-08-18 09:39:34', '2023-08-18 09:39:34'),
(62, 'عرض مشغول الى كسر', 'admin-web', '2023-08-18 09:39:41', '2023-08-18 09:39:41'),
(63, 'تعديل مشغول الى كسر', 'admin-web', '2023-08-18 09:39:48', '2023-08-18 09:39:48'),
(64, 'حذف مشغول الى كسر', 'admin-web', '2023-08-18 09:39:56', '2023-08-18 09:39:56'),
(65, 'اضافة دفتر دخول النقدية', 'admin-web', '2023-08-19 06:15:36', '2023-08-19 06:15:36'),
(66, 'عرض دفتر دخول النقدية', 'admin-web', '2023-08-19 06:15:46', '2023-08-19 06:15:46'),
(67, 'تعديل دفتر دخول النقدية', 'admin-web', '2023-08-19 06:15:54', '2023-08-19 06:15:54'),
(68, 'حذف دفتر دخول النقدية', 'admin-web', '2023-08-19 06:16:02', '2023-08-19 06:16:02'),
(69, 'اضافة دفتر خروج النقدية', 'admin-web', '2023-08-19 06:18:30', '2023-08-19 06:18:30'),
(70, 'عرض دفتر خروج النقدية', 'admin-web', '2023-08-19 06:18:40', '2023-08-19 06:18:40'),
(71, 'تعديل دفتر خروج النقدية', 'admin-web', '2023-08-19 06:18:47', '2023-08-19 06:18:47'),
(72, 'حذف دفتر خروج النقدية', 'admin-web', '2023-08-19 06:18:54', '2023-08-19 06:18:54'),
(73, 'حذف فاتورة ضريبية', 'admin-web', '2023-08-22 12:02:29', '2023-08-22 12:02:29'),
(74, 'حذف فاتورة مشتريات', 'admin-web', '2023-08-22 12:03:10', '2023-08-22 12:03:10'),
(75, 'اضافة جرد', 'admin-web', '2023-09-05 16:22:36', '2023-09-05 16:22:36'),
(76, 'عرض جرد', 'admin-web', '2023-09-05 16:22:54', '2023-09-05 16:22:54'),
(77, 'تعديل جرد', 'admin-web', '2023-09-05 16:23:04', '2023-09-05 16:23:04'),
(78, 'حذف جرد', 'admin-web', '2023-09-05 16:23:14', '2023-09-05 16:23:14'),
(79, 'اضافة فاتورة ضريبية مبسطة', 'admin-web', '2023-09-17 08:41:44', '2023-09-17 08:41:44'),
(80, 'عرض فاتورة ضريبية مبسطة', 'admin-web', '2023-09-17 08:41:59', '2023-09-17 08:41:59'),
(81, 'حذف فاتورة ضريبية مبسطة', 'admin-web', '2023-09-17 08:42:15', '2023-09-17 08:42:15'),
(82, 'التقارير المحاسبية', 'admin-web', '2023-09-19 10:36:19', '2023-09-19 10:36:19'),
(83, 'اضافة قيد محاسبي', 'admin-web', '2024-06-16 17:23:35', '2024-06-16 17:23:35'),
(84, 'عرض قيد محاسبي', 'admin-web', '2024-06-16 17:23:53', '2024-06-16 17:23:53'),
(85, 'تعديل قيد محاسبي', 'admin-web', '2024-06-16 17:24:07', '2024-06-16 17:24:07'),
(86, 'حذف قيد محاسبي', 'admin-web', '2024-06-16 17:24:21', '2024-06-16 17:24:21'),
(87, 'اضافة معلومات الشركة', 'admin-web', '2024-06-16 17:24:45', '2024-06-16 17:24:45'),
(88, 'عرض معلومات الشركة', 'admin-web', '2024-06-16 17:24:53', '2024-06-16 17:24:53'),
(89, 'تعديل معلومات الشركة', 'admin-web', '2024-06-16 17:25:06', '2024-06-16 17:25:06'),
(90, 'حذف معلومات الشركة', 'admin-web', '2024-06-16 17:25:13', '2024-06-16 17:25:13'),
(91, 'ميزان رصيد الذهب', 'admin-web', '2024-06-16 17:25:47', '2024-06-16 17:25:47'),
(92, 'اضافة اشعار مدين مبسطة', 'admin-web', '2024-06-16 17:26:15', '2024-06-16 17:26:15'),
(93, 'عرض اشعار مدين مبسطة', 'admin-web', '2024-06-16 17:26:28', '2024-06-16 17:26:28'),
(94, 'اضافة اشعار مدين ضريبية', 'admin-web', '2024-06-16 17:26:51', '2024-06-16 17:26:51'),
(95, 'عرض اشعار مدين ضريبية', 'admin-web', '2024-06-16 17:27:10', '2024-06-16 17:27:10'),
(96, 'اضافة مردود مشتريات', 'admin-web', '2024-06-16 17:27:31', '2024-06-16 17:27:31'),
(97, 'عرض مردود مشتريات', 'admin-web', '2024-06-16 17:27:45', '2024-06-16 17:27:45'),
(98, 'تعديل مردود مشتريات', 'admin-web', '2024-06-16 17:27:53', '2024-06-16 17:27:53'),
(99, 'حذف مردود مشتريات', 'admin-web', '2024-06-16 17:28:00', '2024-06-16 17:28:00'),
(100, 'اضافة نسخة احتياطية', 'admin-web', '2024-06-16 17:28:32', '2024-06-16 17:28:32'),
(101, 'عرض نسخة احتياطية', 'admin-web', '2024-06-16 17:28:43', '2024-06-16 17:28:43'),
(102, 'حذف نسخة احتياطية', 'admin-web', '2024-06-16 17:28:54', '2024-06-16 17:28:54');

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
-- Table structure for table `pos_settings`
--

CREATE TABLE `pos_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `show_items` varchar(255) DEFAULT NULL,
  `default_category` int(11) DEFAULT 0,
  `cashier_id` int(11) DEFAULT 0,
  `client_id` int(11) DEFAULT 0,
  `show_time` int(11) DEFAULT 0,
  `item_search` varchar(255) DEFAULT NULL,
  `add_new_item` varchar(255) DEFAULT NULL,
  `insert_client` varchar(255) DEFAULT NULL,
  `add_client` varchar(255) DEFAULT NULL,
  `category_toggle` varchar(255) DEFAULT NULL,
  `subCategory_toggle` varchar(255) DEFAULT NULL,
  `brand_toggle` varchar(255) DEFAULT NULL,
  `cancel_sell` varchar(255) DEFAULT NULL,
  `pend_sell` varchar(255) DEFAULT NULL,
  `printed_material` varchar(255) DEFAULT NULL,
  `finish_bill` varchar(255) DEFAULT NULL,
  `daily_sales` varchar(255) DEFAULT NULL,
  `opening_pending_sales` varchar(255) DEFAULT NULL,
  `close_shift` varchar(255) DEFAULT NULL,
  `qr_print` int(11) DEFAULT 0,
  `header_print` int(11) DEFAULT 0,
  `header_img` varchar(255) DEFAULT NULL,
  `seller_buyer` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricings`
--

CREATE TABLE `pricings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `last_Update` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` double(10,2) NOT NULL DEFAULT 0.00,
  `price_21` double(10,2) NOT NULL DEFAULT 0.00,
  `price_22` double(10,2) NOT NULL DEFAULT 0.00,
  `price_24` double(10,2) NOT NULL DEFAULT 0.00,
  `price_18` double(10,2) NOT NULL DEFAULT 0.00,
  `price_14` double(10,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricings`
--

INSERT INTO `pricings` (`id`, `last_Update`, `user_id`, `price`, `price_21`, `price_22`, `price_24`, `price_18`, `price_14`, `currency`, `created_at`, `updated_at`) VALUES
(1, '2026-02-01 19:29:39', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'SAR', '2026-02-01 16:29:39', '2026-02-01 16:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` int(11) NOT NULL,
  `price` double NOT NULL,
  `cost` double NOT NULL,
  `lista` double NOT NULL,
  `alert_quantity` double NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `tax` double NOT NULL,
  `tax_rate` int(11) NOT NULL,
  `tax_method` int(11) NOT NULL,
  `tax_excise` double NOT NULL,
  `track_quantity` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `featured` int(11) NOT NULL,
  `city_tax` double NOT NULL,
  `max_order` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_units`
--

CREATE TABLE `product_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_settings`
--

CREATE TABLE `program_settings` (
  `id` int(11) NOT NULL,
  `branche` int(11) NOT NULL,
  `users` int(11) NOT NULL,
  `items` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_settings`
--

INSERT INTO `program_settings` (`id`, `branche`, `users`, `items`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 1, 1, '2026-02-01 16:29:39', '2026-02-01 16:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `total` double NOT NULL,
  `discount` double NOT NULL,
  `tax` double NOT NULL,
  `net` double NOT NULL,
  `paid` double NOT NULL,
  `purchase_status` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `returned_bill_id` int(11) DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases_collectibles`
--

CREATE TABLE `purchases_collectibles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(50) NOT NULL,
  `supplier_bill_number` varchar(50) DEFAULT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_collectible_details`
--

CREATE TABLE `purchase_collectible_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `made_money` decimal(8,2) NOT NULL,
  `net_weight` decimal(8,2) NOT NULL,
  `net_money` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `cost_without_tax` double NOT NULL,
  `cost_with_tax` double NOT NULL,
  `warehouse_id` double NOT NULL,
  `unit_id` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `net` double NOT NULL,
  `returned_qnt` double DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `representatives`
--

CREATE TABLE `representatives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_works`
--

CREATE TABLE `return_works` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `reason` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin-web', '2026-02-01 16:29:40', '2026-02-01 16:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_views`
--

CREATE TABLE `role_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `view_id` int(11) NOT NULL,
  `all_auth` int(11) NOT NULL DEFAULT 0,
  `save_auth` int(11) NOT NULL DEFAULT 0,
  `edit_auth` int(11) NOT NULL DEFAULT 0,
  `delete_auth` int(11) NOT NULL DEFAULT 0,
  `preview_auth` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_docs`
--

CREATE TABLE `salary_docs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notes` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_doc_details`
--

CREATE TABLE `salary_doc_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` int(11) NOT NULL,
  `hours` double NOT NULL,
  `hour_value` double NOT NULL,
  `reward` double NOT NULL,
  `additional` double NOT NULL,
  `advance_payment` double NOT NULL,
  `deductions` double NOT NULL,
  `salary_doc_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `biller_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `total` double NOT NULL,
  `discount` double NOT NULL,
  `tax` double NOT NULL,
  `tax_excise` double DEFAULT NULL,
  `net` double NOT NULL,
  `paid` double NOT NULL,
  `sale_status` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `pos` int(11) NOT NULL,
  `lista` double NOT NULL,
  `profit` double NOT NULL,
  `additional_service` double NOT NULL DEFAULT 0,
  `note` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_collectibles`
--

CREATE TABLE `sale_collectibles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(191) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_tax_number` varchar(50) DEFAULT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_collectibles_details`
--

CREATE TABLE `sale_collectibles_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(8,2) NOT NULL,
  `gram_tax` decimal(8,2) NOT NULL,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `price_unit` double NOT NULL,
  `discount` double DEFAULT 0,
  `price_with_tax` double NOT NULL,
  `warehouse_id` double NOT NULL,
  `unit_id` double NOT NULL,
  `tax` double NOT NULL,
  `tax_excise` double NOT NULL,
  `total` double NOT NULL,
  `lista` double NOT NULL,
  `profit` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `simplified_debit`
--

CREATE TABLE `simplified_debit` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `bill_number` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `total21_gold` decimal(10,2) NOT NULL,
  `paid_money` decimal(10,2) NOT NULL,
  `remain_money` decimal(10,2) NOT NULL,
  `paid_gold` decimal(10,2) NOT NULL,
  `remain_gold` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `net_money` decimal(10,2) NOT NULL,
  `qr` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `invoice_hash` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `simplified_debit_details`
--

CREATE TABLE `simplified_debit_details` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `simplified_detail_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `gram_price` decimal(10,2) NOT NULL,
  `gram_manufacture` decimal(10,2) NOT NULL,
  `gram_tax` decimal(10,2) NOT NULL,
  `net_money` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `standard_debit`
--

CREATE TABLE `standard_debit` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `bill_number` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `total21_gold` decimal(10,2) NOT NULL,
  `paid_money` decimal(10,2) NOT NULL,
  `remain_money` decimal(10,2) NOT NULL,
  `paid_gold` decimal(10,2) NOT NULL,
  `remain_gold` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `net_money` decimal(10,2) NOT NULL,
  `qr` text DEFAULT NULL,
  `invoice_hash` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `standard_debit_details`
--

CREATE TABLE `standard_debit_details` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `standard_detail_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `gram_price` decimal(10,2) NOT NULL,
  `gram_manufacture` decimal(10,2) NOT NULL,
  `gram_tax` decimal(10,2) NOT NULL,
  `net_money` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `storehouses`
--

CREATE TABLE `storehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `tax_number` varchar(200) DEFAULT '',
  `commercial_registration` varchar(200) DEFAULT '',
  `serial_prefix` varchar(200) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sync_states`
--

CREATE TABLE `sync_states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `currency_id` int(11) DEFAULT 0,
  `email` varchar(255) DEFAULT NULL,
  `client_group_id` int(11) DEFAULT 0,
  `nom_of_days_to_edit_bill` int(11) DEFAULT 0,
  `branch_id` int(11) DEFAULT 0,
  `cashier_id` int(11) DEFAULT 0,
  `item_tax` int(11) DEFAULT 0,
  `item_expired` int(11) DEFAULT 0,
  `img_width` double DEFAULT 0,
  `img_height` double DEFAULT 0,
  `small_img_width` double DEFAULT 0,
  `small_img_height` double DEFAULT 0,
  `barcode_break` int(11) DEFAULT 0,
  `sell_without_stock` int(11) DEFAULT 0,
  `customize_refNumber` int(11) DEFAULT 0,
  `item_serial` int(11) DEFAULT 0,
  `adding_item_method` int(11) DEFAULT 0,
  `payment_method` int(11) DEFAULT 0,
  `sales_prefix` varchar(255) DEFAULT NULL,
  `sales_return_prefix` varchar(255) DEFAULT NULL,
  `payment_prefix` varchar(255) DEFAULT NULL,
  `purchase_payment_prefix` varchar(255) DEFAULT NULL,
  `deliver_prefix` varchar(255) DEFAULT NULL,
  `purchase_prefix` varchar(255) DEFAULT NULL,
  `purchase_return_prefix` varchar(255) DEFAULT NULL,
  `transaction_prefix` varchar(255) DEFAULT NULL,
  `expenses_prefix` varchar(255) DEFAULT NULL,
  `store_prefix` varchar(255) DEFAULT NULL,
  `quotation_prefix` varchar(255) DEFAULT NULL,
  `update_qnt_prefix` varchar(255) DEFAULT NULL,
  `fraction_number` int(11) DEFAULT 0,
  `qnt_double_point` int(11) DEFAULT 0,
  `double_type` int(11) DEFAULT 0,
  `thousand_type` int(11) DEFAULT 0,
  `show_currency` int(11) DEFAULT 0,
  `currency_label` varchar(255) DEFAULT NULL,
  `a4_double_point` int(11) DEFAULT 0,
  `barcode_type` int(11) DEFAULT 0,
  `barcode_length` int(11) DEFAULT 0,
  `flag_character` varchar(255) DEFAULT NULL,
  `barcode_start` int(11) DEFAULT 0,
  `code_length` int(11) DEFAULT 0,
  `weight_start` int(11) DEFAULT 0,
  `weight_length` int(11) DEFAULT 0,
  `weight_divider` double DEFAULT 0,
  `email_protocol` int(11) DEFAULT 0,
  `email_host` varchar(255) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `email_port` varchar(255) DEFAULT NULL,
  `email_encrypt` int(11) DEFAULT 0,
  `email_path` varchar(255) DEFAULT NULL,
  `client_value` double DEFAULT 0,
  `client_points` double DEFAULT 0,
  `employee_value` double DEFAULT 0,
  `employee_points` double DEFAULT 0,
  `is_tobacco` int(11) DEFAULT 0,
  `tobacco_tax` double DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `enable_inventory` int(11) NOT NULL DEFAULT 1,
  `valid_to` varchar(255) NOT NULL DEFAULT '',
  `contact_phone` varchar(255) NOT NULL DEFAULT '',
  `enable_accounting` int(11) NOT NULL DEFAULT 1,
  `max_users` int(11) NOT NULL DEFAULT 2,
  `max_branches` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_excise`
--

CREATE TABLE `tax_excise` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` double NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_settings`
--

CREATE TABLE `tax_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enabled` int(11) NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_settings`
--

INSERT INTO `tax_settings` (`id`, `enabled`, `value`, `created_at`, `updated_at`) VALUES
(1, 0, 0.00, '2026-02-01 16:29:39', '2026-02-01 16:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stone_type`
--

CREATE TABLE `tbl_stone_type` (
  `id` int(11) NOT NULL,
  `stone_ar` varchar(150) NOT NULL,
  `stone_en` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_quntities`
--

CREATE TABLE `update_quntities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `bill_date` datetime DEFAULT NULL,
  `bill_number` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_quntity_details`
--

CREATE TABLE `update_quntity_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `update_qnt_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `qnt` int(11) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `branch_id`, `phone_number`, `profile_pic`, `role_name`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'المبيعات', 'info@admin.com', '$2y$12$1tVNZ09ivdE4ZC70OaG8perNhiHwlPsNhbwykdJn49LSN93C/1chm', 1, '0000000000', '', 'Admin', 1, 'nU8t9ODJvY6uph3SHP9Y7T1tQFBsNQcvk79GIfEvsb1Vtj3DhBThC5RYvCc1', '2026-02-01 16:29:39', '2026-02-02 11:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_movements`
--

CREATE TABLE `vendor_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `paid` double NOT NULL,
  `debit` double NOT NULL,
  `credit` double NOT NULL,
  `date` varchar(255) NOT NULL,
  `invoice_type` varchar(255) NOT NULL,
  `invoice_id` double NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `paid_by` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `route` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rep_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` date NOT NULL,
  `state` int(11) NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tax_number` varchar(255) DEFAULT NULL,
  `commercial_registration` varchar(255) DEFAULT NULL,
  `serial_prefix` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `karat_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `enter_weight` decimal(8,2) NOT NULL DEFAULT 0.00,
  `out_weight` decimal(8,2) NOT NULL DEFAULT 0.00,
  `bill_id` int(11) NOT NULL DEFAULT 0,
  `date` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `code`, `name`, `phone`, `email`, `address`, `tax_number`, `commercial_registration`, `serial_prefix`, `branch_id`, `type`, `karat_id`, `category_id`, `enter_weight`, `out_weight`, `bill_id`, `date`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.00, 1, '2026-02-01 20:24:00', 1, 0, '2026-02-01 17:24:00', '2026-02-01 17:24:00'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 1.40, 2, '2026-02-03 18:06:02', 1, 0, '2026-02-03 15:06:02', '2026-02-03 15:06:02'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.00, 3, '2026-02-03 20:03:57', 1, 0, '2026-02-03 17:03:57', '2026-02-03 17:03:57'),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 2.10, 3, '2026-02-03 20:03:57', 1, 0, '2026-02-03 17:03:57', '2026-02-03 17:03:57'),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.40, 4, '2026-02-03 20:15:53', 1, 0, '2026-02-03 17:15:53', '2026-02-03 17:15:53'),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.60, 5, '2026-02-03 20:17:48', 1, 0, '2026-02-03 17:17:48', '2026-02-03 17:17:48'),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.10, 6, '2026-02-04 14:26:21', 1, 0, '2026-02-04 11:26:21', '2026-02-04 11:26:21'),
(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 6.90, 7, '2026-02-04 14:27:27', 1, 0, '2026-02-04 11:27:27', '2026-02-04 11:27:27'),
(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 10.10, 8, '2026-02-04 17:33:13', 1, 0, '2026-02-04 14:33:13', '2026-02-04 14:33:13'),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.80, 9, '2026-02-04 18:39:11', 1, 0, '2026-02-04 15:39:11', '2026-02-04 15:39:11'),
(11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 6.10, 10, '2026-02-05 19:19:02', 1, 0, '2026-02-05 16:19:02', '2026-02-05 16:19:02'),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.50, 11, '2026-02-05 19:48:01', 1, 0, '2026-02-05 16:48:01', '2026-02-05 16:48:01'),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 9.20, 12, '2026-02-06 14:55:36', 1, 0, '2026-02-06 11:55:36', '2026-02-06 11:55:36'),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.60, 13, '2026-02-06 18:43:11', 1, 0, '2026-02-06 15:43:11', '2026-02-06 15:43:11'),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.90, 14, '2026-02-06 19:19:35', 1, 0, '2026-02-06 16:19:35', '2026-02-06 16:19:35'),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 47.70, 15, '2026-02-07 18:22:15', 1, 0, '2026-02-07 15:22:15', '2026-02-07 15:22:15'),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 4.30, 15, '2026-02-07 18:22:15', 1, 0, '2026-02-07 15:22:15', '2026-02-07 15:22:15'),
(18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 5.30, 16, '2026-02-08 14:57:28', 1, 0, '2026-02-08 11:57:28', '2026-02-08 11:57:28'),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.10, 17, '2026-02-08 16:50:10', 1, 0, '2026-02-08 13:50:10', '2026-02-08 13:50:10'),
(20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 4.70, 18, '2026-02-09 16:10:57', 1, 0, '2026-02-09 13:10:57', '2026-02-09 13:10:57'),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.50, 19, '2026-02-09 16:22:03', 1, 0, '2026-02-09 13:22:03', '2026-02-09 13:22:03'),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 3.80, 20, '2026-02-09 16:26:32', 1, 0, '2026-02-09 13:26:32', '2026-02-09 13:26:32'),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 13.60, 21, '2026-02-10 15:15:26', 1, 0, '2026-02-10 12:15:26', '2026-02-10 12:15:26'),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.35, 22, '2026-02-11 16:21:13', 1, 0, '2026-02-11 13:21:13', '2026-02-11 13:21:13'),
(25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.35, 23, '2026-02-11 16:23:42', 1, 0, '2026-02-11 13:23:42', '2026-02-11 13:23:42'),
(26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 6.10, 24, '2026-02-11 18:26:05', 1, 0, '2026-02-11 15:26:05', '2026-02-11 15:26:05'),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 6.10, 25, '2026-02-11 18:28:05', 1, 0, '2026-02-11 15:28:05', '2026-02-11 15:28:05'),
(28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 4.60, 26, '2026-02-11 18:30:40', 1, 0, '2026-02-11 15:30:40', '2026-02-11 15:30:40'),
(29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.20, 27, '2026-02-11 19:25:57', 1, 0, '2026-02-11 16:25:57', '2026-02-11 16:25:57'),
(30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 1.10, 28, '2026-02-11 19:47:31', 1, 0, '2026-02-11 16:47:31', '2026-02-11 16:47:31'),
(31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.10, 29, '2026-02-11 19:49:10', 1, 0, '2026-02-11 16:49:10', '2026-02-11 16:49:10'),
(32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 2.70, 30, '2026-02-11 19:53:50', 1, 0, '2026-02-11 16:53:50', '2026-02-11 16:53:50'),
(33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 18.40, 31, '2026-02-11 20:23:11', 1, 0, '2026-02-11 17:23:11', '2026-02-11 17:23:11'),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 2.50, 32, '2026-02-11 20:25:04', 1, 0, '2026-02-11 17:25:04', '2026-02-11 17:25:04'),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.60, 33, '2026-02-12 16:20:19', 1, 0, '2026-02-12 13:20:19', '2026-02-12 13:20:19'),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.00, 34, '2026-02-12 18:02:44', 1, 0, '2026-02-12 15:02:44', '2026-02-12 15:02:44'),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 7.17, 35, '2026-02-13 15:48:52', 1, 0, '2026-02-13 12:48:52', '2026-02-13 12:48:52'),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 5.00, 36, '2026-02-13 15:50:38', 1, 0, '2026-02-13 12:50:38', '2026-02-13 12:50:38'),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 4.40, 37, '2026-02-13 16:35:14', 1, 0, '2026-02-13 13:35:14', '2026-02-13 13:35:14'),
(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.60, 38, '2026-02-13 19:36:05', 1, 0, '2026-02-13 16:36:05', '2026-02-13 16:36:05'),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 4.80, 39, '2026-02-14 14:30:05', 1, 0, '2026-02-14 11:30:05', '2026-02-14 11:30:05'),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 0.90, 40, '2026-02-14 17:25:19', 1, 0, '2026-02-14 14:25:19', '2026-02-14 14:25:19'),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.00, 41, '2026-02-14 17:47:57', 1, 0, '2026-02-14 14:47:57', '2026-02-14 14:47:57'),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 5.00, 42, '2026-02-15 14:03:30', 1, 0, '2026-02-15 11:03:30', '2026-02-15 11:03:30'),
(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.60, 43, '2026-02-15 14:46:23', 1, 0, '2026-02-15 11:46:23', '2026-02-15 11:46:23'),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 4.10, 44, '2026-02-15 18:58:17', 1, 0, '2026-02-15 15:58:17', '2026-02-15 15:58:17'),
(47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.50, 45, '2026-02-15 19:48:50', 1, 0, '2026-02-15 16:48:50', '2026-02-15 16:48:50'),
(48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 40.40, 46, '2026-02-16 14:42:35', 1, 0, '2026-02-16 11:42:35', '2026-02-16 11:42:35'),
(49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.10, 47, '2026-02-17 15:18:39', 1, 0, '2026-02-17 12:18:39', '2026-02-17 12:18:39'),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 48, '2026-02-17 16:26:03', 1, 0, '2026-02-17 13:26:03', '2026-02-17 13:26:03'),
(51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 49, '2026-02-18 20:32:29', 1, 0, '2026-02-18 17:32:29', '2026-02-18 17:32:29'),
(52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 7.60, 50, '2026-02-19 22:09:15', 1, 0, '2026-02-19 19:09:15', '2026-02-19 19:09:15'),
(53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 11.70, 51, '2026-02-20 20:35:14', 1, 0, '2026-02-20 17:35:14', '2026-02-20 17:35:14'),
(54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.50, 52, '2026-02-21 18:13:42', 1, 0, '2026-02-21 15:13:42', '2026-02-21 15:13:42'),
(55, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.60, 53, '2026-02-21 18:41:20', 1, 0, '2026-02-21 15:41:20', '2026-02-21 15:41:20'),
(56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.10, 54, '2026-02-22 18:41:17', 1, 0, '2026-02-22 15:41:17', '2026-02-22 15:41:17'),
(57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 0.90, 55, '2026-02-22 21:49:51', 1, 0, '2026-02-22 18:49:51', '2026-02-22 18:49:51'),
(58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.00, 56, '2026-02-22 22:24:54', 1, 0, '2026-02-22 19:24:54', '2026-02-22 19:24:54'),
(59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 3.00, 57, '2026-02-23 14:22:54', 1, 0, '2026-02-23 11:22:54', '2026-02-23 11:22:54'),
(60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.10, 58, '2026-02-23 21:24:18', 1, 0, '2026-02-23 18:24:18', '2026-02-23 18:24:18'),
(61, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 23.30, 59, '2026-02-23 22:47:15', 1, 0, '2026-02-23 19:47:15', '2026-02-23 19:47:15'),
(62, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.70, 60, '2026-02-24 19:17:33', 1, 0, '2026-02-24 16:17:33', '2026-02-24 16:17:33'),
(63, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.30, 61, '2026-02-24 20:44:58', 1, 0, '2026-02-24 17:44:58', '2026-02-24 17:44:58'),
(64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.70, 62, '2026-02-25 18:24:14', 1, 0, '2026-02-25 15:24:14', '2026-02-25 15:24:14'),
(65, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 3.40, 63, '2026-02-25 19:53:52', 1, 0, '2026-02-25 16:53:52', '2026-02-25 16:53:52'),
(66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.20, 64, '2026-02-25 20:01:55', 1, 0, '2026-02-25 17:01:55', '2026-02-25 17:01:55'),
(67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.00, 65, '2026-02-26 20:22:10', 1, 0, '2026-02-26 17:22:10', '2026-02-26 17:22:10'),
(68, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.00, 66, '2026-02-26 20:32:45', 1, 0, '2026-02-26 17:32:45', '2026-02-26 17:32:45'),
(69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.40, 67, '2026-02-27 18:18:07', 1, 0, '2026-02-27 15:18:07', '2026-02-27 15:18:07'),
(70, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.40, 68, '2026-02-27 18:34:36', 1, 0, '2026-02-27 15:34:36', '2026-02-27 15:34:36'),
(71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 22.80, 69, '2026-02-27 19:24:18', 1, 0, '2026-02-27 16:24:18', '2026-02-27 16:24:18'),
(72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.10, 70, '2026-02-27 21:27:32', 1, 0, '2026-02-27 18:27:32', '2026-02-27 18:27:32'),
(73, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.10, 71, '2026-02-27 21:37:28', 1, 0, '2026-02-27 18:37:28', '2026-02-27 18:37:28'),
(74, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.50, 72, '2026-02-27 21:53:55', 1, 0, '2026-02-27 18:53:55', '2026-02-27 18:53:55'),
(75, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 0.90, 73, '2026-02-28 19:01:00', 1, 0, '2026-02-28 16:01:00', '2026-02-28 16:01:00'),
(76, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.20, 74, '2026-02-28 20:17:15', 1, 0, '2026-02-28 17:17:15', '2026-02-28 17:17:15'),
(77, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.80, 75, '2026-03-01 18:21:31', 1, 0, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(78, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.80, 75, '2026-03-01 18:21:31', 1, 0, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(79, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 18.80, 75, '2026-03-01 18:21:31', 1, 0, '2026-03-01 15:21:31', '2026-03-01 15:21:31'),
(80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 2.10, 76, '2026-03-01 19:38:14', 1, 0, '2026-03-01 16:38:14', '2026-03-01 16:38:14'),
(81, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.30, 77, '2026-03-01 20:13:38', 1, 0, '2026-03-01 17:13:38', '2026-03-01 17:13:38'),
(82, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 5.70, 78, '2026-03-01 20:39:08', 1, 0, '2026-03-01 17:39:08', '2026-03-01 17:39:08'),
(83, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.30, 79, '2026-03-01 21:59:59', 1, 0, '2026-03-01 18:59:59', '2026-03-01 18:59:59'),
(84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.40, 80, '2026-03-01 22:10:20', 1, 0, '2026-03-01 19:10:20', '2026-03-01 19:10:20'),
(85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 81, '2026-03-01 22:12:50', 1, 0, '2026-03-01 19:12:50', '2026-03-01 19:12:50'),
(86, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 7.30, 82, '2026-03-01 22:19:38', 1, 0, '2026-03-01 19:19:38', '2026-03-01 19:19:38'),
(87, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 1.80, 83, '2026-03-01 22:40:12', 1, 0, '2026-03-01 19:40:12', '2026-03-01 19:40:12'),
(88, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.20, 84, '2026-03-02 21:13:48', 1, 0, '2026-03-02 18:13:48', '2026-03-02 18:13:48'),
(89, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 13.10, 85, '2026-03-02 21:17:13', 1, 0, '2026-03-02 18:17:13', '2026-03-02 18:17:13'),
(90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.83, 86, '2026-03-03 13:55:57', 1, 0, '2026-03-03 10:55:57', '2026-03-03 10:55:57'),
(91, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.40, 86, '2026-03-03 13:55:57', 1, 0, '2026-03-03 10:55:57', '2026-03-03 10:55:57'),
(92, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 3.20, 87, '2026-03-03 13:57:40', 1, 0, '2026-03-03 10:57:40', '2026-03-03 10:57:40'),
(93, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.10, 88, '2026-03-03 18:12:36', 1, 0, '2026-03-03 15:12:36', '2026-03-03 15:12:36'),
(94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 4.60, 89, '2026-03-03 22:19:13', 1, 0, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 23.20, 89, '2026-03-03 22:19:13', 1, 0, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(96, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 22.00, 89, '2026-03-03 22:19:13', 1, 0, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(97, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.90, 89, '2026-03-03 22:19:13', 1, 0, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(98, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 8.80, 89, '2026-03-03 22:19:13', 1, 0, '2026-03-03 19:19:13', '2026-03-03 19:19:13'),
(99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.00, 90, '2026-03-03 22:29:50', 1, 0, '2026-03-03 19:29:50', '2026-03-03 19:29:50'),
(100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 8.30, 91, '2026-03-03 22:31:19', 1, 0, '2026-03-03 19:31:19', '2026-03-03 19:31:19'),
(101, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.40, 92, '2026-03-03 23:11:27', 1, 0, '2026-03-03 20:11:27', '2026-03-03 20:11:27'),
(102, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 11.30, 93, '2026-03-04 04:20:24', 1, 0, '2026-03-04 01:20:24', '2026-03-04 01:20:24'),
(103, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 48.40, 94, '2026-03-04 19:39:19', 1, 0, '2026-03-04 16:39:19', '2026-03-04 16:39:19'),
(104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.60, 95, '2026-03-04 20:30:40', 1, 0, '2026-03-04 17:30:40', '2026-03-04 17:30:40'),
(105, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.20, 95, '2026-03-04 20:30:40', 1, 0, '2026-03-04 17:30:40', '2026-03-04 17:30:40'),
(106, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 11.60, 96, '2026-03-04 20:37:38', 1, 0, '2026-03-04 17:37:38', '2026-03-04 17:37:38'),
(107, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.40, 97, '2026-03-05 19:26:39', 1, 0, '2026-03-05 16:26:39', '2026-03-05 16:26:39'),
(108, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 0.60, 98, '2026-03-05 19:54:35', 1, 0, '2026-03-05 16:54:35', '2026-03-05 16:54:35'),
(109, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.22, 99, '2026-03-05 20:44:17', 1, 0, '2026-03-05 17:44:17', '2026-03-05 17:44:17'),
(110, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 7.00, 100, '2026-03-05 21:11:24', 1, 0, '2026-03-05 18:11:24', '2026-03-05 18:11:24'),
(111, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 0.90, 101, '2026-03-05 21:20:48', 1, 0, '2026-03-05 18:20:48', '2026-03-05 18:20:48'),
(112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.00, 102, '2026-03-05 23:00:42', 1, 0, '2026-03-05 20:00:42', '2026-03-05 20:00:42'),
(113, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 18.40, 103, '2026-03-06 18:13:00', 1, 0, '2026-03-06 15:13:00', '2026-03-06 15:13:00'),
(114, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.20, 104, '2026-03-06 18:17:32', 1, 0, '2026-03-06 15:17:32', '2026-03-06 15:17:32'),
(115, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.30, 105, '2026-03-06 19:44:47', 1, 0, '2026-03-06 16:44:47', '2026-03-06 16:44:47'),
(116, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.70, 106, '2026-03-06 20:09:17', 1, 0, '2026-03-06 17:09:17', '2026-03-06 17:09:17'),
(117, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 2.90, 107, '2026-03-06 21:05:08', 1, 0, '2026-03-06 18:05:08', '2026-03-06 18:05:08'),
(118, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 8.20, 108, '2026-03-06 21:07:47', 1, 0, '2026-03-06 18:07:47', '2026-03-06 18:07:47'),
(119, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 7.70, 109, '2026-03-06 21:09:07', 1, 0, '2026-03-06 18:09:07', '2026-03-06 18:09:07'),
(120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 25.00, 110, '2026-03-06 21:26:35', 1, 0, '2026-03-06 18:26:35', '2026-03-06 18:26:35'),
(121, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 14.70, 111, '2026-03-07 05:19:52', 1, 0, '2026-03-07 02:19:52', '2026-03-07 02:19:52'),
(122, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.30, 112, '2026-03-07 18:13:45', 1, 0, '2026-03-07 15:13:45', '2026-03-07 15:13:45'),
(123, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 9.80, 113, '2026-03-07 18:26:02', 1, 0, '2026-03-07 15:26:02', '2026-03-07 15:26:02'),
(124, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 2.40, 114, '2026-03-07 18:52:09', 1, 0, '2026-03-07 15:52:09', '2026-03-07 15:52:09'),
(125, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 8.70, 115, '2026-03-07 21:08:46', 1, 0, '2026-03-07 18:08:46', '2026-03-07 18:08:46'),
(126, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 2.30, 116, '2026-03-07 21:28:29', 1, 0, '2026-03-07 18:28:29', '2026-03-07 18:28:29'),
(127, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 16.00, 117, '2026-03-07 21:30:40', 1, 0, '2026-03-07 18:30:40', '2026-03-07 18:30:40'),
(128, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 3.00, 118, '2026-03-07 23:16:10', 1, 0, '2026-03-07 20:16:10', '2026-03-07 20:16:10'),
(129, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.40, 119, '2026-03-08 14:07:29', 1, 0, '2026-03-08 11:07:29', '2026-03-08 11:07:29'),
(130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 12.20, 120, '2026-03-08 18:32:36', 1, 0, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(131, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.60, 120, '2026-03-08 18:32:36', 1, 0, '2026-03-08 15:32:36', '2026-03-08 15:32:36'),
(132, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 15.10, 121, '2026-03-08 19:19:15', 1, 0, '2026-03-08 16:19:15', '2026-03-08 16:19:15'),
(133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 28.20, 122, '2026-03-08 19:21:09', 1, 0, '2026-03-08 16:21:09', '2026-03-08 16:21:09'),
(134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 13.70, 123, '2026-03-08 19:55:00', 1, 0, '2026-03-08 16:55:00', '2026-03-08 16:55:00'),
(135, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 25.00, 124, '2026-03-08 21:31:58', 1, 0, '2026-03-08 18:31:58', '2026-03-08 18:31:58'),
(136, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 7.90, 125, '2026-03-08 23:07:08', 1, 0, '2026-03-08 20:07:08', '2026-03-08 20:07:08'),
(137, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.70, 126, '2026-03-08 23:09:20', 1, 0, '2026-03-08 20:09:20', '2026-03-08 20:09:20'),
(138, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.80, 127, '2026-03-08 23:19:03', 1, 0, '2026-03-08 20:19:03', '2026-03-08 20:19:03'),
(139, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.60, 128, '2026-03-09 14:24:17', 1, 0, '2026-03-09 11:24:17', '2026-03-09 11:24:17'),
(140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.40, 129, '2026-03-11 18:54:42', 1, 0, '2026-03-11 15:54:42', '2026-03-11 15:54:42'),
(141, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 11.00, 130, '2026-03-11 19:00:43', 1, 0, '2026-03-11 16:00:43', '2026-03-11 16:00:43'),
(142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.30, 131, '2026-03-11 20:35:50', 1, 0, '2026-03-11 17:35:50', '2026-03-11 17:35:50'),
(143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 0.74, 132, '2026-03-11 20:37:44', 1, 0, '2026-03-11 17:37:44', '2026-03-11 17:37:44'),
(144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.50, 133, '2026-03-12 04:40:19', 1, 0, '2026-03-12 01:40:19', '2026-03-12 01:40:19'),
(145, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.80, 134, '2026-03-12 18:38:38', 1, 0, '2026-03-12 15:38:38', '2026-03-12 15:38:38'),
(146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 135, '2026-03-12 18:39:42', 1, 0, '2026-03-12 15:39:42', '2026-03-12 15:39:42'),
(147, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.50, 136, '2026-03-12 19:46:40', 1, 0, '2026-03-12 16:46:40', '2026-03-12 16:46:40'),
(148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.00, 137, '2026-03-12 20:49:31', 1, 0, '2026-03-12 17:49:31', '2026-03-12 17:49:31'),
(149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 2.60, 138, '2026-03-12 21:36:50', 1, 0, '2026-03-12 18:36:50', '2026-03-12 18:36:50'),
(150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.70, 139, '2026-03-12 23:03:54', 1, 0, '2026-03-12 20:03:54', '2026-03-12 20:03:54'),
(151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.00, 140, '2026-03-13 04:34:34', 1, 0, '2026-03-13 01:34:34', '2026-03-13 01:34:34'),
(152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 12.10, 141, '2026-03-13 18:34:13', 1, 0, '2026-03-13 15:34:13', '2026-03-13 15:34:13'),
(153, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.70, 142, '2026-03-13 19:33:09', 1, 0, '2026-03-13 16:33:09', '2026-03-13 16:33:09'),
(154, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.60, 143, '2026-03-13 19:49:34', 1, 0, '2026-03-13 16:49:34', '2026-03-13 16:49:34'),
(155, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 0.90, 144, '2026-03-13 20:03:23', 1, 0, '2026-03-13 17:03:23', '2026-03-13 17:03:23'),
(156, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 1.70, 145, '2026-03-13 20:39:23', 1, 0, '2026-03-13 17:39:23', '2026-03-13 17:39:23'),
(157, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 0.40, 146, '2026-03-13 21:18:59', 1, 0, '2026-03-13 18:18:59', '2026-03-13 18:18:59'),
(158, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 2.60, 147, '2026-03-13 21:50:15', 1, 0, '2026-03-13 18:50:15', '2026-03-13 18:50:15'),
(159, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 148, '2026-03-13 23:52:01', 1, 0, '2026-03-13 20:52:01', '2026-03-13 20:52:01'),
(160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.10, 148, '2026-03-13 23:52:01', 1, 0, '2026-03-13 20:52:01', '2026-03-13 20:52:01'),
(161, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 11.60, 149, '2026-03-14 03:01:22', 1, 0, '2026-03-14 00:01:22', '2026-03-14 00:01:22'),
(162, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.90, 150, '2026-03-14 04:55:57', 1, 0, '2026-03-14 01:55:57', '2026-03-14 01:55:57'),
(163, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.44, 151, '2026-03-14 18:57:48', 1, 0, '2026-03-14 15:57:48', '2026-03-14 15:57:48'),
(164, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.60, 152, '2026-03-14 18:59:16', 1, 0, '2026-03-14 15:59:16', '2026-03-14 15:59:16'),
(165, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 4.80, 153, '2026-03-14 19:10:06', 1, 0, '2026-03-14 16:10:06', '2026-03-14 16:10:06'),
(166, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.40, 154, '2026-03-14 19:55:05', 1, 0, '2026-03-14 16:55:05', '2026-03-14 16:55:05'),
(167, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 4.10, 155, '2026-03-14 22:54:02', 1, 0, '2026-03-14 19:54:02', '2026-03-14 19:54:02'),
(168, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 1.40, 156, '2026-03-14 23:04:37', 1, 0, '2026-03-14 20:04:37', '2026-03-14 20:04:37'),
(169, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.10, 157, '2026-03-15 04:50:37', 1, 0, '2026-03-15 01:50:38', '2026-03-15 01:50:38'),
(170, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 158, '2026-03-15 14:13:17', 1, 0, '2026-03-15 11:13:17', '2026-03-15 11:13:17'),
(171, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 158, '2026-03-15 14:13:17', 1, 0, '2026-03-15 11:13:17', '2026-03-15 11:13:17'),
(172, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 0.70, 158, '2026-03-15 14:13:17', 1, 0, '2026-03-15 11:13:17', '2026-03-15 11:13:17'),
(173, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 1.20, 159, '2026-03-15 14:34:52', 1, 0, '2026-03-15 11:34:52', '2026-03-15 11:34:52'),
(174, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 8.00, 160, '2026-03-15 19:50:15', 1, 0, '2026-03-15 16:50:15', '2026-03-15 16:50:15'),
(175, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.50, 161, '2026-03-15 22:17:25', 1, 0, '2026-03-15 19:17:25', '2026-03-15 19:17:25'),
(176, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.20, 162, '2026-03-16 04:39:44', 1, 0, '2026-03-16 01:39:44', '2026-03-16 01:39:44'),
(177, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 6.80, 163, '2026-03-16 14:04:34', 1, 0, '2026-03-16 11:04:34', '2026-03-16 11:04:34'),
(178, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 0.90, 164, '2026-03-16 23:07:04', 1, 0, '2026-03-16 20:07:04', '2026-03-16 20:07:04'),
(179, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 11.10, 165, '2026-03-17 22:14:39', 1, 0, '2026-03-17 19:14:39', '2026-03-17 19:14:39'),
(180, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.80, 166, '2026-03-17 22:41:20', 1, 0, '2026-03-17 19:41:20', '2026-03-17 19:41:20'),
(181, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 7.70, 167, '2026-03-18 05:36:33', 1, 0, '2026-03-18 02:36:33', '2026-03-18 02:36:33'),
(182, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.80, 167, '2026-03-18 05:36:33', 1, 0, '2026-03-18 02:36:33', '2026-03-18 02:36:33'),
(183, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.40, 168, '2026-03-18 19:30:10', 1, 0, '2026-03-18 16:30:10', '2026-03-18 16:30:10'),
(184, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.40, 169, '2026-03-18 19:30:51', 1, 0, '2026-03-18 16:30:51', '2026-03-18 16:30:51'),
(185, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.30, 170, '2026-03-18 20:43:09', 1, 0, '2026-03-18 17:43:09', '2026-03-18 17:43:09'),
(186, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.30, 171, '2026-03-18 20:57:54', 1, 0, '2026-03-18 17:57:54', '2026-03-18 17:57:54'),
(187, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 50.00, 172, '2026-03-18 21:22:46', 1, 0, '2026-03-18 18:22:46', '2026-03-18 18:22:46'),
(188, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 0.40, 172, '2026-03-18 21:22:46', 1, 0, '2026-03-18 18:22:46', '2026-03-18 18:22:46'),
(189, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.00, 173, '2026-03-18 22:13:21', 1, 0, '2026-03-18 19:13:21', '2026-03-18 19:13:21'),
(190, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.30, 174, '2026-03-18 23:01:45', 1, 0, '2026-03-18 20:01:45', '2026-03-18 20:01:45'),
(191, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.70, 175, '2026-03-19 19:50:02', 1, 0, '2026-03-19 16:50:02', '2026-03-19 16:50:02'),
(192, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 3.40, 176, '2026-03-23 15:32:35', 1, 0, '2026-03-23 12:32:35', '2026-03-23 12:32:35'),
(193, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.30, 177, '2026-03-23 16:59:10', 1, 0, '2026-03-23 13:59:10', '2026-03-23 13:59:10'),
(194, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.30, 178, '2026-03-23 19:58:42', 1, 0, '2026-03-23 16:58:42', '2026-03-23 16:58:42'),
(195, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 16.30, 179, '2026-03-23 20:26:19', 1, 0, '2026-03-23 17:26:19', '2026-03-23 17:26:19'),
(196, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.50, 180, '2026-03-24 07:42:14', 1, 0, '2026-03-24 04:42:14', '2026-03-24 04:42:14'),
(197, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 5.10, 181, '2026-03-24 14:46:43', 1, 0, '2026-03-24 11:46:43', '2026-03-24 11:46:43'),
(198, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.60, 182, '2026-03-24 16:37:41', 1, 0, '2026-03-24 13:37:41', '2026-03-24 13:37:41'),
(199, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.80, 183, '2026-03-24 18:53:22', 1, 0, '2026-03-24 15:53:22', '2026-03-24 15:53:22'),
(200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 22.10, 184, '2026-03-24 19:02:13', 1, 0, '2026-03-24 16:02:13', '2026-03-24 16:02:13'),
(201, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.41, 185, '2026-03-24 19:40:32', 1, 0, '2026-03-24 16:40:32', '2026-03-24 16:40:32'),
(202, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 30.00, 186, '2026-03-25 15:32:28', 1, 0, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(203, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 15.50, 186, '2026-03-25 15:32:28', 1, 0, '2026-03-25 12:32:28', '2026-03-25 12:32:28'),
(204, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.60, 187, '2026-03-25 18:12:41', 1, 0, '2026-03-25 15:12:41', '2026-03-25 15:12:41'),
(205, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.08, 188, '2026-03-25 20:28:06', 1, 0, '2026-03-25 17:28:06', '2026-03-25 17:28:06'),
(206, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 189, '2026-03-26 17:59:41', 1, 0, '2026-03-26 14:59:41', '2026-03-26 14:59:41'),
(207, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.10, 190, '2026-03-26 18:50:36', 1, 0, '2026-03-26 15:50:36', '2026-03-26 15:50:36'),
(208, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.00, 191, '2026-03-26 18:56:18', 1, 0, '2026-03-26 15:56:18', '2026-03-26 15:56:18'),
(209, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.90, 192, '2026-03-26 19:58:35', 1, 0, '2026-03-26 16:58:35', '2026-03-26 16:58:35'),
(210, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 14.48, 193, '2026-03-27 14:28:24', 1, 0, '2026-03-27 11:28:24', '2026-03-27 11:28:24'),
(211, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 0.60, 194, '2026-03-27 14:33:24', 1, 0, '2026-03-27 11:33:24', '2026-03-27 11:33:24'),
(212, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.10, 194, '2026-03-27 14:33:24', 1, 0, '2026-03-27 11:33:24', '2026-03-27 11:33:24'),
(213, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.80, 195, '2026-03-27 18:24:44', 1, 0, '2026-03-27 15:24:44', '2026-03-27 15:24:44'),
(214, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 5.20, 196, '2026-03-27 19:05:46', 1, 0, '2026-03-27 16:05:46', '2026-03-27 16:05:46'),
(215, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.90, 197, '2026-03-27 20:04:33', 1, 0, '2026-03-27 17:04:33', '2026-03-27 17:04:33'),
(216, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 11.70, 198, '2026-03-28 15:00:27', 1, 0, '2026-03-28 12:00:27', '2026-03-28 12:00:27'),
(217, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 0, 0.00, 3.90, 199, '2026-03-28 16:43:42', 1, 0, '2026-03-28 13:43:42', '2026-03-28 13:43:42'),
(218, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 12.10, 200, '2026-03-28 17:58:46', 1, 0, '2026-03-28 14:58:46', '2026-03-28 14:58:46'),
(219, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.90, 200, '2026-03-28 17:58:46', 1, 0, '2026-03-28 14:58:46', '2026-03-28 14:58:46'),
(220, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 7.00, 201, '2026-03-28 18:33:33', 1, 0, '2026-03-28 15:33:33', '2026-03-28 15:33:33'),
(221, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.00, 202, '2026-03-28 19:30:04', 1, 0, '2026-03-28 16:30:04', '2026-03-28 16:30:04'),
(222, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.00, 203, '2026-03-28 20:00:07', 1, 0, '2026-03-28 17:00:07', '2026-03-28 17:00:07'),
(223, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.50, 204, '2026-03-29 16:20:49', 1, 0, '2026-03-29 13:20:49', '2026-03-29 13:20:49'),
(224, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 11.30, 205, '2026-03-29 18:07:38', 1, 0, '2026-03-29 15:07:38', '2026-03-29 15:07:38'),
(225, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.70, 206, '2026-03-29 20:10:35', 1, 0, '2026-03-29 17:10:35', '2026-03-29 17:10:35'),
(226, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, 3.30, 207, '2026-03-29 20:20:42', 1, 0, '2026-03-29 17:20:42', '2026-03-29 17:20:42'),
(227, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 3.10, 208, '2026-03-31 13:55:54', 1, 0, '2026-03-31 10:55:54', '2026-03-31 10:55:54'),
(228, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 1.40, 209, '2026-03-31 16:36:34', 1, 0, '2026-03-31 13:36:34', '2026-03-31 13:36:34'),
(229, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.00, 210, '2026-03-31 18:16:02', 1, 0, '2026-03-31 15:16:02', '2026-03-31 15:16:02'),
(230, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 2.90, 211, '2026-04-01 08:30:16', 1, 0, '2026-04-01 05:30:16', '2026-04-01 05:30:16'),
(231, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 0, 0.00, 6.20, 212, '2026-04-01 20:24:46', 1, 0, '2026-04-01 17:24:46', '2026-04-01 17:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses_items`
--

CREATE TABLE `warehouses_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `type` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `enter` decimal(8,2) NOT NULL,
  `out` decimal(8,2) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_movements`
--

CREATE TABLE `warehouse_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `debit` double NOT NULL,
  `credit` double NOT NULL,
  `invoice_type` varchar(255) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `invoice_no` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_products`
--

CREATE TABLE `warehouse_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `cost` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounting_closing`
--
ALTER TABLE `accounting_closing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_trees`
--
ALTER TABLE `accounts_trees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_movements`
--
ALTER TABLE `account_movements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_settings`
--
ALTER TABLE `account_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advance_payments`
--
ALTER TABLE `advance_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advance_payment_months`
--
ALTER TABLE `advance_payment_months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashiers`
--
ALTER TABLE `cashiers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catch_recipts`
--
ALTER TABLE `catch_recipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_infos`
--
ALTER TABLE `company_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_movements`
--
ALTER TABLE `company_movements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer_categories`
--
ALTER TABLE `employer_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enter_money`
--
ALTER TABLE `enter_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enter_olds`
--
ALTER TABLE `enter_olds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enter_old_details`
--
ALTER TABLE `enter_old_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enter_works`
--
ALTER TABLE `enter_works`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enter_work_details`
--
ALTER TABLE `enter_work_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exit_money`
--
ALTER TABLE `exit_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exit_olds`
--
ALTER TABLE `exit_olds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exit_old_details`
--
ALTER TABLE `exit_old_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exit_works`
--
ALTER TABLE `exit_works`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exit_work_details`
--
ALTER TABLE `exit_work_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses_categories`
--
ALTER TABLE `expenses_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventorys`
--
ALTER TABLE `inventorys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_details`
--
ALTER TABLE `inventory_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_collectibles`
--
ALTER TABLE `items_collectibles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_details`
--
ALTER TABLE `journal_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karats`
--
ALTER TABLE `karats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pos_settings`
--
ALTER TABLE `pos_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricings`
--
ALTER TABLE `pricings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_units`
--
ALTER TABLE `product_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `representatives`
--
ALTER TABLE `representatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary_docs`
--
ALTER TABLE `salary_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_doc_details`
--
ALTER TABLE `salary_doc_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_excise`
--
ALTER TABLE `tax_excise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_quntities`
--
ALTER TABLE `update_quntities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_quntity_details`
--
ALTER TABLE `update_quntity_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_movements`
--
ALTER TABLE `vendor_movements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse_movements`
--
ALTER TABLE `warehouse_movements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounting_closing`
--
ALTER TABLE `accounting_closing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_trees`
--
ALTER TABLE `accounts_trees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `account_movements`
--
ALTER TABLE `account_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- AUTO_INCREMENT for table `account_settings`
--
ALTER TABLE `account_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `advance_payments`
--
ALTER TABLE `advance_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advance_payment_months`
--
ALTER TABLE `advance_payment_months`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashiers`
--
ALTER TABLE `cashiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catch_recipts`
--
ALTER TABLE `catch_recipts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_infos`
--
ALTER TABLE `company_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_movements`
--
ALTER TABLE `company_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employers`
--
ALTER TABLE `employers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employer_categories`
--
ALTER TABLE `employer_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enter_money`
--
ALTER TABLE `enter_money`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `enter_olds`
--
ALTER TABLE `enter_olds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enter_old_details`
--
ALTER TABLE `enter_old_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enter_works`
--
ALTER TABLE `enter_works`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enter_work_details`
--
ALTER TABLE `enter_work_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exit_money`
--
ALTER TABLE `exit_money`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exit_olds`
--
ALTER TABLE `exit_olds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exit_old_details`
--
ALTER TABLE `exit_old_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exit_works`
--
ALTER TABLE `exit_works`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT for table `exit_work_details`
--
ALTER TABLE `exit_work_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_categories`
--
ALTER TABLE `expenses_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventorys`
--
ALTER TABLE `inventorys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_details`
--
ALTER TABLE `inventory_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `items_collectibles`
--
ALTER TABLE `items_collectibles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- AUTO_INCREMENT for table `journal_details`
--
ALTER TABLE `journal_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1537;

--
-- AUTO_INCREMENT for table `karats`
--
ALTER TABLE `karats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pos_settings`
--
ALTER TABLE `pos_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pricings`
--
ALTER TABLE `pricings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `representatives`
--
ALTER TABLE `representatives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salary_docs`
--
ALTER TABLE `salary_docs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_doc_details`
--
ALTER TABLE `salary_doc_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_excise`
--
ALTER TABLE `tax_excise`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_quntities`
--
ALTER TABLE `update_quntities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_quntity_details`
--
ALTER TABLE `update_quntity_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_movements`
--
ALTER TABLE `vendor_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `warehouse_movements`
--
ALTER TABLE `warehouse_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
