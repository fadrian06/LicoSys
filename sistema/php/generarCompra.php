<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["procesar"])):
		$fecha = getHora();
		$items = count($_POST);
		for($i = 0; $i <= $items; $i++):
			if(isset($_POST["codigo$i"])) $codigos[$i] = $_POST["codigo$i"];
		endfor;
		$datosCarrito = getRegistros("SELECT * FROM carrito_compra");
		foreach($datosCarrito as $datoCarrito):
			$codigo = $datoCarrito["cod"];
			$producto = getRegistro("SELECT * FROM inventario WHERE cod='$codigo'");
			$precioB = ($datoCarrito["precio_b"] > $producto["precio_b"])
				? (string) $datoCarrito["precio_b"]
				: (string) $producto["precio_b"];
			$nuevoStock = (int) $producto["stock"] + $datoCarrito["cantidad"];
			setRegistro("INSERT INTO compra VALUES(NULL, '$fecha', '{$datoCarrito["cod"]}', '{$datoCarrito["nom_p"]}', {$datoCarrito["cantidad"]}, '{$datoCarrito["precio_b"]}', {$_SESSION["idProveedor"]}, {$_SESSION["idUsuario"]}, {$_SESSION["idNegocio"]})");
			setRegistro("UPDATE inventario SET precio_b='$precioB', stock=$nuevoStock WHERE cod='$codigo'");
		endforeach;
		setRegistro("TRUNCATE TABLE carrito_compra");
		$notificacion = "
			<script>
				notificacion('Compra realizada exitósamente', false);
				window.scrollTo(0, document.body.scrollHeight);
			</script>
		";
		$datosCarrito = getRegistros("SELECT * FROM carrito_compra ORDER BY nom_p");
		$productos    = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
	endif;
?>