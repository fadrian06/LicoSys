<?php
	session_start();

	/*==========================================
	=            SCRIPTS ESENCIALES            =
	==========================================*/
	require 'php/conexion.php';
	require 'php/funciones.php';

	$_SESSION['usuario'] = '';
	$alerta = '';

	try {
		$negocios = getRegistros('SELECT * FROM negocio WHERE activo=1');
		$admin = getRegistro("SELECT * FROM usuario WHERE cargo='a'");
	} catch (Exception $e) {
		$_SESSION['bienvenido'] = true;
		sleep(10);
		header('location: ./');
	}

	/*====================================
	=            VALIDACIONES            =
	====================================*/
	require 'php/registrarAdmin.php';
	require 'php/login.php';
	require 'php/consultarPreguntas.php';
	require 'php/validarRespuestas.php';
	require 'php/cambiarClave.php';
?>