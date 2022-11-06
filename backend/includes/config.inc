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
		'patron' => '/(0|\+57|\+58)\s?-?(412|414|424|416|426)-?\d{3}-?\d{4}/',
		'descripcion' => 'ejemplo (+58 416-111-2222 o 0416-111-2222)'
	];
	$DIRECCION = [
		'patron' => '/[#\/,\.-\w\s]*/',
		'descripcion' => 'Sólo se permiten letras, números y símbolos (, . - / #)'
	];

	///////////////////////////////////////
	// CONFIGURACIÓN DE LA BASE DE DATOS //
	///////////////////////////////////////
	$HOST    = 'localhost';
	$USUARIO = 'root';
	$CLAVE   = '';
	$BD      = 'licoreria';
	$CHARSET = 'utf8';
?>