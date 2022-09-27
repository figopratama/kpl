-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2022 at 04:58 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(13) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `latest_login` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `birthdate`, `phone`, `password`, `created_at`, `latest_login`) VALUES
(1, 'Admin8', '', NULL, '0', '$2y$10$w6eXiNVEnp6EZXn6dhnBmejiXBSrYEGHvwHQAuVE0U6e2rL42HnS2', '2022-09-08 20:08:33', '2022-09-14 12:30:54'),
(2, 'admin1', '', NULL, '0', '$2y$10$BZePLXvpJanJFUsNCp1mM.j59fz8I181T0tUEHHUOtGw8SCYmuBPa', '2022-09-08 21:12:10', '2022-09-11 02:08:54'),
(3, 'admin2', '', NULL, '0', '$2y$10$rLIILNKvXAU85GUi0Uk75OE1Rlf1RBvd1gD2YhCs5z3r0E1Kxz7g2', '2022-09-08 22:23:17', '2022-09-08 15:23:24'),
(10, 'admin3', '', NULL, '0', '$2y$10$qi935B7HCk38Jz1K0SaaXOWmsfNwvGscAR3cHwLgK7/Sd1Uzxxfoa', '2022-09-26 12:41:53', '2022-09-26 05:41:53'),
(11, 'admin4', 'admin4@gmail.com', NULL, '0', '', '2022-09-26 12:51:59', '2022-09-26 05:51:59'),
(29, 'admin5', 'admin5', '2022-09-06', '628952010652', '$2y$10$RzCOhctSscWBxqK6KKUBceSZIFPtUI586j8uuzBWuWkxFbq308efm', '2022-09-26 17:20:57', '2022-09-26 10:20:57'),
(30, 'admin6', 'admin6@gmail.com', '2022-09-09', '89520106522', '$2y$10$qsuQuAPYcEgB7ed5Ac85ieh4n.H4bK9ITc4.LgsJlXeD9L8l8At9C', '2022-09-26 17:23:02', '2022-09-26 10:23:02'),
(31, 'admin7', 'admin7@gmail.com', '2022-09-10', '089520106522', '$2y$10$vcEywA8KRzi.nBZqGh.mZOx623Pn7LCG8cZkEAy4IV7131Hq84C3G', '2022-09-26 17:24:00', '2022-09-26 10:24:00'),
(32, 'admin9', 'admin9@gmail.com', '2022-09-06', '089520106522', '$2y$10$tktMK4zbTg.DpKXknsY5jeb9uHUhQMzwBeSBCfzaVrfEplTTpJ8Eq', '2022-09-26 17:26:02', '2022-09-26 10:26:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
