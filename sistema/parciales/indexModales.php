<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<!-- OVERLAY -->
<div class="overlayModal w3-overlay w3-animate-opacity w3-hide"></div>

<!-- REGISTRO DE CAMBIOS -->
<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalRegistroCambios">
	<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
	<h3 class="swal2-title w3-margin-bottom">Registro de Cambios</h3>
	<dl class="w3-left-align w3-container">
		<?php foreach($versiones as $version): ?>
			<dt class="w3-tag w3-blue"><?=$version["nombre_v"]?></dt>
				<dd class="w3-small w3-margin-bottom"><?=$version["descripcion"]?></dd>
		<?php endforeach ?>
	</dl>
</div>

<!-- SOPORTE TÉCNICO -->
<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalSoporteTecnico">
	<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
	<h3 class="swal2-title w3-margin-bottom">Soporte técnico</h3>
	<dl class="w3-left-align w3-container">
		<dt class="w3-tag w3-blue">Correo Electrónico</dt>
		<dd class="w3-section w3-hover-text-grey"><a href="mailto:franyeradriansanchez@gmail.com">franyeradriansanchez@gmail.com</a></dd>
		<dd class="w3-margin-bottom w3-hover-text-grey"><a href="mailto:ftutorials610@gmail.com">ftutorials610@gmail.com</a></dd>
		<dd class="w3-margin-bottom w3-hover-text-grey"><a href="mailto:franyeradriansanchez@outlook.com">franyeradriansanchez@outlook.com</a></dd>
		<dd class="w3-margin-bottom w3-hover-text-grey"><a href="mailto:franyersanchez06@hotmail.com">franyersanchez06@hotmail.com</a></dd>
		<dt class="w3-tag w3-blue">Teléfono</dt>
		<dd class="w3-section w3-hover-text-grey"><span class="icon-whatsapp w3-text-green"> </span><u>+58 416-533-5826</u></dd>
		<dd class="w3-margin-bottom w3-hover-text-grey"><span class="icon-whatsapp w3-text-green"> </span><u>+58 416-546-2946</u></dd>
		<dd class="w3-margin-bottom w3-hover-text-grey"><span class="icon-telegram w3-text-blue"> </span><u>+58 416-533-5826</u></dd>
		<dd class="w3-margin-bottom w3-hover-text-grey"><span class="icon-telegram w3-text-blue"> </span><u>+58 424-715-7381</u></dd>
	</dl>
</div>

<!-- MANUAL DE USUARIO -->
<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalManual">
	<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
	<h3 class="swal2-title w3-margin-bottom">Manual de Usuario</h3>
</div>

<!-- ACTUALIZAR MONEDAS -->
<?php if($_SESSION["cargo"] == "a"):?>
	<form method="POST" class="w3-margin-top formularioModal w3-padding-16 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formMonedas">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h3 class="swal2-title">Actualizar Valores</h3>
		<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
			<label for="iva" class="w3-block w3-left-align w3-margin-bottom w3-margin-left">IVA: (actual) <b><?=getIVA()?></b></label>
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="text" id="iva" name="iva" placeholder="IVA" autofocus minlength="1" maxlength="4" required pattern="^0\.[0-9]{2,3}$" title="Un número decimal o un porcentaje" value="<?=getIVA()?>">
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
			<label for="iva" class="w3-block w3-left-align w3-margin-bottom w3-margin-left">DÓLAR: (actual) <b class="w3-block w3-margin-left">Bs. <?=getDolar()?></b><b class="w3-block w3-margin-left"><?=getPeso()?> Pesos</b></label>
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="text" name="dolar" placeholder="Valor en Bs." autofocus minlength="1" maxlength="4" required pattern="^\d+\.\d{1,2}$" title="Un número decimal" value="<?=getDolar()?>">
			</div>
			<div class="input w3-margin-top">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="number" name="peso" placeholder="Valor en Pesos" autofocus minlength="1" maxlength="4" required pattern="/^[^e]?[\d]{1,4}$/" title="Un número entero" value="<?=getPeso()?>">
			</div>
		</section>
		<div class="w3-center w3-margin-top">
			<input class="w3-button w3-blue w3-round-xlarge" type="submit" value="Actualizar" name="actualizarMonedas">
		</div>
	</form>
<?php endif; ?>