<?php
	@session_start();
	session_destroy();
	try {
		include '../php/conexion.php';
	} catch(Exception $e){
		$HOST    = 'localhost';
		$USUARIO = 'root';
		$CLAVE   = '';
		$BD      = 'licoreria';
		$CHARSET = 'utf8';

		$conexion = @new Mysqli($HOST, $USUARIO, $CLAVE);

		if ($conexion->connect_errno)
			exit("Error, no se pudo conectar a MySQL: <b>$conexion->error</b><br>");

		$conexion->set_charset($CHARSET)
			or exit("Error cargando el conjunto de caracteres <b>$CHARSET: <u>$conexion->error</u></b><br>");

		try {
			$conexion->select_db($BD);
		} catch (Exception $e) {
			$sql = file_get_contents('backup/inicializar.sql');
			$conexion->multi_query($sql) or exit($conexion->error);
		}
	}
	$conexion->query('TRUNCATE TABLE carrito_venta');
	$conexion->query('TRUNCATE TABLE carrito_compra');
	header('location: ../');
?>