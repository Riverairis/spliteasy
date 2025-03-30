-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 06:51 PM
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
-- Database: `spliteasy`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bill_name` varchar(255) NOT NULL,
  `invite_code` varchar(10) NOT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `user_id`, `bill_name`, `invite_code`, `is_archived`, `created_at`) VALUES
(1, 4, 'Dinner with Friends', 'cb16239399', 0, '2025-03-24 15:30:12'),
(2, 5, 'Dinner with Friends', '4dea895854', 1, '2025-03-28 06:50:36'),
(3, 5, 'Dinner with Henrich', '3648626e8c', 0, '2025-03-28 08:52:49'),
(4, 5, 'Dinner with Shaira', '7c90d9fd38', 0, '2025-03-28 08:53:53'),
(5, 5, 'Dinner with Friends', 'b07263dc57', 0, '2025-03-28 09:08:15'),
(6, 5, 'Adrienne Warren', 'e920e22c07', 0, '2025-03-28 09:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `bill_participants`
--

CREATE TABLE `bill_participants` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `guest_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_participants`
--

INSERT INTO `bill_participants` (`id`, `bill_id`, `user_id`, `guest_email`, `guest_name`) VALUES
(2, 1, 1, NULL, NULL),
(3, 1, 4, NULL, NULL),
(4, 4, 4, NULL, NULL),
(5, 3, 5, NULL, NULL),
(6, 3, 1, NULL, NULL),
(7, 3, 4, NULL, NULL),
(8, 4, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `expense_name` varchar(255) NOT NULL,
  `paid_by` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `split_type` enum('equally','custom') DEFAULT 'equally'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `bill_id`, `expense_name`, `paid_by`, `amount`, `split_type`) VALUES
(1, 1, 'Pasta', 4, 500.00, 'equally'),
(7, 1, 'spag', 4, 200.00, 'custom');

-- --------------------------------------------------------

--
-- Table structure for table `expense_splits`
--

CREATE TABLE `expense_splits` (
  `id` int(11) NOT NULL,
  `expense_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_splits`
--

INSERT INTO `expense_splits` (`id`, `expense_id`, `user_id`, `guest_email`, `amount`) VALUES
(1, 7, 1, NULL, 200.00),
(2, 7, 4, NULL, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_type` enum('standard','premium') DEFAULT 'standard',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `nickname`, `email`, `username`, `password`, `account_type`, `created_at`, `email_verified`, `verification_token`) VALUES
(1, 'Erickson', 'Ramona', 'mae', 'ryriseva@gmail.com', 'maet', 'nikko123.', 'standard', '2025-03-24 15:19:35', 0, NULL),
(2, 'Suarez', 'Barry', 'Zahir Simpson', 'wegamasy@mailinator.com', 'xutydofer', '$2y$10$RV3vEpcHycwqf5rZLrtz9.K19/Uf/dGCVitkpe5JBmEdUkKet0B3m', 'standard', '2025-03-24 15:25:43', 0, NULL),
(3, 'Gilmore', 'Tana', 'Veronica Casey', 'bihijudyfi@mailinator.com', 'xureqa', '$2y$10$ouJheZHDE9bh7AvkLhlzde7Isir/vPdky11/gtn7R4J4shObSCihC', 'standard', '2025-03-24 15:26:31', 0, NULL),
(4, 'Weber', 'Yuli', 'Sade Green', 'silizur@mailinator.com', 'pogo', '$2y$10$WjqVBNyGvBnEmr3im.ZJyeFT7muOsFzbk8e9b/saOaXWhOwsQlr8.', 'standard', '2025-03-24 15:27:59', 0, NULL),
(5, 'Henson', 'Iris', 'Miles', 'lokucu@gmail.com', 'wayt', '$2y$10$QOenMsN09QyU3KQ9MHPGjOTIGT7jBSZBbS2EJOeqDTnAe6V1hZbL.', 'standard', '2025-03-28 06:45:30', 0, NULL),
(20, 'Russell', 'Bertha', 'Holmes Walton', 'nyvykuv@mailinator.com', 'pytiqiv', '$2y$10$HNHpGPzoRB3OQSKSUgIlTekH0/gGQ3KRHJNAC/n8gkRRbe7QpOP5u', 'standard', '2025-03-28 08:49:47', 0, 'eea5f7a384c7cdf93356bf0111b9cf67');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invite_code` (`invite_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bill_participants`
--
ALTER TABLE `bill_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `paid_by` (`paid_by`);

--
-- Indexes for table `expense_splits`
--
ALTER TABLE `expense_splits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_id` (`expense_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `verification_token` (`verification_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bill_participants`
--
ALTER TABLE `bill_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `expense_splits`
--
ALTER TABLE `expense_splits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bill_participants`
--
ALTER TABLE `bill_participants`
  ADD CONSTRAINT `bill_participants_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`),
  ADD CONSTRAINT `bill_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`),
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`paid_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `expense_splits`
--
ALTER TABLE `expense_splits`
  ADD CONSTRAINT `expense_splits_ibfk_1` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`),
  ADD CONSTRAINT `expense_splits_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
