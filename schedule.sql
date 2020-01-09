-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 09 2020 г., 18:17
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `schedule`
--

-- --------------------------------------------------------

--
-- Структура таблицы `changes`
--

CREATE TABLE `changes` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `num` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `cab` varchar(90) DEFAULT NULL,
  `teacher` varchar(255) DEFAULT NULL,
  `is_main` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `changes`
--

INSERT INTO `changes` (`id`, `group_id`, `day`, `num`, `subject`, `cab`, `teacher`, `is_main`) VALUES
(1, 2, '2019-12-11', 1, 'сабақ кестесі бойынша', NULL, NULL, 1),
(2, 2, '2019-12-11', 2, 'сабақ кестесі бойынша', NULL, NULL, 1),
(3, 2, '2019-12-11', 3, 'сабақ кестесі бойынша', NULL, NULL, 1),
(4, 2, '2019-12-11', 4, 'сабақ кестесі бойынша', NULL, NULL, 1),
(5, 2, '2019-12-11', 5, 'Өлкетану факультативі Солтанова А.М.', NULL, NULL, NULL),
(6, 3, '2019-12-11', 1, 'урок по основному расписанию', NULL, NULL, 1),
(7, 3, '2019-12-11', 2, 'урок по основному расписанию', NULL, NULL, 1),
(8, 3, '2019-12-11', 3, 'Физическая культура Косбармаков А.Д./Серёгина Е.А.', NULL, NULL, NULL),
(9, 3, '2019-12-11', 4, 'Иностранный язык Шнайдер С.А./Куршакова М.В.', NULL, NULL, NULL),
(10, 4, '2019-12-11', 1, 'Саясат. және әлеумет. негіз. Солтанова А.М.', NULL, NULL, NULL),
(11, 4, '2019-12-11', 2, 'Электротехниканың теориялық негіздері Канагатова М.С.', NULL, NULL, NULL),
(12, 4, '2019-12-11', 3, 'Кәсіптік шет тілі Шнайдер С.А.', NULL, NULL, NULL),
(13, 4, '2019-12-11', 4, 'Математика Саденова Р.Ж.', NULL, NULL, NULL),
(14, 11, '2019-12-11', 1, 'Математика Саденова Р.Ж.', NULL, NULL, NULL),
(15, 11, '2019-12-11', 2, 'сабақ кестесі бойынша', NULL, NULL, 1),
(16, 11, '2019-12-11', 3, 'География  Солтанова А.М.', NULL, NULL, NULL),
(17, 11, '2019-12-11', 4, 'АӘД Кабдыгалиев Е.К.', NULL, NULL, NULL),
(18, 12, '2019-12-11', 1, 'сабақ кестесі бойынша', NULL, NULL, 1),
(19, 12, '2019-12-11', 2, 'Физика Хасенова А.Х.', NULL, NULL, NULL),
(20, 12, '2019-12-11', 3, 'сабақ кестесі бойынша', NULL, NULL, 1),
(21, 12, '2019-12-11', 4, 'Мәдениеттану Солтанова А.М.', NULL, NULL, NULL),
(22, 13, '2019-12-11', 1, '---', NULL, NULL, NULL),
(23, 13, '2019-12-11', 2, 'сабақ кестесі бойынша', NULL, NULL, 1),
(24, 13, '2019-12-11', 3, 'Қазақстан тарихы Кизатова Г.С.', NULL, NULL, NULL),
(25, 13, '2019-12-11', 4, 'АжБН Жакупова А.С./Шойтынов Д.Р.', NULL, NULL, NULL),
(26, 13, '2019-12-11', 5, 'Жоғары математика негіздері   Саденова Р.Ж.', NULL, NULL, NULL),
(27, 14, '2019-12-11', 1, '---', NULL, NULL, NULL),
(28, 14, '2019-12-11', 2, 'Саясат. және әлеумет. негіз. Солтанова А.М.', NULL, NULL, NULL),
(29, 14, '2019-12-11', 3, 'сабақ кестесі бойынша', NULL, NULL, 1),
(30, 14, '2019-12-11', 4, ' Дене тәрбиесі Косбармаков А.Д.', NULL, NULL, NULL),
(31, 14, '2019-12-11', 5, 'КГжГ  Шойтынов Д.Р.', NULL, NULL, NULL),
(32, 15, '2019-12-11', 1, 'Бухгалтерлік есеп Жуматаева Р.К.', NULL, NULL, NULL),
(33, 15, '2019-12-11', 2, 'сабақ кестесі бойынша', NULL, NULL, 1),
(34, 15, '2019-12-11', 3, 'сабақ кестесі бойынша', NULL, NULL, 1),
(35, 15, '2019-12-11', 4, 'сабақ кестесі бойынша', NULL, NULL, 1),
(36, 15, '2019-12-11', 5, '---', NULL, NULL, NULL),
(37, 16, '2019-12-11', 1, 'Иностранный язык                                                                                                               Шнайдер С.А./Мустафин Е.Е.', NULL, NULL, NULL),
(38, 16, '2019-12-11', 2, 'урок по основному расписанию', NULL, NULL, 1),
(39, 16, '2019-12-11', 3, 'урок по основному расписанию', NULL, NULL, 1),
(40, 16, '2019-12-11', 4, 'Химия Каримова Т.Т.', NULL, NULL, NULL),
(41, 17, '2019-12-11', 1, 'Физика Хасенова А.Х.', NULL, NULL, NULL),
(42, 17, '2019-12-11', 2, 'Казахская литература Омарова К.А.', NULL, NULL, NULL),
(43, 17, '2019-12-11', 3, 'Иностранный язык Куршакова М.В./Мустафин Е.Е.', NULL, NULL, NULL),
(44, 17, '2019-12-11', 4, 'Основы экономики  Жумалиева Е.С.', NULL, NULL, NULL),
(45, 17, '2019-12-11', 5, 'Самопознание Льясова А.А.', NULL, NULL, NULL),
(46, 18, '2019-12-11', 1, 'урок по основному расписанию', NULL, NULL, 1),
(47, 18, '2019-12-11', 2, 'Иностранный язык Шнайдер С.А./Куршакова М.В.', NULL, NULL, NULL),
(48, 18, '2019-12-11', 3, 'урок по основному расписанию', NULL, NULL, 1),
(49, 18, '2019-12-11', 4, 'Физическая культура Алданов Р.А./Серёгина Е.А.', NULL, NULL, NULL),
(50, 19, '2019-12-11', 1, '---', NULL, NULL, NULL),
(51, 19, '2019-12-11', 2, 'урок по основному расписанию', NULL, NULL, 1),
(52, 19, '2019-12-11', 3, 'урок по основному расписанию', NULL, NULL, 1),
(53, 19, '2019-12-11', 4, 'урок по основному расписанию', NULL, NULL, 1),
(54, 19, '2019-12-11', 5, 'Профессиональный иностранный язык Куршакова М.В./Мустафин Е.Е.', NULL, NULL, NULL),
(55, 20, '2019-12-11', 1, 'История Казахстана Кизатова Г.С.', NULL, NULL, NULL),
(56, 20, '2019-12-11', 2, 'Математика Комарова Н.В.', NULL, NULL, NULL),
(57, 20, '2019-12-11', 3, 'Осн. политологии и социлогии Льясова А.А.', NULL, NULL, NULL),
(58, 20, '2019-12-11', 4, 'Казахский язык Абышева А.М./Омарова К.А.', NULL, NULL, NULL),
(59, 21, '2019-12-11', 1, 'урок по основному расписанию', NULL, NULL, 1),
(60, 21, '2019-12-11', 2, 'урок по основному расписанию', NULL, NULL, 1),
(61, 21, '2019-12-11', 3, 'урок по основному расписанию', NULL, NULL, 1),
(62, 21, '2019-12-11', 4, 'Этика и псих.дел.отношений Муканова Д.Ж.', NULL, NULL, NULL),
(63, 22, '2019-12-11', 1, 'ИСВКиПД  Шойтынов Д.Р.', NULL, NULL, NULL),
(64, 22, '2019-12-11', 2, 'урок по основному расписанию', NULL, NULL, 1),
(65, 22, '2019-12-11', 3, 'Основы высшей математики Саденова Р.Ж.', NULL, NULL, NULL),
(66, 22, '2019-12-11', 4, 'урок по основному расписанию', NULL, NULL, 1),
(67, 23, '2019-12-11', 1, 'ОАиП Жалпаков Т.Т.', NULL, NULL, NULL),
(68, 23, '2019-12-11', 2, 'А в ИС Зайнутдинов Э.Ф.', NULL, NULL, NULL),
(69, 23, '2019-12-11', 3, 'урок по основному расписанию', NULL, NULL, 1),
(70, 23, '2019-12-11', 4, 'урок по основному расписанию', NULL, NULL, 1),
(71, 24, '2019-12-11', 1, 'урок по основному расписанию', NULL, NULL, 1),
(72, 24, '2019-12-11', 2, 'Физическая культура Косбармаков А.Д./Серёгина Е.А.', NULL, NULL, NULL),
(73, 24, '2019-12-11', 3, 'урок по основному расписанию', NULL, NULL, 1),
(74, 24, '2019-12-11', 4, 'урок по основному расписанию', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `cikls`
--

CREATE TABLE `cikls` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `name_kz` varchar(255) DEFAULT NULL,
  `short_name_kz` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cikls`
--

INSERT INTO `cikls` (`id`, `name`, `short_name`, `name_kz`, `short_name_kz`) VALUES
(1, 'общеобразовательные дисциплины', 'ООД', NULL, NULL),
(2, 'общегуманитарные дисциплины', 'ОГД', NULL, NULL),
(3, 'социально-экономические дисциплины', 'СЭД', NULL, NULL),
(4, 'общепрофессиональные дисциплины', 'ОПД', NULL, NULL),
(5, 'специальные дисциплины', 'СД', NULL, NULL),
(6, 'профессиональная практика', 'ПП', NULL, NULL),
(7, 'консультации', NULL, NULL, NULL),
(8, 'факультатив', NULL, NULL, NULL),
(9, 'экзамены', NULL, NULL, NULL),
(10, 'Дисциплины, определяемая организацией образования', 'ООД', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `college_graphics`
--

CREATE TABLE `college_graphics` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `start1` date DEFAULT NULL,
  `end1` date DEFAULT NULL,
  `start2` date DEFAULT NULL,
  `end2` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `college_graphics`
--

INSERT INTO `college_graphics` (`id`, `year`, `start1`, `end1`, `start2`, `end2`) VALUES
(2, 2019, '2019-09-02', '2020-01-12', '2020-01-27', '2020-06-28');

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'Информационные технологии'),
(2, 'Электротехника');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `year_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `department_id`, `lang_id`, `year_create`) VALUES
(1, 'ИС-426', 1, 2, 2016),
(2, 'ТЭ-139к', 2, 1, 2019),
(3, 'ТЭ-149р', 2, 2, 2019),
(4, 'ТЭ-218к', 2, 1, 2018),
(5, 'ТЭ-228р', 2, 2, 2018),
(6, 'ЭЛ-327', 2, 2, 2017),
(7, 'ТЭ-317к', 2, 1, 2017),
(8, 'ТЭ-327р', 2, 2, 2017),
(9, 'ТЭ-416к', 2, 1, 2016),
(10, 'ТЭ-426р', 2, 2, 2016),
(11, 'АЖ-119', 1, 1, 2019),
(12, 'ЕТ-159', 1, 1, 2019),
(13, 'АЖ-279', 1, 1, 2019),
(14, 'АЖ-218', 1, 1, 2018),
(15, 'АЖ-317', 1, 1, 2017),
(16, 'ИС-129', 1, 2, 2019),
(17, 'ВТ-169', 1, 2, 2019),
(18, 'М-129', 1, 2, 2019),
(19, 'ИС-228', 1, 2, 2018),
(20, 'ИС-248', 1, 2, 2018),
(21, 'М-228', 1, 2, 2018),
(22, 'ИС-388', 1, 2, 2018),
(23, 'ИС-327', 1, 2, 2017),
(24, 'ИС-337', 1, 2, 2017),
(25, 'ИС-436', 1, 2, 2016),
(26, 'АЖ-378', 1, 1, 2018),
(27, 'АЖ-416', 1, 1, 2016),
(28, 'АЖ-417', 1, 1, 2017);

-- --------------------------------------------------------

--
-- Структура таблицы `langs`
--

