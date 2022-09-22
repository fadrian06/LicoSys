<?php
	// Evalua si el formulario se envió
	if (isset($_POST["registrar"])):
		require_once "../php/conexion.php";
		require_once "php/funciones.php";
		$codigo = ESCAPAR_STRING($_POST["codigo"]);
		$nombre = ESCAPAR_STRING($_POST["nombre"]);
		$stock = (int) $_POST["stock"];
		$precio = round($_POST["precio_b"], 2);
		$excento = ESCAPAR_STRING($_POST["excento"]);
		$cedulaUsuario = (int) $_SESSION["idUsuario"];
		$negocio = (int) $_SESSION["negocio"];

		$consulta="SELECT * FROM inventario WHERE cod='$codigo' AND nom_p='$nombre' AND excento='$excento'";
		$resultado=mysqli_query($conexion, $consulta);
		if(mysqli_num_rows($resultado)>0):
			echo "<div class='w3-panel w3-red w3-center'><p>Artículo ya existe</p></div>";
		else:
			$sql="INSERT INTO inventario VALUES('$codigo', '$nombre', $stock, '$excento', $precio, $negocio, $cedulaUsuario)";
			$resultado=mysqli_query($conexion, $sql);
			echo (mysqli_affected_rows($conexion)>0)?"<div class='w3-panel w3-green w3-center'><p>Registro Exitoso</p></div>":"<div class='w3-panel w3-red w3-center'><p>Error al Registrar</p></div>";
		endif;
	endif;
?>