<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class IndexController implements RequestHandlerInterface
{
  public function __construct(
    private ResponseFactoryInterface $responseFactory,
  ) {}

  #[Override]
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $response = $this->responseFactory->createResponse();
    $response->getBody()->write(ob_get_clean());

    return $response;
  }
}
