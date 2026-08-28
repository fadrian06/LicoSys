<?php

declare(strict_types=1);

namespace App;

use NoDiscard;
use Override;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class QueueRequestHandler implements RequestHandlerInterface
{
  /** @var class-string<MiddlewareInterface>[] */
  private array $middlewares = [];

  /** @param class-string<RequestHandlerInterface> $fallbackHandler */
  public function __construct(
    private readonly ContainerInterface $container,
    private readonly string $fallbackHandler,
  ) {}

  /** @param class-string<MiddlewareInterface> $middleware */
  public function add(string $middleware): void
  {
    $this->middlewares[] = $middleware;
  }

  #[Override]
  #[NoDiscard]
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $middleware = array_shift($this->middlewares);

    if ($middleware) {
      $middleware = $this->container->get($middleware);

      if ($middleware instanceof LoggerAwareInterface) {
        $middleware->setLogger($this->getLogger());
      }

      if ($middleware instanceof MiddlewareInterface) {
        return $middleware->process($request, $this);
      }
    }

    /** @var RequestHandlerInterface */
    $handler = $this->container->get($this->fallbackHandler);

    if ($handler instanceof LoggerAwareInterface) {
      $handler->setLogger($this->getLogger());
    }

    return $handler->handle($request);
  }

  private function getLogger(): LoggerInterface
  {
    return $this->container->has(LoggerInterface::class)
      ? $this->container->get(LoggerInterface::class)
      : new NullLogger;
  }
}
