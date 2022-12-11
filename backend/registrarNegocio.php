<?php
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$respuesta = [
			'error' => '',
			'datos' => []
		];
		
		$nombre    = escapar(capitalize($_POST['nombreNegocio']));
		$rif       = escapar(strtoupper($_POST['rif']));
		$telefono  = escapar($_POST['telefono']);
		$direccion = escapar($_POST['direccion']);
		$logo      = (array) $_FILES['logo'];
		$imagen = '';
		
		/*----------  VALIDACIONES  ----------*/
		if (!$nombre or !$rif)
			$respuesta['error'] = 'Por favor rellene los campos';
		
		if ($logo):
			$imagen = (string) $logo['name'];
			$tipo = (string) $logo['type'];
			$peso = (int) $logo['size'];
			$rutaOrigen = (string) $logo['tmp_name'];
			$rutaDestino = '../images/negocios/';
			
			switch ($tipo):
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/png':
					$rutaDestino .= $imagen;
			endswitch;
			
			if (strpos('.jpeg', $rutaDestino))
				$respuesta['error'] = 'Sólo se permite imagenes JPG y PNG';
			
			if ($peso > (1 * 1024 * 2048) /*2MB*/)
				$respuesta['error'] = 'La imagen no puede ser mayor a 2MB';
		endif;
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		move_uploaded_file($rutaOrigen, $rutaDestino);
		$sql = "INSERT INTO negocios VALUES(null, '$nombre', '$rif', '$telefono', '$direccion', '$imagen', 1)";
		$resultado = setRegistro($sql);
		if (!$resultado)
			$respuesta['error'] = $conexion->error;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>