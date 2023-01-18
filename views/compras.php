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
			SELECT c.id, c.fecha, i.producto, c.unidades, c.total, p.nombre
			FROM compras c INNER JOIN inventario i INNER JOIN proveedores p
			INNER JOIN usuarios u ON c.producto_id=i.id AND c.proveedor_id=p.id
			WHERE c.negocio_id={$_SESSION['negocioID']}
			GROUP BY c.id ORDER BY c.fecha DESC
		SQL;
		
		$encabezados = [
			'escritorio' => ['Fecha', 'Producto', 'Unidades', 'Total', 'Proveedor'],
			'movil' => ['Producto', 'Total']
		];
		
		$datos = [
			'camposEscritorio' => ['fecha', 'producto', 'unidades', 'total', 'nombre'],
			'camposMovil' => ['producto', 'total'],
			'filas' => getRegistros($sql)
		];
		
		foreach ($encabezados['escritorio'] as &$encabezado)
			$encabezado = "<small>$encabezado</small>";
		unset($encabezado);
		
		foreach ($datos['filas'] as &$compra):
			$compra['fecha'] = formatearFecha($compra['fecha']);
			
			foreach ($compra as $clave => $valor)
				$compra[$clave] = "<small>$valor</small>";
		endforeach;
		unset($compra);
		
		tabla('Compras', $encabezados, $datos, 'No hay compras registradas');
		
		/*===================================
		=            VER FACTURA            =
		===================================*/
		$titulo = <<<HTML
			<div class="w3-container">
				<img src="images/logo.png" class="w3-margin-right w3-responsive" width="100px">
				Taberna Los 7 Hermanos
			</div>
		HTML;
		$contenido = <<<HTML
			<h3 class="w3-container w3-xlarge w3-right-align w3-blue">Comprobante</h3>
			<div class="w3-margin">
				<h5 class="w3-container w3-xlarge">Datos del proveedor:</h5>
				<table class="w3-table-all">
					<tr></tr>
					<tr>
						<th class="w3-tag w3-blue">Nombre:</th>
						<td>Daniel Mancilla</td>
					</tr>
					<tr>
						<th class="w3-tag w3-blue">RIF:</th>
						<td>v-28.001.002</td>
					</tr>
				</table>
			</div>
			<div class="w3-responsive w3-margin">
				<h5 class="w3-container w3-xlarge">Datos de la compra</h5>
				<table class="w3-table-all w3-centered">
					<tr class="w3-bottombar">
						<th>Cantidad</th>
						<th>Producto</th>
						<th>Precio unitario</th>
						<th>Monto total</th>
					</tr>
					<tr>
						<td>2</td>
						<td>5 Estrellas</td>
						<td>$8</td>
						<td>$17.5</td>
					</tr>
					<tr>
						<td>5</td>
						<td>Macondo</td>
						<td>$9</td>
						<td>$50.36</td>
					</tr>
				</table>
				<div class="w3-container w3-center w3-padding-top-24 w3-large">
					<div class="w3-right">Monto total: <span class="icon-dollar w3-text-green w3-xlarge"></span><b class="w3-xlarge">67.86</b></div>
				</div>
				<div class="w3-row w3-padding-top-48">
					<table class="w3-col s8 w3-container w3-left-align">
						<tr>
							<th>Correo:</th>
							<td> correo@correo.com</td>
						</tr>
						<tr>
							<th>Teléfono:</th>
							<td> <span class="icon-whatsapp w3-text-green"> </span>0557-123-1234</td>
						</tr>
					</table>
					<button class="w3-rest w3-auto w3-button w3-blue w3-round-xlarge">
						<i class="icon-save"></i>
						Guardar
					</button>
				</div>
			</div>
		HTML;
		generarModal('div', 'modalFactura', $titulo, $contenido);
		
		echo '<footer id="botones">' . BOTONES['NUEVA_COMPRA'] . '</footer>';
		echo '</div>';
	else:
		include '../templates/head.php';
		$script .= "<script src='{$BASE_URL}js/restringido.js'></script>";
		include '../templates/footer.php';
	endif;
?>