-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 21, 2021 at 01:49 PM
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
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_seo` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL DEFAULT 'Male',
  `user_email` varchar(255) NOT NULL,
  `simple_password` varchar(255) NOT NULL,
  `encrypted_password` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `region` varchar(255) NOT NULL,
  `about_me` text NOT NULL,
  `date_added` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `last_login_date` int(11) NOT NULL,
  `active_counter` int(1) NOT NULL DEFAULT '0',
  `is_top_member` int(1) NOT NULL,
  `last_review` int(11) NOT NULL,
  `last_comment` int(11) NOT NULL,
  `fb_id` varchar(50) NOT NULL,
  `oauth_provider` varchar(100) NOT NULL,
  `google_oauth_uid` varchar(100) NOT NULL,
  `link` varchar(50) NOT NULL,
  `modified_on` datetime NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_name`, `user_seo`, `fname`, `lname`, `gender`, `user_email`, `simple_password`, `encrypted_password`, `country_id`, `region`, `about_me`, `date_added`, `status`, `profile_image`, `activation_code`, `last_login_date`, `active_counter`, `is_top_member`, `last_review`, `last_comment`, `fb_id`, `oauth_provider`, `google_oauth_uid`, `link`, `modified_on`, `created_on`) VALUES
(54, 'faulknerreviews', 'faulknerreviews', '', '', 'Male', 'input1@tailem.com', 'testing123', '7f2ababa423061c509f4923dd04b6cf1', 0, '', '', 1482311843, 1, '', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-07-17 21:31:33'),
(55, 'Tailem', 'Tailem', '', '', 'Male', 'input@tailem.com', 'test1234', '16d7a4fca7442dda3ad93c9a726597e4', 0, '', '', 1482542860, 1, '164196664_tailem.com logo.png', '', 0, 0, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-02-08 07:07:44'),
(186, 'Tailem Music Reviews', 'Tailem_Music_Reviews', '', '', 'Male', 'info@tailem.com', 'lolsrs1313', '6b637867b6e75063decbf15d1cb582ef', 0, '', '', 1500168206, 1, '', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-07-16 01:23:26'),
(188, 'dorat88', 'dorat88', '', '', 'Male', 'input2@tailem.com', 'tailem123', '0bc0b359dc67038d11472b6cbcf2c714', 0, '', '', 1500199933, 1, '1260269956_dorat88.png', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-07-16 10:37:30'),
(189, 'victoriaemilova', 'victoriaemilova', '', '', 'Male', 'victoria.emilova@yahoo.com', 'zvezda77', 'c05cbb86f5188283108ccbcbea17b23c', 0, '', '', 1500286175, 1, '737408635_music.png', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-07-17 12:31:39'),
(190, 'Amr Abdelhady', 'Amr_Abdelhady', 'Amr', 'Abdelhady', '', 'amrabdelhadi94@gmail.com', '19572191', '6c7401928499a9dbf576cce139afc6bb', 0, '', '', 1500290894, 1, '', '', 0, 0, 0, 0, 0, '', 'google', '106325877148664127629', '', '2017-07-17 21:28:14', '2017-07-20 09:16:54'),
(193, 'Kamran Sohail', 'Kamran_Sohail', 'Kamran', '', 'Male', 'evs.kamran@gmail.com', '58066', '7a737701149111e508f97116bf21f116', 0, '', '', 1500382323, 1, '', '', 1500382323, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-07-18 12:52:03'),
(194, 'Evs tester', 'Evs_tester', 'Evs', 'tester', 'male', 'evs.tester@gmail.com', '70673058', '1334c3bf825a2814b317212d50063585', 0, '', '', 1500383063, 1, 'Evs_1500383063.png', '', 0, 0, 0, 0, 0, '', 'google', '116370122673647047039', 'https://plus.google.com/116370122673647047039', '2017-07-18 23:04:23', '2017-07-18 13:04:23'),
(196, 'Raahim Jaan', 'Raahim_Jaan', '', '', 'Male', 'maryaan812@gmail.com', 'pass1234', 'b4af804009cb036a4ccdc33431ef9ac9', 0, '', '', 1500532673, 1, '', '', 0, 0, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-07-20 06:37:53'),
(199, 'Limond', 'Limond', '', '', 'Male', 'Darren.limon@bigpond.com', 'nissan', '8928603cd5f39e8583cf8becbc180bd2', 0, '', '', 1500983797, 1, '1305527783_IMG_20170710_165701.jpg', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-07-26 10:56:38'),
(200, 'Vijay Lal', 'Vijay_Lal', '', '', 'Male', 'contactvijaylal@gmail.com', 'p@ssw0rd1111', 'd989af0d32dd2db2646e274188273655', 0, '', '', 1502394659, 1, '', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-08-10 19:50:59'),
(201, 'test', 'test', '', '', 'Male', 'synapse979@gmail.com', 'p@ssw0rd1111', 'd989af0d32dd2db2646e274188273655', 0, '', '', 1503038625, 1, '728251103_1000x1000bb-85.jpg', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2017-08-18 06:44:35'),
(202, 'testingabc', 'testingabc', '', '', 'Male', 'testingabc@tailem.com', 'test1234', '16d7a4fca7442dda3ad93c9a726597e4', 0, '', '', 1629444946, 1, '', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2021-08-20 07:35:46'),
(203, 'test123', 'test123', '', '', 'Male', 'test123@tailem.com', 'test1234', '16d7a4fca7442dda3ad93c9a726597e4', 0, '', '', 1629448613, 1, '', '', 0, 1, 0, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '2021-08-20 08:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_playlist`
--

CREATE TABLE `tbl_user_playlist` (
  `id` int(11) NOT NULL,
  `title_playlist` varchar(255) NOT NULL,
  `title_playlist_seo` varchar(255) NOT NULL,
  `user_id_playlist` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `posted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_playlist`
--

INSERT INTO `tbl_user_playlist` (`id`, `title_playlist`, `title_playlist_seo`, `user_id_playlist`, `song_id`, `artist_id`, `posted_date`) VALUES
(1, 'Playlist 1', 'playlist-1', 53, 1030597947, 201714418, '2017-04-14 22:26:41'),
(3, 'PoP Song', 'pop-song', 53, 1030597947, 201714418, '2017-04-14 23:19:15'),
(25, 'This is a test', 'this-is-a-test', 53, 1030597947, 201714418, '2017-04-18 07:34:44'),
(26, 'This is a test1', 'this-is-a-test1', 53, 1030597947, 201714418, '2017-04-18 07:36:17'),
(28, 'This is a test', 'this-is-a-test', 162, 1030597947, 201714418, '2017-04-18 07:43:33'),
(30, 'Top Music', 'top-music', 53, 1030597947, 201714418, '2017-04-18 20:55:42'),
(35, 'One', 'one', 64, 1049605633, 320569549, '2017-04-21 22:29:16'),
(36, 'Meh 2', 'meh-2', 155, 378423783, 111051, '2017-04-22 09:56:58'),
(38, 'This is test', 'this-is-test', 53, 378423783, 111051, '2017-04-25 10:37:08'),
(39, 'Playlist 1', 'playlist-1', 155, 378423783, 111051, '2017-04-25 10:49:37'),
(40, 'Playlist 2', 'playlist-2', 155, 378423783, 111051, '2017-04-25 10:54:37'),
(41, 'a', 'a', 155, 378423783, 111051, '2017-04-25 10:54:52'),
(42, 'ab', 'ab', 155, 378423783, 111051, '2017-04-25 10:54:57'),
(43, 'abc', 'abc', 155, 378423783, 111051, '2017-04-25 10:55:04'),
(44, 'abcd', 'abcd', 155, 378423783, 111051, '2017-04-25 10:55:09'),
(45, 'abcde', 'abcde', 155, 378423783, 111051, '2017-04-25 10:55:15'),
(46, 'abcdef', 'abcdef', 155, 378423783, 111051, '2017-04-25 10:55:18'),
(47, 'abcdefg', 'abcdefg', 155, 378423783, 111051, '2017-04-25 10:55:21'),
(48, 'abcdefgh', 'abcdefgh', 155, 378423783, 111051, '2017-04-25 10:55:25'),
(49, 'abcdefghi', 'abcdefghi', 155, 378423783, 111051, '2017-04-25 10:55:28'),
(53, 'Hello', 'hello', 53, 378423783, 111051, '2017-04-26 20:26:38'),
(54, 'Testing Latest Activity', 'testing-latest-activity', 53, 378423783, 111051, '2017-04-27 07:47:38'),
(57, 'This is test', 'this-is-test', 164, 378423786, 111051, '2017-05-07 16:19:17'),
(59, 'Create new playlist', 'create-new-playlist', 165, 378423786, 111051, '2017-05-07 16:53:30'),
(60, 'This is test 2', 'this-is-test-2', 166, 1156172785, 479756766, '2017-05-08 12:49:24'),
(62, 'Sigh', 'sigh', 166, 1156172785, 479756766, '2017-05-08 12:51:26'),
(64, 'This is test2', 'this-is-test2', 167, 378423786, 111051, '2017-05-08 14:11:28'),
(65, 'xcx', 'xcx', 163, 1030597947, 201714418, '2017-05-08 20:38:36'),
(66, 'This is test', 'this-is-test', 168, 1030597947, 201714418, '2017-05-09 07:39:24'),
(67, 'two', 'two', 64, 731756777, 111051, '2017-05-10 16:34:36'),
(68, 'three', 'three', 64, 731756777, 111051, '2017-05-10 16:34:43'),
(69, 'thisistest', 'thisistest', 173, 378423786, 111051, '2017-05-15 22:03:26'),
(70, 'thisistest2', 'thisistest2', 173, 378423786, 111051, '2017-05-15 22:03:44'),
(71, 'thisistest3', 'thisistest3', 173, 1042495958, 111051, '2017-05-15 22:07:07'),
(72, 'This is test 2', 'this-is-test-2', 177, 935860153, 111051, '2017-05-21 21:40:29'),
(74, 'This is test 3', 'this-is-test-3', 178, 378423786, 111051, '2017-05-22 20:47:15'),
(75, 'This is test 2', 'this-is-test-2', 178, 378423786, 111051, '2017-05-22 20:47:22'),
(76, 'This is Test', 'this-is-test', 183, 1047366878, 111051, '2017-06-04 14:53:54'),
(78, 'This is test', 'this-is-test', 184, 1187423474, 302533564, '2017-06-04 15:41:56'),
(79, 'This is', 'this-is', 185, 206535843, 111051, '2017-06-04 16:38:03'),
(80, 'playlist1', 'playlist1', 200, 1030597947, 201714418, '2017-08-11 05:51:45'),
(81, '1', '1', 201, 1049605649, 320569549, '2017-09-04 18:55:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_playlist_songs`
--

CREATE TABLE `tbl_user_playlist_songs` (
  `id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `p_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_playlist_songs`
--

INSERT INTO `tbl_user_playlist_songs` (`id`, `playlist_id`, `user_id`, `song_id`, `artist_id`, `p_date`) VALUES
(57, 1, 53, 378423786, 111051, '2017-04-23 00:00:00'),
(92, 3, 53, 1030597947, 201714418, '2017-04-23 00:00:00'),
(93, 3, 53, 560398388, 554290495, '2017-04-23 00:00:00'),
(94, 35, 64, 1049605633, 320569549, '2017-04-23 00:00:00'),
(98, 35, 64, 907242703, 159260351, '2017-04-23 00:00:00'),
(102, 25, 53, 1156172785, 479756766, '2017-04-23 00:00:00'),
(110, 38, 53, 1077515660, 111051, '2017-04-23 00:00:00'),
(111, 38, 53, 1077515661, 111051, '2017-04-23 00:00:00'),
(112, 38, 53, 1077515662, 111051, '2017-04-23 00:00:00'),
(113, 38, 53, 1077515663, 111051, '2017-04-23 00:00:00'),
(114, 38, 53, 1077515664, 111051, '2017-04-23 00:00:00'),
(115, 38, 53, 1077515665, 111051, '2017-04-23 00:00:00'),
(116, 38, 53, 1077515669, 111051, '2017-04-23 00:00:00'),
(117, 38, 53, 1077515671, 111051, '2017-04-23 00:00:00'),
(118, 38, 53, 1077515672, 111051, '2017-04-23 00:00:00'),
(119, 38, 53, 1077515674, 111051, '2017-04-23 00:00:00'),
(120, 38, 53, 1077515675, 111051, '2017-04-23 00:00:00'),
(126, 36, 155, 378423783, 111051, '2017-04-23 00:00:00'),
(127, 39, 155, 378423783, 111051, '2017-04-23 00:00:00'),
(128, 44, 155, 378423783, 111051, '2017-04-23 00:00:00'),
(133, 38, 53, 1047366878, 111051, '2017-04-23 00:00:00'),
(135, 1, 53, 378423783, 111051, '2017-04-23 00:00:00'),
(136, 30, 53, 378423783, 111051, '2017-04-23 00:00:00'),
(149, 25, 53, 690928331, 64387566, '2017-04-26 23:03:24'),
(150, 54, 53, 378423783, 111051, '2017-04-27 07:47:42'),
(151, 54, 53, 378423833, 111051, '2017-05-02 07:52:49'),
(153, 1, 53, 1012587649, 111051, '2017-05-04 09:32:43'),
(155, 25, 53, 1030597947, 201714418, '2017-05-04 20:17:45'),
(159, 57, 164, 378423786, 111051, '2017-05-07 16:34:21'),
(161, 57, 164, 1047366878, 111051, '2017-05-07 16:43:50'),
(162, 57, 164, 378423783, 111051, '2017-05-07 16:44:09'),
(163, 59, 165, 378423786, 111051, '2017-05-07 16:53:32'),
(166, 60, 166, 1156172785, 479756766, '2017-05-08 12:50:23'),
(170, 64, 167, 378423786, 111051, '2017-05-08 14:11:41'),
(171, 65, 163, 1030597947, 201714418, '2017-05-08 20:38:40'),
(172, 66, 168, 1030597947, 201714418, '2017-05-09 07:39:29'),
(173, 54, 53, 1030597947, 201714418, '2017-05-09 07:40:23'),
(174, 54, 53, 560398388, 554290495, '2017-05-09 07:41:04'),
(175, 3, 53, 690928331, 64387566, '2017-05-09 15:38:25'),
(177, 30, 53, 690928331, 64387566, '2017-05-09 15:56:21'),
(178, 26, 53, 690928331, 64387566, '2017-05-09 16:02:22'),
(180, 3, 53, 1013027556, 64387566, '2017-05-09 16:03:50'),
(181, 26, 53, 1013027556, 64387566, '2017-05-09 16:04:11'),
(182, 26, 53, 1030597947, 201714418, '2017-05-10 08:20:30'),
(191, 30, 53, 1030597947, 201714418, '2017-05-11 07:28:24'),
(193, 30, 53, 1049605633, 320569549, '2017-05-11 07:28:52'),
(199, 71, 173, 378423797, 111051, '2017-05-15 22:14:53'),
(200, 38, 53, 378423786, 111051, '2017-05-16 20:58:11'),
(201, 3, 53, 1017954, 111051, '2017-05-16 21:08:00'),
(202, 3, 53, 1012587722, 111051, '2017-05-16 21:08:11'),
(203, 3, 53, 1187423474, 302533564, '2017-05-17 15:37:35'),
(204, 38, 53, 1187423474, 302533564, '2017-05-18 20:08:52'),
(206, 72, 177, 935860153, 111051, '2017-05-21 21:40:36'),
(209, 75, 178, 378423786, 111051, '2017-05-22 20:47:28'),
(210, 74, 178, 378423786, 111051, '2017-05-22 20:48:22'),
(211, 74, 178, 378423783, 111051, '2017-05-22 20:52:21'),
(212, 38, 53, 1012587649, 111051, '2017-05-25 21:01:26'),
(215, 76, 183, 1047366878, 111051, '2017-06-04 14:54:16'),
(216, 76, 183, 378423786, 111051, '2017-06-04 14:54:50'),
(217, 76, 183, 206535644, 111051, '2017-06-04 14:58:57'),
(218, 76, 183, 1187423474, 302533564, '2017-06-04 14:59:07'),
(220, 78, 184, 1187423474, 302533564, '2017-06-04 15:41:58'),
(222, 78, 184, 378423786, 111051, '2017-06-04 15:44:22'),
(223, 79, 185, 206535843, 111051, '2017-06-04 16:38:05'),
(224, 79, 185, 345758267, 111051, '2017-06-04 16:38:16'),
(225, 79, 185, 1187423474, 302533564, '2017-06-04 16:38:25'),
(226, 80, 200, 1030597947, 201714418, '2017-08-11 05:51:50'),
(227, 81, 201, 1049605649, 320569549, '2017-09-04 18:55:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `tbl_user_playlist`
--
ALTER TABLE `tbl_user_playlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_playlist_songs`
--
ALTER TABLE `tbl_user_playlist_songs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;
--
-- AUTO_INCREMENT for table `tbl_user_playlist`
--
ALTER TABLE `tbl_user_playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `tbl_user_playlist_songs`
--
ALTER TABLE `tbl_user_playlist_songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
