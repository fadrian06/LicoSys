<?php
	if (!empty($_POST)):
		require 'conexion.php';
		require 'funciones.php';
		
		$mensaje = [
			'error' => '',
			'datos' => []
		];
		
		$nuevoIVA = $_POST['iva'] < 1
			? (float) $_POST['iva']
			: (float) $_POST['iva'] / 100;
		
		$nuevoDolar = round($_POST['dolar'], 2);
		$nuevoPeso = (int) $_POST['pesos'];
		
		/*----------  VALIDACIONES  ----------*/
		if (!$nuevoIVA or !$nuevoDolar or !$nuevoPeso)
			$mensaje['error'] = 'Por favor rellene los campos.';
		
		if ($mensaje['error'])
			exit(json_encode($mensaje, JSON_INVALID_UTF8_IGNORE));
		
		$sqlIVA = "INSERT INTO iva(valor) VALUES('$nuevoIVA')";
		$sqlDolar = "INSERT INTO dolar(valor) VALUES('$nuevoDolar')";
		$sqlPeso = "INSERT INTO peso(valor) VALUES('$nuevoPeso')";
		
		if (!setRegistro($sqlIVA) or !setRegistro($sqlDolar) or !setRegistro($sqlPeso))
			$mensaje['error'] = json_encode($conexion->error_list, JSON_INVALID_UTF8_IGNORE);
		
		exit(json_encode($mensaje, JSON_INVALID_UTF8_IGNORE));
	endif;
?>