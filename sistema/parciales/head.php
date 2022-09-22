<?php
	session_start();
	$notificacion = "";
	$restringido = "";
	if (!isset($_SESSION["activa"])) header("location: ../");
	/*==========================================
	=            SCRIPTS ESENCIALES            =
	==========================================*/
	require "../php/conexion.php";
	require "../php/funciones.php";
	require "php/desactivar.php";
	require "php/activar.php";

	/*========================================
	=            FUNCIONES EXTRAS            =
	========================================*/
	require "php/panelActual.php";

	/*===========================================
	=            SCRIPTS DE REGISTRO            =
	===========================================*/
	require "php/registrarProducto.php";
	require "php/registrarCliente.php";
	require "php/registrarProveedor.php";
	require "php/registrarUsuario.php";
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
		<link rel="icon" href="../imagenes/favicon.png">
		<link rel="stylesheet" href="../iconos/style.min.css">
		<link rel="stylesheet" href="../librerias/w3/w3.min.css">
		<link rel="stylesheet" href="../librerias/sweetalert2/sweetalert2.min.css">
		<link rel="stylesheet" href="../librerias/animate.min.css">
		<link rel="stylesheet" href="../fuentes/fuentes.css">
		<link rel="stylesheet" href="../css/sistema.css">
		<link rel="stylesheet" href="../css/boton.css">
		<link rel="stylesheet" href="../css/miPerfil.css">
		<link rel="stylesheet" href="../css/configuracionNegocios.css">
		<link rel="stylesheet" href="../css/main.css">
		<title>LicoSys</title>
	</head>

	<body class="w3-light-grey">
		<?php require "parciales/menu.php" ?>

		<div class="w3-overlay w3-hide w3-animate-opacity" id="modalOverlay"></div>

		<?php require "parciales/botones.php" ?>

		<!-- ACERCA DE -->
		<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalAcercaDe">
			<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
			<h3 class="swal2-title w3-margin-bottom">Acerca de <small>LicoSys</small></h3>
		</div>