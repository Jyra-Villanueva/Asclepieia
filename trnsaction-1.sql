-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2024 at 11:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trnsaction`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$G6vl.2UKhRjtoMdC1WqFQu31OlrJpyWV.YBf1uDUaCS.J52tTj.Ai');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL,
  `blogID` bigint(255) NOT NULL,
  `userNAME` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentID`, `blogID`, `userNAME`, `comment`, `datetime`) VALUES
(23, 29, 'samine', 'hey', '2023-12-13 08:42:10'),
(24, 27, 'jyra', 'good!', '2023-12-13 08:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `blogID` bigint(20) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_content` varchar(255) NOT NULL,
  `dateTime_created` datetime NOT NULL,
  `blog_cat` varchar(255) NOT NULL,
  `blog_pic` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `rating` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`blogID`, `blog_title`, `blog_content`, `dateTime_created`, `blog_cat`, `blog_pic`, `username`, `rating`) VALUES
(27, 'What does Lemon Grass do to your body?', 'Lemongrass offers a range of advantages, including its antioxidant properties, digestive health support, anti-inflammatory effects, potential antibacterial and antifungal capabilities, stress relief qualities through aromatherapy, etc.', '2023-12-13 01:05:28', 'herbs', 'C:\\xampp\\htdocs\\users\\uploads\\download (18).jpg', 'Jessica123', 5),
(28, 'Why is Oregano so Effective?', 'It\'s often used to treat respiratory infections, digestive issues, and even skin conditions. Some studies suggest that oregano oil may have antibacterial properties against certain strains of bacteria, potentially aiding in fighting infections.', '2023-12-13 01:07:48', 'herbs', 'C:\\xampp\\htdocs\\users\\uploads\\Oregano-Leaf-Product-Pic.jpg', 'Jessica123', 4),
(29, 'What can Siling Labuyo do to your body?', 'This compound triggers a burning sensation in the mouth, throat, and can even affect the stomach. While it can induce discomfort for some, for others, eating spicy foods like Siling Labuyo can release endorphins, creating a pleasurable sensation or a \"spi', '2023-12-13 01:53:00', 'vegetables', 'C:\\xampp\\htdocs\\users\\uploads\\images (2).jpg', 'Jyra', 3),
(33, 'sadsad', 'dsadsa', '2023-12-13 16:27:26', 'herbs', 'C:\\xampp\\htdocs\\users\\uploads\\calen.jpg', 'jaja', 5);

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_responses`
--

CREATE TABLE `questionnaire_responses` (
  `response_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `question_1` int(11) NOT NULL,
  `question_2` int(11) NOT NULL,
  `question_3` varchar(255) DEFAULT NULL,
  `question_4` int(11) NOT NULL,
  `question_5` varchar(255) DEFAULT NULL,
  `question_6` varchar(255) DEFAULT NULL,
  `question_7` int(11) NOT NULL,
  `question_8` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionnaire_responses`
--

INSERT INTO `questionnaire_responses` (`response_id`, `username`, `question_1`, `question_2`, `question_3`, `question_4`, `question_5`, `question_6`, `question_7`, `question_8`) VALUES
(1, 'root', 1, 1, 'No', 0, 'dv', 'Beginner', 0, '0'),
(2, 'root', 1, 1, 'No', 0, 'dv', 'Beginner', 0, '0'),
(3, 'root', 1, 1, 'No', 0, '', 'Beginner', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `firstname` varchar(11) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `image` varchar(100) NOT NULL,
  `gender` varchar(1024) NOT NULL,
  `bio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `birthday`, `firstname`, `lastname`, `email`, `image`, `gender`, `bio`) VALUES
('admin', '$2y$10$T5Nm.7JWuUru6p9vQiFkGOr3T8h5ZxoVL1O48EpdzlAnFqRBN/JTy', NULL, 'Admin', 'User', 'admin@example.com', '', 'male', ''),
('admin', '$2y$10$YourActualHashHere', NULL, '', '', '', '', '', ''),
('elijahtry123', '$2y$10$bi1xkt/.ISYuxQCh2PPq7u5AvmbuTaJX9lMq./.WadOSZsaz.LMdO', '1992-02-06', 'Fragrance', 'Booyah', 'elijahtry123@gmail.com', '', 'female', ''),
('hasging', '$2y$10$hHqInsRxHfrd1TyDu6KRFOUAtgWCAMHIVcXTacKR2M4bxBp8.V8jm', '2003-02-05', 'Hera', 'Nar', 'hashing@gmail.com', '', 'male', ''),
('hasging123', '$2y$10$woQ0jSP78S7QMCP3l/xcl.dvn0hiGW75t/2879f5OvxFSfjf6OaAG', '2002-10-06', 'Hera2', 'Nar2', 'hashing123@gmail.com', '', 'female', ''),
('jaja', '$2y$10$W91U0Xv1gt6ciCFhDZNbc.fwkLZahN2ibH5EKazeGRywnBKZk1lUm', NULL, 'ja', 'tabalba', 'a@gmail.com', '', 'female', ''),
('Jessica123', '$2y$10$4tdTL.eGeoOKF9DJkq2Ctu6euCzaLErGh8vhnX.OqEXlKj6wFgJ26', NULL, 'Jessica', 'Llego', 'jllego1@gmail.com', '', 'female', ''),
('jyra', '$2y$10$ILileKLyM4buGITZfnmNjeKa.7Xg/H5O9BUX5/hHpVX4OS.dtD9b.', NULL, 'jyra', 'jyraaaaa', 'ff@gmail.com', '', 'male', ''),
('Jyra', '$2y$10$WJMGItkQHPEvVB5gcH6zd.ci7J99dwdSHnQOVkpVLaZ8.41mxAsUm', NULL, 'Jyra', 'Villanueva', 'villanuevajyra1@gmail.com', '', 'female', ''),
('samine', '$2y$10$9UiSUiPhVAvxHArDYzN5weSpQ6j/FAMlsQkDHSBfgQjEAIPCnFdWa', NULL, 'samine', 'almuete', 'ffa@gmail.com', '', 'female', ''),
('user123', '$2y$10$37I6J5cqpDITjJI4/S7lnOtW2e2yGI102XUVHV2y3Kf1c0Dd5AxpW', '2003-01-06', 'user123', 'last', 'gawalang@gmail.com', '', 'male', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `blogID_fk` (`blogID`),
  ADD KEY `username_fk` (`userNAME`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`blogID`),
  ADD KEY `users_fk_1` (`username`);

--
-- Indexes for table `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
  ADD PRIMARY KEY (`response_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`,`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `blogID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `username_fk` FOREIGN KEY (`userNAME`) REFERENCES `user` (`username`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `users_fk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
