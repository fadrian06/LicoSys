<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["agregarProducto"])):
		$codigo      = ESCAPAR(strtoupper($_POST["codigo"]));
		$nombre      = ESCAPAR($_POST["nombreProducto"]);
		$stock       = (int) ESCAPAR($_POST["stock"]);
		$precioB     = substr($_POST["precioB"], 2);
		$precioB     = (float) round($precioB, 2);
		$cantidad    = (float) ESCAPAR($_POST["cantidad"]);
		$precioTotal = (string) $precioB * $cantidad;
		$excento     = ESCAPAR(strtoupper($_POST["excento"]));
		$iva         = getIVA();
		$ciCliente   = (int) ESCAPAR($_POST["ci"]);
		$totalIva = "0";
		if(!empty($ciCliente)):
			$_SESSION["ciCliente"] = $ciCliente;
			if($cantidad <= $stock):
				if($temporal = getRegistro("SELECT * FROM carrito_venta WHERE cod='$codigo'")):
					$nuevaCantidad = $cantidad + $temporal["cantidad"];
					setRegistro("UPDATE carrito_venta SET cantidad=$nuevaCantidad WHERE cod='$codigo'");
					$temporal = getRegistro("SELECT * FROM carrito_venta WHERE cod='$codigo'");
					$total = round($temporal["cantidad"] * $temporal["precio_b"], 2);
					if($temporal["excento"] == "SI") $totalIva = (string) round($total + ($total * $iva), 2);
					setRegistro("UPDATE carrito_venta SET precio_total='$total', total_iva='$totalIva' WHERE cod='$codigo'");
					$nuevoStock = $temporal["stock"] - $temporal["cantidad"];
					setRegistro("UPDATE inventario SET stock=$nuevoStock WHERE cod='$codigo'");
					$notificacion = "
						<script>
							window.scrollTo(0, document.body.scrollHeight);
						</script>
					";
				else:
					if($excento == "SI") $totalIva = (string) round(($precioTotal + ($precioTotal * $iva)), 2);
					setRegistro("INSERT INTO carrito_venta VALUES('$codigo', '$nombre', $stock, $precioB, $cantidad, '$excento', '$precioTotal', '$totalIva')");
				endif;
				$temporal = getRegistro("SELECT * FROM carrito_venta WHERE cod='$codigo'");
				$nuevoStock = $temporal["stock"] - $temporal["cantidad"];
				if($nuevoStock <= 0) $nuevoStock = 0;
				setRegistro("UPDATE inventario SET stock=$nuevoStock WHERE cod='$codigo'");
				$notificacion = "
					<script>
						window.scrollTo(0, document.body.scrollHeight);
					</script>
				";
				$codigo      = "";
				$nombre      = "";
				$stock       = "";
				$precioB     = "";
				$cantidad    = "";
				$precioTotal = "";
				$excento     = "";
				$datosCarrito = getRegistros("SELECT * FROM carrito_venta ORDER BY nom_p");
				$productos    = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
			else:
				$notificacion = "
					<script>
						alerta('<b>Cantidad</b> no puede ser mayor a <b>Existencia</b>');
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Por favor seleccione un cliente');
				</script>
			";
		endif;
	endif;
?>