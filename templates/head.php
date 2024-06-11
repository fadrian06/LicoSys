<?php
/*=================================================
	=            VARIABLES PREESTABLECIDAS            =
	=================================================*/
$script = '';
$url = explode('/', $_SERVER['SCRIPT_NAME']);
$archivoActual = (string) $url[count($url) - 1];

/** @var bool Indica si el usuario intenta acceder a una vista mediante la URL */
$seEncuentraEnCarpetaViews = $url[count($url) - 2] === 'views' ? true : false;
/** @var string Hace referencia a la carpeta raiz del proyecto */
$BASE_URL = $seEncuentraEnCarpetaViews ? '../' : '';

require "{$BASE_URL}backend/config.php";
require "{$BASE_URL}backend/componentes.php";
require "{$BASE_URL}backend/conexion.php";
require "{$BASE_URL}backend/funciones.php";

/*=================================================================
	=            LÓGICA DE TODO EL SISTEMA, MENOS EL LOGIN            =
	=================================================================*/
if ($archivoActual !== 'index.php') :
	$script .= "<script src='{$BASE_URL}assets/js/navegacion.js'></script>";
	$script .= "<script src='{$BASE_URL}assets/js/main.js'></script>";

	/*----------  No tienes preguntas y respuestas registradas  ----------*/
	$sql = <<<SQL
			SELECT pre1, pre2, pre3 FROM usuarios WHERE id={$_SESSION['userID']}
		SQL;
	$usuario = getRegistro($sql);
	if (
		$usuario['pre1'] === 'No especificada' || !$usuario['pre1']
		|| $usuario['pre2'] === 'No especificada' || !$usuario['pre2']
		|| $usuario['pre3'] === 'No especificada' || !$usuario['pre3']
	) $script .= <<<HTML
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
		$tiempo = 1000 * 60; /*60 segundos*/
		if (!$producto['stock'])
			$script .= <<<HTML
					<script>
						setTimeout(() => alerta('{$producto['producto']} está AGOTADO').show(),3000)

						let intervalo{$i} = setInterval(() => {
							alerta('{$producto['producto']} está AGOTADO').show()
						}, $tiempo)

						setTimeout(() => clearInterval(intervalo{$i}), $tiempo * 10 /*10 minutos*/)
					</script>
				HTML;
		elseif ($producto['stock'] <= 5)
			$script .= <<<HTML
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
	=            LÓGICA DE TODO EL SISTEMA, INCLUIDO EL LOGIN            =
	====================================================================*/
$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
$admin    = getRegistro("SELECT * FROM usuarios WHERE cargo='a'");

$script .= <<<HTML
		<script>
			document.body.classList.remove('w3-disabled')
		</script>
	HTML;

$productosEnCarrito = contarRegistros('carrito_venta');
$productosEnCarritoCompra = contarRegistros('carrito_compra');
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta name="theme-color" content="black" />
	<link rel="icon" href="<?= $BASE_URL ?>assets/images/logo.png" />
	<link rel="stylesheet" href="<?= $BASE_URL ?>assets/ico/style.min.css" />
	<link rel="stylesheet" href="<?= $BASE_URL ?>assets/fonts/fuentes.min.css" />
	<link rel="stylesheet" href="<?= $BASE_URL ?>assets/libs/noty/noty.css" />
	<link rel="stylesheet" href="<?= $BASE_URL ?>assets/libs/noty/themes/sunset.css" />
	<link rel="stylesheet" href="<?= $BASE_URL ?>assets/css/bundle.css" />
	<title>LicoSys</title>
	<script src="<?= $BASE_URL ?>assets/libs/jquery.min.js"></script>
	<script src="<?= $BASE_URL ?>assets/libs/w3/w3.min.js"></script>
	<script src="<?= $BASE_URL ?>assets/libs/noty/noty.min.js"></script>
	<script src="<?= $BASE_URL ?>assets/libs/Chart.js"></script>
	<script src="<?= $BASE_URL ?>assets/libs/html2pdf.bundle.min.js"></script>
	<script src="<?= $BASE_URL ?>assets/js/actualizarImagen.js"></script>
	<script src="<?= $BASE_URL ?>assets/js/funciones.js"></script>
	<script src="<?= $BASE_URL ?>assets/js/validar.js"></script>
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
		include 'templates/menu.php';
	endif;

	include 'templates/acercaDe.php';
