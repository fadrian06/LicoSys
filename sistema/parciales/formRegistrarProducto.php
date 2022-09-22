<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<form method="POST" class="w3-margin-top formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formularioRegistrarProducto">
	<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
	<h3 class="swal2-title w3-margin-bottom">Registro de Productos</h3>
	<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="text" name="codigo" placeholder="Código del Producto" minlength="3" maxlength="10" required autofocus autocapitalize="characters" pattern="^[a-zA-Z\d-.#]{3,10}$" title="Sólo se permiten letras, números y símbolos (- . #)">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="text" name="nombreProducto" placeholder="Nombre del Producto" autocapitalize="words" required minlength="4" maxlength="30" pattern="^[\w-áÁéÉíÍóÓúÚñÑ\s]{4,50}$," title="Sólo se permiten entre 4 y 20 letras, números y símbolos (_ -)">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="number" name="stock" placeholder="Existencia" required pattern="^[^e]?[\d]+$">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="text" name="precio" placeholder="Precio" required pattern="^[\d.]+$">
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