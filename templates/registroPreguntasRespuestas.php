<?php
	if (!empty($mostrarRegistro))
		echo <<<HTML
			<form id="registrarPreguntasRespuestas" autocomplete="off" class="modal w3-white w3-card w3-round-large w3-animate-zoom">
				<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Cree sus Preguntas y Respuestas
				</h1>
				<div class="step-container">
					<div class="step"><span>1</span></div>
					<div class="step"><span>2</span></div>
					<div class="step"><span class="w3-blue">3</span></div>
				</div>
				<div class="w3-row w3-display-container w3-topbar">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					<section class="w3-padding-top-24 w3-half w3-rightbar">
						<fieldset class="w3-border-0">
							<legend class="w3-large w3-padding">
								<b>Pregunta 1:</b>
							</legend>
							<div class="w3-row w3-center w3-border-bottom">
								<div class="icon-edit w3-col s2 w3-xxlarge"></div>
								<div class="w3-col s10 w3-display-container">
									<input id="pre1" name="pre1" placeholder="Cree una pregunta" required maxlength="50" pattern="[\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\s]+" title="Sólo se permiten hasta 30 letras y símbolos (¿ ?)" class="w3-input w3-border-0 w3-large">
									<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
									<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
								</div>
							</div>
						</fieldset>
						<fieldset class="w3-border-0">
							<legend class="w3-large w3-padding">
								<b>Pregunta 2:</b>
							</legend>
							<div class="w3-row w3-center w3-border-bottom">
								<div class="icon-edit w3-col s2 w3-xxlarge"></div>
								<div class="w3-col s10 w3-display-container">
									<input id="pre2" name="pre2" placeholder="Cree una pregunta" required maxlength="50" pattern="[\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\s]+" title="Sólo se permiten hasta 30 letras y símbolos (¿ ?)" class="w3-input w3-border-0 w3-large">
									<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
									<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
								</div>
							</div>
						</fieldset>
						<fieldset class="w3-border-0">
							<legend class="w3-large w3-padding">
								<b>Pregunta 3:</b>
							</legend>
							<div class="w3-row w3-center w3-border-bottom">
								<div class="icon-edit w3-col s2 w3-xxlarge"></div>
								<div class="w3-col s10 w3-display-container">
									<input id="pre3" name="pre3" placeholder="Cree una pregunta" required maxlength="50" pattern="[\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\s]+" title="Sólo se permiten hasta 30 letras y símbolos (¿ ?)" class="w3-input w3-border-0 w3-large">
									<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
									<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
								</div>
							</div>
						</fieldset>
					</section>
					<section class="w3-padding-top-24 w3-half w3-leftbar">
						<fieldset class="w3-border-0">
							<legend class="w3-large w3-padding">
								<b>Respuesta 1:</b> <sup respuesta="res1" class="w3-text-blue"></sup>
							</legend>
							<div class="w3-row w3-center w3-border-bottom">
								<div class="icon-edit w3-col s2 w3-xxlarge"></div>
								<div class="w3-col s10 w3-display-container">
									<input type="password" id="res1" name="res1" placeholder="La respuesta" required minlength="1" maxlength="20" pattern="[a-zA-Z0-9\s]{1,20}" title="Sólo se permiten letras y números" class="w3-input w3-border-0 w3-large">
									<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
								</div>
							</div>
						</fieldset>
						<fieldset class="w3-border-0">
							<legend class="w3-large w3-padding">
								<b>Respuesta 2:</b> <sup respuesta="res2" class="w3-text-blue"></sup>
							</legend>
							<div class="w3-row w3-center w3-border-bottom">
								<div class="icon-edit w3-col s2 w3-xxlarge"></div>
								<div class="w3-col s10 w3-display-container">
									<input type="password" id="res2" name="res2" placeholder="La respuesta" required minlength="1" maxlength="20" pattern="[a-zA-Z0-9\s]{1,20}" title="Sólo se permiten letras y números" class="w3-input w3-border-0 w3-large">
									<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
								</div>
							</div>
						</fieldset>
						<fieldset class="w3-border-0">
							<legend class="w3-large w3-padding">
								<b>Respuesta 3:</b> <sup respuesta="res3" class="w3-text-blue"></sup>
							</legend>
							<div class="w3-row w3-center w3-border-bottom">
								<div class="icon-edit w3-col s2 w3-xxlarge"></div>
								<div class="w3-col s10 w3-display-container">
									<input type="password" id="res3" name="res3" placeholder="La respuesta" required minlength="1" maxlength="20" pattern="[a-zA-Z0-9\s]{1,20}" title="Sólo se permiten letras y números" class="w3-input w3-border-0 w3-large">
									<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
								</div>
							</div>
						</fieldset>
					</section>
				</div>
				<div class="w3-margin-top w3-center">
					<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block" style="width: 50%; margin: auto">
						Registrar
					</button>
					<br>
					<button id="masTarde" class="w3-button w3-round-xlarge w3-ripple w3-margin-bottom">
						Más tarde
					</button>
				</div>
			</form>
		HTML;
?>