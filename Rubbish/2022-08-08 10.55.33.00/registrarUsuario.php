<?php
	// Evalua si el formulario se envió
	if (isset($_POST["registrar"])):
		require_once "../php/conexion.php";
		require_once "php/funciones.php";
		$cedula   = (int) $_POST["cedula"];
		$nombre   = ESCAPAR_STRING($_POST["nombre"]);
		$usuario  = ESCAPAR_STRING($_POST["usuario"]);
		$clave    = ESCAPAR_STRING($_POST["clave"]);
		$clave2   = ESCAPAR_STRING($_POST["clave2"]);
		$telefono = ESCAPAR_STRING($_POST["telefono"]);
		$cargo    = "v";

		// Caso 1: claves iguales pero no vacías
		if ($clave == $clave2 && $clave != "" && $clave2 != ""):
			// Antes de insertar se comprueba si ya existe el usuario o la cédula
			$consulta = "SELECT * FROM usuario WHERE usuario='$usuario' || ci_u=$cedula";
			$resultado = mysqli_query($conexion, $consulta);
			$filas = mysqli_num_rows($resultado);
			if ($filas > 0):
				echo "<div class='w3-panel w3-red w3-center'><p>Usuario ya existe</p></div>";
			else:
				// Encripta la clave
				$clave = ENCRIPTAR($clave);
				// Si no se encuentras filas SI hace el registro
				$insertar = "INSERT INTO usuario(ci_u, usuario, nom_u, clave, cargo, tlf) VALUES($cedula, '$usuario', '$nombre', '$clave', '$cargo', '$telefono')";
				$resultado = mysqli_query($conexion, $insertar);
				if (mysqli_affected_rows($conexion)>0):
					echo "<div class='w3-panel w3-green w3-center'><p>Registro Exitoso</p></div>";
				else:
					echo "<div class='w3-panel w3-red w3-center'><p>Error al registrar</p></div>";
				endif;
			endif;
		else:
			// Caso 2: claves diferentes y vacías
			if ($clave != $clave2 && $clave == "" || $clave2 == ""):
				echo "<div class='w3-panel w3-red w3-center'><p>Por favor rellene los campos</p></div>";
			else:	# Caso 3: claves diferentes pero no vacias
				echo "<div class='w3-panel w3-red w3-center'><p>Contraseñas no coinciden</p></div>";echo "<p class='existe'>Contraseñas no coinciden</p>";
			endif;
		endif;
		mysqli_close($conexion);
	endif;
?>