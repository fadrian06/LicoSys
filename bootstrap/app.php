<?php

declare(strict_types=1);

use App\BareUI;
use App\ErrorLogger;
use App\Route;
use App\RoutingMiddleware;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

use function App\getenv;

require_once __DIR__ . '/../vendor/autoload.php';

$container = Container::getInstance();

$container->singletonIf(
  ContainerInterface::class,
  static fn(): ContainerInterface => $container,
);

$container->singletonIf(ResponseFactoryInterface::class, HttpFactory::class);

$container->singletonIf(
  ServerRequestInterface::class,
  ServerRequest::fromGlobals(...),
);

$container->singletonIf(
  Manager::class,
  static function (ContainerInterface $container): Manager {
    $manager = new Manager($container);

    $manager->addConnection([
      'driver' => getenv('DB_CONNECTION'),
      'host' => getenv('DB_HOST'),
      'database' => getenv('DB_DATABASE'),
      'username' => getenv('DB_USERNAME'),
      'password' => getenv('DB_PASSWORD'),
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
    ]);

    $manager->setAsGlobal();
    $manager->bootEloquent();

    return $manager;
  },
);

$container->when(BareUI::class)->needs('$path')->give(__DIR__ . '/..');
$container->singletonIf(BareUI::class);
$container->singletonIf(LoggerInterface::class, ErrorLogger::class,);

$container->singletonIf(
  mysqli::class,
  static function (): mysqli {
    $mysqli = new mysqli(
      getenv('DB_HOST'),
      getenv('DB_USERNAME'),
      getenv('DB_PASSWORD'),
      port: (int) getenv('DB_PORT'),
    );

    $mysqli->set_charset('utf8');

    return $mysqli;
  },
);

$container
  ->when(RoutingMiddleware::class)
  ->needs(Route::class)
  ->give(static fn(): array => require __DIR__ . '/../routes/web.php');

$container->singletonIf(RoutingMiddleware::class);
