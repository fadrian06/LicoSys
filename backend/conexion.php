<?php
	// LOCAL
	const HOST    = 'localhost';
	const USUARIO = 'root';
	const CLAVE   = '';
	const BD      = 'licosys';
	const CHARSET = 'utf8';
	// ONLINE
	// const USUARIO = '477828';
	// const CLAVE = 'fsanchez61001';
	// const BD = '477828';

	$conexion = @new MySQLi(HOST, USUARIO, CLAVE);

	if ($conexion->connect_errno)
		exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b><br>");

	$conexion->set_charset(CHARSET)
		or exit("Error cargando el conjunto de caracteres <b>" . CHARSET . ": <u>$conexion->error</u></b><br>");
	
	if (!$conexion->select_db(BD))
		$mostrarLoader = '<script src="js/loader.js"></script>';
	
	if (!empty($_POST['instalarBD'])):
		$sql = file_get_contents('init.sql');
		exit($conexion->multi_query($sql) ? 'true' : $conexion->error);
	endif;
?>