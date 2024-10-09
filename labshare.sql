-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 03:12 PM
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
-- Database: `labshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `item_code` varchar(7) NOT NULL,
  `name` varchar(225) NOT NULL,
  `item_stock` varchar(225) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `item_code`, `name`, `item_stock`, `image`) VALUES
(1, '1234', 'camera ony', '5', 'camera.jpg'),
(3, '123', 'Monitor', '0', 'monitor.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `borrower_name` varchar(225) DEFAULT NULL,
  `tools_id` int(225) DEFAULT NULL,
  `number_tools` int(100) DEFAULT NULL,
  `loan_date` varchar(225) DEFAULT NULL,
  `return_date` varchar(225) DEFAULT NULL,
  `actual_return_date` date DEFAULT current_timestamp(),
  `status` enum('borrowed','returned','check','wait') DEFAULT 'check'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `borrower_name`, `tools_id`, `number_tools`, `loan_date`, `return_date`, `actual_return_date`, `status`) VALUES
(8, 'Cahyo', 1, 1, '3 September, 2024', '4 September, 2024', '2024-09-03', 'returned'),
(9, 'Cahyo', 1, 1, '3 September, 2024', '4 September, 2024', '2024-09-03', 'returned'),
(10, 'Cahyo', 1, 1, '3 September, 2024', '4 September, 2024', '2024-09-03', 'returned'),
(11, 'Cahyo', 1, 1, '31 August, 2024', '2 September, 2024', '2024-09-03', 'returned'),
(12, 'Cahyo', 1, 4, '2 September, 2024', '8 September, 2024', '2024-09-10', 'returned'),
(13, 'Cahyo', 1, 3, '2 September, 2024', '8 September, 2024', '2024-09-10', 'returned'),
(14, 'Cahyo', 1, 1, '9 September, 2024', '10 September, 2024', '2024-09-10', 'returned'),
(15, 'Cahyo', 1, 3, '10 September, 2024', '11 September, 2024', '2024-09-10', 'wait'),
(16, 'Cahyo', 1, 4, '9 September, 2024', '10 September, 2024', '2024-09-17', 'wait'),
(17, 'Cahyo', 1, 1, '17 September, 2024', '18 September, 2024', '2024-09-17', 'wait'),
(18, 'Cahyo', 1, 1, '24 September, 2024', '30 September, 2024', '0000-00-00', 'check'),
(21, 'Cahyo', 3, 1, '7 October, 2024', '8 October, 2024', '0000-00-00', 'check'),
(22, 'Cahyo', 3, 2, '8 October, 2024', '10 October, 2024', '0000-00-00', 'check'),
(23, 'Cahyo', 3, 4, '8 October, 2024', '10 October, 2024', '2024-10-08', 'returned');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `username` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `role` enum('siswa','guru') DEFAULT 'siswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`) VALUES
(1, 'Cahyo', 'cahyo', 'cahyo@gmail.com', 'de66d0e8965c8fed104942b72b530c8d2f1fb1f14c507985e460b735cafddf60', 'siswa'),
(3, 'BillyOtto', 'billy', 'billy@gmail.com', '47798d12ae31ce5a6d9c9dddec7bc9f2a27fffa424b7f2a154fa0e26690972de', 'guru'),
(5, 'SuryaPa', 'yapayapa', 'yapa@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'guru'),
(8, 'Nana', 'nana', 'nana@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'guru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_code` (`item_code`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tools_id` (`tools_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD FULLTEXT KEY `password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`tools_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
