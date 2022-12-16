<?php
	if (isset($_SESSION['changePassword']))
		echo <<<HTML
			<form id="cambiarClave" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show">
				<div class="w3-right-align">
					<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
				</div>
				<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Recuperar Contraseña
				</h1>
				<div class="step-container">
					<div class="step"><span>1</span></div>
					<div class="step"><span>2</span></div>
					<div class="step"><span class="w3-blue">3</span></div>
				</div>
				<section class="w3-display-container">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">
							<b>Nueva Contraseña:</b>
						</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-key w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="password" id="clave" name="clave" minlength="4" maxlength="20" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
							</div>
						</div>
					</fieldset>
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">
							<b>Repetir contraseña:</b>
						</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-key w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="password" id="confirmar" name="confirmar" minlength="4" maxlength="20" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
							</div>
						</div>
					</fieldset>
				</section>
				<section class="w3-panel">
					<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
						Cambiar
				</button>
				</section>
			</form>
		HTML;
?>