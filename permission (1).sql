-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2023 at 12:29 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baheer`
--

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` bigint(20) NOT NULL,
  `title` varchar(256) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` tinytext DEFAULT NULL,
  `page` varchar(128) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `title`, `slug`, `description`, `page`, `status`, `created_at`, `updated_at`) VALUES
(23, 'View Job Processing Form Page', '258', 'enable user to view Job Processing Form Page Job under process option of job center manage page', 'ARCHIVE DEPARTMENT', 0, '0000-00-00 00:00:00', NULL),
(24, 'View Create Polymer Button JP', '259', 'enable user to view Create Polymer Button in  Job processing form of manage button ', 'ARCHIVE DEPARTMENT', 0, '0000-00-00 00:00:00', NULL),
(25, 'View Create Die Button JP', '260', 'enable user to view Create Die Button  in Job Processing form of manage ', 'ARCHIVE DEPARTMENT', 0, '0000-00-00 00:00:00', NULL),
(26, 'View Polymer & Die Center Page', '261', 'enable user to view Polymer & Die Center Page of Archive ', 'ARCHIVE DEPARTMENT', 0, '0000-00-00 00:00:00', NULL),
(27, 'View Create Polymer Button Pad', '262', 'enable user to view Create Polymer Button of Polymer and Die center page of Archive dept', 'ARCHIVE DEPARTMENT', 0, '0000-00-00 00:00:00', NULL),
(28, 'View Create Die Button Pad', '263', 'enable user to view Create Die Button of Polymer and Die center of Archive dept', 'ARCHIVE DEPARTMENT', 0, '0000-00-00 00:00:00', NULL),
(29, 'View Archive Product List Page', '264', 'enable user to View Archive Product List Page of Archive dept', 'ARCHIVE DEPARTMENT', 0, '0000-00-00 00:00:00', NULL),
(30, 'View Report Page Of Archive', '265', 'enable user to View Report Page Of Archive dept', 'ARCHIVE DEPARTMENT', 0, '0000-00-00 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
