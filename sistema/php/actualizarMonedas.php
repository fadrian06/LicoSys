<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["actualizarMonedas"])):
		$nuevoIVA = $_POST["iva"] < 1 ? (float) $_POST["iva"] : (float) $_POST["iva"] / 100;
		$nuevoDolar = round($_POST["dolar"], 2);
		$nuevoPeso = (int) $_POST["peso"];
		if($nuevoIVA && $nuevoDolar && $nuevoPeso):
			$sqlIVA   = "INSERT INTO iva(iva) VALUES($nuevoIVA)";
			$sqlDolar = "INSERT INTO dolar(dolar) VALUES('$nuevoDolar')";
			$sqlPeso  = "INSERT INTO peso(peso) VALUES('$nuevoPeso')";
			if(setRegistro($sqlIVA) && setRegistro($sqlDolar) && setRegistro($sqlPeso)):
				$notificacion = "
					<script>
						notificacion('Actualización exitosa');
					</script>
				";
				$iva = $nuevoIVA;
			else:
				$notificacion = "
					<script>
						" . getSQLError() . ";
						notificacion('No se han hecho cambios');
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					alerta('Por favor rellene los campos');
					ventanaEmergente(w3.getElement('#formMonedas'), overlay);
				</script>
			";
		endif;
	endif;
?>