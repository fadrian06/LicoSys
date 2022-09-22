<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<section class="w3-row-padding w3-margin-bottom">
	<?php if($_SESSION["cargo"] == "a"): ?>
		<a href="ventas.php" class="w3-quarter w3-hover-opacity">
			<div class="w3-container w3-red w3-padding-16">
				<i class="icon-list-alt w3-xxxlarge w3-left"></i>
				<span class="w3-right w3-xlarge"><?=$numVentas?></span>
				<div class="w3-clear"></div>
				<span class="w3-large w3-block w3-margin-top">Ventas</span>
			</div>
		</a>
		<a href="compras.php" class="w3-quarter w3-hover-opacity">
			<div class="w3-container w3-blue w3-padding-16">
				<i class="icon-handshake-o w3-xxxlarge w3-left"></i>
				<span class="w3-right w3-xlarge"><?=$numCompras?></span>
				<div class="w3-clear"></div>
				<span class="w3-large w3-block w3-margin-top">Compras</span>
			</div>
		</a>
	<?php endif; ?>
	<a href="inventario.php" class="<?=$_SESSION["cargo"]=="a" ? "w3-quarter" : "w3-half"?> w3-hover-opacity">
		<div class="w3-container w3-teal w3-padding-16">
			<i class="icon-product-hunt w3-xxxlarge w3-left"></i>
			<span class="w3-right w3-xlarge"><?=$numProductos?></span>
			<div class="w3-clear"></div>
			<span class="w3-large w3-block w3-margin-top">Productos</span>
		</div>
	</a>
	<a href="<?=($_SESSION['cargo']=='a') ? 'usuarios.php' : 'clientes.php'?>" class="<?=$_SESSION["cargo"]=="a" ? "w3-quarter" : "w3-half"?> w3-hover-opacity">
		<div class="w3-container w3-orange w3-text-white w3-padding-16">
			<i class="icon-users w3-xxxlarge w3-left"></i>
			<span class="w3-right w3-xlarge"><?=$_SESSION["cargo"]=="a" ? contarRegistros("usuario") - 1 : contarRegistros("cliente")?></span class="w3-right w3-xlarge">
			<div class="w3-clear"></div>
			<span class="w3-large w3-block w3-margin-top"><?=$_SESSION["cargo"]=="a" ? "Usuarios" : "Clientes"?></span>
		</div>
	</a>
</section>