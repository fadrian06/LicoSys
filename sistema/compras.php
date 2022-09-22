<?php require_once "parciales/head.php" ?>

	<main class="w3-main">
		<?php if($_SESSION["cargo"] == "a"):
			$compras     = getRegistros("SELECT fecha_c, cod, producto, unidades, precio_c, proveedor FROM compra c INNER JOIN proveedor p ON c.id_p=p.id_p AND c.id_n={$_SESSION["idNegocio"]}");
			$encabezados = ["Fecha", "Código", "Producto", "Unidades", "Precio", "Proveedor"];
			echo "<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>Compras</h2>";
			TABLA($compras, $encabezados);
		else:
			$restringido = REDIRECCIONAR();
		endif?>
	</main>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php" ?>