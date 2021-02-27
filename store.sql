-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 27, 2021 at 07:10 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `parent` tinyint(2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ordering` tinyint(4) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 1,
  `comments` tinyint(1) NOT NULL DEFAULT 1,
  `ads` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent`, `description`, `ordering`, `visibility`, `comments`, `ads`) VALUES
(1, 'Devices', 0, 'PCs,Laptops,Mobiles,IPads', 2, 1, 1, 1),
(3, 'games', 0, 'consoles, games & toys', 5, 1, 1, 1),
(4, 'private', 0, 'private category', 100, 0, 0, 0),
(5, 'Mattresses', 0, 'Mattresses , carpets, Sheets...', 7, 1, 1, 1),
(6, 'Clothes', 0, 'Men,Women Children Clothes.', 6, 1, 1, 1),
(7, 'Shoes', 0, 'Men,Women Children Shoes & bags.', 4, 1, 1, 1),
(8, 'Furniture', 0, 'chairs &amp; Tables.', 9, 1, 1, 1),
(9, 'Books', 0, 'Stories, Manga & studying books.', 15, 1, 1, 1),
(10, 'Sports', 0, 'Balls &amp; sports clothes', 11, 1, 1, 1),
(84, 'mobile phones', 1, 'mobile phones &amp; tablets', 19, 1, 1, 1),
(85, 'computers', 1, 'computers, laptop &amp; relative accessories', 25, 1, 1, 1),
(86, 'toys', 3, 'children toys', 97, 1, 1, 1),
(87, 'consoles', 3, 'playstations &amp;  xboxes ', 98, 1, 1, 1),
(88, 'cd games', 3, 'playstations\'  &amp;  xboxes\' cd games ', 99, 1, 1, 1),
(90, 'suits', 6, 'awesome formal suits', 94, 1, 1, 1),
(91, 'shirts', 6, 'men shirts', 93, 1, 1, 1),
(92, 'dresses', 6, 'women dresses', 92, 1, 1, 1),
(93, 'trousers', 6, 'trousers &amp; shorts', 91, 1, 1, 1),
(94, 'boots', 7, 'long boots', 90, 1, 1, 1),
(95, 'chairs', 8, 'chairs', 89, 1, 1, 1),
(96, 'beds', 8, 'sleeping beds', 88, 1, 1, 1),
(97, 'tables', 8, 'tables', 87, 1, 1, 1),
(98, 'couch', 8, 'couch', 86, 1, 1, 1),
(99, 'history books', 9, 'history books', 85, 1, 1, 1),
(100, 'adventure ', 9, 'adventure  books', 84, 1, 1, 1),
(101, 'science fiction', 9, 'science fiction books', 83, 1, 1, 1),
(102, 'educational', 9, 'educational books', 82, 1, 1, 1),
(103, 'balls', 10, 'footballs, basketballs,...etc', 81, 1, 1, 1),
(104, 'sports wear', 10, 'sports wear', 80, 1, 1, 1),
(105, 'carpets', 5, 'wool carpets', 72, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `prod_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `date`, `status`, `prod_id`, `user_id`) VALUES
(9, 'very soft & deserve its price', '2021-02-13', 1, 21, 1),
(11, 'wow very exciting book', '2021-02-13', 1, 20, 1),
(12, 'have a performance issue', '2021-02-13', 1, 32, 1),
(14, 'it&#39;s very expensive', '2021-02-13', 1, 31, 1),
(15, 'very good at rendering', '2021-02-13', 1, 23, 1),
(16, 'suitable for ordinary user not gamers', '2021-02-13', 1, 22, 1),
(17, 'trash', '2021-02-13', 1, 33, 1),
(18, 'cool', '2021-02-13', 1, 30, 1),
(19, 'pes is much better', '2021-02-13', 1, 35, 1),
(20, 'very relief', '2021-02-13', 1, 19, 1),
(21, 'nice ', '2021-02-13', 1, 36, 1),
(22, 'trash', '2021-02-13', 1, 27, 1),
(23, 'wow', '2021-02-13', 1, 29, 1),
(24, 'god for adventeurers', '2021-02-13', 1, 25, 1),
(25, 'have a balance issues', '2021-02-13', 1, 39, 1),
(26, 'very comfortable', '2021-02-13', 1, 40, 1),
(27, 'what a romantic view', '2021-02-13', 1, 24, 1),
(28, 'exciting book', '2021-02-13', 1, 34, 1),
(29, 'boring ', '2021-02-13', 1, 28, 1),
(30, 'trash', '2021-02-13', 1, 37, 1),
(31, 'good one', '2021-02-13', 1, 41, 1),
(32, 'good one', '2021-02-13', 1, 26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `country` varchar(15) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(50) NOT NULL,
  `rate` tinyint(2) NOT NULL DEFAULT 0,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `cat_id` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `country`, `image`, `status`, `rate`, `approve`, `cat_id`, `user_id`) VALUES
(19, 'Carpet', 'Soft Carpet', '250', '2021-02-12', 'Turkey', 'uploads/12-02-2021_60253_ryan-christodoulou-Vra_DPrrBlE-unsplash.jpg', '1', 0, 1, 105, 1),
(20, 'Harry Potter', 'Harry Potter Series', '70$', '2021-02-13', 'ENG', 'uploads/13-02-2021_71761adventure.jpg', '2', 0, 1, 100, 23),
(21, 'couch', 'soft cotton couch', '250$', '2021-02-13', 'Turkey', 'uploads/13-02-2021_87222couch.jpg', '1', 0, 1, 98, 20),
(22, 'DELL Inspiron 15 5593', '1TB Hard,8GB Ram', '1500$', '2021-02-13', 'CHINA', 'uploads/13-02-2021_69764dell.jpg', '1', 0, 1, 85, 4),
(23, 'lenove idepad 201', '1TB Hard,8GB Ram', '1700$', '2021-02-13', 'CHINA', 'uploads/13-02-2021_34123lenovo-idepad.jpg', '1', 0, 1, 85, 4),
(24, 'Table', 'Classic table', '200$', '2021-02-13', 'SPAIN', 'uploads/13-02-2021_85279table.jpg', '1', 0, 1, 97, 4),
(25, 'Boot', 'tall brown boot', '100$', '2021-02-13', 'ITALY', 'uploads/13-02-2021_99274stephan-seeber-NzAfGi8XuA4-unsplash.jpg', '1', 0, 1, 94, 24),
(26, 'Training cloth', 'nike sports shirt', '65$', '2021-02-13', 'USA', 'uploads/13-02-2021_96464sports-wear.jpg', '1', 0, 1, 104, 13),
(27, 'shirts', 'rounded shirts', '40$', '2021-02-13', 'Egypt', 'uploads/13-02-2021_56185shirts.jpg', '1', 0, 1, 91, 17),
(28, 'star trek', 'science fiction books', '99$', '2021-02-13', 'USA', 'uploads/13-02-2021_21368science-fiction.jpg', '3', 0, 1, 101, 19),
(29, 'Red dress', 'tall red dress', '120$', '2021-02-13', 'ITALY', 'uploads/13-02-2021_37504red-dress.jpg', '1', 0, 1, 92, 21),
(30, 'PS3', 'playstation 3', '100$', '2021-02-13', 'ENGLAND', 'uploads/13-02-2021_54811ps3.jpg', '4', 0, 1, 87, 27),
(31, 'iphone 12 pro max', '6GB Ram, 128GB space', '1100$', '2021-02-13', 'USA', 'uploads/13-02-2021_8009iphone_12pr.jpg', '2', 0, 1, 84, 5),
(32, 'huwei Y7', '6GB Ram, 128GB space', '700$', '2021-02-13', 'CHINA', 'uploads/13-02-2021_43888huawei_y7.jpg', '1', 0, 1, 84, 22),
(33, 'horse toy', 'horse toy for children', '5', '2021-02-13', 'Egypt', 'uploads/13-02-2021_68199_horse-toy.jpg', '4', 0, 1, 86, 3),
(34, 'Osman', 'turkish osman founder osmans&#39;', '40', '2021-02-13', 'Turkey', 'uploads/13-02-2021_89111_history.jpg', '3', 0, 1, 99, 3),
(35, 'fifa 20', 'ps4 fifa 20', '30', '2021-02-13', 'Egypt', 'uploads/13-02-2021_36626_fifa20.jpg', '2', 0, 1, 88, 3),
(36, 'Blue Suit', 'Zara Blue Suit', '350', '2021-02-13', 'ITALY', 'uploads/13-02-2021_90398_blue-suit.jpg', '1', 0, 1, 90, 3),
(37, 'educational books', '3rd secondary school books', '30', '2021-02-13', 'Egypt', 'uploads/13-02-2021_86125_educational-books.jpg', '4', 0, 1, 102, 3),
(39, 'chair', 'comfortable wool chair', '100', '2021-02-13', 'Egypt', 'uploads/13-02-2021_43464_chair.jpg', '2', 0, 1, 95, 3),
(40, 'bed', 'comfortable,  wide &  soft bed ', '1100', '2021-02-13', 'Turkey', 'uploads/13-02-2021_72236_bed.jpg', '1', 0, 1, 96, 3),
(41, 'ball', 'leather football', '20', '2021-02-13', 'USA', 'uploads/13-02-2021_94685_ball.jpg', '1', 0, 1, 103, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'uploads/avatar.jpg',
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `permission` int(1) NOT NULL DEFAULT 0 COMMENT 'admin permission or ordinary user',
  `trustStatus` int(1) NOT NULL DEFAULT 0 COMMENT 'trusted selller or not',
  `regStatus` int(1) NOT NULL DEFAULT 0 COMMENT 'approval'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `image`, `email`, `password`, `full_name`, `Date`, `permission`, `trustStatus`, `regStatus`) VALUES
(1, 'emad967', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'emadhibishy@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'emad ahmed mohamed roshdy hibishy', '2021-01-15', 1, 0, 1),
(3, 'osama', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'osama@elzero.info', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'osama elzero', '2021-01-25', 0, 0, 1),
(4, 'hussien', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'hussien@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'hussien ezzat kamel', '2021-01-25', 0, 0, 1),
(5, 'samir', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'samir@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'samir said abd el-salam', '2021-01-25', 0, 0, 1),
(7, 'amr', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'amr@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'amr ahmed elshair', '2021-01-25', 0, 0, 1),
(13, 'elsayed', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'elsayed@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'elsayed moner', '2021-01-25', 0, 0, 1),
(17, 'khaled', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'khaled@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'khaled ali', '2021-01-27', 0, 0, 1),
(19, 'shawky', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'shawky@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'shawky mahmoud', '2021-01-30', 0, 0, 1),
(20, 'eraky97', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'eraky97@yahoo.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohamed eraky', '2021-01-30', 0, 0, 1),
(21, 'heshamovic`', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'hesham@yahoo.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hesham elbaz', '2021-01-30', 0, 0, 1),
(22, 'tarek', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'tarek@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'tarek ali', '2021-02-09', 0, 0, 1),
(23, 'mostafa', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'mostafa@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mostafa ahmed', '2021-02-09', 0, 0, 0),
(24, 'mahmoud', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'mahmoud@yahoo.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mahmoud khairy', '2021-02-09', 0, 0, 0),
(25, '3laa', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'alaayehia@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'alaa yehia', '2021-02-09', 0, 0, 0),
(26, 'emadHamdy', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'emadhamdy@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'emad hamdy', '2021-02-09', 0, 0, 0),
(27, 'mahrous', 'uploads/13-02-2021_50151IMG-20191016-WA0021.jpg', 'mahrous@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mahrous elsayed', '2021-02-09', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_products_fk` (`prod_id`),
  ADD KEY `comments_users_fk` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user1` (`user_id`),
  ADD KEY `category1` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `name_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_products_fk` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `category1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
