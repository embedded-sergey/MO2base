-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 27 2022 г., 07:14
-- Версия сервера: 10.4.22-MariaDB
-- Версия PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `fishresp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL COMMENT 'Primary key',
  `species_id` int(11) DEFAULT NULL COMMENT 'N..1',
  `publication_id` int(11) DEFAULT NULL COMMENT 'N..1',
  `temperature` int(11) NOT NULL,
  `salinity` int(11) NOT NULL,
  `do_level` int(11) NOT NULL,
  `smr_avg` float NOT NULL,
  `smr_min` float NOT NULL,
  `smr_max` float NOT NULL,
  `mmr_avg` float NOT NULL,
  `mmr_min` float NOT NULL,
  `mmr_max` float NOT NULL,
  `mmr_method` int(11) DEFAULT NULL COMMENT 'N..1',
  `mass_avg` float NOT NULL,
  `vr_test` tinyint(1) NOT NULL DEFAULT 0,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `mmr_method`
--

CREATE TABLE `mmr_method` (
  `id` int(11) NOT NULL COMMENT 'Primary key',
  `name` varchar(64) NOT NULL COMMENT 'MMR method name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `publication`
--

CREATE TABLE `publication` (
  `id` int(11) NOT NULL COMMENT 'Primary key',
  `doi` varchar(64) NOT NULL COMMENT 'DOI: prefix/suffix'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `species`
--

CREATE TABLE `species` (
  `id` int(11) NOT NULL COMMENT 'Primary key',
  `name` varchar(256) NOT NULL COMMENT 'Species name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publication_id` (`publication_id`),
  ADD KEY `species_id` (`species_id`),
  ADD KEY `data_ibfk_3` (`mmr_method`);

--
-- Индексы таблицы `mmr_method`
--
ALTER TABLE `mmr_method`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

--
-- AUTO_INCREMENT для таблицы `mmr_method`
--
ALTER TABLE `mmr_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

--
-- AUTO_INCREMENT для таблицы `publication`
--
ALTER TABLE `publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

--
-- AUTO_INCREMENT для таблицы `species`
--
ALTER TABLE `species`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `data_ibfk_2` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `data_ibfk_3` FOREIGN KEY (`mmr_method`) REFERENCES `mmr_method` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
