-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 21, 2021 at 02:05 PM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_devexceed`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social_links`
--

CREATE TABLE `tbl_social_links` (
  `links_id` int(11) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `google` varchar(255) NOT NULL,
  `pinterest` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_social_links`
--

INSERT INTO `tbl_social_links` (`links_id`, `facebook`, `linkedin`, `twitter`, `google`, `pinterest`) VALUES
(1, 'https://www.facebook.com/tailemmusicreviews/', '', 'https://twitter.com/TailemMusic', 'https://plus.google.com/u/0/115387622205274597807', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social_username`
--

CREATE TABLE `tbl_social_username` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `network` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_social_username`
--

INSERT INTO `tbl_social_username` (`id`, `fullname`, `network`, `user_id`) VALUES
(1, 'Evs Tester', 'facebook', 64),
(6, 'Evs tester', 'gmail', 64),
(7, 'Peter Jackson', 'facebook', 94),
(8, 'Tailem Testing', 'gmail', 98),
(9, 'Evs tester', 'gmail', 99),
(10, 'Tailem Testing', 'gmail', 100),
(11, 'Leticia Bibon', 'facebook', 100),
(12, 'Leticia Bibon', 'facebook', 101),
(13, 'Tailem Testing', 'gmail', 102),
(14, 'Michael Douglas', 'gmail', 106),
(15, 'Evs Tester', 'facebook', 108),
(16, 'Evs tester', 'gmail', 109),
(17, 'Tailem Testing', 'gmail', 110),
(18, 'Michael Douglas', 'facebook', 119),
(19, 'Michael Douglas', 'facebook', 120),
(20, 'Tailem Music Reviews', 'gmail', 120),
(21, 'Michael Douglas', 'facebook', 121),
(22, 'Tailem Music Reviews', 'gmail', 121),
(23, 'Michael Douglas', 'facebook', 123),
(24, 'Tailem Music Reviews', 'gmail', 123),
(25, 'Kamran Mughal', 'facebook', 124),
(26, 'Michael Douglas', 'facebook', 132),
(27, 'Tailem Music Reviews', 'gmail', 132),
(28, 'Umair Khan', 'facebook', 153),
(29, 'Michael Douglas', 'facebook', 165),
(30, 'Tailem Music Reviews', 'gmail', 165),
(31, 'Amr Abdelhady', 'gmail', 190),
(32, 'Kamran ', 'facebook', 191),
(33, 'Evs tester', 'gmail', 192),
(34, 'Kamran ', 'facebook', 193),
(35, 'Evs tester', 'gmail', 194);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_social_links`
--
ALTER TABLE `tbl_social_links`
  ADD PRIMARY KEY (`links_id`);

--
-- Indexes for table `tbl_social_username`
--
ALTER TABLE `tbl_social_username`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_social_links`
--
ALTER TABLE `tbl_social_links`
  MODIFY `links_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_social_username`
--
ALTER TABLE `tbl_social_username`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
