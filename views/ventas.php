<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	require '../backend/config.php';
	require '../backend/componentes.php';
	require '../backend/conexion.php';
	require '../backend/funciones.php';
	
	echo LOADER;
	echo '<div id="moduloVentas">';
	
	/*=============================
	=            TABLA            =
	=============================*/
	$sql = <<<SQL
		SELECT v.id, fecha, c.nombre, i.producto, unidades, total, usuario
		FROM ventas v INNER JOIN clientes c INNER JOIN inventario i INNER JOIN usuarios u
		ON v.cliente_id=c.id AND v.producto_id=i.id AND v.usuario_id=u.id
		WHERE negocio_id={$_SESSION['negocioID']} ORDER BY fecha DESC
	SQL;
	
	$encabezados = [
		'escritorio' => ['Fecha', 'Vendido a', 'Producto', 'Unidades', 'Total', 'Vendido por'],
		'movil' => ['Producto', 'Total']
	];
	
	$datos = [
		'camposEscritorio' => ['fecha', 'nombre', 'producto', 'unidades', 'total', 'usuario'],
		'camposMovil' => ['producto', 'total'],
		'filas' => getRegistros($sql)
	];
	
	tabla('Ventas', $encabezados, $datos, 'No hay ventas registradas');
	
	echo '<footer id="botones">' . BOTONES['NUEVA_VENTA'] . '</footer>';
	echo '</div>';
?>