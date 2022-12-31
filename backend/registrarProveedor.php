<?php
	session_start();
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$rif = escapar($_POST['rif']);
		$nombre = escapar($_POST['nombreNegocio']);
		
		/*====================================
		=            VALIDACIONES            =
		====================================*/
		if (!$rif or !$nombre)
			$respuesta['error'] = 'El RIF y el nombre son requeridos.';
		
		$proveedorEncontrado = consulta("SELECT rif FROM proveedores WHERE rif='$rif'");
		if ($proveedorEncontrado)
			$respuesta['error'] = 'Ya existe un proveedor con ese RIF.';
		/*=====  End of VALIDACIONES  ======*/
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = <<<SQL
			INSERT INTO proveedores(rif, nombre, usuario_id, negocio_id)
			VALUES('$rif', '$nombre', {$_SESSION['userID']}, {$_SESSION['negocioID']})
		SQL;
		
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = 'Proveedor registrado exitósamente.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>