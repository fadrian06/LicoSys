<?php

declare(strict_types=1);

namespace App;

use NoDiscard;
use Override;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

final class RoutingMiddleware implements
  MiddlewareInterface,
  LoggerAwareInterface
{
  use LoggerAwareTrait;

  /** @var Route[] */
  private readonly array $routes;

  public function __construct(
    private readonly ContainerInterface $container,
    Route ...$routes,
  ) {
    $this->routes = $routes;
  }

  #[Override]
  #[NoDiscard]
  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    foreach ($this->routes as $route) {
      if (!in_array($request->getMethod(), $route->methods)) {
        continue;
      }

      if ($route->pattern === $request->getUri()->getPath()) {
        return $route->handle($request, $this->container);
      }

      @preg_match($route->pattern, $request->getUri()->getPath(), $matches);

      if (!$matches) {
        continue;
      }

      foreach ($matches as $name => $value) {
        if (is_string($name)) {
          $request = $request->withAttribute($name, $value);
        }
      }

      return $route->handle($request, $this->container);
    }

    return $handler->handle($request);
  }
}
