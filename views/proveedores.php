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
		SELECT p.id, p.nombre, p.rif, p.nombreEmpresa, p.telefono,
		p.direccion FROM proveedores p INNER JOIN usuarios u
		ON p.usuario_id=u.id WHERE negocio_id={$_SESSION['negocioID']} ORDER BY p.rif
	SQL;
	
	$encabezados = [
		'escritorio' => ['Contacto', 'RIF', 'Proveedor', 'Teléfono', 'Dirección'],
		'movil' => ['RIF', 'Proveedor']
	];
	
	$datos = [
		'camposEscritorio' => ['nombre', 'rif', 'nombreEmpresa', 'telefono', 'direccion'],
		'camposMovil' => ['rif', 'nombreEmpresa'],
		'filas' => getRegistros($sql)
	];
	
	$editar = [
		'tabla' => 'proveedores',
		'campo' => 'id',
		'enlace' => 'views/proveedores.php',
		'IDform' => '#editarProveedor'
	];
	
	foreach ($encabezados['escritorio'] as &$encabezado)
		$encabezado = "<small>$encabezado</small>";
	unset($encabezado);
	
	foreach ($datos['filas'] as &$proveedor)
		foreach ($proveedor as $clave => $valor)
			if ($clave !== 'id') $proveedor[$clave] = "<small>$valor</small>";
	unset($proveedor);
	
	tabla('Proveedores', $encabezados, $datos, 'No hay proveedores registrados.', false, $editar);
	
	/*===========================================
	=            REGISTRAR PROVEEDOR            =
	===========================================*/
	$label = '<b>Cédula: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputCedula = generarINPUT('CEDULA', $label, 'Cédula de persona');
	
	$label = '<b>Nombre: </b><sup class="w3-text-red">(requirido)</sup>';
	$inputNombre = generarINPUT('NOMBRE', $label, 'Nombre de persona');
	
	$label = '<b>RIF: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputRIF = generarINPUT('RIF', $label, 'RIF del proveedor');
	
	$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
	$inputNombreEmpresa = generarINPUT('NOMBRE_NEGOCIO', $label, 'Nombre del proveedor');
	
	$label = '<b>Teléfono: </b><sup class="w3-text-blue">(opcional)</sup>';
	$inputTelefono = generarINPUT('TELEFONO', $label, 'Teléfono de contacto');
	
	$label = '<b>Dirección: </b><sup class="w3-text-blue">(opcional)</sup>';
	$inputDireccion = generarINPUT('DIRECCION', $label, 'Direccion del proveedor');
	
	echo <<<HTML
		<form id="registrarProveedor" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
			<div class="w3-right-align">
				<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
			</div>
			<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
				Registrar Proveedor
			</h1>
			<section class="w3-display-container w3-row-padding">
				<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
				<div class="w3-half w3-bottombar w3-topbar">
					<h2 class="w3-container w3-large"><b>Datos de persona de contacto</b></h2>
					$inputCedula
					$inputNombre
				</div>
				<div class="w3-half w3-bottombar w3-topbar">
					<h2 class="w3-container w3-large"><b>Datos del proveedor</b></h2>
					$inputRIF
					$inputNombreEmpresa
					$inputTelefono
					$inputDireccion
				</div>
			</section>
			<section class="w3-panel" style="width: 50%; margin-left: auto; margin-right: auto">
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