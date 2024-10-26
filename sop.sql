-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 11:26 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sop`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_data`
--

CREATE TABLE `order_data` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cylinder_option` enum('with','without') NOT NULL,
  `service_option` enum('Deliver','Walk-in') NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','In Progress','Completed','Cancelled') NOT NULL DEFAULT 'Completed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_data`
--

INSERT INTO `order_data` (`order_id`, `user_id`, `cylinder_option`, `service_option`, `order_date`, `total_amount`, `status`) VALUES
(1, 2, '', '', '2024-10-24 01:33:36', '2500.00', 'Pending'),
(2, 2, '', '', '2024-10-24 01:34:19', '10230.00', 'Pending'),
(3, 2, '', '', '2024-10-24 01:35:50', '10230.00', 'Pending'),
(4, 2, '', '', '2024-10-24 01:50:39', '4342.00', 'Pending'),
(5, 2, '', '', '2024-10-24 01:53:55', '2500.00', 'Pending'),
(6, 2, '', '', '2024-10-24 01:55:06', '5592.00', 'Pending'),
(7, 2, '', '', '2024-10-24 01:58:10', '639.00', 'Pending'),
(8, 2, '', '', '2024-10-24 01:59:36', '500.00', ''),
(9, 2, '', '', '2024-10-24 02:02:06', '2500.00', 'Completed'),
(10, 2, '', '', '2024-10-24 14:52:18', '2500.00', 'Completed'),
(11, 2, '', '', '2024-10-24 16:23:16', '642.20', 'Completed'),
(12, 2, '', '', '2024-10-24 16:47:36', '250.00', 'Completed'),
(13, 2, 'with', 'Deliver', '2024-10-24 16:49:14', '750.00', 'Completed'),
(14, 2, '', '', '2024-10-24 16:50:19', '773.00', 'Completed'),
(15, 2, '', '', '2024-10-24 16:51:08', '500.00', 'Completed'),
(16, 2, 'with', 'Deliver', '2024-10-24 16:54:11', '213.00', 'Completed'),
(17, 2, 'with', 'Deliver', '2024-10-24 17:19:55', '417.48', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_data`
--

CREATE TABLE `payment_data` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('Cash','Credit Card','Debit Card','Online') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tendered_amount` decimal(10,2) NOT NULL,
  `amount_change` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_data`
--

CREATE TABLE `product_data` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_stocks` int(50) NOT NULL DEFAULT 0,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_data`
--

INSERT INTO `product_data` (`product_id`, `product_name`, `product_price`, `product_stocks`, `product_image`) VALUES
(1, 'PETRON GASUL 50 KILOS', '1250.00', 20, '50kg.png'),
(2, 'PETRON GASUL 22 KILOS', '1546.00', 15, '22kg.png'),
(3, 'PETRON GASUL 11 KILOS', '773.00', 10, '11kg.png'),
(4, 'PETRON GASUL 7 KILOS', '505.00', 5, '7kg.png'),
(5, 'PETRON GASUL 2.7 KILOS', '213.00', 12, '2.7kg.png'),
(6, 'PETRON GASUL ELITE 11 KILOS', '250.00', 3, '11kg-Elite-removebg-preview.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','cashier','customer') NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`user_id`, `username`, `email_address`, `contact_number`, `password`, `user_type`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 2147483647, '$2y$10$cZ7y9XwyWKRm55XsS1K.F.4raESyi6AdVt2FVtxxel54cIDl.hP7K', 'admin', '2024-10-12 08:15:04.570511'),
(2, 'cashier1', 'cashier_gen@gmail.com', 2147483647, '$2y$10$FObP.NrIHunTy0egIzp7P.G80rgCX5SzLQKLeJQyJpPMajQSMjZOq', 'cashier', '2024-10-12 08:16:37.010950'),
(3, 'cashier2', 'cashier2_krizia@gmail.com', 2147483647, '$2y$10$VLLyaP9uXcw9TsuDZywYteqBgysnjkR3h6pxIiOygVFZpIOS3Egqm', 'cashier', '2024-10-12 08:17:38.935211'),
(4, 'cashier3', 'cashier3_farfara@gmail.com', 2147483647, '$2y$10$DH80uoqbQ2OpG9/eg.UTBuJrFRn7kZ/M0.ug0FPA1OwCDTY4jKzE.', 'cashier', '2024-10-12 08:18:36.709865'),
(5, 'admin2', 'admin2@gmail.com', 1122334455, 'admin2123', 'admin', '0000-00-00 00:00:00.000000'),
(6, 'krizia', 'kz@gmail.com', 2147483647, '12345', 'customer', '2024-10-24 08:06:37.336696');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_data`
--
ALTER TABLE `order_data`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment_data`
--
ALTER TABLE `payment_data`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product_data`
--
ALTER TABLE `product_data`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_data`
--
ALTER TABLE `order_data`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_data`
--
ALTER TABLE `payment_data`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_data`
--
ALTER TABLE `product_data`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_data`
--
ALTER TABLE `order_data`
  ADD CONSTRAINT `order_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_data` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_data` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_data` (`product_id`);

--
-- Constraints for table `payment_data`
--
ALTER TABLE `payment_data`
  ADD CONSTRAINT `payment_data_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_data` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
