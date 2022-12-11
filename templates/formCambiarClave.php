<?php if(isset($cambiarClave)): ?>
	<form method="POST" class="w3-margin-top formularioModal w3-padding-16 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show" id="formClave">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h1 class="w3-xlarge">Recuperar Contraseña</h1>
		<b class="w3-text-teal w3-margin-bottom">Paso 3/3</b>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-lock"></span>
				</div>
				<input type="password" name="nuevaClave" placeholder="Nueva contraseña" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)">
				<div class="icono ver">
					<span class="icon-eye"></span>
				</div>
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-key"></span>
				</div>
				<input type="password" name="confirmar" placeholder="Repetir contraseña" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)">
				<div class="icono ver">
					<span class="icon-eye"></span>
				</div>
			</div>
		</section>
		<div class="w3-margin-top w3-container">
			<input class="w3-margin-left w3-margin-right" type="submit" value="Actualizar" name="actualizarClave">
		</div>
	</form>
<?php else: header("location: ../"); endif ?>