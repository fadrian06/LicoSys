<?php

	if(isset($_POST['registrarAdmin'])):
		require 'conexion.inc';
		require 'includes/funciones.inc';
		
		$cedula    = (int) $_POST['cedula'];
		$nombre    = capitalize($_POST['nombre']);
		$usuario   = $_POST['usuario'];
		$clave     = $_POST['nuevaClave'];
		$confirmar = $_POST['confirmar'];
		$telefono  = $_POST['telefono'];
		$nombreFoto = $_FILES['foto']['name'];
		
		$respuesta = ['ok' => false, 'mensaje' => ''];
		
		//////////////////
		// VALIDACIONES //
		//////////////////
		if(!$cedula or !$nombre or !$usuario or !$clave or !$confirmar)
			$respuesta['mensaje'] = 'Los campos <b class="w3-text-red">CÉDULA, NOMBRE, USUARIO y CLAVE</b> no pueden estar vacíos';
		elseif(!validar($CEDULA['patron'], $cedula))
			$respuesta['mensaje'] = $CEDULA['descripcion'];
		elseif(!validar($NOMBRE['patron'], $nombre))
			$respuesta['mensaje'] = $NOMBRE['descripcion'];
		elseif(!validar($USUARIO['patron'], $usuario))
			$respuesta['mensaje'] = $USUARIO['descripcion'];
		elseif(!validar($CLAVE['patron'], $clave))
			$respuesta['mensaje'] = $CLAVE['descripcion'];
		elseif($clave !== $confirmar)
			$respuesta['mensaje'] = 'Las contraseñas no coinciden';
		elseif($telefono and !validar($TELEFONO['patron'], $telefono))
			$respuesta['mensaje'] = $TELEFONO['descripcion'];
		
		if($nombreFoto):
			$tipo = $_FILES['foto']['type'];
			$size = $_FILES['foto']['size'];
			$tmpDir = $_FILES['foto']['tmp_name'];
			
			switch($tipo):
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/png':
					$nombreFoto = "$cedula.jpeg";
			endswitch;
			
			if(!strpos($nombreFoto, '.jpeg'))
				$respuesta['mensaje'] = 'Sólo se permiten imagenes <b class="w3-text-red">jpg y png</b>';
			elseif($size > (1 * 1000 * 2048))
				$respuesta['mensaje'] = 'La imagen no puede ser mayor a <b class="w3-text-red">2MB</b>';
			else move_uploaded_file($tmpDir, "../assets/images/perfil/$nombreFoto");
		endif;
		
		if($respuesta['mensaje'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$clave = encriptar($clave);
		$sql = "INSERT INTO usuarios(cedula, nombre, usuario, clave, cargo, telefono, foto, activo) VALUES($cedula, '$nombre', '$usuario', '$clave', 'a', '$telefono', '$nombreFoto', 1)";
		if(setRegistro($sql)):
			$respuesta['ok'] = true;
			$respuesta['mensaje'] = 'Usuario registrado exitósamente';
		else:
			$respuesta['mensaje'] = "Ha ocurrido un error, por favor intente nuevamente <b class='w3-block'>$conexion->error</b>";
		endif;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
	endif;

?>