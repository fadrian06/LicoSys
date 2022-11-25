<?php
	session_start();
	$notificacion = '';
	$restringido  = '';

	if (!isset($_SESSION['activa']))
		header('location: ../');

	/*==========================================
	=            SCRIPTS ESENCIALES            =
	==========================================*/
	require '../php/conexion.php';
	require '../php/funciones.php';
	require 'php/desactivar.php';
	require 'php/activar.php';

	/*========================================
	=            FUNCIONES EXTRAS            =
	========================================*/
	require 'php/panelActual.php';
	require 'php/apis.php';

	/*===========================================
	=            SCRIPTS DE REGISTRO            =
	===========================================*/
	require 'php/registrarProducto.php';
	require 'php/registrarCliente.php';
	require 'php/registrarProveedor.php';
	require 'php/registrarUsuario.php';
?>

<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="author" content="Franyer Sánchez">
		<meta name="author" content="Daniel Mancilla">
		<meta name="description" content="Sistema Automatizado para Registrar Compras y Ventas">
		<meta name="theme-color" content="black">
		<link rel="icon" href="../dist/images/logo.png">
		<link rel="stylesheet" href="../css/sistema.css">
		<link rel="stylesheet" href="../css/boton.css">
		<link rel="stylesheet" href="../css/miPerfil.css">
		<link rel="stylesheet" href="../css/configuracionNegocios.css">
		<link rel="stylesheet" href="../dist/bundle.css">
		<title>LicoSys</title>
	</head>

	<body class="w3-light-grey">
		<?php
			require 'parciales/menu.php';
			require 'parciales/botones.php' 
		?>

		<div class="w3-overlay w3-hide w3-animate-opacity" id="modalOverlay"></div>

		<!-- ACERCA DE -->
		<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalAcercaDe">
			<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
			<h3 class="swal2-title w3-margin-bottom">Acerca de <small>LicoSys</small></h3>
			<div class="w3-container" style="max-width: 700px">
				<div class="w3-row">
					<p class="w3-twothird w3-padding-large w3-xlarge w3-justify">&nbsp;&nbsp;&nbsp;LicoSys es un sistema administrativo que simplifica los procesos que se llevan a cabo para la correcta gestión de cualquier negocio.</p>
					<div class="w3-third w3-center">
						<img src="../dist/images/logo.png" class="w3-image" data-aos="fade-right" style="width: 20vw">
					</div>
					<div class="w3-clear"></div>
				</div>
				<ul class="w3-ul w3-padding-large w3-large w3-justify">
					<li class="w3-margin">
						<i class="icon-check"></i>
						Realiza procesos de <b>transacción de bienes</b>.
					</li>
					<li class="w3-margin">
						<i class="icon-check"></i>
						Consulta facturas ordenadas.
					</li>
					<li class="w3-margin">
						<i class="icon-check"></i>
						Registra a tus <b>clientes</b> y <b>proveedores</b> más frecuentes.
					</li>
					<li class="w3-margin">
						<i class="icon-check"></i>
						Gestiona a tus <b>vendedores</b>.
					</li>
					<li class="w3-margin">
						<i class="icon-check"></i>
						Convierte <b>monedas</b>.
					</li>
					<li class="w3-margin">
						<i class="icon-check"></i>
						Monitorea el <b>dólar</b> en todas sus variantes.
					</li>
					<li class="w3-margin">
						<i class="icon-check"></i>
						Analiza el desempaño de tu <b>negocio</b>.
					</li>
					<li class="w3-margin">
						<i class="icon-check"></i>
						Consulta tus <b>finanzas</b>.
					</li>
					<p>Todo desde la comodidad de tu equipo preferido, LicoSys funciona tanto en <b>computadoras</b> como en <b>smartphones y tablets</b>, su entorno es web con lo cual sólo necesitarás un navegador y consume la aplicación.</p>
					<img src="../dist/images/devices.jpg" class="w3-image" style="width: 700px">
				</ul>
				<div class="w3-row w3-justify w3-xlarge">
					<p class="w3-margin w3-padding-large">&nbsp;&nbsp;&nbsp;LicoSys está fuertemente centrado en la <b>experiencia de usuario</b> y la <b>seguridad de la información</b>.</p>
				</div>
				<div class="w3-row w3-justify w3-xlarge">
					<p class="w3-margin w3-padding-large">&nbsp;&nbsp;&nbsp;Utilizar el sistema es sumamente sencillo, con unos pocos pasos y pocos clics, habrás registrado lo necesario para que la aplicación funcione correctamente.</p>
				</div>
			</div>
		</div>