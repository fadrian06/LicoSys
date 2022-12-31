<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	require '../backend/config.php';
	require '../backend/componentes.php';
	require '../backend/conexion.php';
	require '../backend/funciones.php';
	
	echo LOADER;
	echo '<div id="moduloClientes">';
	
	/*=============================
	=            TABLA            =
	=============================*/
	$sql = <<<SQL
		SELECT c.cedula, c.nombre, u.usuario FROM clientes c
		INNER JOIN usuarios u ON c.usuario_id=u.id
	SQL;
	
	$encabezados = [
		'escritorio' => ['C.I', 'Nombre', 'Registrado por'],
		'movil' => ['C.I', 'Nombre']
	];
	
	$datos = [
		'camposEscritorio' => ['cedula', 'nombre', 'usuario'],
		'camposMovil' => ['cedula', 'nombre'],
		'filas' => getRegistros($sql)
	];
	
	$editar = [
		'tabla' => 'clientes',
		'campo' => 'cedula',
		'enlace' => 'views/clientes.php',
		'IDform' => '#editarCliente'
	];
	
	tabla('Clientes', $encabezados, $datos, 'No hay clientes registrados.', false, $editar);
	
	/*=========================================
	=            REGISTRAR CLIENTE            =
	=========================================*/
	$label = '<b>Cédula: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputCedula = generarINPUT('CEDULA', $label, 'Cédula del cliente');
	
	$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputNombre = generarINPUT('NOMBRE', $label, 'Nombre del cliente');
	
	echo <<<HTML
		<form id="registrarCliente" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
			<div class="w3-right-align">
				<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
			</div>
			<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
				Registrar Cliente
			</h1>
			<section class="w3-display-container">
				<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
				$inputCedula
				$inputNombre
			</section>
			<section class="w3-panel">
				<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
					Registrar
				</button>
			</section>
		</form>
	HTML;
		
	/*======================================
	=            EDITAR CLIENTE            =
	======================================*/
	echo <<<HTML
		<form id="editarCliente" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide"></form>
	HTML;
	
	/*=======================================
	=            BOTÓN REGISTRAR            =
	=======================================*/
	echo '<footer id="botones">' . BOTONES['REGISTRAR_CLIENTE'] . '</footer>';
	echo '</div>'
?>