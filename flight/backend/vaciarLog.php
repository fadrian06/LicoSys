<?php

declare(strict_types=1);

use Leaf\Http\Session;

if (!empty($_POST['vaciar'])) :
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/conexion.php';
  require_once __DIR__ . '/funciones.php';

  if (!Session::has('activa') && Session::get('cargo') !== 'a') {
    $respuesta['error'] = 'No tienes los permisos necesarios';
  }

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $resultado = setRegistro('TRUNCATE TABLE log');

  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  $respuesta['ok'] = 'Registro vaciado exitósamente.';
  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
