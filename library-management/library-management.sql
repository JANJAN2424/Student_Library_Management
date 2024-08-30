-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 12:47 AM
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
-- Database: `library-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books_information`
--

CREATE TABLE `tbl_books_information` (
  `id` bigint(250) NOT NULL,
  `book_title` varchar(250) DEFAULT NULL,
  `book_author` varchar(250) DEFAULT NULL,
  `book_img` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'available',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_books_information`
--

INSERT INTO `tbl_books_information` (`id`, `book_title`, `book_author`, `book_img`, `status`, `timestamp`) VALUES
(1, 'TEsting', 'qweqweqwe', '1704096095.png', 'deleted', '2024-01-01 08:01:35'),
(2, 'TEsting123123', 'asdwqe', '1704096158.png', 'deleted', '2024-01-01 08:02:38'),
(3, 'TEsting', 'edited', '1704193807.png', 'borrowed', '2024-01-02 10:22:32'),
(4, 'qweqwe123', 'wqe23easdasd', '1704193958.png', 'available', '2024-01-02 11:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_borrowed_books`
--

CREATE TABLE `tbl_borrowed_books` (
  `id` bigint(250) NOT NULL,
  `borrower_id` bigint(250) DEFAULT NULL,
  `book_id` bigint(250) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_borrowed_books`
--

INSERT INTO `tbl_borrowed_books` (`id`, `borrower_id`, `book_id`, `timestamp`) VALUES
(129, 1704193980, 3, '2024-01-02 11:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_account`
--

CREATE TABLE `tbl_login_account` (
  `id` bigint(250) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `firstname` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `role` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_login_account`
--

INSERT INTO `tbl_login_account` (`id`, `username`, `password`, `firstname`, `lastname`, `role`, `created_at`) VALUES
(101010101, 'admin', '$2y$10$MJ7HRn/9OwKz1w5cdC8Yj.28E8u1jfQhrkco3GCr1SlhC9L41cfR6', 'Admin', 'Admin', 'admin', '2024-01-01 04:47:53'),
(1704089832, 'asdasd', '$2y$10$lbgh5QA7dh9LT4Eooqe8JO18GIctiJ6Esyx2UMBAik/IhbSqaQffG', 'Testing', 'User', 'user', '2024-01-01 06:17:12'),
(1704193980, 'qweqwe', '$2y$10$J69HSr.zoqziqeXibxlWm.xJBzBaXHd2vvPoINEeMcIs4JJGw4Gk.', 'qweqwe', 'qwe', 'user', '2024-01-02 11:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `id` bigint(250) NOT NULL,
  `borrower_id` bigint(250) DEFAULT NULL,
  `book_id` bigint(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`id`, `borrower_id`, `book_id`, `type`, `description`, `timestamp`) VALUES
(1, 1704089832, 1, 'Borrow', 'Testing User borrowed a book.', '2024-01-02 08:41:11'),
(4, 1704089832, 1, 'Return', 'Testing User borrowed a book.', '2024-01-02 09:03:00'),
(5, 1704089832, 2, 'Borrow', 'Testing User borrowed a book.', '2024-01-02 09:04:18'),
(6, 1704089832, 2, 'Return', 'Testing User borrowed a book.', '2024-01-02 09:04:27'),
(7, 1704089832, 2, 'Borrow', 'Testing User borrowed a book.', '2024-01-02 09:04:42'),
(8, 1704089832, 2, 'Return', 'Testing User borrowed a book.', '2024-01-02 10:05:30'),
(9, 1704089832, 2, 'Borrow', 'Testing User borrowed a book.', '2024-01-02 10:09:16'),
(10, 1704089832, 3, 'Borrow', 'Testing User borrowed a book.', '2024-01-02 11:12:48'),
(11, 1704089832, 4, 'Borrow', 'Testing User borrowed a book.', '2024-01-02 11:12:50'),
(12, 1704089832, 2, 'Return', 'Testing User borrowed a book.', '2024-01-02 11:14:32'),
(13, 1704089832, 3, 'Return', 'Testing User borrowed a book.', '2024-01-02 11:14:35'),
(14, 1704089832, 4, 'Return', 'Testing User borrowed a book.', '2024-01-02 11:14:37'),
(15, 1704193980, 3, 'Borrow', 'qweqwe qwe borrowed a book.', '2024-01-02 11:14:50'),
(16, 1704089832, 4, 'Borrow', 'Testing User borrowed a book.', '2024-01-07 13:35:31'),
(17, 1704089832, 4, 'Return', 'Testing User borrowed a book.', '2024-01-07 13:35:35'),
(18, 1704089832, 4, 'Borrow', 'Testing User borrowed a book.', '2024-01-07 13:40:26'),
(19, 1704089832, 4, 'Return', 'Testing User borrowed a book.', '2024-01-07 13:40:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_books_information`
--
ALTER TABLE `tbl_books_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_borrowed_books`
--
ALTER TABLE `tbl_borrowed_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrower_id` (`borrower_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `tbl_login_account`
--
ALTER TABLE `tbl_login_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrower_id` (`borrower_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_books_information`
--
ALTER TABLE `tbl_books_information`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_borrowed_books`
--
ALTER TABLE `tbl_borrowed_books`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `tbl_login_account`
--
ALTER TABLE `tbl_login_account`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1704193981;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_borrowed_books`
--
ALTER TABLE `tbl_borrowed_books`
  ADD CONSTRAINT `tbl_borrowed_books_ibfk_1` FOREIGN KEY (`borrower_id`) REFERENCES `tbl_login_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_borrowed_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `tbl_books_information` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD CONSTRAINT `tbl_transaction_ibfk_1` FOREIGN KEY (`borrower_id`) REFERENCES `tbl_login_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transaction_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `tbl_books_information` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
