<?php
	require 'conexion.php';
	
	if (!empty($_GET['comprobarNegocio'])):
		$result = $conexion->query('SELECT * FROM negocios');
		exit($result->num_rows ? 'true' : 'false');
	endif;
?>