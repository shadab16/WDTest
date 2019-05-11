-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2019 at 01:02 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shadab`
--

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_on` int(11) NOT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`permission_id`, `name`, `created_on`, `modified_on`, `active`) VALUES
(1, 'View Post', 1557554728, NULL, 'Y'),
(2, 'Create Post', 1557554728, NULL, 'Y'),
(3, 'Edit Post', 1557554728, NULL, 'Y'),
(4, 'Edit Any Post', 1557554728, NULL, 'Y'),
(5, 'Delete Post', 1557554728, NULL, 'Y'),
(6, 'Delete Any Post', 1557554728, NULL, 'Y'),
(7, 'View Any Post', 1557554728, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `content` mediumtext NOT NULL,
  `version` smallint(6) NOT NULL,
  `created_on` int(11) NOT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `author_id`, `title`, `content`, `version`, `created_on`, `modified_on`, `status`) VALUES
(1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing eli', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac tellus eu nunc posuere porta.\r\n\r\nProin eu erat ultricies, maximus sem ac, faucibus odio. Pellentesque orci massa, tristique eget molestie ut, placerat id sem. In maximus odio ut purus mollis sollicitudin et sit amet metus. Morbi vel placerat turpis. Nam felis libero, hendrerit non placerat eu, dapibus eu mi. Proin et lectus ultrices nisi aliquam pharetra. Nam gravida vitae ex eu commodo. Sed quis auctor augue, quis dapibus orci.\r\n\r\nMaecenas sit amet sem pharetra, molestie felis id, consectetur justo. Curabitur ut nisl in nisl dapibus semper. Quisque ut malesuada felis. Nam finibus lorem arcu, sed faucibus nibh dictum et. Integer eget mi condimentum, tempor nunc vel, imperdiet erat. Integer accumsan sem velit, in tristique tellus tempus vel. Phasellus vitae orci convallis, condimentum dolor a, fermentum leo.', 1, 1557554728, 1557571834, 1),
(2, 2, 'Mauris ultricies purus ac congue fringilla', 'Fusce non convallis urna. Nulla orci erat, convallis non dapibus ut, aliquam quis nibh. Duis quis eros lacinia, commodo ipsum eget, cursus augue. Mauris ornare sem nec nisi pulvinar porttitor. Proin sodales hendrerit orci, in commodo magna ornare et.\r\n\r\nCras mauris orci, luctus at odio non, ultrices sollicitudin ex. Ut lobortis lacinia nisi, eget mattis est dictum quis. Sed condimentum rhoncus magna, ac feugiat urna consectetur et. Donec cursus eros ac auctor pulvinar. Mauris mattis, massa quis fermentum tincidunt, est lacus eleifend felis, et ultricies quam odio a ante. Vivamus rhoncus dolor vel nibh ultrices gravida. In venenatis hendrerit sapien, a bibendum purus porttitor vitae. Donec venenatis felis eget diam volutpat, non ultricies ex laoreet.\r\n', 1, 1557554728, NULL, 1),
(3, 2, 'Integer nec felis pellentesque, rhoncus ligula vel, luctus neque', 'Mauris convallis quis nibh vel aliquam. Cras eleifend lobortis aliquet. Duis tincidunt aliquam turpis vitae tempor. Fusce non vestibulum nunc. Proin nulla est, rutrum vitae sapien quis, vehicula volutpat nulla. Donec rhoncus magna in tristique tempor. Fusce felis erat, iaculis ac nisl ut, dictum imperdiet turpis. Morbi eget nisi in lectus elementum porttitor. Sed hendrerit tristique sem vel malesuada.', 1, 1557554728, NULL, 1),
(4, 2, 'This is a text [updated]', 'This is a new content', 1, 1557568578, NULL, 1),
(5, 2, 'This is a text [new]', 'This is a new content', 1, 1557568835, 1557569481, 1),
(7, 2, 'Last update: <b>This is a text</b>', 'This is a new content', 1, 1557568938, NULL, 1),
(8, 2, 'Sample <h1> text', 'This is a<b>tag</b>', 1, 1557568959, NULL, 1),
(9, 2, 'new content after permission check', 'This is new content', 1, 1557572369, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_on` int(11) NOT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`, `created_on`, `modified_on`, `active`) VALUES
(1, 'Administrator', 1557554728, NULL, 'Y'),
(2, 'Author', 1557554728, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_permissions_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_on` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_permissions_id`, `role_id`, `permission_id`, `created_on`) VALUES
(1, 1, 1, 1557554728),
(2, 1, 2, 1557554728),
(3, 1, 3, 1557554728),
(4, 1, 4, 1557554728),
(5, 1, 5, 1557554728),
(6, 1, 6, 1557554728),
(7, 1, 7, 1557554728),
(8, 2, 1, 1557554728),
(9, 2, 2, 1557554728),
(10, 2, 3, 1557554728),
(11, 2, 5, 1557554728),
(12, 2, 7, 1557554728);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_on` int(11) NOT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `password_hash`, `email`, `created_on`, `modified_on`, `active`) VALUES
(1, 'Administrator', '$2y$10$K2g9zOCJ3PHBIzXIv4DXDumbsN0wwdDErWv/cBj5NrVciGrpX.AY2', 'admin@geekpoint.net', 1557554728, NULL, 'Y'),
(2, 'Shadab', '$2y$10$K2g9zOCJ3PHBIzXIv4DXDumbsN0wwdDErWv/cBj5NrVciGrpX.AY2', 'shadab@geekpoint.net', 1557554728, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_roles_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_on` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_roles_id`, `user_id`, `role_id`, `created_on`) VALUES
(1, 1, 1, 1557554728),
(2, 2, 2, 1557554728);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_permissions_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_roles_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `role_permissions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `user_roles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
