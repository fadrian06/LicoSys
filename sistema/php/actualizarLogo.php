<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["actualizarFoto"])):
		$idNegocio = (int) $_POST["idNegocio"];
		$foto = $_FILES["foto"];
		$peso = $foto["size"];
		$tipo = $foto["type"];
		$temporal = $foto["tmp_name"];
		switch($tipo):
			case "image/jpeg":
			case "image/jpg":
			case "image/png":
				$tipo = "image/jpeg";
				$imagen = "$idNegocio.jpeg";
				break;
		endswitch;
		if($tipo == "image/jpeg"):
			if($peso < 1*1000*2048 /*2MB*/):
				setRegistro("UPDATE negocio SET foto='$imagen' WHERE id_n=$idNegocio");
				move_uploaded_file($temporal, "../dist/images/negocios/$imagen");
				$notificacion = "
					<script>
						notificacion('Foto actualizada exitosamente');
						w3.getElement('#foto$idNegocio').src = '../dist/images/negocios/$imagen';
					</script>
				";
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
		$negocios = getRegistros("SELECT * FROM negocio");
	endif;
?>