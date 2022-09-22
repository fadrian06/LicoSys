<?php
	if (isset($_POST["registrarUsuario"])):
		$cedula    = (int) $_POST["cedula"];
		$nombre    = ESCAPAR(CAPITALIZE($_POST["nombre"]));
		$usuario   = ESCAPAR($_POST["usuario"]);
		$clave     = ESCAPAR($_POST["nuevaClave"]);
		$confirmar = ESCAPAR($_POST["confirmar"]);
		$telefono  = ESCAPAR($_POST["telefono"]);
		if($cedula && $nombre && $usuario && $clave && $confirmar):
			if ($clave == $confirmar):
				if (CONSULTA("SELECT * FROM usuario WHERE usuario='$usuario' || ci_u=$cedula")):
					$alerta = "
						<script>
							alerta('Usuario ya existe');
							ventanaEmergente(formAdmin, overlay);
						</script>
					";
				else:
					$clave = ENCRIPTAR($clave);
					if (setRegistro("INSERT INTO usuario(ci_u, usuario, nom_u, clave, cargo, tlf, activo) VALUES($cedula, '$usuario', '$nombre', '$clave', 'a', '$telefono', 1)")):
						$alerta = registroExitoso();
					else:
						$alerta = "
							<script>
								" . getSQLError() . ";
								ventanaEmergente(formAdmin, overlay);
							</script>
						";
					endif;
				endif;
			else:
				$alerta = "
					<script>
						alerta('Las contraseñas no coinciden');
						ventanaEmergente(formAdmin, overlay);
					</script>
				";
			endif;
		else:
			$alerta = "
				<script>
					alerta('Por favor rellene los campos');
					ventanaEmergente(formAdmin, overlay);
				</script>
			";
		endif;
	endif;
?>