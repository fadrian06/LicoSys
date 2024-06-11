<?php

require_once __DIR__ . '/../.env.php';

/**
 * @deprecated Use `Backend\Classes\Response::class`
 * @var array{
 *   ok: string,
 *   error: string,
 *   datos: array<string, mixed>
 * } Respuesta del servidor al cliente
 */
$respuesta = [
  'ok'    => '',
  'error' => '',
  'datos' => []
];

try {
  $conexion = new MySQLi(
    $_ENV['db']['host'],
    $_ENV['db']['user'],
    $_ENV['db']['password']
  );

  $conexion->set_charset($_ENV['db']['charset']);
} catch (mysqli_sql_exception $error) {
  exit("Error, no se pudo conectar a MySQL: <b>{$error->getMessage()}</b><br>");
}

/*----------  Si no existe la base de datos, comienza la instalación  ----------*/
try {
  $conexion->select_db($_ENV['db']['dbname']);
} catch (mysqli_sql_exception) {
  $mostrarLoader = '<script src="js/loader.js"></script>';
}

/*----------  Instala la Base de Datos  ----------*/
if (key_exists('instalarBD', $_POST)) :
  $sql = file_get_contents(__DIR__ . '/init.sql');

  exit($conexion->multi_query($sql) ? 'true' : $conexion->error);
endif;
