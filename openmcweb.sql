-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2016 at 06:05 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openmcweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogyazisi`
--

DROP TABLE IF EXISTS `blogyazisi`;
CREATE TABLE IF NOT EXISTS `blogyazisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yazar_id` int(11) DEFAULT NULL,
  `baslik` varchar(100) DEFAULT NULL,
  `icerik` longtext,
  `eklenme_zamani` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogYazisi_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hesaplar`
--

DROP TABLE IF EXISTS `hesaplar`;
CREATE TABLE IF NOT EXISTS `hesaplar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` varchar(100) NOT NULL,
  `gercekad` varchar(255) DEFAULT NULL,
  `sifre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `giris_yapilmis_mi` tinyint(1) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `songiris` bigint(20) DEFAULT NULL,
  `songiris_x` double NOT NULL DEFAULT '0',
  `songiris_y` double NOT NULL DEFAULT '0',
  `songiris_z` double NOT NULL DEFAULT '0',
  `songiris_world` varchar(255) NOT NULL DEFAULT 'world',
  `degiskenler` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hesaplar_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
