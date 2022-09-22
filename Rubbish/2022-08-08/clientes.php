<?php require_once "partial/head.php";?>
<!-- !CONTENIDO! -->
<main class="w3-main">
	<?php
		$clientes    = CONSULTA("SELECT ci_c, cliente, usuario FROM cliente c INNER JOIN usuario u ON c.ci_u=u.ci_u");
		$encabezados = ["C.I", "Nombre", "Usuario"];
		$campos      = ["ci_c", "cliente", "usuario"];
		echo "
			<header class='w3-container w3-center'>
				<h1 class='w3-bottombar w3-border-gray w3-round-large'>Clientes</h1>
			</header>
		";
		TABLA($clientes, $encabezados, $campos);
	?>
</main>
<?php require_once "partial/footer.php";?>