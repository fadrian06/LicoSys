<?php require_once "parciales/head.php" ?>

	<main class="w3-main">
		<?php if($_SESSION["cargo"] == "a"):
			$consulta = "SELECT fecha_v, cliente, nom_p, unidades, precio_v, iva, usuario FROM venta INNER JOIN cliente INNER JOIN inventario INNER JOIN usuario ON venta.ci_c=cliente.ci_c AND venta.cod=inventario.cod AND venta.ci_u=usuario.ci_u AND venta.id_n={$_SESSION["idNegocio"]}";
			$ventas = getRegistros($consulta);
			$encabezados = ["Fecha", "Cliente", "Producto", "Unidades", "Precio", "IVA", "Usuario"];
			echo "<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>Ventas</h2>";
			TABLA($ventas, $encabezados);
		else:
			$restringido = REDIRECCIONAR();
		endif?>
	</main>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php" ?>