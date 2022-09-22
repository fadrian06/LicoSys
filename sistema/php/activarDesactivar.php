<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["desactivarNegocio"]) || isset($_POST["activarNegocio"])):
		$idNegocio = (int) $_POST["idNegocio"];
		if(isset($_POST["desactivarNegocio"])):
			if(setRegistro("UPDATE negocio SET activo=0 WHERE id_n=$idNegocio")):
				$notificacion = "
					<script>
						notificacion('Negocio desactivado correctamente', false);
					</script>
				";
			else:
				$notificacion = "
					<script>
						" . getSQLError() . ";
					</script>
				";
			endif;
		elseif(isset($_POST["activarNegocio"])):
			if(setRegistro("UPDATE negocio SET activo=1 WHERE id_n=$idNegocio")):
				$notificacion = "
					<script>
						notificacion('Negocio activado correctamente', false);
					</script>
				";
			else:
				$notificacion = "
					<script>
						" . getSQLError() . ";
					</script>
				";
			endif;
		endif;
		$negocios = getRegistros("SELECT * FROM negocio");
	endif;
?>