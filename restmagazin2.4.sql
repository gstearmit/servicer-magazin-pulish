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


-- Dumping structure for table restmagazin.album
CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8;

-- Dumping data for table restmagazin.album: ~153 rows (approximately)
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` (`id`, `artist`, `title`, `genre`) VALUES
	(1, 'ho ngoc ha', 'can nha trong', 'jazz'),
	(11, 'bai viet hay', 'tran hong nghiem', 'country'),
	(14, 'Hoàng Hà', 'Trần trọng kim', NULL),
	(15, 'Để rồi mà', 'Hoàn Thành đi', NULL),
	(16, 'David Bowie', 'The Next Day (Deluxe Version)', NULL),
	(17, 'Bastille', 'Bad Blood', 'rap'),
	(18, 'Bruno Mars', 'Unorthodox Jukebox', NULL),
	(19, 'Emeli Sandé', 'Our Version of Events (Special Edition)', NULL),
	(20, 'Bon Jovi', 'What About Now (Deluxe Version)', 'country'),
	(21, 'Justin Timberlake', 'The 20/20 Experience (Deluxe Version)', NULL),
	(22, 'Bastille', 'Bad Blood (The Extended Cut)', NULL),
	(23, 'P!nk', 'The Truth About Love', NULL),
	(24, 'Sound City - Real to Reel', 'Sound City - Real to Reel', NULL),
	(25, 'Jake Bugg', 'Jake Bugg', NULL),
	(26, 'Various Artists', 'The Trevor Nelson Collection', NULL),
	(27, 'David Bowie', 'The Next Day', NULL),
	(28, 'Mumford & Sons', 'Babel', NULL),
	(29, 'The Lumineers', 'The Lumineers', NULL),
	(30, 'Various Artists', 'Get Ur Freak On - R&B Anthems', NULL),
	(31, 'The 1975', 'Music For Cars EP', NULL),
	(32, 'Various Artists', 'Saturday Night Club Classics - Ministry of Sound', NULL),
	(33, 'Hurts', 'Exile (Deluxe)', NULL),
	(35, 'Ben Howard', 'Every Kingdom', NULL),
	(36, 'Stereophonics', 'Graffiti On the Train', NULL),
	(37, 'The Script', '#3', NULL),
	(38, 'Stornoway', 'Tales from Terra Firma', NULL),
	(39, 'David Bowie', 'Hunky Dory (Remastered)', NULL),
	(40, 'Worship Central', 'Let It Be Known (Live)', NULL),
	(41, 'Ellie Goulding', 'Halcyon', NULL),
	(42, 'Various Artists', 'Dermot O\'Leary Presents the Saturday Sessions 2013', NULL),
	(43, 'Stereophonics', 'Graffiti On the Train (Deluxe Version)', NULL),
	(44, 'Dido', 'Girl Who Got Away (Deluxe)', NULL),
	(45, 'Hurts', 'Exile', NULL),
	(46, 'Bruno Mars', 'Doo-Wops & Hooligans', NULL),
	(47, 'Calvin Harris', '18 Months', NULL),
	(48, 'Olly Murs', 'Right Place Right Time', NULL),
	(49, 'Alt-J (?)', 'An Awesome Wave', NULL),
	(50, 'One Direction', 'Take Me Home', NULL),
	(51, 'Various Artists', 'Pop Stars', NULL),
	(52, 'Various Artists', 'Now That\'s What I Call Music! 83', NULL),
	(53, 'John Grant', 'Pale Green Ghosts', NULL),
	(54, 'Paloma Faith', 'Fall to Grace', NULL),
	(55, 'Laura Mvula', 'Sing To the Moon (Deluxe)', NULL),
	(56, 'Duke Dumont', 'Need U (100%) [feat. A*M*E] - EP', NULL),
	(57, 'Watsky', 'Cardboard Castles', NULL),
	(58, 'Blondie', 'Blondie: Greatest Hits', NULL),
	(59, 'Foals', 'Holy Fire', NULL),
	(60, 'Maroon 5', 'Overexposed', NULL),
	(61, 'Bastille', 'Pompeii (Remixes) - EP', NULL),
	(62, 'Imagine Dragons', 'Hear Me - EP', NULL),
	(63, 'Various Artists', '100 Hits: 80s Classics', NULL),
	(64, 'Various Artists', 'Les Misérables (Highlights From the Motion Picture Soundtrack)', NULL),
	(65, 'Mumford & Sons', 'Sigh No More', NULL),
	(66, 'Frank Ocean', 'Channel ORANGE', NULL),
	(67, 'Bon Jovi', 'What About Now', NULL),
	(68, 'Various Artists', 'BRIT Awards 2013', NULL),
	(69, 'Taylor Swift', 'Red', NULL),
	(70, 'Fleetwood Mac', 'Fleetwood Mac: Greatest Hits', NULL),
	(71, 'David Guetta', 'Nothing But the Beat Ultimate', NULL),
	(72, 'Various Artists', 'Clubbers Guide 2013 (Mixed By Danny Howard) - Ministry of Sound', NULL),
	(73, 'David Bowie', 'Best of Bowie', NULL),
	(74, 'Laura Mvula', 'Sing To the Moon', NULL),
	(75, 'ADELE', '21', NULL),
	(76, 'Of Monsters and Men', 'My Head Is an Animal', NULL),
	(77, 'Rihanna', 'Unapologetic', NULL),
	(78, 'Various Artists', 'BBC Radio 1\'s Live Lounge - 2012', NULL),
	(79, 'Avicii & Nicky Romero', 'I Could Be the One (Avicii vs. Nicky Romero)', NULL),
	(80, 'The Streets', 'A Grand Don\'t Come for Free', NULL),
	(81, 'Tim McGraw', 'Two Lanes of Freedom', NULL),
	(82, 'Foo Fighters', 'Foo Fighters: Greatest Hits', NULL),
	(83, 'Various Artists', 'Now That\'s What I Call Running!', NULL),
	(84, 'Swedish House Mafia', 'Until Now', NULL),
	(85, 'The xx', 'Coexist', NULL),
	(86, 'Five', 'Five: Greatest Hits', NULL),
	(87, 'Jimi Hendrix', 'People, Hell & Angels', NULL),
	(88, 'Biffy Clyro', 'Opposites (Deluxe)', NULL),
	(89, 'The Smiths', 'The Sound of the Smiths', NULL),
	(90, 'The Saturdays', 'What About Us - EP', NULL),
	(91, 'Fleetwood Mac', 'Rumours', NULL),
	(92, 'Various Artists', 'The Big Reunion', NULL),
	(93, 'Various Artists', 'Anthems 90s - Ministry of Sound', NULL),
	(94, 'The Vaccines', 'Come of Age', NULL),
	(95, 'Nicole Scherzinger', 'Boomerang (Remixes) - EP', NULL),
	(96, 'Bob Marley', 'Legend (Bonus Track Version)', NULL),
	(97, 'Josh Groban', 'All That Echoes', NULL),
	(98, 'Blue', 'Best of Blue', NULL),
	(99, 'Ed Sheeran', '+', NULL),
	(100, 'Olly Murs', 'In Case You Didn\'t Know (Deluxe Edition)', NULL),
	(101, 'Macklemore & Ryan Lewis', 'The Heist (Deluxe Edition)', NULL),
	(102, 'Various Artists', 'Defected Presents Most Rated Miami 2013', NULL),
	(103, 'Gorgon City', 'Real EP', NULL),
	(104, 'Mumford & Sons', 'Babel (Deluxe Version)', NULL),
	(105, 'Various Artists', 'The Music of Nashville: Season 1, Vol. 1 (Original Soundtrack)', NULL),
	(106, 'Various Artists', 'The Twilight Saga: Breaking Dawn, Pt. 2 (Original Motion Picture Soundtrack)', NULL),
	(107, 'Various Artists', 'Mum - The Ultimate Mothers Day Collection', NULL),
	(108, 'One Direction', 'Up All Night', NULL),
	(109, 'Bon Jovi', 'Bon Jovi Greatest Hits', NULL),
	(110, 'Agnetha Fältskog', 'A', NULL),
	(111, 'Fun.', 'Some Nights', NULL),
	(112, 'Justin Bieber', 'Believe Acoustic', NULL),
	(113, 'Atoms for Peace', 'Amok', NULL),
	(114, 'Justin Timberlake', 'Justified', NULL),
	(115, 'Passenger', 'All the Little Lights', NULL),
	(116, 'Kodaline', 'The High Hopes EP', NULL),
	(117, 'Lana Del Rey', 'Born to Die', NULL),
	(118, 'JAY Z & Kanye West', 'Watch the Throne (Deluxe Version)', NULL),
	(119, 'Biffy Clyro', 'Opposites', NULL),
	(120, 'Various Artists', 'Return of the 90s', NULL),
	(121, 'Gabrielle Aplin', 'Please Don\'t Say You Love Me - EP', NULL),
	(122, 'Various Artists', '100 Hits - Driving Rock', NULL),
	(123, 'Jimi Hendrix', 'Experience Hendrix - The Best of Jimi Hendrix', NULL),
	(124, 'Various Artists', 'The Workout Mix 2013', NULL),
	(125, 'The 1975', 'Sex', NULL),
	(126, 'Chase & Status', 'No More Idols', NULL),
	(127, 'Rihanna', 'Unapologetic (Deluxe Version)', NULL),
	(128, 'The Killers', 'Battle Born', NULL),
	(129, 'Olly Murs', 'Right Place Right Time (Deluxe Edition)', NULL),
	(130, 'A$AP Rocky', 'LONG.LIVE.A$AP (Deluxe Version)', NULL),
	(131, 'Various Artists', 'Cooking Songs', NULL),
	(132, 'Haim', 'Forever - EP', NULL),
	(133, 'Lianne La Havas', 'Is Your Love Big Enough?', NULL),
	(134, 'Michael Bublé', 'To Be Loved', NULL),
	(135, 'Daughter', 'If You Leave', NULL),
	(137, 'Eminem', 'Curtain Call', NULL),
	(138, 'Kendrick Lamar', 'good kid, m.A.A.d city (Deluxe)', NULL),
	(139, 'Disclosure', 'The Face - EP', NULL),
	(140, 'Palma Violets', '180', NULL),
	(141, 'Cody Simpson', 'Paradise', NULL),
	(142, 'Ed Sheeran', '+ (Deluxe Version)', NULL),
	(143, 'Michael Bublé', 'Crazy Love (Hollywood Edition)', NULL),
	(144, 'Bon Jovi', 'Bon Jovi Greatest Hits - The Ultimate Collection', NULL),
	(145, 'Rita Ora', 'Ora', NULL),
	(146, 'g33k', 'Spabby', NULL),
	(147, 'Various Artists', 'Annie Mac Presents 2012', NULL),
	(148, 'David Bowie', 'The Platinum Collection', NULL),
	(149, 'Bridgit Mendler', 'Ready or Not (Remixes) - EP', NULL),
	(150, 'Dido', 'Girl Who Got Away', NULL),
	(151, 'Various Artists', 'Now That\'s What I Call Disney', NULL),
	(152, 'The 1975', 'Facedown - EP', NULL),
	(153, 'Kodaline', 'The Kodaline - EP', NULL),
	(154, 'Various Artists', '100 Hits: Super 70s', NULL),
	(155, 'Fred V & Grafix', 'Goggles - EP', NULL),
	(156, 'Biffy Clyro', 'Only Revolutions (Deluxe Version)', NULL),
	(157, 'Train', 'California 37', NULL),
	(158, 'Ben Howard', 'Every Kingdom (Deluxe Edition)', NULL),
	(159, 'Various Artists', 'Motown Anthems', NULL),
	(160, 'Courteeners', 'ANNA', NULL),
	(161, 'Johnny Marr', 'The Messenger', NULL),
	(162, 'Rodriguez', 'Searching for Sugar Man', NULL),
	(163, 'Jessie Ware', 'Devotion', NULL),
	(164, 'Bruno Mars', 'Unorthodox Jukebox', NULL),
	(165, 'Various Artists', 'Call the Midwife (Music From the TV Series)', NULL),
	(176, 'ậksajkajsakjksjaksajska', 'trándsadsdskk', NULL);
/*!40000 ALTER TABLE `album` ENABLE KEYS */;


-- Dumping structure for table restmagazin.booknew
CREATE TABLE IF NOT EXISTS `booknew` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

-- Dumping data for table restmagazin.booknew: ~1 rows (approximately)
/*!40000 ALTER TABLE `booknew` DISABLE KEYS */;
INSERT INTO `booknew` (`id`, `artist`, `title`) VALUES
	(177, 'testt', 'test book new');
/*!40000 ALTER TABLE `booknew` ENABLE KEYS */;


-- Dumping structure for table restmagazin.magazinepublish
CREATE TABLE IF NOT EXISTS `magazinepublish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `descriptionkey` varchar(100) NOT NULL,
  `imgkey` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

