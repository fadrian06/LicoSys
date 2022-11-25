<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["registrar"])):
		$nombre    = ESCAPAR(CAPITALIZE($_POST["nombreNegocio"]));
		$rif       = ESCAPAR(strtoupper($_POST["rif"]));
		$telefono  = ESCAPAR($_POST["telefono"]);
		$direccion = ESCAPAR(CAPITALIZE($_POST["direccion"]));
		$foto      = $_FILES["foto"]["name"] ? $_FILES["foto"] : "";
		$imagen    = "";
		if($nombre && $rif):
			if($foto):
				$id = getUltimoNegocio() + 1;
				$tipo = $foto["type"];
				$peso = $foto["size"];
				$temporal = $foto["tmp_name"];
				switch($tipo):
					case "image/jpeg":
					case "image/jpg":
					case "image/png":
						$tipo = "image/jpeg";
						$imagen = "$id.jpeg";
						break;
				endswitch;
				if($tipo == "image/jpeg"):
					if($peso < 1*1000*2048 /*2MB*/):
						move_uploaded_file($temporal, "../dist/images/negocios/$imagen");
					else:
						$notificacion = "
							<script>
								alerta('La imagen no puede ser mayor a <b class=\"w3-text-red\" title=\"2 Megabytes\">2MB</b);
							</script>
						";
						exit;
					endif;
				else:
					$notificacion = "
						<script>
							alerta('Sólo se permiten dist/images (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)')
						</script>
					";
					exit;
				endif;
			endif;
			$filas = CONSULTA("SELECT * FROM negocio WHERE nom_n='$nombre' OR rif='$rif'");
			if(!$filas):
				setRegistro("INSERT INTO negocio(nom_n, rif, tlf_n, direccion_n, foto, activo) VALUES('$nombre', '$rif', '$telefono', '$direccion', '$imagen', 1)");
				$notificacion = "
					<script>
						notificacion('Registro existoso', false);
					</script>
				";
			else:
				$notificacion = "
					<script>
						alerta('Negocio ya existe')
						ventanaEmergente(w3.getElement('#formularioRegistrarNegocio'), overlay);
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Por favor rellene los campos');
					ventanaEmergente(w3.getElement('#formularioRegistrarNegocio'), overlay);
				</script>
			";
		endif;
		$negocios = getRegistros("SELECT * FROM negocio");
	endif;
?>