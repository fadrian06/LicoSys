<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["agregarProducto"])):
		$codigo = ESCAPAR(strtoupper($_POST["codigo"]));
		$nombre = ESCAPAR($_POST["nombreProducto"]);
		$stock  = (int) ESCAPAR($_POST["stock"]);
		$precioB  = substr($_POST["precioB"], 2);
		$precioB  = (float) round($precioB, 2);
		$cantidad    = (float) ESCAPAR($_POST["cantidad"]);
		$precioTotal = (string) $precioB * $cantidad;
		$excento     = ESCAPAR(strtoupper($_POST["excento"]));
		$idProveedor = (int) ESCAPAR($_POST["idProveedor"]);
		if($idProveedor):
			$_SESSION["idProveedor"] = $idProveedor;
			if($cantidad > 0):
				if($temporal = getRegistro("SELECT * FROM carrito_compra WHERE cod='$codigo'")):
					$nuevaCantidad = $cantidad + $temporal["cantidad"];
					setRegistro("UPDATE carrito_compra SET cantidad=$nuevaCantidad WHERE cod='$codigo'");
					$temporal = getRegistro("SELECT * FROM carrito_compra WHERE cod='$codigo'");
					$total = (string) round($temporal["cantidad"] * $temporal["precio_b"], 2);
					setRegistro("UPDATE carrito_compra SET precio_total='$total' WHERE cod='$codigo'");	
				else:
					setRegistro("INSERT INTO carrito_compra VALUES('$codigo', '$nombre', $stock, $precioB, $cantidad, '$precioTotal')");
				endif;
			else:
				$notificacion = "
					<script>
						alerta('<b>Cantidad</b> no puede ser menor a 1</b>');
					</script>
				";
			endif;
			$temporal = getRegistro("SELECT * FROM carrito_compra WHERE cod='$codigo'");
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
			$datosCarrito = getRegistros("SELECT * FROM carrito_compra ORDER BY nom_p");
			$productos    = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
		else:
			$notificacion = "
				<script>
					alerta('Por favor seleccione un proveedor');
				</script>
			";
		endif;
	endif;
?>