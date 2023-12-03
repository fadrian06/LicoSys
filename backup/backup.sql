SET foreign_key_checks=0;

TRUNCATE TABLE carrito_compra;
TRUNCATE TABLE carrito_venta;
TRUNCATE TABLE clientes;
INSERT INTO clientes VALUES(3, 40000000, 'No Especificado', 1);

INSERT INTO clientes VALUES(4, 28072391, 'Franyer', 1);

INSERT INTO clientes VALUES(5, 30735099, 'Yender', 1);

INSERT INTO clientes VALUES(6, 13825355, 'Franklin', 1);

INSERT INTO clientes VALUES(7, 18055034, 'Yenni', 1);

TRUNCATE TABLE compras;
TRUNCATE TABLE dolar;
INSERT INTO dolar VALUES('2023-12-03 16:00:49', '36');

TRUNCATE TABLE inventario;
INSERT INTO inventario VALUES(1, 'ART-01', 'Articulo Uno', 0, 1, 1.00, 1, 1);

INSERT INTO inventario VALUES(2, 'ART-02', 'Articulo Dos', 0, 0, 2.00, 1, 1);

INSERT INTO inventario VALUES(3, 'ART-03', 'Articulo Tres', 0, 0, 3.00, 1, 1);

INSERT INTO inventario VALUES(4, 'ART-04', 'Articulo Cuatro', 0, 1, 4.00, 1, 1);

INSERT INTO inventario VALUES(5, 'ART-05', 'Articulo Cinco', 0, 0, 5.00, 1, 1);

TRUNCATE TABLE iva;
INSERT INTO iva VALUES('2023-12-03 16:00:49', '0.16');

TRUNCATE TABLE log;
TRUNCATE TABLE negocios;
INSERT INTO negocios VALUES(1, 'Negocio De Pruebas', 'V280723911', '+584165335826', 'El Pinar, Estado Mérida', '', 1);

TRUNCATE TABLE peso;
INSERT INTO peso VALUES('2023-12-03 16:00:49', '4000');

TRUNCATE TABLE proveedores;
INSERT INTO proveedores VALUES(1, 28072391, 'Franyer', 'V280723911', 'Proveedor Uno', '+584165335826', 'El Pinar, Estado Mérida', 1, 1);

INSERT INTO proveedores VALUES(2, 30735099, 'Yender', 'V307350999', 'Proveedor Dos', '', 'El Pinar, Estado Mérida', 1, 1);

INSERT INTO proveedores VALUES(3, 18055034, 'Yenni', 'V180550344', 'Proveedor Tres', '04247542450', 'El Pinar, Estado Mérida', 1, 1);

INSERT INTO proveedores VALUES(4, 13825355, 'Franklin', 'V138253555', 'Proveedor Cuatro', '', 'El Pinar, Estado Mérida', 1, 1);

TRUNCATE TABLE usuarios;
INSERT INTO usuarios VALUES(1, 28072391, 'Franyer', 'fadrian06', '$2y$10$SBRglToaA5XR9p5pvz1.SO3xKdp1R3nzU8qat/XubK33beI8xOT2.', 'a', '+584165335826', '', 1, 'No Especificada', 'No Especificada', 'No Especificada', '', '', '');

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

INSERT INTO versiones VALUES(32, '3.0a', 'Nuevo LicoSys, nueva y renovada interfaz para una mejor experiencia de usuario.');

INSERT INTO versiones VALUES(33, '3.1a', 'Todas las fechas ahora cuentan con mejor presentación y legibilidad.');

INSERT INTO versiones VALUES(34, '3.2a', 'Nueva "Calculadora Monetaria"');

INSERT INTO versiones VALUES(35, '3.3a', 'Gráfica de Productos más Vendidos añadida.');

INSERT INTO versiones VALUES(36, '3.4a', '"Conversión Monetaria" ahora acepta operaciones básicas. Tooltips en botones añadidos.');

INSERT INTO versiones VALUES(37, '3.5a', 'LicoSys genera facturas de ventas en PDF.');

INSERT INTO versiones VALUES(38, '3.6a', 'Ampliado el módulo "Proveedores". Correcciones de seguridad.');

