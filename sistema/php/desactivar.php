<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(isset($_POST["desactivar"])):
		$id = (int) $_POST["llavePrimaria"];
		setRegistro("UPDATE {$_SESSION["tabla"]} SET activo = 0 WHERE {$_SESSION["llavePrimaria"]} = $id");
		$notificacion = "
			<script>
				notificacion('" . CAPITALIZE($_SESSION['tabla']) . " desactivado correctamente', false);
			</script>
		";
	endif;
?>