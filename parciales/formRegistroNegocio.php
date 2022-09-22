<?php if(isset($registrarNegocio)): ?>
	<form method="POST" enctype="multipart/form-data" class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show" id="formNegocio">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h1 class="w3-margin-bottom w3-xlarge">Registro de Negocio</h1>
		<div class="w3-twothird w3-rightbar">
			<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
				<div class="input">
					<div class="icono">
						<span class="icon-edit"></span>
					</div>
					<input type="text" name="nombreNegocio" placeholder="Nombre del negocio" autocomplete="off" autocapitalize="words" required minlength="4" maxlength="50" pattern="^[\wáÁéÉíÍóÓúÚñÑ\s]{4,50}$" title="Sólo se permiten entre 4 y 50 letras">
				</div>
			</section>
			<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
				<div class="input">
					<div class="icono">
						<span class="icon-edit"></span>
					</div>
					<input type="text" name="rif" placeholder="RIF del negocio" autocomplete="off" autocapitalize required minlength="10" maxlength="15" pattern="^(v|e|V|E){1}\d{9,15}$" title="Debe empezar por V o E seguido de entre 9 y 15 dígitos">
				</div>
			</section>
			<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
				<div class="input">
					<div class="icono">
						<span class="icon-edit"></span>
					</div>
					<input type="text" name="telefono" placeholder="Teléfono de contacto" maxlength="13" pattern="^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}" title="Ejemplo (+58 416-111-2222 o 0416-111-2222)">
				</div>
			</section>
			<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
				<div class="input">
					<div class="icono">
						<span class="icon-edit"></span>
					</div>
					<input type="text" name="direccion" placeholder="Dirección del negocio" maxlength="50" pattern="^([\w\,\.\-\#\/]\s?){4,50}$" title="Sólo se permiten letras, números y símbolos (, . - / #)">
				</div>
			</section>
			<div class="w3-margin-top w3-container">
				<input class="w3-margin-left w3-margin-right" type="submit" value="Registrar" name="registrarNegocio">
			</div>
		</div>
		<div class="formFoto w3-third w3-center w3-white">
			<label for="registroLogo" class="w3-display-container w3-hover-opacity">
				<i class="icon-camera w3-xxxlarge w3-display-middle"></i>
				<input type="file" name="foto" class="w3-hide" id="registroLogo">
				<img class="image-result w3-image" src="imagenes/logoNegocio.jpg" style="width: 150px;">
			</label>
			<b class="w3-medium w3-white w3-block w3-margin-top">Logotipo del negocio</b>
			<b class="w3-small w3-white w3-block w3-text-blue">Opcional</b>
		</div>
	</form>
<?php else: header("location: ../"); endif ?>