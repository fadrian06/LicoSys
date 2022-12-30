<?php
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$respuesta = [
			'ok'    => '',
			'error' => '',
			'datos' => []
		];
		
		/** @var string La tabla a la que pertenece el registro. */
		$tabla = escapar($_POST['tabla']);
		/** @var string Campo que identifica cada registro. */
		$campo = escapar($_POST['campo']);
		/** @var string Valor único de cada registro. */
		$valor = (int) escapar($_POST['valor']);
		/** @var string 'activar' | 'desactivar' */
		$accion = escapar($_POST['accion']);
		
		switch ($tabla):
			case 'usuarios':
				$respuesta['ok'] = 'Usuario ';
				break;
		endswitch;
		
		switch ($accion):
			case 'activar':
				$sql = "UPDATE $tabla SET activo=1 WHERE $campo=$valor";
				$respuesta['ok'] .= 'activado exitósamente.';
				break;
			case 'desactivar':
				$sql = "UPDATE $tabla SET activo=0 WHERE $campo=$valor";
				$respuesta['ok'] .= 'desactivado exitósamente.';
				break;
			default:
				$respuesta['error'] = "Por favor envie una opción ('activar' o 'desactivar')";
		endswitch;
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$resultado = setRegistro($sql);
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>