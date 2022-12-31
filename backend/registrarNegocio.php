<?php
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$nombre    = escapar(capitalize($_POST['nombreNegocio']));
		$rif       = escapar(strtoupper($_POST['rif']));
		$telefono  = escapar($_POST['telefono']);
		$direccion = escapar($_POST['direccion']);
		$logo      = (array) $_FILES['logo'];
		$imagen = '';
		/*----------  VALIDACIONES  ----------*/
		if (!$nombre or !$rif)
			$respuesta['error'] = 'Por favor rellene los campos';
		
		if ($logo['error'] !== 4):
			$imagen = (string) $logo['name'];
			$tipo   = (string) $logo['type'];
			$peso   = (int) $logo['size'];
			$rutaOrigen  = (string) $logo['tmp_name'];
			$rutaDestino = "../images/negocios/$imagen";
			
			if ($tipo !== 'image/jpeg' && $tipo !== 'image/jpg' && $tipo !== 'image/png')
				$respuesta['error'] = "Sólo se permite imagenes JPG y PNG, $tipo";
			elseif ($peso > (1 * 1000 * 1024 * 2)) /*1b * 1000 = 1kb * 1024 = 1mb * 2 = :D*/
				$respuesta['error'] = 'La imagen no puede ser mayor a 2MB';
			else move_uploaded_file($rutaOrigen, $rutaDestino);
		endif;
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = "INSERT INTO negocios VALUES(null, '$nombre', '$rif', '$telefono', '$direccion', '$imagen', 1)";
		$resultado = setRegistro($sql);
		if (!$resultado)
			$respuesta['error'] = $conexion->error;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>