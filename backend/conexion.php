<?php
	/** @var array Respuesta del servidor al cliente. */
	$respuesta = [
		'ok'    => '',
		'error' => '',
		'datos' => []
	];

	// LOCAL
	if (!defined('HOST') && !defined('USUARIO') && !defined('CLAVE') && !defined('BD') && !defined('CHARSET')) {
		define('HOST', 'localhost');
		define('USUARIO', 'root');
		define('CLAVE', '');
		define('BD', 'licosys');
		define('CHARSET', 'utf8');
	}

	$conexion = @new MySQLi(HOST, USUARIO, CLAVE);

	if ($conexion->connect_errno)
		exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b><br>");

	$conexion->set_charset(CHARSET);

	/*----------  Si no existe la base de datos, comienza la instalación  ----------*/
	try {
		$conexion->select_db(BD);
	} catch (mysqli_sql_exception) {
		$mostrarLoader = '<script src="js/loader.js"></script>';
	}

	/*----------  Instala la Base de Datos  ----------*/
	if (!empty($_POST['instalarBD'])):
		$sql = file_get_contents('init.sql');
		exit($conexion->multi_query($sql) ? 'true' : $conexion->error);
	endif;

	return $conexion;
?>
