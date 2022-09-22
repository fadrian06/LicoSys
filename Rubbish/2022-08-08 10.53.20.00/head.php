<?php
	session_start();
	require_once "../php/conexion.php";
	require_once "php/funciones.php";
	if (!isset($_SESSION["usuario"])) header("location: ../");

	$indexActivo           = "";
	$nuevaVentaActivo      = "";
	$inventarioActivo      = "";
	$clientesActivo        = "";
	$proveedoresActivo     = "";
	$comprasActivo         = "";
	$ventasActivo          = "";
	$usuariosActivo        = "";
	$negocioActivo         = "";
	$colorMenuSeleccionado = "w3-blue";
	switch ($_SERVER["PHP_SELF"]):
		case "/licoreria/sistema/nuevaVenta.php":
			$nuevaVentaActivo = $colorMenuSeleccionado;
			break;
		case "/licoreria/sistema/inventario.php":
		case "/licoreria/sistema/registrarArticulo.php":
			$inventarioActivo = $colorMenuSeleccionado;
			break;
		case "/licoreria/sistema/clientes.php":
		case "/licoreria/sistema/registrarCliente.php":
			$clientesActivo = $colorMenuSeleccionado;
			break;
		case "/licoreria/sistema/proveedores.php":
		case "/licoreria/sistema/registrarProveedor.php":
			$proveedoresActivo = $colorMenuSeleccionado;
			break;
		case "/licoreria/sistema/compras.php":
		case "/licoreria/sistema/nuevaCompra.php":
			$comprasActivo = $colorMenuSeleccionado;
			break;
		case "/licoreria/sistema/ventas.php":
			$ventasActivo = $colorMenuSeleccionado;
			break;
		case "/licoreria/sistema/usuarios.php":
		case "/licoreria/sistema/log.php":
		case "/licoreria/sistema/registrarUsuario.php":
			$usuariosActivo = $colorMenuSeleccionado;
			break;
		case "/licoreria/sistema/negocio.php":
			$negocioActivo = $colorMenuSeleccionado;
			break;
		case "/licoreria/sistema/":
		case "/licoreria/sistema/index.php":
			$indexActivo = $colorMenuSeleccionado;
	endswitch;

	$negocio = (int) $_SESSION["negocio"];
	$negocio = CONSULTA("SELECT nom_n FROM negocio WHERE id_n=$negocio");
	$negocio = $negocio[0]["nom_n"];

	$usuario = $_SESSION["usuario"];

	if ((empty($_SESSION["pregunta1"]) || empty($_SESSION["respuesta1"]) || empty($_SESSION["pregunta2"]) || empty($_SESSION["respuesta2"]) || empty($_SESSION["pregunta3"]) || empty($_SESSION["respuesta3"])) && $indexActivo):
		$notificacion = "
			<script>
				Swal.fire({
					title: 'No tienes <br>\"preguntas y respuestas secretas\" registradas.',
					footer: '<a href=\"miPerfil.php\" class=\"w3-text-indigo\">CLICK AQUÍ</a>&nbsp;para registrarlas',
					icon: 'warning',
					toast: true,
					timer: 5000,
					timerProgressBar: true,
					position: 'bottom-end',
					showConfirmButton: false
				})
			</script>
		";
	endif;
