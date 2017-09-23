-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 23. Sep 2017 um 09:33
-- Server Version: 5.5.57-0+deb8u1
-- PHP-Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `patient_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `patient_info`
--

CREATE TABLE IF NOT EXISTS `patient_info` (
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
  `shows_on_screen` int(11) NOT NULL DEFAULT '0',
  `img_path` varchar(64) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `patient_info`
--

INSERT INTO `patient_info` (`id`, `station`, `first_name`, `last_name`, `birthday`, `bwm`, `hsm`, `allergene`, `barcodedata`, `creationdate`, `badge_printed`, `shows_on_screen`, `img_path`) VALUES
(1, 'Kieferheilkunde', 'Marcel', 'Ochsendorf', '11.09.1995', 'Nein', 'Nein', 'Keine', '1', '2017-09-23 06:35:51', 1, 0, 'marcel_ochsendorf.jpg'),
(29, 'ZNA', 'Julia', 'Zimmermann', '25.08.1990', 'Nein', 'Nein', 'Keine', '3', '2017-09-23 07:21:35', 1, 1, 'julia.jpg'),
(33, 'ICP', 'nee', 'ochsendorf', 'XX95-09-11', 'nein', 'nein', 'keine', '3', '2017-09-23 08:50:45', 1, 0, 'default.jpg'),
(34, 'ICP', 'ja', 'Zimmermann', '1990-08-20', 'nein', 'nein', 'keine', '4', '2017-09-23 09:24:49', 1, 0, 'default.jpg');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `patient_info`
--
ALTER TABLE `patient_info`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `patient_info`
--
ALTER TABLE `patient_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
