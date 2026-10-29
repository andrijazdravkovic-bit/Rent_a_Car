-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 30, 2025 at 05:15 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rent`
--

-- --------------------------------------------------------

--
-- Table structure for table `automobili`
--

DROP TABLE IF EXISTS `automobili`;
CREATE TABLE IF NOT EXISTS `automobili` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `marka` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `godina` year NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `automobili`
--

INSERT INTO `automobili` (`id`, `marka`, `model`, `godina`, `cena`) VALUES
(1, 'BMW', 'X6', '2024', 150.00),
(2, 'Porsche', '911 Carrera', '2023', 250.00),
(3, 'Ferrari', 'Roma', '2023', 400.00),
(4, 'Ford', 'Mustang GT', '2022', 180.00),
(5, 'Mercedes', 'C-Class', '2021', 70.00),
(6, 'Audi', 'A7', '2022', 110.00),
(7, 'Volkswagen', 'Golf', '2021', 45.00),
(8, 'Tesla', 'Model 3', '2023', 90.00);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `prijava_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `prijava_id` (`prijava_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `email`, `lozinka`, `prijava_id`) VALUES
(1, 'Andrija', 'Zdravkovic', 'andrijazdravkovic1111@gmail.com', '$2y$10$MbsMRYEAd6TYNwHe9np7cu5wp7bM86qerZ/xReDU27FjuYSGBFERK', 3),
(3, 'Andrija', 'Zdravkovic', 'andrijazdravkovic1@gmail.com', '$2y$10$L.ptUKJY/Ocqpc0dXdWsvOu16GDxLNj1/WM4q./bY7OSDA3PAlnAa', 3);

-- --------------------------------------------------------

--
-- Table structure for table `poruke`
--

DROP TABLE IF EXISTS `poruke`;
CREATE TABLE IF NOT EXISTS `poruke` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ime` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `poruka` text NOT NULL,
  `odgovoren` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prijavljivanje`
--

DROP TABLE IF EXISTS `prijavljivanje`;
CREATE TABLE IF NOT EXISTS `prijavljivanje` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prijavljivanje`
--

INSERT INTO `prijavljivanje` (`id`, `naziv`) VALUES
(1, 'admin'),
(2, 'manager'),
(3, 'korisnik'),
(4, 'admin'),
(5, 'manager'),
(6, 'korisnik'),
(7, 'admin'),
(8, 'manager'),
(9, 'korisnik'),
(10, 'admin'),
(11, 'manager'),
(12, 'korisnik'),
(13, 'admin'),
(14, 'manager'),
(15, 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `rezervacije`
--

DROP TABLE IF EXISTS `rezervacije`;
CREATE TABLE IF NOT EXISTS `rezervacije` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `automobil_id` int UNSIGNED DEFAULT NULL,
  `korisnik_id` int UNSIGNED DEFAULT NULL,
  `datumPocetka` date NOT NULL,
  `datumKraja` date NOT NULL,
  `ukupnaCena` decimal(10,2) NOT NULL,
  `status` enum('rezervisano','odbijeno','potvrdjeno') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `automobil_id` (`automobil_id`),
  KEY `korisnik_id` (`korisnik_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rezervacije`
--

INSERT INTO `rezervacije` (`id`, `automobil_id`, `korisnik_id`, `datumPocetka`, `datumKraja`, `ukupnaCena`, `status`) VALUES
(3, 1, 1, '2025-10-31', '2025-10-31', 150.00, 'potvrdjeno');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD CONSTRAINT `korisnici_ibfk_1` FOREIGN KEY (`prijava_id`) REFERENCES `prijavljivanje` (`id`);

--
-- Constraints for table `rezervacije`
--
ALTER TABLE `rezervacije`
  ADD CONSTRAINT `rezervacije_ibfk_1` FOREIGN KEY (`automobil_id`) REFERENCES `automobili` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rezervacije_ibfk_2` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
