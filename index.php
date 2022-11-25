<?php
	session_start();
	require 'php/conexion.php';
	require 'php/funciones.php';

	$negocios = getRegistros('SELECT * FROM negocio WHERE activo=1');
	$admin    = getRegistro("SELECT * FROM usuario WHERE cargo='a'");

	require 'php/registrarNegocio.php';
	require 'php/registrarAdmin.php';
	require 'php/login.php';
	require 'php/consultarPreguntas.php';
	require 'php/validarRespuestas.php';
	require 'php/cambiarClave.php';
?>

<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Franyer Sánchez, Daniel Mancilla">
		<meta name="description" content="Sistema Automatizado de Gestión de Compras y Ventas">
		<meta name="theme-color" content="black">
		<link rel="icon" href="dist/images/logo.png">
		<link rel="stylesheet" href="dist/bundle.css">
		<title>LicoSys</title>
	</head>

	<body>
		<div class="w3-overlay w3-animate-opacity w3-hide"></div>
		<?php
			if (!$negocios):
				
				if (file_exists('backup/licosys.sql'))
					$alerta = '<script src="node_modules/axios/dist/axios.min.js"></script><script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script><script src="src/modules/restaurarBD.js"></script>';
				else
					$alerta = <<<HTML
						<link rel="stylesheet" href="librerias/sweetalert2/borderless.min.css">
						<script src="src/modules/loader.js"></script>
					HTML;
					
				$registrarNegocio = true;
				require 'parciales/formRegistroNegocio.php';
			elseif (!$admin):
				$registrarAdmin = true;
				require 'parciales/formRegistroAdmin.php';
			else:
				require 'parciales/login.php';
				require 'parciales/formConsulta.php';
				
				if (isset($mostrarPreguntas))
					require 'parciales/formPreguntas.php';
				
				if (isset($cambiarClave))
					require 'parciales/formCambiarClave.php';
			endif;
		?>
		<script src="dist/bundle.js"></script>
		<?=$alerta ?? ''?>
	</body>
</html>