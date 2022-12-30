<?php if (isset($mostrarLogin)): ?>
	<main class="w3-row w3-animate-zoom" id="mainLogin">
		<?=LOADER?>
		<!--===================================
		=            PANEL LATERAL            =
		====================================-->
		<aside class="w3-padding-large w3-hide-small w3-col l6 m5 w3-display-container w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border-black w3-round-xlarge">
			<div id="typed-container" onclick="modal(this)" data-target="#acercaDe" class="w3-padding-large w3-xlarge w3-right w3-hover-black">
				<b class="w3-block w3-xxlarge">LICOSYS <?=getUltimaVersion()?></b>
				<div class="w3-padding"><span id="typed"></span></div>
			</div>
			<div class="reloj w3-display-bottomright w3-margin"></div>
		</aside>
		<!--====================================================
		=            FORMULARIO DE INICIO DE SESIÓN            =
		=====================================================-->
		<form id="login" autocomplete="off" class="w3-padding w3-rest w3-white w3-topbar w3-bottombar w3-rightbar w3-leftbar w3-border-black w3-round-xlarge">
			<h1 class="w3-xlarge w3-margin">Iniciar Sesión</h1>
			<section class="w3-section">
				<strong class="w3-block w3-margin w3-text-grey">
					Por favor seleccione un negocio:
				</strong>
				<div class="w3-row-padding">
					<?php
						$checked = count($negocios) === 1 ? 'checked' : '';
						foreach($negocios as $negocio):
							$url = $negocio['logo'] ? "images/negocios/{$negocio['logo']}" : 'images/logoNegocio.jpg';
							echo <<<HTML
								<div class="w3-col s4 tooltip-container">
									<input type="radio" id="negocio#{$negocio['id']}" name="negocio" value="{$negocio['id']}" $checked class="w3-hide">
									<label for="negocio#{$negocio['id']}" class="w3-block w3-topbar w3-bottombar w3-leftbar w3-rightbar w3-border-black w3-round-xlarge">
										<img src="$url" class="w3-image w3-round-xlarge">
									</label>
									<span class="tooltip w3-block w3-padding-small w3-card-4 w3-center">
										{$negocio['nombre']}
									</span>
								</div>
							HTML;
						endforeach
					?>
				</div>
			</section>
			<section class="w3-display-container">
				<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
				<?=generarINPUT('USUARIO', 'Usuario:', 'Introduzca su usuario')?>
				<?=generarINPUT('CLAVE', 'Contraseña:', 'Introduzca su contraseña')?>
			</section>
			<section class="w3-panel w3-center">
				<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block" style="width: 75%; margin: auto">
					Iniciar
				</button>
				<br>
				<button id="recuperar" data-target="#consultar" class="w3-button w3-round-xlarge w3-ripple">
					¿Olvidó su contraseña?
				</button>
			</section>
		</form>
	</main>
<?php endif ?>