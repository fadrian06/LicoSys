<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<!--===================================
=            BOTONES FIJOS            =
====================================-->
<?php if ($indexActivo || $ventasActivo): ?>
	<div class="w3-bottom">
		<a href="nuevaVenta.php" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
			<i class="icon-cart-plus w3-xlarge"></i>Nueva<br>Venta
		</a>
	</div>
<?php elseif ($inventarioActivo): ?>
	<div class="w3-bottom">
		<a href="#" id="registrarProducto" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
			<i class="icon-plus w3-xlarge"></i>Nuevo<br>Producto
		</a>
	</div>
	<?php require_once "parciales/formRegistrarProducto.php" ?>
<?php elseif ($clientesActivo): ?>
	<div class="w3-bottom">
		<a href="#" id="registrarCliente" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
			<i class="icon-id-card-o w3-xlarge"></i>Nuevo<br>Cliente
		</a>
	</div>
	<?php require_once "parciales/formRegistrarClientes.php" ?>
<?php elseif ($proveedoresActivo && $_SESSION["cargo"] == "a"): ?>
	<div class="w3-bottom">
		<a href="#" id="registrarProveedor" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
			<i class="icon-truck w3-xlarge"></i>Nuevo<br>Proveedor
		</a>
	</div>
	<?php require_once "parciales/formRegistrarProveedor.php" ?>
<?php elseif ($comprasActivo && $_SERVER['PHP_SELF'] != "/licoreria/sistema/nuevaCompra.php"): ?>
	<div class="w3-bottom">
		<a href="nuevaCompra.php" id="nuevaCompra" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
			<i class="icon-cart-plus w3-xlarge"></i>Nueva<br>Compra
		</a>
	</div>
<?php elseif ($usuariosActivo && $_SESSION["cargo"] == "a" && $_SERVER["PHP_SELF"] != "/licoreria/sistema/log.php"): ?>
	<div class="w3-bottom">
		<a href="#" id="registrarUsuario" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
			<i class="icon-user-plus w3-xlarge"></i>Nuevo<br>Usuario
		</a>
	</div>
	<?php require_once "parciales/formRegistrarUsuario.php" ?>
<?php elseif($_SERVER["PHP_SELF"] == "/licoreria/sistema/log.php"): ?>
	<div class="w3-bottom">
		<button id="boton-vaciar" class="w3-button w3-margin w3-right w3-blue w3-hover-blue w3-hover-text-black w3-round-xlarge">
			<i class="icon-trash w3-xlarge"></i><br>Vaciar Registro
		</button>
	</div>
<?php endif; ?>