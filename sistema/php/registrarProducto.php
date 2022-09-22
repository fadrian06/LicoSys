<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if (isset($_POST["registrarProducto"])):
		$codigo  = ESCAPAR(strtoupper($_POST["codigo"]));
		$nombre  = ESCAPAR(CAPITALIZE($_POST["nombreProducto"]));
		$stock   = (int) $_POST["stock"];
		$precio  = round($_POST["precio"], 2);
		$excento = ESCAPAR(strtoupper($_POST["excento"]));

		if($codigo && $nombre && $stock && $precio && $excento):
			$filas = CONSULTA("SELECT * FROM inventario WHERE cod = '$codigo' OR nom_p = '$nombre'");
			if($filas):
				$notificacion = "
					<script>
						alerta('Producto ya existe');
						botonRegistrarProducto.click();
					</script>
				";
			else:
				if(setRegistro("INSERT INTO inventario VALUES('$codigo', '$nombre', $stock, '$excento', $precio, {$_SESSION["idNegocio"]}, {$_SESSION["idUsuario"]})")):
					$notificacion = registroExitoso();
				else:
					$notificacion = "
						<script>
							" . getSQLError() . ";
							botonRegistrarProducto.click();
						</script>
					";
				endif;
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Todos los campos son requeridos');
					botonRegistrarProducto.click();
				</script>
			";
		endif;
	endif;
?>