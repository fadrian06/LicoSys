<?php
	$host     = "localhost";
	$user     = "root";
	$clave    = "";
	$bd       = "licoreria";
	$charset  = "utf8";
	
	$conexion = mysqli_connect($host, $user, $clave, $bd);

	if (mysqli_connect_errno()) exit("Error, no se pudo conectar a MySQL: " . mysqli_connect_errno() . "<br>");

	if (!mysqli_select_db($conexion, $bd)) exit("No existe la base de datos: " . mysqli_error($conexion) . "<br>");
	
	if (!mysqli_set_charset($conexion, $charset)) exit("Error cargando el conjunto de caracteres $charset: " . mysqli_error($conexion) . "<br>");
?>