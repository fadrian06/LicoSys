SET foreign_key_checks=0;

TRUNCATE TABLE carrito_compra;
TRUNCATE TABLE carrito_venta;
TRUNCATE TABLE clientes;
INSERT INTO clientes VALUES(3, 40000000, 'No Especificado', 1);

INSERT INTO clientes VALUES(4, 28072391, 'Cliente Uno', 1);

INSERT INTO clientes VALUES(5, 30735099, 'Cliente Dos', 1);

INSERT INTO clientes VALUES(6, 13825355, 'Cliente Tres', 1);

INSERT INTO clientes VALUES(7, 18055034, 'Cliente Cuatro', 1);

TRUNCATE TABLE compras;
INSERT INTO compras VALUES(1, '2023-01-18 23:24:22', 1, 10, 1.00, 10.00, 3, 1, 1);

INSERT INTO compras VALUES(2, '2023-01-18 23:24:36', 4, 20, 0.50, 10.00, 3, 1, 1);

INSERT INTO compras VALUES(3, '2023-01-18 23:50:02', 5, 5, 0.68, 3.40, 1, 1, 1);

INSERT INTO compras VALUES(4, '2023-01-22 20:50:44', 3, 6, 0.30, 1.80, 3, 1, 1);

INSERT INTO compras VALUES(5, '2023-01-22 20:50:44', 2, 5, 2.00, 10.00, 3, 1, 1);

INSERT INTO compras VALUES(6, '2023-01-25 18:46:27', 4, 3, 0.50, 1.50, 3, 1, 1);

TRUNCATE TABLE dolar;
INSERT INTO dolar VALUES('2023-01-18 22:14:02', '21');

INSERT INTO dolar VALUES('2023-01-18 22:14:02', '21');

INSERT INTO dolar VALUES('2023-01-27 12:10:25', '23');

INSERT INTO dolar VALUES('2023-01-28 17:25:43', '24');

TRUNCATE TABLE inventario;
INSERT INTO inventario VALUES(1, 'ART-01', 'Articulo Excento', 10, 1, 1.00, 1, 1);

INSERT INTO inventario VALUES(2, 'ART-02', 'Articulo No Excento', 6, 0, 2.00, 1, 1);

INSERT INTO inventario VALUES(3, 'ART-03', 'Articulo De Prueba', 6, 0, 0.30, 1, 1);

INSERT INTO inventario VALUES(4, 'ART-04', 'Articulo Cuatro', 18, 0, 0.50, 1, 1);

INSERT INTO inventario VALUES(5, 'ART-05', 'Otro Articulo', 20, 0, 0.68, 1, 1);

TRUNCATE TABLE iva;
INSERT INTO iva VALUES('2023-01-18 22:14:02', '0.16');

INSERT INTO iva VALUES('2023-01-18 22:14:02', '0.16');

INSERT INTO iva VALUES('2023-01-27 12:10:25', '0.16');

INSERT INTO iva VALUES('2023-01-28 17:25:43', '0.16');

TRUNCATE TABLE log;
INSERT INTO log VALUES('2023-01-18 22:08:37', 2, 1);

INSERT INTO log VALUES('2023-01-18 22:09:10', 3, 1);

INSERT INTO log VALUES('2023-01-18 22:17:11', 2, 1);

INSERT INTO log VALUES('2023-01-18 22:25:51', 2, 1);

INSERT INTO log VALUES('2023-01-21 11:57:59', 2, 1);

INSERT INTO log VALUES('2023-01-27 11:55:48', 2, 1);

INSERT INTO log VALUES('2023-01-27 12:23:19', 2, 1);

TRUNCATE TABLE negocios;
INSERT INTO negocios VALUES(1, 'Negocio De Pruebas', 'V123456789', '', '', 'fmujSLHP_4x.jpg', 1);

INSERT INTO negocios VALUES(2, 'Negocio Dos', 'V987654321', '', '', '', 1);

INSERT INTO negocios VALUES(3, 'Negocio Tres', 'V543216789', '', '', '', 0);

