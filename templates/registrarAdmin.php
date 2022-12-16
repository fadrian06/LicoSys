<?php
	if(!empty($mostrarRegistro))
		echo <<<HTML
			<form id="registrarAdmin" autocomplete="off" class="w3-row modal w3-white w3-card w3-round-large w3-animate-zoom">
				<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Cree su cuenta de Administrador
				</h1>
				<div class="step-container">
					<div class="step"><span>1</span></div>
					<div class="step"><span class="w3-blue">2</span></div>
					<div class="step"><span>3</span></div>
				</div>
				<section class="w3-padding-top-24 w3-twothird w3-rightbar w3-topbar w3-bottombar w3-display-container">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">
							<b>Cédula:</b> <sup class="w3-text-red">(requerido)</sup>
						</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-id-card w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="number" id="cedula" name="cedula" placeholder="Introduce tu cédula" required min="1" max="40000000" minlength="7" maxlength="8" pattern="[^e]?\d{7,8}" title="Un número entre 7 y 8 dígitos" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">
							<b>Nombre:</b> <sup class="w3-text-red">(requerido)</sup>
						</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-edit w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="nombre" name="nombre" placeholder="Introduce tu nombre" required minlength="4" maxlength="20" pattern="^[a-zA-Z]{4,20}$" title="Sólo se permiten entre 4 y 20 letras sin espacios" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">
							<b>Usuario:</b> <sup class="w3-text-red">(requerido)</sup>
						</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-user-circle-o w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="usuario" name="usuario" placeholder="@usuario" required minlength="4" maxlength="20" pattern="^[\w-]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números o guiones(-)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">
							<b>Contraseña:</b> <sup class="w3-text-red">(requerido)</sup>
						</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-key w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="password" id="clave" name="clave" placeholder="Cree una contraseña" minlength="4" maxlength="20" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
							</div>
						</div>
					</fieldset>
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">
							<b>Repetir contraseña:</b> <sup class="w3-text-red">(requerido)</sup>
						</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-key w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="password" id="confirmar" name="confirmar" placeholder="Repite la contraseña" minlength="4" maxlength="20" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
							</div>
						</div>
					</fieldset>
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">
							<b>Teléfono:</b> <sup class="w3-text-blue">(opcional)</sup>
						</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-phone w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="telefono" name="telefono" placeholder="Introduce un número de teléfono" maxlength="13" pattern="^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}" title="Ejemplo (+58 416-111-2222 o 0416-111-2222)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
					<div class="w3-panel">
						<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
							Registrar
						</button>
					</div>
				</section>
				<section class="w3-third w3-topbar w3-bottombar w3-center">
					<label for="foto" class="w3-display-container w3-hover-opacity w3-circle">
						<i class="icon-camera w3-xxxlarge w3-display-middle w3-display-hover"></i>
						<input type="file" id="foto" accept="image/jpeg,image/png" name="foto" class="w3-hide">
						<img class="image-result w3-image" src="images/avatar1.png" style="width: 150px">
					</label>
					<div class="w3-container w3-margin-top w3-center">
						<label for="foto" class="w3-button w3-round-xlarge w3-blue w3-ripple">
							<i class="icon-upload"></i> Subir foto
						</label>
					</div>
					<b class="w3-white w3-block w3-margin-top w3-margin-bottom">
						Foto de perfil
					</b>
					<b class="w3-margin-bottom w3-white w3-block w3-text-blue">Opcional</b>
				</section>
			</form>
		HTML;
?>