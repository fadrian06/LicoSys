<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
  ->withPaths([
    __DIR__ . '/backend',
    __DIR__ . '/templates',
    __DIR__ . '/views',
    __DIR__ . '/dashboard.php',
    __DIR__ . '/ecs.php',
    __DIR__ . '/index.php',
    __DIR__ . '/rector.php',
    __DIR__ . '/salir.php',
  ])
  ->withCache(__DIR__ . '/storage/ecs')
  ->withEditorConfig()
  ->withPhpCsFixerSets()
  ->withPreparedSets()
  ->withRealPathReporting()
  ->withRootFiles()
  ->withSkip([])
  ->withRules([
  ])
  ->withSets([]);
