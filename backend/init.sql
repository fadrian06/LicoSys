DROP DATABASE IF EXISTS licosys;
CREATE DATABASE IF NOT EXISTS licosys;
USE licosys;

DROP TABLE IF EXISTS negocios;
CREATE TABLE IF NOT EXISTS negocios (
	id int PRIMARY KEY AUTO_INCREMENT,
	nombre varchar(255) NOT NULL,
	rif varchar(255) NOT NULL,
	tlf varchar(255),
	direccion varchar(255),
	logo varchar(255),
	activo tinyint(1) NOT NULL DEFAULT 1
);

DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios (
	id int PRIMARY KEY AUTO_INCREMENT,
	nombre varchar(255) NOT NULL,
	usuario varchar(255) NOT NULL,
	clave varchar(255) NOT NULL,
	cargo varchar(1) DEFAULT 'v',
	telefono varchar(255),
	foto varchar(255),
	activo tinyint(1) DEFAULT 1,
	pre1 varchar(255),
	pre2 varchar(255),
	pre3 varchar(255),
	res1 varchar(255),
	res2 varchar(255),
	res3 varchar(255)
);

DROP TABLE IF EXISTS versiones;
CREATE TABLE IF NOT EXISTS versiones(
	id int PRIMARY KEY AUTO_INCREMENT,
	nombre varchar(4) NOT NULL,
	descripcion text NOT NULL
);

TRUNCATE TABLE versiones;
INSERT INTO versiones VALUES(1, '1.0a', 'Módulo "Iniciar Sesión" añadido');
INSERT INTO versiones VALUES(2, '1.1a', 'Módulo "Registrar Usuarios" añadido');
INSERT INTO versiones VALUES(3, '1.2a', 'Correcciones de seguridad');
INSERT INTO versiones VALUES(4, '1.3a', 'Nueva interfaz del "Panel de Administración"');
INSERT INTO versiones VALUES(5, '1.4a', 'Módulos "Consultar" y "Registrar" añadidos');
INSERT INTO versiones VALUES(6, '1.5a', 'Módulo "Mi perfil" añadido');
INSERT INTO versiones VALUES(7, '1.6a', 'Módulo "Configuración" añadido');
INSERT INTO versiones VALUES(8, '1.61a', 'Correcciones de seguridad y rendimiento.');
INSERT INTO versiones VALUES(9, '1.62a', 'Correcciones de bugs y mejoras de estabilidad.');
INSERT INTO versiones VALUES(10, '1.63a', '"Pie de Página" del "Dashboard" mejorado.');
INSERT INTO versiones VALUES(11, '1.7a', 'Solicita "Registrar Negocio" en caso que no exista ninguno');
INSERT INTO versiones VALUES(12, '1.8a', 'Formularios de Registro ahora son ventanas emergentes');
INSERT INTO versiones VALUES(13, '1.81a', 'Solicita "Registro de Administrador" en caso de que no exista.');
INSERT INTO versiones VALUES(14, '1.82a', 'Mejoras de seguridad, corrección de errores y compatibilidad mejorada');
INSERT INTO versiones VALUES(15, '1.9a', 'Posibilidad de "Desactivar Usuarios"');
INSERT INTO versiones VALUES(16, '1.91a', 'Correcciones de seguridad y estabilidad');
INSERT INTO versiones VALUES(17, '1.92a', 'Panel "Mi Perfil" ahora implementa ventanas emergentes');
INSERT INTO versiones VALUES(18, '2.0a', 'Ahora se puede actualizar el IVA');
INSERT INTO versiones VALUES(19, '2.1a', 'Módulo "Nueva Venta" completado');
INSERT INTO versiones VALUES(20, '2.11a', 'Búsqueda de clientes en "Nueva Venta" ahora es por cédula');
INSERT INTO versiones VALUES(21, '2.12a', 'Corrección de bugs y mejoras de seguridad');
INSERT INTO versiones VALUES(22, '2.2a', 'Registro y actualización de "Divisas" añadido');
INSERT INTO versiones VALUES(23, '2.21a', 'Se agregaron mensajes emergentes que realizan "Conversión Monetaria"');
INSERT INTO versiones VALUES(24, '2.3a', 'Módulo "Compras" terminado');
INSERT INTO versiones VALUES(25, '2.31a', 'Comienza el desarrollo del módulo "Finanzas"');
INSERT INTO versiones VALUES(26, '2.32a', 'Correcciones de seguridad');
INSERT INTO versiones VALUES(27, '2.33a', 'Alertas de "Producto Agotado" añadidas');
INSERT INTO versiones VALUES(28, '2.4a', 'Integración entre "DolarToday" y "LicoSys"');
INSERT INTO versiones VALUES(29, '2.41a', 'Advertencias de "Inventario Agotado" mejoradas');
INSERT INTO versiones VALUES(30, '2.5a', 'Posibilidad de actualizar "Productos", "Clientes" y "Proveedores"');
INSERT INTO versiones VALUES(31, '2.6a', 'Ya se pueden crear y restaurar respaldo de los datos');