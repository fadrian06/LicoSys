<form method="POST" class="w3-margin-top formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formConsulta">
	<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
	<h1 class="w3-xlarge">Recuperar Contraseña</h1>
	<b class="w3-text-teal w3-margin-bottom">Paso 1/3</b>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-id-card"></span>
			</div>
			<input type="number" name="cedula" placeholder="Ingrese su cédula" autocomplete="off" value="<?=$cedula ?? ""?>" minlength="7" maxlength="8" required pattern="^[^e]?[0-9]{7,8}$" title="Debe tener entre 7 y 8 dígitos">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-user-circle-o"></span>
			</div>
			<input type="text" name="usuario" placeholder="Ingrese su usuario" autocomplete="off" value="<?=$usuario ?? ""?>" minlength="4" maxlength="20" required pattern="^[a-zA-Z]*[\w-]{4,20}$" title="Sólo se permiten letras, guiones(-) y espacios">
		</div>
	</section>
	<div class="w3-margin-top w3-container">
		<input class="w3-margin-left w3-margin-right" type="submit" value="Consultar" name="consultar">
	</div>
</form>