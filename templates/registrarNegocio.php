<?php
	if(!empty($mostrarRegistro)):
		$label = '<b>Nombre:</b> <sup class="w3-text-red">(requerido)</sup>';
		$inputNombre = generarINPUT('NOMBRE_NEGOCIO', $label, 'Nombre del negocio');
		
		$label = '<b>RIF:</b> <sup class="w3-text-red">(requerido)</sup>';
		$inputRIF = generarINPUT('RIF', $label, 'RIF del negocio');
		
		$label = '<b>Teléfono:</b> <sup class="w3-text-blue">(opcional)</sup>';
		$inputTelefono = generarINPUT('TELEFONO', $label, 'Teléfono de contacto');
		
		$label = '<b>Dirección:</b> <sup class="w3-text-blue">(opcional)</sup>';
		$inputDireccion = generarINPUT('DIRECCION', $label, 'Dirección del negocio');
		echo <<<HTML
			<form id="registrarNegocio" autocomplete="off" class="w3-row modal w3-white w3-card w3-round-large w3-animate-zoom">
				<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Registro de Negocio
				</h1>
				<div class="step-container">
					<div class="step"><span class="w3-blue">1</span></div>
					<div class="step"><span>2</span></div>
					<div class="step"><span>3</span></div>
				</div>
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
					<label for="logo" class="w3-display-container w3-hover-opacity" style="cursor: pointer">
						<i class="icon-camera w3-xxxlarge w3-display-middle w3-display-hover"></i>
						<input type="file" id="logo" accept="image/jpeg,image/png" name="logo" class="w3-hide">
						<img class="image-result w3-image" src="images/logoNegocio.jpg" style="width: 150px">
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
	endif;
?>