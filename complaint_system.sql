-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2023 at 04:53 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complaint_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE `attachment` (
  `attachmentID` int(11) NOT NULL,
  `complaintID` int(11) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attachment`
--

INSERT INTO `attachment` (`attachmentID`, `complaintID`, `position`, `filename`, `type`) VALUES
(1, NULL, NULL, '', NULL),
(2, NULL, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `complaintID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `attachmentID` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT current_timestamp(),
  `modifydate` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `departmentID` int(11) DEFAULT NULL,
  `noteID` int(11) DEFAULT NULL,
  `notification` varchar(255) DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `group_name` varchar(10000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`complaintID`, `title`, `detail`, `category`, `attachmentID`, `createdate`, `modifydate`, `status`, `departmentID`, `noteID`, `notification`, `userID`, `group_name`) VALUES
(1, 'ABC', '12345', NULL, '1', '2023-01-14 01:26:13', NULL, 'kiv', 1, NULL, NULL, 1, NULL),
(2, 'Testing 123', 'Checking', NULL, '2', '2023-01-14 23:05:20', NULL, 'pending', 1, NULL, NULL, 1, NULL),
(3, 'GG', 'eghwreb', NULL, '3', '2023-01-14 23:33:11', '2023-01-14 16:32:55', 'active', NULL, NULL, NULL, 2, NULL),
(4, 'rtnbrwn', 'erwnwrn', NULL, '4', '2023-01-14 23:36:09', '2023-01-14 16:35:49', 'closed', NULL, NULL, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_ID` int(11) NOT NULL,
  `department_name` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_ID`, `department_name`) VALUES
(1, 'Registration'),
(2, 'FICT'),
(3, 'FAME'),
(4, 'Library');

-- --------------------------------------------------------

--
-- Table structure for table `notetable`
--

CREATE TABLE `notetable` (
  `noteID` int(11) NOT NULL,
  `complaintID` int(11) NOT NULL,
  `notetext` varchar(10000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `helpdesk` tinyint(1) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `departmentID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `name`, `role`, `email`, `helpdesk`, `image`, `departmentID`) VALUES
(1, 'admin', '123', 'admin', 'admin', 'admin@gmail.com', 1, NULL, 1),
(2, 'wongjunann0227', 'Junann97', NULL, 'student', 'wongjunann0227@newera.edu.my', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`attachmentID`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`complaintID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_ID`);

--
-- Indexes for table `notetable`
--
ALTER TABLE `notetable`
  ADD PRIMARY KEY (`noteID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `attachmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `complaintID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notetable`
--
ALTER TABLE `notetable`
  MODIFY `noteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
