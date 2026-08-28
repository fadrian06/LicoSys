<?php

declare(strict_types=1);

use App\BareUI;
use App\Http\Controllers\IndexController;
use App\Http\Middleware\CleanCarts;
use App\Http\Middleware\CreateDbIfNotExists;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\ShowAdminRegisterIfThereIsNoOneAdmin;
use App\Http\Middleware\ShowBusinessRegisterIfThereIsNoOneActiveBusiness;
use App\Http\Middleware\ShowRestoreDbToastIfThereIsOneBackup;
use App\QueueRequestHandler;
use App\Scripts;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseInterface;

require_once __DIR__ . '/bootstrap/app.php';

$manager = Container::getInstance()->get(Manager::class);
$controller = Container::getInstance()->get(IndexController::class);
$queueRequestHandler = new QueueRequestHandler($controller);

$middlewares = [
  Container::getInstance()->get(CreateDbIfNotExists::class),
  Container::getInstance()->get(RedirectIfAuthenticated::class),
  Container::getInstance()->get(CleanCarts::class),
  Container::getInstance()->get(ShowRestoreDbToastIfThereIsOneBackup::class),
  Container::getInstance()
    ->get(ShowBusinessRegisterIfThereIsNoOneActiveBusiness::class),
  Container::getInstance()->get(ShowAdminRegisterIfThereIsNoOneAdmin::class),
];

foreach ($middlewares as $middleware) {
  $queueRequestHandler->add($middleware);
}

$response = Container::getInstance()->call($queueRequestHandler->handle(...));

if ($response instanceof ResponseInterface) {
  foreach ($response->getHeaders() as $name => $values) {
    header("$name: " . join(', ', $values));
  }

  $body = (string) $response->getBody();

  if ($body) {
    echo $body;

    return;
  }
}

/*======================================
=            LÓGICA INICIAL            =
======================================*/
include __DIR__ . '/templates/head.php';

if (!empty($_SESSION['userID'])) $_SESSION['userID'] = $admin['id'];

$bareUi = Container::getInstance()->get(BareUI::class);
$bareUi::config('params', $GLOBALS);

/*----------  Si el administrador no tiene preguntas secretas, solicita registro  ----------*/
if (!isset($mostrarLoader) and !$admin['pre1']):
  echo $bareUi::render(
    'templates/registroPreguntasRespuestas.php',
    ['mostrarRegistro' => true],
  );

  Scripts::pushSrcOnce('./resources/build/registrarPreguntasRespuestas.js');

/*----------  Muestra el login  ----------*/
elseif (!isset($mostrarLoader)):
  $bareUi::setParam('mostrarLogin', true);
  echo $bareUi::render('templates/login.php');
  echo $bareUi::render('templates/consultarPreguntasRespuestas.php');

  if (isset($_SESSION['showQuestions']))
    echo $bareUi::render('templates/preguntasRespuestas.php');

  if (isset($_SESSION['changePassword']))
    echo $bareUi::render('templates/cambiarClave.php');

  Scripts::pushSrcOnce('./resources/libs/typedjs/typed.min.js');
  Scripts::pushSrcOnce('./resources/build/reloj.js');
  Scripts::pushSrcOnce('./resources/build/login.js');
  Scripts::pushSrcOnce('./resources/build/recuperarClave.js');
endif;

echo $bareUi::render('templates/footer.php', [
  'mostrarLoader' => $mostrarLoader ?? '',
]);
