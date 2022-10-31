<?php

	if (isset($_GET["restaurar"])):
		require "../../php/conexion.php";
		$archivo   = "../../backup/licosys.sql";
		$manejador = fopen($archivo, "r");
		$sql       = fread($manejador, filesize($archivo));
		echo (mysqli_multi_query($conexion, $sql)) ? "true" : "false";

	endif;
?>