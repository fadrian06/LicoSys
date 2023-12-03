<?php

/** @var array Respuesta del servidor al cliente. */
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

// ONLINE - 000webhost.com
// const USUARIO = 'id20496120_fsanchez';
// const CLAVE = 'tGB73Jd}mgcO$4I=';
// const BD = 'id20496120_licosys';

try {
  $conexion = new MySQLi(HOST, USUARIO, CLAVE);
  $conexion->set_charset(CHARSET);
} catch (mysqli_sql_exception $error) {
  exit("Error, no se pudo conectar a MySQL: <b>{$error->getMessage()}</b><br>");
}

/*----------  Si no existe la base de datos, comienza la instalación  ----------*/
try {
  $conexion->select_db(BD);
} catch (mysqli_sql_exception) {
  $mostrarLoader = '<script src="js/loader.js"></script>';
}

/*----------  Instala la Base de Datos  ----------*/
if (!empty($_POST['instalarBD'])) :
  $sql = file_get_contents(__DIR__ . '/init.sql');
  exit($conexion->multi_query($sql) ? 'true' : $conexion->error);
endif;
