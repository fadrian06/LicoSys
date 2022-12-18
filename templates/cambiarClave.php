<?php
	if (isset($_SESSION['changePassword'])):
		$inputClave = generarINPUT('CLAVE', 'Nueva Contraseña:');
		$inputConfirmar = generarINPUT('CONFIRMAR', 'Confirmar Contraseña:');
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
					$inputClave
					$inputConfirmar
				</section>
				<section class="w3-panel">
					<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
						Cambiar
					</button>
				</section>
			</form>
		HTML;
	endif;
?>