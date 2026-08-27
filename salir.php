<?php

declare(strict_types=1);

use App\Http\Controllers\LogoutController;
use App\QueueRequestHandler;
use Illuminate\Container\Container;
use Psr\Http\Message\ResponseInterface;

require_once __DIR__ . '/bootstrap/app.php';

$controller = Container::getInstance()->get(LogoutController::class);
$queueRequestHandler = new QueueRequestHandler($controller);
$response = Container::getInstance()->call($queueRequestHandler->handle(...));

if ($response instanceof ResponseInterface) {
  foreach ($response->getHeaders() as $name => $values) {
    header("$name: " . join(', ', $values));
  }

  echo $response->getBody();
}
