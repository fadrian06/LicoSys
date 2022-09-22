<?php
	// Evalua si el formulario se envió
	if (isset($_POST["registrar"])):
		require_once "../php/conexion.php";
		require_once "php/funciones.php";
		$nombre = ESCAPAR_STRING($_POST["nombre"]);
		$cedulaUsuario = (int) $_SESSION["idUsuario"];
		$negocio = (int) $_SESSION["negocio"];

		$consulta="SELECT * FROM proveedor WHERE proveedor='$nombre'";
		$resultado=mysqli_query($conexion, $consulta);
		if(mysqli_num_rows($resultado)>0):
			echo "<div class='w3-panel w3-red w3-center'><p>Proveedor ya existe</p></div>";
		else:
			$sql="INSERT INTO proveedor VALUES(NULL, '$nombre', $cedulaUsuario, $negocio)";
			$resultado=mysqli_query($conexion, $sql);
			echo (mysqli_affected_rows($conexion)>0)?"<div class='w3-panel w3-green w3-center'><p>Registro Exitoso</p></div>":"<div class='w3-panel w3-red w3-center'><p>Error al Registrar</p></div>";
		endif;
	endif;
?>