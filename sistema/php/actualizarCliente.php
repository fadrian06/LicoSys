<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if (isset($_POST["actualizarCliente"])):
		$cedula = (int) ESCAPAR($_POST["cedula"]);
		$ci = (int) ESCAPAR($_POST["ci"]);
		$nombre = ESCAPAR(CAPITALIZE($_POST["nombre"]));
		if($cedula && $nombre):
			if(CONSULTA("SELECT * FROM cliente WHERE ci_c = $cedula")):
				$notificacion = "
					<script>
						notificacion('No se han hecho cambios');
					</script>
				";
			else:
				if(setRegistro("UPDATE cliente SET ci_c=$cedula, cliente='$nombre' WHERE ci_c=$ci")):
					$notificacion = "
						<script>
							notificacion('Actualización exitosa');
						</script>
					";
					$clientes = getRegistros("SELECT * FROM cliente ORDER BY ci_c");
				else:
					$notificacion = "
						<script>
							" . getSQLError() . ";
							alerta('Ha ocurrido un error, por favor intente nuevamente');
						</script>
					";
				endif;
			endif;
		else:
			$notificacion = "
				alerta('Por favor rellene los campos');
				botonRegistrarCliente.click();
			";
		endif;
	endif;
?>