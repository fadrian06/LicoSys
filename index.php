<?php

declare(strict_types=1);

use App\Http\Controllers\IndexController;
use App\Http\Middleware\CleanCarts;
use App\Http\Middleware\CreateDbIfNotExists;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\ShowAdminRegisterIfThereIsNoOneAdmin;
use App\Http\Middleware\ShowBusinessRegisterIfThereIsNoOneActiveBusiness;
use App\Http\Middleware\ShowRestoreDbToastIfThereIsOneBackup;
use App\Http\Middleware\ShowSecretQuestionsRegisterIfAdminHasNot;
use App\QueueRequestHandler;
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
  Container::getInstance()
    ->get(ShowSecretQuestionsRegisterIfAdminHasNot::class),
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
