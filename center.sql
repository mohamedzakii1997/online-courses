-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2017 at 10:13 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `center`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `lost` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `password`, `email`, `profileImage`, `lost`) VALUES
(1, 'aymoo', 'aymon', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'aymoooo@gail.com', 'images/designer.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `coverImage` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `edition` tinyint(4) NOT NULL,
  `courseId` int(11) DEFAULT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookId`, `name`, `coverImage`, `description`, `author`, `price`, `category`, `edition`, `courseId`, `number`) VALUES
(3, 'name', 'images/dfdf.jpg', 'description', 'author', 6, 'category', 5, NULL, -4);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branchId` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branchId`, `location`, `description`, `phone`) VALUES
(7, 'cairo', 'good branch', '45654345');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `verify` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profileImage` varchar(255) DEFAULT NULL,
  `unseen_notific` int(11) DEFAULT NULL,
  `registrationDate` date NOT NULL,
  `lost` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `username`, `name`, `password`, `phone`, `verify`, `email`, `profileImage`, `unseen_notific`, `registrationDate`, `lost`) VALUES
(5, 'amrali', 'amr ali ahmed', '5120439d45aecff023a96951b83be08772a30cb5', '45654', 0, 'amrali@gmail.com', 'images/dfdf.jpg', 0, '2017-12-07', NULL),
(6, 'ashraf1996', 'abdelrahman', '98874a2910687357799429549e61aee05f4e9083', '01112481686', 1, 'tika-1996@hotmail.com', '', 0, '2017-12-13', 'a74425cde8ce067d6410960d35a85846'),
(7, 'gemygemy', 'gemy', '2abcd468eaa84cb4105b3320124f567cc24f2cc5', '3456754', 0, 'medoayman494@gmail.com', '', 0, '2017-12-13', NULL),
(8, 'gvlkfj', 'gwlrkgjk', '5043849689a8824bfee92caedbc55692c1d0d250', '56545', 0, 'gwrfljk@gjgw.fwjrfk', '', 0, '2017-12-13', NULL),
(9, 'bogyy', 'abdelrahman ', 'f5a68c4288fe4f612d9c221ff14e3835d45a724d', '01154216453', 0, 'abaradah@gmail.com', '', 0, '2017-12-13', NULL),
(10, 'mustfa', 'mustfa', 'f5f2f9764f659801d03d6a75421cfd1b81d0e9df', '4557', 0, 'mustafamammdoh@gmail.com', '', 0, '2017-12-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_book`
--

CREATE TABLE `client_book` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `bookid` int(11) NOT NULL,
  `purchasedate` date NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_book`
--

INSERT INTO `client_book` (`id`, `clientid`, `bookid`, `purchasedate`, `number`) VALUES
(2, 5, 3, '2017-12-05', 2),
(8, 5, 3, '2017-12-12', 1),
(9, 5, 3, '2017-12-12', 1),
(10, 6, 3, '2017-12-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_course`
--

CREATE TABLE `client_course` (
  `clientid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `registerdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_course`
--

INSERT INTO `client_course` (`clientid`, `courseid`, `registerdate`) VALUES
(5, 3, '2017-12-14'),
(10, 3, '2017-12-14');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `message` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `hours` tinyint(4) NOT NULL,
  `price` int(11) NOT NULL,
  `certifications` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `startDate` date NOT NULL,
  `lectureTime` varchar(255) NOT NULL,
  `myinstructorid` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `max` smallint(6) NOT NULL,
  `resources` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseId`, `name`, `description`, `content`, `hours`, `price`, `certifications`, `image`, `startDate`, `lectureTime`, `myinstructorid`, `category`, `state`, `max`, `resources`) VALUES
(3, 'co1', 'ojfk', 'kjfjwjf', 127, 455, 'FKWEFJ', 'images/gfgf.jpg', '2222-03-22', 'FWFRG', 2, 'JIFKL', 0, 3452, NULL),
(4, 'course', 'courfwojfn', 'cfkjwfj', 127, 3434, 'fkjff', 'images/gfgf.jpg', '2222-02-22', 'fgeg', 2, 'fkjgj', 0, 5654, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `name` varchar(20) NOT NULL,
  `salary` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `workDate` date NOT NULL,
  `career` varchar(100) NOT NULL,
  `rate` tinyint(4) NOT NULL,
  `lost` varchar(255) DEFAULT NULL,
  `unseen_notific` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `username`, `password`, `email`, `profileImage`, `name`, `salary`, `address`, `phone`, `description`, `workDate`, `career`, `rate`, `lost`, `unseen_notific`) VALUES
(2, 'nssldfj', '6cfd48f58cb5c63a3ce5d4d39f378ca2a584eeb4', 'fdjlfa!jfk@jakjfs.sfekw', 'images/rfrf.jpg', 'ims', 345434543, 'lfkjasajfjkasf', '345654', 'fde', '2017-12-14', 'fsdafj', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `newsId` int(11) NOT NULL,
  `header` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creationDate` date NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`newsId`, `header`, `description`, `creationDate`, `image`) VALUES
(4, 'helo', 'here is the description', '2017-11-17', 'images/rfrf.jpg'),
(6, 'new again', 'new description', '2017-11-21', 'images/03.jpg'),
(14, 'new news', 'description', '2017-12-07', 'images/gfgf.jpg'),
(9, 'sfjsdkfs', 'vxcmxv', '2017-11-21', 'images/test.jpg'),
(10, 'ueoqueqio', 'hfsdfskh', '2017-11-21', 'images/designer.jpg'),
(19, 'btngan', 'btngan', '2017-12-08', 'images/bfbf.jpg'),
(23, 'ah', 'ah', '2017-12-08', 'images/bfbf.jpg'),
(22, 'fdfl', 'fdlfd', '2017-12-08', 'images/bfbf.jpg'),
(21, 'awf', 'wfaw', '2017-12-08', 'images/bfbf.jpg'),
(20, 'sf', 'sdff', '2017-12-08', 'images/bfbf.jpg'),
(24, 'dfh', 'dhf', '2017-12-08', 'images/bfbf.jpg'),
(25, 'wfls', 'wefj', '2017-12-08', 'images/bfbf.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `paypal`
--

CREATE TABLE `paypal` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `amount` double NOT NULL,
  `paydate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `clientid` int(11) NOT NULL,
  `instructorid` int(11) NOT NULL,
  `value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `salary` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `workDate` date NOT NULL,
  `lost` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`id`, `name`, `username`, `password`, `email`, `profileImage`, `salary`, `phone`, `address`, `workDate`, `lost`) VALUES
(3, 'h', 'super', '8451ba8a14d79753d34cb33b51ba46b4b025eb81', 'gemy@yahoo.com', 'images/rfrf.jpg', 34, '43', 'EF', '2017-12-02', '');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `description`, `client_id`) VALUES
(1, 'you are good company', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usernamekey` (`username`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookId`),
  ADD KEY `courseId` (`courseId`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branchId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `client_book`
--
ALTER TABLE `client_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `bookid` (`bookid`);

--
-- Indexes for table `client_course`
--
ALTER TABLE `client_course`
  ADD PRIMARY KEY (`clientid`,`courseid`),
  ADD KEY `courseid` (`courseid`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientId` (`clientId`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseId`),
  ADD KEY `myinstructorid` (`myinstructorid`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`newsId`);

--
-- Indexes for table `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid` (`clientid`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`clientid`,`instructorid`),
  ADD KEY `instructorid` (`instructorid`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`name`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `branchId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `client_book`
--
ALTER TABLE `client_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `newsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `paypal`
--
ALTER TABLE `paypal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `courses` (`courseId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_book`
--
ALTER TABLE `client_book`
  ADD CONSTRAINT `client_book_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_book_ibfk_2` FOREIGN KEY (`bookid`) REFERENCES `books` (`bookId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_course`
--
ALTER TABLE `client_course`
  ADD CONSTRAINT `client_course_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_course_ibfk_2` FOREIGN KEY (`courseid`) REFERENCES `courses` (`courseId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD CONSTRAINT `contact_us_ibfk_1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`myinstructorid`) REFERENCES `instructors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paypal`
--
ALTER TABLE `paypal`
  ADD CONSTRAINT `paypal_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rates_ibfk_2` FOREIGN KEY (`instructorid`) REFERENCES `instructors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
