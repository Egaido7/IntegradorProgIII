-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2024 a las 23:50:19
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
-- Base de datos: `very_deli`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `idCalificacion` int(11) NOT NULL,
  `idCalifica` int(11) NOT NULL,
  `puntaje` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `idCalificado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `idLocalidad` int(11) NOT NULL,
  `Nombrelocalidad` varchar(100) NOT NULL,
  `idProvincia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`idLocalidad`, `Nombrelocalidad`, `idProvincia`) VALUES
(1, 'La Plata', 1),
(2, 'Mar del Plata', 1),
(3, 'Bahía Blanca', 1),
(4, 'San Fernando del Valle de Catamarca', 2),
(5, 'Belén', 2),
(6, 'Tinogasta', 2),
(7, 'Resistencia', 3),
(8, 'Charata', 3),
(9, 'Saenz Peña', 3),
(10, 'Rawson', 4),
(11, 'Trelew', 4),
(12, 'Comodoro Rivadavia', 4),
(13, 'Balvanera', 5),
(14, 'San Telmo', 5),
(15, 'Puerto Madero', 5),
(16, 'Córdoba', 6),
(17, 'Villa Carlos Paz', 6),
(18, 'Río Cuarto', 6),
(19, 'Corrientes', 7),
(20, 'Goya', 7),
(21, 'Resistencia', 7),
(22, 'Paraná', 8),
(23, 'Concordia', 8),
(24, 'Gualeguaychú', 8),
(25, 'Formosa', 9),
(26, 'Pirané', 9),
(27, 'Clorinda', 9),
(28, 'San Salvador de Jujuy', 10),
(29, 'Palpala', 10),
(30, 'Perico', 10),
(31, 'Santa Rosa', 11),
(32, 'General Pico', 11),
(33, 'Toay', 11),
(34, 'La Rioja', 12),
(35, 'Chilecito', 12),
(36, 'Villa Unión', 12),
(37, 'Mendoza', 13),
(38, 'San Rafael', 13),
(39, 'Tunuyán', 13),
(40, 'Posadas', 14),
(41, 'Oberá', 14),
(42, 'Eldorado', 14),
(43, 'Neuquén', 15),
(44, 'Plottier', 15),
(45, 'San Martín de los Andes', 15),
(46, 'Viedma', 16),
(47, 'Roca', 16),
(48, 'Cipolletti', 16),
(49, 'Salta', 17),
(50, 'Rosario de la Frontera', 17),
(51, 'Orán', 17),
(52, 'San Juan', 18),
(53, 'Albardón', 18),
(54, 'Rivadavia', 18),
(55, 'San Luis', 19),
(56, 'Villa Mercedes', 19),
(57, 'Justo Daract', 19),
(58, 'Río Gallegos', 20),
(59, 'El Calafate', 20),
(60, 'Pico Truncado', 20),
(61, 'Santa Fe', 21),
(62, 'Rosario', 21),
(63, 'Rafaela', 21),
(64, 'Santiago del Estero', 22),
(65, 'La Banda', 22),
(66, 'Termas de Río Hondo', 22),
(67, 'Ushuaia', 23),
(68, 'Rio Grande', 23),
(69, 'Tolhuin', 23),
(70, 'San Miguel de Tucumán', 24),
(71, 'Yerba Buena', 24),
(72, 'Tafí del Valle', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `idUsuario` int(11) NOT NULL,
  `idPublicacion` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fechaComentario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`idUsuario`, `idPublicacion`, `comentario`, `fechaComentario`) VALUES
