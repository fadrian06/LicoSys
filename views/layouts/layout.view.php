<?php

declare(strict_types=1);

use Leaf\BareUI;

/**
 * @var string[] $scripts
 */

$slot ??= '';
$scripts = join(' ', $scripts ?? []);

$url = explode('/', strval($_SERVER['SCRIPT_NAME']));
$archivoActual = $url[count($url) - 1];

?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>LicoSys</title>
  <base href="/licosys/" />
  <link rel="icon" href="./assets/images/logo.png" />
  <link rel="stylesheet" href="./assets/dist/index.css" />
  <link rel="stylesheet" href="./assets/css/bundle.css" />
</head>

<body class="w3-disabled">
  <!--==================================
  =            FONDO OSCURO            =
  ===================================-->
  <?= BareUI::render('components/overlay', ['role' => 'modalOverlay']) ?>
  <?= BareUI::render('components/overlay', ['role' => 'menuOverlay']) ?>

  <?php if ($archivoActual !== 'index.php') : ?>
    <?= BareUI::render('components/header', [
      'salesCartProductsAmount' => contarRegistros('carrito_venta'),
      'shoppingCartProductsAmount' => contarRegistros('carrito_compra'),
    ]) ?>
  <?php endif ?>

  <?= BareUI::render('components/modal', [
    'tag' => 'div',
    'id' => 'acercaDe',
    'title' => 'Acerca de <small>LicoSys</small>',
    'slot' => <<<'html'
      <div class="w3-row">
        <div class="w3-third w3-padding-large w3-center">
          <img src="./assets/images/logo.png" class="w3-image">
        </div>
        <p class="w3-padding-large w3-rest w3-xlarge w3-justify">
          &nbsp;&nbsp;&nbsp;LicoSys es un sistema administrativo que
          simplifica los procesos que se llevan a cabo para la correcta
          gestión de cualquier negocio.
        </p>
      </div>
      <ul class="w3-container w3-ul w3-large w3-justify">
        <li class="w3-margin">
          <i class="icon-check"></i>
          Realiza procesos de <b>transacción de bienes</b>.
        </li>
        <li class="w3-margin">
          <i class="icon-check"></i>
          Consulta facturas ordenadas.
        </li>
        <li class="w3-margin">
          <i class="icon-check"></i>
          Registra a tus <b>clientes</b> y <b>proveedores</b> más frecuentes.
        </li>
        <li class="w3-margin">
          <i class="icon-check"></i>
          Gestiona a tus <b>vendedores</b>.
        </li>
        <li class="w3-margin">
          <i class="icon-check"></i>
          Convierte <b>monedas</b>.
        </li>
        <li class="w3-margin">
          <i class="icon-check"></i>
          Monitorea el <b>dólar</b> en todas sus variantes.
        </li>
        <li class="w3-margin">
          <i class="icon-check"></i>
          Analiza el desempaño de tu <b>negocio</b>.
        </li>
        <li class="w3-margin">
          <i class="icon-check"></i>
          Consulta tus <b>finanzas</b>.
        </li>
      </ul>
      <p class="w3-container w3-large w3-justify">
        Todo desde la comodidad de tu equipo preferido, LicoSys funciona tanto
        en <b>computadoras</b> como en <b>smartphones y tablets</b>, su entorno
        es web con lo cual sólo necesitarás un navegador y consume la
        aplicación.
      </p>
      <img src="./assets/images/devices.jpg" class="w3-image">
      <p class="w3-container w3-large w3-justify">
        &nbsp;&nbsp;&nbsp;LicoSys está fuertemente centrado en la
        <b>experiencia de usuario</b> y la <b>seguridad de la información</b>.
      </p>
      <p class="w3-container w3-large w3-justify">
        &nbsp;&nbsp;&nbsp;Utilizar el sistema es sumamente sencillo,
        con unos pocos pasos y pocos clics, habrás registrado lo necesario
        para que la aplicación funcione correctamente.
      </p>
    html,
  ]) ?>

  <?= $slot ?>
  <script src="./assets/dist/index.js"></script>
  <?= $scripts ?>
</body>

</html>
