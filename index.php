<?php

declare(strict_types=1);

use App\NotFoundHandler;
use App\QueueRequestHandler;
use App\RoutingMiddleware;
use Illuminate\Container\Container;
use Psr\Http\Message\ResponseInterface;

require_once __DIR__ . '/bootstrap/app.php';

$container = Container::getInstance();
$queueRequestHandler = new QueueRequestHandler($container, NotFoundHandler::class);
$queueRequestHandler->add(RoutingMiddleware::class);
$response = $container->call($queueRequestHandler->handle(...));

if ($response instanceof ResponseInterface) {
  http_response_code($response->getStatusCode());

  foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
      header("$name: $value", false);
    }
  }

  echo $response->getBody();
}
