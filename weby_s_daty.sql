-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 16. pro 2020, 15:45
-- Verze serveru: 10.4.14-MariaDB
-- Verze PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `weby_sp`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `prispevek`
--

CREATE TABLE `prispevek` (
  `id_prispevek` int(11) NOT NULL,
  `datum` varchar(20) COLLATE utf8mb4_czech_ci NOT NULL,
  `nadpis` varchar(60) COLLATE utf8mb4_czech_ci NOT NULL,
  `text` text COLLATE utf8mb4_czech_ci NOT NULL,
  `id_recenzent` int(11) DEFAULT NULL,
  `recenzovano` int(11) NOT NULL DEFAULT 0,
  `UZIVATEL_id_uzivatel` int(11) NOT NULL,
  `cesta` varchar(150) COLLATE utf8mb4_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `prispevek`
--

INSERT INTO `prispevek` (`id_prispevek`, `datum`, `nadpis`, `text`, `id_recenzent`, `recenzovano`, `UZIVATEL_id_uzivatel`, `cesta`) VALUES
(81, '2020/12/16', 'Titulek', '<p>Text</p>', -1, 0, 17, ''),
(82, '2020/12/16', 'Titulek 2', '<p>Text 2</p>', -1, 0, 17, ''),
(83, '2020/12/16', 'Titulek se souborem', '<p>tento př. má soubor</p>', -1, 0, 17, 'Uploads/reseneulohy7linzobrazeni.pdf');

-- --------------------------------------------------------

--
-- Struktura tabulky `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nazev` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL,
  `vaha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `role`
--

INSERT INTO `role` (`id_role`, `nazev`, `vaha`) VALUES
(0, 'čtenář', 0),
(1, 'autor', 1),
(2, 'recenzent', 2),
(3, 'administrátor', 3);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

CREATE TABLE `uzivatel` (
  `id_uzivatel` int(11) NOT NULL,
  `jmeno` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL,
  `prijmeni` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL,
  `ROLE_id_role` int(11) NOT NULL,
  `heslo` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL,
  `login` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`id_uzivatel`, `jmeno`, `prijmeni`, `ROLE_id_role`, `heslo`, `login`) VALUES
(17, 'admin', 'admin', 3, 'admin', 'admin'),
(19, 'uživatel2', 'už2', 0, 'kubice', 'uzivatel2'),
(20, 'uživatel3', 'už3', 2, 'kubice', 'uzivatel3'),
(21, 'uživatel4', 'už4', 2, 'kubice', 'uzivatel4'),
(22, 'uživatel5', 'už5', 3, 'kubice', 'uzivatel5');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `prispevek`
--
ALTER TABLE `prispevek`
  ADD PRIMARY KEY (`id_prispevek`),
  ADD KEY `fk_PRISPEVEK_UZIVATEL1_idx` (`UZIVATEL_id_uzivatel`);

--
-- Klíče pro tabulku `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Klíče pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  ADD PRIMARY KEY (`id_uzivatel`),
  ADD KEY `fk_UZIVATEL_ROLE_idx` (`ROLE_id_role`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `prispevek`
--
ALTER TABLE `prispevek`
  MODIFY `id_prispevek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `id_uzivatel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `prispevek`
--
ALTER TABLE `prispevek`
  ADD CONSTRAINT `fk_PRISPEVEK_UZIVATEL1` FOREIGN KEY (`UZIVATEL_id_uzivatel`) REFERENCES `uzivatel` (`id_uzivatel`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  ADD CONSTRAINT `fk_UZIVATEL_ROLE` FOREIGN KEY (`ROLE_id_role`) REFERENCES `role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
