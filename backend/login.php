<?php
	session_start();
	
	require 'conexion.php';
	require 'funciones.php';
	
	$respuesta = [
		'error' => '',
		'datos' => []
	];
	
	if (!empty($_POST['verificarUsuario'])):
		$usuario = escapar($_POST['usuario']);
		
		/*----------  VALIDACIONES  ----------*/
		if (!$usuario) $respuesta['error'] = 'El usuario no puede estar vacío';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = "SELECT usuario FROM usuarios WHERE BINARY(usuario)=BINARY('$usuario')";
		$filaUsuario = getRegistro($sql);
		
		if (!$filaUsuario)
			$respuesta['error'] = 'Usuario no existe, (verifique mayúsculas y minúsculas)';
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
	endif;
	
	if (!empty($_POST['login'])):
		
		$usuario = escapar($_POST['usuario']);
		$clave = escapar($_POST['clave']);
		$idNegocio = (int) $_POST['negocio'];
		
		/*----------  VALIDACIONES  ----------*/
		if (!$idNegocio) $respuesta['error'] = 'Por favor seleccione un negocio';
		if (!$usuario or !$clave)
			$respuesta['error'] = 'Por favor introduzca un usuario y una contraseña';
		
		$sql = "SELECT id, nombre, usuario, clave, activo, foto, cargo FROM usuarios 
			WHERE BINARY(usuario)=BINARY('$usuario')
		";
		$filaUsuario = getRegistro($sql);
		
		$sql = "SELECT id, logo, nombre FROM negocios WHERE id=$idNegocio";
		$negocioSeleccionado = getRegistro($sql);
		
		if (!$filaUsuario)
			$respuesta['error'] = 'Usuario no existe, (verifique mayúsculas y minúsculas)';
		elseif (!password_verify($clave, $filaUsuario['clave']))
			$respuesta['error'] = 'Contraseña incorrecta';
		elseif (!$filaUsuario['activo'])
			$respuesta['error'] = 'Este usuario se encuentra desactivado';
		
		if ($filaUsuario['cargo'] === 'v'):
			$sql = "INSERT INTO log(usuario_id, negocio_id) VALUES({$filaUsuario['id']}, {$negocioSeleccionado['id']})";
			$resultado = setRegistro($sql);
			
			if (!$resultado) $respuesta['error'] = $conexion->error;
		endif;
		
		if ($respuesta['error']):
			session_destroy();
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		endif;		
		/*----------  FIN DE VALIDACIONES  ----------*/
		
		$_SESSION = [
			'activa'    => true,
			'user'      => $filaUsuario['usuario'],
			'userName'  => $filaUsuario['nombre'],
			'userID'    => $filaUsuario['id'],
			'cargo'     => $filaUsuario['cargo'],
			'userFoto'  => $filaUsuario['foto']
											? "images/perfil/{$filaUsuario['foto']}"
											: 'images/avatar3.png',
			'negocio'   => $negocioSeleccionado['nombre'],
			'negocioID' => $negocioSeleccionado['id'],
			'negocioLogo'      => $negocioSeleccionado['logo']
											? "images/negocios/{$negocioSeleccionado['logo']}"
											: 'images/logoNegocio.jpg'
		];
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
	endif;
?>