<?php
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$nuevoIVA = $_POST['iva'] < 1
			? (float) $_POST['iva']
			: (float) $_POST['iva'] / 100;
		
		$nuevoDolar = round($_POST['dolar'], 2);
		$nuevoPeso = (int) $_POST['pesos'];
		
		/*----------  VALIDACIONES  ----------*/
		if (!$nuevoIVA or !$nuevoDolar or !$nuevoPeso)
			$respuesta['error'] = 'Por favor rellene los campos.';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sqlIVA = "INSERT INTO iva(valor) VALUES('$nuevoIVA')";
		$sqlDolar = "INSERT INTO dolar(valor) VALUES('$nuevoDolar')";
		$sqlPeso = "INSERT INTO peso(valor) VALUES('$nuevoPeso')";
		
		if (!setRegistro($sqlIVA) or !setRegistro($sqlDolar) or !setRegistro($sqlPeso))
			$respuesta['error'] = json_encode($conexion->error_list, JSON_INVALID_UTF8_IGNORE);
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>