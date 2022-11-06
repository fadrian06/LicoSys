<?php

	if(isset($_POST['registrarNegocio'])):
		require 'conexion.inc';
		require 'includes/funciones.inc';
		
		$nombre     = capitalize($_POST['nombreNegocio']);
		$rif        = strtoupper($_POST['rif']);
		$telefono   = $_POST['telefono'];
		$direccion  = $_POST['direccion'];
		$nombreLogo = $_FILES['logo']['name'];
		
		$respuesta = ['ok' => false, 'mensaje' => ''];
		
		//////////////////
		// VALIDACIONES //
		//////////////////
		if(!$nombre or !$rif)
			$respuesta['mensaje'] = 'Los campos <b class="w3-text-red">NOMBRE y RIF</b> no pueden estar vacíos';
		elseif(!validar($NOMBRE_NEGOCIO['patron'], $nombre))
			$respuesta['mensaje'] = "<b class='w3-text-red'>NOMBRE</b> {$NOMBRE_NEGOCIO['descripcion']}";
		elseif(!validar($RIF['patron'], $rif))
			$respuesta['mensaje'] = "<b class='w3-text-red'>RIF</b> {$RIF['descripcion']}";
		elseif($telefono and !validar($TELEFONO['patron'], $telefono))
			$respuesta['mensaje'] = "<b class='w3-text-red'>TELEFONO no sigue el patrón</b> {$TELEFONO['descripcion']}";
		elseif($direccion and !validar($DIRECCION['patron'], $direccion))
			$respuesta['mensaje'] = "DIRECCION {$DIRECCION['descripcion']}";
		
		if($nombreLogo):
			$id = getUltimoNegocio() + 1;
			$tipo = $_FILES['logo']['type'];
			$size = $_FILES['logo']['size'];
			$tmpDir = $_FILES['logo']['tmp_name'];
			
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
			else move_uploaded_file($tmpDir, "../assets/images/negocios/$nombreLogo");
		endif;
		
		if($respuesta['mensaje'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = "INSERT INTO negocios VALUES(NULL, '$nombre', '$rif', '$telefono', '$direccion', '$nombreLogo', 1)";
		if(setRegistro($sql)):
			$respuesta['ok'] = true;
			$respuesta['mensaje'] = 'Negocio registrado exitósamente';
		else:
			$respuesta['mensaje'] = "Ha ocurrido un error, por favor intente nuevamente <b class='w3-block'>$conexion->error</b>";
		endif;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
	endif;

?>