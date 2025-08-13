<?php

declare(strict_types=1);

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
  $script .= "<script src='./assets/js/navegacion.js'></script>";
  $script .= "<script src='./assets/js/main.js'></script>";
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

$script .= <<<html
  <script>
    document.body.classList.remove('w3-disabled')
  </script>
html;

$productosEnCarrito = contarRegistros('carrito_venta');
$productosEnCarritoCompra = contarRegistros('carrito_compra');

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>LicoSys</title>
  <base href="/licosys/" />
  <link rel="icon" href="./assets/images/logo.png" />
  <link rel="stylesheet" href="./assets/ico/style.min.css" />
  <link rel="stylesheet" href="./assets/libs/noty/noty.css" />
  <link rel="stylesheet" href="./assets/libs/noty/themes/sunset.css" />
  <link rel="stylesheet" href="./assets/js/index.css" />
  <link rel="stylesheet" href="./assets/css/bundle.css" />
  <script src="./assets/js/index.js"></script>
  <script src="./assets/libs/jquery.min.js"></script>
  <script src="./assets/libs/w3/w3.min.js"></script>
  <script src="./assets/libs/noty/noty.min.js"></script>
  <script src="./assets/libs/Chart.js"></script>
  <script src="./assets/libs/html2pdf.bundle.min.js"></script>
  <script src="./assets/js/actualizarImagen.js"></script>
  <script src="./assets/js/funciones.js"></script>
  <script src="./assets/js/validar.js"></script>
</head>

<body class="w3-disabled">
  <!--==================================
  =            FONDO OSCURO            =
  ===================================-->
  <div role="modalOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>
  <div role="menuOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>

  <?php

  if ($archivoActual !== 'index.php') {
    $mostrarMenu = true;

    include BASE_DIR . '/templates/menu.php';
  }

  include BASE_DIR . '/templates/acercaDe.php';
