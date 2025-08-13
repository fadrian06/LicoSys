<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

(new Dotenv)->load(BASE_DIR . '/.env.dist', BASE_DIR . '/.env');

/**
 * Respuesta del servidor al cliente.
 *
 * @var array{ok: string, error: string, datos: mixed[]}
 */
$respuesta = ['ok' => '', 'error' => '', 'datos' => []];

$conexion = new mysqli(
  $_ENV['DB_HOST'],
  $_ENV['DB_USERNAME'],
  $_ENV['DB_PASSWORD'],
);

$conexion->set_charset('utf8');

/*----------  Si no existe la base de datos, comienza la instalación  ----------*/
try {
  if (!$conexion->select_db($_ENV['DB_DATABASE'])) {
    throw new mysqli_sql_exception;
  }
} catch (mysqli_sql_exception) {
  $mostrarLoader = true;
}

/*----------  Instala la Base de Datos  ----------*/
if (array_key_exists('instalarBD', $_POST)) {
  $sql = file_get_contents(BASE_DIR . '/database/init.mysql.sql');

  exit($conexion->multi_query($sql ?: '') ? 'true' : $conexion->error);
}
