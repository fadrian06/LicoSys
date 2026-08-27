<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Database\Capsule\Manager;
use NoDiscard;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CleanCarts implements MiddlewareInterface
{
  public function __construct(private Manager $manager) {}

  #[Override]
  #[NoDiscard]
  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    $this->manager::table('carrito_venta')->delete();
    $this->manager::table('carrito_compra')->delete();

    return $handler->handle($request);
  }
}
