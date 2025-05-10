-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 10, 2025 at 10:29 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wecare`
--

-- --------------------------------------------------------

--
-- Table structure for table `wecare_signup`
--

DROP TABLE IF EXISTS `wecare_signup`;
CREATE TABLE IF NOT EXISTS `wecare_signup` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','doctor','patient') NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `wecare_signup`
--

INSERT INTO `wecare_signup` (`userid`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', '', 'admin123', 'admin'),
(2, 'sawan', 'sawan@gmail.com', 's', 'patient'),
(3, 'a', 'ad@gmail.com', 'a', 'patient'),
(4, 'q', 'q@gmail.com', 'q', 'patient'),
(5, 'd', 'doc@gmail.com', 'd', 'doctor'),
(6, 'doc', 'd@gmail.com', 'd', 'doctor'),
(7, 'Surya Prakash Singh', 'surya9792844645@gmail.com', '$2y$10$EmPfqYvqPT.MDPLyvLqUvuInwd8jLytVqjQK4TB9W2K50amGLMNY.', 'doctor');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
