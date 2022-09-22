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
	<?php require_once "parciales/formRegistrarProducto.php" ?>
<?php elseif ($clientesActivo): ?>
	<div class="w3-bottom">
		<span id="registrarCliente" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
			<i class="icon-id-card-o"></i><br>Nuevo<br>Cliente
		</span>
	</div>
	<?php require_once "parciales/formRegistrarClientes.php" ?>
<?php elseif ($proveedoresActivo && $_SESSION["cargo"] == "a"): ?>
	<div class="w3-bottom">
		<span id="registrarProveedor" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
			<i class="icon-truck"></i><br>Nuevo<br><small>Proveedor</small>
		</span>
	</div>
	<?php require_once "parciales/formRegistrarProveedor.php" ?>
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
	<?php require_once "parciales/formRegistrarUsuario.php" ?>
<?php endif; ?>
<!--====  End of BOTONES FIJOS  ====-->