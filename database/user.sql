-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2013 at 04:15 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created` date DEFAULT '0000-00-00',
  `created_by` int(11) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `fullname`, `password`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `group_id`) VALUES
(1, 'nvan', 'nvan@gmail.com', 'Nguyễn Văn An', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 0, 4, 1),
(2, 'nvb', 'nvb@gmail.com', 'Nguyễn Văn B', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 0, 3, 2),
(3, 'nvc', 'nvc@gmail.com', 'Nguyễn Văn C', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 0, 2, 3),
(4, 'admin', 'admin@gmail.com', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 0, 1, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
