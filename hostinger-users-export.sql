-- Users table with existing data for Hostinger deployment
-- Run this in Hostinger phpMyAdmin first

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert existing users
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Rsyad', 'rsyad@gmail.com', '$2y$12$O2sWeqccY676Uq7ZhpzKW.KoSNQSQXyid5qv2v5UBgczn1DtBM6nO', NULL, '2026-01-21 10:24:28', '2026-01-28 10:09:11'),
(4, 'Ummi Kart', 'ummikartini2004@gmail.com', '$2y$12$J4FNtsdYTZC4U18j6F49U.TLJi1Fl5t7z1hBOW2lryzD1k6J65DrG', NULL, '2026-01-28 07:33:22', '2026-01-28 07:38:29'),
(5, 'Aliff', 'aliff@gmail.com', '$2y$12$MDGlqVn0RYR4jEeH3FnK5ec8qn7IP1vh/G4rh14gk40u1uaXcGA3C', NULL, '2026-01-28 08:12:28', '2026-01-28 08:12:28'),
(6, 'Raudha', 'raudha@gmail.com', '$2y$12$oJOGFQKV41EbnJVeV2GrKOhPzlEiiGoWnmcckxHzHmbaf1pciJE6K', NULL, '2026-01-28 12:21:18', '2026-01-28 12:33:46');

-- Note: Passwords are already hashed
-- Default password for all users is 'password'
-- You can change passwords by updating the hash
