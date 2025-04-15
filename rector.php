<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
  ->withPaths([
    __DIR__ . '/backend',
    __DIR__ . '/templates',
    __DIR__ . '/views',
    __DIR__ . '/dashboard.php',
    __DIR__ . '/index.php',
    __DIR__ . '/rector.php',
    __DIR__ . '/salir.php',
  ])
  ->withPhpSets(php82: true)
  ->withIndent(' ', 2)
  ->withCache(
    cacheDirectory: __DIR__ . '/storage/rector/cache',
    containerCacheDirectory: __DIR__ . '/storage/rector'
  )
  ->withDowngradeSets(php82: true)
  ->withEditorUrl('subl://open?url=file://%file&line=%line')
  ->withFluentCallNewLine()
  ->withImportNames(removeUnusedImports: true)
  ->withParallel()
  ->withPreparedSets(
    deadCode: true,
  );
