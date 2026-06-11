-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2026 a las 06:38:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdvuelos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avion`
--

CREATE TABLE `avion` (
  `id_avion` int(11) NOT NULL,
  `id_vuelo` int(11) NOT NULL,
  `dispo` int(11) NOT NULL DEFAULT 42,
  `A1` int(11) NOT NULL DEFAULT 0,
  `A2` int(11) NOT NULL DEFAULT 0,
  `A3` int(11) NOT NULL DEFAULT 0,
  `A4` int(11) NOT NULL DEFAULT 0,
  `A5` int(11) NOT NULL DEFAULT 0,
  `A6` int(11) NOT NULL DEFAULT 0,
  `B1` int(11) NOT NULL DEFAULT 0,
  `B2` int(11) NOT NULL DEFAULT 0,
  `B3` int(11) NOT NULL DEFAULT 0,
  `B4` int(11) NOT NULL DEFAULT 0,
  `B5` int(11) NOT NULL DEFAULT 0,
  `B6` int(11) NOT NULL DEFAULT 0,
  `C1` int(11) NOT NULL DEFAULT 0,
  `C2` int(11) NOT NULL DEFAULT 0,
  `C3` int(11) NOT NULL DEFAULT 0,
  `C4` int(11) NOT NULL DEFAULT 0,
  `C5` int(11) NOT NULL DEFAULT 0,
  `C6` int(11) NOT NULL DEFAULT 0,
  `D1` int(11) NOT NULL DEFAULT 0,
  `D2` int(11) NOT NULL DEFAULT 0,
  `D3` int(11) NOT NULL DEFAULT 0,
  `D4` int(11) NOT NULL DEFAULT 0,
  `D5` int(11) NOT NULL DEFAULT 0,
  `D6` int(11) NOT NULL DEFAULT 0,
  `E1` int(11) NOT NULL DEFAULT 0,
  `E2` int(11) NOT NULL DEFAULT 0,
  `E3` int(11) NOT NULL DEFAULT 0,
  `E4` int(11) NOT NULL DEFAULT 0,
  `E5` int(11) NOT NULL DEFAULT 0,
  `E6` int(11) NOT NULL DEFAULT 0,
  `F1` int(11) NOT NULL DEFAULT 0,
  `F2` int(11) NOT NULL DEFAULT 0,
  `F3` int(11) NOT NULL DEFAULT 0,
  `F4` int(11) NOT NULL DEFAULT 0,
  `F5` int(11) NOT NULL DEFAULT 0,
  `F6` int(11) NOT NULL DEFAULT 0,
  `G1` int(11) NOT NULL DEFAULT 0,
  `G2` int(11) NOT NULL DEFAULT 0,
  `G3` int(11) NOT NULL DEFAULT 0,
  `G4` int(11) NOT NULL DEFAULT 0,
  `G5` int(11) NOT NULL DEFAULT 0,
  `G6` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `avion`
--

INSERT INTO `avion` (`id_avion`, `id_vuelo`, `dispo`, `A1`, `A2`, `A3`, `A4`, `A5`, `A6`, `B1`, `B2`, `B3`, `B4`, `B5`, `B6`, `C1`, `C2`, `C3`, `C4`, `C5`, `C6`, `D1`, `D2`, `D3`, `D4`, `D5`, `D6`, `E1`, `E2`, `E3`, `E4`, `E5`, `E6`, `F1`, `F2`, `F3`, `F4`, `F5`, `F6`, `G1`, `G2`, `G3`, `G4`, `G5`, `G6`) VALUES
(1, 1, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0),
(2, 2, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 0, 0, 0, 0),
(3, 3, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 4, 42, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 4, 42, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 5, 42, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 6, 42, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidoP` varchar(100) NOT NULL,
  `apellidoM` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `nacionalidad` varchar(100) NOT NULL,
  `num_pasaporte` varchar(50) NOT NULL,
  `tipo_usuario` varchar(8) NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `user`, `nombre`, `apellidoP`, `apellidoM`, `correo`, `pass`, `tel`, `fecha_nacimiento`, `nacionalidad`, `num_pasaporte`, `tipo_usuario`, `fecha_registro`) VALUES
