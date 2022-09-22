<?php require_once "parciales/head.php" ?>
<?php require_once "php/actualizarCliente.php" ?>

	<main class="w3-main" id="clientes">
		<?php
			$clientes    = getRegistros("SELECT ci_c, cliente, usuario FROM cliente c INNER JOIN usuario u ON c.ci_u=u.ci_u");
			$encabezados = ["C.I", "Nombre", "Usuario"];
			echo "<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>Clientes</h2>";
			TABLA($clientes, $encabezados, false, "cliente", "ci_c", [], true);
		?>
	</main>

	<form method="POST" class="w3-margin-top formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formEditCliente">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h3 class="swal2-title w3-margin-bottom">Actualizar Datos</h3>
		<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="number" name="cedula" placeholder="Cédula del Cliente" minlength="7" maxlength="8" autocomplete="off" required pattern="^[^e]?[\d]{7,8}$" title="Un número entre 7 y 8 dígitos">
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="text" name="nombre" placeholder="Nombre del Cliente" required minlength="4" maxlength="20" autocomplete="off" autocapitalize pattern="^[a-zA-Z]{4,20}$" title="Sólo se permiten entre 4 y 20 letras sin espacios">
			</div>
		</section>
		<div class="submit w3-margin-top w3-container">
			<input type="hidden" name="ci">
			<input class="w3-padding-large w3-margin-left w3-margin-right" type="submit" value="Actualizar" name="actualizarCliente">
		</div>
	</form>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php" ?>