<?php

declare(strict_types=1);

namespace App;

use NoDiscard;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Override;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Route implements RequestHandlerInterface
{
  /**
   * @param string[] $methods
   * @param class-string<RequestHandlerInterface> $handler
   * @param class-string<MiddlewareInterface>[] $middlewares
   */
  public function __construct(
    public readonly array $methods,
    public readonly string $pattern,
    private readonly string $handler,
    private array $middlewares,
  ) {}

  #[Override]
  #[NoDiscard]
  public function handle(
    ServerRequestInterface $request,
    ?ContainerInterface $container = null,
  ): ResponseInterface {
    static $container = $container;

    $middleware = array_shift($this->middlewares);

    return $middleware
      ? $container->get($middleware)->process($request, $this)
      : $container->get($this->handler)->handle($request);
  }
}
