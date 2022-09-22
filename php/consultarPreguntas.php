<?php
	if(isset($_POST["consultar"])):
		$cedula  = (int) ESCAPAR($_POST["cedula"]);
		$usuario = ESCAPAR($_POST["usuario"]);
		if($cedula && $usuario):
			$sql = "SELECT * FROM usuario WHERE BINARY(usuario)=BINARY('$usuario')";
			if(CONSULTA($sql)):
				$registro = getRegistro($sql);
				if($registro["ci_u"] == $cedula):
					$_SESSION["usuario"]   = $registro["usuario"];
					$_SESSION["idUsuario"] = (int) $registro["ci_u"];
					$mostrarPreguntas = true;
				else:
					$alerta = "
						<script>
							ventanaEmergente(formRecuperar, overlay);
							alerta('Cédula incorrecta');
						</script>
					";
				endif;
			else:
				$alerta = "
					<script>
						ventanaEmergente(formRecuperar, overlay);
						alerta('Usuario no existe<br><small class=\"w3-text-red\">Verifique mayúsculas y minúsculas</small>');
					</script>
				";
			endif;
		else:
			$alerta = "
				<script>
					ventanaEmergente(formRecuperar, overlay);
					alerta('Por favor rellene los campos');
				</script>
			";
		endif;
	endif;
?>