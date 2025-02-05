-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 05, 2025 at 11:13 AM
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
(1, 'Admin', '$2a$12$a800eOh6bhtWp0mYhPaPHO5M5GXc8fZ0Sv1775Rwydr3ixiX/.fh2', NULL, NULL, 'Admin');

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
(1, 'Wildlife Photography Prints', 1, '....', 100, 1, 1000, '2025-02-05 10:07:14', '2025-02-05 10:07:14', NULL),
(2, 'Traditional Hausa Crafts & Beads', 1, '..', 34, 1, 200, '2025-02-05 10:07:29', '2025-02-05 10:07:29', NULL),
(3, 'Custom Safari Hats & T-shirts', 1, '...', 33, 1, 2000, '2025-02-05 10:07:44', '2025-02-05 10:07:44', NULL),
(4, 'Locally Made Wood Carvings & Sculptures', 2, '...', 32, 1, 300, '2025-02-05 10:08:10', '2025-02-05 10:08:10', NULL),
(5, 'Handwoven Aso-Oke & Traditional Fabrics', 2, '...', 32, 1, 32000, '2025-02-05 10:08:26', '2025-02-05 10:08:26', NULL),
(6, 'Custom-Made Adventure Gear', 2, '...', 32, 1, 2390, '2025-02-05 10:08:39', '2025-02-05 10:08:39', NULL),
(7, 'Zuma Rock-Themed Artwork & Paintings', 3, ',,,', 43, 1, 20000, '2025-02-05 10:08:59', '2025-02-05 10:08:59', NULL),
(8, 'Handmade Leather Goods (Shoes, Bags)', 3, '...', 93, 1, 9440, '2025-02-05 10:09:16', '2025-02-05 10:09:16', NULL),
(9, 'Adire (Tie-Dye) Fabrics & Clothing', 4, ',,,', 43, 1, 8999, '2025-02-05 10:09:29', '2025-02-05 10:09:29', NULL),
(10, 'Wildlife-Themed Merchandise (T-shirts, Caps)', 5, '...', 12, 1, 3000, '2025-02-05 10:09:48', '2025-02-05 10:09:48', NULL);

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
(1, 'Yankari National Park', 'Nigeria\'s largest wildlife park, home to elephants, baboons, antelopes, and the warm Wikki Springs. Great for safari experiences.', 'Bauchi State', 1, 'a:1:{i:0;s:81:\"assets/uploads/cjjapiyd9jfmyc5tfgbbiecmv0arge6lfxtrkofz-1656785530-compressed.jpg\";}', 25000, 'active', '2025-02-05 09:58:32', '2025-02-05 09:59:16'),
(2, 'Obudu Mountain Resort', 'A beautiful mountain retreat with cable cars, waterfalls, and hiking trails. Ideal for nature lovers and adventure seekers.', 'Cross River State', 1, 'a:1:{i:0;s:43:\"assets/uploads/67a337493d948_1738749769.jpg\";}', 30000, 'active', '2025-02-05 10:02:49', '2025-02-05 10:02:49'),
(3, 'Zuma Rock', 'A massive monolithic rock with a face-like appearance, considered a symbol of strength and resilience in Nigeria.', 'Niger State (near Abuja)', 1, 'a:1:{i:0;s:43:\"assets/uploads/67a3376336536_1738749795.jpg\";}', 10000, 'active', '2025-02-05 10:03:15', '2025-02-05 10:03:15'),
(4, 'Olumo Rock', 'A historical rock formation used as a natural fortress during inter-tribal wars, offering breathtaking views of Abeokuta city.', 'Ogun State', 1, 'a:1:{i:0;s:43:\"assets/uploads/67a33794c49df_1738749844.jpg\";}', 15000, 'active', '2025-02-05 10:04:04', '2025-02-05 10:04:04'),
(5, 'Lekki Conservation Centre', 'A nature reserve with a canopy walkway, diverse wildlife, and beautiful landscapes, perfect for eco-tourism.', 'Lagos State', 1, 'a:1:{i:0;s:43:\"assets/uploads/67a337be99061_1738749886.jpg\";}', 43000, 'active', '2025-02-05 10:04:46', '2025-02-05 10:04:46');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `siteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