(1, 4, 'este es un comentario', '2024-11-09 17:56:53'),
(1, 4, 'otro comentario', '2024-11-09 18:36:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulacion`
--

CREATE TABLE `postulacion` (
  `idPostulacion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `monto` float NOT NULL,
  `idPublicacion` int(11) NOT NULL,
  `alerta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `postulacion`
--

INSERT INTO `postulacion` (`idPostulacion`, `idUsuario`, `monto`, `idPublicacion`, `alerta`) VALUES
(1, 1, 1000, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `idProvincia` int(11) NOT NULL,
  `nombreProvincia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`idProvincia`, `nombreProvincia`) VALUES
(1, 'Buenos Aires'),
(2, 'Catamarca'),
(3, 'Chaco'),
(4, 'Chubut'),
(5, 'CABA'),
(6, 'Córdoba'),
(7, 'Corrientes'),
(8, 'Entre Ríos'),
(9, 'Formosa'),
(10, 'Jujuy'),
(11, 'La Pampa'),
(12, 'La Rioja'),
(13, 'Mendoza'),
(14, 'Misiones'),
(15, 'Neuquén'),
(16, 'Río Negro'),
(17, 'Salta'),
(18, 'San Juan'),
(19, 'San Luis'),
(20, 'Santa Cruz'),
(21, 'Santa Fe'),
(22, 'Santiago del Estero'),
(23, 'Tierra del Fuego'),
(24, 'Tucumán');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `idPublicacion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `volumen` float NOT NULL,
  `peso` float NOT NULL,
  `provinciaOrigen` varchar(40) NOT NULL,
  `provinciaDestino` varchar(40) NOT NULL,
  `fechaPublicacion` date NOT NULL,
  `imagenPublicacion` varchar(40) NOT NULL,
  `descripcion` text NOT NULL,
  `contacto` varchar(30) NOT NULL,
  `postulanteElegido` int(11) NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `estado` int(11) NOT NULL,
  `localidadOrigen` varchar(50) NOT NULL,
  `localidadDestino` varchar(50) NOT NULL,
  `domicilioOrigen` varchar(50) NOT NULL,
  `domicilioDestino` varchar(50) NOT NULL,
  `nombreRecibir` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idPublicacion`, `idUsuario`, `volumen`, `peso`, `provinciaOrigen`, `provinciaDestino`, `fechaPublicacion`, `imagenPublicacion`, `descripcion`, `contacto`, `postulanteElegido`, `titulo`, `estado`, `localidadOrigen`, `localidadDestino`, `domicilioOrigen`, `domicilioDestino`, `nombreRecibir`) VALUES
(4, 1, 100, 200, 'san luis', 'la punta', '2024-11-07', 'imagenes/termostanley.webp', 'es un objeto muy bonito', 'ola01@gmail.com', 0, 'objeto bonito', 0, '', '', '', '', ''),
(6, 1, 10, 3, 'San Luis', 'San Luis', '2024-11-10', 'imagenes/publicacionDefault.jpg', 'botines nike en caja', '2664546384', 0, 'botines nike', 0, 'San Luis', 'Villa Mercedes', 'calle 3 sur', 'calle angosta 212', 'uriel gomez'),
(7, 1, 10, 2, 'Buenos Aires', 'NeuquÃ©n', '2024-11-10', 'imagenes/publicacionDefault.jpg', 'maquina de cortar el pelo', '2664721223', 0, 'patillera suono', 0, 'La Plata', 'San MartÃ­n de los Andes', 'laplata2025', 'barilochepromo2021', 'juaquin munoz'),
(8, 1, 10, 4, 'La Rioja', 'Corrientes', '2024-11-10', 'imagenes/publicacionDefault.jpg', 'termo stanley de 1lts', '2664339196', 0, 'termo stanley', 0, 'La Rioja', 'Goya', 'rioseco1212', 'desiertosahara21', 'emiliano gaido'),
(9, 1, 100, 25, 'Tierra del Fuego', 'Chaco', '2024-11-10', 'imagenes/67313163268a1_bici.jpg', 'bicicleta raleigh rodado 29 7 cambios', '2664546384', 0, 'bicicleta raleigh', 0, 'Ushuaia', 'Saenz PeÃ±a', 'eliglu2012', 'pomberito2', 'uriel gomez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `dni` int(11) NOT NULL,
  `responsable` tinyint(1) NOT NULL,
  `email` varchar(40) NOT NULL,
  `domicilio` varchar(50) NOT NULL,
  `codPostal` int(11) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `dni`, `responsable`, `email`, `domicilio`, `codPostal`, `contraseña`, `imagen`) VALUES
(1, 'joaquin', 'muñoz', 45802248, 1, 'joaquinemunoz04@gmail.com', 'casa', 1234, '131231231231312312312313231231231231231231231231', 'e054903e6671684eff1264dc3ee6ec46.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `patente` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`patente`, `idUsuario`, `modelo`, `categoria`) VALUES
(1234, 1, 'aas', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`idCalificacion`),
  ADD KEY `idCalifica` (`idCalifica`,`idCalificado`),
  ADD KEY `idCalificado` (`idCalificado`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`idLocalidad`),
  ADD KEY `idProvincia` (`idProvincia`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD KEY `idUsuario` (`idUsuario`,`idPublicacion`),
  ADD KEY `idPublicacion` (`idPublicacion`);

--
-- Indices de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD PRIMARY KEY (`idPostulacion`),
  ADD KEY `idUsuario` (`idUsuario`,`idPublicacion`),
  ADD KEY `idPublicacion` (`idPublicacion`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`idProvincia`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idPublicacion`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `contraseña` (`contraseña`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idUsuario_2` (`idUsuario`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`patente`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `idCalificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `idLocalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  MODIFY `idPostulacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `idProvincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idPublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `calificacion_ibfk_1` FOREIGN KEY (`idCalifica`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calificacion_ibfk_2` FOREIGN KEY (`idCalificado`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `localidad_ibfk_1` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`idProvincia`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `mensaje_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensaje_ibfk_2` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD CONSTRAINT `postulacion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `postulacion_ibfk_2` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
