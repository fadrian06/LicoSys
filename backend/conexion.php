<?php

/**
 * Respuesta del servidor al cliente.
 * @var array{ok: string, error: string, datos: array}
 */
$respuesta = [
	'ok'    => '',
	'error' => '',
	'datos' => []
];

// LOCAL
const HOST    = 'localhost';
const USUARIO = 'root';
const CLAVE   = '';
const BD      = 'licosys';
const CHARSET = 'utf8';

// ONLINE - FWHA
// const USUARIO = '477828';
// const CLAVE = 'fsanchez61001';
// const BD = '477828';

// ONLINE - 000webhost.com
// const USUARIO = 'id20496120_fsanchez';
// const CLAVE = 'tGB73Jd}mgcO$4I=';
// const BD = 'id20496120_licosys';

$conexion = @new MySQLi(HOST, USUARIO, CLAVE);

if ($conexion->connect_errno)
	exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b>");

$conexion->set_charset(CHARSET);

/*----------  Si no existe la base de datos, comienza la instalación  ----------*/
if (!$conexion->select_db(BD))
	$mostrarLoader = '<script src="js/loader.js"></script>';

/*----------  Instala la Base de Datos  ----------*/
if (!empty($_POST['instalarBD'])) :
	$sql = file_get_contents('init.sql');

	exit($conexion->multi_query($sql) ? 'true' : $conexion->error);
endif;
