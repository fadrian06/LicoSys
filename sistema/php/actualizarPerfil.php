<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["actualizarPerfil"])):
		$nombre   = ESCAPAR(CAPITALIZE($_POST["nombre"]));
		$usuario  = ESCAPAR($_POST["usuario"]);
		$telefono = ESCAPAR($_POST["telefono"]);
		if($nombre && $usuario):
			if(setRegistro("UPDATE usuario SET nom_u='$nombre', usuario='$usuario', tlf='$telefono' WHERE ci_u={$_SESSION["idUsuario"]}")):
				$_SESSION["nombreUsuario"] = $nombre;
				$_SESSION["usuario"] = $usuario;
				$_SESSION["telefono"] = $telefono;
				$notificacion = "
					<script>
						notificacion('Actualización exitosa', false);
					</script>
				";
			else:
				$notificacion = "
					<script>
						notificacion('No se han hecho cambios');
						botonActualizarDatos.click();
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Por favor rellene los campos');
					botonActualizarDatos.click();
				</script>
			";
		endif;
	endif;
?>