<?php

	if(!empty($_POST)):
		require '../php/conexion.php';
		require '../php/funciones.php';
		
		$nombre     = CAPITALIZE($_POST['nombreNegocio']);
		$rif        = strtoupper($_POST['rif']);
		$telefono   = $_POST['telefono'];
		$direccion  = $_POST['direccion'];
		$nombreLogo = $_FILES['foto']['name'];
		
		//////////////////
		// VALIDACIONES //
		//////////////////
		$respuesta = ['ok' => false, 'mensaje' => ''];
		
		if(!$nombre or !$rif)
			$respuesta['mensaje'] = 'Los campos <b class="w3-text-red">NOMBRE y RIF</b> no pueden estar vacíos';
		elseif(!VALIDAR($NOMBRE_NEGOCIO['patron'], $nombre))
			$respuesta['mensaje'] = '<b class="w3-text-red">NOMBRE</b> ' . $NOMBRE_NEGOCIO['descripcion'];
		elseif(!VALIDAR($RIF['patron'], $rif))
			$respuesta['mensaje'] = '<b class="w3-text-red">RIF</b> ' . $RIF['descripcion'];
		elseif($telefono and !VALIDAR($TELEFONO['patron'], $telefono))
			$respuesta['mensaje'] = '<b class="w3-text-red">TELEFONO no sigue el patrón</b> ' . $TELEFONO['descripcion'];
		elseif($direccion and !VALIDAR($DIRECCION['patron'], $direccion))
			$respuesta['mensaje'] = 'DIRECCION ' . $DIRECCION['descripcion'];
		
		if($nombreLogo):
			$id = getUltimoNegocio() + 1;
			$tipo = $_FILES['foto']['type'];
			$size = $_FILES['foto']['size'];
			
			switch($tipo):
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/png':
					$nombreLogo = "$id.jpeg";
			endswitch;
			
			if(!strpos($nombreLogo, '.jpeg'))
				$respuesta['mensaje'] = 'Sólo se permiten imagenes <b class="w3-text-red">jpg y png</b>';
			elseif($size > (1 * 1000 * 2048))
				$respuesta['mensaje'] = 'La imagen no puede ser mayor a <b class="w3-text-red">2MB</b>';
			else
				move_uploaded_file($_FILES['foto']['tmp_name'], "../imagenes/negocios/$nombreLogo");
		endif;
		
		if($respuesta['mensaje'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = "INSERT INTO negocio VALUES(NULL, '$nombre', '$rif', '$telefono', '$direccion', '$nombreLogo', 1)";
		if(setRegistro($sql)):
			$respuesta['ok'] = true;
			$respuesta['mensaje'] = 'Negocio registrado exitósamente';
		else:
			$respuesta['mensaje'] = getSQLError();
		endif;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
	endif;

?>