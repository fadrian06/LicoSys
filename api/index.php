<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

Flight::route('POST /instalar-bd', function (): void {
  require_once BASE_DIR . '/backend/conexion.php';

  $sql = file_get_contents(BASE_DIR . '/database/init.mysql.sql');

  exit($conexion->multi_query($sql ?: '') ? 'true' : $conexion->error);
});

Flight::start();
