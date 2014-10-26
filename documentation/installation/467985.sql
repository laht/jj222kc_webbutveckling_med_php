-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 25, 2014 at 05:53 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `467985`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) NOT NULL,
  `commenterId` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`pk`, `comment`, `commenterId`, `ownerId`, `date`) VALUES
(3, 'asd', 1, 12, '2014-10-20 19:44:52'),
(4, 'tja linus', 1, 57, '2014-10-23 18:43:17'),
(5, 'adadadadadadad', 4, 57, '2014-10-23 18:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `postTitle` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `ownerId` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pk`, `postTitle`, `description`, `ownerId`, `image`) VALUES
(1, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(2, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(3, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(4, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(5, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(6, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(7, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(8, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(9, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(10, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(11, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(12, 'First test post', 'This is the first post ever made here okay mhm...', 1, 'images/first.jpg'),
(13, 'NU funkar allt', 'asd', 1, 'images/ndxb6bf1b2dcc226.JPG'),
(14, 'Laddar upp en bild', 'På ren pin tjiv', 1, 'images/ndy39wc3f4651cb4.jpg'),
(15, 'asdasd', 'asdasd', 1, 'images/ndyot8bff03e1508.jpg'),
(16, 'sfad', 'fsda', 1, 'images/ndyp6rd21489701e.jpg'),
(17, 'hfg', 'fghdd', 1, 'images/ndyp913080db648f.jpg'),
(18, 'fhg', 'dfhg', 1, 'images/ndyp9f76fc3d3162.jpg'),
(19, 'asdf', 'ad', 1, 'images/ne0lq09389a430c6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`pk`, `username`, `password`) VALUES
(1, 'admin', 'bfd59291e825b5f2bbf1eb76569f8fe7'),
(2, 'asd', '7815696ecbf1c96e6894b779456d330e'),
(3, 'uc6', '202cb962ac59075b964b07152d234b70'),
(4, 'Wretis', '1582164fc5bac843435debf8eebb6337');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
