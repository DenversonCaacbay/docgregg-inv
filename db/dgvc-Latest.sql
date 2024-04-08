-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 08, 2024 at 05:26 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dgvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `prod_id` int NOT NULL,
  `customer_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `product` text COLLATE utf8mb4_general_ci NOT NULL,
  `total` text COLLATE utf8mb4_general_ci NOT NULL,
  `profit` text COLLATE utf8mb4_general_ci NOT NULL,
  `totalQty` int NOT NULL,
  `cash` text COLLATE utf8mb4_general_ci NOT NULL,
  `cash_change` text COLLATE utf8mb4_general_ci NOT NULL,
  `staff_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`prod_id`, `customer_name`, `product`, `total`, `profit`, `totalQty`, `cash`, `cash_change`, `staff_name`, `created_at`) VALUES
(1, 'Blesie', 'Pedigree P120 1 pc(s)', '120', '20', 1, '120', '0', 'Gregg Sumalbag', '2024-02-10 06:14:02'),
(2, 'Blessie', 'Pedigree P120 4 pc(s)', '480', '80', 4, '500', '20', 'Gregg Sumalbag', '2024-02-10 10:43:03'),
(3, 'Bimby', 'Pedigree P320 1 pc(s), Royal Canin Bengal P220 1 pc(s)', '540', '40', 2, '550', '10', 'Super Admin', '2024-02-25 15:12:44'),
(4, 'emmy', 'Pedigree P320 1 pc(s)', '320', '20', 1, '400', '80', 'Gregg Sumalbag', '2024-02-25 15:17:55'),
(5, 'bal', 'Pedigree P320 1 pc(s)', '320', '20', 1, '400', '80', 'Gregg Sumalbag', '2024-02-25 15:18:18'),
(6, 'bal', 'Pedigree P320 1 pc(s)', '320', '20', 1, '400', '80', 'Gregg Sumalbag', '2024-03-03 13:37:48'),
(7, 'Lynn', 'Special Cat Chicken & Turkey P150 1 pc(s)', '150', '50', 1, '200', '50', 'Gregg Sumalbag', '2024-03-11 08:51:39'),
(8, 'gregg', 'Pedigree P320 1 pc(s)', '320', '20', 1, '1000', '680', 'Gregg Sumalbag', '2024-03-11 09:15:42'),
(9, 'Kath', 'Pedigree P320 1 pc(s)', '320', '20', 1, '400', '80', 'Gregg Sumalbag', '2024-03-12 15:22:05'),
(10, 'andrei', 'Pedigree P320 1 pc(s)', '320', '20', 1, '400', '80', 'Gregg Sumalbag', '2024-03-13 12:28:14'),
(11, 'drei', 'Pedigree P320 91 pc(s)', '29120', '1820', 91, '30000', '880', 'Gregg Sumalbag', '2024-03-13 12:47:09'),
(12, 'bless', 'Royal Canin Bengal P220 79 pc(s)', '17380', '1580', 79, '18000', '620', 'Gregg Sumalbag', '2024-03-13 12:47:55'),
(13, 'drei', 'Special Cat Chicken & Turkey P150 78 pc(s)', '11700', '3900', 78, '12000', '300', 'Gregg Sumalbag', '2024-03-13 12:49:43'),
(14, 'Blessie L. Gabales', 'Royal Canin Bengal P150 3 pc(s)', '450', '150', 3, '500', '50', 'Gregg Sumalbag', '2024-03-20 16:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `verified` int NOT NULL,
  `position` text COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `email`, `password`, `lname`, `fname`, `mi`, `picture`, `verification_code`, `verified`, `position`, `role`, `created_at`, `deleted_at`) VALUES
(1, 'dgvetclinic@gmail.com', '$2y$10$ipFGj.xC1/fdgTbeaNmc5OH6q7ua/45EGOPa/XeJ8.dhaHCZAuwAi', 'Sumalbag', 'Gregg', '', '../uploads/admin/1704849200.png', '2c039b37fcc29dd836bdd07003b1112d', 1, 'Veterinarian', 'administrator', '2024-01-15 11:06:55', NULL),
(2, 'gabalesblessielibron@gmail.com', '$2y$10$0PLJCTntzNyCxQpLY5yfoeeF5LpsGK0b9TBijRcGgUscBfYpPCC/G', 'Admin', 'Super', '', '../uploads/admin/1708191759.jpg', '1a4e5f6c8d2b3a7f9e1c0d2b3a1e2f3', 1, 'Super Admin', 'administrator', '2024-01-23 13:24:32', NULL),
(3, 'blessygables09@gmail.com', '$2y$10$8ERphXckTHXbY2qeC10n/Oa1oeMFSz2bgd/bj9NLZ5iH5aYjDHE7W', 'Gables', 'Blessy', '', '../uploads/admin/cropped_1709639862.png', '7183', 1, 'Groomer', 'Staff', '2024-03-05 11:27:04', '2024-03-11 13:03:47'),
(4, 'esguerrabebe009@gmail.com', '$2y$10$O5gTQX2/imTimRtwN3YmVeUZKFCYk9LNTBKP.AX5Fyg56TSZ/x3Q6', 'Esguerra', 'Erwin', '', '../uploads/admin/cropped_1710147807.png', '9866', 1, 'Groomer', 'Staff', '2024-03-11 08:58:15', NULL),
(5, 'ndanielbaunsimbulan06@gmail.com', '$2y$10$BhIWBFUuOdo/LqgWcvABnugccg/HCEwAwwaY7k84syeczvF8VVQa6', 'Simbulan', 'Daniel', '', '../uploads/admin/cropped_1710148343.png', '9799', 1, 'Assistant Groomer', 'Staff', '2024-03-11 09:07:05', NULL),
(6, 'kathdeatras@gmail.com', '$2y$10$SW.2KDOOu8b/.0JcXy0NhetFLK.lVPNBdHKJMc62RasFC8APBKYl2', 'Deatras', 'Katherine', '', NULL, '9246', 1, 'Groomer', 'Staff', '2024-03-13 10:52:36', NULL),
(7, 'blesles67@gmail.com', '$2y$10$qURXXIi/n5Ok7jVnmiLTIubQvU.7c1jD.qebFcwqwEjdv4k8FOSzu', 'Gab', 'Bles', '', NULL, '1891', 1, 'Assistant Groomer', 'Staff', '2024-03-20 16:54:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `inv_id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `capital` float NOT NULL,
  `profit` float NOT NULL DEFAULT '0',
  `quantity` int NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `picture` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `purchased_at` date DEFAULT NULL,
  `expired_at` date DEFAULT NULL,
  `Column 8` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`inv_id`, `name`, `price`, `capital`, `profit`, `quantity`, `category`, `picture`, `purchased_at`, `expired_at`, `Column 8`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, 'Pedigree', 320, 300, 20, 102, 'Dog Food', '../uploads/inventory/1708191346.jpg', '2024-02-14', '2025-02-26', NULL, '2024-02-14 11:04:04', '2024-02-14 11:04:04', NULL),
