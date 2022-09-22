<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["procesar"])):
		$iva = getIVA();
		$fecha = getHora();
		$items = count($_POST);
		for($i = 0; $i <= $items; $i++):
			if(isset($_POST["codigo$i"])) $codigos[$i] = $_POST["codigo$i"];
		endfor;
		$datosCarrito = getRegistros("SELECT * FROM carrito_venta");
		foreach($datosCarrito as $datoCarrito):
			$precioVenta = !empty($datoCarrito["total_iva"])
				? $datoCarrito["total_iva"]
				: $datoCarrito["precio_total"];
				setRegistro("INSERT INTO venta VALUES(NULL, '$fecha', {$_SESSION["ciCliente"]}, '{$datoCarrito['cod']}', {$datoCarrito['cantidad']}, '$precioVenta', $iva, {$_SESSION["idUsuario"]}, {$_SESSION["idNegocio"]})");
		endforeach;
		setRegistro("TRUNCATE TABLE carrito_venta");
		$notificacion = "
			<script>
				notificacion('Venta realizada exitósamente', false);
				window.scrollTo(0, document.body.scrollHeight);
			</script>
		";
		$datosCarrito = getRegistros("SELECT * FROM carrito_venta ORDER BY nom_p");
		$productos    = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
	endif;
?>