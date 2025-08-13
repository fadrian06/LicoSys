<?php

declare(strict_types=1);

use Leaf\BareUI;
use Leaf\Http\Session;

require_once __DIR__ . '/../vendor/autoload.php';
require_once BASE_DIR . '/backend/componentes.php';
require_once BASE_DIR . '/backend/conexion.php';
require_once BASE_DIR . '/backend/funciones.php';

/*=================================================
=            VARIABLES PREESTABLECIDAS            =
=================================================*/
$script = '';
$url = explode('/', strval($_SERVER['SCRIPT_NAME']));
$archivoActual = $url[count($url) - 1];

/*=================================================================
=            LÓGICA DE TOD0 EL SISTEMA, MENOS EL LOGIN            =
=================================================================*/
if ($archivoActual !== 'index.php') {
  $script .= "<script src='./assets/dist/navegacion.js'></script>";
  $script .= "<script src='./assets/dist/main.js'></script>";
  $userId = Session::get('userID');

  /*----------  No tienes preguntas y respuestas registradas  ----------*/
  $sql = "SELECT pre1, pre2, pre3 FROM usuarios WHERE id={$userId}";
  $usuario = getRegistro($sql) ?? [];

  if (
    $usuario['pre1'] === 'No especificada' || !$usuario['pre1']
    || $usuario['pre2'] === 'No especificada' || !$usuario['pre2']
    || $usuario['pre3'] === 'No especificada' || !$usuario['pre3']
  ) {
    $script .= <<<html
      <script>
        let textoNoTienesPreguntasNiRespuestas = `
          <strong class="w3-text-red">
            No tienes preguntas y respuestas registradas.
          </strong><br>
          <small>¿Desea registrarlas?</small>
        `

        confirmar(textoNoTienesPreguntasNiRespuestas, 'center', () => {
          $('[href="views/miPerfil.php"]')[0].click()

          let intervalo = setInterval(() => {
            if ($('#moduloPerfil')[0]) {
              $('[role="botonPanel"]:last-child')[0].click()
              $('[data-target="#editarPreguntasRespuestas"]')[0].click()
              clearInterval(intervalo)
            }
          }, 500)
        })
      </script>
    html;
  }

  /*----------  Inventario agotado  ----------*/
  $sql = 'SELECT id, producto, stock FROM inventario';
  $productos = getRegistros($sql) ?? [];
  $i = 1;

  foreach ($productos as $producto) {
    $tiempo = 1000 * 60; /*60 segundos*/

    if (!$producto['stock']) {
      $script .= <<<html
        <script>
          setTimeout(() => alerta('{$producto['producto']} está AGOTADO').show(), 3000)

          let intervalo{$i} = setInterval(() => {
            alerta('{$producto['producto']} está AGOTADO').show()
          }, {$tiempo})

          setTimeout(() => clearInterval(intervalo{$i}), {$tiempo} * 10 /*10 minutos*/)
        </script>
      html;
    } elseif ($producto['stock'] <= 5) {
      $script .= <<<html
        <script>
          setTimeout(() => advertencia('{$producto['producto']} CASI AGOTADO').show(), 3000)

          let intervalo{$i} = setInterval(() => {
            advertencia('{$producto['producto']} CASI AGOTADO').show()
          }, {$tiempo})

          setTimeout(() => clearInterval(intervalo{$i}), {$tiempo} * 10 /*5 minutos*/)
        </script>
      html;
    }
    ++$i;
  }
}

/*====================================================================
=            LÓGICA DE TOD0 EL SISTEMA, INCLUIDO EL LOGIN            =
====================================================================*/
$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
$admin = getRegistro("SELECT * FROM usuarios WHERE cargo='a'");

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
</head>

<body class="w3-disabled" x-init="$el.classList.remove('w3-disabled')">
  <!--==================================
  =            FONDO OSCURO            =
  ===================================-->
  <?= BareUI::render('components/overlay', ['role' => 'modalOverlay']) ?>
  <?= BareUI::render('components/overlay', ['role' => 'menuOverlay']) ?>

  <?php

  $archivoActual !== 'index.php' && print BareUI::render('components/header', [
    'salesCartProductsAmount' => contarRegistros('carrito_venta'),
    'shoppingCartProductsAmount' => contarRegistros('carrito_compra'),
  ]);

  $negocios && $admin && print BareUI::render('components/modal', [
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
  ]);
