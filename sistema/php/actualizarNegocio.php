<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["actualizarNegocio"])):
		$id = (int) $_POST["idNegocio"];
		$nombre = ESCAPAR(CAPITALIZE($_POST["nombreNegocio"]));
		$rif    = ESCAPAR(strtoupper($_POST["rif"]));
		$telefono  = ESCAPAR($_POST["telefono"]);
		$direccion = ESCAPAR(CAPITALIZE($_POST["direccion"]));
		if($nombre && $rif):
			if(setRegistro("UPDATE negocio SET nom_n='$nombre', rif='$rif', tlf_n='$telefono', direccion_n='$direccion' WHERE id_n=$id")):
				if($id == $_SESSION["idNegocio"]):
					$_SESSION["idNegocio"] = $id;
					$_SESSION["nombreNegocio"] = $_POST["nombreNegocio"];
				endif;
				$notificacion = "
					<script>
						notificacion('Actualización exitosa', false);
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
					alerta('Por favor rellene los campos \"Nombre\" y \"RIF\"');
					w3.getElement('#botonActualizarNegocio$id').click();
				</script>
			";
		endif;
		$negocios = getRegistros("SELECT * FROM negocio");
	endif;
?>