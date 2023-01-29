<?php
	session_start();
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$cedula = (int) $_POST['cedula'];
		$nombrePersona = escapar($_POST['nombre']);
		$rif = escapar($_POST['rif']);
		$nombreEmpresa = escapar($_POST['nombreNegocio']);
		$telefono = escapar($_POST['telefono']);
		$direccion = escapar(capitalize($_POST['direccion']));
		
		/*====================================
		=            VALIDACIONES            =
		====================================*/
		if (!$cedula or !$nombrePersona)
			$respuesta['error'] = 'Los datos de persona de contacto son requeridos.';
		
		if (!$rif or !$nombreEmpresa)
			$respuesta['error'] = 'El RIF y el nombre de empresa son requeridos.';
		
		$proveedorEncontrado = consulta("SELECT rif FROM proveedores WHERE rif='$rif'");
		if ($proveedorEncontrado)
			$respuesta['error'] = 'Ya existe un proveedor con ese RIF.';
		/*=====  End of VALIDACIONES  ======*/
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = <<<SQL
			INSERT INTO proveedores(cedula, nombre, rif, nombreEmpresa,
				telefono, direccion, usuario_id, negocio_id
			) VALUES($cedula, '$nombrePersona', '$rif', '$nombreEmpresa', '$telefono',
				'$direccion', {$_SESSION['userID']}, {$_SESSION['negocioID']}
			)
		SQL;
		
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = 'Proveedor registrado exitósamente.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>