-- Dumping data for table restmagazin.magazinepublish: ~28 rows (approximately)
/*!40000 ALTER TABLE `magazinepublish` DISABLE KEYS */;
INSERT INTO `magazinepublish` (`id`, `title`, `descriptionkey`, `imgkey`) VALUES
	(1, 'Test', 'Test', 'Page_026.JPG'),
	(2, 'SUBMISSION GUIDELINE', 'If you want to contribute with the next number,', 'Page_001.JPG'),
	(3, 'Photo nice', 'very nice', 'Page_224.JPG'),
	(4, 'Test NUll', 'all Null', 'Page_003.JPG'),
	(5, 'News', 'Very good', 'Page_002.JPG'),
	(14, 'SUBMISSION GUIDELINE', 'If you want to contribute with the next number,', 'Page_003.JPG'),
	(15, 'SUBMISSION GUIDELINE', 'If you want to contribute with the next number,', 'Page_135.JPG'),
	(16, 'The Next Day (Deluxe Version)', 'David Bowie', 'Page_026.JPG'),
	(17, 'Bad Blood', 'Bastille', 'Page_009.JPG'),
	(18, 'Unorthodox Jukebox', 'Bruno Mars', 'Page_047.JPG'),
	(20, 'What About Now (Deluxe Version)', 'Bon Jovi', 'Page_128.JPG'),
	(21, 'The 20/20 Experience (Deluxe Version)', 'Justin Timberlake', 'Page_115.JPG'),
	(25, 'twet  zxzxzx', 'Chillwave hoodie ea gentrify aute sriracha consequat', 'Page_139.JPG'),
	(26, 'Chillwave', 'Chillwave hoodie ea gentrify aute sriracha consequat', 'Page_129.JPG'),
	(29, 'SUBMISSION GUIDELINE', 'Se volete partecipare', 'Page_168.JPG'),
	(30, 'SUBMISSION GUIDELINE', 'Se volete partecipare', 'Page_165.JPG'),
	(31, 'SUBMISSION GUIDELINE', 'Se volete partecipare', 'Page_217.JPG'),
	(32, 'SUBMISSION GUIDELINE', 'Se volete partecipare', 'Page_224.JPG'),
	(33, 'SUBMISSION GUIDELINE', 'Se volete partecipare', 'Page_228.JPG'),
	(34, 'SUBMISSION GUIDELINE', 'Se volete partecipare', 'Page_231.JPG'),
	(35, 'SUBMISSION GUIDELINE', 'Se volete partecipare', 'Page_126.JPG'),
	(50, 'SUBMISSION GUIDELINE', 'Se volete partecipare', 'Page_225.JPG'),
	(51, 'tattooed iPhon', 'Chillwave hoodie ea gentrify aute sriracha consequat', 'Page_08.JPG'),
	(81, 'ssd', 'cxcxcxcxcxcxcxcx', 'Page_01.JPG'),
	(82, 'ereer', 'ererere', 'Page_02.JPG'),
	(86, '123345555', 'cvcvcvcvcvcvcvcvc', 'Page_03.JPG'),
	(87, '1221sdzeqwqezz', 'asaasaasasassa', 'Page_01.JPG'),
	(90, 'fdfd', 'fdffd', 'e41417bda70afe4a4966a45eaab0beda.png');
