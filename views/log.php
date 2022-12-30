<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/componentes.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		echo LOADER;
		echo '<div id="moduloLog">';
		$sql = <<<SQL
			SELECT fecha, nombre, usuario, telefono FROM log
			INNER JOIN usuarios ON usuario_id=id
			WHERE negocio_id={$_SESSION['negocioID']}
			GROUP BY usuario_id ORDER BY fecha DESC
		SQL;
		
		$encabezados = [
			'escritorio' => ['Fecha', 'Nombre', 'Usuario', 'Teléfono'],
			'movil' => ['Fecha', 'Usuario']
		];
		
		$datos = [
			'camposEscritorio' => ['fecha', 'nombre', 'usuario', 'telefono'],
			'camposMovil' => ['fecha', 'usuario'],
			'filas' => getRegistros($sql)
		];
		
		tabla('Registro de Sesiones', $encabezados, $datos, 'No hay registros de sesiones.');
		
		if ($datos['filas'])
			echo '<footer id="botones">' . BOTONES['VACIAR_LOG'] . '</footer>';
		echo '</div>';
	else:
		include '../templates/head.php';
		$script .= "<script src='{$BASE_URL}js/restringido.js'></script>";
		include '../templates/footer.php';
	endif;
?>