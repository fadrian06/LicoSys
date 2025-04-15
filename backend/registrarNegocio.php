<?php

declare(strict_types=1);

if ($_POST !== []):
  require __DIR__ . '/conexion.php';
  require __DIR__ . '/funciones.php';

  $nombre    = escapar(capitalize($_POST['nombreNegocio']));
  $rif       = escapar(strtoupper(strval($_POST['rif'])));
  $telefono  = escapar($_POST['telefono']);
  $direccion = escapar($_POST['direccion']);
  $logo      = (array) $_FILES['logo'];
  $imagen = '';
  /*----------  VALIDACIONES  ----------*/
  if ($nombre === '' || $nombre === '0' || ($rif === '' || $rif === '0')) {
    $respuesta['error'] = 'Por favor rellene los campos';
  }

  $negocioEncontrado = getRegistro(sprintf("SELECT rif FROM negocios WHERE rif='%s'", $rif));
  if ($negocioEncontrado !== null && $negocioEncontrado !== []) {
    $respuesta['error'] = 'Ya existe un negocio con este RIF';
  }

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  if ($logo['error'] !== 4):
    $imagen = (string) $logo['name'];
    $tipo   = (string) $logo['type'];
    $peso   = (int) $logo['size'];
    $rutaOrigen  = (string) $logo['tmp_name'];
    $rutaDestino = '../assets/images/negocios/' . $imagen;

    if ($tipo !== 'image/jpeg' && $tipo !== 'image/jpg' && $tipo !== 'image/png') {
      $respuesta['error'] = "Sólo se permite imagenes JPG y PNG";
    } elseif ($peso > (1000 * 1024 * 2)) {
      /*1b * 1000 = 1kb * 1024 = 1mb * 2 = :D*/
      $respuesta['error'] = 'La imagen no puede ser mayor a 2MB';
    } else {
      move_uploaded_file($rutaOrigen, $rutaDestino);
    }
  endif;

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $sql = sprintf("INSERT INTO negocios VALUES(null, '%s', '%s', '%s', '%s', '%s', 1)", $nombre, $rif, $telefono, $direccion, $imagen);
  $resultado = setRegistro($sql);
  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  $respuesta['ok'] = 'Negocio registrado exitósamente.';
  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
