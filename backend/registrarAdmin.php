<?php
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$respuesta = [
			'error' => '',
			'datos' => []
		];
		
		$cedula    = (int) $_POST['cedula'];
		$nombre    = escapar(capitalize($_POST['nombre']));
		$usuario   = escapar($_POST['usuario']);
		$clave     = escapar($_POST['clave']);
		$confirmar = escapar($_POST['confirmar']);
		$telefono  = escapar($_POST['telefono']);
		$foto      = (array) $_FILES['foto'];
		$imagen = '';
		
		/*----------  VALIDACIONES  ----------*/
		if (!$cedula or !$nombre or !$usuario or !$clave or !$confirmar)
			$respuesta['error'] = 'Por favor rellene los campos';
		
		if ($clave !== $confirmar)
			$respuesta['error'] = 'Ambas contraseñas deben ser iguales.';
		
		if ($foto['error'] !== 4):
			$imagen = (string) $foto['name'];
			$tipo   = (string) $foto['type'];
			$peso   = (int) $foto['size'];
			$rutaOrigen = (string) $foto['tmp_name'];
			$rutaDestino = "../images/perfil/$imagen";
			
			if ($tipo !== 'image/jpeg' && $tipo !== 'image/jpg' && $tipo !== 'image/png')
				$respuesta['error'] = 'Sólo se permite imagenes JPG y PNG';
			elseif ($peso > (1 * 1024 * 2048) /*2MB*/)
				$respuesta['error'] = 'La imagen no puede ser mayor a 2MB';
			else move_uploaded_file($rutaOrigen, $rutaDestino);
		endif;
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$clave = encriptar($clave);
		$sql = "INSERT INTO usuarios(
			cedula, nombre, usuario, clave, cargo, telefono, foto, activo
		) VALUES(
			$cedula, '$nombre', '$usuario', '$clave', 'a', '$telefono', '$imagen', 1
		)";
		$resultado = setRegistro($sql);
		if (!$resultado)
			$respuesta['error'] = $conexion->error;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>