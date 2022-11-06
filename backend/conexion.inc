<?php

	/**
	 * Retorna la URL del servidor
	 * @param  string $ruta Ruta relativa al servidor `/licoreria/ruta`
	 * @return string       `ej. http://localhost`
	 */
	function getURL(string $ruta = ''):string {
		return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}$ruta";
	}
	
	require getURL('/licoreria/backend/includes/config.inc');

	$conexion = @new mysqli($HOST, $USUARIO, $CLAVE);

	if ($conexion->connect_errno)
		exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b><br>");

	$conexion->set_charset($CHARSET)
		or exit("Error cargando el conjunto de caracteres <b>" . $CHARSET . ": <u>$conexion->error</u></b><br>");
	
	if (!empty($_GET['comprobarBD'])):
		exit('false');
		exit($conexion->select_db($BD) ?: 'false');
	else:
		$conexion->select_db($BD);
	endif;
	
	if (!empty($_POST['crearBD'])):
		exit('true');
		$sql = file_get_contents('backup/inicializar.sql');
		exit($conexion->multi_query($sql) ?: 'false');
	endif;

?>