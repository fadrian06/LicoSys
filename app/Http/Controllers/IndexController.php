<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\BareUI;
use App\Scripts;
use Illuminate\Database\Capsule\Manager;
use NoDiscard;
use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class IndexController implements RequestHandlerInterface
{
  public function __construct(
    private ResponseFactoryInterface $responseFactory,
    private Manager $manager,
    private BareUI $bareUI,
  ) {}

  #[Override]
  #[NoDiscard]
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $admin = $this->manager::table('usuarios')->where('cargo', 'a')->first();

    if (!empty($_SESSION['userID'])) {
      $_SESSION['userID'] = $admin->id;
    }

    Scripts::pushSrcOnce('./resources/libs/typedjs/typed.min.js');
    Scripts::pushSrcOnce('./resources/build/reloj.js');
    Scripts::pushSrcOnce('./resources/build/login.js');
    Scripts::pushSrcOnce('./resources/build/recuperarClave.js');

    $this->bareUI::setParam('mostrarLogin', true);

    $this->bareUI::setParam(
      'negocios',
      $this
        ->manager::table('negocios')
        ->where('activo', true)
        ->get()
        ->toArray(),
    );

    $this->bareUI::setParam(
      'admin',
      $this
        ->manager::table('usuarios')
        ->where('cargo', 'a')
        ->first(),
    );

    $slot = $this->bareUI::render('templates/login.php');

    $slot .= $this
      ->bareUI::render('templates/consultarPreguntasRespuestas.php');

    if (isset($_SESSION['showQuestions'])) {
      $slot .= $this->bareUI::render('templates/preguntasRespuestas.php');
    }

    if (isset($_SESSION['changePassword'])) {
      $slot .= $this->bareUI::render('templates/cambiarClave.php');
    }

    $response = $this->responseFactory->createResponse();

    $response
      ->getBody()
      ->write($this->bareUI::render('resources/views/components/layout.php', [
        'slot' => $slot,
      ]));

    return $response;
  }
}
