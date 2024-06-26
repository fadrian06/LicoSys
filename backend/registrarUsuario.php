<?php
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$cedula    = (int) $_POST['cedula'];
		$nombre    = escapar(capitalize($_POST['nombre']));
		$usuario   = escapar($_POST['usuario']);
		$clave     = escapar($_POST['clave']);
		$confirmar = escapar($_POST['confirmar']);
		$telefono  = escapar($_POST['telefono']);
		$cargo     = (string) $_POST['cargo'];
		$foto      = !empty($_FILES['foto']) ? (array) $_FILES['foto'] : ['error' => 4];
		$imagen = '';
		
		/*----------  VALIDACIONES  ----------*/
		if (!$cedula or !$nombre or !$usuario or !$clave or !$confirmar)
			$respuesta['error'] = 'Por favor rellene los campos';
		
		if ($clave !== $confirmar)
			$respuesta['error'] = 'Ambas contraseñas deben ser iguales.';
		
		$sql = <<<SQL
			SELECT cedula, usuario FROM usuarios
			WHERE cedula=$cedula OR usuario='$usuario'
		SQL;
		$usuarioEncontrado = getRegistro($sql);
		if ($usuarioEncontrado)
			$respuesta['error'] = 'Ya existe un usuario con esos datos.';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		if ($foto['error'] !== 4):
			$imagen = (string) $foto['name'];
			$tipo   = (string) $foto['type'];
			$peso   = (int) $foto['size'];
			$rutaOrigen = (string) $foto['tmp_name'];
			$rutaDestino = "../assets/images/perfil/$imagen";
			
			if ($tipo !== 'image/jpeg' && $tipo !== 'image/jpg' && $tipo !== 'image/png')
				$respuesta['error'] = 'Sólo se permite imagenes JPG y PNG';
			elseif ($peso > (1 * 1024 * 2048) /*2MB*/)
				$respuesta['error'] = 'La imagen no puede ser mayor a 2MB';
			else move_uploaded_file($rutaOrigen, $rutaDestino);
		endif;
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$clave = encriptar($clave);
		$sql = <<<SQL
			INSERT INTO usuarios(cedula, nombre, usuario, clave, cargo, telefono, foto, activo)
			VALUES($cedula, '$nombre', '$usuario', '$clave', '$cargo', '$telefono', '$imagen', 1)
		SQL;
		$resultado = setRegistro($sql);
		
		// REGISTRAR CLIENTE POR DEFECTO
		$sql = <<<SQL
			INSERT INTO clientes(id, cedula, nombre, usuario_id)
			VALUES(3, 40000000, 'No Especificado', $conexion->insert_id)
		SQL;
		setRegistro($sql);
		
		if (!$resultado)
			$respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = $cargo === 'a'
			? 'Administrador registrado exitósamente.'
			: 'Usuario registrado exitósamente.';
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>
