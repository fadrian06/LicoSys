SET foreign_key_checks=0;

TRUNCATE TABLE carrito_compra;
TRUNCATE TABLE carrito_venta;
TRUNCATE TABLE cliente;
INSERT INTO cliente VALUES(30000000, 'Clientedos', 28888888);

INSERT INTO cliente VALUES(40000000, 'Clientetres', 28888888);

TRUNCATE TABLE compra;
INSERT INTO compra VALUES(1, '20-09-2022, 01:05 pm', 'PRO4', 'Producto No Excento', 5, '10', 1, 28888888, 2);

INSERT INTO compra VALUES(2, '10-10-2022, 10:20 am', 'PRO3', 'Producto 3', 4, '5', 1, 28888888, 1);

INSERT INTO compra VALUES(3, '10-10-2022, 10:21 am', 'PRO3', 'Producto 3', 1, '5', 1, 28888888, 1);

INSERT INTO compra VALUES(4, '17-10-2022, 01:24 pm', 'PRO3', 'Producto 4', 5, '4', 3, 28888888, 1);

TRUNCATE TABLE dolar;
INSERT INTO dolar VALUES('2022-09-10 14:52:02', '8.68');

INSERT INTO dolar VALUES('2022-10-13 19:29:12', '8.68');

TRUNCATE TABLE inventario;
INSERT INTO inventario VALUES('PRO3', 'Producto 4', 5, 'NO', 5, 1, 28888888);

INSERT INTO inventario VALUES('PRO4', 'Producto No Excento', 20, 'NO', 10, 1, 28888888);

TRUNCATE TABLE iva;
INSERT INTO iva VALUES('2022-09-10 14:52:02', '0.16');

INSERT INTO iva VALUES('2022-10-13 19:29:11', '0.16');

TRUNCATE TABLE log;
INSERT INTO log VALUES('17-10-2022, 08:58 am', 28072391, 1);

INSERT INTO log VALUES('17-10-2022, 11:00 am', 23892005, 1);

INSERT INTO log VALUES('17-10-2022, 11:01 am', 23892005, 2);

TRUNCATE TABLE negocio;
INSERT INTO negocio VALUES(1, 'Licorería Don Ramón', 'V12345678901', '04165335826', 'El Pinar, Carretera Panamericana', '1.jpeg', 1);

INSERT INTO negocio VALUES(2, 'Taberna Los 7 Hermanos', 'V9239239279', '', 'El Pinar, Carretera Panamericana', '2.jpeg', 1);

INSERT INTO negocio VALUES(3, 'Distribuidora La Gigante', 'E232323232', '', '', '3.jpeg', 1);

INSERT INTO negocio VALUES(4, 'Negocio De Prueba', 'V29429329392', '', '', '', 0);

TRUNCATE TABLE peso;
INSERT INTO peso VALUES('2022-09-10 14:52:02', '4000');

INSERT INTO peso VALUES('2022-10-13 19:29:12', '4000');

TRUNCATE TABLE proveedor;
INSERT INTO proveedor VALUES(1, 'Proveedor1', 28888888, 1);

INSERT INTO proveedor VALUES(2, 'Proveedor2', 28888888, 1);

INSERT INTO proveedor VALUES(3, 'Proveedor4', 28888888, 1);

TRUNCATE TABLE usuario;
INSERT INTO usuario VALUES(23892005, 'emerson', 'Emerson', '$2y$10$0fV9z2EXRghQqd9ECyixSO/VLoRFp1jfwKXznlVfPL9h.rA26/eJ2', 'v', '', '', '', '', '', '', '', '', 1);

INSERT INTO usuario VALUES(28072391, 'franyer', 'Franyer', '$2y$10$bQvLHZqhTWvyJkMcEw0KWubxzgmiW8WdOdJ/qOfjUEVZQv9dCgVDe', 'v', '04165335826', 'Color', '$2y$10$FTa5TgTukhlWbYOlyyg3/uRv0ApcrJ7WGAkMh95s0jNoTbmTELs26', 'Carrera universitaria', '$2y$10$D1/O1I7Lxjb1w.Jtt7X74e7JXavj3zZqBtgzH8Zb3X38eVPdSjjx6', 'Mejor amiga', '$2y$10$9UbaOfKuGaVP5GIKm2rLqugX8kCuhH6nr.5HRMYe4.vO6XlkkNYD2', '28072391.jpeg', 0);

INSERT INTO usuario VALUES(28888888, 'admin', 'Administrador', '$2y$10$nVlRKjkv5BcPPo4lF.XXcefa.QLVVb1UjhXczIpSBiM.Mz8Rkr6VO', 'a', '04165335826', 'pregunta', '$2y$10$3Ii/4o1EkNRikHDKE98z5uFC7dUYi..CG3zpk9MIlpfmtgRLtTPRK', 'pregunta', '$2y$10$ud0H4d2leN7IMfZSfiIbluRkaKFJvPT47g5hHJJlzALxntzWw8O1O', 'pregunta', '$2y$10$jcnCVu2WYGDf2mYE26cUm.DOPAndwR3C4JRz/bzmRDGoIcE4OitJ.', '28888888.jpeg', 1);

TRUNCATE TABLE venta;
INSERT INTO venta VALUES(1, '10-10-2022, 09:31 am', 40000000, 'PRO3', 8, '46.4', '0.16', 28888888, 1);

INSERT INTO venta VALUES(2, '10-10-2022, 09:33 am', 40000000, 'PRO3', 8, '46.4', '0.16', 28888888, 1);

INSERT INTO venta VALUES(3, '17-10-2022, 11:01 am', 30000000, 'PRO3', 10, '50', '0.16', 23892005, 1);

INSERT INTO venta VALUES(4, '17-10-2022, 01:19 pm', 30000000, 'PRO4', 5, '50', '0.16', 28888888, 1);

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

