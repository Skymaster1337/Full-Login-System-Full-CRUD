-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2018 at 03:47 AM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `login_profile`
--
CREATE DATABASE IF NOT EXISTS `login_profile` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `login_profile`;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `permissions_id` int(11) NOT NULL AUTO_INCREMENT,
  `permissions_name` varchar(50) NOT NULL,
  `permissions_cname` varchar(50) NOT NULL,
  PRIMARY KEY (`permissions_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permissions_id`, `permissions_name`, `permissions_cname`) VALUES
(1, 'Administration: Opret brugere', 'admin_opret_brugere'),
(2, 'Administration: Rediger brugere', 'admin_rediger_brugere'),
(3, 'Administration: Slet brugere', 'admin_slet_brugere'),
(4, 'Administration: Deaktiver brugere', 'admin_deaktiver_brugere'),
(5, 'Administration: Skift medlemmers brugernavn', 'admin_skift_medlemmers_username'),
(6, 'Administration: Skift moderatorers brugernavn', 'admin_skift_moderators_username'),
(7, 'Administration: Rediger spil', 'admin_rediger_spil'),
(8, 'Administration: Slet spil', 'admin_slet_spil'),
(9, 'Administration: Deaktiver spil', 'admin_deaktiver_spil'),
(10, 'Administration: Deaktiver specifikke downloads', 'admin_deaktiver_specifikke_downloads'),
(11, 'Administration: Rediger medlemmers kommentarer', 'admin_rediger_medlemmers_kommentarer'),
(12, 'Administration: Slet medlemmers kommentarer', 'admin_slet_medlemmers_kommentarer'),
(13, 'Administration: Rediger moderatorers kommentarer', 'admin_rediger_moderatorers_kommentarer'),
(14, 'Administration: Slet moderatorers kommentarer', 'admin_slet_moderatorers_kommentarer'),
(15, 'Registrer profil', 'registrer_profil'),
(16, 'Upload spil', 'upload_spil'),
(17, 'Rediger egne spil', 'rediger_egne_spil'),
(18, 'Slet egne spil', 'slet_egne_spil'),
(19, 'Rate spil', 'rate_spil'),
(20, 'Download spil', 'download_spil'),
(21, 'Læs kommentarer', 'laes_kommentarer'),
(22, 'Skriv kommentarer', 'skriv_kommentarer'),
(23, 'Tilmeld og frameld nyhedsbrev', 'tilmeld_og_frameld_nyhedsbrev'),
(24, 'Spil online', 'spil_online');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(2) NOT NULL DEFAULT '1',
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `order`, `role_name`) VALUES
(1, 9, 'ADMIN'),
(2, 8, 'MODERATOR'),
(3, 1, 'MEMBER'),
(4, 0, 'GUEST');

-- --------------------------------------------------------

--
-- Table structure for table `roles_and_permissions`
--

CREATE TABLE IF NOT EXISTS `roles_and_permissions` (
  `insertId` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'This is for the Specific Role',
  `uid` int(11) NOT NULL COMMENT 'Linking to the User''s account',
  `permission_id` int(11) NOT NULL COMMENT 'Linking to the Role and it''s permissions',
  PRIMARY KEY (`insertId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `roles_and_permissions`
--

INSERT INTO `roles_and_permissions` (`insertId`, `uid`, `permission_id`) VALUES
(1, 34, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(30) DEFAULT NULL,
  `upass` varchar(200) DEFAULT NULL,
  `uemail` varchar(70) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(60) NOT NULL,
  `address` varchar(100) NOT NULL,
  `zipcode` varchar(6) NOT NULL DEFAULT '000000',
  `city` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `upass`, `uemail`, `fname`, `lname`, `address`, `zipcode`, `city`, `phone`) VALUES
(34, 'spar', 'f412a2010eb6625c85ebe505e051e18008501c5e', 'master@thehouse.co.uk', 'Spar', 'Admin', '123 FakeIt Road Ave', '000000', 'WWW', '8885554455'),
(35, 'hej', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'hej@live.dk', 'hej', 'hej', '', '123456', '', '0'),
(36, 'test', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'test@live.dk', 'test', 'test', '', '123456', '', '0'),
(37, 'noob', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'noob@two.o', 'Noob', 'Noob', '', '123456', '', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
