<?php
	const LOADER = '
		<div class="loader" id="loader">
			<i class="w3-block w3-spin icon-spinner"></i>
		</div>
	';
	
	/**
	 * Botones HTML
	 * @var array ['REGISTRAR_USUARIO']
	 */
	const BOTONES = [
		'REGISTRAR_USUARIO' => <<<HTML
			<button class="w3-blue w3-text-black w3-button w3-circle">
				<i class="w3-block w3-center icon-user-plus w3-xxlarge"></i>
				Registrar<br>Usuario
			</button>
		HTML
	];
	
	/**
	 * Genera un `<input>` HTML
	 * @param  string $nombre El nombre del input. <br><br>
	 * `'CLAVE', 'CONFIRMAR', 'USUARIO', 'CEDULA', 'IVA', `<br>`
	 * 'DOLAR', 'PESO', 'res1', 'res2', 'res3', 'NOMBRE', `<br>`
	 * 'TELEFONO', 'NOMBRE_NEGOCIO', 'RIF', 'DIRECCION', `<br>`
	 * 'pre1', 'pre2', 'pre3'`
	 * @param  string $label El título del `<input>`
	 * @param  string $placeholder El placeholder del input.
	 * @param string $value El valor por defecto del `<input>`
	 * @return string El elemento `<input>`
	 */
	function generarINPUT(string $nombre, string $label, string $placeholder = '', string $value = ''):string {
		switch ($nombre):
			case 'CLAVE':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>$label</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-key w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="password" id="clave" name="clave" placeholder="$placeholder" value="$value" minlength="4" maxlength="20" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'CONFIRMAR':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>Repetir contraseña:</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-key w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="password" id="confirmar" name="confirmar" placeholder="$placeholder" value="$value" minlength="4" maxlength="20" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'USUARIO':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>$label</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-user-circle-o w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="usuario" name="usuario" placeholder="$placeholder" value="$value" required minlength="4" maxlength="20" pattern="^[\w-]{4,20}$" title="Sólo se permiten entre 4 y 20 letras, números o guiones(-)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-hide" id="loader">
									<i class="w3-block w3-spin icon-spinner"></i>
								</div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'CEDULA':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>$label</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-id-card w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="number" id="cedula" name="cedula" placeholder="$placeholder" value="$value" required min="1" max="40000000" minlength="7" maxlength="8" pattern="[^e]?\d{7,8}" title="Un número entre 7 y 8 dígitos" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'IVA':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>$label</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-percent w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="number" step="0.01" id="iva" name="iva" placeholder="$placeholder" value="$value" required minlength="1" maxlength="4" pattern="((0\.[0-9])|[0-9]){2,3}" title="Un número decimal o un porcentaje" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'DOLAR':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>$label</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-dollar w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="number" step="0.01" id="dolar" name="dolar" placeholder="$placeholder" value="$value" required minlength="1" maxlength="4" pattern="\d+\.?(\d{1,2})?" title="Un número con decimales opcionales" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'PESO':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>$label</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="w3-col s2 w3-xxlarge">P</div>
							<div class="w3-col s10 w3-display-container">
								<input type="number" id="pesos" name="pesos" placeholder="$placeholder" value="$value" required pattern="[^e]?\d{1,4}" title="Sólo se permiten números" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'res1':
			case 'res2':
			case 'res3':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>$label</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-key w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="password" id="$nombre" name="$nombre" placeholder="$placeholder" value="$value" required minlength="1" maxlength="20" pattern="[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ\s]{1,20}" title="Sólo se permiten letras y números" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'NOMBRE':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">$label</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-edit w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="nombre" name="nombre" placeholder="$placeholder" value="$value" required minlength="4" maxlength="20" pattern="[a-zA-Z]{4,20}" title="Sólo se permiten entre 4 y 20 letras sin espacios" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'NOMBRE_NEGOCIO':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">$label</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-building w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="nombreNegocio" name="nombreNegocio" placeholder="$placeholder" value="$value" required minlength="4" maxlength="20" pattern="[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ\s]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y espacios" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'TELEFONO':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">$label</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-phone w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input type="tel" id="telefono" name="telefono" placeholder="$placeholder" value="$value" maxlength="13" pattern="(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}" title="Ejemplo (+58 416-111-2222 o 0416-111-2222)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'RIF':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">$label</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-id-card w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="rif" name="rif" placeholder="$placeholder" value="$value" required minlength="10" maxlength="15" pattern="(v|e|V|E){1}\d{9,15}" title="Debe empezar por V o E seguido de entre 9 y 15 dígitos" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'DIRECCION':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding">$label</legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-map-marker w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="direccion" name="direccion" placeholder="$placeholder" value="$value" maxlength="50" pattern=".{4,50}" title="Sólo se permiten letras, números y símbolos (, . - / #)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
			case 'pre1':
			case 'pre2':
			case 'pre3':
				return <<<HTML
					<fieldset class="w3-border-0">
						<legend class="w3-large w3-padding"><b>$label</b></legend>
						<div class="w3-row w3-center w3-border-bottom">
							<div class="icon-question-circle w3-col s2 w3-xxlarge"></div>
							<div class="w3-col s10 w3-display-container">
								<input id="$nombre" name="$nombre" placeholder="$placeholder" value="$value" required maxlength="50" pattern="[\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\s]+" title="Sólo se permiten hasta 30 letras y símbolos (¿ ?)" class="w3-input w3-border-0 w3-large">
								<div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
								<div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
							</div>
						</div>
					</fieldset>
				HTML;
		endswitch;
	}
?>