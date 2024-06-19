-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 15 2024 г., 10:08
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hilkevich`
--

-- --------------------------------------------------------

--
-- Структура таблицы `msg`
--

CREATE TABLE `msg` (
  `message_id` int NOT NULL,
  `msg` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `room_id` int NOT NULL,
  `users_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `msg`
--

INSERT INTO `msg` (`message_id`, `msg`, `room_id`, `users_id`) VALUES
(28, 'asdasd', 3, 18),
(42, 'скака', 4, 19),
(55, 'может 2 рпавно?', 1, 19),
(57, 'dfdfdf', 1, 19),
(62, 'asdasdas', 1, 18),
(63, 'asdasd', 1, 18),
(64, 'asdasd', 1, 18),
(65, 'vsyo]', 1, 19),
(66, 'победа))', 1, 19),
(67, 'xaxxax da da', 1, 19),
(68, 'vsyo ya vishel potom esho posmotrim chto mojno dobavit ', 1, 19),
(72, 'пп', 2, 18),
(73, 'fefef', 3, 19),
(75, 'efef', 0, 19),
(76, 'Привет!', 5, 21),
(79, 'Я принесу камень', 5, 22),
(85, 'ggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', 5, 21),
(89, 'п', 5, 22),
(92, 'fffffffffffffffffffffffffff', 2, 19),
(98, 'пппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппп', 1, 18),
(100, 'ggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', 2, 18),
(102, 'это надо пофиксить выше(', 1, 18),
(103, 'еще как то выровнять значок крестика, там фотки есть пробовал тод не получилось', 1, 18);

-- --------------------------------------------------------

--
-- Структура таблицы `room`
--

CREATE TABLE `room` (
  `id` int NOT NULL,
  `name` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `room`
--

INSERT INTO `room` (`id`, `name`, `token`, `isActive`) VALUES
(1, 'Общий', 'room1', 1),
(2, 'Вопрос/ответ', 'room2', 1),
(3, 'Программироание', 'room3', 1),
(4, 'Хацкеры', 'room4', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `banned` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `banned`) VALUES
(18, '123', '$2y$10$qT274PpV7r9k0fWBbGSikeNsCnVTZX8K0WmDa0kt7gCusnVDiIvYy', 'admin', NULL),
(19, '111', '$2y$10$mqIifIFFHh0.WOgDyowj8OwHGFBqDfq82uoqOAOfKifwgMlQv9BEG', 'user', 0),
(21, 'Nikolay', '$2y$10$eUaJjyYqpdN2GRX.wz2yC.VsjtJ0Nd6ajhm.5NWuuZW01lYETaUvG', 'user', NULL),
(22, 'No name', '$2y$10$1qyBuEl5zvQOBJBrmzAsCuwQZztpTfk9IIg.Mq/Vn0NVoFLeq2CRq', 'admin', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`message_id`);

--
-- Индексы таблицы `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `msg`
--
ALTER TABLE `msg`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT для таблицы `room`
--
ALTER TABLE `room`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
