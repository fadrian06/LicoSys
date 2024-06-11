<?php
	/*======================================
	=            LÓGICA INICIAL            =
	======================================*/
	session_start();
	if (isset($_SESSION['activa'])) header('location: dashboard.php');
	
	include 'templates/head.php';
	
	if (!empty($_SESSION['userID']))$_SESSION['userID'] = $admin['id'];
	
	setRegistro('TRUNCATE TABLE carrito_venta');
	setRegistro('TRUNCATE TABLE carrito_compra');
	
	function verificarCopiaDeSeguridad() {
		global $script;
		if (file_exists('backup/backup.sql'))
			$script .= '<script src="assets/js/restaurarBD.js"></script>';
	}
	/*=====  End of LÓGICA INICIAL  ======*/
	
	/*----------  Si no hay negocios, solicita registro  ----------*/
	if (!isset($mostrarLoader) and !$negocios):
		
		verificarCopiaDeSeguridad();		
		$mostrarRegistro = true;
		include 'templates/registrarNegocio.php';
		$script .= '<script src="assets/js/registrarNegocio.js"></script>';
		
	/*----------  Si no hay administrador, solicita registro  ----------*/
	elseif (!isset($mostrarLoader) and !$admin):
		
		verificarCopiaDeSeguridad();
		$mostrarRegistro = true;
		include 'templates/registrarAdmin.php';
		$script .= '<script src="assets/js/registrarAdmin.js"></script>';
		
	/*----------  Si el administrador no tiene preguntas secretas, solicita registro  ----------*/
	elseif (!isset($mostrarLoader) and !$admin['pre1']):
		
		verificarCopiaDeSeguridad();
		$mostrarRegistro = true;
		include 'templates/registroPreguntasRespuestas.php';
		$script .= '<script src="assets/js/registrarPreguntasRespuestas.js"></script>';
	
	/*----------  Muestra el login  ----------*/
	elseif (!isset($mostrarLoader)):
		
		$mostrarLogin = true;
		include 'templates/login.php';
		include 'templates/consultarPreguntasRespuestas.php';
		
		if (isset($_SESSION['showQuestions']))
			include 'templates/preguntasRespuestas.php';
		
		if (isset($_SESSION['changePassword']))
			include 'templates/cambiarClave.php';
		
		$script .= '<script src="assets/js/reloj.js"></script>';
		$script .= '<script src="assets/libs/typedjs/typed.min.js"></script>';
		$script .= '<script src="assets/js/login.js"></script>';
		$script .= '<script src="assets/js/recuperarClave.js"></script>';
		
	endif;
	
	include 'templates/footer.php';
