<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Scripts;
use Illuminate\Database\Capsule\Manager;
use NoDiscard;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ShowRestoreDbToastIfThereIsOneBackup implements
  MiddlewareInterface
{
  public function __construct(private Manager $manager) {}

  #[Override]
  #[NoDiscard]
  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    if (
      file_exists(__DIR__ . '/../../../backup/backup.sql')
      && (
        !$this->manager::table('negocios')->where('activo', true)->count()
        || !$this
          ->manager::table('usuarios')
          ->where('cargo', 'a')
          ->first()
          ?->pre1
      )
    ) {
      Scripts::pushSrcOnce('./resources/build/restaurarBD.js');
    }

    return $handler->handle($request);
  }
}
