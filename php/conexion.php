<?php

	const URL = 'http://localhost/licoreria/';

	const HOST    = 'localhost';
	const USUARIO = 'root';
	const CLAVE   = '';
	const BD      = 'licoreria';
	const CHARSET = 'utf8';

	$conexion = @new MySQLi(HOST, USUARIO, CLAVE);

	if ($conexion->connect_errno)
		exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b><br>");

	$conexion->set_charset(CHARSET)
		or exit("Error cargando el conjunto de caracteres <b>" . CHARSET . ": <u>$conexion->error</u></b><br>");

	if (!$conexion->select_db(BD)):
		$sql = file_get_contents('backup/inicializar.sql');
		$conexion->multi_query($sql) or exit($conexion->error);
		$conexion->select_db(BD);
		header('location: ./');
	endif;
?>