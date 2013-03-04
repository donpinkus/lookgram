-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2013 at 04:39 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `mirrorme`
--

-- --------------------------------------------------------

--
-- Table structure for table `follower_directory`
--

CREATE TABLE `follower_directory` (
  `follower_id` int(9) NOT NULL,
  `followee_id` int(9) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follower_directory`
--


-- --------------------------------------------------------

--
-- Table structure for table `photo_descriptions`
--

CREATE TABLE `photo_descriptions` (
  `photo_id` int(10) NOT NULL,
  `photo_description` text NOT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photo_descriptions`
--

INSERT INTO `photo_descriptions` VALUES(94, 'Can''t tell if this suit is super fancy or super cheap, but I like the cut.');
INSERT INTO `photo_descriptions` VALUES(95, 'What are our thoughts on pea coats? \r\n\r\nBlack or gray?');
INSERT INTO `photo_descriptions` VALUES(96, '''Red Strongman Henley'' from Betabrand... ');
INSERT INTO `photo_descriptions` VALUES(97, 'Best kicks ever - adidas samba');
INSERT INTO `photo_descriptions` VALUES(98, 'Hiking boots? ');
INSERT INTO `photo_descriptions` VALUES(100, 'Getting my prep on.');
INSERT INTO `photo_descriptions` VALUES(101, 'Pretty cool pea coat, I think the bottom may look a bit too much like a skirt though...');
INSERT INTO `photo_descriptions` VALUES(102, 'Greek style.');
INSERT INTO `photo_descriptions` VALUES(103, 'Sweet blue sweater. Usually I''m not a fan of v-necks but this is cool.');
INSERT INTO `photo_descriptions` VALUES(104, 'Polos are nerdy unless you''re ripped?');
INSERT INTO `photo_descriptions` VALUES(105, 'Army green actually works on this one. Not sure if you could wear it with jeans though...');
INSERT INTO `photo_descriptions` VALUES(106, 'Sweet combo. I want that sweater, anyone know where to get it?');
INSERT INTO `photo_descriptions` VALUES(107, 'Blue suits are in');
INSERT INTO `photo_descriptions` VALUES(108, 'Cowboy?');
INSERT INTO `photo_descriptions` VALUES(109, 'This suit looks awesome in a photo, wonder how that material is in reality.');
INSERT INTO `photo_descriptions` VALUES(110, 'Matt Damon...\r\n\r\nBut seriously that is a cool coat.');
INSERT INTO `photo_descriptions` VALUES(111, 'Cargo pants are coming back?');
INSERT INTO `photo_descriptions` VALUES(112, 'I <3 flannel.');
INSERT INTO `photo_descriptions` VALUES(113, 'Sweet monocle!');
INSERT INTO `photo_descriptions` VALUES(114, 'This isn''t a look....');
INSERT INTO `photo_descriptions` VALUES(115, 'Superman that ho.');

-- --------------------------------------------------------

--
-- Table structure for table `photo_directory`
--

CREATE TABLE `photo_directory` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time_uploaded` datetime NOT NULL,
  `extension` varchar(20) NOT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `photo_directory`
--

INSERT INTO `photo_directory` VALUES(13, 8, '2012-12-03 09:09:33', '.jpeg');
INSERT INTO `photo_directory` VALUES(14, 9, '2012-12-03 09:10:12', '.jpeg');
INSERT INTO `photo_directory` VALUES(15, 9, '2012-12-03 09:10:21', '.jpeg');
INSERT INTO `photo_directory` VALUES(16, 10, '2012-12-03 09:12:09', '.jpeg');
INSERT INTO `photo_directory` VALUES(17, 10, '2012-12-03 09:12:20', '.jpeg');
INSERT INTO `photo_directory` VALUES(18, 10, '2012-12-03 09:12:46', '.jpeg');
INSERT INTO `photo_directory` VALUES(19, 9, '2012-12-03 09:13:12', '.jpeg');
INSERT INTO `photo_directory` VALUES(94, 1, '2012-12-25 13:03:41', '.jpeg');
INSERT INTO `photo_directory` VALUES(95, 1, '2012-12-25 13:08:36', '.jpeg');
INSERT INTO `photo_directory` VALUES(96, 1, '2012-12-25 13:12:43', '.jpeg');
INSERT INTO `photo_directory` VALUES(97, 1, '2012-12-25 13:19:41', '.jpeg');
INSERT INTO `photo_directory` VALUES(98, 1, '2012-12-25 14:46:09', '.jpeg');
INSERT INTO `photo_directory` VALUES(100, 1, '2012-12-25 14:53:12', '.jpeg');
INSERT INTO `photo_directory` VALUES(101, 1, '2012-12-25 15:12:14', '.jpeg');
INSERT INTO `photo_directory` VALUES(102, 1, '2012-12-25 15:16:33', '.jpeg');
INSERT INTO `photo_directory` VALUES(103, 11, '2012-12-25 23:44:57', '.jpeg');
INSERT INTO `photo_directory` VALUES(104, 11, '2012-12-25 23:47:35', '.jpeg');
INSERT INTO `photo_directory` VALUES(105, 11, '2012-12-25 23:48:41', '.jpeg');
INSERT INTO `photo_directory` VALUES(106, 11, '2012-12-25 23:55:34', '.jpeg');
INSERT INTO `photo_directory` VALUES(107, 11, '2012-12-25 23:56:30', '.jpeg');
INSERT INTO `photo_directory` VALUES(108, 11, '2012-12-25 23:59:37', '.jpeg');
INSERT INTO `photo_directory` VALUES(109, 11, '2012-12-26 00:01:18', '.jpeg');
INSERT INTO `photo_directory` VALUES(110, 11, '2012-12-26 00:02:23', '.jpeg');
INSERT INTO `photo_directory` VALUES(111, 11, '2012-12-26 00:04:32', '.jpeg');
INSERT INTO `photo_directory` VALUES(112, 13, '2013-01-06 12:38:52', '.jpeg');
INSERT INTO `photo_directory` VALUES(113, 13, '2013-01-08 22:23:35', '.png');
INSERT INTO `photo_directory` VALUES(114, 14, '2013-02-06 14:07:16', '.jpeg');
INSERT INTO `photo_directory` VALUES(115, 1, '2013-02-06 16:29:14', '.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `photo_tags`
--

CREATE TABLE `photo_tags` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `photo_id` int(10) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `article` varchar(30) NOT NULL,
  `brand` varchar(30) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `attributes` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `photo_tags`
--

INSERT INTO `photo_tags` VALUES(1, 88, '', 'shirt', 'zara', NULL, NULL);
INSERT INTO `photo_tags` VALUES(2, 94, 'men', 'suit', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(3, 95, 'men', 'coat', 'Betabrand', NULL, NULL);
INSERT INTO `photo_tags` VALUES(4, 96, 'men', 'shirt', 'Betabrand', NULL, NULL);
INSERT INTO `photo_tags` VALUES(5, 97, 'men', 'shoes', 'adidas', NULL, NULL);
INSERT INTO `photo_tags` VALUES(6, 98, 'men', 'shoes', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(7, 100, 'men', 'shoes', 'Sperrys Topsiders', NULL, NULL);
INSERT INTO `photo_tags` VALUES(8, 101, 'men', 'coat', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(9, 102, 'men', 'coat', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(10, 103, 'men', 'Sweater', 'H&M', NULL, NULL);
INSERT INTO `photo_tags` VALUES(11, 104, 'men', 'shirt', 'H&M', NULL, NULL);
INSERT INTO `photo_tags` VALUES(12, 105, 'men', 'coat', 'A.P.C.', NULL, NULL);
INSERT INTO `photo_tags` VALUES(13, 106, 'men', 'sweater', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(14, 106, 'men', 'suit', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(15, 107, 'men', 'suit', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(16, 108, 'men', 'coat', 'Dior', NULL, NULL);
INSERT INTO `photo_tags` VALUES(17, 109, 'men', 'suit', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(18, 110, 'men', 'coat', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(19, 111, 'men', 'sweater', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(20, 111, 'men', 'pants', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(21, 111, 'men', 'shirt', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(22, 112, 'male', 'shirt', 'Panhandle', NULL, NULL);
INSERT INTO `photo_tags` VALUES(23, 112, NULL, '', NULL, NULL, NULL);
INSERT INTO `photo_tags` VALUES(24, 113, 'men', 'shirt', 'H&M', NULL, NULL);
INSERT INTO `photo_tags` VALUES(25, 114, 'men', 'Shirt', 'h&M', NULL, NULL);
INSERT INTO `photo_tags` VALUES(26, 115, 'men', 'shirt', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `photo_votes`
--

CREATE TABLE `photo_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(9) NOT NULL,
  `photo_id` int(9) NOT NULL,
  `vote` int(3) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `photo_votes`
--

INSERT INTO `photo_votes` VALUES(51, 1, 102, -1, '2013-02-05 14:31:59');
INSERT INTO `photo_votes` VALUES(53, 1, 109, 1, '2013-02-05 14:32:04');
INSERT INTO `photo_votes` VALUES(59, 1, 103, 1, '2013-02-06 10:29:56');
INSERT INTO `photo_votes` VALUES(61, 1, 111, -1, '2013-02-06 10:30:01');
INSERT INTO `photo_votes` VALUES(65, 1, 97, 1, '2013-02-06 10:44:05');
INSERT INTO `photo_votes` VALUES(66, 13, 101, 1, '2013-02-06 10:44:32');
INSERT INTO `photo_votes` VALUES(67, 13, 108, 1, '2013-02-06 10:44:35');
INSERT INTO `photo_votes` VALUES(68, 13, 110, 1, '2013-02-06 10:44:37');
INSERT INTO `photo_votes` VALUES(69, 13, 103, 1, '2013-02-06 10:44:40');
INSERT INTO `photo_votes` VALUES(70, 13, 100, 1, '2013-02-06 10:44:44');
INSERT INTO `photo_votes` VALUES(71, 13, 97, 1, '2013-02-06 10:44:46');
INSERT INTO `photo_votes` VALUES(72, 13, 96, 1, '2013-02-06 10:44:48');
INSERT INTO `photo_votes` VALUES(73, 13, 107, 1, '2013-02-06 10:44:52');
INSERT INTO `photo_votes` VALUES(74, 14, 97, 1, '2013-02-06 14:04:34');
INSERT INTO `photo_votes` VALUES(76, 1, 96, 1, '2013-02-06 16:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE `user_auth` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_handle` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` VALUES(1, 'don', 'test');
INSERT INTO `user_auth` VALUES(3, 'someone', 'test');
INSERT INTO `user_auth` VALUES(4, 'newguy', 'test');
INSERT INTO `user_auth` VALUES(5, 'anotherbro', 'test');
INSERT INTO `user_auth` VALUES(6, 'BrianKim', 'test');
INSERT INTO `user_auth` VALUES(7, 'anothertester', 'don');
INSERT INTO `user_auth` VALUES(8, 'abominable_snowman', 'test');
INSERT INTO `user_auth` VALUES(9, 'suited_up', 'test');
INSERT INTO `user_auth` VALUES(10, 'flymolo', 'test');
INSERT INTO `user_auth` VALUES(11, 'hiphopera', 'test');
INSERT INTO `user_auth` VALUES(12, 'BKLounge', 'test');
INSERT INTO `user_auth` VALUES(13, 'dantan', 'test');
INSERT INTO `user_auth` VALUES(14, 'max', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `user_id`
--

CREATE TABLE `user_id` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `fb_id` int(20) DEFAULT NULL,
  `handle` varchar(20) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user_id`
--

INSERT INTO `user_id` VALUES(1, NULL, 'don', NULL, NULL);
INSERT INTO `user_id` VALUES(3, NULL, 'someone', NULL, NULL);
INSERT INTO `user_id` VALUES(4, NULL, 'newguy', NULL, NULL);
INSERT INTO `user_id` VALUES(5, NULL, 'anotherbro', NULL, NULL);
INSERT INTO `user_id` VALUES(6, NULL, 'BrianKim', NULL, NULL);
INSERT INTO `user_id` VALUES(7, NULL, 'anothertester', NULL, NULL);
INSERT INTO `user_id` VALUES(8, NULL, 'abominable_snowman', NULL, NULL);
INSERT INTO `user_id` VALUES(9, NULL, 'suited_up', NULL, NULL);
INSERT INTO `user_id` VALUES(10, NULL, 'flymolo', NULL, NULL);
INSERT INTO `user_id` VALUES(11, NULL, 'hiphopera', NULL, NULL);
INSERT INTO `user_id` VALUES(12, NULL, 'BKLounge', NULL, NULL);
INSERT INTO `user_id` VALUES(13, NULL, 'dantan', NULL, NULL);
INSERT INTO `user_id` VALUES(14, NULL, 'max', NULL, NULL);
