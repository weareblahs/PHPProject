-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2024 at 01:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mts`
--

-- --------------------------------------------------------

--
-- Table structure for table `addon`
--

CREATE TABLE `addon` (
  `addonUniqID` varchar(255) NOT NULL,
  `addonName` varchar(255) NOT NULL,
  `addonPrice` decimal(10,0) NOT NULL,
  `addonImage` varchar(255) NOT NULL,
  `addonDescription` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addonorders`
--

CREATE TABLE `addonorders` (
  `addonOrderID` varchar(255) NOT NULL,
  `addonID` varchar(255) NOT NULL,
  `addonQuantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignedseats`
--

CREATE TABLE `assignedseats` (
  `ticketID` varchar(255) NOT NULL,
  `seat` varchar(255) NOT NULL,
  `assignedShowtimeID` varchar(255) NOT NULL,
  `time` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cinemaexperiences`
--

CREATE TABLE `cinemaexperiences` (
  `uniqID` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `iconPath` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `ticketPrice` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `filmID` varchar(255) NOT NULL DEFAULT '255',
  `experienceID` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '255',
  `altName` varchar(255) DEFAULT 'none',
  `logoPath` varchar(255) NOT NULL,
  `filmRating` varchar(255) NOT NULL,
  `filmGenre` varchar(255) NOT NULL DEFAULT '255',
  `releaseDate` date DEFAULT NULL,
  `isAvailable` tinyint(1) NOT NULL DEFAULT 0,
  `isFeatured` tinyint(1) NOT NULL DEFAULT 0,
  `filmDescription` mediumtext NOT NULL DEFAULT '65536',
  `cast` varchar(255) NOT NULL DEFAULT '255',
  `director` varchar(255) NOT NULL DEFAULT '255',
  `imagePosterPath` varchar(255) NOT NULL DEFAULT '255',
  `artwork` varchar(255) NOT NULL DEFAULT '255',
  `trailerURL` varchar(255) NOT NULL,
  `associatedShowtimeID` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `length` int(3) NOT NULL DEFAULT 0,
  `logoAvailable` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `globalsettings`
--

CREATE TABLE `globalsettings` (
  `intervalTime` int(3) NOT NULL,
  `showStart` varchar(5) NOT NULL,
  `showEnd` varchar(5) NOT NULL,
  `dayValue` varchar(255) NOT NULL,
  `currentGlobalSetting` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `hallUniqID` varchar(255) NOT NULL,
  `hallName` varchar(255) NOT NULL,
  `experienceID` varchar(255) NOT NULL,
  `seatmapDir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `showtimes`
--

CREATE TABLE `showtimes` (
  `filmID` varchar(255) NOT NULL,
  `time` int(10) NOT NULL,
  `showtimeID` varchar(255) NOT NULL,
  `hallID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `userID` varchar(255) NOT NULL,
  `paymentID` varchar(255) NOT NULL,
  `ticketID` varchar(255) NOT NULL,
  `filmID` varchar(255) NOT NULL,
  `totalPrice` int(3) NOT NULL,
  `addonID` varchar(255) NOT NULL DEFAULT '0',
  `isValidated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userorders`
--

CREATE TABLE `userorders` (
  `filmID` varchar(255) NOT NULL,
  `userID` varchar(255) NOT NULL,
  `selectedSeats` varchar(255) NOT NULL,
  `selectedAddonID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userUniqID` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addon`
--
ALTER TABLE `addon`
  ADD UNIQUE KEY `addonUniqID` (`addonUniqID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
