<?php

/*======================================
=            LÓGICA INICIAL            =
======================================*/
session_start();

if (isset($_SESSION['activa'])) {
  header('location: dashboard.php');
}

include __DIR__ . '/templates/head.php';

if (!empty($_SESSION['userID'])) {
  $_SESSION['userID'] = $admin['id'];
}

setRegistro('TRUNCATE TABLE carrito_venta');
setRegistro('TRUNCATE TABLE carrito_compra');

function verificarCopiaDeSeguridad() {
  global $scriptss;

  if (file_exists('backup/backup.sql')) {
    $scriptss .= '<script src="assets/build/js/restaurarBD.js"></script>';
  }
}
/*=====  End of LÓGICA INICIAL  ======*/

/*----------  Si no hay negocios, solicita registro  ----------*/
if (!isset($mostrarLoader) and !$negocios) {
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registrarNegocio.php';
  $scripts .= '<script src="assets/build/js/registrarNegocio.js"></script>';

  /*----------  Si no hay administrador, solicita registro  ----------*/
} elseif (!isset($mostrarLoader) and !$admin) {
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registrarAdmin.php';
  $scripts .= '<script src="assets/build/js/registrarAdmin.js"></script>';

  /*----------  Si el administrador no tiene preguntas secretas, solicita registro  ----------*/
} elseif (!isset($mostrarLoader) and !$admin['pre1']) {
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registroPreguntasRespuestas.php';
  $scripts .= '<script src="assets/build/js/registrarPreguntasRespuestas.js"></script>';

  /*----------  Muestra el login  ----------*/
} elseif (!isset($mostrarLoader)) {
  $mostrarLogin = true;
  include __DIR__ . '/templates/login.php';
  include __DIR__ . '/templates/consultarPreguntasRespuestas.php';

  if (isset($_SESSION['showQuestions'])) {
    include __DIR__ . '/templates/preguntasRespuestas.php';
  }

  if (isset($_SESSION['changePassword'])) {
    include __DIR__ . '/templates/cambiarClave.php';
  }

  $scripts .= '<script src="assets/build/js/reloj.js"></script>';
  $scripts .= '<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>';
  $scripts .= '<script src="assets/build/js/login.js"></script>';
  $scripts .= '<script src="assets/build/js/recuperarClave.js"></script>';
}

include __DIR__ . '/templates/footer.php';