CREATE TABLE `langs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `langs`
--

INSERT INTO `langs` (`id`, `name`) VALUES
(1, 'Казахский'),
(2, 'Русский');

-- --------------------------------------------------------

--
-- Структура таблицы `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `cikl_id` int(11) DEFAULT NULL,
  `shifr` varchar(10) DEFAULT NULL,
  `shifr_kz` varchar(10) DEFAULT NULL,
  `semestr` int(11) NOT NULL,
  `is_exam` int(11) DEFAULT NULL,
  `is_zachet` int(11) DEFAULT NULL,
  `is_project` int(11) DEFAULT NULL,
  `controls` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `theory_main` int(11) DEFAULT NULL,
  `practice_main` int(11) DEFAULT NULL,
  `theory` int(11) DEFAULT NULL,
  `practice` int(11) DEFAULT NULL,
  `lab` int(11) DEFAULT NULL,
  `project` int(11) DEFAULT NULL,
  `exam` int(11) DEFAULT NULL,
  `consul` int(11) DEFAULT NULL,
  `subgroup` int(11) DEFAULT NULL,
  `weeks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `plans`
--

INSERT INTO `plans` (`id`, `group_id`, `subject_id`, `cikl_id`, `shifr`, `shifr_kz`, `semestr`, `is_exam`, `is_zachet`, `is_project`, `controls`, `total`, `theory_main`, `practice_main`, `theory`, `practice`, `lab`, `project`, `exam`, `consul`, `subgroup`, `weeks`) VALUES
(1, 1, 1, 1, NULL, NULL, 1, 1, NULL, NULL, 1, 36, NULL, 112, NULL, 36, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 1, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 20, NULL, 112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 1, 1, NULL, NULL, 3, 1, 1, NULL, 1, 20, NULL, 112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 2, 1, NULL, NULL, 1, 1, NULL, NULL, NULL, 36, NULL, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 2, 1, NULL, NULL, 2, NULL, 1, NULL, NULL, 84, NULL, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 3, 1, NULL, NULL, 1, NULL, 1, NULL, NULL, 38, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 3, 1, NULL, NULL, 2, 1, 1, NULL, NULL, 50, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 4, 1, NULL, NULL, 1, NULL, 1, NULL, 1, 38, 112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 4, 1, NULL, NULL, 2, 1, NULL, NULL, 1, 76, 112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 4, 1, NULL, NULL, 3, 1, 1, NULL, 1, 38, 112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 5, 1, NULL, NULL, 1, 1, NULL, NULL, 1, 68, NULL, 164, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 5, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 40, NULL, 164, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 6, 1, NULL, NULL, 1, NULL, 1, NULL, 1, 38, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 7, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 38, 88, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, 7, 1, NULL, NULL, 3, 1, 1, NULL, 1, 32, 88, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 1, 8, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 36, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, 9, 1, NULL, NULL, 1, 1, 1, NULL, 1, 44, 148, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 1, 9, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 72, 148, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 1, 9, 1, NULL, NULL, 3, 1, 1, NULL, 1, 46, 148, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 1, 10, 1, NULL, NULL, 1, NULL, 1, NULL, 1, 38, 46, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 1, 10, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 30, 46, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 1, 11, 1, NULL, NULL, 1, NULL, 1, NULL, 1, 36, 114, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 1, 11, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 38, 114, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 1, 11, 1, NULL, NULL, 3, 1, 1, NULL, 1, 38, 114, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 1, 12, 1, NULL, NULL, 1, NULL, 1, NULL, 1, 22, 54, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 1, 12, 1, NULL, NULL, 2, 1, 1, NULL, 1, 108, 54, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 1, 13, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 20, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 1, 14, 1, NULL, NULL, 1, NULL, 1, NULL, 1, 34, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 1, 15, 1, NULL, NULL, 1, 1, NULL, NULL, 1, 20, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 1, 15, 1, NULL, NULL, 2, 1, 1, NULL, 1, 42, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 1, 16, 1, NULL, NULL, 2, NULL, 1, NULL, NULL, 34, NULL, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 1, 17, 1, NULL, NULL, 1, NULL, 1, NULL, 1, 50, NULL, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 1, 17, 1, NULL, NULL, 2, NULL, 1, NULL, 1, 44, NULL, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 1, 18, 2, NULL, NULL, 4, 1, NULL, 1, 1, 108, NULL, 92, NULL, NULL, NULL, 36, NULL, NULL, NULL, NULL),
(35, 1, 18, 2, NULL, NULL, 5, 1, 1, NULL, 1, 72, NULL, 92, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 1, 19, 2, NULL, NULL, 3, 1, NULL, NULL, 1, 44, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 1, 19, 2, NULL, NULL, 4, 1, 1, NULL, 1, 36, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 1, 17, 2, NULL, NULL, 3, 1, NULL, NULL, 1, 44, NULL, 260, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 1, 17, 2, NULL, NULL, 4, NULL, 1, NULL, 1, 72, NULL, 260, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 1, 17, 2, NULL, NULL, 5, 1, NULL, NULL, NULL, 44, NULL, 260, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 1, 17, 2, NULL, NULL, 6, NULL, 1, NULL, 1, 22, NULL, 260, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 1, 17, 2, NULL, NULL, 7, 1, 1, NULL, 1, 32, NULL, 260, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 1, 20, 3, NULL, NULL, 1, 1, 1, 1, 1, 40, 38, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL),
(44, 1, 21, 3, NULL, NULL, 3, NULL, 1, NULL, 1, 56, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 1, 22, 3, NULL, NULL, 2, NULL, 1, NULL, 1, 44, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 1, 23, 3, NULL, NULL, 1, NULL, 1, NULL, 1, 36, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 1, 24, 3, NULL, NULL, 1, NULL, 1, NULL, 1, 108, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 1, 25, 4, NULL, NULL, 6, NULL, NULL, NULL, 1, 144, 38, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 1, 25, 4, NULL, NULL, 7, NULL, 1, NULL, NULL, 72, 38, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 1, 26, 4, NULL, NULL, 4, NULL, NULL, NULL, 1, 144, 132, 62, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 1, 26, 4, NULL, NULL, 5, 1, NULL, NULL, 1, 108, 132, 62, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 1, 27, 4, NULL, NULL, 5, NULL, NULL, NULL, 1, 432, 44, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 1, 27, 4, NULL, NULL, 6, NULL, 1, NULL, NULL, 216, 44, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 1, 28, 4, NULL, NULL, 4, NULL, NULL, NULL, 1, 288, 34, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 1, 28, 4, NULL, NULL, 5, NULL, 1, NULL, NULL, 50, 34, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 1, 29, 4, NULL, NULL, 3, NULL, NULL, NULL, 1, 20, 40, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 1, 29, 4, NULL, NULL, 4, 1, NULL, NULL, NULL, 14, 40, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 1, 30, 4, NULL, NULL, 3, NULL, NULL, NULL, 1, 14, 58, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 1, 30, 4, NULL, NULL, 4, 1, NULL, NULL, 1, 14, 58, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 1, 31, 4, NULL, NULL, 3, NULL, 1, NULL, 1, 10, 14, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 1, 32, 4, NULL, NULL, 3, NULL, 1, NULL, 1, 36, 20, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 1, 33, 4, NULL, NULL, 7, NULL, 1, NULL, 1, 46, 34, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 1, 34, 5, NULL, NULL, 3, NULL, NULL, NULL, 1, 72, 90, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 1, 34, 5, NULL, NULL, 4, NULL, NULL, NULL, 1, 60, 90, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 1, 34, 5, NULL, NULL, 5, 1, NULL, 1, NULL, 12, 90, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 1, 35, 5, NULL, NULL, 5, NULL, 1, NULL, 1, 48, 52, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 1, 35, 5, NULL, NULL, 6, 1, NULL, NULL, 1, 36, 52, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 1, 36, 5, NULL, NULL, 6, NULL, NULL, NULL, 1, 36, 50, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 1, 36, 5, NULL, NULL, 7, 1, NULL, NULL, NULL, 44, 50, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 1, 37, 5, NULL, NULL, 5, NULL, NULL, NULL, 1, 54, 66, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 1, 37, 5, NULL, NULL, 6, 1, NULL, NULL, NULL, 36, 66, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 1, 38, 5, NULL, NULL, 6, NULL, NULL, NULL, 1, 36, 52, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 1, 38, 5, NULL, NULL, 7, 1, NULL, NULL, NULL, 44, 52, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 1, 39, 5, NULL, NULL, 2, NULL, 1, NULL, NULL, 72, 58, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 1, 40, 5, NULL, NULL, 6, NULL, NULL, NULL, 1, 34, 48, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 1, 40, 5, NULL, NULL, 7, 1, NULL, NULL, NULL, 44, 48, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 1, 41, 5, NULL, NULL, 6, NULL, NULL, NULL, 1, 26, 28, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 1, 41, 5, NULL, NULL, 7, NULL, 1, NULL, NULL, 22, 28, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 1, 42, 5, NULL, NULL, 4, NULL, 1, NULL, NULL, 32, 8, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 1, 43, 5, NULL, NULL, 4, NULL, NULL, NULL, 1, 30, 98, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 1, 43, 5, NULL, NULL, 5, NULL, NULL, NULL, 1, 74, 98, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 1, 43, 5, NULL, NULL, 6, NULL, NULL, NULL, NULL, 20, 98, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 1, 43, 5, NULL, NULL, 7, 1, NULL, 1, 1, 40, 98, 46, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL),
(84, 1, 44, 5, NULL, NULL, 5, NULL, NULL, NULL, 1, 56, 38, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 1, 45, 5, NULL, NULL, 7, NULL, 1, NULL, 1, 44, 36, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 1, 46, 6, NULL, NULL, 2, NULL, NULL, NULL, NULL, 36, NULL, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 1, 46, 6, NULL, NULL, 4, NULL, NULL, NULL, NULL, 36, NULL, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 1, 39, 6, NULL, NULL, 4, NULL, 1, NULL, NULL, 72, NULL, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 1, 35, 6, NULL, NULL, 6, 1, NULL, NULL, NULL, 72, NULL, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 1, 47, 6, NULL, NULL, 6, NULL, NULL, NULL, NULL, 108, NULL, 108, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 1, 48, 6, NULL, NULL, 6, NULL, NULL, NULL, NULL, 144, NULL, 144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 1, 49, 6, NULL, NULL, 6, NULL, NULL, NULL, NULL, 72, NULL, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 1, 50, 6, NULL, NULL, 4, NULL, NULL, NULL, NULL, 144, NULL, 144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 1, 51, 6, NULL, NULL, 4, NULL, NULL, NULL, NULL, 108, NULL, 108, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 1, 52, 6, NULL, NULL, 8, NULL, NULL, NULL, NULL, 432, NULL, 432, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 1, 53, 6, NULL, NULL, 8, NULL, NULL, NULL, NULL, 216, NULL, 216, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 1, 54, 6, NULL, NULL, 8, NULL, NULL, NULL, NULL, 288, NULL, 288, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 1, 55, 7, NULL, NULL, 1, NULL, NULL, NULL, NULL, 50, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 1, 55, 7, NULL, NULL, 2, NULL, NULL, NULL, NULL, 50, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 1, 55, 7, NULL, NULL, 3, NULL, NULL, NULL, NULL, 50, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 1, 55, 7, NULL, NULL, 4, NULL, NULL, NULL, NULL, 50, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 1, 55, 7, NULL, NULL, 5, NULL, NULL, NULL, NULL, 50, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 1, 55, 7, NULL, NULL, 6, NULL, NULL, NULL, NULL, 50, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 1, 55, 7, NULL, NULL, 7, NULL, NULL, NULL, NULL, 50, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 1, 55, 7, NULL, NULL, 8, NULL, NULL, NULL, NULL, 50, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 1, 56, 8, NULL, NULL, 1, NULL, NULL, NULL, NULL, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 1, 56, 8, NULL, NULL, 2, NULL, NULL, NULL, NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 1, 56, 8, NULL, NULL, 3, NULL, NULL, NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 1, 56, 8, NULL, NULL, 4, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 1, 57, 8, NULL, NULL, 2, NULL, NULL, NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 1, 58, 8, NULL, NULL, 3, NULL, NULL, NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 1, 59, 8, NULL, NULL, 7, NULL, NULL, NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 1, 60, 8, NULL, NULL, 5, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 1, 61, 8, NULL, NULL, 6, NULL, NULL, NULL, NULL, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 1, 62, 8, NULL, NULL, 1, NULL, NULL, NULL, NULL, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 1, 62, 8, NULL, NULL, 2, NULL, NULL, NULL, NULL, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 1, 62, 8, NULL, NULL, 3, NULL, NULL, NULL, NULL, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 1, 62, 8, NULL, NULL, 4, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 1, 62, 8, NULL, NULL, 5, NULL, NULL, NULL, NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 1, 62, 8, NULL, NULL, 7, NULL, NULL, NULL, NULL, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 1, 62, 8, NULL, NULL, 8, NULL, NULL, NULL, NULL, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 1, 63, 9, NULL, NULL, 3, NULL, NULL, NULL, NULL, 36, NULL, 216, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 1, 63, 9, NULL, NULL, 4, NULL, NULL, NULL, NULL, 36, NULL, 216, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 1, 63, 9, NULL, NULL, 5, NULL, NULL, NULL, NULL, 36, NULL, 216, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 1, 63, 9, NULL, NULL, 6, NULL, NULL, NULL, NULL, 36, NULL, 216, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 1, 63, 9, NULL, NULL, 7, NULL, NULL, NULL, NULL, 72, NULL, 216, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 1, 64, 9, NULL, NULL, 8, NULL, NULL, NULL, NULL, 60, NULL, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 1, 65, 9, NULL, NULL, 8, NULL, NULL, NULL, NULL, 12, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 1, 66, 10, NULL, NULL, 7, NULL, 1, NULL, 1, 48, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `semestr` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `num` int(11) NOT NULL,
  `cab` varchar(90) DEFAULT NULL,
  `teacher` varchar(255) DEFAULT NULL,
  `day` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `schedules`
--

INSERT INTO `schedules` (`id`, `group_id`, `year`, `semestr`, `subject`, `num`, `cab`, `teacher`, `day`) VALUES
(1, 16, 2019, 1, 'Физика', 1, NULL, 'Жагапарова Г.С.', 1),
(2, 16, 2019, 1, 'Информатика', 2, NULL, 'Джакина А.А./Садыкова Ж.Е.', 1),
(3, 16, 2019, 1, 'НВП', 3, NULL, 'Кабдыгалиев Е.К.', 1),
(4, 16, 2019, 1, 'Русский язык                                                                                       Зарипова Д.Н.', 4, NULL, 'Казахская литература Омарова К.А.', 1),
(5, 16, 2019, 1, 'Химия', 1, NULL, 'Каримова Т.Т.', 2),
(6, 16, 2019, 1, 'Математика', 2, NULL, 'Саденова Р.Ж.', 2),
(7, 16, 2019, 1, 'Казахская литература', 3, NULL, 'Омарова К.А.', 2),
(8, 16, 2019, 1, 'Физическая культура', 1, NULL, 'Бондарь В.Н./Серёгина Е.А.', 3),
(9, 16, 2019, 1, 'Казахский язык', 2, NULL, 'Абышева А.Б./Жактай А.М.', 3),
(10, 16, 2019, 1, 'Всемирная история', 3, NULL, 'Кизатова Г.С.', 3),
(11, 16, 2019, 1, 'Иностранный язык', 4, NULL, 'Шнайдер С.А./Мустафин Е.Е.', 3),
(12, 16, 2019, 1, 'География', 1, NULL, 'Солтанова А.М.', 4),
(13, 16, 2019, 1, 'Русская литература', 2, NULL, 'Сагатова А.К.', 4),
(14, 16, 2019, 1, 'Математика', 3, NULL, 'Саденова Р.Ж.', 4),
(15, 16, 2019, 1, 'Физика', 4, NULL, 'Жагапарова Г.С.', 4),
(16, 16, 2019, 1, 'Иностранный язык', 1, NULL, 'Шнайдер С.А./Мустафин Е.Е.', 5),
(17, 16, 2019, 1, 'Физическая культура', 2, NULL, 'Бондарь В.Н./Серёгина Е.А.', 5),
(18, 16, 2019, 1, 'Русский язык', 3, NULL, 'Зарипова Д.Н.', 5),
(19, 17, 2019, 1, 'Физическая культура', 1, NULL, 'Кривушкин В.П./Серёгина Е.А.', 1),
(20, 17, 2019, 1, 'Математика', 2, NULL, 'Комарова Н.В.', 1),
(21, 17, 2019, 1, 'Информатика', 3, NULL, 'Джакина А.А./Комарова Н.В.', 1),
(22, 17, 2019, 1, 'Казахский язык                             Абышева А.Б./Омарова К.А.', 4, NULL, 'Физика                Хасенова А.Х.', 1),
(23, 17, 2019, 1, 'Основы экономики', 1, NULL, 'Жумалиева Е.С.', 2),
(24, 17, 2019, 1, 'Казахская литература', 2, NULL, 'Омарова К.А.', 2),
(25, 17, 2019, 1, 'Иностранный язык', 3, NULL, 'Кажикенова Г.М./Мустафин Е.Е.', 2),
(26, 17, 2019, 1, 'Физика', 1, NULL, 'Хасенова А.Х.', 3),
(27, 17, 2019, 1, 'Культурология', 2, NULL, 'Солтанова А.М.', 3),
(28, 17, 2019, 1, 'Физическая культура', 3, NULL, 'Кривушкин В.П./Серёгина Е.А.', 3),
(29, 17, 2019, 1, 'Математика', 4, NULL, 'Комарова Н.В.', 3),
(30, 17, 2019, 1, 'Русская литература                  Зарипова Д.Н.', 1, NULL, 'Иностранный язык Кажикенова Г.М./Мустафин Е.Е.', 4),
(31, 17, 2019, 1, 'Химия', 2, NULL, 'Каримова Т.Т.', 4),
(32, 17, 2019, 1, 'Основы права', 3, NULL, 'Льясова А.А.', 4),
(33, 17, 2019, 1, 'Казахский язык', 4, NULL, 'Абышева А.Б./Омарова К.А.', 4),
(34, 17, 2019, 1, 'Русский язык', 1, NULL, 'Зарипова Д.Н.', 5),
(35, 17, 2019, 1, 'Русская литература', 2, NULL, 'Зарипова Д.Н.', 5),
(36, 17, 2019, 1, 'Начальная военная подготовка', 3, NULL, 'Кабдыгалиев Е.К.', 5),
(37, 18, 2019, 1, 'Казахская литература', 1, NULL, 'Абышева А.Б.', 1),
(38, 18, 2019, 1, 'Всемирная история', 2, NULL, 'Кизатова Г.С.', 1),
(39, 18, 2019, 1, 'Казахский язык', 3, NULL, 'Абышева А.Б./Жактай А.М.', 1),
(40, 18, 2019, 1, 'География', 4, NULL, 'Солтанова А.М.', 1),
(41, 18, 2019, 1, 'Химия              Каримова Т.Т.', 1, NULL, 'Физика        Жагапарова Г.С.', 2),
(42, 18, 2019, 1, 'Иностранный язык', 2, NULL, 'Шнайдер С.А./Кажикенова Г.М.', 2),
(43, 18, 2019, 1, 'Русская литература', 3, NULL, 'Зарипова Д.Н.', 2),
(44, 18, 2019, 1, 'Физическая культура', 4, NULL, 'Бондарь В.Н./Серёгина Е.А.', 2),
(45, 18, 2019, 1, 'НВП', 1, NULL, 'Кабдыгалиев Е.К.', 3),
(46, 18, 2019, 1, 'Математика', 2, NULL, 'Комарова Н.В.', 3),
(47, 18, 2019, 1, 'Физика', 3, NULL, 'Жагапарова Г.С.', 3),
(48, 18, 2019, 1, 'История Казахстана', 1, NULL, 'Кизатова Г.С.', 4),
(49, 18, 2019, 1, 'Физическая культура', 2, NULL, 'Бондарь В.Н./Серёгина Е.А.', 4),
(50, 18, 2019, 1, 'Иностранный язык', 3, NULL, 'Шнайдер С.А./Кажикенова Г.М.', 4),
(51, 18, 2019, 1, 'Русский язык', 1, NULL, 'Сагатова А.К.', 5),
(52, 18, 2019, 1, 'Химия', 2, NULL, 'Каримова Т.Т.', 5),
(53, 18, 2019, 1, 'Информатика', 3, NULL, 'Джакина А.А./Курмангазина А.Ж.', 5),
(54, 18, 2019, 1, 'Основы экономики', 4, NULL, 'Холодова С.М.', 5),
(55, 19, 2019, 1, 'ОАиП', 1, NULL, 'Жалпаков Т.Т.', 1),
(56, 19, 2019, 1, 'Физическая культура', 2, NULL, 'Бондарь В.Н./Кривушкин В.П.', 1),
(57, 19, 2019, 1, 'Weв-программирование', 3, NULL, 'Шойтынов Д.Р.', 1),
(58, 19, 2019, 1, 'Профессиональный иностранный язык', 1, NULL, 'Кажикенова Г.М./Мустафин Е.Е.', 2),
(59, 19, 2019, 1, 'Казахский язык', 2, NULL, 'Абышева А.Б./Жактай А.М.', 2),
(60, 19, 2019, 1, 'Основы менеджмента и маркетинга', 3, NULL, 'Холодова С.М.', 2),
(61, 19, 2019, 1, 'Основы высшей математики', 4, NULL, 'Комарова Н.В.', 2),
(62, 19, 2019, 1, 'ОАиП               Жалпаков Т.Т.', 1, NULL, 'Основы высшей математики    Комарова Н.В.', 3),
(63, 19, 2019, 1, 'История Казахстана', 2, NULL, 'Кизатова Г.С.', 3),
(64, 19, 2019, 1, 'Профессиональный казахский язык', 3, NULL, 'Абышева А.Б./Жактай А.М.', 3),
(65, 19, 2019, 1, 'Физическая культура', 4, NULL, 'Бондарь В.Н./Кривушкин В.П.', 3),
(66, 19, 2019, 1, '-----', 1, NULL, '', 4),
(67, 19, 2019, 1, 'Русская литература', 2, NULL, 'Зарипова Д.Н.', 4),
(68, 19, 2019, 1, 'Математика', 3, NULL, 'Комарова Н.В.', 4),
(69, 19, 2019, 1, 'ОСиСО', 4, NULL, 'Рахимбаев М.М.', 4),
(70, 19, 2019, 1, 'Физика', 1, NULL, 'Жагапарова Г.С.', 5),
(71, 19, 2019, 1, 'Weв-программирование             Шойтынов Д.Р.', 2, NULL, 'КГиГ       Джакина А.А..', 5),
(72, 19, 2019, 1, 'Основы политологии и социологии', 3, NULL, 'Льясова А.А.', 5),
(73, 19, 2019, 1, 'Делопроизводство на казахском языке', 4, NULL, 'Жактай А.М.', 5),
(74, 20, 2019, 1, 'Weв-программирование', 1, NULL, 'Шойтынов Д.Р.', 1),
(75, 20, 2019, 1, 'ОАиП', 2, NULL, 'Жалпаков Т.Т.', 1),
(76, 20, 2019, 1, 'Основы менеджмента и маркетинга', 3, NULL, 'Холодова С.М.', 1),
(77, 20, 2019, 1, 'Физика', 4, NULL, 'Жагапарова Г.С.', 1),
(78, 20, 2019, 1, 'Математика', 1, NULL, 'Комарова Н.В.', 2),
(79, 20, 2019, 1, 'Основы социологии и политологии', 2, NULL, 'Льясова А.А.', 2),
(80, 20, 2019, 1, 'История Казахстана', 3, NULL, 'Кизатова Г.С.', 2),
(81, 20, 2019, 1, 'Казахский язык', 4, NULL, 'Абышева А.Б./Омарова К.А.', 2),
(82, 20, 2019, 1, 'Основы высшей математики    Комарова Н.В.', 1, NULL, 'КГиГ    Джакина А.А.', 3),
(83, 20, 2019, 1, 'Физическая культура', 2, NULL, 'Бондарь В.Н./Серёгина Е.А.', 3),
(84, 20, 2019, 1, 'ОСиСО', 3, NULL, 'Рахимбаев М.М.', 3),
(85, 20, 2019, 1, 'Профессиональный казахский язык', 4, NULL, 'Абышева А.Б./Жактай А.М.', 3),
(86, 20, 2019, 1, '-----', 1, NULL, '', 4),
(87, 20, 2019, 1, 'Основы высшей математики', 2, NULL, 'Комарова Н.В.', 4),
(88, 20, 2019, 1, 'Делопроизводство на казахском языке', 3, NULL, 'Жактай А.М.', 4),
(89, 20, 2019, 1, 'Русская литература', 4, NULL, 'Зарипова Д.Н.', 4),
(90, 20, 2019, 1, 'Физическая культура', 1, NULL, 'Бондарь В.Н./Серёгина Е.А.', 5),
(91, 20, 2019, 1, 'ОАиП               Жалпаков Т.Т.', 2, NULL, 'Weв-программирование             Шойтынов Д.Р.', 5),
(92, 20, 2019, 1, 'Профессиональный иностранный язык', 3, NULL, 'Шнайдер С.А./Мустафин Е.Е.', 5),
(93, 21, 2019, 1, 'Техническое оснащение предприятия (отрасли) и охрана труда', 1, NULL, 'Холодова С.М.', 1),
(94, 21, 2019, 1, 'Основы маркетинга', 2, NULL, 'Холодова С.М.', 1),
(95, 21, 2019, 1, 'Этика и психология деловых отношений', 3, NULL, 'Муканова Д.Ж.', 1),
(96, 21, 2019, 1, 'Физическая культура', 4, NULL, 'Кривушкин В.П.', 1),
(97, 21, 2019, 1, 'Организация и технология отрасли', 1, NULL, 'Жумалиева Е.С.', 2),
(98, 21, 2019, 1, 'Дисциплина с учетом специализации отрасли', 2, NULL, 'Жумалиева Е.С.', 2),
(99, 21, 2019, 1, 'Математика', 3, NULL, 'Комарова Н.В.', 2),
(100, 21, 2019, 1, 'Экономическая информатика и ВТ  Джакина А.А.', 1, NULL, 'Этика и психология деловых отношений       Муканова Д.Ж.', 3),
(101, 21, 2019, 1, 'Физическая культура', 2, NULL, 'Кривушкин В.П.', 3),
(102, 21, 2019, 1, 'Основы микро и макроэкономики', 3, NULL, 'Холодова С.М.', 3),
(103, 21, 2019, 1, 'Организация и технология отрасли                  Жумалиева Е.С.', 4, NULL, 'Дисциплина с учетом специализации отрасли                                                         Жумалиева Е.С.', 3),
(104, 21, 2019, 1, 'Экономическая информатика и ВТ', 1, NULL, 'Джакина А.А.', 4),
(105, 21, 2019, 1, 'Основы микро и макро экономики          Холодова С.М..', 2, NULL, 'Основы маркетинга                                                                                                                   Холодова С.М.', 4),
(106, 21, 2019, 1, 'Русская литература', 3, NULL, 'Зарипова Д.Н.', 4),
(107, 21, 2019, 1, 'История Казахстана', 4, NULL, 'Кизатова Г.С.', 4),
(108, 21, 2019, 1, 'Техническое оснащение предприятия (отрасли) и охрана труда            Холодова С.М.', 1, NULL, 'Математика            Комарова Н.В.', 5),
(109, 21, 2019, 1, 'Казахский язык', 2, NULL, 'Абышева А.Б.', 5),
(110, 21, 2019, 1, 'Менеджмент организации', 3, NULL, 'Холодова С.М.', 5),
(111, 22, 2019, 1, 'Основы философии', 1, NULL, 'Солтанова А.М.', 1),
(112, 22, 2019, 1, 'Бухгалтерский учёт', 2, NULL, 'Кейль В.В.', 1),
(113, 22, 2019, 1, 'ОАиП', 3, NULL, 'Жалпаков Т.Т.', 1),
(114, 22, 2019, 1, 'Физическая культура', 4, NULL, 'Бондарь В.Н.', 1),
(115, 22, 2019, 1, 'Основы высшей математики', 1, NULL, 'Саденова Р.Ж.', 2),
(116, 22, 2019, 1, 'Бухгалтерский учёт', 2, NULL, 'Кейль В.В.', 2),
(117, 22, 2019, 1, 'ИСВКиПД', 3, NULL, 'Шойтынов Д.Р.', 2),
(118, 22, 2019, 1, 'Делопроизводство на казахском языке', 4, NULL, 'Жактай А.М.', 2),
(119, 22, 2019, 1, 'Общая теория статистики', 1, NULL, 'Холодова С.М.', 3),
(120, 22, 2019, 1, 'ОАиП', 2, NULL, 'Жалпаков Т.Т.', 3),
(121, 22, 2019, 1, 'Электротехника и электроника', 3, NULL, 'Тенизова О.В.', 3),
(122, 22, 2019, 1, 'Основы высшей математики', 1, NULL, 'Саденова Р.Ж.', 4),
(123, 22, 2019, 1, 'Электротехника и электроника   Тенизова О.В.', 2, NULL, 'ИСВКиПД    Шойтынов Д.Р.', 4),
(124, 22, 2019, 1, 'Физическая культура', 3, NULL, 'Бондарь В.Н.', 4),
(125, 22, 2019, 1, 'КГиГ', 4, NULL, 'Шойтынов Д.Р.', 4),
(126, 22, 2019, 1, 'Мультимедиа технологии', 1, NULL, 'Шойтынов Д.Р.', 5),
(127, 22, 2019, 1, 'Бухгалтерский учёт', 2, NULL, 'Кейль В.В.', 5),
(128, 22, 2019, 1, 'АИС', 3, NULL, 'Зайнутдинов Э.Ф.', 5),
(129, 23, 2019, 1, 'АИС', 1, NULL, 'Зайнутдинов Э.Ф.', 1),
(130, 23, 2019, 1, 'Электротехника и электроника', 2, NULL, 'Тенизова О.В.', 1),
(131, 23, 2019, 1, 'Физическая культура', 3, NULL, 'Бондарь В.Н./Серёгина Е.А.', 1),
(132, 23, 2019, 1, 'Бухгалтерский учёт', 4, NULL, 'Кейль В.В.', 1),
(133, 23, 2019, 1, 'ОАиП', 1, NULL, 'Жалпаков Т.Т.', 2),
(134, 23, 2019, 1, 'А в ИС', 2, NULL, 'Зайнутдинов Э.Ф.', 2),
(135, 23, 2019, 1, 'Бухгалтерский учёт', 3, NULL, 'Кейль В.В.', 2),
(136, 23, 2019, 1, 'Основы рыночной экономики', 4, NULL, 'Холодова С.М.', 2),
(137, 23, 2019, 1, 'АИС         Зайнутдинов Э.Ф.', 1, NULL, 'ОАиП       Жалпаков Т.Т.', 3),
(138, 23, 2019, 1, 'Основы высшей математики', 2, NULL, 'Саденова Р.Ж.', 3),
(139, 23, 2019, 1, 'Основы философии', 3, NULL, 'Льясова А.А.', 3),
(140, 23, 2019, 1, 'ИРиВС', 4, NULL, 'Рахимбаев М.М.', 3),
(141, 23, 2019, 1, 'Общая теория статистики', 1, NULL, 'Холодова С.М.', 4),
(142, 23, 2019, 1, 'ЗИиИБ        Тетерина С.В.', 2, NULL, 'Ав ИС       Зайнутдинов Э.Ф.', 4),
(143, 23, 2019, 1, 'Основы рыночной экономики  Холодова С.М.', 3, NULL, 'ИРиВС       Рахимбаев М.М.', 4),
(144, 23, 2019, 1, 'Профессиональный казахский язык', 1, NULL, 'Абышева А.Б./Жактай А.М.', 5),
(145, 23, 2019, 1, 'Основы высшей математики', 2, NULL, 'Саденова Р.Ж.', 5),
(146, 23, 2019, 1, 'Физическая культура', 3, NULL, 'Бондарь В.Н./Серёгина Е.А.', 5),
(147, 24, 2019, 1, 'Основы высшей математики', 1, NULL, 'Комарова Н.В.', 1),
(148, 24, 2019, 1, 'Основы философии', 2, NULL, 'Льясова А.А.', 1),
(149, 24, 2019, 1, 'АИС', 3, NULL, 'Зайнутдинов Э.Ф.', 1),
(150, 24, 2019, 1, 'Основы рыночной экономики', 4, NULL, 'Холодова С.М.', 1),
(151, 24, 2019, 1, 'Электротехника и электроника', 1, NULL, 'Тенизова О.В.', 2),
(152, 24, 2019, 1, 'Физическая культура', 2, NULL, 'Бондарь В.Н./Серёгина Е.А.', 2),
(153, 24, 2019, 1, 'Профессиональный казахский язык', 3, NULL, 'Абышева А.Б./Жактай А.М.', 2),
(154, 24, 2019, 1, 'Бухгалтерский учёт', 4, NULL, 'Кейль В.В.', 2),
(155, 24, 2019, 1, '-----', 1, NULL, '', 3),
(156, 24, 2019, 1, '-----', 2, NULL, '', 3),
(157, 24, 2019, 1, 'Основы высшей математики', 3, NULL, 'Комарова Н.В.', 3),
(158, 24, 2019, 1, 'Общая теория статистики', 4, NULL, 'Холодова С.М.', 3),
(159, 24, 2019, 1, 'ИРиВС', 5, NULL, 'Рахимбаев М.М.', 3),
(160, 24, 2019, 1, 'ОАиП', 1, NULL, 'Жалпаков Т.Т.', 4),
(161, 24, 2019, 1, 'Ав ИС        Зайнутдинов Э.Ф.', 2, NULL, 'ЗИиИБ       Садыкова Ж.Е.', 4),
(162, 24, 2019, 1, 'ИРиВС        Рахимбаев М.М.', 3, NULL, 'Основы рыночной экономики   Холодова С.М..', 4),
(163, 24, 2019, 1, 'А в ИС', 1, NULL, 'Зайнутдинов Э.Ф.', 5),
(164, 24, 2019, 1, 'АИС            Зайнутдинов Э.Ф.', 2, NULL, 'ОАиП               Жалпаков Т.Т.', 5),
(165, 24, 2019, 1, 'Бухгалтерский учёт', 3, NULL, 'Кейль В.В.', 5),
(166, 24, 2019, 1, 'Физическая культура', 4, NULL, 'Бондарь В.Н./Серёгина Е.А.', 5),
(167, 1, 2019, 1, '-----', 1, NULL, '', 1),
(168, 1, 2019, 1, 'ОМПиЭП', 2, NULL, 'Тетерина С.В.', 1),
(169, 1, 2019, 1, 'Бухгалтерский учёт', 3, NULL, 'Кейль В.В.', 1),
(170, 1, 2019, 1, 'ПМП', 4, NULL, 'Жалпаков Т.Т.', 1),
(171, 1, 2019, 1, 'Делопроизводство на казахском языке', 5, NULL, 'Жактай А.М.', 1),
(172, 1, 2019, 1, 'Охрана труда', 1, NULL, 'Шойтынов Д.Р.', 2),
(173, 1, 2019, 1, 'ИСВКиПД', 2, NULL, 'Жалпаков Т.Т.', 2),
(174, 1, 2019, 1, 'ПМП', 3, NULL, 'Жалпаков Т.Т.', 2),
(175, 1, 2019, 1, 'ПО АИС', 4, NULL, 'Зайнутдинов Э.Ф.', 2),
(176, 1, 2019, 1, 'Физическая культура', 1, NULL, 'Кривушкин В.П.', 3),
(177, 1, 2019, 1, 'ПО АИС', 2, NULL, 'Зайнутдинов Э.Ф.', 3),
(178, 1, 2019, 1, 'ЗИиИБ', 3, NULL, 'Жалпаков Т.Т.', 3),
(179, 1, 2019, 1, 'Охрана труда', 1, NULL, 'Шойтынов Д.Р.', 4),
(180, 1, 2019, 1, 'Бухгалтерский учёт', 2, NULL, 'Кейль В.В.', 4),
(181, 1, 2019, 1, 'ИСВКиПД', 3, NULL, 'Жалпаков Т.Т.', 4),
(182, 1, 2019, 1, 'ЗИиИБ', 1, NULL, 'Жалпаков Т.Т.', 5),
(183, 1, 2019, 1, 'ОМПиЭП', 2, NULL, 'Тетерина С.В.', 5),
(184, 1, 2019, 1, 'Физическая культура', 3, NULL, 'Кривушкин В.П.', 5),
(185, 1, 2019, 1, 'А в ИС', 4, NULL, 'Зайнутдинов Э.Ф.', 5),
(186, 25, 2019, 1, '-----', 1, NULL, '', 1),
(187, 25, 2019, 1, 'А в ИС', 2, NULL, 'Зайнутдинов Э.Ф.', 1),
(188, 25, 2019, 1, 'Охрана труда', 3, NULL, 'Курмангазина А.Ж.', 1),
(189, 25, 2019, 1, 'Делопроизводство на казахском языке', 4, NULL, 'Жактай А.М.', 1),
(190, 25, 2019, 1, 'Физическая культура', 1, NULL, 'Бондарь В.Н./Кривушкин В.П.', 2),
(191, 25, 2019, 1, 'ОМПиЭП', 2, NULL, 'Тетерина С.В.', 2),
(192, 25, 2019, 1, 'ПО АИС', 3, NULL, 'Зайнутдинов Э.Ф.', 2),
(193, 25, 2019, 1, 'ПМП', 4, NULL, 'Садыкова Ж.Е.', 2),
(194, 25, 2019, 1, 'Бухгалтерский учёт', 1, NULL, 'Кейль В.В.', 3),
(195, 25, 2019, 1, 'ОМПиЭП', 2, NULL, 'Тетерина С.В.', 3),
(196, 25, 2019, 1, 'ПО АИС', 3, NULL, 'Зайнутдинов Э.Ф.', 3),
(197, 25, 2019, 1, 'ИСВКиПД', 4, NULL, 'Шойтынов Д.Р.', 3),
(198, 25, 2019, 1, 'Физическая культура', 1, NULL, 'Бондарь В.Н./Кривушкин В.П.', 4),
(199, 25, 2019, 1, 'ЗИиИБ', 2, NULL, 'Жалпаков Т.Т.', 4),
(200, 25, 2019, 1, 'ИСВКиПД', 3, NULL, 'Шойтынов Д.Р.', 4),
(201, 25, 2019, 1, 'ПМП', 4, NULL, 'Садыкова Ж.Е.', 4),
(202, 25, 2019, 1, '-----', 1, NULL, '', 5),
(203, 25, 2019, 1, 'Охрана труда', 2, NULL, 'Курмангазина А.Ж.', 5),
(204, 25, 2019, 1, 'ЗИиИБ', 3, NULL, 'Жалпаков Т.Т.', 5),
(205, 25, 2019, 1, 'Бухгалтерский учёт', 4, NULL, 'Кейль В.В.', 5),
(206, 2, 2019, 1, 'Орыс  тілі', 1, NULL, 'Зарипова Д.Н./Сагатова А.К.', 1),
(207, 2, 2019, 1, 'География', 2, NULL, 'Солтанова А.М.', 1),
(208, 2, 2019, 1, 'Математика   Саденова Р.Ж.', 3, NULL, 'Физика және астрономия                             Жагапарова Г.С.', 1),
(209, 2, 2019, 1, 'Шет тілі', 4, NULL, 'Кажикенова Г.М./Мустафин Е.Е.', 1),
(210, 2, 2019, 1, 'Қазақ әдебиеті', 1, NULL, 'Жактай А.М.', 2),
(211, 2, 2019, 1, 'Қазақстан тарихы', 2, NULL, 'Кизатова Г.С.', 2),
(212, 2, 2019, 1, 'Физика және астрономия', 3, NULL, 'Жагапарова Г.С.', 2),
(213, 2, 2019, 1, 'Қоғамтану', 4, NULL, 'Кизатова Г.С.', 2),
(214, 2, 2019, 1, 'Дене тәрбиесі', 1, NULL, 'Алданов Р.А./Косбармаков А.Д.', 3),
(215, 2, 2019, 1, 'Химия', 2, NULL, 'Каримова Т.Т.', 3),
(216, 2, 2019, 1, 'Шет тілі', 3, NULL, 'Кажикенова Г.М./Мустафин Е.Е.', 3),
(217, 2, 2019, 1, 'Информатика', 1, NULL, 'Канагатова М.С./Курмангазина А.Ж.', 4),
(218, 2, 2019, 1, 'Қазақ тілі', 2, NULL, 'Жактай А.М.', 4),
(219, 2, 2019, 1, 'АӘД', 3, NULL, 'Кабдыгалиев Е.К.', 4),
(220, 2, 2019, 1, 'Дене тәрбиесі', 4, NULL, 'Алданов Р.А./Косбармаков А.Д.', 4),
(221, 2, 2019, 1, 'Математика', 1, NULL, 'Саденова Р.Ж.', 5),
(222, 2, 2019, 1, 'Орыс әдебиеті', 2, NULL, 'Ахмедьянова А.М.', 5),
(223, 2, 2019, 1, 'Дүние жүзілік тарихы', 3, NULL, 'Кизатова Г.С.', 5),
(224, 3, 2019, 1, 'Информатика', 1, NULL, 'Джакина А.А./Курмангазина А.Ж.', 1),
(225, 3, 2019, 1, 'Казахский язык', 2, NULL, 'Абышева А.Б./Жактай А.М.', 1),
(226, 3, 2019, 1, 'Физика және астрономия Жагапарова Г.С.', 3, NULL, 'Математика   Саденова Р.Ж.', 1),
(227, 3, 2019, 1, 'Русская литература', 1, NULL, 'Зарипова Д.Н.', 2),
(228, 3, 2019, 1, 'Химия', 2, NULL, 'Каримова Т.Т.', 2),
(229, 3, 2019, 1, 'Физическая культура', 3, NULL, 'Кривушкин В.П./Серёгина Е.А.', 2),
(230, 3, 2019, 1, 'Иностранный язык', 4, NULL, 'Шнайдер С.А./Кажикенова Г.М.', 2),
(231, 3, 2019, 1, 'География', 1, NULL, 'Солтанова А.М.', 3),
(232, 3, 2019, 1, 'Обществознание', 2, NULL, 'Льясова А.А.', 3),
(233, 3, 2019, 1, 'Русский язык', 3, NULL, 'Зарипова Д.Н.', 3),
(234, 3, 2019, 1, 'Всемирная история', 4, NULL, 'Кизатова Г.С.', 3),
(235, 3, 2019, 1, 'Казахская литература', 1, NULL, 'Абышева А.Б.', 4),
(236, 3, 2019, 1, 'Иностранный язык', 2, NULL, 'Шнайдер С.А./Куршакова М.В.', 4),
(237, 3, 2019, 1, 'Физика и астрономия', 3, NULL, 'Жагапарова Г.С.', 4),
(238, 3, 2019, 1, 'Физическая культура', 4, NULL, 'Кривушкин В.П./Серёгина Е.А.', 4),
(239, 3, 2019, 1, 'История Казахстана', 1, NULL, 'Кизатова Г.С.', 5),
(240, 3, 2019, 1, 'НВП', 2, NULL, 'Кабдыгалиев Е.К.', 5),
(241, 3, 2019, 1, 'Математика', 3, NULL, 'Саденова Р.Ж.', 5),
(242, 4, 2019, 1, 'Орыс тілі', 1, NULL, 'Ахмедьянова А.М.', 1),
(243, 4, 2019, 1, 'Физика және астрономия', 2, NULL, 'Жагапарова Г.С.', 1),
(244, 4, 2019, 1, 'Электржетегінің негіздері', 3, NULL, 'Канагатова М.С.', 1),
(245, 4, 2019, 1, 'Математика', 4, NULL, 'Саденова Р.Ж.', 1),
(246, 4, 2019, 1, 'Кәсіби  шетел тілі', 1, NULL, 'Шнайдер С.А.', 2),
(247, 4, 2019, 1, 'Электротехниканың теориялық негіздері', 2, NULL, 'Канагатова М.С.', 2),
(248, 4, 2019, 1, 'Саясаттану және әлеуметтану негіздері', 3, NULL, 'Солтанова А.М.', 2),
(249, 4, 2019, 1, 'Электротехниканың теориялық негіздері', 1, NULL, 'Канагатова М.С.', 3),
(250, 4, 2019, 1, 'Өнеркәсіптік электроника негіздері', 2, NULL, 'Канагатова М.С.', 3),
(251, 4, 2019, 1, 'Математика', 3, NULL, 'Саденова Р.Ж.', 3),
(252, 4, 2019, 1, 'Дене тәрбиесі', 4, NULL, 'Косбармаков А.Д.', 3),
(253, 4, 2019, 1, '-----', 1, NULL, '', 4),
(254, 4, 2019, 1, 'Қазақ әдебиеті', 2, NULL, 'Абышева А.Б.', 4),
(255, 4, 2019, 1, 'Дене тәрбиесі', 3, NULL, 'Косбармаков А.Д.', 4),
(256, 4, 2019, 1, 'Мәдениеттану                                                                    Солтанова А.М.', 4, NULL, 'Өнеркәсіптік электроника негіздері   Канагатова М.С.', 4),
(257, 4, 2019, 1, 'Экономика негіздері', 5, NULL, 'Жуматаева Р.К.', 4),
(258, 4, 2019, 1, 'Электрлік өлшемдер', 1, NULL, 'Самаров Е.А.', 5),
(259, 4, 2019, 1, 'Физика және астрономия', 2, NULL, 'Жагапарова Г.С.', 5),
(260, 4, 2019, 1, 'Техникалық механика негіздері', 3, NULL, 'Самаров Е.А.', 5),
(261, 5, 2019, 1, 'Профессиональный иностранный язык', 1, NULL, 'Шнайдер С.А.', 1),
(262, 5, 2019, 1, 'Физическая культура', 2, NULL, 'Серёгина Е.А.', 1),
(263, 5, 2019, 1, 'Теоретические основы электротехники', 3, NULL, 'Тенизова О.В.', 1),
(264, 5, 2019, 1, 'Математика', 4, NULL, 'Комарова Н.В.', 1),
(265, 5, 2019, 1, 'Электрические измерения', 1, NULL, 'Пономаренко У.С.', 2),
(266, 5, 2019, 1, 'Русская литература', 2, NULL, 'Зарипова Д.Н.', 2),
(267, 5, 2019, 1, 'Основы электропривода', 3, NULL, 'Алеушинов Т.Т.', 2),
(268, 5, 2019, 1, 'Основы технической механики', 4, NULL, 'Алеушинов Т.Т.', 2),
(269, 5, 2019, 1, 'Основы промышленной электроники', 1, NULL, 'Тенизова О.В.', 3),
(270, 5, 2019, 1, 'Физика и астрономия', 2, NULL, 'Жагапарова Г.С.', 3),
(271, 5, 2019, 1, 'Основы экономики', 3, NULL, 'Жумалиева Е.С.', 3),
(272, 5, 2019, 1, 'Теоретические основы электротехники', 1, NULL, 'Тенизова О.В.', 4),
(273, 5, 2019, 1, 'Культурология                                                                     Льясова А.А.', 2, NULL, 'Основы промышленной электроники   Тенизова О.В.', 4),
(274, 5, 2019, 1, 'Физическая культура', 3, NULL, 'Серёгина Е.А.', 4),
(275, 5, 2019, 1, 'Математика', 4, NULL, 'Комарова Н.В.', 4),
(276, 5, 2019, 1, '-----', 1, NULL, '', 5),
(277, 5, 2019, 1, 'Основы политологии и социологии', 2, NULL, 'Льясова А.А.', 5),
(278, 5, 2019, 1, 'Казахский язык', 3, NULL, 'Абышева А.Б.', 5),
(279, 5, 2019, 1, 'Физика и астрономия', 4, NULL, 'Жагапарова Г.С.', 5),
(280, 6, 2019, 1, 'Основы рыночной экономики', 1, NULL, 'Жумалиева Е.С.', 1),
(281, 6, 2019, 1, 'ТО и РЭ', 2, NULL, 'Пономаренко У.С.', 1),
(282, 6, 2019, 1, 'Основы рыночной экономики', 3, NULL, 'Жумалиева Е.С.', 1),
(283, 6, 2019, 1, 'ДООО \"ЭоПиГЗ\"', 4, NULL, 'Пономаренко У.С.', 1),
(284, 6, 2019, 1, '-----', 1, NULL, '', 2),
(285, 6, 2019, 1, '-----', 2, NULL, '', 2),
(286, 6, 2019, 1, 'Электротехника', 3, NULL, 'Тенизова О.В.', 2),
(287, 6, 2019, 1, 'ДООО\"Эо и ЭсПиГЗ\"     Пономаренко У.С.', 4, NULL, 'ТОиРЭ          Пономаренко У.С.', 2),
(288, 6, 2019, 1, 'Основы рыночной экономики', 5, NULL, 'Жумалиева Е.С.', 2),
(289, 6, 2019, 1, '-----', 1, NULL, '', 3),
(290, 6, 2019, 1, 'Электротехника                                                                     Тенизова О.В.', 2, NULL, 'Основы рыночной экономики   Жумалиева Е.С.', 3),
(291, 6, 2019, 1, 'ДООО \"Эо и ЭсПиГЗ\"', 3, NULL, 'Пономаренко У.С.', 3),
(292, 6, 2019, 1, 'ТО и РЭ', 4, NULL, 'Пономаренко У.С.', 3),
(293, 6, 2019, 1, 'Основы рыночной экономики', 5, NULL, 'Жумалиева Е.С.', 3),
(294, 6, 2019, 1, '-----', 1, NULL, '', 4),
(295, 6, 2019, 1, 'ТО и РЭ', 2, NULL, 'Пономаренко У.С.', 4),
(296, 6, 2019, 1, 'ДООО \"Эо и ЭсПиГЗ\"', 3, NULL, 'Пономаренко У.С.', 4),
(297, 6, 2019, 1, 'Электротехника', 4, NULL, 'Тенизова О.В.', 4),
(298, 6, 2019, 1, 'Физическая культура', 5, NULL, 'Кривушкин В.П.', 4),
(299, 6, 2019, 1, 'Физическая культура', 1, NULL, 'Кривушкин В.П.', 5),
(300, 6, 2019, 1, 'ДООО \"Эо и ЭсПиГЗ\"', 2, NULL, 'Пономаренко У.С.', 5),
(301, 6, 2019, 1, 'ТО и РЭ', 3, NULL, 'Пономаренко У.С.', 5),
(302, 7, 2019, 1, '-----', 1, NULL, '', 1),
(303, 7, 2019, 1, 'Электржабдығын пайдалану және жөндеу', 2, NULL, 'Канагатова М.С.', 1),
(304, 7, 2019, 1, 'Электрлік машиналар мен трансформаторлар', 3, NULL, 'Самаров Е.А.', 1),
(305, 7, 2019, 1, 'Компьютерлік технология негіздері', 4, NULL, 'Канагатова М.С.', 1),
(306, 7, 2019, 1, 'Философия негіздері', 5, NULL, 'Солтанова А.М.', 1),
(307, 7, 2019, 1, 'Электржабдығын пайдалану және жөндеу', 1, NULL, 'Канагатова М.С.', 2),
(308, 7, 2019, 1, 'Кәсіби орыс тілі', 2, NULL, 'Ахмедьянова А.М.', 2),
(309, 7, 2019, 1, 'КмАҒЭҚ', 3, NULL, 'Самаров Е.А.', 2),
(310, 7, 2019, 1, 'КмАҒЭЖ', 4, NULL, 'Ашимова А.К.', 2),
(311, 7, 2019, 1, '-----', 1, NULL, '', 3),
(312, 7, 2019, 1, '-----', 2, NULL, '', 3),
(313, 7, 2019, 1, 'Электржетегін автоматты басқару', 3, NULL, 'Самаров Е.А.', 3),
(314, 7, 2019, 1, 'КмАҒЭҚ  Самаров Е.А.', 4, NULL, 'КмАҒЭЖ   Ашимова А.К.', 3),
(315, 7, 2019, 1, 'Философия негіздері', 5, NULL, 'Солтанова А.М.', 3),
(316, 7, 2019, 1, 'Дене тәрбиесі', 1, NULL, 'Алданов Р.А.', 4),
(317, 7, 2019, 1, 'Электржетегін автоматты басқару', 2, NULL, 'Самаров Е.А.', 4),
(318, 7, 2019, 1, 'Электржабдығын пайдалану және жөндеу', 3, NULL, 'Канагатова М.С.', 4),
(319, 7, 2019, 1, 'КмАҒЭЖ', 4, NULL, 'Ашимова А.К.', 4),
(320, 7, 2019, 1, 'Дене тәрбиесі', 1, NULL, 'Алданов Р.А.', 5),
(321, 7, 2019, 1, 'Электрлік машиналар мен трансформаторлар', 2, NULL, 'Самаров Е.А.', 5),
(322, 7, 2019, 1, 'Кәсіби орыс тілі', 3, NULL, 'Ахмедьянова А.М.', 5),
(323, 8, 2019, 1, 'Физическая культура', 1, NULL, 'Бондарь В.Н.', 1),
(324, 8, 2019, 1, 'Автоматическое управление электроприводом', 2, NULL, 'Алеушинов Т.Т.', 1),
(325, 8, 2019, 1, 'Эксплуатация и ремонт электрооборудования', 3, NULL, 'Пономаренко У.С.', 1),
(326, 8, 2019, 1, 'Электрические машины и трансформаторы', 4, NULL, 'Тенизова О.В.', 1),
(327, 8, 2019, 1, 'АУЭ        Алеушинов Т.Т.', 1, NULL, 'Професиональный казахский язык                    Омарова К.А.', 2),
(328, 8, 2019, 1, 'ЭоПиГЗ', 2, NULL, 'Алеушинов Т.Т.', 2),
(329, 8, 2019, 1, 'ДООО \"Электрическое оснащение\"', 3, NULL, 'Пономаренко У.С.', 2),
(330, 8, 2019, 1, 'ЭоПиГЗ', 1, NULL, 'Алеушинов Т.Т.', 3),
(331, 8, 2019, 1, 'ЭсПиГЗ   Пономаренко У.С.', 2, NULL, 'Электрические машины и трансформаторы                                          Тенизова О.В.', 3),
(332, 8, 2019, 1, 'Физическая культура', 3, NULL, 'Бондарь В.Н.', 3),
(333, 8, 2019, 1, 'Основы философии', 4, NULL, 'Солтанова А.М.', 3),
(334, 8, 2019, 1, 'Эксплуатация и ремонт электрооборудования', 1, NULL, 'Пономаренко У.С.', 4),
(335, 8, 2019, 1, 'Основы компьютерных технологий', 2, NULL, 'Канагатова М.С.', 4),
(336, 8, 2019, 1, 'ЭоПиГЗ', 3, NULL, 'Алеушинов Т.Т.', 4),
(337, 8, 2019, 1, 'Наладка электрооборудования', 4, NULL, 'Алеушинов Т.Т.', 4),
(338, 8, 2019, 1, '-----', 1, NULL, '', 5),
(339, 8, 2019, 1, 'Электрические машины и трансформаторы', 2, NULL, 'Тенизова О.В.', 5),
(340, 8, 2019, 1, 'Охрана труда', 3, NULL, 'Тенизова О.В.', 5),
(341, 8, 2019, 1, 'ЭсПиГЗ', 4, NULL, 'Пономаренко У.С.', 5),
(342, 9, 2019, 1, '-----', 1, NULL, '', 1),
(343, 9, 2019, 1, '-----', 2, NULL, '', 1),
(344, 9, 2019, 1, '-----', 3, NULL, '', 1),
(345, 9, 2019, 1, 'Дене тәрбиесі', 4, NULL, 'Алданов Р.А./Серёгина Е.А.', 1),
(346, 9, 2019, 1, 'Электржабдығын пайдалану және жөндеу', 5, NULL, 'Ашимова А.К.', 1),
(347, 9, 2019, 1, 'КмАҒЭҚ', 6, NULL, 'Ашимова А.К.', 1),
(348, 9, 2019, 1, 'Электржабдығын баптау', 7, NULL, 'Ашимова А.К.', 1),
(349, 9, 2019, 1, '-----', 1, NULL, '', 2),
(350, 9, 2019, 1, '-----', 2, NULL, '', 2),
(351, 9, 2019, 1, '-----', 3, NULL, '', 2),
(352, 9, 2019, 1, 'Сала экономикасы', 4, NULL, 'Жуматаева Р.К.', 2),
(353, 9, 2019, 1, 'Электржабдығын баптау', 5, NULL, 'Ашимова А.К.', 2),
(354, 9, 2019, 1, 'КмАҒЭҚ', 6, NULL, 'Ашимова А.К.', 2),
(355, 9, 2019, 1, '-----', 1, NULL, '', 3),
(356, 9, 2019, 1, '-----', 2, NULL, '', 3),
(357, 9, 2019, 1, '-----', 3, NULL, '', 3),
(358, 9, 2019, 1, 'Дене тәрбиесі', 4, NULL, 'Алданов Р.А./Серёгина Е.А.', 3),
(359, 9, 2019, 1, 'Сала экономикасы  Жуматаева Р.К.', 5, NULL, 'Электржабдығын пайдалану және жөндеу   Ашимова А.К.', 3),
(360, 9, 2019, 1, 'КмАҒЭҚ', 6, NULL, 'Ашимова А.К.', 3),
(361, 9, 2019, 1, 'Электржабдығын баптау', 7, NULL, 'Ашимова А.К.', 3),
(362, 9, 2019, 1, '-----', 1, NULL, '', 4),
(363, 9, 2019, 1, '-----', 2, NULL, '', 4),
(364, 9, 2019, 1, '-----', 3, NULL, '', 4),
(365, 9, 2019, 1, 'Сала экономикасы', 4, NULL, 'Жуматаева Р.К.', 4),
(366, 9, 2019, 1, 'Электржабдығын пайдалану және жөндеу', 5, NULL, 'Ашимова А.К.', 4),
(367, 9, 2019, 1, 'КмАҒЭҚ', 6, NULL, 'Ашимова А.К.', 4),
(368, 9, 2019, 1, 'Электржабдығын баптау', 7, NULL, 'Ашимова А.К.', 4),
(369, 9, 2019, 1, '-----', 1, NULL, '', 5),
(370, 9, 2019, 1, '-----', 2, NULL, '', 5),
(371, 9, 2019, 1, '-----', 3, NULL, '', 5),
(372, 9, 2019, 1, 'Сала экономикасы', 4, NULL, 'Жуматаева Р.К.', 5),
(373, 9, 2019, 1, 'КмАҒЭҚ', 5, NULL, 'Ашимова А.К.', 5),
(374, 9, 2019, 1, 'Электржабдығын пайдалану және жөндеу', 6, NULL, 'Ашимова А.К.', 5),
(375, 10, 2019, 1, 'ЭсПиГЗ', 1, NULL, 'Тенизова О.В.', 1),
(376, 10, 2019, 1, 'Экономика отрасли', 2, NULL, 'Жумалиева Е.С.', 1),
(377, 10, 2019, 1, 'Наладка электрооборудования', 3, NULL, 'Алеушинов Т.Т.', 1),
(378, 10, 2019, 1, '-----', 1, NULL, '', 2),
(379, 10, 2019, 1, 'Физическая  культура', 2, NULL, 'Алданов Р.А.', 2),
(380, 10, 2019, 1, 'Экономика отрасли', 3, NULL, 'Жумалиева Е.С.', 2),
(381, 10, 2019, 1, 'ЭсПиГЗ', 4, NULL, 'Тенизова О.В.', 2),
(382, 10, 2019, 1, 'ЭиРЭ', 5, NULL, 'Алеушинов Т.Т.', 2),
(383, 10, 2019, 1, 'Экономика отрасли', 1, NULL, 'Жумалиева Е.С.', 3),
(384, 10, 2019, 1, 'Экономика отрасли                                                                    Жумалиева Е.С.', 2, NULL, 'ЭиРЭ   Алеушинов Т.Т..', 3),
(385, 10, 2019, 1, 'Наладка электрооборудования', 3, NULL, 'Алеушинов Т.Т.', 3),
(386, 10, 2019, 1, 'ЭсПиГЗ', 4, NULL, 'Тенизова О.В.', 3),
(387, 10, 2019, 1, 'ЭиРЭ', 1, NULL, 'Алеушинов Т.Т.', 4),
(388, 10, 2019, 1, 'Наладка электрооборудования', 2, NULL, 'Алеушинов Т.Т.', 4),
(389, 10, 2019, 1, 'ЭсПиГЗ', 3, NULL, 'Тенизова О.В.', 4),
(390, 10, 2019, 1, '-----', 1, NULL, '', 5),
(391, 10, 2019, 1, 'ЭиРЭ', 2, NULL, 'Алеушинов Т.Т.', 5),
(392, 10, 2019, 1, 'Наладка электрооборудования', 3, NULL, 'Алеушинов Т.Т.', 5),
(393, 10, 2019, 1, 'ЭсПиГЗ', 4, NULL, 'Тенизова О.В.', 5),
(394, 10, 2019, 1, 'Физическая  культура', 5, NULL, 'Алданов Р.А.', 5),
(395, 11, 2019, 1, 'Дене тәрбиесі', 1, NULL, 'Алданов Р.А./Косбармаков А.Д.', 1),
(396, 11, 2019, 1, 'Орыс  тілі', 2, NULL, 'Зарипова Д.Н./Сагатова А.К.', 1),
(397, 11, 2019, 1, 'Дүние жүзілік тарихы', 3, NULL, 'Кизатова Г.С.', 1),
(398, 11, 2019, 1, 'Орыс әдебиеті', 4, NULL, 'Сагатова А.К.', 1),
(399, 11, 2019, 1, 'География', 1, NULL, 'Солтанова А.М.', 2),
(400, 11, 2019, 1, 'Физика', 2, NULL, 'Жагапарова Г.С.', 2),
(401, 11, 2019, 1, 'АӘД', 3, NULL, 'Кабдыгалиев Е.К.', 2),
(402, 11, 2019, 1, 'Математика', 4, NULL, 'Саденова Р.Ж.', 2),
(403, 11, 2019, 1, 'Математика', 1, NULL, 'Саденова Р.Ж.', 3),
(404, 11, 2019, 1, 'Шет тілі', 2, NULL, 'Шнайдер С.А./Мустафин Е.Е.', 3),
(405, 11, 2019, 1, 'Информатика', 3, NULL, 'Канагатова М.С./Садыкова Ж.Е.', 3),
(406, 11, 2019, 1, 'Орыс әдебиеті               Сагатова А.К.', 1, NULL, 'Қазақ тілі              Жактай А.М..', 4),
(407, 11, 2019, 1, 'Физика', 2, NULL, 'Жагапарова Г.С.', 4),
(408, 11, 2019, 1, 'Қазақ әдебиеті', 3, NULL, 'Абышева А.Б.', 4),
(409, 11, 2019, 1, 'Химия', 1, NULL, 'Каримова Т.Т.', 5),
(410, 11, 2019, 1, 'Инностранный язык', 2, NULL, 'Шнайдер С.А./Мустафин Е.Е.', 5),
(411, 11, 2019, 1, 'Қазақ тілі', 3, NULL, 'Жактай А.М.', 5),
(412, 11, 2019, 1, 'Дене тәрбиесі', 4, NULL, 'Алданов Р.А./Косбармаков А.Д.', 5),
(413, 12, 2019, 1, 'Математика', 1, NULL, 'Саденов К.А.', 1),
(414, 12, 2019, 1, 'Химия', 2, NULL, 'Каримова Т.Т.', 1),
(415, 12, 2019, 1, 'Орыс  тілі', 3, NULL, 'Зарипова Д.Н./Сагатова А.К.', 1),
(416, 12, 2019, 1, 'Физика          Хасенова А.Х.', 4, NULL, 'Қазақ әдебиеті               Абышева А.Б.', 1),
(417, 12, 2019, 1, 'Қазақ тілі', 1, NULL, 'Абышева А.Б.', 2),
(418, 12, 2019, 1, 'Мәдениеттану', 2, NULL, 'Солтанова А.М.', 2),
(419, 12, 2019, 1, 'Информатика', 3, NULL, 'Канагатова М.С./Садыкова Ж.Е.', 2),
(420, 12, 2019, 1, 'Қазақ әдебиеті', 1, NULL, 'Абышева А.Б.', 3),
(421, 12, 2019, 1, 'Физика', 2, NULL, 'Хасенова А.Х.', 3),
(422, 12, 2019, 1, 'Құқық негіздері', 3, NULL, 'Солтанова А.М.', 3),
(423, 12, 2019, 1, 'Орыс әдебиеті', 4, NULL, 'Сагатова А.К.', 3),
(424, 12, 2019, 1, 'Шет тілі Кажикенова Г.М./Шнайдер С.А.', 1, NULL, 'Орыс тілі                                        Сагатова А.К./Зарипова Д.Н.', 4),
(425, 12, 2019, 1, 'Дене тәрбиесі', 2, NULL, 'Алданов Р.А./Косбармаков А.Д.', 4),
(426, 12, 2019, 1, 'Экономика негіздері', 3, NULL, 'Жуматаева Р.К.', 4),
(427, 12, 2019, 1, 'АӘД', 4, NULL, 'Кабдыгалиев Е.К.', 4),
(428, 12, 2019, 1, 'Шет тілі', 1, NULL, 'Кажикенова Г.М./Шнайдер С.А.', 5),
(429, 12, 2019, 1, 'Математика', 2, NULL, 'Саденов К.А.', 5),
(430, 12, 2019, 1, 'Дене тәрбиесі', 3, NULL, 'Алданов Р.А./Косбармаков А.Д.', 5),
(431, 13, 2019, 1, 'Жоғары математика негіздері', 1, NULL, 'Саденова Р.Ж.', 1),
(432, 13, 2019, 1, 'Экономика негіздері', 2, NULL, 'Саденова Р.Ж.', 1),
(433, 13, 2019, 1, 'Дене тәрбиесі', 3, NULL, 'Алданов Р.А./Косбармаков А.Д.', 1),
(434, 13, 2019, 1, 'Қазақстан тарихы          Кизатова Г.С.', 4, NULL, 'Менеджмент және маркетинг негіздері                    Жуматаева Р.К.', 1),
(435, 13, 2019, 1, 'Қазақстан тарихы', 1, NULL, 'Кизатова Г.С.', 2),
(436, 13, 2019, 1, 'ОЖжЖЕ', 2, NULL, 'Садыкова Ж.Е.', 2),
(437, 13, 2019, 1, 'Жоғары математика негіздері', 3, NULL, 'Саденова Р.Ж.', 2),
(438, 13, 2019, 1, 'Кәсіптік шет тілі', 1, NULL, 'Кажикенова Г.М./Мустафин Е.Е.', 3),
(439, 13, 2019, 1, 'Дене тәрбиесі', 2, NULL, 'Алданов Р.А./Косбармаков А.Д.', 3),
(440, 13, 2019, 1, 'АжБН', 3, NULL, 'Жакупова А.С.', 3),
(441, 13, 2019, 1, 'Кәсіби орыс тілі', 4, NULL, 'Ахмедьянова А.М./Зарипова Д.Н.', 3),
(442, 13, 2019, 1, '-----', 1, NULL, '', 4),
(443, 13, 2019, 1, 'Мәдениеттану', 2, NULL, 'Кизатова Г.С.', 4),
(444, 13, 2019, 1, 'ОЖжЖЕ', 3, NULL, 'Садыкова Ж.Е.', 4),
(445, 13, 2019, 1, 'Нарықтық экономика негіздері', 4, NULL, 'Саденова Р.Ж.', 4),
(446, 13, 2019, 1, 'АжБН', 5, NULL, 'Жакупова А.С.', 4),
(447, 13, 2019, 1, 'Менеджмент және маркетинг негіздері', 1, NULL, 'Жуматаева Р.К.', 5),
(448, 13, 2019, 1, 'Саясаттану және әлеуметтану негіздері', 2, NULL, 'Кизатова Г.С.', 5),
(449, 13, 2019, 1, 'Weв-бағдарламалау', 3, NULL, 'Шойтынов Д.Р.', 5),
(450, 14, 2019, 1, 'Қазақ әдебиеті', 1, NULL, 'Жактай А.М.', 1),
(451, 14, 2019, 1, 'ОЖжЖБЕ', 2, NULL, 'Кабасова А.Ж.', 1),
(452, 14, 2019, 1, 'Кәсіптік шет тілі', 3, NULL, 'Мустафин Е.Е.', 1),
(453, 14, 2019, 1, 'Дене тәрбиесі', 4, NULL, 'Косбармаков А.Д.', 1),
(454, 14, 2019, 1, '-----', 1, NULL, '', 2),
(455, 14, 2019, 1, 'Web бағдарламалау   Шойтынов Д.Р.', 2, NULL, 'КГжГ                              Шойтынов Д.Р.', 2),
(456, 14, 2019, 1, 'АжБН', 3, NULL, 'Жакупова А.С.', 2),
(457, 14, 2019, 1, 'Саясаттану және әлеуметтану негіздері', 4, NULL, 'Солтанова А.М.', 2),
(458, 14, 2019, 1, 'Жоғары математика негіздері   Саденова Р.Ж.', 5, NULL, '', 2),
(459, 14, 2019, 1, '-----', 1, NULL, 'АжБН                      Жакупова А.С.', 3),
(460, 14, 2019, 1, 'Web бағдарламалау', 2, NULL, 'Шойтынов Д.Р.', 3),
(461, 14, 2019, 1, 'Орыс  тілі', 3, NULL, 'Ахмедьянова А.М.', 3),
(462, 14, 2019, 1, 'Менеджмент және маркетинг негіздері', 4, NULL, 'Саденова Р.Ж.', 3),
(463, 14, 2019, 1, 'Дене тәрбиесі', 1, NULL, 'Косбармаков А.Д.', 4),
(464, 14, 2019, 1, 'Математика', 2, NULL, 'Саденова Р.Ж.', 4),
(465, 14, 2019, 1, 'Қазақстан тарихы', 3, NULL, 'Кизатова Г.С.', 4),
(466, 14, 2019, 1, 'Кәсіби орыс тілі', 4, NULL, 'Ахмедьянова А.М.', 4),
(467, 14, 2019, 1, '-----', 1, NULL, '', 5),
(468, 14, 2019, 1, 'Мемлекеттік тілде іс қағаздарын жүргізу', 2, NULL, 'Жактай  А.М.', 5),
(469, 14, 2019, 1, 'Физика', 3, NULL, 'Жагапарова Г.С.', 5),
(470, 14, 2019, 1, 'Жоғары математика негіздері', 4, NULL, 'Саденова Р.Ж.', 5),
(471, 15, 2019, 1, 'Бухгалтерлік есеп', 1, NULL, 'Шаймарданова А.К.', 1),
(472, 15, 2019, 1, 'Нарықтық экономика негіздері', 2, NULL, 'Жуматаева Р.К.', 1),
(473, 15, 2019, 1, 'АЖБ', 3, NULL, 'Сырнай Ж.С.', 1),
(474, 15, 2019, 1, 'АжБН', 4, NULL, 'Жакупова А.С.', 1),
(475, 15, 2019, 1, '-----', 1, NULL, '', 2),
(476, 15, 2019, 1, 'Статистиканың жалпы теориясы', 2, NULL, 'Жуматаева Р.К.', 2),
(477, 15, 2019, 1, 'ААЖ', 3, NULL, 'Сырнай Ж.С.', 2),
(478, 15, 2019, 1, 'Кәсіби орыс тілі', 4, NULL, 'Ахмедьянова А.М./Зарипова Д.Н.', 2),
(479, 15, 2019, 1, 'Бухгалтерлік есеп', 5, NULL, 'Шаймарданова А.К.', 2),
(480, 15, 2019, 1, '-----', 1, NULL, '', 3),
(481, 15, 2019, 1, 'Жоғары математика негіздері', 2, NULL, 'Саденов К.А.', 3),
(482, 15, 2019, 1, 'АЖБ   Сырнай Ж.С.', 3, NULL, 'АҚ жАҚ                 Кабасова А.Ж.', 3),
(483, 15, 2019, 1, 'АжБН                         Жакупова А.С.', 4, NULL, 'ААЖ                              Сырнай Ж.С.', 3),
(484, 15, 2019, 1, 'Дене тәрбиесі', 5, NULL, 'Алданов Р.А./Косбармаков А.Д.', 3),
(485, 15, 2019, 1, 'АРжЕЖ', 1, NULL, 'Жакупова А.С.', 4),
(486, 15, 2019, 1, 'Жоғары математика негіздері', 2, NULL, 'Саденов К.А.', 4),
(487, 15, 2019, 1, 'Философия негіздері', 3, NULL, 'Солтанова А.М.', 4),
(488, 15, 2019, 1, 'Электротехника және электроника', 1, NULL, 'Канагатова М.С.', 5),
(489, 15, 2019, 1, 'Дене тәрбиесі', 2, NULL, 'Алданов Р.А./Косбармаков А.Д.', 5),
(490, 15, 2019, 1, 'АРжЕЖ                           Жакупова А.С.', 3, NULL, 'Нарықтық экономика негіздері                              Жуматаева Р.К.', 5),
(491, 26, 2019, 1, 'АжБН', 1, NULL, 'Жакупова А.С.', 1),
(492, 26, 2019, 1, 'ААЖ', 2, NULL, 'Сырнай Ж.С.', 1),
(493, 26, 2019, 1, 'Статистиканың жалпы теориясы', 3, NULL, 'Жуматаева Р.К.', 1),
(494, 26, 2019, 1, 'Дене тәрбиесі', 1, NULL, 'Косбармаков А.Д.', 2),
(495, 26, 2019, 1, 'Жоғары математика негіздері', 2, NULL, 'Саденов К.А.', 2),
(496, 26, 2019, 1, 'Бухгалтерлік есеп', 3, NULL, 'Жуматаева Р.К.', 2),
(497, 26, 2019, 1, 'ВКжҚДИҚ', 4, NULL, 'Сырнай Ж.С.', 2),
(498, 26, 2019, 1, 'Мемлекеттік тілде іс қағаздарын жүргізу', 1, NULL, 'Жактай А.М.', 3),
(499, 26, 2019, 1, 'Мультимедиялық технология', 2, NULL, 'Кабасова А.Ж.', 3),
(500, 26, 2019, 1, 'Бухгалтерлік есеп', 3, NULL, 'Жуматаева Р.К.', 3),
(501, 26, 2019, 1, 'Жоғары математика негіздері', 4, NULL, 'Саденов К.А.', 3),
(502, 26, 2019, 1, '-----', 1, NULL, '', 4),
(503, 26, 2019, 1, 'Философия негіздері', 2, NULL, 'Солтанова А.М.', 4),
(504, 26, 2019, 1, 'КГжГ', 3, NULL, 'Джакина А.А.', 4),
(505, 26, 2019, 1, 'Электротехника және электроника          Канагатова М.С.', 4, NULL, 'ВКжҚДИҚ                   Сырнай Ж.С.', 4),
(506, 26, 2019, 1, 'Дене тәрбиесі', 1, NULL, 'Косбармаков А.Д.', 5),
(507, 26, 2019, 1, 'Бухгалтерлік есеп', 2, NULL, 'Жуматаева Р.К.', 5),
(508, 26, 2019, 1, 'Электротехника және электроника', 3, NULL, 'Канагатова М.С.', 5),
(509, 26, 2019, 1, 'АжБН', 4, NULL, 'Жакупова А.С.', 5),
(510, 27, 2019, 1, '-----', 1, NULL, '', 1),
(511, 27, 2019, 1, '-----', 2, NULL, '', 1),
(512, 27, 2019, 1, 'ААЖ БҚ', 3, NULL, 'Кабасова А.Ж.', 1),
(513, 27, 2019, 1, 'ӨжЭҮМН', 4, NULL, 'Садыкова Ж.Е.', 1),
(514, 27, 2019, 1, 'Бухгалтерлік есеп', 5, NULL, 'Шаймарданова А.К.', 1),
(515, 27, 2019, 1, 'ВКжҚДИҚ', 1, NULL, 'Кабасова А.Ж.', 2),
(516, 27, 2019, 1, 'Еңбекті қорғау', 2, NULL, 'Кабасова А.Ж.', 2),
(517, 27, 2019, 1, 'Дене тәрбиесі', 3, NULL, 'Алданов Р.А./Косбармаков А.Д.', 2),
(518, 27, 2019, 1, 'АҚ ж АҚ', 4, NULL, 'Жакупова А.С.', 2),
(519, 27, 2019, 1, 'МҚБ', 1, NULL, 'Садыкова Ж.Е.', 3),
(520, 27, 2019, 1, 'АЖБ', 2, NULL, 'Сырнай Ж.С.', 3),
(521, 27, 2019, 1, 'Дене тәрбиесі', 3, NULL, 'Алданов Р.А./Косбармаков А.Д.', 3),
(522, 27, 2019, 1, 'Бухгалтерлік есеп', 4, NULL, 'Шаймарданова А.К.', 3),
(523, 27, 2019, 1, 'ААЖ БҚ', 1, NULL, 'Кабасова А.Ж.', 4),
(524, 27, 2019, 1, 'Еңбекті қорғау', 2, NULL, 'Кабасова А.Ж.', 4),
(525, 27, 2019, 1, 'АҚ ж АҚ', 3, NULL, 'Жакупова А.С.', 4),
(526, 27, 2019, 1, 'Мемлекеттік тілде іс қағаздарын жүргізу', 4, NULL, 'Жактай А.М.', 4),
(527, 27, 2019, 1, 'ӨжЭҮМН', 1, NULL, 'Садыкова Ж.Е.', 5),
(528, 27, 2019, 1, 'ВКжҚДИҚ', 2, NULL, 'Кабасова А.Ж.', 5),
(529, 27, 2019, 1, 'МҚБ', 3, NULL, 'Садыкова Ж.Е.', 5),
(530, 28, 2019, 1, 'ӨжЭҮМН', 1, NULL, 'Садыкова Ж.Е.', 1),
(531, 28, 2019, 1, 'МҚБ', 2, NULL, 'Шойтынов Д.Р.', 1),
(532, 28, 2019, 1, 'АҚ ж АҚ', 3, NULL, 'Жакупова  А.К.', 1),
(533, 28, 2019, 1, 'ААЖ БҚ', 4, NULL, 'Сырнай Ж.С.', 1),
(534, 28, 2019, 1, 'АРжЕЖ', 1, NULL, 'Жакупова А.С.', 2),
(535, 28, 2019, 1, 'Техникалық құралдар кешені', 2, NULL, 'Сырнай Ж.С.', 2),
(536, 28, 2019, 1, 'Еңбекті қорғау', 3, NULL, 'Кабасова А.Ж.', 2),
(537, 28, 2019, 1, 'Дене тәрбиесі', 4, NULL, 'Алданов Р.А.', 2),
(538, 28, 2019, 1, 'Техникалық құралдар кешені', 1, NULL, 'Сырнай Ж.С.', 3),
(539, 28, 2019, 1, 'ӨжЭҮМН', 2, NULL, 'Садыкова Ж.Е.', 3),
(540, 28, 2019, 1, 'МҚБ', 3, NULL, 'Шойтынов Д.Р.', 3),
(541, 28, 2019, 1, '-----', 1, NULL, '', 4),
(542, 28, 2019, 1, 'ӨжЭҮМН                      Садыкова Ж.Е.', 2, NULL, 'ААЖ БҚ            Сырнай Ж.С.', 4),
(543, 28, 2019, 1, 'Еңбекті қорғау', 3, NULL, 'Кабасова А.Ж.', 4),
(544, 28, 2019, 1, 'АҚ ж АҚ', 4, NULL, 'Жакупова А.С.', 4),
(545, 28, 2019, 1, 'Дене тәрбиесі', 5, NULL, 'Алданов Р.А.', 4),
(546, 28, 2019, 1, 'АРжЕЖ', 1, NULL, 'Жакупова А.С.', 5),
(547, 28, 2019, 1, 'Техникалық құралдар кешені', 2, NULL, 'Сырнай Ж.С.', 5),
(548, 28, 2019, 1, 'ААЖ БҚ', 3, NULL, 'Сырнай Ж.С.', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_kz` varchar(255) DEFAULT NULL,
  `divide` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `name_kz`, `divide`) VALUES
