<?php

if ($_POST !== []):
  require __DIR__ . '/conexion.php';
  require __DIR__ . '/funciones.php';

  /** @var string La tabla a la que pertenece el registro. */
  $tabla = escapar($_POST['tabla']);
  /** @var string Campo que identifica cada registro. */
  $campo = escapar($_POST['campo']);
  /** @var string Valor único de cada registro. */
  $valor = (int) escapar($_POST['valor']);
  /** @var string 'activar' | 'desactivar' */
  $accion = escapar($_POST['accion']);

  switch ($tabla):
    case 'usuarios':
      $respuesta['ok'] = 'Usuario ';
      break;
    case 'negocios':
      $respuesta['ok'] = 'Negocio ';
      break;
  endswitch;

  switch ($accion):
    case 'activar':
      $sql = sprintf('UPDATE %s SET activo=1 WHERE %s=%s', $tabla, $campo, $valor);
      $respuesta['ok'] .= 'activado exitósamente.';
      break;
    case 'desactivar':
      $sql = sprintf('UPDATE %s SET activo=0 WHERE %s=%s', $tabla, $campo, $valor);
      $respuesta['ok'] .= 'desactivado exitósamente.';
      break;
    default:
      $respuesta['error'] = "Por favor envie una opción ('activar' o 'desactivar')";
  endswitch;

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $resultado = setRegistro($sql);
  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
