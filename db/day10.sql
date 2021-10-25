-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 25, 2021 at 01:38 AM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `day10`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(50) DEFAULT NULL,
  `admin_password` varchar(50) DEFAULT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_contact` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Checkin`
--

CREATE TABLE `Checkin` (
  `checkin_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Company`
--

CREATE TABLE `Company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_branch` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Company`
--

INSERT INTO `Company` (`company_id`, `company_name`, `company_branch`, `date_created`) VALUES
(1, 'Company Amal', 'HQ', '2021-10-25 09:21:32'),
(2, 'Company Amal', 'Branch 1', '2021-10-25 09:21:51'),
(3, 'Company Amal', 'Branch 2', '2021-10-25 09:21:51'),
(4, 'Company Kita', 'HQ', '2021-10-25 09:22:13'),
(5, 'Company Kita', 'Branch 1', '2021-10-25 09:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE `Customers` (
  `customer_id` int(11) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_password` text,
  `customer_name` varchar(100) NOT NULL,
  `customer_phoneNum` varchar(50) NOT NULL,
  `customer_status` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Customers`
--

INSERT INTO `Customers` (`customer_id`, `customer_email`, `customer_password`, `customer_name`, `customer_phoneNum`, `customer_status`, `date_created`) VALUES
(3, 'amaluddinasyraf@invokeisdata.com', NULL, 'Amaluddin', '12113323132', 0, '2021-10-22 17:23:08'),
(5, 'testmail@mail.com', NULL, 'Amaluddin', '99999999999', 0, '2021-10-24 22:44:54'),
(6, 'testmail1@mail.com', NULL, 'Amaluddin', '1111111111', 0, '2021-10-24 22:59:14'),
(7, 'testmail2@mail.com', NULL, 'Amaluddin', '555555555', 0, '2021-10-24 23:17:32'),
(8, 'testmail3@mail.com', NULL, 'Amaluddin', '22222222', 0, '2021-10-24 23:43:27'),
(9, 'testmail4@mail.com', NULL, 'Amaluddin', '1234567890', 0, '2021-10-24 23:56:28'),
(10, 'testmail5@mail.com', NULL, 'Amaluddin', '1234567890', 0, '2021-10-24 23:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `Location`
--

CREATE TABLE `Location` (
  `location_id` int(11) NOT NULL,
  `address_line1` varchar(100) NOT NULL,
  `address_line2` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Location`
--

INSERT INTO `Location` (`location_id`, `address_line1`, `address_line2`, `city`, `state`, `company_id`) VALUES
(1, 'Jalan Company Amal', 'Bandar Baru', 'Kuantan', 'Pahang', 1),
(2, 'Jalan Company 1', 'Bandar Baru', 'Kuantan', 'Pahang', 2),
(3, 'Jalan Company 2', 'Bandar Baru', 'Kuantan', 'Pahang', 3),
(4, 'Jalan Company 2 Branch HQ', 'Bandar Baru', 'Kuantan', 'Pahang', 4),
(5, 'Jalan Kita', 'Bandar Baru', 'Kuantan', 'Pahang', 5);

-- --------------------------------------------------------

--
-- Table structure for table `TAC`
--

CREATE TABLE `TAC` (
  `tac_id` int(11) NOT NULL,
  `tacNum` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TAC`
--

INSERT INTO `TAC` (`tac_id`, `tacNum`, `date_created`, `customer_id`) VALUES
(1, 634251, '2021-10-24 23:23:15', 7),
(2, 829314, '2021-10-24 23:46:59', 8),
(3, 918226, '2021-10-24 23:56:58', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `Checkin`
--
ALTER TABLE `Checkin`
  ADD PRIMARY KEY (`checkin_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `Company`
--
ALTER TABLE `Company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `Customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email` (`customer_email`);

--
-- Indexes for table `Location`
--
ALTER TABLE `Location`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `TAC`
--
ALTER TABLE `TAC`
  ADD PRIMARY KEY (`tac_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Checkin`
--
ALTER TABLE `Checkin`
  MODIFY `checkin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Company`
--
ALTER TABLE `Company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Customers`
--
ALTER TABLE `Customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Location`
--
ALTER TABLE `Location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `TAC`
--
ALTER TABLE `TAC`
  MODIFY `tac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Checkin`
--
ALTER TABLE `Checkin`
  ADD CONSTRAINT `checkin_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `Location` (`location_id`),
  ADD CONSTRAINT `checkin_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`customer_id`);

--
-- Constraints for table `Location`
--
ALTER TABLE `Location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `Company` (`company_id`);

--
-- Constraints for table `TAC`
--
ALTER TABLE `TAC`
  ADD CONSTRAINT `tac_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
