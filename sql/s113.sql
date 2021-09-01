-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 
-- Czas generowania: 29 Cze 2021, 12:39
-- Wersja serwera: 8.0.21
-- Wersja PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `s113`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int UNSIGNED NOT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `fpfti_id` int NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id`, `text`, `user_id`, `fpfti_id`, `created`) VALUES
(1, 'HaHa rel', 40, 1, '2021-06-29 11:40:06'),
(2, 'A mi nie, ja jestem na keto od tygodnia', 41, 5, '2021-06-29 11:45:58'),
(3, 'Nooo, tak jest', 42, 9, '2021-06-29 11:52:25');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `fpfti`
--

CREATE TABLE `fpfti` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `link` varchar(350) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '0',
  `likes` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `fpfti`
--

INSERT INTO `fpfti` (`id`, `title`, `user_id`, `link`, `accepted`, `likes`, `created`) VALUES
(1, 'Tyle planów...', 39, 'https://s113.labagh.pl/resources/fpfti/60db05ffa8f900.23701331.jpg', 0, 3, '2021-06-29 11:37:35'),
(2, 'Piesł przetamń', 39, 'https://s113.labagh.pl/resources/fpfti/60db062d367dd9.69860091.png', 0, 2, '2021-06-29 11:38:21'),
(3, 'Czasami boli', 40, 'https://s113.labagh.pl/resources/fpfti/60db0684ca37a8.97575185.png', 0, 1, '2021-06-29 11:39:48'),
(4, 'Praca za sam papier', 40, 'https://s113.labagh.pl/resources/fpfti/60db06e6991313.32727771.png', 1, -1, '2021-06-29 11:41:26'),
(5, 'Mi też', 40, 'https://s113.labagh.pl/resources/fpfti/60db077894c7a3.26807825.jpg', 0, -2, '2021-06-29 11:43:52'),
(6, 'byle do wtorku', 41, 'https://s113.labagh.pl/resources/fpfti/60db08159ba367.62700436.jpg', 1, 1, '2021-06-29 11:46:29'),
(7, 'Egzystencja', 41, 'https://s113.labagh.pl/resources/fpfti/60db0832acf447.73074439.png', 0, 0, '2021-06-29 11:46:58'),
(8, 'za każdym razem', 41, 'https://s113.labagh.pl/resources/fpfti/60db08545342b4.19917787.png', 1, 0, '2021-06-29 11:47:32'),
(9, 'No tak', 41, 'https://s113.labagh.pl/resources/fpfti/60db086bdd4f54.70096461.png', 1, 4, '2021-06-29 11:47:55'),
(10, 'Straszne', 41, 'https://s113.labagh.pl/resources/fpfti/60db0889494240.45737874.png', 0, -2, '2021-06-29 11:48:25'),
(11, 'Niejestem', 42, 'https://s113.labagh.pl/resources/fpfti/60db09a47094e8.18059172.jpg', 1, 0, '2021-06-29 11:53:08');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `likes`
--

CREATE TABLE `likes` (
  `user_id` int NOT NULL,
  `fpfti_id` int NOT NULL,
  `is_positive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `likes`
--

INSERT INTO `likes` (`user_id`, `fpfti_id`, `is_positive`) VALUES
(39, 1, 1),
(39, 2, 1),
(40, 1, 1),
(40, 2, 1),
(40, 4, 0),
(40, 3, 1),
(40, 5, 0),
(41, 5, 0),
(41, 1, 1),
(41, 6, 1),
(41, 9, 1),
(41, 10, 0),
(42, 10, 0),
(42, 9, 1),
(35, 9, 1),
(14, 9, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tags`
--

CREATE TABLE `tags` (
  `tag` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fpfti_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `tags`
--

INSERT INTO `tags` (`tag`, `fpfti_id`) VALUES
('#rel', 1),
('#wróżkowie', 1),
('#kotki', 2),
('#rel', 3),
('#chomiczek', 3),
('#rel', 4),
('#studia', 4),
('#kotki', 5),
('#grubasy', 5),
('#sesja', 6),
('#rel', 8),
('#rel', 9),
('#sesja', 9),
('#narkotyki', 11);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int UNSIGNED DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `age`, `is_admin`, `created`) VALUES
(14, 'mleko', '$2y$10$QAyW5OacoKxf75BGJ5VKJuUm4b1hJcWw28s1bPmbO7507KWr3TG1e', 'mleczko', 1, 1, '1916-07-28 11:11:11'),
(15, 'TooHotToHandle', '$2y$10$pB8/6g6KYxFBV9kXXFOjBe/do6U2OWTUENxVpBLkAza1mP3lryiGC', 'anita', 21, 1, '2021-06-27 09:30:10'),
(35, 'toja', '$2y$10$MYRnVhSdJjlA619rmOsCQ.CqXFFIlI/oG0x6VJj6V1oZJn.R0bJuO', NULL, NULL, 1, '2021-06-29 06:39:08'),
(39, 'Json', '$2y$10$9Rsj90rmRGLSvp3.Iwsw0.qR5IhbPrxGHrXTUZanxfN7c9tVgaKz.', NULL, NULL, 0, '2021-06-29 11:36:39'),
(40, 'Partycja', '$2y$10$HggJyXehea6Chkg/DHgLVu38AJasb8UlhB8kSrnXuOZ0S5436X0AK', NULL, NULL, 0, '2021-06-29 11:38:52'),
(41, 'SynKoleżankiTwojejMamy', '$2y$10$r1Xd7gOa5L.R/16ykXkgF.iqB6o3hnhUrrYjQRn976/C8f1qY4RDu', NULL, NULL, 0, '2021-06-29 11:45:14'),
(42, 'Baba', '$2y$10$VbmnvApV76o38UIhNKB5juY3WucUHFkbmITdo59gGrqaZsdT1QPGq', NULL, NULL, 0, '2021-06-29 11:52:01');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `fpfti`
--
ALTER TABLE `fpfti`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`login`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `fpfti`
--
ALTER TABLE `fpfti`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
