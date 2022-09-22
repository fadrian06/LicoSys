<?php require_once "parciales/head.php" ?>

	<main class="w3-main">
		<?php
			if ($_SESSION["cargo"] == "a"):
				$logs        = getRegistros("SELECT fecha, nom_u, usuario FROM log l INNER JOIN usuario u ON l.ci_u=u.ci_u WHERE l.id_n={$_SESSION['idNegocio']} ORDER BY fecha DESC");
				$encabezados = ["Fecha", "Nombre", "Usuario"];
				echo "<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>Registro de Sesiones</h2>";
				TABLA($logs, $encabezados);
			else:
				$restringido = REDIRECCIONAR();
			endif
		?>
	</main>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php" ?>