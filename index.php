<?php

declare(strict_types=1);

use App\Http\Controllers\IndexController;
use App\Http\Middleware\RedirectIfAuthenticated;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Container\Container;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

require_once __DIR__ . '/vendor/autoload.php';

Container::getInstance()->singletonIf(ResponseFactoryInterface::class, HttpFactory::class);
Container::getInstance()->singletonIf(ServerRequestInterface::class, ServerRequest::fromGlobals(...));

$redirectIfAuthenticated = Container::getInstance()->get(RedirectIfAuthenticated::class);
$indexController = Container::getInstance()->get(IndexController::class);
$response = Container::getInstance()->call($redirectIfAuthenticated->process(...), ['handler' => $indexController]);

if ($response instanceof ResponseInterface) {
  foreach ($response->getHeaders() as $name => $values) {
    header("$name: " . join(', ', $values));
  }

  echo $response->getBody();
}

/*======================================
=            LÓGICA INICIAL            =
======================================*/
include __DIR__ . '/templates/head.php';

if (!empty($_SESSION['userID'])) $_SESSION['userID'] = $admin['id'];

setRegistro('TRUNCATE TABLE carrito_venta');
setRegistro('TRUNCATE TABLE carrito_compra');

function verificarCopiaDeSeguridad(): void
{
  global $script;

  if (file_exists(__DIR__ . '/backup/backup.sql'))
    $script .= '<script src="resources/build/restaurarBD.js"></script>';
}

/*----------  Si no hay negocios, solicita registro  ----------*/
if (!isset($mostrarLoader) and !$negocios):
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registrarNegocio.php';
  $script .= '<script src="./resources/build/registrarNegocio.js"></script>';

/*----------  Si no hay administrador, solicita registro  ----------*/
elseif (!isset($mostrarLoader) and !$admin):
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registrarAdmin.php';
  $script .= '<script src="./resources/build/registrarAdmin.js"></script>';

/*----------  Si el administrador no tiene preguntas secretas, solicita registro  ----------*/
elseif (!isset($mostrarLoader) and !$admin['pre1']):
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registroPreguntasRespuestas.php';
  $script .= '<script src="./resources/build/registrarPreguntasRespuestas.js"></script>';

/*----------  Muestra el login  ----------*/
elseif (!isset($mostrarLoader)):
  $mostrarLogin = true;
  include __DIR__ . '/templates/login.php';
  include __DIR__ . '/templates/consultarPreguntasRespuestas.php';

  if (isset($_SESSION['showQuestions']))
    include __DIR__ . '/templates/preguntasRespuestas.php';

  if (isset($_SESSION['changePassword']))
    include __DIR__ . '/templates/cambiarClave.php';

  $script .= '<script src="./resources/libs/typedjs/typed.min.js"></script>';
  $script .= '<script src="./resources/build/reloj.js"></script>';
  $script .= '<script src="./resources/build/login.js"></script>';
  $script .= '<script src="./resources/build/recuperarClave.js"></script>';
endif;

include __DIR__ . '/templates/footer.php';
