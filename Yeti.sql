-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 15, 2022 at 01:31 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Yeti`
--

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE `Rating` (
  `id` int(11) NOT NULL,
  `yeti_id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `vote` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Rating`
--

INSERT INTO `Rating` (`id`, `yeti_id`, `user`, `vote`, `date`) VALUES
(1, 1, 'aa@gmail.com', 1, '2022-06-07'),
(3, 2, 'bb@gmail.com', 1, '2022-07-07'),
(7, 3, 'aa@gmail.com', -1, '2022-07-09'),
(8, 1, 'bb@gmail.com', 1, '2022-06-09'),
(59, 4, 'aa@gmail.com', 1, '2022-07-10'),
(60, 2, 'aa@gmail.com', -1, '2022-07-10'),
(61, 3, 'abc@gmail.com', 1, '2022-07-11'),
(62, 2, 'abc@gmail.com', 1, '2022-07-11'),
(63, 4, 'abc@gmail.com', 1, '2022-07-11'),
(64, 1, 'abc@gmail.com', 1, '2022-06-11'),
(65, 1, 'abcd@gmail.com', 1, '2022-06-11'),
(66, 3, 'add@gmail.com', 1, '2022-07-11'),
(67, 2, 'add@gmail.com', 1, '2022-07-11'),
(68, 4, 'add@gmail.com', 1, '2022-07-11'),
(69, 1, 'add@gmail.com', 1, '2022-07-11'),
(70, 3, 'as@gmail.com', 1, '2022-07-11'),
(71, 2, 'as@gmail.com', 1, '2022-07-11'),
(72, 4, 'as@gmail.com', 1, '2022-07-11'),
(73, 1, 'as@gmail.com', 1, '2022-07-11'),
(74, 3, 'abcd@gmail.com', 1, '2022-07-11'),
(75, 2, 'abcd@gmail.com', 1, '2022-07-11'),
(76, 4, 'abcd@gmail.com', 1, '2022-07-11'),
(77, 1, 'aa@gmail.com', 1, '2022-06-08'),
(78, 8, 'abbc@gmail.com', 1, '2022-07-12'),
(79, 3, 'abbc@gmail.com', 1, '2022-07-12'),
(80, 2, 'abbc@gmail.com', 1, '2022-07-12'),
(81, 4, 'abbc@gmail.com', -1, '2022-07-12'),
(82, 1, 'abbc@gmail.com', 1, '2022-07-12'),
(83, 9, 'abbc@gmail.com', -1, '2022-07-12'),
(84, 10, 'abbc@gmail.com', 1, '2022-07-12'),
(85, 9, 'ttt@gmail.com', -1, '2022-07-12'),
(86, 10, 'ttt@gmail.com', 1, '2022-07-12'),
(87, 8, 'ttt@gmail.com', 1, '2022-07-12'),
(88, 3, 'ttt@gmail.com', -1, '2022-07-12'),
(89, 4, 'ttt@gmail.com', 1, '2022-07-12'),
(90, 2, 'ttt@gmail.com', 1, '2022-07-12'),
(91, 1, 'ttt@gmail.com', 1, '2022-07-12'),
(92, 1, 'pop@gmail.com', 1, '2022-07-12'),
(93, 9, 'pop@gmail.com', 1, '2022-07-13'),
(94, 8, 'pop@gmail.com', 1, '2022-07-13'),
(95, 10, 'pop@gmail.com', 1, '2022-07-13'),
(96, 3, 'pop@gmail.com', 1, '2022-07-13'),
(97, 4, 'pop@gmail.com', -1, '2022-07-13'),
(98, 2, 'pop@gmail.com', 1, '2022-07-13'),
(99, 1, 'cvcv@gmail.com', 1, '2022-07-13'),
(100, 2, 'cvcv@gmail.com', 0, '2022-07-13'),
(101, 1, 'avn@gmail.com', 1, '2022-07-13'),
(102, 9, 'avn@gmail.com', -1, '2022-07-13'),
(103, 11, 'avn@gmail.com', 0, '2022-07-13'),
(104, 12, 'avn@gmail.com', 1, '2022-07-13'),
(105, 8, 'avn@gmail.com', 1, '2022-07-13'),
(106, 10, 'avn@gmail.com', 1, '2022-07-13'),
(107, 4, 'avn@gmail.com', 1, '2022-07-13'),
(108, 3, 'avn@gmail.com', 1, '2022-07-13'),
(109, 2, 'avn@gmail.com', 0, '2022-07-13'),
(110, 9, 'dfg2@gmail.com', 0, '2022-07-13'),
(111, 11, 'dfg2@gmail.com', 0, '2022-07-13'),
(112, 12, 'dfg2@gmail.com', 1, '2022-07-13'),
(113, 10, 'dfg2@gmail.com', 1, '2022-07-13'),
(114, 8, 'dfg2@gmail.com', 1, '2022-07-13'),
(115, 3, 'dfg2@gmail.com', 1, '2022-07-13'),
(116, 4, 'dfg2@gmail.com', 1, '2022-07-13'),
(117, 2, 'dfg2@gmail.com', 1, '2022-07-13'),
(118, 1, 'dfg2@gmail.com', 1, '2022-07-13'),
(119, 9, 'wow@gmail.com', 0, '2022-07-14'),
(146, 3, 'wow@gmail.com', 1, '2022-07-14'),
(148, 4, 'wow@gmail.com', 1, '2022-07-14'),
(149, 8, 'wow@gmail.com', 1, '2022-07-14'),
(150, 10, 'wow@gmail.com', 1, '2022-07-14'),
(185, 11, 'wow@gmail.com', 1, '2022-07-14'),
(187, 2, 'wow@gmail.com', 1, '2022-07-14'),
(193, 12, 'wow@gmail.com', 1, '2022-07-14'),
(194, 1, 'wow@gmail.com', 1, '2022-07-14'),
(195, 1, 'hm@gmail.com', 1, '2022-07-14'),
(196, 9, 'hm@gmail.com', 0, '2022-07-14'),
(197, 10, 'hm@gmail.com', 1, '2022-07-14'),
(198, 11, 'hm@gmail.com', 1, '2022-07-14'),
(200, 14, 'hm@gmail.com', 1, '2022-07-14'),
(201, 15, 'hm@gmail.com', 1, '2022-07-14'),
(202, 12, 'hm@gmail.com', 1, '2022-07-14'),
(203, 8, 'hm@gmail.com', 1, '2022-07-14'),
(204, 4, 'hm@gmail.com', 1, '2022-07-14'),
(205, 3, 'hm@gmail.com', 1, '2022-07-14'),
(206, 2, 'hm@gmail.com', 1, '2022-07-14'),
(207, 9, 'cvbn@gmail.com', 1, '2022-07-14');

-- --------------------------------------------------------

--
-- Table structure for table `Yetis`
--

CREATE TABLE `Yetis` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `rating` int(11) DEFAULT 0,
  `weight` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Yetis`
