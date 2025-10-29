<?php

declare(strict_types=1);

use Leaf\Http\Session;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

/*=================================================
=            Actualizar foto de perfil            =
=================================================*/
if (!empty($_FILES['foto']['name'])) :
  $foto = empty($_FILES['foto']) ? ['error' => 4] : (array) $_FILES['foto'];
  $imagen = '';

  if ($foto['error'] !== 4) :
    $sql    = 'SELECT foto FROM usuarios WHERE id=' . Session::get('userID');
    $imagen = (string) (getRegistro($sql) ?? [])['foto'];

    if ($imagen === '' || $imagen === '0') {
      $imagen = (string) $foto['name'];
    }

    $tipo   = (string) $foto['type'];
    $peso   = (int) $foto['size'];
    $rutaOrigen = (string) $foto['tmp_name'];
    $rutaDestino = '../assets/images/perfil/' . $imagen;
    $respuesta['datos'] = ['nombre' => $imagen, 'ruta' => $rutaDestino];

    if ($tipo !== 'image/jpeg' && $tipo !== 'image/jpg' && $tipo !== 'image/png') {
      $respuesta['error'] = 'Sólo se permite imagenes JPG y PNG';
    } elseif ($peso > (1024 * 2048)) {
      $respuesta['error'] = 'La imagen no puede ser mayor a 2MB';
    } else {
      move_uploaded_file($rutaOrigen, $rutaDestino);
    }
  endif;

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $sql = sprintf("UPDATE usuarios SET foto='%s' WHERE id=%s", $imagen, Session::get('userID'));
  $resultado = setRegistro($sql);

  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  $respuesta['ok'] = 'Imagen actualizada exitósamente.';
  Session::set('userFoto', 'assets/images/perfil/' . $imagen);

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;

/*==================================================
=            Actualizar logo de negocio            =
==================================================*/
if (!empty($_FILES['logo']['name'])) :
  $id = (int) $_POST['id'];
  $foto = empty($_FILES['logo']) ? ['error' => 4] : (array) $_FILES['logo'];
  $imagen = '';

  if ($foto['error'] !== 4) :
    $sql    = 'SELECT logo FROM negocios WHERE id=' . $id;
    $imagen = (string) (getRegistro($sql) ?? [])['logo'];
    if ($imagen === '' || $imagen === '0') {
      $imagen = (string) $foto['name'];
    }

    $tipo   = (string) $foto['type'];
    $peso   = (int) $foto['size'];
    $rutaOrigen = (string) $foto['tmp_name'];
    $rutaDestino = '../assets/images/negocios/' . $imagen;

    if ($tipo !== 'image/jpeg' && $tipo !== 'image/jpg' && $tipo !== 'image/png') {
      $respuesta['error'] = 'Sólo se permite imagenes JPG y PNG';
    } elseif ($peso > (1024 * 2048)) {
      $respuesta['error'] = 'La imagen no puede ser mayor a 2MB';
    } else {
      move_uploaded_file($rutaOrigen, $rutaDestino);
    }
  endif;

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $sql = sprintf("UPDATE negocios SET logo='%s' WHERE id=%d", $imagen, $id);
  $resultado = setRegistro($sql);

  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  $respuesta['ok'] = 'Imagen actualizada exitósamente.';

  if ($id === Session::get('negocioID')) {
    Session::set('negocioLogo', 'assets/images/negocios/' . $imagen);
  }

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
