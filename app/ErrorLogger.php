<?php

declare(strict_types=1);

namespace App;

use Override;
use Psr\Log\AbstractLogger;
use Stringable;

final class ErrorLogger extends AbstractLogger
{
  #[Override]
  public function log(
    $level,
    string|Stringable $message,
    array $context = [],
  ): void {
    ini_set('error_log', __DIR__ . '/../storage/logs/licosys.log');

    error_log($message);

    if (!empty($context['exception'])) {
      error_log((string) $context['exception']);
    }
  }
}
