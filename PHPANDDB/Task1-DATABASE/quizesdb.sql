-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 16, 2023 at 06:48 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizesdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `answerSyntax` varchar(255) NOT NULL,
  `questionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answerSyntax`, `questionId`) VALUES
(4, 'The World Wide Web Consortium', 2),
(5, 'Mozilla', 2),
(6, 'Google', 2),
(10, '1000', 4),
(11, '1010', 4),
(12, '112', 4),
(16, '10000', 6),
(17, '1010', 6),
(18, '4', 6),
(19, '1001', 7),
(20, '1000', 7),
(21, '1010', 7),
(62, '1939 ', 29),
(63, '1954', 29),
(65, 'True', 30),
(66, 'False', 30),
(67, 'Romaine lettuce', 31),
(68, 'Spinach ', 31),
(224, 'Correct Answer Updated', 93),
(225, 'Choice1 updated', 93),
(226, 'Choice 2 updated', 93),
(227, 'Choice 3 updated', 93),
(228, 'Added new choice', 93);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question-Syntax` varchar(255) NOT NULL,
  `correctAnswer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question-Syntax`, `correctAnswer`) VALUES
(2, 'Who is making the Web standards?', 4),
(4, 'What is 100+100 in binary', 10),
(6, 'what is 1000+1000 in binary', 16),
(7, '9 in binary is', 19),
(29, 'When did  world war 2 start', 62),
(30, '10+10=20', 65),
(31, 'Which green is usually found in a Caesar salad?', 67),
(93, 'Question Syntax updated', 224);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answerSyntax` (`answerSyntax`),
  ADD KEY `questionId` (`questionId`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `question-Syntax` (`question-Syntax`),
  ADD KEY `questions_ibfk_1` (`correctAnswer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `question-answers-id` FOREIGN KEY (`questionId`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`correctAnswer`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
