<?php require_once "partial/head.php";?>
<!-- !CONTENIDO! -->
<main class="w3-main">
	<?php
		$compras     = CONSULTA("SELECT fecha_c, unidades, precio_c, proveedor, usuario FROM compra c INNER JOIN proveedor p INNER JOIN usuario u ON c.id_p=p.id_p AND c.ci_u=u.ci_u");
		$encabezados = ["Fecha", "Unidades", "Precio", "Proveedor", "Usuario"];
		$campos      = ["fecha_c", "unidades", "precio_c", "proveedor", "usuario"];
		echo "
			<header class='w3-container w3-center'>
				<h1 class='w3-bottombar w3-border-gray w3-round-large'>Compras</h1>
			</header>
		";
		TABLA($compras, $encabezados, $campos);
	?>
</main>
<?php require_once "partial/footer.php";?>