--

INSERT INTO `Yetis` (`id`, `name`, `rating`, `weight`, `height`, `address`, `photo`) VALUES
(1, 'Tom', 15, 200, 200, 'Vrchlabi', 'yeti8.png'),
(2, 'Grace', 10, 210, 105, 'Trutnov', 'yeti2.png'),
(3, 'Boris', 8, 99, 201, 'Cerny Dul', 'yeti3.png'),
(4, 'Gee', 8, 55, 100, 'Vrchlabi', 'yeti4.png'),
(8, 'Big', 7, 300, 300, 'Vrchlabi', 'yeti1-62cd999f7521c.png'),
(9, 'Small', -1, 100, 100, 'Spindleruv Mlyn', 'yeti5-62cdb1a247cba.png'),
(10, 'Phil', 7, 150, 250, 'Spindleruv Mlyn', 'yeti6-62cdc758dba40.png'),
(11, 'Jamie', 2, 100, 250, 'Temny Dul', 'yeti7-62ce6d36a41a3.png'),
(12, 'Bob', 4, 150, 220, 'Krivoklat Castle', 'yeti8.png'),
(14, 'Annie', 1, 100, 200, 'Vrchlabi', 'yeti4-62d07214ba9d8.png'),
(15, 'Henry', 1, 178, 255, 'Krivoklat Castle', 'yeti8-62d074e9e7713.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Rating`
--
ALTER TABLE `Rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Yetis`
--
ALTER TABLE `Yetis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Rating`
--
ALTER TABLE `Rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `Yetis`
--
ALTER TABLE `Yetis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
