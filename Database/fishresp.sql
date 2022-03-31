-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2022 at 01:24 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fishresp`
--

-- --------------------------------------------------------

--
-- Table structure for table `br_test`
--

CREATE TABLE `br_test` (
  `id` int(11) NOT NULL,
  `name` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `br_test`
--

INSERT INTO `br_test` (`id`, `name`) VALUES
(0, ''),
(1, 'Yes'),
(2, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `filters`
--

CREATE TABLE `filters` (
  `id` int(11) NOT NULL,
  `name` varchar(16) DEFAULT NULL,
  `sql_code` varchar(128) NOT NULL COMMENT 'SQL code for filter request',
  `html_code` varchar(256) NOT NULL COMMENT 'HTML code for table'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `filters`
--

INSERT INTO `filters` (`id`, `name`, `sql_code`, `html_code`) VALUES
(0, 'disabled', 'TRUE', '<div class=\"disabled\">&nbsp;</div>'),
(1, 'textbox', '%JSON_ID%.name LIKE \"%VALUE%%\" ', '<input class=\"Unbordered\" onchange=\"table.updateFilter(this)\" id=\"%ID%\" placeholder=\"%PLACEHOLDER%\">'),
(2, 'textbox_listed', '%JSON_ID%.name LIKE \"%VALUE%%\" ', '<input class=\"Unbordered\" onchange=\"table.updateFilter(this)\" id=\"%ID%\" placeholder=\"%PLACEHOLDER%\" list=\"%ID%_list\">'),
(3, 'min_max', '', '<input class=\"Unbordered\" onchange=\"table.updateFilter(this)\" id=\"%ID%__min\" placeholder=\"min\">-<input class=\"Unbordered\" onchange=\"table.updateFilter(this)\" id=\"%ID%__max\" placeholder=\"max\">'),
(4, 'select', '%JSON_ID%.name = \"%VALUE%\"', '<select class=\"Unbordered\" onchange=\"table.updateFilter(this)\" id=\"%ID%\">\r\n</select>');

-- --------------------------------------------------------

--
-- Table structure for table `js_cellcode`
--

CREATE TABLE `js_cellcode` (
  `id` int(11) NOT NULL,
  `code` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `js_cellcode`
--

INSERT INTO `js_cellcode` (`id`, `code`) VALUES
(0, 'object = document.createTextNode(\"\")'),
(1, 'var value = this.#json.data[curent_index].%JSON_ID%\r\nif (value == undefined)\r\n    value = \'\'\r\nobject = document.createTextNode(value)');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `id` int(11) NOT NULL,
  `species_id` int(11) DEFAULT NULL,
  `publication_id` int(11) DEFAULT NULL,
  `temperature` int(11) DEFAULT NULL,
  `salinity` int(11) DEFAULT NULL,
  `do_level` int(11) DEFAULT NULL,
  `smr_avg` float DEFAULT NULL,
  `smr_min` float DEFAULT NULL,
  `smr_max` float DEFAULT NULL,
  `mmr_avg` float DEFAULT NULL,
  `mmr_max` float DEFAULT NULL,
  `mmr_method_id` int(11) NOT NULL DEFAULT 0,
  `mass_avg` float DEFAULT NULL,
  `br_test_id` int(11) NOT NULL DEFAULT 0,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mmr_method`
--

CREATE TABLE `mmr_method` (
  `id` int(11) NOT NULL COMMENT 'Primary key',
  `name` varchar(64) NOT NULL COMMENT 'MMR method name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mmr_method`
--

INSERT INTO `mmr_method` (`id`, `name`) VALUES
(0, ''),
(1, 'Yes'),
(2, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `id` int(11) NOT NULL COMMENT 'Primary key',
  `name` varchar(64) NOT NULL COMMENT 'DOI: prefix/suffix'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `species`
--

CREATE TABLE `species` (
  `id` int(11) NOT NULL COMMENT 'Primary key',
  `name` varchar(256) NOT NULL COMMENT 'Species name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `table_data`
--

CREATE TABLE `table_data` (
  `id` int(11) NOT NULL,
  `caption` varchar(32) NOT NULL,
  `json_ident` varchar(32) NOT NULL,
  `filter_id` int(11) NOT NULL,
  `filter_placeholder` varchar(32) DEFAULT NULL,
  `js_cellcode_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_data`
--

INSERT INTO `table_data` (`id`, `caption`, `json_ident`, `filter_id`, `filter_placeholder`, `js_cellcode_id`) VALUES
(1, 'Species', 'species', 2, 'Name', 1),
(2, 'Publication', 'publication', 1, 'DOI', 1),
(3, 'Temperature', 'temperature', 3, NULL, 1),
(4, 'Salinity', 'salinity', 3, NULL, 1),
(5, 'DO level', 'do_level', 3, NULL, 1),
(6, 'SMR avg', 'smr_avg', 3, NULL, 1),
(7, 'SMR min', 'smr_min', 3, NULL, 1),
(8, 'SMR max', 'smr_max', 3, NULL, 1),
(9, 'MMR avg', 'mmr_avg', 3, NULL, 1),
(10, 'MMR min', 'mmr_min', 3, NULL, 1),
(11, 'MMR max', 'mmr_max', 3, NULL, 1),
(12, 'MMR method', 'mmr_method', 4, NULL, 1),
(13, 'Mass avg', 'mass_avg', 3, NULL, 1),
(14, 'BR test', 'br_test', 4, 'BR test', 1),
(15, 'Comment', 'comment', 0, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `br_test`
--
ALTER TABLE `br_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `js_cellcode`
--
ALTER TABLE `js_cellcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `measurements_ibfk_4` (`br_test_id`),
  ADD KEY `measurements_ibfk_2` (`publication_id`),
  ADD KEY `measurements_ibfk_3` (`species_id`),
  ADD KEY `measurements_ibfk_5` (`mmr_method_id`);

--
-- Indexes for table `mmr_method`
--
ALTER TABLE `mmr_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_data`
--
ALTER TABLE `table_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filter_id` (`filter_id`),
  ADD KEY `table_data_ibfk_2` (`js_cellcode_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `br_test`
--
ALTER TABLE `br_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `filters`
--
ALTER TABLE `filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `js_cellcode`
--
ALTER TABLE `js_cellcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mmr_method`
--
ALTER TABLE `mmr_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `publication`
--
ALTER TABLE `publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

--
-- AUTO_INCREMENT for table `species`
--
ALTER TABLE `species`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

--
-- AUTO_INCREMENT for table `table_data`
--
ALTER TABLE `table_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `measurements`
--
ALTER TABLE `measurements`
  ADD CONSTRAINT `measurements_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `measurements_ibfk_3` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `measurements_ibfk_4` FOREIGN KEY (`br_test_id`) REFERENCES `br_test` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `measurements_ibfk_5` FOREIGN KEY (`mmr_method_id`) REFERENCES `mmr_method` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `table_data`
--
ALTER TABLE `table_data`
  ADD CONSTRAINT `table_data_ibfk_1` FOREIGN KEY (`filter_id`) REFERENCES `filters` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `table_data_ibfk_2` FOREIGN KEY (`js_cellcode_id`) REFERENCES `js_cellcode` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
