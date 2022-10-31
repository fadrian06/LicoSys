<?php
	if(isset($_GET["vaciar"])):
		require "../php/conexion.php";
		require "../php/funciones.php";
		setRegistro("TRUNCATE TABLE log");
		echo "true";
	else:
		require_once "parciales/head.php" ?>
		<main class="w3-main" id="log">
			<?php
				if ($_SESSION["cargo"] == "a"):
					$logs        = getRegistros("SELECT fecha, nom_u, usuario FROM log l INNER JOIN usuario u ON l.ci_u=u.ci_u WHERE l.id_n={$_SESSION['idNegocio']} GROUP BY l.ci_u ORDER BY l.fecha");
					$encabezados = ["Fecha", "Nombre", "Usuario"];
					echo "<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>Registro de Sesiones</h2>";
					TABLA($logs, $encabezados);
				else:
					$restringido = REDIRECCIONAR();
				endif
			?>
		</main>
		<?php require_once "parciales/indexModales.php"?>
		<?php require_once "parciales/footer.php";
	endif
?>