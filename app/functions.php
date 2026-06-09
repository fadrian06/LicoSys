<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\FormatException;
use Symfony\Component\Dotenv\Exception\PathException;

/** @throws FormatException | PathException */
function getenv(string $name): string|int|null
{
  if (!array_key_exists($name, $_ENV)) {
    $dotenv = new Dotenv;
    $dotenv->load(__DIR__ . '/../.env.example');
    $dotenv->overload(__DIR__ . '/../.env');
  }

  $env = $_ENV[$name] ?? null;

  if (filter_var($env, FILTER_VALIDATE_INT)) {
    $env = intval(filter_var($env, FILTER_VALIDATE_INT));
  }

  return is_string($env) || is_int($env) ? $env : null;
}
