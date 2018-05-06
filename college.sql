-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2018 at 08:40 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(1) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `phone` tinytext NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `image_link` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `role_id`, `name`, `phone`, `email`, `password`, `image_link`) VALUES
(14, 2, 'Ofer', '0544447456', 'ofer@iol.co.il', '$2y$10$KQytpLThh0a3uSrTSCDWlO6yR9kiYyPt/6kt7.a9m8yV0xxRMOJOm', 'IMG\\administrators\\Ofer.jpg'),
(17, 3, 'Miki', '0535594441', 'mikk@gmail.com', '$2y$10$YFP41vC01kBXKi/ChEaG3exD/Wlxdvs6V6kQKdc9/S0UEy8.WrY9e', 'IMG\\administrators\\Miki.jpg'),
(23, 1, 'Niv', '0501111111', 'nivus@gmail.com', '$2y$10$7XBxxny.zdlYqIhyooaq9uaTBOzb8TSDqQAuu.qvLyXKoQpT7wvZq', 'IMG\\administrators\\Niv.png'),
(24, 3, 'Spiderman', '0544775693', 'spider62@gmail.com', '$2y$10$JSECFYZb/O3N6b/9In7AmuWzBq8h7fZtAqJ2D5qURvfJ10hFrGpgq', 'IMG\\administrators\\Spiderman.jpg'),
(25, 2, 'Calimero', '0586546587', 'calimeroegg@gmail.com', '$2y$10$p9iDTNC676X3tMQkBPRu.OTVnqKhlpO2yQg/UH4OnuARYtwksjfH.', 'IMG\\administrators\\Calimero.jpg'),
(26, 2, 'Rina', '0584657327', 'rina1970@gmail.com', '$2y$10$14f.lUa2RZ0Onc6M/tYJUOLWngF.oZcCvze57fU6Qkr2ktXm5J94m', 'IMG\\administrators\\Rina.png');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `description` varchar(600) NOT NULL,
  `image_link` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `image_link`) VALUES
(1, 'Web Application Development', 'In this course we will learn by doing.  We will start by learning the major components of web application architectures, along with the fundamental design patterns and philosophies that are used to organize them.  You will build and continually refine a fully functional full-stack web application as we progress through the modules in this course.  Along the way you will be exposed to agile software development practices, numerous tools that software engineers are expected to know how to use, and a modern web application development framework.', 'IMG\\courses\\web.jpg'),
(2, 'Introduction to Structured Query Language (SQL)', 'In this course, you\'ll walk through installation steps for installing a text editor, installing MAMP or XAMPP (or equivalent) and creating a MySql Database. You\'ll learn about single table queries and the basic syntax of the SQL language, as well as database design with multiple tables, foreign keys, and the JOIN operation. Lastly, you\'ll learn to model many-to-many relationships like those needed to represent users, roles, and courses.', 'IMG\\courses\\SQL.png'),
(67, 'CSS Development', 'Anyone who has worked in web development for more than five minutes can tell you: the difference between an outstanding site and a terrible site is the quality of the CSS. With our CSS Tutorial for Beginners course, you can learn to make high-quality, graphically amazing and thoroughly impressive web sites.\r\n\r\nAll it takes is a little creativity and a strong understanding of CSS design and code and your website will look exactly the way you want it to.\r\n\r\nLearnToProgramâ€™s Zachary Kingston brings you this dynamic and comprehensive CSS course.', 'IMG\\courses\\css3.png'),
(70, 'Mathematics for Machine Learning Specialization', 'Through the assignments of this specialisation you will use the skills you have learned to produce mini-projects with Python on interactive notebooks, an easy to learn tool which will help you apply the knowledge to real world problems. For example, using linear algebra in order to calculate the page rank of a small simulated internet, applying multivariate calculus in order to train your own neural network, performing a non-linear least squares regression to fit a model to a data set, and using principal component analysis to determine the features of the MNIST digits data set.', 'IMG\\courses\\Specialization.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`id`, `course_id`, `student_id`) VALUES
(29, 1, 1),
(13, 1, 2),
(15, 1, 3),
(16, 2, 3),
(20, 2, 15),
(21, 2, 16),
(14, 67, 2),
(18, 67, 14),
(22, 67, 16),
(23, 67, 17),
(19, 70, 14),
(24, 70, 17);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(1) UNSIGNED NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(2, 'manager'),
(1, 'owner'),
(3, 'sales');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `phone` tinytext NOT NULL,
  `email` varchar(60) NOT NULL,
  `image_link` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `phone`, `email`, `image_link`) VALUES
(1, 'Moshe', '0543337018', 'moshe@gmail.com', 'IMG\\students\\Moshe.jpg'),
(2, 'Or', '0536313052', 'oor@gmail.com', 'IMG\\students\\Or.jpg'),
(3, 'Oz', '0543335013', 'Ozzz@yahoo.com', 'IMG\\students\\Oz.jpg'),
(14, 'Mor', '0559898666', 'mormor@gmail.com', 'IMG\\students\\Mor.jpg'),
(15, 'Gambit', '0501111333', 'aceking@gmail.com', 'IMG\\students\\Gambit.png'),
(16, 'Moriarty', '0509998585', 'morihatesherlock@gmail.com', 'IMG\\students\\Moriarty.png'),
(17, 'Snufkin', '0522000478', 'snifi@gmail.com', 'IMG\\students\\Snufkin.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK_roles` (`role_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_idx` (`name`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index` (`course_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`role`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `FK_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
