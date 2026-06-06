<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Dotenv\Dotenv;

function getenv(string $name): string|int|null|bool
{
  if (!key_exists($name, $_ENV)) {
    $dotenv = new Dotenv;
    $dotenv->load(__DIR__ . '/../.env.example');
    file_exists(__DIR__ . '/../.env') && $dotenv->overload(__DIR__ . '/../.env');
  }

  $env = $_ENV[$name];

  if (filter_var($env, FILTER_VALIDATE_INT)) {
    $env = filter_var($env, FILTER_VALIDATE_INT);
  } elseif (filter_var($env, FILTER_VALIDATE_BOOL)) {
    $env = filter_var($env, FILTER_VALIDATE_BOOL);
  }

  return is_string($env) || is_int($env) || is_bool($env) ? $env : null;
}
