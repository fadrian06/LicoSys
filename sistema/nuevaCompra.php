<?php require "parciales/head.php" ?>
<?php
	$proveedores  = getRegistros("SELECT * FROM proveedor ORDER BY proveedor");
	$productos    = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
	$datosCarrito = getRegistros("SELECT * FROM carrito_compra");

	require_once "php/registrarProveedor.php";
	require_once "php/registrarProducto.php";
	require_once "php/actualizarMonedas.php";
	require_once "php/agregarProductoCompra.php";
	require_once "php/anularCompra.php";
	require_once "php/generarCompra.php";
?>
	<main class="w3-main w3-container" id="panelNuevaCompra">
		<?php if($_SESSION["cargo"] == "a"):?>
			<?php require_once "parciales/datosProveedor.php" ?>
			<?php require_once "parciales/datosCompra.php" ?>
			<?php require_once "parciales/datosCarritoCompra.php" ?>
		<?php else: $restringido = REDIRECCIONAR();
		endif?>
	</main>
<div class="w3-bottom w3-hide">
	<a href="#" id="registrarProveedor" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
		<i class="icon-truck w3-xlarge"></i>Nuevo<br>Proveedor
	</a>
</div>
<div class="w3-bottom w3-hide">
	<a href="#" id="registrarProducto" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
		<i class="icon-plus w3-xlarge"></i>Nuevo<br>Producto
	</a> 
</div>
<?php require_once "parciales/indexModales.php" ?>
<?php require_once "parciales/formRegistrarProveedor.php" ?>
<?php require_once "parciales/formRegistrarProducto.php" ?>
<?php require_once "parciales/footer.php" ?>