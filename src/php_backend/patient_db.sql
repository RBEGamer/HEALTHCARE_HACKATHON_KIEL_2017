-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 29. Sep 2017 um 04:21
-- Server-Version: 5.6.35
-- PHP-Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `patient_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `day` text NOT NULL,
  `menu_a` text NOT NULL,
  `menu_b` text NOT NULL,
  `menu_c` text NOT NULL,
  `allergene_a` text NOT NULL,
  `allergene_b` text NOT NULL,
  `allergene_c` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `menu`
--

INSERT INTO `menu` (`id`, `day`, `menu_a`, `menu_b`, `menu_c`, `allergene_a`, `allergene_b`, `allergene_c`) VALUES
(1, 'Mon', 'Schnitzel mit Pommes oder Kartoffeln', 'Vegetarische Lasagne mit Parmesan', 'Milchreis mit Roter Grütze', 'gluten', '', ''),
(2, 'Tue', 'Pizza Hawaii', 'Curryreis mit Lamm', 'Doener mit Tzaziki', 'gluten', '', 'laktose'),
(3, 'Wed', 'Brot mit Lachs in Hanfsosse', 'Rotkohl mit Lebersosse', 'Düsseldorfer Alt', 'gluten', 'laktose', ''),
(4, 'Thu', 'Schnitzel Wiener Art mit Pommes und einem Beilagensalat', 'Frischer Sommersalat mit Lachs', 'Vegetarische Spagetti Bolognese', '', '', 'gluten'),
(5, 'Fri', 'Strom mit dem extra feeling', 'Wasser still natural', 'Warum der Trabbi so lecker', '', 'gluten', ''),
(6, 'Sat', 'Essen halt', 'Verhungert', 'Ich habe dir gesagt es gibt nichts', '', '', ''),
(7, 'Sun', 'Pudding', 'Knödel', 'ddpjfsionsoifnsdiosfnsdoif', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `patient_info`
--

CREATE TABLE `patient_info` (
  `id` int(11) NOT NULL,
  `station` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `birthday` text NOT NULL,
  `bwm` text NOT NULL,
  `hsm` text NOT NULL,
  `allergene` text NOT NULL,
  `barcodedata` text NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `badge_printed` int(11) NOT NULL DEFAULT '0',
  `shows_on_screen` int(11) NOT NULL DEFAULT '-1',
  `img_path` varchar(64) NOT NULL DEFAULT 'default.jpg',
  `hash_sh1` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `patient_info`
--

INSERT INTO `patient_info` (`id`, `station`, `first_name`, `last_name`, `birthday`, `bwm`, `hsm`, `allergene`, `barcodedata`, `creationdate`, `badge_printed`, `shows_on_screen`, `img_path`, `hash_sh1`) VALUES
(1, 'ICP', 'Marcel', 'O', '11.09.1995', 'Nein', 'Nein', 'gluten', '60bb26f62br0WOo', '2017-09-28 22:22:15', 1, 1, './images/marcelochsendorf1191995.jpeg', '60bb26f62b201debdbbd974194efb0670168ef2d'),
(86, 'HZR', 'Julia', 'Z', '25.07.1990', 'Ja', 'Nein', 'gluten,laktose', 'a4f37ddc2f4aecd', '2017-09-29 02:07:48', 1, -1, '/images/juliaz258199.jpeg', 'a4f37ddc2f4aecdb7361ab4099e896be94ce997a');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `termine`
--

CREATE TABLE `termine` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `activity` text NOT NULL,
  `location` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `old` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `termine`
--

INSERT INTO `termine` (`id`, `pid`, `activity`, `location`, `timestamp`, `old`) VALUES
(1, 1, 'Ultraschall', 'C 312', '2017-09-29 02:01:17', 0),
(2, 1, 'physiotherapie', 'D 12', '2017-09-29 02:01:19', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vital_data`
--

CREATE TABLE `vital_data` (
  `id` int(11) NOT NULL,
  `systole` int(11) NOT NULL,
  `diastole` int(11) NOT NULL,
  `puls` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `vital_data`
--

INSERT INTO `vital_data` (`id`, `systole`, `diastole`, `puls`, `pid`, `ts`) VALUES
(20, 100, 80, 50, 1, '2017-09-23 10:12:03'),
(21, 120, 80, 80, 1, '2017-09-23 10:15:53'),
(22, 120, 80, 80, 1, '2017-09-23 10:17:34'),
(23, 120, 80, 80, 1, '2017-09-23 11:03:02');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `patient_info`
--
ALTER TABLE `patient_info`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `termine`
--
ALTER TABLE `termine`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vital_data`
--
ALTER TABLE `vital_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `patient_info`
--
ALTER TABLE `patient_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT für Tabelle `termine`
--
ALTER TABLE `termine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `vital_data`
--
ALTER TABLE `vital_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
