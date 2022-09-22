<?php
	if(isset($_POST["actualizarClave"]) && isset($_SESSION["idUsuario"])):
		$nuevaClave = $_POST["nuevaClave"];
		$confirmar  = $_POST["confirmar"];
		if($nuevaClave && $confirmar):
			if($nuevaClave == $confirmar):
				$nuevaClave = ENCRIPTAR($nuevaClave);
				if(setRegistro("UPDATE usuario SET clave='$nuevaClave' WHERE ci_u={$_SESSION["idUsuario"]}")):
					$alerta = "
						<script>
							notificacion('Contraseña actualizada correctamente', false);
						</script>
					";
					session_destroy();
				else:
					$cambiarClave = true;
					$alerta = "
						<script>
							" . getSQLError() . ";
							alerta('Ha ocurrido un error, por favor intente nuevamente');
						</script>
					";
				endif;
			else:
				$cambiarClave = true;
				$alerta = "
					<script>
						alerta('Las contraseñas deben ser iguales');
					</script>
				";
			endif;
		else:
			$cambiarClave = true;
			$alerta = "
				<script>
					alerta('Por favor rellene los campos');
				</script>
			";
		endif;
	endif;
?>