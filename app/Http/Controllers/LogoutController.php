<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use NoDiscard;
use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class LogoutController implements RequestHandlerInterface
{
  public function __construct(
    private ResponseFactoryInterface $responseFactory,
  ) {}

  #[Override]
  #[NoDiscard]
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    session_destroy();

    return $this->responseFactory->createResponse()->withHeader(
      'location',
      './',
    );
  }
}
