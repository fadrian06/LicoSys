<?php

declare(strict_types=1);

use Leaf\Http\Session;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

if (!empty($_POST['consultar'])) :
  $cedula = (int) $_POST['cedula'];
  $usuario = escapar($_POST['usuario']);

  /*----------  VALIDACIONES  ----------*/
  if ($cedula === 0 || ($usuario === '' || $usuario === '0')) {
    $respuesta['error'] = 'Por favor introduzca su cédula y usuario.';
  }

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $sql = <<<SQL
      SELECT id, pre1, pre2, pre3, res1, activo
      FROM usuarios WHERE cedula={$cedula} AND BINARY(usuario)=BINARY('{$usuario}')
    SQL;
  $filaUsuario = getRegistro($sql);

  if ($filaUsuario === null || $filaUsuario === []) {
    $respuesta['error'] = 'Cédula o usuario incorrecto, <strong>(verifique mayúsculas y minúsculas)</strong>';
  } elseif (!$filaUsuario['activo']) {
    $respuesta['error'] = 'Este usuario se encuentra desactivado.';
  } elseif (!$filaUsuario['res1']) {
    $respuesta['error'] = 'Este usuario no tiene <strong>Preguntas y Respuestas</strong> registradas.';
  } else {
    Session::set('userID', $filaUsuario['id']);
    Session::set('pre1', $filaUsuario['pre1']);
    Session::set('pre2', $filaUsuario['pre2']);
    Session::set('pre3', $filaUsuario['pre3']);
    Session::set('showQuestions', true);
  }

  if ($respuesta['error']) :
    Session::destroy();
    Session::set('userID', $filaUsuario['id'] ?? null);
  endif;

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;

if (!empty($_POST['verificarRespuestas'])) :
  $id = (int) $_POST['id'];
  $res1 = escapar($_POST['res1']);
  $res2 = escapar($_POST['res2']);
  $res3 = escapar($_POST['res3']);

  $sql = 'SELECT id, usuario, res1, res2, res3 FROM usuarios WHERE id=' . $id;
  $filaUsuario = getRegistro($sql);

  if (
    !password_verify($res1, strval($filaUsuario['res1'] ?? ''))
    || !password_verify($res2, strval($filaUsuario['res2'] ?? ''))
    || !password_verify($res3, strval($filaUsuario['res3'] ?? ''))
  ) {
    $respuesta['error'] = 'Respuestas incorrectas.';
  }

  Session::remove('showQuestions');

  if (!$respuesta['error']) {
    Session::set('changePassword', true);
  }

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;

if (!empty($_POST['cambiarClave'])) :
  $id = (int) $_POST['id'];
  $clave     = escapar($_POST['clave']);
  $confirmar = escapar($_POST['confirmar']);

  /*----------  VALIDACIONES  ----------*/
  if ($clave === '' || $clave === '0' || ($confirmar === '' || $confirmar === '0')) {
    $respuesta['error'] = 'Por favor ingrese una contraseña.';
  } elseif ($clave !== $confirmar) {
    $respuesta['error'] = 'Ambas contraseñas deben ser iguales.';
  }

  if ($respuesta['error']) :
    Session::remove('changePassword');

    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  endif;

  $clave = encriptar($clave);
  $sql = sprintf("UPDATE usuarios SET clave='%s' WHERE id=%d", $clave, $id);
  $resultado = setRegistro($sql);

  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  session_destroy();
  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;

if (!empty($_POST['cerrar'])) {
  exit(session_destroy() ? 'Sesión destruida correctamente' : 'Ha ocurrido un error');
}
