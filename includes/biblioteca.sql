-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-07-2021 a las 18:59:50
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autore`
--

CREATE TABLE `autore` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `data_nascita` date NOT NULL,
  `data_morte` date DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autore_libro`
--

CREATE TABLE `autore_libro` (
  `id_autore` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indirizzo`
--

CREATE TABLE `indirizzo` (
  `id_utente` int(11) NOT NULL,
  `via` varchar(150) NOT NULL,
  `numero` int(11) NOT NULL,
  `citta` varchar(150) NOT NULL,
  `cap` varchar(5) NOT NULL,
  `regione` varchar(150) NOT NULL,
  `indirizzo_principale` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id` int(11) NOT NULL,
  `ISBN` varchar(13) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `copertina` varchar(255) DEFAULT NULL,
  `data_pubblicazione` date DEFAULT NULL,
  `genere` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ricensioni`
--

CREATE TABLE `ricensioni` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ritiro_libro`
--

CREATE TABLE `ritiro_libro` (
  `id_libro` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `data_ritiro` date NOT NULL,
  `data_consegna` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cognome` varchar(150) NOT NULL,
  `codice_fiscale` varchar(11) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `stato` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autore`
--
ALTER TABLE `autore`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `autore_libro`
--
ALTER TABLE `autore_libro`
  ADD KEY `id_autore` (`id_autore`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `indirizzo`
--
ALTER TABLE `indirizzo`
  ADD KEY `indirizzo_utente` (`id_utente`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ricensioni`
--
ALTER TABLE `ricensioni`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ritiro_libro`
--
ALTER TABLE `ritiro_libro`
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indices de la tabla `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autore`
--
ALTER TABLE `autore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `ricensioni`
--
ALTER TABLE `ricensioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `autore_libro`
--
ALTER TABLE `autore_libro`
  ADD CONSTRAINT `id_autore` FOREIGN KEY (`id_autore`) REFERENCES `autore` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_libro` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `indirizzo`
--
ALTER TABLE `indirizzo`
  ADD CONSTRAINT `indirizzo_utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ritiro_libro`
--
ALTER TABLE `ritiro_libro`
  ADD CONSTRAINT `id_libro` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
  
  -- Volcado de datos para la tabla `utente`
--

INSERT INTO `utente` (`id`, `username`, `password`, `nome`, `cognome`, `codice_fiscale`, `telefono`, `email`, `stato`) VALUES
(3, 'pola', '202cb962ac59075b964b07152d234b70', 'Paula', 'Goicoechea', 'gccpla90d52', '3517680105', 'paula.goicoechea@gmail.com', NULL);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
