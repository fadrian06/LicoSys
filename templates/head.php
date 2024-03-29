<?php

/*=================================================
=            VARIABLES PREESTABLECIDAS            =
=================================================*/
$scripts = '';
$url = explode('/', $_SERVER['SCRIPT_NAME']);
$archivoActual = (string) $url[count($url) - 1];

/** @var bool Indica si el usuario intenta acceder a una vista mediante la URL */
$seEncuentraEnCarpetaViews = $url[count($url) - 2] === 'views' ? true : false;
/** @var string Hace referencia a la carpeta raiz del proyecto */
$BASE_URL = $seEncuentraEnCarpetaViews ? '../' : '';

require __DIR__ . '/../backend/config.php';
require __DIR__ . '/../backend/componentes.php';
require __DIR__ . '/../backend/conexion.php';
require __DIR__ . '/../backend/funciones.php';

/*=================================================================
=            LÓGICA DE T0DO EL SISTEMA, MENOS EL LOGIN            =
=================================================================*/
if ($archivoActual !== 'index.php') :
  $scripts .= "<script src='{$BASE_URL}js/navegacion.js'></script>";
  $scripts .= "<script src='{$BASE_URL}js/main.js'></script>";

  /*----------  No tienes preguntas y respuestas registradas  ----------*/
  $sql = "SELECT pre1, pre2, pre3 FROM usuarios WHERE id={$_SESSION['userID']}";
  $usuario = getRegistro($sql);
  if (
    $usuario['pre1'] === 'No especificada' || !$usuario['pre1']
    || $usuario['pre2'] === 'No especificada' || !$usuario['pre2']
    || $usuario['pre3'] === 'No especificada' || !$usuario['pre3']
  ) $scripts .= <<<HTML
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
    HTML;

  /*----------  Inventario agotado  ----------*/
  $sql = "SELECT id, producto, stock FROM inventario";
  $productos = getRegistros($sql);

  $i = 1;
  foreach ($productos as $producto) :
    $tiempo = 1000 * 60; /* 60 segundos */
    if (!$producto['stock'])
      $scripts .= <<<HTML
        <script>
          setTimeout(() => alerta('{$producto['producto']} está AGOTADO').show(),3000)

          let intervalo{$i} = setInterval(() => {
            alerta('{$producto['producto']} está AGOTADO').show()
          }, $tiempo)

          setTimeout(() => clearInterval(intervalo{$i}), $tiempo * 10 /* 10 minutos */)
        </script>
      HTML;
    elseif ($producto['stock'] <= 5)
      $scripts .= <<<HTML
          <script>
            setTimeout(() => advertencia('{$producto['producto']} CASI AGOTADO').show(), 3000)

            let intervalo{$i} = setInterval(() => {
              advertencia('{$producto['producto']} CASI AGOTADO').show()
            }, $tiempo)

            setTimeout(() => clearInterval(intervalo{$i}), $tiempo * 10 /*5 minutos*/)
          </script>
        HTML;
    ++$i;
  endforeach;
endif;

/*====================================================================
=            LÓGICA DE T0DO EL SISTEMA, INCLUIDO EL LOGIN            =
====================================================================*/
$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
$admin    = getRegistro("SELECT * FROM usuarios WHERE cargo='a'");

$scripts .= "<script>document.body.classList.remove('w3-disabled')</script>";

$productosEnCarrito = contarRegistros('carrito_venta');
$productosEnCarritoCompra = contarRegistros('carrito_compra');

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width" />
  <meta name="description" content="Sistema Automatizado de Gestión de Compras y Ventas" />
  <meta name="theme-color" content="black" />
  <link rel="icon" href="<?= $BASE_URL ?>images/logo.png" />
  <link
    rel="stylesheet"
    href="https://faslatam.000webhostapp.com/compartido/iconos/fontawesome.css"
  />
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto:wght@400;700&display=swap"
  />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css"
  />
  <link
    rel="stylesheet"
    href="https://raw.githubusercontent.com/needim/noty/master/lib/themes/sunset.css"
  />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
  <link rel="stylesheet" href="<?= $BASE_URL ?>css/bundle.css" />
  <title>LicoSys</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://www.w3schools.com/lib/w3.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script src="<?= $BASE_URL ?>js/actualizarImagen.js"></script>
  <script src="<?= $BASE_URL ?>js/funciones.js"></script>
  <script src="<?= $BASE_URL ?>js/validar.js"></script>
</head>

<body class="w3-disabled">
  <!--==================================
  =            FONDO OSCURO            =
  ===================================-->
  <div role="modalOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>
  <div role="menuOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>

  <?php
  if ($archivoActual !== 'index.php') :
    $mostrarMenu = true;
    include __DIR__ . '/menu.php';
  endif;

  include __DIR__ . '/acercaDe.php';
  ?>
