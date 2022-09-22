<?php require "partial/head.php";?>
<main class="w3-main">
	<?php
		$negocio = $_SESSION["negocio"];
		$consulta = "SELECT id_p, proveedor, usuario FROM proveedor p INNER JOIN usuario u ON p.ci_u=u.ci_u WHERE id_n=$negocio";
		$proveedores = CONSULTA($consulta);
		$campos = ["id_p", "proveedor", "usuario"];
		$encabezados = ["ID", "Proveedor", "Usuario"];
		echo "
			<header class='w3-container w3-center'>
				<h1 class='w3-bottombar w3-border-gray w3-round-large'>Proveedores</h1>
			</header>
		";
		TABLA($proveedores, $encabezados, $campos);
	?>
</main>
<?php include "partial/footer.php";?>