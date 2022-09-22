<?php require_once "partial/head.php";?>
<main class="w3-main">
	<?php
		$productos   = CONSULTA("SELECT cod, nom_p, stock, excento, precio_b, usuario FROM inventario i INNER JOIN usuario u ON i.ci_u=u.ci_u ORDER BY cod");
		$encabezados = ["Código", "Nombre", "Existencia", "Excento", "Precio", "Usuario"];
		$campos      = ["cod", "nom_p", "stock", "excento", "precio_b", "usuario"];
		echo "
			<header class='w3-container w3-center'>
				<h1 class='w3-bottombar w3-border-gray w3-round-large'>Inventario</h1>
			</header>
		";
		TABLA($productos, $encabezados, $campos);
	?>
</main>
<?php require_once "partial/footer.php";?>