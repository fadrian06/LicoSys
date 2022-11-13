<?php
	session_start();

	/*==========================================
	=            SCRIPTS ESENCIALES            =
	==========================================*/
	require 'php/conexion.php';
	require 'php/funciones.php';

	$_SESSION['usuario'] = '';
	$alerta = '';

	$negocios = getRegistros('SELECT * FROM negocio WHERE activo=1');
	$admin    = getRegistro("SELECT * FROM usuario WHERE cargo='a'");

	/*====================================
	=            VALIDACIONES            =
	====================================*/
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
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="author" content="Franyer Sánchez, Daniel Mancilla">
		<meta name="description" content="Sistema Automatizado de Gestión de Compras y Ventas">
		<meta name="theme-color" content="black">

		<link rel="icon" href="imagenes/logo.png">
		<link rel="stylesheet" href="iconos/style.min.css">
		<link rel="stylesheet" href="librerias/w3/w3.min.css">
		<link rel="stylesheet" href="librerias/animate.min.css">
		<link rel="stylesheet" href="fuentes/fuentes.css">
		<link rel="stylesheet" href="css/login.css">
		<link rel="stylesheet" href="css/main.css">

		<script src="librerias/w3/w3.min.js"></script>
		<script src="librerias/axios/axios.min.js"></script>
		<script src="librerias/sweetalert2/sweetalert2.all.min.js"></script>
		<script src="js/funciones.js"></script>
		
		<title>LicoSys</title>
	</head>

	<body>