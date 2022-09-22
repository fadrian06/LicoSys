<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["actualizarClave"])):
		$claveActual = $_POST["clave"];
		$nuevaClave  = $_POST["nuevaClave"];
		$confirmar   = $_POST["confirmar"];
		if($claveActual != $_POST["nuevaClave"]):
			if($nuevaClave == $confirmar):
				$nuevaClave = ENCRIPTAR($nuevaClave);
				if(setRegistro("UPDATE usuario SET clave = '$nuevaClave' WHERE ci_u = {$_SESSION["idUsuario"]}")):
					$_SESSION["clave"] = $confirmar;
					$notificacion = "
						<script>
							notificacion('Contraseña actualizada exitosamente');
						</script>
					";
				else:
					$notificacion = "
						<script>
							" . getSQLError() . ";
							botonActualizarClave.click();
						</script>
					";
				endif;
			else:
				$notificacion = "
					<script>
						alerta('Las contraseñas no coinciden');
						botonActualizarClave.click();
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('La nueva contraseña no puede ser igual a la anterior');
					botonActualizarClave.click();
				</script>
			";
		endif;
	endif;
?>