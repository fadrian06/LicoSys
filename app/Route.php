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
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class Route implements RequestHandlerInterface
{
  private static ?ContainerInterface $container = null;

  /**
   * @param string[] $methods
   * @param class-string<RequestHandlerInterface> $handler
   * @param class-string<MiddlewareInterface>[] $middlewares
   */
  public function __construct(
    public readonly array $methods,
    public readonly string $pattern,
    private readonly string $handler,
    private array $middlewares = [],
  ) {}

  #[Override]
  #[NoDiscard]
  public function handle(
    ServerRequestInterface $request,
    ?ContainerInterface $container = null,
  ): ResponseInterface {
    if (!self::$container && $container) {
      self::$container = $container;
    }

    $middleware = array_shift($this->middlewares);

    if ($middleware) {
      $middleware = self::$container->get($middleware);

      if ($middleware instanceof LoggerAwareInterface) {
        $middleware->setLogger($this->getLogger());
      }

      if ($middleware instanceof MiddlewareInterface) {
        return $middleware->process($request, $this);
      }
    }

    /** @var RequestHandlerInterface */
    $handler = self::$container->get($this->handler);

    if ($handler instanceof LoggerAwareInterface) {
      $handler->setLogger($this->getLogger());
    }

    return $handler->handle($request);
  }

  private static function getLogger(): LoggerInterface
  {
    return self::$container->has(LoggerInterface::class)
      ? self::$container->get(LoggerInterface::class)
      : new NullLogger;
  }
}
