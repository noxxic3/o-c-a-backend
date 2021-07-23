-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 23, 2021 at 03:07 AM
-- Server version: 8.0.20
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tfg_obesity_control_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `admins_role_name_foreign` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`user_id`, `role_name`, `created_at`, `updated_at`) VALUES
(36, 'Admin', '2020-12-12 05:44:48', '2020-12-12 05:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `diets`
--

DROP TABLE IF EXISTS `diets`;
CREATE TABLE IF NOT EXISTS `diets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diets`
--

INSERT INTO `diets` (`id`, `image`, `name`, `description`) VALUES
(1, '1_1608652944.jpg', 'Low-Calorie Diet (LCD)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet ipsum commodo, laoreet elit nec, blandit nisl. Nam rhoncus pretium mauris non iaculis. Sed egestas rhoncus tempor. Nam mollis viverra elementum. Sed blandit turpis ac nunc efficitur, at dictum nibh tincidunt. Aliquam placerat cursus metus, quis maximus sem tempor ac. Quisque congue egestas nulla quis sodales. Quisque eget orci eleifend, consequat velit eget, dictum odio. Duis blandit eleifend pellentesque. \r\nIn lacinia rutrum urna non varius. Aenean non bibendum orci. Sed cursus lacus lectus, in tincidunt elit sagittis tempus. Praesent posuere, nibh eget viverra lacinia, urna nisi vulputate massa, eget facilisis velit nibh vitae augue. Praesent luctus dui arcu.'),
(2, '2_1608652991.jpg', 'Very Low-Calorie Diet (VLCD)', 'Vivamus eros purus, eleifend ut dolor ullamcorper, condimentum varius turpis. Aenean justo nulla, venenatis sit amet tellus sit amet, euismod feugiat libero. In consequat, ipsum vel dapibus efficitur, lacus erat hendrerit quam, nec bibendum ligula neque id justo. Vivamus convallis laoreet sagittis. In hac habitasse platea dictumst. Aenean libero metus, ullamcorper in nisl eu, vestibulum porta arcu. Praesent id elementum mauris, vel dignissim magna. Mauris tincidunt arcu quis pretium porta. Nullam aliquam ex lacus, ut rutrum nisi suscipit vitae.'),
(3, '3_1609347344.jpg', 'Very low energy diet (VLED)', 'Nam tempor sodales porta. In eget consequat neque. Quisque cursus nunc et tempor sagittis. Curabitur sed lectus ac leo convallis rhoncus. Ut ullamcorper tincidunt urna eget auctor. Quisque nec velit sapien. Ut nec nibh a urna elementum rhoncus ut pellentesque lectus. Cras mi ipsum, molestie quis diam elementum, efficitur facilisis erat. Donec ex purus, suscipit a ultricies sit amet, auctor nec odio.'),
(4, '4_1609347384.jpg', 'Low energy diets (LED)', 'Sed consequat interdum turpis a vehicula. Maecenas euismod libero odio. Aenean in pretium orci. Donec sed viverra neque. Vivamus maximus eros purus. Curabitur vel lacus sed dolor faucibus malesuada sit amet a leo. Etiam porta odio sed mi elementum gravida. Proin dui dolor, viverra vitae congue vel, sollicitudin eu nulla. Nulla non odio facilisis arcu pulvinar dapibus. Aenean molestie magna et ligula viverra ullamcorper.');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `user_id` bigint UNSIGNED NOT NULL,
  `speciality` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `doctors_role_name_foreign` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`user_id`, `speciality`, `role_name`, `created_at`, `updated_at`) VALUES
