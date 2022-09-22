<?php
	session_start();
	if (!isset($_SESSION["usuario"])) header("location: ../");
	require_once "../php/conexion.php";
	require_once "../php/funciones.php";
	require_once "php/panelActual.php";

	require_once "php/registrarProducto.php";
	require_once "php/registrarCliente.php";
	require_once "php/registrarProveedor.php";
	require_once "php/registrarUsuario.php";
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
		<link rel="stylesheet" href="css/sistema.css">
		<link rel="stylesheet" href="css/boton.css">
		<link rel="stylesheet" href="css/miPerfil.css">
		<link rel="stylesheet" href="css/configuracionNegocios.css">
		<title>LicoSys</title>
	</head>

	<body class="w3-light-grey">
		<?php require_once "parciales/menu.php" ?>
	
		<!-- Overlay effect when opening sidebar on small screens -->
		<div class="w3-overlay w3-hide w3-animate-opacity" id="modalOverlay"></div>

		<?php require_once "parciales/botones.php" ?>