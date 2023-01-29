<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	require '../backend/config.php';
	require '../backend/componentes.php';
	require '../backend/conexion.php';
	require '../backend/funciones.php';
	
	echo LOADER;
	echo '<div id="moduloInventario">';
	
	/*=============================
	=            TABLA            =
	=============================*/
	$sql = <<<SQL
		SELECT i.id, codigo, producto, stock, precio, usuario FROM inventario i
		INNER JOIN usuarios u ON i.usuario_id=u.id
		WHERE i.negocio_id={$_SESSION['negocioID']} ORDER BY producto
	SQL;
	
	$encabezados = [
		'escritorio' => ['Código', 'Producto', 'Existencia', 'Precio', 'Registrado por'],
		'movil' => ['Producto', 'Precio']
	];
	
	$datos = [
		'camposEscritorio' => ['codigo', 'producto', 'stock', 'precio', 'usuario'],
		'camposMovil' => ['producto', 'precio'],
		'filas' => getRegistros($sql)
	];
	
	$editar = [
		'tabla' => 'inventario',
		'campo' => 'id',
		'enlace' => 'views/inventario.php',
		'IDform' => '#editarProducto'
	];
	
	foreach ($datos['filas'] as &$producto):
		$producto['stock'] = $producto['stock'] ?: <<<HTML
			<strong class="w3-text-red">Agotado</strong>
		HTML;
		
		foreach ($producto as $clave => $valor)
			if ($clave !== 'id')
				$producto[$clave] = "<small>$producto[$clave]</small>";
	endforeach;
	unset($producto);
	
	tabla('Inventario', $encabezados, $datos, 'No hay productos registrados', false, $editar);
	
	/*==========================================
	=            REGISTRAR PRODUCTO            =
	==========================================*/
	$label = '<b>Código: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputCodigo = generarINPUT('CODIGO', $label, 'Código del producto');
	$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputNombre = generarINPUT('NOMBRE', $label, 'Nombre del producto');
	$label = '<b>Precio: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputPrecio = generarINPUT('PRECIO', $label, 'Precio base del producto');
	$label = '<b>Excento: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputExcento = generarINPUT('EXCENTO', $label, '¿Excento de IVA?');
	$label = '<b>Existencia: </b><sup class="w3-text-blue">(opcional)</sup>';
	$inputStock = generarINPUT('STOCK', $label, 'Cantidad disponible');
	echo <<<HTML
		<form id="registrarProducto" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
			<div class="w3-right-align">
				<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
			</div>
			<h2 class="w3-center w3-xlarge oswald w3-margin-bottom">
				Registrar Producto
			</h2>
			<section class="w3-display-container">
				<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
				$inputCodigo
				$inputNombre
				$inputPrecio
				$inputExcento
				$inputStock
			</section>
			<section class="w3-panel">
				<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
					Registrar
				</button>
			</section>
		</form>
	HTML;
	
	/*=======================================
	=            REGISTRAR COMBO            =
	=======================================*/
	echo <<<HTML
		<form id="registrarCombo" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
			<div class="w3-right-align">
				<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
			</div>
			<h2 class="w3-center w3-xlarge oswald w3-margin-bottom">
				Registrar Combo
			</h2>
			<section class="w3-display-container">
				<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
			</section>
			<section class="w3-panel">
				<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
					Registrar
				</button>
			</section>
		</form>
	HTML;
	
	/*=======================================
	=            EDITAR PRODUCTO            =
	=======================================*/
	echo <<<HTML
		<form id="editarProducto" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide"></form>
	HTML;
	
	/*==========================================
	=            BOTONES INFERIORES            =
	==========================================*/
	echo '<footer id="botones">' . BOTONES['REGISTRAR_PRODUCTO'] . BOTONES['REGISTRAR_COMBO'] . '</footer>';	
	echo '</div>';
?>