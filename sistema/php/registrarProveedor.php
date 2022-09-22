<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if (isset($_POST["registrarProveedor"])):
		$nombre = ESCAPAR(CAPITALIZE($_POST["nombreProveedor"]));
		if(CONSULTA("SELECT * FROM proveedor WHERE proveedor='$nombre'")):
			$notificacion = "
				<script>
					alerta('Proveedor ya existe');
					botonRegistrarProveedor.click();
				</script>
			";
		elseif(setRegistro("INSERT INTO proveedor VALUES(NULL, '$nombre', {$_SESSION["idUsuario"]}, {$_SESSION["idNegocio"]})")):
			$notificacion = registroExitoso();
		else:
			$notificacion = "
				<script>
					" . getSQLError() . ";
					botonRegistrarProveedor.click();
				</script>
			";
		endif;
	endif;
?>