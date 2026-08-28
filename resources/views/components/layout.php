<?php

declare(strict_types=1);

use App\BareUI;
use App\Scripts;
use Illuminate\Container\Container;
use Psr\Http\Message\ServerRequestInterface;

use function App\getenv;

$path = Container::getInstance()
  ->get(ServerRequestInterface::class)
  ->getUri()
  ->getPath();

$baseHref = str_replace(
  ['index.php', 'dashboard.php'],
  '',
  $_SERVER['SCRIPT_NAME'],
);

$bareUI = Container::getInstance()->get(BareUI::class);

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
  <base href="<?= $baseHref ?>" />
  <link rel="icon" href="./resources/images/logo.png" />
  <link rel="stylesheet" href="./resources/icons/style.min.css" />
  <link rel="stylesheet" href="./resources/fonts/fuentes.css" />
  <link rel="stylesheet" href="./resources/libs/noty/noty.css" />
  <link rel="stylesheet" href="./resources/libs/noty/themes/sunset.css" />
  <link rel="stylesheet" href="./resources/build/index.css" />
  <title><?= getenv('APP_NAME')  ?></title>
  <script src="./resources/libs/jquery.min.js"></script>
  <script src="./resources/libs/w3/w3.min.js"></script>
  <script src="./resources/libs/noty/noty.min.js"></script>
  <script src="./resources/libs/Chart.js"></script>
  <script src="./resources/libs/html2pdf.bundle.min.js"></script>
  <script src="./resources/build/actualizarImagen.js"></script>
  <script src="./resources/build/funciones.js"></script>
  <script src="./resources/build/validar.js"></script>
</head>

<body>
  <!--==================================
  =            FONDO OSCURO            =
  ===================================-->
  <div role="modalOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>
  <div role="menuOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>

  <?php if ($path === '/dashboard.php'): ?>
    <?= $bareUI::render('templates/menu.php', ['mostrarMenu' => true]) ?>
  <?php endif ?>

  <?= $bareUI::render('templates/acercaDe.php') ?>

  <?= $slot ?? '' ?>

  <?= Scripts::toHtml() ?>
</body>

</html>
