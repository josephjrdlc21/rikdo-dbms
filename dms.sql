-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 03:32 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dms`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_log`
--

CREATE TABLE `account_log` (
  `id` int(11) NOT NULL,
  `account` int(11) NOT NULL,
  `log_in` timestamp NULL DEFAULT NULL,
  `log_out` timestamp NULL DEFAULT NULL,
  `unique_number` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account_log`
--

INSERT INTO `account_log` (`id`, `account`, `log_in`, `log_out`, `unique_number`) VALUES
(151, 22, '2023-01-02 14:56:52', '2023-01-02 14:57:42', '63b2f0b4881a1'),
(152, 31, '2023-01-02 14:57:51', '2023-01-02 14:58:16', '63b2f0ef4bffd'),
(199, 1, '2023-03-02 14:45:55', '2023-03-02 15:47:23', '6400b6a36d97c'),
(200, 1, '2023-03-03 12:20:32', '2023-03-03 15:03:30', '6401e6103cd93'),
(201, 26, '2023-03-03 14:10:53', '2023-03-03 15:03:10', '6401ffedea6da'),
(202, 1, '2023-03-04 12:52:02', '2023-03-04 13:41:04', '64033ef2c1d8e'),
(203, 22, '2023-03-04 13:04:41', '2023-03-04 13:19:48', '640341e968d0c'),
(204, 26, '2023-03-04 13:04:48', '2023-03-04 13:19:33', '640341f0a4a52'),
(205, 1, '2023-03-04 13:49:55', '2023-03-04 13:50:50', '64034c833e045'),
(206, 1, '2023-03-05 14:56:37', '2023-03-05 16:08:21', '6404ada53164c'),
(207, 26, '2023-03-05 15:24:40', '2023-03-05 16:08:14', '6404b4386cdfa'),
(208, 1, '2023-03-06 15:19:10', '2023-03-06 16:20:01', '6406046e7a318'),
(209, 26, '2023-03-06 15:21:48', '2023-03-06 16:20:05', '6406050c85afe'),
(210, 22, '2023-03-06 15:37:21', '2023-03-06 16:20:06', '640608b12ae86'),
(211, 1, '2023-03-07 12:55:05', '2023-03-07 13:22:08', '64073429b6708'),
(212, 26, '2023-03-12 06:02:01', '2023-03-12 06:17:57', '640d6ad95ed45'),
(213, 1, '2023-03-14 18:30:52', '2023-03-14 18:50:28', '6410bd5c0337c'),
(214, 26, '2023-03-14 18:34:22', '2023-03-14 18:45:55', '6410be2ed7ee8'),
(215, 1, '2023-04-16 16:22:47', '2023-04-16 17:16:28', '643c20d7bf7e8'),
(216, 1, '2023-11-23 13:21:42', '2023-11-23 13:23:19', '655f51e63e4cb'),
(217, 1, '2023-11-24 05:06:16', '2023-11-24 05:06:46', '65602f4852118'),
(218, 24, '2023-11-24 05:06:50', '2023-11-24 05:06:58', '65602f6a3271b'),
(219, 1, '2023-11-24 05:07:11', '2023-11-24 05:07:56', '65602f7f313d1'),
(220, 22, '2023-11-24 05:08:08', '2023-11-24 05:08:17', '65602fb8c9183');

-- --------------------------------------------------------

--
-- Table structure for table `action_done`
--

CREATE TABLE `action_done` (
  `id` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `type` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `action_done`
--

INSERT INTO `action_done` (`id`, `document`, `type`) VALUES
(82, 48, 'view'),
(83, 48, 'view'),
(84, 48, 'view'),
(85, 48, 'view'),
(86, 48, 'download'),
(87, 48, 'view'),
(88, 48, 'download'),
(89, 48, 'view'),
(90, 48, 'view'),
(91, 48, 'download'),
(92, 48, 'view'),
(95, 48, 'view'),
(138, 53, 'view'),
(139, 48, 'view'),
(141, 55, 'view'),
(142, 55, 'download'),
(143, 55, 'view'),
(144, 48, 'view'),
(146, 55, 'view'),
(147, 55, 'view'),
(148, 55, 'view'),
(149, 55, 'view'),
(150, 55, 'view'),
(155, 53, 'view'),
(158, 55, 'view'),
(159, 53, 'view'),
(160, 55, 'view'),
(161, 55, 'view'),
(162, 55, 'download'),
(163, 48, 'view'),
(164, 48, 'view'),
(165, 53, 'view'),
(169, 53, 'view'),
(171, 53, 'view'),
(172, 55, 'view'),
(173, 55, 'view'),
(174, 55, 'view'),
(175, 53, 'view'),
(176, 55, 'view'),
(177, 53, 'view'),
(178, 55, 'view'),
(179, 53, 'view'),
(180, 55, 'view'),
(181, 53, 'view'),
(183, 55, 'view'),
(184, 55, 'download'),
(185, 55, 'view'),
(187, 54, 'view'),
(188, 54, 'view'),
(189, 54, 'download'),
(190, 54, 'view'),
(200, 57, 'view'),
(201, 53, 'view'),
(202, 53, 'download'),
(203, 53, 'download'),
(204, 57, 'view'),
(205, 53, 'view'),
(206, 58, 'view'),
(207, 58, 'download'),
(208, 58, 'view'),
(209, 60, 'view'),
(210, 60, 'view'),
(211, 60, 'view'),
(212, 60, 'download'),
(213, 57, 'view'),
(214, 57, 'view'),
(215, 57, 'download'),
(216, 58, 'view'),
(218, 62, 'view'),
(219, 62, 'view');

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `account` int(11) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `account`, `activity`, `created_at`) VALUES
(3, 26, 'Submits research chapter 2 entitled The Implications of Human Identity Chips', '2023-03-05 15:57:39'),
(4, 26, 'Submits version 2 of research entitled The Implications of Human Identity Chips', '2023-03-05 16:00:40'),
(5, 26, 'Submits research chapter 3 entitled The Implications of Human Identity Chips', '2023-03-05 16:01:42'),
(6, 26, 'Deletes a research document', '2023-03-06 15:22:49'),
(7, 22, 'Downloads a research document entitled Natural Language Processing', '2023-03-06 15:46:06'),
(8, 26, 'Downloads a research document entitled Natural Language Processing', '2023-03-06 15:46:45'),
(9, 22, 'Add comments on research entitled Natural Language Processing', '2023-03-06 15:47:16'),
(10, 26, 'Submits a research paper entitled Video Gaming as a Solution to World Problems', '2023-03-06 15:51:26'),
(11, 26, 'Downloads a research document entitled Video Gaming as a Solution to World Problems', '2023-03-06 15:52:02'),
(12, 26, 'Submits a research paper entitled The Pros and Cons of Human Cloning', '2023-03-06 15:57:42'),
(13, 22, 'Deletes a research document', '2023-03-06 15:58:21'),
(14, 26, 'Submits a research paper entitled The Pros and Cons of Human Cloning', '2023-03-06 15:59:05'),
(15, 22, 'Add comments on research entitled The Pros and Cons of Human Cloning', '2023-03-06 15:59:20'),
(16, 22, 'Checks a research document entitledThe Pros and Cons of Human Cloning', '2023-03-06 15:59:47'),
(17, 22, 'Checks a research document entitledThe Pros and Cons of Human Cloning', '2023-03-06 16:00:13'),
(18, 22, 'Downloads a research document entitled The Pros and Cons of Human Cloning', '2023-03-06 16:00:47'),
(19, 1, 'Add comments on research entitled The Implications of Human Identity Chips', '2023-03-06 16:18:31'),
(20, 1, 'Downloads a research document entitled The Implications of Human Identity Chips', '2023-03-06 16:18:43'),
(21, 1, 'Generate pdf inventory reports', '2023-03-07 13:19:47'),
(22, 1, 'Print a pdf inventory reports', '2023-03-07 13:19:53'),
(23, 26, 'Submits a research paper entitled Bulag At pipi', '2023-03-14 18:35:04'),
(24, 26, 'Deletes a research document', '2023-03-14 18:39:56'),
(25, 26, 'Submits a research paper entitled asdasdasd', '2023-03-14 18:40:15'),
(26, 26, 'Submits version 2 of research entitled asdasdasd', '2023-03-14 18:41:40'),
(27, 26, 'Submits research chapter 6 entitled asdasdasd', '2023-03-14 18:42:50'),
(28, 1, 'Checks a research document entitledasdasdasd', '2023-03-14 18:46:11'),
(29, 1, 'Post completed research entitled asdasdasd', '2023-03-14 18:47:37'),
(30, 1, 'Print a pdf inventory reports', '2023-04-16 16:32:35'),
(31, 1, 'Print a pdf inventory reports', '2023-04-16 16:40:04'),
(32, 1, 'Print a pdf inventory reports', '2023-04-16 16:41:56'),
(33, 1, 'Print a pdf inventory reports', '2023-04-16 17:01:07'),
(34, 1, 'Print a pdf inventory reports', '2023-04-16 17:01:46'),
(35, 1, 'Print a pdf inventory reports', '2023-04-16 17:02:38'),
(36, 1, 'Print a pdf inventory reports', '2023-04-16 17:02:52'),
(37, 1, 'Print a pdf inventory reports', '2023-04-16 17:09:40'),
(38, 1, 'Generate pdf inventory reports', '2023-04-16 17:10:56');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `commentor` int(11) NOT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date_comment` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `document`, `commentor`, `message`, `date_comment`) VALUES
(188, 53, 22, '{\"ops\":[{\"insert\":\"hello world\\n\"}]}', '2023-03-06 15:47:16'),
(189, 60, 22, '{\"ops\":[{\"insert\":\"Yow\\n\"}]}', '2023-03-06 15:59:20'),
(190, 57, 1, '{\"ops\":[{\"insert\":\"Revise\\n\"}]}', '2023-03-06 16:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `degree_strand`
--

CREATE TABLE `degree_strand` (
  `id` int(11) NOT NULL,
  `ds_code` varchar(10) NOT NULL,
  `ds_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `degree_strand`
--

INSERT INTO `degree_strand` (`id`, `ds_code`, `ds_name`) VALUES
(1, 'AB-C', 'Bachelor Of Arts In Communication'),
(2, 'AB-PS', 'Bachelor Of Arts Major In Political Science'),
(3, 'BLIS', 'Bachelor of Library And Information Science'),
(4, 'BSA', 'Bachelor of Science In Accountancy'),
(5, 'BSARCH', 'Bachelor of Science In Architecture'),
(6, 'BSBA-FM', 'Bachelor of Science In Business Administration Major In Financial Management'),
(7, 'BSBA-HRDM', 'Bachelor of Science In Business Administration Major In Human Resource Development Management'),
(8, 'BSBA-M', 'Bachelor of Science In Business Administration Major In Management'),
(9, 'BSBA-MM', 'Bachelor of Science In Business Administration Major In Marketing Management'),
(10, 'BSBA-OM', 'Bachelor of Science In Business Administration Major In Operations Management'),
(11, 'BSCE', 'Bachelor of Science In Civil Engineering'),
(12, 'BSCpE', 'Bachelor of Science In Computer Engineering'),
(13, 'BSCS', 'Bachelor of Science In Computer Science'),
(14, 'BS-ECE', 'Bachelor of Science In Electronics Engineering'),
(15, 'BSED-BS', 'Bachelor of Secondary Education Major In Biological Science'),
(16, 'BSED-E', 'Bachelor of Secondary Education Major In English'),
(17, 'BSED-F', 'Bachelor of Secondary Education Major In Filipino'),
(18, 'BSED-M', 'Bachelor of Secondary Education Major In Mathematics'),
(19, 'BSED-MAPE', 'Bachelor of Secondary Education Major In Music, Arts And Physical Education'),
(20, 'BSED-RE', 'Bachelor of Secondary Education Major In Religious Education'),
(21, 'BSED-SS', 'Bachelor of Secondary Education Major In Social Studies'),
(22, 'BSED-VE', 'Bachelor of Secondary Education Major In Values Education'),
(23, 'BSEE', 'Bachelor of Science In Electrical Engineering'),
(24, 'BSHRM', 'Bachelor of Science In Hotel & Restaurant Management'),
(25, 'BSIE', 'Bachelor of Science In Industrial Engineering'),
(26, 'BSIT', 'Bachelor of Science In Information Technology'),
(27, 'BSN', 'Bachelor of Science In Nursing'),
(28, 'BSOA', 'Bachelor of Science In Office Administration'),
(29, 'BSSW', 'Bachelor of Science In Social Network'),
(30, 'BST', 'Bachelor of Science In Tourism'),
(31, 'ACT', 'Associate In Computer Technology'),
(32, 'MAED', 'Master Of Arts In Education Major In Educational Administration'),
(33, 'MALT', 'Master Of Arts In Education Major In English Language Teaching'),
(34, 'MARE', 'Master Of Arts In Education Major In Religious Education'),
(35, 'MASE', 'Master Of Arts In Education Major In Science Education'),
(36, 'MAV', 'Master Of Arts In Education Major In Values Education'),
(37, 'MBA', 'Master In Business Administration'),
(38, 'MPM', 'Master In Public Management'),
(39, 'BEED', 'Bachelor Of Elementary Education'),
(40, 'CR-E', 'Cross-Enrollee'),
(41, 'ED.D', 'Doctor Of Education'),
(42, 'JHSE', 'Junior High School Education'),
(43, 'EE', 'Elementary Education'),
(44, 'SHSE', 'Senior High School Education'),
(45, 'BSTM', 'Bachelor Of Science In Tourism Management'),
(46, 'BSAcT', 'Bachelor Of Science In Accounting Technology'),
(47, 'ED', 'General Course'),
(48, 'MBA_NT', 'Master In Business Administration (Non-Thesis)'),
(49, 'MARE_NT', 'Master Of Arts In Education Major In Religous Education (Non-Thesis)'),
(50, 'MPM_NT', 'Master In Public Management (Non-Thesis)'),
(51, 'STEM_MAIN', 'Science, Technology, Engineering, And Mathematics Strand'),
(52, 'STEM_BR', 'Science, Technology, Engineering, And Mathematics Strand'),
(53, 'HUMMS_MAIN', 'Humanities, And Social Sciences Strand'),
(54, 'HUMMS_BR', 'Humanities, And Social Sciences Strand'),
(55, 'ABM_MAIN', 'Accountancy, Business And Management Strand'),
(56, 'ABM_BR', 'Accountancy, Business And Management Strand'),
(57, 'GAS_MAIN', 'General Academic Strand'),
(58, 'GAS_BR', 'General Academic Strand'),
(59, 'TVL_HE1', 'Technical, Vocational And Livelihood-HE1'),
(60, 'TVL_HE2', 'Technical, Vocational And Livelihood-HE2'),
(61, 'TVL_ICT', 'Technical, Vocational And Livelihood-ICT'),
(62, 'ABPS', 'Bachelor Of Arts In Political Science'),
(63, 'BECE', 'Bachelor Of Early Childhood Education'),
(64, 'BPED', 'Bachelor Of Physical Education'),
(65, 'BSED-S', 'Bachelor Of Secondary Education Major In Science'),
(66, 'BSMA', 'Bachelor Of Science In Management Accounting'),
(67, 'BASIA', 'Bachelor Of Science In Internal Auditing'),
(68, 'BSBA-BML', 'Bachelor Of Science In Business Administration Major In Business Management And Leadership'),
(69, 'BSHM', 'Bachelor Of Science In Hospitality Management'),
(70, 'BECED', 'Bachelor Of Early Childhood Education'),
(71, 'MAELT', 'Master Of Arts In Education Major In English Language Teaching'),
(72, 'CVEd', 'Certificate In Values Education'),
(73, 'CREED', 'Certificate In Religious Education'),
(74, 'CPE', 'Certificate In Professional Education'),
(75, 'CPEd', 'Certificate In Physical Education'),
(76, 'CECEd', 'Certificate In Early Childhood Education'),
(77, 'BHumServ', 'Bachelor In Human Services'),
(78, 'ACT.', 'Associate In Computer Technology'),
(79, 'MAVE', 'Master Of Arts In Education Major In Values Education'),
(80, 'MARE.', 'Master Of Arts In Education Major In Religious Education'),
(81, 'BS-ITTSM', 'Bachelor Of Science In International Tourism And Travel Services Management'),
(82, 'BSIHM-HRA', 'Bachelor Of Science In International Hospitality Management Major In Hotel And Restaurant Administra'),
(83, 'BSIHM-MSCA', 'Bachelor Of Science In International Hospitality Management Major In Meal Science And Culinary Arts'),
(84, 'OT', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `dept_code` varchar(10) NOT NULL,
  `dept_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dept_code`, `dept_name`) VALUES
(1, 'ABM', 'Accountancy, Business, And Management'),
(2, 'GAS', 'General Academic Strand'),
(3, 'HUMSS', 'Humanities, And Social Sciences'),
(4, 'STEM', 'Science, Technology, Engineering And Mathematics'),
(5, 'CBA', 'College of Business And Accountancy'),
(6, 'CCS', 'College of Computer Studies'),
(7, 'CASED', 'College of Arts and Sciences and Education'),
(8, 'COE', 'College of Engineering'),
(9, 'CON', 'College of Nursing'),
(10, 'COA', 'College of Architecture'),
(11, 'OT', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `published_research`
--

CREATE TABLE `published_research` (
  `id` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `format` varchar(100) NOT NULL,
  `abstract` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `published_research`
--

INSERT INTO `published_research` (`id`, `document`, `year`, `format`, `abstract`) VALUES
(11, 55, 2023, 'imrad', 'Data Analysis is the process of systematically applying statistical and/or logical techniques to describe and illustrate, condense and recap, and evaluate data. According to Shamoo and Resnik (2003) various analytic procedures “provide a way of drawing inductive inferences from data and distinguishing the signal (the phenomenon of interest) from the noise (statistical fluctuations) present in the data”'),
(12, 54, 2023, 'imrad', 'Queueing systems are simplified mathematical models to explain congestion. Broadly speaking, a queueing system occurs any time ‘customers’ demand ‘service’ from some facility; usually both the arrival of the customers and the service times are assumed to be random. If all of the ‘servers’ are busy when new customers arrive, these will generally wait in line for the next available server. Simple queueing systems are defined by specifying the following (a) the arrival pattern, (b) the service mechanism, and (c) queue discipline.'),
(13, 62, 2023, 'imrad', 'dasdhaskjhdjkash');

-- --------------------------------------------------------

--
-- Table structure for table `publish_viewed`
--

CREATE TABLE `publish_viewed` (
  `id` int(11) NOT NULL,
  `published` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `publish_viewed`
--

INSERT INTO `publish_viewed` (`id`, `published`) VALUES
(40, 11),
(41, 11),
(42, 11),
(45, 11),
(43, 12),
(44, 12),
(46, 13);

-- --------------------------------------------------------

--
-- Table structure for table `research_documents`
--

CREATE TABLE `research_documents` (
  `id` int(11) NOT NULL,
  `research_title` varchar(300) NOT NULL,
  `authors` varchar(200) NOT NULL,
  `degree_strand` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `chapter` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `status` varchar(45) NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `submitted_by` int(11) NOT NULL,
  `adviser` int(11) NOT NULL,
  `file_names` varchar(150) NOT NULL,
  `instatus` varchar(45) DEFAULT NULL,
  `date_restore` timestamp NOT NULL DEFAULT current_timestamp(),
  `type_r` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `research_documents`
--

INSERT INTO `research_documents` (`id`, `research_title`, `authors`, `degree_strand`, `department`, `chapter`, `version`, `status`, `date_submitted`, `submitted_by`, `adviser`, `file_names`, `instatus`, `date_restore`, `type_r`) VALUES
(48, 'Web-based Document Management System', 'Joseph Dela Cruz, Gerson Capati', 26, 6, 1, 1, 'Approved', '2023-02-20 10:28:11', 26, 22, 'Research about art.docx', 'active', '2023-02-20 10:28:11', 'Capstone'),
(53, 'Natural Language Processing', 'Gerson Capati', 12, 8, 0, 2, 'Rejected', '2023-02-25 17:17:03', 26, 22, '1.0.6-class-activity top-hacker-shows-us-how-it-is-done answers.docx', 'active', '2023-02-25 13:32:51', 'Proposal'),
(54, 'Queuing System With Chatbot', 'Joshua Hipolito', 26, 6, 5, 2, 'Published', '2023-03-04 13:10:12', 26, 22, 'CRITERIA FOR JUDGING.pdf', 'active', '2023-02-25 13:35:17', 'Thesis'),
(55, 'Data Analysis AI', 'Marvin Gregorio', 26, 6, 5, 2, 'Published', '2023-03-03 14:11:23', 26, 1, 'Lab 4.5.4.pdf', 'active', '2023-02-26 14:17:00', 'Capstone'),
(57, 'The Implications of Human Identity Chips', 'Josh Henry, Jovin Torres', 12, 8, 3, 1, 'Pending', '2023-03-05 16:01:42', 26, 1, 'Template 1.docx', 'active', '2023-03-05 15:37:16', 'Dissertation'),
(58, 'Video Gaming as a Solution to World Problems', 'Karl Pangilinan', 26, 6, 3, 1, 'Revision', '2023-03-06 15:51:25', 26, 22, 'ICT103E-1.docx', 'active', '2023-03-06 15:51:25', 'Thesis'),
(60, 'The Pros and Cons of Human Cloning', 'Jovin Torres', 13, 6, 4, 1, 'Approved', '2023-03-06 15:59:05', 26, 22, 'Group-2_Prelim-Exam.docx', 'active', '2023-03-06 15:59:05', 'Thesis'),
(62, 'asdasdasd', 'asdasd', 18, 10, 6, 1, 'Published', '2023-03-14 18:42:47', 26, 1, 'Chapters 4 and 5.pdf', 'active', '2023-03-14 18:40:15', 'Capstone');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `idnum` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `degree_or_strand` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `role` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `password` varchar(80) NOT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `status` varchar(45) NOT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp(),
  `code` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `idnum`, `firstname`, `lastname`, `degree_or_strand`, `dept`, `role`, `email`, `contact`, `password`, `profile`, `status`, `date_created`, `code`) VALUES
(1, '19310090', 'Joseph', 'Dela Cruz Jr.', 26, 6, 'Administrator', 'josephdelacruzjr4@gmail.com', '09381834805', '80f5916563f802a578c0cf3ecac093f0', 'joseph.jpg', 'activated', '2022-12-01 14:03:29', '0'),
(22, '19310091', 'Gerson', 'Capati', 14, 8, 'Adviser', 'gsrchsll@gmail.com', '09283472718', '2e3746e131d178d04609038957bfa567', 'gerson.jpg', 'activated', '2022-12-01 14:03:29', '0'),
(23, '19310092', 'Marvin', 'Gregorio', 5, 10, 'Graduates', 'marvingregorio@gmail.com', '09384756321', 'dba0079f1cb3a3b56e102dd5e04fa2af', 'marvin.jpg', 'deactivated', '2022-12-01 14:03:29', '0'),
(24, '19310093', 'Jonathan Jake', 'Juico', 4, 5, 'College', 'jakejuico@gmail.com', '09384738173', '1200cf8ad328a60559cf5e7c5f46ee6d', 'jake.jpg', 'activated', '2022-12-01 14:03:29', '0'),
(25, '19310094', 'Salve Ann', 'Austria', 27, 9, 'College', 'salveannaustria@gmail.com', '09485769183', 'd21a891233c1e4d010c92d60592138fd', 'salve.jpg', 'activated', '2021-12-22 14:02:32', '0'),
(26, '19310095', 'John Adrian', 'Regalado', 51, 4, 'Senior High School', 'josephdelacruzjr4@gmail.com', '09375836123', '527bd5b5d689e2c32ae974c6229ff785', 'aid.jpg', 'activated', '2021-12-22 14:02:32', '0'),
(27, '19310096', 'Karl Andrei', 'Pangilinan', 71, 7, 'Adviser', 'karlandrei06@gmail.com', '09388867475', 'f47636673b14c54021a69dc06f6a19fb', 'karl.jpg', 'activated', '2021-12-23 14:02:32', '0'),
(28, '19310098', 'Sherbert', 'Mateo', 53, 3, 'Senior High School', 'sherbertmateo@gmail.com', '09377583751', '349cf4581569282fec1e0c7fd6e5f4d4', 'sherbert.jpg', 'deactivated', '2020-12-16 14:01:55', '0'),
(29, '19310099', 'Krisha Ann', 'Ablaza', 80, 7, 'Faculty', 'krishaablaza@gmail.com', '09337458230', '5cd230bcff9868a79e32fadeff460094', 'krisha.jpg', 'activated', '2020-12-17 14:01:55', '0'),
(30, '19310011', 'Arvin John', 'Bato', 3, 6, 'Administrator', 'gsrchsll@gmail.com', '09333456888', '89f6432af2e2bcea9489ad02cd27a134', 'arvin.jpg', 'deactivated', '2018-12-13 14:00:42', '0'),
(31, '19310018', 'Joshua James', 'Hipolito', 68, 5, 'Graduates', 'joshuahipolito@gmail.com', '09334858586', 'd1133275ee2118be63a577af759fc052', 'joshua.jpg', 'activated', '2019-12-18 14:00:42', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_log`
--
ALTER TABLE `account_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Indexes for table `action_done`
--
ALTER TABLE `action_done`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document` (`document`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document` (`document`),
  ADD KEY `commentor` (`commentor`);

--
-- Indexes for table `degree_strand`
--
ALTER TABLE `degree_strand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `published_research`
--
ALTER TABLE `published_research`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document` (`document`);

--
-- Indexes for table `publish_viewed`
--
ALTER TABLE `publish_viewed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published` (`published`);

--
-- Indexes for table `research_documents`
--
ALTER TABLE `research_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `degree_strand` (`degree_strand`),
  ADD KEY `department` (`department`),
  ADD KEY `submitted_by` (`submitted_by`),
  ADD KEY `adviser` (`adviser`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `degree_or_strand` (`degree_or_strand`),
  ADD KEY `dept` (`dept`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_log`
--
ALTER TABLE `account_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `action_done`
--
ALTER TABLE `action_done`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `degree_strand`
--
ALTER TABLE `degree_strand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `published_research`
--
ALTER TABLE `published_research`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `publish_viewed`
--
ALTER TABLE `publish_viewed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `research_documents`
--
ALTER TABLE `research_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_log`
--
ALTER TABLE `account_log`
  ADD CONSTRAINT `account_log_ibfk_1` FOREIGN KEY (`account`) REFERENCES `users` (`id`);

--
-- Constraints for table `action_done`
--
ALTER TABLE `action_done`
  ADD CONSTRAINT `action_done_ibfk_1` FOREIGN KEY (`document`) REFERENCES `research_documents` (`id`);

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`account`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`document`) REFERENCES `research_documents` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`commentor`) REFERENCES `users` (`id`);

--
-- Constraints for table `published_research`
--
ALTER TABLE `published_research`
  ADD CONSTRAINT `published_research_ibfk_1` FOREIGN KEY (`document`) REFERENCES `research_documents` (`id`);

--
-- Constraints for table `publish_viewed`
--
ALTER TABLE `publish_viewed`
  ADD CONSTRAINT `publish_viewed_ibfk_1` FOREIGN KEY (`published`) REFERENCES `published_research` (`id`);

--
-- Constraints for table `research_documents`
--
ALTER TABLE `research_documents`
  ADD CONSTRAINT `research_documents_ibfk_1` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `research_documents_ibfk_2` FOREIGN KEY (`adviser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `research_documents_ibfk_3` FOREIGN KEY (`department`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `research_documents_ibfk_4` FOREIGN KEY (`degree_strand`) REFERENCES `degree_strand` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`dept`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`degree_or_strand`) REFERENCES `degree_strand` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
