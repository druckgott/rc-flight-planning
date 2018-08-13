-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db669182842.db.1and1.com
-- Erstellungszeit: 20. Aug 2017 um 15:35
-- Server Version: 5.5.57-0+deb7u1-log
-- PHP-Version: 5.4.45-0+deb7u9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `db669182842`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einstellungen`
--

CREATE TABLE IF NOT EXISTS `einstellungen` (
  `id_e` int(11) NOT NULL AUTO_INCREMENT,
  `name_s` varchar(100) NOT NULL,
  `value_s` varchar(100) NOT NULL,
  PRIMARY KEY (`id_e`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `einstellungen`
--

INSERT INTO `einstellungen` (`id_e`, `name_s`, `value_s`) VALUES
(1, 'index_background', '#BDBDBD'),
(2, 'index_text_color', '#000000'),
(3, 'index_num_top_b', '10'),
(4, 'index_num_bottom_b', '4'),
(5, 'index_font_size_top_b', 'h1'),
(6, 'index_font_size_split_top_b', 'h5'),
(7, 'index_font_size_bottom_b', 'h5'),
(8, 'index_icon_split_color', '#ffffff'),
(9, 'index_back_split_color', '#000000'),
(10, 'index_wait_time', '1'),
(11, 'index_back_color_first', '#04b431'),
(12, 'index_back_color_second', '#FF8000'),
(13, 'index_back_color_third', '#FF8000'),
(14, 'index_back_color_other', '#ffffff'),
(15, 'global_max_flight_time', '900');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
