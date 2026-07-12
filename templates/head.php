<?php

	use App\Scripts;
	use Illuminate\Container\Container;
	use Illuminate\Database\Capsule\Manager;

	use function App\get_exception_handler;
	use function App\getenv;

	require_once __DIR__ . '/../vendor/autoload.php';

	/*=================================================
	=            VARIABLES PREESTABLECIDAS            =
	=================================================*/
	$url = explode('/', $_SERVER['SCRIPT_NAME']);
	$archivoActual = array_last($url);

	require_once __DIR__ . '/../backend/componentes.php';
	require_once __DIR__ . '/../backend/conexion.php';
	require_once __DIR__ . '/../backend/funciones.php';

	$manager = Container::getInstance()->get(Manager::class);

	/*=================================================================
	=            LÓGICA DE TOD0 EL SISTEMA, MENOS EL LOGIN            =
	=================================================================*/
	if ($archivoActual !== 'index.php' && key_exists('userID', $_SESSION)):
		Scripts::pushSrcOnce('./resources/build/navegacion.js');
		Scripts::pushSrcOnce('./resources/build/main.js');

		/*----------  No tienes preguntas y respuestas registradas  ----------*/
		$usuario = (array) $manager::table('usuarios')->find(
			$_SESSION['userID'],
			['pre1', 'pre2', 'pre3']
		);

		if (
			strtolower($usuario['pre1']) === 'no especificada' || !$usuario['pre1']
			|| strtolower($usuario['pre2']) === 'no especificada' || !$usuario['pre2']
			|| strtolower($usuario['pre3']) === 'no especificada' || !$usuario['pre3']
		) Scripts::push(<<<HTML
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
		HTML);

		/*----------  Inventario agotado  ----------*/
		$productos = $manager::table('inventario')->get(['id', 'producto', 'stock'])->toArray();

		foreach ($productos as $i => $producto):
			$producto = (array) $producto;
			$tiempo = 1000 * 60; /*60 segundos*/

			if (!$producto['stock'])
				Scripts::push(<<<HTML
					<script>
						setTimeout(() => alerta('{$producto['producto']} está AGOTADO').show(), 3000)

						let intervalo{$i} = setInterval(() => {
							alerta('{$producto['producto']} está AGOTADO').show()
						}, $tiempo)

						setTimeout(() => clearInterval(intervalo{$i}), $tiempo * 10 /* 10 minutos */)
					</script>
				HTML);
			elseif ($producto['stock'] <= 5)
				Scripts::push(<<<HTML
					<script>
						setTimeout(() => advertencia('{$producto['producto']} CASI AGOTADO').show(), 3000)

						let intervalo{$i} = setInterval(() => {
							advertencia('{$producto['producto']} CASI AGOTADO').show()
						}, $tiempo)

						setTimeout(() => clearInterval(intervalo{$i}), $tiempo * 10 /* 5 minutos */)
					</script>
				HTML);
		endforeach;
	endif;

	/*====================================================================
	=            LÓGICA DE TODO EL SISTEMA, INCLUIDO EL LOGIN            =
	====================================================================*/
	Scripts::push(<<<HTML
		<script>
			document.body.classList.remove('w3-disabled')
		</script>
	HTML);

	$negocios = [];
	$admin = [];
	$productosEnCarrito = 0;
	$productosEnCarritoCompra = 0;

	try {
		$negocios = $manager::table('negocios')->where('activo', true)->get()->toArray();
		$admin = (array) $manager::table('usuarios')->where('cargo', 'a')->first();
		$productosEnCarrito = $manager::table('carrito_venta')->count();
		$productosEnCarritoCompra = $manager::table('carrito_compra')->count();
	} catch (PDOException $exception) {
		get_exception_handler()($exception);
	}

?>

<!DOCTYPE html>
<html lang="es" data-app-name="<?= getenv('APP_NAME') ?>">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="black">
		<meta name="color-scheme" content="light dark">
		<base href="<?= str_replace(['index.php', 'dashboard.php'], '', $_SERVER['SCRIPT_NAME']) ?>">
		<link rel="icon" href="./resources/images/logo.png">
		<link rel="stylesheet" href="./resources/icons/style.min.css">
		<link rel="stylesheet" href="./resources/fonts/fuentes.css">
		<link rel="stylesheet" href="./resources/libs/noty/noty.css">
		<link rel="stylesheet" href="./resources/libs/noty/themes/sunset.css">
		<link rel="stylesheet" href="./resources/build/index.css">
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

	<body class="w3-disabled">
		<!--==================================
		=            FONDO OSCURO            =
		===================================-->
		<div role="modalOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>
		<div role="menuOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>

		<?php if ($archivoActual !== 'index.php'): ?>
			<?php $mostrarMenu = true ?>
			<?php include __DIR__ . '/menu.php' ?>
		<?php endif ?>

		<?php include __DIR__ . '/acercaDe.php' ?>
