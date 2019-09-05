--CREATING TABLE admins
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `lost` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usernamekey` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--INSERTING DATA INTO admins
INSERT INTO admins VALUES ('1','aymoo','aymon','40bd001563085fc35165329ea1ff5c5ecbdbbeef','aymoooo@gail.com','images/designer.jpg','');



--CREATING TABLE books
CREATE TABLE `books` (
  `bookId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `coverImage` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `edition` tinyint(4) NOT NULL,
  `courseId` int(11) DEFAULT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`bookId`),
  KEY `courseId` (`courseId`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `courses` (`courseId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--INSERTING DATA INTO books
INSERT INTO books VALUES ('3','name','images/dfdf.jpg','description','author','6','category','5','','-3');



--CREATING TABLE branches
CREATE TABLE `branches` (
  `branchId` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL,
  PRIMARY KEY (`branchId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--INSERTING DATA INTO branches
INSERT INTO branches VALUES ('7','cairo','good branch','45654345');



--CREATING TABLE client_book
CREATE TABLE `client_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL,
  `bookid` int(11) NOT NULL,
  `purchasedate` date NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clientid` (`clientid`),
  KEY `bookid` (`bookid`),
  CONSTRAINT `client_book_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `client_book_ibfk_2` FOREIGN KEY (`bookid`) REFERENCES `books` (`bookId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--INSERTING DATA INTO client_book
INSERT INTO client_book VALUES ('2','5','3','2017-12-05','2');
INSERT INTO client_book VALUES ('8','5','3','2017-12-12','1');
INSERT INTO client_book VALUES ('9','5','3','2017-12-12','1');



--CREATING TABLE client_course
CREATE TABLE `client_course` (
  `clientid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `registerdate` date NOT NULL,
  PRIMARY KEY (`clientid`,`courseid`),
  KEY `courseid` (`courseid`),
  CONSTRAINT `client_course_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `client_course_ibfk_2` FOREIGN KEY (`courseid`) REFERENCES `courses` (`courseId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--INSERTING DATA INTO client_course



--CREATING TABLE clients
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `verify` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profileImage` varchar(255) DEFAULT NULL,
  `unseen_notific` int(11) DEFAULT NULL,
  `registrationDate` date NOT NULL,
  `lost` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--INSERTING DATA INTO clients
INSERT INTO clients VALUES ('5','amrali','amr ali ahmed','5120439d45aecff023a96951b83be08772a30cb5','45654','0','amrali@gmail.com','images/dfdf.jpg','0','2017-12-07','');
INSERT INTO clients VALUES ('6','ashraf1996','abdelrahman','98874a2910687357799429549e61aee05f4e9083','01112481686','0','tika-1996@hotmail.com','','0','2017-12-13','a74425cde8ce067d6410960d35a85846');
INSERT INTO clients VALUES ('7','gemygemy','gemy','2abcd468eaa84cb4105b3320124f567cc24f2cc5','3456754','0','medoayman494@gmail.com','','0','2017-12-13','');
INSERT INTO clients VALUES ('8','gvlkfj','gwlrkgjk','5043849689a8824bfee92caedbc55692c1d0d250','56545','0','gwrfljk@gjgw.fwjrfk','','0','2017-12-13','');
INSERT INTO clients VALUES ('9','bogyy','abdelrahman ','f5a68c4288fe4f612d9c221ff14e3835d45a724d','01154216453','0','abaradah@gmail.com','','0','2017-12-13','');
INSERT INTO clients VALUES ('10','mustfa','mustfa','f5f2f9764f659801d03d6a75421cfd1b81d0e9df','4557','0','mustafamammdoh@gmail.com','','0','2017-12-14','');



--CREATING TABLE contact_us
CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientId` int(11) NOT NULL,
  `message` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clientId` (`clientId`),
  CONSTRAINT `contact_us_ibfk_1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO contact_us



--CREATING TABLE courses
CREATE TABLE `courses` (
  `courseId` int(11) NOT NULL AUTO_INCREMENT,
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
  `resources` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`courseId`),
  KEY `myinstructorid` (`myinstructorid`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`myinstructorid`) REFERENCES `instructors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--INSERTING DATA INTO courses



--CREATING TABLE instructors
CREATE TABLE `instructors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `unseen_notific` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--INSERTING DATA INTO instructors



--CREATING TABLE news
CREATE TABLE `news` (
  `newsId` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creationDate` date NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`newsId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--INSERTING DATA INTO news
INSERT INTO news VALUES ('4','helo','here is the description','2017-11-17','images/rfrf.jpg');
INSERT INTO news VALUES ('6','new again','new description','2017-11-21','images/03.jpg');
INSERT INTO news VALUES ('14','new news','description','2017-12-07','images/gfgf.jpg');
INSERT INTO news VALUES ('9','sfjsdkfs','vxcmxv','2017-11-21','images/test.jpg');
INSERT INTO news VALUES ('10','ueoqueqio','hfsdfskh','2017-11-21','images/designer.jpg');
INSERT INTO news VALUES ('19','btngan','btngan','2017-12-08','images/bfbf.jpg');
INSERT INTO news VALUES ('23','ah','ah','2017-12-08','images/bfbf.jpg');
INSERT INTO news VALUES ('22','fdfl','fdlfd','2017-12-08','images/bfbf.jpg');
INSERT INTO news VALUES ('21','awf','wfaw','2017-12-08','images/bfbf.jpg');
INSERT INTO news VALUES ('20','sf','sdff','2017-12-08','images/bfbf.jpg');
INSERT INTO news VALUES ('24','dfh','dhf','2017-12-08','images/bfbf.jpg');
INSERT INTO news VALUES ('25','wfls','wefj','2017-12-08','images/bfbf.jpg');



--CREATING TABLE paypal
CREATE TABLE `paypal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `amount` double NOT NULL,
  `paydate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clientid` (`clientid`),
  CONSTRAINT `paypal_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO paypal



--CREATING TABLE rates
CREATE TABLE `rates` (
  `clientid` int(11) NOT NULL,
  `instructorid` int(11) NOT NULL,
  `value` tinyint(4) NOT NULL,
  PRIMARY KEY (`clientid`,`instructorid`),
  KEY `instructorid` (`instructorid`),
  CONSTRAINT `rates_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rates_ibfk_2` FOREIGN KEY (`instructorid`) REFERENCES `instructors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO rates



--CREATING TABLE supervisors
CREATE TABLE `supervisors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `salary` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `workDate` date NOT NULL,
  `lost` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--INSERTING DATA INTO supervisors
INSERT INTO supervisors VALUES ('3','h','super','8451ba8a14d79753d34cb33b51ba46b4b025eb81','gemy@yahoo.com','images/rfrf.jpg','34','43','EF','2017-12-02','');



--CREATING TABLE testimonials
CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO testimonials
INSERT INTO testimonials VALUES ('1','you are good company','5');



-- THE END

