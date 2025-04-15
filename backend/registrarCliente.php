<?php

declare(strict_types=1);

session_start();

if ($_POST !== []) :
  require __DIR__ . '/conexion.php';
  require __DIR__ . '/funciones.php';

  $cedula = (int) $_POST['cedula'];
  $nombre = escapar(capitalize($_POST['nombre']));

  if ($cedula === 0 || ($nombre === '' || $nombre === '0')) {
    $respuesta['error'] = 'Lá cédula y el nombre son requeridos.';
  }

  $clienteEncontrado = getRegistro('SELECT cedula FROM clientes WHERE cedula=' . $cedula);
  if ($clienteEncontrado !== null && $clienteEncontrado !== []) {
    $respuesta['error'] = 'Ya existe un cliente con ésta cédula.';
  }

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $sql = sprintf(
    "INSERT INTO clientes(cedula, nombre, usuario_id) VALUES(%d, '%s', %s)",
    $cedula,
    $nombre,
    $_SESSION['userID']
  );

  $resultado = setRegistro($sql);

  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  $respuesta['ok'] = 'Cliente registrado exitósamente.';

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
