-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2016 at 10:10 AM
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
  `book_description` text NOT NULL,
  `book_price` int(11) NOT NULL,
  `book_releasedby` date NOT NULL,
  `book_publisher` text NOT NULL,
  `book_cover_pic` text NOT NULL,
  `book_added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `book_status` enum('available','notavailable') NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;



--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `category_id`, `book_name`, `book_author`, `book_description`, `book_price`, `book_releasedby`, `book_publisher`, `book_cover_pic`, `book_added_date`, `book_status`) VALUES
(1, 2, 'asdassdas', 'asdasd', 'asdasd', 23, '0000-00-00', 'sadas', '', '2016-04-07 09:32:42', 'available'),
(2, 16, 'saa', 'asdas', 'asdasd', 20, '0000-00-00', 'ddd', '1460021891235161.jpg', '2016-04-07 09:38:11', 'available'),
(3, 3, 'Patrick Hemsworth, Sydney', 'dasd', 'sdasdasda', 0, '0000-00-00', 'dasda', '1460028571235161.jpg', '2016-04-07 11:29:31', 'available'),
(4, 3, 'sathish', 'test', 'sdasd', 23, '0000-00-00', '', '', '2016-04-07 16:52:47', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `book_categories`
--

CREATE TABLE IF NOT EXISTS `book_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `book_categories`
--

INSERT INTO `book_categories` (`category_id`, `category`) VALUES
(1, 'Science fiction'),
(2, '\r\nSatire'),
(3, 'Drama'),
(4, 'Action and Adventure'),
(5, 'Romance'),
(6, 'Mystery'),
(7, 'Horror'),
(8, 'Self help'),
(9, 'Health'),
(10, 'Guide'),
(11, 'Travel'),
(12, 'Children''s'),
(13, 'Religion'),
(14, 'Spirituality & New Age'),
(15, 'Science'),
(16, 'History'),
(17, 'Math'),
(18, 'Anthology'),
(19, 'Poetry'),
(20, 'Encyclopedias'),
(21, 'Dictionaries'),
(22, 'Comics'),
(23, 'Art'),
(24, 'Cookbooks'),
(25, 'Diaries'),
(26, 'Journals'),
(27, 'Prayer books'),
(28, 'Series'),
(29, 'Trilogy'),
(30, 'Biographies'),
(31, 'Autobiographies'),
(32, 'Fantasy '),
(33, 'Others');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
