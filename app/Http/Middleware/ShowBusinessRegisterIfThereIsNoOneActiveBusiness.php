<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\BareUI;
use App\Scripts;
use Illuminate\Database\Capsule\Manager;
use NoDiscard;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ShowBusinessRegisterIfThereIsNoOneActiveBusiness
implements MiddlewareInterface
{
  public function __construct(
    private ResponseFactoryInterface $responseFactory,
    private Manager $manager,
    private BareUI $bareUI,
  ) {}

  #[Override]
  #[NoDiscard]
  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    if ($this->manager::table('negocios')->where('activo', true)->count()) {
      return $handler->handle($request);
    }

    Scripts::pushSrcOnce('./resources/build/registrarNegocio.js');

    $response = $this->responseFactory->createResponse();

    $response
      ->getBody()
      ->write($this->bareUI::render('resources/views/components/layout.php', [
        'slot' => $this->bareUI::render('templates/registrarNegocio.php', [
          'mostrarRegistro' => true,
        ]),
      ]));

    return $response;
  }
}
