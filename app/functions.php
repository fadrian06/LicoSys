<?php

declare(strict_types=1);

namespace App;

use PDOException;
use Symfony\Component\Dotenv\Dotenv;
use Throwable;

function getenv(string $name): string
{
  if (!array_key_exists($name, $_ENV)) {
    $dotenv = new Dotenv;
    $dotenv->load(__DIR__ . '/../.env.example', __DIR__ . '/../.env');
  }

  return $_ENV[$name] ?? null;
}

function get_exception_handler(): callable
{
  return static function (Throwable $throwable): void {
    if ($throwable instanceof PDOException && $throwable->getCode() === 1049) {
      return;
    }

    throw $throwable;
  };
}
