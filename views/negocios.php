<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/componentes.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		echo LOADER;
		echo '<div id="moduloNegocios" class="w3-row" style="max-height: 71vh; overflow: auto">';
		
		$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
		$desactivados = getRegistros('SELECT * FROM negocios WHERE activo=0');
		
		/*----------  ACTIVADOS  ----------*/
		$botones = '';
		$paneles = '';
		foreach ($negocios as $negocio):
			$activo = $negocio['id'] === $_SESSION['negocioID']
				? 'w3-blue'
				: '';
			$botones .= <<<HTML
				<li role="botonPanel" onclick="mostrarPanel(this, '#panelNegocio{$negocio['id']}')" class="w3-button w3-block w3-rightbar $activo">
					<i class="icon-building w3-large"></i>
					<div>{$negocio['nombre']}</div>
				</li>
			HTML;
			
			$activo = $negocio['id'] === $_SESSION['negocioID']
				? 'w3-show'
				: 'w3-hide';
			$botonActualizarActivo = $negocio['id'] === $_SESSION['negocioID']
				? 'w3-hide'
				: 'w3-show-inline-block';
			$negocio['logo'] = $negocio['logo']
				? "assets/images/negocios/{$negocio['logo']}"
				: 'assets/images/logoNegocio.jpg';
			$negocio['tlf'] = $negocio['tlf'] ?: '<b class="w3-text-red">No establecido</b>';
			$negocio['direccion'] = $negocio['direccion'] ?: '<b class="w3-text-red">No establecido</b>';
			$permitirDesactivar = $negocio['id'] === $_SESSION['negocioID']
				? 'w3-hide'
				: 'w3-show-inline-block';
			$idNegocioActivo = $negocio['id'] === $_SESSION['negocioID']
				? 'id="nombreNegocioActivo"'
				: '';
			$paneles .= <<<HTML
				<div id="panelNegocio{$negocio['id']}" role="panel" class="w3-rest $activo w3-animate-opacity">
					<div class="w3-row">
						<!------------  INFORMACIÓN  ------------>
						<div class="w3-twothird m6 w3-margin-top w3-container w3-white w3-card">
							<h2 class="w3-large w3-padding w3-border-bottom w3-text-blue">Información</h2>
							<ul class="w3-ul w3-small">
								<li>
									<span class="w3-tag w3-blue w3-left">Identificador:</span>
									<b class="w3-right">{$negocio['id']}</b>
									<div class="w3-clear"></div>
								</li>
								<li>
									<span class="w3-tag w3-blue w3-left">Nombre:</span>
									<b $idNegocioActivo class="w3-right">{$negocio['nombre']}</b>
									<div class="w3-clear"></div>
								</li>
								<li>
									<span class="w3-tag w3-blue w3-left">RIF:</span>
									<b class="w3-right">{$negocio['rif']}</b>
									<div class="w3-clear"></div>
								</li>
								<li>
									<span class="w3-tag w3-blue w3-left">Teléfono:</span>
									<b class="w3-right">{$negocio['tlf']}</b>
									<div class="w3-clear"></div>
								</li>
								<li>
									<span class="w3-tag w3-blue w3-left">Dirección:</span>
									<b class="w3-right">{$negocio['direccion']}</b>
									<div class="w3-clear"></div>
								</li>
							</ul>
							<div class="w3-center w3-padding-large">
								<button onclick="editar(this, 'negocios', 'id', {$negocio['id']}, 'views/negocios.php')" data-target="#editarNegocio" class="w3-show-inline-block w3-button w3-blue w3-round-large">
									Actualizar Datos
								</button>
								<button onclick="desactivar('negocios', 'id', {$negocio['id']}, 'views/negocios.php')" class="$permitirDesactivar w3-button w3-red w3-round-large">
									Desactivar
								</button>
							</div>
						</div>
						<!------------  LOGO  ------------>
						<div class="w3-third w3-center">
							<div class="w3-margin-top w3-leftbar">
								<form enctype="multipart/form-data" class="w3-padding-large w3-center w3-white w3-card">
									<h3 class="w3-large">Actualizar Logo</h3>
									<p class="w3-small w3-text-blue">Pulsa en la imagen para actualizar</p>
									<label for="logo{$negocio['id']}" class="w3-display-container w3-hover-opacity w3-circle">
										<i class="icon-camera w3-xxxlarge w3-display-middle w3-display-hover"></i>
										<input type="hidden" name="id" value="{$negocio['id']}" class="w3-hide">
										<input type="file" id="logo{$negocio['id']}" accept="image/jpeg,image/png" name="logo" class="w3-hide">
										<img class="image-result w3-image" src="{$negocio['logo']}" style="width: 150px">
									</label>
									<div class="w3-center">
										<button class="w3-button w3-blue w3-round-large w3-section w3-animate-right w3-hide">
											Actualizar
										</button>
									</div>
									<div class="w3-padding">
										<span class="w3-medium w3-white w3-block">{$negocio['nombre']}</span>
										<span class="w3-small w3-white w3-block w3-text-blue">{$negocio['rif']}</span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			HTML;
		endforeach;
		
		/*----------  DESACTIVADOS  ----------*/
		$mostrarDesactivados = '';
		$botonesDesactivados = '';
		$panelesDesactivados = '';
		if ($desactivados):
			foreach ($desactivados as $negocio):
				$botonesDesactivados .= <<<HTML
					<li role="botonPanel" onclick="mostrarPanel(this, '#panelNegocio{$negocio['id']}')" class="w3-button w3-block w3-rightbar w3-red">
						<i class="icon-building w3-large"></i>
						<div>{$negocio['nombre']}</div>
					</li>
				HTML;
				$negocio['logo'] = $negocio['logo']
					? "assets/images/negocios/{$negocio['logo']}"
					: 'assets/images/logoNegocio.jpg';
				$negocio['tlf'] = $negocio['tlf'] ?: '<b class="w3-text-red">No establecido</b>';
				$negocio['direccion'] = $negocio['direccion'] ?: '<b class="w3-text-red">No establecido</b>';
				$panelesDesactivados .= <<<HTML
					<div id="panelNegocio{$negocio['id']}" role="panel" class="w3-rest w3-hide w3-animate-opacity">
						<div class="w3-row">
							<!------------  INFORMACIÓN  ------------>
							<div class="w3-twothird m6 w3-margin-top w3-container w3-white w3-card">
								<h2 class="w3-large w3-padding w3-border-bottom w3-text-blue">Información</h2>
								<ul class="w3-ul w3-small">
									<li>
										<span class="w3-tag w3-blue w3-left">Identificador:</span>
										<b class="w3-right">{$negocio['id']}</b>
										<div class="w3-clear"></div>
									</li>
									<li>
										<span class="w3-tag w3-blue w3-left">Nombre:</span>
										<b class="w3-right">{$negocio['nombre']}</b>
										<div class="w3-clear"></div>
									</li>
									<li>
										<span class="w3-tag w3-blue w3-left">RIF:</span>
										<b class="w3-right">{$negocio['rif']}</b>
										<div class="w3-clear"></div>
									</li>
									<li>
										<span class="w3-tag w3-blue w3-left">Teléfono:</span>
										<b class="w3-right">{$negocio['tlf']}</b>
										<div class="w3-clear"></div>
									</li>
									<li>
										<span class="w3-tag w3-blue w3-left">Dirección:</span>
										<b class="w3-right">{$negocio['direccion']}</b>
										<div class="w3-clear"></div>
									</li>
								</ul>
								<div class="w3-center w3-padding-large">
									<button onclick="editar(this, 'negocios', 'id', {$negocio['id']}, 'views/negocios.php')" data-target="#editarNegocio" class="w3-show-inline-block w3-button w3-blue w3-round-large">
										Actualizar Datos
									</button>
									<button onclick="activar('negocios', 'id', {$negocio['id']}, 'views/negocios.php')" class="w3-button w3-green w3-round-large">
										Activar
									</button>
								</div>
							</div>
							<!------------  LOGO  ------------>
							<div class="w3-third w3-center">
								<div class="w3-margin-top w3-leftbar">
									<form enctype="multipart/form-data" class="w3-padding-large w3-center w3-white w3-card">
										<h3 class="w3-large">Actualizar Logo</h3>
										<p class="w3-small w3-text-blue">Pulsa en la imagen para actualizar</p>
										<label for="logo{$negocio['id']}" class="w3-display-container w3-hover-opacity w3-circle">
											<i class="icon-camera w3-xxxlarge w3-display-middle w3-display-hover"></i>
											<input type="hidden" name="id" value="{$negocio['id']}" class="w3-hide">
											<input type="file" id="logo{$negocio['id']}" accept="image/jpeg,image/png" name="logo" class="w3-hide">
											<img class="image-result w3-image" src="{$negocio['logo']}" style="width: 150px">
										</label>
										<div class="w3-center">
											<button class="w3-button w3-blue w3-round-large w3-section w3-animate-right w3-hide">
												Actualizar
											</button>
										</div>
										<div class="w3-padding">
											<span class="w3-medium w3-white w3-block">{$negocio['nombre']}</span>
											<span class="w3-small w3-white w3-block w3-text-blue">{$negocio['rif']}</span>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				HTML;
			endforeach;
			$cantidadDesactivados = count($desactivados);
			$mostrarDesactivados = <<<HTML
				<details class="w3-margin-top">
					<summary class="w3-padding w3-small">
						<i class="icon-lock"> Desactivados</i>
						<span class="w3-badge" style="padding-top: 3px; padding-bottom: 3px">
							$cantidadDesactivados
						</span>
						<i class="icon-chevron-right w3-margin-left"></i>
					</summary>
					<div>
						<ul class="w3-ul w3-card w3-white w3-tiny w3-center">$botonesDesactivados</ul>
					</div>
				</details>
			HTML;
		endif;
		
		/*=====================================
		=            BARRA LATERAL            =
		=====================================*/
		$botonRegistrar = BOTONES['REGISTRAR_NEGOCIO'];
		echo <<<HTML
			<div class="w3-col s4 m3 w3-padding-top-64 w3-ul w3-center">
				<ul class="w3-ul w3-card w3-white w3-tiny w3-center">$botones</ul>
				$mostrarDesactivados
				<div class="w3-margin w3-padding-top-24">$botonRegistrar</div>
			</div>
		HTML;
		
		/*=======================================
		=            PANEL PRINCIPAL            =
		=======================================*/
		echo $paneles;
		if ($desactivados) echo $panelesDesactivados;
		
		/*=========================================
		=            REGISTRAR NEGOCIO            =
		=========================================*/
		$label = '<b>Nombre:</b> <sup class="w3-text-red">(requerido)</sup>';
		$inputNombre = generarINPUT('NOMBRE_NEGOCIO', $label, 'Nombre del negocio');
		
		$label = '<b>RIF:</b> <sup class="w3-text-red">(requerido)</sup>';
		$inputRIF = generarINPUT('RIF', $label, 'RIF del negocio');
		
		$label = '<b>Teléfono:</b> <sup class="w3-text-blue">(opcional)</sup>';
		$inputTelefono = generarINPUT('TELEFONO', $label, 'Teléfono de contacto');
		
		$label = '<b>Dirección:</b> <sup class="w3-text-blue">(opcional)</sup>';
		$inputDireccion = generarINPUT('DIRECCION', $label, 'Dirección del negocio');
		echo <<<HTML
			<form id="registrarNegocio" autocomplete="off" class="w3-row modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
				<div class="w3-right-align">
					<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
				</div>
				<h2 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Registro de Negocio
				</h2>
				<section class="w3-padding-top-24 w3-twothird w3-rightbar w3-topbar w3-bottombar w3-display-container">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					$inputNombre
					$inputRIF
					$inputTelefono
					$inputDireccion
					<div class="w3-panel">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Registrar
						</button>
					</div>
				</section>
				<section class="w3-third w3-topbar w3-bottombar w3-center">
					<label for="logoRegistrar" class="w3-display-container w3-hover-opacity" style="cursor: pointer">
						<i class="icon-camera w3-xxxlarge w3-display-middle w3-display-hover"></i>
						<input type="file" id="logoRegistrar" accept="image/jpeg,image/png" name="logo" class="w3-hide">
						<img class="image-result w3-image" src="assets/images/logoNegocio.jpg" style="width: 150px">
					</label>
					<div class="w3-container w3-margin-top w3-center">
						<label for="logo" class="w3-button w3-round-xlarge w3-blue w3-ripple">
							<i class="icon-upload"></i> Subir logo
						</label>
					</div>
					<b class="w3-white w3-block w3-margin-top w3-margin-bottom">
						Logotipo del negocio
					</b>
					<b class="w3-margin-bottom w3-white w3-block w3-text-blue">Opcional</b>
				</section>
			</form>
		HTML;
		
		/*======================================
		=            EDITAR NEGOCIO            =
		======================================*/
		echo <<<HTML
			<form id="editarNegocio" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide"></form>
		HTML;
		
		/*==========================================
		=            BOTONES INFERIORES            =
		==========================================*/
		echo '
			<footer id="botones" class="w3-grey w3-padding-small" style="width: 100vw; bottom: 0">
				<button class="w3-button w3-disabled w3-opacity-min w3-hover-gray w3-margin-bottom">
					<i class="icon-chevron-right w3-xxlarge"></i>
					&nbsp;Base de Datos
				</button>
		',
		BOTONES['RESPALDAR'],
		BOTONES['RESTAURAR'],
		'</footer>';
		echo '</div>';
	else:
		include '../templates/head.php';
		$script .= "<script src='{$BASE_URL}assets/js/restringido.js'></script>";
		include '../templates/footer.php';
	endif;
