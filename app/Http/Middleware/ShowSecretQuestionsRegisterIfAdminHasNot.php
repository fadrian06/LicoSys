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

final readonly class ShowSecretQuestionsRegisterIfAdminHasNot implements
  MiddlewareInterface
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
    if (
      $this
      ->manager::table('usuarios')
      ->where('cargo', 'a')
      ->whereNotNull('pre1')
      ->count()
    ) {
      return $handler->handle($request);
    }

    Scripts::pushSrcOnce('./resources/build/registrarPreguntasRespuestas.js');

    $response = $this->responseFactory->createResponse();

    $response
      ->getBody()
      ->write($this->bareUI::render('resources/views/components/layout.php', [
        'slot' => $this->bareUI::render(
          'templates/registroPreguntasRespuestas.php',
          ['mostrarRegistro' => true],
        ),
      ]));

    return $response;
  }
}
