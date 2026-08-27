<?php

declare(strict_types=1);

use function App\getenv;

?>

<!doctype html>
<html
  lang="<?= getenv('APP_LOCALE') ?>"
  data-app-name="<?= getenv('APP_NAME') ?>">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta name="theme-color" content="black" />
    <meta name="color-scheme" content="light dark" />
    <base href="<?= str_replace(
      ['index.php', 'dashboard.php'],
      '',
      $_SERVER['SCRIPT_NAME'],
    ) ?>" />
    <link rel="icon" href="./resources/images/logo.png" />
    <link rel="stylesheet" href="./resources/fonts/fuentes.css" />
    <link rel="stylesheet" href="./resources/libs/noty/noty.css" />
    <link rel="stylesheet" href="./resources/build/index.css" />
    <title><?= getenv('APP_NAME') ?></title>
    <script src="./resources/libs/jquery.min.js"></script>
    <script src="./resources/libs/noty/noty.min.js"></script>
    <script defer src="./resources/build/loader.js"></script>
  </head>
</html>
