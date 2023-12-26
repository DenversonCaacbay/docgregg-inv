-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2023 at 05:53 AM
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
-- Database: `dgvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `email`, `password`, `lname`, `fname`, `mi`, `role`) VALUES
(2, 'admin1@gmail.com', '$2y$12$ViiL6Wq2tezmsJ8aFSjUrufLSs55x4Ligv0jbsNq.OOCWF2aYBfdK', 'Turqueza', 'Charlene', 'G.', 'administrator'),
(3, 'admin@gmail.com', '$2y$12$ViiL6Wq2tezmsJ8aFSjUrufLSs55x4Ligv0jbsNq.OOCWF2aYBfdK', 'Duarte', 'Dan Emmanuel', 'U.', 'administrator'),
(17, 'email@email.com', '$2y$10$FQAdtVubpwdKp7DKddReNuVfLqxDs/QZxQrVHyFPVk8xYwAxvuKVi', 'Branwen', 'Qrow', 'D.', 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `inv_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`inv_id`, `name`, `price`, `quantity`, `picture`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, 'Sample1', 100, 100, NULL, '2023-12-26 00:00:00', '2023-12-26 00:00:00', NULL),
(2, 'Sample2', 100, 100, NULL, '2023-12-26 00:00:00', '2023-12-26 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet`
--

CREATE TABLE `tbl_pet` (
  `pet_id` int(11) NOT NULL,
  `pet_owner` text NOT NULL,
  `pet_name` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet`
--

INSERT INTO `tbl_pet` (`pet_id`, `pet_owner`, `pet_name`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, 'denverkunfalcon@gmail.com', 'bruno', '2023-12-22 17:59:00', '2023-12-22 17:59:00', NULL),
(2, 'berma@gmail.com', 'pochi', '2023-12-24 17:59:00', '2023-12-24 17:59:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `picture` mediumblob DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `picture`, `email`, `password`, `lname`, `fname`, `mi`, `sex`, `address`, `contact`, `birthdate`, `nationality`, `created_at`, `deleted_at`) VALUES
(3, NULL, 'denverkunfalcon@gmail.com', '$2y$10$sHDsCsXfyTce0mzSdvwHVuWvE5Mc2xQhBfMg.Eq1pcsnNU/lRCyzW', 'Caacbay', 'Denverson', 'Falcon', 'Male', 'address', '09496329271', '2000-06-09', 'Filipino', '2023-12-21 17:54:14', NULL),
(4, NULL, 'berma@gmail.com', '$2y$10$gTYLGKas1hBGWCvvuAuLvOTmz1e7msLpDoBrt7oyvTnbGKNvB8KGe', 'Caacbay', 'Berma', 'Falcon', 'Female', 'some address', '09193101414', '1968-09-22', 'Filipino', '2023-12-24 17:54:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vaccine_record`
--

CREATE TABLE `tbl_vaccine_record` (
  `vac_id` int(11) NOT NULL,
  `pet_owner` text NOT NULL,
  `pet_name` text NOT NULL,
  `vaccine_name` text NOT NULL,
  `date_vaccinated` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vaccine_record`
--

INSERT INTO `tbl_vaccine_record` (`vac_id`, `pet_owner`, `pet_name`, `vaccine_name`, `date_vaccinated`, `created_at`, `deleted_at`) VALUES
(1, 'denverkunfalcon@gmail.com', 'bruno', 'Rabbies', '2023-12-26', '2023-12-16 17:55:37', NULL),
(2, 'berma@gmail.com', 'pochi', 'Distemper', '2023-12-24', '2023-12-24 17:55:41', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tbl_vaccine_record`
--
ALTER TABLE `tbl_vaccine_record`
  ADD PRIMARY KEY (`vac_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_vaccine_record`
--
ALTER TABLE `tbl_vaccine_record`
  MODIFY `vac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
