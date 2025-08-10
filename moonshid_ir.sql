-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2025 at 03:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moonshid.ir`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `file_name`, `created_at`) VALUES
(25, 'first programmer in the world', '<p>tle more than a year, and Ada never met her father. To counteract the \"dangerous\" mental tendencies of Ada\'s father, Annabella</p>', '../uploads/avatar1.png', '2024-11-03 20:30:00'),
(26, 'firsr programmer in the world', '<p style=\"text-align: left; \">\n  <h3 class=\"\"><span style=\"color: rgb(33, 37, 41); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; background-color: rgb(255, 255, 255);\">&nbsp;who is the first programmer in the world?&nbsp;</span></h3><br style=\"color: rgb(33, 37, 41); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; background-color: rgb(255, 255, 255);\"><br style=\"color: rgb(33, 37, 41); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; background-color: rgb(255, 255, 255);\"><span style=\"color: rgb(33, 37, 41); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; background-color: rgb(255, 255, 255);\">Ada Lovelace is known as the first programmer in history and a pioneer in modern computing, and more importantly, the world\'s first female programmer. He was born in Britain on December 10, 1815, and at the age of 17, he got acquainted with the Analytical Engine and in 1842, he got involved with the concept that we call computer programming today.</span></p>\n\n\n\n<img src=\"https://i.imgur.com/S4p16Fh.jpeg\" alt=\"\" width=\"450\" height=\"506\">\n\n<h3>Inventing the world\'s first algorithm</h3>\n\n<p>\n  Ada Lovelace translated Charles Babbage\'s complex notes and studies on the Analytical Engine from French into English and explained the concept, not only did she translate these notes, but she also included her own innovative ideas about how to perform calculations. Through machines, he added to them that these notes are today known as the first algorithm in the world (there is no need to explain that the word algorithm is also derived from the Arabic word al-Khwarizmi, which is derived from the name of the great Iranian scientist Khwarazmi). He is also a mathematical genius. and he had inherited this feature from his mother so that Charles Babbage gave him the title of the wizard of numbers.</p>\n</p>\n\n<img src=\"https://i.imgur.com/U9TGVj5.jpeg\" alt=\"\" width=\"450\" height=\"506\">\n', '../uploads/photo14673192612.jpg', '2024-11-03 20:30:00'),
(27, 'gg', '<p>fffffffff<br><img src=\"https://static.roocket.ir/images/cover/2024/3/17/cjrvYIIKwBOgP9NlKHeWYi4bXIcwIe9UQHZNlAbs.jpg\" alt=\"\" width=\"302\" height=\"170\"><br>ggg</p>', '../uploads/photo14625066199.jpg', '2024-11-15 20:30:00'),
(28, 'تستی اول', '<p>سلام این تستی هست<br><br></p>', '../uploads/00.jpg', '2024-12-11 20:30:00'),
(29, 'yy', '<p>yesssss</p>', '../uploads/5.jpg', '2024-12-19 20:30:00'),
(30, 'yy', '<p>yesssss</p>', '../uploads/5.jpg', '2024-12-29 20:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(12) NOT NULL,
  `title` varchar(255) CHARACTER SET utf32 COLLATE utf32_general_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `body` longtext CHARACTER SET utf32 COLLATE utf32_general_ci DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf32 COLLATE utf32_general_ci DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `body`, `category`, `file_name`, `created_at`) VALUES
(2, 'دوره html', 'دوره html', '<p>ffffff inja tekam bishtar vvvvvvvvv</p>', 'web_programming', '../uploads/courses/دوره html/Capture.PNG', '2025-02-19 08:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `currencys`
--

CREATE TABLE `currencys` (
  `id` int(11) NOT NULL,
  `usd` varchar(255) DEFAULT NULL,
  `aed` varchar(255) DEFAULT NULL,
  `try` varchar(255) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `currencys`
--

INSERT INTO `currencys` (`id`, `usd`, `aed`, `try`, `updated`) VALUES
(1, 'اطلاعات موجود نیست', '208,380', '21,600', '2024-12-22 14:07:20'),
(2, 'اطلاعات موجود نیست', '208,380', '21,600', '2024-12-22 14:07:47'),
(3, 'اطلاعات موجود نیست', '208,380', '21,600', '2024-12-22 14:09:14'),
(4, 'اطلاعات موجود نیست', 'اطلاعات موجود نیست', 'اطلاعات موجود نیست', '2024-12-22 14:10:59'),
(5, 'اطلاعات موجود نیست', 'اطلاعات موجود نیست', 'اطلاعات موجود نیست', '2024-12-22 14:11:03'),
(6, '759,850', '208,380', '21,600', '2024-12-22 14:12:10'),
(7, '759,850', '208,380', '21,600', '2024-12-22 14:15:23'),
(8, '759,850', '208,380', '21,600', '2024-12-22 14:15:41'),
(9, '759,850', '208,380', '21,600', '2024-12-22 14:15:45'),
(10, '759,850', '208,380', '21,600', '2024-12-22 14:40:33');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `type` enum('bid','message','system') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `related_link` varchar(255) DEFAULT NULL,
  `bid_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `deadline` varchar(10) DEFAULT NULL,
  `min_budget` int(11) DEFAULT NULL,
  `max_budget` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `assigned_freelancer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_bids`
