<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["anular"])):
		$items = count($_POST);
		for($i = 0; $i <= $items; $i++):
			if(isset($_POST["codigo$i"])) $codigos[$i] = $_POST["codigo$i"];
		endfor;
		$productos = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
		$cantidadCodigos = count($codigos);
		foreach($productos as $producto):
			for($i = 1; $i <= $cantidadCodigos; $i++):
				if($producto["cod"] == $codigos[$i]):
					$productoTemporal = getRegistro("SELECT * FROM carrito_venta WHERE cod='{$codigos[$i]}'");
					setRegistro("UPDATE inventario SET stock={$productoTemporal["stock"]} WHERE cod='{$codigos[$i]}'");
				endif;
			endfor;
		endforeach;
		setRegistro("TRUNCATE TABLE carrito_venta");
		$notificacion = "
			<script>
				notificacion('Venta anulada');
				window.scrollTo(0, document.body.scrollHeight);
			</script>
		";
		$datosCarrito = getRegistros("SELECT * FROM carrito_venta ORDER BY nom_p");
		$productos    = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
	endif;
?>