<?php
	$script = '';
	$url = explode('/', $_SERVER['SCRIPT_NAME']);
	$archivoActual = $url[count($url) - 1];
	
	$carpetaViews = $url[count($url) - 2] === 'views' ? true : false;
	$BASE_URL = $carpetaViews ? '../' : '';
	
	require "{$BASE_URL}backend/config.php";
	require "{$BASE_URL}backend/componentes.php";
	require "{$BASE_URL}backend/conexion.php";
	require "{$BASE_URL}backend/funciones.php";

	if ($archivoActual !== 'index.php')
		$script .= '<script src="js/main.js"></script>';
?>

<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Franyer Sánchez, Daniel Mancilla">
		<meta name="description" content="Sistema Automatizado de Gestión de Compras y Ventas">
		<meta name="theme-color" content="black">
		<link rel="icon" href="<?=$BASE_URL?>images/logo.png">
		<link rel="stylesheet" href="<?=$BASE_URL?>icons/style.min.css">
		<link rel="stylesheet" href="<?=$BASE_URL?>fonts/fuentes.min.css">
		<link rel="stylesheet" href="<?=$BASE_URL?>libs/noty/noty.css">
		<link rel="stylesheet" href="<?=$BASE_URL?>libs/noty/themes/sunset.css">
		<link rel="stylesheet" href="<?=$BASE_URL?>css/bundle.css">
		<title>LicoSys</title>
	</head>

	<body>
		<div class="w3-overlay w3-animate-opacity w3-hide"></div>
		
		<?php if ($archivoActual !== 'index.php'): ?>
			<header id="encabezado" class="w3-top w3-black w3-large">
				<button class="w3-button w3-hide-large w3-hover-none w3-hover-text-grey">
					<i class="icon-bars"></i> Menú
				</button>
				<div class="w3-container w3-small w3-hide-medium w3-hide-small">
					<?=fecha()?>
				</div>
				<div class="w3-medium w3-hide-small">
					<button id="version" class="w3-button">LicoSys <?=getUltimaVersion()?></button>
				</div>
				<a href="dashboard.php" class="w3-medium w3-button tooltip-container">
					<img src="<?=$BASE_URL . $_SESSION['negocioLogo']?>" class="w3-image w3-circle" style="height: 25px; width:25px">
					&nbsp;<?=$_SESSION['negocio']?>
				</a>
			</header>
			<aside id="menu" class="w3-sidebar w3-collapse w3-white w3-animate-left w3-hide">
				<section class="w3-padding-top-24 w3-black w3-container w3-row w3-border-bottom w3-margin-bottom">
					<a href="views/miPerfil.php" class="w3-block w3-col s3">
						<img id="fotoPerfil" src="<?=$BASE_URL . $_SESSION['userFoto']?>" class="w3-image w3-circle w3-margin-right w3-padding-small">
					</a>
					<div class="w3-col s9 w3-center">
						<div>Bienvenido, <b><?=$_SESSION['userName']?></b></div>
						<hr style="margin: 5px">
						<a href="views/miPerfil.php" title="Mi Perfil" class="w3-button icon-cog"></a>
						<a href="salir.php" title="Cerrar Sesión" class="w3-button icon-sign-out"></a>
					</div>
				</section>
				<p class="w3-container">Panel de Administración</p>
				<nav class="w3-bar-block">
					<a href="dashboard.php" class="w3-bar-item w3-button w3-padding w3-blue">
						<i class="icon-home"></i> Inicio
					</a>
					<a href="views/nuevaVenta.php" class="w3-bar-item w3-button w3-padding">
						<i class="icon-shopping-cart"></i> Nueva Venta
					</a>
					<a href="views/inventario.php" class="w3-bar-item w3-button w3-padding">
						<i class="icon-product-hunt"></i> Inventario
					</a>
					<a href="views/clientes.php" class="w3-bar-item w3-button w3-padding">
						<i class="icon-id-card"></i> Clientes
					</a>
					<a href="views/proveedores.php" class="w3-bar-item w3-button w3-padding">
						<i class="icon-address-book"></i> Proveedores
					</a>
					<a href="views/ventas.php" class="w3-bar-item w3-button w3-padding">
						<i class="icon-list-alt"></i> Ventas
					</a>
					<?php if ($_SESSION['cargo'] === 'a'): ?>
						<details class="w3-bar-block w3-light-gray">
							<summary class="w3-hover-grey w3-padding">
								<i class="icon-handshake-o"></i> Compras
								<i class="icon-chevron-right w3-right"></i>
							</summary>
							<div>
								<a href="views/compras.php" class="w3-bar-item w3-button w3-padding">
									<i class="icon-handshake-o"></i> Ver Compras
								</a>
								<a href="views/nuevaCompra.php" class="w3-bar-item w3-button">
									<i class="icon-cart-plus"></i> Nueva Compra
								</a>
							</div>
						</details>
						<details class="w3-bar-block w3-light-gray">
							<summary class="w3-hover-grey w3-padding">
								<i class="icon-users"></i> Usuarios
								<i class="icon-chevron-right w3-right"></i>
							</summary>
							<div>
								<a href="views/usuarios.php" class="w3-bar-item w3-button">
									<i class="icon-users"></i> Ver Usuarios
								</a>
								<a href="views/log.php" title="Registro de Sesiones" class="w3-bar-item w3-button">
									<i class="icon-list-alt"></i> Ver log
								</a>
							</div>
						</details>
						<a href="views/negocio.php" class="w3-bar-item w3-button w3-padding">
							<i class='icon-gears'></i> Configuración
						</a>
						<a href="views/finanzas.php" class="w3-bar-item w3-button w3-padding">
							<i class="icon-bar-chart"></i> Finanzas
						</a>
					<?php endif ?>
				</nav>
				<br><br><br><br><br>
			</aside>
		<?php endif ?>
		
		<div id="acercaDe" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
			<div class="w3-right-align">
				<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
			</div>
			<h2 class="w3-center w3-xxlarge oswald w3-margin-bottom">
				Acerca de <small>LicoSys</small>
			</h2>
			<div class="w3-row">
				<div id="logo" class="w3-quarter w3-padding-large w3-center">
					<img src="images/logo.png" class="w3-image" style="max-width: 50%">
				</div>
				<p class="w3-padding-large w3-threequarter w3-xlarge w3-justify">
					&nbsp;&nbsp;&nbsp;LicoSys es un sistema administrativo que 
					simplifica los procesos que se llevan a cabo para la correcta 
					gestión de cualquier negocio.
				</p>
			</div>
			<ul class="w3-ul w3-large w3-justify">
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
			<img src="images/devices.jpg" class="w3-image">
			<p class="w3-container w3-large w3-justify">
				&nbsp;&nbsp;&nbsp;LicoSys está fuertemente centrado en la 
				<b>experiencia de usuario</b> y la <b>seguridad de la información</b>.
			</p>
			<p class="w3-container w3-large w3-justify">
				&nbsp;&nbsp;&nbsp;Utilizar el sistema es sumamente sencillo, 
				con unos pocos pasos y pocos clics, habrás registrado lo necesario 
				para que la aplicación funcione correctamente.
			</p>
		</div>