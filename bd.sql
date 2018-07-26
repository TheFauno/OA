-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2018 at 03:52 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oirs_ambiental`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `idarea` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`idarea`, `nombre`) VALUES
(1, 'Ideas para tu carrera'),
(2, 'Docente otras carreras'),
(3, 'Administrativo otras unidades'),
(4, 'Docente carrera'),
(5, 'Ingraestructura y equipamiento'),
(6, 'Sistemas informáticos de docencia'),
(7, 'Beneficios estudiantiles'),
(8, 'Ideas para tu carrera');

-- --------------------------------------------------------

--
-- Table structure for table `comentario`
--

CREATE TABLE `comentario` (
  `idcomentario` int(10) UNSIGNED NOT NULL,
  `tipo_comentario` int(10) UNSIGNED NOT NULL,
  `area` int(10) UNSIGNED NOT NULL,
  `comentario` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estudiante_rut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comentario`
--

INSERT INTO `comentario` (`idcomentario`, `tipo_comentario`, `area`, `comentario`, `created_at`, `estudiante_rut`) VALUES
(1, 1, 1, 'hola que tal bien y tu', '2018-07-26 01:36:13', 18006063);

-- --------------------------------------------------------

--
-- Table structure for table `estudiante`
--

CREATE TABLE `estudiante` (
  `rut` int(11) NOT NULL,
  `digito` varchar(1) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apaterno` varchar(45) DEFAULT NULL,
  `amaterno` varchar(45) DEFAULT NULL,
  `vigente` varchar(1) DEFAULT 'S',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `estudiante`
--

INSERT INTO `estudiante` (`rut`, `digito`, `nombre`, `apaterno`, `amaterno`, `vigente`, `created_at`, `updated_at`) VALUES
(18006063, '4', 'camilo', 'daza', 'lavín', 'S', '2018-07-26 01:22:15', '2018-07-26 01:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `jefe_carrera`
--

CREATE TABLE `jefe_carrera` (
  `rut` int(10) UNSIGNED NOT NULL,
  `digito` varchar(1) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apaterno` varchar(45) NOT NULL,
  `amaterno` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `vigente` varchar(1) NOT NULL DEFAULT 'S',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_comentario`
--

CREATE TABLE `tipo_comentario` (
  `idtipo_comentario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_comentario`
--

INSERT INTO `tipo_comentario` (`idtipo_comentario`, `nombre`) VALUES
(1, 'Reclamos'),
(2, 'Información'),
(3, 'Sugerencias'),
(4, 'Felicitación');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`idarea`),
  ADD UNIQUE KEY `idarea_UNIQUE` (`idarea`);

--
-- Indexes for table `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`idcomentario`,`tipo_comentario`,`area`,`estudiante_rut`),
  ADD UNIQUE KEY `idcomentario_UNIQUE` (`idcomentario`),
  ADD KEY `fk_comentario_tipo_comentario_idx` (`tipo_comentario`),
  ADD KEY `fk_comentario_area1_idx` (`area`),
  ADD KEY `fk_comentario_estudiante1_idx` (`estudiante_rut`);

--
-- Indexes for table `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`rut`);

--
-- Indexes for table `jefe_carrera`
--
ALTER TABLE `jefe_carrera`
  ADD PRIMARY KEY (`rut`);

--
-- Indexes for table `tipo_comentario`
--
ALTER TABLE `tipo_comentario`
  ADD PRIMARY KEY (`idtipo_comentario`),
  ADD UNIQUE KEY `idtipo_comentario_UNIQUE` (`idtipo_comentario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `idarea` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comentario`
--
ALTER TABLE `comentario`
  MODIFY `idcomentario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tipo_comentario`
--
ALTER TABLE `tipo_comentario`
  MODIFY `idtipo_comentario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `fk_comentario_area1` FOREIGN KEY (`area`) REFERENCES `area` (`idarea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comentario_estudiante1` FOREIGN KEY (`estudiante_rut`) REFERENCES `estudiante` (`rut`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comentario_tipo_comentario` FOREIGN KEY (`tipo_comentario`) REFERENCES `tipo_comentario` (`idtipo_comentario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
