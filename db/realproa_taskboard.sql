-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2018 at 10:48 PM
-- Server version: 5.6.39
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realproa_taskboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activities`
--

CREATE TABLE `tbl_activities` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `board_id` bigint(20) DEFAULT NULL,
  `new_board_id` bigint(20) DEFAULT NULL,
  `task_id` bigint(20) DEFAULT NULL,
  `new_task_id` bigint(20) DEFAULT NULL,
  `checklist_id` bigint(20) DEFAULT NULL,
  `checklistvalue_id` bigint(20) DEFAULT NULL,
  `message` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_activities`
--

INSERT INTO `tbl_activities` (`id`, `user_id`, `project_id`, `board_id`, `new_board_id`, `task_id`, `new_task_id`, `checklist_id`, `checklistvalue_id`, `message`, `url`, `status`, `slug`, `type`, `created`, `modified`) VALUES
(1, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '56786278', 'create_project', '2018-01-31 05:41:56', '2018-01-31 05:41:56'),
(2, 2, 1, 1, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '84630025', 'create_board', '2018-01-31 05:42:09', '2018-01-31 05:42:09'),
(3, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'First Board', '', 1, '92250522', 'delete_board', '2018-01-31 19:44:48', '2018-01-31 19:44:48'),
(4, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '29461859', 'create_board', '2018-01-31 19:45:04', '2018-01-31 19:45:04'),
(5, 2, 1, 3, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '74715309', 'create_board', '2018-01-31 19:45:11', '2018-01-31 19:45:11'),
(6, 2, 1, 4, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '17150012', 'create_board', '2018-01-31 19:45:20', '2018-01-31 19:45:20'),
(7, 2, 1, 5, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '70988106', 'create_board', '2018-01-31 19:45:33', '2018-01-31 19:45:33'),
(8, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Title collaboration board', '', 1, '63965763', 'delete_board', '2018-01-31 19:45:41', '2018-01-31 19:45:41'),
(9, 2, 1, 6, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '26902721', 'create_board', '2018-01-31 19:45:52', '2018-01-31 19:45:52'),
(10, 2, 1, 7, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '58255892', 'create_board', '2018-01-31 19:46:13', '2018-01-31 19:46:13'),
(11, 2, 1, 2, NULL, 2, NULL, NULL, NULL, 'attachment added into task', '', 1, '92775362', 'add_attachment', '2018-01-31 19:51:16', '2018-01-31 19:51:16'),
(12, 2, 1, 2, NULL, 2, NULL, NULL, NULL, 'attachment added into task', '', 1, '79542139', 'add_attachment', '2018-01-31 19:51:58', '2018-01-31 19:51:58'),
(13, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '20816328', 'create_project', '2018-02-01 08:51:17', '2018-02-01 08:51:17'),
(14, 4, 2, 8, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '67830209', 'create_board', '2018-02-01 08:51:30', '2018-02-01 08:51:30'),
(15, 4, 2, 9, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '63357954', 'create_board', '2018-02-01 08:51:37', '2018-02-01 08:51:37'),
(16, 4, 2, 10, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '36028825', 'create_board', '2018-02-01 08:51:46', '2018-02-01 08:51:46'),
(17, 4, 2, 11, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '44357147', 'create_board', '2018-02-01 08:51:54', '2018-02-01 08:51:54'),
(18, 4, 2, 12, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '81509075', 'create_board', '2018-02-01 08:52:02', '2018-02-01 08:52:02'),
(19, 4, 2, 12, NULL, 4, NULL, NULL, NULL, 'created task into board', '', 1, '62104234', 'create_task', '2018-02-01 08:52:14', '2018-02-01 08:52:14'),
(20, 4, 2, 12, NULL, 5, NULL, NULL, NULL, 'created task into board', '', 1, '68390552', 'create_task', '2018-02-01 08:52:23', '2018-02-01 08:52:23'),
(21, 4, 2, 12, NULL, 5, NULL, NULL, NULL, 'comment added into task', '', 1, '77060831', 'add_comment', '2018-02-01 08:53:56', '2018-02-01 08:53:56'),
(22, 4, 2, 12, NULL, 5, NULL, NULL, NULL, 'attachment added into task', '', 1, '63263856', 'add_attachment', '2018-02-01 08:54:00', '2018-02-01 08:54:00'),
(23, 4, 2, 8, NULL, 3, NULL, NULL, NULL, 'attachment added into task', '', 1, '87306184', 'add_attachment', '2018-02-01 09:00:50', '2018-02-01 09:00:50'),
(24, 4, 2, 8, NULL, 3, NULL, NULL, NULL, 'comment added into task', '', 1, '96483136', 'add_comment', '2018-02-01 09:01:18', '2018-02-01 09:01:18'),
(25, 6, 2, 8, NULL, 3, NULL, NULL, NULL, 'comment added into task', '', 1, '89729835', 'add_comment', '2018-02-01 09:03:03', '2018-02-01 09:03:03'),
(26, 4, 2, 9, NULL, 6, NULL, NULL, NULL, 'created task into board', '', 1, '18957301', 'create_task', '2018-02-22 06:52:33', '2018-02-22 06:52:33'),
(27, 4, 2, 9, NULL, 6, NULL, NULL, NULL, 'comment added into task', '', 1, '97025068', 'add_comment', '2018-02-22 06:52:53', '2018-02-22 06:52:53'),
(28, 4, 2, 12, NULL, 4, 4, NULL, NULL, 'board copied', '', 1, '98985550', 'move_task', '2018-02-23 16:29:55', '2018-02-23 16:29:55'),
(29, 4, 2, 12, NULL, 4, 4, NULL, NULL, 'board copied', '', 1, '85404306', 'move_task', '2018-02-23 16:30:05', '2018-02-23 16:30:05'),
(30, 4, 2, 12, NULL, 4, NULL, NULL, NULL, 'attachment added into task', '', 1, '99786011', 'add_attachment', '2018-02-23 16:30:51', '2018-02-23 16:30:51'),
(31, 4, 2, 12, NULL, 4, NULL, NULL, NULL, 'attachment added into task', '', 1, '51916586', 'add_attachment', '2018-02-23 16:31:36', '2018-02-23 16:31:36'),
(32, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'Buyer Under Contract List', '', 1, '86309611', 'delete_board', '2018-02-23 18:09:46', '2018-02-23 18:09:46'),
(33, 4, 2, 12, NULL, 4, 4, NULL, NULL, 'board copied', '', 1, '47417718', 'move_task', '2018-03-05 05:26:28', '2018-03-05 05:26:28'),
(34, 4, 2, 12, NULL, 4, NULL, NULL, NULL, 'comment added into task', '', 1, '73603468', 'add_comment', '2018-03-05 05:27:09', '2018-03-05 05:27:09'),
(35, 4, 2, 13, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '82630018', 'create_board', '2018-03-05 05:28:32', '2018-03-05 05:28:32'),
(36, 4, 2, 13, NULL, 7, NULL, NULL, NULL, 'created task into board', '', 1, '24221439', 'create_task', '2018-03-05 05:28:50', '2018-03-05 05:28:50'),
(37, 4, 2, 9, 9, NULL, NULL, NULL, NULL, 'move_board', '', 1, '71986755', 'move_board', '2018-03-05 05:39:37', '2018-03-05 05:39:37'),
(38, 4, 2, 13, NULL, 7, NULL, NULL, NULL, 'attachment added into task', '', 1, '98658331', 'add_attachment', '2018-03-05 05:40:49', '2018-03-05 05:40:49'),
(39, 4, 2, 13, NULL, 7, NULL, NULL, NULL, 'comment added into task', '', 1, '72081599', 'add_comment', '2018-03-05 05:44:09', '2018-03-05 05:44:09'),
(40, 5, 2, 13, NULL, 7, NULL, NULL, NULL, 'comment added into task', '', 1, '37109978', 'add_comment', '2018-03-05 05:45:18', '2018-03-05 05:45:18'),
(41, 4, 2, 13, NULL, 7, NULL, NULL, NULL, 'comment added into task', '', 1, '82236943', 'add_comment', '2018-03-05 05:45:48', '2018-03-05 05:45:48'),
(42, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'Roofing cert', '', 1, '70889812', 'delete_board', '2018-03-05 05:50:34', '2018-03-05 05:50:34'),
(43, 4, 2, 11, NULL, 7, NULL, NULL, NULL, 'created task into board', '', 1, '74521780', 'create_task', '2018-04-19 05:49:47', '2018-04-19 05:49:47'),
(44, 8, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '51729908', 'create_project', '2018-05-02 12:14:54', '2018-05-02 12:14:54'),
(45, 8, 3, 13, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '27569637', 'create_board', '2018-05-02 12:14:54', '2018-05-02 12:14:54'),
(46, 8, 3, 13, NULL, 9, NULL, NULL, NULL, 'created task into board', '', 1, '11952783', 'create_task', '2018-05-02 12:16:17', '2018-05-02 12:16:17'),
(47, 4, 2, 12, NULL, 10, NULL, NULL, NULL, 'created task into board', '', 1, '21385909', 'create_task', '2018-05-03 04:32:39', '2018-05-03 04:32:39'),
(48, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '54528789', 'create_project', '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(49, 4, 4, 14, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '96714210', 'create_board', '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(50, 4, 5, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '56284115', 'create_project', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(51, 4, 5, 15, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '70882011', 'create_board', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(52, 4, 5, 16, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '19092628', 'create_board', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(53, 4, 5, 17, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '56748905', 'create_board', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(54, 4, 5, 18, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '84297898', 'create_board', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(55, 4, 5, 19, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '84606979', 'create_board', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(56, 4, 5, 20, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '67478320', 'create_board', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(57, 4, 5, 15, NULL, 30, NULL, NULL, NULL, 'comment added into task', '', 1, '19346534', 'add_comment', '2018-05-12 21:54:40', '2018-05-12 21:54:40'),
(58, 5, 5, 15, NULL, 30, NULL, NULL, NULL, 'comment added into task', '', 1, '18865475', 'add_comment', '2018-05-12 21:55:05', '2018-05-12 21:55:05'),
(59, 4, 6, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '90243880', 'create_project', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(60, 4, 6, 21, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '85748618', 'create_board', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(61, 4, 6, 22, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '44746166', 'create_board', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(62, 4, 6, 23, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '69935846', 'create_board', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(63, 4, 6, 24, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '52333234', 'create_board', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(64, 4, 6, 25, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '35089037', 'create_board', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(65, 4, 6, 26, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '98478449', 'create_board', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(66, 4, 6, 26, NULL, 78, NULL, NULL, NULL, 'created task into board', '', 1, '42142973', 'create_task', '2018-05-17 01:26:15', '2018-05-17 01:26:15'),
(67, 4, 6, 26, NULL, 79, NULL, NULL, NULL, 'created task into board', '', 1, '47663410', 'create_task', '2018-05-17 01:26:59', '2018-05-17 01:26:59'),
(68, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '57249477', 'create_project', '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(69, 4, 7, 27, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '36991238', 'create_board', '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(70, 4, 7, 28, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '27672954', 'create_board', '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(71, 5, 7, 27, NULL, 80, NULL, NULL, NULL, 'comment added into task', '', 1, '43512232', 'add_comment', '2018-05-17 01:44:26', '2018-05-17 01:44:26'),
(72, 5, 7, 27, NULL, 80, NULL, NULL, NULL, 'attachment added into task', '', 1, '91368501', 'add_attachment', '2018-05-17 01:51:58', '2018-05-17 01:51:58'),
(73, 4, 7, 29, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '37671502', 'create_board', '2018-05-17 02:04:08', '2018-05-17 02:04:08'),
(74, 4, 7, 29, NULL, 119, NULL, NULL, NULL, 'created task into board', '', 1, '65687956', 'create_task', '2018-05-17 02:05:06', '2018-05-17 02:05:06'),
(75, 4, 7, 29, NULL, 120, NULL, NULL, NULL, 'created task into board', '', 1, '89511015', 'create_task', '2018-05-17 02:08:39', '2018-05-17 02:08:39'),
(76, 4, 7, 29, NULL, 121, NULL, NULL, NULL, 'created task into board', '', 1, '48664155', 'create_task', '2018-05-17 02:09:27', '2018-05-17 02:09:27'),
(77, 4, 7, 30, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '53850900', 'create_board', '2018-05-17 02:11:55', '2018-05-17 02:11:55'),
(78, 10, 8, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '83566967', 'create_project', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(79, 10, 8, 31, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '12306682', 'create_board', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(80, 10, 8, 32, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '94792804', 'create_board', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(81, 10, 8, 33, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '26429785', 'create_board', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(82, 10, 8, 34, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '67953920', 'create_board', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(83, 10, 8, 35, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '22651736', 'create_board', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(84, 10, 8, 36, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '92993716', 'create_board', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(85, 10, 8, 37, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '12176474', 'create_board', '2018-05-18 03:59:39', '2018-05-18 03:59:39'),
(86, 10, 8, 37, NULL, 169, NULL, NULL, NULL, 'created task into board', '', 1, '48631607', 'create_task', '2018-05-18 04:00:04', '2018-05-18 04:00:04'),
(87, 10, 8, 37, NULL, 170, NULL, NULL, NULL, 'created task into board', '', 1, '40687291', 'create_task', '2018-05-18 04:01:46', '2018-05-18 04:01:46'),
(88, 10, 8, 37, NULL, 171, NULL, NULL, NULL, 'created task into board', '', 1, '37144969', 'create_task', '2018-05-18 04:01:58', '2018-05-18 04:01:58'),
(89, 10, 8, 37, NULL, 172, NULL, NULL, NULL, 'created task into board', '', 1, '94172580', 'create_task', '2018-05-18 04:02:28', '2018-05-18 04:02:28'),
(90, 10, 8, 37, NULL, 173, NULL, NULL, NULL, 'created task into board', '', 1, '45552763', 'create_task', '2018-05-18 04:02:42', '2018-05-18 04:02:42'),
(91, 10, 8, 38, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '64679204', 'create_board', '2018-05-18 04:33:13', '2018-05-18 04:33:13'),
(92, 10, 8, 38, NULL, 174, NULL, NULL, NULL, 'created task into board', '', 1, '98348520', 'create_task', '2018-05-18 04:38:12', '2018-05-18 04:38:12'),
(93, 4, 4, 39, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '52719628', 'create_board', '2018-05-30 17:08:33', '2018-05-30 17:08:33'),
(94, 8, 3, 13, NULL, 175, NULL, NULL, NULL, 'created task into board', '', 1, '76052882', 'create_task', '2018-05-31 11:30:46', '2018-05-31 11:30:46'),
(95, 4, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '57688121', 'create_project', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(96, 4, 9, 40, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '46669785', 'create_board', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(97, 4, 9, 41, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '19232699', 'create_board', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(98, 4, 9, 42, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '72641090', 'create_board', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(99, 4, 9, 43, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '60699392', 'create_board', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(100, 4, 9, 44, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '48411174', 'create_board', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(101, 4, 9, 45, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '69122353', 'create_board', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(102, 4, 9, 45, NULL, 177, NULL, NULL, NULL, 'created task into board', '', 1, '15685378', 'create_task', '2018-06-05 20:20:09', '2018-06-05 20:20:09'),
(103, 10, 10, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '76477515', 'create_project', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(104, 10, 10, 46, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '90598354', 'create_board', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(105, 10, 10, 47, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '45671622', 'create_board', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(106, 10, 10, 48, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '63188581', 'create_board', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(107, 10, 10, 49, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '76880347', 'create_board', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(108, 10, 10, 50, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '32215767', 'create_board', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(109, 10, 10, 51, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '63234729', 'create_board', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(110, 4, 9, 45, NULL, 225, NULL, NULL, NULL, 'created task into board', '', 1, '97553332', 'create_task', '2018-06-12 23:38:08', '2018-06-12 23:38:08'),
(111, 4, 9, 45, NULL, 226, NULL, NULL, NULL, 'created task into board', '', 1, '54721216', 'create_task', '2018-06-13 12:08:59', '2018-06-13 12:08:59'),
(112, 4, 9, 45, NULL, NULL, NULL, NULL, NULL, 'Task 3', '', 1, '90424145', 'delete_task', '2018-06-13 12:24:00', '2018-06-13 12:24:00'),
(113, 4, 9, 45, NULL, 227, NULL, NULL, NULL, 'created task into board', '', 1, '80062783', 'create_task', '2018-06-13 12:24:16', '2018-06-13 12:24:16'),
(114, 4, 9, NULL, NULL, NULL, NULL, NULL, NULL, 'Client Communication ', '', 1, '29381225', 'delete_board', '2018-06-13 12:26:36', '2018-06-13 12:26:36'),
(115, 4, 11, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '47141090', 'create_project', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(116, 4, 11, 52, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '76927238', 'create_board', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(117, 4, 11, 53, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '31042433', 'create_board', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(118, 4, 11, 54, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '47051935', 'create_board', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(119, 4, 11, 55, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '86814413', 'create_board', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(120, 4, 11, 56, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '19601509', 'create_board', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(121, 10, 12, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '49483645', 'create_project', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(122, 10, 12, 57, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '85300923', 'create_board', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(123, 10, 12, 58, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '15965239', 'create_board', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(124, 10, 12, 59, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '86585366', 'create_board', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(125, 10, 12, 60, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '79880890', 'create_board', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(126, 10, 12, 61, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '25305488', 'create_board', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(127, 10, 12, 62, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '86320726', 'create_board', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(128, 10, 12, 63, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '21768832', 'create_board', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(129, 4, 12, 63, NULL, 230, NULL, NULL, NULL, 'comment added into task', '', 1, '63455238', 'add_comment', '2018-06-24 13:21:32', '2018-06-24 13:21:32'),
(130, 10, 13, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '28394223', 'create_project', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(131, 10, 13, 64, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '68134469', 'create_board', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(132, 10, 13, 65, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '39070126', 'create_board', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(133, 10, 13, 66, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '31793752', 'create_board', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(134, 10, 13, 67, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '85101163', 'create_board', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(135, 10, 13, 68, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '59786624', 'create_board', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(136, 10, 13, 69, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '47063493', 'create_board', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(137, 10, 13, 70, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '57633364', 'create_board', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(138, 4, 9, 41, NULL, 235, NULL, NULL, NULL, 'created task into board', '', 1, '82677122', 'create_task', '2018-06-25 21:40:22', '2018-06-25 21:40:22'),
(139, 4, 14, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '80586134', 'create_project', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(140, 4, 14, 71, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '97711345', 'create_board', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(141, 4, 14, 72, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '88620056', 'create_board', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(142, 4, 14, 73, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '51787855', 'create_board', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(143, 4, 14, 74, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '71432099', 'create_board', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(144, 4, 14, 75, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '43285509', 'create_board', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(145, 4, 14, 74, NULL, 237, NULL, NULL, NULL, 'created task into board', '', 1, '17841376', 'create_task', '2018-06-26 23:36:10', '2018-06-26 23:36:10'),
(146, 4, 5, 20, NULL, 238, NULL, NULL, NULL, 'created task into board', '', 1, '35628219', 'create_task', '2018-06-27 21:40:22', '2018-06-27 21:40:22'),
(147, 4, 5, 20, NULL, 239, NULL, NULL, NULL, 'created task into board', '', 1, '75313158', 'create_task', '2018-06-27 21:40:28', '2018-06-27 21:40:28'),
(148, 4, 9, 44, NULL, 240, NULL, NULL, NULL, 'created task into board', '', 1, '50741678', 'create_task', '2018-06-28 21:15:00', '2018-06-28 21:15:00'),
(149, 4, 9, 44, NULL, 240, NULL, NULL, NULL, 'comment added into task', '', 1, '91698393', 'add_comment', '2018-06-28 21:15:16', '2018-06-28 21:15:16'),
(150, 4, 9, 44, NULL, 240, NULL, NULL, NULL, 'comment added into task', '', 1, '21286753', 'add_comment', '2018-06-28 21:20:12', '2018-06-28 21:20:12'),
(151, 4, 9, 44, NULL, 241, NULL, NULL, NULL, 'created task into board', '', 1, '82845216', 'create_task', '2018-06-28 21:21:46', '2018-06-28 21:21:46'),
(152, 4, 9, 42, NULL, 242, NULL, NULL, NULL, 'created task into board', '', 1, '44939119', 'create_task', '2018-06-29 21:22:08', '2018-06-29 21:22:08'),
(153, 10, 8, 38, NULL, 243, NULL, NULL, NULL, 'created task into board', '', 1, '63711646', 'create_task', '2018-07-06 12:46:59', '2018-07-06 12:46:59'),
(154, 4, 15, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '99876859', 'create_project', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(155, 4, 15, 76, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '32278713', 'create_board', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(156, 4, 15, 77, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '85908958', 'create_board', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(157, 4, 15, 78, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '72521940', 'create_board', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(158, 4, 15, 79, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '29245276', 'create_board', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(159, 4, 15, 80, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '80576474', 'create_board', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(160, 4, 15, 81, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '49379161', 'create_board', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(161, 10, 12, 63, NULL, 291, NULL, NULL, NULL, 'created task into board', '', 1, '39207332', 'create_task', '2018-07-11 19:37:10', '2018-07-11 19:37:10'),
(162, 13, 16, NULL, NULL, NULL, NULL, NULL, NULL, 'created this project', '', 1, '49905792', 'create_project', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(163, 13, 16, 82, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '88339470', 'create_board', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(164, 13, 16, 83, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '60775833', 'create_board', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(165, 13, 16, 84, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '57734214', 'create_board', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(166, 13, 16, 85, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '77422718', 'create_board', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(167, 13, 16, 86, NULL, NULL, NULL, NULL, NULL, 'created board into project', '', 1, '72414930', 'create_board', '2018-07-17 18:36:09', '2018-07-17 18:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_additionals`
--

CREATE TABLE `tbl_additionals` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `key_data` tinyint(4) NOT NULL,
  `value_data` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_additionals`
--

INSERT INTO `tbl_additionals` (`id`, `project_id`, `key_data`, `value_data`, `slug`, `created`, `modified`) VALUES
(33, 3, 0, '', '152526329427465', '2018-05-02 12:14:54', '0000-00-00 00:00:00'),
(34, 3, 1, '', '152526329420081', '2018-05-02 12:14:54', '0000-00-00 00:00:00'),
(35, 3, 2, '', '152526329480420', '2018-05-02 12:14:54', '0000-00-00 00:00:00'),
(36, 3, 3, '', '152526329424989', '2018-05-02 12:14:54', '0000-00-00 00:00:00'),
(37, 3, 4, '', '152526329417887', '2018-05-02 12:14:54', '0000-00-00 00:00:00'),
(38, 3, 5, '', '152526329463977', '2018-05-02 12:14:54', '0000-00-00 00:00:00'),
(39, 3, 6, '', '152526329452663', '2018-05-02 12:14:54', '0000-00-00 00:00:00'),
(40, 3, 7, '', '152526329445847', '2018-05-02 12:14:54', '0000-00-00 00:00:00'),
(41, 4, 0, '', '152570232476043', '2018-05-07 14:12:04', '0000-00-00 00:00:00'),
(42, 4, 1, '', '152570232478221', '2018-05-07 14:12:04', '0000-00-00 00:00:00'),
(43, 4, 2, '4', '152570232456166', '2018-05-07 14:12:04', '0000-00-00 00:00:00'),
(44, 4, 3, '3', '152570232412241', '2018-05-07 14:12:04', '0000-00-00 00:00:00'),
(45, 4, 4, 'Single Family Home', '152570232441722', '2018-05-07 14:12:04', '0000-00-00 00:00:00'),
(46, 4, 5, 'Buyers', '152570232491627', '2018-05-07 14:12:04', '0000-00-00 00:00:00'),
(47, 4, 6, 'Open House', '152570232488750', '2018-05-07 14:12:04', '0000-00-00 00:00:00'),
(48, 4, 7, '2.5%', '152570232490628', '2018-05-07 14:12:04', '0000-00-00 00:00:00'),
(49, 5, 0, '', '152570684414504', '2018-05-07 15:27:24', '0000-00-00 00:00:00'),
(50, 5, 1, '', '152570684481698', '2018-05-07 15:27:24', '0000-00-00 00:00:00'),
(51, 5, 2, '4', '152570684438730', '2018-05-07 15:27:24', '0000-00-00 00:00:00'),
(52, 5, 3, '3', '152570684478784', '2018-05-07 15:27:24', '0000-00-00 00:00:00'),
(53, 5, 4, 'Single family', '152570684498283', '2018-05-07 15:27:24', '0000-00-00 00:00:00'),
(54, 5, 5, 'Buyer', '152570684452771', '2018-05-07 15:27:24', '0000-00-00 00:00:00'),
(55, 5, 6, 'Referral', '152570684416458', '2018-05-07 15:27:24', '0000-00-00 00:00:00'),
(56, 5, 7, '3', '152570684434054', '2018-05-07 15:27:24', '0000-00-00 00:00:00'),
(57, 6, 0, '', '152652017032536', '2018-05-17 01:22:50', '0000-00-00 00:00:00'),
(58, 6, 1, '', '152652017098505', '2018-05-17 01:22:50', '0000-00-00 00:00:00'),
(59, 6, 2, '', '152652017088474', '2018-05-17 01:22:50', '0000-00-00 00:00:00'),
(60, 6, 3, '', '152652017029901', '2018-05-17 01:22:50', '0000-00-00 00:00:00'),
(61, 6, 4, '', '152652017035396', '2018-05-17 01:22:50', '0000-00-00 00:00:00'),
(62, 6, 5, 'Seller', '152652017011422', '2018-05-17 01:22:50', '0000-00-00 00:00:00'),
(63, 6, 6, 'Referral', '152652017012221', '2018-05-17 01:22:50', '0000-00-00 00:00:00'),
(64, 6, 7, '15000', '152652017037762', '2018-05-17 01:22:50', '0000-00-00 00:00:00'),
(65, 7, 0, '', '152652055321088', '2018-05-17 01:29:13', '0000-00-00 00:00:00'),
(66, 7, 1, '', '152652055314193', '2018-05-17 01:29:13', '0000-00-00 00:00:00'),
(67, 7, 2, '', '152652055370942', '2018-05-17 01:29:13', '0000-00-00 00:00:00'),
(68, 7, 3, '', '152652055345586', '2018-05-17 01:29:13', '0000-00-00 00:00:00'),
(69, 7, 4, '', '152652055353363', '2018-05-17 01:29:13', '0000-00-00 00:00:00'),
(70, 7, 5, '', '152652055326736', '2018-05-17 01:29:13', '0000-00-00 00:00:00'),
(71, 7, 6, 'Referral', '152652055361120', '2018-05-17 01:29:13', '0000-00-00 00:00:00'),
(72, 7, 7, '15000', '152652055362896', '2018-05-17 01:29:13', '0000-00-00 00:00:00'),
(73, 8, 0, '', '152659652668686', '2018-05-17 22:35:26', '0000-00-00 00:00:00'),
(74, 8, 1, '', '152659652688574', '2018-05-17 22:35:26', '0000-00-00 00:00:00'),
(75, 8, 2, '', '152659652666165', '2018-05-17 22:35:26', '0000-00-00 00:00:00'),
(76, 8, 3, '', '152659652668879', '2018-05-17 22:35:26', '0000-00-00 00:00:00'),
(77, 8, 4, '', '152659652611830', '2018-05-17 22:35:26', '0000-00-00 00:00:00'),
(78, 8, 5, '', '152659652661682', '2018-05-17 22:35:26', '0000-00-00 00:00:00'),
(79, 8, 6, 'Past Client', '152659652617621', '2018-05-17 22:35:26', '0000-00-00 00:00:00'),
(80, 8, 7, '30000', '152659652662201', '2018-05-17 22:35:26', '0000-00-00 00:00:00'),
(81, 9, 0, '', '152825513648996', '2018-06-05 20:18:56', '0000-00-00 00:00:00'),
(82, 9, 1, '', '152825513690349', '2018-06-05 20:18:56', '0000-00-00 00:00:00'),
(83, 9, 2, '', '152825513682996', '2018-06-05 20:18:56', '0000-00-00 00:00:00'),
(84, 9, 3, '', '152825513615819', '2018-06-05 20:18:56', '0000-00-00 00:00:00'),
(85, 9, 4, '', '152825513615686', '2018-06-05 20:18:56', '0000-00-00 00:00:00'),
(86, 9, 5, '', '152825513656717', '2018-06-05 20:18:56', '0000-00-00 00:00:00'),
(87, 9, 6, '', '152825513687352', '2018-06-05 20:18:56', '0000-00-00 00:00:00'),
(88, 9, 7, '', '152825513674973', '2018-06-05 20:18:56', '0000-00-00 00:00:00'),
(89, 10, 0, '', '152884243172383', '2018-06-12 15:27:11', '0000-00-00 00:00:00'),
(90, 10, 1, '', '152884243159705', '2018-06-12 15:27:11', '0000-00-00 00:00:00'),
(91, 10, 2, '', '152884243198997', '2018-06-12 15:27:11', '0000-00-00 00:00:00'),
(92, 10, 3, '', '152884243188023', '2018-06-12 15:27:11', '0000-00-00 00:00:00'),
(93, 10, 4, '', '152884243118308', '2018-06-12 15:27:11', '0000-00-00 00:00:00'),
(94, 10, 5, '', '152884243134429', '2018-06-12 15:27:11', '0000-00-00 00:00:00'),
(95, 10, 6, '', '152884243114021', '2018-06-12 15:27:11', '0000-00-00 00:00:00'),
(96, 10, 7, '', '152884243186435', '2018-06-12 15:27:11', '0000-00-00 00:00:00'),
(97, 11, 0, '1902', '152970459732316', '2018-06-22 14:56:37', '0000-00-00 00:00:00'),
(98, 11, 1, '', '152970459749247', '2018-06-22 14:56:37', '0000-00-00 00:00:00'),
(99, 11, 2, '', '152970459733228', '2018-06-22 14:56:37', '0000-00-00 00:00:00'),
(100, 11, 3, '5000', '152970459718935', '2018-06-22 14:56:37', '0000-00-00 00:00:00'),
(101, 11, 4, 'FHA', '152970459893717', '2018-06-22 14:56:38', '0000-00-00 00:00:00'),
(102, 11, 5, 'N/A', '152970459887267', '2018-06-22 14:56:38', '0000-00-00 00:00:00'),
(103, 11, 6, 'Open House', '152970459850029', '2018-06-22 14:56:38', '0000-00-00 00:00:00'),
(104, 11, 7, '15000', '152970459886699', '2018-06-22 14:56:38', '0000-00-00 00:00:00'),
(105, 12, 0, '2000', '152986865860512', '2018-06-24 12:30:58', '0000-00-00 00:00:00'),
(106, 12, 1, 'sentrilock', '152986865842237', '2018-06-24 12:30:58', '0000-00-00 00:00:00'),
(107, 12, 2, '', '152986865825397', '2018-06-24 12:30:58', '0000-00-00 00:00:00'),
(108, 12, 3, '7000', '152986865884167', '2018-06-24 12:30:58', '0000-00-00 00:00:00'),
(109, 12, 4, 'Conventional', '152986865835167', '2018-06-24 12:30:58', '0000-00-00 00:00:00'),
(110, 12, 5, 'HOA', '152986865810536', '2018-06-24 12:30:58', '0000-00-00 00:00:00'),
(111, 12, 6, 'Referral', '152986865895735', '2018-06-24 12:30:58', '0000-00-00 00:00:00'),
(112, 12, 7, '21,000', '152986865819692', '2018-06-24 12:30:58', '0000-00-00 00:00:00'),
(113, 13, 0, '2011', '152987399253428', '2018-06-24 13:59:52', '0000-00-00 00:00:00'),
(114, 13, 1, 'sentrilock', '152987399237128', '2018-06-24 13:59:52', '0000-00-00 00:00:00'),
(115, 13, 2, '', '152987399284807', '2018-06-24 13:59:52', '0000-00-00 00:00:00'),
(116, 13, 3, '7000', '152987399259457', '2018-06-24 13:59:52', '0000-00-00 00:00:00'),
(117, 13, 4, 'conventional', '152987399270817', '2018-06-24 13:59:52', '0000-00-00 00:00:00'),
(118, 13, 5, 'HOA', '152987399240364', '2018-06-24 13:59:52', '0000-00-00 00:00:00'),
(119, 13, 6, 'Referral', '152987399275837', '2018-06-24 13:59:52', '0000-00-00 00:00:00'),
(120, 13, 7, '15000', '152987399249490', '2018-06-24 13:59:52', '0000-00-00 00:00:00'),
(121, 14, 0, '', '153008088581383', '2018-06-26 23:28:05', '0000-00-00 00:00:00'),
(122, 14, 1, '', '153008088592362', '2018-06-26 23:28:05', '0000-00-00 00:00:00'),
(123, 14, 2, '', '153008088521625', '2018-06-26 23:28:05', '0000-00-00 00:00:00'),
(124, 14, 3, '', '153008088572493', '2018-06-26 23:28:05', '0000-00-00 00:00:00'),
(125, 14, 4, '', '153008088581234', '2018-06-26 23:28:05', '0000-00-00 00:00:00'),
(126, 14, 5, '', '153008088555284', '2018-06-26 23:28:05', '0000-00-00 00:00:00'),
(127, 14, 6, '', '153008088553136', '2018-06-26 23:28:05', '0000-00-00 00:00:00'),
(128, 14, 7, '', '153008088562815', '2018-06-26 23:28:05', '0000-00-00 00:00:00'),
(129, 15, 0, '2005', '153127997849924', '2018-07-10 20:32:58', '0000-00-00 00:00:00'),
(130, 15, 1, '', '153127997898294', '2018-07-10 20:32:58', '0000-00-00 00:00:00'),
(131, 15, 2, '', '153127997828641', '2018-07-10 20:32:58', '0000-00-00 00:00:00'),
(132, 15, 3, '$10,000', '153127997837410', '2018-07-10 20:32:58', '0000-00-00 00:00:00'),
(133, 15, 4, 'VA', '153127997869624', '2018-07-10 20:32:58', '0000-00-00 00:00:00'),
(134, 15, 5, 'None', '153127997837482', '2018-07-10 20:32:58', '0000-00-00 00:00:00'),
(135, 15, 6, 'Open House', '153127997847841', '2018-07-10 20:32:58', '0000-00-00 00:00:00'),
(136, 15, 7, '150000', '153127997862767', '2018-07-10 20:32:58', '0000-00-00 00:00:00'),
(137, 16, 0, '123', '153187776915797', '2018-07-17 18:36:09', '0000-00-00 00:00:00'),
(138, 16, 1, 'lk', '153187776930240', '2018-07-17 18:36:09', '0000-00-00 00:00:00'),
(139, 16, 2, '', '153187776964790', '2018-07-17 18:36:09', '0000-00-00 00:00:00'),
(140, 16, 3, 'lkj', '153187776967547', '2018-07-17 18:36:09', '0000-00-00 00:00:00'),
(141, 16, 4, 'lkj', '153187776980213', '2018-07-17 18:36:09', '0000-00-00 00:00:00'),
(142, 16, 5, 'lk', '153187776955577', '2018-07-17 18:36:09', '0000-00-00 00:00:00'),
(143, 16, 6, 'lkj', '153187776961096', '2018-07-17 18:36:09', '0000-00-00 00:00:00'),
(144, 16, 7, '500', '153187776921657', '2018-07-17 18:36:09', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adminboards`
--

CREATE TABLE `tbl_adminboards` (
  `id` bigint(20) NOT NULL,
  `project_id` int(11) NOT NULL,
  `board_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `lastupdate` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_adminboards`
--

INSERT INTO `tbl_adminboards` (`id`, `project_id`, `board_name`, `status`, `slug`, `lastupdate`, `created`, `modified`) VALUES
(1, 1, 'Buyer Transaction List', '1', 'first_board', '0000-00-00', '2018-01-27 06:14:06', '2018-05-07 14:46:32'),
(2, 2, 'Client Communication ', '1', 'client_communication', '0000-00-00', '2018-01-31 17:56:05', '2018-01-31 18:09:02'),
(4, 2, 'Home Inspection Negotiations', '1', 'home_inspection_negotiations', '0000-00-00', '2018-01-31 17:58:39', '2018-01-31 17:58:39'),
(5, 2, 'Loan Officer Communication', '1', 'loan_officer_communication', '0000-00-00', '2018-01-31 17:59:33', '2018-01-31 17:59:33'),
(6, 2, 'Settlement Company Communication', '1', 'settlement_company_communication', '0000-00-00', '2018-01-31 17:59:53', '2018-01-31 17:59:53'),
(7, 2, 'Contingency Deadlines', '1', 'contingency_deadlines', '0000-00-00', '2018-01-31 18:01:56', '2018-06-20 21:16:34'),
(8, 2, 'Contract Inspections', '1', 'contract_inspections', '0000-00-00', '2018-01-31 18:07:01', '2018-06-20 21:13:45'),
(9, 3, 'Buyer Under Contract List', '1', 'buyer_under_contract_list', '0000-00-00', '2018-01-31 19:32:08', '2018-01-31 19:32:08'),
(10, 3, 'Lender collaboration board', '1', 'lender_collaboration_board', '0000-00-00', '2018-01-31 19:32:19', '2018-01-31 19:32:19'),
(11, 3, 'Title collaboration board', '1', 'title_collaboration_board', '0000-00-00', '2018-01-31 19:32:31', '2018-01-31 19:32:31'),
(12, 3, 'Escrow collaboration board', '1', 'escrow_collaboration_board', '0000-00-00', '2018-01-31 19:32:43', '2018-01-31 19:32:43'),
(13, 3, 'Inspector collaboration board', '1', 'inspector_collaboration_board', '0000-00-00', '2018-01-31 19:33:00', '2018-01-31 19:33:00'),
(14, 4, 'Seller Transaction List', '1', 'seller_transaction_list', '0000-00-00', '2018-05-07 14:23:53', '2018-05-07 14:23:53'),
(15, 4, 'Buyer Transaction List', '1', 'buyer_transaction_list', '0000-00-00', '2018-05-07 14:36:51', '2018-05-07 14:36:51'),
(16, 1, 'Seller Transaction List', '1', 'seller_transaction_list-1525704405', '0000-00-00', '2018-05-07 14:46:45', '2018-05-07 14:46:45'),
(17, 1, 'Lender Transaction List', '1', 'lender_transaction_list', '0000-00-00', '2018-05-07 15:00:16', '2018-05-07 15:00:16'),
(18, 1, 'Home Inspection Transaction List', '1', 'home_inspection_transaction_list', '0000-00-00', '2018-05-07 15:01:01', '2018-05-07 15:01:01'),
(19, 1, 'Title Transaction List', '1', 'title_transaction_list', '0000-00-00', '2018-05-07 15:01:43', '2018-05-07 15:01:43'),
(20, 1, 'Escrow Transaction List', '1', 'escrow_transaction_list', '0000-00-00', '2018-05-07 15:02:02', '2018-05-07 15:02:02'),
(21, 2, 'Client Touch', '1', 'client_touch', '0000-00-00', '2018-06-20 21:20:56', '2018-06-20 21:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adminchecklists`
--

CREATE TABLE `tbl_adminchecklists` (
  `id` int(20) NOT NULL,
  `task_id` int(20) NOT NULL,
  `board_id` int(20) NOT NULL,
  `checkbox_title` varchar(255) NOT NULL,
  `no_of_items` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_adminchecklists`
--

INSERT INTO `tbl_adminchecklists` (`id`, `task_id`, `board_id`, `checkbox_title`, `no_of_items`, `status`, `slug`, `created`, `modified`) VALUES
(3, 6, 2, 'Day 0', 0, 1, 'day_0', '2018-01-31 18:12:43', '2018-01-31 18:12:43'),
(4, 6, 2, 'Day 1', 0, 1, 'day_1', '2018-01-31 18:13:28', '2018-01-31 18:13:28'),
(5, 6, 2, 'Day 2', 0, 1, 'day_2', '2018-01-31 18:14:14', '2018-01-31 18:14:14'),
(6, 9, 9, 'Fully executed contract', 0, 1, 'fully_executed_contract', '2018-01-31 19:34:33', '2018-01-31 19:34:33'),
(7, 6, 2, 'Day 3', 0, 1, 'day_3', '2018-01-31 21:41:41', '2018-01-31 21:41:41'),
(9, 6, 2, 'Day 4', 0, 1, 'day_4', '2018-01-31 21:43:10', '2018-01-31 21:43:10'),
(10, 6, 2, 'Day 5', 0, 1, 'day_5', '2018-01-31 21:43:32', '2018-01-31 21:43:32'),
(11, 6, 2, 'Day 7', 0, 1, 'day_7', '2018-01-31 21:44:03', '2018-01-31 21:44:03'),
(12, 6, 2, 'Day 8', 0, 1, 'day_8', '2018-01-31 21:44:25', '2018-01-31 21:44:25'),
(13, 6, 2, 'Day 10', 0, 1, 'day_10', '2018-01-31 21:44:47', '2018-01-31 21:44:47'),
(14, 6, 2, 'Day 11', 0, 1, 'day_11', '2018-01-31 21:45:18', '2018-01-31 21:45:18'),
(15, 6, 2, 'Day 13', 0, 1, 'day_13', '2018-01-31 21:45:41', '2018-01-31 21:45:41'),
(16, 6, 2, 'Day 15', 0, 1, 'day_15', '2018-01-31 21:46:18', '2018-01-31 21:46:18'),
(17, 6, 2, 'Day 17', 0, 1, 'day_17', '2018-01-31 21:46:49', '2018-01-31 21:46:49'),
(18, 6, 2, 'Day 18', 0, 1, 'day_18', '2018-01-31 21:47:16', '2018-01-31 21:47:16'),
(19, 6, 2, 'Day 20', 0, 1, 'day_20', '2018-01-31 21:47:41', '2018-01-31 21:47:41'),
(20, 6, 2, 'Day 22', 0, 1, 'day_22', '2018-01-31 21:48:24', '2018-01-31 21:48:24'),
(21, 6, 2, 'Day 23', 0, 1, 'day_23', '2018-01-31 21:48:45', '2018-01-31 21:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adminchecklistvalues`
--

CREATE TABLE `tbl_adminchecklistvalues` (
  `id` bigint(20) NOT NULL,
  `checklist_id` bigint(20) NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `board_id` bigint(20) NOT NULL,
  `checkbox_value` varchar(255) NOT NULL,
  `is_checked` tinyint(2) NOT NULL,
  `checked_by` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_adminchecklistvalues`
--

INSERT INTO `tbl_adminchecklistvalues` (`id`, `checklist_id`, `task_id`, `board_id`, `checkbox_value`, `is_checked`, `checked_by`, `status`, `slug`, `created`, `modified`) VALUES
(2, 3, 6, 2, 'VIDEO AUTO TEXT TO BUYER CLIENT\r\nAuto Video Script for Buyers after filling out Contract Wizard questions: \r\n\r\n\"Congratulations \"Buyer\'s Name\" on your new home. Now that you found your dream home we will proceed with the transaction. We will go through th', 0, 0, 1, 'video_auto_text_to_buyer_client_au', '2018-01-31 18:13:05', '2018-01-31 19:22:47'),
(3, 4, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see when you’re available for home inspection.  Let me know…have a great day, thanks :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec', '2018-01-31 18:13:57', '2018-01-31 18:13:57'),
(4, 5, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nPlease turn in all your docs to “Loan Officer”.  You may hear from the Processor if you haven’t already…they will be asking for lots of info in the next 20 days.  Im here if you have any questions.  Have a good one!', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_plea', '2018-01-31 18:14:29', '2018-01-31 18:14:29'),
(5, 7, 6, 2, 'Auto Text to Buyer’s 11:30 a.m.\r\nGood afternoon “buyer name”…can I ask you for a favor and provide me a review by clicking on this link “link”.  I appreciate you taking the time out of your day to help me out.  Thanks for being awesome!  Waiting on confir', 0, 0, 1, 'auto_text_to_buyer_s_11_30_a_m', '2018-01-31 21:41:58', '2018-01-31 21:41:58'),
(7, 9, 6, 2, 'Auto Text to Buyer’s 8:45 a.m.\r\nGood morning :-)  Not sure if you’ve had a chance to talk to “lender” about locking in your rate…you may want to touch base to see if this is something you should do now or later.  Have a good day!', 0, 0, 1, 'auto_text_to_buyer_s_8_45_a_m_g', '2018-01-31 21:43:23', '2018-01-31 21:43:23'),
(8, 10, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nJust checking in… Here are some helpful links to check out…  EPA.gov.  I hope you’re day has been good.  If you have any questions, let me know.  By the way…if you know anyone who is looking to buy, sell or rent, please provid', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_just', '2018-01-31 21:43:44', '2018-01-31 21:43:44'),
(9, 11, 6, 2, 'VM Drop to Buyer’s 9 a.m.\r\nCan you believe its been one week?  Soon you will be in the property… excited yet?  If you have any ?’s please do not hesitate to ask.  Talk to you later', 0, 0, 1, 'vm_drop_to_buyer_s_9_a_m_can_yo', '2018-01-31 21:44:11', '2018-01-31 21:44:11'),
(10, 12, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nNot sure if “Lender” has told you…don’t do anything with your credit (buy a car, apply for credit, buy furniture, etc)!  If you need to please ask me or “Lender” first, we don’t want you debt ratio to change …don’t deposit any', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_not', '2018-01-31 21:44:33', '2018-01-31 21:44:33'),
(11, 13, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nDon’t switch jobs before closing, unless it’s unavoidable.  Change of employment will require lots of paperwork changes and will cause delay or sometimes cause you not to qualify anymore…I hope these helps :-) ', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_don', '2018-01-31 21:45:00', '2018-01-31 21:45:00'),
(12, 14, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nCan you contact your insurance agent to get a quote for the home.  You need to provide this to “Lender” once you receive the quote.  If you need another insurance agent let me know and I’d be happy to provide you my contacts :', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_can', '2018-01-31 21:45:26', '2018-01-31 21:45:26'),
(13, 15, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nHave you seen the home budgeting spreadsheet?  Check it out….its a great way to keep track of your money :-)  So far so good on the title search…no issues as of today.  Let me know if you know anyone looking to sell or buy :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_have', '2018-01-31 21:45:52', '2018-01-31 21:45:52'),
(14, 16, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nDuring this transaction…im never going to ask you to wire any funds.  If you see any emails from me asking please delete it and give me a call right away.  Just wanted to let you know…thanks.', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_duri', '2018-01-31 21:46:32', '2018-01-31 21:46:32'),
(15, 17, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see if you’ve provided all the documents “lender” needs…just wanted to warn you…they may keep asking for more even until the very end.  Its a little frustrating although it’s a lot of money you’re borrowing.  If', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec-1517435217', '2018-01-31 21:46:57', '2018-01-31 21:46:57'),
(16, 18, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nIm requesting for the utility info for your home…once received, I will let you know.  You’ll want to get the utilities transfer to you on settlement day.  ?’s let me know :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_im_r', '2018-01-31 21:47:22', '2018-01-31 21:47:22'),
(17, 19, 6, 2, 'Auto Text to Buyer’s 9 a.m.\r\nI wanted to get feedback on how you like working with “Lender”.  If you have any issues please let me know…I want to make sure you’re being taken care of :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_i_wa', '2018-01-31 21:47:48', '2018-01-31 21:47:48'),
(18, 20, 6, 2, 'Voicemail Drop\r\nWould you like me to create a search for homes in your new neighborhood so you can watch your equity grow?  Let me know :-)\r\n', 0, 0, 1, 'voicemail_drop_would_you_like_me_t', '2018-01-31 21:48:32', '2018-01-31 21:48:32'),
(19, 21, 6, 2, 'Auto Text to Buyer’s 9 a.m.   ********asking for referral\r\nGood morning..it’s time to start making a list to send change of addresses to….i.e.  post office, credit cards, bank, insurance, auto registration, friends/relatives (if you know anyone looking to', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m', '2018-01-31 21:48:58', '2018-01-31 21:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adminprojects`
--

CREATE TABLE `tbl_adminprojects` (
  `id` bigint(20) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_adminprojects`
--

INSERT INTO `tbl_adminprojects` (`id`, `project_name`, `status`, `slug`, `created`, `modified`) VALUES
(1, 'Buyer Transaction List', '1', 'buyer_project', '2018-01-27 06:13:55', '2018-05-07 14:02:27'),
(2, 'Buyer 30 Day Closing', '1', 'buyer_30_day_closing', '2018-01-31 17:55:43', '2018-06-20 21:20:40'),
(3, 'Buyer escrow', '1', 'juan_test_project', '2018-01-31 19:31:42', '2018-05-07 14:23:12'),
(4, 'Seller Transaction List', '1', 'seller_transaction_list', '2018-05-07 14:23:32', '2018-06-19 13:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admins`
--

CREATE TABLE `tbl_admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `phone` varchar(20) CHARACTER SET latin1 NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `status` smallint(2) NOT NULL,
  `is_tax` tinyint(1) NOT NULL DEFAULT '0',
  `tax` varchar(254) CHARACTER SET latin1 NOT NULL,
  `is_default_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `normal` varchar(100) CHARACTER SET latin1 NOT NULL,
  `advance` varchar(100) CHARACTER SET latin1 NOT NULL,
  `delivery_charge_limit` varchar(254) CHARACTER SET latin1 DEFAULT NULL,
  `customer_time` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `caterer_time` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `courier_time` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `modified` datetime NOT NULL,
  `attempt` int(11) NOT NULL,
  `resetkey` varchar(255) NOT NULL,
  `about` varchar(255) DEFAULT NULL,
  `contact_address` varchar(255) DEFAULT NULL,
  `contact_fax` varchar(50) DEFAULT NULL,
  `contact_emailaddress` varchar(255) DEFAULT NULL,
  `contact_number1` varchar(50) DEFAULT NULL,
  `contact_number2` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admins`
--

INSERT INTO `tbl_admins` (`id`, `username`, `password`, `email`, `name`, `phone`, `address`, `created`, `status`, `is_tax`, `tax`, `is_default_delivery`, `normal`, `advance`, `delivery_charge_limit`, `customer_time`, `caterer_time`, `courier_time`, `modified`, `attempt`, `resetkey`, `about`, `contact_address`, `contact_fax`, `contact_emailaddress`, `contact_number1`, `contact_number2`) VALUES
(1, 'logicspice', '00be3699f06b5124cbcccd08918b35d4', 'ashish.kharloya@logicspice.com', 'logicspice', '1234567891', 'logicspice', '2014-08-25 02:11:18', 1, 1, '10', 0, '9', '19', '50', '25550', '300', '120', '2014-12-04 17:16:34', 0, '', 'RealtySpace is the leader in online real estate and operator of the WK of real estate web site for consumers and real estate professionals. Real Estate of websites captures more than 20 million monthly visitors RealtySpace is the leader in online real tyr', '1950 New York, NY, Ave NW, California, DC 3000600, USA', '+1 202 555 0135', 'info@reultra.com', '+1 202 555 0135', '+1 202 555 0158');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admintasks`
--

CREATE TABLE `tbl_admintasks` (
  `id` bigint(20) NOT NULL,
  `board_id` bigint(20) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_description` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `due_date` datetime NOT NULL,
  `lastupdate` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admintasks`
--

INSERT INTO `tbl_admintasks` (`id`, `board_id`, `task_name`, `task_description`, `status`, `slug`, `due_date`, `lastupdate`, `created`, `modified`) VALUES
(1, 1, 'Agency relationship disclosure', '', '1', 'task_1', '0000-00-00 00:00:00', '0000-00-00', '2018-01-27 06:14:13', '2018-05-07 14:03:14'),
(6, 2, '30 Day Follow Up with Client', 'Communication for a 30 day closing', '1', '30_day_follow_up_with_client', '0000-00-00 00:00:00', '0000-00-00', '2018-01-31 18:09:31', '2018-01-31 18:15:01'),
(9, 9, 'Fully executed contract', '', '1', 'fully_executed_contract', '0000-00-00 00:00:00', '0000-00-00', '2018-01-31 19:34:06', '2018-01-31 19:34:15'),
(10, 1, 'Purchase agreement\r\n', '', '1', 'purchase_agreement', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:05:00', '2018-05-07 14:05:00'),
(11, 1, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:05:20', '2018-05-07 14:05:20'),
(12, 1, 'Schedule home inspection\r\n', '', '1', 'schedule_home_inspection', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:06:17', '2018-05-07 14:06:17'),
(13, 1, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:06:30', '2018-05-07 14:06:30'),
(14, 1, 'Order appraisal', '', '1', 'order_appraisal', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:06:40', '2018-05-07 14:06:40'),
(15, 1, 'Receive disclosures', '', '1', 'receive_disclosures', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:06:54', '2018-05-07 14:06:54'),
(16, 1, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:07:17', '2018-05-07 14:07:17'),
(17, 1, 'Enviromental hazards booklet', '', '1', 'enviromental_hazards_booklet', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:07:43', '2018-05-07 14:07:43'),
(18, 1, 'Natural hazards report', '', '1', 'natural_hazards_report', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:07:59', '2018-05-07 14:07:59'),
(19, 1, 'Property tax disclosure', '', '1', 'property_tax_disclosure', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:08:08', '2018-05-07 14:08:08'),
(20, 1, 'Review disclosures', '', '1', 'review_disclosures', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:08:16', '2018-05-07 14:08:16'),
(21, 1, 'Appraisal report', '', '1', 'appraisal_report', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:08:27', '2018-05-07 14:08:27'),
(22, 1, 'Remove contingencies', '', '1', 'remove_contingencies', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:08:36', '2018-05-07 14:08:36'),
(23, 1, 'Obtain homeowner\'s insurance', '', '1', 'obtain_homeowner_s_insurance', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:08:51', '2018-05-07 14:08:51'),
(24, 1, 'Confirm closer of escrow', '', '1', 'confirm_closer_of_escrow', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:09:05', '2018-05-07 14:09:05'),
(25, 1, 'Order home warranty', '', '1', 'order_home_warranty', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:09:17', '2018-05-07 14:09:17'),
(26, 1, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:09:30', '2018-05-07 14:09:30'),
(27, 1, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:09:51', '2018-05-07 14:09:51'),
(28, 14, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:24:11', '2018-05-07 14:24:11'),
(29, 14, 'Listing agreement', '', '1', 'listing_agreement', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:24:21', '2018-05-07 14:24:21'),
(30, 14, 'Estimate of sellers costs', '', '1', 'estimate_of_sellers_costs', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:24:43', '2018-05-07 14:24:43'),
(31, 14, 'Install yard sign', '', '1', 'install_yard_sign', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:24:52', '2018-05-07 14:24:52'),
(32, 14, 'Lock box authorization', '', '1', 'lock_box_authorization', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:25:01', '2018-05-07 14:25:01'),
(33, 14, 'Submit listing to MLS', '', '1', 'submit_listing_to_mls', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:25:08', '2018-05-07 14:25:08'),
(34, 14, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1525703123', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:25:23', '2018-05-07 14:25:23'),
(35, 14, 'Environmental hazards report', '', '1', 'environmental_hazards_report', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:25:46', '2018-05-07 14:25:46'),
(36, 14, 'Natural hazards report', '', '1', 'natural_hazards_report-1525703172', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:26:12', '2018-05-07 14:26:12'),
(37, 14, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1525703186', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:26:26', '2018-05-07 14:26:26'),
(38, 14, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1525703200', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:26:40', '2018-05-07 14:26:40'),
(39, 14, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1525703210', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:26:50', '2018-05-07 14:26:50'),
(40, 14, 'Order appraisal', '', '1', 'order_appraisal-1525703218', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:26:58', '2018-05-07 14:26:58'),
(41, 14, 'Send disclosures to buyer', '', '1', 'send_disclosures_to_buyer', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:27:14', '2018-05-07 14:27:14'),
(42, 14, 'Appraisal report', '', '1', 'appraisal_report-1525703253', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:27:33', '2018-05-07 14:27:33'),
(43, 14, 'Confirm removal of contingencies', '', '1', 'confirm_removal_of_contingencies', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:27:47', '2018-05-07 14:27:47'),
(44, 14, 'Order home warranty', '', '1', 'order_home_warranty-1525703276', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:27:56', '2018-05-07 14:27:56'),
(45, 14, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1525703288', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:28:08', '2018-05-07 14:28:08'),
(46, 14, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis-1525703313', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:28:33', '2018-05-07 14:28:33'),
(47, 14, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:28:43', '2018-05-07 14:28:43'),
(48, 15, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1525703836', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:37:16', '2018-05-07 14:37:16'),
(49, 15, 'Purchase agreement', '', '1', 'purchase_agreement-1525703847', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:37:27', '2018-05-07 14:37:27'),
(50, 15, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1525703860', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:37:40', '2018-05-07 14:37:40'),
(51, 15, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1525703875', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:37:55', '2018-05-07 14:37:55'),
(52, 15, 'Schedule home inspection', '', '1', 'schedule_home_inspection-1525703905', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:38:25', '2018-05-07 14:38:25'),
(53, 15, 'Order appraisal', '', '1', 'order_appraisal-1525703913', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:38:33', '2018-05-07 14:38:33'),
(54, 15, 'Receive disclosures', '', '1', 'receive_disclosures-1525703921', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:38:41', '2018-05-07 14:38:41'),
(55, 15, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1525703932', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:38:52', '2018-05-07 14:38:52'),
(56, 15, 'Environmental hazards booklet', '', '1', 'environmental_hazards_report-1525703952', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:39:12', '2018-05-07 14:39:34'),
(57, 15, 'Natural Hazards report', '', '1', 'natural_hazards_report-1525703988', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:39:48', '2018-05-07 14:39:48'),
(58, 15, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1525703996', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:39:56', '2018-05-07 14:39:56'),
(59, 15, 'Review disclosures', '', '1', 'review_disclosures-1525704008', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:40:08', '2018-05-07 14:40:08'),
(60, 15, 'Appraisal report', '', '1', 'appraisal_report-1525704016', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:40:16', '2018-05-07 14:40:16'),
(61, 15, 'Remove contingencies', '', '1', 'remove_contingencies-1525704043', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:40:43', '2018-05-07 14:40:43'),
(62, 15, 'Obtain homeowner\'s insurance', '', '1', 'obtain_homeowner_s_insurance-1525704313', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:45:13', '2018-05-07 14:45:13'),
(63, 15, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow-1525704322', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:45:22', '2018-05-07 14:45:22'),
(64, 15, 'Oder home warranty', '', '1', 'oder_home_warranty', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:45:31', '2018-05-07 14:45:31'),
(65, 15, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1525704349', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:45:49', '2018-05-07 14:45:49'),
(66, 15, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis-1525704364', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:46:04', '2018-05-07 14:46:04'),
(67, 16, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1525704428', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:47:08', '2018-05-07 14:47:08'),
(68, 16, 'Listing agreement', '', '1', 'listing_agreement-1525704897', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:54:57', '2018-05-07 14:54:57'),
(69, 16, 'Estimate of sellers costs', '', '1', 'estimate_of_sellers_costs-1525704910', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:55:10', '2018-05-07 14:55:10'),
(70, 16, 'Install yard sign', '', '1', 'install_yard_sign-1525704920', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:55:20', '2018-05-07 14:55:20'),
(71, 16, 'Lock box authorization', '', '1', 'lock_box_authorization-1525704929', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:55:29', '2018-05-07 14:55:29'),
(72, 16, 'Submit listing to MLS', '', '1', 'submit_listing_to_mls-1525704942', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:55:42', '2018-05-07 14:55:42'),
(73, 16, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1525704954', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:55:54', '2018-05-07 14:55:54'),
(74, 16, 'Environmental  hazards booklet', '', '1', 'environmental_hazards_booklet', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:56:22', '2018-05-07 14:56:22'),
(75, 16, 'Natural hazards report', '', '1', 'natural_hazards_report-1525705003', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:56:43', '2018-05-07 14:56:43'),
(76, 16, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1525705014', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:56:54', '2018-05-07 14:56:54'),
(77, 16, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1525705027', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:57:07', '2018-05-07 14:57:07'),
(78, 16, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1525705046', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:57:26', '2018-05-07 14:57:26'),
(79, 16, 'Order appraisal', '', '1', 'order_appraisal-1525705053', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:57:33', '2018-05-07 14:57:33'),
(80, 16, 'Send disclosures to Buyer', '', '1', 'send_disclosures_to_buyer-1525705074', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:57:54', '2018-05-07 14:57:54'),
(81, 16, 'Appraisal report', '', '1', 'appraisal_report-1525705085', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:58:05', '2018-05-07 14:58:05'),
(82, 16, 'Confirm removal of contingencies', '', '1', 'confirm_removal_of_contingencies-1525705102', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:58:22', '2018-05-07 14:58:22'),
(83, 16, 'Order home warranty', '', '1', 'order_home_warranty-1525705135', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:58:55', '2018-05-07 14:58:55'),
(84, 16, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1525705149', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:59:09', '2018-05-07 14:59:09'),
(85, 16, 'Confirm that Broker verified commissions ', '', '1', 'confirm_that_broker_verified_commis-1525705165', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:59:25', '2018-05-07 14:59:25'),
(86, 16, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow-1525705185', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 14:59:45', '2018-05-07 14:59:45'),
(87, 17, 'Send Fully executed purchase agreement and any counter offers', '', '1', 'send_fully_executed_purchase_agreem', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 15:00:48', '2018-05-07 15:00:48'),
(88, 18, 'Order Home Inspection', '', '1', 'order_home_inspection', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 15:01:12', '2018-05-07 15:01:12'),
(89, 18, 'Review home inspection report', '', '1', 'review_home_inspection_report', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 15:01:23', '2018-05-07 15:01:23'),
(90, 18, 'Request for repairs', '', '1', 'request_for_repairs', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 15:01:32', '2018-05-07 15:01:32'),
(91, 19, 'Order prelim', '', '1', 'order_prelim', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 15:01:51', '2018-05-07 15:01:51'),
(92, 20, 'Send Fully executed purchase agreement', '', '1', 'send_fully_executed_purchase_agreem-1525705338', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 15:02:18', '2018-05-07 15:02:18'),
(93, 20, 'Send emd', '', '1', 'send_emd', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 15:02:30', '2018-05-07 15:02:30'),
(94, 20, 'Escrow deposit receipt ', '', '1', 'escrow_deposit_receipt-1525705421', '0000-00-00 00:00:00', '0000-00-00', '2018-05-07 15:03:41', '2018-05-07 15:03:41'),
(96, 21, 'Client Touch task 1', '', '1', 'client_touch_task_1', '0000-00-00 00:00:00', '0000-00-00', '2018-06-20 21:21:11', '2018-06-20 21:21:11'),
(97, 21, 'client touch 2', '', '1', 'client_touch_2', '0000-00-00 00:00:00', '0000-00-00', '2018-06-24 12:27:33', '2018-06-24 12:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attachments`
--

CREATE TABLE `tbl_attachments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attachment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_attachments`
--

INSERT INTO `tbl_attachments` (`id`, `task_id`, `user_id`, `attachment`, `status`, `slug`, `created`, `modified`) VALUES
(1, 2, 2, '1517428276Taskboard project file 1-31-18.docx', 1, '151742827662643', '2018-01-31 19:51:16', '0000-00-00 00:00:00'),
(2, 2, 2, '1517428318f1503 monitor.jpg', 1, '151742831855871', '2018-01-31 19:51:58', '0000-00-00 00:00:00'),
(3, 5, 4, '1517475240Taskboard project file 1-31-18.docx', 1, '151747524026539', '2018-02-01 08:54:00', '0000-00-00 00:00:00'),
(4, 3, 4, '1517475650Taskboard project file 1-31-18.docx', 1, '151747565019330', '2018-02-01 09:00:50', '0000-00-00 00:00:00'),
(5, 4, 4, '15194034519Tips on Preparing Your Home for Sale.doc', 1, '151940345182173', '2018-02-23 16:30:51', '0000-00-00 00:00:00'),
(6, 4, 4, '151940349612552745_10208613939374273_780014593243024942_n.jpg', 1, '151940349697245', '2018-02-23 16:31:36', '0000-00-00 00:00:00'),
(7, 7, 4, '1520228449beating cancer.pdf', 1, '152022844910308', '2018-03-05 05:40:49', '0000-00-00 00:00:00'),
(8, 80, 5, '1526521918184 Tasks Agents Do For You | Ohio Association of Realtors.pdf', 1, '152652191838957', '2018-05-17 01:51:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_boards`
--

CREATE TABLE `tbl_boards` (
  `id` bigint(20) NOT NULL,
  `project_id` int(20) NOT NULL,
  `board_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `board_position` bigint(20) NOT NULL,
  `lastupdate` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_boards`
--

INSERT INTO `tbl_boards` (`id`, `project_id`, `board_name`, `status`, `slug`, `board_position`, `lastupdate`, `created`, `modified`) VALUES
(2, 1, 'Buyer Under Contract List', '1', 'buyer_under_contract_list', 5, '0000-00-00', '2018-01-31 19:45:04', '2018-01-31 19:45:04'),
(3, 1, 'Lender collaboration board', '1', 'lender_collaboration_board', 4, '0000-00-00', '2018-01-31 19:45:11', '2018-01-31 19:45:11'),
(5, 1, 'Title collaboration board', '1', 'title_collaboration_board-1517427933', 3, '0000-00-00', '2018-01-31 19:45:33', '2018-01-31 19:45:33'),
(6, 1, 'Escrow collaboration board', '1', 'escrow_collaboration_board', 2, '0000-00-00', '2018-01-31 19:45:52', '2018-01-31 19:45:52'),
(7, 1, 'Inspector collaboration board', '1', 'inspector_collaboration_board', 1, '0000-00-00', '2018-01-31 19:46:13', '2018-01-31 19:46:13'),
(9, 2, 'Lender collaboration board', '1', 'lender_collaboration_board-1517475097', 4, '0000-00-00', '2018-02-01 08:51:37', '2018-03-05 05:39:39'),
(10, 2, 'Title collaboration board', '1', 'title_collaboration_board', 3, '0000-00-00', '2018-02-01 08:51:46', '2018-02-01 08:51:46'),
(11, 2, 'Escrow collaboration board', '1', 'escrow_collaboration_board-1517475114', 2, '0000-00-00', '2018-02-01 08:51:54', '2018-04-19 05:49:39'),
(12, 2, 'Inspector collaboration board', '1', 'inspector_collaboration_board-1517475122', 1, '0000-00-00', '2018-02-01 08:52:02', '2018-02-01 08:52:02'),
(13, 3, 'First Board', '1', 'first_board', 1, '0000-00-00', '2018-05-02 12:14:54', '2018-05-02 12:14:54'),
(14, 4, 'Buyer Transaction List', '1', 'first_board-1525702324', 2, '0000-00-00', '2018-05-07 14:12:04', '2018-05-07 14:14:46'),
(15, 5, 'Buyer Transaction List', '1', 'buyer_transaction_list', 6, '0000-00-00', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(16, 5, 'Seller Transaction List', '1', 'seller_transaction_list', 5, '0000-00-00', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(17, 5, 'Lender Transaction List', '1', 'lender_transaction_list', 4, '0000-00-00', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(18, 5, 'Home Inspection Transaction List', '1', 'home_inspection_transaction_list', 3, '0000-00-00', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(19, 5, 'Title Transaction List', '1', 'title_transaction_list', 2, '0000-00-00', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(20, 5, 'Escrow Transaction List', '1', 'escrow_transaction_list', 1, '0000-00-00', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(21, 6, 'Client Communication ', '1', 'client_communication', 6, '0000-00-00', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(22, 6, 'Home Inspection Negotiations', '1', 'home_inspection_negotiations', 5, '0000-00-00', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(23, 6, 'Loan Officer Communication', '1', 'loan_officer_communication', 4, '0000-00-00', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(24, 6, 'Settlement Company Communication', '1', 'settlement_company_communication', 3, '0000-00-00', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(25, 6, 'Contingency Deadlines', '1', 'contingency_deadlines', 2, '0000-00-00', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(26, 6, 'Contract Inspections', '1', 'contract_inspections', 1, '0000-00-00', '2018-05-17 01:22:50', '2018-05-17 01:25:35'),
(27, 7, 'Seller Transaction List', '1', 'seller_transaction_list-1526520553', 4, '0000-00-00', '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(28, 7, 'Buyer Transaction List', '1', 'buyer_transaction_list-1526520553', 3, '0000-00-00', '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(29, 7, 'HomeInspection', '1', 'homeispection', 2, '0000-00-00', '2018-05-17 02:04:08', '2018-05-17 02:04:16'),
(30, 7, 'Termite', '1', 'termite', 1, '0000-00-00', '2018-05-17 02:11:55', '2018-05-17 02:11:55'),
(31, 8, 'Buyer Transaction List', '1', 'buyer_transaction_list-1526596526', 8, '0000-00-00', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(32, 8, 'Seller Transaction List', '1', 'seller_transaction_list-1526596526', 7, '0000-00-00', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(33, 8, 'Lender Transaction List', '1', 'lender_transaction_list-1526596526', 6, '0000-00-00', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(34, 8, 'Home Inspection', '1', 'home_inspection_transaction_list-1526596526', 5, '0000-00-00', '2018-05-17 22:35:26', '2018-06-20 13:12:49'),
(35, 8, 'Title Transaction List', '1', 'title_transaction_list-1526596526', 4, '0000-00-00', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(36, 8, 'Escrow Transaction List', '1', 'escrow_transaction_list-1526596526', 3, '0000-00-00', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(37, 8, 'Client Communication', '1', 'buyer30day_buyercommunication', 2, '0000-00-00', '2018-05-18 03:59:39', '2018-06-20 13:10:18'),
(38, 8, 'RadonTest', '1', 'radontest', 1, '0000-00-00', '2018-05-18 04:33:13', '2018-05-18 04:34:31'),
(39, 4, 'Tasklist2', '1', 'tasklist2', 1, '0000-00-00', '2018-05-30 17:08:33', '2018-06-13 12:22:12'),
(41, 9, 'Home Inspection Negotiations', '1', 'home_inspection_negotiations-1528255136', 5, '0000-00-00', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(42, 9, 'Lender docs and task list', '1', 'loan_officer_communication-1528255136', 4, '0000-00-00', '2018-06-05 20:18:56', '2018-07-05 14:21:01'),
(43, 9, 'Title docs and task list', '1', 'settlement_company_communication-1528255136', 3, '0000-00-00', '2018-06-05 20:18:56', '2018-07-05 14:20:46'),
(44, 9, 'Escrow docs and task list', '1', 'contingency_deadlines-1528255136', 2, '0000-00-00', '2018-06-05 20:18:56', '2018-07-05 14:20:08'),
(45, 9, 'Buyer task list', '1', 'contract_inspections-1528255136', 1, '0000-00-00', '2018-06-05 20:18:56', '2018-07-06 10:24:28'),
(46, 10, 'Buyer Transaction List', '1', 'buyer_transaction_list-1528842431', 6, '0000-00-00', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(47, 10, 'Seller Transaction List', '1', 'seller_transaction_list-1528842431', 5, '0000-00-00', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(48, 10, 'Lender Transaction List', '1', 'lender_transaction_list-1528842431', 4, '0000-00-00', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(49, 10, 'Home Inspection Transaction List', '1', 'home_inspection_transaction_list-1528842431', 3, '0000-00-00', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(50, 10, 'Title Transaction List', '1', 'title_transaction_list-1528842431', 2, '0000-00-00', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(51, 10, 'Escrow Transaction List', '1', 'escrow_transaction_list-1528842431', 1, '0000-00-00', '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(52, 11, 'Buyer Under Contract List', '1', 'buyer_under_contract_list-1529704598', 5, '0000-00-00', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(53, 11, 'Lender collaboration board', '1', 'lender_collaboration_board-1529704598', 4, '0000-00-00', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(54, 11, 'Title collaboration board', '1', 'title_collaboration_board-1529704598', 3, '0000-00-00', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(55, 11, 'Escrow collaboration board', '1', 'escrow_collaboration_board-1529704598', 2, '0000-00-00', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(56, 11, 'Inspector collaboration board', '1', 'inspector_collaboration_board-1529704598', 1, '0000-00-00', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(57, 12, 'Client Communication ', '1', 'client_communication-1529868658', 7, '0000-00-00', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(58, 12, 'Home Inspection Negotiations', '1', 'home_inspection_negotiations-1529868658', 6, '0000-00-00', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(59, 12, 'Loan Officer Communication', '1', 'loan_officer_communication-1529868658', 5, '0000-00-00', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(60, 12, 'Settlement Company Communication', '1', 'settlement_company_communication-1529868658', 4, '0000-00-00', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(61, 12, 'Contingency Deadlines', '1', 'contingency_deadlines-1529868658', 3, '0000-00-00', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(62, 12, 'Contract Inspections', '1', 'contract_inspections-1529868658', 2, '0000-00-00', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(63, 12, 'Client Touch', '1', 'client_touch', 1, '0000-00-00', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(64, 13, 'Client Communication ', '1', 'client_communication-1529873992', 7, '0000-00-00', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(65, 13, 'Home Inspection Negotiations', '1', 'home_inspection_negotiations-1529873992', 6, '0000-00-00', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(66, 13, 'Loan Officer Communication', '1', 'loan_officer_communication-1529873992', 5, '0000-00-00', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(67, 13, 'Settlement Company Communication', '1', 'settlement_company_communication-1529873992', 4, '0000-00-00', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(68, 13, 'Contingency Deadlines', '1', 'contingency_deadlines-1529873992', 3, '0000-00-00', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(69, 13, 'Contract Inspections', '1', 'contract_inspections-1529873992', 2, '0000-00-00', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(70, 13, 'Client Touch', '1', 'client_touch-1529873992', 1, '0000-00-00', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(71, 14, 'Buyer Under Contract List', '1', 'buyer_under_contract_list-1530080885', 5, '0000-00-00', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(72, 14, 'Lender collaboration board', '1', 'lender_collaboration_board-1530080885', 4, '0000-00-00', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(73, 14, 'Title collaboration board', '1', 'title_collaboration_board-1530080885', 3, '0000-00-00', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(74, 14, 'Escrow collaboration board', '1', 'escrow_collaboration_board-1530080885', 2, '0000-00-00', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(75, 14, 'Inspector collaboration board', '1', 'inspector_collaboration_board-1530080885', 1, '0000-00-00', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(76, 15, 'Buyer Transaction List', '1', 'buyer_transaction_list-1531279978', 6, '0000-00-00', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(77, 15, 'Seller Transaction List', '1', 'seller_transaction_list-1531279978', 5, '0000-00-00', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(78, 15, 'Lender Transaction List', '1', 'lender_transaction_list-1531279978', 4, '0000-00-00', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(79, 15, 'Home Inspection Transaction List', '1', 'home_inspection_transaction_list-1531279978', 3, '0000-00-00', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(80, 15, 'Title Transaction List', '1', 'title_transaction_list-1531279978', 2, '0000-00-00', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(81, 15, 'Escrow Transaction List', '1', 'escrow_transaction_list-1531279978', 1, '0000-00-00', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(82, 16, 'Buyer Under Contract List', '1', 'buyer_under_contract_list-1531877769', 5, '0000-00-00', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(83, 16, 'Lender collaboration board', '1', 'lender_collaboration_board-1531877769', 4, '0000-00-00', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(84, 16, 'Title collaboration board', '1', 'title_collaboration_board-1531877769', 3, '0000-00-00', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(85, 16, 'Escrow collaboration board', '1', 'escrow_collaboration_board-1531877769', 2, '0000-00-00', '2018-07-17 18:36:09', '2018-07-17 18:36:09'),
(86, 16, 'Inspector collaboration board', '1', 'inspector_collaboration_board-1531877769', 1, '0000-00-00', '2018-07-17 18:36:09', '2018-07-17 18:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `category_auther` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checklists`
--

CREATE TABLE `tbl_checklists` (
  `id` int(20) NOT NULL,
  `task_id` int(20) NOT NULL,
  `board_id` int(20) NOT NULL,
  `checkbox_title` varchar(255) NOT NULL,
  `no_of_items` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_checklists`
--

INSERT INTO `tbl_checklists` (`id`, `task_id`, `board_id`, `checkbox_title`, `no_of_items`, `status`, `slug`, `created`, `modified`) VALUES
(2, 2, 2, 'Fully Executed contract items', 0, 1, 'fully_executed_contract_items', '2018-01-31 19:48:12', '2018-01-31 19:48:12'),
(3, 3, 8, 'Fully executed contract', 0, 1, 'fully_executed_contract', '2018-02-01 08:51:30', '2018-02-01 08:51:30'),
(4, 4, 12, 'checklist 1', 0, 1, 'checklist_1', '2018-02-09 01:06:36', '2018-02-09 01:06:36'),
(5, 77, 21, 'Day 0', 0, 1, 'day_0', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(6, 77, 21, 'Day 1', 0, 1, 'day_1', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(7, 77, 21, 'Day 2', 0, 1, 'day_2', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(8, 77, 21, 'Day 3', 0, 1, 'day_3', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(9, 77, 21, 'Day 4', 0, 1, 'day_4', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(10, 77, 21, 'Day 5', 0, 1, 'day_5', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(11, 77, 21, 'Day 7', 0, 1, 'day_7', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(12, 77, 21, 'Day 8', 0, 1, 'day_8', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(13, 77, 21, 'Day 10', 0, 1, 'day_10', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(14, 77, 21, 'Day 11', 0, 1, 'day_11', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(15, 77, 21, 'Day 13', 0, 1, 'day_13', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(16, 77, 21, 'Day 15', 0, 1, 'day_15', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(17, 77, 21, 'Day 17', 0, 1, 'day_17', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(18, 77, 21, 'Day 18', 0, 1, 'day_18', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(19, 77, 21, 'Day 20', 0, 1, 'day_20', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(20, 77, 21, 'Day 22', 0, 1, 'day_22', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(21, 77, 21, 'Day 23', 0, 1, 'day_23', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(22, 176, 40, 'Day 0', 0, 1, 'day_0-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(23, 176, 40, 'Day 1', 0, 1, 'day_1-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(24, 176, 40, 'Day 2', 0, 1, 'day_2-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(25, 176, 40, 'Day 3', 0, 1, 'day_3-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(26, 176, 40, 'Day 4', 0, 1, 'day_4-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(27, 176, 40, 'Day 5', 0, 1, 'day_5-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(28, 176, 40, 'Day 7', 0, 1, 'day_7-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(29, 176, 40, 'Day 8', 0, 1, 'day_8-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(30, 176, 40, 'Day 10', 0, 1, 'day_10-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(31, 176, 40, 'Day 11', 0, 1, 'day_11-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(32, 176, 40, 'Day 13', 0, 1, 'day_13-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(33, 176, 40, 'Day 15', 0, 1, 'day_15-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(34, 176, 40, 'Day 17', 0, 1, 'day_17-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(35, 176, 40, 'Day 18', 0, 1, 'day_18-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(36, 176, 40, 'Day 20', 0, 1, 'day_20-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(37, 176, 40, 'Day 22', 0, 1, 'day_22-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(38, 176, 40, 'Day 23', 0, 1, 'day_23-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(39, 228, 52, 'Fully executed contract', 0, 1, 'fully_executed_contract-1529704598', '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(40, 229, 57, 'Day 0', 0, 1, 'day_0-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(41, 229, 57, 'Day 1', 0, 1, 'day_1-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(42, 229, 57, 'Day 2', 0, 1, 'day_2-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(43, 229, 57, 'Day 3', 0, 1, 'day_3-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(44, 229, 57, 'Day 4', 0, 1, 'day_4-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(45, 229, 57, 'Day 5', 0, 1, 'day_5-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(46, 229, 57, 'Day 7', 0, 1, 'day_7-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(47, 229, 57, 'Day 8', 0, 1, 'day_8-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(48, 229, 57, 'Day 10', 0, 1, 'day_10-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(49, 229, 57, 'Day 11', 0, 1, 'day_11-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(50, 229, 57, 'Day 13', 0, 1, 'day_13-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(51, 229, 57, 'Day 15', 0, 1, 'day_15-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(52, 229, 57, 'Day 17', 0, 1, 'day_17-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(53, 229, 57, 'Day 18', 0, 1, 'day_18-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(54, 229, 57, 'Day 20', 0, 1, 'day_20-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(55, 229, 57, 'Day 22', 0, 1, 'day_22-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(56, 229, 57, 'Day 23', 0, 1, 'day_23-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(57, 232, 64, 'Day 0', 0, 1, 'day_0-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(58, 232, 64, 'Day 1', 0, 1, 'day_1-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(59, 232, 64, 'Day 2', 0, 1, 'day_2-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(60, 232, 64, 'Day 3', 0, 1, 'day_3-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(61, 232, 64, 'Day 4', 0, 1, 'day_4-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(62, 232, 64, 'Day 5', 0, 1, 'day_5-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(63, 232, 64, 'Day 7', 0, 1, 'day_7-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(64, 232, 64, 'Day 8', 0, 1, 'day_8-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(65, 232, 64, 'Day 10', 0, 1, 'day_10-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(66, 232, 64, 'Day 11', 0, 1, 'day_11-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(67, 232, 64, 'Day 13', 0, 1, 'day_13-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(68, 232, 64, 'Day 15', 0, 1, 'day_15-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(69, 232, 64, 'Day 17', 0, 1, 'day_17-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(70, 232, 64, 'Day 18', 0, 1, 'day_18-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(71, 232, 64, 'Day 20', 0, 1, 'day_20-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(72, 232, 64, 'Day 22', 0, 1, 'day_22-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(73, 232, 64, 'Day 23', 0, 1, 'day_23-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(74, 236, 71, 'Fully executed contract', 0, 1, 'fully_executed_contract-1530080885', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(75, 292, 82, 'Fully executed contract', 0, 1, 'fully_executed_contract-1531877769', '2018-07-17 18:36:09', '2018-07-17 18:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checklistvalues`
--

CREATE TABLE `tbl_checklistvalues` (
  `id` bigint(20) NOT NULL,
  `checklist_id` bigint(20) NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `board_id` bigint(20) NOT NULL,
  `checkbox_value` varchar(255) NOT NULL,
  `is_checked` tinyint(2) NOT NULL,
  `checked_by` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_checklistvalues`
--

INSERT INTO `tbl_checklistvalues` (`id`, `checklist_id`, `task_id`, `board_id`, `checkbox_value`, `is_checked`, `checked_by`, `status`, `slug`, `created`, `modified`) VALUES
(1, 2, 2, 2, 'Residential Purchase Agreement', 0, 2, 1, 'residential_purchase_agreement', '2018-01-31 19:48:33', '2018-01-31 19:48:58'),
(2, 2, 2, 2, 'Counter offers', 0, 0, 1, 'counter_offers', '2018-01-31 19:48:47', '2018-01-31 19:48:47'),
(3, 2, 2, 2, 'Addendums', 0, 0, 1, 'addendums', '2018-01-31 19:48:53', '2018-01-31 19:48:53'),
(4, 5, 77, 21, 'VIDEO AUTO TEXT TO BUYER CLIENT\r\nAuto Video Script for Buyers after filling out Contract Wizard questions: \r\n\r\n\"Congratulations \"Buyer\'s Name\" on your new home. Now that you found your dream home we will proceed with the transaction. We will go through th', 0, 0, 1, 'video_auto_text_to_buyer_client_au', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(5, 6, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see when you’re available for home inspection.  Let me know…have a great day, thanks :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(6, 7, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nPlease turn in all your docs to “Loan Officer”.  You may hear from the Processor if you haven’t already…they will be asking for lots of info in the next 20 days.  Im here if you have any questions.  Have a good one!', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_plea', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(7, 8, 77, 21, 'Auto Text to Buyer’s 11:30 a.m.\r\nGood afternoon “buyer name”…can I ask you for a favor and provide me a review by clicking on this link “link”.  I appreciate you taking the time out of your day to help me out.  Thanks for being awesome!  Waiting on confir', 0, 0, 1, 'auto_text_to_buyer_s_11_30_a_m', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(8, 9, 77, 21, 'Auto Text to Buyer’s 8:45 a.m.\r\nGood morning :-)  Not sure if you’ve had a chance to talk to “lender” about locking in your rate…you may want to touch base to see if this is something you should do now or later.  Have a good day!', 0, 0, 1, 'auto_text_to_buyer_s_8_45_a_m_g', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(9, 10, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nJust checking in… Here are some helpful links to check out…  EPA.gov.  I hope you’re day has been good.  If you have any questions, let me know.  By the way…if you know anyone who is looking to buy, sell or rent, please provid', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_just', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(10, 11, 77, 21, 'VM Drop to Buyer’s 9 a.m.\r\nCan you believe its been one week?  Soon you will be in the property… excited yet?  If you have any ?’s please do not hesitate to ask.  Talk to you later', 0, 0, 1, 'vm_drop_to_buyer_s_9_a_m_can_yo', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(11, 12, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nNot sure if “Lender” has told you…don’t do anything with your credit (buy a car, apply for credit, buy furniture, etc)!  If you need to please ask me or “Lender” first, we don’t want you debt ratio to change …don’t deposit any', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_not', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(12, 13, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nDon’t switch jobs before closing, unless it’s unavoidable.  Change of employment will require lots of paperwork changes and will cause delay or sometimes cause you not to qualify anymore…I hope these helps :-) ', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_don', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(13, 14, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nCan you contact your insurance agent to get a quote for the home.  You need to provide this to “Lender” once you receive the quote.  If you need another insurance agent let me know and I’d be happy to provide you my contacts :', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_can', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(14, 15, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nHave you seen the home budgeting spreadsheet?  Check it out….its a great way to keep track of your money :-)  So far so good on the title search…no issues as of today.  Let me know if you know anyone looking to sell or buy :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_have', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(15, 16, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nDuring this transaction…im never going to ask you to wire any funds.  If you see any emails from me asking please delete it and give me a call right away.  Just wanted to let you know…thanks.', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_duri', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(16, 17, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see if you’ve provided all the documents “lender” needs…just wanted to warn you…they may keep asking for more even until the very end.  Its a little frustrating although it’s a lot of money you’re borrowing.  If', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec-1526520170', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(17, 18, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nIm requesting for the utility info for your home…once received, I will let you know.  You’ll want to get the utilities transfer to you on settlement day.  ?’s let me know :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_im_r', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(18, 19, 77, 21, 'Auto Text to Buyer’s 9 a.m.\r\nI wanted to get feedback on how you like working with “Lender”.  If you have any issues please let me know…I want to make sure you’re being taken care of :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_i_wa', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(19, 20, 77, 21, 'Voicemail Drop\r\nWould you like me to create a search for homes in your new neighborhood so you can watch your equity grow?  Let me know :-)\r\n', 0, 0, 1, 'voicemail_drop_would_you_like_me_t', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(20, 21, 77, 21, 'Auto Text to Buyer’s 9 a.m.   ********asking for referral\r\nGood morning..it’s time to start making a list to send change of addresses to….i.e.  post office, credit cards, bank, insurance, auto registration, friends/relatives (if you know anyone looking to', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m', '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(21, 22, 176, 40, 'VIDEO AUTO TEXT TO BUYER CLIENT\r\nAuto Video Script for Buyers after filling out Contract Wizard questions: \r\n\r\n\"Congratulations \"Buyer\'s Name\" on your new home. Now that you found your dream home we will proceed with the transaction. We will go through th', 0, 0, 1, 'video_auto_text_to_buyer_client_au-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(22, 23, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see when you’re available for home inspection.  Let me know…have a great day, thanks :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(23, 24, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nPlease turn in all your docs to “Loan Officer”.  You may hear from the Processor if you haven’t already…they will be asking for lots of info in the next 20 days.  Im here if you have any questions.  Have a good one!', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_plea-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(24, 25, 176, 40, 'Auto Text to Buyer’s 11:30 a.m.\r\nGood afternoon “buyer name”…can I ask you for a favor and provide me a review by clicking on this link “link”.  I appreciate you taking the time out of your day to help me out.  Thanks for being awesome!  Waiting on confir', 0, 0, 1, 'auto_text_to_buyer_s_11_30_a_m-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(25, 26, 176, 40, 'Auto Text to Buyer’s 8:45 a.m.\r\nGood morning :-)  Not sure if you’ve had a chance to talk to “lender” about locking in your rate…you may want to touch base to see if this is something you should do now or later.  Have a good day!', 0, 0, 1, 'auto_text_to_buyer_s_8_45_a_m_g-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(26, 27, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nJust checking in… Here are some helpful links to check out…  EPA.gov.  I hope you’re day has been good.  If you have any questions, let me know.  By the way…if you know anyone who is looking to buy, sell or rent, please provid', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_just-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(27, 28, 176, 40, 'VM Drop to Buyer’s 9 a.m.\r\nCan you believe its been one week?  Soon you will be in the property… excited yet?  If you have any ?’s please do not hesitate to ask.  Talk to you later', 0, 0, 1, 'vm_drop_to_buyer_s_9_a_m_can_yo-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(28, 29, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nNot sure if “Lender” has told you…don’t do anything with your credit (buy a car, apply for credit, buy furniture, etc)!  If you need to please ask me or “Lender” first, we don’t want you debt ratio to change …don’t deposit any', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_not-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(29, 30, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nDon’t switch jobs before closing, unless it’s unavoidable.  Change of employment will require lots of paperwork changes and will cause delay or sometimes cause you not to qualify anymore…I hope these helps :-) ', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_don-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(30, 31, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nCan you contact your insurance agent to get a quote for the home.  You need to provide this to “Lender” once you receive the quote.  If you need another insurance agent let me know and I’d be happy to provide you my contacts :', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_can-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(31, 32, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nHave you seen the home budgeting spreadsheet?  Check it out….its a great way to keep track of your money :-)  So far so good on the title search…no issues as of today.  Let me know if you know anyone looking to sell or buy :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_have-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(32, 33, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nDuring this transaction…im never going to ask you to wire any funds.  If you see any emails from me asking please delete it and give me a call right away.  Just wanted to let you know…thanks.', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_duri-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(33, 34, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see if you’ve provided all the documents “lender” needs…just wanted to warn you…they may keep asking for more even until the very end.  Its a little frustrating although it’s a lot of money you’re borrowing.  If', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(34, 35, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nIm requesting for the utility info for your home…once received, I will let you know.  You’ll want to get the utilities transfer to you on settlement day.  ?’s let me know :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_im_r-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(35, 36, 176, 40, 'Auto Text to Buyer’s 9 a.m.\r\nI wanted to get feedback on how you like working with “Lender”.  If you have any issues please let me know…I want to make sure you’re being taken care of :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_i_wa-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(36, 37, 176, 40, 'Voicemail Drop\r\nWould you like me to create a search for homes in your new neighborhood so you can watch your equity grow?  Let me know :-)\r\n', 0, 0, 1, 'voicemail_drop_would_you_like_me_t-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(37, 38, 176, 40, 'Auto Text to Buyer’s 9 a.m.   ********asking for referral\r\nGood morning..it’s time to start making a list to send change of addresses to….i.e.  post office, credit cards, bank, insurance, auto registration, friends/relatives (if you know anyone looking to', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m-1528255136', '2018-06-05 20:18:56', '2018-06-05 20:18:56'),
(38, 40, 229, 57, 'VIDEO AUTO TEXT TO BUYER CLIENT\r\nAuto Video Script for Buyers after filling out Contract Wizard questions: \r\n\r\n\"Congratulations \"Buyer\'s Name\" on your new home. Now that you found your dream home we will proceed with the transaction. We will go through th', 0, 0, 1, 'video_auto_text_to_buyer_client_au-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(39, 41, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see when you’re available for home inspection.  Let me know…have a great day, thanks :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(40, 42, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nPlease turn in all your docs to “Loan Officer”.  You may hear from the Processor if you haven’t already…they will be asking for lots of info in the next 20 days.  Im here if you have any questions.  Have a good one!', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_plea-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(41, 43, 229, 57, 'Auto Text to Buyer’s 11:30 a.m.\r\nGood afternoon “buyer name”…can I ask you for a favor and provide me a review by clicking on this link “link”.  I appreciate you taking the time out of your day to help me out.  Thanks for being awesome!  Waiting on confir', 0, 0, 1, 'auto_text_to_buyer_s_11_30_a_m-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(42, 44, 229, 57, 'Auto Text to Buyer’s 8:45 a.m.\r\nGood morning :-)  Not sure if you’ve had a chance to talk to “lender” about locking in your rate…you may want to touch base to see if this is something you should do now or later.  Have a good day!', 0, 0, 1, 'auto_text_to_buyer_s_8_45_a_m_g-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(43, 45, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nJust checking in… Here are some helpful links to check out…  EPA.gov.  I hope you’re day has been good.  If you have any questions, let me know.  By the way…if you know anyone who is looking to buy, sell or rent, please provid', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_just-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(44, 46, 229, 57, 'VM Drop to Buyer’s 9 a.m.\r\nCan you believe its been one week?  Soon you will be in the property… excited yet?  If you have any ?’s please do not hesitate to ask.  Talk to you later', 0, 0, 1, 'vm_drop_to_buyer_s_9_a_m_can_yo-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(45, 47, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nNot sure if “Lender” has told you…don’t do anything with your credit (buy a car, apply for credit, buy furniture, etc)!  If you need to please ask me or “Lender” first, we don’t want you debt ratio to change …don’t deposit any', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_not-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(46, 48, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nDon’t switch jobs before closing, unless it’s unavoidable.  Change of employment will require lots of paperwork changes and will cause delay or sometimes cause you not to qualify anymore…I hope these helps :-) ', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_don-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(47, 49, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nCan you contact your insurance agent to get a quote for the home.  You need to provide this to “Lender” once you receive the quote.  If you need another insurance agent let me know and I’d be happy to provide you my contacts :', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_can-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(48, 50, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nHave you seen the home budgeting spreadsheet?  Check it out….its a great way to keep track of your money :-)  So far so good on the title search…no issues as of today.  Let me know if you know anyone looking to sell or buy :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_have-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(49, 51, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nDuring this transaction…im never going to ask you to wire any funds.  If you see any emails from me asking please delete it and give me a call right away.  Just wanted to let you know…thanks.', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_duri-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(50, 52, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see if you’ve provided all the documents “lender” needs…just wanted to warn you…they may keep asking for more even until the very end.  Its a little frustrating although it’s a lot of money you’re borrowing.  If', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(51, 53, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nIm requesting for the utility info for your home…once received, I will let you know.  You’ll want to get the utilities transfer to you on settlement day.  ?’s let me know :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_im_r-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(52, 54, 229, 57, 'Auto Text to Buyer’s 9 a.m.\r\nI wanted to get feedback on how you like working with “Lender”.  If you have any issues please let me know…I want to make sure you’re being taken care of :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_i_wa-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(53, 55, 229, 57, 'Voicemail Drop\r\nWould you like me to create a search for homes in your new neighborhood so you can watch your equity grow?  Let me know :-)\r\n', 0, 0, 1, 'voicemail_drop_would_you_like_me_t-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(54, 56, 229, 57, 'Auto Text to Buyer’s 9 a.m.   ********asking for referral\r\nGood morning..it’s time to start making a list to send change of addresses to….i.e.  post office, credit cards, bank, insurance, auto registration, friends/relatives (if you know anyone looking to', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m-1529868658', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(55, 57, 232, 64, 'VIDEO AUTO TEXT TO BUYER CLIENT\r\nAuto Video Script for Buyers after filling out Contract Wizard questions: \r\n\r\n\"Congratulations \"Buyer\'s Name\" on your new home. Now that you found your dream home we will proceed with the transaction. We will go through th', 0, 0, 1, 'video_auto_text_to_buyer_client_au-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(56, 58, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see when you’re available for home inspection.  Let me know…have a great day, thanks :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(57, 59, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nPlease turn in all your docs to “Loan Officer”.  You may hear from the Processor if you haven’t already…they will be asking for lots of info in the next 20 days.  Im here if you have any questions.  Have a good one!', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_plea-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(58, 60, 232, 64, 'Auto Text to Buyer’s 11:30 a.m.\r\nGood afternoon “buyer name”…can I ask you for a favor and provide me a review by clicking on this link “link”.  I appreciate you taking the time out of your day to help me out.  Thanks for being awesome!  Waiting on confir', 0, 0, 1, 'auto_text_to_buyer_s_11_30_a_m-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(59, 61, 232, 64, 'Auto Text to Buyer’s 8:45 a.m.\r\nGood morning :-)  Not sure if you’ve had a chance to talk to “lender” about locking in your rate…you may want to touch base to see if this is something you should do now or later.  Have a good day!', 0, 0, 1, 'auto_text_to_buyer_s_8_45_a_m_g-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(60, 62, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nJust checking in… Here are some helpful links to check out…  EPA.gov.  I hope you’re day has been good.  If you have any questions, let me know.  By the way…if you know anyone who is looking to buy, sell or rent, please provid', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_just-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(61, 63, 232, 64, 'VM Drop to Buyer’s 9 a.m.\r\nCan you believe its been one week?  Soon you will be in the property… excited yet?  If you have any ?’s please do not hesitate to ask.  Talk to you later', 0, 0, 1, 'vm_drop_to_buyer_s_9_a_m_can_yo-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(62, 64, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nNot sure if “Lender” has told you…don’t do anything with your credit (buy a car, apply for credit, buy furniture, etc)!  If you need to please ask me or “Lender” first, we don’t want you debt ratio to change …don’t deposit any', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_not-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(63, 65, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nDon’t switch jobs before closing, unless it’s unavoidable.  Change of employment will require lots of paperwork changes and will cause delay or sometimes cause you not to qualify anymore…I hope these helps :-) ', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_don-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(64, 66, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nCan you contact your insurance agent to get a quote for the home.  You need to provide this to “Lender” once you receive the quote.  If you need another insurance agent let me know and I’d be happy to provide you my contacts :', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_can-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(65, 67, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nHave you seen the home budgeting spreadsheet?  Check it out….its a great way to keep track of your money :-)  So far so good on the title search…no issues as of today.  Let me know if you know anyone looking to sell or buy :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_have-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(66, 68, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nDuring this transaction…im never going to ask you to wire any funds.  If you see any emails from me asking please delete it and give me a call right away.  Just wanted to let you know…thanks.', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_duri-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(67, 69, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nChecking in to see if you’ve provided all the documents “lender” needs…just wanted to warn you…they may keep asking for more even until the very end.  Its a little frustrating although it’s a lot of money you’re borrowing.  If', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_chec-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(68, 70, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nIm requesting for the utility info for your home…once received, I will let you know.  You’ll want to get the utilities transfer to you on settlement day.  ?’s let me know :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_im_r-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(69, 71, 232, 64, 'Auto Text to Buyer’s 9 a.m.\r\nI wanted to get feedback on how you like working with “Lender”.  If you have any issues please let me know…I want to make sure you’re being taken care of :-)', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m_i_wa-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(70, 72, 232, 64, 'Voicemail Drop\r\nWould you like me to create a search for homes in your new neighborhood so you can watch your equity grow?  Let me know :-)\r\n', 0, 0, 1, 'voicemail_drop_would_you_like_me_t-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(71, 73, 232, 64, 'Auto Text to Buyer’s 9 a.m.   ********asking for referral\r\nGood morning..it’s time to start making a list to send change of addresses to….i.e.  post office, credit cards, bank, insurance, auto registration, friends/relatives (if you know anyone looking to', 0, 0, 1, 'auto_text_to_buyer_s_9_a_m-1529873992', '2018-06-24 13:59:52', '2018-06-24 13:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`id`, `task_id`, `user_id`, `comment`, `status`, `slug`, `created`, `modified`) VALUES
(1, 5, 4, 'Here is the inspection report', 1, '151747523626087', '2018-02-01 08:53:56', '0000-00-00 00:00:00'),
(2, 3, 4, '@ez_leadpages  Here is the contract', 1, '151747567812250', '2018-02-01 09:01:18', '0000-00-00 00:00:00'),
(3, 3, 6, 'Thanks Juan', 1, '151747578333653', '2018-02-01 09:03:03', '0000-00-00 00:00:00'),
(4, 6, 4, '@ez_leadpages ', 1, '151928237390307', '2018-02-22 06:52:53', '0000-00-00 00:00:00'),
(5, 4, 4, '@ez_leadpages ', 1, '152022762973983', '2018-03-05 05:27:09', '0000-00-00 00:00:00'),
(6, 7, 4, 'Thanks phatleads @phat ', 1, '152022864916031', '2018-03-05 05:44:09', '0000-00-00 00:00:00'),
(7, 7, 5, 'thank you', 1, '152022871896971', '2018-03-05 05:45:18', '0000-00-00 00:00:00'),
(8, 7, 4, 'Great, good job boy', 1, '152022874884837', '2018-03-05 05:45:48', '0000-00-00 00:00:00'),
(9, 30, 4, 'testing @phat ', 1, '152616208070823', '2018-05-12 21:54:40', '0000-00-00 00:00:00'),
(10, 30, 5, 'great', 1, '152616210574005', '2018-05-12 21:55:05', '0000-00-00 00:00:00'),
(11, 80, 5, 'Hey Giovanni', 1, '152652146622375', '2018-05-17 01:44:26', '0000-00-00 00:00:00'),
(12, 230, 4, '@giovanni_santaana I\"m in, thanks for inviting me!', 1, '152987169267565', '2018-06-24 13:21:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invites`
--

CREATE TABLE `tbl_invites` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `join_status` tinyint(4) NOT NULL,
  `user_type` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_invites`
--

INSERT INTO `tbl_invites` (`id`, `project_id`, `board_id`, `user_id`, `email_address`, `status`, `join_status`, `user_type`, `created`, `modified`) VALUES
(1, 1, 0, 0, 'infoezleadpages@gmail.com', 1, 0, 1, '2018-01-31 19:52:35', '0000-00-00 00:00:00'),
(2, 2, 0, 6, 'infoezleadpages@gmail.com', 1, 1, 1, '2018-02-01 08:55:23', '2018-02-01 08:57:50'),
(3, 2, 0, 5, 'infophatleads@gmail.com', 1, 1, 0, '2018-03-05 05:37:11', '2018-03-05 05:37:49'),
(4, 5, 15, 5, 'infophatleads@gmail.com', 1, 1, 0, '2018-05-12 21:50:07', '2018-05-12 21:52:47'),
(5, 7, 28, 5, 'infophatleads@gmail.com', 1, 1, 0, '2018-05-17 01:29:57', '2018-05-17 01:43:55'),
(6, 5, 20, 6, 'infoezleadpages@gmail.com', 1, 1, 0, '2018-05-31 17:06:53', '2018-05-31 17:12:20'),
(7, 9, 45, 6, 'infoezleadpages@gmail.com', 1, 1, 0, '2018-06-05 20:19:07', '2018-06-05 20:19:44'),
(8, 12, 63, 4, 'juangmolina76@gmail.com', 1, 1, 0, '2018-06-24 12:38:31', '2018-06-24 13:21:00'),
(9, 14, 75, 5, 'infophatleads@gmail.com', 1, 0, 0, '2018-06-26 23:39:57', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `read_status` tinyint(4) NOT NULL,
  `url` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`id`, `user_id`, `project_id`, `board_id`, `task_id`, `type`, `status`, `read_status`, `url`, `slug`, `created`, `modified`) VALUES
(1, 2, 1, 0, 0, 'delete_board', 1, 1, '', '65717835', '2018-01-31 19:44:48', '2018-01-31 19:47:20'),
(2, 2, 1, 0, 0, 'delete_board', 1, 1, '', '61430624', '2018-01-31 19:45:41', '2018-01-31 19:47:20'),
(3, 4, 2, 12, 4, 'add_task', 1, 1, '', '74154687', '2018-02-01 08:52:14', '2018-07-12 22:32:23'),
(4, 4, 2, 12, 5, 'add_task', 1, 1, '', '37903653', '2018-02-01 08:52:23', '2018-07-12 22:32:23'),
(5, 4, 2, 12, 5, 'add_comment', 1, 1, '', '45902170', '2018-02-01 08:53:56', '2018-07-12 22:32:23'),
(6, 6, 0, 8, 3, 'memeber_mention', 1, 1, '', '15174756783540298', '2018-02-01 09:01:18', '2018-06-28 22:19:37'),
(7, 6, 2, 8, 3, 'add_comment', 1, 1, '', '31195391', '2018-02-01 09:01:18', '2018-06-28 22:19:37'),
(8, 4, 2, 8, 3, 'add_comment', 1, 1, '', '39214248', '2018-02-01 09:01:18', '2018-07-12 22:32:23'),
(9, 6, 2, 8, 3, 'add_comment', 1, 1, '', '31191790', '2018-02-01 09:03:03', '2018-06-28 22:19:37'),
(10, 4, 2, 8, 3, 'add_comment', 1, 1, '', '18033143', '2018-02-01 09:03:04', '2018-07-12 22:32:23'),
(11, 6, 2, 9, 6, 'add_task', 1, 1, '', '64094103', '2018-02-22 06:52:33', '2018-06-28 22:19:37'),
(12, 4, 2, 9, 6, 'add_task', 1, 1, '', '72732432', '2018-02-22 06:52:33', '2018-07-12 22:32:23'),
(13, 6, 0, 9, 6, 'memeber_mention', 1, 1, '', '15192823734048242', '2018-02-22 06:52:53', '2018-06-28 22:19:37'),
(14, 6, 2, 9, 6, 'add_comment', 1, 1, '', '65009891', '2018-02-22 06:52:53', '2018-06-28 22:19:37'),
(15, 4, 2, 9, 6, 'add_comment', 1, 1, '', '47430873', '2018-02-22 06:52:53', '2018-07-12 22:32:23'),
(16, 4, 2, 0, 0, 'delete_board', 1, 1, '', '50124060', '2018-02-23 18:09:46', '2018-07-12 22:32:23'),
(17, 4, 2, 0, 0, 'delete_board', 1, 1, '', '67867261', '2018-02-23 18:09:46', '2018-07-12 22:32:23'),
(18, 6, 0, 12, 4, 'memeber_mention', 1, 1, '', '15202276294626485', '2018-03-05 05:27:09', '2018-06-28 22:19:37'),
(19, 6, 2, 12, 4, 'add_comment', 1, 1, '', '42645390', '2018-03-05 05:27:09', '2018-06-28 22:19:37'),
(20, 4, 2, 12, 4, 'add_comment', 1, 1, '', '98610408', '2018-03-05 05:27:10', '2018-07-12 22:32:23'),
(21, 6, 2, 13, 0, 'add_board', 1, 1, '', '89014215', '2018-03-05 05:28:32', '2018-06-28 22:19:37'),
(22, 4, 2, 13, 0, 'add_board', 1, 1, '', '47556171', '2018-03-05 05:28:32', '2018-07-12 22:32:23'),
(23, 6, 2, 13, 7, 'add_task', 1, 1, '', '93853856', '2018-03-05 05:28:50', '2018-06-28 22:19:37'),
(24, 4, 2, 13, 7, 'add_task', 1, 1, '', '90862097', '2018-03-05 05:28:50', '2018-07-12 22:32:23'),
(25, 5, 0, 0, 0, 'membor_invite', 1, 1, 'http://realproagent.com/joinproject/3/infophatleads@gmail.com/ez_project-1517475077', '1520228231', '2018-03-05 05:37:11', '2018-05-12 21:58:06'),
(26, 5, 0, 13, 7, 'memeber_mention', 1, 1, '', '15202286496993583', '2018-03-05 05:44:09', '2018-05-12 21:58:06'),
(27, 6, 2, 13, 7, 'add_comment', 1, 1, '', '48070566', '2018-03-05 05:44:09', '2018-06-28 22:19:37'),
(28, 5, 2, 13, 7, 'add_comment', 1, 1, '', '15768930', '2018-03-05 05:44:09', '2018-05-12 21:58:06'),
(29, 4, 2, 13, 7, 'add_comment', 1, 1, '', '46253569', '2018-03-05 05:44:09', '2018-07-12 22:32:23'),
(30, 6, 2, 13, 7, 'add_comment', 1, 1, '', '99313816', '2018-03-05 05:45:18', '2018-06-28 22:19:37'),
(31, 5, 2, 13, 7, 'add_comment', 1, 1, '', '49848863', '2018-03-05 05:45:18', '2018-05-12 21:58:06'),
(32, 4, 2, 13, 7, 'add_comment', 1, 1, '', '55477332', '2018-03-05 05:45:18', '2018-07-12 22:32:23'),
(33, 6, 2, 13, 7, 'add_comment', 1, 1, '', '33216647', '2018-03-05 05:45:48', '2018-06-28 22:19:37'),
(34, 5, 2, 13, 7, 'add_comment', 1, 1, '', '73763941', '2018-03-05 05:45:48', '2018-05-12 21:58:06'),
(35, 4, 2, 13, 7, 'add_comment', 1, 1, '', '99955329', '2018-03-05 05:45:49', '2018-07-12 22:32:23'),
(36, 4, 2, 0, 0, 'delete_board', 1, 1, '', '99866681', '2018-03-05 05:50:34', '2018-07-12 22:32:23'),
(37, 4, 2, 0, 0, 'delete_board', 1, 1, '', '79769150', '2018-03-05 05:50:34', '2018-07-12 22:32:23'),
(38, 4, 2, 0, 0, 'delete_board', 1, 1, '', '61171026', '2018-03-05 05:50:34', '2018-07-12 22:32:23'),
(39, 6, 2, 11, 7, 'add_task', 1, 1, '', '22663546', '2018-04-19 05:49:47', '2018-06-28 22:19:37'),
(40, 5, 2, 11, 7, 'add_task', 1, 1, '', '36569494', '2018-04-19 05:49:47', '2018-05-12 21:58:06'),
(41, 4, 2, 11, 7, 'add_task', 1, 1, '', '78929133', '2018-04-19 05:49:47', '2018-07-12 22:32:23'),
(42, 8, 3, 13, 9, 'add_task', 1, 0, '', '14289817', '2018-05-02 12:16:17', '2018-05-02 12:16:17'),
(43, 6, 2, 12, 10, 'add_task', 1, 1, '', '51976288', '2018-05-03 04:32:39', '2018-06-28 22:19:37'),
(44, 5, 2, 12, 10, 'add_task', 1, 1, '', '17065981', '2018-05-03 04:32:39', '2018-05-12 21:58:06'),
(45, 4, 2, 12, 10, 'add_task', 1, 1, '', '90483715', '2018-05-03 04:32:39', '2018-07-12 22:32:23'),
(46, 5, 0, 0, 0, 'membor_invite', 1, 1, 'http://realproagent.com/joinproject/4/infophatleads@gmail.com/buyer_test_transaction/buyer_transaction_list', '1526161807', '2018-05-12 21:50:07', '2018-05-12 21:58:06'),
(47, 5, 0, 15, 30, 'memeber_mention', 1, 1, '', '15261620804819156', '2018-05-12 21:54:40', '2018-05-12 21:58:06'),
(48, 5, 5, 15, 30, 'add_comment', 1, 1, '', '40308006', '2018-05-12 21:54:40', '2018-05-12 21:58:06'),
(49, 4, 5, 15, 30, 'add_comment', 1, 1, '', '18129660', '2018-05-12 21:54:40', '2018-07-12 22:32:23'),
(50, 5, 5, 15, 30, 'add_comment', 1, 1, '', '36869667', '2018-05-12 21:55:05', '2018-05-12 21:58:06'),
(51, 4, 5, 15, 30, 'add_comment', 1, 1, '', '60042921', '2018-05-12 21:55:05', '2018-07-12 22:32:23'),
(52, 4, 6, 26, 78, 'add_task', 1, 1, '', '64033276', '2018-05-17 01:26:15', '2018-07-12 22:32:23'),
(53, 4, 6, 26, 79, 'add_task', 1, 1, '', '40767110', '2018-05-17 01:26:59', '2018-07-12 22:32:23'),
(54, 5, 0, 0, 0, 'membor_invite', 1, 0, 'http://realproagent.com/joinproject/5/infophatleads@gmail.com/123_main_st/buyer_transaction_list-1526520553', '1526520597', '2018-05-17 01:29:57', '0000-00-00 00:00:00'),
(55, 5, 7, 27, 80, 'add_comment', 1, 0, '', '48706521', '2018-05-17 01:44:26', '2018-05-17 01:44:26'),
(56, 4, 7, 27, 80, 'add_comment', 1, 1, '', '98544581', '2018-05-17 01:44:26', '2018-07-12 22:32:23'),
(57, 5, 7, 29, 0, 'add_board', 1, 0, '', '40180378', '2018-05-17 02:04:08', '2018-05-17 02:04:08'),
(58, 4, 7, 29, 0, 'add_board', 1, 1, '', '78233150', '2018-05-17 02:04:08', '2018-07-12 22:32:23'),
(59, 5, 7, 29, 119, 'add_task', 1, 0, '', '32538089', '2018-05-17 02:05:06', '2018-05-17 02:05:06'),
(60, 4, 7, 29, 119, 'add_task', 1, 1, '', '44669263', '2018-05-17 02:05:06', '2018-07-12 22:32:23'),
(61, 5, 7, 29, 120, 'add_task', 1, 0, '', '95722624', '2018-05-17 02:08:39', '2018-05-17 02:08:39'),
(62, 4, 7, 29, 120, 'add_task', 1, 1, '', '85401989', '2018-05-17 02:08:39', '2018-07-12 22:32:23'),
(63, 5, 7, 29, 121, 'add_task', 1, 0, '', '79392568', '2018-05-17 02:09:27', '2018-05-17 02:09:27'),
(64, 4, 7, 29, 121, 'add_task', 1, 1, '', '41157965', '2018-05-17 02:09:27', '2018-07-12 22:32:23'),
(65, 5, 7, 30, 0, 'add_board', 1, 0, '', '91883875', '2018-05-17 02:11:55', '2018-05-17 02:11:55'),
(66, 4, 7, 30, 0, 'add_board', 1, 1, '', '89925188', '2018-05-17 02:11:55', '2018-07-12 22:32:23'),
(67, 10, 8, 37, 0, 'add_board', 1, 1, '', '51432774', '2018-05-18 03:59:39', '2018-07-02 05:04:58'),
(68, 10, 8, 37, 169, 'add_task', 1, 1, '', '73737833', '2018-05-18 04:00:04', '2018-07-02 05:04:58'),
(69, 10, 8, 37, 170, 'add_task', 1, 1, '', '91644220', '2018-05-18 04:01:46', '2018-07-02 05:04:58'),
(70, 10, 8, 37, 171, 'add_task', 1, 1, '', '99528942', '2018-05-18 04:01:58', '2018-07-02 05:04:58'),
(71, 10, 8, 37, 172, 'add_task', 1, 1, '', '91295339', '2018-05-18 04:02:28', '2018-07-02 05:04:58'),
(72, 10, 8, 37, 173, 'add_task', 1, 1, '', '14034482', '2018-05-18 04:02:42', '2018-07-02 05:04:58'),
(73, 10, 8, 38, 0, 'add_board', 1, 1, '', '24851173', '2018-05-18 04:33:13', '2018-07-02 05:04:58'),
(74, 10, 8, 38, 174, 'add_task', 1, 1, '', '89460046', '2018-05-18 04:38:12', '2018-07-02 05:04:58'),
(75, 4, 4, 39, 0, 'add_board', 1, 1, '', '67284810', '2018-05-30 17:08:33', '2018-07-12 22:32:23'),
(76, 8, 3, 13, 175, 'add_task', 1, 0, '', '59782379', '2018-05-31 11:30:46', '2018-05-31 11:30:46'),
(77, 6, 0, 0, 0, 'membor_invite', 1, 1, 'http://realproagent.com/joinproject/6/infoezleadpages@gmail.com/buyer_test_transaction/escrow_transaction_list', '1527786413', '2018-05-31 17:06:53', '2018-06-28 22:19:37'),
(78, 6, 0, 0, 0, 'membor_invite', 1, 1, 'http://realproagent.com/joinproject/7/infoezleadpages@gmail.com/brand_new_transaction/contract_inspections-1528255136', '1528255147', '2018-06-05 20:19:07', '2018-06-28 22:19:37'),
(79, 6, 9, 45, 177, 'add_task', 1, 1, '', '90087657', '2018-06-05 20:20:09', '2018-06-28 22:19:37'),
(80, 4, 9, 45, 177, 'add_task', 1, 1, '', '64600194', '2018-06-05 20:20:09', '2018-07-12 22:32:23'),
(81, 6, 9, 45, 225, 'add_task', 1, 1, '', '46688356', '2018-06-12 23:38:08', '2018-06-28 22:19:37'),
(82, 4, 9, 45, 225, 'add_task', 1, 1, '', '93293842', '2018-06-12 23:38:09', '2018-07-12 22:32:23'),
(83, 6, 9, 45, 226, 'add_task', 1, 1, '', '72616868', '2018-06-13 12:08:59', '2018-06-28 22:19:37'),
(84, 4, 9, 45, 226, 'add_task', 1, 1, '', '60972926', '2018-06-13 12:08:59', '2018-07-12 22:32:23'),
(85, 6, 9, 45, 0, 'delete_task', 1, 1, '', '14706526', '2018-06-13 12:24:00', '2018-06-28 22:19:37'),
(86, 4, 9, 45, 0, 'delete_task', 1, 1, '', '36902891', '2018-06-13 12:24:00', '2018-07-12 22:32:23'),
(87, 6, 9, 45, 227, 'add_task', 1, 1, '', '98472573', '2018-06-13 12:24:16', '2018-06-28 22:19:37'),
(88, 4, 9, 45, 227, 'add_task', 1, 1, '', '19913084', '2018-06-13 12:24:16', '2018-07-12 22:32:23'),
(89, 4, 9, 0, 0, 'delete_board', 1, 1, '', '16281564', '2018-06-13 12:26:36', '2018-07-12 22:32:23'),
(90, 4, 9, 0, 0, 'delete_board', 1, 1, '', '89392149', '2018-06-13 12:26:37', '2018-07-12 22:32:23'),
(91, 4, 0, 0, 0, 'membor_invite', 1, 1, 'http://realproagent.com/joinproject/8/juangmolina76@gmail.com/123_testing_suite_2/client_touch', '1529869111', '2018-06-24 12:38:31', '2018-07-12 22:32:23'),
(92, 10, 0, 63, 230, 'memeber_mention', 1, 1, '', '15298716928152259', '2018-06-24 13:21:32', '2018-07-02 05:04:58'),
(93, 4, 12, 63, 230, 'add_comment', 1, 1, '', '72606322', '2018-06-24 13:21:32', '2018-07-12 22:32:23'),
(94, 10, 12, 63, 230, 'add_comment', 1, 1, '', '30932233', '2018-06-24 13:21:32', '2018-07-02 05:04:58'),
(95, 6, 9, 41, 235, 'add_task', 1, 1, '', '50378076', '2018-06-25 21:40:22', '2018-06-28 22:19:37'),
(96, 4, 9, 41, 235, 'add_task', 1, 1, '', '92154013', '2018-06-25 21:40:22', '2018-07-12 22:32:23'),
(97, 4, 14, 74, 237, 'add_task', 1, 1, '', '22572502', '2018-06-26 23:36:10', '2018-07-12 22:32:23'),
(98, 5, 0, 0, 0, 'membor_invite', 1, 0, 'http://realproagent.com/joinproject/9/infophatleads@gmail.com/111_harvey_dr/inspector_collaboration_board-1530080885', '1530081597', '2018-06-26 23:39:57', '0000-00-00 00:00:00'),
(99, 5, 5, 20, 238, 'add_task', 1, 0, '', '14665140', '2018-06-27 21:40:22', '2018-06-27 21:40:22'),
(100, 6, 5, 20, 238, 'add_task', 1, 1, '', '66563379', '2018-06-27 21:40:22', '2018-06-28 22:19:37'),
(101, 4, 5, 20, 238, 'add_task', 1, 1, '', '90340040', '2018-06-27 21:40:22', '2018-07-12 22:32:23'),
(102, 5, 5, 20, 239, 'add_task', 1, 0, '', '25806434', '2018-06-27 21:40:28', '2018-06-27 21:40:28'),
(103, 6, 5, 20, 239, 'add_task', 1, 1, '', '29508451', '2018-06-27 21:40:28', '2018-06-28 22:19:37'),
(104, 4, 5, 20, 239, 'add_task', 1, 1, '', '80972376', '2018-06-27 21:40:28', '2018-07-12 22:32:23'),
(105, 6, 9, 44, 240, 'add_task', 1, 1, '', '64178324', '2018-06-28 21:15:00', '2018-06-28 22:19:37'),
(106, 4, 9, 44, 240, 'add_task', 1, 1, '', '99699395', '2018-06-28 21:15:00', '2018-07-12 22:32:23'),
(107, 6, 0, 44, 240, 'memeber_mention', 1, 1, '', '15302457168481557', '2018-06-28 21:15:16', '2018-06-28 22:19:37'),
(108, 6, 9, 44, 240, 'add_comment', 1, 1, '', '69216856', '2018-06-28 21:15:16', '2018-06-28 22:19:37'),
(109, 4, 9, 44, 240, 'add_comment', 1, 1, '', '26315684', '2018-06-28 21:15:16', '2018-07-12 22:32:23'),
(110, 6, 0, 44, 240, 'memeber_mention', 1, 1, '', '15302460121458355', '2018-06-28 21:20:12', '2018-06-28 22:19:37'),
(111, 6, 9, 44, 240, 'add_comment', 1, 1, '', '39810506', '2018-06-28 21:20:12', '2018-06-28 22:19:37'),
(112, 4, 9, 44, 240, 'add_comment', 1, 1, '', '20063640', '2018-06-28 21:20:12', '2018-07-12 22:32:23'),
(113, 6, 9, 44, 241, 'add_task', 1, 1, '', '56201448', '2018-06-28 21:21:46', '2018-06-28 22:19:37'),
(114, 4, 9, 44, 241, 'add_task', 1, 1, '', '86266203', '2018-06-28 21:21:46', '2018-07-12 22:32:23'),
(115, 4, 9, 42, 242, 'add_task', 1, 1, '', '20536946', '2018-06-29 21:22:08', '2018-07-12 22:32:23'),
(116, 10, 8, 38, 243, 'add_task', 1, 0, '', '27146440', '2018-07-06 12:46:59', '2018-07-06 12:46:59'),
(117, 4, 12, 63, 291, 'add_task', 1, 1, '', '27383168', '2018-07-11 19:37:10', '2018-07-12 22:32:23'),
(118, 10, 12, 63, 291, 'add_task', 1, 0, '', '28889168', '2018-07-11 19:37:11', '2018-07-11 19:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

CREATE TABLE `tbl_pages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(254) CHARACTER SET latin1 DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text CHARACTER SET latin1,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`id`, `name`, `category`, `slug`, `description`, `status`, `created`, `modified`) VALUES
(1, 'About us', NULL, 'about_us', 'Coming soon...<br>', 1, '2016-08-06 06:09:28', '0000-00-00 00:00:00'),
(2, 'Help', NULL, 'help', '<div style=\"text-align: justify;\"><span style=\"line-height: 1.42857;\">Coming soon........</span></div>', 1, '2016-08-24 06:13:36', '0000-00-00 00:00:00'),
(3, 'Privacy Policy', NULL, 'privacy_policy', 'Coming soon.........', 1, '2016-08-24 07:09:52', '0000-00-00 00:00:00'),
(4, 'Terms & Conditions', NULL, 'terms_conditions', 'Coming soon.....................', 1, '2016-08-25 04:34:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_projectinvites`
--

CREATE TABLE `tbl_projectinvites` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_projectinvites`
--

INSERT INTO `tbl_projectinvites` (`id`, `project_id`, `board_id`, `user_id`, `status`, `created`, `modified`) VALUES
(1, 2, 0, 6, 1, '2018-02-01 08:57:50', '2018-02-01 08:57:50'),
(2, 2, 0, 5, 1, '2018-03-05 05:37:49', '2018-03-05 05:37:49'),
(3, 5, 15, 5, 1, '2018-05-12 21:52:47', '2018-05-12 21:52:47'),
(4, 7, 28, 5, 1, '2018-05-17 01:43:55', '2018-05-17 01:43:55'),
(5, 5, 20, 6, 1, '2018-05-31 17:12:20', '2018-05-31 17:12:20'),
(6, 9, 45, 6, 1, '2018-06-05 20:19:44', '2018-06-05 20:19:44'),
(7, 12, 63, 4, 1, '2018-06-24 13:21:00', '2018-06-24 13:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_projects`
--

CREATE TABLE `tbl_projects` (
  `id` bigint(20) NOT NULL,
  `admin_project_id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_starred` tinyint(2) NOT NULL,
  `transaction` tinyint(2) NOT NULL,
  `transaction_amount` varchar(255) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_projects`
--

INSERT INTO `tbl_projects` (`id`, `admin_project_id`, `user_id`, `project_name`, `status`, `slug`, `is_starred`, `transaction`, `transaction_amount`, `transaction_type`, `start_date`, `end_date`, `created`, `modified`) VALUES
(1, 1, 2, 'EZ project', '1', 'ez_project', 0, 0, '500000', 2, '0000-00-00', '0000-00-00', '2018-01-31 05:41:56', '2018-01-31 06:57:28'),
(2, 1, 4, 'EZ Project', '1', 'ez_project-1517475077', 0, 0, '500000', 2, '0000-00-00', '0000-00-00', '2018-02-01 08:51:17', '2018-03-05 05:50:56'),
(3, 1, 8, 'test', '1', 'ff', 0, 1, '45', 2, '2018-05-09', '2018-05-31', '2018-05-02 12:14:54', '2018-05-02 12:15:15'),
(4, 1, 4, '123 Happy Dr. Oxnard, CA 93036', '1', '123_happy_dr_oxnard_ca_93036', 0, 0, '500000', 2, '2018-05-07', '2018-06-07', '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(5, 1, 4, 'Buyer Test Transaction', '1', 'buyer_test_transaction', 0, 0, '600000', 2, '2018-05-07', '2018-06-07', '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(6, 1, 4, '8254 Plum Court', '1', '8254_plum_court', 0, 1, '500000', 1, '2018-05-18', '2018-07-31', '2018-05-17 01:22:50', '2018-05-17 01:23:13'),
(7, 1, 4, '123 Main St', '1', '123_main_st', 0, 1, '5000000', 1, '2018-05-18', '2018-07-31', '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(8, 1, 10, '789 today st', '1', '789_today_st', 0, 0, '1000000', 2, '2018-05-17', '2018-06-14', '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(9, 1, 4, 'Brand new transaction', '1', 'brand_new_transaction', 0, 0, '350000', 4, '2018-06-05', '2018-07-05', '2018-06-05 20:18:56', '2018-06-13 12:16:19'),
(10, 1, 10, 'Rixlew 2018', '1', 'rixlew_2018', 0, 0, '2000000', 2, '2018-06-12', '2018-06-30', '2018-06-12 15:27:11', '2018-06-12 15:29:03'),
(11, 3, 4, '555 Wonder Dr. Oxnard, CA 93030', '1', '555_wonder_dr_oxnard_ca_93030', 0, 0, '500000', 2, '2018-06-22', '2018-07-26', '2018-06-22 14:56:37', '2018-06-22 14:56:37'),
(12, 2, 10, '123 testing suite 2', '1', '123_testing_suite_2', 0, 0, '700000', 2, '2018-06-24', '2018-07-27', '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(13, 2, 10, '345b sarah test', '1', '345b_sarah_test', 0, 0, '500000', 2, '2018-06-24', '2018-07-20', '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(14, 3, 4, '111 Harvey Dr.', '1', '111_harvey_dr', 0, 0, '500000', 2, '2018-06-19', '2018-06-30', '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(15, 1, 4, '1301 Roosevelt Dr. Oxnard, CA 93036', '1', '1301_roosevelt_dr_oxnard_ca_93036', 0, 0, '550000', 2, '2018-07-10', '2018-08-10', '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(16, 3, 13, 'test', '1', 'test', 0, 0, '23', 4, '2018-07-11', '2018-07-24', '2018-07-17 18:36:09', '2018-07-17 18:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reminders`
--

CREATE TABLE `tbl_reminders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `time_gap` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `email_content` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_reminders`
--

INSERT INTO `tbl_reminders` (`id`, `user_id`, `task_id`, `type`, `title`, `time_gap`, `datetime`, `email_subject`, `email_content`, `status`, `created`, `modified`, `slug`) VALUES
(1, 4, 11, '1', 'Test 1', '', '2018-05-30 13:00:00', 'testing email autoresponders', '', 1, '2018-05-30 16:44:02', '0000-00-00 00:00:00', ''),
(2, 4, 11, '2', 'test 1', '', '2018-05-31 13:00:00', 'testing autoresponder sms', '', 1, '2018-05-30 16:44:22', '0000-00-00 00:00:00', ''),
(4, 8, 8, '1', 'fghfgh', '', '2018-06-01 12:00:00', 'fghfgh', '<p>gfhfhfgh</p>\r\n', 2, '2018-05-31 11:17:56', '2018-06-01 11:00:01', ''),
(8, 4, 73, '1', 'test111', '', '2018-05-31 13:30:00', 'none', '', 1, '2018-05-31 17:24:02', '0000-00-00 00:00:00', ''),
(9, 4, 73, '1', '1', '', '2018-06-01 12:00:00', '1', '', 2, '2018-05-31 17:24:19', '2018-06-01 11:00:01', ''),
(17, 4, 74, '2', 'test 444', '', '2018-06-04 13:00:00', 'testing to see if sms works', '', 1, '2018-06-04 00:42:21', '0000-00-00 00:00:00', ''),
(19, 4, 74, '2', 'test 555', '', '2018-06-04 08:00:00', 'test 555', '', 1, '2018-06-04 00:43:42', '0000-00-00 00:00:00', ''),
(20, 4, 74, '1', 'Test 6', '', '2018-06-12 20:00:00', 'Test 6', '<p>testing email system test 6</p>\n\n<p>&nbsp;</p>\n\n<p>Best regards,</p>\n\n<p>Juan Gabriel</p>\n\n<p>8056028728</p>\n', 2, '2018-06-05 19:40:57', '2018-06-12 20:00:01', ''),
(21, 4, 74, '1', 'Test 7', '', '2018-06-05 20:30:00', 'Test 7', '<p>I&#39;m testing the system</p>\n', 2, '2018-06-05 19:41:31', '2018-06-05 20:30:01', ''),
(22, 4, 74, '2', 'Test 7 sms', '', '2018-06-05 20:00:00', 'hey how are you, looking forward to seeing this test go through', '', 1, '2018-06-05 19:42:02', '0000-00-00 00:00:00', ''),
(27, 10, 161, '2', 'Testing text', '', '2018-06-07 08:30:00', 'giovanni@move4freerealty.com', '', 2, '2018-06-07 05:10:30', '2018-06-07 08:30:02', ''),
(28, 10, 165, '2', 'test', '', '2018-06-08 19:00:00', 'testing real pro text', '', 2, '2018-06-08 15:37:45', '2018-06-08 19:00:01', ''),
(30, 4, 177, '1', 'Testing Autoreponders 6-11-18', '', '2018-06-11 17:00:00', 'Testing Autoreponders 6-11-18', '<p>Testing autoreponders on 6-11-18</p>\n', 2, '2018-06-11 16:34:15', '2018-06-11 17:00:07', ''),
(31, 4, 177, '2', 'Testing SMS autoreponders 6-11-18', '', '2018-06-11 17:00:00', 'Testing autoreponders 6-11-18 SMS', '', 2, '2018-06-11 16:34:47', '2018-06-11 17:00:08', ''),
(32, 10, 162, '2', 'Test', '', '2018-06-12 18:30:00', 'This is a test.... please work!!!', '', 2, '2018-06-12 15:21:09', '2018-06-12 18:30:01', ''),
(33, 10, 196, '2', '12345', '', '2018-06-12 19:00:00', 'Bashing', '', 2, '2018-06-12 15:30:45', '2018-06-12 19:00:01', ''),
(34, 13, 292, '2', 'test', '', '2018-07-17 22:00:00', 'this is a test', '', 2, '2018-07-17 18:44:01', '2018-07-17 22:00:07', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tasks`
--

CREATE TABLE `tbl_tasks` (
  `id` bigint(20) NOT NULL,
  `board_id` bigint(20) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_description` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `task_position` bigint(20) NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `lastupdate` date NOT NULL,
  `is_checked` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tasks`
--

INSERT INTO `tbl_tasks` (`id`, `board_id`, `task_name`, `task_description`, `status`, `slug`, `task_position`, `due_date`, `lastupdate`, `is_checked`, `created`, `modified`) VALUES
(2, 2, 'Fully executed contract', '', '1', 'fully_executed_contract', 1, '2018-01-31 00:00:00', '0000-00-00', 0, '2018-01-31 19:45:04', '2018-01-31 19:49:06'),
(4, 12, 'Inspection date', '', '1', 'inspection_date', 1, '2018-05-24 12:00:00', '0000-00-00', 0, '2018-02-01 08:52:14', '2018-05-07 07:46:13'),
(5, 12, 'Termite report', 'Termite report', '1', 'inspection_report', 2, '2018-03-21 12:00:00', '0000-00-00', 0, '2018-02-01 08:52:23', '2018-03-19 06:35:31'),
(6, 9, 'Loan', '', '1', 'losn', 1, NULL, '0000-00-00', 0, '2018-02-22 06:52:33', '2018-02-22 06:52:41'),
(7, 11, 'e', '', '1', 'e', 1, NULL, '0000-00-00', 0, '2018-04-19 05:49:47', '2018-04-19 05:49:47'),
(8, 13, 'Task 1', '', '1', 'task_1', 1, '2018-06-20 00:00:00', '0000-00-00', 0, '2018-05-02 12:14:54', '2018-06-18 00:13:06'),
(9, 13, 'This is for testing', '', '1', 'this_is_for_testing', 2, NULL, '0000-00-00', 0, '2018-05-02 12:16:17', '2018-05-02 12:16:17'),
(10, 12, 'Task1\r\n', '', '1', 'task1', 3, NULL, '0000-00-00', 0, '2018-05-03 04:32:39', '2018-05-07 07:46:17'),
(11, 14, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure', 1, '2018-05-08 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-30 17:06:59'),
(12, 14, 'Purchase agreement\r\n', '', '1', 'purchase_agreement', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(13, 14, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(14, 14, 'Schedule home inspection\r\n', '', '1', 'schedule_home_inspection', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(15, 14, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(16, 14, 'Order appraisal', '', '1', 'order_appraisal', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(17, 14, 'Receive disclosures', '', '1', 'receive_disclosures', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(18, 14, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(19, 14, 'Enviromental hazards booklet', '', '1', 'enviromental_hazards_booklet', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(20, 14, 'Natural hazards report', '', '1', 'natural_hazards_report', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(21, 14, 'Property tax disclosure', '', '1', 'property_tax_disclosure', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(22, 14, 'Review disclosures', '', '1', 'review_disclosures', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(23, 14, 'Appraisal report', '', '1', 'appraisal_report', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(24, 14, 'Remove contingencies', '', '1', 'remove_contingencies', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(25, 14, 'Obtain homeowner\'s insurance', '', '1', 'obtain_homeowner_s_insurance', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(26, 14, 'Confirm closer of escrow', '', '1', 'confirm_closer_of_escrow', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(27, 14, 'Order home warranty', '', '1', 'order_home_warranty', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(28, 14, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(29, 14, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 14:12:04', '2018-05-07 14:12:04'),
(30, 15, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1525706844', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-12 21:56:11'),
(31, 15, 'Purchase agreement\r\n', '', '1', 'purchase_agreement-1525706844', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(32, 15, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1525706844', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(33, 15, 'Schedule home inspection\r\n', '', '1', 'schedule_home_inspection-1525706844', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(34, 15, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1525706844', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(35, 15, 'Order appraisal', '', '1', 'order_appraisal-1525706844', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(36, 15, 'Receive disclosures', '', '1', 'receive_disclosures-1525706844', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(37, 15, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1525706844', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(38, 15, 'Enviromental hazards booklet', '', '1', 'enviromental_hazards_booklet-1525706844', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(39, 15, 'Natural hazards report', '', '1', 'natural_hazards_report-1525706844', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(40, 15, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1525706844', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(41, 15, 'Review disclosures', '', '1', 'review_disclosures-1525706844', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(42, 15, 'Appraisal report', '', '1', 'appraisal_report-1525706844', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(43, 15, 'Remove contingencies', '', '1', 'remove_contingencies-1525706844', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(44, 15, 'Obtain homeowner\'s insurance', '', '1', 'obtain_homeowner_s_insurance-1525706844', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(45, 15, 'Confirm closer of escrow', '', '1', 'confirm_closer_of_escrow-1525706844', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(46, 15, 'Order home warranty', '', '1', 'order_home_warranty-1525706844', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(47, 15, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1525706844', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(48, 15, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis-1525706844', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(49, 16, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1525706844', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:38:57'),
(50, 16, 'Listing agreement', '', '1', 'listing_agreement', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(51, 16, 'Estimate of sellers costs', '', '1', 'estimate_of_sellers_costs', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(52, 16, 'Install yard sign', '', '1', 'install_yard_sign', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(53, 16, 'Lock box authorization', '', '1', 'lock_box_authorization', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(54, 16, 'Submit listing to MLS', '', '1', 'submit_listing_to_mls', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(55, 16, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1525706844', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(56, 16, 'Environmental  hazards booklet', '', '1', 'environmental_hazards_booklet', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(57, 16, 'Natural hazards report', '', '1', 'natural_hazards_report-1525706844', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(58, 16, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1525706844', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(59, 16, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1525706844', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(60, 16, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1525706844', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(61, 16, 'Order appraisal', '', '1', 'order_appraisal-1525706844', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(62, 16, 'Send disclosures to Buyer', '', '1', 'send_disclosures_to_buyer', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(63, 16, 'Appraisal report', '', '1', 'appraisal_report-1525706844', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(64, 16, 'Confirm removal of contingencies', '', '1', 'confirm_removal_of_contingencies', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(65, 16, 'Order home warranty', '', '1', 'order_home_warranty-1525706844', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(66, 16, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1525706844', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(67, 16, 'Confirm that Broker verified commissions ', '', '1', 'confirm_that_broker_verified_commis-1525706844', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(68, 16, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow', 20, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(69, 17, 'Send Fully executed purchase agreement and any counter offers', '', '1', 'send_fully_executed_purchase_agreem', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(70, 18, 'Order Home Inspection', '', '1', 'order_home_inspection', 1, '0000-00-00 00:00:00', '0000-00-00', 1, '2018-05-07 15:27:24', '2018-06-27 21:43:32'),
(71, 18, 'Review home inspection report', '', '1', 'review_home_inspection_report', 2, '0000-00-00 00:00:00', '0000-00-00', 1, '2018-05-07 15:27:24', '2018-06-27 21:43:32'),
(72, 18, 'Request for repairs', '', '1', 'request_for_repairs', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(73, 19, 'Order prelim', '', '1', 'order_prelim', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-07 15:27:24', '2018-05-07 15:27:24'),
(74, 20, 'Send Fully executed purchase agreement', '', '1', 'send_fully_executed_purchase_agreem-1525706844', 1, '2018-06-02 00:00:00', '0000-00-00', 1, '2018-05-07 15:27:24', '2018-06-19 17:31:14'),
(75, 20, 'Send emd', '', '1', 'send_emd', 2, '0000-00-00 00:00:00', '0000-00-00', 1, '2018-05-07 15:27:24', '2018-06-27 21:50:55'),
(76, 20, 'Escrow deposit receipt ', '', '1', 'escrow_deposit_receipt-1525706844', 3, '0000-00-00 00:00:00', '0000-00-00', 1, '2018-05-07 15:27:24', '2018-06-27 21:50:56'),
(77, 21, '30 Day Follow Up with Client', 'Communication for a 30 day closing', '1', '30_day_follow_up_with_client', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:22:50', '2018-05-17 01:22:50'),
(78, 26, 'Initial Email', '', '1', 'initial_email', 1, NULL, '0000-00-00', 0, '2018-05-17 01:26:15', '2018-05-17 01:26:36'),
(79, 26, 'Text task', '', '1', 'text_task', 2, NULL, '0000-00-00', 0, '2018-05-17 01:26:59', '2018-05-17 01:26:59'),
(80, 27, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1526520553', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(81, 27, 'Listing agreement', '', '1', 'listing_agreement-1526520553', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(82, 27, 'Estimate of sellers costs', '', '1', 'estimate_of_sellers_costs-1526520553', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(83, 27, 'Install yard sign', '', '1', 'install_yard_sign-1526520553', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(84, 27, 'Lock box authorization', '', '1', 'lock_box_authorization-1526520553', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(85, 27, 'Submit listing to MLS', '', '1', 'submit_listing_to_mls-1526520553', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(86, 27, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1526520553', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(87, 27, 'Environmental hazards report', '', '1', 'environmental_hazards_report', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(88, 27, 'Natural hazards report', '', '1', 'natural_hazards_report-1526520553', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(89, 27, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1526520553', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(90, 27, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1526520553', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(91, 27, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1526520553', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(92, 27, 'Order appraisal', '', '1', 'order_appraisal-1526520553', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(93, 27, 'Send disclosures to buyer', '', '1', 'send_disclosures_to_buyer-1526520553', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(94, 27, 'Appraisal report', '', '1', 'appraisal_report-1526520553', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(95, 27, 'Confirm removal of contingencies', '', '1', 'confirm_removal_of_contingencies-1526520553', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(96, 27, 'Order home warranty', '', '1', 'order_home_warranty-1526520553', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(97, 27, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1526520553', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(98, 27, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis-1526520553', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(99, 27, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow-1526520553', 20, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(100, 28, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1526520553', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(101, 28, 'Purchase agreement', '', '1', 'purchase_agreement-1526520553', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(102, 28, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1526520553', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(103, 28, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1526520553', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(104, 28, 'Schedule home inspection', '', '1', 'schedule_home_inspection-1526520553', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(105, 28, 'Order appraisal', '', '1', 'order_appraisal-1526520553', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(106, 28, 'Receive disclosures', '', '1', 'receive_disclosures-1526520553', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(107, 28, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1526520553', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(108, 28, 'Environmental hazards booklet', '', '1', 'environmental_hazards_booklet-1526520553', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(109, 28, 'Natural Hazards report', '', '1', 'natural_hazards_report-1526520553', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(110, 28, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1526520553', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(111, 28, 'Review disclosures', '', '1', 'review_disclosures-1526520553', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(112, 28, 'Appraisal report', '', '1', 'appraisal_report-1526520553', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(113, 28, 'Remove contingencies', '', '1', 'remove_contingencies-1526520553', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(114, 28, 'Obtain homeowner\'s insurance', '', '1', 'obtain_homeowner_s_insurance-1526520553', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(115, 28, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow-1526520553', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(116, 28, 'Oder home warranty', '', '1', 'oder_home_warranty', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(117, 28, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1526520553', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(118, 28, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis-1526520553', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 01:29:13', '2018-05-17 01:29:13'),
(119, 29, 'Intro Email to Inspector', '', '1', 'intro_email_to_inspector', 1, NULL, '0000-00-00', 0, '2018-05-17 02:05:06', '2018-05-17 02:05:16'),
(120, 29, 'Intro Text to Inspector', '', '1', 'intro_text_to_inspector', 2, NULL, '0000-00-00', 0, '2018-05-17 02:08:39', '2018-05-17 02:08:39'),
(121, 29, 'Text Other Agent', '', '1', 'text_other_agent', 3, NULL, '0000-00-00', 0, '2018-05-17 02:09:27', '2018-05-17 02:09:27'),
(122, 31, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1526596526', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(123, 31, 'Purchase agreement\r\n', '', '1', 'purchase_agreement-1526596526', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(124, 31, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1526596526', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(125, 31, 'Schedule home inspection\r\n', '', '1', 'schedule_home_inspection-1526596526', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(126, 31, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1526596526', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(127, 31, 'Order appraisal', '', '1', 'order_appraisal-1526596526', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(128, 31, 'Receive disclosures', '', '1', 'receive_disclosures-1526596526', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(129, 31, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1526596526', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(130, 31, 'Enviromental hazards booklet', '', '1', 'enviromental_hazards_booklet-1526596526', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(131, 31, 'Natural hazards report', '', '1', 'natural_hazards_report-1526596526', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(132, 31, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1526596526', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(133, 31, 'Review disclosures', '', '1', 'review_disclosures-1526596526', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(134, 31, 'Appraisal report', '', '1', 'appraisal_report-1526596526', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(135, 31, 'Remove contingencies', '', '1', 'remove_contingencies-1526596526', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(136, 31, 'Obtain homeowner\'s insurance', '', '1', 'obtain_homeowner_s_insurance-1526596526', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(137, 31, 'Confirm closer of escrow', '', '1', 'confirm_closer_of_escrow-1526596526', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(138, 31, 'Order home warranty', '', '1', 'order_home_warranty-1526596526', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(139, 31, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1526596526', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(140, 31, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis-1526596526', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(141, 32, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1526596526', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(142, 32, 'Listing agreement', '', '1', 'listing_agreement-1526596526', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(143, 32, 'Estimate of sellers costs', '', '1', 'estimate_of_sellers_costs-1526596526', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(144, 32, 'Install yard sign', '', '1', 'install_yard_sign-1526596526', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(145, 32, 'Lock box authorization', '', '1', 'lock_box_authorization-1526596526', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(146, 32, 'Submit listing to MLS', '', '1', 'submit_listing_to_mls-1526596526', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(147, 32, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1526596526', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(148, 32, 'Environmental  hazards booklet', '', '1', 'environmental_hazards_booklet-1526596526', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(149, 32, 'Natural hazards report', '', '1', 'natural_hazards_report-1526596526', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(150, 32, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1526596526', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(151, 32, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1526596526', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(152, 32, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1526596526', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(153, 32, 'Order appraisal', '', '1', 'order_appraisal-1526596526', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(154, 32, 'Send disclosures to Buyer', '', '1', 'send_disclosures_to_buyer-1526596526', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(155, 32, 'Appraisal report', '', '1', 'appraisal_report-1526596526', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(156, 32, 'Confirm removal of contingencies', '', '1', 'confirm_removal_of_contingencies-1526596526', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(157, 32, 'Order home warranty', '', '1', 'order_home_warranty-1526596526', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(158, 32, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1526596526', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(159, 32, 'Confirm that Broker verified commissions ', '', '1', 'confirm_that_broker_verified_commis-1526596526', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(160, 32, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow-1526596526', 20, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(161, 33, 'Send Fully executed purchase agreement and any counter offers', '', '1', 'send_fully_executed_purchase_agreem-1526596526', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(162, 34, 'Order Home Inspection', '', '1', 'order_home_inspection-1526596526', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(163, 34, 'Review home inspection report', '', '1', 'review_home_inspection_report-1526596526', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(164, 34, 'Request for repairs', '', '1', 'request_for_repairs-1526596526', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(165, 35, 'Order prelim', '', '1', 'order_prelim-1526596526', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(166, 36, 'Send Fully executed purchase agreement', '', '1', 'send_fully_executed_purchase_agreem-1526596526', 1, '0000-00-00 00:00:00', '0000-00-00', 1, '2018-05-17 22:35:26', '2018-06-07 05:07:46'),
(167, 36, 'Send emd', '', '1', 'send_emd-1526596526', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(168, 36, 'Escrow deposit receipt ', '', '1', 'escrow_deposit_receipt-1526596526', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-05-17 22:35:26', '2018-05-17 22:35:26'),
(169, 37, '\"Congratulations \"Buyer\'s Name\" on your new home. Now that you found your dream home we will proceed with the transaction. We will go through the steps necessary to get closer to settlement. Please don\'t hesitate to ask any questions throughout, I am here', '', '1', 'day_0', 1, NULL, '0000-00-00', 0, '2018-05-18 04:00:04', '2018-05-18 04:03:46'),
(170, 37, 'Subject: \"Address\" Under Contract/Escrow\r\nHello Team,\r\nSee attached a copy of the ratified contract along a breakdown of the offer. Please confirm receipt. Let me know if you have any questions :-)\r\n\"Agent Signature\"', '', '1', 'subject_address_under_contract_e', 2, NULL, '0000-00-00', 0, '2018-05-18 04:01:46', '2018-05-18 04:01:46'),
(171, 37, 'Subject: New Inspection: \"Address\" \r\nHello \"Contractor\",\r\nI need an inspection for the property at \"address\". Call me when you get a chance to schedule and please respond to your availability this week. Thank you and have a great day!\r\n\"Agent Signature\"', '', '1', 'subject_new_inspection_address', 3, NULL, '0000-00-00', 0, '2018-05-18 04:01:58', '2018-05-18 04:01:58'),
(172, 37, 'Hello \"Contractor\", it\'s \"Agent\" with \"Brokerage/Team Name\". Need to schedule an inspection @ “address”..let me know when you’re available. Sent you an email as well. Thanks\r\n', '', '1', 'hello_contractor_it_s_agent_wi', 4, NULL, '0000-00-00', 0, '2018-05-18 04:02:28', '2018-05-18 04:02:28'),
(173, 37, 'REMOVE home search from website!', '', '1', 'remove_home_search_from_website', 5, NULL, '0000-00-00', 0, '2018-05-18 04:02:42', '2018-05-18 04:02:42'),
(174, 38, 'Start Date', '', '1', 'start_date', 1, NULL, '0000-00-00', 0, '2018-05-18 04:38:12', '2018-05-18 04:38:12'),
(175, 13, 'dfsfsd', '', '1', 'dfsfsd', 3, NULL, '0000-00-00', 0, '2018-05-31 11:30:46', '2018-05-31 11:30:46'),
(177, 45, 'Task to test autoresponders', '', '1', 'task_to_test_autoresponders', 1, '2018-06-16 12:00:00', '0000-00-00', 1, '2018-06-05 20:20:09', '2018-06-28 22:19:21'),
(178, 46, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1528842431', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:30:01'),
(179, 46, 'Purchase agreement\r\n', '', '1', 'purchase_agreement-1528842431', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(180, 46, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1528842431', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(181, 46, 'Schedule home inspection\r\n', '', '1', 'schedule_home_inspection-1528842431', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(182, 46, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1528842431', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(183, 46, 'Order appraisal', '', '1', 'order_appraisal-1528842431', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(184, 46, 'Receive disclosures', '', '1', 'receive_disclosures-1528842431', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(185, 46, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1528842431', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(186, 46, 'Enviromental hazards booklet', '', '1', 'enviromental_hazards_booklet-1528842431', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(187, 46, 'Natural hazards report', '', '1', 'natural_hazards_report-1528842431', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(188, 46, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1528842431', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(189, 46, 'Review disclosures', '', '1', 'review_disclosures-1528842431', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(190, 46, 'Appraisal report', '', '1', 'appraisal_report-1528842431', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(191, 46, 'Remove contingencies', '', '1', 'remove_contingencies-1528842431', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(192, 46, 'Obtain homeowner\'s insurance', '', '1', 'obtain_homeowner_s_insurance-1528842431', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(193, 46, 'Confirm closer of escrow', '', '1', 'confirm_closer_of_escrow-1528842431', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(194, 46, 'Order home warranty', '', '1', 'order_home_warranty-1528842431', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(195, 46, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1528842431', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(196, 46, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis-1528842431', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(197, 47, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1528842431', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(198, 47, 'Listing agreement', '', '1', 'listing_agreement-1528842431', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(199, 47, 'Estimate of sellers costs', '', '1', 'estimate_of_sellers_costs-1528842431', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(200, 47, 'Install yard sign', '', '1', 'install_yard_sign-1528842431', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(201, 47, 'Lock box authorization', '', '1', 'lock_box_authorization-1528842431', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(202, 47, 'Submit listing to MLS', '', '1', 'submit_listing_to_mls-1528842431', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(203, 47, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1528842431', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(204, 47, 'Environmental  hazards booklet', '', '1', 'environmental_hazards_booklet-1528842431', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(205, 47, 'Natural hazards report', '', '1', 'natural_hazards_report-1528842431', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(206, 47, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1528842431', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(207, 47, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1528842431', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(208, 47, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1528842431', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(209, 47, 'Order appraisal', '', '1', 'order_appraisal-1528842431', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(210, 47, 'Send disclosures to Buyer', '', '1', 'send_disclosures_to_buyer-1528842431', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(211, 47, 'Appraisal report', '', '1', 'appraisal_report-1528842431', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(212, 47, 'Confirm removal of contingencies', '', '1', 'confirm_removal_of_contingencies-1528842431', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(213, 47, 'Order home warranty', '', '1', 'order_home_warranty-1528842431', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(214, 47, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1528842431', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(215, 47, 'Confirm that Broker verified commissions ', '', '1', 'confirm_that_broker_verified_commis-1528842431', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(216, 47, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow-1528842431', 20, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(217, 48, 'Send Fully executed purchase agreement and any counter offers', '', '1', 'send_fully_executed_purchase_agreem-1528842431', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(218, 49, 'Order Home Inspection', '', '1', 'order_home_inspection-1528842431', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(219, 49, 'Review home inspection report', '', '1', 'review_home_inspection_report-1528842431', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(220, 49, 'Request for repairs', '', '1', 'request_for_repairs-1528842431', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(221, 50, 'Order prelim', '', '1', 'order_prelim-1528842431', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(222, 51, 'Send Fully executed purchase agreement', '', '1', 'send_fully_executed_purchase_agreem-1528842431', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(223, 51, 'Send emd', '', '1', 'send_emd-1528842431', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(224, 51, 'Escrow deposit receipt ', '', '1', 'escrow_deposit_receipt-1528842431', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-12 15:27:11', '2018-06-12 15:27:11'),
(225, 45, 'Task 2 on this board', '', '1', 'task_2_on_this_board', 2, '2018-06-17 12:00:00', '0000-00-00', 0, '2018-06-12 23:38:08', '2018-07-06 10:24:24'),
(227, 45, 'Farmland act', '', '1', 'farmland_act', 3, '2018-06-19 12:00:00', '0000-00-00', 0, '2018-06-13 12:24:16', '2018-06-17 20:54:43'),
(228, 52, 'Fully executed contract', '', '1', 'fully_executed_contract-1529704598', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-22 14:56:38', '2018-06-22 14:56:38'),
(229, 57, '30 Day Follow Up with Client', 'Communication for a 30 day closing', '1', '30_day_follow_up_with_client-1529868658', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(230, 63, 'Client Touch task 1', '', '1', 'client_touch_task_1', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(231, 63, 'client touch 2', '', '1', 'client_touch_2', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-24 12:30:58', '2018-06-24 12:30:58'),
(232, 64, '30 Day Follow Up with Client', 'Communication for a 30 day closing', '1', '30_day_follow_up_with_client-1529873992', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(233, 70, 'Client Touch task 1', '', '1', 'client_touch_task_1-1529873992', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(234, 70, 'client touch 2', '', '1', 'client_touch_2-1529873992', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-24 13:59:52', '2018-06-24 13:59:52'),
(235, 41, 'Task 1', '', '1', 'task_1-1529988022', 1, NULL, '0000-00-00', 0, '2018-06-25 21:40:22', '2018-06-25 21:40:22'),
(236, 71, 'Fully executed contract', '', '1', 'fully_executed_contract-1530080885', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-06-26 23:28:05', '2018-06-26 23:28:05'),
(237, 74, 'task1', '', '1', 'task1-1530081370', 1, NULL, '0000-00-00', 0, '2018-06-26 23:36:10', '2018-06-26 23:36:10'),
(238, 20, 'TAsk  2', '', '1', 'task_2', 4, NULL, '0000-00-00', 0, '2018-06-27 21:40:22', '2018-06-27 21:50:58'),
(239, 20, 'Task 3', '', '1', 'task_3', 5, NULL, '0000-00-00', 0, '2018-06-27 21:40:28', '2018-06-27 21:40:28'),
(240, 44, 'Task 1', '', '1', 'task_1-1530245699', 1, NULL, '0000-00-00', 0, '2018-06-28 21:15:00', '2018-06-28 21:15:00'),
(241, 44, 'Task 2', '', '1', 'task_2-1530246106', 2, NULL, '0000-00-00', 0, '2018-06-28 21:21:46', '2018-06-28 21:21:46'),
(242, 42, '1', '', '1', '1', 1, NULL, '0000-00-00', 0, '2018-06-29 21:22:08', '2018-06-29 21:22:08'),
(243, 38, 'testing', '', '1', 'testing', 2, '2018-07-09 08:00:00', '0000-00-00', 0, '2018-07-06 12:46:59', '2018-07-06 12:47:36'),
(244, 76, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1531279978', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(245, 76, 'Purchase agreement\r\n', '', '1', 'purchase_agreement-1531279978', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(246, 76, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1531279978', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(247, 76, 'Schedule home inspection\r\n', '', '1', 'schedule_home_inspection-1531279978', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(248, 76, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1531279978', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(249, 76, 'Order appraisal', '', '1', 'order_appraisal-1531279978', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(250, 76, 'Receive disclosures', '', '1', 'receive_disclosures-1531279978', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(251, 76, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1531279978', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(252, 76, 'Enviromental hazards booklet', '', '1', 'enviromental_hazards_booklet-1531279978', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(253, 76, 'Natural hazards report', '', '1', 'natural_hazards_report-1531279978', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(254, 76, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1531279978', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(255, 76, 'Review disclosures', '', '1', 'review_disclosures-1531279978', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(256, 76, 'Appraisal report', '', '1', 'appraisal_report-1531279978', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(257, 76, 'Remove contingencies', '', '1', 'remove_contingencies-1531279978', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(258, 76, 'Obtain homeowner\'s insurance', '', '1', 'obtain_homeowner_s_insurance-1531279978', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(259, 76, 'Confirm closer of escrow', '', '1', 'confirm_closer_of_escrow-1531279978', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(260, 76, 'Order home warranty', '', '1', 'order_home_warranty-1531279978', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(261, 76, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1531279978', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(262, 76, 'Confirm that Broker verified commissions', '', '1', 'confirm_that_broker_verified_commis-1531279978', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(263, 77, 'Agency relationship disclosure', '', '1', 'agency_relationship_disclosure-1531279978', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(264, 77, 'Listing agreement', '', '1', 'listing_agreement-1531279978', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(265, 77, 'Estimate of sellers costs', '', '1', 'estimate_of_sellers_costs-1531279978', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(266, 77, 'Install yard sign', '', '1', 'install_yard_sign-1531279978', 4, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(267, 77, 'Lock box authorization', '', '1', 'lock_box_authorization-1531279978', 5, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(268, 77, 'Submit listing to MLS', '', '1', 'submit_listing_to_mls-1531279978', 6, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(269, 77, 'Earthquake disclosure report', '', '1', 'earthquake_disclosure_report-1531279978', 7, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(270, 77, 'Environmental  hazards booklet', '', '1', 'environmental_hazards_booklet-1531279978', 8, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(271, 77, 'Natural hazards report', '', '1', 'natural_hazards_report-1531279978', 9, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(272, 77, 'Property tax disclosure', '', '1', 'property_tax_disclosure-1531279978', 10, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(273, 77, 'Escrow deposit receipt', '', '1', 'escrow_deposit_receipt-1531279978', 11, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(274, 77, 'Schedule termite inspection', '', '1', 'schedule_termite_inspection-1531279978', 12, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(275, 77, 'Order appraisal', '', '1', 'order_appraisal-1531279978', 13, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(276, 77, 'Send disclosures to Buyer', '', '1', 'send_disclosures_to_buyer-1531279978', 14, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(277, 77, 'Appraisal report', '', '1', 'appraisal_report-1531279978', 15, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(278, 77, 'Confirm removal of contingencies', '', '1', 'confirm_removal_of_contingencies-1531279978', 16, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(279, 77, 'Order home warranty', '', '1', 'order_home_warranty-1531279978', 17, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(280, 77, 'Confirm that Broker reviewed all docs', '', '1', 'confirm_that_broker_reviewed_all_do-1531279978', 18, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(281, 77, 'Confirm that Broker verified commissions ', '', '1', 'confirm_that_broker_verified_commis-1531279978', 19, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(282, 77, 'Confirm close of escrow', '', '1', 'confirm_close_of_escrow-1531279978', 20, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(283, 78, 'Send Fully executed purchase agreement and any counter offers', '', '1', 'send_fully_executed_purchase_agreem-1531279978', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(284, 79, 'Order Home Inspection', '', '1', 'order_home_inspection-1531279978', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(285, 79, 'Review home inspection report', '', '1', 'review_home_inspection_report-1531279978', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(286, 79, 'Request for repairs', '', '1', 'request_for_repairs-1531279978', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(287, 80, 'Order prelim', '', '1', 'order_prelim-1531279978', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(288, 81, 'Send Fully executed purchase agreement', '', '1', 'send_fully_executed_purchase_agreem-1531279978', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(289, 81, 'Send emd', '', '1', 'send_emd-1531279978', 2, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(290, 81, 'Escrow deposit receipt ', '', '1', 'escrow_deposit_receipt-1531279978', 3, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-10 20:32:58', '2018-07-10 20:32:58'),
(291, 63, 'example 3', '', '1', 'example_3', 3, NULL, '0000-00-00', 0, '2018-07-11 19:37:10', '2018-07-11 19:37:10'),
(292, 82, 'Fully executed contract', '', '1', 'fully_executed_contract-1531877769', 1, '0000-00-00 00:00:00', '0000-00-00', 0, '2018-07-17 18:36:09', '2018-07-17 18:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transactions`
--

INSERT INTO `tbl_transactions` (`id`, `type`, `status`, `slug`, `created`, `modified`) VALUES
(1, 'Listings', 1, 'listings', '2018-01-31 05:40:55', '0000-00-00 00:00:00'),
(2, 'Buyers under contract', 1, 'buyers_under_contract', '2018-01-31 05:41:07', '0000-00-00 00:00:00'),
(3, 'Sellers under contract', 1, 'sellers_under_contract', '2018-01-31 05:41:16', '0000-00-00 00:00:00'),
(4, 'Both sides', 1, 'both_sides', '2018-01-31 05:41:26', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `user_type` tinyint(4) NOT NULL COMMENT '0->Agents, 1->Lender, 2-> Title',
  `turn_off_notification` tinyint(2) NOT NULL,
  `user_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text,
  `gender` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `forget_password_status` tinyint(1) NOT NULL DEFAULT '0',
  `activation_status` tinyint(1) NOT NULL DEFAULT '0',
  `approve_status` tinyint(1) NOT NULL COMMENT 'used to check admin approval',
  `last_login_ip` varchar(50) NOT NULL,
  `online_status` tinyint(1) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `lastupdate` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `mark_default` tinyint(1) NOT NULL DEFAULT '0',
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `first_name`, `last_name`, `title`, `company_name`, `user_type`, `turn_off_notification`, `user_name`, `description`, `gender`, `email_address`, `password`, `profile_image`, `contact`, `address`, `address2`, `forget_password_status`, `activation_status`, `approve_status`, `last_login_ip`, `online_status`, `slug`, `lastupdate`, `created`, `modified`, `status`, `mark_default`, `location`) VALUES
(4, 'Juan', 'Gabriel', 'Realtor', '', 0, 0, NULL, NULL, '', 'juangmolina76@gmail.com', 'f56a24c4bb9079ef7223f4e41d210061', '1529987868Juan Gabriel Profile pic.jpg', '18056028728', '137 w. 2nd st. Oxnard, CA 93036', '', 0, 1, 0, '', 0, 'juan_gabriel', '0000-00-00', '2018-01-31 19:59:49', '2018-06-11 16:32:25', '1', 0, NULL),
(5, 'Phat', 'Leads', '', '', 1, 0, NULL, NULL, '', 'infophatleads@gmail.com', 'f56a24c4bb9079ef7223f4e41d210061', '', '8056028728', '123 Happy Dr.', '', 0, 1, 1, '', 0, 'phat', '0000-00-00', '2018-02-01 08:57:06', '0000-00-00 00:00:00', '1', 0, NULL),
(6, 'EZ', 'LeadPages', 'Realtor', '', 1, 0, NULL, NULL, '', 'infoezleadpages@gmail.com', 'f56a24c4bb9079ef7223f4e41d210061', '1529987958Ceci pic.jpg', '18052291813', '123 Happy Dr. Oxnard, CA 93030', '', 0, 1, 0, '', 0, 'ez_leadpages', '0000-00-00', '2018-02-01 08:57:50', '2018-06-11 16:32:46', '1', 0, NULL),
(7, 'MaksSmasyJJ', 'MaksSmasyJJ', '', '', 0, 0, NULL, NULL, '', 'spectrocoin3@mail.ru', 'f841c026c7602d3168c54904c3496ee9', NULL, NULL, NULL, NULL, 0, 0, 0, '', 0, 'makssmasyjj_makssmasyjj', '0000-00-00', '2018-03-07 01:54:09', '0000-00-00 00:00:00', '1', 0, NULL),
(8, 'Anil', 'Moud', '', '', 0, 0, NULL, NULL, '', 'anil.moud@logicspice.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, 0, 1, 0, '', 0, 'anil_moud', '0000-00-00', '2018-05-02 12:08:01', '0000-00-00 00:00:00', '1', 0, NULL),
(9, 'SitesicLD', 'SitesicLD', '', '', 0, 0, NULL, NULL, '', 'miekisimpna2013@seocdvig.ru', '530847c084097a37923d317ca06e1d73', NULL, NULL, NULL, NULL, 0, 0, 0, '', 0, 'sitesicld_sitesicld', '0000-00-00', '2018-05-15 22:21:02', '0000-00-00 00:00:00', '1', 0, NULL),
(10, 'Giovanni', 'SantaAna', '', '', 0, 0, NULL, NULL, '', 'giovanni@move4freerealty.com', '8f8439bd01556aace5fd2b93ea927958', NULL, NULL, NULL, NULL, 0, 1, 0, '', 0, 'giovanni_santaana', '0000-00-00', '2018-05-17 13:12:47', '0000-00-00 00:00:00', '1', 0, NULL),
(11, 'gmoney', 'santaana', '', '', 0, 0, NULL, NULL, '', 'gsantaana@icloud.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, NULL, NULL, 0, 0, 0, '', 0, 'gmoney_santaana', '0000-00-00', '2018-05-19 18:50:52', '0000-00-00 00:00:00', '1', 0, NULL),
(12, 'SitesicLD', 'SitesicLD', '', '', 0, 0, NULL, NULL, '', 'amerpropas1967@seocdvig.ru', '4ba2697a695bb11070d775074c372cdb', NULL, NULL, NULL, NULL, 0, 0, 0, '', 0, 'sitesicld_sitesicld-1528309615', '0000-00-00', '2018-06-06 11:26:55', '0000-00-00 00:00:00', '1', 0, NULL),
(13, 'Braden', 'Jackson', 'Developer', '', 0, 0, NULL, NULL, '', 'bradenjackson93@gmail.com', 'c9d620912a2a4c80ede63c5962cce805', NULL, '7654189478', 'test', '', 0, 1, 0, '', 0, 'braden_jackson', '0000-00-00', '2018-07-15 12:50:29', '2018-07-17 18:43:04', '1', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usertypes`
--

CREATE TABLE `tbl_usertypes` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_usertypes`
--

INSERT INTO `tbl_usertypes` (`id`, `type`, `status`, `slug`, `created`, `modified`) VALUES
(1, 'Agents', 1, 'agents', '2018-04-16 00:00:00', '2018-04-16 00:00:00'),
(2, 'Lenders', 1, 'lenders', '2018-04-16 00:00:00', '2018-04-16 00:00:00'),
(3, 'Title', 1, 'title', '2018-04-16 00:00:00', '2018-04-16 00:00:00'),
(4, 'Client', 1, 'client', '2018-04-16 00:00:00', '2018-04-16 00:00:00'),
(5, 'Workers', 1, 'workers', '2018-04-23 08:58:17', '2018-04-23 08:58:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_additionals`
--
ALTER TABLE `tbl_additionals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_adminboards`
--
ALTER TABLE `tbl_adminboards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_adminchecklists`
--
ALTER TABLE `tbl_adminchecklists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_adminchecklistvalues`
--
ALTER TABLE `tbl_adminchecklistvalues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_adminprojects`
--
ALTER TABLE `tbl_adminprojects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admintasks`
--
ALTER TABLE `tbl_admintasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_attachments`
--
ALTER TABLE `tbl_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_boards`
--
ALTER TABLE `tbl_boards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_checklists`
--
ALTER TABLE `tbl_checklists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_checklistvalues`
--
ALTER TABLE `tbl_checklistvalues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_invites`
--
ALTER TABLE `tbl_invites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_projectinvites`
--
ALTER TABLE `tbl_projectinvites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_projects`
--
ALTER TABLE `tbl_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reminders`
--
ALTER TABLE `tbl_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_usertypes`
--
ALTER TABLE `tbl_usertypes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `tbl_additionals`
--
ALTER TABLE `tbl_additionals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `tbl_adminboards`
--
ALTER TABLE `tbl_adminboards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_adminchecklists`
--
ALTER TABLE `tbl_adminchecklists`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_adminchecklistvalues`
--
ALTER TABLE `tbl_adminchecklistvalues`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_adminprojects`
--
ALTER TABLE `tbl_adminprojects`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admintasks`
--
ALTER TABLE `tbl_admintasks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `tbl_attachments`
--
ALTER TABLE `tbl_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_boards`
--
ALTER TABLE `tbl_boards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_checklists`
--
ALTER TABLE `tbl_checklists`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_checklistvalues`
--
ALTER TABLE `tbl_checklistvalues`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_invites`
--
ALTER TABLE `tbl_invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_projectinvites`
--
ALTER TABLE `tbl_projectinvites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_projects`
--
ALTER TABLE `tbl_projects`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_reminders`
--
ALTER TABLE `tbl_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_usertypes`
--
ALTER TABLE `tbl_usertypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
