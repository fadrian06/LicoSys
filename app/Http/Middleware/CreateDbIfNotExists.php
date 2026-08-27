<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\BareUI;
use mysqli;
use mysqli_sql_exception;
use NoDiscard;
use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

use function App\getenv;

final class CreateDbIfNotExists implements
  MiddlewareInterface,
  LoggerAwareInterface
{
  use LoggerAwareTrait;

  public function __construct(
    private readonly ResponseFactoryInterface $responseFactory,
    private readonly mysqli $mysqli,
    private readonly BareUI $bareUI,
    LoggerInterface $logger = new NullLogger,
  ) {
    $this->setLogger($logger);
  }

  #[Override]
  #[NoDiscard]
  public function process(
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
  ): ResponseInterface {
    if (empty($request->getParsedBody()['instalarBD'])) {
      try {
        $this->mysqli->select_db(getenv('DB_DATABASE'));

        return $handler->handle($request);
      } catch (mysqli_sql_exception $exception) {
        $this->logger->debug($exception->getMessage(), [
          'exception' => $exception
        ]);

        $response = $this->responseFactory->createResponse();

        $response
          ->getBody()
          ->write($this->bareUI::render('resources/views/install.php'));

        return $response;
      }
    }

    $sqlFilename = __DIR__ . '/../../../database/migrations/mysql.sql';
    $query = file_get_contents($sqlFilename);
    $query = str_replace('{DB_DATABASE}', getenv('DB_DATABASE'), $query);
    $response = $this->responseFactory->createResponse();

    try {
      $this->mysqli->multi_query($query);
      $response->getBody()->write('true');
    } catch (mysqli_sql_exception $exception) {
      $this->logger->debug($exception->getMessage(), [
        'exception' => $exception
      ]);

      $response->getBody()->write($exception->getMessage());
    }

    return $response;
  }
}