?>
<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="author" content="Franyer Sánchez">
		<meta name="author" content="Daniel Mancilla">
		<meta name="description" content="Sistema Automatizado para Registrar Compras y Ventas">
		<meta name="theme-color" content="black">
		<link rel="icon" href="../imagenes/favicon.png">
		<link rel="stylesheet" href="../iconos/style.min.css">
		<link rel="stylesheet" href="../librerias/w3/w3.min.css">
		<link rel="stylesheet" href="../librerias/sweetalert2/sweetalert2.min.css">
		<link rel="stylesheet" href="../fuentes/fuentes.css">
		<link rel="stylesheet" href="css/sistema.css">
		<link rel="stylesheet" href="css/boton.css">
		<link rel="stylesheet" href="css/miPerfil.css">
		<link rel="stylesheet" href="css/configuracionNegocios.css">
		<title>Licoreria</title>
	</head>

	<body class="w3-light-grey">
		<!--===================================
		=            MENÚ SUPERIOR            =
		====================================-->
		<nav class="w3-cell-row w3-top w3-black w3-large">
			<button id="barras" class="w3-cell w3-button w3-hide-large w3-hover-none w3-hover-text-grey"><i class="icon-bars"> </i>Menú</button>
			<div class="w3-container w3-small w3-cell w3-cell-middle w3-hide-small w3-hide-medium"><?=FECHA()?></div>
			<a href="index.php" class="w3-right w3-cell w3-button"><?=$negocio?></a>
		</nav>
		<!--====  End of MENÚ SUPERIOR  ====-->
		
		<!--==================================
		=            MENÚ LATERAL            =
		===================================-->
		<aside class="w3-sidebar w3-collapse w3-white w3-animate-left w3-padding-top-24" id="mySidebar" style="display:none">
			<header class="w3-container w3-row w3-border-bottom w3-margin-bottom">
				<div class="w3-col s4">
					<img src="<?=!empty($_SESSION["foto"]) ? "../imagenes/perfil/" . $_SESSION["foto"] : "../imagenes/avatar2.png"?>" class="w3-circle w3-margin-right" id="fotoPerfil">
				</div>
				<div class="w3-col s8 w3-bar">
					<div>Bienvenido, <strong><?=$_SESSION["nombreUsuario"]?></strong></div>
					<a href="miPerfil.php" class="w3-bar-item w3-button" title="Mi Perfil"><i class="icon-user"></i></a>
					<a href="miPerfil.php" class="w3-bar-item w3-button" title="Mi Perfil"><i class="icon-cog"></i></a>
					<a href="salir.php" class="w3-bar-item w3-button" title="Cerrar Sesión"><i class="icon-sign-out"></i></a>
				</div>
			</header>
			<p class="w3-container">Panel de Administración</p>
			<section class="w3-bar-block">
				<span id="cerrarMenu" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black">&times; Cerrar Menú</span>
				<a href="index.php" class="w3-bar-item w3-button w3-padding <?=$indexActivo?>"><i class="icon-home"> </i>Inicio</a>
				<a href="nuevaVenta.php" class="w3-bar-item w3-button w3-padding <?=$nuevaVentaActivo?>"><i class="icon-shopping-cart"> </i>Nueva Venta</a>
				<a href="inventario.php" class="w3-bar-item w3-button w3-padding <?=$inventarioActivo?>"><i class="icon-product-hunt"> </i>Inventario</a>
				<a href="clientes.php" class="w3-bar-item w3-button w3-padding <?=$clientesActivo?>"><i class="icon-id-card"> </i>Clientes</a>
				<a href="proveedores.php" class="w3-bar-item w3-button w3-padding <?=$proveedoresActivo?>"><i class="icon-address-book"> </i>Proveedores</a>
				<a href="compras.php" class="w3-bar-item w3-button w3-padding <?=$comprasActivo?>"><i class="icon-handshake-o"> </i>Compras</a>
				<a href="ventas.php" class="w3-bar-item w3-button w3-padding <?=$ventasActivo?>"><i class="icon-list-alt"> </i>Ventas</a>
				<?php if ($_SESSION["cargo"] == "a"): ?>
					<details class="w3-bar-block w3-light-gray">
						<summary class="w3-hover-grey <?=$usuariosActivo?>"><i class="icon-users"> </i>Usuarios</summary>
						<a href="usuarios.php" class="w3-bar-item w3-button"><i class="icon-users"> </i>Ver Usuarios</a>
						<a href="log.php" class="w3-bar-item w3-button" title="Registro de Sesiones"><i class="icon-list-alt"> </i>Ver log</a>
					</details>
					<a href='negocio.php' class='w3-bar-item w3-button w3-padding <?=$negocioActivo?>'><i class='icon-gears'> </i>Configuración</a>
				<?php endif; ?>
				<br><br><br><br><br>
			</section>
		</aside>
		<!--====  End of MENÚ LATERAL  ====-->
	
		<!-- Overlay effect when opening sidebar on small screens -->
		<div id="myOverlay" class="w3-overlay w3-hide-large w3-animate-opacity" style="display:none"></div>

		<!--===================================
		=            BOTONES FIJOS            =
		====================================-->
		<?php if ($indexActivo || $ventasActivo): ?>
			<div class="w3-bottom">
				<a href="nuevaVenta.php" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-cart-plus w3-large"><br></i>Nueva<br>Venta
				</a>
			</div>
		<?php elseif ($inventarioActivo): ?>
			<div class="w3-bottom">
				<a href="registrarArticulo.php" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-plus"></i><br>Nuevo<br><small>Producto</small>
				</a>
			</div>
		<?php elseif ($clientesActivo): ?>
			<div class="w3-bottom">
				<a href="registrarCliente.php" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-id-card-o"></i><br>Nuevo<br>Cliente
				</a>
			</div>
		<?php elseif ($proveedoresActivo && $_SESSION["cargo"] == "a"): ?>
			<div class="w3-bottom">
				<a href="registrarProveedor.php" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-truck"></i><br>Nuevo<br><small>Proveedor</small>
				</a>
			</div>
		<?php elseif ($comprasActivo && $_SERVER['PHP_SELF'] != "/licoreria/sistema/nuevaCompra.php"): ?>
			<div class="w3-bottom">
				<a href="nuevaCompra.php" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-cart-plus"></i><br>Nueva<br><small>Compra</small>
				</a>
			</div>
		<?php elseif ($usuariosActivo && $_SESSION["cargo"] == "a"): ?>
			<div class="w3-bottom">
				<a href="registrarUsuario.php" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-user-plus"></i><br>Nuevo<br>Usuario
				</a>
			</div>
		<?php endif; ?>
		<!--====  End of BOTONES FIJOS  ====-->