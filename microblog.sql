-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2022 at 04:13 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `microblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `created`, `modified`, `deleted`) VALUES
(6, 2, 44, 'Test 1', '2022-02-02 08:00:32', '2022-02-02 08:00:32', NULL),
(12, 2, 44, 'Test 2', '2022-02-02 09:39:20', '2022-02-02 09:39:20', '2022-02-03 01:53:43'),
(13, 2, 44, 'Test 3', '2022-02-02 09:39:30', '2022-02-02 09:39:30', '2022-02-03 01:52:21'),
(14, 2, 44, 'Test 4 Edited', '2022-02-02 09:39:45', '2022-02-03 01:33:06', NULL),
(15, 6, 44, 'Comment 1', '2022-02-03 02:33:09', '2022-02-03 02:33:09', '2022-02-03 02:43:58'),
(16, 6, 44, 'Comment 2', '2022-02-03 02:43:11', '2022-02-03 02:43:11', '2022-02-07 06:17:49'),
(17, 6, 44, 'Comment 3 Edited', '2022-02-03 02:43:32', '2022-02-03 03:27:42', '2022-02-07 06:17:56'),
(18, 6, 44, 'Comment 4 Edited', '2022-02-03 02:44:18', '2022-02-03 02:55:42', NULL),
(19, 6, 44, 'Comment 5', '2022-02-03 03:26:40', '2022-02-03 03:26:40', '2022-02-03 03:27:28'),
(20, 6, 44, 'Comment 5', '2022-02-03 03:37:59', '2022-02-03 03:37:59', '2022-02-03 03:54:04'),
(21, 6, 44, 'Comment 5', '2022-02-03 03:54:13', '2022-02-03 03:54:13', '2022-02-03 03:54:35'),
(22, 6, 44, 'Cooment', '2022-02-03 03:54:42', '2022-02-03 03:54:42', '2022-02-03 03:56:13'),
(23, 6, 44, 'Test', '2022-02-03 03:56:19', '2022-02-03 03:56:19', NULL),
(24, 6, 44, 'Test 2', '2022-02-03 05:10:38', '2022-02-03 05:10:38', NULL),
(25, 14, 23, 'Comment 1', '2022-02-04 03:18:13', '2022-02-04 03:18:13', '2022-02-04 03:29:38'),
(26, 14, 23, 'Comment 1', '2022-02-04 03:18:31', '2022-02-04 03:18:31', '2022-02-04 03:29:43'),
(27, 14, 23, 'Comment 2', '2022-02-04 03:27:14', '2022-02-04 03:27:14', NULL),
(28, 14, 23, 'Comment 3', '2022-02-04 03:28:36', '2022-02-04 03:28:36', NULL),
(29, 14, 23, 'Comment 4', '2022-02-04 03:29:55', '2022-02-04 03:29:55', NULL),
(30, 14, 23, 'Comment 5', '2022-02-04 03:30:12', '2022-02-04 03:30:12', '2022-02-04 03:57:59'),
(31, 16, 23, 'test', '2022-02-04 03:59:07', '2022-02-04 03:59:07', NULL),
(32, 16, 44, 'Test 2', '2022-02-04 05:12:23', '2022-02-04 05:12:23', '2022-02-07 06:17:22'),
(33, 12, 44, 'Test 1', '2022-02-04 05:12:41', '2022-02-04 05:12:41', NULL),
(34, 15, 44, 'Awesome !', '2022-02-04 05:13:56', '2022-02-04 05:13:56', NULL),
(35, 16, 23, 'Awesome!', '2022-02-04 09:25:56', '2022-02-04 09:25:56', NULL),
(36, 16, 44, 'Test 1', '2022-02-07 06:11:03', '2022-02-07 06:11:03', NULL),
(37, 16, 44, 'Test 2', '2022-02-07 06:11:18', '2022-02-07 06:11:18', NULL),
(38, 16, 44, 'Test 3', '2022-02-07 06:11:26', '2022-02-07 06:11:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` bigint(20) NOT NULL,
  `following_user` bigint(20) NOT NULL,
  `follower_user` bigint(20) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `following_user`, `follower_user`, `created`, `modified`, `deleted`) VALUES
