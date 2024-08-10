-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 03:08 AM
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
-- Database: `db_travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(1, 'Destinasi Wisata'),
(2, 'Tempat Kuliner'),
(3, 'Penginapan');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `package_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `num_people` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled','Unverified','Rejected') DEFAULT 'Pending',
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `package_id`, `booking_date`, `num_people`, `total_price`, `status`, `proof_of_payment`, `created_at`, `updated_at`) VALUES
(4, 4, 2, '2024-08-16', 3, 2370000.00, 'Confirmed', '259-poster ekraf .png', '2024-08-06 13:39:41', '2024-08-09 02:00:51'),
(5, 4, 4, '2024-08-30', 1, 950000.00, 'Cancelled', '', '2024-08-06 13:53:03', '2024-08-06 14:38:51'),
(6, 4, 2, '2024-08-31', 4, 3160000.00, 'Rejected', '548-gallery-2.jpg', '2024-08-09 02:16:26', '2024-08-09 03:11:22'),
(7, 4, 4, '2024-08-16', 1, 950000.00, 'Cancelled', NULL, '2024-08-09 03:23:26', '2024-08-09 03:23:35'),
(8, 7, 5, '2024-12-30', 4, 3000000.00, 'Confirmed', '820-gallery-1.jpg', '2024-08-09 05:45:18', '2024-08-09 05:48:22'),
(9, 7, 2, '2024-08-17', 2, 1580000.00, 'Rejected', '356-gallery-1.jpg', '2024-08-09 05:48:52', '2024-08-09 05:49:29'),
(10, 5, 5, '2024-08-17', 2, 1500000.00, 'Cancelled', NULL, '2024-08-10 01:04:02', '2024-08-10 01:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `tour_packages`
--

CREATE TABLE `tour_packages` (
  `package_id` int(11) NOT NULL,
  `package` varchar(30) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `price` varchar(15) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_packages`
--

INSERT INTO `tour_packages` (`package_id`, `package`, `picture`, `price`, `description`, `category_id`) VALUES
(1, 'Borobudur', '434-gallery-5.jpg', '1000000', '3 hari 2 malam', 1),
(2, 'Bromo', '189-gallery-7.jpg', '790000', 'Paket 2 hari 1 malam', 1),
(4, 'Bali', '11-gallery-4.jpg', '950000', '3 hari 2 malam', 1),
(5, 'Raja Ampat', '561-gallery-3.jpg', '750000', '2 hari 1 malam', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `telephone` varchar(13) DEFAULT NULL,
  `gender` enum('pria','wanita') DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `nama_lengkap`, `email`, `password`, `telephone`, `gender`, `profile_picture`, `role`) VALUES
(3, 'Muhammad Faza Ibrahim', 'muhammadfaza23@gmail.com', 'faza123456', '086787654323', 'pria', '956-gallery-1.jpg', 'admin'),
(4, 'Fuji Kaze', 'fujikaze45@gmail.com', 'fuji1234', '', '', '853-gallery-2.jpg', 'user'),
(5, 'Andrean Putra Pratama', 'andreanputra29@gmail.com', 'putrapratama123', NULL, NULL, '431-dio-hasibuan-9ZNhQZFivZc-unsplash.jpg', 'user'),
(6, 'Ahmad Sofyan', 'ahmadsofyan6@gmail.com', 'ahmad1234', NULL, NULL, '', 'user'),
(7, 'ochann', 'ochann@gmail.com', 'Ochan123', '08123456789', 'pria', '651-gallery-1.jpg', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD PRIMARY KEY (`package_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tour_packages`
--
ALTER TABLE `tour_packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `tour_packages` (`package_id`);

--
-- Constraints for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD CONSTRAINT `tour_packages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
