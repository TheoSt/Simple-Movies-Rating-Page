-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2016 at 08:02 PM
-- Server version: 5.7.11-log
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movies_rating_database`
--

DROP DATABASE IF EXISTS `movies_rating_database`;
CREATE DATABASE `movies_rating_database` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `movies_rating_database`;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--
DROP USER IF EXISTS 'movies'@'localhost';

create user 'movies'@'localhost' identified by '2345';
grant all privileges on *.*to'movies'@'localhost' identified by '2345';

FLUSH PRIVILEGES;

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_title` varchar(100) NOT NULL,
  `movie_release_year` varchar(4) NOT NULL,
  `movie_category` varchar(50) NOT NULL,
  `movie_poster` varchar(40) NOT NULL,
  `movie_scenario` text NOT NULL,
  `average_rating` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_title`, `movie_release_year`, `movie_category`, `movie_poster`, `movie_scenario`, `average_rating`) VALUES
(1, 'Seven', '1995', 'Drama/Mystery', 'images/1.jpg', 'Two detectives, a rookie and a veteran, hunt a serial killer who uses the seven deadly sins as his modus operandi.', '3.00'),
(2, 'Prisoners', '2013', 'Crime/Drama/Mystery', 'images/2.jpg', 'When Keller Dover\'s daughter and her friend go missing, he takes matters into his own hands as the police pursue multiple leads and the pressure mounts. But just how far will this desperate father go to protect his family?', '3.50'),
(3, 'The Matrix', '1999', 'Action/SciFi', 'images/3.jpg', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', '0.00'),
(4, 'Life is beautiful', '1997', 'Comedy/Romance', 'images/4.jpg', 'When an open-minded Jewish librarian and his son become victims of the Holocaust, he uses a perfect mixture of will, humor and imagination to protect his son from the dangers around their camp.', '0.00'),
(5, 'Intestellar', '2014', 'Adventure/Drama/SciFi', 'images/5.jpg', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.', '1.00'),
(6, 'Intouchables', '2011', 'Comedy/Drama', 'images/6.jpg', 'After he becomes a quadriplegic from a paragliding accident, an aristocrat hires a young man from the projects to be his caregiver.', '1.50'),
(7, 'Memento', '2000', 'Mystery/Thriller', 'images/7.jpg', 'A man creates a strange system to help him remember things; so he can hunt for the murderer of his wife without his short-term memory loss being an obstacle.', '0.00'),
(8, 'Silence of the lambs', '1991', 'Crime/Drama/Horror', 'images/8.jpg', 'A young F.B.I. cadet must confide in an incarcerated and manipulative killer to receive his help on catching another serial killer who skins his victims.', '2.00'),
(9, 'Boyhood', '2014', 'Drama', 'images/9.jpg', 'The life of Mason, from early childhood to his arrival at college.', '2.50'),
(10, 'Walk the Line', '2005', 'Biography/Music', 'images/10.jpg', 'A chronicle of country music legend Johnny Cash\'s life.', '0.00'),
(11, 'Dead Poets Society', '1989', 'Comedy/Drama', 'images/11.jpg', 'English teacher John Keating inspires his students to look at poetry with a different perspective of authentic knowledge and feelings.', '2.00'),
(12, 'Django Unchained', '2012', 'Drama/Western', 'images/12.jpg', 'With the help of a German bounty hunter, a freed slave sets out to rescue his wife from a brutal Mississippi plantation owner.', '1.50'),
(13, 'The Wolf of Wall Street', '2013', 'Biography/Comedy/Crime', 'images/13.jpg', 'Based on the true story of Jordan Belfort, from his rise to a wealthy stock-broker living the high life to his fall involving crime, corruption and the federal government.', '0.00'),
(14, 'Inception', '2010', 'Action/Adventure/Crime', 'images/14.jpg', 'A thief, who steals corporate secrets through use of dream-sharing technology, is given the inverse task of planting an idea into the mind of a CEO.', '0.00'),
(15, 'Fight Club', '1999', 'Drama', 'images/15.jpg', 'An insomniac office worker, looking for a way to change his life, crosses paths with a devil-may-care soap maker, forming an underground fight club that evolves into something much, much more...', '1.50');



CREATE TABLE `movies_rating` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `rating` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_mail` varchar(40) NOT NULL,
  `user_password` varchar(16) NOT NULL,
  `user_first_name` varchar(20) NOT NULL,
  `user_last_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `movies_rating`
--
ALTER TABLE `movies_rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `movies_rating`
--
ALTER TABLE `movies_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `movies_rating`
--
ALTER TABLE `movies_rating`
  ADD CONSTRAINT `movies_rating_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `movies_rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
