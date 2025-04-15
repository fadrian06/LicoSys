<?php

declare(strict_types=1);

use Leaf\Http\Session;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

if (!empty($_POST['verificarUsuario'])) :
  $usuario = escapar($_POST['usuario']);

  /*----------  VALIDACIONES  ----------*/
  if ($usuario === '' || $usuario === '0') {
    $respuesta['error'] = 'El usuario no puede estar vacío';
  }

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $sql = sprintf("SELECT usuario FROM usuarios WHERE BINARY(usuario)=BINARY('%s')", $usuario);
  $filaUsuario = getRegistro($sql);

  if ($filaUsuario === null || $filaUsuario === []) {
    $respuesta['error'] = 'Usuario no existe, (verifique mayúsculas y minúsculas)';
  }

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;

if (!empty($_POST['login'])) :
  $usuario = escapar($_POST['usuario']);
  $clave = escapar($_POST['clave']);
  $idNegocio = (int) $_POST['negocio'];

  /*----------  VALIDACIONES  ----------*/
  if ($idNegocio === 0) {
    $respuesta['error'] = 'Por favor seleccione un negocio';
  }

  if ($usuario === '' || $usuario === '0' || ($clave === '' || $clave === '0')) {
    $respuesta['error'] = 'Por favor introduzca un usuario y una contraseña';
  }

  $sql = <<<SQL
      SELECT * FROM usuarios WHERE BINARY(usuario)=BINARY('{$usuario}')
    SQL;
  $filaUsuario = getRegistro($sql) ?? [];

  $sql = 'SELECT id, logo, nombre FROM negocios WHERE id=' . $idNegocio;
  $negocioSeleccionado = getRegistro($sql) ?? [];

  if ($filaUsuario === []) {
    $respuesta['error'] = 'Usuario no existe, (verifique mayúsculas y minúsculas)';
  } elseif (!password_verify($clave, strval($filaUsuario['clave']))) {
    $respuesta['error'] = 'Contraseña incorrecta';
  } elseif (!$filaUsuario['activo']) {
    $respuesta['error'] = 'Este usuario se encuentra desactivado';
  }

  if ($filaUsuario['cargo'] === 'v') :
    $sql = sprintf(
      'INSERT INTO log(usuario_id, negocio_id) VALUES(%s, %s)',
      $filaUsuario['id'],
      $negocioSeleccionado['id']
    );

    $resultado = setRegistro($sql);

    if ($resultado === null || $resultado === 0) {
      $respuesta['error'] = $conexion->error;
    }
  endif;

  if ($respuesta['error']) :
    session_destroy();
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  endif;

  /*----------  FIN DE VALIDACIONES  ----------*/
  Session::set('activa', true);
  Session::set('user', $filaUsuario['usuario']);
  Session::set('userName', $filaUsuario['nombre']);
  Session::set('userID', $filaUsuario['id']);
  Session::set('userCedula', $filaUsuario['cedula']);
  Session::set('cargo', $filaUsuario['cargo']);

  Session::set(
    'userFoto',
    $filaUsuario['foto']
      ? 'assets/images/perfil/' . $filaUsuario['foto']
      : 'assets/images/avatar3.png'
  );

  Session::set('userTlf', $filaUsuario['telefono'] ?: 'No especificado');
  Session::set('negocio', $negocioSeleccionado['nombre']);
  Session::set('negocioID', $negocioSeleccionado['id']);

  Session::set(
    'negocioLogo',
    $negocioSeleccionado['logo']
      ? 'assets/images/negocios/' . $negocioSeleccionado['logo']
      : 'assets/images/logoNegocio.jpg'
  );

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
