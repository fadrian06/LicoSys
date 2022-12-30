<?php
	session_start();
	require 'config.php';
	require 'componentes.php';
	require 'conexion.php';
	require 'funciones.php';
	$respuesta = [
		'error' => '',
		'ok'    => '',
		'datos' => []
	];
	
	if (!empty($_POST['editar'])):
		$tabla = escapar($_POST['tabla']);
		$campo = escapar($_POST['campo']);
		$valor = (int) $_POST['valor'];
		
		$registro = getRegistro("SELECT * FROM $tabla WHERE $campo=$valor");
		
		if (!$registro) $respuesta['error'] = $conexion->error;
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		switch ($tabla):
			case 'clientes':
				$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputNombre = generarINPUT('NOMBRE', $label, 'Nombre del cliente', "{$registro['nombre']}");
				
				$inputID = generarINPUT('ID', '', '', "{$registro['id']}");
				$respuesta['ok'] = <<<HTML
					<div class="w3-right-align">
						<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
					</div>
					<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
						Editar Cliente
					</h1>
					<section class="w3-display-container">
						<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
						$inputID
						$inputNombre
					</section>
					<section class="w3-panel">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Actualizar
						</button>
					</section>
				HTML;
				break;
		endswitch;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	if (!empty($_POST['id'])):
		$id = (int) $_POST['id'];
		$tabla = escapar($_POST['tabla']);
		
		unset($_POST['id']);
		unset($_POST['tabla']);
		
		$camposActualizados = '';
		foreach ($_POST as $clave => $valor):
			$camposActualizados .= is_numeric($valor)
				? "$clave=$valor,"
				: "$clave='$valor',";
		endforeach;
		$camposActualizados[strlen($camposActualizados) - 1] = ' ';
		
		$sql = "UPDATE $tabla SET $camposActualizados WHERE id=$id";
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		switch ($tabla):
			case 'clientes':
				$respuesta['ok'] = 'Cliente ';
				break;
		endswitch;
		
		$respuesta['ok'] .= 'actualizado exitósamente.';
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>