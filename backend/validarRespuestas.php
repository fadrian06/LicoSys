<?php
	if(isset($_POST["enviarRespuestas"])):
		$respuesta1 = ESCAPAR($_POST["respuesta1"]);
		$respuesta2 = ESCAPAR($_POST["respuesta2"]);
		$respuesta3 = ESCAPAR($_POST["respuesta3"]);
		if($respuesta1 && $respuesta2 && $respuesta3):
			$registro = getRegistro("SELECT * FROM usuario WHERE ci_u={$_SESSION["idUsuario"]}");
			if(password_verify($respuesta1, $registro["r1"]) && password_verify($respuesta2, $registro["r2"]) && password_verify($respuesta3, $registro["r3"])):
				$cambiarClave = true;
			else:
				$mostrarPreguntas = true;
				$alerta = "
					<script>
						alerta('Respuestas incorrectas<br><small class=\"w3-text-red\">Verifique mayúsculas y minúsculas</small>');
					</script>
				";
			endif;
		else:
			$mostrarPreguntas = true;
			$registro = getRegistro("SELECT * FROM usuario WHERE ci_u={$_SESSION["idUsuario"]}");
			$alerta = "
				<script>
					alerta('Por favor rellene los campos');
				</script>
			";
		endif;
	endif;
?>