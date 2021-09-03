-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 21, 2021 at 02:06 PM
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
-- Table structure for table `tbl_gcomment_report`
--

CREATE TABLE `tbl_gcomment_report` (
  `gc_report_id` int(11) NOT NULL,
  `gc_report_comment_id` int(11) NOT NULL,
  `gc_report_user_id` int(11) NOT NULL,
  `gc_report_deatil` text NOT NULL,
  `gc_report_date` int(11) NOT NULL,
  `gc_report_status` int(1) NOT NULL,
  `gc_report_ip` varchar(50) NOT NULL,
  `gc_report_option` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_gcomment_report`
--

INSERT INTO `tbl_gcomment_report` (`gc_report_id`, `gc_report_comment_id`, `gc_report_user_id`, `gc_report_deatil`, `gc_report_date`, `gc_report_status`, `gc_report_ip`, `gc_report_option`) VALUES
(1, 7, 4, 'We are in progress', 1388488806, 1, '58.65.172.229', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_comments`
--

CREATE TABLE `tbl_general_comments` (
  `gcomment_id` int(11) NOT NULL,
  `gcomment_user_id` int(11) NOT NULL,
  `gcomment_cat_id` int(11) NOT NULL,
  `gcomment_detail` text NOT NULL,
  `gcomment_post_date` int(11) NOT NULL,
  `gcomment_status` int(1) NOT NULL,
  `gcomment_ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_general_comments`
--

INSERT INTO `tbl_general_comments` (`gcomment_id`, `gcomment_user_id`, `gcomment_cat_id`, `gcomment_detail`, `gcomment_post_date`, `gcomment_status`, `gcomment_ip`) VALUES
(2, 5, 31, 'Test for eloctronics2', 1385212916, 1, '58.65.172.229'),
(3, 4, 31, 'This is a new general comment Test', 1385376987, 1, '58.65.172.229'),
(4, 1, 39, 'This is general comments', 1385379568, 1, '58.65.172.229'),
(5, 7, 35, 'Cool', 1385412402, 1, '121.219.80.96'),
(6, 1, 31, 'This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. This is 1 more comment. ', 1386658213, 1, '58.65.172.229'),
(7, 21, 31, 'my general comment\'', 1387793368, 1, '58.65.172.229'),
(8, 21, 43, 'kamran\'s genral comment', 1387793395, 1, '58.65.172.229'),
(9, 1, 50, 'Hello, we are Testing', 1388660863, 1, '58.65.172.229'),
(11, 5, 43, 'This is a discussion forum', 1392375470, 1, '200.200.200.1'),
(13, 31, 51, 'adadada', 1397030461, 1, '121.219.227.3'),
(15, 4, 43, 'This is one man fish against test ', 1398768675, 1, '200.200.200.1'),
(16, 4, 43, 'We are in progress with url structure1', 1400068768, 1, '200.200.200.1'),
(17, 4, 53, 'ssss', 1401188986, 1, '200.200.200.1'),
(18, 4, 53, 'fdffdsffffd', 1401188997, 1, '200.200.200.1'),
(19, 4, 53, 'This is testing', 1401189220, 1, '200.200.200.1'),
(21, 4, 35, 'This is new comment', 1407145952, 1, '200.200.200.1'),
(22, 4, 43, 'This is update testing...', 1407153287, 1, '200.200.200.1'),
(24, 4, 51, 'sdsdsdf', 1407840563, 1, '200.200.200.1'),
(25, 31, 51, 'dqdqd fwdqdq dqdqd', 1409296744, 1, '101.160.137.89'),
(26, 4, 31, 'We are in progress fdergg', 1409655576, 1, '200.200.200.1'),
(27, 4, 43, 'sss', 1411099159, 1, '200.200.200.1'),
(28, 4, 43, 'This is new discussion', 1411099220, 1, '200.200.200.1'),
(31, 4, 43, 'sss', 1411099547, 1, '200.200.200.1'),
(32, 4, 43, 'dddd', 1411100393, 1, '200.200.200.1'),
(35, 4, 43, 'this is testing dis', 1411105572, 1, '200.200.200.1'),
(37, 4, 31, 'asddssdsd12', 1411186091, 1, '101.160.137.89'),
(38, 1, 43, 'This is new discussion by umair', 1411471887, 1, '200.200.200.1'),
(39, 1, 43, 'This is new discussion2 from umair', 1411472005, 1, '200.200.200.1'),
(40, 31, 50, 'adad Ssfwdd fwf', 1411544405, 1, '101.160.137.89'),
(41, 4, 43, 'sjdcnjdjad ', 1412838573, 1, '101.160.137.89'),
(42, 4, 30, 'This is new comment', 1414393043, 1, '200.200.200.1'),
(43, 4, 30, 'This is testing discussion', 1414393059, 1, '200.200.200.1'),
(44, 21, 30, 's', 1414763049, 1, '200.200.200.1'),
(45, 16, 30, 'ssss', 1414763130, 1, '200.200.200.1'),
(46, 16, 30, 'ddd', 1414763450, 1, '200.200.200.1'),
(47, 21, 30, 'sdf', 1414763553, 1, '200.200.200.1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_comments_likes`
--

CREATE TABLE `tbl_general_comments_likes` (
  `g_comment_like_id` int(11) NOT NULL,
  `g_comment_id` int(11) NOT NULL,
  `g_comment_cat_id` int(11) NOT NULL,
  `g_comment_like_user_id` int(11) NOT NULL,
  `g_comment_like_receive_user_id` int(11) NOT NULL,
  `g_comment_like_date` int(11) NOT NULL,
  `g_comment_like_status` int(1) NOT NULL,
  `g_comment_like_ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_general_comments_likes`
--

INSERT INTO `tbl_general_comments_likes` (`g_comment_like_id`, `g_comment_id`, `g_comment_cat_id`, `g_comment_like_user_id`, `g_comment_like_receive_user_id`, `g_comment_like_date`, `g_comment_like_status`, `g_comment_like_ip`) VALUES
(4, 2, 31, 7, 0, 1385412515, 1, '121.219.80.96'),
(8, 3, 31, 1, 0, 1388994265, 1, '58.65.172.229'),
(12, 11, 31, 1, 0, 1389852282, 1, '200.200.200.1'),
(21, 8, 43, 5, 21, 1392266317, 1, '200.200.200.1'),
(25, 3, 31, 5, 4, 1396961923, 1, '200.200.200.1'),
(27, 3, 31, 16, 4, 1397563181, 1, '200.200.200.1'),
(44, 22, 43, 16, 4, 1407218847, 1, '200.200.200.1'),
(45, 19, 53, 16, 4, 1407220481, 1, '200.200.200.1'),
(46, 19, 53, 31, 4, 1408711550, 1, '101.160.137.89'),
(47, 2, 31, 1, 5, 1409208462, 1, '200.200.200.1'),
(48, 7, 31, 1, 21, 1409210612, 1, '200.200.200.1'),
(49, 22, 43, 31, 4, 1411543881, 1, '101.160.137.89'),
(50, 6, 31, 4, 1, 1413271523, 1, '200.200.200.1'),
(51, 13, 51, 4, 31, 1414393102, 1, '200.200.200.1'),
(52, 25, 51, 4, 31, 1414393109, 1, '200.200.200.1'),
(62, 42, 30, 16, 4, 1414760378, 1, '200.200.200.1'),
(64, 43, 30, 16, 4, 1414761555, 1, '200.200.200.1'),
(68, 42, 30, 21, 4, 1414761945, 1, '200.200.200.1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_review`
--

CREATE TABLE `tbl_general_review` (
  `g_review_id` int(11) NOT NULL,
  `g_review_suggestion` varchar(500) NOT NULL,
  `g_review_category` varchar(500) NOT NULL,
  `g_review_title` varchar(500) NOT NULL,
  `g_review_detail` text NOT NULL,
  `g_review_rating` float NOT NULL,
  `g_review_user_id` int(11) NOT NULL,
  `g_review_ip` varchar(50) NOT NULL,
  `greview_image` varchar(1000) NOT NULL,
  `g_review_post_date` int(11) NOT NULL,
  `g_status` int(1) NOT NULL,
  `g_review_allocated` enum('No','Yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_general_review`
--

INSERT INTO `tbl_general_review` (`g_review_id`, `g_review_suggestion`, `g_review_category`, `g_review_title`, `g_review_detail`, `g_review_rating`, `g_review_user_id`, `g_review_ip`, `greview_image`, `g_review_post_date`, `g_status`, `g_review_allocated`) VALUES
(7, 'Product', 'Business', 'Business flow', 'State accurate facts and be objective State accurate facts and be objective State accurate facts and be objective State accurate facts and be objective State accurate facts and be objective', 10, 1, '58.65.172.229', '', 1385464930, 1, 'No'),
(8, 'Mobile game', 'Games', 'This is new Test', 'This is details', 10, 1, '58.65.172.229', '', 1385465319, 1, 'No'),
(9, 'Mobile game', 'Games', 'This is new Test', 'This is details', 10, 1, '58.65.172.229', '', 1385465319, 1, 'No'),
(10, 'Services', 'Marketing', 'Marketing Rules', 'Please provide enough detail for our team to allocate your review into the right category.Please provide enough detail for our team to allocate your review into the right category.Please provide enough detail for our team to allocate your review into the right category.Please provide enough detail for our team to allocate your review into the right category.', 10, 4, '58.65.172.229', '', 1386590108, 1, 'No'),
(11, 'Can\\\'t find the Review topic as', 'Can\\\'t find the Review topic', 'Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you', 'Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.\\nCan\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.', 4, 4, '58.65.172.229', '', 1387362545, 1, 'No'),
(12, 'My tom', 'Game', 'My talking Tom', 'My talking tom is best one. My kid like this game very much, specially he wants to feed cat all time does not matter how much coins spend', 10, 21, '58.65.172.229', '', 1387793774, 1, 'No'),
(13, 'Producat and services', 'Services', 'This is test for image', 'Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.', 10, 4, '200.200.200.1', '', 1391602136, 1, 'No'),
(14, 'Producat and services', 'Services', 'This is test for image', 'Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.Can\\\'t find the Review topic you are looking for? Please complete this form and we\\\'ll create your review topic especially for you.', 10, 4, '200.200.200.1', '', 1391602172, 1, 'No'),
(15, 'Producat and services', 'Services', 'This is new review image', 'This is new review image.State accurate facts and be objective State accurate facts and be objective State accurate facts and be objective State accurate facts and be objective State accurate facts and be objective', 10, 4, '200.200.200.1', '', 1391602245, 1, 'No'),
(16, 'Folk music', 'Music', 'art music and folk music', 'Music is an art form whose medium is sound and silence. Its common elements are pitch (which governs melody and harmony), rhythm (and its associated concepts tempo, meter, and articulation), dynamics, and the sonic qualities of timbre and texture. The word derives from Greek μουσική (mousike; \\"art of the Muses\\").[1]\\n\\nThe creation, performance, significance, and even the definition of music vary according to culture and social context. Music ranges from strictly organized compositions (and their recreation in performance), through improvisational music to aleatoric forms. Music can be divided into genres and subgenres, although the dividing lines and relationships between music genres are often subtle, sometimes open to personal interpretation, and occasionally controversial. Within the arts, music may be classified as a performing art, a fine art, and auditory art. It may also be divided among art music and folk music. There is also a strong connection between music and mathematics.[2] Music may be played and heard live, may be part of a dramatic work or film, or may be recorded.', 9, 4, '200.200.200.1', '1201102764_animation.jpg', 1392187306, 1, 'No'),
(17, 'Computer accessories', 'USB', 'Kingston USB', 'This usb is awesome, I am using this from last few months and it is working perfectly.', 10, 4, '200.200.200.1', '', 1397541062, 1, 'No'),
(18, 'Computer accessories', 'Laptops', 'HP CQC15', 'Hi Folks, this laptop is really great to use. I have pretty nice experience with this. You can enjoy this Laptop if you are planing to purchase a new one.', 10, 4, '200.200.200.1', '1558872860_hp-laptop-3.jpg', 1397541319, 1, 'No'),
(19, '3G Technologies', 'Mobile & Internet', '3G Technology', 'Lorem ipsum dolor sit amet, consectetueradipiscing elit. Nam cursus. Morbi ut mi. Nullam enim leo, egestas id, condimentum at, laoreet mattis, massa. Sed eleifend onummy diam.\\n\\nLorem ipsum dolor sit amet, consectetueradipiscing elit. Nam cursus. Morbi ut mi. Nullam enim leo, egestas id, condimentum at, laoreet mattis, massa. Sed eleifend onummy diam.\\n\\nLorem ipsum dolor sit amet, consectetueradipiscing elit. Nam cursus.', 2, 1, '200.200.200.1', '864569918_687314647_imgres3.jpg', 1398685395, 1, 'No'),
(20, '4G Technologies', 'Internet & Mobile', '4G Technology', 'Advance technology as compared to 3G', 4, 1, '200.200.200.1', '514777331_freight.jpg', 1398685518, 1, 'No'),
(21, 'sadsda', 'asddsadas', 'sadadsdsdsa', 'dsaadasdsdsasadads', 2, 1, '200.200.200.1', '', 1398685667, 1, 'No'),
(22, 'sdasdasda', 'sdsdad', 'sadasd sdasda', 'sdasdddd sad  sadsdasd sdsdasdasda', 7.5, 1, '200.200.200.1', '', 1398685962, 1, 'No'),
(23, 'This is product,services etc', 'This is Category', 'This is title', 'This is review details', 10, 4, '200.200.200.1', '1867758240_Chrysanthemum.jpg', 1403676894, 1, 'No'),
(24, 'This is MOBILE product,services etc', 'This is  MOBILE Category', 'This is MOBILE  title', 'this is  MOBILE review details', 8, 4, '200.200.200.1', '', 1403688836, 1, 'No'),
(25, 'new test suggestion', 'we are testing mobile review category', 'THis is Mobile review title', 'This is mobile review details', 9.5, 4, '200.200.200.1', '1587064703_Desert.jpg', 1404881851, 1, 'Yes'),
(26, 'we make a new test', 'This is new category for mobile, mobile APPS', 'sssss', 'sss sssssss sssssss sssssss sssssss sssssss sssssss sssssss sssssss sssssss sssssss sssssss sssssss sssssss ssss', 8.5, 4, '200.200.200.1', '', 1404897585, 1, 'No'),
(27, 'asdsafsd', 'sdfgdsgdsg', 'sdfgsdgdsg', 'sdgsdgsdfgsdfg', 9.5, 4, '200.200.200.1', '1810633010_animated-character-2.jpg', 1411974785, 1, 'No'),
(28, '', 'test', 'dsffds', 'sdffdfdfs dffdfd dfsfddf', 10, 4, '200.200.200.1', '', 1413798296, 1, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_setting`
--

CREATE TABLE `tbl_general_setting` (
  `setting_id` int(11) NOT NULL,
  `facebook_right_script` text NOT NULL,
  `facebook_bottom_script` text NOT NULL,
  `desktop_version_logo` varchar(255) NOT NULL,
  `mobile_version_logo` varchar(255) NOT NULL,
  `rate_review` text NOT NULL,
  `discuss` text NOT NULL,
  `profile` text NOT NULL,
  `rhyming_larics` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_general_setting`
--

INSERT INTO `tbl_general_setting` (`setting_id`, `facebook_right_script`, `facebook_bottom_script`, `desktop_version_logo`, `mobile_version_logo`, `rate_review`, `discuss`, `profile`, `rhyming_larics`) VALUES
(1, '', '', '1497687704_logo.png', '2084083476_logo.png', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_gcomment_report`
--
ALTER TABLE `tbl_gcomment_report`
  ADD PRIMARY KEY (`gc_report_id`);

--
-- Indexes for table `tbl_general_comments`
--
ALTER TABLE `tbl_general_comments`
  ADD PRIMARY KEY (`gcomment_id`);

--
-- Indexes for table `tbl_general_comments_likes`
--
ALTER TABLE `tbl_general_comments_likes`
  ADD PRIMARY KEY (`g_comment_like_id`);

--
-- Indexes for table `tbl_general_review`
--
ALTER TABLE `tbl_general_review`
  ADD PRIMARY KEY (`g_review_id`),
  ADD KEY `g_review_title` (`g_review_title`(255)),
  ADD KEY `g_review_rating` (`g_review_rating`),
  ADD KEY `g_review_user_id` (`g_review_user_id`),
  ADD KEY `greview_image` (`greview_image`(255)),
  ADD KEY `g_review_post_date` (`g_review_post_date`);

--
-- Indexes for table `tbl_general_setting`
--
ALTER TABLE `tbl_general_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_gcomment_report`
--
ALTER TABLE `tbl_gcomment_report`
  MODIFY `gc_report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_general_comments`
--
ALTER TABLE `tbl_general_comments`
  MODIFY `gcomment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `tbl_general_comments_likes`
--
ALTER TABLE `tbl_general_comments_likes`
  MODIFY `g_comment_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `tbl_general_review`
--
ALTER TABLE `tbl_general_review`
  MODIFY `g_review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tbl_general_setting`
--
ALTER TABLE `tbl_general_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
