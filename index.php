<?php

declare(strict_types=1);

use App\NotFoundHandler;
use App\QueueRequestHandler;
use App\RoutingMiddleware;
use Illuminate\Container\Container;
use Psr\Http\Message\ResponseInterface;

require_once __DIR__ . '/bootstrap/app.php';

$container = Container::getInstance();
$notFoundHandler = $container->get(NotFoundHandler::class);
$queueRequestHandler = new QueueRequestHandler($notFoundHandler);

$middlewares = [
  new RoutingMiddleware($container, ...require __DIR__ . '/routes/web.php'),
];

foreach ($middlewares as $middleware) {
  $queueRequestHandler->add($middleware);
}

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
