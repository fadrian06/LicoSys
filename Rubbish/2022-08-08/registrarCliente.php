<?php
	// Evalua si el formulario se envió
	if (isset($_POST["registrar"])):
		require_once "../php/conexion.php";
		require_once "php/funciones.php";
		$cedula = (int) $_POST["cedula"];
		$nombre = ESCAPAR_STRING($_POST["nombre"]);
		$cedulaUsuario = (int) $_SESSION["idUsuario"];

		$consulta="SELECT * FROM cliente WHERE ci_c='$cedula'";
		$resultado=mysqli_query($conexion, $consulta);
		if(mysqli_num_rows($resultado)>0):
			echo "<div class='w3-panel w3-red w3-center'><p>Cliente ya existe</p></div>";
		else:
			$sql="INSERT INTO cliente VALUES($cedula, '$nombre', $cedulaUsuario)";
			$resultado=mysqli_query($conexion, $sql);
			echo (mysqli_affected_rows($conexion)>0)?"<div class='w3-panel w3-green w3-center'><p>Registro Exitoso</p></div>":"<div class='w3-panel w3-red w3-center'><p>Error al Registrar</p></div>";
		endif;
	endif;
?>