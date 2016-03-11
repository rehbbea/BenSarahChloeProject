-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2016 at 10:10 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `auctions`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_auctions`
--

CREATE TABLE IF NOT EXISTS `t_auctions` (
  `auction_id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `date_listed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_expires` datetime NOT NULL,
  `reserve_price` decimal(10,0) DEFAULT '0',
  `item_name` varchar(40) NOT NULL,
  `cat` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_price` decimal(10,0) DEFAULT '0',
  `pageviews` int(11) DEFAULT '0',
  `winnerid` int(11) DEFAULT NULL,
  `highest_bid` decimal(10,0) DEFAULT NULL,
  `w_notify` binary(1) DEFAULT NULL,
  `s_notify` binary(1) DEFAULT NULL,
  `sent` date DEFAULT NULL,
  `received` binary(1) DEFAULT NULL,
  `w_feedback` int(11) DEFAULT NULL,
  `s_feedback` int(11) DEFAULT NULL,
  `w_paid` tinyint(1) NOT NULL,
  `s_paid` tinyint(1) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`auction_id`),
  KEY `seller_id` (`seller_id`),
  KEY `cat` (`cat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `t_auctions`
--

INSERT INTO `t_auctions` (`auction_id`, `seller_id`, `date_listed`, `date_expires`, `reserve_price`, `item_name`, `cat`, `description`, `start_price`, `pageviews`, `winnerid`, `highest_bid`, `w_notify`, `s_notify`, `sent`, `received`, `w_feedback`, `s_feedback`, `w_paid`, `s_paid`, `img`) VALUES
(1, 1, '2016-02-27 10:32:54', '2016-03-08 00:00:00', '5', 'A golden Toilet', 4, 'Toilet made of solid gold', '1', 35, NULL, NULL, NULL, NULL, '2016-03-09', NULL, 1, 1, 0, 0, ''),
(2, 1, '2016-03-05 15:39:31', '2016-03-11 17:47:16', '500', 'A photocopy of Kylie''s bum', 4, 'Who would not want this?', '5', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, ''),
(3, 1, '2016-03-05 16:26:36', '2016-04-13 00:00:00', '0', 'Bark', 7, 'Lots of bark. Don''t ask', '0', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, ''),
(16, 17, '2016-03-05 20:53:01', '2016-03-11 10:34:17', '0', 'bum', 7, 'lalala', '0', 15, NULL, NULL, NULL, NULL, '2016-03-11', NULL, NULL, 4, 0, 0, ''),
(35, 1, '2016-03-09 22:27:16', '2016-03-10 23:27:16', '45', 'Didgeridoo', 4, 'didgeridont', '45', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'http://www.alfelectronics.co.uk/ekmps/shops/alfelectronics/images/world-playground-bamboo-didgeridoo-120cm-wp13030-3486-p.jpg'),
(36, 20, '2016-03-11 17:37:38', '2016-03-11 20:39:38', '1', 'Button', 5, 'Shiny Red button', '1', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'http://www.publicdomainpictures.net/view-image.php?image=82878&picture=red-button-for-web'),
(37, 17, '2016-03-11 19:25:57', '2016-03-11 21:45:57', '5', 'Cats Pyjamas', 1, 'The bestest pyjamas', '3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `t_bids`
--

CREATE TABLE IF NOT EXISTS `t_bids` (
  `bid_id` int(11) NOT NULL AUTO_INCREMENT,
  `auctionid` int(11) DEFAULT NULL,
  `buyer_id` int(11) NOT NULL,
  `date_bid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`bid_id`),
  KEY `auctionid` (`auctionid`),
  KEY `buyer_id` (`buyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `t_bids`
--

INSERT INTO `t_bids` (`bid_id`, `auctionid`, `buyer_id`, `date_bid`, `amount`) VALUES
(1, 1, 2, '2016-02-27 10:33:42', '3'),
(2, 1, 20, '2016-03-06 20:26:09', '7'),
(3, 16, 20, '2016-03-08 17:27:02', '0'),
(4, 1, 20, '2016-03-09 19:26:43', '8'),
(5, 1, 20, '2016-03-09 19:51:50', '9'),
(6, 16, 1, '2016-03-09 20:36:40', '7'),
(7, 35, 20, '2016-03-10 17:08:40', '5'),
(8, 16, 20, '2016-03-11 16:15:31', '8'),
(9, 16, 20, '2016-03-11 16:15:42', '700'),
(10, 36, 17, '2016-03-11 17:39:15', '1'),
(11, 36, 17, '2016-03-11 17:39:24', '2'),
(12, 2, 17, '2016-03-11 17:46:21', '1'),
(13, 37, 20, '2016-03-11 20:22:26', '70');

-- --------------------------------------------------------

--
-- Table structure for table `t_buyers`
--

CREATE TABLE IF NOT EXISTS `t_buyers` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `buyer_rep` int(11) DEFAULT '2',
  `buyer_count` int(11) DEFAULT '1',
  `no_buys` int(11) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `t_buyers`
--

INSERT INTO `t_buyers` (`user_id`, `buyer_rep`, `buyer_count`, `no_buys`) VALUES
(1, 3, 1, 4),
(2, 3, 1, 4),
(17, 3, 1, 3),
(20, 3, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `t_cat`
--

CREATE TABLE IF NOT EXISTS `t_cat` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_desc` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `t_cat`
--

INSERT INTO `t_cat` (`cat_id`, `cat_desc`) VALUES
(1, 'Clothing'),
(2, 'Leisure'),
(3, 'electronics'),
(4, 'collectables'),
(5, 'jewellery'),
(6, 'home and garden'),
(7, 'Miscellaneous/Other');

-- --------------------------------------------------------

--
-- Table structure for table `t_emails`
--

CREATE TABLE IF NOT EXISTS `t_emails` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `msgtype` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `t_emails`
--

INSERT INTO `t_emails` (`message_id`, `user_id`, `auction_id`, `msgtype`, `message`, `is_read`) VALUES
(1, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(2, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(4, 1, 1, 4, 'Congratulations, the auction on your item A golden Toilet was successful. The winning bid was Â£9 placed by bennett', 0),
(5, 17, 16, 4, 'Congratulations, the auction on your item bum was successful. The winning bid was Â£700 placed by bennett', 1),
(7, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(8, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(10, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(11, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(13, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(14, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(16, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(17, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(19, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(20, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(22, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(23, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(25, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(26, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(28, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(29, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(31, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(32, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(34, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(35, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(37, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(38, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(40, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(41, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(43, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(44, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(46, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(47, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(49, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(50, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(52, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(53, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(55, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(56, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(58, 1, 2, 5, 'Sorry, the auction on your item A photocopy of Kylie''s bum was  not successful', 0),
(59, 1, 35, 5, 'Sorry, the auction on your item Didgeridoo was  not successful', 0),
(61, 17, 36, 2, 'The you have been outbid on item Button Go to item to place another bid', 1),
(62, 17, 36, 1, 'The auction on item Button is ending soon', 0),
(63, 17, 36, 1, 'The auction on item Button is ending soon', 0),
(65, 17, 37, 4, 'Congratulations, the auction on your item Cats Pyjamas was successful. The winning bid was Â£70 placed by bennett', 0),
(66, 20, 37, 1, 'The auction on item Cats Pyjamas is ending soon', 0),
(67, 20, 36, 4, 'Congratulations, the auction on your item Button was successful. The winning bid was Â£2 placed by kyle_rees', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_sellers`
--

CREATE TABLE IF NOT EXISTS `t_sellers` (
  `user_id` int(11) NOT NULL,
  `seller_rep` int(11) DEFAULT '2',
  `seller_rep_count` int(11) DEFAULT '1',
  `no_sales` int(11) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `t_sellers`
--

INSERT INTO `t_sellers` (`user_id`, `seller_rep`, `seller_rep_count`, `no_sales`) VALUES
(1, 4, 1, 6),
(17, 4, 0, 6),
(20, 4, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE IF NOT EXISTS `t_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `p_word` varchar(20) NOT NULL,
  `d_name` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `d_name` (`d_name`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`user_id`, `first_name`, `last_name`, `p_word`, `d_name`, `email`) VALUES
(1, 'Dave', 'Benson-Philips', 'password', 'GetYourOwnBack', 'gyob@gyob.co.uk'),
(2, 'Ed', 'The_Duck', 'password', 'EdTheDuck', 'Ed@broomcupboard.com'),
(3, 'Thomas', 'Cromwell', 'password', 'puritan4eva', 'tommo@roundheads.com'),
(4, 'Shirley', 'Temple', 'password', 'Lollipop', 's.temple@hotmail.com'),
(5, 'sarah', 'kerry', 'sarahiscool', 'fidel_saztro', 'sarah@sarahkerry.co.uk'),
(17, 'Kyle', 'Rees', 'blahblah', 'kyle_rees', 'reesespieces@hotmail.com'),
(18, 'Elenor', 'Ripley', 'passwor', 'ih8aliens', 'ih8aliens@hotmail.com'),
(19, 'Bishop', 'Droid', 'password', 'Bishopwasrobbed', 'top_droids@gmail.com'),
(20, 'Bennett', 'Halverson', 'blahblah', 'bennett', 'bennett@halverson.com'),
(27, 'Hewwoo', 'Panda', 'd3395867d05cc4c27f01', 'panda', 'hello@panda.com');

-- --------------------------------------------------------

--
-- Table structure for table `t_watchlist`
--

CREATE TABLE IF NOT EXISTS `t_watchlist` (
  `auctionid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `t_watchlist`
--

INSERT INTO `t_watchlist` (`auctionid`, `user_id`) VALUES
(3, 20),
(1, 1),
(4, 1),
(16, 1),
(2, 20),
(36, 17);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_auctions`
--
ALTER TABLE `t_auctions`
  ADD CONSTRAINT `auctionsellers` FOREIGN KEY (`seller_id`) REFERENCES `t_sellers` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cat_ddl` FOREIGN KEY (`cat`) REFERENCES `t_cat` (`cat_id`);

--
-- Constraints for table `t_bids`
--
ALTER TABLE `t_bids`
  ADD CONSTRAINT `biddersarebuyers` FOREIGN KEY (`buyer_id`) REFERENCES `t_buyers` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bidonauction` FOREIGN KEY (`auctionid`) REFERENCES `t_auctions` (`auction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_buyers`
--
ALTER TABLE `t_buyers`
  ADD CONSTRAINT `buyersusers` FOREIGN KEY (`user_id`) REFERENCES `t_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_sellers`
--
ALTER TABLE `t_sellers`
  ADD CONSTRAINT `sellersusers` FOREIGN KEY (`user_id`) REFERENCES `t_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