(3, 23, 44, '2022-02-07 08:21:38', '2022-02-08 01:31:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`, `created`, `modified`, `deleted`) VALUES
(13, 11, 44, '2022-02-03 08:32:32', '2022-02-08 01:26:16', NULL),
(14, 9, 44, '2022-02-03 08:32:46', '2022-02-08 01:24:48', NULL),
(15, 16, 1, '2022-02-04 05:12:16', '2022-02-04 06:42:22', '2022-02-08 02:57:08'),
(16, 14, 1, '2022-02-04 05:30:11', '2022-02-04 05:31:29', NULL),
(17, 15, 1, '2022-02-04 05:32:29', '2022-02-04 05:34:49', NULL),
(18, 6, 44, '2022-02-08 01:25:53', '2022-02-08 01:25:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `post` varchar(255) NOT NULL,
  `shared_post_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `image_path`, `post`, `shared_post_id`, `created`, `modified`, `deleted`) VALUES
(2, 44, NULL, 'asdasd', NULL, '2022-01-31 05:49:21', '2022-01-31 05:49:21', NULL),
(3, 44, 'logo.PNG', 'Test Post with Image', NULL, '2022-01-31 05:50:51', '2022-01-31 05:50:51', NULL),
(4, 44, 'solo.png', 'Test 31', NULL, '2022-01-31 06:13:19', '2022-01-31 09:01:06', '2022-01-31 09:45:13'),
(6, 44, NULL, 'Test 1', NULL, '2022-02-03 02:31:30', '2022-02-03 02:31:30', NULL),
(8, 44, NULL, 'Shared Post:', 6, '2022-02-03 07:35:32', '2022-02-03 07:35:32', '2022-02-03 08:03:56'),
(9, 44, NULL, 'Shared Post', 3, '2022-02-03 08:00:00', '2022-02-03 08:00:00', NULL),
(11, 44, NULL, 'Shared Post:', 2, '2022-02-03 08:05:20', '2022-02-03 08:05:20', NULL),
(12, 23, NULL, 'Test Post 1', NULL, '2022-02-04 03:03:41', '2022-02-04 03:03:41', NULL),
(13, 23, 'logo.PNG', 'Test Post 2 with image', NULL, '2022-02-04 03:04:05', '2022-02-04 03:04:05', NULL),
(14, 23, NULL, 'Shared Post:', 12, '2022-02-04 03:04:14', '2022-02-04 03:04:14', NULL),
(15, 23, NULL, 'Shared Post:', 3, '2022-02-04 03:31:20', '2022-02-04 03:31:20', NULL),
(16, 23, NULL, 'Awesome!', 3, '2022-02-04 03:54:08', '2022-02-04 03:54:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `profile_path` varchar(255) DEFAULT NULL,
  `banner_path` varchar(255) DEFAULT NULL,
  `gender` varchar(20) NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `activation_token` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `age`, `profile_path`, `banner_path`, `gender`, `verified`, `activation_token`, `created`, `modified`, `deleted`) VALUES
(1, 'allanjumadiao', 'Allan L. Jumadiao', 'allanjumadiao.yns@gmail.com', '$2y$10$kQsVKGJvYfh8usfNdBCHqOgPD1.oZWM9/aOf840.C90FGrxRGl79m', 26, NULL, NULL, '', 1, '', NULL, NULL, NULL),
(23, 'jumadiaoallan', 'Allan Jumadiao', 'allan.jumadiao01@gmail.com', '$2y$10$kQsVKGJvYfh8usfNdBCHqOgPD1.oZWM9/aOf840.C90FGrxRGl79m', 26, 'icon.PNG', 'logo.PNG', '0', 1, '42c48d010e8b214c656db68c48b90cfd18b4ac78', '2022-01-26 08:36:39', '2022-01-26 08:36:39', NULL),
(44, 'allan.jumadiao', 'Allan Lazada Jumadiao', 'allanjumadiao.bioessence@gmail.com', '$2y$10$XbBpnMfgQUDjk8I51/W8Mu72xpnz50JqL7t/eeZaxWsqH9KEK3xwG', 26, 'icon.PNG', 'solo.png', '0', 1, 'dd0da291b8e258a0b8bbeb66b68bc2a4b37a7330', '2022-01-27 03:11:53', '2022-02-04 02:51:38', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
