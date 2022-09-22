<?php if(isset($registrarAdmin)): ?>
	<form method="POST" class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show" id="formAdmin">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h1 class="w3-margin-bottom w3-xlarge">Registro de Administrador</h1>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="number" name="cedula" placeholder="Cédula" minlength="7" maxlength="8" autocomplete="off" required pattern="^[^e]?[\d]{7,8}$" title="Un número entre 7 y 8 dígitos">
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="text" name="nombre" placeholder="Nombre" required minlength="4" maxlength="20" autocomplete="off" autocapitalize pattern="^[a-zA-Z]{4,20}$" title="Sólo se permiten entre 4 y 20 letras sin espacios">
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="text" name="usuario" placeholder="@usuario" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w-]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números o guiones(-)">
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="password" name="nuevaClave" placeholder="Crear Contraseña" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)">
				<div class="icono ver">
					<span class="icon-eye"></span>
				</div>
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="password" name="confirmar" placeholder="Repetir contraseña" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)">
				<div class="icono ver">
					<span class="icon-eye"></span>
				</div>
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<div class="input">
				<div class="icono">
					<span class="icon-edit"></span>
				</div>
				<input type="text" name="telefono" placeholder="Teléfono (opcional)" maxlength="13" pattern="^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}" title="Ejemplo (+58 416-111-2222 o 0416-111-2222)">
			</div>
		</section>
		<div class="w3-margin-top w3-container">
			<input class="w3-padding-large w3-margin-left w3-margin-right" type="submit" value="Registrar" name="registrarUsuario">
		</div>
	</form>
<?php else: header("location: ../"); endif ?>