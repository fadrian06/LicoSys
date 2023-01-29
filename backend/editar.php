<?php
	session_start();
	require 'config.php';
	require 'componentes.php';
	require 'conexion.php';
	require 'funciones.php';
	
	/*====================================================
	=            ENVIAR FORMULARIO DE EDICIÓN            =
	====================================================*/
	if (!empty($_POST['editar'])):
		$tabla      = escapar($_POST['tabla']);
		$campo      = escapar($_POST['campo']);
		$valor      = (int) $_POST['valor'];
		
		$copiaTabla = $tabla;
		if ($copiaTabla === 'usuarios:informacion'
			|| $copiaTabla === 'usuarios:clave'
			|| $copiaTabla === 'usuarios:preguntasRespuestas'
		) $copiaTabla = 'usuarios';
		
		$registro = getRegistro("SELECT * FROM $copiaTabla WHERE $campo=$valor");
		
		if (!$registro) $respuesta['error'] = $conexion->error;
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$inputID = generarINPUT('ID', '', '', "{$registro['id']}");
		switch ($tabla):
			case 'clientes':
				$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputNombre = generarINPUT('NOMBRE', $label, '', "{$registro['nombre']}");
				
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
				$label = '<b>Cédula: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputCedula = generarINPUT('CEDULA', $label, '', "{$registro['cedula']}");
				
				$label = '<b>Nombre: </b><sup class="w3-text-red">(requirido)</sup>';
				$inputNombre = generarINPUT('NOMBRE', $label, '', "{$registro['nombre']}");
				
				$label = '<b>RIF: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputRIF = generarINPUT('RIF', $label, '', "{$registro['rif']}");
				
				$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputNombreEmpresa = generarINPUT('NOMBRE_NEGOCIO', $label, '', "{$registro['nombreEmpresa']}");
				
				$label = '<b>Teléfono: </b><sup class="w3-text-blue">(opcional)</sup>';
				$inputTelefono = generarINPUT('TELEFONO', $label, "{$registro['telefono']}");
				
				$label = '<b>Dirección: </b><sup class="w3-text-blue">(opcional)</sup>';
				$inputDireccion = generarINPUT('DIRECCION', $label, "{$registro['direccion']}");
								
				$respuesta['ok'] = <<<HTML
					<div class="w3-right-align">
						<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
					</div>
					<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
						Editar Proveedor
					</h1>
					<section class="w3-display-container w3-row-padding">
						<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
						$inputID
						<div class="w3-half w3-bottombar w3-topbar">
							<h2 class="w3-container w3-large"><b>Datos de persona de contacto</b></h2>
							$inputCedula
							$inputNombre
						</div>
						<div class="w3-half w3-bottombar w3-topbar">
							<h2 class="w3-container w3-large"><b>Datos del proveedor</b></h2>
							$inputRIF
							$inputNombreEmpresa
							$inputTelefono
							$inputDireccion
						</div>
					</section>
					<section class="w3-panel" style="width: 50%; margin-left: auto; margin-right: auto">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Actualizar
						</button>
					</section>
				HTML;
				break;
			case 'inventario':
				$label = '<b>Código: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputCodigo = generarINPUT('CODIGO', $label, '', "{$registro['codigo']}");
				$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputNombre = generarINPUT('NOMBRE', $label, '', "{$registro['producto']}");
				$label = '<b>Precio: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputPrecio = generarINPUT('PRECIO', $label, '', "{$registro['precio']}");
				$label = '<b>Excento: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputExcento = generarINPUT('EXCENTO', $label, '¿Excento de IVA?');
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
						$inputCodigo
						$inputNombre
						$inputPrecio
						$inputExcento
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
				$inputNombre = generarINPUT('NOMBRE', $label, '', "{$registro['nombre']}");
				
				$label = '<b>Usuario: </b><sup class="w3-text-red">(requerido)</sup>';
				$inputUsuario = generarINPUT('USUARIO', $label, '', "{$registro['usuario']}");
				
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
				$inputPRE1 = generarINPUT('pre1', 'Pregunta 1:', '', "{$registro['pre1']}");
				$inputPRE2 = generarINPUT('pre2', 'Pregunta 2:', '', "{$registro['pre2']}");
				$inputPRE3 = generarINPUT('pre3', 'Pregunta 3:', '', "{$registro['pre3']}");
				
				$label = '<b>Respuesta 1:</b> <sup respuesta="res1" class="w3-text-blue"></sup>';
				$inputRES1 = generarINPUT('res1', $label, '********');
				
				$label = '<b>Respuesta 2:</b> <sup respuesta="res2" class="w3-text-blue"></sup>';
				$inputRES2 = generarINPUT('res2', $label, '********');
				
				$label = '<b>Respuesta 3:</b> <sup respuesta="res3" class="w3-text-blue"></sup>';
				$inputRES3 = generarINPUT('res3', $label, '********');
				
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
			case 'negocios':
				$registro['tlf'] = $registro['tlf'] ?: 'No establecido';
				$registro['direccion'] = $registro['direccion'] ?: 'No establecido';
			
				$label = '<b>Nombre:</b> <sup class="w3-text-red">(requerido)</sup>';
				$inputNombre = generarINPUT('NOMBRE_NEGOCIO', $label, '', "{$registro['nombre']}");
				
				$label = '<b>RIF:</b> <sup class="w3-text-red">(requerido)</sup>';
				$inputRIF = generarINPUT('RIF', $label, '', "{$registro['rif']}");
				
				$label = '<b>Teléfono:</b> <sup class="w3-text-blue">(opcional)</sup>';
				$inputTelefono = generarINPUT('TELEFONO', $label, "{$registro['tlf']}");
				
				$label = '<b>Dirección:</b> <sup class="w3-text-blue">(opcional)</sup>';
				$inputDireccion = generarINPUT('DIRECCION', $label, "{$registro['direccion']}");
				$respuesta['ok'] = <<<HTML
					<div class="w3-right-align">
						<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
					</div>
					<h2 class="w3-center w3-xlarge oswald w3-margin-bottom">
						Actualizar Información
					</h2>
					<section class="w3-padding-top-24 w3-display-container">
						<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
						$inputID
						$inputNombre
						$inputRIF
						$inputTelefono
						$inputDireccion
					</section>
					<section class="w3-panel">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Actualizar
						</button>
					</section>
				HTML;
		endswitch;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	/*======================================================
	=            ACTUALIZAR LOS DATOS RECIBIDOS            =
	======================================================*/
	if (!empty($_POST['id'])):
		/** @var int ID del registro a actualizar */
		$id = (int) $_POST['id'];
		/** @var string Tabla de la cual proviene el registro, incluye variantes */
		$tabla = escapar($_POST['tabla']);
		/** @var string Copia de la tabla que será escapada para la sentencia SQL */
		$copiaTabla = $tabla;
		
		if ($copiaTabla === 'usuarios:informacion'
			|| $copiaTabla === 'usuarios:clave'
			|| $copiaTabla === 'usuarios:preguntasRespuestas'
		) $copiaTabla = 'usuarios';
		
		/*----------  Quita el ID y la tabla del array POST  ----------*/
		unset($_POST['id']);
		unset($_POST['tabla']);
		
		/** @var string Lista de `campo=valor` o `campo='valor'` */
		$camposActualizados = '';
		
		/*----------  Itera sobre cada clave en POST  ----------*/
		foreach ($_POST as $clave => $valor):
			if ($copiaTabla === 'proveedores' && $clave === 'nombreNegocio')
				$clave = 'nombreEmpresa';
			
			if ($copiaTabla !== 'proveedores' && $clave === 'nombreNegocio')
				$clave = 'nombre';
			
			if ($clave === 'clave' || $clave === 'res1' || $clave === 'res2' || $clave === 'res3')
				$valor = encriptar($valor);
			
			if ($clave === 'confirmar'):
				if ($_POST['clave'] !== $_POST['confirmar'])
					$respuesta['error'] = 'Ambas claves deben ser iguales.';
				continue;
			endif;
			
			if ($copiaTabla === 'negocios' && $clave === 'telefono') $clave = 'tlf';
			if ($copiaTabla === 'inventario' && $clave === 'nombre') $clave = 'producto';
			
			/*----------  ENTRECOMILLAMOS LOS CAMPOS NO NUMÉRICOS  ----------*/
			if ($clave === 'id'
				or $clave === 'cedula'
				or $clave === 'stock'
				or $clave === 'precio'
			) $camposActualizados .= "$clave=$valor,";
			else $camposActualizados .= "$clave='$valor',";
		endforeach;
		// Quitamos la última ,
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
			case 'negocios':
				$respuesta['ok'] = 'Información actualizada exitósamente.';
				break;
			case 'inventario':
				$respuesta['ok'] = 'Producto actualizado exitósamente.';
				break;
		endswitch;
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>