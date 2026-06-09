<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
  ->withPaths([
    __DIR__ . '/backend',
    __DIR__ . '/templates',
    __DIR__ . '/views',
  ])
  ->withSkipPath(__DIR__ . '/vendor')
  ->withPhpSets(php82: true)
  ->withIndent(' ', 2)
  ->withCache(
    cacheDirectory: __DIR__ . '/storage/rector/cache',
    containerCacheDirectory: __DIR__ . '/storage/rector'
  )
  ->withDowngradeSets(php82: true)
  ->withFluentCallNewLine()
  ->withImportNames(removeUnusedImports: true)
  ->withParallel()
  ->withPreparedSets(
    deadCode: true,
    codeQuality: true,
    codingStyle: true,
    typeDeclarations: true,
    privatization: true,
    naming: true,
    instanceOf: true,
    earlyReturn: true,
    strictBooleans: true,
    rectorPreset: true,
  )
  ->withRealPathReporting()
  ->withRootFiles()
  ->withRules([])
  ->withSetProviders()
  ->withSets([])
  ->withSkip([]);
