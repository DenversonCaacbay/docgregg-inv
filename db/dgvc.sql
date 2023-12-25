-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2023 at 05:23 PM
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
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `inv_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`inv_id`, `name`, `price`, `quantity`, `date_created`, `date_updated`) VALUES
(1, 'Sample1', 100, 100, '2023-12-26', '0000-00-00'),
(2, 'Sample2', 100, 100, '2023-12-26', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet`
--

CREATE TABLE `tbl_pet` (
  `pet_id` int(11) NOT NULL,
  `pet_owner` text NOT NULL,
  `pet_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet`
--

INSERT INTO `tbl_pet` (`pet_id`, `pet_owner`, `pet_name`) VALUES
(1, 'denverkunfalcon@gmail.com', 'bruno'),
(2, 'berma@gmail.com', 'pochi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `res_photo` mediumblob DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `houseno` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `municipal` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `bdate` date NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `addedby` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `res_photo`, `email`, `password`, `lname`, `fname`, `mi`, `age`, `sex`, `houseno`, `street`, `brgy`, `municipal`, `address`, `contact`, `bdate`, `nationality`, `role`, `addedby`) VALUES
(3, NULL, 'denverkunfalcon@gmail.com', '$2y$10$sHDsCsXfyTce0mzSdvwHVuWvE5Mc2xQhBfMg.Eq1pcsnNU/lRCyzW', 'Caacbay', 'Denverson', 'Falcon', 23, 'Male', '123', 'National High Way', 'Matain', 'Subic', NULL, '09496329271', '2000-06-09', 'Filipino', 'resident', NULL),
(4, NULL, 'berma@gmail.com', '$2y$10$gTYLGKas1hBGWCvvuAuLvOTmz1e7msLpDoBrt7oyvTnbGKNvB8KGe', 'Caacbay', 'Berma', 'Falcon', 55, 'Female', '123', 'National High Way', 'Matain', 'Subic', NULL, '09193101414', '1968-09-22', 'Filipino', 'resident', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vaccine_record`
--

CREATE TABLE `tbl_vaccine_record` (
  `vac_id` int(11) NOT NULL,
  `pet_owner` text NOT NULL,
  `pet_name` text NOT NULL,
  `vaccine_name` text NOT NULL,
  `date_vaccinated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vaccine_record`
--

INSERT INTO `tbl_vaccine_record` (`vac_id`, `pet_owner`, `pet_name`, `vaccine_name`, `date_vaccinated`) VALUES
(1, 'denverkunfalcon@gmail.com', 'bruno', 'Rabbies', '2023-12-26'),
(2, 'berma@gmail.com', 'pochi', 'Distemper', '2023-12-24');

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
