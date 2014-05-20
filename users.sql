-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.8 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for restmagazin
CREATE DATABASE IF NOT EXISTS `restmagazin` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `restmagazin`;


-- Dumping structure for table restmagazin.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `status` varchar(128) NOT NULL,
  `state` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table restmagazin.user: ~5 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `username`, `email`, `display_name`, `password`, `status`, `state`) VALUES
	(1, 'Admin', 'phuca4@gmail.com', 'admin', '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', '', NULL),
	(2, 'Hoang Phuc', 'phuca478@gmail.com', 'superadmin', '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', '', 1),
	(3, NULL, 'tranhuong0493@gmail.com', NULL, '$2y$14$fL9adnmkhCiY5UR9ybv8Y.mwYK1h23XUucwdG9hxArht/Q40j8gYK', '', NULL),
	(4, NULL, 'tranhang.90hn@gmail.com', NULL, '$2y$14$uLHlUQ7M1CUKafi4UV/MX.YgPIPXblyqwhIcHPIeIZzHHhLYQEsIy', '', NULL),
	(5, NULL, 'vietnamict91@gmail.com', NULL, '$2y$14$WIEb3acvw7JqW2rqRChE6eYEvZYNLrYXWb0g60kL8tsH8KSISCFLG', '', NULL),
	(6, NULL, 'example.1@example.com', NULL, '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y', NULL),
	(7, NULL, 'example.2@example.com', NULL, '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y', NULL),
	(8, NULL, 'example.3@example.com', NULL, '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y', NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
