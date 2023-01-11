<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	require '../backend/config.php';
	require '../backend/componentes.php';
	require '../backend/conexion.php';
	require '../backend/funciones.php';
	
	echo LOADER;
	echo '<div id="moduloProveedores">';
	
	/*=============================
	=            TABLA            =
	=============================*/
	$sql = <<<SQL
		SELECT p.id, p.rif, p.nombre, u.usuario FROM proveedores p
		INNER JOIN usuarios u ON p.usuario_id=u.id
		WHERE negocio_id={$_SESSION['negocioID']} ORDER BY p.rif
	SQL;
	
	$encabezados = [
		'escritorio' => ['RIF', 'Nombre', 'Registrado por'],
		'movil' => ['RIF', 'Nombre']
	];
	
	$datos = [
		'camposEscritorio' => ['rif', 'nombre', 'usuario'],
		'camposMovil' => ['rif', 'nombre'],
		'filas' => getRegistros($sql)
	];
	
	$editar = [
		'tabla' => 'proveedores',
		'campo' => 'id',
		'enlace' => 'views/proveedores.php',
		'IDform' => '#editarProveedor'
	];
	
	tabla('Proveedores', $encabezados, $datos, 'No hay proveedores registrados.', false, $editar);
	
	/*===========================================
	=            REGISTRAR PROVEEDOR            =
	===========================================*/
	$label = '<b>RIF: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputRIF = generarINPUT('RIF', $label, 'RIF del proveedor');
	
	$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputNombre = generarINPUT('NOMBRE_NEGOCIO', $label, 'Nombre del proveedor');
	
	echo <<<HTML
		<form id="registrarProveedor" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
			<div class="w3-right-align">
				<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
			</div>
			<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
				Registrar Proveedor
			</h1>
			<section class="w3-display-container">
				<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
				$inputRIF
				$inputNombre
			</section>
			<section class="w3-panel">
				<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
					Registrar
				</button>
			</section>
		</form>
	HTML;
	
	/*========================================
	=            EDITAR PROVEEDOR            =
	========================================*/
	echo <<<HTML
		<form id="editarProveedor" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide"></form>
	HTML;
	
	/*=======================================
	=            BOTÓN REGISTRAR            =
	=======================================*/
	echo '<footer id="botones">' . BOTONES['REGISTRAR_PROVEEDOR'] . '</footer>';
	echo '</div>';
?>