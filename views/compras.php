<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/componentes.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		echo LOADER;
		echo '<div id="moduloCompras">';
		
		/*=============================
		=            TABLA            =
		=============================*/
		$sql = <<<SQL
			SELECT c.id, fecha, producto, unidades, total, p.nombre
			FROM compras c INNER JOIN inventario i INNER JOIN proveedores p
			INNER JOIN usuarios u ON producto_id=i.id AND proveedor_id=p.id
			WHERE negocio_id={$_SESSION['negocioID']}
			ORDER BY fecha
		SQL;
		
		$encabezados = [
			'escritorio' => ['Fecha', 'Producto', 'Unidades', 'Total', 'Proveedor'],
			'movil' => ['Producto', 'Total']
		];
		
		$datos = [
			'camposEscritorio' => ['fecha', 'producto', 'unidades', 'total', 'nombre'],
			'movil' => ['producto', 'total'],
			'filas' => getRegistros($sql)
		];
		
		tabla('Compras', $encabezados, $datos, 'No hay compras registradas');
		
		echo '<footer id="botones">' . BOTONES['NUEVA_COMPRA'] . '</footer>';
		echo '</div>';
	else:
		include '../templates/head.php';
		$script .= "<script src='{$BASE_URL}js/restringido.js'></script>";
		include '../templates/footer.php';
	endif;
?>