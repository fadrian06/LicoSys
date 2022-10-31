<?php @session_start(); if(!isset($_SESSION["activa"])) require '../salir.php' ?>
<?php
	if (isset($_POST['actualizarProducto'])):
		$cod = ESCAPAR(strtoupper($_POST["cod"]));
		$codigo  = ESCAPAR(strtoupper($_POST["codigo"]));
		$nombre  = ESCAPAR(CAPITALIZE($_POST["nombreProducto"]));
		$stock   = (int) $_POST["stock"];
		$precio  = round($_POST["precio"], 2);
		$excento = ESCAPAR(strtoupper($_POST["excento"]));

		if($codigo && $nombre && $stock && $precio && $excento):
			$filas = CONSULTA("SELECT * FROM inventario WHERE cod='$codigo'");
			if($filas === null):
				$notificacion = "
					<script>
						notificacion('Código de producto no existe');
					</script>
				";
			elseif(setRegistro("UPDATE inventario SET cod='$codigo', nom_p='$nombre', stock=$stock, precio_b='$precio', excento='$excento' WHERE cod='$cod'")):
				$notificacion = "
					<script>
						notificacion('Actualización exitosa');
					</script>
				";
			else:
				$notificacion = "
					<script>
						" . getSQLError() . ";
						ventanaEmergente(formEdit, overlay);
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Todos los campos son requeridos');
					ventanaEmergente(formEdit, overlay);
				</script>
			";
		endif;
	endif;
?>