-- Создание базы данных (если её нет)
CREATE DATABASE IF NOT EXISTS `vkusnaya_kuhnya` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `vkusnaya_kuhnya`;

-- --------------------------------------------------------

--
-- Структура таблицы `recipes`
--

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
