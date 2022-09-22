<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if (isset($_POST["registrarCliente"])):
		$cedula = (int) ESCAPAR($_POST["cedula"]);
		$nombre = ESCAPAR(CAPITALIZE($_POST["nombre"]));
		if($cedula && $nombre):
			if(CONSULTA("SELECT * FROM cliente WHERE ci_c = $cedula")):
				$notificacion = "
					<script>
						alerta('Cliente ya existe');
						botonRegistrarCliente.click();
					</script>
				";
			elseif(setRegistro("INSERT INTO cliente VALUES($cedula, '$nombre', {$_SESSION["idUsuario"]})")):
				$notificacion = registroExitoso();
				$clientes = getRegistros("SELECT * FROM cliente ORDER BY ci_c");
			else:
				$notificacion = "
					<script>
						" . getSQLError() . ";
						botonRegistrarCliente.click();
					</script>
				";
			endif;
		else:
			$notificacion = "
				alerta('Por favor rellene los campos');
				botonRegistrarCliente.click();
			";
		endif;
	endif;
?>