-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 11 mrt 2014 om 10:22
-- Serverversie: 5.5.33
-- PHP-versie: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databank: `spotify`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `fbid` varchar(25) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`fbid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden uitgevoerd voor tabel `accounts`
--

INSERT INTO `accounts` (`fbid`, `name`, `email`) VALUES
('100001566806807', 'Lloyd Keijzer', 'lloyd_msn@live.nl');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `uri` varchar(250) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `fbid` varchar(25) COLLATE utf8_bin NOT NULL,
  `tid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `search.fbid` (`fbid`),
  KEY `search.tid` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `uri` varchar(250) COLLATE utf8_bin NOT NULL,
  `aid` int(11) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `tracks.aid` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `search`
--
ALTER TABLE `search`
  ADD CONSTRAINT `search_ibfk_3` FOREIGN KEY (`fbid`) REFERENCES `accounts` (`fbid`),
  ADD CONSTRAINT `search_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `tracks` (`tid`);

--
-- Beperkingen voor tabel `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `artist` (`aid`);
