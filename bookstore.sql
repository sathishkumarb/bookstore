-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2016 at 10:05 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `book_name` text NOT NULL,
  `book_author` varchar(255) NOT NULL,
  `book_description` text,
  `book_price` int(11) DEFAULT NULL,
  `book_releasedby` date DEFAULT NULL,
  `book_publisher` text,
  `book_cover_pic` text,
  `book_added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `book_status` enum('available','notavailable') DEFAULT 'available',
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `category_id`, `book_name`, `book_author`, `book_description`, `book_price`, `book_releasedby`, `book_publisher`, `book_cover_pic`, `book_added_date`, `book_status`) VALUES
(1, 2, 'asdasdas', 'asdasd', 'asdasd', 23, '0000-00-00', 'sadas', '', '2016-04-07 09:32:42', 'available'),
(2, 16, 'sdasd', 'asdas', 'asdasd', 20, '0000-00-00', 'ddd', '1460021891235161.jpg', '2016-04-07 09:38:11', 'available'),
(3, 3, 'Patrick Hemsworth, Sydney', 'dasd', 'sdasdasda', 0, '0000-00-00', 'dasda', '1460028571235161.jpg', '2016-04-07 11:29:31', 'available'),
(4, 1, 'TIger manrathon', 'sathish', 'fantastic', 300, '2016-04-13', 'dasda', '14600542037Lsr3VLzNVdIPxcSyeP06fIqaoLIJyc7I2PXBa58zb0.jpg', '2016-04-07 18:36:43', 'available'),
(5, 1, 'gokulastami', 'pushpak', NULL, NULL, NULL, NULL, '', '2016-04-07 20:02:10', 'available');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
