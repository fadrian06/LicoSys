<?php
	session_start();
	if (!isset($_SESSION['activa']))
		header('location: ../salir.php');

	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		echo LOADER;
		$sql = "SELECT ci, nom, usuario, tlf FROM usuarios WHERE cargo<>'a' AND activo=1";
		$usuarios = getRegistros($sql);
		$sql = "SELECT ci, nom, usuario, tlf FROM usuarios WHERE cargo<>'a' AND activo=0";
		$desactivados = getRegistros($sql);
		$encabezados = ['C.I', 'Nombre', 'Usuario', 'Teléfono'];
		echo '<h2 class="w3-center w3-bottombar w3-border-blue w3-round-medium">Usuarios</h2>';
		// tabla($usuarios ?: [], $encabezados, true, 'usuario', 'id', $desactivados);
		echo '<footer id="botones">' . BOTONES['REGISTRAR_USUARIO'] . '</footer>';
	else:
		include "../templates/head.php";
		$script = "<script src='{$BASE_URL}js/restringido.js'></script>";
		include "../templates/footer.php";
	endif;
?>