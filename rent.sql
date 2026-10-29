-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2026 at 11:55 PM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.5.12

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

CREATE TABLE `automobili` (
  `id` int(10) UNSIGNED NOT NULL,
  `marka` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `godina` year(4) NOT NULL,
  `cena` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `korisnici` (
  `id` int(10) UNSIGNED NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `prijava_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `email`, `lozinka`, `prijava_id`) VALUES
(4, 'Andrija', 'Zdravkovic', 'andrija.zdravkovic@pmf.edu.rs', '$2y$12$e9wZxjjUVuSvgztYjZBrNOTTIeBruhj2I5kU1ZqS7Q43Fd5x7MOsq', 3),
(6, 'Pavle ', 'Mancic', 'pavle@gmail.com', '$2y$12$k9Wtm4zVTIlJqtGlOF1CPO.j22WCu/dsDOzCuzrlpqDU5rxpdh3DW', 3);

-- --------------------------------------------------------

--
-- Table structure for table `poruke`
--

CREATE TABLE `poruke` (
  `id` int(11) NOT NULL,
  `ime` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `poruka` text NOT NULL,
  `odgovoren` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poruke`
--

INSERT INTO `poruke` (`id`, `ime`, `email`, `poruka`, `odgovoren`) VALUES
(1, 'Andrija', 'andrija.zdravkovic@pmf.edu.rs', 'Zdravo!', 1),
(2, 'Andrija', 'andrija.zdravkovic@pmf.edu.rs', 'Zdravo!', 0),
(3, 'Andrija', 'andrija.zdravkovic@pmf.edu.rs', 'Zdravo!', 0),
(4, 'Andrija', 'andrija.zdravkovic@pmf.edu.rs', 'Zdravo!!!', 0),
(5, 'Pavle', 'pavle@gmail.com', 'Zdravo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `prijavljivanje`
--

CREATE TABLE `prijavljivanje` (
  `id` int(10) UNSIGNED NOT NULL,
  `naziv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prijavljivanje`
--

INSERT INTO `prijavljivanje` (`id`, `naziv`) VALUES
(1, 'admin'),
(2, 'manager'),
(3, 'korisnik'),
(4, 'admin'),
(5, 'manager'),
(6, 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `rezervacije`
--

CREATE TABLE `rezervacije` (
  `id` int(10) UNSIGNED NOT NULL,
  `automobil_id` int(10) UNSIGNED DEFAULT NULL,
  `korisnik_id` int(10) UNSIGNED DEFAULT NULL,
  `datumPocetka` date NOT NULL,
  `datumKraja` date NOT NULL,
  `ukupnaCena` decimal(10,2) NOT NULL,
  `status` enum('rezervisano','odbijeno','potvrdjeno') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rezervacije`
--

INSERT INTO `rezervacije` (`id`, `automobil_id`, `korisnik_id`, `datumPocetka`, `datumKraja`, `ukupnaCena`, `status`) VALUES
(7, 3, 4, '2026-11-03', '2026-11-06', 1600.00, 'potvrdjeno'),
(8, 4, 6, '2026-10-31', '2026-11-04', 900.00, 'potvrdjeno');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `automobili`
--
ALTER TABLE `automobili`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `prijava_id` (`prijava_id`);

--
-- Indexes for table `poruke`
--
ALTER TABLE `poruke`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prijavljivanje`
--
ALTER TABLE `prijavljivanje`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rezervacije`
--
ALTER TABLE `rezervacije`
  ADD PRIMARY KEY (`id`),
  ADD KEY `automobil_id` (`automobil_id`),
  ADD KEY `korisnik_id` (`korisnik_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `automobili`
--
ALTER TABLE `automobili`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `poruke`
--
ALTER TABLE `poruke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prijavljivanje`
--
ALTER TABLE `prijavljivanje`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rezervacije`
--
ALTER TABLE `rezervacije`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
