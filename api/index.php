<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

Flight::route('POST /instalar-bd', function (): void {
  $mysqli = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD'],
  );

  $mysqli->set_charset('utf8');
  $sql = file_get_contents(BASE_DIR . '/database/init.mysql.sql');

  exit($mysqli->multi_query($sql ?: '') ? 'true' : $mysqli->error);
});

Flight::start();