(2, 'Royal Canin Bengal', 220, 200, 20, 120, 'Cat food', '../uploads/inventory/1708870496.jpg', '2024-02-26', '2025-02-28', NULL, '2024-02-25 14:14:56', '2024-02-25 14:14:56', NULL),
(3, 'Special Cat Chicken & Turkey', 150, 100, 50, 21, 'Cat food', '../uploads/inventory/1709472932.jpg', '2024-03-03', '2025-03-17', NULL, '2024-03-03 13:35:32', '2024-03-03 13:35:32', NULL),
(4, 'Royal Canin Bengal', 150, 100, 50, 97, 'Cat food', '../uploads/inventory/1709534962.jpg', '2024-03-04', '2025-03-19', NULL, '2024-03-04 06:49:22', '2024-03-04 06:49:22', NULL),
(5, 'Adult Instinctive', 168, 150, 18, 100, 'Cat food', '../uploads/inventory/1710081049.jpg', '2024-03-10', '2025-03-17', NULL, '2024-03-10 14:30:49', '2024-03-10 14:30:49', NULL),
(6, 'Royal Canin Short Hair', 1680, 1650, 30, 100, 'Cat food', '../uploads/inventory/1710081511.jpg', '2024-03-01', '2025-03-03', NULL, '2024-03-10 14:38:31', '2024-03-10 14:38:31', NULL),
(7, 'Royal Canin Hairball Boules de Poils', 1360, 1300, 60, 100, 'Cat food', '../uploads/inventory/1710081700.jpg', '2024-03-02', '2025-03-04', NULL, '2024-03-10 14:41:40', '2024-03-10 14:41:40', NULL),
(8, 'Royal Canin Indoor Interieur ', 1269, 1250, 19, 100, 'Cat food', '../uploads/inventory/1710081881.jpg', '2024-03-03', '2025-03-06', NULL, '2024-03-10 14:44:41', '2024-03-10 14:44:41', NULL),
(9, 'Royal Digestive Destif', 385, 370, 15, 100, 'Cat food', '../uploads/inventory/1710082233.jpg', '2024-03-09', '2025-03-10', NULL, '2024-03-10 14:50:33', '2024-03-10 14:50:33', NULL),
(10, 'Pedigree', 170, 135, 35, 100, 'Dog Food', '../uploads/inventory/1710147330.jpg', '2024-03-11', '2025-03-19', NULL, '2024-03-11 08:55:30', '2024-03-11 08:55:30', NULL),
(11, 'Special Cat Chicken & Turkey', 155, 140, 15, 100, 'Cat food', '../uploads/inventory/1710160600.jpg', '2024-03-11', '2025-03-13', NULL, '2024-03-11 12:36:40', '2024-03-11 12:36:40', NULL),
(12, 'Poodle Food', 1069, 1059, 10, 100, 'Dog Food', '../uploads/inventory/1710166398.jpg', '2024-03-11', '2025-03-12', NULL, '2024-03-11 14:13:18', '2024-03-11 14:13:18', NULL),
(13, 'Puppy Chiot Royal Canin', 929, 919, 10, 100, 'Dog Food', '../uploads/inventory/1710166593.jpg', '2024-03-11', '2025-03-14', NULL, '2024-03-11 14:16:33', '2024-03-11 14:16:33', NULL),
(14, 'Royal Canin Bulldog', 870, 850, 20, 100, 'Dog Food', '../uploads/inventory/1710167825.jpg', '2024-03-12', '2025-03-15', NULL, '2024-03-11 14:37:05', '2024-03-11 14:37:05', NULL),
(15, 'Royal Canin Chihuahua', 1085, 1075, 10, 100, 'Dog Food', '../uploads/inventory/1710169251.jpg', '2024-03-11', '2025-03-16', NULL, '2024-03-11 15:00:51', '2024-03-11 15:00:51', NULL),
(16, 'Puppy Chiot Food', 929, 919, 10, 100, 'Dog Food', '../uploads/inventory/1710169350.jpg', '2024-03-11', '2025-03-17', NULL, '2024-03-11 15:02:30', '2024-03-11 15:02:30', NULL),
(17, 'Madre de cacao', 345, 330, 15, 100, 'Shampoo', '../uploads/inventory/1710172714.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-11 15:58:34', '2024-03-11 15:58:34', NULL),
(18, 'Fur magic Dog shampoo', 465, 450, 15, 100, 'Shampoo', '../uploads/inventory/1710173983.png', '2024-03-12', '2025-03-12', NULL, '2024-03-11 16:19:43', '2024-03-11 16:19:43', NULL),
(19, 'Groom & Bloom', 120, 110, 10, 100, 'Shampoo', '../uploads/inventory/1710174582.jpg', '2024-03-12', '2025-03-19', NULL, '2024-03-11 16:29:42', '2024-03-11 16:29:42', NULL),
(20, 'Premium Organic Cat Shampoo', 520, 500, 20, 100, 'Shampoo', '../uploads/inventory/1710175090.jpg', '2024-03-12', '2025-03-13', NULL, '2024-03-11 16:38:10', '2024-03-11 16:38:10', NULL),
(21, 'Royal Tail Shampoo', 320, 300, 20, 100, 'Shampoo', '../uploads/inventory/1710175669.jpg', '2024-03-12', '2025-03-13', NULL, '2024-03-11 16:47:49', '2024-03-11 16:47:49', NULL),
(22, 'Mixidine', 350, 330, 20, 100, 'Shampoo', '../uploads/inventory/1710175905.jpg', '2024-03-12', '2025-03-12', NULL, '2024-03-11 16:51:45', '2024-03-11 16:51:45', NULL),
(23, '0.3ml Insulin Syringe', 310, 300, 10, 100, 'Syringe', '../uploads/inventory/1710176387.jpeg', '2024-03-12', '2025-03-13', NULL, '2024-03-11 16:59:47', '2024-03-11 16:59:47', NULL),
(24, '0.5ml Syringe', 1320, 1300, 20, 100, 'Syringe', '../uploads/inventory/1710176698.jpg', '2024-03-12', '2025-03-12', NULL, '2024-03-11 17:04:58', '2024-03-11 17:04:58', NULL),
(25, 'Benadryl', 130, 120, 10, 20, 'Medicine', '../uploads/inventory/1710255085.png', '2024-03-12', '2025-03-13', NULL, '2024-03-12 14:51:25', '2024-03-12 14:51:25', NULL),
(26, 'Carprofen ', 120, 110, 10, 100, 'Medicine', '../uploads/inventory/1710255266.png', '2024-03-12', '2025-03-12', NULL, '2024-03-12 14:54:26', '2024-03-12 14:54:26', NULL),
(27, 'Doxeprime', 700, 680, 20, 100, 'Medicine', '../uploads/inventory/1710255354.png', '2024-03-12', '2025-03-12', NULL, '2024-03-12 14:55:54', '2024-03-12 14:55:54', NULL),
(28, 'Doxycyline', 100, 90, 10, 100, 'Medicine', '../uploads/inventory/1710255695.png', '2024-03-12', '2025-03-12', NULL, '2024-03-12 15:01:35', '2024-03-12 15:01:35', NULL),
(29, 'Dymetrazole', 135, 120, 15, 100, 'Medicine', '../uploads/inventory/1710255877.jpg', '2024-03-12', '2025-03-12', NULL, '2024-03-12 15:04:37', '2024-03-12 15:04:37', NULL),
(30, 'Induzepam', 120, 110, 10, 100, 'Medicine', '../uploads/inventory/1710255935.png', '2024-03-12', '2025-03-12', NULL, '2024-03-12 15:05:35', '2024-03-12 15:05:35', NULL),
(31, 'Ketoconazole', 90, 80, 10, 100, 'Medicine', '../uploads/inventory/1710256153.png', '2024-03-12', '2025-03-12', NULL, '2024-03-12 15:09:13', '2024-03-12 15:09:13', NULL),
(32, 'OTC_Medication', 110, 100, 10, 100, 'Medicine', '../uploads/inventory/1710256473.png', '2024-03-12', '2025-03-12', NULL, '2024-03-12 15:14:33', '2024-03-12 15:14:33', NULL),
(33, 'Pepcid ', 140, 130, 10, 100, 'Medicine', '../uploads/inventory/1710256595.png', '2024-03-12', '2025-03-12', NULL, '2024-03-12 15:16:35', '2024-03-12 15:16:35', NULL),
(34, 'Pepto Bismol', 112, 100, 12, 100, 'Medicine', '../uploads/inventory/1710256660.jpg', '2024-03-12', '2025-03-12', NULL, '2024-03-12 15:17:40', '2024-03-12 15:17:40', NULL),
(35, 'Rabvac', 135, 120, 15, 100, 'Vaccine', '../uploads/inventory/1710256771.jpg', '2024-03-12', '2025-03-12', NULL, '2024-03-12 15:19:31', '2024-03-12 15:19:31', NULL),
(36, 'Powercat', 210, 200, 10, 100, 'Cat food', '../uploads/inventory/1710260210.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-12 16:16:50', '2024-03-12 16:16:50', NULL),
(37, 'Powercat Kitten', 265, 250, 15, 100, 'Cat food', '../uploads/inventory/1710260352.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-12 16:19:12', '2024-03-12 16:19:12', NULL),
(38, '4in1', 145, 130, 15, 100, 'Vaccine', '../uploads/inventory/1710260855.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-12 16:27:35', '2024-03-12 16:27:35', NULL),
(39, 'Rabies Vaccine', 110, 100, 10, 100, 'Vaccine', '../uploads/inventory/1710261017.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-12 16:30:17', '2024-03-12 16:30:17', NULL),
(40, 'FVRCP Vaccine for cats', 132, 120, 12, 100, 'Vaccine', '../uploads/inventory/1710261481.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-12 16:38:01', '2024-03-12 16:38:01', NULL),
(41, 'FeLV Vaccine for Cats', 110, 100, 10, 100, 'Vaccine', '../uploads/inventory/1710261592.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-12 16:39:52', '2024-03-12 16:39:52', NULL),
(42, 'Spectra Vaccine', 270, 250, 20, 100, 'Vaccine', '../uploads/inventory/1710261674.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-12 16:41:14', '2024-03-12 16:41:14', NULL),
(43, 'Kenel Cough', 160, 150, 10, 100, 'Vaccine', '../uploads/inventory/1710262008.jpg', '2024-03-13', '2025-03-13', NULL, '2024-03-12 16:46:48', '2024-03-12 16:46:48', NULL),
(44, 'D-Glucose', 110, 100, 10, 100, 'Medicine', '../uploads/inventory/1710952682.jpg', '2024-03-21', '2025-03-21', NULL, '2024-03-20 16:38:02', '2024-03-20 16:38:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log_inventory`
--

CREATE TABLE `tbl_log_inventory` (
  `logs_id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_type` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_log_inventory`
--

INSERT INTO `tbl_log_inventory` (`logs_id`, `name`, `log_date`, `log_type`) VALUES
(1, 'Pedigree', '2024-02-14 11:04:04', 'Added'),
(2, 'Pedigree', '2024-02-14 11:20:12', 'Updated'),
(3, 'Pedigree', '2024-02-17 17:35:46', 'Updated'),
(4, 'Royal Canin Bengal', '2024-02-25 14:14:56', 'Added'),
(5, 'Special Cat Chicken & Turkey', '2024-03-03 13:35:32', 'Added'),
(6, 'Royal Canin Bengal', '2024-03-04 06:49:22', 'Added'),
(7, 'Adult Instinctive', '2024-03-10 14:30:49', 'Added'),
(8, 'Royal Canin Short Hair', '2024-03-10 14:38:31', 'Added'),
(9, 'Royal Canin Hairball Boules de Poils', '2024-03-10 14:41:40', 'Added'),
(10, 'Royal Canin Indoor Interieur ', '2024-03-10 14:44:41', 'Added'),
(11, 'Royal Digestive Destif', '2024-03-10 14:50:33', 'Added'),
(12, 'Pedigree', '2024-03-11 08:55:30', 'Added'),
(13, 'Special Cat Chicken & Turkey', '2024-03-11 12:36:40', 'Added'),
(14, 'Poodle Food', '2024-03-11 14:13:18', 'Added'),
(15, 'Puppy Chiot Royal Canin', '2024-03-11 14:16:33', 'Added'),
(16, 'Royal Canin Bulldog', '2024-03-11 14:37:05', 'Added'),
(17, 'Royal Canin Chihuahua', '2024-03-11 15:00:51', 'Added'),
(18, 'Puppy Chiot Food', '2024-03-11 15:02:30', 'Added'),
(19, 'Madre de cacao', '2024-03-11 15:58:34', 'Added'),
(20, 'Fur magic Dog shampoo', '2024-03-11 16:19:43', 'Added'),
(21, 'Groom & Bloom', '2024-03-11 16:29:42', 'Added'),
(22, 'Premium Organic Cat Shampoo', '2024-03-11 16:38:10', 'Added'),
(23, 'Royal Tail Shampoo', '2024-03-11 16:47:49', 'Added'),
(24, 'Mixidine', '2024-03-11 16:51:45', 'Added'),
(25, '0.3ml Insulin Syringe', '2024-03-11 16:59:47', 'Added'),
(26, '0.5ml Syringe', '2024-03-11 17:04:58', 'Added'),
(27, 'Benadryl', '2024-03-12 14:51:25', 'Added'),
(28, 'Carprofen ', '2024-03-12 14:54:26', 'Added'),
(29, 'Doxeprime', '2024-03-12 14:55:54', 'Added'),
(30, 'Doxycyline', '2024-03-12 15:01:35', 'Added'),
(31, 'Dymetrazole', '2024-03-12 15:04:37', 'Added'),
(32, 'Induzepam', '2024-03-12 15:05:35', 'Added'),
(33, 'Ketoconazole', '2024-03-12 15:09:13', 'Added'),
(34, 'OTC_Medication', '2024-03-12 15:14:33', 'Added'),
(35, 'Pepcid ', '2024-03-12 15:16:35', 'Added'),
(36, 'Pepto Bismol', '2024-03-12 15:17:40', 'Added'),
(37, 'Rabvac', '2024-03-12 15:19:31', 'Added'),
(38, 'Powercat', '2024-03-12 16:16:50', 'Added'),
(39, 'Powercat Kitten', '2024-03-12 16:19:12', 'Added'),
(40, '4in1', '2024-03-12 16:27:35', 'Added'),
(41, 'Rabies Vaccine', '2024-03-12 16:30:17', 'Added'),
(42, 'FVRCP Vaccine for cats', '2024-03-12 16:38:01', 'Added'),
(43, 'FeLV Vaccine for Cats', '2024-03-12 16:39:52', 'Added'),
(44, 'Spectra Vaccine', '2024-03-12 16:41:14', 'Added'),
(45, 'Kenel Cough', '2024-03-12 16:46:48', 'Added'),
(46, 'D-Glucose', '2024-03-20 16:38:02', 'Added'),
(47, 'Pedigree', '2024-03-20 16:41:16', 'Added Stocks'),
(48, 'Royal Canin Bengal', '2024-03-20 16:41:45', 'Added Stocks');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log_services`
--

CREATE TABLE `tbl_log_services` (
  `log_serv_id` int NOT NULL,
  `customer_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `customer_contact` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `service_availed` text COLLATE utf8mb4_general_ci NOT NULL,
  `log_type` text COLLATE utf8mb4_general_ci NOT NULL,
  `staff_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_log_services`
--

INSERT INTO `tbl_log_services` (`log_serv_id`, `customer_name`, `customer_contact`, `customer_address`, `service_availed`, `log_type`, `staff_name`, `log_date`) VALUES
(1, 'Katherine', '09123456789', 'Iram', 'Treatment', 'Added', 'Gregg Sumalbag', '2024-02-14 11:13:29'),
(2, 'Blessie L. Gabales', '09123456789', 'Iram', 'Treatment', 'Added', 'Gregg Sumalbag', '2024-02-17 17:34:58'),
(3, 'Irene', '09467821303', 'Oc', 'Surgery', 'Added', 'Gregg Sumalbag', '2024-02-17 17:38:37'),
(4, 'Ely', '09126547891', 'Oc', 'Treatment', 'Added', 'Gregg Sumalbag', '2024-02-25 14:59:25'),
(5, 'Blessie Gables', '9123456791', 'Old Cabalan Olongapo', 'Treatment', 'Added', 'Gregg Sumalbag', '2024-03-03 13:30:54'),
(6, 'Lynn', '09785463215', 'Mabayuan', 'Consultation', 'Added', 'Gregg Sumalbag', '2024-03-05 11:51:30'),
(7, 'Alexander Smith', '09672355162', '123 Magsaysay Drive, Barangay West Bajac-bajac, Olongapo City', 'Consultation', 'Added', 'Gregg Sumalbag', '2024-03-11 13:45:43'),
(8, 'Sophia Johnson', '09367821153', '456 Rizal Avenue Extension, Barangay East Tapinac, Olongapo City', 'Vaccination', 'Added', 'Gregg Sumalbag', '2024-03-11 13:53:30'),
(9, 'Ethan Williams', '09756984332', '789 Dewey Avenue, Barangay Gordon Heights, Olongapo City', 'Deworming', 'Added', 'Gregg Sumalbag', '2024-03-11 13:54:08'),
(10, 'Isabella Brown', '09476325121', '101 Quezon Avenue, Barangay New Asinan, Olongapo City', 'HeartWorm', 'Added', 'Gregg Sumalbag', '2024-03-11 13:54:47'),
(11, 'Liam Davis', '09471156332', '234 Otero Avenue, Barangay New Cabalan, Olongapo City', 'Laboratory', 'Added', 'Gregg Sumalbag', '2024-03-11 13:55:46'),
(12, 'Olivia Martinez', '09362514921', '567 National Highway, Barangay Barretto, Olongapo City', 'Confinement', 'Added', 'Gregg Sumalbag', '2024-03-11 13:56:46'),
(13, 'William Garcia', '09275015534', '890 Sampson Road, Barangay Kalaklan, Olongapo City', 'Diagnostic', 'Added', 'Gregg Sumalbag', '2024-03-11 13:57:29'),
(14, 'Mia Rodriguez', '09221453687', '112 Burgos Street, Barangay Pag-asa, Olongapo City', 'Grooming', 'Added', 'Gregg Sumalbag', '2024-03-11 13:58:44'),
(15, 'Ethan Rodriguez', '09568821443', '345 M. Dela Cruz Street, Barangay Mabayuan, Olongapo City', 'Blood Chemistry Test', 'Added', 'Gregg Sumalbag', '2024-03-12 14:35:07'),
(16, 'Amelia Hernandez', '09231564894', '678 Perez Street, Barangay Santa Rita, Olongapo City', 'Cesarian Section Surgery', 'Added', 'Gregg Sumalbag', '2024-03-12 14:39:36'),
(17, 'Dann Andrei Mallari', '09123466789', '678 Perez Street, Barangay Santa Rita, Olongapo City', 'Treatment', 'Added', 'Gregg Sumalbag', '2024-03-13 12:19:03'),
(18, 'Blessie Libron', '09770275219', 'Old Cabalan Olongapo City', 'Treatment', 'Added', 'Gregg Sumalbag', '2024-03-20 16:36:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet`
--

CREATE TABLE `tbl_pet` (
  `pet_id` int NOT NULL,
  `pet_owner_id` text COLLATE utf8mb4_general_ci NOT NULL,
  `pet_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `pet_type` text COLLATE utf8mb4_general_ci NOT NULL,
  `breed` text COLLATE utf8mb4_general_ci NOT NULL,
  `bdate` date DEFAULT NULL,
  `sex` text COLLATE utf8mb4_general_ci NOT NULL,
  `pet_picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet`
--

INSERT INTO `tbl_pet` (`pet_id`, `pet_owner_id`, `pet_name`, `pet_type`, `breed`, `bdate`, `sex`, `pet_picture`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, '1', 'Corgi', 'Dog', 'Corgi', '2021-09-01', 'Female', 'uploads/pets/1704698481.jpg', '2024-01-08 07:21:21', '2024-01-08 07:21:21', NULL),
(2, '2', 'Grey', 'Cat', 'Persian', '2020-06-10', 'Male', 'uploads/pets/1704699754.jpg', '2024-01-08 07:42:34', '2024-01-08 07:42:34', NULL),
(3, '1', 'Grey', 'Dog', 'Siberian husky', '2024-01-12', 'Male', 'uploads/pets/1705038815.jpg', '2024-01-12 05:53:35', '2024-01-12 05:53:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `serv_id` int NOT NULL,
  `customer_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `customer_contact` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `service_availed` text COLLATE utf8mb4_general_ci NOT NULL,
  `staff_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`serv_id`, `customer_name`, `customer_contact`, `customer_address`, `service_availed`, `staff_name`, `created_at`, `deleted_at`) VALUES
(1, 'Katherine', '09123456789', 'Iram', 'Treatment', 'Gregg Sumalbag', '2024-02-14 11:13:29', NULL),
(2, 'Blessie L. Gabales', '09123456789', 'Iram', 'Treatment', 'Gregg Sumalbag', '2024-02-17 17:34:58', NULL),
(3, 'Irene', '09467821303', 'Oc', 'Surgery', 'Gregg Sumalbag', '2024-02-17 17:38:37', NULL),
(4, 'Ely', '09126547891', 'Oc', 'Treatment', 'Gregg Sumalbag', '2024-02-25 14:59:25', NULL),
(5, 'Blessie Gables', '9123456791', 'Old Cabalan Olongapo', 'Treatment', 'Gregg Sumalbag', '2024-03-03 13:30:54', NULL),
(6, 'Lynn', '09785463215', 'Mabayuan', 'Consultation', 'Gregg Sumalbag', '2024-03-05 11:51:30', NULL),
(7, 'Alexander Smith', '09672355162', '123 Magsaysay Drive, Barangay West Bajac-bajac, Olongapo City', 'Consultation', 'Gregg Sumalbag', '2024-03-11 13:45:43', NULL),
(8, 'Sophia Johnson', '09367821153', '456 Rizal Avenue Extension, Barangay East Tapinac, Olongapo City', 'Vaccination', 'Gregg Sumalbag', '2024-03-11 13:53:30', NULL),
(9, 'Ethan Williams', '09756984332', '789 Dewey Avenue, Barangay Gordon Heights, Olongapo City', 'Deworming', 'Gregg Sumalbag', '2024-03-11 13:54:08', NULL),
(10, 'Isabella Brown', '09476325121', '101 Quezon Avenue, Barangay New Asinan, Olongapo City', 'HeartWorm', 'Gregg Sumalbag', '2024-03-11 13:54:47', NULL),
(11, 'Liam Davis', '09471156332', '234 Otero Avenue, Barangay New Cabalan, Olongapo City', 'Laboratory', 'Gregg Sumalbag', '2024-03-11 13:55:46', NULL),
(12, 'Olivia Martinez', '09362514921', '567 National Highway, Barangay Barretto, Olongapo City', 'Confinement', 'Gregg Sumalbag', '2024-03-11 13:56:46', NULL),
(13, 'William Garcia', '09275015534', '890 Sampson Road, Barangay Kalaklan, Olongapo City', 'Diagnostic', 'Gregg Sumalbag', '2024-03-11 13:57:29', NULL),
(14, 'Mia Rodriguez', '09221453687', '112 Burgos Street, Barangay Pag-asa, Olongapo City', 'Grooming', 'Gregg Sumalbag', '2024-03-11 13:58:44', NULL),
(15, 'Ethan Rodriguez', '09568821443', '345 M. Dela Cruz Street, Barangay Mabayuan, Olongapo City', 'Blood Chemistry Test', 'Gregg Sumalbag', '2024-03-12 14:35:07', NULL),
(16, 'Amelia Hernandez', '09231564894', '678 Perez Street, Barangay Santa Rita, Olongapo City', 'Cesarian Section Surgery', 'Gregg Sumalbag', '2024-03-12 14:39:36', NULL),
(17, 'Dann Andrei Mallari', '09123466789', '678 Perez Street, Barangay Santa Rita, Olongapo City', 'Treatment', 'Gregg Sumalbag', '2024-03-13 12:19:03', NULL),
(18, 'Blessie Libron', '09770275219', 'Old Cabalan Olongapo City', 'Treatment', 'Gregg Sumalbag', '2024-03-20 16:36:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_treatment`
--

CREATE TABLE `tbl_treatment` (
  `id_treatment` int NOT NULL,
  `serv_id` int NOT NULL,
  `treatment_name` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_treatment`
--

INSERT INTO `tbl_treatment` (`id_treatment`, `serv_id`, `treatment_name`) VALUES
(1, 1, 'Treatment: Surgical'),
(2, 2, 'Treatment: Surgical'),
(3, 4, 'Treatment: Disease Management'),
(4, 5, 'Treatment: Disease Management'),
(5, 17, 'Treatment: Surgical'),
(6, 18, 'Treatment: Surgical');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int NOT NULL,
  `customer_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `customer_contact` text COLLATE utf8mb4_general_ci NOT NULL,
  `customer_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staff_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `deleted_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `customer_name`, `customer_contact`, `customer_address`, `staff_name`, `created_at`, `deleted_at`) VALUES
(1, 'Blessie Gabales', '09123456789', 'Sample Address', 'Gregg Sumalbag', '2024-04-08 14:21:01', NULL),
(2, 'Katherine Rose', '09123456789', 'Sample Address', 'Gregg Sumalbag', '2024-04-08 14:21:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vaccination`
--

CREATE TABLE `tbl_vaccination` (
  `vac_id` int NOT NULL,
  `pet_owner_id` text COLLATE utf8mb4_general_ci NOT NULL,
  `pet_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `vac_used` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vac_condition` text COLLATE utf8mb4_general_ci NOT NULL,
  `vac_next` datetime DEFAULT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vaccination`
--

INSERT INTO `tbl_vaccination` (`vac_id`, `pet_owner_id`, `pet_id`, `vac_used`, `vac_condition`, `vac_next`, `is_done`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, '2', '2', 'Clonazepam', 'FeLV', '2024-02-08 15:00:00', 0, '2024-01-08 07:46:38', '2024-01-08 07:46:38', NULL),
(2, '1', '1', 'Clonazepam', 'Ear Infection', '2024-02-14 10:00:00', 0, '2024-01-08 13:45:44', '2024-01-08 13:45:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `visit_id` int NOT NULL,
  `ip_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `visit_date` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`visit_id`, `ip_address`, `visit_date`) VALUES
(1, '122.52.91.148', '2024-03-29 13:11:54'),
(2, '143.44.145.29', '2024-03-29 13:14:12'),
(3, '143.44.145.11', '2024-03-29 13:45:45'),
(4, '143.44.145.11', '2024-03-29 13:53:28'),
(5, '223.25.57.252', '2024-03-29 13:59:41'),
(6, '143.44.145.199', '2024-03-29 14:00:59'),
(7, '223.25.57.252', '2024-03-29 14:02:21'),
(8, '2001:4451:126b:7200:191d:db05:a267:bb81', '2024-03-29 14:04:12'),
(9, '112.206.242.36', '2024-03-29 14:04:28'),
(10, '223.25.57.252', '2024-03-29 14:04:57'),
(11, '143.44.145.29', '2024-03-29 14:06:46'),
(12, '143.44.144.1', '2024-03-29 14:08:05'),
(13, '223.25.58.251', '2024-03-29 14:09:12'),
(14, '110.54.151.213', '2024-03-29 14:12:25'),
(15, '143.44.224.48', '2024-03-29 14:13:06'),
(16, '143.44.145.11', '2024-03-29 14:16:03'),
(17, '143.44.224.31', '2024-03-29 14:17:08'),
(18, '2001:4451:12ee:f800:d0ac:fb3:fb74:2d08', '2024-03-29 14:17:32'),
(19, '143.44.224.38', '2024-03-29 14:19:50'),
(20, '143.44.145.136', '2024-03-29 14:22:24'),
(21, '223.25.58.132', '2024-03-29 14:25:13'),
(22, '143.44.224.24', '2024-03-29 14:25:19'),
(23, '223.25.57.21', '2024-03-29 14:28:16'),
(24, '143.44.145.29', '2024-03-29 14:28:34'),
(25, '2001:4452:5d1:2c00:bc34:6201:edbe:18e3', '2024-03-29 14:29:45'),
(26, '122.52.80.25', '2024-03-29 14:31:59'),
(27, '203.118.245.36', '2024-03-29 14:32:50'),
(28, '223.25.58.132', '2024-03-29 14:41:10'),
(29, '175.176.12.55', '2024-03-29 14:41:12'),
(30, '223.25.58.74', '2024-03-29 14:41:43'),
(31, '136.158.123.254', '2024-03-29 14:41:43'),
(32, '158.62.10.107', '2024-03-29 14:42:19'),
(33, '2001:4451:1201:d00:8575:5069:f726:9367', '2024-03-29 14:42:27'),
(34, '143.44.225.77', '2024-03-29 14:42:43'),
(35, '175.176.12.55', '2024-03-29 14:44:05'),
(36, '61.245.9.165', '2024-03-29 14:45:05'),
(37, '223.25.59.246', '2024-03-29 14:45:45'),
(38, '2001:4451:1245:7c00:4828:f991:f5f:9f3', '2024-03-29 14:46:08'),
(39, '120.28.218.10', '2024-03-29 14:47:17'),
(40, '2001:4452:5e7:9200:24e9:26e9:4d91:355d', '2024-03-29 14:51:45'),
(41, '2001:4451:1201:d00:fd0b:cc33:d268:4a7', '2024-03-29 14:53:26'),
(42, '143.44.224.48', '2024-03-29 14:56:20'),
(43, '2001:4451:1201:d00:fd0b:cc33:d268:4a7', '2024-03-29 14:58:31'),
(44, '110.54.152.102', '2024-03-29 15:00:06'),
(45, '143.44.145.11', '2024-03-29 15:01:47'),
(46, '2001:4452:51e:7100:9:cbf7:2b7f:8215', '2024-03-29 15:02:27'),
(47, '143.44.145.67', '2024-03-29 15:02:58'),
(48, '223.25.59.59', '2024-03-29 15:03:06'),
(49, '2001:4451:12ef:4600:616a:cf5e:9b5f:479f', '2024-03-29 15:03:56'),
(50, '143.44.145.25', '2024-03-29 15:04:03'),
(51, '175.176.13.141', '2024-03-29 15:04:21'),
(52, '143.44.224.36', '2024-03-29 15:04:48'),
(53, '2001:4451:1256:6900:77:e4ad:b2e4:561e', '2024-03-29 15:05:28'),
(54, '2001:4451:2cf:8a00:3865:1bc0:b4b9:48d1', '2024-03-29 15:05:33'),
(55, '175.176.8.10', '2024-03-29 15:07:10'),
(56, '223.25.58.123', '2024-03-29 15:08:12'),
(57, '112.198.113.140', '2024-03-29 15:08:19'),
(58, '175.176.93.105', '2024-03-29 15:08:21'),
(59, '223.25.58.218', '2024-03-29 15:09:01'),
(60, '223.25.58.179', '2024-03-29 15:09:09'),
(61, '64.224.125.82', '2024-03-29 15:12:31'),
(62, '143.44.145.43', '2024-03-29 15:13:28'),
(63, '143.44.145.77', '2024-03-29 15:17:00'),
(64, '203.118.245.37', '2024-03-29 15:17:14'),
(65, '223.25.59.160', '2024-03-29 15:21:45'),
(66, '2001:4451:1245:e300:21a6:362a:df09:af24', '2024-03-29 15:24:51'),
(67, '143.44.145.11', '2024-03-29 15:28:29'),
(68, '143.44.224.15', '2024-03-29 15:51:35'),
(69, '2001:fd8:1f30:6d16:11c8:dbee:c3b6:4bb3', '2024-03-29 15:57:19'),
(70, '143.44.145.144', '2024-03-29 16:35:18'),
(71, '143.44.145.144', '2024-03-29 16:35:44'),
(72, '143.44.145.11', '2024-03-29 17:51:38'),
(73, '143.44.145.77', '2024-03-29 18:35:45'),
(74, '143.44.145.11', '2024-03-29 18:53:39'),
(75, '124.104.118.124', '2024-03-29 19:54:21'),
(76, '159.196.132.82', '2024-03-29 20:54:20'),
(77, '139.135.65.183', '2024-03-29 20:55:28'),
(78, '136.158.42.50', '2024-03-29 20:55:35'),
(79, '119.95.105.42', '2024-03-29 23:11:51'),
(80, '180.191.52.164', '2024-03-29 23:12:19'),
(81, '143.44.224.62', '2024-03-29 23:31:22'),
(82, '143.44.145.11', '2024-03-30 00:36:14'),
(83, '143.44.144.252', '2024-03-30 01:12:20'),
(84, '2001:4451:1245:7c00:58f9:30a7:360e:d1fe', '2024-03-30 01:33:54'),
(85, '143.44.145.11', '2024-03-30 01:35:43'),
(86, '143.44.224.37', '2024-03-30 01:46:12'),
(87, '143.44.224.62', '2024-03-30 01:55:59'),
(88, '2001:fd8:485:8983:3cc1:212e:c7b:171d', '2024-03-30 02:17:25'),
(89, '143.44.145.11', '2024-03-30 02:18:30'),
(90, '143.44.145.26', '2024-03-30 02:42:38'),
(91, '223.25.59.38', '2024-03-30 03:41:15'),
(92, '2001:4451:1201:d00:f4fe:e2f7:6286:5384', '2024-03-30 04:16:04'),
(93, '223.25.59.135', '2024-03-30 04:43:01'),
(94, '143.44.145.11', '2024-03-30 06:08:36'),
(95, '143.44.144.11', '2024-03-30 06:19:36'),
(96, '2001:4451:255:300:4de0:1bdd:940b:e853', '2024-03-30 06:20:03'),
(97, '143.44.145.11', '2024-03-30 08:06:20'),
(98, '143.44.145.11', '2024-03-30 09:53:56'),
(99, '143.44.145.11', '2024-03-30 11:19:08'),
(100, '143.44.145.11', '2024-03-30 16:04:37'),
(101, '143.44.145.11', '2024-03-30 20:04:55'),
(102, '2001:4451:11ea:3a00:8527:6480:3cec:4051', '2024-03-30 23:34:42'),
(103, '143.44.145.11', '2024-03-31 05:45:37'),
(104, '143.44.145.11', '2024-03-31 13:17:55'),
(105, '2001:4451:1201:d00:41e:46f7:17fc:ea13', '2024-03-31 14:08:00'),
(106, '143.44.145.11', '2024-03-31 15:33:18'),
(107, '143.44.144.0', '2024-03-31 17:45:34'),
(108, '2001:4451:12d9:7700:2da4:e62d:31ec:a4a3', '2024-04-01 07:48:13'),
(109, '143.44.145.11', '2024-04-01 12:57:15'),
(110, '2a03:2880:ff:70::face:b00c', '2024-04-01 12:58:33'),
(111, '143.44.145.11', '2024-04-01 13:55:13'),
(112, '124.217.91.7', '2024-04-01 14:50:51'),
(113, '124.217.91.7', '2024-04-01 14:51:04'),
(114, '45.124.58.5', '2024-04-01 14:51:21'),
(115, '124.217.91.7', '2024-04-01 14:54:56'),
(116, '124.217.91.7', '2024-04-01 14:58:32'),
(117, '124.217.91.7', '2024-04-01 15:00:52'),
(118, '112.209.20.255', '2024-04-01 15:11:57'),
(119, '143.44.144.218', '2024-04-01 15:16:18'),
(120, '143.44.145.32', '2024-04-01 15:16:19'),
(121, '143.44.145.216', '2024-04-01 15:17:20'),
(122, '143.44.145.11', '2024-04-01 15:23:54'),
(123, '143.44.145.11', '2024-04-01 15:47:04'),
(124, '143.44.145.11', '2024-04-01 15:54:26'),
(125, '143.44.145.11', '2024-04-01 16:35:35'),
(126, '124.217.91.7', '2024-04-01 16:41:53'),
(127, '143.44.145.11', '2024-04-01 17:31:07'),
(128, '2001:4451:12af:4b00:f8a3:e775:1df2:3ceb', '2024-04-01 21:50:11'),
(129, '143.44.145.45', '2024-04-02 00:35:24'),
(130, '143.44.145.11', '2024-04-02 01:13:40'),
(131, '143.44.145.11', '2024-04-02 04:01:04'),
(132, '124.106.157.147', '2024-04-03 02:34:28'),
(133, '143.44.145.11', '2024-04-03 05:36:48'),
(134, '2a03:2880:21ff:c::face:b00c', '2024-04-03 05:36:53'),
(135, '2001:4451:12e8:4100:b15d:1dd5:ebe5:49dd', '2024-04-03 10:49:55'),
(136, '143.44.145.11', '2024-04-04 03:33:30'),
(137, '31.13.115.8', '2024-04-04 11:23:54'),
(138, '2001:4451:1201:d00:9077:7d09:78a1:98e3', '2024-04-04 14:04:14'),
(139, '223.25.59.19', '2024-04-04 14:07:06'),
(140, '223.25.59.93', '2024-04-04 14:46:05'),
(141, '143.44.145.11', '2024-04-04 14:51:39'),
(142, '2001:4452:581:fb00:7962:1631:95bf:437', '2024-04-04 15:24:14'),
(143, '143.44.145.11', '2024-04-04 15:34:01'),
(144, '143.44.145.11', '2024-04-04 18:01:50'),
(145, '112.198.128.175', '2024-04-04 21:12:36'),
(146, '175.176.11.176', '2024-04-05 07:05:03'),
(147, '143.44.145.11', '2024-04-05 16:35:38'),
(148, '136.158.79.85', '2024-04-06 03:29:12'),
(149, '143.44.145.11', '2024-04-06 08:34:58'),
(150, '143.44.145.11', '2024-04-06 09:00:16'),
(151, '143.44.145.11', '2024-04-06 09:09:58'),
(152, '119.94.170.64', '2024-04-06 11:44:10'),
(153, '143.44.145.11', '2024-04-06 11:55:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `tbl_log_inventory`
--
ALTER TABLE `tbl_log_inventory`
  ADD PRIMARY KEY (`logs_id`);

--
-- Indexes for table `tbl_log_services`
--
ALTER TABLE `tbl_log_services`
  ADD PRIMARY KEY (`log_serv_id`);

--
-- Indexes for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`serv_id`);

--
-- Indexes for table `tbl_treatment`
--
ALTER TABLE `tbl_treatment`
  ADD PRIMARY KEY (`id_treatment`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tbl_vaccination`
--
ALTER TABLE `tbl_vaccination`
  ADD PRIMARY KEY (`vac_id`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`visit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `prod_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  MODIFY `inv_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_log_inventory`
--
ALTER TABLE `tbl_log_inventory`
  MODIFY `logs_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_log_services`
--
ALTER TABLE `tbl_log_services`
  MODIFY `log_serv_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  MODIFY `pet_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `serv_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_treatment`
--
ALTER TABLE `tbl_treatment`
  MODIFY `id_treatment` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_vaccination`
--
ALTER TABLE `tbl_vaccination`
  MODIFY `vac_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visit`
--
ALTER TABLE `visit`
  MODIFY `visit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
