<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

(new Dotenv)->load(__DIR__ . '/../.env');

/**
 * Respuesta del servidor al cliente.
 *
 * @var array{ok: string, error: string, datos: array}
 */
$respuesta = [
	'ok'    => '',
	'error' => '',
	'datos' => []
];

$conexion = @new mysqli(
	$_ENV['DB_HOST'],
	$_ENV['DB_USERNAME'],
	$_ENV['DB_PASSWORD']
);

if ($conexion->connect_errno)
	exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b>");

$conexion->set_charset('utf8');

/*----------  Si no existe la base de datos, comienza la instalación  ----------*/
try {
	if (!$conexion->select_db($_ENV['DB_DATABASE']))
		throw new mysqli_sql_exception;
} catch (mysqli_sql_exception) {
	$mostrarLoader = '<script src="js/loader.js"></script>';
}

/*----------  Instala la Base de Datos  ----------*/
if (!empty($_POST['instalarBD'])) :
	$sql = file_get_contents(__DIR__ . '/../database/init.sql');

	exit($conexion->multi_query($sql) ? 'true' : $conexion->error);
endif;