/*!40000 ALTER TABLE `magazinepublish` ENABLE KEYS */;


-- Dumping structure for table restmagazin.mzimg
CREATE TABLE IF NOT EXISTS `mzimg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmz` int(11) NOT NULL COMMENT 'quan he 1 -1 table magazinepublish',
  `img` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL COMMENT 'them vao the p cua detaill 2',
  `title` varchar(100) NOT NULL COMMENT 'h3 cua detaill 2',
  `page` varchar(100) NOT NULL COMMENT 'servicer 1 . vi du : title:"Cover"',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- Dumping data for table restmagazin.mzimg: ~37 rows (approximately)
/*!40000 ALTER TABLE `mzimg` DISABLE KEYS */;
INSERT INTO `mzimg` (`id`, `idmz`, `img`, `description`, `title`, `page`) VALUES
	(1, 1, 'Page_026.JPG', 'test2', 'test2', 'page 1'),
	(2, 1, 'Page_033.JPG', 'testmz1', 'testmz1', 'page2'),
	(11, 3, 'Page_057.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'Exercitation occaecat', 'Page one'),
	(13, 3, 'car_magazine_1.jpg', 'Ex disrupt cray yr, butcher pour-over magna umami kitsch before they sold out commodo.', 'Brunch semiotics', 'Page one'),
	(14, 3, 'Page_002.JPG', 'Pariatur food truck street art consequat sustainable, et kogi beard qui paleo.', 'Chillwave nihil occupy', 'Page 4'),
	(15, 3, 'Page_033.JPG', 'Ex disrupt cray yr, butcher pour-over magna umami kitsch before they sold out commodo', 'velit chia Kale chips lomo biodiesel', 'Page 4'),
	(16, 3, 'Page_003.JPG', 'Exercitation occaecat Street chillwave hoodie ea gentrify.', 'Brunch  velit chia semiotics', 'Page two'),
	(17, 2, 'Page_033.JPG', 'Bastille tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo', 'Kale chips lomo biodiesel', 'Page one'),
	(18, 13, 'car_magazine_1.jpg', 'Bruno Mars tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical pale', 'velit chia Brunch semiotics', ''),
	(19, 2, 'Page_009.JPG', 'Emeli Sandé Emeli Sandé', 'Emeli Sandé', 'page 4'),
	(20, 2, 'Page_026.JPG', 'Chillwave hoodie ea gentrify aute sriracha', 'Chillwave ', 'page 5'),
	(22, 2, 'car_magazine_1.jpg', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo', 'tattooed iPhon', 'page one'),
	(23, 2, 'Page_006.JPG', 'Additional study references', 'Additional study references', 'Page 6'),
	(24, 2, 'Page_07.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page 7'),
	(25, 13, 'Page_013.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page 1'),
	(26, 14, 'Page_014.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page 1'),
	(27, 15, 'Page_18.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page one'),
	(28, 16, 'Page_007.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page 7'),
	(29, 15, 'Page_001.JPG', 'If you want to contribute with the next number,', 'SUBMISSION GUIDELINE', 'page 1'),
	(30, 15, 'Page_002.JPG', 'If you want to contribute with the next number,', 'SUBMISSION GUIDELINE', 'page 2'),
	(31, 15, 'Page_003.JPG', 'If you want to contribute with the next number,', 'Exercitation occaecat', 'page 3'),
	(32, 15, 'Page_004.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'page 4'),
	(33, 15, 'Page_005.JPG', 'If you want to contribute with the next number,', 'The 20/20 Experience (Deluxe Version)', 'page 5'),
	(34, 14, 'Page_006.JPG', 'Bastille', 'Bad Blood', 'page 2'),
	(35, 14, 'Page_007.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'Bad Blood', 'page 3'),
	(36, 14, 'Page_008.JPG', 'Bastille', 'Exercitation occaecat', 'page 4'),
	(37, 13, 'Page_007.JPG', 'Bastille', 'Exercitation occaecat', 'page 3'),
	(38, 13, 'Page_008.JPG', 'If you want to contribute with the next number,', 'Bad Blood', 'page 4'),
	(39, 2, 'Page_027.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page 2'),
	(40, 32, 'Page_072.JPG', 'test3', 'test3', 'Page 2'),
	(41, 3, 'Page_033.JPG', 'test3', 'test3', 'Page 1'),
	(42, 35, 'Page_025.JPG', 'If you want to contribute with the next number,', 'SUBMISSION GUIDELINE', 'Page one'),
	(43, 35, 'Page_030.JPG', 'Ex disrupt cray yr, butcher pour-over magna umami kitsch before they sold out commodo', 'SUBMISSION GUIDELINE', 'Page one'),
	(44, 34, 'Page_025.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page 2'),
	(45, 34, 'Page_018.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page 2'),
	(46, 33, 'Page_036.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo.', 'SUBMISSION GUIDELINE', 'Page 2'),
	(52, 14, 'age_002.JPG', 'Laborum tattooed iPhone, Schlitz irure nulla Tonx retro 90\'s chia cardigan quis asymmetrical paleo', 'Laborum tattooed', 'page 4');
/*!40000 ALTER TABLE `mzimg` ENABLE KEYS */;


-- Dumping structure for table restmagazin.permission
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(45) NOT NULL,
  `resource_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table restmagazin.permission: ~4 rows (approximately)
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` (`id`, `permission_name`, `resource_id`) VALUES
	(1, 'index', 1),
	(2, 'index', 2),
	(3, 'show', 1),
	(4, 'test', 1);
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;


-- Dumping structure for table restmagazin.resource
CREATE TABLE IF NOT EXISTS `resource` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table restmagazin.resource: ~4 rows (approximately)
/*!40000 ALTER TABLE `resource` DISABLE KEYS */;
INSERT INTO `resource` (`id`, `resource_name`) VALUES
	(1, 'Application\\Controller\\Index'),
	(2, 'ZF2AuthAcl\\Controller\\Index'),
	(3, 'Application\\Controller\\Index'),
	(4, 'ZF2AuthAcl\\Controller\\Index');
/*!40000 ALTER TABLE `resource` ENABLE KEYS */;


-- Dumping structure for table restmagazin.role
CREATE TABLE IF NOT EXISTS `role` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table restmagazin.role: ~3 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`rid`, `role_name`, `status`) VALUES
	(1, 'Role1', 'Active'),
	(2, 'Role2', 'Active'),
	(3, 'Role3', 'Active');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;


-- Dumping structure for table restmagazin.role_permission
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table restmagazin.role_permission: ~8 rows (approximately)
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 1, 4),
	(5, 2, 1),
	(6, 2, 2),
	(7, 3, 1),
	(8, 3, 3);
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;


-- Dumping structure for table restmagazin.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `status` varchar(128) NOT NULL,
  `state` smallint(6) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Dumping data for table restmagazin.user: ~8 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `username`, `email`, `display_name`, `password`, `status`, `state`, `first_name`, `last_name`) VALUES
	(1, NULL, 'example.1@example.com', NULL, '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y', NULL, NULL, NULL),
	(2, NULL, 'example.2@example.com', NULL, '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y', NULL, NULL, NULL),
	(3, NULL, 'example.3@example.com', NULL, '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y', NULL, NULL, NULL),
	(23, 'Admin', 'phuca4@gmail.com', 'admin', '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', '', NULL, NULL, NULL),
	(24, 'Hoang Phuc', 'phuca478@gmail.com', 'superadmin', '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', '', 1, NULL, NULL),
	(25, NULL, 'tranhuong0493@gmail.com', NULL, '$2y$14$fL9adnmkhCiY5UR9ybv8Y.mwYK1h23XUucwdG9hxArht/Q40j8gYK', '', NULL, NULL, NULL),
	(26, NULL, 'tranhang.90hn@gmail.com', NULL, '$2y$14$uLHlUQ7M1CUKafi4UV/MX.YgPIPXblyqwhIcHPIeIZzHHhLYQEsIy', '', NULL, NULL, NULL),
	(27, NULL, 'vietnamict91@gmail.com', NULL, '$2y$14$WIEb3acvw7JqW2rqRChE6eYEvZYNLrYXWb0g60kL8tsH8KSISCFLG', '', NULL, NULL, NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for table restmagazin.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_role` (`role_id`),
  KEY `idx_parent_id` (`parent_id`),
  CONSTRAINT `fk_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `user_role` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table restmagazin.user_role: ~3 rows (approximately)
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`id`, `role_id`, `is_default`, `parent_id`, `user_id`) VALUES
	(1, '1', 0, NULL, 1),
	(2, '2', 0, NULL, 2),
	(3, '3', 0, NULL, 3);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;


-- Dumping structure for table restmagazin.user_role_linker
CREATE TABLE IF NOT EXISTS `user_role_linker` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table restmagazin.user_role_linker: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_role_linker` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role_linker` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
