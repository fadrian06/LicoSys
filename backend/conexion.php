<?php

use App\Environment\Env;

require_once __DIR__ . '/../vendor/autoload.php';

/** @var array Respuesta del servidor al cliente. */
$respuesta = [
  'ok'    => '',
  'error' => '',
  'datos' => []
];

try {
  $conexion = new MySQLi(Env::get('DB_HOST'), Env::get('DB_USERNAME'), Env::get('DB_PASSWORD'));
  $conexion->set_charset(Env::get('DB_CHARSET'));
} catch (mysqli_sql_exception $error) {
  exit("Error, no se pudo conectar a MySQL: <b>{$error->getMessage()}</b><br>");
}

/*----------  Si no existe la base de datos, comienza la instalación  ----------*/
try {
  $conexion->select_db(Env::get('DB_DATABASE'));
} catch (mysqli_sql_exception) {
  $mostrarLoader = '<script src="js/loader.js"></script>';
}

/*----------  Instala la Base de Datos  ----------*/
if (!empty($_POST['instalarBD'])) :
  $sql = file_get_contents(__DIR__ . '/init.sql');
  exit($conexion->multi_query($sql) ? 'true' : $conexion->error);
endif;
