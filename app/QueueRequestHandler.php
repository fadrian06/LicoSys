<?php

declare(strict_types=1);

namespace App;

use NoDiscard;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class QueueRequestHandler implements RequestHandlerInterface
{
  /** @var MiddlewareInterface[] */
  private array $middlewares = [];

  public function __construct(
    private readonly RequestHandlerInterface $fallbackHandler,
  ) {}

  public function add(MiddlewareInterface $middleware): void
  {
    $this->middlewares[] = $middleware;
  }

  #[Override]
  #[NoDiscard]
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $middleware = array_shift($this->middlewares);

    return $middleware
      ? $middleware->process($request, $this)
      : $this->fallbackHandler->handle($request);
  }
}
