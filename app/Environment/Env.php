<?php

namespace App\Environment;

abstract class Env {
  private static array $vars = [];

  static function get(string $key): ?string {
    if (!key_exists($key, self::$vars)) {
      self::loadVars();
    }

    return self::$vars[$key] ?? null;
  }

  private static function loadVars(): void {
    $envPath = __DIR__ . '/.env.php';

    if (!file_exists($envPath)) {
      copy(__DIR__ . '/.env.example.php', $envPath);
    }

    $vars = require_once $envPath;

    if (is_array($vars)) {
      self::$vars = $vars;
    }
  }
}
