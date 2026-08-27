<?php

declare(strict_types=1);

use App\BareUI;
use App\ErrorLogger;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

use function App\getenv;

require_once __DIR__ . '/../vendor/autoload.php';

Container::getInstance()->singletonIf(ResponseFactoryInterface::class, HttpFactory::class);
Container::getInstance()->singletonIf(ServerRequestInterface::class, ServerRequest::fromGlobals(...));

Container::getInstance()->singletonIf(Manager::class, static function (): Manager {
  $manager = new Manager(Container::getInstance());

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
});

Container::getInstance()
  ->when(BareUI::class)
  ->needs('$path')
  ->give(__DIR__ . '/..');

Container::getInstance()->singletonIf(BareUI::class);

Container::getInstance()->singletonIf(
  LoggerInterface::class,
  ErrorLogger::class,
);