(35, 'Surgeon', 'Doctor', '2020-12-10 08:08:14', '2020-12-10 08:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

DROP TABLE IF EXISTS `medications`;
CREATE TABLE IF NOT EXISTS `medications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posology` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medications`
--

INSERT INTO `medications` (`id`, `image`, `name`, `posology`) VALUES
(1, '1_1608651994.jpg', 'Diethylpropion', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet ipsum commodo, laoreet elit nec, blandit nisl. Nam rhoncus pretium mauris non iaculis. Sed egestas rhoncus tempor. Nam mollis viverra elementum. Sed blandit turpis ac nunc efficitur, at dictum nibh tincidunt. Aliquam placerat cursus metus, quis maximus sem tempor ac. Quisque congue egestas nulla quis sodales. Quisque eget orci eleifend, consequat velit eget, dictum odio. Duis blandit eleifend pellentesque. In lacinia rutrum urna non varius. Aenean non bibendum orci. Sed cursus lacus lectus, in tincidunt elit sagittis tempus. Praesent posuere, nibh eget viverra lacinia, urna nisi vulputate massa, eget facilisis velit nibh vitae augue. Praesent luctus dui arcu.'),
(2, '2_1608652472.jpg', 'Lorcaserin', 'Vivamus eros purus, eleifend ut dolor ullamcorper, condimentum varius turpis. Aenean justo nulla, venenatis sit amet tellus sit amet, euismod feugiat libero. In consequat, ipsum vel dapibus efficitur, lacus erat hendrerit quam, nec bibendum ligula neque id justo. Vivamus convallis laoreet sagittis. In hac habitasse platea dictumst. Aenean libero metus, ullamcorper in nisl eu, vestibulum porta arcu. Praesent id elementum mauris, vel dignissim magna. Mauris tincidunt arcu quis pretium porta. Nullam aliquam ex lacus, ut rutrum nisi suscipit vitae.'),
(3, '3_1608654278.jpg', 'Phentermine', 'Nam tempor sodales porta. In eget consequat neque. Quisque cursus nunc et tempor sagittis. Curabitur sed lectus ac leo convallis rhoncus. Ut ullamcorper tincidunt urna eget auctor. Quisque nec velit sapien. Ut nec nibh a urna elementum rhoncus ut pellentesque lectus. Cras mi ipsum, molestie quis diam elementum, efficitur facilisis erat. Donec ex purus, suscipit a ultricies sit amet, auctor nec odio.'),
(4, '4_1608654288.jpg', 'Naltrexone', 'Sed consequat interdum turpis a vehicula. Maecenas euismod libero odio. Aenean in pretium orci. Donec sed viverra neque. Vivamus maximus eros purus. Curabitur vel lacus sed dolor faucibus malesuada sit amet a leo. Etiam porta odio sed mi elementum gravida. Proin dui dolor, viverra vitae congue vel, sollicitudin eu nulla. Nulla non odio facilisis arcu pulvinar dapibus. Aenean molestie magna et ligula viverra ullamcorper.');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2014_10_12_000000_create_users_table', 3),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_10_14_194944_create_xxxes_table', 1),
(5, '2020_11_06_133050_create_news_table', 2),
(7, '2020_11_07_163513_create_roles_table', 4),
(8, '2020_11_07_170156_create_patients_table', 5),
(9, '2020_11_07_190242_create_doctors_table', 6),
(10, '2020_11_07_190322_create_office_stacks_table', 6),
(11, '2020_11_07_190340_create_admins_table', 6),
(12, '2020_11_08_204555_create_diets_table', 7),
(13, '2020_11_08_204846_create_physical_activities_table', 7),
(14, '2020_11_08_205138_create_medications_table', 7),
(15, '2020_11_09_140230_create_patient_states_table', 8),
(16, '2020_11_09_171133_create_patient_treatments_table', 9),
(17, '2019_12_14_000001_create_personal_access_tokens_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `created_at`, `updated_at`, `name`, `category`, `image`, `description`) VALUES
(1, NULL, NULL, 'name A', 'category A', 'http://localhost/8_TFG/ObesityControlApp/public/images/visceral_fat_analyzer.png', 'description A'),
(2, '2020-11-06 16:17:41', '2020-11-06 16:17:41', 'name A', 'category A', 'http://localhost/8_TFG/ObesityControlApp/public/images/gastric_balloon.jpg  ', 'description A'),
(3, '2020-11-06 16:47:23', '2020-11-06 16:47:23', 'name A', 'category A', 'http://localhost/8_TFG/ObesityControlApp/public/images/danakil.jpg', 'description A');

-- --------------------------------------------------------

--
-- Table structure for table `office_stacks`
--

DROP TABLE IF EXISTS `office_stacks`;
CREATE TABLE IF NOT EXISTS `office_stacks` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `office_stacks_role_name_foreign` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office_stacks`
--

INSERT INTO `office_stacks` (`user_id`, `role_name`, `created_at`, `updated_at`) VALUES
(39, 'OfficeStack', '2020-12-16 18:17:06', '2020-12-16 18:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (
  `user_id` bigint UNSIGNED NOT NULL,
  `height` double(8,2) NOT NULL,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `patients_role_name_foreign` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`user_id`, `height`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 40.00, 'Patient', NULL, NULL),
(37, 40.03, 'Patient', '2020-12-12 16:14:15', '2020-12-12 16:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `patient_states`
--

DROP TABLE IF EXISTS `patient_states`;
CREATE TABLE IF NOT EXISTS `patient_states` (
  `patient_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `weight` double(8,2) NOT NULL,
  `IMC` double(8,2) NOT NULL,
  `muscle_mass` double(8,2) NOT NULL,
  `fat_mass` double(8,2) NOT NULL,
  `blood_pressure` double(8,2) DEFAULT NULL,
  `cholesterol` double(8,2) DEFAULT NULL,
  `checked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`patient_id`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_states`
--

INSERT INTO `patient_states` (`patient_id`, `date`, `weight`, `IMC`, `muscle_mass`, `fat_mass`, `blood_pressure`, `cholesterol`, `checked`) VALUES
(1, '2020-11-09', 60.00, 18.52, 33.00, 41.00, 79.00, 182.00, 1),
(1, '2020-10-09', 80.00, 24.69, 50.00, 42.00, 80.00, 240.00, 1),
(1, '2020-10-10', 20.20, 6.23, 13.00, 4.00, 60.00, 210.00, 1),
(1, '2021-01-02', 50.00, 15.43, 10.00, 1.00, 60.00, 180.00, 1),
(37, '2020-12-22', 20.00, 6.17, 10.00, 0.00, 60.00, 180.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient_treatments`
--

DROP TABLE IF EXISTS `patient_treatments`;
CREATE TABLE IF NOT EXISTS `patient_treatments` (
  `patient_id` bigint UNSIGNED NOT NULL,
  `patient_state_date` date NOT NULL,
  `treatment_date` date NOT NULL,
  `diet` bigint UNSIGNED DEFAULT NULL,
  `physical_activity` bigint UNSIGNED DEFAULT NULL,
  `medication` bigint UNSIGNED DEFAULT NULL,
  `observations` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`patient_id`,`patient_state_date`,`treatment_date`),
  KEY `patient_treatments_patient_state_date_foreign` (`patient_state_date`),
  KEY `patient_treatments_diet_foreign` (`diet`),
  KEY `patient_treatments_physical_activity_foreign` (`physical_activity`),
  KEY `patient_treatments_medication_foreign` (`medication`),
  KEY `patient_treatments_doctor_foreign` (`doctor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_treatments`
--

INSERT INTO `patient_treatments` (`patient_id`, `patient_state_date`, `treatment_date`, `diet`, `physical_activity`, `medication`, `observations`, `doctor`) VALUES
(1, '2020-10-09', '2020-12-22', 1, 1, 1, 'Observation A', 36),
(1, '2020-10-10', '2020-12-23', 2, 2, 2, 'Observation 2', 35),
(1, '2020-11-09', '2020-12-30', 3, 3, 3, 'Observation A', 35),
(1, '2021-01-02', '2021-01-02', 4, 1, 4, 'Observ1', 35);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=244 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `physical_activities`
--

DROP TABLE IF EXISTS `physical_activities`;
CREATE TABLE IF NOT EXISTS `physical_activities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `physical_activities`
--

INSERT INTO `physical_activities` (`id`, `image`, `name`, `description`) VALUES
(1, '1_1608652852.jpg', 'Cardio workout Level 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet ipsum commodo, laoreet elit nec, blandit nisl. Nam rhoncus pretium mauris non iaculis. Sed egestas rhoncus tempor. Nam mollis viverra elementum. Sed blandit turpis ac nunc efficitur, at dictum nibh tincidunt. Aliquam placerat cursus metus, quis maximus sem tempor ac. Quisque congue egestas nulla quis sodales. Quisque eget orci eleifend, consequat velit eget, dictum odio. Duis blandit eleifend pellentesque. In lacinia rutrum urna non varius. Aenean non bibendum orci. Sed cursus lacus lectus, in tincidunt elit sagittis tempus. Praesent posuere, nibh eget viverra lacinia, urna nisi vulputate massa, eget facilisis velit nibh vitae augue. Praesent luctus dui arcu.'),
(2, '2_1608660353.jpg', 'Cardio workout Level 2', 'Vivamus eros purus, eleifend ut dolor ullamcorper, condimentum varius turpis. Aenean justo nulla, venenatis sit amet tellus sit amet, euismod feugiat libero. In consequat, ipsum vel dapibus efficitur, lacus erat hendrerit quam, nec bibendum ligula neque id justo. Vivamus convallis laoreet sagittis. In hac habitasse platea dictumst. Aenean libero metus, ullamcorper in nisl eu, vestibulum porta arcu. Praesent id elementum mauris, vel dignissim magna. Mauris tincidunt arcu quis pretium porta. Nullam aliquam ex lacus, ut rutrum nisi suscipit vitae.'),
(3, '3_1609347269.jpg', 'Muscle mass Level 1', 'Nam tempor sodales porta. In eget consequat neque. Quisque cursus nunc et tempor sagittis. Curabitur sed lectus ac leo convallis rhoncus. Ut ullamcorper tincidunt urna eget auctor. Quisque nec velit sapien. Ut nec nibh a urna elementum rhoncus ut pellentesque lectus. Cras mi ipsum, molestie quis diam elementum, efficitur facilisis erat. Donec ex purus, suscipit a ultricies sit amet, auctor nec odio.');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`name`, `created_at`, `updated_at`) VALUES
('Patient', NULL, NULL),
('Doctor', NULL, NULL),
('OfficeStack', NULL, NULL),
('Admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surnames` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surnames`, `birthdate`, `image`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'patient A', 'surnames', '2020-12-16', '6_1606840137.png', 'patient_a@m', '2020-11-06 21:40:07', 'password_patientA', 'remember_token A', '2020-11-06 21:40:07', '2020-11-06 21:40:07'),
(37, 'patient B', 'surnames', '2020-12-22', '2_1607793255.png', 'patient_b@m', NULL, 'password_patientB', NULL, '2020-12-12 16:14:15', '2020-12-12 16:14:15'),
(39, 'office A', 'surnames', '2020-12-22', NULL, 'office_a@m', NULL, 'password_officeA', NULL, '2020-12-16 18:17:06', '2020-12-16 18:17:06'),
(36, 'admin A', 'surnames', '2020-12-08', NULL, 'admin_a@m', NULL, 'password_adminA', NULL, '2020-12-12 05:44:48', '2020-12-12 05:44:48'),
(35, 'doctor A', 'surnames', '2020-12-16', NULL, 'doctor_a@m', NULL, 'password_doctorA', NULL, '2020-12-10 08:08:14', '2020-12-10 08:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `xxxes`
--

DROP TABLE IF EXISTS `xxxes`;
CREATE TABLE IF NOT EXISTS `xxxes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `xxxes`
--

INSERT INTO `xxxes` (`id`, `created_at`, `updated_at`, `title`, `name`) VALUES
(1, NULL, '2020-11-13 04:55:24', 'rrrrrrrrrrrrrrrrrrrrrrr', '33333333333333333333'),
(3, '2020-10-15 19:12:53', '2020-11-13 04:56:28', '222222222222222222222222222', 'ooooooooooooooooo'),
(24, '2020-11-05 21:45:58', '2020-11-06 13:08:24', 'Fjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 'Flintstone');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
