<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if (isset($_POST["actualizarProveedor"])):
		$id = (int) $_POST["id"];
		$nombre = ESCAPAR(CAPITALIZE($_POST["nombreProveedor"]));
		if(CONSULTA("SELECT * FROM proveedor WHERE proveedor='$nombre'")):
			$notificacion = "
				<script>
					alerta('No se han hecho cambios');
				</script>
			";
		elseif(setRegistro("UPDATE proveedor SET proveedor='$nombre' WHERE id_p=$id")):
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
	endif;
?>