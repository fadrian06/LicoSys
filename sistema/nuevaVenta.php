<?php require_once "parciales/head.php" ?>
<?php
	$clientes  = getRegistros("SELECT * FROM cliente ORDER BY cliente");
	$productos = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
	$datosCarrito = getRegistros("SELECT * FROM carrito_venta");

	require_once "php/registrarCliente.php";
	require_once "php/registrarProducto.php";
	require_once "php/actualizarMonedas.php";
	require_once "php/agregarProducto.php";
	require_once "php/anularVenta.php";
	require_once "php/generarVenta.php";
?>
<main class="w3-main w3-container" id="panelNuevaVenta">
	<?php require_once "parciales/datosCliente.php" ?>
	<?php require_once "parciales/datosVenta.php" ?>
	<?php require_once "parciales/datosCarritoVenta.php" ?>
</main>

<div class="w3-bottom w3-hide">
	<span id="registrarCliente" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
		<i class="icon-id-card-o"></i><br>Nuevo<br>Cliente
	</span>
</div>
<div class="w3-bottom w3-hide">
	<span id="registrarProducto" class="w3-button w3-circle w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black">
		<i class="icon-plus"></i><br>Nuevo<br><small>Producto</small>
	</span>
</div>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/formRegistrarClientes.php"?>
<?php require_once "parciales/formRegistrarProducto.php"?>
<?php require_once "parciales/footer.php" ?>