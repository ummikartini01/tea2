-- Complete database export for Hostinger deployment
-- Run this in Hostinger phpMyAdmin
-- Generated: 2026-01-29 04:28:36

-- Table: failed_jobs
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- No data in table: failed_jobs


-- Table: migrations
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: migrations
INSERT INTO `migrations` VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_21_054241_add_role_to_users_table', 2),
(7, '2026_01_21_054919_create_teas_table', 3),
(8, '2026_01_21_055903_create_ratings_table', 4),
(9, '2026_01_21_060030_create_preferences_table', 4),
(10, '2026_01_21_054919_add_source_to_teas_table', 5),
(11, '2026_01_26_084229_add_description_to_ratings_table', 6),
(12, '2026_01_26_090458_create_weather_table', 7),
(13, '2026_01_26_090512_add_weather_preferences_to_preferences_table', 8),
(14, '2024_01_26_000001_create_recommendation_interactions_table', 9),
(16, '2026_01_28_125441_create_tea_timetables_table', 10);


-- Table: password_reset_tokens
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: password_reset_tokens
INSERT INTO `password_reset_tokens` VALUES
('ummikartini2004@gmail.com', '$2y$12$5UlBu02Z082ylqF6t8iQweZ.uswq8f.nGSZwfVaNFgDL/9UmeUUky', '2026-01-28 07:37:02');


-- Table: personal_access_tokens
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- No data in table: personal_access_tokens


-- Table: preferences
CREATE TABLE `preferences` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `preferred_flavor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preferred_caffeine` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `health_goal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `weather_based_recommendations` tinyint(1) NOT NULL DEFAULT '0',
  `weather_preference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preferences_user_id_foreign` (`user_id`),
  CONSTRAINT `preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: preferences
INSERT INTO `preferences` VALUES
(2, 2, 'floral', 'low', 'weight_loss', 'Malacca', NULL, NULL, NULL, 1, 'malaysian_hot_humid', '2026-01-21 10:38:49', '2026-01-29 01:42:07'),
(3, 4, 'floral', 'low', 'relax_calm', 'Malacca', NULL, NULL, NULL, 1, 'auto', '2026-01-28 08:41:42', '2026-01-28 08:52:39'),
(4, 5, 'sweet', 'high', 'relax_calm', 'Seremban', NULL, NULL, NULL, 1, 'malaysian_hot_humid', '2026-01-28 10:34:47', '2026-01-28 12:44:21');


-- Table: ratings
CREATE TABLE `ratings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tea_id` bigint unsigned NOT NULL,
  `rating` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_user_id_foreign` (`user_id`),
  KEY `ratings_tea_id_foreign` (`tea_id`),
  CONSTRAINT `ratings_tea_id_foreign` FOREIGN KEY (`tea_id`) REFERENCES `teas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: ratings
INSERT INTO `ratings` VALUES
(4, 2, 12, 4, NULL, '2026-01-21 20:10:49', '2026-01-26 08:20:57'),
(5, 2, 37, 4, 'It really good for my stomach', '2026-01-22 04:52:20', '2026-01-29 00:21:00'),
(6, 2, 33, 2, NULL, '2026-01-26 08:55:57', '2026-01-26 08:55:57'),
(8, 2, 53, 5, NULL, '2026-01-28 10:32:43', '2026-01-28 12:17:29'),
(9, 5, 5, 5, NULL, '2026-01-28 10:35:24', '2026-01-28 10:35:24'),
(11, 2, 9, 3, NULL, '2026-01-29 01:42:19', '2026-01-29 01:42:19');


-- Table: recommendation_interactions
CREATE TABLE `recommendation_interactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tea_id` bigint unsigned NOT NULL,
  `weather_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature` decimal(5,2) DEFAULT NULL,
  `humidity` decimal(5,2) DEFAULT NULL,
  `day_of_week` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_of_day` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `season` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_flavor_preference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_caffeine_preference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_health_goal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_weather_preference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint DEFAULT NULL,
  `algorithm_used` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidence_score` decimal(3,2) DEFAULT NULL,
  `prediction_score` decimal(3,2) DEFAULT NULL,
  `features` json DEFAULT NULL,
  `feature_importance` json DEFAULT NULL,
  `model_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recommendation_interactions_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `recommendation_interactions_tea_id_action_index` (`tea_id`,`action`),
  KEY `recommendation_interactions_weather_category_action_index` (`weather_category`,`action`),
  KEY `recommendation_interactions_algorithm_used_created_at_index` (`algorithm_used`,`created_at`),
  KEY `recommendation_interactions_created_at_index` (`created_at`),
  CONSTRAINT `recommendation_interactions_tea_id_foreign` FOREIGN KEY (`tea_id`) REFERENCES `teas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recommendation_interactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: recommendation_interactions
