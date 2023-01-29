<?php
	
	session_start();
	require 'conexion.php';
	require 'funciones.php';

	if (!empty($_POST['consultar'])):
		$cedula = (int) $_POST['cedula'];
		$usuario = escapar($_POST['usuario']);
		
		/*----------  VALIDACIONES  ----------*/
		if (!$cedula or !$usuario)
			$respuesta['error'] = 'Por favor introduzca su cédula y usuario.';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = <<<SQL
			SELECT id, pre1, pre2, pre3, res1, activo
			FROM usuarios WHERE cedula=$cedula AND BINARY(usuario)=BINARY('$usuario')
		SQL;
		$filaUsuario = getRegistro($sql);
		
		if (!$filaUsuario)
			$respuesta['error'] = 'Cédula o usuario incorrecto, <strong>(verifique mayúsculas y minúsculas)</strong>';
		elseif (!$filaUsuario['activo'])
			$respuesta['error'] = 'Este usuario se encuentra desactivado.';
		elseif (!$filaUsuario['res1'])
			$respuesta['error'] = 'Este usuario no tiene <strong>Preguntas y Respuestas</strong> registradas.';
		else $_SESSION = [
			'userID' => $filaUsuario['id'],
			'pre1'   => $filaUsuario['pre1'],
			'pre2'   => $filaUsuario['pre2'],
			'pre3'   => $filaUsuario['pre3'],
			'showQuestions' => true
		];
		
		if ($respuesta['error']):
			session_destroy();
			$_SESSION['userID'] = $filaUsuario['id'] ?? null;
		endif;
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	if (!empty($_POST['verificarRespuestas'])):
		$id = (int) $_POST['id'];
		$res1 = escapar($_POST['res1']);
		$res2 = escapar($_POST['res2']);
		$res3 = escapar($_POST['res3']);
		
		$sql = "SELECT id, usuario, res1, res2, res3 FROM usuarios WHERE id=$id";
		$filaUsuario = getRegistro($sql);
		
		if (!password_verify($res1, $filaUsuario['res1'])
			or !password_verify($res2, $filaUsuario['res2'])
			or !password_verify($res3, $filaUsuario['res3'])
		) $respuesta['error'] = 'Respuestas incorrectas.';
		
		unset($_SESSION['showQuestions']);
		if (!$respuesta['error'])
			$_SESSION['changePassword'] = true;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	if (!empty($_POST['cambiarClave'])):
		$id = (int) $_POST['id'];
		$clave     = escapar($_POST['clave']);
		$confirmar = escapar($_POST['confirmar']);
		
		/*----------  VALIDACIONES  ----------*/
		if (!$clave or !$confirmar)
			$respuesta['error'] = 'Por favor ingrese una contraseña.';
		elseif ($clave !== $confirmar)
			$respuesta['error'] = 'Ambas contraseñas deben ser iguales.';
		
		if ($respuesta['error']):
			unset($_SESSION['changePassword']);
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		endif;
		
		$clave = encriptar($clave);
		$sql = "UPDATE usuarios SET clave='$clave' WHERE id=$id";
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		session_destroy();
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;

	if (!empty($_POST['cerrar']))
		exit(session_destroy() ? 'Sesión destruida correctamente' : 'Ha ocurrido un error');

?>