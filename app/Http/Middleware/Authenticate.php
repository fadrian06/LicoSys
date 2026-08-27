<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Database\Capsule\Manager;
use NoDiscard;
use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class Authenticate implements MiddlewareInterface
{
  public function __construct(
    private ResponseFactoryInterface $responseFactory,
    private Manager $manager,
  ) {}

  #[Override]
  #[NoDiscard]
  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    if (!$this->manager::table('usuarios')->find($_SESSION['userID'])) {
      return $this->responseFactory->createResponse()->withHeader(
        'location',
        './salir.php',
      );
    }

    return $handler->handle($request);
  }
}
