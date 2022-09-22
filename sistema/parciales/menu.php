<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<div class="w3-overlay w3-animate-opacity w3-hide" id="menuOverlay"></div>

<!--===================================
=            MENÚ SUPERIOR            =
====================================-->
<nav class="w3-cell-row w3-top w3-black w3-large">
	<button id="barras" class="w3-cell w3-cell-middle w3-button w3-hide-large w3-hover-none w3-hover-text-grey">
		<i class="icon-bars"> </i>
	Menú</button>
	<div class="w3-container w3-small w3-cell w3-cell-middle w3-hide-medium w3-hide-small"><?=FECHA()?></div>
	<div class="w3-center w3-medium w3-cell w3-cell-middle w3-hide-medium w3-hide-small">
		<button id="version" class="w3-button">LicoSys <?=getUltimaVersion()?></button>
	</div>
	<a href="index.php" class="w3-medium w3-right w3-cell w3-cell-middle w3-button">
		<img class="w3-image w3-circle w3-hide-small" src="<?=!empty($_SESSION['logo']) ? "../imagenes/negocios/{$_SESSION["logo"]}" : "../imagenes/logoNegocio.jpg"?>" style="height: 25px;width:25px">
	&nbsp;<?=$_SESSION["nombreNegocio"]?></a>
</nav>

<!--==================================
=            MENÚ LATERAL            =
===================================-->
<aside class="w3-sidebar w3-collapse w3-white w3-animate-left w3-padding-top-24 w3-hide" id="mySidebar">
	<header class="w3-container w3-row w3-border-bottom w3-margin-bottom">
		<div class="w3-col s4">
			<a href="miPerfil.php"><img src="<?=!empty($_SESSION["foto"]) ? "../imagenes/perfil/{$_SESSION["foto"]}" : "../imagenes/avatar2.png"?>" class="w3-circle w3-margin-right" id="fotoPerfil"></a>
		</div>
		<div class="w3-col s8 w3-bar">
			<div>Bienvenido, <strong><?=$_SESSION["nombreUsuario"]?></strong></div>
			<a href="miPerfil.php" class="w3-bar-item w3-button" title="Mi Perfil"><i class="icon-cog"></i></a>
			<a href="salir.php" class="w3-bar-item w3-button" title="Cerrar Sesión"><i class="icon-sign-out"></i></a>
		</div>
	</header>
	<p class="w3-container">Panel de Administración</p>
	<section class="w3-bar-block">
		<a href="index.php" class="w3-bar-item w3-button w3-padding <?=$indexActivo?>"><i class="icon-home"> </i>Inicio</a>
		<a href="nuevaVenta.php" class="w3-bar-item w3-button w3-padding <?=$nuevaVentaActivo?>"><i class="icon-shopping-cart"> </i>Nueva Venta</a>
		<a href="inventario.php" class="w3-bar-item w3-button w3-padding <?=$inventarioActivo?>"><i class="icon-product-hunt"> </i>Inventario</a>
		<a href="clientes.php" class="w3-bar-item w3-button w3-padding <?=$clientesActivo?>"><i class="icon-id-card"> </i>Clientes</a>
		<a href="proveedores.php" class="w3-bar-item w3-button w3-padding <?=$proveedoresActivo?>"><i class="icon-address-book"> </i>Proveedores</a>
		<?php if ($_SESSION["cargo"] == "a"): ?>
			<a href="ventas.php" class="w3-bar-item w3-button w3-padding <?=$ventasActivo?>"><i class="icon-list-alt"> </i>Ventas</a>
			<details class="w3-bar-block w3-light-gray">
				<summary class="w3-hover-grey <?=$comprasActivo?>"><i class="icon-handshake-o"> </i>Compras</summary>
				<a href="compras.php" class="w3-bar-item w3-button w3-padding"><i class="icon-handshake-o"> </i>Ver Compras</a>
				<a href="nuevaCompra.php" class="w3-bar-item w3-button"><i class="icon-cart-plus"> </i>Nueva Compra</a>
			</details>
			<details class="w3-bar-block w3-light-gray">
				<summary class="w3-hover-grey <?=$usuariosActivo?>"><i class="icon-users"> </i>Usuarios</summary>
				<a href="usuarios.php" class="w3-bar-item w3-button"><i class="icon-users"> </i>Ver Usuarios</a>
				<a href="log.php" class="w3-bar-item w3-button" title="Registro de Sesiones"><i class="icon-list-alt"> </i>Ver log</a>
			</details>
			<a href='negocio.php' class='w3-bar-item w3-button w3-padding <?=$negocioActivo?>'><i class='icon-gears'> </i>Configuración</a>
			<a href='finanzas.php' class='w3-bar-item w3-button w3-padding <?=$finanzasActivo?>'><i class='icon-bar-chart'> </i>Finanzas</a>
		<?php endif; ?>
		<br><br><br><br><br>
	</section>
</aside>