-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2022 at 12:39 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hiring_portal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_08_29_171108_create_quizzes_table', 2),
(6, '2022_08_29_171117_create_questions_table', 2),
(7, '2022_08_30_060506_create_quiz_submissions_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` int(11) NOT NULL,
  `quiz_id` bigint(20) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `options`, `answer`, `quiz_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Capital of Bangladesh?', '[\"Dhaka\",\"Barishal\",\"Khulna\",\"Jhalokati\"]', 1, 1, NULL, NULL, NULL),
(2, 'Bangladeshi Currency is?', '[\"Taka\",\"Dollar\",\"Rupe\",\"Rubel\"]', 1, 1, NULL, NULL, NULL),
(3, 'ইউনাইটেড কিংডোম -এ ভারতের পরবর্তী হাই কমিশনার পদে কে নিযুক্ত হয়েছেন?', '[\"\\u0985\\u0996\\u09bf\\u09b2\\u09c7\\u09b6 \\u09ae\\u09bf\\u09b6\\u09cd\\u09b0\\u09be\",\"\\u09ac\\u09bf\\u0995\\u09cd\\u09b0\\u09ae \\u09a1\\u09b0\\u09be\\u0987\\u09b8\\u09cd\\u09ac\\u09be\\u09ae\\u09c0\",\"\\u09ae\\u09a8\\u09cb\\u099c \\u0995\\u09c1\\u09ae\\u09be\\u09b0 \\u09ad\\u09be\\u09b0\\u09a4\\u09c0\",\"\\u09aa\\u09cd\\u09b0\\u09b6\\u09be\\u09a8\\u09cd\\u09a4 \\u09aa\\u09bf\\u09b7\\u09c7\"]', 2, 3, NULL, NULL, '2022-08-29 13:25:50'),
(4, 'সম্প্রতি, James Webb Space Telescope কোন গ্রহের চিত্র ক্যাপচার করেছে?', '[\"\\u09ae\\u0999\\u09cd\\u0997\\u09b2\",\"\\u09ac\\u09c1\\u09a7\",\"\\u09ac\\u09c3\\u09b9\\u09b8\\u09cd\\u09aa\\u09a4\\u09bf\",\"\\u09b6\\u09a8\\u09bf\"]', 3, 3, NULL, NULL, '2022-08-29 13:25:50'),
(5, '‘World Water Week 2022’ -এর থীম কী?', '[\"Global collaboration for water\",\"Seeing the Unseen: The Value of Water\",\"Biodiversity and climate change\",\"Transforming the global water challenges\"]', 2, 3, NULL, NULL, '2022-08-29 13:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `description`, `user_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Test Quiz 1', NULL, 1, 1, NULL, '2022-08-29 11:47:42', '2022-08-29 13:27:40'),
(3, 'Test Quiz 2', NULL, 1, 1, NULL, '2022-08-29 11:56:28', '2022-08-29 11:56:28'),
(5, 'Test Quiz 3', NULL, 1, 1, '2022-08-30 04:38:19', '2022-08-30 04:33:22', '2022-08-30 04:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `quiz_id` bigint(20) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `answers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_submissions`
--

INSERT INTO `quiz_submissions` (`id`, `user_id`, `quiz_id`, `total_marks`, `answers`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 8, 3, 1, '[{\"answer\":\"\\u09ac\\u09bf\\u0995\\u09cd\\u09b0\\u09ae \\u09a1\\u09b0\\u09be\\u0987\\u09b8\\u09cd\\u09ac\\u09be\\u09ae\\u09c0\",\"mark\":1,\"std_answer\":\"2\"},{\"answer\":\"\\u09ac\\u09c3\\u09b9\\u09b8\\u09cd\\u09aa\\u09a4\\u09bf\",\"mark\":0,\"std_answer\":\"\"},{\"answer\":\"Seeing the Unseen: The Value of Water\",\"mark\":0,\"std_answer\":\"4\"}]', NULL, '2022-08-30 00:24:39', '2022-08-30 00:24:39'),
(5, 8, 1, 0, '[{\"answer\":\"Dhaka\",\"mark\":0,\"std_answer\":\"\"},{\"answer\":\"Taka\",\"mark\":0,\"std_answer\":\"\"}]', NULL, '2022-08-30 00:49:30', '2022-08-30 00:49:30'),
(6, 9, 3, 0, '[{\"answer\":\"\\u09ac\\u09bf\\u0995\\u09cd\\u09b0\\u09ae \\u09a1\\u09b0\\u09be\\u0987\\u09b8\\u09cd\\u09ac\\u09be\\u09ae\\u09c0\",\"mark\":0,\"std_answer\":\"\"},{\"answer\":\"\\u09ac\\u09c3\\u09b9\\u09b8\\u09cd\\u09aa\\u09a4\\u09bf\",\"mark\":0,\"std_answer\":\"\"},{\"answer\":\"Seeing the Unseen: The Value of Water\",\"mark\":0,\"std_answer\":\"\"}]', NULL, '2022-08-30 01:00:48', '2022-08-30 01:00:48'),
(8, 9, 1, 2, '[{\"answer\":\"Dhaka\",\"mark\":1,\"std_answer\":\"1\"},{\"answer\":\"Taka\",\"mark\":1,\"std_answer\":\"1\"}]', NULL, '2022-08-30 01:53:08', '2022-08-30 01:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cv_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `cv_link`, `is_admin`, `status`, `email_verified_at`, `password`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Aftab uddin Arif', 'aftabuddin', 'aftabuddin6222@gmail.com', '01787206222', NULL, 1, 1, NULL, '$2y$10$EgILXwkCZ4z4/Zmj40SZ3O0El8foMSnlkAmaaTiKxdT3cf84N7bLG', 'yO3sUJCySRzO8SQbdCxPVkGHHYgmqDkNl5YJ4EstiGZWXUsTYKwVpofi1aH2', NULL, '2022-08-28 09:47:09', '2022-08-28 12:44:05'),
(8, 'Developer Aftab', NULL, 'developeraftab6222@gmail.com', '01787206222', 'http://localhost/own/prictice/hiring-portal/register', 0, 1, NULL, '$2y$10$p5FT2NfOA5lqWiuk06BqBOdWG2pV7hRvWPs3dqoplr3mU/qvGri3S', NULL, NULL, '2022-08-28 23:27:24', '2022-08-29 02:38:03'),
(9, 'Arif Hossen', NULL, 'arifhossen6222@gmail.com', '01787206222', 'http://localhost/own/prictice/hiring-portal/register', 0, 1, NULL, '$2y$10$XkbYQwwMS49IxBemh0VWpuDz95QkBAQijivftJYCMxA/V6jCVGfaa', NULL, NULL, '2022-08-30 00:58:35', '2022-08-30 00:59:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
