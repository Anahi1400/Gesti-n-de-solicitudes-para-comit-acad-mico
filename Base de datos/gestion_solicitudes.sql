-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3308
-- Tiempo de generación: 07-12-2023 a las 03:39:04
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_solicitudes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `Id_Admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`Id`, `Nombre`, `Apellidos`, `Id_Admin`) VALUES
(1, 'Quinatzin', 'Reyes Gomez', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `Id_Carrera` int(11) NOT NULL,
  `NombreCarrera` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`Id_Carrera`, `NombreCarrera`) VALUES
(1, 'Ing. Sistemas Computacionales'),
(2, 'Ing. Electromecánica'),
(3, 'Ing. Civil'),
(4, 'Ing. Electrónica'),
(5, 'Ing. Industrial (Presencial)'),
(6, 'Ing. Industrial (Mixta)'),
(7, 'Ing. En Gestión Empresarial (Presencial)'),
(8, 'Ing. En Gestión Empresarial (Mixta)'),
(9, 'Lic. En Gastronomía'),
(10, 'Lic. En Arquitectura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `Id_Fecha` int(11) NOT NULL,
  `Fecha_Limite` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `Id_Estudiante` int(11) NOT NULL,
  `No_Control` int(15) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido_Mat` varchar(30) DEFAULT NULL,
  `Apellido_Pat` varchar(30) NOT NULL,
  `Semestre` varchar(6) NOT NULL,
  `Foto` mediumblob DEFAULT NULL,
  `Id_Carrera1` int(11) NOT NULL,
  `Id_Usuario1` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_solicitud`
--

CREATE TABLE `estudiante_solicitud` (
  `Id` int(11) NOT NULL,
  `Id_Estudiante` int(11) NOT NULL,
  `Id_Solicitud` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio_admin`
--

CREATE TABLE `inicio_admin` (
  `Id_Admin` int(11) NOT NULL,
  `Correo` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inicio_admin`
--

INSERT INTO `inicio_admin` (`Id_Admin`, `Correo`, `password`) VALUES
(1, 'quinatzin.reyes@zapopan.tecmm.edu.mx', '$2y$10$kfteavomxt71kvaRTyk9OOiwi8r7e/1s00mKbZr2YoZNzdodl.iES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio_alum`
--

CREATE TABLE `inicio_alum` (
  `Id_Usuario` int(11) NOT NULL,
  `Correo` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `codigo_verificacion` text NOT NULL,
  `email_verificado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `Id_Lote` int(11) NOT NULL,
  `Lote` varchar(255) NOT NULL,
  `Activo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `Id_Solicitud` int(11) NOT NULL,
  `Petición` mediumblob NOT NULL,
  `Evidencias` mediumblob DEFAULT NULL,
  `Comentarios` varchar(200) DEFAULT NULL,
  `Estatus` varchar(10) NOT NULL,
  `Id` int(11) DEFAULT NULL,
  `ComentariosAdmin` varchar(255) DEFAULT NULL,
  `Respuesta` mediumblob DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `Lote` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Fk_Admin` (`Id_Admin`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`Id_Carrera`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`Id_Fecha`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`Id_Estudiante`),
  ADD KEY `Fk_Carrera` (`Id_Carrera1`),
  ADD KEY `Fk_Usuario` (`Id_Usuario1`);

--
-- Indices de la tabla `estudiante_solicitud`
--
ALTER TABLE `estudiante_solicitud`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Estudiante` (`Id_Estudiante`),
  ADD KEY `Id_Solicitud` (`Id_Solicitud`);

--
-- Indices de la tabla `inicio_admin`
--
ALTER TABLE `inicio_admin`
  ADD PRIMARY KEY (`Id_Admin`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `inicio_alum`
--
ALTER TABLE `inicio_alum`
  ADD PRIMARY KEY (`Id_Usuario`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`Id_Lote`),
  ADD UNIQUE KEY `Lote` (`Lote`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`Id_Solicitud`),
  ADD KEY `Fk_Admin1` (`Id`),
  ADD KEY `Lote` (`Lote`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `Id_Carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `Id_Fecha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `Id_Estudiante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiante_solicitud`
--
ALTER TABLE `estudiante_solicitud`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inicio_admin`
--
ALTER TABLE `inicio_admin`
  MODIFY `Id_Admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inicio_alum`
--
ALTER TABLE `inicio_alum`
  MODIFY `Id_Usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `Id_Lote` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `Id_Solicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`Id_Admin`) REFERENCES `inicio_admin` (`Id_Admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`Id_Usuario1`) REFERENCES `inicio_alum` (`Id_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiante_ibfk_2` FOREIGN KEY (`Id_Carrera1`) REFERENCES `carrera` (`Id_Carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante_solicitud`
--
ALTER TABLE `estudiante_solicitud`
  ADD CONSTRAINT `estudiante_solicitud_ibfk_1` FOREIGN KEY (`Id_Solicitud`) REFERENCES `solicitudes` (`Id_Solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiante_solicitud_ibfk_2` FOREIGN KEY (`Id_Estudiante`) REFERENCES `estudiante` (`Id_Estudiante`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`Id`) REFERENCES `administrador` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`Lote`) REFERENCES `lotes` (`Id_Lote`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
