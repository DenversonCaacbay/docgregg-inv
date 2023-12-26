-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 26, 2023 at 04:31 PM
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
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `email`, `password`, `lname`, `fname`, `mi`, `role`) VALUES
(1, 'admin@gmail.com', '$2y$12$ViiL6Wq2tezmsJ8aFSjUrufLSs55x4Ligv0jbsNq.OOCWF2aYBfdK', 'Admin', 'Super', 'A.', 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `inv_id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `quantity` int NOT NULL,
  `picture` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`inv_id`, `name`, `price`, `quantity`, `picture`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, 'Sample1', 100.5, 100, NULL, '2023-12-26 00:00:00', '2023-12-26 00:00:00', NULL),
(2, 'Sample2', 100, 100, NULL, '2023-12-26 00:00:00', '2023-12-26 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet`
--

CREATE TABLE `tbl_pet` (
  `pet_id` int NOT NULL,
  `pet_owner_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pet_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet`
--

INSERT INTO `tbl_pet` (`pet_id`, `pet_owner_id`, `pet_name`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, '3', 'bruno', '2023-12-22 17:59:00', '2023-12-22 17:59:00', NULL),
(2, '4', 'pochi', '2023-12-24 17:59:00', '2023-12-24 17:59:00', NULL),
(3, '3', 'test', '2023-12-26 16:28:12', '2023-12-26 16:28:12', '2023-12-26 16:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int NOT NULL,
  `picture` mediumblob,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `birthdate` date NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `picture`, `email`, `password`, `lname`, `fname`, `mi`, `sex`, `address`, `contact`, `birthdate`, `nationality`, `created_at`, `deleted_at`) VALUES
(3, NULL, 'johndoe@gmail.com', '$2y$10$.nASaAG8CytzlOl26..mO.7OpjUF.ieA3AuSJJkyBHnWSdAQ/5XAy', 'Doe', 'John', 'Smith', 'Male', 'address', '09496329271', '2000-06-09', 'Filipino', '2023-12-21 17:54:14', NULL),
(4, NULL, 'jack123@gmail.com', '$2y$10$.nASaAG8CytzlOl26..mO.7OpjUF.ieA3AuSJJkyBHnWSdAQ/5XAy', 'Brown', 'Jack', 'Lee', 'Female', 'some address', '09193101414', '1968-09-22', 'Filipino', '2023-12-24 17:54:23', NULL),
(5, NULL, 'email1@email.com', '$2y$10$.nASaAG8CytzlOl26..mO.7OpjUF.ieA3AuSJJkyBHnWSdAQ/5XAy', 'Santos', 'Juan', 'Gomez', 'Male', 'address', '09513165161', '2000-11-24', 'Filipino', '2023-12-26 15:24:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vaccine_record`
--

CREATE TABLE `tbl_vaccine_record` (
  `vac_id` int NOT NULL,
  `pet_id` int DEFAULT NULL,
  `vaccine_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_vaccinated` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vaccine_record`
--

INSERT INTO `tbl_vaccine_record` (`vac_id`, `pet_id`, `vaccine_name`, `date_vaccinated`, `created_at`, `deleted_at`) VALUES
(1, 1, 'Rabbies', '2023-12-26', '2023-12-16 17:55:37', NULL),
(2, 2, 'Distemper', '2023-12-24', '2023-12-24 17:55:41', NULL);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  MODIFY `inv_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  MODIFY `pet_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_vaccine_record`
--
ALTER TABLE `tbl_vaccine_record`
  MODIFY `vac_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
