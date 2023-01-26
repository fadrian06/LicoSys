<?php
	if (!empty($_POST)):
		session_start();
		require 'conexion.php';
		require 'funciones.php';
		
		$codigo = escapar(strtoupper($_POST['codigo']));
		$producto = escapar(capitalize($_POST['nombre']));
		$precio = (float) $_POST['precio'];
		$excento = (int) $_POST['excento'];
		$stock = (int) $_POST['stock'];
		
		/*----------  VALIDACIONES  ----------*/
		if (!$codigo or !$producto or !$precio)
			$respuesta['error'] = 'El código, nombre, precio y excento son requeridos.';
		elseif ($excento < 0 or $excento > 1)
			$respuesta['error'] = 'Excento sólo puede ser SI o NO.';
		
		$productoEncontrado = getRegistro("SELECT codigo FROM inventario WHERE codigo='$codigo'");
		if ($productoEncontrado)
			$respuesta['error'] = 'Ya existe un producto con ese código.';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = <<<SQL
			INSERT INTO inventario(codigo, producto, stock, excento, precio, negocio_id, usuario_id)
			VALUES('$codigo', '$producto', $stock, $excento, $precio, {$_SESSION['negocioID']}, {$_SESSION['userID']})
		SQL;
		
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = 'Producto registrado exitósamente.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>