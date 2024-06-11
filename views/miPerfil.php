<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	require '../backend/config.php';
	require '../backend/componentes.php';
	require '../backend/conexion.php';
	require '../backend/funciones.php';
	
	$usuario = getRegistro("SELECT * FROM usuarios WHERE id={$_SESSION['userID']}");
	
	echo LOADER;
	echo '<div id="moduloPerfil" class="w3-row w3-padding-top-24">';
	
	/*=====================================
	=            BARRA LATERAL            =
	=====================================*/
	echo <<<HTML
		<div class="w3-col s3 m2 w3-padding-top-64 w3-ul w3-center">
			<ul class="w3-ul w3-card w3-white w3-tiny w3-center">
				<li role="botonPanel" onclick="mostrarPanel(this, '#panelSobreMi')" class="w3-button w3-block w3-rightbar w3-blue">
					<i class="icon-user w3-large"></i>
					<div>SOBRE MI</div>
				</li>
				<li role="botonPanel" onclick="mostrarPanel(this, '#panelSeguridad')" class="w3-button w3-block w3-rightbar">
					<i class="icon-key w3-large"></i>
					<div>SEGURIDAD</div>
				</li>
			</ul>
		</div>
	HTML;
	
	/*=======================================
	=            PANEL PRINCIPAL            =
	=======================================*/
	$cargo = $usuario['cargo'] === 'a' ? 'Administrador' : 'Vendedor';
	$usuario['telefono'] = $usuario['telefono'] ?: '<b class="w3-text-red">No especificado</b>';
	$usuario['foto'] = $usuario['foto']
		? "assets/images/perfil/{$usuario['foto']}"
		: 'assets/images/avatar3.png';
	$hayPreguntasRegistradas = 'w3-blue';
	$textoBotonHayPreguntasRegistradas = 'Cambiar';
	if (!$usuario['pre1'] or !$usuario['pre2'] or !$usuario['pre3']):
		$hayPreguntasRegistradas = 'w3-red';
		$textoBotonHayPreguntasRegistradas = 'Crear';
	endif;
	
	$usuario['pre1'] = $usuario['pre1'] ?: 'No definida';
	$usuario['pre2'] = $usuario['pre2'] ?: 'No definida';
	$usuario['pre3'] = $usuario['pre3'] ?: 'No definida';
	
	echo <<<HTML
		<!------------  SOBRE MI  ------------>
		<div id="panelSobreMi" role="panel" class="w3-col s9 m6 w3-margin-top w3-container w3-card w3-white w3-show w3-animate-opacity">
			<h2 class="w3-large w3-padding w3-border-bottom">
				<span class="w3-text-blue">Sobre </span>
				mí
			</h2>
			<ul class="w3-ul w3-small">
				<li>
					<span class="w3-tag w3-blue w3-left">Cédula:</span>
					<b class="w3-right">{$usuario['cedula']}</b>
					<div class="w3-clear"></div>
				</li>
				<li>
					<span class="w3-tag w3-blue w3-left">Nombre:</span>
					<b id="nombreUsuario" class="w3-right">{$usuario['nombre']}</b>
					<div class="w3-clear"></div>
				</li>
				<li>
					<span class="w3-tag w3-blue w3-left">Usuario:</span>
					<b class="w3-right">@{$usuario['usuario']}</b>
					<div class="w3-clear"></div>
				</li>
				<li>
					<span class="w3-tag w3-blue w3-left">Cargo:</span>
					<b class="w3-right">$cargo</b>
					<div class="w3-clear"></div>
				</li>
				<li>
					<span class="w3-tag w3-blue w3-left">Teléfono:</span>
					<b class="w3-right">{$usuario['telefono']}</b>
					<div class="w3-clear"></div>
				</li>
			</ul>
			<div class="w3-center w3-padding-large">
				<button onclick="editar(this, 'usuarios:informacion', 'cedula', {$usuario['cedula']}, 'views/miPerfil.php')" data-target="#editarUsuario" class="w3-show-inline-block w3-button w3-blue w3-round-large">
					Actualizar Datos
				</button>
			</div>
		</div>
		
		<!------------  SEGURIDAD  ------------>
		<div id="panelSeguridad" role="panel" class="w3-col s9 m6 w3-margin-top w3-container w3-card w3-white w3-hide w3-animate-opacity">
			<h2 class="w3-large w3-padding w3-border-bottom w3-text-blue">Seguridad</h2>
			<div class="w3-row">
				<ul class="w3-ul w3-small w3-half w3-bottombar">
					<h3 class="w3-center w3-medium w3-container w3-border-bottom">
						Contraseña
					</h3>
					<li><b>********</b></li>
					<div class="w3-center w3-padding-large">
						<button onclick="editar(this, 'usuarios:clave', 'cedula', {$usuario['cedula']}, 'views/miPerfil.php')" data-target="#cambiarClave" class="w3-show-inline-block w3-button w3-blue w3-round-large">
							Cambiar
						</button>
					</div>
				</ul>
				<ul class="w3-ul w3-small w3-half w3-bottombar w3-leftbar">
					<h3 class="w3-center w3-medium w3-container w3-border-bottom">
						Preguntas y Respuestas
					</h3>
					<li>
						<span class="w3-tag $hayPreguntasRegistradas">{$usuario['pre1']}:</span>
						<b class="w3-margin-top w3-block">********</b>
					</li>
					<li>
						<span class="w3-tag $hayPreguntasRegistradas">{$usuario['pre2']}:</span>
						<b class="w3-margin-top w3-block">********</b>
					</li>
					<li>
						<span class="w3-tag $hayPreguntasRegistradas">{$usuario['pre2']}:</span>
						<b class="w3-margin-top w3-block">********</b>
					</li>
					<div class="w3-center w3-padding-large">
						<button onclick="editar(this, 'usuarios:preguntasRespuestas', 'cedula', {$usuario['cedula']}, 'views/miPerfil.php')" data-target="#editarPreguntasRespuestas" class="w3-show-inline-block w3-button w3-blue w3-round-large">
							$textoBotonHayPreguntasRegistradas
						</button>
					</div>
				</ul>
			</div>
		</div>
		
		<!------------  FOTO DE PERFIL  ------------>
		<div class="w3-col s12 m4 w3-center">
			<div class="w3-margin-top w3-leftbar">
				<form enctype="multipart/form-data" class="w3-padding-large w3-center w3-white w3-card">
					<h3 class="w3-large">Actualizar Foto</h3>
					<p class="w3-small w3-text-blue">Pulsa en la imagen para actualizar</p>
					<label for="foto" class="w3-display-container w3-hover-opacity w3-circle">
						<i class="icon-camera w3-xxxlarge w3-display-middle w3-display-hover"></i>
						<input type="file" id="foto" accept="image/jpeg,image/png" name="foto" class="w3-hide">
						<img class="image-result w3-image" src="{$usuario['foto']}" style="width: 150px">
					</label>
					<div class="w3-center">
						<button class="w3-button w3-blue w3-round-large w3-section w3-animate-right w3-hide">
							Actualizar
						</button>
					</div>
					<div class="w3-padding">
						<span class="w3-medium w3-white w3-block">{$usuario['nombre']}</span>
						<span class="w3-small w3-white w3-block w3-text-blue">@{$usuario['usuario']}</span>
					</div>
				</form>
			</div>
		</div>
	HTML;	
	
	/*==============================================
	=            ACTUALIZAR INFORMACIÓN            =
	==============================================*/
	echo <<<HTML
		<form id="editarUsuario" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide"></form>
	HTML;

	/*========================================
	=            ACTUALIZAR CLAVE            =
	========================================*/
	echo <<<HTML
		<form id="cambiarClave" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide"></form>
	HTML;
	
	/*=========================================================
	=            ACTUALIZAR PREGUNTAS Y RESPUESTAS            =
	=========================================================*/
	echo <<<HTML
		<form id="editarPreguntasRespuestas" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide"></form>
	HTML;
	
	echo '</div>';
?>
