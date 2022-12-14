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

	$conexion = @new mysqli($HOST, $USUARIO_BD, $CLAVE_BD);

	if ($conexion->connect_errno)
		exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b><br>");

	$conexion->set_charset($CHARSET)
		or exit("Error cargando el conjunto de caracteres <b>" . $CHARSET . ": <u>$conexion->error</u></b><br>");
	
	if (isset($_GET['comprobarBD']))
		exit($conexion->select_db($BD) ?: 'false');
	else
		$conexion->select_db($BD);
	
	if (isset($_POST['crearBD'])):
		$sql = file_get_contents('backup/inicializar.sql');
		exit($conexion->multi_query($sql) ?: 'false');
	endif;

?>