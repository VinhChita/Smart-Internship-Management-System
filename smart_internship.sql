-- ============================================================
-- Smart Internship Management System
-- Import into database: smart_internship  (MySQL / MariaDB)
-- phpMyAdmin: select "smart_internship" -> Import -> choose this file -> Go
-- Demo login password for ALL demo accounts: password
-- NOTE: Use this file INSTEAD of "php artisan migrate".
--       Do not run migrate afterwards (tables already exist).
-- ============================================================

CREATE DATABASE IF NOT EXISTS `smart_internship`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smart_internship`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `app_notifications`;
DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `evaluations`;
DROP TABLE IF EXISTS `reports`;
DROP TABLE IF EXISTS `attendances`;
DROP TABLE IF EXISTS `applications`;
DROP TABLE IF EXISTS `internship_programs`;
DROP TABLE IF EXISTS `personal_access_tokens`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `companies`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;

-- ------------------------------------------------------------
-- Laravel system tables
-- ------------------------------------------------------------
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Application tables
-- ------------------------------------------------------------
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','supervisor','intern') NOT NULL DEFAULT 'intern',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `phone` varchar(255) DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `internship_programs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `field` varchar(255) DEFAULT NULL,
  `slots` int unsigned NOT NULL DEFAULT '1',
  `deadline` date NOT NULL,
  `status` enum('draft','open','closed') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `internship_programs_company_id_foreign` (`company_id`),
  KEY `internship_programs_created_by_foreign` (`created_by`),
  CONSTRAINT `internship_programs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `internship_programs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `program_id` bigint unsigned NOT NULL,
  `intern_id` bigint unsigned NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `cover_letter` text,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `applications_program_id_intern_id_unique` (`program_id`,`intern_id`),
  KEY `applications_intern_id_foreign` (`intern_id`),
  KEY `applications_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `applications_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `internship_programs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applications_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `intern_id` bigint unsigned NOT NULL,
  `supervisor_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late','excused') NOT NULL DEFAULT 'present',
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_intern_id_date_unique` (`intern_id`,`date`),
  KEY `attendances_supervisor_id_foreign` (`supervisor_id`),
  CONSTRAINT `attendances_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `intern_id` bigint unsigned NOT NULL,
  `type` enum('weekly','final') NOT NULL DEFAULT 'weekly',
  `week_number` tinyint unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `supervisor_feedback` text,
  `status` enum('submitted','reviewed') NOT NULL DEFAULT 'submitted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_intern_id_foreign` (`intern_id`),
  CONSTRAINT `reports_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `evaluations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `intern_id` bigint unsigned NOT NULL,
  `supervisor_id` bigint unsigned NOT NULL,
  `program_id` bigint unsigned DEFAULT NULL,
  `score` tinyint unsigned NOT NULL,
  `feedback` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluations_intern_id_foreign` (`intern_id`),
  KEY `evaluations_supervisor_id_foreign` (`supervisor_id`),
  KEY `evaluations_program_id_foreign` (`program_id`),
  CONSTRAINT `evaluations_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `evaluations_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `evaluations_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `internship_programs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `app_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `app_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Demo data  (password for every demo user = "password")
-- ------------------------------------------------------------
INSERT INTO `companies` (`id`,`name`,`address`,`contact_email`,`contact_phone`,`website`,`created_at`,`updated_at`) VALUES
(1,'Tech Solution Co.','Phnom Penh','hr@techsolution.example','012 000 000',NULL,NOW(),NOW()),
(2,'Bright Media Group','Phnom Penh','hr@brightmedia.example','012 111 111',NULL,NOW(),NOW()),
(3,'Golden Finance Ltd.','Siem Reap','hr@goldenfinance.example','012 222 222',NULL,NOW(),NOW());

INSERT INTO `users` (`id`,`name`,`email`,`password`,`role`,`status`,`phone`,`telegram`,`university`,`major`,`company_id`,`created_at`,`updated_at`) VALUES
(1,'Admin','admin@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin','approved',NULL,NULL,NULL,NULL,NULL,NOW(),NOW()),
(2,'Vichet Sovanna','supervisor@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','supervisor','approved','012 345 111','@vichet',NULL,NULL,1,NOW(),NOW()),
(3,'Sokha Routana','intern@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','intern','approved','012 345 678','@sokha','Royal University of Phnom Penh','Information Technology',NULL,NOW(),NOW()),
(4,'Chan Narith','intern2@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','intern','approved','012 999 888',NULL,'Royal University of Phnom Penh','Marketing',NULL,NOW(),NOW()),
(5,'Pending Intern','pending@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','intern','pending',NULL,NULL,NULL,NULL,NULL,NOW(),NOW());

INSERT INTO `internship_programs` (`id`,`company_id`,`created_by`,`title`,`description`,`field`,`slots`,`deadline`,`status`,`created_at`,`updated_at`) VALUES
(1,1,2,'Frontend Developer','Build web UI with Laravel Blade and JavaScript.','IT',3,DATE_ADD(CURDATE(), INTERVAL 30 DAY),'open',NOW(),NOW()),
(2,2,2,'Marketing Assistant','Support social media and campaign planning.','Marketing',2,DATE_ADD(CURDATE(), INTERVAL 20 DAY),'open',NOW(),NOW()),
(3,3,2,'Accounting Intern','Assist with bookkeeping and monthly reports.','Finance',1,DATE_ADD(CURDATE(), INTERVAL 45 DAY),'draft',NOW(),NOW());

INSERT INTO `applications` (`id`,`program_id`,`intern_id`,`status`,`cover_letter`,`reviewed_by`,`created_at`,`updated_at`) VALUES
(1,1,3,'approved','I am interested in web development.',2,NOW(),NOW()),
(2,2,4,'pending','I would like to learn digital marketing.',NULL,NOW(),NOW());

INSERT INTO `attendances` (`id`,`intern_id`,`supervisor_id`,`date`,`status`,`note`,`created_at`,`updated_at`) VALUES
(1,3,2,DATE_SUB(CURDATE(), INTERVAL 2 DAY),'present',NULL,NOW(),NOW()),
(2,3,2,DATE_SUB(CURDATE(), INTERVAL 1 DAY),'late','Traffic',NOW(),NOW()),
(3,3,2,CURDATE(),'present',NULL,NOW(),NOW());

INSERT INTO `reports` (`id`,`intern_id`,`type`,`week_number`,`title`,`content`,`supervisor_feedback`,`status`,`created_at`,`updated_at`) VALUES
(1,3,'weekly',1,'Week 1 Report','Set up Laravel project and learned the team workflow.','Good start. Keep it up.','reviewed',NOW(),NOW()),
(2,3,'weekly',2,'Week 2 Report','Built the login and register pages.',NULL,'submitted',NOW(),NOW());

INSERT INTO `evaluations` (`id`,`intern_id`,`supervisor_id`,`program_id`,`score`,`feedback`,`created_at`,`updated_at`) VALUES
(1,3,2,1,88,'Responsible and learns fast.',NOW(),NOW());

INSERT INTO `messages` (`id`,`sender_id`,`receiver_id`,`body`,`created_at`,`updated_at`) VALUES
(1,3,2,'Hello, I submitted my Week 2 report.',NOW(),NOW()),
(2,2,3,'Thank you, I will review it today.',NOW(),NOW());

INSERT INTO `app_notifications` (`id`,`user_id`,`title`,`body`,`read_at`,`created_at`,`updated_at`) VALUES
(1,3,'Application approved','Your application for "Frontend Developer" was approved.',NULL,NOW(),NOW()),
(2,3,'Report reviewed','Your report "Week 1 Report" has new feedback.',NULL,NOW(),NOW());

SET FOREIGN_KEY_CHECKS = 1;
