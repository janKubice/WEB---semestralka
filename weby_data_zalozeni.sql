-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 21. pro 2020, 20:07
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
(81, '2020/12/16', 'Titulek', '<p>Text</p>', 22, 0, 17, ''),
(82, '2020/12/16', 'Titulek 2', '<p>Text 2</p>', 17, 1, 17, ''),
(83, '2020/12/16', 'Titulek se souborem', '<p>tento př. má soubor</p>', -1, 0, 17, 'Uploads/reseneulohy7linzobrazeni.pdf'),
(84, '2020/12/21', 'Jenom další titulek', '<ul><li>woah</li><li>bullet</li><li>pointy</li></ul>', -1, 0, 17, ''),
(85, '2020/12/21', 'Článek uživatele 4', '<p><strong>Tučný text, </strong><i>Kurzíva, <strong>tučná kurzíva?!?!</strong> &nbsp;</i></p>', -1, 0, 21, ''),
(86, '2020/12/21', 'T I T U L E K VELKÝ Č L Á N E K', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam at arcu a est sollicitudin euismod. Vivamus ac leo pretium faucibus. Mauris metus. Nunc tincidunt ante vitae massa. Morbi scelerisque luctus velit. Aliquam ante. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Suspendisse sagittis ultrices augue. Praesent dapibus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus. Nullam sit amet magna in magna gravida vehicula. In enim a arcu imperdiet malesuada. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Suspendisse sagittis ultrices augue. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam. Nam sed tellus id magna elementum tincidunt. Proin pede metus, vulputate nec, fermentum fringilla, vehicula vitae, justo.</p><p>In convallis. Duis pulvinar. Mauris elementum mauris vitae tortor. Phasellus rhoncus. Donec quis nibh at felis congue commodo. Sed ac dolor sit amet purus malesuada congue. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat. Integer malesuada. Etiam neque. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Nullam faucibus mi quis velit. Nunc tincidunt ante vitae massa. Fusce tellus. Aenean id metus id velit ullamcorper pulvinar. Curabitur ligula sapien, pulvinar a vestibulum quis, facilisis vel sapien. Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat. Donec iaculis gravida nulla.</p><p>Nam sed tellus id magna elementum tincidunt. Praesent in mauris eu tortor porttitor accumsan. Aliquam ornare wisi eu metus. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Mauris metus. Mauris suscipit, ligula sit amet pharetra semper, nibh ante cursus purus, vel sagittis velit mauris vel metus. Nulla non lectus sed nisl molestie malesuada. Nunc dapibus tortor vel mi dapibus sollicitudin. Mauris dictum facilisis augue. Et harum quidem rerum facilis est et expedita distinctio. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. Nunc tincidunt ante vitae massa. Nulla non arcu lacinia neque faucibus fringilla. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla est.</p><p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. In rutrum. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Suspendisse nisl. Nulla quis diam. Maecenas lorem. Nullam rhoncus aliquam metus. Nullam faucibus mi quis velit. Duis viverra diam non justo. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus. In convallis. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Nunc auctor. Aliquam ornare wisi eu metus. Mauris suscipit, ligula sit amet pharetra semper, nibh ante cursus purus, vel sagittis velit mauris vel metus. Duis ante orci, molestie vitae vehicula venenatis, tincidunt ac pede.</p><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Nullam at arcu a est sollicitudin euismod. Aliquam ante. Vivamus luctus egestas leo. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Nulla accumsan, elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel leo. Quisque porta. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Et harum quidem rerum facilis est et expedita distinctio. Nulla est. Sed ac dolor sit amet purus malesuada congue. Phasellus faucibus molestie nisl. Nullam sit amet magna in magna gravida vehicula. Aenean vel massa quis mauris vehicula lacinia.</p>', -1, 0, 21, ''),
(87, '2020/12/21', ':)', '<h2>:)</h2>', -1, 0, 20, '');

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
(19, 'uživatel2', 'už2', 1, 'kubice', 'uzivatel2'),
(20, 'uživatel3', 'už3', 2, 'kubice', 'uzivatel3'),
(21, 'uživatel4', 'už4', 2, 'kubice', 'uzivatel4'),
(22, 'uživatel5', 'už5', 1, 'kubice', 'uzivatel5'),
(23, 'uživatel6', 'už6', 1, 'kubice', 'uzivatel6'),
(24, 'uzivatel7', 'už7', 3, 'kubice', 'uzivatel7'),
(25, 'uživatel8', 'už8', 0, 'kubice', 'uzivatel8');

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
  MODIFY `id_prispevek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `id_uzivatel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
