<?php require_once "parciales/head.php" ?>

	<main class="w3-main w3-padding-large">
		<?php
			if($_SESSION["cargo"]=="a"):
				$usuarios = getRegistros("SELECT ci_u, nom_u, usuario, tlf FROM usuario WHERE cargo<>'a' AND activo=1");
				$desactivados = getRegistros("SELECT ci_u, nom_u, usuario, tlf FROM usuario WHERE cargo<>'a' AND activo=0");
				$encabezados = ["C.I", "Nombre", "Usuario", "Teléfono"];
				echo "<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>Usuarios</h2>";
				TABLA($usuarios, $encabezados, true, "usuario", "ci_u", $desactivados);
			else:
				$restringido = REDIRECCIONAR();
			endif?>
	</main>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php" ?>