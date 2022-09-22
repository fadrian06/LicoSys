-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2022 a las 13:49:19
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `licoreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ci_c` int(11) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `ci_u` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ci_c`, `cliente`, `ci_u`) VALUES
(18055034, 'Yenni', 28072391),
(25654342, 'Franklin', 28072391),
(29999999, 'Cliente de prueba', 28888888);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_c` int(11) NOT NULL,
  `fecha_c` date DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `u_caja` int(11) DEFAULT NULL,
  `precio_c` decimal(10,2) DEFAULT NULL,
  `id_p` int(11) DEFAULT NULL,
  `ci_u` int(11) DEFAULT NULL,
  `id_n` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_temporales`
--

CREATE TABLE `datos_temporales` (
  `cod` varchar(255) NOT NULL,
  `nom_p` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_b` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos_temporales`
--

INSERT INTO `datos_temporales` (`cod`, `nom_p`, `stock`, `precio_b`, `cantidad`, `precio_total`) VALUES
('ART-01', 'Artículo de Prueba', 12, '4.05', 2, '8.10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `cod` varchar(20) NOT NULL,
  `nom_p` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `excento` varchar(2) DEFAULT NULL,
  `precio_b` decimal(10,2) DEFAULT NULL,
  `id_n` int(11) DEFAULT NULL,
  `ci_u` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`cod`, `nom_p`, `stock`, `excento`, `precio_b`, `id_n`, `ci_u`) VALUES
('ART-01', 'Artículo de Prueba', 12, 'SI', '4.05', 1, 28888888),
('ART-02', 'Artículo de Prueba 2', 23, 'SI', '2.40', 1, 28888888),
('ART-04', 'Artículo de Prueba 4', 6, 'NO', '7.50', 1, 28072391),
('ART-05', 'Artículo de Prueba 5', 8, 'NO', '8.40', 1, 28072391);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE `iva` (
  `fecha_iva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `iva` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `iva`
--

