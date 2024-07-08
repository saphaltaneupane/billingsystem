-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 03:58 AM
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
-- Database: `billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `bill_date` datetime NOT NULL,
  `bill_data` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_option` varchar(50) NOT NULL,
  `membershipno` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `bill_date`, `bill_data`, `total_amount`, `payment_option`, `membershipno`) VALUES
(1, '2024-05-25 08:02:53', 'a:1:{i:10;a:4:{s:4:\"name\";s:5:\"labeo\";s:8:\"category\";s:7:\"seafood\";s:5:\"price\";i:400;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(2, '2024-05-25 08:05:40', 'a:2:{i:8;a:4:{s:4:\"name\";s:6:\"Banana\";s:8:\"category\";s:6:\"fruits\";s:5:\"price\";i:80;s:8:\"quantity\";s:1:\"1\";}i:9;a:4:{s:4:\"name\";s:7:\"Current\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:50;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(3, '2024-05-25 08:05:51', 'a:2:{i:8;a:4:{s:4:\"name\";s:6:\"Banana\";s:8:\"category\";s:6:\"fruits\";s:5:\"price\";i:80;s:8:\"quantity\";s:1:\"1\";}i:9;a:4:{s:4:\"name\";s:7:\"Current\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:50;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(4, '2024-05-25 08:06:11', 'a:2:{i:8;a:4:{s:4:\"name\";s:6:\"Banana\";s:8:\"category\";s:6:\"fruits\";s:5:\"price\";i:80;s:8:\"quantity\";s:1:\"0\";}i:9;a:4:{s:4:\"name\";s:7:\"Current\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:50;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(5, '2024-05-25 08:12:59', 'a:1:{i:0;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(6, '2024-05-25 10:36:40', 'a:1:{i:1;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(7, '2024-05-25 10:43:53', 'a:1:{i:1;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(8, '2024-05-25 12:22:15', 'a:1:{i:13;a:4:{s:4:\"name\";s:4:\"Lays\";s:8:\"category\";s:6:\"snacks\";s:5:\"price\";i:50;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(9, '2024-05-25 15:51:42', 'a:1:{i:1;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"1\";}}', 0.00, '', NULL),
(10, '2024-05-25 16:30:44', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Sprite\";s:8:\"category\";s:9:\"beverages\";s:5:\"price\";s:2:\"50\";s:8:\"quantity\";i:2;s:5:\"total\";i:100;}}', 100.00, 'cash', NULL),
(11, '2024-05-26 09:32:29', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:1;s:5:\"total\";i:250;}}', 250.00, 'cash', NULL),
(12, '2024-05-26 09:33:51', 'a:2:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:3;s:5:\"total\";i:750;}i:1;a:5:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:4:\"1000\";s:8:\"quantity\";i:45;s:5:\"total\";i:45000;}}', 45750.00, 'cash', NULL),
(13, '2024-05-26 11:11:00', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:4:\"1000\";s:8:\"quantity\";i:1;s:5:\"total\";i:1000;}}', 1000.00, 'cash', '23'),
(14, '2024-05-26 11:11:33', 'a:1:{i:6;a:4:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";i:1000;s:8:\"quantity\";s:1:\"1\";}}', 1000.00, 'cash', '23'),
(15, '2024-05-26 14:04:45', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:4:\"1000\";s:8:\"quantity\";i:2;s:5:\"total\";i:2000;}}', 2000.00, 'cash', ''),
(16, '2024-05-26 14:06:37', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"Lays\";s:8:\"category\";s:6:\"snacks\";s:5:\"price\";s:2:\"50\";s:8:\"quantity\";i:1;s:5:\"total\";i:50;}}', 50.00, 'cash', '123'),
(17, '2024-05-26 17:33:50', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Sprite\";s:8:\"category\";s:9:\"beverages\";s:5:\"price\";s:2:\"50\";s:8:\"quantity\";i:1;s:5:\"total\";i:50;}}', 50.00, 'cash', '5'),
(18, '2024-05-26 17:33:58', 'a:1:{i:12;a:4:{s:4:\"name\";s:6:\"Sprite\";s:8:\"category\";s:9:\"beverages\";s:5:\"price\";i:50;s:8:\"quantity\";s:1:\"1\";}}', 50.00, 'cash', '5'),
(19, '2024-05-27 04:26:28', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:4:\"1000\";s:8:\"quantity\";i:5;s:5:\"total\";i:5000;}}', 5000.00, 'cash', ''),
(20, '2024-05-27 04:28:01', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:4:\"1000\";s:8:\"quantity\";i:5;s:5:\"total\";i:5000;}}', 5000.00, 'cash', ''),
(21, '2024-05-27 07:10:14', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:1;s:5:\"total\";i:250;}}', 250.00, 'cash', '23'),
(22, '2024-05-27 07:10:35', 'a:1:{i:1;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"1\";}}', 250.00, 'cash', '23'),
(23, '2024-05-27 16:27:34', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:4:\"1000\";s:8:\"quantity\";i:1;s:5:\"total\";i:1000;}}', 1000.00, 'cash', '5'),
(24, '2024-05-27 16:27:41', 'a:1:{i:6;a:4:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";i:1000;s:8:\"quantity\";s:1:\"1\";}}', 1000.00, 'cash', '5'),
(25, '2024-05-28 02:28:50', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:1;s:5:\"total\";i:250;}}', 250.00, 'khalti', '23'),
(26, '2024-05-28 05:33:41', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"meat\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:4:\"1000\";s:8:\"quantity\";i:1;s:5:\"total\";i:1000;}}', 1000.00, 'cash', '2'),
(27, '2024-05-28 06:51:15', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:1;s:5:\"total\";i:250;}}', 250.00, 'cash', '123'),
(28, '2024-05-28 06:53:38', 'a:1:{i:0;a:5:{s:4:\"name\";s:12:\"Potato Chips\";s:8:\"category\";s:6:\"snacks\";s:5:\"price\";s:3:\"-40\";s:8:\"quantity\";i:1;s:5:\"total\";i:-40;}}', -40.00, 'cash', ''),
(29, '2024-05-28 06:53:58', 'a:1:{i:16;a:4:{s:4:\"name\";s:12:\"Potato Chips\";s:8:\"category\";s:6:\"snacks\";s:5:\"price\";i:-40;s:8:\"quantity\";s:1:\"1\";}}', -40.00, 'cash', ''),
(30, '2024-05-29 16:45:11', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"fish\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:3:\"500\";s:8:\"quantity\";i:1;s:5:\"total\";i:500;}}', 500.00, 'cash', '123'),
(31, '2024-05-29 16:45:14', 'a:1:{i:0;a:5:{s:4:\"name\";s:4:\"fish\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";s:3:\"500\";s:8:\"quantity\";i:1;s:5:\"total\";i:500;}}', 500.00, 'cash', '123'),
(32, '2024-05-29 16:45:26', 'a:1:{i:17;a:4:{s:4:\"name\";s:4:\"fish\";s:8:\"category\";s:4:\"meat\";s:5:\"price\";i:500;s:8:\"quantity\";s:1:\"1\";}}', 500.00, 'cash', '123'),
(33, '2024-06-05 16:04:28', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"sprite\";s:8:\"category\";s:9:\"beverages\";s:5:\"price\";s:2:\"30\";s:8:\"quantity\";i:2;s:5:\"total\";i:60;}}', 60.00, 'cash', '56'),
(34, '2024-06-05 16:04:38', 'a:1:{i:18;a:4:{s:4:\"name\";s:6:\"sprite\";s:8:\"category\";s:9:\"beverages\";s:5:\"price\";i:30;s:8:\"quantity\";s:1:\"2\";}}', 30.00, 'cash', '56'),
(35, '2024-07-03 12:36:18', 'a:1:{i:1;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"1\";}}', 250.00, 'esewa', '23'),
(36, '2024-07-03 12:36:37', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:1;s:5:\"total\";i:250;}}', 250.00, 'cash', '123'),
(37, '2024-07-08 03:36:31', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:2;s:5:\"total\";i:500;}}', 500.00, 'cash', ''),
(38, '2024-07-08 03:36:42', 'a:1:{i:1;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"2\";}}', 250.00, 'cash', ''),
(39, '2024-07-08 03:42:02', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:1;s:5:\"total\";i:250;}}', 250.00, 'cash', ''),
(40, '2024-07-08 03:42:08', 'a:1:{i:1;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"1\";}}', 250.00, 'cash', ''),
(41, '2024-07-08 03:42:25', 'a:1:{i:0;a:5:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";s:3:\"250\";s:8:\"quantity\";i:1;s:5:\"total\";i:250;}}', 250.00, 'cash', ''),
(42, '2024-07-08 03:42:35', 'a:1:{i:1;a:4:{s:4:\"name\";s:6:\"Cheese\";s:8:\"category\";s:14:\"processed_food\";s:5:\"price\";i:250;s:8:\"quantity\";s:1:\"1\";}}', 250.00, 'cash', '');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `membershipno` varchar(50) NOT NULL,
  `phoneno` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `membershipno`, `phoneno`, `address`) VALUES
(1, 'Nabaraj', '123', '987654321', 'chakrapath'),
(2, 'sija', '1', '987654321', 'Dillibazar'),
(3, 'safu', '2', '987654321', 'Dillibazar'),
(4, 'Anjila', '23', '987654321', 'Dillibazar'),
(5, 'JN', '5', '9876543210', 'chabhail'),
(6, 'Saphaltaaa', '78', '987654321', 'Dillibazar'),
(7, 'Shristy/Khusbu', '56', '9876543210', 'chakrapath');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `name` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`name`, `price`, `category`, `id`, `image`, `stock`) VALUES
('Cheese', 250, 'processed_food', 1, 'uploads/cheese.jpg', 21),
('meat', 1000, 'meat', 6, 'uploads/meat.jpg', 0),
('Banana', 80, 'fruits', 8, 'uploads/banana.png', 0),
('lays', 200, 'snacks', 15, 'uploads/lays.png', 0),
('fish', 500, 'meat', 17, 'uploads/fish.png', 0),
('sprite', 30, 'beverages', 18, 'uploads/sprite.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `id` int(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `id`, `email`, `user_type`) VALUES
('admin', 'admin', 1, 'admin@gmail.com', 'admin'),
('saphalta', 'saphalta1', 2, 'neupanesaphalta@gmail.com', 'employee'),
('saphalta', '1234safu', 3, 'neupanesaphalta@gmail.com', 'employee'),
('anjila', 'anjila12', 5, 'anjila@gmail.com', 'employee'),
('users', 'users123', 6, 'user@gmail.com', 'employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `membershipno` (`membershipno`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
