<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if (isset($_POST["registrarUsuario"])):
		$cedula    = (int) ESCAPAR($_POST["cedula"]);
		$nombre    = ESCAPAR(CAPITALIZE($_POST["nombre"]));
		$usuario   = ESCAPAR($_POST["usuario"]);
		$clave     = ESCAPAR($_POST["nuevaClave"]);
		$confirmar = ESCAPAR($_POST["confirmar"]);
		$telefono  = ESCAPAR($_POST["telefono"]);
		if ($cedula && $nombre && $usuario && $clave && $confirmar):
			if($clave == $confirmar):
				if (CONSULTA("SELECT * FROM usuario WHERE usuario='$usuario' || ci_u=$cedula")):
					$notificacion = "
						<script>
							alerta('Usuario ya existe');
							botonRegistrarUsuario.click();
						</script>
					";
				else:
					$clave = ENCRIPTAR($clave);
					if (setRegistro("INSERT INTO usuario(ci_u, usuario, nom_u, clave, cargo, tlf, activo) VALUES($cedula, '$usuario', '$nombre', '$clave', 'v', '$telefono', 1)")):
						$notificacion = registroExitoso();
					else:
						$notificacion = "
							<script>
								" . getSQLError() . ";
								botonRegistrarUsuario.click();
							</script>
						";
					endif;
				endif;
			else:
				$notificacion = "
					<script>
						alerta('Las contraseñas no coinciden');
						botonRegistrarUsuario.click();
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Por favor rellene los campos');
					botonRegistrarUsuario.click();
				</script>
			";
		endif;
	endif;
?>