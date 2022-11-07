<?php
	
	if (isset($_POST['restaurar'])):
		require 'conexion.inc';
		$sql = file_get_contents('../backup/licosys.sql');
		exit($conexion->multi_query($sql) or $conexion->error);
	endif;
	
?>