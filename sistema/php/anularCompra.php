<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["anular"])):
		setRegistro("TRUNCATE TABLE carrito_compra");
		$notificacion = "
			<script>
				notificacion('Compra anulada');
				window.scrollTo(0, document.body.scrollHeight);
			</script>
		";
		$datosCarrito = getRegistros("SELECT * FROM carrito_compra ORDER BY nom_p");
		$productos    = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
	endif;
?>