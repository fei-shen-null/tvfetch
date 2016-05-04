/*
Navicat MariaDB Data Transfer

Source Server         : localhost
Source Server Version : 100106
Source Host           : localhost:3306
Source Database       : tvfetch

Target Server Type    : MariaDB
Target Server Version : 100106
File Encoding         : 65001

Date: 2016-05-04 16:22:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for episodes
-- ----------------------------
DROP TABLE IF EXISTS `episodes`;
CREATE TABLE `episodes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tv_id` int(11) NOT NULL,
  `href` text NOT NULL,
  `txt` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `tv_id` (`tv_id`) USING BTREE,
  CONSTRAINT `episodes_ibfk_1` FOREIGN KEY (`tv_id`) REFERENCES `tv` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5850 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for subscribe_to_new_tv
-- ----------------------------
DROP TABLE IF EXISTS `subscribe_to_new_tv`;
CREATE TABLE `subscribe_to_new_tv` (
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`) USING HASH,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for subscribe_tv
-- ----------------------------
DROP TABLE IF EXISTS `subscribe_tv`;
CREATE TABLE `subscribe_tv` (
  `tv_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`tv_id`),
  KEY `tv_id` (`tv_id`,`user_id`),
  CONSTRAINT `subscribe_tv_ibfk_1` FOREIGN KEY (`tv_id`) REFERENCES `tv` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subscribe_tv_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tv
-- ----------------------------
DROP TABLE IF EXISTS `tv`;
CREATE TABLE `tv` (
  `id` int(11) NOT NULL,
  `day_of_week` varchar(255) DEFAULT NULL,
  `name_cn` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tv_list
-- ----------------------------
DROP TABLE IF EXISTS `tv_list`;
CREATE TABLE `tv_list` (
  `tv_id` int(11) NOT NULL,
  PRIMARY KEY (`tv_id`),
  KEY `tv_id` (`tv_id`),
  CONSTRAINT `tv_list_ibfk_1` FOREIGN KEY (`tv_id`) REFERENCES `tv` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
