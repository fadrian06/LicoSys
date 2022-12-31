<?php
	session_start();
	if (!empty($_POST['vaciar'])):
		require 'conexion.php';
		require 'funciones.php';
		
		if (empty($_SESSION['activa']) and $_SESSION['cargo'] !== 'a')
			$respuesta['error'] = 'No tienes los permisos necesarios';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$resultado = setRegistro('TRUNCATE TABLE log');
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = 'Registro vaciado exitósamente.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>