<?php
	session_start();
	if (isset($_SESSION['activa'])) header('location: dashboard.php');
	
	include 'templates/head.php';
	
	$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
	$admin    = getRegistro("SELECT * FROM usuarios WHERE cargo='a'");
	
	if (!empty($_SESSION['userID'])) $_SESSION['userID'] = $admin['id'];
?>

<?php
	if (!isset($mostrarLoader) and !$negocios):
		if (file_exists('backup/licosys.sql'))
			$script .= '<script src="js/restaurarBD.js"></script>';
		
		$mostrarRegistro = true;
		include 'templates/registrarNegocio.php';
		$script .= '<script src="js/actualizarImagen.js"></script>';
		$script .= '<script src="js/registrarNegocio.js"></script>';
	elseif (!isset($mostrarLoader) and !$admin):
		if (file_exists('backup/licosys.sql'))
			$script .= '<script src="js/restaurarBD.js"></script>';
		
		$mostrarRegistro = true;
		include 'templates/registrarAdmin.php';
		$script .= '<script src="js/actualizarImagen.js"></script>';
		$script .= '<script src="js/registrarAdmin.js"></script>';
	elseif (!isset($mostrarLoader) and !$admin['pre1']):
		if (file_exists('backup/licosys.sql'))
			$script .= '<script src="js/restaurarBD.js"></script>';
		
		$mostrarRegistro = true;
		include 'templates/registroPreguntasRespuestas.php';
		
		$script .= '<script src="js/registrarPreguntasRespuestas.js"></script>';
	elseif (!isset($mostrarLoader)):
		include 'templates/login.php';
		include 'templates/consultarPreguntasRespuestas.php';
		
		if (isset($_SESSION['showQuestions']))
			include 'templates/preguntasRespuestas.php';
		
		if (isset($_SESSION['changePassword']))
			include 'templates/cambiarClave.php';
		
		$script .= '<script src="js/reloj.js"></script>';
		$script .= '<script src="libs/typedjs/typed.min.js"></script>';
		$script .= '<script src="js/login.js"></script>';
		$script .= '<script src="js/recuperarClave.js"></script>';
	endif;
	
	include 'templates/footer.php';
?>