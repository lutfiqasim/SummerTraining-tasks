-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 23, 2023 at 12:57 PM
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
(10, '1000', 4),
(11, '1010', 4),
(12, '112', 4),
(16, '10000', 6),
(17, '1010', 6),
(18, '4', 6),
(19, '1001', 7),
(20, '1000', 7),
(21, '1010', 7),
(65, 'True', 30),
(66, 'False', 30),
(67, 'Romaine lettuce', 31),
(68, 'Spinach ', 31),
(224, 'Correct Answer Updated', 93),
(225, 'Choice1 updated', 93),
(226, 'Choice 2 updated', 93),
(227, 'Choice 3 updated', 93),
(228, 'Added new choice', 93),
(237, 'Hyper Text Markup Language', 97),
(238, 'Hyperlinks and Text Markup Language', 97),
(244, 'new choice 1', 93),
(245, 'new choice 2', 93),
(246, 'new choice 3', 93),
(281, 'CorrectAnswer', 115),
(282, 'Choice1', 115),
(283, 'b', 4);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question-Syntax` varchar(255) NOT NULL,
  `correctAnswer` int(11) DEFAULT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question-Syntax`, `correctAnswer`, `userId`) VALUES
(4, 'What is 100+100 in binary', 10, 1),
(6, 'what is 1000+1000 in binary', 16, 1),
(7, '9 in binary is', 19, 1),
(30, '10+10=20', 65, 1),
(31, 'Which green is usually found in a Caesar salad?', 67, 1),
(93, 'Question Syntax updated', 224, 1),
(97, 'Choose the correct HTML element for the largest heading:', 237, 1),
(115, 'User question', 281, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'ex', 'ex@gmail.com', 'bf4fc65a70ed8f1794b7e83d3aaf51d7', 1),
(2, 'user2', 'user2@gmail.com', 'bf4fc65a70ed8f1794b7e83d3aaf51d7', 0);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
