-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 15, 2017 at 11:05 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkreiner`
--

-- --------------------------------------------------------

--
-- Table structure for table `flugzeug`
--

CREATE TABLE `flugzeug` (
  `id_f` int(11) NOT NULL,
  `name_f` varchar(100) NOT NULL,
  `piloten_id` varchar(100) NOT NULL,
  `flugzeugtyp_id` varchar(100) NOT NULL,
  `flugzeugantrieb_id` int(11) NOT NULL,
  `published` varchar(100) NOT NULL,
  `aktivated` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flugzeug`
--

INSERT INTO `flugzeug` (`id_f`, `name_f`, `piloten_id`, `flugzeugtyp_id`, `flugzeugantrieb_id`, `published`, `aktivated`) VALUES
(62, 'Fuchsjagd', '203', '10', 5, '2', 1),
(63, 'Styrostangen', '203', '12', 5, '1', 1),
(64, 'Ballonstechen', '203', '10', 5, '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `flugzeug_antrieb`
--

CREATE TABLE `flugzeug_antrieb` (
  `id_fa` int(11) NOT NULL,
  `name_fa` varchar(100) NOT NULL,
  `flugzeugantrieb_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flugzeug_antrieb`
--

INSERT INTO `flugzeug_antrieb` (`id_fa`, `name_fa`, `flugzeugantrieb_id`) VALUES
(1, 'keinen', 1),
(2, 'Turbine', 2),
(3, 'Impeller', 3),
(4, 'Verbrenner', 4),
(5, 'Elektro', 5);

-- --------------------------------------------------------

--
-- Table structure for table `flugzeug_typ`
--

CREATE TABLE `flugzeug_typ` (
  `id_ft` int(11) NOT NULL,
  `name_ft` varchar(100) NOT NULL,
  `flugzeugtyp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flugzeug_typ`
--

INSERT INTO `flugzeug_typ` (`id_ft`, `name_ft`, `flugzeugtyp_id`) VALUES
(1, 'Hubschrauber Kunstflug', 1),
(2, 'Hubschrauber Normal', 2),
(3, 'Flugzeug Kunstflug', 3),
(4, 'Turbinen Jet', 4),
(5, 'Impeller Jet', 5),
(6, 'Segelflugzeug', 6),
(7, 'Schleppflugzeug', 7),
(8, 'Funmodell', 8),
(9, 'Warbird', 9),
(10, 'Oldtimer', 10),
(11, 'Copter', 11),
(12, 'Event', 12);

-- --------------------------------------------------------

--
-- Table structure for table `piloten`
--

CREATE TABLE `piloten` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `emailsend` varchar(100) NOT NULL,
  `ordering` int(100) NOT NULL,
  `published` varchar(100) NOT NULL,
  `aktivated` varchar(100) NOT NULL,
  `aktiv_flugzeug` int(100) NOT NULL,
  `unique_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `piloten`
--

INSERT INTO `piloten` (`id`, `name`, `vorname`, `email`, `emailsend`, `ordering`, `published`, `aktivated`, `aktiv_flugzeug`, `unique_id`) VALUES
(203, 'Attraktion', ' ', '', '2', 999999, '2', '1', 0, 'e440ee224bb8a8ad1383d784');

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `id_ti` int(11) NOT NULL,
  `type_id` varchar(100) NOT NULL DEFAULT '',
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `end_time` time NOT NULL DEFAULT '00:00:00',
  `result_time` time NOT NULL DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unique_ids`
--

CREATE TABLE `unique_ids` (
  `id_un` int(11) NOT NULL,
  `number` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `unique_ids`
--

INSERT INTO `unique_ids` (`id_un`, `number`) VALUES
(203, 'b53d278a065fad1b553a6529');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flugzeug`
--
ALTER TABLE `flugzeug`
  ADD PRIMARY KEY (`id_f`);

--
-- Indexes for table `flugzeug_antrieb`
--
ALTER TABLE `flugzeug_antrieb`
  ADD PRIMARY KEY (`id_fa`);

--
-- Indexes for table `flugzeug_typ`
--
ALTER TABLE `flugzeug_typ`
  ADD PRIMARY KEY (`id_ft`);

--
-- Indexes for table `piloten`
--
ALTER TABLE `piloten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unique_ids`
--
ALTER TABLE `unique_ids`
  ADD PRIMARY KEY (`id_un`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flugzeug`
--
ALTER TABLE `flugzeug`
  MODIFY `id_f` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;
--
-- AUTO_INCREMENT for table `flugzeug_antrieb`
--
ALTER TABLE `flugzeug_antrieb`
  MODIFY `id_fa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `flugzeug_typ`
--
ALTER TABLE `flugzeug_typ`
  MODIFY `id_ft` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `piloten`
--
ALTER TABLE `piloten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;
--
-- AUTO_INCREMENT for table `unique_ids`
--
ALTER TABLE `unique_ids`
  MODIFY `id_un` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;COMMIT;

  
  CREATE TABLE IF NOT EXISTS `einstellungen` (
  `id_e` int(11) NOT NULL AUTO_INCREMENT,
  `name_s` varchar(100) NOT NULL,
  `value_s` varchar(100) NOT NULL,
  PRIMARY KEY (`id_e`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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


CREATE TABLE `history` (
  `history_id` int(11) NOT NULL,
  `history_piloten_id` int(100) NOT NULL,
  `history_name` varchar(100) NOT NULL,
  `history_vorname` varchar(100) NOT NULL,
  `history_name_f` text NOT NULL,
  `history_name_ft` text NOT NULL,
  `history_name_fa` text NOT NULL,
  `history_starttime` datetime NOT NULL,
  `history_stoptime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `history`
--

INSERT INTO `history` (`history_id`, `history_piloten_id`, `history_name`, `history_vorname`, `history_name_f`, `history_name_ft`, `history_name_fa`, `history_starttime`, `history_stoptime`) VALUES
(72, 0, 'B', 'Stephan', 'Eurofighter', 'Turbinen Jet', 'Turbine', '2017-08-18 20:51:32', '2017-08-18 20:51:36'),
(74, 0, 'B', 'Klaus', 'ME163', 'Oldtimer', 'Elektro', '2017-08-18 20:51:36', '2017-08-18 20:51:38'),
(75, 0, 'A', 'Tim', 'Corsair F4U', 'Warbird', 'Verbrenner', '2017-08-18 20:51:38', '2017-08-18 20:51:41'),
(78, 0, 'D', 'Heinrich', 'Fokker DR 1', 'Oldtimer', 'Verbrenner', '2017-08-18 21:20:24', '2017-08-18 21:21:19'),
(79, 199, 'Attraktion', 'Tim', 'Corsair F4U', 'Warbird', 'Verbrenner', '2017-08-18 21:21:19', '2017-08-18 21:33:24'),
(80, 379, 'K ', 'Florian', 'Katana', 'Flugzeug Kunstflug', 'Elektro', '2017-08-18 21:21:19', '2017-08-18 21:33:24'),
(81, 203, 'A', ' ', 'Styrostangen', 'Event', 'Elektro', '2017-08-18 21:33:24', '2017-08-18 21:33:35'),
(82, 293, 'Ã–', 'Robert', 'Dountless', 'Funmodell', 'Verbrenner', '2017-08-18 21:33:35', '2017-08-18 21:33:45'),
(83, 314, 'B', 'Ingmar', 'Carf DG800S-T', 'Turbinen Jet', 'Turbine', '2017-08-18 21:33:45', '2017-08-18 21:33:48'),
(85, 272, 'B', 'Stephan', 'Eurofighter', 'Turbinen Jet', 'Turbine', '2017-08-18 22:15:48', '2017-08-18 22:16:17'),
(86, 302, 'D', 'Heinrich', 'Fokker DR 1', 'Oldtimer', 'Verbrenner', '2017-08-18 22:15:48', '2017-08-18 22:16:17'),
(87, 185, 'D', 'Manfred', 'Piper PA 18', 'Oldtimer', 'Verbrenner', '2017-08-18 22:15:48', '2017-08-18 22:16:17'),
(88, 203, 'Attraktion', ' ', 'Styrostangen', 'Event', 'Elektro', '2017-08-18 22:16:17', '2017-08-18 22:22:51'),
(89, 293, 'Ã–', 'Robert', 'Dountless', 'Funmodell', 'Verbrenner', '2017-08-18 22:22:51', '2017-08-18 22:23:45'),
(90, 379, 'K ', 'Florian', 'Katana', 'Flugzeug Kunstflug', 'Elektro', '2017-08-18 22:23:45', '2017-08-18 22:24:02'),
(91, 199, 'A', 'Tim', 'Corsair F4U', 'Warbird', 'Verbrenner', '2017-08-18 22:24:02', '2017-08-18 22:24:06'),
(93, 293, 'Ã–', 'Robert', 'Dountless', 'Funmodell', 'Verbrenner', '2017-08-19 01:34:17', '2017-08-19 01:34:39'),
(95, 341, 'W', 'Axel', 'Minimoa', 'Segelflugzeug', 'keinen', '2017-08-20 21:50:27', '2017-08-21 21:11:16'),
(96, 199, 'A', 'Tim', 'Corsair F4U', 'Warbird', 'Verbrenner', '2017-08-21 21:11:16', '2017-08-21 21:11:16');

--
-- Indizes für die Tabelle `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
COMMIT;

ALTER TABLE `flugzeug` ADD `flugzeug_kommentar` TEXT NOT NULL AFTER `flugzeugantrieb_id`;
ALTER TABLE `piloten` ADD `kommentar` TEXT NOT NULL AFTER `unique_id`;


ALTER TABLE `flugzeug_typ` ADD `iconname_ft` VARCHAR(100) NOT NULL AFTER `flugzeugtyp_id`;


ALTER TABLE `history` ADD `history_starttime` DATETIME NOT NULL AFTER `history_flugzeug`;
ALTER TABLE `history` ADD `history_stoptime` DATETIME NOT NULL AFTER `history_starttime`;


ALTER TABLE `history` ADD `history_name_f` TEXT NOT NULL AFTER `history_flugzeug`, ADD `history_name_ft` TEXT NOT NULL AFTER `history_name_f`, ADD `history_name_fa` TEXT NOT NULL AFTER `history_name_ft`;
ALTER TABLE `history` DROP `history_flugzeug`;
ALTER TABLE `history` ADD `history_piloten_id` INT(100) NOT NULL AFTER `history_id`;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
