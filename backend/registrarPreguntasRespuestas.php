<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

if ($_POST !== []) :
  $pre1 = escapar(capitalize($_POST['pre1']));
  $pre2 = escapar(capitalize($_POST['pre2']));
  $pre3 = escapar(capitalize($_POST['pre3']));
  $res1 = escapar($_POST['res1']);
  $res2 = escapar($_POST['res2']);
  $res3 = escapar($_POST['res3']);

  $res1 = $_POST['res1'] ? encriptar($res1) : '';
  $res2 = $_POST['res2'] ? encriptar($res2) : '';
  $res3 = $_POST['res3'] ? encriptar($res3) : '';

  $sql = "
    UPDATE usuarios SET pre1='{$pre1}', pre2='{$pre2}', pre3='{$pre3}',
    res1='{$res1}', res2='{$res2}', res3='{$res3}' WHERE cargo='a'
  ";

  $resultado = setRegistro($sql);

  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
