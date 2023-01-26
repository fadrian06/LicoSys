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

	if ($archivoActual !== 'index.php'):
		$script .= "<script src='{$BASE_URL}js/navegacion.js'></script>";
		$script .= "<script src='{$BASE_URL}js/main.js'></script>";
		
		/*----------  No tienes preguntas y respuestas registradas  ----------*/
		$sql = <<<SQL
			SELECT pre1, pre2, pre3 FROM usuarios WHERE id={$_SESSION['userID']}
		SQL;
		$usuario = getRegistro($sql);
		if ($usuario['pre1'] === 'No especificada' || !$usuario['pre1']
			|| $usuario['pre2'] === 'No especificada' || !$usuario['pre2']
			|| $usuario['pre3'] === 'No especificada' || !$usuario['pre3']
		) $script .= <<<HTML
			<script>
				let texto = `
					<strong class="w3-text-red">
						No tienes preguntas y respuestas registradas.
					</strong><br>
					<small>¿Desea registrarlas?</small>
				`
				confirmar(texto, 'center', () => {
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
		foreach ($productos as $producto):
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
	
	$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
	$admin    = getRegistro("SELECT * FROM usuarios WHERE cargo='a'");
	
	$script .= <<<HTML
		<script>
			document.body.classList.remove('w3-disabled')
		</script>
	HTML;
	
	$productosEnCarrito = contarRegistros('carrito_venta');
	$productosEnCarritoCompra = contarRegistros('carrito_compra') ?? 0;
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
		<link rel="stylesheet" href="<?=$BASE_URL?>ico/style.min.css">
		<link rel="stylesheet" href="<?=$BASE_URL?>fonts/fuentes.min.css">
		<link rel="stylesheet" href="<?=$BASE_URL?>libs/noty/noty.css">
		<link rel="stylesheet" href="<?=$BASE_URL?>libs/noty/themes/sunset.css">
		<link rel="stylesheet" href="<?=$BASE_URL?>css/bundle.css">
		<title>LicoSys</title>
		<script src="<?=$BASE_URL?>libs/jquery.min.js"></script>
		<script src="<?=$BASE_URL?>libs/w3/w3.min.js"></script>
		<script src="<?=$BASE_URL?>libs/noty/noty.min.js"></script>
		<script src="<?=$BASE_URL?>libs/Chart.js"></script>
		<script src="<?=$BASE_URL?>js/actualizarImagen.js"></script>
		<script src="<?=$BASE_URL?>js/funciones.js"></script>
		<script src="<?=$BASE_URL?>js/validar.js"></script>
	</head>

	<body class="w3-disabled">
		<!--==================================
		=            FONDO OSCURO            =
		===================================-->
		<div role="modalOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>
		<div role="menuOverlay" class="w3-overlay w3-animate-opacity w3-hide"></div>
		
		<?php if ($archivoActual !== 'index.php'): ?>
			<!--====================================
			=            BARRA SUPERIOR            =
			=====================================-->
			<header id="encabezado" class="w3-top w3-black w3-large">
				<button class="w3-button w3-hide-large w3-hover-none w3-hover-text-grey">
					<i class="icon-bars"></i> Menú
				</button>
				<div class="w3-container w3-small w3-hide-medium w3-hide-small">
					<?=fecha()?>
				</div>
				<div class="w3-medium w3-hide-small w3-dropdown-hover">
					<button onclick="modal(this)" data-target="#acercaDe" class="w3-button">
						LicoSys <?=getUltimaVersion()?>
					</button>
					<?=generarTooltip('Acerca De')?>
				</div>
				<div class="w3-row">
					<div class="w3-half w3-medium w3-dropdown-hover w3-black">
						<a href="views/nuevaVenta.php" role="navegacion" title="Nueva Venta" class="w3-large w3-button">
							<i class="icon-cart-arrow-down"></i>
							<b id="productosEnCarrito"><?=$productosEnCarrito?></b>
						</a>
						<?=generarTooltip('Carrito de Ventas')?>
					</div>
					<?php
						$tooltipCarritoCompras = generarTooltip('Carrito de Compras');
						if ($_SESSION['cargo'] === 'a')
							echo <<<HTML
								<div class="w3-half w3-medium w3-dropdown-hover w3-black">
									<a href="views/nuevaCompra.php" role="navegacion" title="Nueva Compra" class="w3-large w3-button w3-hide-small">
										<i class="icon-handshake-o"></i>
										<b id="productosEnCarritoCompra">$productosEnCarritoCompra</b>
									</a>
									$tooltipCarritoCompras
								</div>
							HTML;
					?>
				</div>
				<div class="w3-medium w3-dropdown-hover w3-black">
					<a href="dashboard.php" role="navegacion" title="Panel de Administración" class="w3-medium w3-button">
						<img src="<?="$BASE_URL{$_SESSION['negocioLogo']}"?>" class="w3-image w3-circle" style="height: 25px; width:25px">
						&nbsp;<b id="menuNombreNegocio"><?=$_SESSION['negocio']?></b>
					</a>
					<?=generarTooltip('Panel de Administración')?>
				</div>
			</header>
			<!--==================================
			=            MENÚ LATERAL            =
			===================================-->
			<aside id="menu" class="w3-sidebar w3-collapse w3-white w3-animate-left w3-hide">
				<section class="w3-padding-top-24 w3-black w3-container w3-row w3-border-bottom w3-margin-bottom">
					<a href="views/miPerfil.php" role="navegacion" title="Mi Perfil" class="w3-block w3-col s3">
						<img id="fotoPerfil" src="<?="$BASE_URL{$_SESSION['userFoto']}"?>" class="w3-image w3-circle w3-margin-right w3-padding-small">
					</a>
					<div class="w3-col s9 w3-center">
						<div>
							Bienvenido,
							&nbsp;<b id="menuNombreUsuario"><?=$_SESSION['userName']?></b>
						</div>
						<hr style="margin: 5px">
						<?php
							if (is_float(getDolar()) and is_int(getPeso())):
								echo <<<HTML
									<button onclick="modal(this)" data-target="#conversionMonetaria" title="Calculadora Monetaria" class="w3-button icon-calculator"></button>
								HTML;
								
								$titulo = <<<HTML
									<div class="w3-container">Conversión Monetaria</div>
								HTML;
								
								$inputBS = generarINPUT('BS', 'Monto en Bs.');
								$inputDolar = generarINPUT('DOLAR', 'Monto en Dólares');
								$inputPesos = generarINPUT('PESO', 'Monto en Pesos');
								
								$valorDolar = getDolar();
								$valorPesos = getPeso();
								$contenido = <<<HTML
									<section class="w3-display-container">
										$inputBS
										$inputDolar
										$inputPesos
									</section>
									<section class="w3-hide">
										<input type="hidden" id="valorDolar" value="$valorDolar">
										<input type="hidden" id="valorPesos" value="$valorPesos">
									</section>
								HTML;
								generarModal('form', 'conversionMonetaria', $titulo, $contenido);
							endif;
						?>
						<a href="views/miPerfil.php" role="navegacion" title="Mi Perfil" class="w3-button icon-cog"></a>
						<button onclick="cerrarSesion()" title="Cerrar Sesión" class="w3-button icon-sign-out"></button>
					</div>
				</section>
				<p class="w3-container">Panel de Administración</p>
				<nav class="w3-bar-block">
					<a href="dashboard.php" role="navegacion" title="Panel de Administración" class="w3-bar-item w3-button w3-padding w3-blue">
						<i class="icon-home"></i> Inicio
					</a>
					<a href="views/nuevaVenta.php" role="navegacion" title="Registrar Venta" class="w3-bar-item w3-button w3-padding">
						<i class="icon-shopping-cart"></i> Nueva Venta
					</a>
					<a href="views/inventario.php" role="navegacion" title="Ver Inventario" class="w3-bar-item w3-button w3-padding">
						<i class="icon-product-hunt"></i> Inventario
					</a>
					<a href="views/clientes.php" role="navegacion" title="Ver Clientes" class="w3-bar-item w3-button w3-padding">
						<i class="icon-id-card"></i> Clientes
					</a>
					<a href="views/proveedores.php" role="navegacion" title="Ver Proveedores" class="w3-bar-item w3-button w3-padding">
						<i class="icon-address-book"></i> Proveedores
					</a>
					<a href="views/ventas.php" role="navegacion" title="Gestionar Ventas" class="w3-bar-item w3-button w3-padding">
						<i class="icon-list-alt"></i> Ventas
					</a>
					<?php if ($_SESSION['cargo'] === 'a'): ?>
						<details class="w3-bar-block w3-light-gray">
							<summary class="w3-hover-grey w3-padding">
								<i class="icon-handshake-o"></i> Compras
								<i class="icon-chevron-right w3-right"></i>
							</summary>
							<div>
								<a href="views/compras.php" role="navegacion" title="Gestionar Compras" class="w3-bar-item w3-button w3-padding">
									<i class="icon-handshake-o"></i> Ver Compras
								</a>
								<a href="views/nuevaCompra.php" role="navegacion" title="Registrar Compra" class="w3-bar-item w3-button">
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
								<a href="views/usuarios.php" role="navegacion" title="Gestionar Usuarios" class="w3-bar-item w3-button">
									<i class="icon-users"></i> Ver Usuarios
								</a>
								<a href="views/log.php" role="navegacion" title="Registro de Sesiones" class="w3-bar-item w3-button">
									<i class="icon-list-alt"></i> Ver Log
								</a>
							</div>
						</details>
						<a href="views/negocios.php" role="navegacion" title="Gestionar Negocios" class="w3-bar-item w3-button w3-padding">
							<i class='icon-building'></i> Negocios
						</a>
						<a href="views/finanzas.php" role="navegacion" title="Gestionar Finanzas" class="w3-bar-item w3-button w3-padding">
							<i class="icon-bar-chart"></i> Finanzas
						</a>
					<?php endif ?>
				</nav>
				<br><br><br><br><br>
			</aside>
		<?php endif ?>
		
		<?php
			/*=================================
			=            ACERCA DE            =
			=================================*/
			if (!empty($negocios) and !empty($admin)):
				$titulo = 'Acerca de <small>LicoSys</small>';
				$contenido = <<<HTML
					<div class="w3-row">
						<div class="w3-third w3-padding-large w3-center">
							<img src="images/logo.png" class="w3-image">
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
				HTML;
				
				generarModal('div', 'acercaDe', $titulo, $contenido);
			endif;
		?>