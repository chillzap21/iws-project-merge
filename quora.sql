-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2017 at 05:37 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30
SET GLOBAL log_bin_trust_function_creators = 1;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quora`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `q_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL,
  `answer` varchar(5000) NOT NULL,
  `date` text NOT NULL,
  `u_name` text NOT NULL,
  `upvotes` int(11) NOT NULL,
  `del` tinyint(1) NOT NULL DEFAULT '0',
  `mod_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`q_id`, `a_id`, `answer`, `date`, `u_name`, `upvotes`, `del`, `mod_name`) VALUES
(2, 1, 'Any quiest', '4th Nov 2017', 'Suhird Singh', 1, 0, '0'),
(2, 2, 'All questions are possible', '5th Nov 2017', 'SX', 0, 0, '0'),
(4, 3, 'Answer', '15th Nov 2017', 'Suhird Singh', 0, 0, '0'),
(5, 4, 'dfsfdsdfds', '1st Dec 2017', 'Suhird Singh', 0, 0, '0'),
(5, 5, 'vvcjujutg', '1st Dec 2017', 'Suhird Singh', 0, 0, '0'),
(1, 6, 'Many things\r\n', '4th Dec 2017', 'Suhird Singh', 0, 0, '0'),
(1, 7, 'as', '8th Dec 2017', 'Suhird Singh', 1, 0, ''),
(5, 8, 'Yes', '8th Dec 2017', 'SX', 0, 0, ''),
(6, 9, 'Sample Answer\r\n', '8th Dec 2017', 'SX', 1, 1, 'Moderator_x');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `b_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`b_id`, `user_id`, `q_id`) VALUES
(3, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `comment` text NOT NULL,
  `del` tinyint(1) NOT NULL DEFAULT '0',
  `mod_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `ans_id`, `user_name`, `comment`, `del`, `mod_name`) VALUES
(1, 1, 'Suhird Singh', 'OK, thanks', 0, '0'),
(2, 2, 'Suhird Singh', 'Thank you', 0, '0'),
(3, 1, 'Suhird Singh', 'Ok', 0, '0'),
(4, 1, 'Suhird Singh', 'OK, thanks', 0, '0'),
(8, 6, 'Suhird Singh', 'Could you elaborate?', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `mods`
--

CREATE TABLE `mods` (
  `mod_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `mod_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mods`
--

INSERT INTO `mods` (`mod_id`, `username`, `password`, `mod_name`) VALUES
(1, 'mod1', '1234', 'Moderator_x');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `n_id` int(11) NOT NULL,
  `notif` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`n_id`, `notif`) VALUES
(1, 'user123 upvoted on your answer to question x'),
(2, 'user456 upvoted on your answer to question y'),
(3, 'userxyz commented on your answer to question z'),
(4, 'John Doe answered your question abc');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `q_id` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`q_id`, `question`, `date`) VALUES
(1, 'What is Quora used for?', '30th Oct 2017'),
(2, 'What kind of questions can I ask on quora?', '30th Oct 2017'),
(5, 'ffgrefrefr', '1st Dec 2017'),
(6, 'Sample Question?', '8th Dec 2017');

-- --------------------------------------------------------

--
-- Table structure for table `upvotes`
--

CREATE TABLE `upvotes` (
  `up_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upvotes`
--

INSERT INTO `upvotes` (`up_id`, `user_id`, `ans_id`) VALUES
(3, 2, 1),
(4, 2, 9),
(7, 1, 7);

--
-- Triggers `upvotes`
--
DELIMITER $$
CREATE TRIGGER `upvote_add` AFTER INSERT ON `upvotes` FOR EACH ROW BEGIN
	UPDATE answers SET upvotes = upvotes + 1 WHERE a_id = NEW.ans_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `upvote_remove` AFTER DELETE ON `upvotes` FOR EACH ROW BEGIN
	UPDATE answers SET upvotes = upvotes - 1 WHERE a_id = OLD.ans_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `location`) VALUES
(1, 'chilly', '1234', 'Suhird Singh', ''),
(2, 'chilly2', '1234', 'SX', ''),
(3, 'chilly3', '1234', 'chilly', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `mods`
--
ALTER TABLE `mods`
  ADD PRIMARY KEY (`mod_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `upvotes`
--
ALTER TABLE `upvotes`
  ADD PRIMARY KEY (`up_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `mods`
--
ALTER TABLE `mods`
  MODIFY `mod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `n_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `upvotes`
--
ALTER TABLE `upvotes`
  MODIFY `up_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
