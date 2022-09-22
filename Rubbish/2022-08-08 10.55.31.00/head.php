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

	$versiones = CONSULTA("SELECT * FROM versiones");
	$version = CONSULTA("SELECT MAX(id_v) FROM versiones");
	$ultimaVersion = $version[0]["MAX(id_v)"];
	$version = CONSULTA("SELECT * FROM versiones WHERE id_v=$ultimaVersion");
	$ultimaVersion = $version[0]["nombre_v"];

	if (isset($_POST["registrarProducto"])):
		$codigo = ESCAPAR_STRING($_POST["codigo"]);
		$nombre = ESCAPAR_STRING($_POST["nombreProducto"]);
		$stock = (int) $_POST["stock"];
		$precio = !empty($_POST["precio"]) ? round($_POST["precio"], 2) : 0.00;
		$excento = ESCAPAR_STRING($_POST["excento"]);
		$cedulaUsuario = (int) $_SESSION["idUsuario"];
		$negocio = (int) $_SESSION["negocio"];

		$consulta="SELECT * FROM inventario WHERE cod='$codigo' AND nom_p='$nombre' AND excento='$excento'";
		$resultado=mysqli_query($conexion, $consulta);
		if(mysqli_num_rows($resultado)>0):
			$notificacion = "
				<script>
					Swal.fire({
						title: 'Producto ya existe',
						icon: 'error',
						toast: true,
						timer: 5000,
						timerProgressBar: true,
						position: 'bottom-end',
						showConfirmButton: false
					})
					document.querySelector('#registrarProducto').click();
				</script>
			";
		else:
			$sql="INSERT INTO inventario VALUES('$codigo', '$nombre', $stock, '$excento', $precio, $negocio, $cedulaUsuario)";
			$resultado=mysqli_query($conexion, $sql);
			if(mysqli_affected_rows($conexion)>0):
				$notificacion = "
					<script>
						Swal.fire({
							title: 'Registro exitoso',
							icon: 'success',
							timer: 2000,
							timerProgressBar: true,
							showConfirmButton: false
						})
					</script>
				";
			else:
				$notificacion = "
					<script>
						Swal.fire({
							title: 'Ha ocurrido un error, por favor intente nuevamente',
							icon: 'error',
							toast: true,
							timer: 5000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
						document.querySelector('#registrarProducto').click();
					</script>
				";
			endif;
		endif;
	endif;

	if (isset($_POST["registrarCliente"])):
		$cedula = (int) $_POST["cedula"];
		$nombre = ESCAPAR_STRING($_POST["nombre"]);
		$cedulaUsuario = (int) $_SESSION["idUsuario"];

		$consulta="SELECT * FROM cliente WHERE ci_c='$cedula'";
		$resultado=mysqli_query($conexion, $consulta);
		if(mysqli_num_rows($resultado)>0):
			$notificacion = "
				<script>
					Swal.fire({
						title: 'Cliente ya existe',
						icon: 'error',
						toast: true,
						timer: 5000,
						timerProgressBar: true,
						position: 'bottom-end',
						showConfirmButton: false
					})
					document.querySelector('#registrarCliente').click();
				</script>
			";
		else:
			$sql="INSERT INTO cliente VALUES($cedula, '$nombre', $cedulaUsuario)";
			$resultado=mysqli_query($conexion, $sql);
			if(mysqli_affected_rows($conexion)>0):
				$notificacion = "
					<script>
						Swal.fire({
							title: 'Registro exitoso',
							icon: 'success',
							timer: 2000,
							timerProgressBar: true,
							showConfirmButton: false
						})
					</script>
				";
			else:
				$notificacion = "
					<script>
						Swal.fire({
							title: 'Ha ocurrido un error, por favor intente nuevamente',
							icon: 'error',
							toast: true,
							timer: 5000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
						document.querySelector('#registrarCliente').click();
					</script>
				";
			endif;
		endif;
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
		<link rel="stylesheet" href="../librerias/animate.min.css">
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
			<div class="w3-container w3-center w3-medium w3-cell w3-cell-middle"><a href="#registroCambios">LicoSys <?=$ultimaVersion?></a></div>
			<a href="index.php" class="w3-right w3-cell w3-button"><?=$negocio?></a>
		</nav>
		<!--====  End of MENÚ SUPERIOR  ====-->
		
		<!--==================================
		=            MENÚ LATERAL            =
		===================================-->
		<aside class="w3-sidebar w3-collapse w3-white w3-animate-left w3-padding-top-24" id="mySidebar" style="display:none">
			<header class="w3-container w3-row w3-border-bottom w3-margin-bottom">
				<div class="w3-col s4">
					<a href="miPerfil.php"><img src="<?=!empty($_SESSION["foto"]) ? "../imagenes/perfil/{$_SESSION["foto"]}" : "../imagenes/avatar2.png"?>" class="w3-circle w3-margin-right" id="fotoPerfil"></a>
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
		<div class="overlayModal w3-overlay w3-hide"></div>

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
				<span id="registrarProducto" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-plus"></i><br>Nuevo<br><small>Producto</small>
				</span>
			</div>
			<form action="" method="POST" class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formularioRegistrarProducto">
				<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
				<h3 class="swal2-title w3-margin-bottom">Registro de Productos</h3>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="text" name="codigo" placeholder="Código del Producto" minlength="3" maxlength="10" required>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="text" name="nombreProducto" placeholder="Nombre del Producto" required>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="number" name="stock" placeholder="Existencia">
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="text" name="precio" placeholder="Precio" required>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
					<label for="">Excento</label>
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<select class="w3-margin-left w3-border-0" name="excento" required title="Indica si el producto es excento de IVA">
							<option value="SI">SI</option>
							<option value="NO">NO</option>
						</select>
					</div>
				</section>
				<div class="submit w3-margin-top w3-container">
					<input class="w3-padding-large w3-margin-left w3-margin-right" type="submit" value="Registrar" name="registrarProducto">
				</div>
			</form>
		<?php elseif ($clientesActivo): ?>
			<div class="w3-bottom">
				<span id="registrarCliente" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-id-card-o"></i><br>Nuevo<br>Cliente
				</span>
			</div>
			<form action="" method="POST" class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formularioRegistrarCliente">
				<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
				<h3 class="swal2-title w3-margin-bottom">Registro de Clientes</h3>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="number" name="cedula" placeholder="Cédula del Cliente" minlength="7" maxlength="8" required>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="text" name="nombre" placeholder="Nombre del Cliente" required>
					</div>
				</section>
				<div class="submit w3-margin-top w3-container">
					<input class="w3-padding-large w3-margin-left w3-margin-right" type="submit" value="Registrar" name="registrarCliente">
				</div>
			</form>
		<?php elseif ($proveedoresActivo && $_SESSION["cargo"] == "a"): ?>
			<div class="w3-bottom">
				<span id="registrarProveedor" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-truck"></i><br>Nuevo<br><small>Proveedor</small>
				</span>
			</div>
			<form action="" method="POST" class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formularioRegistrarProveedor">
				<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
				<h3 class="swal2-title w3-margin-bottom">Registro de Proveedores</h3>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="text" name="nombre" placeholder="Nombre del Proveedor" required>
					</div>
				</section>
				<div class="submit w3-margin-top w3-container">
					<input class="w3-padding-large w3-margin-left w3-margin-right" type="submit" value="Registrar" name="registrarProveedor">
				</div>
			</form>
		<?php elseif ($comprasActivo && $_SERVER['PHP_SELF'] != "/licoreria/sistema/nuevaCompra.php"): ?>
			<div class="w3-bottom">
				<span id="nuevaCompra" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-cart-plus"></i><br>Nueva<br><small>Compra</small>
				</span>
			</div>
		<?php elseif ($usuariosActivo && $_SESSION["cargo"] == "a"): ?>
			<div class="w3-bottom">
				<span id="registrarUsuario" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
					<i class="icon-user-plus"></i><br>Nuevo<br>Usuario
				</span>
			</div>
		<?php endif; ?>
		<!--====  End of BOTONES FIJOS  ====-->