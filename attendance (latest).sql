-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 03:26 AM
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
-- Database: `admin1`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `ic_number` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `present` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `name`, `ic_number`, `date`, `present`, `created_at`, `updated_at`) VALUES
(2, 28, 'Aina binti Tahir', '110502043879', '2024-09-01', 1, NULL, NULL),
(3, 27, 'Ainani binti Tahir', '110502041988', '2024-09-01', 2, NULL, NULL),
(4, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-01', 2, NULL, NULL),
(5, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-01', 1, NULL, NULL),
(6, 26, 'Anis bin Bakar', '110929071298', '2024-09-01', 2, NULL, NULL),
(7, 10, 'Chan Tan Kiong', '070312056789', '2024-09-01', 1, NULL, NULL),
(8, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-01', 2, NULL, NULL),
(9, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-01', 3, NULL, NULL),
(10, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-01', 3, NULL, NULL),
(11, 25, 'Intan bin Hafiz', '101114021026', '2024-09-01', 3, NULL, NULL),
(12, 16, 'Izzah bin Eman', '080911031202', '2024-09-01', 3, NULL, NULL),
(13, 20, 'Lee Sana Sini', '090712031257', '2024-09-01', 3, NULL, NULL),
(14, 21, 'Lim Kok Sing', '090729041244', '2024-09-01', 3, NULL, NULL),
(15, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-01', 1, NULL, NULL),
(16, 23, 'Mujahid bin Awang', '100926071231', '2024-09-01', 4, NULL, NULL),
(17, 19, 'Munir bin Jimin', '090215050765', '2024-09-01', 1, NULL, NULL),
(18, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-01', 1, NULL, NULL),
(19, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-01', 4, NULL, NULL),
(20, 22, 'Sophea binti Pia', '100321091244', '2024-09-01', 4, NULL, NULL),
(21, 18, 'Vegeta Goku San', '090506101221', '2024-09-01', 4, NULL, NULL),
(22, 28, 'Aina binti Tahir', '110502043879', '2024-09-02', 1, NULL, NULL),
(23, 27, 'Ainani binti Tahir', '110502041988', '2024-09-02', 1, NULL, NULL),
(24, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-02', 1, NULL, NULL),
(25, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-02', 1, NULL, NULL),
(26, 26, 'Anis bin Bakar', '110929071298', '2024-09-02', 1, NULL, NULL),
(27, 10, 'Chan Tan Kiong', '070312056789', '2024-09-02', 1, NULL, NULL),
(28, 28, 'Aina binti Tahir', '110502043879', '2024-09-02', 1, NULL, NULL),
(29, 27, 'Ainani binti Tahir', '110502041988', '2024-09-02', 1, NULL, NULL),
(30, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-02', 1, NULL, NULL),
(31, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-02', 1, NULL, NULL),
(32, 26, 'Anis bin Bakar', '110929071298', '2024-09-02', 1, NULL, NULL),
(33, 10, 'Chan Tan Kiong', '070312056789', '2024-09-02', 3, NULL, NULL),
(34, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-02', 1, NULL, NULL),
(35, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-02', 1, NULL, NULL),
(36, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-02', 1, NULL, NULL),
(37, 25, 'Intan bin Hafiz', '101114021026', '2024-09-02', 1, NULL, NULL),
(38, 16, 'Izzah bin Eman', '080911031202', '2024-09-02', 4, NULL, NULL),
(39, 20, 'Lee Sana Sini', '090712031257', '2024-09-02', 1, NULL, NULL),
(40, 21, 'Lim Kok Sing', '090729041244', '2024-09-02', 1, NULL, NULL),
(41, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-02', 1, NULL, NULL),
(42, 23, 'Mujahid bin Awang', '100926071231', '2024-09-03', 1, NULL, NULL),
(43, 19, 'Munir bin Jimin', '090215050765', '2024-09-03', 1, NULL, NULL),
(44, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-03', 2, NULL, NULL),
(45, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-03', 1, NULL, NULL),
(46, 22, 'Sophea binti Pia', '100321091244', '2024-09-03', 1, NULL, NULL),
(47, 18, 'Vegeta Goku San', '090506101221', '2024-09-03', 1, NULL, NULL),
(48, 28, 'Aina binti Tahir', '110502043879', '2024-09-03', 1, NULL, NULL),
(49, 27, 'Ainani binti Tahir', '110502041988', '2024-09-03', 1, NULL, NULL),
(50, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-03', 1, NULL, NULL),
(51, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-03', 1, NULL, NULL),
(52, 26, 'Anis bin Bakar', '110929071298', '2024-09-03', 1, NULL, NULL),
(53, 10, 'Chan Tan Kiong', '070312056789', '2024-09-03', 1, NULL, NULL),
(54, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-03', 4, NULL, NULL),
(55, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-03', 1, NULL, NULL),
(56, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-03', 1, NULL, NULL),
(57, 25, 'Intan bin Hafiz', '101114021026', '2024-09-03', 1, NULL, NULL),
(58, 16, 'Izzah bin Eman', '080911031202', '2024-09-03', 1, NULL, NULL),
(59, 20, 'Lee Sana Sini', '090712031257', '2024-09-03', 1, NULL, NULL),
(60, 21, 'Lim Kok Sing', '090729041244', '2024-09-03', 1, NULL, NULL),
(61, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-03', 1, NULL, NULL),
(62, 23, 'Mujahid bin Awang', '100926071231', '2024-09-04', 1, NULL, NULL),
(63, 19, 'Munir bin Jimin', '090215050765', '2024-09-04', 1, NULL, NULL),
(64, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-04', 1, NULL, NULL),
(65, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-04', 1, NULL, NULL),
(66, 22, 'Sophea binti Pia', '100321091244', '2024-09-04', 1, NULL, NULL),
(67, 18, 'Vegeta Goku San', '090506101221', '2024-09-04', 1, NULL, NULL),
(68, 28, 'Aina binti Tahir', '110502043879', '2024-09-04', 1, NULL, NULL),
(69, 27, 'Ainani binti Tahir', '110502041988', '2024-09-04', 3, NULL, NULL),
(70, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-04', 1, NULL, NULL),
(71, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-04', 1, NULL, NULL),
(72, 26, 'Anis bin Bakar', '110929071298', '2024-09-04', 1, NULL, NULL),
(73, 10, 'Chan Tan Kiong', '070312056789', '2024-09-04', 2, NULL, NULL),
(74, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-04', 1, NULL, NULL),
(75, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-04', 1, NULL, NULL),
(76, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-04', 1, NULL, NULL),
(77, 25, 'Intan bin Hafiz', '101114021026', '2024-09-04', 1, NULL, NULL),
(78, 16, 'Izzah bin Eman', '080911031202', '2024-09-04', 2, NULL, NULL),
(79, 20, 'Lee Sana Sini', '090712031257', '2024-09-04', 1, NULL, NULL),
(80, 21, 'Lim Kok Sing', '090729041244', '2024-09-04', 2, NULL, NULL),
(81, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-04', 1, NULL, NULL),
(82, 23, 'Mujahid bin Awang', '100926071231', '2024-09-05', 1, NULL, NULL),
(83, 19, 'Munir bin Jimin', '090215050765', '2024-09-05', 1, NULL, NULL),
(84, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-05', 1, NULL, NULL),
(85, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-05', 1, NULL, NULL),
(86, 22, 'Sophea binti Pia', '100321091244', '2024-09-05', 4, NULL, NULL),
(87, 18, 'Vegeta Goku San', '090506101221', '2024-09-05', 1, NULL, NULL),
(88, 28, 'Aina binti Tahir', '110502043879', '2024-09-05', 4, NULL, NULL),
(89, 27, 'Ainani binti Tahir', '110502041988', '2024-09-05', 1, NULL, NULL),
(90, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-05', 3, NULL, NULL),
(91, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-05', 1, NULL, NULL),
(92, 26, 'Anis bin Bakar', '110929071298', '2024-09-05', 4, NULL, NULL),
(93, 10, 'Chan Tan Kiong', '070312056789', '2024-09-05', 1, NULL, NULL),
(94, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-05', 1, NULL, NULL),
(95, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-05', 1, NULL, NULL),
(96, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-05', 1, NULL, NULL),
(97, 25, 'Intan bin Hafiz', '101114021026', '2024-09-05', 4, NULL, NULL),
(98, 16, 'Izzah bin Eman', '080911031202', '2024-09-05', 4, NULL, NULL),
(99, 20, 'Lee Sana Sini', '090712031257', '2024-09-05', 4, NULL, NULL),
(100, 21, 'Lim Kok Sing', '090729041244', '2024-09-05', 1, NULL, NULL),
(101, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-05', 1, NULL, NULL),
(102, 23, 'Mujahid bin Awang', '100926071231', '2024-09-08', 2, NULL, NULL),
(103, 19, 'Munir bin Jimin', '090215050765', '2024-09-08', 1, NULL, NULL),
(104, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-08', 2, NULL, NULL),
(105, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-08', 1, NULL, NULL),
(106, 22, 'Sophea binti Pia', '100321091244', '2024-09-08', 1, NULL, NULL),
(107, 18, 'Vegeta Goku San', '090506101221', '2024-09-08', 1, NULL, NULL),
(108, 28, 'Aina binti Tahir', '110502043879', '2024-09-08', 3, NULL, NULL),
(109, 27, 'Ainani binti Tahir', '110502041988', '2024-09-08', 1, NULL, NULL),
(110, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-08', 1, NULL, NULL),
(111, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-08', 1, NULL, NULL),
(112, 26, 'Anis bin Bakar', '110929071298', '2024-09-08', 4, NULL, NULL),
(113, 10, 'Chan Tan Kiong', '070312056789', '2024-09-08', 4, NULL, NULL),
(114, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-08', 4, NULL, NULL),
(115, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-08', 1, NULL, NULL),
(116, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-08', 1, NULL, NULL),
(117, 25, 'Intan bin Hafiz', '101114021026', '2024-09-08', 1, NULL, NULL),
(118, 16, 'Izzah bin Eman', '080911031202', '2024-09-08', 2, NULL, NULL),
(119, 20, 'Lee Sana Sini', '090712031257', '2024-09-08', 1, NULL, NULL),
(120, 21, 'Lim Kok Sing', '090729041244', '2024-09-08', 2, NULL, NULL),
(121, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-08', 1, NULL, NULL),
(122, 23, 'Mujahid bin Awang', '100926071231', '2024-09-09', 3, NULL, NULL),
(123, 19, 'Munir bin Jimin', '090215050765', '2024-09-09', 1, NULL, NULL),
(124, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-09', 3, NULL, NULL),
(125, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-09', 1, NULL, NULL),
(126, 22, 'Sophea binti Pia', '100321091244', '2024-09-09', 1, NULL, NULL),
(127, 18, 'Vegeta Goku San', '090506101221', '2024-09-09', 4, NULL, NULL),
(128, 28, 'Aina binti Tahir', '110502043879', '2024-09-09', 4, NULL, NULL),
(129, 27, 'Ainani binti Tahir', '110502041988', '2024-09-09', 1, NULL, NULL),
(130, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-09', 1, NULL, NULL),
(131, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-09', 2, NULL, NULL),
(132, 26, 'Anis bin Bakar', '110929071298', '2024-09-09', 2, NULL, NULL),
(133, 10, 'Chan Tan Kiong', '070312056789', '2024-09-09', 1, NULL, NULL),
(134, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-09', 1, NULL, NULL),
(135, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-09', 1, NULL, NULL),
(136, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-09', 4, NULL, NULL),
(137, 25, 'Intan bin Hafiz', '101114021026', '2024-09-09', 1, NULL, NULL),
(138, 16, 'Izzah bin Eman', '080911031202', '2024-09-09', 1, NULL, NULL),
(139, 20, 'Lee Sana Sini', '090712031257', '2024-09-09', 1, NULL, NULL),
(140, 21, 'Lim Kok Sing', '090729041244', '2024-09-09', 3, NULL, NULL),
(141, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-09', 1, NULL, NULL),
(142, 23, 'Mujahid bin Awang', '100926071231', '2024-09-10', 1, NULL, NULL),
(143, 19, 'Munir bin Jimin', '090215050765', '2024-09-10', 1, NULL, NULL),
(144, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-10', 3, NULL, NULL),
(145, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-10', 1, NULL, NULL),
(146, 22, 'Sophea binti Pia', '100321091244', '2024-09-10', 3, NULL, NULL),
(147, 18, 'Vegeta Goku San', '090506101221', '2024-09-10', 3, NULL, NULL),
(148, 28, 'Aina binti Tahir', '110502043879', '2024-09-10', 1, NULL, NULL),
(149, 27, 'Ainani binti Tahir', '110502041988', '2024-09-10', 1, NULL, NULL),
(150, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-10', 1, NULL, NULL),
(151, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-10', 1, NULL, NULL),
(152, 26, 'Anis bin Bakar', '110929071298', '2024-09-10', 1, NULL, NULL),
(153, 10, 'Chan Tan Kiong', '070312056789', '2024-09-10', 1, NULL, NULL),
(154, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-10', 1, NULL, NULL),
(155, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-10', 1, NULL, NULL),
(156, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-10', 1, NULL, NULL),
(157, 25, 'Intan bin Hafiz', '101114021026', '2024-09-10', 1, NULL, NULL),
(158, 16, 'Izzah bin Eman', '080911031202', '2024-09-10', 1, NULL, NULL),
(159, 20, 'Lee Sana Sini', '090712031257', '2024-09-10', 1, NULL, NULL),
(160, 21, 'Lim Kok Sing', '090729041244', '2024-09-10', 1, NULL, NULL),
(161, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-10', 1, NULL, NULL),
(162, 23, 'Mujahid bin Awang', '100926071231', '2024-09-11', 1, NULL, NULL),
(163, 19, 'Munir bin Jimin', '090215050765', '2024-09-11', 1, NULL, NULL),
(164, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-11', 1, NULL, NULL),
(165, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-11', 1, NULL, NULL),
(166, 22, 'Sophea binti Pia', '100321091244', '2024-09-11', 1, NULL, NULL),
(167, 18, 'Vegeta Goku San', '090506101221', '2024-09-11', 1, NULL, NULL),
(168, 28, 'Aina binti Tahir', '110502043879', '2024-09-11', 1, NULL, NULL),
(169, 27, 'Ainani binti Tahir', '110502041988', '2024-09-11', 1, NULL, NULL),
(170, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-11', 1, NULL, NULL),
(171, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-11', 4, NULL, NULL),
(172, 26, 'Anis bin Bakar', '110929071298', '2024-09-11', 1, NULL, NULL),
(173, 10, 'Chan Tan Kiong', '070312056789', '2024-09-11', 4, NULL, NULL),
(174, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-11', 1, NULL, NULL),
(175, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-11', 1, NULL, NULL),
(176, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-11', 1, NULL, NULL),
(177, 25, 'Intan bin Hafiz', '101114021026', '2024-09-11', 1, NULL, NULL),
(178, 16, 'Izzah bin Eman', '080911031202', '2024-09-11', 1, NULL, NULL),
(179, 20, 'Lee Sana Sini', '090712031257', '2024-09-11', 2, NULL, NULL),
(180, 21, 'Lim Kok Sing', '090729041244', '2024-09-11', 1, NULL, NULL),
(181, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-11', 1, NULL, NULL),
(182, 23, 'Mujahid bin Awang', '100926071231', '2024-09-12', 1, NULL, NULL),
(183, 19, 'Munir bin Jimin', '090215050765', '2024-09-12', 3, NULL, NULL),
(184, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-12', 1, NULL, NULL),
(185, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-12', 1, NULL, NULL),
(186, 22, 'Sophea binti Pia', '100321091244', '2024-09-12', 4, NULL, NULL),
(187, 18, 'Vegeta Goku San', '090506101221', '2024-09-12', 4, NULL, NULL),
(188, 28, 'Aina binti Tahir', '110502043879', '2024-09-12', 4, NULL, NULL),
(189, 27, 'Ainani binti Tahir', '110502041988', '2024-09-12', 4, NULL, NULL),
(190, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-12', 4, NULL, NULL),
(191, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-12', 1, NULL, NULL),
(192, 26, 'Anis bin Bakar', '110929071298', '2024-09-12', 3, NULL, NULL),
(193, 10, 'Chan Tan Kiong', '070312056789', '2024-09-12', 3, NULL, NULL),
(194, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-12', 1, NULL, NULL),
(195, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-12', 1, NULL, NULL),
(196, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-12', 1, NULL, NULL),
(197, 25, 'Intan bin Hafiz', '101114021026', '2024-09-12', 1, NULL, NULL),
(198, 16, 'Izzah bin Eman', '080911031202', '2024-09-12', 1, NULL, NULL),
(199, 20, 'Lee Sana Sini', '090712031257', '2024-09-12', 1, NULL, NULL),
(200, 21, 'Lim Kok Sing', '090729041244', '2024-09-12', 1, NULL, NULL),
(201, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-12', 1, NULL, NULL),
(202, 23, 'Mujahid bin Awang', '100926071231', '2024-09-15', 1, NULL, NULL),
(203, 19, 'Munir bin Jimin', '090215050765', '2024-09-15', 1, NULL, NULL),
(204, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-15', 1, NULL, NULL),
(205, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-15', 4, NULL, NULL),
(206, 22, 'Sophea binti Pia', '100321091244', '2024-09-15', 4, NULL, NULL),
(207, 18, 'Vegeta Goku San', '090506101221', '2024-09-15', 3, NULL, NULL),
(208, 28, 'Aina binti Tahir', '110502043879', '2024-09-15', 3, NULL, NULL),
(209, 27, 'Ainani binti Tahir', '110502041988', '2024-09-15', 3, NULL, NULL),
(210, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-15', 1, NULL, NULL),
(211, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-15', 1, NULL, NULL),
(212, 26, 'Anis bin Bakar', '110929071298', '2024-09-15', 1, NULL, NULL),
(213, 10, 'Chan Tan Kiong', '070312056789', '2024-09-15', 1, NULL, NULL),
(214, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-15', 1, NULL, NULL),
(215, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-15', 2, NULL, NULL),
(216, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-15', 4, NULL, NULL),
(217, 25, 'Intan bin Hafiz', '101114021026', '2024-09-15', 4, NULL, NULL),
(218, 16, 'Izzah bin Eman', '080911031202', '2024-09-15', 1, NULL, NULL),
(219, 20, 'Lee Sana Sini', '090712031257', '2024-09-15', 1, NULL, NULL),
(220, 21, 'Lim Kok Sing', '090729041244', '2024-09-15', 1, NULL, NULL),
(221, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-15', 1, NULL, NULL),
(222, 23, 'Mujahid bin Awang', '100926071231', '2024-09-16', 1, NULL, NULL),
(223, 19, 'Munir bin Jimin', '090215050765', '2024-09-16', 1, NULL, NULL),
(224, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-16', 1, NULL, NULL),
(225, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-16', 1, NULL, NULL),
(226, 22, 'Sophea binti Pia', '100321091244', '2024-09-16', 1, NULL, NULL),
(227, 18, 'Vegeta Goku San', '090506101221', '2024-09-16', 1, NULL, NULL),
(228, 28, 'Aina binti Tahir', '110502043879', '2024-09-16', 1, NULL, NULL),
(229, 27, 'Ainani binti Tahir', '110502041988', '2024-09-16', 1, NULL, NULL),
(230, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-16', 1, NULL, NULL),
(231, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-16', 1, NULL, NULL),
(232, 26, 'Anis bin Bakar', '110929071298', '2024-09-16', 1, NULL, NULL),
(233, 10, 'Chan Tan Kiong', '070312056789', '2024-09-16', 1, NULL, NULL),
(234, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-16', 2, NULL, NULL),
(235, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-16', 1, NULL, NULL),
(236, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-16', 1, NULL, NULL),
(237, 25, 'Intan bin Hafiz', '101114021026', '2024-09-16', 2, NULL, NULL),
(238, 16, 'Izzah bin Eman', '080911031202', '2024-09-16', 3, NULL, NULL),
(239, 20, 'Lee Sana Sini', '090712031257', '2024-09-16', 3, NULL, NULL),
(240, 21, 'Lim Kok Sing', '090729041244', '2024-09-16', 1, NULL, NULL),
(241, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-16', 4, NULL, NULL),
(242, 23, 'Mujahid bin Awang', '100926071231', '2024-09-17', 2, NULL, NULL),
(243, 19, 'Munir bin Jimin', '090215050765', '2024-09-17', 2, NULL, NULL),
(244, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-17', 4, NULL, NULL),
(245, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-17', 4, NULL, NULL),
(246, 22, 'Sophea binti Pia', '100321091244', '2024-09-17', 1, NULL, NULL),
(247, 18, 'Vegeta Goku San', '090506101221', '2024-09-17', 1, NULL, NULL),
(248, 28, 'Aina binti Tahir', '110502043879', '2024-09-17', 1, NULL, NULL),
(249, 27, 'Ainani binti Tahir', '110502041988', '2024-09-17', 1, NULL, NULL),
(250, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-17', 1, NULL, NULL),
(251, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-17', 1, NULL, NULL),
(252, 26, 'Anis bin Bakar', '110929071298', '2024-09-17', 2, NULL, NULL),
(253, 10, 'Chan Tan Kiong', '070312056789', '2024-09-17', 1, NULL, NULL),
(254, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-17', 1, NULL, NULL),
(255, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-17', 1, NULL, NULL),
(256, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-17', 1, NULL, NULL),
(257, 25, 'Intan bin Hafiz', '101114021026', '2024-09-17', 3, NULL, NULL),
(258, 16, 'Izzah bin Eman', '080911031202', '2024-09-17', 1, NULL, NULL),
(259, 20, 'Lee Sana Sini', '090712031257', '2024-09-17', 1, NULL, NULL),
(260, 21, 'Lim Kok Sing', '090729041244', '2024-09-17', 1, NULL, NULL),
(261, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-17', 1, NULL, NULL),
(262, 23, 'Mujahid bin Awang', '100926071231', '2024-09-18', 4, NULL, NULL),
(263, 19, 'Munir bin Jimin', '090215050765', '2024-09-18', 4, NULL, NULL),
(264, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-18', 1, NULL, NULL),
(265, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-18', 1, NULL, NULL),
(266, 22, 'Sophea binti Pia', '100321091244', '2024-09-18', 3, NULL, NULL),
(267, 18, 'Vegeta Goku San', '090506101221', '2024-09-18', 1, NULL, NULL),
(268, 28, 'Aina binti Tahir', '110502043879', '2024-09-18', 1, NULL, NULL),
(269, 27, 'Ainani binti Tahir', '110502041988', '2024-09-18', 1, NULL, NULL),
(270, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-18', 1, NULL, NULL),
(271, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-18', 1, NULL, NULL),
(272, 26, 'Anis bin Bakar', '110929071298', '2024-09-18', 1, NULL, NULL),
(273, 10, 'Chan Tan Kiong', '070312056789', '2024-09-18', 1, NULL, NULL),
(274, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-18', 1, NULL, NULL),
(275, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-18', 1, NULL, NULL),
(276, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-18', 1, NULL, NULL),
(277, 25, 'Intan bin Hafiz', '101114021026', '2024-09-18', 1, NULL, NULL),
(278, 16, 'Izzah bin Eman', '080911031202', '2024-09-18', 1, NULL, NULL),
(279, 20, 'Lee Sana Sini', '090712031257', '2024-09-18', 1, NULL, NULL),
(280, 21, 'Lim Kok Sing', '090729041244', '2024-09-18', 1, NULL, NULL),
(281, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-18', 1, NULL, NULL),
(282, 23, 'Mujahid bin Awang', '100926071231', '2024-09-19', 1, NULL, NULL),
(283, 19, 'Munir bin Jimin', '090215050765', '2024-09-19', 1, NULL, NULL),
(284, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-19', 1, NULL, NULL),
(285, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-19', 1, NULL, NULL),
(286, 22, 'Sophea binti Pia', '100321091244', '2024-09-19', 1, NULL, NULL),
(287, 18, 'Vegeta Goku San', '090506101221', '2024-09-19', 1, NULL, NULL),
(288, 28, 'Aina binti Tahir', '110502043879', '2024-09-19', 1, NULL, NULL),
(289, 27, 'Ainani binti Tahir', '110502041988', '2024-09-19', 2, NULL, NULL),
(290, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-19', 1, NULL, NULL),
(291, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-19', 4, NULL, NULL),
(292, 26, 'Anis bin Bakar', '110929071298', '2024-09-19', 1, NULL, NULL),
(293, 10, 'Chan Tan Kiong', '070312056789', '2024-09-19', 3, NULL, NULL),
(294, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-19', 1, NULL, NULL),
(295, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-19', 4, NULL, NULL),
(296, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-19', 1, NULL, NULL),
(297, 25, 'Intan bin Hafiz', '101114021026', '2024-09-19', 1, NULL, NULL),
(298, 16, 'Izzah bin Eman', '080911031202', '2024-09-19', 1, NULL, NULL),
(299, 20, 'Lee Sana Sini', '090712031257', '2024-09-19', 1, NULL, NULL),
(300, 21, 'Lim Kok Sing', '090729041244', '2024-09-19', 1, NULL, NULL),
(301, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-19', 1, NULL, NULL),
(302, 23, 'Mujahid bin Awang', '100926071231', '2024-09-22', 3, NULL, NULL),
(303, 19, 'Munir bin Jimin', '090215050765', '2024-09-22', 1, NULL, NULL),
(304, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-22', 3, NULL, NULL),
(305, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-22', 1, NULL, NULL),
(306, 22, 'Sophea binti Pia', '100321091244', '2024-09-22', 1, NULL, NULL),
(307, 18, 'Vegeta Goku San', '090506101221', '2024-09-22', 1, NULL, NULL),
(308, 28, 'Aina binti Tahir', '110502043879', '2024-09-22', 1, NULL, NULL),
(309, 27, 'Ainani binti Tahir', '110502041988', '2024-09-22', 1, NULL, NULL),
(310, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-22', 2, NULL, NULL),
(311, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-22', 1, NULL, NULL),
(312, 26, 'Anis bin Bakar', '110929071298', '2024-09-22', 1, NULL, NULL),
(313, 10, 'Chan Tan Kiong', '070312056789', '2024-09-22', 1, NULL, NULL),
(314, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-22', 4, NULL, NULL),
(315, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-22', 1, NULL, NULL),
(316, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-22', 1, NULL, NULL),
(317, 25, 'Intan bin Hafiz', '101114021026', '2024-09-22', 4, NULL, NULL),
(318, 16, 'Izzah bin Eman', '080911031202', '2024-09-22', 3, NULL, NULL),
(319, 20, 'Lee Sana Sini', '090712031257', '2024-09-22', 1, NULL, NULL),
(320, 21, 'Lim Kok Sing', '090729041244', '2024-09-22', 1, NULL, NULL),
(321, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-22', 1, NULL, NULL),
(322, 23, 'Mujahid bin Awang', '100926071231', '2024-09-23', 3, NULL, NULL),
(323, 19, 'Munir bin Jimin', '090215050765', '2024-09-23', 1, NULL, NULL),
(324, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-23', 1, NULL, NULL),
(325, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-23', 4, NULL, NULL),
(326, 22, 'Sophea binti Pia', '100321091244', '2024-09-23', 1, NULL, NULL),
(327, 18, 'Vegeta Goku San', '090506101221', '2024-09-23', 2, NULL, NULL),
(328, 28, 'Aina binti Tahir', '110502043879', '2024-09-23', 1, NULL, NULL),
(329, 27, 'Ainani binti Tahir', '110502041988', '2024-09-23', 2, NULL, NULL),
(330, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-23', 3, NULL, NULL),
(331, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-23', 1, NULL, NULL),
(332, 26, 'Anis bin Bakar', '110929071298', '2024-09-23', 4, NULL, NULL),
(333, 10, 'Chan Tan Kiong', '070312056789', '2024-09-23', 1, NULL, NULL),
(334, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-23', 1, NULL, NULL),
(335, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-23', 1, NULL, NULL),
(336, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-23', 1, NULL, NULL),
(337, 25, 'Intan bin Hafiz', '101114021026', '2024-09-23', 1, NULL, NULL),
(338, 16, 'Izzah bin Eman', '080911031202', '2024-09-23', 1, NULL, NULL),
(339, 20, 'Lee Sana Sini', '090712031257', '2024-09-23', 4, NULL, NULL),
(340, 21, 'Lim Kok Sing', '090729041244', '2024-09-23', 1, NULL, NULL),
(341, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-23', 4, NULL, NULL),
(342, 23, 'Mujahid bin Awang', '100926071231', '2024-09-24', 1, NULL, NULL),
(343, 19, 'Munir bin Jimin', '090215050765', '2024-09-24', 1, NULL, NULL),
(344, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-24', 1, NULL, NULL),
(345, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-24', 2, NULL, NULL),
(346, 22, 'Sophea binti Pia', '100321091244', '2024-09-24', 1, NULL, NULL),
(347, 18, 'Vegeta Goku San', '090506101221', '2024-09-24', 2, NULL, NULL),
(348, 28, 'Aina binti Tahir', '110502043879', '2024-09-24', 2, NULL, NULL),
(349, 27, 'Ainani binti Tahir', '110502041988', '2024-09-24', 1, NULL, NULL),
(350, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-24', 4, NULL, NULL),
(351, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-24', 1, NULL, NULL),
(352, 26, 'Anis bin Bakar', '110929071298', '2024-09-24', 1, NULL, NULL),
(353, 10, 'Chan Tan Kiong', '070312056789', '2024-09-24', 1, NULL, NULL),
(354, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-24', 1, NULL, NULL),
(355, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-24', 1, NULL, NULL),
(356, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-24', 3, NULL, NULL),
(357, 25, 'Intan bin Hafiz', '101114021026', '2024-09-24', 1, NULL, NULL),
(358, 16, 'Izzah bin Eman', '080911031202', '2024-09-24', 1, NULL, NULL),
(359, 20, 'Lee Sana Sini', '090712031257', '2024-09-24', 1, NULL, NULL),
(360, 21, 'Lim Kok Sing', '090729041244', '2024-09-24', 4, NULL, NULL),
(361, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-24', 1, NULL, NULL),
(362, 23, 'Mujahid bin Awang', '100926071231', '2024-09-25', 1, NULL, NULL),
(363, 19, 'Munir bin Jimin', '090215050765', '2024-09-25', 4, NULL, NULL),
(364, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-25', 1, NULL, NULL),
(365, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-25', 1, NULL, NULL),
(366, 22, 'Sophea binti Pia', '100321091244', '2024-09-25', 1, NULL, NULL),
(367, 18, 'Vegeta Goku San', '090506101221', '2024-09-25', 2, NULL, NULL),
(368, 28, 'Aina binti Tahir', '110502043879', '2024-09-25', 1, NULL, NULL),
(369, 27, 'Ainani binti Tahir', '110502041988', '2024-09-25', 3, NULL, NULL),
(370, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-25', 1, NULL, NULL),
(371, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-25', 1, NULL, NULL),
(372, 26, 'Anis bin Bakar', '110929071298', '2024-09-25', 1, NULL, NULL),
(373, 10, 'Chan Tan Kiong', '070312056789', '2024-09-25', 3, NULL, NULL),
(374, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-25', 1, NULL, NULL),
(375, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-25', 1, NULL, NULL),
(376, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-25', 1, NULL, NULL),
(377, 25, 'Intan bin Hafiz', '101114021026', '2024-09-25', 1, NULL, NULL),
(378, 16, 'Izzah bin Eman', '080911031202', '2024-09-25', 1, NULL, NULL),
(379, 20, 'Lee Sana Sini', '090712031257', '2024-09-25', 1, NULL, NULL),
(380, 21, 'Lim Kok Sing', '090729041244', '2024-09-25', 1, NULL, NULL),
(381, 24, 'Mohd Aman bin Anma', '101231064597', '2024-09-25', 4, NULL, NULL),
(382, 23, 'Mujahid bin Awang', '100926071231', '2024-09-26', 1, NULL, NULL),
(383, 19, 'Munir bin Jimin', '090215050765', '2024-09-26', 1, NULL, NULL),
(384, 13, 'Nur Ain binti Hamdan', '070101072244', '2024-09-26', 1, NULL, NULL),
(385, 14, 'Nurul Alya binti Ali', '080808085678', '2024-09-26', 1, NULL, NULL),
(386, 22, 'Sophea binti Pia', '100321091244', '2024-09-26', 1, NULL, NULL),
(387, 18, 'Vegeta Goku San', '090506101221', '2024-09-26', 1, NULL, NULL),
(388, 28, 'Aina binti Tahir', '110502043879', '2024-09-26', 2, NULL, NULL),
(389, 27, 'Ainani binti Tahir', '110502041988', '2024-09-26', 1, NULL, NULL),
(390, 29, 'Ainur binti Khaleed', '1107088142', '2024-09-26', 4, NULL, NULL),
(391, 17, 'Andrew A/L Palawan', '080417147653', '2024-09-26', 1, NULL, NULL),
(392, 26, 'Anis bin Bakar', '110929071298', '2024-09-26', 1, NULL, NULL),
(393, 10, 'Chan Tan Kiong', '070312056789', '2024-09-26', 3, NULL, NULL),
(394, 11, 'Faez Bin Zakaria', '071203041233', '2024-09-26', 1, NULL, NULL),
(395, 15, 'Hadi bin Firdaus', '080315079057', '2024-09-26', 1, NULL, NULL),
(396, 12, 'Ieman bin Abdullah', '070611090987', '2024-09-26', 1, NULL, NULL),
(397, 25, 'Intan bin Hafiz', '101114021026', '2024-09-26', 1, NULL, NULL),
(398, 16, 'Izzah bin Eman', '080911031202', '2024-09-26', 1, NULL, NULL),
(399, 20, 'Lee Sana Sini', '090712031257', '2024-09-26', 4, NULL, NULL),
(400, 21, 'Lim Kok Sing', '090729041244', '2024-09-26', 1, NULL, NULL),
(408, 28, 'Aina binti Tahir', '110502043879', '2024-09-26', 4, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=428;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
