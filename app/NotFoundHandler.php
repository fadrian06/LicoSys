<?php

declare(strict_types=1);

namespace App;

use NoDiscard;
use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class NotFoundHandler implements RequestHandlerInterface
{
  public function __construct(
    private ResponseFactoryInterface $responseFactory,
  ) {}

  #[Override]
  #[NoDiscard]
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    return $this->responseFactory->createResponse(404);
  }
}
