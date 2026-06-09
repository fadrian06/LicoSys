<?php

declare(strict_types=1);

use Leaf\Http\Session;

if ($_POST !== []) :
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/conexion.php';
  require_once __DIR__ . '/funciones.php';

  $codigo = escapar(strtoupper(strval($_POST['codigo'])));
  $producto = escapar(capitalize($_POST['nombre']));
  $precio = (float) $_POST['precio'];
  $excento = (int) $_POST['excento'];
  $stock = (int) $_POST['stock'];

  /*----------  VALIDACIONES  ----------*/
  if ($codigo === '' || $codigo === '0' || ($producto === '' || $producto === '0') || !$precio) {
    $respuesta['error'] = 'El código, nombre, precio y excento son requeridos.';
  } elseif ($excento < 0 || $excento > 1) {
    $respuesta['error'] = 'Excento sólo puede ser SI o NO.';
  }

  $productoEncontrado = getRegistro(sprintf("SELECT codigo FROM inventario WHERE codigo='%s'", $codigo));
  if ($productoEncontrado !== null && $productoEncontrado !== []) {
    $respuesta['error'] = 'Ya existe un producto con ese código.';
  }

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $negocioId = Session::get('negocioID');
  $userId = Session::get('userID');

  $sql = "
    INSERT INTO inventario(
      codigo, producto, stock, excento, precio, negocio_id, usuario_id
    ) VALUES(
      '{$codigo}', '{$producto}', {$stock}, {$excento}, {$precio},
      {$negocioId}, {$userId}
    )
  ";

  $resultado = setRegistro($sql);

  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  $respuesta['ok'] = 'Producto registrado exitósamente.';

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
