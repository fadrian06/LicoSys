<?php

	use function App\getenv;

	require_once __DIR__ . '/../vendor/autoload.php';

	/** @var array Respuesta del servidor al cliente. */
	$respuesta = [
		'ok'    => '',
		'error' => '',
		'datos' => []
	];

	if (
		!defined('HOST')
		&& !defined('USUARIO')
		&& !defined('CLAVE')
		&& !defined('BD')
		&& !defined('CHARSET')
		&& !defined('PORT')
	) {
		define('HOST', getenv('DB_HOST'));
		define('USUARIO', getenv('DB_USERNAME'));
		define('CLAVE', getenv('DB_PASSWORD'));
		define('BD', getenv('DB_DATABASE'));
		define('PORT', getenv('DB_PORT'));
		define('CHARSET', 'utf8');
	}

	$conexion = @new MySQLi(HOST, USUARIO, CLAVE, port: PORT);

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
