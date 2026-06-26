<?php

declare(strict_types=1);

use App\Http\Controllers\IndexController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Scripts;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseInterface;

use function App\get_exception_handler;

require_once __DIR__ . '/bootstrap/app.php';

$manager = Container::getInstance()->get(Manager::class);
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
Scripts::push($script);

if (!empty($_SESSION['userID'])) $_SESSION['userID'] = $admin['id'];

try {
  $manager::table('carrito_venta')->delete();
  $manager::table('carrito_compra')->delete();
} catch (PDOException $exception) {
  get_exception_handler()($exception);
}

function verificarCopiaDeSeguridad(): void
{
  if (file_exists(__DIR__ . '/backup/backup.sql'))
    Scripts::pushSrcOnce('./resources/build/restaurarBD.js');
}

/*----------  Si no hay negocios, solicita registro  ----------*/
if (!isset($mostrarLoader) and !$negocios):
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registrarNegocio.php';
  Scripts::pushSrcOnce('./resources/build/registrarNegocio.js');

/*----------  Si no hay administrador, solicita registro  ----------*/
elseif (!isset($mostrarLoader) and !$admin):
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registrarAdmin.php';
  Scripts::pushSrcOnce('./resources/build/registrarAdmin.js');

/*----------  Si el administrador no tiene preguntas secretas, solicita registro  ----------*/
elseif (!isset($mostrarLoader) and !$admin['pre1']):
  verificarCopiaDeSeguridad();
  $mostrarRegistro = true;
  include __DIR__ . '/templates/registroPreguntasRespuestas.php';
  Scripts::pushSrcOnce('./resources/build/registrarPreguntasRespuestas.js');

/*----------  Muestra el login  ----------*/
elseif (!isset($mostrarLoader)):
  $mostrarLogin = true;
  include __DIR__ . '/templates/login.php';
  include __DIR__ . '/templates/consultarPreguntasRespuestas.php';

  if (isset($_SESSION['showQuestions']))
    include __DIR__ . '/templates/preguntasRespuestas.php';

  if (isset($_SESSION['changePassword']))
    include __DIR__ . '/templates/cambiarClave.php';

  Scripts::pushSrcOnce('./resources/libs/typedjs/typed.min.js');
  Scripts::pushSrcOnce('./resources/build/reloj.js');
  Scripts::pushSrcOnce('./resources/build/login.js');
  Scripts::pushSrcOnce('./resources/build/recuperarClave.js');
endif;

include __DIR__ . '/templates/footer.php';