--

CREATE TABLE `project_bids` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `bid_amount` decimal(10,0) NOT NULL,
  `bid_message` text NOT NULL,
  `bid_deadline` varchar(10) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `message_to_freelancer` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_viewed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(12) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `family` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `number` varchar(12) DEFAULT NULL,
  `subject` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `name`, `family`, `email`, `number`, `subject`) VALUES
(1, 'مهشید', 'خودسیانی', 'mahsa@yahoo.com', '09130109552', 'طراحی سایت'),
(2, 'مهشید', 'خودسیانی', 'mahsa@yahoo.com', '09130109552', 'طراحی سایت');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(12) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `vv` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `path`, `vv`) VALUES
(1, 'img/1/bg.png', NULL),
(2, 'img/2/bg.png', NULL),
(3, 'img/3/bg.png', NULL),
(4, 'img/4/bg.png', NULL),
(5, '../uploadimg/5/bg.png', NULL),
(6, '../uploadimg/6/bg.png', NULL),
(7, '../uploadimg/7/bat.jpg', NULL),
(8, '../uploadimg/8/google.png', NULL),
(9, '../uploadimg/9/main_image_10_1658309308.jpg', NULL),
(10, '../uploadimg/10/main_image_10_1658309308.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `family` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `family`, `username`, `password`, `role`, `profile_image`, `created_at`) VALUES
(5, 'مهشید', 'خودسیانی', 'mahshid', '123', 'employer', NULL, '2025-04-13 08:10:09'),
(6, 'مهنوش', 'خودسیانی', 'mehnoosh', '123', 'freelancer', NULL, '2025-04-13 08:10:09'),
(7, 'کوروش', 'فکاری', 'koorosh', '123', 'freelancer', NULL, '2025-08-01 11:13:47'),
(8, 'کتایون ', 'خانجانی', 'kati', '123', 'employer', NULL, '2025-08-01 12:00:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_freelancer_unique` (`project_id`,`freelancer_id`),
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `currencys`
--
ALTER TABLE `currencys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assigned_freelancer` (`assigned_freelancer_id`);

--
-- Indexes for table `project_bids`
--
ALTER TABLE `project_bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
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
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `currencys`
--
ALTER TABLE `currencys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `project_bids`
--
ALTER TABLE `project_bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`freelancer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chats_ibfk_3` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_assigned_freelancer` FOREIGN KEY (`assigned_freelancer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `project_bids`
--
ALTER TABLE `project_bids`
  ADD CONSTRAINT `project_bids_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_bids_ibfk_2` FOREIGN KEY (`freelancer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
