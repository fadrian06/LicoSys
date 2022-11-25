<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["actualizarFoto"])):
		$foto = $_FILES["foto"];
		$tipo = $foto["type"];
		$peso = $foto["size"];
		$temporal = $foto["tmp_name"];
		switch($tipo):
			case "image/jpeg":
			case "image/jpg":
			case "image/png":
				$tipo = "image/jpeg";
				$imagen = "{$_SESSION['idUsuario']}.jpeg";
				break;
		endswitch;
		if($tipo == "image/jpeg"):
			if($peso < 1*1000*2048 /*2MB*/):
				setRegistro("UPDATE usuario SET foto='$imagen' WHERE usuario='{$_SESSION["usuario"]}'");
				move_uploaded_file($temporal, "../dist/images/perfil/$imagen");
				$notificacion = "
					<script>
						notificacion('Foto actualizada exitosamente');
					</script>
				";
				$_SESSION["foto"] = $imagen;
			else:
				$notificacion = "
					<script>
						alerta('La imagen no puede ser mayor a <b class=\"w3-text-red\" title=\"2 Megabytes\">2MB</b>');
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Sólo se permiten dist/images (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)');
				</script>
			";
		endif;
	endif;
?>