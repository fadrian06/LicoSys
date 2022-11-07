<?php

	//////////////
	// PATRONES //
	//////////////
	$NOMBRE_NEGOCIO = [
		'patron' => '/[\sA-Za-z]{4,20}/',
		'descripcion' => 'Sólo se permiten nombres de entre 4 y 20 letras'
	];
	$RIF = [
		'patron' => '/(v|e|V|E){1}\d{9,15}/',
		'descripcion' => 'El RIF debe empezar por V o E seguido de entre 9 y 15 dígitos'
	];
	$TELEFONO = [
		'patron' => '/(0|\+57|\+58)\s?-?(412|414|424|416|426)-?\d{3}-?\d{4}/',
		'descripcion' => 'Teléfono inválido, ejemplos (+58 416-111-2222 o 0416-111-2222)'
	];
	$DIRECCION = [
		'patron' => '/[#\/,\.-\w\s]*/',
		'descripcion' => 'Sólo se permiten direcciones con letras, números y símbolos (, . - / #)'
	];
	$CEDULA = [
		'patron' => '/[^e]?\d{7,8}/',
		'descripcion' => 'La cédula debe ser un número de entre 7 y 8 dígitos'
	];
	$NOMBRE = [
		'patron' => '/[A-Z][a-záÁéÉíÍóÓúÚñÑ]{4,20}/',
		'descripcion' => 'Sólo se permiten nombres de entre 4 y 20 letras'
	];
	$USUARIO = [
		'patron' => '/@?[\w-]{4,20}/',
		'descripcion' => 'Sólo se permiten usuarios de entre 4 y 20 letras, números y símbolos(@ - _)'
	];
	$CLAVE = [
		'patron' => '/[\w.-@#*]{4,20}/',
		'descripcion' => 'Sólo se permiten contraseñas de entre 4 y 20 letras, números y símbolos (. - _ @ # *)'
	];

	///////////////////////////////////////
	// CONFIGURACIÓN DE LA BASE DE DATOS //
	///////////////////////////////////////
	$HOST    = 'localhost';
	$USUARIO_BD = 'root';
	$CLAVE_BD   = '';
	$BD      = 'licoreria';
	$CHARSET = 'utf8';
?>