INSERT INTO `recommendation_interactions` VALUES
(1, 4, 5, 'hot', 26.97, 71.00, 'Wednesday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 09:00:10', '2026-01-28 09:00:10'),
(3, 4, 33, 'hot', 26.56, 71.00, 'Friday', 'evening', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 09:00:11', '2026-01-28 09:00:11'),
(4, 4, 34, 'hot', 26.88, 73.00, 'Saturday', 'night', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.30, NULL, NULL, NULL, '2026-01-28 09:00:11', '2026-01-28 09:00:11'),
(5, 4, 2, 'hot', 25.99, 77.00, 'Sunday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 09:00:11', '2026-01-28 09:00:11'),
(6, 4, 8, 'hot', 27.02, 65.00, 'Monday', 'afternoon', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 09:00:11', '2026-01-28 09:00:11'),
(7, 4, 5, 'hot', 26.97, 71.00, 'Wednesday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 09:00:37', '2026-01-28 09:00:37'),
(9, 4, 33, 'hot', 26.56, 71.00, 'Friday', 'evening', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 09:00:37', '2026-01-28 09:00:37'),
(10, 4, 34, 'hot', 26.88, 73.00, 'Saturday', 'night', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.30, NULL, NULL, NULL, '2026-01-28 09:00:37', '2026-01-28 09:00:37'),
(11, 4, 2, 'hot', 25.99, 77.00, 'Sunday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 09:00:38', '2026-01-28 09:00:38'),
(12, 4, 8, 'hot', 27.02, 65.00, 'Monday', 'afternoon', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 09:00:38', '2026-01-28 09:00:38'),
(13, 4, 5, 'hot', 26.97, 71.00, 'Wednesday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 09:00:39', '2026-01-28 09:00:39'),
(15, 4, 33, 'hot', 26.56, 71.00, 'Friday', 'evening', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 09:00:39', '2026-01-28 09:00:39'),
(16, 4, 34, 'hot', 26.88, 73.00, 'Saturday', 'night', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.30, NULL, NULL, NULL, '2026-01-28 09:00:40', '2026-01-28 09:00:40'),
(17, 4, 2, 'hot', 25.99, 77.00, 'Sunday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 09:00:40', '2026-01-28 09:00:40'),
(18, 4, 8, 'hot', 27.02, 65.00, 'Monday', 'afternoon', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 09:00:40', '2026-01-28 09:00:40'),
(19, 4, 5, 'hot', 26.97, 71.00, 'Wednesday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 09:10:45', '2026-01-28 09:10:45'),
(21, 4, 33, 'hot', 26.56, 71.00, 'Friday', 'evening', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 09:10:46', '2026-01-28 09:10:46'),
(22, 4, 34, 'hot', 26.88, 73.00, 'Saturday', 'night', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.30, NULL, NULL, NULL, '2026-01-28 09:10:46', '2026-01-28 09:10:46'),
(23, 4, 2, 'hot', 25.99, 77.00, 'Sunday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 09:10:46', '2026-01-28 09:10:46'),
(24, 4, 8, 'hot', 27.02, 65.00, 'Monday', 'afternoon', 'winter', 'floral', 'low', 'relax_calm', 'auto', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 09:10:46', '2026-01-28 09:10:46'),
(25, 2, 5, 'hot', 26.01, 82.00, 'Wednesday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 10:33:28', '2026-01-28 10:33:28'),
(26, 2, 33, 'hot', 25.35, 83.00, 'Thursday', 'afternoon', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 10:33:28', '2026-01-28 10:33:28'),
(27, 2, 6, 'hot', 25.07, 81.00, 'Friday', 'evening', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 10:33:28', '2026-01-28 10:33:28'),
(28, 2, 7, 'hot', 25.95, 77.00, 'Saturday', 'night', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 10:33:28', '2026-01-28 10:33:28'),
(30, 2, 53, 'hot', 28.59, 57.00, 'Monday', 'afternoon', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 0.70, NULL, NULL, NULL, '2026-01-28 10:33:29', '2026-01-28 10:33:29'),
(31, 5, 40, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 10:36:01', '2026-01-28 10:36:01'),
(32, 5, 5, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 10:36:01', '2026-01-28 10:36:01'),
(33, 5, 33, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 10:36:01', '2026-01-28 10:36:01'),
(35, 5, 46, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 10:36:02', '2026-01-28 10:36:02'),
(36, 5, 57, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 10:36:02', '2026-01-28 10:36:02'),
(37, 5, 40, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 10:47:54', '2026-01-28 10:47:54'),
(38, 2, 5, 'hot', 26.01, 82.00, 'Wednesday', 'morning', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 10:47:54', '2026-01-28 10:47:54'),
(39, 5, 5, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 10:47:54', '2026-01-28 10:47:54'),
(40, 2, 33, 'hot', 25.35, 83.00, 'Thursday', 'afternoon', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 10:47:54', '2026-01-28 10:47:54'),
(41, 5, 33, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 10:47:55', '2026-01-28 10:47:55'),
(42, 2, 6, 'hot', 25.07, 81.00, 'Friday', 'evening', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 10:47:55', '2026-01-28 10:47:55'),
(44, 2, 7, 'hot', 25.95, 77.00, 'Saturday', 'night', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.00, NULL, NULL, NULL, '2026-01-28 10:47:55', '2026-01-28 10:47:55'),
(45, 5, 46, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 10:47:55', '2026-01-28 10:47:55'),
(47, 5, 57, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 10:47:55', '2026-01-28 10:47:55'),
(48, 2, 53, 'hot', 28.59, 57.00, 'Monday', 'afternoon', 'winter', 'floral', 'low', 'relax_calm', 'malaysian_thunderstorm', 'recommended', NULL, 'rule-based-diversity', 0.70, 0.70, NULL, NULL, NULL, '2026-01-28 10:47:55', '2026-01-28 10:47:55'),
(49, 5, 40, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:10:16', '2026-01-28 11:10:16'),
(51, 5, 5, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 11:10:16', '2026-01-28 11:10:16'),
(52, 5, 40, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:10:16', '2026-01-28 11:10:16'),
(53, 5, 33, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:10:17', '2026-01-28 11:10:17'),
(55, 5, 5, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 11:10:17', '2026-01-28 11:10:17'),
(56, 5, 46, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:17', '2026-01-28 11:10:17'),
(57, 5, 57, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:17', '2026-01-28 11:10:17'),
(58, 5, 33, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:10:17', '2026-01-28 11:10:17'),
(59, 5, 46, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:17', '2026-01-28 11:10:17'),
(60, 5, 57, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:18', '2026-01-28 11:10:18'),
(61, 5, 40, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:10:19', '2026-01-28 11:10:19'),
(63, 5, 5, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 11:10:19', '2026-01-28 11:10:19'),
(64, 5, 33, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:10:20', '2026-01-28 11:10:20'),
(65, 5, 46, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:20', '2026-01-28 11:10:20'),
(66, 5, 57, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:20', '2026-01-28 11:10:20'),
(67, 5, 40, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:10:26', '2026-01-28 11:10:26'),
(69, 5, 5, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 11:10:26', '2026-01-28 11:10:26'),
(70, 5, 33, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:10:27', '2026-01-28 11:10:27'),
(71, 5, 40, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:10:27', '2026-01-28 11:10:27'),
(72, 5, 46, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:27', '2026-01-28 11:10:27'),
(73, 5, 57, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:27', '2026-01-28 11:10:27'),
(75, 5, 5, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 11:10:28', '2026-01-28 11:10:28'),
(76, 5, 33, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:10:28', '2026-01-28 11:10:28'),
(77, 5, 46, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:28', '2026-01-28 11:10:28'),
(78, 5, 57, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:10:29', '2026-01-28 11:10:29'),
(79, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:43:55', '2026-01-28 11:43:55'),
(80, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:43:55', '2026-01-28 11:43:55'),
(81, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:43:55', '2026-01-28 11:43:55'),
(82, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:43:55', '2026-01-28 11:43:55'),
(83, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:43:56', '2026-01-28 11:43:56'),
(84, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:43:56', '2026-01-28 11:43:56'),
(85, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:49:54', '2026-01-28 11:49:54'),
(86, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:49:55', '2026-01-28 11:49:55'),
(87, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:49:55', '2026-01-28 11:49:55'),
(88, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:49:55', '2026-01-28 11:49:55'),
(89, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:49:55', '2026-01-28 11:49:55'),
(90, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:49:56', '2026-01-28 11:49:56'),
(91, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:50:05', '2026-01-28 11:50:05'),
(92, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:50:06', '2026-01-28 11:50:06'),
(93, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:50:06', '2026-01-28 11:50:06'),
(94, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:50:06', '2026-01-28 11:50:06'),
(95, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:50:06', '2026-01-28 11:50:06'),
(96, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:50:06', '2026-01-28 11:50:06'),
(97, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:50:12', '2026-01-28 11:50:12'),
(98, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:50:13', '2026-01-28 11:50:13'),
(99, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:50:13', '2026-01-28 11:50:13'),
(100, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:50:13', '2026-01-28 11:50:13'),
(101, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:50:13', '2026-01-28 11:50:13'),
(102, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:50:14', '2026-01-28 11:50:14'),
(103, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:50:37', '2026-01-28 11:50:37'),
(104, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:50:38', '2026-01-28 11:50:38'),
(105, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:50:38', '2026-01-28 11:50:38'),
(106, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:50:38', '2026-01-28 11:50:38'),
(107, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:50:38', '2026-01-28 11:50:38'),
(108, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:50:39', '2026-01-28 11:50:39'),
(109, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:55:33', '2026-01-28 11:55:33'),
(110, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:55:33', '2026-01-28 11:55:33'),
(111, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:55:33', '2026-01-28 11:55:33'),
(112, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:55:33', '2026-01-28 11:55:33'),
(113, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:55:33', '2026-01-28 11:55:33'),
(114, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:55:34', '2026-01-28 11:55:34'),
(115, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:55:43', '2026-01-28 11:55:43'),
(116, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:55:44', '2026-01-28 11:55:44'),
(117, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:55:44', '2026-01-28 11:55:44'),
(118, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:55:44', '2026-01-28 11:55:44'),
(119, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:55:44', '2026-01-28 11:55:44'),
(120, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:55:45', '2026-01-28 11:55:45'),
(121, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:55:45', '2026-01-28 11:55:45'),
(122, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:55:46', '2026-01-28 11:55:46'),
(123, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:55:46', '2026-01-28 11:55:46'),
(124, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:55:46', '2026-01-28 11:55:46'),
(125, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:55:46', '2026-01-28 11:55:46'),
(126, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:55:47', '2026-01-28 11:55:47'),
(127, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:55:55', '2026-01-28 11:55:55'),
(128, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:55:56', '2026-01-28 11:55:56'),
(129, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:55:56', '2026-01-28 11:55:56'),
(130, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:55:56', '2026-01-28 11:55:56'),
(131, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:55:56', '2026-01-28 11:55:56'),
(132, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:55:57', '2026-01-28 11:55:57'),
(133, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:05', '2026-01-28 11:56:05'),
(134, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:06', '2026-01-28 11:56:06'),
(135, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:56:06', '2026-01-28 11:56:06'),
(136, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:56:06', '2026-01-28 11:56:06'),
(137, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:56:06', '2026-01-28 11:56:06'),
(138, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:56:06', '2026-01-28 11:56:06'),
(139, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:17', '2026-01-28 11:56:17'),
(140, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:18', '2026-01-28 11:56:18'),
(141, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:56:18', '2026-01-28 11:56:18'),
(142, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:56:18', '2026-01-28 11:56:18'),
(143, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:56:18', '2026-01-28 11:56:18'),
(144, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:56:18', '2026-01-28 11:56:18'),
(145, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:30', '2026-01-28 11:56:30'),
(146, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:31', '2026-01-28 11:56:31'),
(147, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:56:31', '2026-01-28 11:56:31'),
(148, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:56:31', '2026-01-28 11:56:31'),
(149, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:56:31', '2026-01-28 11:56:31'),
(150, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:56:31', '2026-01-28 11:56:31'),
(151, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:44', '2026-01-28 11:56:44'),
(152, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:45', '2026-01-28 11:56:45'),
(153, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:56:45', '2026-01-28 11:56:45'),
(154, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:56:45', '2026-01-28 11:56:45'),
(155, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:56:45', '2026-01-28 11:56:45'),
(156, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:56:45', '2026-01-28 11:56:45'),
(157, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:54', '2026-01-28 11:56:54'),
(158, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 11:56:55', '2026-01-28 11:56:55'),
(159, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 11:56:55', '2026-01-28 11:56:55'),
(160, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 11:56:55', '2026-01-28 11:56:55'),
(161, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 11:56:55', '2026-01-28 11:56:55'),
(162, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 11:56:55', '2026-01-28 11:56:55'),
(163, 5, 11, 'hot', 25.61, 89.00, 'Wednesday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 12:07:35', '2026-01-28 12:07:35'),
(164, 5, 25, 'hot', 26.02, 81.00, 'Thursday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.70, NULL, NULL, NULL, '2026-01-28 12:07:35', '2026-01-28 12:07:35'),
(165, 5, 40, 'hot', 25.80, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.50, NULL, NULL, NULL, '2026-01-28 12:07:35', '2026-01-28 12:07:35'),
(166, 5, 5, 'hot', 25.44, 84.00, 'Saturday', 'night', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-28 12:07:35', '2026-01-28 12:07:35'),
(167, 5, 33, 'hot', 25.30, 84.00, 'Sunday', 'morning', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 12:07:36', '2026-01-28 12:07:36'),
(168, 5, 32, 'hot', 28.51, 59.00, 'Monday', 'afternoon', 'winter', 'sweet', 'caffeine_free', 'weight_loss', 'malaysian_haze', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 12:07:36', '2026-01-28 12:07:36'),
(169, 5, 5, 'hot', 25.77, 83.00, 'Wednesday', 'morning', 'winter', 'sweet', 'high', 'relax_calm', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-28 12:50:39', '2026-01-28 12:50:39'),
(171, 5, 33, 'hot', 25.07, 81.00, 'Friday', 'evening', 'winter', 'sweet', 'high', 'relax_calm', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.38, NULL, NULL, NULL, '2026-01-28 12:50:40', '2026-01-28 12:50:40'),
(172, 5, 32, 'hot', 25.95, 77.00, 'Saturday', 'night', 'winter', 'sweet', 'high', 'relax_calm', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-28 12:50:40', '2026-01-28 12:50:40'),
(173, 5, 9, 'hot', 25.31, 81.00, 'Sunday', 'morning', 'winter', 'sweet', 'high', 'relax_calm', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.10, NULL, NULL, NULL, '2026-01-28 12:50:40', '2026-01-28 12:50:40'),
(174, 5, 34, 'hot', 27.78, 61.00, 'Monday', 'afternoon', 'winter', 'sweet', 'high', 'relax_calm', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.10, NULL, NULL, NULL, '2026-01-28 12:50:40', '2026-01-28 12:50:40'),
(175, 2, 5, 'hot', 26.59, 71.00, 'Thursday', 'morning', 'winter', 'floral', 'low', 'weight_loss', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.60, NULL, NULL, NULL, '2026-01-29 01:42:36', '2026-01-29 01:42:36'),
(176, 2, 9, 'hot', 26.56, 71.00, 'Friday', 'afternoon', 'winter', 'floral', 'low', 'weight_loss', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.42, NULL, NULL, NULL, '2026-01-29 01:42:36', '2026-01-29 01:42:36'),
(177, 2, 11, 'hot', 26.88, 73.00, 'Saturday', 'evening', 'winter', 'floral', 'low', 'weight_loss', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.40, NULL, NULL, NULL, '2026-01-29 01:42:37', '2026-01-29 01:42:37'),
(178, 2, 2, 'hot', 25.99, 77.00, 'Sunday', 'night', 'winter', 'floral', 'low', 'weight_loss', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.30, NULL, NULL, NULL, '2026-01-29 01:42:37', '2026-01-29 01:42:37'),
(179, 2, 32, 'hot', 27.02, 65.00, 'Monday', 'morning', 'winter', 'floral', 'low', 'weight_loss', 'malaysian_hot_humid', 'recommended', NULL, 'rule-based-diversity', 0.70, 1.20, NULL, NULL, NULL, '2026-01-29 01:42:37', '2026-01-29 01:42:37');


-- Table: tea_timetables
CREATE TABLE `tea_timetables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `schedule` json NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `telegram_notifications_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `telegram_chat_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tea_timetables_user_id_is_active_index` (`user_id`,`is_active`),
  KEY `telegram_notifications_idx` (`telegram_notifications_enabled`,`telegram_chat_id`),
  CONSTRAINT `tea_timetables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: tea_timetables
INSERT INTO `tea_timetables` VALUES
(21, 2, 'Future Hour Test - 2 hours', 'Test timetable 2 hours from now', '[{\"day\": \"thursday\", \"times\": [{\"time\": \"02:18\", \"notes\": \"Future test - 2 hours from now at 02:18\", \"tea_id\": 2}]}]', 1, 1, 1012190593, '2026-01-29', '2026-02-05', 'Asia/Kuala_Lumpur', '2026-01-29 00:18:54', '2026-01-29 00:18:54'),
(34, 2, 'tea10', 'tea10', '[{\"day\": \"thursday\", \"times\": [{\"time\": \"02:02\", \"notes\": \"10\", \"tea_id\": 13}]}]', 1, 1, 1012190593, '2026-01-29', '2026-01-30', 'Asia/Kuala_Lumpur_Melaka', '2026-01-29 01:33:26', '2026-01-29 02:01:51'),
(35, 2, 'tea11', 'tea11', '[{\"day\": \"thursday\", \"times\": [{\"time\": \"01:45\", \"notes\": \"11\", \"tea_id\": \"47\"}]}]', 1, 1, 1012190593, '2026-01-29', '2026-01-30', 'Asia/Kuala_Lumpur', '2026-01-29 01:44:07', '2026-01-29 01:44:07'),
(37, 2, 'Tea Time Test', 'plis', '[{\"day\": \"thursday\", \"times\": [{\"time\": \"02:56\", \"notes\": \"ttt\", \"tea_id\": \"12\"}]}]', 1, 1, 1012190593, '2026-01-29', '2026-01-30', 'Asia/Kuala_Lumpur', '2026-01-29 01:57:09', '2026-01-29 01:57:09'),
(38, 6, 'tea0', 00, '[{\"day\": \"thursday\", \"times\": [{\"time\": \"02:07\", \"notes\": \"00\", \"tea_id\": \"6\"}]}]', 1, 1, 1012190593, '2026-01-29', '2026-01-30', 'Asia/Kuala_Lumpur', '2026-01-29 02:05:46', '2026-01-29 02:05:46'),
(39, 2, 'tea13', 13, '[{\"day\": \"thursday\", \"times\": [{\"time\": \"03:49\", \"notes\": \"13\", \"tea_id\": 67}]}]', 1, 1, 1012190593, '2026-01-29', '2026-01-30', 'Asia/Kuala_Lumpur', '2026-01-29 02:10:03', '2026-01-29 03:47:34');


-- Table: teas
CREATE TABLE `teas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flavor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caffeine_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `health_benefit` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` enum('scraped','manual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: teas
INSERT INTO `teas` VALUES
(2, 'Green Tea', 'Various', 'Low-Medium', 'Energy and alertness, weight management, antioxidant source, heart health, brain function', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 11:43:21', '2026-01-28 11:45:51'),
(5, 'Strawberry', 'Fruity', 'Caffeine-free', 'Supports heart health', 'teas/p44oEEm9neXLnvgEQLCyH9tc64XRcRrqXI2HVFrz.jpg', 'manual', '2026-01-21 12:51:00', '2026-01-21 12:51:00'),
(6, 'Artichoke Tea', 'Earthy', 'Caffeine-free', 'Artichoke tea is definitely one of the lesser-known tea varieties, but it does not involve the actual vegetable itself.', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:14:46', '2026-01-21 14:21:06'),
(7, 'Barley Tea', 'Herbal', 'Caffeine-free', 'Commonly used for aiding digestion and promoting weight loss.', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:14:47', '2026-01-28 11:45:51'),
(8, 'Black Tea', 'Various', 'Medium-High', 'Energy boost, cholesterol reduction, anti-bacterial properties', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:14:47', '2026-01-28 11:45:51'),
(9, 'Brown Rice Tea', 'Nutty', 'Low', 'Brown rice tea originates in Korea and it simply involves steeping teabags that contain roasted grains of brown rice in boiling water.', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:14:47', '2026-01-21 14:21:06'),
(10, 'Chaga Tea', 'Earthy', 'Caffeine-free', 'Many mushrooms have medicinal properties, but have you ever tried mushroom tea?', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:14:47', '2026-01-21 14:21:06'),
(11, 'Chai Tea', 'Sweet', 'Medium', 'Chai is a combination of black tea, steamed milk, and various Indian herbs and spices.', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:14:47', '2026-01-21 14:21:06'),
(12, 'Chamomile Tea', 'Various', 'Caffeine-free', 'Help with sleep, relaxation, stress relief, headache relief, anti-anxiety effects', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(13, 'Chrysanthemum Tea', 'Herbal', 'Caffeine-free', 'Strong antioxidant activity. Used for cooling effect, sedative effect and lowering blood pressure.', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(14, 'Dandelion Tea', 'Herbal', 'Caffeine-free', 'May support liver health and act as a diuretic.', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(15, 'Essiac Tea', 'Earthy', 'Caffeine-free', 'Essiac tea is a traditional drink of the Ojibwa, a North American Indian tribe also known as the Chippewa.', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-21 14:21:06'),
(16, 'Hibiscus Tea', 'Various', 'Caffeine-free', 'Heart health support, blood pressure regulation', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(17, 'Honeybush Tea', 'Herbal', 'Caffeine-free', 'Used for treating cough and for calming effect.', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(18, 'Lemon balm Tea', 'Various', 'Caffeine-free', 'Nervous system support, anti-depressant effects, calming nerves', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(19, 'Matcha Tea', 'Various', 'High', 'High antioxidant levels for cellular protection, improved heart health, weight loss support, and liver detoxification. ', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-21 14:21:06'),
(20, 'Moringa Tea', 'Herbal', 'Caffeine-free', 'Superfood that may help with heart diseases, diabetes, cancer and fatty liver.', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(21, 'Nettle Tea', 'Various', 'Caffeine-free', 'Allergy relief, bone health support, improving hair health, reducing water retention', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:43:51'),
(22, 'Oolong Tea', 'Various', 'Medium', 'Weight management, boosting metabolism, weight loss aid', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(23, 'Peppermint Tea', 'Various', 'Caffeine-free', 'Settle stomach, digestive aid, oral health, appetite control, hangover remedy', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(24, 'Pu-erh Tea', 'Earthy', 'Medium-High', 'Pu-erh tea (also pu’er) is one of the five true teas.', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-21 14:21:06'),
(25, 'Pau d’arco Tea', 'Earthy', 'Caffeine-free', 'Boost immune function, and alleviate pain from conditions like arthritis.', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-21 14:21:06'),
(26, 'Raspberry Leaf Tea', 'Herbal', 'Caffeine-free', 'Mostly used by pregnant women to shorten labour.', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(27, 'Rooibos Tea', 'Various', 'Caffeine-free', 'Skin health improvement, boosting collagen production, caffeine replacement', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(28, 'Rose Tea', 'Herbal', 'Caffeine-free', 'Great source of vitamin C and antioxidants. May help with weight loss, protect the brain and skin from aging.', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(29, 'Rosemary Tea', 'Herbal', 'Caffeine-free', 'May help with Alzheimer\'s disease and treating anxiety.', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(30, 'Senna Tea', 'Sweet', 'Caffeine-free', 'Stimulate bowel movements and relieve constipation', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-21 14:21:06'),
(31, 'Sencha Tea', 'Various', 'Medium', 'Sencha is a common variety of Japanese green tea.', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:43:51'),
(32, 'Spearmint Tea', 'Minty', 'Caffeine-free', 'It has antispasmodic properties, which help relax the stomach muscles, thereby reducing symptoms of nausea and abdominal pain', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-21 14:21:06'),
(33, 'White Tea', 'Various', 'Low', 'Hydration, antioxidant source, anti-aging properties, cancer prevention', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:45:51'),
(34, 'Yerba Mate Tea', 'Herbal', 'Caffeine-free', 'Provides energy boost and contains antioxidants.', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:11:19'),
(35, 'Butterfly Pea Flower Tea', 'Earthy', 'Caffeine-free', 'Butterfly pea flower tea is a unique traditional drink from South-East Asia, and it has a striking blue appearance.', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 13:19:02', '2026-01-28 11:43:51'),
(36, 'Rosehip Tea', 'Herbal', 'Caffeine-free', 'Great source of vitamin C and antioxidants. May help with weight loss, protect the brain and skin from aging.', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(37, 'Ginger Tea', 'Various', 'Caffeine-free', 'Digestive aid, cold and flu relief, anti-inflammatory, joint pain relief, morning sickness relief', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:45:51'),
(38, 'Cinnamon Tea', 'Various', 'Caffeine-free', 'Blood sugar regulation, reducing sugar cravings, managing diabetes', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:45:51'),
(39, 'Lemongrass Tea', 'Herbal', 'Caffeine-free', 'May help relieve pain and anxiety, lower blood pressure, act as antioxidant and help with weight management.', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(40, 'Tulsi Tea', 'Herbal', 'Caffeine-free', 'Adaptogenic herb that reduces stress naturally. Has anti-inflammatory, antioxidant, antidiabetic properties.', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(41, 'Olive leaf Tea', 'Herbal', 'Caffeine-free', 'May help prevent cancer, lower cholesterol and blood sugar, and help with weight loss.', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(42, 'Licorice Tea', 'Herbal', 'Caffeine-free', 'Naturally sweet tea traditionally used for treating stomach pain and cough.', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(43, 'Eucalyptus Tea', 'Various', 'Caffeine-free', 'Respiratory health improvement', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:45:51'),
(44, 'Iceland moss Tea', 'Herbal', 'Caffeine-free', 'Beneficial for treating sore throat and dry cough, may provide instant relief.', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(45, 'Gingko Tea', 'Herbal', 'Caffeine-free', 'Used for treating brain-related problems mostly caused by aging, memory problems.', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(46, 'Ashwagandha Tea', 'Herbal', 'Caffeine-free', 'Adaptogenic herb for treating stress, anxiety and sleeping problems. May protect brain and heart.', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(47, 'Sage Tea', 'Herbal', 'Caffeine-free', 'May be beneficial for depression, dementia, obesity, diabetes, lupus, heart disease, and cancer.', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(48, 'Valerian root Tea', 'Herbal', 'Caffeine-free', 'One of the most common remedies for treating insomnia and sleep disorders.', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(49, 'Anise seed Tea', 'Herbal', 'Caffeine-free', 'Traditionally used for problems related to breathing and digestion.', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(50, 'Elderberry flower Tea', 'Herbal', 'Caffeine-free', 'Has antibacterial and antiviral properties. May help in treating influenza, bronchitis and pain relief.', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(51, 'Linden flower Tea', 'Herbal', 'Caffeine-free', 'Often used for treating common cold, fever, cough and anxiety.', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(52, 'Turmeric Tea', 'Various', 'Caffeine-free', 'Anti-inflammatory effects, joint and muscle pain relief, easing arthritis symptoms', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:45:51'),
(53, 'Lavender Tea', 'Various', 'Caffeine-free', 'Relaxation and stress relief, mood enhancement, calming nerves', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:45:51'),
(54, 'Pine needle Tea', 'Herbal', 'Caffeine-free', 'May act as antidepressant and lift the mood.', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(55, 'Echinacea Tea', 'Various', 'Caffeine-free', 'Boosting immunity, anti-viral properties', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:45:51'),
(56, 'Hibiscus flower Tea', 'Herbal', 'Caffeine-free', 'May help with lowering blood pressure and cholesterol.', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(57, 'Osmanthus Tea', 'Herbal', 'Caffeine-free', 'May boost the immune system and help fight allergies.', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(58, 'Jasmine Tea', 'Herbal', 'Caffeine-free', 'May help treat anxiety, fever, sunburn and stomach ulcers.', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(59, 'Yarrow Tea', 'Herbal', 'Caffeine-free', 'Used to treat wounds, soothe upset stomach, and relieve menstrual cramps and pain.', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(60, 'Stinging nettle Tea', 'Herbal', 'Caffeine-free', 'Used for allergies, arthritis, and urinary issues.', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(61, 'Cranberry Tea', 'Herbal', 'Caffeine-free', 'May help prevent urinary tract infections.', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(62, 'St John’s Wort Tea', 'Herbal', 'Caffeine-free', 'It is also used to help with anxiety, improve sleep quality, and manage symptoms of menopause', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(63, 'Guava Tea', 'Herbal', 'Caffeine-free', 'May help lower blood sugar and support digestive health.', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:47', '2026-01-28 11:43:52'),
(64, 'Gotu kola Tea', 'Herbal', 'Caffeine-free', 'May improve memory and reduce anxiety.', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:43:52'),
(65, 'Marshmallow root Tea', 'Herbal', 'Caffeine-free', 'Soothes irritated mucous membranes and helps with coughs.', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:43:52'),
(66, 'Thyme Tea', 'Various', 'Caffeine-free', 'Respiratory health improvement', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:45:51'),
(67, 'Calendula Tea', 'Herbal', 'Caffeine-free', 'Used for wound healing and reducing inflammation.', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:43:52'),
(68, 'Kuding Tea', 'Herbal', 'Caffeine-free', 'Supporting cardiovascular health, improving metabolism for weight management, and providing potent anti-inflammatory effects. ', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:43:52'),
(69, 'Jiaogulan Tea', 'Herbal', 'Caffeine-free', 'Improving circulation, lowering cholesterol, regulating blood pressure, providing strong antioxidant effects, and assisting in metabolic health. ', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:43:52'),
(70, 'Passion flower Tea', 'Herbal', 'Caffeine-free', 'May help with anxiety and insomnia.', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:43:52'),
(71, 'Kava Tea', 'Herbal', 'Caffeine-free', 'Used for relaxation and reducing anxiety.', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:43:52'),
(72, 'Lapacho bark Tea', 'Herbal', 'Caffeine-free', 'Boost immune function, reduce inflammation, and have anti-ageing effects', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:10:48', '2026-01-28 11:43:52'),
(74, 'Elderberry Tea', 'Various', 'Caffeine-free', 'Boosting immunity, anti-viral properties', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(75, 'Dandelion Root Tea', 'Various', 'Caffeine-free', 'Kidney health support, liver health support, detoxification, diuretic effects', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(76, 'Matcha Green Tea', 'Various', 'Medium-High', 'Mental focus and concentration, enhancing athletic performance', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(77, 'Ginseng Tea', 'Various', 'Caffeine-free', 'Memory and cognitive enhancement, brain function improvement', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(78, 'Passionflower Tea', 'Various', 'Caffeine-free', 'Nervous system support, help with anxiety and insomnia', 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(79, 'Milk Thistle Tea', 'Various', 'Caffeine-free', 'Liver health support, liver detoxification', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(80, 'Licorice Root Tea', 'Various', 'Caffeine-free', 'Sore throat soothing, reducing sugar cravings', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(81, 'Fennel Tea', 'Various', 'Caffeine-free', 'Supporting healthy digestion in infants, supporting breastfeeding', 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(82, 'Hawthorn Tea', 'Various', 'Caffeine-free', 'Improving circulation, heart health', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(83, 'Red Raspberry Leaf Tea', 'Various', 'Caffeine-free', 'Supporting healthy pregnancy', 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(84, 'Red Clover Tea', 'Various', 'Caffeine-free', 'Hormonal balance, alleviating menopause symptoms', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(85, 'Bilberry Tea', 'Various', 'Caffeine-free', 'Eye health improvement', 'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53'),
(86, 'Ginkgo Biloba Tea', 'Various', 'Caffeine-free', 'Memory and cognitive enhancement', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', 'scraped', '2026-01-21 18:25:04', '2026-01-28 11:43:53');


-- Table: users
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: users
INSERT INTO `users` VALUES
(2, 'Rsyad', 'rsyad@gmail.com', NULL, '$2y$12$O2sWeqccY676Uq7ZhpzKW.KoSNQSQXyid5qv2v5UBgczn1DtBM6nO', NULL, '2026-01-21 10:24:28', '2026-01-28 10:09:11', 'user'),
(4, 'Ummi Kart', 'ummikartini2004@gmail.com', '2026-01-28 07:38:29', '$2y$12$J4FNtsdYTZC4U18j6F49U.TLJi1Fl5t7z1hBOW2lryzD1k6J65DrG', NULL, '2026-01-28 07:33:22', '2026-01-28 07:38:29', 'admin'),
(5, 'Aliff', 'aliff@gmail.com', NULL, '$2y$12$MDGlqVn0RYR4jEeH3FnK5ec8qn7IP1vh/G4rh14gk40u1uaXcGA3C', NULL, '2026-01-28 08:12:28', '2026-01-28 08:12:28', 'user'),
(6, 'Raudha', 'raudha@gmail.com', NULL, '$2y$12$oJOGFQKV41EbnJVeV2GrKOhPzlEiiGoWnmcckxHzHmbaf1pciJE6K', NULL, '2026-01-28 12:21:18', '2026-01-28 12:33:46', 'user');


-- Table: weather
CREATE TABLE `weather` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `date` date NOT NULL,
  `temperature` decimal(5,2) NOT NULL,
  `feels_like` decimal(5,2) NOT NULL,
  `humidity` int NOT NULL,
  `wind_speed` decimal(5,2) NOT NULL,
  `pressure` int NOT NULL,
  `main_condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forecast_data` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weather_city_date_index` (`city`,`date`),
  KEY `weather_date_index` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: weather
INSERT INTO `weather` VALUES
(1, 'Malaysia', 'MY', 2.50000000, 112.50000000, '2026-01-26', 22.83, 22.83, 97, 0.34, 1012, 'Clouds', 'overcast clouds', '04n', '{\"icons\": [\"10n\", \"04n\", \"04n\", \"04n\"], \"temps\": [23.53, 23.21, 22.75, 21.81], \"humidity\": [94, 95, 98, 99], \"pressure\": [1012, 1012, 1012, 1012], \"conditions\": [\"Rain\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [0.56, 0.46, 0.02, 0.32], \"descriptions\": [\"light rain\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 11:07:54', '2026-01-26 11:07:55'),
(2, 'Malaysia', 'MY', 2.50000000, 112.50000000, '2026-01-27', 22.94, 22.94, 93, 1.07, 1012, 'Clouds', 'overcast clouds', '10d', '{\"icons\": [\"04d\", \"10d\", \"10d\", \"10d\", \"10n\", \"04n\", \"04n\", \"04n\"], \"temps\": [22.6, 27.31, 25.64, 23.89, 21.94, 21.26, 20.7, 20.17], \"humidity\": [97, 72, 84, 94, 98, 99, 99, 98], \"pressure\": [1013, 1013, 1011, 1011, 1013, 1013, 1012, 1012], \"conditions\": [\"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [0.21, 0.83, 1.91, 1.53, 1.02, 0.89, 0.96, 1.18], \"descriptions\": [\"overcast clouds\", \"light rain\", \"light rain\", \"light rain\", \"light rain\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 11:07:55', '2026-01-26 11:07:55'),
(3, 'Malaysia', 'MY', 2.50000000, 112.50000000, '2026-01-28', 23.49, 23.49, 89, 0.96, 1012, 'Clouds', 'overcast clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"10d\", \"10d\", \"10n\", \"04n\", \"04n\", \"10n\"], \"temps\": [21.36, 27.08, 28.77, 24.89, 21.9, 21.52, 21.33, 21.05], \"humidity\": [96, 71, 62, 89, 98, 98, 99, 99], \"pressure\": [1013, 1013, 1010, 1010, 1013, 1013, 1012, 1011], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\", \"Rain\"], \"wind_speeds\": [0.78, 1.57, 1.59, 1.58, 0.78, 0.69, 0.45, 0.23], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"light rain\", \"light rain\", \"light rain\", \"overcast clouds\", \"overcast clouds\", \"light rain\"]}', '2026-01-26 11:07:55', '2026-01-26 11:07:55'),
(4, 'Malaysia', 'MY', 2.50000000, 112.50000000, '2026-01-29', 22.78, 22.78, 94, 0.73, 1012, 'Rain', 'light rain', '10n', '{\"icons\": [\"04d\", \"10d\", \"10d\", \"10d\", \"10n\", \"10n\", \"10n\", \"10n\"], \"temps\": [22.12, 26.31, 24.99, 23.99, 21.62, 21.59, 20.95, 20.68], \"humidity\": [97, 78, 89, 94, 98, 99, 99, 99], \"pressure\": [1013, 1012, 1010, 1009, 1012, 1013, 1011, 1012], \"conditions\": [\"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Rain\"], \"wind_speeds\": [0.15, 1.22, 1.84, 1.47, 0.6, 0.08, 0.23, 0.25], \"descriptions\": [\"overcast clouds\", \"light rain\", \"moderate rain\", \"moderate rain\", \"light rain\", \"light rain\", \"light rain\", \"moderate rain\"]}', '2026-01-26 11:07:55', '2026-01-26 11:07:55'),
(5, 'Malaysia', 'MY', 2.50000000, 112.50000000, '2026-01-30', 19.39, 19.39, 99, 1.16, 1013, 'Rain', 'light rain', '10d', '{\"icons\": [\"10d\", \"10d\", \"10d\", \"10d\", \"10n\", \"04n\", \"10n\", \"10n\"], \"temps\": [21.03, 20.7, 20.53, 18.42, 18.54, 18.7, 18.63, 18.55], \"humidity\": [99, 99, 99, 98, 98, 98, 98, 99], \"pressure\": [1014, 1014, 1013, 1012, 1014, 1014, 1013, 1013], \"conditions\": [\"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Rain\", \"Rain\"], \"wind_speeds\": [0.28, 0.53, 1.8, 2.12, 1.16, 0.93, 1.34, 1.13], \"descriptions\": [\"moderate rain\", \"heavy intensity rain\", \"heavy intensity rain\", \"moderate rain\", \"light rain\", \"overcast clouds\", \"light rain\", \"light rain\"]}', '2026-01-26 11:07:55', '2026-01-26 11:07:55'),
(6, 'Malaysia', 'MY', 2.50000000, 112.50000000, '2026-01-31', 23.36, 23.36, 82, 1.36, 1013, 'Rain', 'light rain', '10d', '{\"icons\": [\"10d\", \"04d\", \"10d\", \"10d\"], \"temps\": [19.23, 24.41, 25.84, 23.96], \"humidity\": [98, 77, 70, 84], \"pressure\": [1015, 1015, 1012, 1011], \"conditions\": [\"Rain\", \"Clouds\", \"Rain\", \"Rain\"], \"wind_speeds\": [0.87, 1.14, 1.66, 1.76], \"descriptions\": [\"light rain\", \"overcast clouds\", \"light rain\", \"light rain\"]}', '2026-01-26 11:07:55', '2026-01-26 11:07:55'),
(7, 'Malacca', 'MY', 2.19600000, 102.24050000, '2026-01-26', 27.80, 31.19, 77, 3.13, 1012, 'Clouds', 'few clouds', '02n', '{\"dt\": 1769432427, \"id\": 1734759, \"cod\": 200, \"sys\": {\"id\": 2078559, \"type\": 2, \"sunset\": 1769426632, \"country\": \"MY\", \"sunrise\": 1769383369}, \"base\": \"stations\", \"main\": {\"temp\": 27.8, \"humidity\": 77, \"pressure\": 1012, \"temp_max\": 28.02, \"temp_min\": 27.79, \"sea_level\": 1012, \"feels_like\": 31.19, \"grnd_level\": 1011}, \"name\": \"Malacca\", \"wind\": {\"deg\": 70, \"gust\": 0, \"speed\": 3.13}, \"coord\": {\"lat\": 2.196, \"lon\": 102.2405}, \"clouds\": {\"all\": 20}, \"weather\": [{\"id\": 801, \"icon\": \"02n\", \"main\": \"Clouds\", \"description\": \"few clouds\"}], \"timezone\": 28800, \"visibility\": 10000}', '2026-01-26 11:22:23', '2026-01-26 13:02:15'),
(8, 'Malacca', 'MY', 2.19600000, 102.24050000, '2026-01-27', 26.65, 26.65, 69, 4.06, 1013, 'Clouds', 'overcast clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"04d\", \"04d\", \"04n\", \"04n\", \"04n\", \"04n\"], \"temps\": [24.28, 27.73, 30.76, 29.62, 27.45, 25.53, 24.07, 23.72], \"humidity\": [81, 59, 51, 57, 67, 68, 82, 85], \"pressure\": [1013, 1015, 1012, 1010, 1011, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [5.39, 5.2, 1.63, 2.58, 1.13, 5.55, 5.58, 5.41], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"broken clouds\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 11:22:23', '2026-01-26 11:22:23'),
(9, 'Malacca', 'MY', 2.19600000, 102.24050000, '2026-01-28', 26.97, 26.97, 71, 3.16, 1011, 'Clouds', 'overcast clouds', '04n', '{\"icons\": [\"02d\", \"10n\", \"04n\", \"04n\", \"04n\"], \"temps\": [29.02, 28.87, 27.45, 25.07, 24.45], \"humidity\": [58, 62, 68, 81, 84], \"pressure\": [1010, 1010, 1013, 1013, 1011], \"conditions\": [\"Clouds\", \"Rain\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [0.34, 2.34, 3.7, 4.92, 4.48], \"descriptions\": [\"few clouds\", \"light rain\", \"broken clouds\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 11:22:23', '2026-01-28 08:41:47'),
(10, 'Malacca', 'MY', 2.19600000, 102.24050000, '2026-01-29', 26.59, 26.59, 71, 3.99, 1012, 'Clouds', 'overcast clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"04d\", \"04d\", \"10n\", \"04n\", \"04n\", \"04n\"], \"temps\": [25.22, 28.22, 30.31, 27.92, 26.84, 25.5, 24.65, 24.03], \"humidity\": [84, 62, 56, 66, 72, 75, 76, 78], \"pressure\": [1013, 1014, 1011, 1010, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Rain\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [4.74, 5.15, 1.11, 2.33, 0.89, 5.78, 6.04, 5.86], \"descriptions\": [\"overcast clouds\", \"broken clouds\", \"broken clouds\", \"overcast clouds\", \"light rain\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 11:22:23', '2026-01-28 08:41:47'),
(11, 'Malacca', 'MY', 2.19600000, 102.24050000, '2026-01-30', 26.56, 26.56, 71, 3.99, 1012, 'Clouds', 'overcast clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"04d\", \"04d\", \"04n\", \"04n\", \"04n\", \"03n\"], \"temps\": [23.6, 27.93, 30.78, 27.98, 27.22, 26.72, 24.77, 23.5], \"humidity\": [80, 61, 53, 67, 72, 71, 76, 87], \"pressure\": [1013, 1014, 1011, 1009, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [5.54, 5.9, 1, 4.09, 1.97, 4.33, 4.88, 4.17], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"overcast clouds\", \"broken clouds\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\", \"scattered clouds\"]}', '2026-01-26 11:22:23', '2026-01-28 08:41:47'),
(12, 'Malacca', 'MY', 2.19600000, 102.24050000, '2026-01-31', 26.88, 26.88, 73, 3.32, 1012, 'Clouds', 'broken clouds', '04d', '{\"icons\": [\"03d\", \"04d\", \"04d\", \"04d\", \"04n\", \"10n\", \"04n\", \"04n\"], \"temps\": [23.43, 28.68, 30.91, 29.13, 26.84, 26.84, 25.11, 24.12], \"humidity\": [89, 61, 54, 64, 75, 74, 79, 84], \"pressure\": [1013, 1014, 1012, 1009, 1011, 1014, 1012, 1011], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Rain\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [4.25, 3.97, 0.85, 4.04, 1.7, 3.73, 4.06, 3.96], \"descriptions\": [\"scattered clouds\", \"broken clouds\", \"broken clouds\", \"overcast clouds\", \"broken clouds\", \"light rain\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 11:22:23', '2026-01-28 08:41:47'),
(13, 'Seremban', 'MY', 2.72970000, 101.93810000, '2026-01-26', 25.72, 25.72, 81, 2.12, 1012, 'Clouds', 'overcast clouds', '04n', '{\"icons\": [\"10n\", \"04n\", \"04n\"], \"temps\": [27.23, 25.76, 24.16], \"humidity\": [74, 82, 87], \"pressure\": [1012, 1012, 1012], \"conditions\": [\"Rain\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [2.23, 2.17, 1.95], \"descriptions\": [\"light rain\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 13:05:53', '2026-01-26 13:05:54'),
(14, 'Seremban', 'MY', 2.72970000, 101.93810000, '2026-01-27', 25.74, 25.74, 73, 1.35, 1013, 'Clouds', 'overcast clouds', '04n', '{\"icons\": [\"04d\", \"04d\", \"04d\", \"10d\", \"04n\", \"04n\", \"04n\", \"04n\"], \"temps\": [23.06, 29.22, 32.3, 28.29, 25.53, 23.62, 22.25, 21.67], \"humidity\": [87, 58, 47, 68, 77, 80, 81, 83], \"pressure\": [1014, 1015, 1012, 1010, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Rain\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.76, 1.06, 0.63, 1.04, 0.62, 1.83, 1.9, 1.97], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"overcast clouds\", \"light rain\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 13:05:54', '2026-01-26 13:05:54'),
(15, 'Seremban', 'MY', 2.72970000, 101.93810000, '2026-01-28', 25.77, 25.77, 83, 1.62, 1012, 'Clouds', 'overcast clouds', '04n', '{\"icons\": [\"04n\", \"04n\", \"04n\"], \"temps\": [27, 25.71, 24.59], \"humidity\": [70, 84, 94], \"pressure\": [1012, 1012, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.57, 1.66, 1.62], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 13:05:54', '2026-01-28 12:44:22'),
(16, 'Seremban', 'MY', 2.72970000, 101.93810000, '2026-01-29', 25.64, 25.64, 83, 1.39, 1013, 'Clouds', 'overcast clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"10d\", \"10d\", \"10n\", \"10n\", \"04n\", \"04n\"], \"temps\": [24.92, 29.65, 31.15, 27.17, 24.52, 23.51, 22.63, 21.54], \"humidity\": [93, 70, 57, 81, 87, 91, 92, 93], \"pressure\": [1013, 1014, 1012, 1010, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.57, 1.3, 0.41, 0.46, 1.2, 2.19, 2.17, 1.8], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"light rain\", \"moderate rain\", \"light rain\", \"light rain\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 13:05:54', '2026-01-28 12:44:22'),
(17, 'Seremban', 'MY', 2.72970000, 101.93810000, '2026-01-30', 25.07, 25.07, 81, 1.52, 1013, 'Clouds', 'overcast clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"04d\", \"10d\", \"10n\", \"10n\", \"03n\", \"04n\"], \"temps\": [21.56, 28.79, 31.61, 27.4, 24.66, 23.2, 21.87, 21.47], \"humidity\": [91, 61, 52, 78, 88, 91, 90, 93], \"pressure\": [1013, 1015, 1011, 1010, 1012, 1015, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.64, 1.42, 0.44, 1.89, 1.03, 1.98, 2.05, 1.74], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"overcast clouds\", \"light rain\", \"light rain\", \"light rain\", \"scattered clouds\", \"broken clouds\"]}', '2026-01-26 13:05:54', '2026-01-28 12:44:22'),
(18, 'Seremban', 'MY', 2.72970000, 101.93810000, '2026-01-31', 25.95, 25.95, 77, 1.46, 1012, 'Clouds', 'broken clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"04d\", \"04d\", \"10n\", \"10n\", \"04n\", \"04n\"], \"temps\": [22.13, 29.45, 31.85, 30.89, 24.74, 23.49, 22.69, 22.32], \"humidity\": [91, 58, 50, 55, 87, 91, 91, 90], \"pressure\": [1013, 1015, 1012, 1009, 1012, 1014, 1012, 1011], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.42, 1.06, 0.6, 2.65, 1.3, 1.52, 1.61, 1.51], \"descriptions\": [\"broken clouds\", \"broken clouds\", \"broken clouds\", \"overcast clouds\", \"light rain\", \"light rain\", \"overcast clouds\", \"overcast clouds\"]}', '2026-01-26 13:05:54', '2026-01-28 12:44:22'),
(19, 'Ipoh', 'MY', 4.58410000, 101.08290000, '2026-01-26', 25.93, 25.93, 81, 1.35, 1012, 'Clouds', 'light rain', '04n', '{\"icons\": [\"10n\", \"04n\", \"04n\"], \"temps\": [27.87, 26.15, 23.77], \"humidity\": [76, 82, 86], \"pressure\": [1012, 1012, 1012], \"conditions\": [\"Rain\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.28, 1.35, 1.42], \"descriptions\": [\"light rain\", \"broken clouds\", \"overcast clouds\"]}', '2026-01-26 13:25:18', '2026-01-26 13:25:19'),
(20, 'Ipoh', 'MY', 4.58410000, 101.08290000, '2026-01-27', 26.32, 26.32, 80, 1.40, 1013, 'Clouds', 'overcast clouds', '04n', '{\"icons\": [\"04d\", \"04d\", \"10d\", \"10d\", \"10n\", \"04n\", \"04n\", \"04n\"], \"temps\": [25.28, 28.53, 32.78, 29.03, 25.27, 23.96, 23.14, 22.53], \"humidity\": [86, 62, 57, 73, 87, 91, 91, 89], \"pressure\": [1014, 1015, 1012, 1010, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.64, 1.08, 1.57, 2.19, 0.36, 1.12, 1.53, 1.72], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"light rain\", \"light rain\", \"light rain\", \"broken clouds\", \"broken clouds\", \"overcast clouds\"]}', '2026-01-26 13:25:19', '2026-01-26 13:25:19'),
(21, 'Ipoh', 'MY', 4.58410000, 101.08290000, '2026-01-28', 25.61, 25.61, 89, 1.49, 1013, 'Rain', 'light rain', '10n', '{\"icons\": [\"10n\", \"04n\", \"10n\", \"10n\"], \"temps\": [26.64, 26.21, 25.35, 24.25], \"humidity\": [88, 89, 91, 89], \"pressure\": [1012, 1013, 1013, 1012], \"conditions\": [\"Rain\", \"Clouds\", \"Rain\", \"Rain\"], \"wind_speeds\": [1.57, 1.15, 1.52, 1.7], \"descriptions\": [\"light rain\", \"broken clouds\", \"light rain\", \"light rain\"]}', '2026-01-26 13:25:19', '2026-01-28 10:34:49'),
(22, 'Ipoh', 'MY', 4.58410000, 101.08290000, '2026-01-29', 26.02, 26.02, 81, 1.38, 1013, 'Clouds', 'overcast clouds', '04n', '{\"icons\": [\"04d\", \"04d\", \"10d\", \"10d\", \"10n\", \"04n\", \"04n\", \"04n\"], \"temps\": [25.22, 27.25, 31.85, 28.39, 24.77, 24.31, 23.54, 22.85], \"humidity\": [86, 69, 58, 78, 88, 90, 91, 91], \"pressure\": [1013, 1014, 1012, 1010, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.69, 1.18, 0.78, 2.81, 0.5, 1.27, 1.12, 1.66], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"light rain\", \"light rain\", \"moderate rain\", \"overcast clouds\", \"broken clouds\", \"overcast clouds\"]}', '2026-01-26 13:25:19', '2026-01-28 10:34:49'),
(23, 'Ipoh', 'MY', 4.58410000, 101.08290000, '2026-01-30', 25.80, 25.80, 81, 1.39, 1013, 'Rain', 'light rain', '10n', '{\"icons\": [\"04d\", \"04d\", \"10d\", \"10d\", \"10n\", \"10n\", \"10n\", \"03n\"], \"temps\": [22.74, 27.99, 31.6, 29.89, 25.12, 23.75, 22.85, 22.42], \"humidity\": [89, 68, 59, 68, 90, 93, 93, 91], \"pressure\": [1013, 1015, 1012, 1009, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\"], \"wind_speeds\": [1.57, 1.26, 0.89, 1.72, 1.3, 0.97, 1.71, 1.69], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"light rain\", \"light rain\", \"light rain\", \"light rain\", \"light rain\", \"scattered clouds\"]}', '2026-01-26 13:25:19', '2026-01-28 10:34:49'),
(24, 'Ipoh', 'MY', 4.58410000, 101.08290000, '2026-01-31', 25.44, 25.44, 84, 1.63, 1013, 'Rain', 'light rain', '10n', '{\"icons\": [\"02d\", \"04d\", \"10d\", \"10d\", \"10n\", \"10n\", \"10n\", \"04n\"], \"temps\": [22.38, 28.5, 30.66, 28.22, 25.09, 23.67, 22.59, 22.4], \"humidity\": [87, 66, 65, 83, 92, 93, 92, 91], \"pressure\": [1014, 1015, 1012, 1010, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\"], \"wind_speeds\": [1.65, 0.84, 1.75, 3.21, 0.76, 1.4, 1.85, 1.61], \"descriptions\": [\"few clouds\", \"broken clouds\", \"light rain\", \"light rain\", \"light rain\", \"light rain\", \"light rain\", \"overcast clouds\"]}', '2026-01-26 13:25:19', '2026-01-28 10:34:49'),
(25, 'Malacca', 'MY', 2.19600000, 102.24050000, '2026-02-01', 25.99, 25.99, 77, 3.65, 1012, 'Clouds', 'light rain', '10d', '{\"icons\": [\"04d\", \"03d\", \"10d\", \"10d\", \"10n\", \"10n\", \"04n\", \"04n\"], \"temps\": [24.15, 28.89, 30.12, 28.08, 25.6, 24.64, 23.37, 23.05], \"humidity\": [85, 62, 58, 68, 81, 85, 91, 89], \"pressure\": [1013, 1014, 1011, 1010, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [4.83, 4.41, 1.32, 2.02, 3.1, 4.5, 4.3, 4.72], \"descriptions\": [\"overcast clouds\", \"scattered clouds\", \"light rain\", \"moderate rain\", \"light rain\", \"light rain\", \"broken clouds\", \"overcast clouds\"]}', '2026-01-28 08:41:47', '2026-01-28 08:41:47'),
(26, 'Malacca', 'MY', 2.19600000, 102.24050000, '2026-02-02', 27.02, 27.02, 65, 4.72, 1014, 'Clouds', 'overcast clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"04d\"], \"temps\": [22.63, 27.47, 30.95], \"humidity\": [88, 59, 47], \"pressure\": [1014, 1015, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [5.15, 5.78, 3.24], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"broken clouds\"]}', '2026-01-28 08:41:47', '2026-01-28 08:41:47'),
(27, 'Seremban', 'MY', 2.72970000, 101.93810000, '2026-02-01', 25.31, 25.31, 81, 1.23, 1013, 'Clouds', 'light rain', '10d', '{\"icons\": [\"04d\", \"03d\", \"10d\", \"10d\", \"10n\", \"10n\", \"04n\", \"03n\"], \"temps\": [22.53, 30.12, 29.61, 28.25, 24.02, 23.76, 22.58, 21.59], \"humidity\": [90, 56, 61, 72, 90, 91, 94, 95], \"pressure\": [1013, 1014, 1012, 1010, 1012, 1014, 1013, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.52, 0.88, 1.2, 0.46, 1.41, 1.22, 1.66, 1.51], \"descriptions\": [\"overcast clouds\", \"scattered clouds\", \"light rain\", \"moderate rain\", \"light rain\", \"light rain\", \"overcast clouds\", \"scattered clouds\"]}', '2026-01-28 10:31:46', '2026-01-28 12:44:22'),
(28, 'Seremban', 'MY', 2.72970000, 101.93810000, '2026-02-02', 27.78, 27.78, 61, 1.42, 1013, 'Clouds', 'broken clouds', '04d', '{\"icons\": [\"04d\", \"04d\", \"04d\", \"04d\", \"04n\"], \"temps\": [21.56, 28.44, 32.35, 32.01, 24.52], \"humidity\": [93, 57, 40, 39, 78], \"pressure\": [1014, 1015, 1012, 1010, 1012], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [1.58, 1.33, 1.62, 1.32, 1.25], \"descriptions\": [\"broken clouds\", \"overcast clouds\", \"broken clouds\", \"broken clouds\", \"broken clouds\"]}', '2026-01-28 10:31:46', '2026-01-28 12:44:22'),
(29, 'Ipoh', 'MY', 4.58410000, 101.08290000, '2026-02-01', 25.30, 25.30, 84, 1.54, 1013, 'Rain', 'light rain', '10n', '{\"icons\": [\"04d\", \"04d\", \"10d\", \"10d\", \"10n\", \"10n\", \"10n\", \"10n\"], \"temps\": [22.66, 28.73, 31.57, 26.43, 24.39, 23.73, 22.82, 22.06], \"humidity\": [90, 66, 61, 85, 92, 93, 93, 91], \"pressure\": [1014, 1014, 1012, 1010, 1012, 1014, 1013, 1013], \"conditions\": [\"Clouds\", \"Clouds\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Rain\", \"Rain\"], \"wind_speeds\": [1.63, 1.37, 0.66, 2, 1.62, 1.22, 1.89, 1.96], \"descriptions\": [\"overcast clouds\", \"overcast clouds\", \"light rain\", \"moderate rain\", \"moderate rain\", \"moderate rain\", \"light rain\", \"light rain\"]}', '2026-01-28 10:34:49', '2026-01-28 10:34:49'),
(30, 'Ipoh', 'MY', 4.58410000, 101.08290000, '2026-02-02', 28.51, 28.51, 59, 1.29, 1013, 'Clouds', 'scattered clouds', '03d', '{\"icons\": [\"03d\", \"02d\", \"03d\", \"04d\"], \"temps\": [21.48, 28.29, 32.37, 31.89], \"humidity\": [86, 57, 43, 48], \"pressure\": [1014, 1015, 1012, 1009], \"conditions\": [\"Clouds\", \"Clouds\", \"Clouds\", \"Clouds\"], \"wind_speeds\": [2.07, 0.72, 1.21, 1.16], \"descriptions\": [\"scattered clouds\", \"few clouds\", \"scattered clouds\", \"broken clouds\"]}', '2026-01-28 10:34:49', '2026-01-28 10:34:49');