INSERT INTO negocios VALUES(4, 'Negocio Cuatro', 'V678954321', '', '', '', 0);

TRUNCATE TABLE peso;
INSERT INTO peso VALUES('2023-01-18 22:14:02', '5000');

INSERT INTO peso VALUES('2023-01-18 22:14:03', '5000');

INSERT INTO peso VALUES('2023-01-27 12:10:25', '5000');

INSERT INTO peso VALUES('2023-01-28 17:25:43', '5000');

TRUNCATE TABLE proveedores;
INSERT INTO proveedores VALUES(1, 'V332211556', 'Proveedor Uno', 1, 1);

INSERT INTO proveedores VALUES(2, 'V445356332', 'Proveedor Dos', 1, 1);

INSERT INTO proveedores VALUES(3, 'V282832838', 'Proveedor Tres', 1, 1);

TRUNCATE TABLE usuarios;
INSERT INTO usuarios VALUES(1, 12345678, 'Administrador', 'admin', '$2y$10$Hr4/uUmSAOl1UPa.sLzIUOadn4OSe9/VeW/s.LgrTkdAeSm2K2FOG', 'a', '', '', 1, 'pregunta', 'pregunta', 'pregunta', '$2y$10$IZTYHAFyFEta8JqO3dTejueDVQYINwhJJzphT4amDMn4TSYb0xdGG', '$2y$10$xb0RjC2NjxuwrksQbSbJ2OBR5Bon10Ua4D31HXKRGxR/jHLpX/BZO', '$2y$10$roKPIvvk4DuFKK9Nb.tH5ekOZhYFhdKYk.zKSPJiIZ9x2J/LSOQXO');

INSERT INTO usuarios VALUES(2, 28072391, 'Usuario Uno', 'user1', '$2y$10$ak4SLYHZdLU47AtheVRh0.LfzdmBNAS.0rh5amsUgBpz8n3BpgNdq', 'v', '', '', 1, '', '', '', '', '', '');

INSERT INTO usuarios VALUES(3, 30735099, 'Usuario Dos', 'user2', '$2y$10$ahbWkF.e050T/gZZ7QkRSOsPZgDffan5YXMQjTVmkKmSqc46T9y/m', 'v', '', '', 0, '', '', '', '', '', '');

TRUNCATE TABLE ventas;
INSERT INTO ventas VALUES(1, '2023-01-18 22:14:23', 3, 4, 3, 1.50, 0.16, 1, 1);

INSERT INTO ventas VALUES(2, '2023-01-18 22:14:34', 3, 1, 7, 8.12, 0.16, 1, 1);

INSERT INTO ventas VALUES(3, '2023-01-18 22:14:44', 3, 2, 4, 8.00, 0.16, 1, 1);

INSERT INTO ventas VALUES(4, '2023-01-18 22:15:01', 3, 5, 6, 4.08, 0.16, 1, 1);

INSERT INTO ventas VALUES(5, '2023-01-18 23:10:15', 6, 1, 3, 3.48, 0.16, 1, 1);

INSERT INTO ventas VALUES(6, '2023-01-25 18:46:08', 3, 4, 5, 2.50, 0.16, 1, 1);

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

INSERT INTO versiones VALUES(32, '3.0a', 'Nuevo LicoSys, nueva y renovada interfaz para una mejor experiencia de usuario.');

INSERT INTO versiones VALUES(33, '3.1a', 'Todas las fechas ahora cuentan con mejor presentación y legibilidad.');

INSERT INTO versiones VALUES(34, '3.2a', 'Nueva "Calculadora Monetaria"');

INSERT INTO versiones VALUES(35, '3.3a', 'Gráfica de Productos más Vendidos añadida.');

INSERT INTO versiones VALUES(36, '3.4a', '"Conversión Monetaria" ahora acepta operaciones básicas.
Tooltips en botones añadidos.');

INSERT INTO versiones VALUES(37, '3.5a', 'LicoSys genera facturas de ventas en PDF.');

