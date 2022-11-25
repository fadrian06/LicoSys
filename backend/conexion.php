<?php
	$CONFIG = (array) json_decode(file_get_contents('config.json'), true);

	/*========================================
	=            CONEXIÓN A MYSQL            =
	========================================*/
	$conexion = new MySQLi($CONFIG['DB_HOST'], $CONFIG['DB_USER'], $CONFIG['DB_PASSWORD']);
	$conexion->set_charset($CONFIG['DB_CHARSET']);
	$conexion->select_db($CONFIG['DB_NAME']);
	
	/*=======================================
	=            PETICIONES AJAX            =
	=======================================*/
	if (!empty($_GET['comprobarBD']))
		exit($conexion->select_db($CONFIG['DB_NAME']) ? 'true' : 'false');
	
	if (!empty($_POST = json_decode(file_get_contents('php://input'), true))):
		
		if (isset($_POST['restaurarBD'])):
			$sql = file_get_contents('init.sql');
			exit($conexion->multi_query($sql) ? 'true' : 'false');
		endif;
		
		exit;
	endif
?>