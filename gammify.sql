-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for gammify
DROP DATABASE IF EXISTS `gammify`;
CREATE DATABASE IF NOT EXISTS `gammify` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gammify`;

-- Dumping structure for table gammify.ticktacktoe
DROP TABLE IF EXISTS `ticktacktoe`;
CREATE TABLE IF NOT EXISTS `ticktacktoe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_x_id` int(10) unsigned NOT NULL DEFAULT '0',
  `player_o_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `game_key` varchar(255) NOT NULL,
  `move_currentPlayer` varchar(50) DEFAULT NULL,
  `move_element_id` varchar(50) DEFAULT NULL,
  `active_x` datetime DEFAULT NULL,
  `active_o` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `player_x_id` (`player_x_id`),
  KEY `player_o_id` (`player_o_id`),
  CONSTRAINT `FK_ticktacktoe_users` FOREIGN KEY (`player_x_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_ticktacktoe_users_2` FOREIGN KEY (`player_o_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gammify.ticktacktoe: ~0 rows (approximately)
/*!40000 ALTER TABLE `ticktacktoe` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticktacktoe` ENABLE KEYS */;

-- Dumping structure for table gammify.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `bg` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gammify.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
