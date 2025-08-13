<?php

declare(strict_types=1);

use Leaf\BareUI;
use Leaf\Http\Session;

require_once __DIR__ . '/vendor/autoload.php';

/*======================================
=            LÓGICA INICIAL            =
======================================*/
if (Session::has('activa')) {
  header('location: dashboard.php');
}

include BASE_DIR . '/templates/head.php';

if (!empty(Session::get('userID'))) {
  Session::set('userID', $admin['id']);
}

setRegistro('TRUNCATE TABLE carrito_venta');
setRegistro('TRUNCATE TABLE carrito_compra');
/*=====  End of LÓGICA INICIAL  ======*/

/*----------  Si no hay negocios, solicita registro  ----------*/
if (!isset($mostrarLoader) && !$negocios) :
  verificarCopiaDeSeguridad($script);
  $mostrarRegistro = true;
  echo BareUI::render('pages/business/create');
  $script .= '<script src="./assets/dist/registrarNegocio.js"></script>';

/*----------  Si no hay administrador, solicita registro  ----------*/
elseif (!isset($mostrarLoader) && !$admin) :
  verificarCopiaDeSeguridad($script);
  echo BareUI::render('pages/users/create');
  $script .= '<script src="./assets/dist/registrarAdmin.js"></script>';

/*----------  Si el administrador no tiene preguntas secretas, solicita registro  ----------*/
elseif (!isset($mostrarLoader) && !$admin['pre1']) :
  verificarCopiaDeSeguridad($script);
  echo BareUI::render('pages/create-secret-questions');
  $script .= '<script src="./assets/dist/registrarPreguntasRespuestas.js"></script>';

/*----------  Muestra el login  ----------*/
elseif (!isset($mostrarLoader)) :
  echo BareUI::render('pages/login');
  include __DIR__ . '/templates/consultarPreguntasRespuestas.php';

  if (Session::has('showQuestions')) {
    include __DIR__ . '/templates/preguntasRespuestas.php';
  }

  if (Session::has('changePassword')) {
    include __DIR__ . '/templates/cambiarClave.php';
  }

  $script .= '<script src="./assets/dist/reloj.js"></script>';
  $script .= '<script src="./assets/libs/typedjs/typed.min.js"></script>';
  $script .= '<script src="./assets/dist/login.js"></script>';
  $script .= '<script src="./assets/dist/recuperarClave.js"></script>';
endif;

include __DIR__ . '/templates/footer.php';