(1, 'valevale', 'VALERIA', 'CAMPOS', 'ELVIRA', 'valeriacampos@gmail.com', '1234', '4448529635', '2006-09-13', 'MEXICANA', 'MX000913', 'admin', '2026-05-12 02:54:59'),
(2, 'dieegogo', 'DIEGO', 'ALMENDAREZ', 'MARTINES', 'diegoool@gmail.com', '1234', '4447418563', '2006-09-01', 'MEXICANO', 'MX000109', 'user', '2026-05-11 19:57:41'),
(3, 'pitzanami', 'ITZANAMI', 'BERLANGA', 'CONTRERAS', 'pitzanami@gmail.com', '1234', '4448522625', '2001-11-08', 'MEXICANA', 'MX000821', 'user', '2026-05-11 22:55:08'),
(4, 'katia', 'KATIA', 'RAMOS', 'QUEZADA', 'katia@gmail.com', '1234', '4446576683', '2006-02-04', 'MEXICANA', 'BA234567', 'admin', '2026-05-12 18:48:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelos`
--

CREATE TABLE `vuelos` (
  `id_vuelo` int(11) NOT NULL,
  `num_vuelo` varchar(8) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `fecha_llegada` date NOT NULL,
  `hora_llegada` time NOT NULL,
  `puerta_salida` varchar(10) NOT NULL,
  `puerta_embarque` varchar(10) NOT NULL,
  `estado_vuelo` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `num_avion` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vuelos`
--

INSERT INTO `vuelos` (`id_vuelo`, `num_vuelo`, `destino`, `fecha_salida`, `hora_salida`, `fecha_llegada`, `hora_llegada`, `puerta_salida`, `puerta_embarque`, `estado_vuelo`, `precio`, `num_avion`) VALUES
(1, 'MX101', 'CANCUN', '2026-06-12', '11:30:00', '2026-06-12', '14:15:00', 'A1', 'A1', 'Programado', 9500.00, 'BA253'),
(2, 'MX102', 'LONDRES', '2026-05-16', '22:00:00', '2026-05-17', '11:00:00', 'B3', 'C1', 'Programado', 12500.00, 'DK012'),
(3, 'MX103', 'MALINA', '2026-05-13', '09:00:00', '2026-05-14', '09:00:00', 'A1', 'A2', 'Programado', 15750.00, 'ML274'),
(4, 'MX104', 'ROMA', '2026-05-12', '07:00:00', '2026-05-12', '20:00:00', 'A2', 'A3', 'Programado', 11600.00, 'RM116'),
(5, 'MX105', 'NUEVA YORK', '2026-05-13', '07:00:00', '2026-05-13', '11:00:00', 'B2', 'B3', 'Programado', 15500.00, 'NY104'),
(6, 'MX106', 'DUBLIN', '2026-05-22', '21:45:03', '2026-05-23', '12:30:00', 'A1', 'A1', 'Programado', 13400.00, 'DL256');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avion`
--
ALTER TABLE `avion`
  ADD PRIMARY KEY (`id_avion`),
  ADD KEY `id_vuelo` (`id_vuelo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `vuelos`
--
ALTER TABLE `vuelos`
  ADD PRIMARY KEY (`id_vuelo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avion`
--
ALTER TABLE `avion`
  MODIFY `id_avion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `vuelos`
--
ALTER TABLE `vuelos`
  MODIFY `id_vuelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avion`
--
ALTER TABLE `avion`
  ADD CONSTRAINT `avion_ibfk_1` FOREIGN KEY (`id_vuelo`) REFERENCES `vuelos` (`id_vuelo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
