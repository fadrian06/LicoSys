<?php

	//////////////
	// PATRONES //
	//////////////
	$NOMBRE_NEGOCIO = [
		'patron' => '/[\sA-Za-z]{4,20}/',
		'descripcion' => 'Sólo se permiten entre 4 y 20 letras'
	];
	$RIF = [
		'patron' => '/(v|e|V|E){1}\d{9,15}/',
		'descripcion' => 'Debe empezar por V o E seguido de entre 9 y 15 dígitos'
	];
	$TELEFONO = [
		'patron' => '/(0|\+57|\+58)[\s-]?(412|414|424|416|426)-?\d{3}-?\d{4}/',
		'descripcion' => 'ejemplo (+58 416-111-2222 o 0416-111-2222)'
	];
	$DIRECCION = [
		'patron' => '/[#\/,\.-\w\s]{0,20}/',
		'descripcion' => 'Sólo se permiten letras, números y símbolos (, . - / #)'
	];

	///////////////////////////////////////
	// CONFIGURACIÓN DE LA BASE DE DATOS //
	///////////////////////////////////////
	const HOST    = 'localhost';
	const USUARIO = 'root';
	const CLAVE   = '';
	const BD      = 'licoreria';
	const CHARSET = 'utf8';

	$conexion = @new Mysqli(HOST, USUARIO, CLAVE);

	if ($conexion->connect_errno)
		exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b><br>");

	$conexion->set_charset(CHARSET)
		or exit("Error cargando el conjunto de caracteres <b>".CHARSET.": <u>$conexion->error</u></b><br>");

	try {
		$conexion->select_db(BD);
	} catch (Exception $e) {
		$sql = file_get_contents('backup/inicializar.sql');
		$conexion->multi_query($sql) or exit($conexion->error);
	}

?>