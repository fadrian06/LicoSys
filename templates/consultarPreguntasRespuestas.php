<form id="consultar" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
	<div class="w3-right-align">
		<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
	</div>
	<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
		Recuperar Contraseña
	</h1>
	<div class="step-container">
		<div class="step"><span class="w3-blue">1</span></div>
		<div class="step"><span>2</span></div>
		<div class="step"><span>3</span></div>
	</div>
	<section class="w3-display-container">
		<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
		<fieldset class="w3-border-0">
			<legend class="w3-large w3-padding">
				<b>Cédula:</b>
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
				<b>Usuario:</b>
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
	</section>
	<section class="w3-panel">
		<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
			Consultar
	</button>
	</section>
</form>