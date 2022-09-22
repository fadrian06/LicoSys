<?php
	if(isset($_POST["actualizarFoto"])):
		$foto = $_FILES["foto"];
		$tipo = $foto["type"];
		$peso = $foto["size"];
		$dirTemporal = $foto["tmp_name"];
		switch($tipo){
			case "image/jpeg":
			case "image/jpg":
			case "image/png":
				$imagen = "{$_SESSION['idUsuario']}.jpeg";
				break;
		}
		if($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png"):
			if($peso < 1*1000*2048 /*2MB*/):
				setRegistro("UPDATE usuario SET foto='$imagen' WHERE usuario='{$_SESSION["usuario"]}'");
				move_uploaded_file($dirTemporal, "../imagenes/perfil/$imagen");
				$notificacion = "
					<script>
						notificacion('Foto actualizada exitosamente');
						document.querySelector('#fotoPerfil').src = '../imagenes/perfil/$imagen';
						document.querySelector('#img-result').src = '../imagenes/perfil/$imagen';
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
					alerta('Sólo se permiten imagenes (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)');
				</script>
			";
		endif;
	endif;
?>