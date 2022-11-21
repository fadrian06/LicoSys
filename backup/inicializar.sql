--
-- Base de datos: `licoreria`
--
CREATE DATABASE IF NOT EXISTS `licoreria` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `licoreria`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compra`
--

CREATE TABLE `carrito_compra` (
  `cod` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nom_p` varchar(255) CHARACTER SET latin1 NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_b` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_total` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_venta`
--

CREATE TABLE `carrito_venta` (
  `cod` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nom_p` varchar(255) CHARACTER SET latin1 NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_b` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `excento` varchar(2) CHARACTER SET latin1 NOT NULL,
  `precio_total` varchar(255) CHARACTER SET latin1 NOT NULL,
  `total_iva` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ci_c` int(11) NOT NULL,
  `cliente` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ci_u` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_c` int(11) NOT NULL,
  `fecha_c` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cod` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `producto` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `unidades` int(11) DEFAULT NULL,
  `precio_c` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `id_p` int(11) DEFAULT NULL,
  `ci_u` int(11) DEFAULT NULL,
  `id_n` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dolar`
--

CREATE TABLE `dolar` (
  `fecha_dolar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dolar` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `cod` varchar(20) CHARACTER SET latin1 NOT NULL,
  `nom_p` varchar(255) CHARACTER SET latin1 NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `excento` varchar(2) CHARACTER SET latin1 DEFAULT NULL,
  `precio_b` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_n` int(11) DEFAULT NULL,
  `ci_u` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE `iva` (
  `fecha_iva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `iva` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `fecha` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ci_u` int(11) DEFAULT NULL,
  `id_n` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocio`
--

CREATE TABLE `negocio` (
  `id_n` int(11) NOT NULL,
  `nom_n` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `rif` varchar(255) CHARACTER SET latin1 NOT NULL,
  `tlf_n` varchar(255) CHARACTER SET latin1 NOT NULL,
  `direccion_n` varchar(255) CHARACTER SET latin1 NOT NULL,
  `foto` varchar(255) CHARACTER SET latin1 NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peso`
--

CREATE TABLE `peso` (
  `fecha_peso` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `peso` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_p` int(11) NOT NULL,
  `proveedor` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ci_u` int(11) DEFAULT NULL,
  `id_n` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ci_u` int(11) NOT NULL,
  `usuario` varchar(20) CHARACTER SET latin1 NOT NULL,
  `nom_u` varchar(30) CHARACTER SET latin1 NOT NULL,
  `clave` varchar(255) CHARACTER SET latin1 NOT NULL,
  `cargo` varchar(1) CHARACTER SET latin1 NOT NULL,
  `tlf` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `pre1` text CHARACTER SET latin1,
  `r1` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `pre2` text CHARACTER SET latin1,
  `r2` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `pre3` text CHARACTER SET latin1,
  `r3` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_v` int(11) NOT NULL,
  `fecha_v` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ci_c` int(11) DEFAULT NULL,
  `cod` varchar(20) CHARACTER SET latin1 NOT NULL,
  `unidades` int(11) DEFAULT NULL,
  `precio_v` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `iva` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ci_u` int(11) DEFAULT NULL,
  `id_n` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de tabla para la tabla `versiones`
--

CREATE TABLE `versiones` (
  `id_v` int(11) NOT NULL,
  `nombre_v` varchar(255) CHARACTER SET latin1 NOT NULL,
  `descripcion` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `versiones`
--

INSERT INTO `versiones` (`id_v`, `nombre_v`, `descripcion`) VALUES
(1, '1.0a', 'Módulo \"Iniciar Sesión\" añadido'),
(2, '1.1a', 'Módulo \"Registrar Usuarios\" añadido'),
(3, '1.2a', 'Correcciones de seguridad'),
(4, '1.3a', 'Nueva interfaz del \"Panel de Administración\"'),
(5, '1.4a', 'Módulos \"Consultar\" y \"Registrar\" añadidos'),
(6, '1.5a', 'Módulo \"Mi perfil\" añadido'),
(7, '1.6a', 'Módulo \"Configuración\" añadido'),
(8, '1.61a', 'Correcciones de seguridad y rendimiento.'),
(9, '1.62a', 'Correcciones de bugs y mejoras de estabilidad.'),
(10, '1.63a', '\"Pie de Página\" del \"Dashboard\" mejorado.'),
(11, '1.7a', 'Solicita \"Registrar Negocio\" en caso que no exista ninguno'),
(12, '1.8a', 'Formularios de Registro ahora son ventanas emergentes'),
(13, '1.81a', 'Solicita \"Registro de Administrador\" en caso de que no exista.'),
(14, '1.82a', 'Mejoras de seguridad, corrección de errores y compatibilidad mejorada'),
(15, '1.9a', 'Posibilidad de \"Desactivar Usuarios\"'),
(16, '1.91a', 'Correcciones de seguridad y estabilidad'),
(17, '1.92a', 'Panel \"Mi Perfil\" ahora implementa ventanas emergentes'),
(18, '2.0a', 'Ahora se puede actualizar el IVA'),
(19, '2.1a', 'Módulo \"Nueva Venta\" completado'),
(20, '2.11a', 'Búsqueda de clientes en \"Nueva Venta\" ahora es por cédula'),
(21, '2.12a', 'Corrección de bugs y mejoras de seguridad'),
(22, '2.2a', 'Registro y actualización de \"Divisas\" añadido'),
(23, '2.21a', 'Se agregaron mensajes emergentes que realizan \"Conversión Monetaria\"'),
(24, '2.3a', 'Módulo \"Compras\" terminado'),
(25, '2.31a', 'Comienza el desarrollo del módulo \"Finanzas\"'),
(26, '2.32a', 'Correcciones de seguridad'),
(27, '2.33a', 'Alertas de \"Producto Agotado\" añadidas'),
(28, '2.4a', 'Integración entre \"DolarToday\" y \"LicoSys\"'),
(29, '2.41a', 'Advertencias de \"Inventario Agotado\" mejoradas'),
(30, '2.5a', 'Posibilidad de actualizar \"Productos\", \"Clientes\" y \"Proveedores\"'),
(31, '2.6a', 'Ya se pueden crear y restaurar respaldo de los datos');

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
-- Indices de la tabla `dolar`
--
ALTER TABLE `dolar`
  ADD PRIMARY KEY (`fecha_dolar`);

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
  ADD KEY `log_ibfk_1` (`ci_u`),
  ADD KEY `id_n` (`id_n`);

--
-- Indices de la tabla `negocio`
--
ALTER TABLE `negocio`
  ADD PRIMARY KEY (`id_n`);

--
-- Indices de la tabla `peso`
--
ALTER TABLE `peso`
  ADD PRIMARY KEY (`fecha_peso`);

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
  ADD PRIMARY KEY (`id_v`) USING BTREE,
  ADD KEY `venta_ibfk_6` (`iva`),
  ADD KEY `venta_ibfk_1` (`ci_c`),
  ADD KEY `venta_ibfk_2` (`ci_u`),
  ADD KEY `venta_ibfk_5` (`id_n`),
  ADD KEY `venta_ibfk_7` (`cod`);

--
-- Indices de la tabla `versiones`
--
ALTER TABLE `versiones`
  ADD PRIMARY KEY (`id_v`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_c` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `negocio`
--
ALTER TABLE `negocio`
  MODIFY `id_n` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_v` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `versiones`
--
ALTER TABLE `versiones`
  MODIFY `id_v` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`ci_u`) REFERENCES `usuario` (`ci_u`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `log_ibfk_2` FOREIGN KEY (`id_n`) REFERENCES `negocio` (`id_n`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `venta_ibfk_7` FOREIGN KEY (`cod`) REFERENCES `inventario` (`cod`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;