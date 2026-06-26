<?php

declare(strict_types=1);

use App\Http\Controllers\IndexController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Scripts;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function App\getenv;

require_once __DIR__ . '/vendor/autoload.php';

Container::getInstance()->singletonIf(ResponseFactoryInterface::class, HttpFactory::class);
Container::getInstance()->singletonIf(ServerRequestInterface::class, ServerRequest::fromGlobals(...));

Container::getInstance()->singletonIf(Manager::class, static function (): Manager {
  $manager = new Manager(Container::getInstance());

  $manager->addConnection([
    'driver' => getenv('DB_CONNECTION'),
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
  ]);

  $manager->setAsGlobal();
  $manager->bootEloquent();

  return $manager;
});

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

$manager::table('carrito_venta')->delete();
$manager::table('carrito_compra')->delete();

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
