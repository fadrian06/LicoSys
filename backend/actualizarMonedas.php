<?php

if ($_POST !== []):
  require __DIR__ . '/conexion.php';
  require __DIR__ . '/funciones.php';

  $nuevoIVA = $_POST['iva'] < 1
    ? (float) $_POST['iva']
    : (float) $_POST['iva'] / 100;

  $nuevoDolar = round($_POST['dolar'], 2);
  $nuevoPeso = (int) $_POST['pesos'];

  /*----------  VALIDACIONES  ----------*/
  if (!$nuevoIVA || !$nuevoDolar || !$nuevoPeso) {
    $respuesta['error'] = 'Por favor rellene los campos.';
  }

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $sqlIVA = sprintf("INSERT INTO iva(valor) VALUES('%s')", $nuevoIVA);
  $sqlDolar = sprintf("INSERT INTO dolar(valor) VALUES('%s')", $nuevoDolar);
  $sqlPeso = sprintf("INSERT INTO peso(valor) VALUES('%d')", $nuevoPeso);

  if (!setRegistro($sqlIVA) || !setRegistro($sqlDolar) || !setRegistro($sqlPeso)) {
    $respuesta['error'] = json_encode($conexion->error_list, JSON_INVALID_UTF8_IGNORE);
  }

  $respuesta['ok'] = 'Valores actualizados correctamente.';
  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
