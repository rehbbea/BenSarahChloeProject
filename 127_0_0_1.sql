-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2016 at 08:31 PM
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
  `date_listed` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
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
  PRIMARY KEY (`auction_id`),
  KEY `seller_id` (`seller_id`),
  KEY `cat` (`cat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_auctions`
--

INSERT INTO `t_auctions` (`auction_id`, `seller_id`, `date_listed`, `date_expires`, `reserve_price`, `item_name`, `cat`, `description`, `start_price`, `pageviews`, `winnerid`, `highest_bid`, `w_notify`, `s_notify`, `sent`, `received`, `w_feedback`, `s_feedback`) VALUES
(1, 1, '2016-02-27 10:32:54', '2016-03-23 00:00:00', '10', 'A golden Toilet', 4, 'Toilet made of solid gold', '1', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_bids`
--

INSERT INTO `t_bids` (`bid_id`, `auctionid`, `buyer_id`, `date_bid`, `amount`) VALUES
(1, 1, 2, '2016-02-27 10:33:42', '3');

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
(2, 2, 1, 0);

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
(1, 2, 1, 0);

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
