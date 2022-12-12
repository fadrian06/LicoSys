<?php
	session_start();
	require 'backend/conexion.php';
	require 'backend/funciones.php';

	$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
	$admin    = getRegistro("SELECT * FROM usuarios WHERE cargo='a'");
	$_SESSION['userID'] = $admin['id'];
	// require 'backend/login.php';
	// require 'backend/consultarPreguntas.php';
	// require 'backend/validarRespuestas.php';
	// require 'backend/cambiarClave.php';
?>

<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Franyer Sánchez, Daniel Mancilla">
		<meta name="description" content="Sistema Automatizado de Gestión de Compras y Ventas">
		<meta name="theme-color" content="black">
		<link rel="icon" href="images/logo.png">
		<link rel="stylesheet" href="icons/style.min.css">
		<link rel="stylesheet" href="libs/w3/w3.min.css">
		<link rel="stylesheet" href="libs/animate.min.css">
		<link rel="stylesheet" href="libs/noty/noty.css">
		<link rel="stylesheet" href="libs/noty/themes/sunset.css">
		<link rel="stylesheet" href="fonts/fuentes.min.css">
		<link rel="stylesheet" href="css/bundle.css">
		<title>LicoSys</title>
	</head>

	<body>
		<div class="w3-overlay w3-animate-opacity w3-hide"></div>
		<?php
			if (!isset($mostrarLoader) and !$negocios):
				if (file_exists('backup/licosys.sql'))
					$script = '<script src="js/restaurarBD.js"></script>';
				
				$mostrarRegistro = true;
				include 'templates/registrarNegocio.php';
				$script .= '<script src="js/actualizarImagen.js"></script>';
				$script .= '<script src="js/validar.js"></script>';
				$script .= '<script src="js/registrarNegocio.js"></script>';
			elseif (!isset($mostrarLoader) and !$admin):
				if (file_exists('backup/licosys.sql'))
					$script = '<script src="js/restaurarBD.js"></script>';
				
				$mostrarRegistro = true;
				include 'templates/registrarAdmin.php';
				$script .= '<script src="js/actualizarImagen.js"></script>';
				$script .= '<script src="js/validar.js"></script>';
				$script .= '<script src="js/registrarAdmin.js"></script>';
			elseif (!isset($mostrarLoader) and !$admin['pre1']):
				if (file_exists('backup/licosys.sql'))
					$script = '<script src="js/restaurarBD.js"></script>';
				
				$mostrarRegistro = true;
				include 'templates/registroPreguntasRespuestas.php';
				$script .= '<script src="js/validar.js"></script>';
				$script .= '<script src="js/registrarPreguntasRespuestas.js"></script>';
			endif;
			// if (!$negocios):
				
			// 	if (file_exists('backup/licosys.sql'))
			// 		$alerta = '<script src="js/restaurarBD.js"></script>';
			// 	else
			// 		$alerta = <<<HTML
			// 			<link rel="stylesheet" href="librerias/sweetalert2/borderless.min.css">
			// 			<script src="js/loader.js"></script>
			// 		HTML;
					
			// 	$registrarNegocio = true;
			// 	require 'templates/formRegistroNegocio.php';
			// elseif (!$admin):
			// 	$registrarAdmin = true;
			// 	require 'templates/formRegistroAdmin.php';
			// else:
			// 	require 'templates/login.php';
			// 	require 'templates/formConsulta.php';
				
			// 	if (isset($mostrarPreguntas))
			// 		require 'templates/formPreguntas.php';
				
			// 	if (isset($cambiarClave))
			// 		require 'templates/formCambiarClave.php';
			// endif;
		?>
		<script src="libs/jquery.min.js"></script>
		<script src="libs/w3/w3.min.js"></script>
		<script src="libs/noty/noty.min.js"></script>
		<script src="js/funciones.js"></script>
		<?=$mostrarLoader ?? ''?>
		<?=$script ?? ''?>
	</body>
</html>