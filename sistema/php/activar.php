<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["activar"])):
		$id = (int) $_POST["llavePrimaria"];
		setRegistro("UPDATE {$_SESSION["tabla"]} SET activo = 1 WHERE {$_SESSION["llavePrimaria"]} = $id");
		$notificacion = "
			<script>
				notificacion('" . CAPITALIZE($_SESSION['tabla']) . " activado correctamente', false);
			</script>
		";
	endif;
?>