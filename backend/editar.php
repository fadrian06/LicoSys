<?php
	session_start();
	require 'config.php';
	require 'componentes.php';
	require 'conexion.php';
	require 'funciones.php';
	
	if (!empty($_POST['editar'])):
		$tabla = escapar($_POST['tabla']);
		$copiaTabla = escapar($_POST['tabla']);
		$campo = escapar($_POST['campo']);
		$valor = (int) $_POST['valor'];
		
		if ($copiaTabla === 'usuarios:informacion'
			|| $copiaTabla === 'usuarios:clave'
			|| $copiaTabla === 'usuarios:preguntasRespuestas'
		) $copiaTabla = 'usuarios';
		
		$registro = getRegistro("SELECT * FROM $copiaTabla WHERE $campo=$valor");
		
		if (!$registro) $respuesta['error'] = $conexion->error;
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		switch ($tabla):
			case 'clientes':
				$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputNombre = generarINPUT('NOMBRE', $label, "{$registro['nombre']}");
				
				$inputID = generarINPUT('ID', '', '', "{$registro['id']}");
				$respuesta['ok'] = <<<HTML
					<div class="w3-right-align">
						<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
					</div>
					<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
						Editar Cliente
					</h1>
					<section class="w3-display-container">
						<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
						$inputID
						$inputNombre
					</section>
					<section class="w3-panel">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Actualizar
						</button>
					</section>
				HTML;
				break;
			case 'proveedores':
				$label = '<b>RIF: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputRIF = generarINPUT('RIF', $label, "{$registro['rif']}");
				
				$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputNombre = generarINPUT('NOMBRE_NEGOCIO', $label, "{$registro['nombre']}");
				
				$inputID = generarINPUT('ID', '', '', "{$registro['id']}");
				$respuesta['ok'] = <<<HTML
					<div class="w3-right-align">
						<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
					</div>
					<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
						Editar Proveedor
					</h1>
					<section class="w3-display-container">
						<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
						$inputID
						$inputRIF
						$inputNombre
					</section>
					<section class="w3-panel">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Actualizar
						</button>
					</section>
				HTML;
				break;
			case 'usuarios:informacion':
				$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputNombre = generarINPUT('NOMBRE', $label, "{$registro['nombre']}");
				
				$label = '<b>Usuario: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputUsuario = generarINPUT('USUARIO', $label, "{$registro['usuario']}");
				
				$registro['telefono'] = $registro['telefono'] ?: 'No especificado';
				$label = '<b>Teléfono: </b><sup class="w3-text-blue">(opcional)</sup>';
				$inputTelefono = generarINPUT('TELEFONO', $label, "{$registro['telefono']}");
				
				$inputID = generarINPUT('ID', '', '', "{$registro['id']}");
				$respuesta['ok'] = <<<HTML
					<div class="w3-right-align">
						<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
					</div>
					<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
						Actualizar Información
					</h1>
					<section class="w3-display-container">
						<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
						$inputID
						$inputNombre
						$inputUsuario
						$inputTelefono
					</section>
					<section class="w3-panel">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Actualizar
						</button>
					</section>
				HTML;
				break;
			case 'usuarios:clave':
				$inputClave = generarINPUT('CLAVE', 'Nueva Contraseña:', '********');
				$inputConfirmar = generarINPUT('CONFIRMAR', 'Confirmar Contraseña:', '********');
				$inputID = generarINPUT('ID', '', '', "{$_SESSION['userID']}");
				$respuesta['ok'] = <<<HTML
					<div class="w3-right-align">
						<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
					</div>
					<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
						Cambiar Contraseña
					</h1>
					<section class="w3-display-container">
						<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
						$inputID
						$inputClave
						$inputConfirmar
					</section>
					<section class="w3-panel">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Cambiar
						</button>
					</section>
				HTML;
				break;
			case 'usuarios:preguntasRespuestas':
				$registro['pre1'] = $registro['pre1'] ?: 'No definida';
				$registro['pre2'] = $registro['pre2'] ?: 'No definida';
				$registro['pre3'] = $registro['pre3'] ?: 'No definida';
				$inputPRE1 = generarINPUT('pre1', 'Pregunta 1:', "{$registro['pre1']}");
				$inputPRE2 = generarINPUT('pre2', 'Pregunta 2:', "{$registro['pre2']}");
				$inputPRE3 = generarINPUT('pre3', 'Pregunta 3:', "{$registro['pre3']}");
				
				$label = '<b>Respuesta 1:</b> <sup respuesta="res1" class="w3-text-blue"></sup>';
				$inputRES1 = generarINPUT('res1', $label, '********');
				
				$label = '<b>Respuesta 2:</b> <sup respuesta="res2" class="w3-text-blue"></sup>';
				$inputRES2 = generarINPUT('res2', $label, '********');
				
				$label = '<b>Respuesta 3:</b> <sup respuesta="res3" class="w3-text-blue"></sup>';
				$inputRES3 = generarINPUT('res3', $label, '********');
				
				$inputID = generarINPUT('ID', '', '', "{$registro['id']}");
				$respuesta['ok'] = <<<HTML
					<div class="w3-right-align">
						<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
					</div>
					<h2 class="w3-center w3-xlarge oswald w3-margin-bottom">
						Edite sus Preguntas y Respuestas
					</h2>
					<div class="w3-row w3-display-container w3-topbar">
						<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
						$inputID
						<section class="w3-padding-top-24 w3-half w3-rightbar">
							$inputPRE1
							$inputPRE2
							$inputPRE3
						</section>
						<section class="w3-padding-top-24 w3-half w3-leftbar">
							$inputRES1
							$inputRES2
							$inputRES3
						</section>
					</div>
					<div class="w3-margin-top w3-center">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block" style="width: 50%; margin: auto">
							Actualizar
						</button>
					</div>
					<br>
				HTML;
				break;
		endswitch;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	if (!empty($_POST['id'])):
		$id = (int) $_POST['id'];
		$tabla = escapar($_POST['tabla']);
		$copiaTabla = escapar($_POST['tabla']);
		
		if ($copiaTabla === 'usuarios:informacion'
			|| $copiaTabla === 'usuarios:clave'
			|| $copiaTabla === 'usuarios:preguntasRespuestas'
		) $copiaTabla = 'usuarios';
		
		unset($_POST['id']);
		unset($_POST['tabla']);
		
		$camposActualizados = '';
		foreach ($_POST as $clave => $valor):
			if ($clave === 'nombreNegocio') $clave = 'nombre';
			if ($clave === 'clave' || $clave === 'res1' || $clave === 'res2' || $clave === 'res3')
				$valor = encriptar($valor);
			if ($clave === 'confirmar') continue;			
			
			/*----------  ENTRECOMILLAMOS LOS CAMPOS NO NUMÉRICOS  ----------*/
			if ($clave === 'id' or $clave === 'cedula')
				$camposActualizados .= "$clave=$valor,";
			else $camposActualizados .= "$clave='$valor',";
		endforeach;
		$camposActualizados[strlen($camposActualizados) - 1] = ' ';
		
		$sql = "UPDATE $copiaTabla SET $camposActualizados WHERE id=$id";
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		switch ($copiaTabla):
			case 'clientes':
				$respuesta['ok'] = 'Cliente actualizado exitósamente.';
				break;
			case 'proveedores':
				$respuesta['ok'] = 'Proveedor actualizado exitósamente.';
				break;
			case 'usuarios':
				$respuesta['ok'] = 'Información actualizada exitósamente.';
				break;
		endswitch;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>