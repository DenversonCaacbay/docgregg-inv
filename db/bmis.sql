-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 12, 2023 at 04:58 PM
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
-- Database: `bmis`
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
(2, 'admin1@gmail.com', '$2y$12$ViiL6Wq2tezmsJ8aFSjUrufLSs55x4Ligv0jbsNq.OOCWF2aYBfdK', 'Turqueza', 'Charlene', 'G.', 'administrator'),
(3, 'admin@gmail.com', '$2y$12$ViiL6Wq2tezmsJ8aFSjUrufLSs55x4Ligv0jbsNq.OOCWF2aYBfdK', 'Duarte', 'Dan Emmanuel', 'U.', 'administrator'),
(17, 'email@email.com', '$2y$10$FQAdtVubpwdKp7DKddReNuVfLqxDs/QZxQrVHyFPVk8xYwAxvuKVi', 'Branwen', 'Qrow', 'D.', 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcement`
--

CREATE TABLE `tbl_announcement` (
  `id_announcement` int NOT NULL,
  `event` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `addedby` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_announcement`
--

INSERT INTO `tbl_announcement` (`id_announcement`, `event`, `target`, `start_date`, `addedby`) VALUES
(9, 'Barangay Cleanup Alert!\r\n\r\n🗓️ Dec. 15, 2023 ⏰ 8:00AM 📍 Barangay Santa Rita\r\n\r\nLet\'s tidy up our barangay! Join us for a cleanup event. Contact 09762866176 for info.\r\n\r\nYour support matters!', NULL, '2023-11-24', 'Turqueza, Charlene');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blotter`
--

CREATE TABLE `tbl_blotter` (
  `id_blotter` int NOT NULL,
  `id_resident` int NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `houseno` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brgy` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `municipal` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `blot_photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '',
  `contact` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `narrative` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `timeapplied` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_blotter`
--

INSERT INTO `tbl_blotter` (`id_blotter`, `id_resident`, `lname`, `fname`, `mi`, `houseno`, `street`, `brgy`, `municipal`, `blot_photo`, `contact`, `narrative`, `timeapplied`, `deleted_at`) VALUES
(5, 35, 'Turqueza', 'Charlene', 'Gonzales', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', NULL, '2147483647', 'Yung boss ko, sinisigawan ako', '2023-11-24 15:35:13', NULL),
(6, 35, 'Turqueza', 'Charlene', 'Gonzales', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', NULL, '2147483647', 'Sample Report', '2023-11-24 18:10:39', NULL),
(7, 35, 'Turqueza', 'Charlene', 'Gonzales', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', NULL, '2147483647', 'Sample', '2023-11-24 19:24:17', NULL),
(13, 38, 'Turqueza', 'Charlene', 'G.', '10223', 'Jasmin', 'Santa Rita', 'Olongapo', 'uploads/blotter/1701594713.png', '09762866176', 'hello', '2023-11-29 22:36:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brgyid`
--

CREATE TABLE `tbl_brgyid` (
  `id_brgyid` int NOT NULL,
  `id_resident` int NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `houseno` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brgy` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `municipal` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bplace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bdate` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `res_photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inc_lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inc_fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inc_mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inc_contact` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inc_houseno` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inc_street` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inc_brgy` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_brgyid`
--

INSERT INTO `tbl_brgyid` (`id_brgyid`, `id_resident`, `lname`, `fname`, `mi`, `houseno`, `street`, `brgy`, `municipal`, `bplace`, `bdate`, `res_photo`, `inc_lname`, `inc_fname`, `inc_mi`, `inc_contact`, `inc_houseno`, `inc_street`, `inc_brgy`, `deleted_at`) VALUES
(1, 35, 'Turqueza', 'Charlene', 'Gonzales', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', 'Olongapo', '2001-07-31', NULL, 'Turqueza', 'Cynthia', 'Gonzales', '09995011381', 'Olongapo', 'Olongapo', '2001-07-31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bspermit`
--

CREATE TABLE `tbl_bspermit` (
  `id_bspermit` int NOT NULL,
  `id_resident` int NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bsname` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `houseno` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `street` varchar(252) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brgy` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `municipal` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bsindustry` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aoe` int NOT NULL,
  `bspermit_photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bspermit`
--

INSERT INTO `tbl_bspermit` (`id_bspermit`, `id_resident`, `lname`, `fname`, `mi`, `bsname`, `houseno`, `street`, `brgy`, `municipal`, `bsindustry`, `aoe`, `bspermit_photo`, `deleted_at`) VALUES
(3, 39, 'Turqueza', 'Charlene', 'Gonzales', 'ChaCafe', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', 'Food', 100, NULL, NULL),
(5, 39, 'Turqueza', 'Charlene', 'Gonzales', 'ChaCafe', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', 'Food', 100, NULL, '2023-11-27 15:12:45'),
(6, 44, 'Santos', 'Juan', 'D.', '111', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Electronics', 23, 'uploads/bspermit/1701591153.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance`
--

CREATE TABLE `tbl_clearance` (
  `id_clearance` int NOT NULL,
  `id_resident` int NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `houseno` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brgy` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `municipal` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brgyclearance_photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_clearance`
--

INSERT INTO `tbl_clearance` (`id_clearance`, `id_resident`, `lname`, `fname`, `mi`, `purpose`, `houseno`, `street`, `brgy`, `municipal`, `status`, `brgyclearance_photo`, `deleted_at`) VALUES
(2, 35, 'Turqueza', 'Charlene', 'Gonzales', 'Postal ID', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', 'Single', NULL, '2023-12-12 21:41:44'),
(4, 35, 'Turqueza', 'Charlene', 'Gonzales', 'Postal ID', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', 'Single', NULL, '2023-11-29 22:50:05'),
(5, 44, 'Santos', 'Juan', 'D.', 'school', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Single', NULL, NULL),
(6, 44, 'Santos', 'Juan', 'D.', 'Open a Bank Account', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Single', 'uploads/brgyclearance/1701591367.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_indigency`
--

CREATE TABLE `tbl_indigency` (
  `id_indigency` int NOT NULL,
  `id_resident` int NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `houseno` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brgy` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `municipal` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date` date NOT NULL,
  `certofindigency_photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_indigency`
--

INSERT INTO `tbl_indigency` (`id_indigency`, `id_resident`, `lname`, `fname`, `mi`, `nationality`, `houseno`, `street`, `brgy`, `municipal`, `purpose`, `date`, `certofindigency_photo`, `deleted_at`) VALUES
(3, 35, 'Turqueza', 'Charlene', 'G.', 'Filipino', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', 'Other important transactions.', '2023-02-11', NULL, NULL),
(9, 35, 'Turqueza', 'Charlene', 'G.', 'Filipino', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', 'Other important transactions.', '2023-02-11', NULL, '2023-11-27 14:50:39'),
(10, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Other important transactions.', '2023-12-04', NULL, NULL),
(11, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Job/Employment', '2023-12-05', NULL, NULL),
(12, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Financial Transaction', '2023-12-06', NULL, NULL),
(13, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Job/Employment', '2023-12-06', NULL, NULL),
(14, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Job/Employment', '2023-12-05', NULL, NULL),
(15, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'test', '2023-12-04', NULL, NULL),
(16, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Job/Employment', '2023-12-12', NULL, NULL),
(17, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '', '2023-12-25', NULL, NULL),
(18, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '', '2023-12-04', NULL, NULL),
(19, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '', '2023-12-12', NULL, NULL),
(20, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '', '2023-12-04', NULL, NULL),
(21, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '', '2023-12-13', NULL, NULL),
(22, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'a', '2023-12-27', NULL, NULL),
(23, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Job/Employment', '2023-12-05', NULL, '2023-12-03 17:01:13'),
(24, 44, 'Santos', 'Juan', 'D.', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', 'Job/Employment', '2023-12-04', 'uploads/certofindigency/1701591644.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rescert`
--

CREATE TABLE `tbl_rescert` (
  `id_rescert` int NOT NULL,
  `id_resident` int NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `age` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `houseno` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brgy` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `municipal` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `certofres_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rescert`
--

INSERT INTO `tbl_rescert` (`id_rescert`, `id_resident`, `lname`, `fname`, `mi`, `age`, `nationality`, `houseno`, `street`, `brgy`, `municipal`, `date`, `purpose`, `certofres_photo`, `deleted_at`) VALUES
(111112, 35, 'Turqueza', 'Charlene', 'Gonzales', '22', 'Filipino', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', '2001-07-31', 'Job/Employment', NULL, NULL),
(111115, 35, 'Turqueza', 'Charlene', 'Gonzales', '22', 'Filipino', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', '2001-07-31', 'Job/Employment', NULL, '2023-11-27 15:13:27'),
(111116, 44, 'Santos', 'Juan', 'D.', '23', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '2023-12-04', 'sadsad', NULL, NULL),
(111117, 44, 'Santos', 'Juan', 'D.', '23', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '2023-12-04', 'hehe', NULL, NULL),
(111118, 44, 'Santos', 'Juan', 'D.', '23', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '2023-12-04', 'Business Establishment', NULL, NULL),
(111119, 44, 'Santos', 'Juan', 'D.', '23', 'Filipino', '2075th', 'Narra Lane', 'old cabalan', 'olongapo', '2023-12-04', 'Business Establishment', 'uploads/certofres/1701590796.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resident`
--

CREATE TABLE `tbl_resident` (
  `id_resident` int NOT NULL,
  `res_photo` mediumblob,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `houseno` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brgy` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `municipal` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bdate` date NOT NULL,
  `bplace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `family_role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `voter` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `addedby` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_resident`
--

INSERT INTO `tbl_resident` (`id_resident`, `res_photo`, `email`, `password`, `lname`, `fname`, `mi`, `age`, `sex`, `status`, `houseno`, `street`, `brgy`, `municipal`, `address`, `contact`, `bdate`, `bplace`, `nationality`, `family_role`, `voter`, `role`, `addedby`) VALUES
(35, NULL, 'charleneturqueza31@gmail.com', 'password123!', 'Turqueza', 'Charlene', 'Gonzales', 22, 'Female', 'Single', '1022 ', 'Jasmin Street', 'Sta.Rita', 'Olongapo', NULL, '09762866176', '2001-07-31', 'Olongapo', 'Filipino', 'Yes', 'No', 'resident', NULL),
(38, NULL, 'charlene@gmail.com', '$2y$12$ViiL6Wq2tezmsJ8aFSjUrufLSs55x4Ligv0jbsNq.OOCWF2aYBfdK', 'Turqueza', 'Charlene', 'Gonzales', 22, 'Female', 'Single', '1022', 'Jasmin', 'Santa Rita', 'Olongapo', NULL, '09762866176', '2001-07-31', 'Olongapo', 'Filipino', 'No', 'No', 'resident', NULL),
(44, NULL, 'juan@gmail.com', '$2y$10$4wLknYCUGDscFCf0pZt8S.9Is4cY52iLfawfBH3X/zQROfhMHAIgG', 'Santos', 'Juan', 'Deag', 23, 'Male', 'Single', '2075th', 'street', 'Pepsi', 'olongapo', NULL, '09454123288', '2000-06-12', 'Zambales', 'Filipino', 'Yes', 'Yes', 'resident', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `addedby` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  ADD PRIMARY KEY (`id_announcement`);

--
-- Indexes for table `tbl_blotter`
--
ALTER TABLE `tbl_blotter`
  ADD PRIMARY KEY (`id_blotter`);

--
-- Indexes for table `tbl_brgyid`
--
ALTER TABLE `tbl_brgyid`
  ADD PRIMARY KEY (`id_brgyid`);

--
-- Indexes for table `tbl_bspermit`
--
ALTER TABLE `tbl_bspermit`
  ADD PRIMARY KEY (`id_bspermit`);

--
-- Indexes for table `tbl_clearance`
--
ALTER TABLE `tbl_clearance`
  ADD PRIMARY KEY (`id_clearance`);

--
-- Indexes for table `tbl_indigency`
--
ALTER TABLE `tbl_indigency`
  ADD PRIMARY KEY (`id_indigency`);

--
-- Indexes for table `tbl_rescert`
--
ALTER TABLE `tbl_rescert`
  ADD PRIMARY KEY (`id_rescert`);

--
-- Indexes for table `tbl_resident`
--
ALTER TABLE `tbl_resident`
  ADD PRIMARY KEY (`id_resident`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  MODIFY `id_announcement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_blotter`
--
ALTER TABLE `tbl_blotter`
  MODIFY `id_blotter` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_brgyid`
--
ALTER TABLE `tbl_brgyid`
  MODIFY `id_brgyid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_bspermit`
--
ALTER TABLE `tbl_bspermit`
  MODIFY `id_bspermit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_clearance`
--
ALTER TABLE `tbl_clearance`
  MODIFY `id_clearance` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_indigency`
--
ALTER TABLE `tbl_indigency`
  MODIFY `id_indigency` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_rescert`
--
ALTER TABLE `tbl_rescert`
  MODIFY `id_rescert` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111120;

--
-- AUTO_INCREMENT for table `tbl_resident`
--
ALTER TABLE `tbl_resident`
  MODIFY `id_resident` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
