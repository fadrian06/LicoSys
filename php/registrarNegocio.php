<?php
	if(isset($_POST["registrarNegocio"])):
		$nombre    = ESCAPAR(CAPITALIZE($_POST["nombreNegocio"]));
		$rif       = ESCAPAR(strtoupper($_POST["rif"]));
		$telefono  = ESCAPAR($_POST["telefono"]);
		$direccion = ESCAPAR($_POST["direccion"]);
		$foto      = !empty($_FILES["foto"]) ? $_FILES["foto"] : "";
		$imagen    = "";
		if($nombre && $rif):
			if($foto):
				$id   = getUltimoNegocio() + 1;
				$tipo = $foto["type"];
				$peso = $foto["size"];
				switch($tipo):
					case "image/jpeg":
					case "image/jpg":
					case "image/png":
						$imagen = "$id.jpeg";
				endswitch;
				if($tipo == "image/jpeg"):
					if($peso < 1 * 1024 * 2048 /*2MB*/):
						move_uploaded_file($foto["tmp_name"], "dist/images/negocios/$imagen");
					else:
						$alerta = "
							<script>
								alerta('La imagen no puede ser mayor a <b class=\"w3-text-red\" title=\"2 Megabytes\">2MB</b>');
								ventanaEmergente(formNegocio, overlay);
							</script>
						";
					endif;
				else:
					$alerta = "
						<script>
							alerta('Sólo se permiten dist/images (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)');
							ventanaEmergente(formNegocio, overlay);
						</script>
					";
				endif;
			endif;
			if(setRegistro("INSERT INTO negocio VALUES(NULL, '$nombre', '$rif', '$telefono', '$direccion', '$imagen', 1)")):
				$alerta = registroExitoso();
			else:
				$alerta = "
					<script>
						" . getSQLError() . ";
						ventanaEmergente(formNegocio, overlay);
					</script>
				";
			endif;
		else:
			$alerta = "
				<script>
					alerta('Por favor rellene los campos');
					ventanaEmergente(formNegocio, overlay);
				</script>
			";
		endif;
	endif;
?>