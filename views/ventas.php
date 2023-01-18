<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	require '../backend/config.php';
	require '../backend/componentes.php';
	require '../backend/conexion.php';
	require '../backend/funciones.php';
	
	/*=========================================
	=            CONSULTAR FACTURA            =
	=========================================*/
	if (!empty($_GET['ventaID'])):
		$ventaID = (int) escapar($_GET['ventaID']);
		
		$sql = <<<SQL
			SELECT n.nombre as nombreNegocio, n.tlf, n.direccion,
			c.nombre as nombreCliente, c.cedula, v.unidades,
			i.producto, i.precio, v.total
			FROM ventas v INNER JOIN negocios n INNER JOIN clientes c
			INNER JOIN inventario i
			ON v.negocio_id=n.id AND v.cliente_id=c.id AND v.producto_id=i.id
			WHERE v.id=$ventaID
		SQL;
		
		$datos = getRegistro($sql);
		
		if (!$datos) $respuesta['error'] = $conexion->error;
		
		$respuesta['datos'] = [
			'nombreNegocio'    => $datos['nombreNegocio'],
			'telefonoNegocio'  => $datos['tlf'],
			'direccionNegocio' => $datos['direccion'],
			'nombreCliente'    => $datos['nombreCliente'],
			'cedulaCliente'    => $datos['cedula'],
			'cantidad' => $datos['unidades'],
			'producto' => $datos['producto'],
			'precio'   => $datos['precio'],
			'total'    => $datos['total'],
			'iva'      => getIVA()
		];
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;	
	
	echo LOADER;
	echo '<div id="moduloVentas">';
	
	/*=============================
	=            TABLA            =
	=============================*/
	$sql = <<<SQL
		SELECT v.id, fecha, c.nombre, i.producto, unidades, total, usuario
		FROM ventas v INNER JOIN clientes c INNER JOIN inventario i INNER JOIN usuarios u
		ON v.cliente_id=c.id AND v.producto_id=i.id AND v.usuario_id=u.id
		WHERE v.negocio_id={$_SESSION['negocioID']} ORDER BY fecha DESC
	SQL;
	
	$encabezados = [
		'escritorio' => ['Fecha', 'Vendido a', 'Producto', 'Unidades', 'Total', 'Vendedor'],
		'movil' => ['Producto', 'Total']
	];
	
	$datos = [
		'camposEscritorio' => ['fecha', 'nombre', 'producto', 'unidades', 'total', 'usuario'],
		'camposMovil' => ['producto', 'total'],
		'filas' => getRegistros($sql)
	];
	
	foreach ($encabezados['escritorio'] as &$encabezado)
		$encabezado = "<small>$encabezado</small>";
	unset($encabezado);
	
	foreach ($datos['filas'] as &$venta):
		$venta['fecha'] = formatearFecha($venta['fecha']);
		
		foreach ($venta as $clave => $valor)
			$venta[$clave] = $valor === 'No Especificado'
				? ''
				: "<small>$valor</small>";
	endforeach;
	unset($venta);
	
	tabla('Ventas', $encabezados, $datos, 'No hay ventas registradas', false, false, true);
	
	/*===================================
	=            VER FACTURA            =
	===================================*/
	generarModal('div', 'modalFactura', '', '');
		
	echo '<footer id="botones">' . BOTONES['NUEVA_VENTA'] . '</footer>';
	echo '</div>';
?>