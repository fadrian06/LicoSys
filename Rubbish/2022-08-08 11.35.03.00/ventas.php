<?php require "partial/head.php";?>
<!-- !CONTENIDO! -->
<main class="w3-main">
	<?php
		$consulta = "SELECT fecha_v, cliente, nom_p, unidades, precio_v, iva, usuario FROM venta v INNER JOIN cliente c INNER JOIN inventario i INNER JOIN iva INNER JOIN usuario u ON v.ci_u=c.ci_u AND v.cod=i.cod AND v.fecha_iva=iva.fecha_iva AND v.ci_u=u.ci_u";
		$ventas = CONSULTA($consulta);
		$encabezados = ["Fecha", "Cliente", "Producto", "Unidades", "Precio", "IVA", "Usuario"];
		$campos = ["fecha_v", "cliente", "nom_p", "unidades", "precio_v", "iva", "usuario"];
		echo "
			<header class='w3-container w3-center'>
				<h1 class='w3-bottombar w3-border-gray w3-round-large'>Ventas</h1>
			</header>
		";
		TABLA($ventas, $encabezados, $campos);
	?>
</main>
<?php include "partial/footer.php";?>