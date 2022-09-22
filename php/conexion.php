<?php
	$host    = "localhost";
	$user    = "root";
	$clave   = "";
	$bd      = "licoreria";
	$charset = "utf8";

	$conexion = @mysqli_connect($host, $user, $clave, $bd);
	if (mysqli_connect_errno()) exit("Error, no se pudo conectar a MySQL: <b>" . mysqli_connect_error() . "</b><br>");
	
	if (!mysqli_set_charset($conexion, $charset)) exit("Error cargando el conjunto de caracteres <b>$charset: <u>" . mysqli_error($conexion) . "</u></b><br>");
?>