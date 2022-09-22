<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["actualizarPreguntas"])):
		$pregunta1  = ESCAPAR($_POST["pregunta1"]);
		$pregunta2  = ESCAPAR($_POST["pregunta2"]);
		$pregunta3  = ESCAPAR($_POST["pregunta3"]);
		$respuesta1 = ENCRIPTAR(ESCAPAR($_POST["respuesta1"]));
		$respuesta2 = ENCRIPTAR(ESCAPAR($_POST["respuesta2"]));
		$respuesta3 = ENCRIPTAR(ESCAPAR($_POST["respuesta3"]));
		if(!empty($pregunta1) && !empty($pregunta2) && !empty($pregunta3) && !empty($respuesta1) && !empty($respuesta2) && !empty($respuesta3)):
			if(setRegistro("UPDATE usuario SET pre1='$pregunta1', r1='$respuesta1', pre2='$pregunta2', r2='$respuesta2', pre3='$pregunta3', r3='$respuesta3' WHERE ci_u={$_SESSION["idUsuario"]}")):
				$_SESSION["pregunta1"]  = $pregunta1;
				$_SESSION["pregunta2"]  = $pregunta2;
				$_SESSION["pregunta3"]  = $pregunta3;
				$_SESSION["respuesta1"] = $_POST["respuesta1"];
				$_SESSION["respuesta2"] = $_POST["respuesta2"];
				$_SESSION["respuesta3"] = $_POST["respuesta3"];
				$notificacion = "
					<script>
						notificacion('Preguntas y respuestas actualizadas', false);
					</script>
				";
			else:
				$notificacion = "
					<script>
						notificacion('No se han hecho cambios');
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Por favor rellene los campos');
					botonActualizarPreguntas.click();
				</script>
			";
		endif;
	endif;
?>