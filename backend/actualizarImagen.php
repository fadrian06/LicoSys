<?php
	session_start();
	
	require 'conexion.php';
	require 'funciones.php';
	
	if (!empty($_FILES['foto']['name'])):
		$foto = !empty($_FILES['foto']) ? (array) $_FILES['foto'] : ['error' => 4];
		$imagen = '';
		
		if ($foto['error'] !== 4):
			$sql    = "SELECT foto FROM usuarios WHERE id={$_SESSION['userID']}";
			$imagen = (string) getRegistro($sql)['foto'];
			if (!$imagen) $imagen = (string) $foto['name'];
			$tipo   = (string) $foto['type'];
			$peso   = (int) $foto['size'];
			$rutaOrigen = (string) $foto['tmp_name'];
			$rutaDestino = "../images/perfil/$imagen";
			
			$respuesta['datos'] = ['nombre' => $imagen, 'ruta' => $rutaDestino];
			
			if ($tipo !== 'image/jpeg' && $tipo !== 'image/jpg' && $tipo !== 'image/png')
				$respuesta['error'] = 'Sólo se permite imagenes JPG y PNG';
			elseif ($peso > (1 * 1024 * 2048) /*2MB*/)
				$respuesta['error'] = 'La imagen no puede ser mayor a 2MB';
			else move_uploaded_file($rutaOrigen, $rutaDestino);
		endif;
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = "UPDATE usuarios SET foto='$imagen' WHERE id={$_SESSION['userID']}";
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = 'Imagen actualizada exitósamente.';
		$_SESSION['userFoto'] = "images/perfil/$imagen";
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>