(1, 'Казахский язык', NULL, 0),
(2, 'Русский язык', NULL, 0),
(3, 'Казахская литература', NULL, 0),
(4, 'Русская литература', NULL, 0),
(5, 'Иностранный язык', NULL, 0),
(6, 'Всемирная история', NULL, 0),
(7, 'История  Казахстана', NULL, 0),
(8, 'Обществознание', NULL, 0),
(9, 'Математика', NULL, 0),
(10, 'Информатика', NULL, 0),
(11, 'Физика', NULL, 0),
(12, 'Химия ', NULL, 0),
(13, 'Биология', NULL, 0),
(14, 'География', NULL, 0),
(15, 'Начальная  военная  подготовка (теория)', NULL, 0),
(16, 'ЛПС', NULL, 0),
(17, 'Физическая культура', NULL, 0),
(18, 'Профессиональный казахский язык', NULL, 0),
(19, 'Профессиональный иностранный язык', NULL, 0),
(20, 'Культурология', NULL, 0),
(21, 'Основы философии', NULL, 0),
(22, 'Основы социологии и политологии', NULL, 0),
(23, 'Основы экономики', NULL, 0),
(24, 'Основы права', NULL, 0),
(25, 'Делопроизводство на казахском языке', NULL, 0),
(26, 'Основы высшей математики', NULL, 0),
(27, 'Общая теория статистики', NULL, 0),
(28, 'Электротехника и электроника', NULL, 0),
(29, 'Основы менеджмента и маркетинга', NULL, 0),
(30, 'Операционные системы и системное обеспечение', NULL, 0),
(31, 'Основы рыночной экономики', NULL, 0),
(32, 'Weв-программирование', 'Weв-багдарламалау', 2),
(33, 'Охрана труда', NULL, 0),
(34, 'Основы алгоритмизации и программирования', NULL, 0),
(35, 'Информационные ресурсы и вычислительные сети', NULL, 0),
(36, 'Защита информации и информационная безопасность', NULL, 0),
(37, 'Автоматизированные информационные системы', NULL, 0),
(38, 'Программное обеспечение АИС', NULL, 0),
(39, 'Компьютерная геометрия и графика', NULL, 0),
(40, 'Основы моделирования производственных и экономических процессов', NULL, 0),
(41, 'Администрирование в ИС', NULL, 0),
(42, 'Мультимедиа технологии', NULL, 0),
(43, 'Бухгалтерский учет', NULL, 0),
(44, 'Комплекс технических средств', NULL, 0),
(45, 'Инструментальные средства визуальной коммуникации и прикладной дизайн', NULL, 0),
(46, 'Ознакомительная практика ', NULL, 0),
(47, 'ПО АИС', NULL, 0),
(48, 'Программирование базы данных ', NULL, 0),
(49, 'По бухгалтерскому учету', NULL, 0),
(50, 'По приобретению рабочей профессии', NULL, 0),
(51, 'Операционные системы и администрирование в информационных системах', NULL, 0),
(52, 'Производственная технологическая', NULL, 0),
(53, 'Преддипломная', NULL, 0),
(54, 'Дипломное проектирование', NULL, 0),
(55, 'Консультации', NULL, 0),
(56, 'Самопознание', NULL, 0),
(57, 'Краеведение', NULL, 0),
(58, 'Казахстанское право', NULL, 0),
(59, 'Основы акмеологии', NULL, 0),
(60, 'Основы потр. образования', NULL, 0),
(61, 'Основы предпринимательской деятельности', NULL, 0),
(62, 'другие', NULL, 0),
(63, 'Промежуточная аттестация', NULL, 0),
(64, 'Итоговая аттестация', NULL, 0),
(65, 'Оценка уровня профессиональной подготовленности квалификации', NULL, 0),
(66, 'Дисциплины, определяемая организацией образования (Програмирование мобильных приложении)', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teachers`
--

INSERT INTO `teachers` (`id`, `surname`, `name`, `patronymic`) VALUES
(4, 'Бикулова', 'Анфиса', 'Игоревна'),
(5, 'Жутова', 'Ангелина', 'Игоревна'),
(6, 'Кривкова', 'Ирина', 'Николаевна'),
(7, 'Милова', 'Мария', 'Алексеевна'),
(8, 'Чикунов', 'Евграф', 'Аполлинариевич'),
(9, 'Харламов', 'Валерий', 'Всеволодович'),
(10, 'Деменкова', 'Ираида', 'Марковна'),
(11, 'Тесла', 'Диана', 'Емельяновна'),
(12, 'Грязнов', 'Ефрем', 'Эрнестович'),
(13, 'Эссен', 'Ираклий', 'Евгениевич'),
(14, 'Силиванов', 'Дмитрий', 'Феликсович'),
(15, 'Скосырский', 'Порфирий', 'Егорович'),
(16, 'Медведков', 'Сергей', 'Эрнестович'),
(17, 'Барсова', 'Валерия', 'Брониславовна'),
(18, 'Каде', 'Никанор', 'Аполлинариевич'),
(19, 'Щепетинникова', 'Елена', 'Трофимовна'),
(20, 'Деревсков', 'Савелий', 'Мартьянович'),
(21, 'Гачева', 'Инна', 'Мефодиевна'),
(22, 'Марьина', 'Аза', 'Захаровна'),
(23, 'Муравьев', 'Валерьян', 'Онуфриевич'),
(24, 'Игошина', 'Маргарита', 'Германовна'),
(25, 'Гусева', 'Ираида', 'Николаевна'),
(26, 'Трошкина', 'Берта', 'Мироновна'),
(27, 'Серёгин', 'Казимир', 'Фролович'),
(28, 'Гудкова', 'Елена', 'Владленовна'),
(29, 'Сомов', 'Трофим', 'Никифорович'),
(30, 'Сытников', 'Артём', ''),
(31, 'Орехова', 'Анисья', 'Павеловна'),
(32, 'Лимарова', 'Эмилия', 'Серафимовна'),
(33, 'Черников', 'Эдуард', 'Эмилевич'),
(34, 'Комзина', 'Фаина', 'Яновна'),
(35, 'Лелуха', 'Валентина', 'Якововна'),
(36, 'Кваскова', 'Ева', 'Якововна'),
(37, 'Элинский', 'Якуб', 'Вячеславович'),
(38, 'Казакова', 'Эмма', 'Станиславовна'),
(39, 'Болдаев', 'Ростислав', 'Мечиславович');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `changes`
--
ALTER TABLE `changes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cikls`
--
ALTER TABLE `cikls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `college_graphics`
--
ALTER TABLE `college_graphics`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `changes`
--
ALTER TABLE `changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT для таблицы `cikls`
--
ALTER TABLE `cikls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `college_graphics`
--
ALTER TABLE `college_graphics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `langs`
--
ALTER TABLE `langs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT для таблицы `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=549;

--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT для таблицы `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
