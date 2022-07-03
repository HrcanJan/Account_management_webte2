-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 25, 2022 at 02:55 PM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zad3`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `type` enum('classic','google') CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `google_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_slovak_ci DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf32 COLLATE utf32_slovak_ci DEFAULT NULL,
  `secret` varchar(64) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `2fa` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `type`, `google_id`, `password`, `secret`, `2fa`) VALUES
(8, 22, 'classic', NULL, '$2y$10$iJwM/K5zUUp5cD.sC3ULMuGEU7E7ofKNJvBKU6.6q1mvaySXKhOGW', 'B4T3NUNLRNZO3Q7M', 1),
(9, 23, 'classic', NULL, '$2y$10$qGeUMjYOwUELAUsSJubDZu2y11za2OuOYX4fYEY5h1tUltIm5ctwy', 'LHVMYQ3Y3OLN5E3D', 1),
(10, 35, 'classic', NULL, '$2y$10$tBieVWtNlJFUj6hyHMewOu1A.3urfIEftQ3laA/BK.npwmbjuYgj6', 'JZ3ZATRSRYCAZPLX', NULL),
(11, 38, 'google', '104615776091097921542', NULL, 'LACEKJB5XAJDVZ57', NULL),
(12, 39, 'google', '109387357154337597492', NULL, 'XRT5POIISQW2D4UE', NULL),
(14, 49, 'google', '105289886702053186954', NULL, 'IDI3SRMI5EITNQ76', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `account_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `created_at`, `account_id`) VALUES
(31, '2022-03-25 11:22:49', 8),
(32, '2022-03-25 11:23:19', 9),
(33, '2022-03-25 11:44:27', 10),
(34, '2022-03-25 11:51:38', 11),
(35, '2022-03-25 11:51:46', 12),
(36, '2022-03-25 11:52:51', 9),
(37, '2022-03-25 12:41:35', 10),
(38, '2022-03-25 12:41:52', 9),
(39, '2022-03-25 12:42:15', 10),
(40, '2022-03-25 12:42:21', 9),
(41, '2022-03-25 12:42:57', 9),
(42, '2022-03-25 12:43:41', 9),
(43, '2022-03-25 12:45:11', 9),
(44, '2022-03-25 12:45:50', 10),
(45, '2022-03-25 12:46:11', 9),
(46, '2022-03-25 12:47:19', 9),
(47, '2022-03-25 12:52:46', 9),
(48, '2022-03-25 13:13:49', 10),
(49, '2022-03-25 13:15:42', 9),
(51, '2022-03-25 13:27:19', 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `name`, `id`) VALUES
('xhrcan@stuba.sk', 'Jan Hrćan', 22),
('janhrcan@yahoo.com', 'Jan Hrćan', 23),
('janochrtan@gmail.com', 'Krle', 35),
('zrenjaninacz866@gmail.com', 'Happy Tree Friends Wiki', 38),
('jankochrtan55555@gmail.com', 'danstorm', 39),
('jankochrtan555@gmail.com', 'Krle', 49);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

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
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
