<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class Authenticate implements MiddlewareInterface
{
  public function __construct(private ResponseFactoryInterface $responseFactory) {}

  #[Override]
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    if (empty($_SESSION['activa'])) {
      return $this->responseFactory->createResponse()->withHeader('location', './');
    }

    return $handler->handle($request);
  }
}
