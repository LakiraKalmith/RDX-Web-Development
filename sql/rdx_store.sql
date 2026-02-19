-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2026 at 04:19 PM
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
-- Database: `rdx_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`) VALUES
(1, 'Uncategorized', 'inactive'),
(7, 'Accessories', 'active'),
(9, 'T-Shirts', 'active'),
(10, 'Hoodies', 'active'),
(11, 'Caps', 'active'),
(12, 'Pants', 'inactive'),
(16, 'Caps', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `subscribed_at`) VALUES
(1, 'lakira.kalmith@gmail.com', '2026-02-01 17:23:27'),
(3, 'epstein@gmail.com', '2026-02-01 17:24:46'),
(4, 'admin@nsbmstore.com', '2026-02-01 17:25:01'),
(5, 'mijawit522@firain.com', '2026-02-01 17:25:09'),
(8, 'i.am.kira@gmail.com', '2026-02-01 17:29:23'),
(9, 'progamer6177@gmail.com', '2026-02-01 17:30:02'),
(12, 'lakira.kal33mith@gmail.com', '2026-02-01 18:57:02'),
(15, 'babyoil.diddy@gmail.com', '2026-02-02 21:06:11'),
(16, 'lakira.gooneratne@gmail.com', '2026-02-05 20:36:47'),
(22, 'trump@gmail.com', '2026-02-06 22:10:53'),
(23, 'helloworld@gmail.com', '2026-02-06 22:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `category_id`, `featured`, `status`, `created_at`) VALUES
(1, 'Black T-Shirt', 244.00, '100% cottons', '1769865825_black-tee.jpg', 16, 1, 'inactive', '2026-01-27 15:52:22'),
(2, 'White Hoodie', 999.00, 'Hoodies', 'white-hoodie.jpg', 10, 1, 'active', '2026-01-27 15:52:22'),
(3, 'Blue Jeans', 55.00, 'Slim fit blue jeans', 'blue-jeans.jpg', 16, 1, 'active', '2026-01-27 15:52:22'),
(4, 'Red Cap', 15.00, 'Red cap with logo', 'red-cap.jpg', 1, 0, 'active', '2026-01-27 15:52:22'),
(282, 'HOODIE ', 266.00, 'asfa', '1769862987_sample.png', 1, 0, 'active', '2026-01-29 19:25:22'),
(288, 'Shirt', 1212.00, 'ss', '1770561277_Black and White Minimalist Professional Initial Logo.png', 16, 1, 'inactive', '2026-02-08 14:34:37'),
(290, 'Red Cap', 111.00, 'Cotton \r\nleather', '1770570861_download (1).jpeg', 7, 0, 'active', '2026-02-08 17:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` enum('S','M','L') NOT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `stock`) VALUES
(119, 2, 'S', 24),
(123, 3, 'S', 19),
(124, 3, 'M', 6),
(125, 3, 'L', 5),
(138, 282, 'S', 2),
(139, 282, 'M', 100),
(140, 282, 'L', 23),
(141, 4, 'S', 10),
(142, 4, 'M', 12),
(143, 4, 'L', 10),
(146, 288, 'S', 9),
(147, 288, 'M', 9),
(155, 290, 'S', 11),
(156, 290, 'M', 25),
(157, 290, 'L', 5),
(158, 1, 'S', 5),
(159, 1, 'M', 2),
(160, 1, 'L', 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `role`, `created_at`, `updated_at`) VALUES
(3, 'Lakira', 'Kalmith', 'nigga@gmail.com', NULL, '$2y$10$T09gtpdLOJJrZ2duDeSaDu4Lgu86xR4csY/ewqrNt6bwBtNPzT4bm', 'customer', '2026-01-26 10:23:52', '2026-02-01 17:43:20'),
(5, 'Kira', '', 'lakira.gooneratne@gmail.com', NULL, '$2y$10$/i2Ds7WBWL5U8e7avQ0.puFRK0HgHGMMhis80ypC/8d53dq8r1432', 'admin', '2026-01-26 10:26:35', '2026-02-01 19:24:36'),
(6, 'Madushan', 'Boss', 'madushan@gmail.com', '', '$2y$10$IyOJGGNfHYM3WiKWDc3eA.jEGfCyYrbEpQ0oQecXNDUy9ouKLRohe', 'customer', '2026-01-26 11:13:35', '2026-02-03 09:00:19'),
(7, 'Jordan', 'Belfort', 'john@gmail.com', '', '$2y$10$.3dwR2kAVopbxOkHghu.EO5WFtcDVlathQrPXWcw4Rfu6RJ.MH3d.', 'customer', '2026-01-26 19:54:07', '2026-02-06 15:55:50'),
(8, 'Jackie', 'Chan', 'mijawit522@firain.com', NULL, '$2y$10$QI.1lNgFRbmbYBpzH/hie.wxffHplavGVBEe89K6zO22vD66jwNaW', 'customer', '2026-02-01 07:12:00', '2026-02-02 15:08:38'),
(9, 'Lakira', 'Kalmith', 'lakira.kalmith69@gmail.com', NULL, '$2y$10$cco032TOIWlJi.zJ8cWcgOnB6CyMlLNquPGwPYvsVwr25FtFnE5FS', 'customer', '2026-02-01 18:31:07', '2026-02-01 18:31:07'),
(10, 'Pablo', 'Escobar', 'pablo.escobar@gmail.com', NULL, '$2y$10$j0LX5AnF826xvFU9qLcKrumLVlLeNMq626I7d1IjSgQEg.HDBCe3u', 'customer', '2026-02-01 21:18:38', '2026-02-01 21:19:23'),
(11, 'Khalid', 'Mamoon', 'khalidmamoon@gmail.com', NULL, '$2y$10$2et1GKhjwXWy/VT0VO2HS.ddfUVOY8D51yGzF/uCraqOpWjpSGBZ6', 'customer', '2026-02-05 15:12:22', '2026-02-05 15:12:22'),
(12, 'Hadil', 'Mamoon', 'hadil@gmail.com', NULL, '$2y$10$iaY0egDYIBEmveNiwxFOHO3hqE7zdDdiVuc60ftpTyel6J2UNOjGG', 'customer', '2026-02-05 18:42:09', '2026-02-05 18:42:09'),
(13, 'Jordan', 'Gooneratne', 'epstein@gmail.com', NULL, '$2y$10$70lbwn9fNzayuyV6U78G.OovXwoWmjllQgSyrLl9kMElukXf4Lkg2', 'customer', '2026-02-06 16:18:58', '2026-02-06 16:18:58'),
(14, 'Pablo', 'Gooneratne', 'niggers@gmail.com', NULL, '$2y$10$Rtx48WDYUIhaMc.FnA5V4eiTtRpmyhIvfrMEOUEmDcdjUw2xeTjL.', 'customer', '2026-02-06 16:22:25', '2026-02-06 16:22:25'),
(17, 'Pablo', 'Gooneratne', 'hello@gmail.com', NULL, '$2y$10$ANFpcC9UHicHAYDaoR.wIO82PeBPdtMpNJNceAE4aA.iRtFSAs67a', 'customer', '2026-02-06 16:23:21', '2026-02-06 16:23:21'),
(19, 'Lakira', 'Gooneratne', 'jeffrey@gmail.com', NULL, '$2y$10$Cl54QqYj1b9muaERrS3Zh.MhcJgGpaBgOR16xPPGONJ6JCd/RXw2K', 'customer', '2026-02-06 16:25:07', '2026-02-06 16:25:07'),
(20, 'donald', 'trump', 'trump@gmail.com', NULL, '$2y$10$MtHfifkm.SHpiMPxTopXX.eyD62I4cAqJ/ccS39d4IWpELGrQpqQK', 'customer', '2026-02-06 16:56:24', '2026-02-06 16:56:24'),
(21, 'Pablo', 'asfasf', 'helloworld@gmail.com', NULL, '$2y$10$uF8/YWMzkjuhSjbjBKBfL.2wHgD.yoDDeC1SCxpWZXupWqZ.TbP2u', 'customer', '2026-02-06 17:17:19', '2026-02-06 17:17:19'),
(22, 'Shin', 'Bon', 'chigga@gmail.com', NULL, '$2y$10$8Zn9nZoyIJKBfrree7MOj.6E/I8OJ9edWb207GN/9ci.i.V28.2nW', 'customer', '2026-02-06 17:20:38', '2026-02-06 17:20:38'),
(23, 'Jeffrey', 'Epstein', 'hellothere@gmail.com', '', '$2y$10$A/Zo382Jn5AwA/zbMLqCMOtJfwU.jkX.gGmSJV6A7ttPR5XZbtxUK', 'customer', '2026-02-19 07:26:05', '2026-02-19 08:27:25'),
(24, 'Nethra', 'Sarangi', 'nethra@gmail.com', NULL, '$2y$10$gUBZMKO897BHzQF2nYFO1ubrIdpq.6xoF6BI/X35TGrkJdPuYHnD.', 'customer', '2026-02-19 10:49:46', '2026-02-19 10:49:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
