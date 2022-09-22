<?php require "parciales/head.php" ?>
<?php require "php/actualizarProveedor.php" ?>

	<main class="w3-main" id="proveedores">
		<?php
			$consulta = "SELECT id_p, proveedor, usuario FROM proveedor p INNER JOIN usuario u ON p.ci_u=u.ci_u WHERE id_n={$_SESSION["idNegocio"]}";
			$proveedores = getRegistros($consulta);
			$encabezados = ["ID", "Proveedor", "Usuario"];
			echo "<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>Proveedores</h2>";
			TABLA($proveedores, $encabezados, false, "proveedor", "id_p", [], true);
		?>
	</main>

	<form method="POST" class="w3-margin-top formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formEditProveedor">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h3 class="swal2-title w3-margin-bottom">Actualizar Datos</h3>
		<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="text" name="nombreProveedor" placeholder="Nombre del Proveedor" autocapitalize="words" required minlength="4" maxlength="30" pattern="^[a-zA-Z\dáÁéÉíÍóÓúÚñÑ\s]{4,30}$" title="Sólo se permiten entre 4 y 20 letras">
			</div>
		</section>
		<div class="submit w3-margin-top w3-container">
			<input type="hidden" name="id">
			<input class="w3-padding-large w3-margin-left w3-margin-right" type="submit" value="Actualizar" name="actualizarProveedor">
		</div>
	</form>
<?php require_once "parciales/indexModales.php"?>
<?php include "parciales/footer.php" ?>