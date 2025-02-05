-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 08:33 AM
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
-- Database: `tourism`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', '$2y$10$13spIOLxFFiiPNBun0ZGx.xdVX0I7AE4kKcWp4arSajyS2xgCRf2W', '2023-09-07 05:26:37', '2023-09-07 05:26:37', 'admin'),
(2, 'Latimax4all@gmail.com', '$2y$10$0qp/oo5LB6lGbsr8.iY4Q.LOlJZfhgNKLseUK9x2oc8.RffCuonK.', '2024-11-23 21:59:54', '2024-11-23 22:07:16', 'subadmin');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `siteId` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `bookingDate` date NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `paymentStatus` enum('unpaid','paid','refunded') DEFAULT 'unpaid',
  `totalAmount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `userId`, `siteId`, `description`, `bookingDate`, `status`, `paymentStatus`, `totalAmount`, `created_at`, `updated_at`) VALUES
(4, 1, 2, 'Site: Shiro Waterfallsss, Item: Tourism Jacket (₦345,000.00)', '2024-11-27', 'pending', 'unpaid', 375000.00, '2024-11-27 09:57:57', '2024-11-27 10:16:55'),
(5, 1, 3, 'Site: Iroko Hill, Item: Flying skte (₦1,935.00)', '2024-11-27', 'pending', 'unpaid', 36335.00, '2024-11-27 10:25:39', '2024-11-27 10:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `itemID` int(11) NOT NULL,
  `itemName` text NOT NULL,
  `siteID` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `availability` tinyint(1) DEFAULT 1,
  `amount` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`itemID`, `itemName`, `siteID`, `description`, `quantity`, `availability`, `amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Tourism Jacket', 2, 'Tourism Jacket', 3, 1, 345000, '2024-11-27 05:52:14', '2024-11-27 09:22:39', NULL),
(4, 'Basket', 2, 'basjet', 2, 1, 100, '2024-11-27 10:19:08', '2024-11-27 10:19:08', NULL),
(5, 'Flying skte', 3, 'Flying skte', 2, 1, 1935, '2024-11-27 10:20:09', '2024-11-27 10:20:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `site_name` text NOT NULL,
  `site_email` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `owner` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `symbol`, `site_name`, `site_email`, `phone`, `address`, `owner`) VALUES
(1, '₦', 'Tourism Info System', 'info@nasaracapital.com', '+2347018170851', 'Northwest Road, Opposite Aliko Filling Station, Kano', 'Muhammad Abdullahi SPEEDOU');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `siteID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `availability` tinyint(1) DEFAULT 1,
  `images` text DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`siteID`, `name`, `description`, `location`, `availability`, `images`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Shiro Waterfallsss', 'Shiro Waterfall', 'Street Chunky, MS 39323', 1, 'a:2:{i:0;s:24:\"assets/uploads/about.png\";i:1;s:37:\"assets/uploads/2-removebg-preview.png\";}', 30000, 'active', '2024-11-26 21:37:59', '2024-11-27 09:26:32'),
(3, 'Iroko Hill', 'Iroko Hill', 'Street Chunky, MS 39323', 1, 'a:1:{i:0;s:24:\"assets/uploads/img-1.jpg\";}', 34400, 'active', '2024-11-27 10:19:41', '2024-11-27 10:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `fullname` text NOT NULL,
  `gender` text NOT NULL,
  `phone` text NOT NULL,
  `state` text NOT NULL,
  `country` text NOT NULL,
  `status` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fullname`, `gender`, `phone`, `state`, `country`, `status`, `created_at`) VALUES
(1, 'Latimax4all@gmail.com', '$2y$10$E1DuXk2xXq/aqey/qQ/4xO5ptujVl6BjgpENgXlTWdgbc2bAFaOTW', 'Shaibu Abdulateef', 'male', '09063883519', 'Edo', 'Nigeria', 'active', '2024-11-25 22:12:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_User` (`userId`),
  ADD KEY `FK_TouristSite` (`siteId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `FK_SiteInventory` (`siteID`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`siteID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `siteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `FK_TouristSite` FOREIGN KEY (`siteId`) REFERENCES `sites` (`siteID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_User` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `FK_SiteInventory` FOREIGN KEY (`siteID`) REFERENCES `sites` (`siteID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