INSERT INTO `iva` (`fecha_iva`, `iva`) VALUES
('2022-07-02 19:36:20', '0.16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ci_u` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`fecha`, `ci_u`) VALUES
('2022-07-04 01:21:27', 28072391),
('2022-07-04 01:42:32', 28072391),
('2022-07-07 00:39:38', 28072391),
('2022-07-10 13:24:21', 28072391),
('2022-07-10 18:49:15', 28072391),
('2022-07-10 20:10:47', 28072391),
('2022-07-10 21:52:32', 28072391),
('2022-07-04 01:20:35', 30000000),
('2022-07-06 21:49:16', 30000000),
('2022-07-09 21:30:57', 30000000),
('2022-07-10 12:08:11', 30000000),
('2022-07-10 13:13:36', 30000000),
('2022-07-10 13:14:36', 30000000),
('2022-07-10 13:15:39', 30000000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocio`
--

CREATE TABLE `negocio` (
  `id_n` int(5) NOT NULL,
  `nom_n` varchar(30) DEFAULT NULL,
  `rif` varchar(10) NOT NULL,
  `tlf_n` varchar(11) NOT NULL,
  `direccion_n` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `negocio`
--

INSERT INTO `negocio` (`id_n`, `nom_n`, `rif`, `tlf_n`, `direccion_n`) VALUES
(1, 'Licoreria Don Ramón', '11111118', '11111111111', 'direccion'),
(2, 'Taberna Los 7 Hermanos', '22222228', '22222222222', 'direccion'),
(3, 'Distribuidora La Gigante', '33333338', '33333333333', 'direccion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_p` int(11) NOT NULL,
  `proveedor` varchar(255) DEFAULT NULL,
  `ci_u` int(11) DEFAULT NULL,
  `id_n` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_p`, `proveedor`, `ci_u`, `id_n`) VALUES
(1, 'Proveedor de Prueba', 28888888, 1),
(3, 'Proveedor de Prueba 2', 28888888, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ci_u` int(11) NOT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  `nom_u` varchar(30) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `cargo` varchar(1) DEFAULT NULL,
  `tlf` varchar(11) NOT NULL,
  `pre1` text NOT NULL,
  `r1` varchar(255) NOT NULL,
  `pre2` text NOT NULL,
  `r2` varchar(255) NOT NULL,
  `pre3` text NOT NULL,
  `r3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ci_u`, `usuario`, `nom_u`, `clave`, `cargo`, `tlf`, `pre1`, `r1`, `pre2`, `r2`, `pre3`, `r3`) VALUES
(28072391, 'franyer', 'Franyer', '$2y$10$A2yXQYH7R9HnEHXAeMbaPueolCKcNUwRdtdxoF6gFp359a6hjYCoK', 'v', '04165335826', '', '', '', '', '', ''),
(28888888, 'admin', 'Admin', '$2y$10$3D7G.dX.dp9FWC2jjdYGru1xZrc.M1qEdYDV7vP7VLP6JAvKhGI.2', 'a', '04165335826', '', '', '', '', '', ''),
(30000000, 'vendedor', 'Vendedor', '$2y$10$q88QHDR4sztVsLMWxB5kCOPvq5y9yF16P2XaEBk3RVD8plUi6ykwe', 'v', '04165335826', '', '', '', '', '', ''),
(30735099, 'yender', 'Yender', '$2y$10$5BCvg6CyGOBpdYU8A2gyCOmNGgYi/P6SC.4BaspUPMxOimiRmwwk6', 'v', '04247357381', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_v` int(11) NOT NULL,
  `fecha_v` date DEFAULT NULL,
  `ci_c` int(11) DEFAULT NULL,
  `cod` varchar(20) NOT NULL,
  `unidades` int(11) DEFAULT NULL,
  `precio_v` decimal(10,2) DEFAULT NULL,
  `fecha_iva` datetime DEFAULT NULL,
  `ci_u` int(11) DEFAULT NULL,
  `id_n` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ci_c`),
  ADD KEY `ci_u` (`ci_u`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_c`),
  ADD KEY `compra_ibfk_3` (`id_n`),
  ADD KEY `compra_ibfk_1` (`id_p`),
  ADD KEY `compra_ibfk_2` (`ci_u`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`cod`),
  ADD KEY `inventario_ibfk_1` (`id_n`),
  ADD KEY `inventario_ibfk_2` (`ci_u`);

--
-- Indices de la tabla `iva`
--
ALTER TABLE `iva`
  ADD PRIMARY KEY (`fecha_iva`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`fecha`),
  ADD KEY `log_ibfk_1` (`ci_u`);

--
-- Indices de la tabla `negocio`
--
ALTER TABLE `negocio`
  ADD PRIMARY KEY (`id_n`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_p`),
  ADD KEY `proveedor_ibfk_1` (`ci_u`),
  ADD KEY `proveedor_ibfk_2` (`id_n`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ci_u`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_v`),
  ADD KEY `venta_ibfk_6` (`fecha_iva`),
  ADD KEY `venta_ibfk_1` (`ci_c`),
  ADD KEY `venta_ibfk_2` (`ci_u`),
  ADD KEY `venta_ibfk_5` (`id_n`),
  ADD KEY `cod` (`cod`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_c` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `negocio`
--
ALTER TABLE `negocio`
  MODIFY `id_n` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_v` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`ci_u`) REFERENCES `usuario` (`ci_u`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_p`) REFERENCES `proveedor` (`id_p`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`ci_u`) REFERENCES `usuario` (`ci_u`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`id_n`) REFERENCES `negocio` (`id_n`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_n`) REFERENCES `negocio` (`id_n`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`ci_u`) REFERENCES `usuario` (`ci_u`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`ci_u`) REFERENCES `usuario` (`ci_u`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`ci_u`) REFERENCES `usuario` (`ci_u`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `proveedor_ibfk_2` FOREIGN KEY (`id_n`) REFERENCES `negocio` (`id_n`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`ci_c`) REFERENCES `cliente` (`ci_c`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`ci_u`) REFERENCES `usuario` (`ci_u`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_5` FOREIGN KEY (`id_n`) REFERENCES `negocio` (`id_n`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_6` FOREIGN KEY (`fecha_iva`) REFERENCES `iva` (`fecha_iva`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `venta_ibfk_7` FOREIGN KEY (`cod`) REFERENCES `inventario` (`cod`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
