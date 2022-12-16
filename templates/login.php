<main class="w3-row" id="mainLogin">
	<aside class="w3-padding-large w3-hide-small w3-col m6 w3-display-container w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border-black w3-round-xlarge">
		<div id="typed-container" class="w3-padding-large w3-xlarge w3-right">
			<b class="w3-block w3-xxlarge">LICOSYS <?=getUltimaVersion()?></b>
			<div class="w3-padding">
				<span id="typed"></span>
			</div>
		</div>
		<div class="reloj w3-display-bottomright w3-margin"></div>
	</aside>
	<form id="login" autocomplete="off" class="w3-padding w3-rest w3-white w3-topbar w3-bottombar w3-rightbar w3-leftbar w3-border-black w3-round-xlarge">
		<h1 class="w3-xlarge w3-margin">Iniciar Sesión</h1>
		<section class="w3-section">
			<strong class="w3-block w3-margin w3-text-grey">
				Por favor seleccione un negocio:
			</strong>
			<div class="w3-row-padding">
				<?php
					foreach($negocios as $negocio):
						$url = $negocio['logo'] ? "images/negocios/{$negocio['logo']}" : 'images/logoNegocio.jpg';
						echo <<<HTML
							<div class="w3-col s4 tooltip-container">
								<input type="radio" id="negocio#{$negocio['id']}" name="negocio" value="{$negocio['id']}" class="w3-hide">
								<label for="negocio#{$negocio['id']}" class="w3-block w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border-black w3-round-xlarge">
									<img src="$url" class="w3-image w3-round-xlarge">
								</label>
								<span class="tooltip w3-block w3-padding-small w3-card-4 w3-center">
									{$negocio['nombre']}
								</span>
							</div>
						HTML;
					endforeach;
				?>
			</div>
		</section>
		<section class="w3-display-container">
			<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
			<fieldset class="w3-border-0">
				<legend class="w3-large w3-padding">
					<b>Usuario:</b>
				</legend>
				<div class="w3-row w3-center w3-border-bottom">
					<div class="icon-user-circle-o w3-col s2 w3-xxlarge"></div>
					<div class="w3-col s10 w3-display-container">
						<input id="usuario" name="usuario" placeholder="Introduzca su usuario" required minlength="4" maxlength="20" pattern="^[\w-]{4,20}$" title="Sólo se permiten entre 4 y 20 letras, números o guiones(-)" class="w3-input w3-border-0 w3-large">
						<div class="w3-display-right w3-xxlarge w3-hide" id="loader">
							<i class="w3-block w3-spin icon-spinner"></i>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class="w3-border-0">
				<legend class="w3-large w3-padding">
					<b>Contraseña:</b>
				</legend>
				<div class="w3-row w3-center w3-border-bottom">
					<div class="icon-key w3-col s2 w3-xxlarge"></div>
					<div class="w3-col s10 w3-display-container">
						<input type="password" id="clave" name="clave" placeholder="Introduzca su contraseña" minlength="4" maxlength="20" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)" class="w3-input w3-border-0 w3-large">
						<div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
					</div>
				</div>
			</fieldset>
		</section>
		<section class="w3-panel w3-center">
			<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block" style="width: 75%; margin: auto">
				Iniciar
			</button>
			<br>
			<button id="recuperar" class="w3-button w3-round-xlarge w3-ripple">
				¿Olvidó su contraseña?
			</button>
		</section>
	</form>
</main>