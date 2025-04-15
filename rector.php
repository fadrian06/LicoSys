<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
  ->withPaths([
    __DIR__ . '/backend',
    __DIR__ . '/templates',
    __DIR__ . '/views',
  ])
  ->withPhpSets(php82: true)
  ->withIndent(' ', 2);
