SET foreign_key_checks=0;

TRUNCATE TABLE carrito_compra;
TRUNCATE TABLE clientes;
TRUNCATE TABLE compras;
TRUNCATE TABLE dolar;
TRUNCATE TABLE inventario;
TRUNCATE TABLE iva;
TRUNCATE TABLE log;
TRUNCATE TABLE negocios;
INSERT INTO negocios VALUES(1, 'Negocio De Prueba', 'V123456789', '', 'El Pinar, Carretera Panamericana', '', 1);

TRUNCATE TABLE peso;
TRUNCATE TABLE proveedores;
TRUNCATE TABLE usuarios;
INSERT INTO usuarios VALUES(1, 12345678, 'Administrador', 'admin', '$2y$10$DLKP6/vdmZlH7IpbzxKl6.YMs5VpBn8PStM5Ne6P4g6lwuNTAREEe', 'a', '', '', 1, 'No Especificada', 'No Especificada', 'No Especificada', '', '', '');

TRUNCATE TABLE ventas;
TRUNCATE TABLE versiones;
INSERT INTO versiones VALUES(1, '1.0a', 'Módulo "Iniciar Sesión" añadido');

INSERT INTO versiones VALUES(2, '1.1a', 'Módulo "Registrar Usuarios" añadido');

INSERT INTO versiones VALUES(3, '1.2a', 'Correcciones de seguridad');

INSERT INTO versiones VALUES(4, '1.3a', 'Nueva interfaz del "Panel de Administración"');

INSERT INTO versiones VALUES(5, '1.4a', 'Módulos "Consultar" y "Registrar" añadidos');

INSERT INTO versiones VALUES(6, '1.5a', 'Módulo "Mi perfil" añadido');

INSERT INTO versiones VALUES(7, '1.6a', 'Módulo "Configuración" añadido');

INSERT INTO versiones VALUES(8, '1.61', 'Correcciones de seguridad y rendimiento.');

INSERT INTO versiones VALUES(9, '1.62', 'Correcciones de bugs y mejoras de estabilidad.');

INSERT INTO versiones VALUES(10, '1.63', '"Pie de Página" del "Dashboard" mejorado.');

INSERT INTO versiones VALUES(11, '1.7a', 'Solicita "Registrar Negocio" en caso que no exista ninguno');

INSERT INTO versiones VALUES(12, '1.8a', 'Formularios de Registro ahora son ventanas emergentes');

INSERT INTO versiones VALUES(13, '1.81', 'Solicita "Registro de Administrador" en caso de que no exista.');

INSERT INTO versiones VALUES(14, '1.82', 'Mejoras de seguridad, corrección de errores y compatibilidad mejorada');

INSERT INTO versiones VALUES(15, '1.9a', 'Posibilidad de "Desactivar Usuarios"');

INSERT INTO versiones VALUES(16, '1.91', 'Correcciones de seguridad y estabilidad');

INSERT INTO versiones VALUES(17, '1.92', 'Panel "Mi Perfil" ahora implementa ventanas emergentes');

INSERT INTO versiones VALUES(18, '2.0a', 'Ahora se puede actualizar el IVA');

INSERT INTO versiones VALUES(19, '2.1a', 'Módulo "Nueva Venta" completado');

INSERT INTO versiones VALUES(20, '2.11', 'Búsqueda de clientes en "Nueva Venta" ahora es por cédula');

INSERT INTO versiones VALUES(21, '2.12', 'Corrección de bugs y mejoras de seguridad');

INSERT INTO versiones VALUES(22, '2.2a', 'Registro y actualización de "Divisas" añadido');

INSERT INTO versiones VALUES(23, '2.21', 'Se agregaron mensajes emergentes que realizan "Conversión Monetaria"');

INSERT INTO versiones VALUES(24, '2.3a', 'Módulo "Compras" terminado');

INSERT INTO versiones VALUES(25, '2.31', 'Comienza el desarrollo del módulo "Finanzas"');

INSERT INTO versiones VALUES(26, '2.32', 'Correcciones de seguridad');

INSERT INTO versiones VALUES(27, '2.33', 'Alertas de "Producto Agotado" añadidas');

INSERT INTO versiones VALUES(28, '2.4a', 'Integración entre "DolarToday" y "LicoSys"');

INSERT INTO versiones VALUES(29, '2.41', 'Advertencias de "Inventario Agotado" mejoradas');

INSERT INTO versiones VALUES(30, '2.5a', 'Posibilidad de actualizar "Productos", "Clientes" y "Proveedores"');

INSERT INTO versiones VALUES(31, '2.6a', 'Ya se pueden crear y restaurar respaldo de los datos');

